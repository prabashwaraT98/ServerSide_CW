<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class question_controller extends CI_Controller
{

	protected $data = [];
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->data['user_id'] = $this->session->userdata('user_id');
		$this->data['username'] = $this->session->userdata('username');
		$this->load->helper('url');
		$this->load->model('questionModel');
		$this->load->model('answerModel');
		$this->load->helper('date');
		date_default_timezone_set('Asia/Colombo');
		$this->data['showForm'] = false;
	}

    public function displayAnsweringForm($question_id)
	{
		if (!$this->session->userdata('user_id')) {
			
			$this->previousUrlSet();
			redirect('user_controller/login');
		}

		$this->data['question_id'] = $question_id;

		$question = $this->questionModel->getQuestion($question_id);
		$this->data['question'] = $question;


		$this->data['showForm'] = true;
		log_message('debug', 'Answer Form Shown');
		$this->load->view('question_answer_page', $this->data);
	}

    public function questionSolved()
	{
		if (!$this->session->userdata('user_id')) {
			
			$this->previousUrlSet();
			redirect('user_controller/login');
		}
		
		$question_id = $this->input->post('question_id');
		$answer_id = $this->input->post('answer_id');

		$this->questionModel->questionSolved($question_id);
		$this->answerModel->answerCorrect($answer_id);

		redirect('question/view/' . $question_id);

		log_message('debug', 'Question Marked as Solved');
	}

	public function deleteQuestion()
	{	
		if (!$this->session->userdata('user_id')) {
			
			redirect('view_and_ask_questions_controller');
		}
		
		$question_id = $this->input->post('question_id');
		
		$this->load->model('questionModel');
	
		$this->questionModel->deleteAnswersByQuestionId($question_id);

		$this->questionModel->deleteQuestion($question_id);
		log_message('debug', 'Question Deleted');
		
		redirect('view_and_ask_questions_controller');
	}

    public function giveAnswer($question_id)
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('answer', 'Answer', 'required');

		$answer = $this->input->post('answer');

		if ($this->form_validation->run() == FALSE) {
			$this->displayAnsweringForm($question_id);
		} else {
			$this->load->model('answerModel');

			$user_id = $this->session->userdata('user_id');

			$this->answerModel->giveAnswer($answer, $question_id, $user_id);
			log_message('debug', 'Answer Given');

			redirect('question/view/' . $question_id);
		}

	}

    public function showQuestion($id)
	{

		$question = $this->questionModel->getQuestion($id);
		$this->data['question'] = $question;

		$this->load->view('question_answer_page', $this->data);
	}

	public function previousUrlSet()
	{
		$this->session->set_userdata('previous_url', current_url());
	}
}