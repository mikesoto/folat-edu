<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Classroom extends MY_controller {
	function __construct()
	{
	   parent::__construct();
	}

	//function for homepage
	public function index() 
	{
		redirect(base_url('account/taking'));
	}

	public function main($course_slug)
	{
		global $data;
		$this->MY_setLanguage('ClassroomMain');
		//Check if logged in and get user data
		$this->MY_checkIfLoggedIn();
		//Get course data
		$data['course_arr'] = $this->courses_model->getCourseDetails($course_slug);
		if($data['course_arr'])
		{
			//Check if enrolled in this course
			$data['is_enrolled'] = $this->courses_model->checkIfEnrolled($data['user_id'],$data['course_arr']['id']);
			if($data['is_enrolled'])
			{
				//get any existing modules for this course
				$data['modules_arr'] = $this->courses_model->getCourseModules($data['course_arr']['id']); //returns array or false if none
				//get course length and time
				$data['course_arr']['total_length'] = $this->courses_model->getCourseLength($data['modules_arr']);
				$data['course_time'] = convertToTime($data['course_arr']['total_length']);
				//get any review scores data for this course and user
				$data['review_scores'] = $this->modules_model->getReviewScores($data['course_arr']['id'], $data['user_id']);
				//load the classroom main view
				$this->MY_show_page('Classroom '.$data['course_arr']['course_title'], 'classroom_main_view', $data);
			}
			else
			{
				redirect(base_url('account/taking'));
			}
		}
		else
		{
			redirect(base_url('account/taking'));
		}
		
	}


	public function module($module_id)
	{
		global $data;
		$this->MY_setLanguage('ClassroomModule');
		//Check if logged in and get user data
		$this->MY_checkIfLoggedIn();
		//Get module data
		$data['module_arr'] = $this->modules_model->getModuleDetails('id',$module_id);
		$data['has_review_score'] = $this->modules_model->checkIfReviewScore($module_id,$data['user_id']);
		if($data['module_arr'])
		{
			//Check if enrolled in this course
			$data['is_enrolled'] = $this->courses_model->checkIfEnrolled($data['user_id'],$data['module_arr']['course_id']);
			if($data['is_enrolled'])
			{
				//get course array
				$data['course_arr'] = $this->courses_model->getCourseDetailsById($data['module_arr']['course_id']);
				//get all content (slides) for this module
				$data['slides_arr'] = $this->modules_model->getModuleContent('text_slides', $data['module_arr']['id']);
				//load the classroom module view
				$this->MY_show_page('Module '.$data['module_arr']['title'], 'classroom_module_view', $data);
			}
			else
			{
				redirect(base_url('account/taking'));
			}
		}
		else
		{
			redirect(base_url('account/taking'));
		}
	}

	public function generate_review_results($module_id)
	{
		global $data;
		$this->MY_setLanguage('ClassroomModule');
		//Check if logged in and get user data
		$this->MY_checkIfLoggedIn();
		//start json
		echo '{';
		//Get module review data for current user
		$review_results = $this->modules_model->getReviewResults($module_id,$data['user_id']);		
		if($review_results)
		{	
			//save the review results to folat_review_scores table
			$save_res = $this->modules_model->saveReviewResults($review_results,$data['user_id']);
			echo '"rows":[';
			$count = 1;
			$total = count($review_results);
			foreach($review_results as $row)
			{
				echo '	
							{
								"id": "'.$row['id'].'",
								"datetime": "'.$row['datetime'].'",
								"student_id": "'.$row['student_id'].'",
								"course_id": "'.$row['course_id'].'",
								"module_id": "'.$row['module_id'].'",
								"slide_id": "'.$row['slide_id'].'",
								"question_id": "'.$row['question_id'].'",
								"correct_answer": "'.escapeDbQuot($row['correct_answer']).'",
								"selected_answer": "'.escapeDbQuot($row['selected_answer']).'",
								"is_correct": "'.$row['is_correct'].'",
								"question": "'.escapeDbQuot($row['question']).'"
							}
					 ';
				if($count < $total)
				{
					echo ',';
				}
			    $count++;
			}
			echo '],';//close rows list
		}
		//check if there is a next module
		$module_details = $this->modules_model->getModuleDetails("id",$module_id);
		$course_modules = $this->courses_model->getCourseModules($module_details['course_id']);
		$next_module = $this->modules_model->checkIfNextModule($module_id,$course_modules);
		echo '
			"next_module" :';
		if($next_module)
		{
		    echo '
						{
							"set": "TRUE",
							"module_id": "'.$next_module['id'].'",
							"chapter": "'.$next_module['chapter'].'",
							"section": "'.$next_module['section'].'",
							"module_title": "'.escapeDBQuot($next_module['title']).'"
						}
			';
		}
		else
		{
			echo '
						{
							"set": "FALSE"
						}
			';
		}

		//end json
		echo '}';
	}


	public function repeat_module($module_id){
		global $data;
		$this->MY_setLanguage('ClassroomModule');
		//Check if logged in and get user data
		$this->MY_checkIfLoggedIn();
		//delete module review results and scores for this user and moduel from database
		$clear_results = $this->modules_model->clearReviewResults($module_id,$data['user_id']);
		if($clear_results)
		{	//send back to beginning of classroom for module
			redirect(base_url('classroom/module/'.$module_id));
		}
	}

	public function clear_module_review(){
		global $data;
		$this->MY_setLanguage('ClassroomModule');
		//Check if logged in and get user data
		$this->MY_checkIfLoggedIn();
		//delete module review results and scores for this user and moduel from database
		$clear_results = $this->modules_model->clearReviewResults($this->input->post('module_id'),$data['user_id']);
		if($clear_results)
		{	
			echo '{
				"review_cleared" : "TRUE"
			}';
		}
	}

}