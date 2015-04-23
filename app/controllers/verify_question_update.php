<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Verify_Question_Update extends MY_Controller {
   function __construct()
   {
    parent::__construct();
   }
 
   function index()
   {
      global $data;
      $this->MY_checkIfLoggedIn();//generates user data if logged or sends them to login page
      $this->MY_setLanguage('ModuleEdit');
      //This method will have the credentials validation
      $this->load->library('form_validation');
      $this->form_validation->set_rules('module_id', 'Module ID', 'trim|required|xss_clean');
      $this->form_validation->set_rules('slide_id', 'Slide ID', 'trim|required|xss_clean');
      $this->form_validation->set_rules('question_id', 'Question ID', 'trim|required|xss_clean');
      $this->form_validation->set_rules('question', 'lang:questionField_question', 'trim|required|xss_clean|max_length[145]');
      $this->form_validation->set_rules('answer', 'lang:questionField_correctAnswer', 'trim|required|xss_clean|max_length[145]');
      $this->form_validation->set_rules('wrong_1', 'lang:questionField_incorrectAnswer1', 'trim|required|xss_clean|max_length[145]');
      $this->form_validation->set_rules('wrong_2', 'lang:questionField_incorrectAnswer2', 'trim|xss_clean|max_length[145]');
      $this->form_validation->set_rules('wrong_3', 'lang:questionField_incorrectAnswer3', 'trim|xss_clean|max_length[145]');

      $module_id = $this->input->post('module_id');
      $data['module_arr'] = $this->modules_model->getModuleDetails('id',$module_id);
      $data['course_arr'] = $this->courses_model->getCourseDetailsById($data['module_arr']['course_id']);
      //check if they own the course of the module of the slide they are trying to update the question for
      $this->MY_checkIfCourseOwner($data['course_arr']['id']);
      
      //course and module is theirs check if validation passed
      if($this->form_validation->run() == FALSE)
      {
         //validation failed, reload the edit_content view with errors
         $data['module_content'] = $this->modules_model->getModuleContent('text_slides',$data['module_arr']['id']); 
         $this->MY_show_page('Edit Content', 'module_edit_content_view',$data);
      }
      else//validation passed, update question in database
      {            
         //encode double quotes as &quot; 
         $q_array = array(
            'module_id' => $this->input->post('module_id'),
            'slide_id' => $this->input->post('slide_id'),
            'question_id' => $this->input->post('question_id'),
            'slide_id' => $this->input->post('slide_id'),
            'question' =>  encodeQuot($this->input->post('question')),
            'answer' =>   encodeQuot($this->input->post('answer')),
            'wrong_1' =>  encodeQuot($this->input->post('wrong_1')),
            'wrong_2' =>  encodeQuot($this->input->post('wrong_2')),
            'wrong_3' =>  encodeQuot($this->input->post('wrong_3')),
         );
         $updated = $this->modules_model->update_question($q_array);
         if($updated)
         {
            $_SESSION['flash_success'] = $this->lang->line("moduleEdit_msg_updateQuestionSuccess");
            //reload the edit content form (keeps them from refreshing page and sending duplicate posts)
            redirect(base_url('modules/edit_content/'.$data['module_arr']['id'],'refresh'));
         }
      }      
   }

}
?>