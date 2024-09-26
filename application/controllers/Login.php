<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();

    // Libraries
    $this->load->library('encryption');
    $this->load->library('user_agent');

    if (check_session('session_token')) {
      redirect(base_url('dashboard'), 'refresh');
    }

  }

  public function index()
  {
    if ($this->input->server('REQUEST_METHOD') == 'POST') {

      $this->form_validation->set_rules('email', 'e-mail', 'required|valid_email');
      $this->form_validation->set_rules('password', 'senha', 'required');

      $this->form_validation->set_error_delimiters('', '');

      if (!$this->form_validation->run()) {
        header('Content-Type: application/json');
        echo json_encode(
          array(
            'error' => TRUE,
            'error-email' => form_error('email'),
            'error-password' => form_error('password'),
            'CSRFerp' => $this->security->get_csrf_hash()
          )
        );
        return;
      } else {
        $email = strtolower(trim($this->input->post('email')));

        $email_explode = explode('@', $email);

        $user = $this->db->select('id, name, email, password, login_attempts, roles, confirmed, giveaccess, isinactive')
          ->where('emailprefix', $email_explode[0])
          ->where('confirmed', 'T')
          ->get('users')
          ->result();

        if (!$user) {
          return http_response(
            array(
              'error-message' => 'Credenciais inválidas',
            ),
            TRUE
          );
        }
        $sufixs = $this->db->select('emailsuffix')
          ->where('confirmed', 'T')
          ->where('emailsuffix', '@' . $email_explode[1])
          ->get('subsidiaries')
          ->result();

        if (!$sufixs) {
          return http_response(
            array(
              'error-message' => 'Credenciais inválidas',
            ),
            TRUE
          );
        }

        if (@$user[0]->isinactive == 'T') {
          $this->data_persistence->log(
            [
              'table' => 'user',
              'action' => 'login',
              'status' => 'error',
              'user_id' => $user[0]->id,
              'user_role' => $user[0]->roles,
              'defined' => $user[0]->id,
              'data' => ['message' => 'A conta está inativa.']
            ],
          );

          return http_response(
            array(
              'error-message' => 'Conta inativa',
            ),
            TRUE
          );
        }

        if (@$user[0]->giveaccess == 'F') {
          $this->data_persistence->log(
            [
              'table' => 'user',
              'action' => 'login',
              'status' => 'error',
              'user_id' => $user[0]->id,
              'user_role' => $user[0]->roles,
              'defined' => $user[0]->id,
              'data' => ['message' => 'Sem acesso.']
            ],
          );
          return http_response(array('error-message' => 'Sem acesso'), TRUE);
        }

        $login_locks = $this->db->select('id, user_id, lock_expires')
          ->order_by('lock_expires', 'DESC')
          ->where('user_id', $user[0]->id)
          ->get('login_locks')
          ->result();

        if ($login_locks && @$login_locks[0]->lock_expires > time()) {
          $lock_expires = new DateTime(date('Y-m-d H:i:s', $login_locks[0]->lock_expires));
          $today = new DateTime(date('Y-m-d H:i:s', time()));
          $diff = $lock_expires->diff($today);

          $this->data_persistence->log(
            [
              'table' => 'user',
              'action' => 'login',
              'user_id' => $user[0]->id,
              'user_role' => $user[0]->roles,
              'defined' => $user[0]->id,
              'data' => ['message' => 'Login bloqueado.']
            ],
          );

          return http_response(
            array(
              'error-message' => 'Login bloqueado, por favor tente novamente.' . (ceil($diff->format('%i') / 1) + 1) . ' minute(s)',
            ),
            TRUE
          );
        }

        if ($this->check_login($user, $login_locks)) {

          $this->db->delete('user_sessions', array('user_id' => $user[0]->id));

          $session_token = bin2hex(random_bytes(32));

          $data = array(
            'id' => uuidv4(),
            'user_id' => $user[0]->id,
            'session_token' => $session_token,
            'created' => time(),
            'updated' => time()
          );
          $this->db->insert('user_sessions', $data);

          $this->session->set_userdata('session_token', $session_token);

          $this->data_persistence->log(
            [
              'table' => 'user',
              'action' => 'login',
              'user_id' => $user[0]->id,
              'user_role' => $user[0]->roles,
              'defined' => $user[0]->id,
              'data' => ['message' => 'Autenticado com sucesso.']
            ],
          );

          $url = base_url('dashboard');

          if (strpos($this->input->post('ref'), base_url()) !== false) {
            $url = $this->input->post('ref');
          }

          return http_response(
            array(
              'url' => $url,
            )
          );
        } else {
          return http_response(
            array(
              'error-message' => 'Credenciais inválidas',
            ),
            TRUE
          );
        }
      }
    } else {

      $data['title'] = 'Login | ' . $this->config->item('name');
      $data['class'] = 'login';
      $data['js'] = array('login.js?v=1.1.2');

      $this->my_header('headers/header', $data);
      $this->load->view('login');
      $this->load->view('footers/footer');
    }
  }

  public function check_login($user, $login_locks)
  {
    if ($user && @password_verify(md5(trim($this->input->post('password'))), $user[0]->password)) {
      if ($user[0]->confirmed) {
        if ($user[0]->login_attempts > 3 && @$login_locks[0]->lock_expires > time()) {
          return false;
        }
        $this->db->delete('login_locks', array('user_id' => $user[0]->id));
        $this->db->where('id', $user[0]->id)
          ->update('users', array('login_attempts' => 0));
        return true;
      } else {
        return false;
      }
    } else {
      $this->db->where('id', $user[0]->id)
        ->set('login_attempts', 'login_attempts+1', FALSE)
        ->update('users');

      if ($user[0]->login_attempts + 1 > 3) {
        $this->db->delete('login_locks', array('user_id' => $user[0]->id));
        $data = array(
          'id' => uuidv4(),
          'user_id' => $user[0]->id,
          'lock_expires' => time() + 60 * 3
        );
        $this->db->insert('login_locks', $data);
      }
      return false;
    }
  }


}
