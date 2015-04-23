<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Verify_Check_Answer extends MY_Controller {
  function __construct()
  {
     parent::__construct();
  }
 
  function index()
  { 
	global $data;
	$this->MY_checkIfLoggedIn();//sets user data if logged in or redirects to login 
	$this->MY_setLanguage('QuestionFields');//lang file must be loaded before setting rules
	//This method will have the credentials validation
	$this->load->library('form_validation');
	$this->form_validation->set_rules('course_id', 'Course Id', 'trim|required|xss_clean');
	$this->form_validation->set_rules('module_id', 'Module Id', 'trim|required|xss_clean');
	$this->form_validation->set_rules('slide_id', 'Slide Id', 'trim|required|xss_clean');
	$this->form_validation->set_rules('question_id', 'Question Id', 'trim|required|xss_clean');
	$this->form_validation->set_rules('selected_answer', 'Selected Answer', 'required|xss_clean');
	$this->form_validation->set_rules('question', 'Question', 'trim|required|xss_clean');

	if($this->form_validation->run() == FALSE)
	{
		//Field validation failed
		echo '{
				"validation": "failed"
			  }'; //no json response for ajax throws error
	}
	else
	{
		$user_id = $data['user_id'];
		$c_id = $this->input->post('course_id');
		$m_id = $this->input->post('module_id');
		$s_id = $this->input->post('slide_id');
		$q_id = $this->input->post('question_id');
		$s_ans = $this->input->post('selected_answer');
		$qstn = $this->input->post('question');
		//check if selected answer is correct
		$res = $this->modules_model->checkIfCorrectAnswer($q_id, encodeQuot($s_ans));
		if($res['iscorrect'])
		{
			//save question results in folat_review_results
			$save = $this->modules_model->saveQuestionResult($user_id, $c_id, $m_id, $s_id, $q_id, 1, $s_ans, $s_ans, $qstn);
			//Return Json response
			echo '
				{
					"status" : "correct"
				}
			';
		}
		else
		{
			//save question results in folat_review_results
			$save = $this->modules_model->saveQuestionResult($user_id, $c_id, $m_id, $s_id, $q_id, 0, $s_ans, $res['correct_answer'], $qstn);
			//Return Json response
			echo '
				{
					"status" : "incorrect",
					"correct_answer": "'.$res['correct_answer'].'"
				}
			';
		}
	}
  }
 
}
?>