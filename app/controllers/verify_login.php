<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Verify_Login extends MY_Controller {
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
     $this->form_validation->set_rules('user_username', 'lang:form_username', 'trim|required|xss_clean');
     $this->form_validation->set_rules('user_password', 'lang:form_password', 'trim|required|xss_clean|callback_check_database');
     $this->form_validation->set_rules('terms', 'lang:form_terms_of_service', 'required');
   
     if($this->form_validation->run() == FALSE)
     {
       //Field validation failed.  User redirected to login page
       $data['ref_uri'] = $this->uri->uri_string();
       $this->MY_setLanguage('Login');
       $this->MY_show_page('Login','login_view');
     }
     else
     {
        //validation passed, if there is a reference page, send them there, else send to account/profile page
        $ref = $_GET['ref'];
        if($ref != '')
        {
          //Go to private area
          redirect($ref, 'refresh');
        }
        //Go to account profile
        redirect('account/profile/', 'refresh');
     }
   
  }
 
  function check_database($user_password)
  {
     //Field validation succeeded.  Validate against database
     $user_username = $this->input->post('user_username');
     //query the database
     $result = $this->account_model->login($user_username, $user_password);
   
     if($result)
     {
       $sess_array = array();
       foreach($result as $row)
       {
         $sess_array = array(
           'user_id' => $row->user_id,
           'user_name' => $row->user_name,
           'user_lastname' => $row->user_lastname,
           'user_email' => $row->user_email,
           'user_username' => $row->user_username,
           'user_about' => $row->user_about,
           'user_image' => $row->user_image,
         );
         $this->session->set_userdata('logged_in', $sess_array);
       }
       return TRUE;
     }
     else
     {
       $this->form_validation->set_message('check_database', 'Invalid username or password');
       return false;
     }
  }
}
?>