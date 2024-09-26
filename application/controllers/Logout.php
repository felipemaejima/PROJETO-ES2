<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends MY_Controller {

	public function __construct()
	{
		parent::__construct();

		// Libraries
		$this->load->library('encryption');
		$this->load->library('user_agent');

		if (!check_session('session_token')) {
			redirect(base_url('login'), 'refresh');
		}

	}

	public function index()
	{

    $this->data_persistence->log(
      ['table' => 'user', 'action' => 'logout', 
      'user_id' => $this->user[0]->id, 'user_role' => $this->user[0]->roles,
      'defined' => $this->user[0]->id,
      'data' => ['message' => 'Usuário desconectado com sucesso.']],
    );

		$this->session->unset_userdata('session_token');

		$this->session->set_flashdata('success', 'Desconectado com sucesso.');
		redirect(base_url('login'), 'refresh');
	}
}
