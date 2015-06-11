<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Verify_Account_Create extends MY_Controller {
  function __construct()
  {
     parent::__construct();
  }
 
  function index()
  { 
     global $data;
     $this->MY_setLanguage('Register');//lang file must be loaded before setting rules
     //This method will have the credentials validation
     $this->load->library('form_validation');
     $this->form_validation->set_rules('user_name', 'lang:form_first_name', 'trim|required|xss_clean');
     $this->form_validation->set_rules('user_lastname', 'lang:form_last_name', 'trim|required|xss_clean');
     $this->form_validation->set_rules('user_email', 'lang:form_email', 'trim|required|xss_clean|valid_email|is_unique[folat_users.user_email]');
     $this->form_validation->set_rules('user_username', 'lang:form_username', 'trim|required|xss_clean|min_length[5]|max_length[15]|is_unique[folat_users.user_username]');
     $this->form_validation->set_rules('user_password', 'lang:form_password', 'trim|required|xss_clean||min_length[8]|max_length[18]|matches[user_password_conf]|md5');
     $this->form_validation->set_rules('user_password_conf', 'lang:form_confirm_password', 'trim|required|xss_clean');
     $this->form_validation->set_rules('terms', 'lang:form_terms_of_service', 'required');
   
     if($this->form_validation->run() == FALSE)
     {
       //Field validation failed
       $this->MY_show_page('Register','account_create_view',$data);
     }
     else
     {
       //insert new user into database
       $hash = $this->account_model->insert_new_user();
       if($hash)
       {
          $this->load->library('email');
          $this->email->from($this->input->post('user_email'), $this->input->post('user_name'));
          $this->email->to('desarrollowebuno@gmail.com');
          $body = 'You have a new user!:<br/>
          first name: '.$this->input->post('user_name').'<br/>
          last name: '.$this->input->post('user_lastname').'<br/>
          email: '.$this->input->post('user_email').'<br/>
          username: '.$this->input->post('user_username').'<br/>
          ';
          $this->email->subject('New user Registration');
          $this->email->message($body);
          if(!$this->email->send()){
           // echo $this->email->print_debugger();
           die();
          }

          $this->email->to($this->input->post('user_email'), $this->input->post('user_name'));
          $this->email->from('noreply@folat-edu.net');
          $body = 'Thank you for registering for an account at folat-edu.net.<br/>
          Activate your account by clicking on the following link: <br/>
          http://folat-edu.net/account/validate/?hc='.$hash.'<br/><br/>
          The following is the information provided at registration: <br/>
          first name: '.$this->input->post('user_name').'<br/>
          last name: '.$this->input->post('user_lastname').'<br/>
          email: '.$this->input->post('user_email').'<br/>
          username: '.$this->input->post('user_username').'<br/><br/>
          If you did not register for this account, do not click the activation link above and contact us at info@folat-edu.net
          ';
          $this->email->subject('Folat-edu.net Account Verification');
          $this->email->message($body);
          if(!$this->email->send()){
           // echo $this->email->print_debugger();
           die();
          }

          //Go to success message
          $_SESSION['flash_success'] = $this->lang->line('register_text_thankYouMessage');
          redirect('account/login');
       }
       else
       {
         echo 'There was an error processing your request';
       }
     }
  }
 
}
?>