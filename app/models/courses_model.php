<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set ('America/Mexico_City');
class Courses_model extends CI_Model {
	public function __construct(){
		parent::__construct();
		$this->load->helper('my_str_helper.php');
	}

	public function getCatList(){
		$query = $this->db->get('folat_categories');
		$cat_list = $query->result_array();
		return $cat_list;
	}

	public function getSubCatList($parent_id = NULL){
		if(!$parent_id)//get all subcategories
		{
			$query = $this->db->get('folat_subcategories');
			$subcat_list = $query->result_array();
			return $subcat_list;
		}
		else
		{
			$query = $this->db->get_where('folat_subcategories',array('subcat_parent_id' => $parent_id));
			$subcat_list = $query->result_array();
			return $subcat_list;
		}
	}

	public function getCourses($cat_slug = NULL, $subcat_slug = NULL, $featured = FALSE, $lang = 'english'){
		//array to contain result of query
		$courses_arr = array();

		//build course query
		if(!isset($cat_slug))//no category is specified
		{	
			if(!$featured)//not featured
			{
				//perform query for all courses
				$course_query = $this->db->get_where('folat_courses',array('course_lang' => $lang));
				
			}
			else //is featured
			{
				//perform query for all FEATURED courses
				$course_query = $this->db->get_where('folat_courses',array('course_featured' => 1, 'course_lang' => $lang));
			}
		}
		else //specific category
		{
			//get id of category with $cat_slug
			$cat_query = $this->db->get_where('folat_categories', array('cat_slug' => $cat_slug));
			$category = $cat_query->row_array();

			if(!$subcat_slug)//no subcategory
			{
				if(!$featured) //not featured
				{
					//perform query for all courses in CATEGORY
					$course_query = $this->db->get_where('folat_courses',array('course_category_id' => $category['id'], 'course_lang' => $lang));
				}
				else //is featured
				{
					//perform query for all FEATURED courses in CATEGORY
					$query = $this->db->get_where('folat_courses',array('course_featured' => 1, 'course_category_id' => $category['id'], 'course_lang' => $lang));
				}
			}
			else //with subcategory
			{
				//get id of subcategory with $subcat_slug
				$subcat_query = $this->db->get_where('folat_subcategories', array('subcat_slug' => $subcat_slug));
				$subcategory = $subcat_query->row_array();

				if(!$featured) //not featured
				{
					//perform query for all courses in CATEGORY with SUBCATEGORY
					$course_query = $this->db->get_where('folat_courses',array('course_category_id' => $category['id'], 'course_subcat_id' => $subcategory['id'], 'course_lang' => $lang));
				}
				else //is featured
				{
					//perform query for all FEATURED courses in CATEGORY with SUBCATEGORY
					$course_query = $this->db->get_where('folat_courses',array('course_featured' => 1, 'course_category_id' => $category['id'], 'course_subcat_id' => $subcategory['id'], 'course_lang' => $lang));
				}
			}

			
		}
		$courses_arr = $course_query->result_array();

		//get related info for courses
		for($i = 0; $i < count($courses_arr); $i++)
		{	
			//Add course teacher info 
			$query = $this->db->get_where('folat_users', array('user_id' => $courses_arr[$i]['course_teacher_id']));
			$teacher = $query->row_array();
			$courses_arr[$i]['course_teacher_info'] = array(
				'user_id' => $teacher['user_id'],
				'user_name' => $teacher['user_name'],
				'user_lastname' => $teacher['user_lastname'],
				'user_email' => $teacher['user_email'],
				'user_about' => $teacher['user_about'],
				'user_image' => $teacher['user_image']
			);

			//Add course category info 
			$query = $this->db->get_where('folat_categories', array('id' => $courses_arr[$i]['course_category_id']));
			$category = $query->row_array();
			$courses_arr[$i]['course_category_info'] = $category;

			//Add course subcat info 
			$query = $this->db->get_where('folat_subcategories', array('id' => $courses_arr[$i]['course_subcat_id']));
			$subcategory = $query->row_array();
			$courses_arr[$i]['course_subcat_info'] = $subcategory;

			//Add course rating info 
			$query = $this->db->get_where('folat_course_ratings', array('course_id' => $courses_arr[$i]['id']));
			$ratings = $query->result_array();
			$courses_arr[$i]['course_rating_info'] = $ratings;
			$avg = '';
			$sum = 0;
			//calculate average rating
			if( !empty($ratings) )
			{
				$total_ratings = count($ratings);
				foreach($ratings as $r ){
					$int = (int)$r['rating'];
					$sum += $int;
				}
				$avg = round($sum/$total_ratings);
			}
			$courses_arr[$i]['course_rating_avg'] = $avg;

			//get all course modules for total length 
			$mods = $this->getCourseModules($courses_arr[$i]['id']);
			$total_length = $this->getCourseLength($mods);
			//add course time in HH:MM format
			$courses_arr[$i]['course_time'] = convertToTime($total_length);
		}
		return $courses_arr;
	}


