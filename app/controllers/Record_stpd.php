<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'controllers' . DIRECTORY_SEPARATOR . 'Item_bundle_parent.php';

class record_stpd extends item_bundle_parent
{


	function __construct($bundle_type, $bundle_item_type, $menu)
	{

		//bundle_type => taxes,duties
		//bundle_item_type => hotel,restaurant,entertainment,etc
		//menu => record_taxpayer1,record_taxpayer2,etc			
		parent::__construct($bundle_type, $bundle_item_type, $menu, __CLASS__);
	}


	function index()
	{
		$this->_ci->admin_access_handler->check_access();

		$district_rows = $this->_ci->database_interactions->get_district_rows();

		$main_data = array(
			'bundle_row' => $this->bundle_row,
			'district_rows' => $district_rows,
		);

		// no need to modified
		$data = array(
			'menu_params' => $this->menu_params,
			'main_params' => array_merge($this->main_params, $main_data)
		);

		$this->_ci->public_template->render($this->view_folder . '/index', $data);
	}

	function load_taxpayer_list()
	{

		// $search_key = $_POST['src_form-key'];
		$menu = $_POST['menu'];
		$act = $_POST['act'];
		$showed = $_POST['showed'];

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


		// $sql = "SELECT * FROM v_spt2 WHERE pajak_id='" . $this->bundle_id . "' AND status_bayar='0' AND (npwpd LIKE '%" . $search_key . "%' OR nama_wp LIKE '%" . $search_key . "%')";
		$sql = "SELECT a.*, b.stpd_id
				FROM v_spt2 a
				LEFT JOIN stpd b ON a.kode_billing=b.stpd_kode_billing
				WHERE a.status_bayar = '0' AND pajak_id = '" . $this->bundle_id . "' AND b.stpd_id IS NULL ORDER BY spt_id DESC";

		$rows = $this->dao->execute(0, $sql)->result_array();

		$data = array('rows' => $rows, 'act' => $act, 'menu' => $menu, 'showed' => $showed, 'src_params' => $src_params, 'src_daterange_params' => $src_daterange_params);

		$view_folder = $this->bundle_type . '/' . $menu;

		$this->_ci->load->view($view_folder . '/taxpayer_list', $data);
	}


	function taxpayer_search_panel()
	{
		$this->_ci->admin_access_handler->check_access();

		$act = $_POST['act'];
		$menu = $_POST['menu'];
		$showed = $_POST['showed'];

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

		$view_folder = $this->bundle_type . '/' . $menu;

		$data = array(
			'act' => $act,
			'menu' => $menu,
			'showed' => $showed,
			'src_params' => $src_params,
			'src_daterange_params' => $src_daterange_params,
			'bundle_name' => $this->bundle_row['nama_paret'],
			'bundle_item_type' => $this->bundle_item_type,
			'bundle_id' => $this->bundle_id,
		);

		$this->_ci->load->view($view_folder . '/taxpayer_search_panel', $data);
	}

	function form()
	{

		$this->_ci->admin_access_handler->check_access();

		$act = $_POST['act'];
		$menu = $_POST['menu'];
		$showed = $_POST['showed'];
		$spt_id = $_POST['spt_id'];

		$res = $menu . '_resources';
		require_once APPPATH . 'libraries' . DIRECTORY_SEPARATOR . 'system_resources' . DIRECTORY_SEPARATOR . $res . '.php';

		$tbl_name = $res::$_TBL_NAME;
		$pk = $res::$_PK;

		$this->_ci->load->model(array($tbl_name . '_model', 'spt_detil_model'));

		$m1 = $this->_ci->{$tbl_name . '_model'};
		$m2 = $this->_ci->spt_detil_model;

		$id_value = ($act == 'edit' ? $_POST['id'] : '');

		$curr_data = $this->dao->get_data_by_id($act, $m1, $id_value);

		$sql = "SELECT * FROM stpd WHERE stpd_id='" . ($id_value == '' ? '0' : $id_value) . "'";
		$curr_data2 = $this->dao->execute(0, $sql)->result_array();

		$sql = "SELECT a.*,b.persen_denda FROM v_spt2 as a LEFT JOIN bundel_pajak_retribusi as b ON (a.pajak_id=b.bundel_id) 
					WHERE a.spt_id='" . $spt_id . "'";

		$taxpayer_detail_row = $this->dao->execute(0, $sql)->row_array();

		$jatuh_tempo = date('Y-m-d', strtotime("+2 months - 1 day", strtotime($taxpayer_detail_row['masa_pajak1'])));

		$main_form_id = "main-form-id";
		$view_folder = $this->bundle_type . '/' . $menu;

		$main_data = array(
			'act' => $act,
			'curr_data' => $curr_data,
			'curr_data2' => $curr_data2,
			'taxpayer_detail_row' => $taxpayer_detail_row,
			'jatuh_tempo' => $jatuh_tempo,
			'id_value' => $id_value,
			'spt_id' => $spt_id,
			'menu' => $menu,
			'main_form_id' => $main_form_id,
			'showed' => $showed,
			'bundle_name' => $this->bundle_row['nama_paret'],
			'bundle_id' => $this->bundle_id
		);

		$main_data = array_merge($this->main_params, $main_data);

		$data = array_merge($this->main_params, $main_data);

		$this->_ci->load->view($view_folder . '/form', $data);
	}

