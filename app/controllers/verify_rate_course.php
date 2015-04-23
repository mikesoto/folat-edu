<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Verify_Rate_Course extends MY_Controller {
  function __construct()
  {
     parent::__construct();
  }
 
  function index()
  { 
     global $data;
     $this->MY_checkIfLoggedIn();//if logged in, sets user data, else sends them to login page
     //$this->MY_setLanguage('Register');//lang file must be loaded before setting rules
     //This method will have the credentials validation
     $this->load->library('form_validation');
     $this->form_validation->set_rules('rating', 'Rating', 'trim|required|xss_clean');
     $this->form_validation->set_rules('course_id', 'Course ID', 'trim|required|xss_clean');
     $this->form_validation->set_rules('module_id', 'Module ID', 'trim|required|xss_clean');
     $this->form_validation->set_rules('comment', 'Comment', 'trim|xss_clean');
   
     if($this->form_validation->run() == FALSE)
     {
       //Field validation failed
       $_SESSION['flash_error'] = "You did not select a rating";
       $this->MY_show_page('Register','classroom/main/'.$this->input->post('module_id'),$data);
     }
     else
     {
       //insert new RATING into database
       $response = $this->account_model->rate_course($this->input->post());
       if($response)
       {
          //create new certificate ID 
          $CertID = $this->account_model->generate_cert_code($this->input->post('course_id'),$data['user_id']);
          //Go to certificate
          redirect('account/certificate/'.$this->input->post('course_id'));
       }
       else
       {
         echo 'There was an error processing your request';
       }
     }
  }
 
}
?>