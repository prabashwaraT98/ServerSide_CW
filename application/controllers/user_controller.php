<?php
defined('BASEPATH') or exit('No direct script access allowed');

class user_controller extends CI_Controller
{
	protected $data = [];
	protected $user;

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->helper('date');
		$this->load->model('userModel');
		date_default_timezone_set('Asia/Colombo');
		$user_id = $this->session->userdata('user_id');
		$this->user = $this->userModel->obtainUser($user_id);
		if ($this->user !== null) {
			$this->data['user_id'] = $user_id;
			$this->data['username'] = $this->user['username'];
			$this->data['email'] = $this->user['email'];
		}
	}

	public function register()
	{

		$this->data['title'] = 'Register';
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$email = $this->input->post('email');

			
			$registered = $this->userModel->register($username, $password, $email);
			if ($registered) {
				
				redirect('user_controller/login');
				log_message('debug', 'User Register Successful');
			} else {
				
				$this->load->view('register');
				log_message('debug', 'User Register Failed');
			}
		} else {
			
			$this->load->view('register', $this->data);
		}
	}

	public function login()
	{

		$this->data['title'] = 'Login';

		
		$username = $this->input->post('username');
		$password = $this->input->post('password');

		
		$user = $this->userModel->login($username, $password);

		if ($user) {

			
			$this->session->set_userdata('user_id', $user->id);
			$this->session->set_userdata('username', $user->username);
			log_message('debug', 'User Successfully Logged in');
			
			redirect('home_page_controller');
		} else {
			
			$this->load->view('login', $this->data);
			log_message('debug', 'User Login Failed');
		}
	}

	public function userLogout()
	{

		if (!$this->session->userdata('user_id')) {
			
			redirect('home_page_controller');
		}
		
		$this->session->sess_destroy();
		log_message('debug', 'User Successfully Logged Out');

		
		redirect('home_page_controller');
	}

	public function userProfile()
	{
		$this->data['title'] = 'Profile';

		if (!$this->session->userdata('user_id')) {
			
			redirect('home_page_controller');
		}
		$this->load->model('questionModel');
		$this->load->model('answerModel');

		$questions = $this->questionModel->getQuestionsByUser($this->user['id']);
		$this->data['questions'] = $questions;
		$this->data['answers'] = $this->answerModel->getAnswersByUser($this->user['id']);
		$answers = $this->answerModel->getAnswersByUser($this->user['id']);
		$correct_answers = $this->answerModel->getCorrrectAnswersByUser($this->user['id']);

		$this->data['num_questions'] = count($questions);
		$this->data['num_answers'] = count($answers);
		$this->data['num_correct_answers'] = count($correct_answers);

		
		$this->load->view('profile', $this->data);
		log_message('debug', 'Profile Loaded');
	}

}
