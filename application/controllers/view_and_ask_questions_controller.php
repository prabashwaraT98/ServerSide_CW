<?php
defined('BASEPATH') or exit('No direct script access allowed');

class view_and_ask_questions_controller extends CI_Controller
{

	protected $data = [];
	protected $questions = [];

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->helper('date');
		date_default_timezone_set('Asia/Colombo');
		$this->load->model('questionModel');
		$this->data['user_id'] = $this->session->userdata('user_id');
		$this->data['username'] = $this->session->userdata('username');
		$this->data['title'] = 'Home';
		$this->questions = $this->questionModel->displayQuestions();
		$this->data['questions'] = $this->questions;
		$this->data['showForm'] = false;
	}

	public function index()
	{

		$this->data['showForm'] = false;

		$this->load->view('view_and_ask_questions', $this->data);
		log_message('debug', 'View and Ask Questions Page Loaded');
	}

	public function displayQuestionSubmitForm()
	{
		if (!$this->session->userdata('user_id')) 
		{
			$this->previousUrlSet();
			redirect('user_controller/login');
		}

		$this->load->library('form_validation');

		$this->data['showForm'] = true;
		log_message('debug', 'Question Submit Form Displayed');
		$this->load->view('view_and_ask_questions', $this->data);
	}

	public function submitQuestion()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('description', 'Description', 'required');

		
		$title = $this->input->post('title');
		$description = $this->input->post('description');


		if ($this->form_validation->run() == FALSE) {
			$this->displayQuestionSubmitForm();
		} else {
			
			$user_id = $this->session->userdata('user_id');

		
			$this->questionModel->submitQuestion($title, $description, $user_id);
			log_message('debug', 'Question Submitted');

			redirect('view_and_ask_questions_controller');
		}

	}

	public function search()
	{

		$search = $this->input->get('search');

		if ($search == null) {
			redirect('view_and_ask_questions_controller');
		} else {

			$search_words = explode(' ', $search);
			$filtered_questions = [];
			foreach ($search_words as $word) {

				$filtered = array_filter($this->questions, function ($question) use ($word) {
					return strpos(strtolower($question['title']), strtolower($word)) !== false;
				});
				$filtered_questions = array_merge($filtered_questions, $filtered);
			}
			$filtered_questions = array_unique($filtered_questions, SORT_REGULAR);

			$this->data['questions'] = $filtered_questions;
			$this->load->view('view_and_ask_questions', $this->data);
		}
	}

	public function previousUrlSet()
	{
		$this->session->set_userdata('previous_url', current_url());
	}

}
