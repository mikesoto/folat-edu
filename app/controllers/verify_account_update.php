<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Verify_Account_Update extends MY_Controller {
   function __construct()
   {
      parent::__construct();
   }
 
   function index()
   {  
      global $data;
      $this->MY_checkIfLoggedIn();
      //This method will have the credentials validation
      $this->MY_setLanguage('AccountEdit');//lang file must be loaded before setting rules
      $this->load->library('form_validation');
      $this->form_validation->set_rules('user_name', 'lang:form_first_name', 'trim|required|xss_clean');
      $this->form_validation->set_rules('user_lastname', 'lang:form_last_name', 'trim|required|xss_clean');
      $this->form_validation->set_rules('user_email', 'lang:form_email', 'trim|required|xss_clean|valid_email|callback_email_check');
      $this->form_validation->set_rules('user_username', 'lang:form_username', 'trim|required|xss_clean|min_length[5]|max_length[15]|callback_username_check');
      
      $new_user_img = $_FILES['file_user_image']['name'];
      if(!empty($new_user_img))
      {
         $this->form_validation->set_rules('file_user_image', 'Profile Image', 'trim|xss_clean|callback_file_upload_check');
      }

      if($this->form_validation->run() == FALSE)
      {
         $this->send_to_form();
      }
      else
      {
         //UPDATE user info in database
         $update_res = $this->account_model->update_user($data['user_id']);
         if($update_res)
         {
            //update session data with new values
            $sess_array = array(
               'user_id' => $data['user_id'],
               'user_name' => $this->input->post('user_name'),
               'user_lastname' => $this->input->post('user_lastname'),
               'user_email' => $this->input->post('user_email'),
               'user_username' => $this->input->post('user_username'),
               'user_about' => $this->input->post('user_about'),
               'user_image' => $this->input->post('user_image'),
            );
            $this->session->set_userdata('logged_in', $sess_array);
            //Go to success message
            $_SESSION['flash_success'] = $this->lang->line('accountEdit_msg_updateSuccess');
            redirect('account/profile', 'refresh');
         }
      }
   }

   function send_to_form()
   {
      global $data;
      //validation failed, set user variables and load edit_profile_view
      $this->MY_make_account_data();
      $this->MY_show_page('Edit Profile','account_edit_view',$data);
   }

   function username_check() 
   {
      global $data;
      //Field validation succeeded.  Validate new username against database
      $new_username = $this->input->post('user_username');
      $result = $this->account_model->check_username_avail($new_username, $data['user_id']);
      if(!$result)
      {
         $this->form_validation->set_message('username_check', $this->lang->line('accountEdit_msg_usernameTaken'));
         return false;
      } 
      return true;
   }

   function email_check() 
   {
      global $data;
      //Field validation succeeded.  Validate new username against database
      $new_email = $this->input->post('user_email');
      $result = $this->account_model->check_email_avail($new_email, $data['user_id']);
      if(!$result)
      {
         $this->form_validation->set_message('email_check', $this->lang->line('accountEdit_msg_emailTaken') );
         return false;
      }
      return true;
   }

   function file_upload_check() 
   {
      global $data;
      $user_id = $data['user_id'];
      $config['upload_path'] = './uploads/profile_imgs/';
      $config['allowed_types'] = 'gif|jpg|jpeg|png';
      $config['overwrite']  = TRUE;
      $config['max_size'] = '1024';//1M
      $config['max_width'] = '800';
      $config['max_height'] = '800';
      $config['file_name'] = 'folat_profile_'.$user_id;
      $this->load->library('upload', $config);

      if(!$this->upload->do_upload('file_user_image'))
      {
         $this->form_validation->set_message('file_upload_check',$this->upload->display_errors());
         return false;
      }
      else
      {   
         //save user_image filename to the user_image variable
         $file_data = $this->upload->data();
         $_POST['user_image'] = $file_data['file_name'];
         return true;
      } 
   }





}
?>