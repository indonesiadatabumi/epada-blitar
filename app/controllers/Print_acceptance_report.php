<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'controllers' . DIRECTORY_SEPARATOR . 'Item_bundle_parent.php';

class print_acceptance_report extends item_bundle_parent
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
		} elseif ($this->bundle_item_type == 'public_lighting') {
			$pajak_id = '14';
		}

		$sql_kegus = "SELECT ref_kegus_id, nama_kegus FROM ref_kegiatan_usaha WHERE pajak_id = '$pajak_id'";

		$kegus = $this->dao->execute(0, $sql_kegus)->result_array();

		$main_data = array(
			'bundle_row' => $this->bundle_row,
			'district_rows' => $district_rows,
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
			case '3':
				$method = "excel";
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

	function excel()
	{

		$this->show_report(3);
	}

	function show_report($type)
	{
		$src_params = $this->collect_input_params($_GET, 'src');
		$printAttr_params = $this->collect_input_params($_GET, 'printAttr');

		$first_periode = date('Y-m-d');
		$last_periode = date('Y-m-d');
		$periode_desc = "";
		if (isset($src_params['tgl_bayar_awal']) && isset($src_params['tgl_bayar_akhir'])) {
			$first_periode = us_date_format($src_params['tgl_bayar_awal']);
			$last_periode = us_date_format($src_params['tgl_bayar_akhir']);
			$periode_desc = "Periode Tanggal " . mix_2Date($first_periode, $last_periode);
		} else if (isset($src_params['tgl_bayar_awal'])) {
			$first_periode = us_date_format($src_params['tgl_bayar_awal']);
			$last_periode = date('Y-m-d');
			$periode_desc = "Periode Tanggal " . mix_2Date($first_periode, $last_periode);
		} else if (isset($src_params['tgl_bayar_akhir'])) {
			$last_periode = indo_date_format(us_date_format($src_params['tgl_bayar_akhir']), 'longDate');
			$periode_desc = "S.D Tanggal " . $last_periode;
		}

		$sql = "SELECT a.nama,a.nip,b.pangkat,c.nama_jabatan FROM pejabat_daerah as a 
					LEFT JOIN ref_gol_ruang as b ON (a.goru_id=b.ref_goru_id) 
					LEFT JOIN ref_jabatan_pejabat_daerah as c ON (a.japeda_id=c.ref_japeda_id)";

		$show_signature = (isset($printAttr_params['show_signature']));
		$legalitator_row = array();

		if (isset($printAttr_params['legalitator'])) {
			$cond = " WHERE pejda_id='" . $printAttr_params['legalitator'] . "'";
			$_sql = $sql . $cond;
			$legalitator_row = $this->dao->execute(0, $_sql)->row_array();
		}


		$rows = $this->get_rows($src_params);
		$tgl_cetak = us_date_format($printAttr_params['print_date']);

		$judul_kegus = array();
		if (isset($src_params['kegus_id'])) {
			$sql_kegus = "SELECT nama_kegus FROM ref_kegiatan_usaha WHERE ref_kegus_id = '" . $src_params['kegus_id'] . "'";
			$judul_kegus = $this->dao->execute(0, $sql_kegus)->row_array();
		}

		$judul_kecamatan = array();
		if (isset($src_params['kecamatan_id'])) {
			$sql_kecamatan = "SELECT nama_kecamatan FROM ref_kecamatan WHERE kecamatan_id = '" . $src_params['kecamatan_id'] . "'";
			$judul_kecamatan = $this->dao->execute(0, $sql_kecamatan)->row_array();
		}

		$treasurer_official_row = $this->_ci->database_interactions->get_official('treasurer');

		$system_params = $this->_ci->database_interactions->get_system_params();

		$data = array(
			'rows' => $rows,
			'tgl_cetak' => $tgl_cetak,
			'judul_kegus' => $judul_kegus,
			'judul_kecamatan' => $judul_kecamatan,
			'system_params' => $system_params,
			'tax_name' => $this->bundle_row['nama_paret'],
			'bundle_id' => $this->bundle_id,
			'periode_desc' => $periode_desc,
			'legalitator_row' => $legalitator_row,
			'show_signature' => $show_signature,
			'treasurer_official_row' => $treasurer_official_row,
		);

		$view_folder = $this->bundle_type . '/' . __CLASS__;

		if ($type == 1) {
			$view_folder .= '/print';
		} else if ($type == 2) {
			// $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', [215, 330],'orientation'=>'L']);
			// $data['mpdf'] = $mpdf;
			$mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'mpdf'], ['mode' => 'utf-8', [215, 330], 'orientation' => 'L']);

			$mpdf->SetMargins(10, 10, 10);

			// $data['mpdf'] = $mpdf;

			$data = array(
				'rows' => $rows,
				'judul_kegus' => $judul_kegus,
				'judul_kecamatan' => $judul_kecamatan,
				'system_params' => $system_params,
				'tax_name' => $this->bundle_row['nama_paret'],
				'periode_desc' => $periode_desc,
				'legalitator_row' => $legalitator_row,
				'show_signature' => $show_signature,
				'treasurer_official_row' => $treasurer_official_row,
				'mpdf' => $mpdf,
			);

			$view_folder .= '/pdf';
		} else {
			$view_folder .= '/excel';
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

		if (isset($src_params['kegus_id'])) {
			$cond .= " AND b.kegus_id='" . $src_params['kegus_id'] . "'";
		}

		if (isset($src_params['kecamatan_id'])) {
			$cond .= " AND b.kecamatan_id='" . $src_params['kecamatan_id'] . "'";
		}

		if (isset($src_params['tgl_bayar_awal']) && isset($src_params['tgl_bayar_akhir'])) {
			$cond .= (!empty($cond) ? " AND " : "") . " tgl_bayar BETWEEN '" . us_date_format($src_params['tgl_bayar_awal']) . "' AND '" . us_date_format($src_params['tgl_bayar_akhir']) . "'";
		} else if (isset($src_params['tgl_bayar_awal'])) {
			$cond .= (!empty($cond) ? " AND " : "") . " tgl_bayar >= '" . us_date_format($src_params['tgl_bayar_awal']) . "'";
		} else if (isset($src_params['tgl_bayar_akhir'])) {
			$cond .= (!empty($cond) ? " AND " : "") . " tgl_bayar <= '" . us_date_format($src_params['tgl_bayar_akhir']) . "'";
		}

		if (isset($src_params['loket_pembayaran_id'])) {
			$cond .= (!empty($cond) ? " AND " : "") . " loket_pembayaran_id='" . $src_params['loket_pembayaran_id'] . "'";
		}

		$cond .= " AND a.total_bayar > '0'";

		$cond .= " ORDER BY tgl_bayar ASC, a.masa_pajak1";

		$sql .= (!empty($cond) ? " WHERE " : "") . $cond;

		return $this->dao->execute(0, $sql)->result_array();
	}
}