	function submit_form()
	{

		$this->_ci->admin_access_handler->check_access();

		$act = $_POST['act'];
		$id_value = $_POST['id_value'];
		$wp_wr_id = $_POST['wp_wr_id'];
		$pajak_id = $_POST['pajak_id'];
		$tgl_proses = us_date_format($_POST['tgl_proses']);
		$jatuh_tempo = us_date_format($_POST['jatuh_tempo']);
		$periode = $_POST['periode'];
		$korek_id = $_POST['korek_id'];
		$masa_pajak1 = $_POST['masa_pajak1'];
		$masa_pajak2 = $_POST['masa_pajak2'];
		$kode_billing = $_POST['kode_billing'];
		$no_surat = $_POST['no_surat'];
		$menu = $_POST['menu'];
		$showed = $_POST['showed'];

		$query = "select max(stpd_id)+1 as stpd_id from stpd";
		$result = $this->dao->execute(0, $query)->row_array();
		$stpd_id = $result['stpd_id'];
		if ($stpd_id == null) {
			$stpd_id = 1;
		}

		if ($act == 'add') {
			$access = $this->_ci->public_template->get_access_privileges('add', $menu, $this->bundle_id);
		} else {
			$access = $this->_ci->public_template->get_access_privileges('update', $menu, $this->bundle_id);
		}

		if ($access == '1') {

			$this->_ci->db->trans_begin();

			if ($act == 'add') {
				$query = "INSERT INTO stpd (stpd_id, stpd_jenis_pajak, stpd_tgl_proses, stpd_jatuh_tempo, stpd_periode, stpd_nomor, stpd_wp_id, stpd_korek_id, stpd_periode_jual1, stpd_periode_jual2, stpd_kode_billing, no_surat) VALUES ($stpd_id, $pajak_id, '$tgl_proses', '$jatuh_tempo', $periode, $stpd_id, $wp_wr_id, '$korek_id', '$masa_pajak1', '$masa_pajak2', '$kode_billing', '$no_surat')";
				$result = $this->dao->execute(0, $query);
				$label = "menyimpan";
			} else {
				$result = $this->dao->update($m1, array($pk => $id_value));
				$label = "merubah";
			}

			if (!$result) {
				$this->_ci->db->trans_rollback();
				die('ERROR: gagal ' . $label . ' data');
			}

			$this->_ci->db->trans_commit();


			//return response
			if ($showed != '0') {
				$cond_params = array_merge(array('a.pajak_id' => $this->bundle_id), $this->collect_cond_params($_POST, 'src'));

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

				$this->print_list_data($menu, $cond_params, array_merge($src_params, $src_daterange_params));
			}
		} else {
			$this->_ci->load->view('errors/html/error_403', array('type' => $act));
		}
	}

	function delete_record()
	{
		$id = $_POST['id'];
		$act = $_POST['act'];
		$menu = $_POST['menu'];

		$access = $this->_ci->public_template->get_access_privileges('delete', $menu, $this->bundle_id);

		if ($access == '1') {

			$this->_ci->db->trans_begin();

			$query = "DELETE FROM stpd WHERE stpd_id=$id";
			$result = $this->dao->execute(0, $query);
			$label = "menghapus";

			$this->_ci->db->trans_commit();

			$cond_params = array_merge(array('a.pajak_id' => $this->bundle_id), $this->collect_cond_params($_POST, 'src'));


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

			$this->print_list_data($menu, $cond_params, array_merge($src_params, $src_daterange_params));
		} else {
			$this->_ci->load->view('errors/html/error_403', array('type' => $act));
		}
	}

	private function get_fine($tax, $due_date, $tgl_bayar, $determination_type, $jenis_pajak)
	{

		$diff_month = get_diff_months($due_date, $tgl_bayar, $determination_type);

		if ($jenis_pajak == '6') {
			$fine = assess_fine($tax, $diff_month);
		} else {
			$fine = assess_fine_new($tax, $diff_month);
		}

		return $fine;
	}

	function _print()
	{

		$id = $_GET['id'];

		$jenis_pajak = $this->bundle_id;
		$sql_kode_pajak = "SELECT b.rek_bank FROM bundel_pajak_retribusi AS a
							LEFT JOIN tbl_ref_rekening AS b ON a.kode_pajak=b.rek_epada
							WHERE a.bundel_id = " . $jenis_pajak . "";
		$data['kode_pajak'] = $this->dao->execute(0, $sql_kode_pajak)->row_array();

		$sql = "SELECT a.*, b.nama_pajak, b.nomor_spt, b.npwpd, b.nama_wp, b.persen_tarif, b.nilai_terkena_pajak, b.pajak, b.jenis_spt_id FROM stpd as a 
				LEFT JOIN v_spt2 as b ON (a.stpd_kode_billing=b.kode_billing)
				WHERE a.stpd_id='" . $id . "'";
		$rows2 = $this->dao->execute(0, $sql)->row_array();

		$data['rows'] = $rows2;

		$masa_lapor = date('Y-m-d', strtotime("+1 months", strtotime($rows2['stpd_periode_jual1'])));

		if (date('m', strtotime($masa_lapor)) == '02') {
			$jatuh_tempo = date('Y-m-28', strtotime($masa_lapor));
		} else {
			$jatuh_tempo = date('Y-m-30', strtotime($masa_lapor));
		}

		$denda = $this->get_fine($rows2['pajak'], $jatuh_tempo, date('Y-m-d'), $rows2['jenis_spt_id'], $rows2['stpd_jenis_pajak']);

		$data['denda'] = $denda;

		$data['grand_total'] = $rows2['pajak'] + $denda;

		$view_folder = $this->bundle_type . '/record_stpd';

		$this->_ci->load->view($view_folder . '/print', $data);
	}
}
