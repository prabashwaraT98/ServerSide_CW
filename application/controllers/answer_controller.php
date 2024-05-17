<?php
defined('BASEPATH') or exit('No direct script access allowed');

class answer_controller extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
	}	

	public function deleteAnswer()
	{	
		if (!$this->session->userdata('user_id')) {
			
			redirect('view_and_ask_questions_controller');
		}

		$answer_id = $this->input->post('answer_id');
		$question_id = $this->input->post('question_id');

		$this->load->model('answerModel');
		$this->load->model('questionModel');

		$this->answerModel->deleteAnswer($answer_id);
		$this->questionModel->questionUnsolved($question_id);

		log_message('debug', 'Answer Deleted');

		redirect('question/view/' . $question_id);
	}

}
