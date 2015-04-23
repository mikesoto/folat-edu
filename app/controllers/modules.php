<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Modules extends MY_controller {
	function __construct()
	{
	   parent::__construct();
	}

	//function for homepage
	public function index() {
		
	}

	public function create($course_id){
		global $data;
		$this->MY_setLanguage('ModuleCreate');
		//check if user has an open session
		$this->MY_checkIfLoggedIn();//sets user data if logged in
			//is logged in so set user variables 
			$data = $this->account_model->build_user_data();
			$data['course_arr'] = $this->courses_model->getCourseDetailsById($course_id);
			if($data['course_arr'])
			{
				//check if they own the course they are trying to create a module for
				if($this->courses_model->check_ownership($course_id, $data['user_id']))
				{
					$data['mod_types'] = $this->modules_model->getModuleTypes();
					
					$this->load->helper(array('form'));
					$this->MY_show_page('Create Module', 'module_create_view',$data);
				}
				else
				{
					redirect('account/logout','refresh');
				}
			}
		
		
	}

	public function edit_content($module_id = false){
		global $data;
		if(!$module_id || !is_numeric($module_id))
		{
			redirect('account/teaching','refresh');
		}
		else
		{
			$this->MY_setLanguage('ModuleEdit');
			$data['module_arr'] = $this->modules_model->getModuleDetails('id',$module_id);
			$data['module_time'] = convertToTime($data['module_arr']['total_length']);//converts minutes into hh,mm array
			$data['module_content'] = $this->modules_model->getModuleContent('text_slides',$data['module_arr']['id']);
			$data['course_arr'] = $this->courses_model->getCourseDetailsById($data['module_arr']['course_id']);
			$this->load->helper('form');
	        $this->MY_show_page('Edit Content', 'module_edit_content_view',$data);
		}	
	}

	public function delete_question($module_id,$slide_id,$question_id){
		global $data;
		$this->MY_setLanguage('ModuleEdit');
		if(is_numeric($module_id) && is_numeric($slide_id) && is_numeric($question_id))
		{
			$this->MY_checkIfLoggedIn();//if logged in, sets user data, else sends them to login page
			$user_id = $data['user_id'];
			//check if course being deleted belongs to current user
			if($this->modules_model->check_ownership($module_id, $user_id))
			{
				//they are the owner of the module delete question from slide
				$res = $this->modules_model->delete_question($slide_id,$question_id);
				if($res)
				{
					$_SESSION['flash_success'] = $this->lang->line('moduleEdit_msg_deleteQuestionSuccess');
					redirect('modules/edit_content/'.$module_id);
				}
			}
			else
			{
				//not owner log them out
				redirect('account/logout');
			}
		}
		else
		{
			//send to home
			redirect(base_url());
		}
	}

	public function delete_slide($module_id,$slide_id){
		global $data;
		$this->MY_setLanguage('ModuleEdit');
		if(is_numeric($module_id) && is_numeric($slide_id))
		{
			$this->MY_checkIfLoggedIn();//if logged in, sets user data, else sends them to login page
			$user_id = $data['user_id'];
			//check if slide/module/course being deleted belongs to current user
			if($this->modules_model->check_ownership($module_id, $user_id))
			{
				//they are the owner of the module delete question from slide
				$res = $this->modules_model->delete_slide($slide_id);
				if($res)
				{
					$_SESSION['flash_success'] = $this->lang->line('moduleEdit_msg_deleteSlideSuccess');
					redirect('modules/edit_content/'.$module_id);
				}
			}
			else
			{
				//not owner log them out
				redirect('account/logout');
			}
		}
		else
		{
			//send to home
			redirect(base_url());
		}
	}


	public function delete_module($module_id,$course_slug){
		global $data;
		if(is_numeric($module_id))
		{
			$this->MY_checkIfLoggedIn();//if logged in, sets user data, else sends them to login page
			$user_id = $data['user_id'];
			$this->MY_setLanguage('CourseManage');
			//check if slide/module/course being deleted belongs to current user
			if($this->modules_model->check_ownership($module_id, $user_id))
			{
				//they are the owner of the module delete module
				$res = $this->modules_model->delete_module($module_id);
				if($res)
				{
					$_SESSION['flash_success'] = $this->lang->line('courseManage_verify_deleteModuleSuccess');
					redirect('courses/manage/'.$course_slug);
				}
			}
			else
			{
				//not owner log them out
				redirect('account/logout');
			}
		}
		else
		{
			//send to home
			redirect(base_url());
		}
	}



}