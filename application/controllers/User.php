<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();

    // Libraries
    $this->load->library('encryption');
    $this->load->library('user_agent');

    if (!check_session('session_token')) {
      redirect(base_url('login') . '?ref=' . current_url(), 'refresh');
    }

  }

  public function index()
  {

    // adicionar verificação de permissão ?
    if ($this->input->server('REQUEST_METHOD') == 'POST') {

      $this->form_validation->set_rules('name', 'nome', 'required|callback_check_name');
      $this->form_validation->set_rules('dateofbirth', 'data de nascimento', 'required|callback_date_check_format');
      $this->form_validation->set_rules('mobilephone', 'celular', 'required');
      $this->form_validation->set_rules('email', 'email', 'required');
      $this->form_validation->set_rules('document', 'cpf', 'required|callback_cpf_check');
      $this->form_validation->set_rules('phone', 'telefone', '');
      $this->form_validation->set_rules('defaulttheme', 'tema padrão', '');

      $this->form_validation->set_error_delimiters('', '');

      if (!$this->form_validation->run()) {
        header('Content-Type: application/json');
        echo json_encode(
          array(
            'error' => TRUE,
            'error-name' => form_error('name'),
            'error-dateofbirth' => form_error('dateofbirth'),
            'error-mobilephone' => form_error('mobilephone'),
            'error-email' => form_error('email'),
            'error-document' => form_error('document'),
            'error-phone' => form_error('phone'),
            'error-defaulttheme' => form_error('defaulttheme'),
            'error-fields-title' => 'Restam campos obrigatórios!',
            'error-fields' => validation_errors('','<br/>'),
            'CSRFerp' => $this->security->get_csrf_hash()
          )
        );
        return;
      } else {

        $previus_data = $this->db->select('id, name, email, mobilephone, phone, document, dateofbirth, defaulttheme')
          ->where('id', $this->user[0]->id)
          ->get('users')
          ->result();

        $user = array(
          'name' => trim($this->input->post('name')),
          'email' => trim($this->input->post('email')),
          'mobilephone' => trim($this->input->post('mobilephone')),
          'phone' => trim($this->input->post('phone')),
          'document' => trim($this->input->post('document')),
          'dateofbirth' => stringtotimestamp(trim($this->input->post('dateofbirth'))),
          'defaulttheme' => !!$this->input->post('defaulttheme') ? 'dark' : 'light',
          'updated' => time(),
          'ip' => $this->input->ip_address(),
          'platform' => $this->agent->platform(),
          'agent' => $this->agent->browser() . ' ' . $this->agent->version(),
          'referer' => $this->agent->referrer()
        );

        $this->db->where('id', $this->user[0]->id)
          ->update('users', $user);

        $this->data_persistence->log(
          ['table' => 'user', 'action' => 'edit user',
          'user_id' => $this->user[0]->id, 'user_role' => $this->user[0]->roles,
          'defined' => $this->user[0]->id,
          'data' => ['message' => 'Usuário editado com sucesso',
          'process' => edited_data($user, $previus_data[0])]],
        );

        $this->session->set_flashdata('success', 'Parabéns! Seu perfil foi editado com sucesso!');

        return http_response(array(
          'message' => 'Parabéns! Seu perfil foi editado com sucesso!'
        ));
      }


    } else {

      $data['title'] = $this->user[0]->first_last_name . ' | ' . $this->config->item('name');
      $data['class'] = 'user';
      $data['js'] = array('header.js', 'jquery.mask.min.js',  'user.js');

      $data['userData'] = $this->db->select('id, name, email, mobilephone, phone, document, dateofbirth, defaultaddress,  defaulttheme')
          ->where('id', $this->user[0]->id)
          ->get('users')
          ->result()[0];

      $data['addresses'] = $this->db->select('id, address, street, number, complement, neighborhood, city, citycode, state, country, zip, standardshipping, standardbilling')
        ->where('link', $this->user[0]->id)
        ->where('isinactive', 'F')
        ->order_by('created', 'DESC')
        ->get('addresses')
        ->result();

      $data['logs'] = $this->db->select('logs_user.id, logs_user.user, logs_user.defined, users.name, logs_user.action, logs_user.status, logs_user.data, logs_user.ip, logs_user.platform, logs_user.agent, logs_user.created')
        ->where('logs_user.user', $this->user[0]->email)
        ->join('users', 'users.email = logs_user.user')
        ->order_by('logs_user.created', 'DESC')
        ->limit(25)
        ->get('logs_user')
        ->result();

      $this->my_header('headers/header', $data);
      $this->load->view('user');
      $this->load->view('footers/footer');
    }
  }

}


