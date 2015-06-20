<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
ini_set('display_errors', '1');
error_reporting(E_ALL);
ini_set('error_log', APPPATH .'logs/php_errors.log'); 
class MY_Controller extends CI_controller {
	function __construct()
	{
	   parent::__construct();
	   $this->load->model('account_model');
	   $this->load->model('courses_model');
	   $this->load->model('modules_model');
	   $this->load->helper(array('my_str_helper','my_time_helper'));
	   $data = array();
	}

	public function MY_setLanguage($page)
	{
		if(isset($_GET['lang'])){//saves new set language to session and config parameters
			$language = addslashes(htmlentities($_GET['lang']));
			//store language setting in the session so it get's loaded on every page
			$this->session->set_userdata('language', $language);
			//send back to the page they where on before they selected language
			if(isset($_GET['refurl']))
			{
				$refurl = addslashes($_GET['refurl']);
				redirect(base_url($refurl));
			}
		}
		else
		{
			//set English as default language if has not already been set
			if($this->session->userdata('language') == '')
			{
				$this->session->set_userdata('language','english');
			}	
		}
		$this->config->set_item('language', $this->session->userdata('language'));
		//load all global language files
		$this->lang->load('folat_Header', $this->config->item('language'));
		$this->lang->load('folat_Forms', $this->config->item('language'));
		$this->lang->load('folat_CourseFields', $this->config->item('language'));
		$this->lang->load('folat_Categories', $this->config->item('language'));
		$this->lang->load('folat_ModuleFields', $this->config->item('language'));
		$this->lang->load('folat_SlideFields', $this->config->item('language'));
		$this->lang->load('folat_QuestionFields', $this->config->item('language'));

		//set the lang file for the current page (found in app/language dir)
		$this->lang->load('folat_'.$page, $this->config->item('language'));
	}

	public function MY_checkIfLoggedIn()
	{
		//check if logged in for backend pages
		if($this->session->userdata('logged_in'))
		{
			global $data;
			//add the users data to the data array
			$session_data = $this->session->userdata('logged_in');
		    $data['user_id'] = $session_data['user_id'];
		    $data['user_name'] = $session_data['user_name'];
		    $data['user_lastname'] = $session_data['user_lastname'];
		    $data['user_email'] = $session_data['user_email'];
		    $data['user_username'] = $session_data['user_username'];
		    $data['user_about'] = $session_data['user_about'];
		    $data['user_image'] = $session_data['user_image'];
		}
	    else
	    {
	    	//send to login
	    	$_SESSION['flash_error'] =  'You must be logged in to view that page.';
	    	redirect('account/login/'.$this->uri->uri_string(), 'refresh');
	    }
	}

	public function MY_make_account_data(){
		global $data;
		//shortcut for creating all account data 
		$this->MY_get_courses_taking();
		$this->MY_get_courses_teaching();
		$this->MY_get_account_alerts();
	}

	public function MY_get_courses_taking(){
		global $data;
		//is logged in so set user variables and load account view
		$data['courses_taking'] = $this->account_model->get_courses_taking($data['user_id']);
	}

	public function MY_get_courses_teaching(){
		global $data;
		//is logged in so set user variables and load account view
		$data['courses_teaching'] = $this->account_model->get_courses_teaching($data['user_id']);
	}

	public function MY_get_account_alerts(){
		global $data;
		//is logged in so set user variables and load account view
		$data['account_alerts'] = $this->account_model->get_account_alerts($data);
	}
	
	public function MY_show_page($title = '', $view = '', $data = array())
	{
		global $data;
		$data['page_title'] = $title;
		$this->load->view('templates/header.php',$data);
		$this->load->view($view,$data);
		$this->load->view('templates/footer.php',$data);
	}

	public function MY_setCatFilters($cat_slug,$subcat_slug){
		global $data;
		$data['category'] = ucwords(str_replace("-"," ",$cat_slug));
		$data['subcategory'] = ucwords(str_replace("-"," ",$subcat_slug));
	}

	public function MY_get_categories(){
		global $data;
		$data['cat_list'] = $this->courses_model->getCatList();
		$data['subcat_list'] = $this->courses_model->getSubCatList();
	}

	public function MY_get_incategories(){
		global $data;
		$data['incat'] = $this->courses_model->getInCategories($data['cat_list'], $this->config->item('language'));
		$data['insubcat'] = $this->courses_model->getInSubCategories($data['subcat_list'], $this->config->item('language'));
	}

	public function MY_checkIfCourseOwner($course_id){
		global $data;
		if(!$this->courses_model->check_ownership($course_id, $data['user_id']))
		{
			//they are not the course owner so log them out
			redirect('account/logout');
		}
		//else they are the course owner and you may continue.
	}
	
}