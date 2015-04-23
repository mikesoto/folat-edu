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
       if($this->account_model->insert_new_user())
       {
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