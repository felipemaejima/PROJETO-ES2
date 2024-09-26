<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Roles extends MY_Controller
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
    check_user_is_allowed($this->user[0]->roles, 'Roles', ['visualizar', 'criar', 'editar', 'total']);

    $data['title'] = 'Roles | ' . $this->config->item('name');
    $data['class'] = 'roles';
    $data['js'] = array('header.js', 'roles.js');

    $page = !!$this->uri->segment(2) ? $this->uri->segment(2) : 1;

    $offset = 25;
    $limit = $page == 1 ? 0 : (($page - 1) * $offset);

    $data['total'] = $this->db->select('id')
      ->get('roles')
      ->num_rows();

    $data['roles'] = $this->db->select('id, name, role, isinactive, confirmed, created')
      ->order_by('created', 'DESC')
      ->get('roles', $offset, $limit)
      ->result();

    $data['pagination'] = $this->pagination(ceil($data['total'] / $offset), $page);
    $data['initial'] = $page;
    $data['final'] = ceil($data['total'] / $offset);

    $this->my_header('headers/header', $data);
    $this->load->view('roles');
    $this->load->view('footers/footer');
  }

  public function create()
  {
    check_user_is_allowed($this->user[0]->roles, 'Roles', ['criar', 'total']);

    if ($this->input->server('REQUEST_METHOD') == 'POST') {

      $this->form_validation->set_rules('name', 'nome', 'callback_check_name|is_unique[roles.name]');
      $this->form_validation->set_rules('isinactive', 'inativo', '');
      $this->form_validation->set_rules('permissionid[]', 'id permissão', '');
      $this->form_validation->set_rules('permissionname[]', 'nome permissão', '');
      $this->form_validation->set_rules('level[]', 'level permissão', '');

      $this->form_validation->set_error_delimiters('', '');

      if (!$this->form_validation->run()) {

        header('Content-Type: application/json');
        echo json_encode(
          array(
            'error' => TRUE,
            'error-name' => form_error('name'),
            'error-isinactive' => form_error('isinactive'),
            'error-permissionid' => form_error('permissionid[]'),
            'error-permissionname' => form_error('permissionname[]'),
            'error-level' => form_error('level[]'),
            'error-fields-title' => 'Restam campos obrigatórios!',
            'error-fields' => validation_errors('', '<br/>'),
            'CSRFerp' => $this->security->get_csrf_hash()
          )
        );
        return;

      } else {

        $permissions = array();

        if ($this->input->post('permissionid[]')) {
          for ($i = 0; $i < count($this->input->post('permissionid[]')); $i++) {
            $value = array(
              'id' => $this->input->post('permissionid[]')[$i],
              'name' => $this->input->post('permissionname[]')[$i],
              'level' => $this->input->post('level[]')[$i]
            );
            array_push($permissions, $value);
          }
        }

        $id = uuidv4();

        $role = array(
          'id' => $id,
          'name' => trim($this->input->post('name')),
          'role' => trim(strtolower($this->input->post('name'))),
          'isinactive' => $this->input->post('isinactive') ? 'T' : 'F',
          'confirmed' => 'T',
          'permissions' => $permissions ? json_encode($permissions) : NULL,
          'created' => time(),
          'ip' => $this->input->ip_address(),
          'platform' => $this->agent->platform(),
          'agent' => $this->agent->browser() . ' ' . $this->agent->version(),
          'referer' => $this->agent->referrer()
        );

        $this->db->insert('roles', $role);

        $this->data_persistence->log(
          [
            'table' => 'role',
            'action' => 'created role',
            'user_id' => $this->user[0]->id,
            'user_role' => $this->user[0]->roles,
            'defined' => $id,
            'data' => ['message' => 'Função criada com sucesso.']
          ],
        );

        $this->session->set_flashdata('success', 'Parabéns! Função criada com sucesso!');

        return http_response(array(
          'message' => 'Parabéns! Função criada com sucesso!',
        ));
      }
    } else {

      $data['functions'] = $this->db->select('id, title')
        ->where('isinactive', 'F')
        ->get('functions')
        ->result();

      $data['title'] = 'Create Role | ' . $this->config->item('name');
      $data['class'] = 'roles';
      $data['js'] = array('header.js', 'role-create.js');

      $this->my_header('headers/header', $data);
      $this->load->view('role-create');
      $this->load->view('footers/footer');

    }
  }

  public function edit()
  {
    check_user_is_allowed($this->user[0]->roles, 'Roles', ['editar', 'total']);
    
    if ($this->input->server('REQUEST_METHOD') == 'POST') {

      $this->form_validation->set_rules('name', 'nome', 'callback_check_name');
      $this->form_validation->set_rules('isinactive', 'inativo', '');
      $this->form_validation->set_rules('permissionid[]', 'id permissão', '');
      $this->form_validation->set_rules('permissionname[]', 'nome permissão', '');
      $this->form_validation->set_rules('level[]', 'level permissão', '');

      $this->form_validation->set_error_delimiters('', '');

      if (!$this->form_validation->run()) {

        header('Content-Type: application/json');
        echo json_encode(
          array(
            'error' => TRUE,
            'error-name' => form_error('name'),
            'error-isinactive' => form_error('isinactive'),
            'error-permissionid' => form_error('permissionid[]'),
            'error-permissionname' => form_error('permissionname[]'),
            'error-level' => form_error('level[]'),
            'error-fields-title' => 'Restam campos obrigatórios!',
            'error-fields' => validation_errors('', '<br/>'),
            'CSRFerp' => $this->security->get_csrf_hash()
          )
        );
        return;

      } else {

        $previus_data = $this->db->select('name, role, permissions, isinactive')
          ->where('id', $this->uri->segment(2))
          ->get('roles')
          ->result();

        $permissions = array();

        if ($this->input->post('permissionid[]')) {
          for ($i = 0; $i < count($this->input->post('permissionid[]')); $i++) {
            $value = array(
              'id' => $this->input->post('permissionid[]')[$i],
              'name' => $this->input->post('permissionname[]')[$i],
              'level' => $this->input->post('level[]')[$i]
            );
            array_push($permissions, $value);
          }
        }

        $role = array(
          'name' => trim($this->input->post('name')),
          'role' => trim(strtolower($this->input->post('name'))),
          'isinactive' => $this->input->post('isinactive') ? 'T' : 'F',
          'permissions' => $permissions ? json_encode($permissions) : NULL,
          'updated' => time(),
          'ip' => $this->input->ip_address(),
          'platform' => $this->agent->platform(),
          'agent' => $this->agent->browser() . ' ' . $this->agent->version(),
          'referer' => $this->agent->referrer()
        );

        $this->db->where(array('id' => $this->uri->segment(2)))
          ->update('roles', $role);

        $this->data_persistence->log(
          [
            'table' => 'role',
            'action' => 'edited role',
            'user_id' => $this->user[0]->id,
            'user_role' => $this->user[0]->roles,
            'defined' => $this->uri->segment(2),
            'data' => [
              'message' => 'Função editada com sucesso.',
              'process' => edited_data($role, $previus_data[0])
            ]
          ],
        );

        $this->session->set_flashdata('success', 'Parabéns! Função editada com sucesso.');

        return http_response(array(
          'message' => 'Parabéns! Função editada com sucesso.'
        ));

      }

    } else {

      $data['role'] = $this->db->select('id, name, role, permissions, isinactive, confirmed')
        ->where('id', $this->uri->segment(2))
        ->get('roles')
        ->result();

      $data['users'] = $this->db->select('id, name, roles, isinactive, giveaccess, confirmed')
        ->like('roles', $this->uri->segment(2), 'both')
        ->get('users')
        ->result();

      $data['functions'] = $this->db->select('id, title')
        ->where('isinactive', 'F')
        ->get('functions')
        ->result();

      $data['logs'] = $this->db->select('logs_role.id, logs_role.user, logs_role.defined, users.name, logs_role.action, logs_role.status, logs_role.data, logs_role.ip, logs_role.platform, logs_role.agent, logs_role.created')
        ->where('logs_role.defined', $this->uri->segment(2))
        ->join('users', 'users.id = logs_role.user', 'LEFT')
        ->order_by('logs_role.created', 'DESC')
        ->limit(25)
        ->get('logs_role')
        ->result();

      $data['title'] = 'Edit Role ' . $data['role'][0]->name . ' | ' . $this->config->item('name');
      $data['class'] = 'roles';
      $data['js'] = array('header.js', 'role-edit.js');

      $this->my_header('headers/header', $data);
      if ($this->input->get('edit') == 'T') {
        if (!check_access(json_decode($this->user[0]->roles), 'Roles', array('editar', 'total'))) {

          $this->session->set_flashdata('error', 'Você não tem permissão para acessar este recurso!');
          redirect(base_url('roles'), 'refresh');

        }
        $this->load->view('role-edit');
      } else {
        if (!check_access(json_decode($this->user[0]->roles), 'Roles', array('visualizar', 'editar', 'total'))) {

          $this->session->set_flashdata('error', 'Você não tem permissão para acessar este recurso!');
          redirect(base_url('roles'), 'refresh');

        }
        $this->load->view('role-see');
      }
      $this->load->view('footers/footer');

    }
  }

  public function check_name($str)
  {
    if (check_string($str)) {
      return true;
    }
    if (!trim($str)) {
      $this->form_validation->set_message('check_name', 'O campo {field} é obrigatório.');
      return FALSE;
    }
    $this->form_validation->set_message('check_name', 'Somente letras são permitidas.');
    return FALSE;
  }
}
