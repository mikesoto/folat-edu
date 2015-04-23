<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Verify_Course_Update extends MY_Controller {
  function __construct()
  {
    parent::__construct();
  }
 
  function index()
  { 
     global $data;
     $this->MY_checkIfLoggedIn();//sets user data if logged in or redirects to login 
     $this->MY_setLanguage('CourseManage');//lang file must be loaded before setting rules
     //Credentials validation
     $this->load->library('form_validation');
     $this->form_validation->set_rules('title', 'lang:courseField_title', 'trim|required|xss_clean|max_length[45]|callback_title_check');
     $this->form_validation->set_rules('category', 'lang:courseField_category', 'trim|required|xss_clean');
     $this->form_validation->set_rules('subcategory', 'lang:courseField_subcategory', 'trim|required|xss_clean');
     $this->form_validation->set_rules('description', 'lang:courseField_summary', 'trim|required|xss_clean|callback_file_upload_check');
     $this->form_validation->set_rules('enrollment_status', 'lang:courseField_enrollment', 'trim|required|xss_clean|callback_enrollment_check');

     $course_slug = $this->input->post('course_slug');
     $data['course_arr'] = $this->courses_model->getCourseDetails($course_slug);

     if($this->form_validation->run() == FALSE)
     {
        //validation failed, send them back to the create_course view
        $data['modules_arr'] = $this->courses_model->getCourseModules($data['course_arr']['id']); //returns array or false if none
        $data['course_arr']['total_length'] = $this->courses_model->getCourseLength($data['modules_arr']);
        $data['course_time'] = convertToTime($data['course_arr']['total_length']);
    		$this->MY_get_categories();
    		$this->MY_show_page('Manage Course','course_manage_view',$data);
     }
     else
     {
        //validation passed
        $user_id = $data['user_id'];
        $course_id = $this->input->post('course_id');
        //check if course being updated belongs to current user
        $this->MY_checkIfCourseOwner($course_id);//logs them out if not course owner
        //create new course_slug from new title adn add to the post['course_slug']
        $new_slug = slugify($this->input->post('title'));
        $_POST['course_slug'] = $new_slug;
        //update course in database
        $update_res = $this->courses_model->update_course($this->input->post());
        if($update_res)
        {
          //Go to success message
          $_SESSION['flash_success'] = $this->lang->line('courseManage_verify_success1').$this->input->post('title').$this->lang->line('courseManage_verify_success2');
          redirect('courses/manage/'.$new_slug, 'refresh');
        }
     }
  }

  function title_check() 
  {
     //Field validation succeeded.  Validate new course title against database (must be unique)
     $new_course_title = $this->input->post('title');
     $course_id = $this->input->post('course_id');
     $result = $this->courses_model->check_title_update($new_course_title,$course_id);
     if($result)
     {
       return true;
     }
     else
     {
        $this->form_validation->set_message('title_check', $this->lang->line('courseManage_verify_titleError'));
        return false;
     }
  }

  function enrollment_check() 
  {  global $data;
     //check if course has content necessary for open enrollment
     $status_selected = $this->input->post('enrollment_status');
     if($status_selected == 1)
     {
        //check if course has content
        $data['modules_arr'] = $this->courses_model->getCourseModules($data['course_arr']['id']); //returns array or false if none
        $total_length = $this->courses_model->getCourseLength($data['modules_arr']);
        if($total_length == 0)
        {
          $this->form_validation->set_message('enrollment_check', $this->lang->line('courseManage_verify_enrollmentError'));
          return false; 
        }
     }
     return true;
  }

  function file_upload_check() 
  {
      //check if file was selected for upload
	    if(isset($_FILES['file_course_image']))
	    {
		    $new_course_img = $_FILES['file_course_image']['name'];
	      if(!empty($new_course_img))
	      {
	    	  $course_id = $this->input->post('course_id');
	        $config['upload_path'] = './uploads/course_imgs/';
	        $config['allowed_types'] = 'gif|jpg|jpeg|png';
	        $config['overwrite']  = TRUE;
	        $config['max_size'] = '1024';//1M
	        $config['max_width'] = '800';
	        $config['max_height'] = '800';
	        $config['file_name'] = 'folat_course_'.$course_id;
	        $this->load->library('upload', $config);

	        if(!$this->upload->do_upload('file_course_image'))
	        {
	            $this->form_validation->set_message('file_upload_check',$this->upload->display_errors());
	            return false;
	        }
	        else
	        {   
	            //save course_image filename to the course_image variable
	            $file_data = $this->upload->data();
	            $_POST['course_image'] = $file_data['file_name'];
	            return true;
	        }
	      }
	    }
	    else
	    {
	    	return true;
	    }
  }
}
?>