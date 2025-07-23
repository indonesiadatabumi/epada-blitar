<?php

defined('BASEPATH') or exit('No derict script access allowed');


class login extends CI_Controller
{

	public $active_controller;

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library(array('DAO', 'admin_access_handler'));
		$this->load->model(array('global_model'));

		$this->dao = $this->global_model->get_dao();

		$this->admin_access_handler->initialize_dao($this->dao);

		$this->active_controller = __CLASS__;
	}

	function index()
	{
		$data = array();

		$this->load->view('login', $data);
	}

	function login_auth()
	{
		$this->load->helper('mix_helper');

		$username = $this->security->xss_clean($this->input->post('username'));
		$password = $this->security->xss_clean($this->input->post('password'));
		$password = md5($password);
		$ip = get_ip();

		$result['status'] = $this->admin_access_handler->login_process($username, $password, $ip);
		$data['result'] = $result;

		$this->load->view('login_result', $data);
	}

	function logout()
	{
		$this->admin_access_handler->logout_process();
	}

	function updatepassword()
	{
		$user_id = $this->session->userdata("user_id");
		$query = $this->db->query('SELECT * FROM users Where user_id = ' . $user_id . '');
		$user = $query->row();
		$current_password = $_POST['current_password'];
		$new_password = $_POST['new_password1'];
		if (md5($current_password) != $user->password) {
			echo "Password lama salah";
		} else {
			if ($current_password == $new_password) {
				echo "password baru tidak boleh sama ";
			} else {
				// sukses
				$password_md5 = md5($new_password);
				$query = $this->db->query("UPDATE users SET password='" . $password_md5 . "'  WHERE user_id=" . $user_id . "");
				echo "suksess";
			}
		}
	}
}
