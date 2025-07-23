<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'controllers' . DIRECTORY_SEPARATOR . 'Item_bundle_parent.php';

class print_taxpayer_book extends item_bundle_parent
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

		$main_data = array(
			'bundle_row' => $this->bundle_row,
			'district_rows' => $district_rows,
			'official_rows' => $official_rows,
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

		$rows = $this->get_rows($src_params);

		$taxpayer_row = $this->get_taxpayer_row($src_params['wp_wr_detil']);

		$system_params = $this->_ci->database_interactions->get_system_params();
		$data = array(
			'rows' => $rows,
			'system_params' => $system_params,
			'taxpayer_row' => $taxpayer_row,
			'tax_year' => $src_params['tahun_pajak'],
			'print_date' => $printAttr_params['print_date'],
			'tax_name' => $this->bundle_row['nama_paret'],
			'dao' => $this->dao,
		);

		$view_folder = $this->bundle_type . '/' . __CLASS__;

		if ($type == 1) {
			$view_folder .= '/print';
		} else if ($type == 2) {
			// $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', [215, 330],'orientation'=>'P']);
			$mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'mpdf']);

			$mpdf->SetMargins(10, 10, 10);
			// $data['mpdf'] = $mpdf;
			$data = array(
				'rows' => $rows,
				'system_params' => $system_params,
				'taxpayer_row' => $taxpayer_row,
				'tax_year' => $src_params['tahun_pajak'],
				'print_date' => $printAttr_params['print_date'],
				'tax_name' => $this->bundle_row['nama_paret'],
				'dao' => $this->dao,
				'mpdf' => $mpdf
			);
			$view_folder .= '/pdf';
		} else if ($type == 3) {
			$view_folder .= '/excel';
		}

		$this->_ci->load->view($view_folder, $data);
	}

	function get_taxpayer_row($wp_wr_detil)
	{

		$sql = "SELECT a.nama_wp,a.alamat,a.npwprd,a.kelurahan,a.kecamatan,a.jenis_spt_id,a.jenis_pemungutan,b.singkatan as singkatan_spt 
					FROM v_objek_pajak as a LEFT JOIN ref_jenis_spt as b ON (a.jenis_spt_id=b.ref_jenspt_id) 
					WHERE a.wp_wr_detil_id='" . $wp_wr_detil . "'";
		$row = $this->dao->execute(0, $sql)->row_array();
		return $row;
	}

	function get_rows($src_params)
	{

		$res = __CLASS__ . '_resources';
		require_once APPPATH . 'libraries' . DIRECTORY_SEPARATOR . 'system_resources' . DIRECTORY_SEPARATOR . $res . '.php';

		$tbl_name = $res::$_TBL_NAME;
		$pk = $res::$_PK;
		$sql = $res::$_SQL_LIST;

		$sql .= " WHERE pajak_id='" . $this->bundle_id . "'";

		if (isset($src_params['wp_wr_detil'])) {
			$sql .= " AND wp_wr_detil_id='" . $src_params['wp_wr_detil'] . "'";
		}
		if (isset($src_params['tahun_pajak'])) {
			$sql .= " AND tahun_pajak='" . $src_params['tahun_pajak'] . "'";
		}

		if ($this->bundle_id == '7') {
			$sql .= " AND status_ketetapan = '1'";
		}

		$sql .= " ORDER BY a.masa_pajak1 ASC";
		
		return $this->dao->execute(0, $sql)->result_array();
	}
}
