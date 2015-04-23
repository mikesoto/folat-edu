<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Verify_Question_Move extends MY_Controller {
   function __construct()
   {
    parent::__construct();
   }

   function index()
   {  
      global $data;
      $this->MY_checkIfLoggedIn();//sets user data if logged in or redirects to login 
      $this->MY_setLanguage('ModuleEdit');
      //This method will have the credentials validation
      $this->load->library('form_validation');
      $this->form_validation->set_rules('move_to_slide_id', 'Slide Id', 'trim|required|xss_clean');
      $this->form_validation->set_rules('question_id', 'Question Id', 'trim|rquired|xss_clean');
      
      $module_id = $this->input->post('module_id');
      $data['module_arr'] = $this->modules_model->getModuleDetails('id',$module_id);
      $data['course_arr'] = $this->courses_model->getCourseDetailsById($data['module_arr']['course_id']);
      //check if they own the course of the module they are trying to move the question for
      $this->MY_checkIfCourseOwner($data['course_arr']['id']);//logs them out if not owner
    
      //course and module is theirs check if validation passed
      if($this->form_validation->run() == FALSE)
      {
         //validation failed, redirect to edit_content page
         $_SESSION['flash_error'] = $this->lang->line('moduleEdit_msg_moveQuestionError');
         redirect('modules/edit_content/'.$module_id);
      }
      else
      {            
         //validation passed, move question to new slide in database
         $updated = $this->modules_model->move_question($this->input->post());
         if($updated)
         {
            //reload the edit content form (keeps them from refreshing page and sending duplicate posts)
            $_SESSION['flash_success'] = $this->lang->line("moduleEdit_msg_moveQuestionSuccess");
            redirect(base_url('modules/edit_content/'.$module_id));
         }
      }     
   }

}
?>