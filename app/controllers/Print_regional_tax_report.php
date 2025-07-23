<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'controllers' . DIRECTORY_SEPARATOR . 'Item_bundle_parent.php';

class print_regional_tax_report extends item_bundle_parent
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

		$main_data = array('bundle_row' => $this->bundle_row,);

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

		$urlstring_params .= (!empty($urlstring_params) ? "&" : "?") . "search_type=" . $search_type;

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
		$search_type = $_GET['search_type'];
		$src_params = $this->collect_input_params($_GET, 'src');
		$printAttr_params = $this->collect_input_params($_GET, 'printAttr');

		// $rows1 = $this->get_rows1($src_params);
		// $rows2 = $this->get_rows2($rows1, $src_params);
		if ($search_type == '1') {
			$rows1 = $this->get_rows1_1($src_params);
			$rows2 = $this->get_rows2_1($rows1, $src_params);
		} else {
			$rows1 = $this->get_rows1_2($src_params);
			$rows2 = $this->get_rows2_2($rows1, $src_params);
		}

		$x_process_date = explode('-', $src_params['tgl_proses']);

		$system_params = $this->_ci->database_interactions->get_system_params();
		if ($search_type == 1) {
			$periode_report = get_monthName($x_process_date[1]) . " " . $x_process_date[2];
			$curr_week = week_in_month($x_process_date[2] . '-' . $x_process_date[1] . '-' . $x_process_date[0]);
		} else {
			$periode_report = get_monthName($src_params['tgl_proses']);
		}

		$view_folder = $this->bundle_type . '/' . __CLASS__;

		if ($type == 1 && $search_type == '1') {
			$data = array(
				'rows1' => $rows1,
				'rows2' => $rows2,
				'system_params' => $system_params,
				'rows1' => $rows1,
				'rows2' => $rows2,
				'tax_year' => $src_params['tahun_pajak'],
				'tax_name' => $this->bundle_row['nama_paret'],
				'print_date' => $printAttr_params['print_date'],
				'process_date' => indo_date_format($x_process_date[2] . '-' . $x_process_date[1] . '-' . $x_process_date[0], 'longDate'),
				'periode_report' => $periode_report,
				'curr_week' => $curr_week,
				'dao' => $this->dao,
			);
			$view_folder .= '/print';
		} else if ($type == 1 && $search_type == '2') {
			$data = array(
				'rows1' => $rows1,
				'rows2' => $rows2,
				'system_params' => $system_params,
				'rows1' => $rows1,
				'rows2' => $rows2,
				'tax_year' => $src_params['tahun_pajak'],
				'tax_name' => $this->bundle_row['nama_paret'],
				'print_date' => $printAttr_params['print_date'],
				'periode_report' => $periode_report,
				'dao' => $this->dao,
			);
			$view_folder .= '/print2';
		} else if ($type == 2 && $search_type == '1') {
			// $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', [215, 330],'orientation'=>'P']);
			$mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'mpdf']);

			$mpdf->SetMargins(10, 10, 10);
			// $data['mpdf'] = $mpdf;
			$data = array(
				'rows1' => $rows1,
				'rows2' => $rows2,
				'system_params' => $system_params,
				'rows1' => $rows1,
				'rows2' => $rows2,
				'tax_year' => $src_params['tahun_pajak'],
				'print_date' => $printAttr_params['print_date'],
				'process_date' => indo_date_format($x_process_date[2] . '-' . $x_process_date[1] . '-' . $x_process_date[0], 'longDate'),
				'periode_report' => $periode_report,
				'curr_week' => $curr_week,
				'dao' => $this->dao,
				'mpdf' => $mpdf
			);
			$view_folder .= '/pdf';
		} else if ($type == 2 && $search_type == '2') {
			// $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', [215, 330],'orientation'=>'P']);
			$mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'mpdf']);

			$mpdf->SetMargins(10, 10, 10);
			// $data['mpdf'] = $mpdf;
			$data = array(
				'rows1' => $rows1,
				'rows2' => $rows2,
				'system_params' => $system_params,
				'rows1' => $rows1,
				'rows2' => $rows2,
				'tax_year' => $src_params['tahun_pajak'],
				'print_date' => $printAttr_params['print_date'],
				'periode_report' => $periode_report,
				'dao' => $this->dao,
				'mpdf' => $mpdf
			);
			$view_folder .= '/pdf2';
		} else if ($type == 3 && $search_type == '1') {
			$data = array(
				'rows1' => $rows1,
				'rows2' => $rows2,
				'system_params' => $system_params,
				'rows1' => $rows1,
				'rows2' => $rows2,
				'tax_year' => $src_params['tahun_pajak'],
				'tax_name' => $this->bundle_row['nama_paret'],
				'print_date' => $printAttr_params['print_date'],
				'process_date' => indo_date_format($x_process_date[2] . '-' . $x_process_date[1] . '-' . $x_process_date[0], 'longDate'),
				'periode_report' => $periode_report,
				'curr_week' => $curr_week,
				'dao' => $this->dao,
			);
			$view_folder .= '/excel';
		} elseif ($type == 3 && $search_type == '2') {
			$data = array(
				'rows1' => $rows1,
				'rows2' => $rows2,
				'system_params' => $system_params,
				'rows1' => $rows1,
				'rows2' => $rows2,
				'tax_year' => $src_params['tahun_pajak'],
				'tax_name' => $this->bundle_row['nama_paret'],
				'print_date' => $printAttr_params['print_date'],
				'periode_report' => $periode_report,
				'dao' => $this->dao,
			);
			$view_folder .= '/excel2';
		}

		$this->_ci->load->view($view_folder, $data);
	}


	function get_rows1_1($src_params)
	{

		$tax_year = $src_params['tahun_pajak'];
		$process_date = $src_params['tgl_proses'];

		$sql = "SELECT a.bundel_id as pajak_id,a.nama_paret as nama_pajak,
					a.kode_rekening,b.tot_pajak,COALESCE(c.tot_realisasi1,'0') as tot_realisasi1,COALESCE(d.tot_realisasi2,'0') as tot_realisasi2
					FROM bundel_pajak_retribusi as a 
					LEFT JOIN (SELECT SUM(pajak) as tot_pajak,pajak_id FROM v_spt 
								WHERE tahun_pajak='" . $tax_year . "' GROUP BY pajak_id) as b ON (a.bundel_id=b.pajak_id) 
					LEFT JOIN (SELECT SUM(total_bayar) as tot_realisasi1,pajak_id 
								FROM transaksi_pajak WHERE 
								(tgl_bayar<=to_date('" . $process_date . "','dd-mm-yyyy')-cast(extract(dow from to_date('" . $process_date . "','dd-mm-yyyy')) as int)) GROUP BY pajak_id) as c ON (a.bundel_id=c.pajak_id) 
					LEFT JOIN (SELECT SUM(total_bayar) as tot_realisasi2,pajak_id 
								FROM transaksi_pajak WHERE 
								(tgl_bayar BETWEEN 
									to_date('" . $process_date . "','dd-mm-yyyy')-cast(extract(dow from to_date('" . $process_date . "','dd-mm-yyyy')) as int) 
									AND to_date('" . $process_date . "','dd-mm-yyyy')) GROUP BY pajak_id) as d ON (a.bundel_id=d.pajak_id) 
					WHERE (a.bundel_id BETWEEN 1 AND 11) AND a.aktif=TRUE ORDER BY a.bundel_id ASC";

		return $this->dao->execute(0, $sql)->result_array();
	}

	function get_rows2_1($tax_rows, $src_params)
	{

		$tax_year = $src_params['tahun_pajak'];
		$process_date = $src_params['tgl_proses'];

		$sql = "SELECT a.rekening_id,a.nama_rekening,a.kode_rekening,
					b.tot_pajak,COALESCE(c.tot_realisasi1,'0') as tot_realisasi1,COALESCE(d.tot_realisasi2,'0') as tot_realisasi2
					FROM v_rekening as a 
					LEFT JOIN (SELECT SUM(jumlah_pajak) as tot_pajak,rekening_id 
						FROM transaksi_pajak_detil WHERE tahun_pajak='" . $tax_year . "' GROUP BY rekening_id) as b ON (a.rekening_id=b.rekening_id) 
					LEFT JOIN (SELECT SUM(jumlah_pajak) as tot_realisasi1,rekening_id FROM transaksi_pajak_detil 
								WHERE
								(tgl_bayar<=to_date('" . $process_date . "','dd-mm-yyyy')-cast(extract(dow from to_date('" . $process_date . "','dd-mm-yyyy')) as int))  GROUP BY rekening_id) as c ON (a.rekening_id=c.rekening_id) 
					LEFT JOIN (SELECT SUM(jumlah_pajak) as tot_realisasi2,rekening_id FROM transaksi_pajak_detil 
								WHERE
								(tgl_bayar BETWEEN to_date('" . $process_date . "','dd-mm-yyyy')-cast(extract(dow from to_date('" . $process_date . "','dd-mm-yyyy')) as int) 
									AND to_date('" . $process_date . "','dd-mm-yyyy')) GROUP BY rekening_id) as d ON (a.rekening_id=d.rekening_id) 
					WHERE a.jenis_rekening='A' ";

		$result = array();
		foreach ($tax_rows as $row1) {
			$_sql = $sql . " AND pajak_id='" . $row1['pajak_id'] . "'";
			$row2 = $this->dao->execute(0, $_sql)->result_array();
			$result[$row1['pajak_id']] = $row2;
		}

		return $result;
	}

	function get_rows1_2($src_params)
	{

		$tax_year = $src_params['tahun_pajak'];
		$process_date = $src_params['tgl_proses'];
		if ($process_date <= '9') {
			$process_date = '0' . $process_date;
		}

		$sql = "SELECT a.bundel_id as pajak_id,a.nama_paret as nama_pajak,
					a.kode_rekening,b.tot_pajak,COALESCE(c.tot_realisasi1,'0') as tot_realisasi1,COALESCE(d.tot_realisasi2,'0') as tot_realisasi2
					FROM bundel_pajak_retribusi as a 
					LEFT JOIN (SELECT SUM(pajak) as tot_pajak,pajak_id FROM v_spt 
								WHERE tahun_pajak='" . $tax_year . "' GROUP BY pajak_id) as b ON (a.bundel_id=b.pajak_id) 
					LEFT JOIN (SELECT SUM(total_bayar) as tot_realisasi1,pajak_id 
								FROM transaksi_pajak WHERE 
								(to_char(tgl_bayar, 'mm-yyyy') < '" . $process_date . "-" . $tax_year . "') GROUP BY pajak_id) as c ON (a.bundel_id=c.pajak_id) 
					LEFT JOIN (SELECT SUM(total_bayar) as tot_realisasi2,pajak_id 
								FROM transaksi_pajak WHERE 
								(to_char(tgl_bayar, 'mm-yyyy') = '" . $process_date . "-" . $tax_year . "') GROUP BY pajak_id) as d ON (a.bundel_id=d.pajak_id) 
					WHERE (a.bundel_id BETWEEN 1 AND 11) AND a.aktif=TRUE ORDER BY a.bundel_id ASC";

		return $this->dao->execute(0, $sql)->result_array();
	}

	function get_rows2_2($tax_rows, $src_params)
	{

		$tax_year = $src_params['tahun_pajak'];
		$process_date = $src_params['tgl_proses'];
		if ($process_date <= '9') {
			$process_date = '0' . $process_date;
		}

		$sql = "SELECT a.rekening_id,a.nama_rekening,a.kode_rekening,
					b.tot_pajak,COALESCE(c.tot_realisasi1,'0') as tot_realisasi1,COALESCE(d.tot_realisasi2,'0') as tot_realisasi2
					FROM v_rekening as a 
					LEFT JOIN (SELECT SUM(jumlah_pajak) as tot_pajak,rekening_id 
						FROM transaksi_pajak_detil WHERE tahun_pajak='" . $tax_year . "' GROUP BY rekening_id) as b ON (a.rekening_id=b.rekening_id) 
					LEFT JOIN (SELECT SUM(jumlah_pajak) as tot_realisasi1,rekening_id FROM transaksi_pajak_detil 
								WHERE
								(to_char(tgl_bayar, 'mm-yyyy') < '" . $process_date . "-" . $tax_year . "')  GROUP BY rekening_id) as c ON (a.rekening_id=c.rekening_id) 
					LEFT JOIN (SELECT SUM(jumlah_pajak) as tot_realisasi2,rekening_id FROM transaksi_pajak_detil 
								WHERE
								(to_char(tgl_bayar, 'mm-yyyy') = '" . $process_date . "-" . $tax_year . "') GROUP BY rekening_id) as d ON (a.rekening_id=d.rekening_id) 
					WHERE a.jenis_rekening='A' ";

		$result = array();
		foreach ($tax_rows as $row1) {
			$_sql = $sql . " AND pajak_id='" . $row1['pajak_id'] . "'";
			$row2 = $this->dao->execute(0, $_sql)->result_array();
			$result[$row1['pajak_id']] = $row2;
		}

		return $result;
	}
}