	public function add_new_course($course_data,$user_id){
		$course_slug = slugify($course_data['title']);
		$course = array(
			'course_title' => $course_data['title'],
			'course_slug' => $course_slug,
			'course_category_id' => $course_data['category'],
			'course_subcat_id' => $course_data['subcategory'],
			'course_description' => $course_data['description'],
			'course_teacher_id' => $user_id,
			'course_length' => 0,
			'course_featured' => 0,
			'enrollment_status' => 0,
			'course_image' => '',
		);
		//insert new course data into database
		$query = $this->db->insert("folat_courses",$course);
		//get the id of the new course
		$insert_id = $this->db->insert_id();
		//insert new entry into the course instruct relationship table.
		$today = date("Y-m-d H:i:s");
		$instruct = array(
			'user_id' => $user_id,
			'course_id' => $insert_id,
			'date' => $today,
			'status' => 'Active',
		);
		$query = $this->db->insert("folat_instruct",$instruct);
		return $course['course_slug'];
	}

	public function update_course($course_data){
		$course_slug = slugify($course_data['title']);
		$course = array(
			'id' => $course_data['course_id'],
			'course_title' => $course_data['title'],
			'course_slug' => $course_slug,
			'course_category_id' => $course_data['category'],
			'course_subcat_id' => $course_data['subcategory'],
			'course_description' => $course_data['description'],
			'course_teacher_id' => $course_data['course_teacher_id'],
			'course_length' => $course_data['course_length'],
			'course_image' => $course_data['course_image'],
			'enrollment_status' => $course_data['enrollment_status']
		);
		//update course data in database
		$this->db->where('id', $course['id']);
		$this->db->update('folat_courses', $course); 
		return true;
	}

	public function check_title_available($title){
		//perform query for all courses with title
		$query = $this->db->get_where('folat_courses',array('course_title' => $title));
		$courses_arr = $query->result_array();
		$count = count($courses_arr);
		if($count){ return false; }
		else{ return true; }
	}
	
	public function check_title_update($title,$id){
		//perform query for all courses with title that are not the current course
		$query = $this->db->get_where('folat_courses',array('course_title' => $title,'id !=' => $id));
		$courses_arr = $query->result_array();
		$count = count($courses_arr);
		if($count){ return false; }
		else{ return true; }
	}

	

	public function getAllSubcatList(){
		$query = $this->db->get('folat_subcategories');
		$subcat_list = $query->result_array();
		return $subcat_list;
	}

	public function getChildSubcatList($cat_id){
		$query = $this->db->get_where('folat_subcategories', array('subcat_parent_id' => $cat_id));
		$subcat_list = $query->result_array();
		return $subcat_list;
	}

	public function getCourseDetailsById($course_id){
		$course_arr = array();
		$query = $this->db->get_where('folat_courses',array('id' => $course_id));
		$course_arr = $query->row_array();
		if(empty($course_arr))
		{
			return false;
		}

		//ADD course_user_info to the course_arr
		$query = $this->db->get_where('folat_users', array('user_id' => $course_arr['course_teacher_id']));
		$teacher = $query->row_array();
		$course_arr['course_teacher_info'] = $teacher;
		
		//ADD course_category_info to the course_arr
		$query = $this->db->get_where('folat_categories', array('id' => $course_arr['course_category_id']));
		$category = $query->row_array();
		$course_arr['course_category_info'] = $category;

		//ADD course_subcat_info to the course_arr
		$query = $this->db->get_where('folat_subcategories', array('id' => $course_arr['course_subcat_id']));
		$subcategory = $query->row_array();
		$course_arr['course_subcat_info'] = $subcategory;
		return $course_arr;
	}

	public function getCourseDetails($course_slug){
		//perform query for a specific course
		$course_arr = array();
		$query = $this->db->get_where('folat_courses',array('course_slug' => $course_slug));
		$course_arr = $query->row_array();
		if(empty($course_arr))
		{
			return false;
		}

		//ADD course_user_info to the course_arr
		$query = $this->db->get_where('folat_users', array('user_id' => $course_arr['course_teacher_id']));
		$teacher = $query->row_array();
		$course_arr['course_teacher_info'] = $teacher;
		
		//ADD course_category_info to the course_arr
		$query = $this->db->get_where('folat_categories', array('id' => $course_arr['course_category_id']));
		$category = $query->row_array();
		$course_arr['course_category_info'] = $category;

		//ADD course_subcat_info to the course_arr
		$query = $this->db->get_where('folat_subcategories', array('id' => $course_arr['course_subcat_id']));
		$subcategory = $query->row_array();
		$course_arr['course_subcat_info'] = $subcategory;
		return $course_arr;

	}

