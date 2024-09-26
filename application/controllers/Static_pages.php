<?php
defined('BASEPATH') or exit('No direct script access allowed');

class static_pages extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();

		// Libraries
		$this->load->library('encryption');
		$this->load->library('user_agent');

	}

	public function index()
	{
		if (check_session('session_token')) {
			redirect(base_url('dashboard'), 'refresh');
		} else {
			redirect(base_url('login'), 'refresh');
		}
	}

	public function not_found()
	{
		$data['title'] = 'Página não encontrada | ' . $this->config->item('name');
		$data['class'] = 'not-found';
		$data['js'] = array('header.js');

		$this->my_header('headers/header', $data);
		$this->load->view('not-found');
		$this->load->view('footers/footer');
	}
}
