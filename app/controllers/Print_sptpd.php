<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'controllers' . DIRECTORY_SEPARATOR . 'Item_bundle_parent.php';

class print_sptpd extends item_bundle_parent
{


	function __construct($bundle_type, $bundle_item_type, $menu)
	{

		//bundle_type => taxes,duties
		//bundle_item_type => hotel,restaurant,entertainment,etc
		//menu => record_taxpayer1,record_taxpayer2,etc			
		parent::__construct($bundle_type, $bundle_item_type, $menu, __CLASS__);

		$this->n_days_year = 365;
		$this->n_days_month = 30;
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

	function _print()
	{

		$id = $_GET['id'];

		$jenis_pajak = $this->bundle_id;
		$sql_kode_pajak = "SELECT b.rek_bank FROM bundel_pajak_retribusi AS a
							LEFT JOIN tbl_ref_rekening AS b ON a.kode_pajak=b.rek_epada
							WHERE a.bundel_id = " . $jenis_pajak . "";
		$kode_pajak = $this->dao->execute(0, $sql_kode_pajak)->row_array();

		$sql = "SELECT a.*, b.*, c.ijin_usaha FROM v_spt as a 
				LEFT JOIN wp_wr_detil as b on (a.wp_wr_detil_id=b.wp_wr_detil_id)
				LEFT JOIN wp_wr as c on (a.wp_wr_id=c.wp_wr_id)
				WHERE a.spt_id='" . $id . "' ";

		$row = $this->dao->execute(0, $sql)->row_array();
		$get_tgl_cetak = $_GET['tgl_cetak'];
		$tgl_cetak = us_date_format($get_tgl_cetak);



		// echo "<pre>";
		// print_r($tgl_cetak);
		// die();

		$x = explode('-', $row['masa_pajak1']);
		$tax_month = get_monthName($x[1]);
		$system_params = $this->_ci->database_interactions->get_system_params();

		$business_rows = $this->dao->execute(0, "SELECT ref_kegus_id,nama_kegus FROM ref_kegiatan_usaha WHERE pajak_id='" . $row['pajak_id'] . "'")->result_array();
		// $curr_date = date('Y-m-d');

		if ($row['pajak_id'] == '1') {
			$row2 = $this->dao->execute(0, "SELECT * FROM wp_wr_hotel as a LEFT JOIN v_spt as b ON (a.wp_wr_id=b.wp_wr_id) LEFT JOIN wp_wr as c ON (a.wp_wr_id=c.wp_wr_id) where spt_id='" . $id . "'")->row_array();
			$row['jumlah_kamar'] = $row2['jumlah_kamar'];
		}

		if ($row['pajak_id'] == '2') {
			$row2 = $this->dao->execute(0, "SELECT * FROM wp_wr_restoran as a LEFT JOIN v_spt as b ON (a.wp_wr_id=b.wp_wr_id) LEFT JOIN wp_wr as c ON (a.wp_wr_id=c.wp_wr_id)where spt_id='" . $id . "'")->row_array();
			$row['jumlah_meja'] = $row2['jumlah_meja'];
			$row['jumlah_kursi'] = $row2['jumlah_kursi'];
			$row['ijin_usaha'] = $row2['ijin_usaha'];
		}

		if ($row['pajak_id'] == '3') {
			$row2 = $this->dao->execute(0, "SELECT * FROM wp_wr_reklame as a LEFT JOIN v_spt as b ON (a.wp_wr_id=b.wp_wr_id) LEFT JOIN wp_wr as c ON (a.wp_wr_id=c.wp_wr_id) where spt_id='" . $id . "'")->row_array();
		}

		if ($row['pajak_id'] == '4') {
			$row2 = $this->dao->execute(0, "SELECT * FROM wp_wr_hiburan as a LEFT JOIN v_spt as b ON (a.wp_wr_id=b.wp_wr_id) LEFT JOIN wp_wr as c ON (a.wp_wr_id=c.wp_wr_id) where spt_id='" . $id . "'")->row_array();
		}

		if ($row['pajak_id'] == '5') {
			$row2 = $this->dao->execute(0, "SELECT penggunaan_daya,tarif_dasar FROM spt_detil_penerangan_jalan LEFT JOIN wp_wr as c ON (a.wp_wr_id=c.wp_wr_id)WHERE spt_id='" . $id . "'")->row_array();
			$row['penggunaan_daya'] = $row2['penggunaan_daya'];
			$row['tarif_dasar'] = $row2['tarif_dasar'];
		}

		if ($row['pajak_id'] == '11') {
			$row2 = $this->dao->execute(0, "SELECT * FROM wp_wr_parkir as a LEFT JOIN v_spt as b ON (a.wp_wr_id=b.wp_wr_id) LEFT JOIN wp_wr as c ON (a.wp_wr_id=c.wp_wr_id) where spt_id='" . $id . "'")->row_array();
		}

		$data = array('row' => $row, 'kode_pajak' => $kode_pajak, 'tax_month' => $tax_month, 'business_rows' => $business_rows, 'tgl_cetak' => $tgl_cetak, 'system_params' => $system_params);


		if ($row['pajak_id'] == '6') {
			$sql = "SELECT a.volume,a.tarif_dasar,a.nilai_jual,b.jenis_mblb,d.ijin_usaha FROM spt_detil_mblb as a 
						LEFT JOIN ref_jenis_mblb as b ON (a.mblb_id=b.ref_mblb_id) LEFT JOIN v_spt as c ON (a.spt_id=c.spt_id)LEFT JOIN wp_wr as d ON (c.wp_wr_id=d.wp_wr_id)
						WHERE a.spt_id='" . $id . "'";
			$rows2 = $this->dao->execute(0, $sql)->result_array();
			$data['mblb_rows'] = $rows2;
		}

		$view_folder = $this->bundle_type . '/print_sptpd';

		$this->_ci->load->view($view_folder . '/print', $data);
	}

	function _pdf()
	{

		$id = $_GET['id'];

		$sql = "SELECT * FROM v_spt as a LEFT JOIN wp_wr as b on (a.wp_wr_id=b.wp_wr_id)WHERE spt_id='" . $id . "' ";

		$row = $this->dao->execute(0, $sql)->row_array();


		// echo "<pre>";
		// print_r($row);
		// die();

		$x = explode('-', $row['masa_pajak1']);
		$tax_month = get_monthName($x[1]);
		$system_params = $this->_ci->database_interactions->get_system_params();

		$business_rows = $this->dao->execute(0, "SELECT ref_kegus_id,nama_kegus FROM ref_kegiatan_usaha WHERE pajak_id='" . $row['pajak_id'] . "'")->result_array();
		$curr_date = date('Y-m-d');

		if ($row['pajak_id'] == '1') {
			$row2 = $this->dao->execute(0, "SELECT * FROM wp_wr_hotel as a LEFT JOIN v_spt as b ON (a.wp_wr_id=b.wp_wr_id) where spt_id='" . $id . "'")->row_array();
			$row['jumlah_kamar'] = $row2['jumlah_kamar'];
		}

		if ($row['pajak_id'] == '2') {
			$row2 = $this->dao->execute(0, "SELECT * FROM wp_wr_restoran as a LEFT JOIN v_spt as b ON (a.wp_wr_id=b.wp_wr_id) where spt_id='" . $id . "'")->row_array();
			$row['jumlah_meja'] = $row2['jumlah_meja'];
			$row['jumlah_kursi'] = $row2['jumlah_kursi'];
		}

		if ($row['pajak_id'] == '3') {
			$row2 = $this->dao->execute(0, "SELECT * FROM wp_wr_reklame as a LEFT JOIN v_spt as b ON (a.wp_wr_id=b.wp_wr_id) where spt_id='" . $id . "'")->row_array();
		}

		if ($row['pajak_id'] == '4') {
			$row2 = $this->dao->execute(0, "SELECT * FROM wp_wr_hiburan as a LEFT JOIN v_spt as b ON (a.wp_wr_id=b.wp_wr_id) where spt_id='" . $id . "'")->row_array();
			$row['jumlah_meja'] = $row2['jumlah_meja'];
			$row['jumlah_kursi'] = $row2['jumlah_kursi'];
		}

		if ($row['pajak_id'] == '5') {
			$row2 = $this->dao->execute(0, "SELECT penggunaan_daya,tarif_dasar FROM spt_detil_penerangan_jalan WHERE spt_id='" . $id . "'")->row_array();
			$row['penggunaan_daya'] = $row2['penggunaan_daya'];
			$row['tarif_dasar'] = $row2['tarif_dasar'];
		}

		if ($row['pajak_id'] == '7') {
			$row2 = $this->dao->execute(0, "SELECT * FROM wp_wr_parkir as a LEFT JOIN v_spt as b ON (a.wp_wr_id=b.wp_wr_id) where spt_id='" . $id . "'")->row_array();
			$row['jumlah_meja'] = $row2['jumlah_meja'];
			$row['jumlah_kursi'] = $row2['jumlah_kursi'];
		}

		// $data = array('row'=>$row,'tax_month'=>$tax_month,'business_rows'=>$business_rows,'curr_date'=>$curr_date,'system_params'=>$system_params);

		if ($row['pajak_id'] == '6') {
			$sql = "SELECT a.volume,a.tarif_dasar,a.nilai_jual,b.jenis_mblb FROM spt_detil_mblb as a 
						LEFT JOIN ref_jenis_mblb as b ON (a.mblb_id=b.ref_mblb_id) 
						WHERE a.spt_id='" . $id . "'";
			$rows2 = $this->dao->execute(0, $sql)->result_array();
			$data['mblb_rows'] = $rows2;
		}

		// var_dump($row2);
		// die();

		$mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'mpdf']);
		// $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', [215, 330],'orientation'=>'P'.'mpdf']);
		// var_dump($mpdf);
		// die();		

		$mpdf->SetMargins(10, 10, 10);

		$data = array('row' => $row, 'tax_month' => $tax_month, 'business_rows' => $business_rows, 'curr_date' => $curr_date, 'system_params' => $system_params, 'mpdf' => $mpdf);

		$view_folder = $this->bundle_type . '/print_sptpd';

		$this->_ci->load->view($view_folder . '/pdf', $data);
	}
}
