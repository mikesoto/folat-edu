<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Courses extends MY_controller {
	function __construct()
	{
	   parent::__construct();
	}

	//function for homepage
	public function index() {
		$this->category();
	}

	public function category($cat_slug = NULL,$subcat_slug = NULL,$featured = false){
		global $data;
		$this->MY_setLanguage('CoursesListing');
		$this->MY_setCatFilters($cat_slug,$subcat_slug);//sets the category and subcategory variables in the data array
		$this->MY_get_categories();//sets the cat_list and subcat_list variables
		$data['courses_arr'] = $this->courses_model->getCourses($cat_slug, $subcat_slug, $featured, $this->config->item('language'));

		$this->MY_show_page('Courses', 'course_list_view', $data);
	}

	public function details($course_slug){
		global $data;
		$this->MY_setLanguage('CourseDetails');
		$user_id = 0;
		if(isset($this->session->userdata['logged_in']['user_id']))
		{
			$user_id = $this->session->userdata['logged_in']['user_id'];
		}
		$data['course_arr'] = $this->courses_model->getCourseDetails($course_slug);
		//get any existing modules for this course
		$data['modules_arr'] = $this->courses_model->getCourseModules($data['course_arr']['id']); //returns array or false if none
		$data['course_arr']['total_length'] = $this->courses_model->getCourseLength($data['modules_arr']);
		$data['course_time'] = convertToTime($data['course_arr']['total_length']);
		$data['is_enrolled'] = $this->courses_model->checkIfEnrolled($user_id,$data['course_arr']['id']);
		$this->MY_show_page('Course Details', 'course_details_view', $data);
	}

	public function create() {
		global $data;
		$this->MY_setLanguage('CourseCreate');
		$this->MY_checkIfLoggedIn();//sets user data if logged in
		$this->MY_get_categories();//sets the cat_list and subcat_list variables
		$this->MY_make_account_data();//adds courses taking, teaching, and account alerts to data array
		$this->MY_show_page('Create Course', 'course_create_view', $data);
	}

	public function manage($course_slug = false){
		global $data;
		if(!$course_slug){
			redirect('account/teaching', 'refresh');
		}
		else
		{
			$this->MY_setLanguage('CourseManage');
			$this->MY_checkIfLoggedIn();//sets user data if logged in
			$this->MY_get_categories();//sets the cat_list and subcat_list variables
			$data['course_arr'] = $this->courses_model->getCourseDetails($course_slug);

			if(!$data['course_arr'])//if no course with that slug exits
			{	
				$_SESSION['flash_error'] = 'Could not find course';
				redirect('account/teaching');
			}
			else
			{	
				//get any existing modules for this course
				$data['modules_arr'] = $this->courses_model->getCourseModules($data['course_arr']['id']); //returns array or false if none
				$data['course_arr']['total_length'] = $this->courses_model->getCourseLength($data['modules_arr']);
				$data['course_time'] = convertToTime($data['course_arr']['total_length']);
				$this->MY_show_page('Manage Course', 'course_manage_view', $data);
			}
			
		}
	}

	public function delete($course_id) {
		global $data;
		$this->MY_setLanguage('CoursesTeaching');
		//check if logged in for account page
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$user_id = $session_data['user_id'];
			//check if course being deleted belongs to current user
			if($this->courses_model->check_ownership($course_id, $user_id))
			{
				//delete the course and get its title for success message
				$course_title = $this->courses_model->delete_course($course_id, $user_id);
				//set success message in session flash variable
				$_SESSION['flash_success'] = $this->lang->line('coursesTeaching_msg_courseDeleted1').
											 '<strong>'.$course_title.'</strong>'.
											 $this->lang->line('coursesTeaching_msg_courseDeleted2');
				redirect(base_url('account/teaching'));
			}
			else
			{
				//log them out
				redirect('account/logout', 'refresh');
			}
		}
	    else
	    {
	    	//send to login
	    	redirect('account/login', 'refresh');
	    }
	}

}