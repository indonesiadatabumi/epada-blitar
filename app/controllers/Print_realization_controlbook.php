<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'controllers' . DIRECTORY_SEPARATOR . 'Item_bundle_parent.php';

class print_realization_controlbook extends item_bundle_parent
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

		$sql = "SELECT * FROM ref_jenis_spt ORDER BY ref_jenspt_id ASC";
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
		$rows2 = $this->get_rows2($rows1, $src_params);

		$system_params = $this->_ci->database_interactions->get_system_params();

		if ($search_type == '1') {
			$startDate = us_date_format($src_params['masa_pajak1']);
			$endDate = us_date_format($src_params['masa_pajak2']);
		} else {
			$startDate = $src_params['tahun_pajak1'] . '-' . $src_params['masa_pajak1'] . '-01';
			$endDate = $src_params['tahun_pajak2'] . '-' . $src_params['masa_pajak2'] . '-01';
		}
		$diff_tax_periode = get_diff_months($startDate, $endDate);
		// $get_tgl_setor1 = $src_params['tgl_setor1'];
		// $tgl_setor1 = us_date_format($get_tgl_setor1);
		// $get_tgl_setor2 = $src_params['tgl_setor2'];
		// $tgl_setor2 = us_date_format($get_tgl_setor2);
		// $diff_tax_periode = get_diff_months($tgl_setor1, $tgl_setor2);
		$month1 = substr($startDate, 5, -3);
		$year1 = substr($startDate, 0, 4);

		$data = array(
			'rows1' => $rows1,
			'rows2' => $rows2,
			'system_params' => $system_params,
			'tax_name' => $this->bundle_row['nama_paret'],
			'search_type' => $search_type,
			'diff_tax_periode' => $diff_tax_periode,
			// 'month1' => $src_params['masa_pajak1'],
			// 'year1' => $src_params['tahun_pajak1'],
			'month1' => $month1,
			'year1' => $year1,
			'masa_pajak1' => us_date_format($src_params['masa_pajak1']),
			'masa_pajak2' => us_date_format($src_params['masa_pajak2']),
			'determination_type' => $src_params['jenis_spt_id'],
			'dao' => $this->dao,
		);
		$view_folder = $this->bundle_type . '/' . __CLASS__;

		if ($report_type == 1) {
			$view_folder .= '/print' . $search_type;
		} else if ($report_type == 2) {
			$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', [215, 330], 'orientation' => 'L']);
			$data['mpdf'] = $mpdf;
			$view_folder .= '/pdf' . $search_type;
		} else if ($report_type == 3) {
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
		$sql = $res::$_SQL_LIST;

		$sql .= " WHERE pajak_id='" . $this->bundle_id . "'";

		$result = array();
		foreach ($district_rows as $row1) {
			$_sql = $sql . " AND kecamatan_id='" . $row1['kecamatan_id'] . "'";
			if (isset($src_params['kelurahan_id'])) {
				$_sql = $sql . " AND kecamatan_id='" . $row1['kecamatan_id'] . "' AND kelurahan_id='" . $src_params['kelurahan_id'] . "' GROUP BY nama_kelurahan";
			}
			$row2 = $this->dao->execute(0, $_sql)->result_array();
			$result[$row1['kecamatan_id']] = $row2;
		}

		return $result;
	}
}
