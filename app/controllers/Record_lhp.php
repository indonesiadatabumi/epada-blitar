<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'controllers' . DIRECTORY_SEPARATOR . 'Item_bundle_parent.php';

class record_lhp extends item_bundle_parent
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
		$spt_type_rows = $this->dao->execute(0, "SELECT * FROM ref_jenis_spt WHERE singkatan LIKE 'S%' AND ref_jenspt_id<>'1' ORDER BY ref_jenspt_id ASC")->result_array();

		$main_data = array(
			'bundle_row' => $this->bundle_row,
			'district_rows' => $district_rows,
			'spt_type_rows' => $spt_type_rows,
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

		$search_key = $_POST['src_form-key'];
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


		$sql = "SELECT * FROM v_objek_pajak WHERE pajak_id='" . $this->bundle_id . "' AND status=TRUE AND (npwprd LIKE '%" . $search_key . "%' OR nama_wp LIKE '%" . $search_key . "%')";

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
		$wp_wr_detil_id = $_POST['wp_wr_detil_id'];

		$res = $menu . '_resources';
		require_once APPPATH . 'libraries' . DIRECTORY_SEPARATOR . 'system_resources' . DIRECTORY_SEPARATOR . $res . '.php';

		$tbl_name = $res::$_TBL_NAME;
		$pk = $res::$_PK;

		$this->_ci->load->model(array($tbl_name . '_model', 'spt_detil_model'));

		$m1 = $this->_ci->{$tbl_name . '_model'};
		$m2 = $this->_ci->spt_detil_model;

		$id_value = ($act == 'edit' ? $_POST['id'] : '');

		$curr_data = $this->dao->get_data_by_id($act, $m1, $id_value);

		$sql = "SELECT * FROM laporan_hasil_pemeriksaan_detil WHERE lhp_id='" . ($id_value == '' ? '0' : $id_value) . "'";
		$curr_data2 = $this->dao->execute(0, $sql)->result_array();

		$sql = "SELECT a.*,b.persen_denda FROM v_objek_pajak as a LEFT JOIN bundel_pajak_retribusi as b ON (a.pajak_id=b.bundel_id) 
					WHERE a.wp_wr_detil_id='" . $wp_wr_detil_id . "'";

		$taxpayer_detail_row = $this->dao->execute(0, $sql)->row_array();

		$main_form_id = "main-form-id";
		$view_folder = $this->bundle_type . '/' . $menu;

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


		$spt_type_rows = $this->dao->execute(0, "SELECT * FROM ref_jenis_spt WHERE singkatan LIKE 'S%' AND ref_jenspt_id<>'1'")->result_array();

		$sql = "SELECT rekening_id,nama_rekening,kode_rekening,persen_tarif,ref_id,jenis_rekening FROM v_rekening WHERE ref_id='" . $taxpayer_detail_row['kegus_id'] . "' 
					UNION
					SELECT rekening_id,nama_rekening,kode_rekening,persen_tarif,ref_id,jenis_rekening FROM v_rekening WHERE pajak_id='" . $taxpayer_detail_row['pajak_id'] . "' AND jenis_rekening='B'";

		$account_rows = $this->dao->execute(0, $sql)->result_array();

		$main_data = array(
			'act' => $act,
			'curr_data' => $curr_data,
			'curr_data2' => $curr_data2,
			'taxpayer_detail_row' => $taxpayer_detail_row,
			'id_value' => $id_value,
			'wp_wr_detil_id' => $wp_wr_detil_id,
			'menu' => $menu,
			'main_form_id' => $main_form_id,
			'showed' => $showed,
			'src_params' => $src_params,
			'src_daterange_params' => $src_daterange_params,
			'bundle_name' => $this->bundle_row['nama_paret'],
			'bundle_id' => $this->bundle_id,
			'spt_type_rows' => $spt_type_rows,
			'account_rows' => $account_rows,
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
		$wp_wr_detil_id = $_POST['wp_wr_detil_id'];
		$wp_wr_id = $_POST['wp_wr_id'];
		$pajak_id = $_POST['pajak_id'];
		$kegus_id = $_POST['kegus_id'];
		$persen_tarif = $_POST['persen_tarif'];
		$menu = $_POST['menu'];
		$showed = $_POST['showed'];

		$curr_year = date('Y');

		if ($act == 'add') {
			$access = $this->_ci->public_template->get_access_privileges('add', $menu, $this->bundle_id);
		} else {
			$access = $this->_ci->public_template->get_access_privileges('update', $menu, $this->bundle_id);
		}

		if ($access == '1') {

			$res = $menu . '_resources';
			require_once APPPATH . 'libraries' . DIRECTORY_SEPARATOR . 'system_resources' . DIRECTORY_SEPARATOR . $res . '.php';
			$tbl_name = $res::$_TBL_NAME;
			$pk = $res::$_PK;

			$this->_ci->load->model(array($tbl_name . '_model', 'laporan_hasil_pemeriksaan_detil_model'));
			$m1 = $this->_ci->{$tbl_name . '_model'};
			$m2 = $this->_ci->laporan_hasil_pemeriksaan_detil_model;

			$input_params = $this->collect_input_params($_POST, 'input');
			$input_params2 = array();

			$x_account = explode('_', $input_params['rekening_id']);
			$input_params['rekening_id'] = $x_account[0];
			$input_params['persen_tarif'] = $persen_tarif;

			$n_detail_rows = $_POST['n_detail_rows'];

			$this->_ci->db->trans_begin();

			if ($act == 'add') {

				$input_params['wp_wr_id'] = $wp_wr_id;
				$input_params['wp_wr_detil_id'] = $wp_wr_detil_id;
				$input_params['pajak_id'] = $pajak_id;
				$input_params['kegus_id'] = $kegus_id;
				$input_params['tahun_pajak'] = $_POST['tahun_pajak'];
				$input_params['npwprd'] = $_POST['input-npwprd'];
				$input_params['nomor'] = $this->_ci->database_interactions->generate_lhp_number();
				$input_params[$pk] = $this->_ci->global_model->get_nextval('laporan_hasil_pemeriksaan_lhp_id_seq');

				for ($i = 1; $i <= $n_detail_rows; $i++) {

					if (isset($_POST['input2-pajak' . $i])) {
						$input_params2['masa_pajak1'] = us_date_format($_POST['input2-masa_pajak1' . $i]);
						$input_params2['masa_pajak2'] = us_date_format($_POST['input2-masa_pajak2' . $i]);
						$input_params2['nilai_terkena_pajak'] = str_replace(',', '', $_POST['input2-nilai_terkena_pajak' . $i]);
						$input_params2['pajak_terhutang'] = str_replace(',', '', $_POST['input2-pajak_terhutang' . $i]);
						$input_params2['nilai_terkena_pajak'] = str_replace(',', '', $_POST['input2-nilai_terkena_pajak' . $i]);
						$input_params2['persen_tarif'] = $persen_tarif;
						$input_params2['setoran'] = str_replace(',', '', $_POST['input2-setoran' . $i]);
						$input_params2['kompensasi'] = str_replace(',', '', $_POST['input2-kompensasi' . $i]);
						$input_params2['kredit_pajak_lain'] = str_replace(',', '', $_POST['input2-kredit_pajak_lain' . $i]);
						$input_params2['total_kredit_pajak'] = str_replace(',', '', $_POST['input2-total_kredit_pajak' . $i]);
						$input_params2['pokok_pajak'] = str_replace(',', '', $_POST['input2-pokok_pajak' . $i]);
						$input_params2['bunga'] = str_replace(',', '', $_POST['input2-bunga' . $i]);
						$input_params2['kenaikan'] = str_replace(',', '', $_POST['input2-kenaikan' . $i]);
						$input_params2['total_sanksi'] = str_replace(',', '', $_POST['input2-total_sanksi' . $i]);
						$input_params2['pajak'] = str_replace(',', '', $_POST['input2-pajak' . $i]);
						$input_params2['lhp_id'] = $input_params['lhp_id'];
						$input_params2['lhp_detil_id'] = $this->_ci->global_model->get_nextval('laporan_hasil_pemeriksaan_detil_lhp_detil_id_seq');

						$this->delegate_postTomodel($input_params2, $m2);

						$result = $this->dao->insert($m2);

						if (!$result) {
							$this->_ci->db->trans_rollback();
							die('ERROR: gagal menambah data');
						}
					}
				}
			} else {

				$result = $this->dao->delete($m2, array('lhp_id' => $id_value));

				if (!$result) {
					$this->_ci->db->trans_rollback();
					die('ERROR: gagal merubah data');
				}


				for ($i = 1; $i <= $n_detail_rows; $i++) {

					if (isset($_POST['input2-pajak' . $i])) {
						$input_params2['masa_pajak1'] = us_date_format($_POST['input2-masa_pajak1' . $i]);
						$input_params2['masa_pajak2'] = us_date_format($_POST['input2-masa_pajak2' . $i]);
						$input_params2['nilai_terkena_pajak'] = str_replace(',', '', $_POST['input2-nilai_terkena_pajak' . $i]);
						$input_params2['pajak_terhutang'] = str_replace(',', '', $_POST['input2-pajak_terhutang' . $i]);
						$input_params2['nilai_terkena_pajak'] = str_replace(',', '', $_POST['input2-nilai_terkena_pajak' . $i]);
						$input_params2['persen_tarif'] = $persen_tarif;
						$input_params2['setoran'] = str_replace(',', '', $_POST['input2-setoran' . $i]);
						$input_params2['kompensasi'] = str_replace(',', '', $_POST['input2-kompensasi' . $i]);
						$input_params2['kredit_pajak_lain'] = str_replace(',', '', $_POST['input2-kredit_pajak_lain' . $i]);
						$input_params2['total_kredit_pajak'] = str_replace(',', '', $_POST['input2-total_kredit_pajak' . $i]);
						$input_params2['pokok_pajak'] = str_replace(',', '', $_POST['input2-pokok_pajak' . $i]);
						$input_params2['bunga'] = str_replace(',', '', $_POST['input2-bunga' . $i]);
						$input_params2['kenaikan'] = str_replace(',', '', $_POST['input2-kenaikan' . $i]);
						$input_params2['total_sanksi'] = str_replace(',', '', $_POST['input2-total_sanksi' . $i]);
						$input_params2['pajak'] = str_replace(',', '', $_POST['input2-pajak' . $i]);
						$input_params2['lhp_id'] = $id_value;
						$input_params2['lhp_detil_id'] = $this->_ci->global_model->get_nextval('laporan_hasil_pemeriksaan_detil_lhp_detil_id_seq');

						$this->delegate_postTomodel($input_params2, $m2);

						$result = $this->dao->insert($m2);

						if (!$result) {
							$this->_ci->db->trans_rollback();
							die('ERROR: gagal menambah data');
						}
					}
				}
			}

			$this->delegate_postTomodel($input_params, $m1);

			if ($act == 'add') {
				$result = $this->dao->insert($m1);
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

			$res = $menu . '_resources';
			require_once APPPATH . 'libraries' . DIRECTORY_SEPARATOR . 'system_resources' . DIRECTORY_SEPARATOR . $res . '.php';

			$tbl_name = $res::$_TBL_NAME;
			$pk = $res::$_PK;

			$this->_ci->load->model(array($tbl_name . '_model', 'laporan_hasil_pemeriksaan_detil_model'));
			$m1 = $this->_ci->{$tbl_name . '_model'};
			$m2 = $this->_ci->laporan_hasil_pemeriksaan_detil_model;

			$this->_ci->db->trans_begin();

			$cond_params = array($pk => $id);
			$result = $this->dao->delete($m1, $cond_params);
			if (!$result) {
				$this->_ci->db->trans_rollback();
				die('ERROR: gagal menghapus data');
			}

			$result = $this->dao->delete($m2, $cond_params);
			if (!$result) {
				$this->_ci->db->trans_rollback();
				die('ERROR: gagal menghapus data');
			}

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
}
