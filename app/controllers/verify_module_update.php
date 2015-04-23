<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Verify_Module_Update extends MY_Controller {
   function __construct()
   {
    parent::__construct();
   }
 
   function index()
   {
      global $data;
      $this->MY_checkIfLoggedIn();//sets user data if logged in or redirects to login 
      $this->MY_setLanguage('ModuleEdit');//lang file must be loaded before setting rules
      //This method will have the credentials validation
      //** type_id and is not included because it cannot be changed after module has beeen created
      $this->load->library('form_validation');
      $this->form_validation->set_rules('module_id', 'Module Id', 'trim|required|xss_clean');
      $this->form_validation->set_rules('course_id', 'Course Id', 'trim|required|xss_clean');
      $this->form_validation->set_rules('title', 'lang:moduleField_title', 'trim|required|xss_clean|max_length[50]|callback_title_check');
      $this->form_validation->set_rules('chapter', 'lang:moduleField_chapter', 'trim|required|xss_clean|numeric');
      $this->form_validation->set_rules('section', 'lang:moduleField_section', 'trim|required|xss_clean|numeric');
      $this->form_validation->set_rules('summary', 'lang:moduleField_description', 'trim|required|xss_clean');
     
      //check if they own the course they are trying to create a module for
      $course_id = $this->input->post('course_id');
      $this->MY_checkIfCourseOwner($course_id);//logs them out if not owner
     
      //course is theirs, check if validation passed
      if($this->form_validation->run() == FALSE)
      {
          //validation failed, reload the edit_content view with errors
          $module_id = $this->input->post('module_id');
          $data['module_arr'] = $this->modules_model->getModuleDetails('id',$module_id);
          $data['course_arr'] = $this->courses_model->getCourseDetailsById($data['module_arr']['course_id']);
          $data['module_content'] = $this->modules_model->getModuleContent('text_slides',$data['module_arr']['id']);
          $data['module_time'] = convertToTime($data['module_arr']['total_length']);//converts minutes into hh,mm array
          $this->MY_show_page('Edit Content', 'module_edit_content_view',$data);
      }
      else
      {
          //validation passed, updat module in database
          $update_res = $this->modules_model->update_module($this->input->post());
          if($update_res)
          {
             $_SESSION['flash_success'] = $this->lang->line('moduleEdit_msg_updateModuleSuccess1').': <strong>'.$this->input->post('title').'</strong> '.$this->lang->line('moduleEdit_msg_updateModuleSuccess2');
             redirect('modules/edit_content/'.$this->input->post('module_id'));
          }
      }  
   }


   function title_check(){
       //Validate new module title against database (must be unique)
       $new_module_title = $this->input->post('title');
       $module_id = $this->input->post('module_id');
       $result = $this->modules_model->check_title_update($new_module_title,$module_id);
       if($result)
       {
         return true;
       }
       else
       {
          $this->form_validation->set_message('title_check', $this->lang->line('moduleEdit_msg_updateModuleTitleError'));
          return false;
       }
   }

}
?>