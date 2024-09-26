<?php

class MY_Controller extends CI_Controller
{

	protected $user_id;
	protected $user;

	public function __construct()
	{
		parent::__construct();

		// Libraries
		$this->load->library('encryption');
		$this->load->library('user_agent');

		$this->load->model('data_persistence');
		$this->load->model('license_control');

		if (check_session('session_token')) {
			$this->user_id = get_session_data(check_session('session_token'));

			$this->user = $this->db->select('id as id, roles, name as name, CONCAT(UPPER(LEFT(SUBSTRING_INDEX(name, " ", 1), 1)), "", UPPER(LEFT(SUBSTRING_INDEX(name, " ", -1), 1))) as short_name, CONCAT(SUBSTRING_INDEX(name, " ", 1), " ", SUBSTRING_INDEX(name, " ", -1)) as first_last_name, email as email, defaulttheme')
				->where('id', $this->user_id)
				->get('users')
				->result();
		}
	}

	public function my_header($header, $data)
	{

		$data['uri'] = uri_string();
		$data['mobile'] = $this->agent->is_mobile();

		$data['user'] = check_session('session_token') ? $this->user[0] : FALSE;

		$this->load->view($header, $data);
	}

	public function send_mail($to, $subject, $message, $cc = NULL, $attach = NULL)
	{
		$config = array(
			'useragent' => 'PHPMailer',
			'protocol' => 'smtp',
			'smtp_host' => 'smtp.hostinger.com',
			'smtp_port' => 465,
			'smtp_crypto' => 'ssl',
			'smtp_user' => 'system@mogi.glass',
			'smtp_pass' => SMTP_PASS,
			'mailtype' => 'html',
			'charset' => 'utf-8',
			'validate' => TRUE,
			'newline' => '\r\n'
		);

		$this->load->library('email', $config);
		$this->email->from($config['smtp_user'], 'ENIAC Mogiglass');
		$this->email->to($to);
		$this->email->bcc($config['smtp_user']);

		if ($cc) {
			$this->email->cc($cc);
		}

		if ($attach) {
			$this->email->attach($attach, 'attachment');
		}

		$this->email->subject($subject . ' - ' . 'ENIAC');
		$this->email->message($message);
		$this->email->set_mailtype('html');

		if ($this->email->send()) {
			$this->email->clear();
			return TRUE;
		} else {
			var_dump($this->email->print_debugger());
			return FALSE;
		}
	}

	public function pagination($pagination, $page)
	{
		$siblings_count = 3;
		$previous_pages = $this->generate_pages_array($page - 1 - $siblings_count, $page - 1);
		$next_pages = $this->generate_pages_array($page, min($page + $siblings_count, $pagination));

		return array_unique(array_merge(array(1), $previous_pages, array($page), $next_pages, array($pagination)));
	}

	private function generate_pages_array($from, $to)
	{
		$pagination = array();
		for ($i = intval($from) + 1; $i <= intval($to); $i++) {
			if ($i > 0) {
				array_push($pagination, $i);
			}
		}
		return $pagination;
	}

	public function search_pagination_data(&$data, $query, $index, $table, $entitiename = '')
	{
		$entitiename = $entitiename ? $entitiename : $table;
		$data['page'] = !!$this->uri->segment(2) ? $this->uri->segment(2) : 1;

		$offset = 25;
		$limit = $data['page'] == 1 ? 0 : (($data['page'] - 1) * $offset);

		if ($index == 0) {
			$data[$entitiename] = $query->get($table, $offset, $limit)->result();
		} else {
			$data['total'] = $query->get($table)->num_rows();
			$data['pages'] = ceil($data['total'] / $offset);
		}
		$query = null;
	}

	protected function check_roles(array $allowedrolesids)
	{ 
			return !empty(array_intersect((array) json_decode($this->user[0]->roles), $allowedrolesids));
	}

}
