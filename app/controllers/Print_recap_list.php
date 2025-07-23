<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'controllers' . DIRECTORY_SEPARATOR . 'Item_bundle_parent.php';

class print_recap_list extends item_bundle_parent
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

		$sql = "SELECT * FROM ref_jenis_spt WHERE ref_jenspt_id IN (1,3,8,11) ORDER BY ref_jenspt_id ASC";

		$spt_type_rows = $this->dao->execute(0, $sql)->result_array();

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

	function report_controller()
	{

		$menu = $_POST['menu'];
		$search_type = $_POST['search_type'];
		$report_type = $_POST['report_type'];

		$src_params = $this->collect_input_params($_POST, 'src' . $search_type, false);
		$printAttr_params = $this->collect_input_params($_POST, 'printAttr' . $search_type, false);

		$urlstring_params = $this->generate_urlstring_params(array_merge($src_params, $printAttr_params));
		$method = "";

		switch ($report_type) {
			case '1':
				$method = "_print";
				break;
			case '3':
				$method = "excel";
				break;
		}

		$this->menu = $menu;

		$urlstring_params .= (!empty($urlstring_params) ? "&" : "?") . "search_type=" . $search_type;

		echo "<script type='text/javascript'>

				window.open('" . base_url() . "bundle/" . $this->bundle_type . "/" . $this->bundle_item_type . "/" . $menu . "/" . $method . $urlstring_params . "');

			</script>";
	}

	function _print()
	{

		$this->show_report(1);
	}

	function excel()
	{
		$this->show_report(3);
	}

	function show_report($report_type)
	{

		$search_type = $_GET['search_type'];
		$src_params = $this->collect_input_params($_GET, 'src' . $search_type);

		$rows1 = $this->get_rows1($src_params);
		if ($search_type == '1') {
			$rows2 = $this->get_rows2($rows1, $src_params);
		} else {
			$rows2 = $this->get_rows3($rows1, $src_params);
		}

		// var_dump($rows2);
		// die();

		$system_params = $this->_ci->database_interactions->get_system_params();

		$determination_name = $this->_ci->database_interactions->get_arbitrary_data('ref_jenis_spt', 'singkatan', array('ref_jenspt_id' => $src_params['jenis_spt_id']));

		$data = array(
			'rows1' => $rows1,
			'rows2' => $rows2,
			'system_params' => $system_params,
			'tax_name' => $this->bundle_row['nama_paret'],
			'determination_name' => $determination_name,
			'determination_id' => $src_params['jenis_spt_id'],
			'search_type' => $search_type,
			'dao' => $this->dao,
		);

		if ($search_type == '1') {
			$data['month'] = $src_params['masa_pajak'];
			$data['year'] = $src_params['tahun_pajak'];
		} else {

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

			$data['periode_desc'] = $periode_desc;
		}
		$view_folder = $this->bundle_type . '/' . __CLASS__;

		if ($report_type == 1) {
			$view_folder .= '/print' . $search_type;
		} else if ($report_type == 2) {
			$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', [215, 330], 'orientation' => 'L']);
			$data['mpdf'] = $mpdf;
			$view_folder .= '/pdf' . $search_type;
		} else {
			$view_folder .= '/excel' . $search_type;
		}

		$this->_ci->load->view($view_folder, $data);
	}

	function get_rows1($src_params)
	{
		$tbl_name = "ref_kecamatan";
		$pk = "kecamatan_id";
		$sql = "SELECT kecamatan_id,nama_kecamatan FROM ref_kecamatan";

		if (isset($src_params['kecamatan_id'])) {
			$sql .= " WHERE kecamatan_id='" . $src_params['kecamatan_id'] . "'";
		}

		return $this->dao->execute(0, $sql)->result_array();
	}

	function get_rows2($district_rows, $src_params)
	{

		$res = __CLASS__ . '_resources';
		require_once APPPATH . 'libraries' . DIRECTORY_SEPARATOR . 'system_resources' . DIRECTORY_SEPARATOR . $res . '.php';

		$tbl_name = $res::$_TBL_NAME;
		$pk = $res::$_PK;
		// $sql = $res::$_SQL_LIST;
		$sql = "SELECT spt_id,npwpd,wp_wr_detil_id,nama_wp,alamat,kelurahan,kecamatan,nama_pemilik,alamat_pemilik,
				to_char(masa_pajak1,'mm') bulan_pajak, to_char(tgl_proses,'dd-mm-yyyy') as tgl_proses,
				nomor_spt,nilai_terkena_pajak,pajak FROM v_spt";

		$sql .= " WHERE pajak_id='" . $this->bundle_id . "'";

		if (isset($src_params['masa_pajak'])) {
			$sql .= " AND to_char(masa_pajak1,'yyyy-mm')='" . $src_params['tahun_pajak'] . "-0" . $src_params['masa_pajak'] . "'";
		}

		if (isset($src_params['jenis_spt_id'])) {
			$sql .= " AND jenis_spt_id='" . $src_params['jenis_spt_id'] . "'";
		}

		$result = array();
		foreach ($district_rows as $row1) {
			$_sql = $sql . " AND kecamatan_id='" . $row1['kecamatan_id'] . "'";

			$row2 = $this->dao->execute(0, $_sql)->result_array();
			$result[$row1['kecamatan_id']] = $row2;
		}

		return $result;
	}

	function get_rows3($district_rows, $src_params)
	{
		$tbl_name = "transaksi_pajak";
		$pk = "transaksi_id";
		$sql = "SELECT a.no_urut_sts,to_char(a.tgl_bayar,'dd/mm/yyyy') as tgl_bayar,a.total_bayar,
					to_char(b.tgl_proses,'dd/mm/yyyy') as tgl_proses,b.nomor_spt,b.nilai_terkena_pajak,b.pajak,
					b.nama_wp,b.alamat,b.npwpd,to_char(b.masa_pajak1,'mm') as bulan_pajak FROM transaksi_pajak as a 					
					LEFT JOIN v_spt as b ON (a.spt_id=b.spt_id) ";

		$sql .= " WHERE a.pajak_id='" . $this->bundle_id . "'";

		if (isset($src_params['tgl_bayar_awal']) && isset($src_params['tgl_bayar_akhir'])) {
			$sql .= " AND tgl_bayar BETWEEN '" . us_date_format($src_params['tgl_bayar_awal']) . "' AND '" . us_date_format($src_params['tgl_bayar_akhir']) . "'";
		} else if (isset($src_params['tgl_bayar_awal'])) {
			$sql .= " AND tgl_bayar >= '" . us_date_format($src_params['tgl_bayar_awal']) . "'";
		} else if (isset($src_params['tgl_bayar_akhir'])) {
			$sql .= " AND tgl_bayar <= '" . us_date_format($src_params['tgl_bayar_akhir']) . "'";
		}

		if (isset($src_params['jenis_spt_id'])) {
			$sql .= " AND a.jenis_spt_id='" . $src_params['jenis_spt_id'] . "'";
		}

		$result = array();
		foreach ($district_rows as $row1) {
			$_sql = $sql . " AND b.kecamatan_id='" . $row1['kecamatan_id'] . "'";

			$row2 = $this->dao->execute(0, $_sql)->result_array();
			$result[$row1['kecamatan_id']] = $row2;
		}

		return $result;
	}
}
