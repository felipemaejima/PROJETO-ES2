<?php
defined('BASEPATH') or exit('No direct script access allowed');

class data_persistence extends CI_Model
{
  public function log($data)
  {
    $insert = array(
      'id' => uuidv4(),
      'defined' => $data['defined'],
      'user' => $data['user_id'],
      'role' => $data['user_role'],
      'action' => $data['action'],
      'status' => $data['status'] ?? 'success',
      'ip' => $this->input->ip_address(),
      'platform' => $this->agent->platform(),
      'agent' => $this->agent->browser() . ' ' . $this->agent->version(),
      'referer' => $this->agent->referrer(),
      'device' => $this->agent->is_browser() ? 'browser' : ($this->agent->is_robot() ? 'robot' : ($this->agent->is_mobile() ? 'mobile' : 'other')),
      'resolution' => $this->input->post('resolution') ?? NULL,
      'data' => json_encode($data['data']),
      'created' => time(),
    );

    $this->db->insert('logs_' . $data['table'], $insert);

  }
}
