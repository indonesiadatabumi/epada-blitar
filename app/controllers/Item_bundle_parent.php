<?php
defined('BASEPATH') or exit('No direct script access allowed');

class item_bundle_parent
{
	protected $_ci, $active_controller;

	function __construct($bundle_type, $bundle_item_type, $menu, $bundle_item_class)
	{

		$this->_ci = &get_instance();

		$this->_ci->load->library(array('session', 'DAO', 'database_interactions', 'public_template', 'admin_access_handler'));
		$this->_ci->load->model(array('global_model'));
		$this->_ci->load->helper(array('url', 'date_helper', 'mix_helper', 'app_common_function_helper'));

		$this->_ci->global_model->reinitialize_dao();
		$this->dao = $this->_ci->global_model->get_dao();

		$this->_ci->public_template->initialize_dao($this->dao);
		$this->_ci->database_interactions->initialize_dao($this->dao);
		$this->_ci->admin_access_handler->initialize_dao($this->dao);

		$sql = "SELECT a.*,b.jenis_pemungutan as nama_jenis_pemungutan,b.jenis_spt_id FROM bundel_pajak_retribusi as a LEFT JOIN ref_jenis_pemungutan as b ON (a.jenis_pemungutan=b.ref_jenput_id) 
					WHERE a.text_id='" . $bundle_item_type . "'";

		$this->bundle_row = $this->dao->execute(0, $sql)->row_array();
		$this->bundle_type = $bundle_type;
		$this->bundle_item_type = $bundle_item_type;
		$this->menu = $menu;
		$this->bundle_id = $this->bundle_row['bundel_id'];
		$this->bundle_code = $this->bundle_row['kode_pajak'];

		$this->menu_params = array(
			'bundle_type' => $bundle_type,
			'bundle_item_type' => $bundle_item_type,
			'bundle_id' => $this->bundle_row['bundel_id'],
		);

		$this->main_params = array(
			'bundle_type' => $bundle_type,
			'bundle_item_type' => $bundle_item_type,
			'menu' => $menu,
			'bundle_id' => $this->bundle_row['bundel_id'],
		);


		$this->view_folder = $bundle_type . '/' . $menu;
	}

	function generate_list_data($sql)
	{
		$rows = $this->dao->execute(0, $sql)->result_array();
		return $rows;
	}

	function get_list_data($table, $selected_field, array $join = array(), array $on_join = array(), array $cond_params = array(), $order = '', $order_method = '')
	{
		$sql = $this->generate_sql($table, $selected_field, $join, $on_join, $cond_params, $order, $order_method);
		return $this->generate_list_data($sql);
	}

	function get_list_data_with_customsql($sql)
	{
		return $this->generate_list_data($sql);
	}

	function collect_input_params($post, $prefix, $remove_prefix = true, $sql_real_escape_string = false)
	{
		$input_params = array();
		$prefix_key = ($remove_prefix ? "" : $prefix . "-");
		foreach ($post as $key => $val) {
			$x = explode('-', $key);
			if ($x[0] == $prefix and $val != '') {
				$type = (count($x) > 2 ? $x[2] : 'str');
				if ($type == 'str') {
					$_val = $this->_ci->security->xss_clean($val);
					if ($sql_real_escape_string)
						$_val = sql_real_escape_string($_val);
				} else if ($type == 'int') {
					$_val = str_replace(',', '', $this->_ci->security->xss_clean($val));
				} else if ($type == 'date') {
					$_val = us_date_format($val);
				}
				$input_params[$prefix_key . $x[1]] = $_val;
			}
		}
		return $input_params;
	}

	function generate_urlstring_params($arr_params)
	{

		$_urlstring_params = "";
		$urlstring_params = "";
		$s = false;
		foreach ($arr_params as $key => $val) {
			$urlstring_params .= ($s ? "&" : "") . $key . "=" . $val;
			$s = true;
		}

		$_urlstring_params .= (!empty($urlstring_params) ? "?" : "") . $urlstring_params;
		return $_urlstring_params;
	}

	private function generate_sql($table, $selected_field, array $join = array(), array $on_join = array(), array $cond_params = array(), $order = '', $order_method = '')
	{

		$sql = "SELECT " . ($selected_field == '*' ? $selected_field : '');
		if (is_array($selected_field)) {
			for ($i = 0, $s = false; $i < count($selected_field); $i++) {
				$sql .= ($s ? ',' : '') . $selected_field[$i];
				$s = true;
			}
		}

		$alias1 = "a";
		$sql .= "FROM " . $table . " " . (count($join) > 0 ? " as a" : "");

		if (count($join) > 0) {

			$alias = $alias1;
			foreach ($join as $key => $val) {
				$alias++;
				$sql .= " LEFT JOIN " . $val . " as " . $alias;

				foreach ($on_join as $key2 => $val2) {
					$s = false;
					foreach ($val2 as $key3 => $val3) {
						$sql .= ($s ? " AND " : "") . $alias1 . "." . $key3 . "=" . $alias . "." . $val3;
						$s = true;
					}
				}
			}
		}

		$sql .= $this->generate_sql_condition($cond_params);

		if ($order != '') {
			$sql .= " ORDER BY " . $order . " " . $order_method;
		}

		return $sql;
	}

