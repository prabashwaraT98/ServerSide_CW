<?php
defined('BASEPATH') or exit('No direct script access allowed');

class home_page_controller extends CI_Controller
{

	protected $data = [];

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
		$this->data['user_id'] = $this->session->userdata('user_id');
		$this->data['username'] = $this->session->userdata('username');
		$this->data['title'] = 'HomePage';
	
	}

    public function index()
    {
        $this->load->view('homepage', $this->data);
		log_message('debug', 'HomePage Loaded');
    }
}
