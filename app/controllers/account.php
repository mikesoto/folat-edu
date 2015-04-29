<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Account extends MY_controller {
	function __construct()
	{
	   parent::__construct();
	}

	public function index() {
		redirect('account/profile', 'refresh');//redirect shows the correct url after refresh
	}

	function profile(){
		global $data;
		$this->MY_setLanguage('Profile');
		$this->MY_checkIfLoggedIn();//if logged in, sets user data, else sends them to login page
		$this->MY_make_account_data();//adds courses taking, teaching, and account alerts to data array
		$this->MY_show_page('Account Profile', 'account_profile_view', $data);//loads header, content, and footer views
	}

	function taking(){
		global $data;
		$this->MY_setLanguage('CoursesTaking');
		$this->MY_checkIfLoggedIn();//if logged in, sets user data, else sends them to login page
		$this->MY_make_account_data();//adds courses taking, teaching, and account alerts to data array
		$this->MY_show_page('Account Profile', 'account_taking_view', $data);//loads header, content, and footer views
	}

	function teaching(){
		global $data;
		$this->MY_setLanguage('CoursesTeaching');
		$this->MY_checkIfLoggedIn();//sets user data if logged in
		$this->MY_make_account_data();//adds courses taking, teaching, and account alerts to data array
		$this->MY_show_page('Account Teaching', 'account_teaching_view', $data);//loads header, content, and footer views
	}

	public function login(){
		global $data;
		$this->MY_setLanguage('Login');
		$data['ref_uri'] = $this->uri->uri_string();
		$this->MY_show_page('Login', 'login_view',$data);
	}
 
	public function logout()
	{ 
	   $this->session->unset_userdata('logged_in'); 
	   session_destroy(); 
	   redirect('account/login');
	}

	public function register($success = false) {
		global $data;
		$this->MY_setLanguage('Register');
		$this->MY_show_page('Register', 'account_create_view');

	}

	function edit()
	{	
		global $data;
		$this->MY_setLanguage('AccountEdit');
		$this->MY_checkIfLoggedIn();//if logged in, sets user data, else sends them to login page
		$this->MY_make_account_data();//adds courses taking, teaching, and account alerts to data array
		$this->MY_show_page('Edit Account', 'account_edit_view', $data);
	}

	public function enroll($course_slug){
		global $data;
		$this->MY_setLanguage('CourseDetails');
		$this->MY_checkIfLoggedIn();//if logged in, sets user data, else sends them to login page
		$this->MY_make_account_data();//adds courses taking, teaching, and account alerts to data array
		$res = $this->courses_model->enroll_user($data['user_id'],$course_slug);
		if($res != 'ok')
		{	//res is enrollment date
			$_SESSION['flash_error'] = $this->lang->line('courseDetails_msg_alreadyRegistered').$res;
		}
		else
		{
			$_SESSION['flash_success'] = $this->lang->line('courseDetails_msg_registerSuccess').
										'<a class="btn btn-success" href="'.base_url("classroom/main/".$course_slug).'">'.
											$this->lang->line('courseDetails_btn_goToClass').
										'</a>';
		}
		//Go back to the course page
     	redirect('courses/details/'.$course_slug, 'refresh');
	}

	public function certificate($cert_id){
		//public page (no login required)
		global $data;
		$this->MY_setLanguage('Certificate');
		$data['cert_data'] = $this->account_model->getCertData($cert_id);
		$data['course_arr'] = $this->courses_model->getCourseDetailsById($data['cert_data']['course_id']);
		$data['student_data'] = $this->account_model->get_user_data($data['cert_data']['user_id']);
		$this->MY_show_page('Certificate', 'certificate_view', $data);//loads header, content, and footer views
	}


}