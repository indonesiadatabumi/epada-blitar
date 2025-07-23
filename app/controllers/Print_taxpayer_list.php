<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'controllers' . DIRECTORY_SEPARATOR . 'Item_bundle_parent.php';

class print_taxpayer_list extends item_bundle_parent
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
		$business_rows = $this->dao->execute(0, "SELECT * FROM ref_kegiatan_usaha WHERE pajak_id='" . $this->bundle_id . "'")->result_array();

		$sql = "SELECT a.pejda_id,a.nama,b.nama_jabatan FROM pejabat_daerah as a 
					LEFT JOIN ref_jabatan_pejabat_daerah as b ON (a.japeda_id=b.ref_japeda_id)";

		$official_rows = $this->dao->execute(0, $sql)->result_array();

		$main_data = array(
			'bundle_row' => $this->bundle_row,
			'district_rows' => $district_rows,
			'official_rows' => $official_rows,
			'business_rows' => $business_rows,
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

		// var_dump($evaluator_row);
		// die();

		$zone_searched = false;
		$district_row = array();
		$village_row = array();

		if (isset($src_params['kecamatan_id'])) {
			$sql = "SELECT * FROM ref_kecamatan WHERE kecamatan_id='" . $src_params['kecamatan_id'] . "'";
			$district_row = $this->dao->execute(0, $sql)->row_array();
			$zone_searched = true;
		}

		if (isset($src_params['kelurahan_id'])) {
			$sql = "SELECT * FROM ref_kelurahan WHERE kelurahan_id='" . $src_params['kelurahan_id'] . "'";
			$village_row = $this->dao->execute(0, $sql)->row_array();
		}

		$rows = $this->get_rows($src_params);
		$date_period = "S.D Tanggal " . indo_date_format(date('Y-m-d'), 'longDate');
		if (isset($src_params['tgl_pendaftaran_awal']) && isset($src_params['tgl_pendaftaran_akhir'])) {
			$date_period = "Periode Tanggal " . mix_2Date(us_date_format($src_params['tgl_pendaftaran_awal']), us_date_format($src_params['tgl_pendaftaran_akhir']));
		} else if (isset($src_params['tgl_pendaftaran_awal'])) {
			$date_period = "Periode Tanggal " . mix_2Date(us_date_format($src_params['tgl_pendaftaran_awal']), date('Y-m-d'));
		} else if (isset($src_params['tgl_pendaftaran_akhir'])) {
			$date_period = "S.D Tanggal " . indo_date_format(us_date_format($src_params['tgl_pendaftaran_akhir']), 'longDate');
		}

		$system_params = $this->_ci->database_interactions->get_system_params();
		$data = array(
			'rows' => $rows,
			'print_date' => us_date_format($printAttr_params['print_date']),
			'date_period' => $date_period,
			'system_params' => $system_params,
			'tax_name' => $this->bundle_row['nama_paret'],
			'legalitator_row' => $legalitator_row,
			'evaluator_row' => $evaluator_row,
			'district_row' => $district_row,
			'village_row' => $village_row,
			'zone_searched' => $zone_searched,
		);


		$view_folder = $this->bundle_type . '/' . __CLASS__;

		if ($type == 1) {
			$view_folder .= '/print';
		} else {

			// $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', [215, 330],'orientation'=>'L']);
			// $data['mpdf'] = $mpdf;
			$mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'mpdf']);

			$mpdf->SetMargins(10, 10, 10);
			// $data['mpdf'] = $mpdf;
			$data = array(
				'rows' => $rows,
				'print_date' => us_date_format($printAttr_params['print_date']),
				'date_period' => $date_period,
				'system_params' => $system_params,
				'tax_name' => $this->bundle_row['nama_paret'],
				'legalitator_row' => $legalitator_row,
				'evaluator_row' => $evaluator_row,
				'district_row' => $district_row,
				'village_row' => $village_row,
				'zone_searched' => $zone_searched,
				'mpdf' => $mpdf,
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

		$cond = " a.pajak_id='" . $this->bundle_id . "'";

		if (isset($src_params['golongan'])) {
			$cond .= (!empty($cond) ? " AND " : "") . " golongan='" . $src_params['golongan'] . "'";
		}

		if (isset($src_params['kegus_id'])) {
			$cond .= (!empty($cond) ? " AND " : "") . " kegus_id='" . $src_params['kegus_id'] . "'";
		}

		if (isset($src_params['kecamatan_id'])) {
			$cond .= (!empty($cond) ? " AND " : "") . " kecamatan_id='" . $src_params['kecamatan_id'] . "'";
		}

		if (isset($src_params['kelurahan_id'])) {
			$cond .= (!empty($cond) ? " AND " : "") . " kelurahan_id='" . $src_params['kelurahan_id'] . "'";
		}

		if (isset($src_params['tgl_pendaftaran_awal']) && isset($src_params['tgl_pendaftaran_akhir'])) {
			$cond .= (!empty($cond) ? " AND " : "") . " tgl_pendaftaran BETWEEN '" . us_date_format($src_params['tgl_pendaftaran_awal']) . "' AND '" . us_date_format($src_params['tgl_pendaftaran_akhir']) . "'";
		} else if (isset($src_params['tgl_pendaftaran_awal'])) {
			$cond .= (!empty($cond) ? " AND " : "") . " tgl_pendaftaran >= '" . us_date_format($src_params['tgl_pendaftaran_awal']) . "'";
		} else if (isset($src_params['tgl_pendaftaran_akhir'])) {
			$cond .= (!empty($cond) ? " AND " : "") . " tgl_pendaftaran <= '" . us_date_format($src_params['tgl_pendaftaran_akhir']) . "'";
		}

		$sql .= (!empty($cond) ? " WHERE " : "") . $cond;

		return $this->dao->execute(0, $sql)->result_array();
	}
}