	function generate_sql_condition($cond_params)
	{
		$cond = "";

		if (count($cond_params)) {
			$cond = " WHERE ";
			$s = false;
			foreach ($cond_params as $key => $val) {
				$x = explode('-', $key);

				if ($x[0] == 'date_range') {
					$cond .= ($x ? " AND " : "") . " (" . $x[1] . " BETWEEN '" . (isset($val['start']) ? $val['start'] : date('Y-m-d')) . "' AND '" . (isset($val['end']) ? $val['end'] : date('Y-m-d')) . "')";
				} else {
					$cond .= ($s ? " AND " : "") . $key . "='" . $val . "'";
				}
				$s = true;
			}
		}

		return $cond;
	}

	function delegate_postTomodel($input_params, &$model)
	{

		foreach ($input_params as $key => $val) {
			$model->{'set_' . $key}($val);
		}
		return $model;
	}

	function collect_cond_params($post, $prefix)
	{
		$cond_params = array();
		foreach ($post as $key => $val) {
			$x = explode('-', $key);

			if ($x[0] == 'src' and $val != '') {
				$field = str_replace('#', '.', $x[1]);
				$cond_params[$field] = $val;
			}

			if ($x[0] == 'src_date_range' and $val != '') {
				$field = str_replace('#', '.', $x[1]);
				$cond_params['date_range-' . $field][$x[2]] = us_date_format($val);
			}
		}
		return $cond_params;
	}

	function load_list()
	{

		$this->_ci->admin_access_handler->check_access();

		$menu = $_POST['menu'];
		$tgl_cetak = isset($_POST['tgl_cetak']) ? $_POST['tgl_cetak'] : '';
		$nama_bendahara = isset($_POST['nama_bendahara']) ? $_POST['nama_bendahara'] : '';
		$nip = isset($_POST['nip']) ? $_POST['nip'] : '';
		$no_sspd = isset($_POST['no_sspd']) ? $_POST['no_sspd'] : '';
		$no_sts = isset($_POST['no_sts']) ? $_POST['no_sts'] : '';

		$read_priv = $this->_ci->public_template->get_access_privileges('read', $menu, $this->bundle_id);

		$cond_params1 = $this->collect_cond_params($_POST, 'src');

		$cond_params2 = $this->collect_cond_params($_POST, 'src_date_range');

		$src_params = array();
		$src_daterange_params = array();
		foreach ($_POST as $key => $val) {
			$x = explode('-', $key);
			if ($x[0] == 'src' and $val != '') {
				$field = $x[1];
				$src_params[$field] = $val;
			}

			if ($x[0] == 'src_date_range' and $val != '') {
				$field = $x[1];
				$src_daterange_params[$field . '-' . $x[2]] = $val;
			}
		}

		$cond_params = array_merge($cond_params1, $cond_params2);

		if ($read_priv == '1') {
			$this->print_list_data($menu, $tgl_cetak, $nama_bendahara, $nip, $no_sspd, $no_sts, $cond_params, array_merge($src_params, $src_daterange_params));
		} else {
			$this->_ci->load->view('errors/html/error_403', array('type' => 'read'));
		}
	}

	function print_list_data($menu, $tgl_cetak, $nama_bendahara, $nip, $no_sspd, $no_sts, $cond_params, $src_params = array())
	{

		$res = $menu . '_resources';

		require_once APPPATH . 'libraries' . DIRECTORY_SEPARATOR . 'system_resources' . DIRECTORY_SEPARATOR . $res . '.php';

		$sql = $res::$_SQL_LIST;

		if ($sql != '') {
			$cond = $this->generate_sql_condition($cond_params);
			$sql .= $cond;

			if (isset($res::$_ORDER_FIELD) && count($res::$_ORDER_FIELD) > 0) {
				$sql .= " ORDER BY ";
				$s = false;
				foreach ($res::$_ORDER_FIELD as $field) {
					$sql .= ($s ? "," : "") . $field;
					$s = true;
				}
				$sql .= " " . $res::$_ORDER_METHOD;
			}

			$rows = $this->get_list_data_with_customsql($sql);
		} else {
		}

		$menu = $_POST['menu'];
		$tgl_cetak = isset($_POST['tgl_cetak']) ? $_POST['tgl_cetak'] : '';
		$nama_bendahara = isset($_POST['nama_bendahara']) ? $_POST['nama_bendahara'] : '';
		$nip = isset($_POST['nip']) ? $_POST['nip'] : '';
		$no_sspd = isset($_POST['no_sspd']) ? $_POST['no_sspd'] : '';
		$update_priv = $this->_ci->public_template->get_access_privileges('update', $menu, $this->bundle_id);
		$delete_priv = $this->_ci->public_template->get_access_privileges('delete', $menu, $this->bundle_id);
		$print_priv = $this->_ci->public_template->get_access_privileges('print', $menu, $this->bundle_id);

		$data = array_merge($this->main_params, array(
			'rows' => $rows, 'src_params' => (count($src_params) > 0 ? $src_params : $cond_params),
			'update_priv' => $update_priv, 'delete_priv' => $delete_priv,
			'print_priv' => $print_priv, 'menu' => $menu, 'tgl_cetak' => $tgl_cetak,
			'nama_bendahara' => $nama_bendahara, 'nip' => $nip, 'no_sspd' => $no_sspd
		));

		$view_folder = $this->bundle_type . '/' . $menu;

		$this->_ci->load->view($view_folder . '/list_data', $data);
	}
}
