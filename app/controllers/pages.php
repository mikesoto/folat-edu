<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Pages extends MY_controller {
	function __construct()
	{
	   parent::__construct();
	}

	//loads homepage
	public function index() {

		global $data;
		$this->MY_setLanguage('Home');
		$data['courses_arr'] = $this->courses_model->getCourses(NULL, NULL, TRUE,$this->config->item('language'));
		$this->MY_show_page('Home', 'home_view', $data);
	}

	//loads terms of service
	public function terms() {
		global $data;
		$this->MY_setLanguage('Home');
		$this->MY_show_page('Home', 'terms_view', $data);
	}
}