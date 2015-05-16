<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Modules_model extends CI_Model {
	public function __construct(){
		parent::__construct();
		$this->load->helper('my_str_helper.php');
	}

	public function getModuleTypes(){
		$query = $this->db->get('folat_module_types');
		$mod_type_list = $query->result_array();
		return $mod_type_list;
	}

	public function check_ownership($module_id, $user_id){
		//get the course_id that this module belongs to
		$module_arr = $this->getModuleDetails('id',$module_id);
		$course_id = $module_arr['course_id'];

		$this->db->select('id');
		$res = $this->db->get_where('folat_courses',array('course_teacher_id' => $user_id, 'id' => $course_id));
		if($res->num_rows() > 0)
		{
		   return true;
		}
		else
		{
			return false;
		}
	}

	public function delete_question($slide_id,$question_id)
	{
		$res = $this->db->delete('folat_review_questions', array('slide_id' => $slide_id , 'id' => $question_id));
		return $res;
	}

	public function delete_slide($slide_id)
	{
		$res = $this->db->delete('folat_content_text_slides', array('id' => $slide_id));
		if($res)
		{
			//delete all review questions for slide
			$res2 = $this->db->delete('folat_review_questions', array('slide_id' => $slide_id));
			return $res2;
		}
		else
		{
			return false;
		}
	}

	public function delete_module($module_id){
		//get all slides for this module
		$query = $this->db->get_where('folat_content_text_slides',array('module_id' => $module_id));
		$slides_arr = $query->result_array();
		//delete all slides for this module
		foreach($slides_arr as $slide)
		{
			$this->delete_slide($slide['id']); //deletes slides and associated review questions
		}
		//delete the module
		$res = $this->db->delete('folat_modules', array('id' => $module_id));
		return $res;
	}

	public function add_new_module($module_data,$user_id){
		$module_slug = slugify($module_data['title']);
		$module = array(
			'course_id' => $module_data['course_id'],
			'type_id' => $module_data['type_id'],
			'title' => $module_data['title'],
			'chapter' => $module_data['chapter'],
			'section' => $module_data['section'],
			'summary' => lineBreaksToBr($module_data['summary']),
			'slug' => $module_slug
		);
		//insert new module data into database
		$query = $this->db->insert("folat_modules",$module);
		if($query)
		{
			$insert_id = $this->db->insert_id();
			return $insert_id;
		}
		else
		{
			return false;
		}
	}

	public function update_module($module_data){
		$slug = slugify($module_data['title']);
		$module = array(
			'title' => $module_data['title'],
			'chapter' => $module_data['chapter'],
			'section' => $module_data['section'],
			'summary' => $module_data['summary'],
			'slug' => $slug,
		);
		$this->db->where('id',$module_data['module_id']);
		$res = $this->db->update('folat_modules',$module);
		return $res;
	}

	public function check_title_update($title,$id){
		//perform query for all modules with title that are not the current course
		$query = $this->db->get_where('folat_modules',array('title' => $title,'id !=' => $id));
		$courses_arr = $query->result_array();
		$count = count($courses_arr);
		if($count)
		{ 
			return false; //the title is already in use 
		}
		return true; //the title can be used
	}

	public function add_new_slide($slide_data){
		$slide = array(
			'module_id' => $slide_data['module_id'],
			'title' => $slide_data['title'],
			'body' => $slide_data['body'],
			'order_num' => $slide_data['order_num'],
			'length' => $slide_data['length'],
			'refs' => lineBreaksToBr($slide_data['refs']),
		);
		//insert new module data into database
		$query = $this->db->insert("folat_content_text_slides",$slide);
		if($query)
		{
			$insert_id = $this->db->insert_id();
			return $insert_id;
		}
		else
		{
			return false;
		}
	}

	public function update_slide($slide_data){
		$slide = array(
			'module_id' => $slide_data['module_id'],
			'title' => $slide_data['title'],
			'body' => $slide_data['body'],
			'order_num' => $slide_data['order_num'],
			'length' => $slide_data['length'],
			'refs' => lineBreaksToBr($slide_data['refs']),
		);
		//update slide data in database
		$this->db->where('id',$slide_data['slide_id']);
		$query = $this->db->update("folat_content_text_slides",$slide);
		return true;
	}

	public function add_new_question($question_data){
		$question = array(
			'slide_id' => $question_data['slide_id'],
			'question' => lineBreaksToBr($question_data['question']),
			'answer' => lineBreaksToBr($question_data['answer']),
			'wrong_1' => lineBreaksToBr($question_data['wrong_1']),
			'wrong_2' => lineBreaksToBr($question_data['wrong_2']),
			'wrong_3' => lineBreaksToBr($question_data['wrong_3']),
		);
		//insert new question data into database
		$query = $this->db->insert("folat_review_questions",$question);
		if($query)
		{
			$insert_id = $this->db->insert_id();
			return $insert_id;
		}
		else
		{
			return false;
		}
	}

	public function update_question($question_data){
		$question = array(
			'id' => $question_data['question_id'],
			'slide_id' => $question_data['slide_id'],
			'question' => lineBreaksToBr($question_data['question']),
			'answer' => lineBreaksToBr($question_data['answer']),
			'wrong_1' => lineBreaksToBr($question_data['wrong_1']),
			'wrong_2' => lineBreaksToBr($question_data['wrong_2']),
			'wrong_3' => lineBreaksToBr($question_data['wrong_3']),
		);
		//update new question data in database
		$this->db->where('id',$question['id']);
		$query = $this->db->update("folat_review_questions",$question);
		return true;
	}

	public function move_question($question_data){
		$question = array(
			'id' => $question_data['question_id'],
			'slide_id' => $question_data['move_to_slide_id'],
		);
		//update new question data in database
		$this->db->where('id',$question['id']);
		$query = $this->db->update("folat_review_questions",$question);
		return true;
	}

	public function get_module_length($module_id){
		$this->db->select('length');
		//TODO make relational table with all types of content and the modules they belong to 
		$lengths_query = $this->db->get_where('folat_content_text_slides',array('module_id' => $module_id));
		$lengths_arr = $lengths_query->result_array();
		$total_length= 0;
		foreach($lengths_arr as $length)
		{
			$total_length += $length['length'];
		}
		return $total_length;
	}

	public function getModuleDetails($column,$value){
		$module_query = $this->db->get_where('folat_modules',array($column => $value));
		$module_arr = $module_query->row_array();
		if($module_arr)
		{
			//get the name of the module_type
			$module_info_query = $this->db->get_where('folat_module_types',array('id' => $module_arr['type_id']));
			$module_info_arr = $module_info_query->row_array();
			//add the name to the module_arr
			$module_arr['module_type_name'] = $module_info_arr['name'];
			$module_arr['module_type_description'] = $module_info_arr['description'];

			//get the total length of all content for this module
			$module_arr['total_length'] = $this->get_module_length($module_arr['id']);
			return $module_arr;
		}
		else
		{
			return false;
		}
	}

	public function getModuleContent($type, $module_id)
	{	
		//gets all content for module (all content will be of the same type)
		$this->db->order_by('order_num','asc');
		$content_query = $this->db->get_where('folat_content_'.$type,array('module_id' => $module_id));
		$content_arr = $content_query->result_array();
		if($content_arr)
		{
			//get any review questions for each content
			for($i = 0; $i < count($content_arr); $i++)
			{
				$content_questions_query = $this->db->get_where('folat_review_questions',array('slide_id' => $content_arr[$i]['id']));
			 	$content_questions_arr = $content_questions_query->result_array();
			 	//inject result into the current content object
			 	$content_arr[$i]['content_questions'] = $content_questions_arr;
			 	//add slide_time
			 	$content_arr[$i]['slide_time'] = convertToTime($content_arr[$i]['length']);
			}
			return $content_arr;
		}
		else
		{
			return false;
		}
	}

	public function checkIfCorrectAnswer($question_id, $selected_answer)
	{
		$res = array();
		$question_query = $this->db->get_where('folat_review_questions',array('id' => $question_id));
		$question_arr = $question_query->row_array();
		if($question_arr['answer'] == $selected_answer)
		{
			$res['iscorrect'] = true;
		}
		else
		{
			$res['iscorrect'] = false;
			$res['correct_answer'] = $question_arr['answer'];
		}
		return $res;
	}

	public function saveQuestionResult($u_id, $c_id, $m_id, $s_id, $q_id, $is_correct, $s_ans, $c_ans, $qstn)
	{
		$results = array(
			'datetime' => date('Y/m/d h:i:s a', time()),
			'student_id' => $u_id,
			'course_id' => $c_id,
			'module_id' => $m_id,
			'slide_id' => $s_id,
			'question_id' => $q_id,
			'is_correct' => $is_correct,
			'selected_answer' => $s_ans,
			'correct_answer' => $c_ans,
			'question' => $qstn,
		);
		//insert new question data into database
		$query = $this->db->insert("folat_review_results",$results);
		if($query)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function saveReviewResults($rev_res, $user_id)
	{
		$total_qs = count($rev_res);
		$course_id = $rev_res[0]['course_id'];
		$module_id = $rev_res[0]['module_id'];
		$final_score = 0;
		$correct = 0;
		$incorrect = 0;
		$q_value = (1/$total_qs)*100;
		$res_rev_ids = '[';
		$res_count = 1;
		foreach($rev_res as $res)
		{
			if($res['is_correct'] == 1)
			{
				$final_score += $q_value;
				$correct++;
			}
			else
			{
				$incorrect++;	
			}
			//add the review results id to the rev_res_ids string
			$res_rev_ids .= '"'.$res['id'].'"';
			if($res_count < $total_qs)
			{	//add comma if there are more
				$res_rev_ids .= ',';
			}
			else
			{	//close if we have reached the end
				$res_rev_ids .= ']';
			}
			$res_count++;
		}

		$results = array(
			'datetime' => date('Y/m/d h:i:s a', time()),
			'student_id' => $user_id,
			'course_id' => $course_id,
			'module_id' => $module_id,
			'total_questions' => $total_qs,
			'correct_answers' => $correct,
			'incorrect_answers' => $incorrect,
			'final_score' => $final_score,
			'res_rev_ids' => $res_rev_ids,
		);
		//insert new question data into database
		$query = $this->db->insert("folat_review_scores",$results);
		if($query)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function getReviewResults($module_id,$student_id)
	{
		$review_query = $this->db->get_where('folat_review_results',array('module_id' => $module_id, 'student_id' => $student_id));
		$review_arr = $review_query->result_array();
		if($review_arr)	
		{
			return $review_arr;
		}
		else
		{
			return false;
		}
	}


	public function clearReviewResults($module_id,$user_id){
		$this->db->delete('folat_review_scores', array('module_id' => $module_id, 'student_id' => $user_id) );
		$this->db->delete('folat_review_results', array('module_id' => $module_id, 'student_id' => $user_id) ); 
		return true;
	}

	public function getReviewScores($course_id, $user_id){
		$scores_query = $this->db->get_where('folat_review_scores', array('course_id' => $course_id, 'student_id' => $user_id) );
		$scores_result = $scores_query->result_array();
		if($scores_result)
		{
			return $scores_result;
		}
		return false;
	}

	public function getReviewScoresAll($course_id){
		$scores_query = $this->db->get_where('folat_review_scores', array('course_id' => $course_id) );
		$scores_result = $scores_query->result_array();
		if($scores_result)
		{
			return $scores_result;
		}
		return false;
	}

	public function checkIfNextModule($prev_module,$course_modules){
		$found = false;
		foreach($course_modules as $mod)
		{
			if($found)
			{
				$next_module = $mod;
				return $next_module;
			}
			if($mod['id'] == $prev_module)
			{
				$found = true;
			}
		}
		return false;
	}

	public function checkIfReviewScore($module_id,$student_id){
		$query = $this->db->get_where('folat_review_scores', array('module_id' => $module_id, 'student_id' => $student_id) );
		$res = $query->result_array();
		return $res;
	}


}