	public function getCourseModules($course_id){
		$this->db->order_by('chapter','asc');
		$this->db->order_by('section','asc');
		$modules_query = $this->db->get_where('folat_modules',array('course_id' => $course_id));
		$modules_arr = $modules_query->result_array();
		if($modules_arr)
		{
			//add module slides and questions count for each module in result
			for($i=0; $i < count($modules_arr); $i++)
			{
				$slides_query = $this->db->get_where('folat_content_text_slides',array('module_id' => $modules_arr[$i]['id']));
				$slides_arr = $slides_query->result_array();
				//add slides count info to each module
				$modules_arr[$i]['slides_count'] = count($slides_arr);
				//get count of total questions for each slide and add to total for this module
				$questions_count = 0;
				//add up all the lengths of each slide to get total length value for this module
				$module_length = 0;
				foreach($slides_arr as $slide)
				{	
					//add up slide length
					$module_length += $slide['length'];
					//get questions for this slide
					$this->db->where('slide_id',$slide['id']);
					$this->db->from('folat_review_questions');
					$slide_questions_count = $this->db->count_all_results();
					$questions_count += $slide_questions_count;
				}
				//add total questions count to module info
				$modules_arr[$i]['questions_count'] = $questions_count;
				$modules_arr[$i]['total_length'] = $module_length;
				$modules_arr[$i]['module_time'] = convertToTime($modules_arr[$i]['total_length']);
				//add the module type name 
				$this->db->select('name');
				$this->db->where('id',$modules_arr[$i]['type_id']);
				$name_query = $this->db->get('folat_module_types');
				$name_arr = $name_query->row_array();
				//add module_type_name to the module info
				$modules_arr[$i]['module_type_name'] = $name_arr['name'];
			}
			return $modules_arr;
		}
		else
		{
			return false;
		}
	}


	public function getCourseLength($modules){
		$course_length = 0;
		if($modules)
		{
			foreach($modules as $module)
			{
				$course_length += $module['total_length'];//the modules total length includes length of all of it's slides
			}
		}
		return $course_length;
	}

	public function enroll_user($user_id,$course_slug){
		$course = $this->getCourseDetails($course_slug);
		$course_id = $course['id'];

		//check if user already registered
		$query = "SELECT * FROM folat_enrollment WHERE user_id = $user_id AND course_id = $course_id";
		$res = $this->db->query($query);
		if ($res->num_rows() > 0)
		{
		   $row = $res->row_array(); 
		   return $row['enrollment_date'];
		}
		else
		{
			$sql = "INSERT INTO folat_enrollment (user_id,course_id,enrollment_date,status) 
				VALUES($user_id,$course_id,NOW(),'Active')";
			$res = $this->db->query($sql);
			return 'ok';
		}
	}


	public function checkIfEnrolled($user_id,$course_id){
		if($user_id != '')
		{
				//check if user already registered
				$query = "SELECT * FROM folat_enrollment WHERE user_id = $user_id AND course_id = $course_id";
				$res = $this->db->query($query);
				if ($res->num_rows() > 0)
				{
				   return true;
				}
				else
				{
					return false;
				}
		}
		else
		{
			return false;
		}
	}

	public function check_ownership($course_id, $user_id){
		//check if user already registered
		$query = "SELECT id FROM folat_courses WHERE course_teacher_id = $user_id AND id = $course_id";
		$res = $this->db->query($query);
		if ($res->num_rows() > 0)
		{
		   return true;
		}
		else
		{
			return false;
		}
	}

	public function delete_course($course_id, $user_id){
		//get the course title from the database
		$title_query = "SELECT course_title FROM folat_courses WHERE id = $course_id";
		$title_res = $this->db->query($title_query);
		$row = $title_res->row_array();

		//delete course from folat_courses
		$query = "DELETE FROM folat_courses WHERE id = $course_id";
		$res = $this->db->query($query);
		
		//delete relationship in course_instruct
		$this->db->query("DELETE FROM folat_instruct WHERE course_id = $course_id AND user_id = $user_id");
		$res = $this->db->query($query);

		//TODO:: Send email notification to all students letting them know the course will no longer appear in their Courses Taking List
		//The relationship for enrolled students will remain but will not be included in courses taking list.

		//get all modules for this course and delete contents then module
		$modules_query = $this->db->get_where('folat_modules',array('course_id' => $course_id));
		$modules_arr = $modules_query->result_array();
		for($i=0; $i < count($modules_arr); $i++)
		{
			//get all slides for this module
			$slides_query = "SELECT id FROM folat_content_text_slides WHERE module_id = ".$modules_arr[$i]['id'];
			$slides_res = $this->db->query($slides_query);
			$slides = $slides_res->result_array();
			//delete all review questions for each slide and delete slides for this module
			foreach($slides as $sl)
			{
				//delete all of this slide's review questions
				$this->db->query("DELETE FROM folat_review_questions WHERE slide_id = ".$sl['id']);
				$res = $this->db->query($query);

				//delete this slide
				$this->db->query("DELETE FROM folat_content_text_slides WHERE id = ".$sl['id']);
				$res = $this->db->query($query);
			}
			//now delete the module before going on to the next one
			$this->db->query("DELETE FROM folat_modules WHERE id = ".$modules_arr[$i]['id']);
			$res = $this->db->query($query);
		}

		//return course title for success message
		return $row['course_title'];
	}
}