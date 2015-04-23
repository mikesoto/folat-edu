<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Verify_Course_Create extends MY_Controller {
  function __construct()
  {
    parent::__construct();
  }

  function index()
  { 
     global $data;
     $this->MY_checkIfLoggedIn();//sets user data if logged in or redirects to login 
     $this->MY_setLanguage('CourseCreate');//lang file must be loaded before setting rules
     //This method will have the credentials validation
     $this->load->library('form_validation');
     $this->form_validation->set_rules('category', 'lang:courseField_category', 'trim|required|xss_clean');
     $this->form_validation->set_rules('subcategory', 'lang:courseField_subcategory', 'trim|required|xss_clean');
     $this->form_validation->set_rules('title', 'lang:courseField_title', 'trim|required|xss_clean|max_length[45]|callback_title_check');
     $this->form_validation->set_rules('course_lang', 'lang:courseField_language', 'trim|required|xss_clean');
     $this->form_validation->set_rules('description', 'lang:courseField_summary', 'trim|required|xss_clean');
    
     if($this->form_validation->run() == FALSE)
     {
        //validation failed, send them back to the create_course view
        $this->MY_get_categories();//sets the cat_list and subcat_list variables
        $this->MY_show_page('Create Course', 'course_create_view', $data);  
     }
     else
     {
       //insert new course into database
       $course_slug = $this->courses_model->add_new_course($this->input->post(),$data['user_id']);
       if($course_slug)
       {
          $_SESSION['flash_success'] = $this->lang->line('courseCreate_msg_createSuccess1').': <strong>'.$this->input->post('title').'</strong>'.$this->lang->line('courseCreate_msg_createSuccess2');
          redirect('courses/manage/'.$course_slug);
       }
     } 
  }

  function title_check() 
  {
     //Field validation succeeded.  Validate new course title against database (must be unique)
     $new_course_title = $this->input->post('title');
     $result = $this->courses_model->check_title_available($new_course_title);
     if($result)
     {
        return true;
     }
     else
     {
        $this->form_validation->set_message('title_check', $this->lang->line('courseCreate_msg_titleCheckFail') );
        return false;
     }
  }


}
?>