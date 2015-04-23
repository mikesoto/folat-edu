<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Verify_Text_Slide_Update extends MY_Controller {
   function __construct()
   {
    parent::__construct();
   }
 
   function index()
   {
     global $data;
     $this->MY_checkIfLoggedIn();//generates user data if logged or sends them to login page
     //This method will have the credentials validation
     $this->MY_setLanguage('ModuleEdit');//lang file must be loaded before setting rules
     $this->load->library('form_validation');
     $this->form_validation->set_rules('module_id', 'Module Id', 'trim|required|xss_clean');
     $this->form_validation->set_rules('slide_id', 'Slide Id', 'trim|required|xss_clean');
     $this->form_validation->set_rules('title', 'lang:slideField_title', 'trim|required|xss_clean|max_length[50]');
     $this->form_validation->set_rules('body', 'lang:slideField_body', 'trim|required|xss_clean|max_length[2000]');
     $this->form_validation->set_rules('order_num', 'lang:slideField_orderNum', 'trim|required|xss_clean|numeric');
     $this->form_validation->set_rules('length', 'lang:slideField_length', 'trim|required|xss_clean|numeric');
     $this->form_validation->set_rules('refs', 'lang:slideField_references', 'trim|xss_clean');
 
    $module_id = $this->input->post('module_id');
    $data['module_arr'] = $this->modules_model->getModuleDetails('id',$module_id);
    $data['course_arr'] = $this->courses_model->getCourseDetailsById($data['module_arr']['course_id']);
    //check if they own the course of the module they are trying to create a slide for
    $this->MY_checkIfCourseOwner($data['course_arr']['id']);
    //course and module is theirs check if validation passed
    if($this->form_validation->run() == FALSE)
    {
      //validation failed, reload the edit_content view with errors
      $data['module_content'] = $this->modules_model->getModuleContent('text_slides',$data['module_arr']['id']);
      $data['module_time'] = convertToTime($data['module_arr']['total_length']);//converts minutes into hh,mm array
      $this->MY_show_page('Edit Content', 'module_edit_content_view',$data);
    }
    else //validation passed, update slide in database
    {
      //filter the encoded html for embeded videos back into normal html
      $f_body = str_replace( array('&lt;iframe', '&gt;&lt;/iframe&gt;', '&gt;&lt;/iframe>') , array('<iframe', '></iframe>', '></iframe>'), $this->input->post('body') );
      $slide_data = array(
        'module_id' => $this->input->post('module_id'),
        'slide_id' => $this->input->post('slide_id'),
        'title' => $this->input->post('title'),
        'body' => $f_body,
        'order_num' => $this->input->post('order_num'),
        'length' => $this->input->post('length'),
        'refs' => lineBreaksToBr($this->input->post('refs'))
      );

      $update_res = $this->modules_model->update_slide($slide_data);
      if($update_res)
      {
        $slide_title = $this->input->post('title');
        //reload the edit content form (keeps them from refreshing page and sending duplicate posts)
        $_SESSION['flash_success'] = $this->lang->line('moduleEdit_msg_updateSlideSuccess1').': <strong>'.$slide_title.'</strong> '.$this->lang->line('moduleEdit_msg_updateSlideSuccess2');
        redirect(base_url('modules/edit_content/'.$module_id,'refresh'));
      }
    }      
  }

}

?>