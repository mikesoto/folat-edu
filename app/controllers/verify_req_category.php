<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Verify_Req_Category extends MY_Controller {
   function __construct()
   {
    parent::__construct();
   }
 
   function index()
   {
      global $data;
      $this->MY_checkIfLoggedIn();//sets user data if logged in or redirects to login 
      $this->MY_setLanguage('CoursesListing');
      //This method will have the credentials validation
      $this->load->library('form_validation');
      $this->form_validation->set_rules('user_id', 'User ID', 'trim|required|xss_clean');
      $this->form_validation->set_rules('user_username', 'User username', 'trim|required|xss_clean');
      $this->form_validation->set_rules('user_email', 'User email', 'trim|required|xss_clean');
      $this->form_validation->set_rules('cat', 'Category', 'trim|required|xss_clean');
      $this->form_validation->set_rules('subcat', 'Subcategory', 'trim|required|xss_clean');
      $this->form_validation->set_rules('description', 'Description', 'trim|required|xss_clean');
    
     
      //check if validation passed
      if($this->form_validation->run() == FALSE)
      {
          //validation failed, send them back to the course list view
          global $data;
          $this->MY_setCatFilters(NULL,NULL);//sets the category and subcategory variables in the data array
          $this->MY_get_categories();//sets the cat_list and subcat_list variables
          $data['courses_arr'] = $this->courses_model->getCourses(NULL, NULL, FALSE, $this->config->item('language'));
          $this->MY_show_page('Courses', 'course_list_view', $data);
      }
      else
      {
          $this->load->library('email');
          $this->email->from($this->input->post('user_email'), $this->input->post('user_username'));
          $this->email->to('desarrollowebuno@gmail.com');
          $body = 'New Category Request!:<br/>
          From user: '.$this->input->post('user_username').' (id: '.$this->input->post('user_id').')<br/>
          Category: '.$this->input->post('cat').'<br/>
          Subcategory: '.$this->input->post('subcat').'<br/>
          Description: '.$this->input->post('description').'<br/>
          ';
          $this->email->subject('New Category Request');
          $this->email->message($body);
          if(!$this->email->send()){
           // echo $this->email->print_debugger();
           die();
          }

          //Go to success message
          $_SESSION['flash_success'] = 'Thank you for requesting a new category.<br/>We will let you know soon if it has been approved or not.<br/> If you are creating a new course you can set it to an existing category that most closely matches your course and change it later.';
          redirect(base_url('courses'));
      }  
   }

}
?>