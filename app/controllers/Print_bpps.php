<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'controllers' . DIRECTORY_SEPARATOR . 'Item_bundle_parent.php';

class print_bpps extends item_bundle_parent
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

		$locket_rows = $this->dao->execute(0, "SELECT * FROM ref_loket_pembayaran")->result_array();

		$main_data = array(
			'bundle_row' => $this->bundle_row,
			'locket_rows' => $locket_rows,
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
		$rows = $this->get_rows($src_params);

		$media = "Bendahara Penerimaan dan Bank";
		if (isset($src_params['loket_pembayaran_id'])) {
			switch ($src_params['loket_pembayaran_id']) {
				case '1':
					$media = 'Bendahara Penerimaan';
					break;
				case '2':
					$media = 'Bank';
					break;
				case '3':
					$media = 'QRIS';
					break;
			}
		}

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

		$system_params = $this->_ci->database_interactions->get_system_params();
		$data = array(
			'rows' => $rows,
			'system_params' => $system_params,
			'tax_name' => $this->bundle_row['nama_paret'],
			'media' => $media,
			'periode_desc' => $periode_desc
		);

		$view_folder = $this->bundle_type . '/' . __CLASS__;

		if ($type == 1) {
			$view_folder .= '/print';
		} else if ($type == 2) {
			// $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', [215, 330],'orientation'=>'L']);
			// $data['mpdf'] = $mpdf;
			$mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'mpdf']);

			$mpdf->SetMargins(10, 10, 10);
			$data = array(
				'rows' => $rows,
				'system_params' => $system_params,
				'tax_name' => $this->bundle_row['nama_paret'],
				'media' => $media,
				'periode_desc' => $periode_desc,
				'mpdf' => $mpdf,
			);

			$view_folder .= '/pdf';
		} else {
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

		$sql .= (!empty($cond) ? " WHERE " : "") . $cond;

		$sql .= " ORDER BY tgl_bayar ASC";


		return $this->dao->execute(0, $sql)->result_array();
	}
}
