<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'controllers' . DIRECTORY_SEPARATOR . 'Item_bundle_parent.php';

class print_taxpayer_numbers_list extends item_bundle_parent
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

		$sql = "SELECT * FROM bundel_pajak_retribusi WHERE tipe='pajak' AND status='management'";
		$tax_rows = $this->dao->execute(0, $sql)->result_array();

		$sql = "SELECT a.pejda_id,a.nama,b.nama_jabatan FROM pejabat_daerah as a 
					LEFT JOIN ref_jabatan_pejabat_daerah as b ON (a.japeda_id=b.ref_japeda_id)";
		$official_rows = $this->dao->execute(0, $sql)->result_array();

		$pajak_id = '';
		if ($this->bundle_item_type == 'hotel') {
			$pajak_id = '1';
		} elseif ($this->bundle_item_type == 'restaurant') {
			$pajak_id = '2';
		} elseif ($this->bundle_item_type == 'entertainment') {
			$pajak_id = '4';
		} elseif ($this->bundle_item_type == 'nonmetallic_mineral_rock') {
			$pajak_id = '6';
		} elseif ($this->bundle_item_type == 'groundwater') {
			$pajak_id = '7';
		} elseif ($this->bundle_item_type == 'parking') {
			$pajak_id = '11';
		}

		$sql_kegus = "SELECT ref_kegus_id, nama_kegus FROM ref_kegiatan_usaha WHERE pajak_id = '$pajak_id'";

		$kegus = $this->dao->execute(0, $sql_kegus)->result_array();

		$main_data = array(
			'bundle_row' => $this->bundle_row,
			'tax_rows' => $tax_rows,
			'official_rows' => $official_rows,
			'kegus' => $kegus,
		);

		// no need to modified
		$data = array(
			'menu_params' => $this->menu_params,
			'main_params' => array_merge($this->main_params, $main_data)
		);

		$this->_ci->public_template->render($this->view_folder . '/index', $data);
	}

	function report_controller()
	{

		$menu = $_POST['menu'];
		$report_type = $_POST['report_type'];

		$src_params = $this->collect_input_params($_POST, 'src', false);
		$printAttr_params = $this->collect_input_params($_POST, 'printAttr', false);

		$urlstring_params = $this->generate_urlstring_params(array_merge($src_params, $printAttr_params));
		$method = "";

		switch ($report_type) {
			case '1':
				$method = "_print";
				break;
			case '2':
				$method = "pdf";
				break;
		}

		$this->menu = $menu;

		echo "<script type='text/javascript'>

				window.open('" . base_url() . "bundle/" . $this->bundle_type . "/" . $this->bundle_item_type . "/" . $menu . "/" . $method . $urlstring_params . "');

			</script>";
	}

	function _print()
	{

		$this->show_report(1);
	}

	function pdf()
	{

		$this->show_report(2);
	}

	function show_report($type)
	{
		$src_params = $this->collect_input_params($_GET, 'src');
		$printAttr_params = $this->collect_input_params($_GET, 'printAttr');

		$sql = "SELECT a.nama,a.nip,b.pangkat,c.nama_jabatan FROM pejabat_daerah as a 
					LEFT JOIN ref_gol_ruang as b ON (a.goru_id=b.ref_goru_id) 
					LEFT JOIN ref_jabatan_pejabat_daerah as c ON (a.japeda_id=c.ref_japeda_id)";

		$legalitator_row = array();
		$evaluator_row = array();

		if (isset($printAttr_params['legalitator'])) {
			$cond = " WHERE pejda_id='" . $printAttr_params['legalitator'] . "'";
			$_sql = $sql . $cond;
			$legalitator_row = $this->dao->execute(0, $_sql)->row_array();
		}

		if (isset($printAttr_params['evaluator'])) {
			$cond = " WHERE pejda_id='" . $printAttr_params['evaluator'] . "'";
			$_sql = $sql . $cond;
			$evaluator_row = $this->dao->execute(0, $_sql)->row_array();
		}

		$rows = $this->get_rows($src_params);

		$tax_searched = isset($src_params['kegus_id']);
		$tax_row = array();
		if ($tax_searched) {
			$sql = "SELECT * FROM bundel_pajak_retribusi WHERE bundel_id='" . $src_params['kegus_id'] . "'";
			$tax_row = $this->dao->execute(0, $sql)->row_array();
		}

		$date_period = "S.D Tanggal " . indo_date_format(date('Y-m-d'), 'longDate');
		if (isset($src_params['tgl_pendaftaran_awal']) && isset($src_params['tgl_pendaftaran_akhir'])) {
			$date_period = "Periode Tanggal " . mix_2Date(us_date_format($src_params['tgl_pendaftaran_awal']), us_date_format($src_params['tgl_pendaftaran_akhir']));
		} else if (isset($src_params['tgl_pendaftaran_awal'])) {
			$date_period = "Periode Tanggal " . mix_2Date(us_date_format($src_params['tgl_pendaftaran_awal']), date('Y-m-d'));
		} else if (isset($src_params['tgl_pendaftaran_akhir'])) {
			$date_period = "S.D Tanggal " . indo_date_format(us_date_format($src_params['tgl_pendaftaran_akhir']), 'longDate');
		}

		$system_params = $this->_ci->database_interactions->get_system_params();
		$data = array_merge(
			$rows,
			array(
				'print_date' => us_date_format($printAttr_params['print_date']),
				'date_period' => $date_period,
				'system_params' => $system_params,
				'legalitator_row' => $legalitator_row,
				'evaluator_row' => $evaluator_row,
				'tax_searched' => $tax_searched,
				'tax_row' => $tax_row,
			)
		);

		$view_folder = $this->bundle_type . '/' . __CLASS__;

		if ($type == 1) {
			// if (isset($src_params['tgl_pendaftaran_awal']) && isset($src_params['tgl_pendaftaran_akhir'])) {
			// 	$view_folder .= '/print2';
			// } else {
			// 	$view_folder .= '/print';
			// }
			$view_folder .= '/print';
		} else {

			// $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', [210, 297],'orientation'=>'L']);
			// $data['mpdf'] = $mpdf;
			$mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'mpdf']);

			$mpdf->SetMargins(10, 10, 10);
			$data = array_merge(
				$rows,
				array(
					'print_date' => us_date_format($printAttr_params['print_date']),
					'date_period' => $date_period,
					'system_params' => $system_params,
					'legalitator_row' => $legalitator_row,
					'evaluator_row' => $evaluator_row,
					'tax_searched' => $tax_searched,
					'tax_row' => $tax_row,
					'mpdf' => $mpdf,
				)
			);

			$view_folder .= '/pdf';
		}

		$this->_ci->load->view($view_folder, $data);
	}


	function get_rows($src_params)
	{
		$res = __CLASS__ . '_resources';
		require_once APPPATH . 'libraries' . DIRECTORY_SEPARATOR . 'system_resources' . DIRECTORY_SEPARATOR . $res . '.php';

		$tbl_name = $res::$_TBL_NAME;
		$pk = $res::$_PK;
		$sql = $res::$_SQL_LIST;

		$cond = "";

		$type = '';
		if (isset($src_params['kegus_id'])) {
			$rows1 = $this->dao->execute(0, "SELECT kecamatan_id as id,nama_kecamatan as deskripsi FROM ref_kecamatan")->result_array();
			$type = 1;
		} else {
			// $rows1 = $this->dao->execute(0, "SELECT bundel_id as id,nama_paret as deskripsi FROM bundel_pajak_retribusi 
			// 								    WHERE tipe='pajak' AND status='management'")->result_array();
			$pajak_id = '';
			if ($this->bundle_item_type == 'hotel') {
				$pajak_id = '1';
			} elseif (
				$this->bundle_item_type == 'restaurant'
			) {
				$pajak_id = '2';
			} elseif ($this->bundle_item_type == 'entertainment') {
				$pajak_id = '4';
			} elseif ($this->bundle_item_type == 'nonmetallic_mineral_rock') {
				$pajak_id = '6';
			} elseif ($this->bundle_item_type == 'groundwater') {
				$pajak_id = '7';
			} elseif ($this->bundle_item_type == 'parking') {
				$pajak_id = '11';
			}
			$rows1 = $this->dao->execute(0, "SELECT ref_kegus_id as id,nama_kegus as deskripsi FROM ref_kegiatan_usaha 
											    WHERE pajak_id='$pajak_id'")->result_array();
			$type = 2;
		}

		$curr_date = date('Y-m-d');

		$x_curr_date = explode('-', date('Y-m-d'));

		$curr_m = $x_curr_date[1];
		$curr_y = $x_curr_date[0];

		$prev_month_date = date('Y-m-d', mktime(0, 0, 0, $curr_m - 1, $x_curr_date[2], $curr_y));

		$x_prev_month_date = explode('-', $prev_month_date);

		$prev_y = $x_prev_month_date[0];
		$prev_m = $x_prev_month_date[1];

		$prev_n_days = cal_days_in_month(CAL_GREGORIAN, $prev_m, $prev_y);
		$curr_n_days = cal_days_in_month(CAL_GREGORIAN, $curr_m, $curr_y);


		$prev_last_date = $curr_y . '-' . $prev_m . '-' . $prev_n_days;
		$curr_last_date = $curr_y . '-' . $curr_m . '-' . $curr_n_days;
		$curr_start_date = $curr_y . '-' . $curr_m . '-01';

		$_sql = "SELECT COUNT(1) as n_row FROM wp_wr";

		if ($type == 1)
			$_sql .= " WHERE kecamatan_id=? AND kegus_id ='" . $src_params['kegus_id'] . "'";
		else
			$_sql .= " WHERE kegus_id=?";

		// $sql = $_sql . " AND tgl_pendaftaran < '" . $prev_last_date . "'";
		if (isset($src_params['tgl_pendaftaran_awal']) && isset($src_params['tgl_pendaftaran_akhir'])) {
			$start_pendaftaran = us_date_format($src_params['tgl_pendaftaran_awal']);
			$sql = $_sql . " AND tgl_pendaftaran <= '" . $start_pendaftaran . "'";
		} else {
			$sql = $_sql . " AND tgl_pendaftaran <= '" . $prev_last_date . "'";
		}
		$dao1 = $this->dao;
		$dao1->reset_object();
		$dao1->set_sql_with_params($sql);

		if (isset($src_params['tgl_pendaftaran_awal']) && isset($src_params['tgl_pendaftaran_akhir'])) {
			$start_pendaftaran = us_date_format($src_params['tgl_pendaftaran_awal']);
			$end_pendaftaran = us_date_format($src_params['tgl_pendaftaran_akhir']);
			$sql = $_sql . " AND tgl_pendaftaran BETWEEN '" . $start_pendaftaran . "' AND '" . $end_pendaftaran . "'";
		} else {
			$sql = $_sql . " AND tgl_pendaftaran BETWEEN '" . $curr_start_date . "' AND '" . $curr_last_date . "'";
		}
		$this->_ci->global_model->reinitialize_dao();
		$dao2 = $this->_ci->global_model->get_dao();
		$dao2->reset_object();
		$dao2->set_sql_with_params($sql);

		$sql = "SELECT COUNT(1) as n_row FROM wp_wr_penutupan as a LEFT JOIN wp_wr_detil as b ON (a.wp_wr_detil_id=b.wp_wr_detil_id) 
					WHERE " . ($type == 1 ? "b.kecamatan_id" : "b.kegus_id") . "=? AND a.tgl_tutup BETWEEN '" . $curr_start_date . "' AND '" . $curr_last_date . "'";

		$this->_ci->global_model->reinitialize_dao();
		$dao3 = $this->_ci->global_model->get_dao();
		$dao3->reset_object();
		$dao3->set_sql_with_params($sql);

		return array('rows1' => $rows1, 'dao1' => $dao1, 'dao2' => $dao2, 'dao3' => $dao3);
	}
}
