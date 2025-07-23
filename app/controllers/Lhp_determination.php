<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'controllers' . DIRECTORY_SEPARATOR . 'Item_bundle_parent.php';

class lhp_determination extends item_bundle_parent
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

	function form()
	{

		$this->_ci->admin_access_handler->check_access();

		$npwprd = $_POST['npwprd'];

		$tax_year = $_POST['tahun_pajak'];
		$determination_date = $_POST['tgl_penetapan'];
		$menu = $_POST['menu'];
		$act = $_POST['act'];
		$showed = $_POST['showed'];
		$curr_year = date('Y');

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

		$sql = "SELECT a.lhp_id,a.pajak,d.keterangan as keterangan_spt,b.nama as nama_wp,c.npwprd,a.tahun_pajak,
					a.pajak,to_char(a.tgl_pemeriksaan,'dd-mm-yyyy') as tgl_pemeriksaan,
					a.jenis_spt_id,a.rekening_id 
					FROM laporan_hasil_pemeriksaan as a
					INNER JOIN wp_wr_detil as b ON (a.wp_wr_detil_id=b.wp_wr_detil_id) 
					INNER JOIN wp_wr as c ON (a.wp_wr_id=c.wp_wr_id) 					
					INNER JOIN ref_jenis_spt as d ON (a.jenis_spt_id=d.ref_jenspt_id) 
					WHERE a.lhp_id NOT IN (SELECT lhp_id FROM penetapan_pajak WHERE pajak_id='" . $this->bundle_id . "' AND tahun_pajak='" . $tax_year . "' AND lhp_id IS NOT NULL) 
					AND a.pajak_id='" . $this->bundle_id . "' AND tahun_pajak='" . $tax_year . "' AND c.npwprd='" . $npwprd . "' AND status_ketetapan='0'";


		$rows = $this->dao->execute(0, $sql)->result_array();

		$data = array(
			'rows' => $rows, 'act' => $act, 'menu' => $menu, 'showed' => $showed, 'bundle_type' => $this->bundle_type,
			'bundle_item_type' => $this->bundle_item_type, 'tax_year' => $tax_year, 'determination_date' => $determination_date,
			'src_params' => $src_params, 'src_daterange_params' => $src_daterange_params, 'main_form_id' => 'determination-form'
		);

		$view_folder = $this->bundle_type . '/' . $menu;

		$this->_ci->load->view($view_folder . '/form', $data);
	}


	function lhp_search_panel()
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

		$this->_ci->load->view($view_folder . '/lhp_search_panel', $data);
	}


	function submit_form()
	{

		$this->_ci->admin_access_handler->check_access();

		$tax_year = $_POST['tahun_pajak'];
		$tgl_penetapan = us_date_format($_POST['tgl_penetapan']);
		$menu = $_POST['menu'];
		$showed = $_POST['showed'];

		$system_params = $this->_ci->database_interactions->get_system_params();
		$tgl_jatuh_tempo = dateadd($tgl_penetapan, $system_params[13]);

		$created_by = $this->_ci->session->userdata('username');
		$created_time = date('Y-m-d H:i:s');

		$access = $this->_ci->public_template->get_access_privileges('add', $menu, $this->bundle_id);

		if ($access == '1') {

			$res = $menu . '_resources';
			require_once APPPATH . 'libraries' . DIRECTORY_SEPARATOR . 'system_resources' . DIRECTORY_SEPARATOR . $res . '.php';
			$tbl_name = $res::$_TBL_NAME;
			$pk = $res::$_PK;

			$this->_ci->load->model(array($tbl_name . '_model', 'laporan_hasil_pemeriksaan_model'));
			$m1 = $this->_ci->{$tbl_name . '_model'};
			$m2 = $this->_ci->laporan_hasil_pemeriksaan_model;

			$input_params1 = array();
			$input_params2 = array();

			$this->_ci->db->trans_begin();

			$n_lhp = $_POST['n_lhp'];
			$index = $_POST['index'];

			$input_params1['lhp_id'] = $_POST['input-lhp_id' . $index];
			$input_params1['pajak_id'] = $this->bundle_id;
			$input_params1['kohir'] = $this->_ci->database_interactions->generate_lhp_kohir_humb($_POST['input-jenis_spt_id' . $index]);
			$input_params1['jenis_spt_id'] = $_POST['input-jenis_spt_id' . $index];
			$input_params1['tipe_penetapan'] = '2';
			$input_params1['tahun_pajak'] = $tax_year;
			$input_params1['tgl_penetapan'] = $tgl_penetapan;
			$input_params1['tgl_jatuh_tempo'] = $tgl_jatuh_tempo;
			$input_params1['rekening_id'] = $_POST['input-rekening_id' . $index];
			$input_params1['created_by'] = $created_by;
			$input_params1['created_time'] = $created_time;
			$input_params1[$pk] = $this->_ci->global_model->get_nextval('penetapan_pajak_penetapan_id_seq');

			$this->delegate_postTomodel($input_params1, $m1);

			$result = $this->dao->insert($m1);

			if (!$result) {
				$this->_ci->db->trans_rollback();
				die('ERROR: gagal menetapkan data!');
			}

			$m2->set_status_ketetapan('1');
			$m2->set_kode_billing($this->_ci->database_interactions->generate_billing_code('2'));

			$result = $this->dao->update($m2, array('lhp_id' => $_POST['input-lhp_id' . $index]));

			if (!$result) {
				$this->_ci->db->trans_rollback();
				die('ERROR: gagal menetapkan data!');
			}

			$this->_ci->db->trans_commit();

			//return response
			if ($showed != '0') {
				$cond_params = array_merge(array('a.pajak_id' => $this->bundle_id, 'tipe_penetapan' => '2'), $this->collect_cond_params($_POST, 'src'));

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
		$lhp_id = $_POST['lhp_id'];
		$act = $_POST['act'];
		$menu = $_POST['menu'];

		$access = $this->_ci->public_template->get_access_privileges('delete', $menu, $this->bundle_id);

		if ($access == '1') {

			$res = $menu . '_resources';
			require_once APPPATH . 'libraries' . DIRECTORY_SEPARATOR . 'system_resources' . DIRECTORY_SEPARATOR . $res . '.php';

			$tbl_name = $res::$_TBL_NAME;
			$pk = $res::$_PK;

			$this->_ci->load->model(array($tbl_name . '_model', 'laporan_hasil_pemeriksaan_model'));
			$m1 = $this->_ci->{$tbl_name . '_model'};
			$m2 = $this->_ci->laporan_hasil_pemeriksaan_model;

			$this->_ci->db->trans_begin();

			$cond_params = array($pk => $id);
			$result = $this->dao->delete($m1, $cond_params);
			if (!$result) {
				$this->_ci->db->trans_rollback();
				die('ERROR: gagal menghapus data');
			}

			$m2->set_status_ketetapan('0');
			$result = $this->dao->update($m2, array('lhp_id' => $lhp_id));
			if (!$result) {
				$this->_ci->db->trans_rollback();
				die('ERROR: gagal menghapus data');
			}

			$this->_ci->db->trans_commit();

			$cond_params = array_merge(array('a.pajak_id' => $this->bundle_id, 'tipe_penetapan' => '2'), $this->collect_cond_params($_POST, 'src'));

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

	function _print()
	{

		$id = $_GET['id'];

		$sql = "SELECT b.keterangan, a.no_pemeriksaan, TO_CHAR(a.tgl_pemeriksaan,'dd-mm-yyy') AS tgl_pemeriksaan, a.npwprd, a.kesimpulan, a.hasil_pemeriksaan, c.nama_pemilik, c.alamat, d.nama_paret
				FROM laporan_hasil_pemeriksaan AS a 
				LEFT JOIN ref_jenis_spt AS b ON a.jenis_spt_id=b.ref_jenspt_id
				LEFT JOIN wp_wr AS c ON a.wp_wr_id=c.wp_wr_id
				LEFT JOIN bundel_pajak_retribusi AS d ON a.pajak_id=d.bundel_id 
				WHERE a.lhp_id='" . $id . "'";

		$row = $this->dao->execute(0, $sql)->row_array();

		$system_params = $this->_ci->database_interactions->get_system_params();

		$data = array(
			'row' => $row,
			'system_params' => $system_params
		);

		$view_folder = 'taxes/' . $this->menu;
		$this->_ci->load->view($view_folder . '/print', $data);
	}
}
