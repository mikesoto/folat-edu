<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Verify_Module_Create extends MY_Controller {
   function __construct()
   {
    parent::__construct();
   }
 
   function index()
   {
     global $data;
     $this->MY_checkIfLoggedIn();//sets user data if logged in or redirects to login 
     $this->MY_setLanguage('ModuleCreate');
     //This method will have the credentials validation
     $this->load->library('form_validation');
     $this->form_validation->set_rules('course_id', 'Course Id', 'trim|required|xss_clean');
     $this->form_validation->set_rules('type_id', 'lang:moduleField_type', 'trim|required|xss_clean');
     $this->form_validation->set_rules('title', 'lang:moduleField_title', 'trim|required|xss_clean|max_length[50]|is_unique[folat_modules.title]');
     $this->form_validation->set_rules('chapter', 'lang:moduleField_chapter', 'trim|required|xss_clean|numeric');
     $this->form_validation->set_rules('section', 'lang:moduleField_section', 'trim|required|xss_clean|numeric');
     $this->form_validation->set_rules('summary', 'lang:moduleField_description', 'trim|required|xss_clean');
     
      //check if they own the course they are trying to create a module for
      $course_id = $this->input->post('course_id');
      $this->MY_checkIfCourseOwner($course_id);//logs them out if not owner
     
      //course is theirs check if validation passed
      if($this->form_validation->run() == FALSE)
      {
          
          //validation failed, send them back to the create_course view
          $data['mod_types'] = $this->modules_model->getModuleTypes();
          $data['course_arr'] = $this->courses_model->getCourseDetailsById($course_id);
          $this->MY_show_page('Create Module', 'module_create_view',$data);
      }
      else
      {
          //validation passed, insert new module into database
          $insert_id = $this->modules_model->add_new_module($this->input->post(),$data['user_id']);
          if($insert_id)
          {
             $_SESSION['flash_success'] = 'Your new module has been created successfully.<br/>You can now begin adding content and review questions to your module for students to follow.';
             redirect('modules/edit_content/'.$insert_id);
          }
      }  
   }

}
?>