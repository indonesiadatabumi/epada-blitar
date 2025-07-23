<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'controllers' . DIRECTORY_SEPARATOR . 'Item_bundle_parent.php';

class print_sspd extends item_bundle_parent
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

		$sql = "SELECT * FROM ref_jenis_spt ORDER BY ref_jenspt_id ASC";
		$spt_type_rows = $this->dao->execute(0, $sql)->result_array();

		$sql = "SELECT * FROM pejabat_daerah WHERE japeda_id = '7' ORDER BY pejda_id ASC";
		$ref_bendahara = $this->dao->execute(0, $sql)->result_array();

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
			'district_rows' => $district_rows,
			'official_rows' => $official_rows,
			'spt_type_rows' => $spt_type_rows,
			'ref_bendahara' => $ref_bendahara,
			'kegus' => $kegus,
		);

		// no need to modified
		$data = array(
			'menu_params' => $this->menu_params,
			'main_params' => array_merge($this->main_params, $main_data)
		);

		$this->_ci->public_template->render($this->view_folder . '/index', $data);
	}

	function get_nip()
	{
		$pejda_id = $_POST['nama_bendahara'];
		$sql = "SELECT nip FROM pejabat_daerah WHERE pejda_id='" . $pejda_id . "'";
		$nip_bendahara = $this->dao->execute(0, $sql)->row_array();

		echo json_encode($nip_bendahara);
	}


	function _print()
	{

		$id = $_GET['id'];
		$singkatan_spt = $_GET['singkatan_spt'];
		// $get_tgl_cetak = $_GET['tgl_cetak'];
		// $tgl_cetak = us_date_format($get_tgl_cetak);
		$tgl_cetak = $_GET['tgl_cetak'];
		$id_bendahara = $_GET['nama_bendahara'];
		$nip = $_GET['nip'];
		$no_sspd = $_GET['no_sspd'];

		if ($singkatan_spt == 'SPTPD' || $singkatan_spt == 'SKPD') {
			$sql = "SELECT no_urut_sspd FROM spt WHERE spt_id='" . $id . "'";

			$no_urut_sspd = $this->dao->execute(0, $sql)->row_array();
		} else {
			$sql = "SELECT no_urut_sspd FROM laporan_hasil_pemeriksaan WHERE lhp_id='" . $id . "'";

			$no_urut_sspd = $this->dao->execute(0, $sql)->row_array();
		}

		$sql_bendahara = "SELECT nama FROM pejabat_daerah WHERE pejda_id='" . $id_bendahara . "'";

		$nama_bendahara = $this->dao->execute(0, $sql_bendahara)->row_array();

		if ($no_urut_sspd['no_urut_sspd'] == null) {
			$sql_sspd = "UPDATE spt SET no_urut_sspd ='" . $no_sspd . "' WHERE spt_id='" . $id . "'";

			$row_sspd = $this->dao->execute(0, $sql_sspd);
		}

		if ($singkatan_spt == 'SPTPD' || $singkatan_spt == 'SKPD') {
			$sql = "SELECT a.*, b.tgl_jatuh_tempo, c.denda, d.kompensasi FROM v_spt AS a
				LEFT JOIN penetapan_pajak AS b ON a.spt_id=b.spt_id
				LEFT JOIN transaksi_pajak AS c ON a.kode_billing=c.kode_billing
				LEFT JOIN spt AS d ON a.kode_billing=d.kode_billing
				WHERE a.spt_id='" . $id . "' AND a.singkatan_spt='" . $singkatan_spt . "'";
		} else {
			$sql = "SELECT a.*, b.tgl_jatuh_tempo, c.denda, d.kompensasi FROM v_spt AS a
				LEFT JOIN penetapan_pajak AS b ON a.spt_id=b.lhp_id
				LEFT JOIN transaksi_pajak AS c ON a.kode_billing=c.kode_billing
				LEFT JOIN spt AS d ON a.kode_billing=d.kode_billing
				WHERE a.spt_id='" . $id . "' AND a.singkatan_spt='" . $singkatan_spt . "'";
		}


		$row = $this->dao->execute(0, $sql)->row_array();

		$system_params = $this->_ci->database_interactions->get_system_params();

		$x = explode('-', $row['masa_pajak1']);
		$tax_month = get_monthName($x[1]);
		$system_params = $this->_ci->database_interactions->get_system_params();

		$jenis_pajak = $this->bundle_id;

		$sql_kode_pajak = "SELECT b.rek_bank FROM bundel_pajak_retribusi AS a
							LEFT JOIN tbl_ref_rekening AS b ON a.kode_pajak=b.rek_epada
							WHERE a.bundel_id = " . $jenis_pajak . "";
		$kode_pajak = $this->dao->execute(0, $sql_kode_pajak)->row_array();

		$business_rows = $this->dao->execute(0, "SELECT ref_kegus_id,nama_kegus FROM ref_kegiatan_usaha WHERE pajak_id='" . $row['pajak_id'] . "'")->result_array();
		// $curr_date = date('Y-m-d');

		$data = array(
			'row' => $row,
			'tax_month' => $tax_month,
			'business_rows' => $business_rows,
			'tgl_cetak' => $tgl_cetak,
			'nama_bendahara' => $nama_bendahara,
			'nip' => $nip,
			'no_sspd' => $no_sspd,
			'no_urut_sspd' => $no_urut_sspd,
			'kode_pajak' => $kode_pajak,
			'system_params' => $system_params
		);

		if ($row['jenis_ketetapan'] == 'SPT') {
			$sql = "SELECT * FROM spt_detil
						WHERE spt_id='" . $id . "'";
			$rows2 = $this->dao->execute(0, $sql)->row_array();
			$data['rows2'] = $rows2;
		} elseif ($row['jenis_ketetapan'] == 'LHP') {
			$sql = "SELECT * FROM laporan_hasil_pemeriksaan_detil
						WHERE lhp_id='" . $id . "'";
			$rows2 = $this->dao->execute(0, $sql)->row_array();
			$data['rows2'] = $rows2;
		}

		if ($row['pajak_id'] == '6') {
			$sql = "SELECT a.volume,a.tarif_dasar,a.nilai_jual,b.jenis_mblb,d.ijin_usaha FROM spt_detil_mblb as a 
						LEFT JOIN ref_jenis_mblb as b ON (a.mblb_id=b.ref_mblb_id) LEFT JOIN v_spt as c ON (a.spt_id=c.spt_id)LEFT JOIN wp_wr as d ON (c.wp_wr_id=d.wp_wr_id)
						WHERE a.spt_id='" . $id . "'";
			$rows2 = $this->dao->execute(0, $sql)->result_array();
			$data['mblb_rows'] = $rows2;
		} elseif ($row['pajak_id'] == '7') {
			$sql = "SELECT a.volume,a.tarif_dasar,a.nilai_terkena_pajak,a.persen_tarif,e.* FROM spt_detil as a 
					LEFT JOIN v_spt as c ON (a.spt_id=c.spt_id)LEFT JOIN wp_wr as d ON (c.wp_wr_id=d.wp_wr_id)
					LEFT JOIN spt_detil_abt as e ON a.spt_id=e.spt_id 
					WHERE a.spt_id='" . $id . "'";
			$rows2 = $this->dao->execute(0, $sql)->row_array();
			$data['air_tanah'] = $rows2;
		}

		$view_folder = 'taxes/' . $this->menu;
		$this->_ci->load->view($view_folder . '/print', $data);
	}

	function pdf()
	{

		$id = $_GET['id'];

		$sql = "SELECT * FROM v_spt WHERE spt_id='" . $id . "'";

		$row = $this->dao->execute(0, $sql)->row_array();

		$system_params = $this->_ci->database_interactions->get_system_params();

		$x = explode('-', $row['masa_pajak1']);
		$tax_month = get_monthName($x[1]);
		$system_params = $this->_ci->database_interactions->get_system_params();

		$business_rows = $this->dao->execute(0, "SELECT ref_kegus_id,nama_kegus FROM ref_kegiatan_usaha WHERE pajak_id='" . $row['pajak_id'] . "'")->result_array();
		$curr_date = date('Y-m-d');

		$mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'mpdf'], ['mode' => 'utf-8', [215, 330], 'orientation' => 'L']);

		$mpdf->SetMargins(10, 10, 10);

		// $context = stream_context_create([
		// 	'ssl' => [
		// 		'verify_peer' => false,
		// 		'verify_peer_name' => false
		// 	],
		// ]);
		// $mpdf->setHttpContext($context);

		$data = array(
			'row' => $row,
			'tax_month' => $tax_month,
			'business_rows' => $business_rows,
			'curr_date' => $curr_date,
			'system_params' => $system_params,
			'mpdf' => $mpdf
		);

		$view_folder = 'taxes/' . $this->menu;
		$this->_ci->load->view($view_folder . '/pdf', $data);
	}

	function ganti_nomor()
	{
		$spt_id = $_GET['id'];
		$no_sspd = $_GET['no_sspd'];
		$sql_sspd = "UPDATE spt SET no_urut_sspd ='" . $no_sspd . "' WHERE spt_id='" . $spt_id . "'";

		$this->dao->execute(0, $sql_sspd);

		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}

	function cetak_daftar()
	{
		$tahun_pajak = $_POST['tahun_pajak'];
		$tgl_proses_awal = us_date_format($_POST['tgl_proses_awal']);
		$tgl_proses_akhir = us_date_format($_POST['tgl_proses_akhir']);
		$kegus_id = $_POST['kegus_id'];
		$status_bayar = $_POST['status_bayar'];
		$tgl_cetak = $_POST['tgl_cetak'];
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
		$sql = "SELECT a.spt_id,a.pajak_id,a.nomor_spt,a.tahun_pajak,a.masa_pajak1,a.masa_pajak2,
								a.npwpd,a.nama_wp,a.pajak,a.singkatan_spt,b.tgl_bayar,a.status_bayar,b.total_bayar,c.no_urut_sspd,c.kompensasi
								FROM v_spt AS a 
								LEFT JOIN (SELECT spt_id, tgl_bayar, total_bayar FROM transaksi_pajak) AS b ON a.spt_id=b.spt_id
								LEFT JOIN (SELECT spt_id, no_urut_sspd, kompensasi FROM spt) AS c ON a.spt_id=c.spt_id";
		$where = " WHERE pajak_id=$pajak_id";

		if ($tahun_pajak != '') {
			$where .= " AND tahun_pajak= '$tahun_pajak'";
		}

		if ($tgl_proses_awal != '--') {
			$where .= " AND tgl_proses >= '$tgl_proses_awal'";
		}

		if ($tgl_proses_akhir != '--') {
			$where .= " AND tgl_proses <= '$tgl_proses_akhir'";
		}

		if ($kegus_id != '') {
			$where .= " AND kegus_id = '$kegus_id'";
		}

		if ($status_bayar != '') {
			$where .= " AND status_bayar = '$status_bayar'";
		}

		$where .= " ORDER BY spt_id DESC";

		$response = $this->dao->execute(0, $sql . $where)->result_array();
		$data = [
			'response' => $response,
			'tgl_cetak' => $tgl_cetak
		];
		$view_folder = 'taxes/' . $this->menu;
		$this->_ci->load->view($view_folder . '/cetak_daftar', $data);
	}

	// function cetak_daftar_excel()
	// {
	// 	$tahun_pajak = $_POST['tahun_pajak'];
	// 	$tgl_proses_awal = $_POST['tgl_proses_awal'];
	// 	$tgl_proses_akhir = $_POST['tgl_proses_akhir'];
	// 	$kegus_id = $_POST['kegus_id'];
	// 	$status_bayar = $_POST['status_bayar'];
	// 	$tgl_cetak = $_POST['tgl_cetak'];
	// 	$pajak_id = '';
	// 	if ($this->bundle_item_type == 'hotel') {
	// 		$pajak_id = '1';
	// 	} elseif ($this->bundle_item_type == 'restaurant') {
	// 		$pajak_id = '2';
	// 	} elseif ($this->bundle_item_type == 'entertainment') {
	// 		$pajak_id = '4';
	// 	} elseif ($this->bundle_item_type == 'nonmetallic_mineral_rock') {
	// 		$pajak_id = '6';
	// 	} elseif ($this->bundle_item_type == 'groundwater') {
	// 		$pajak_id = '7';
	// 	} elseif ($this->bundle_item_type == 'parking') {
	// 		$pajak_id = '11';
	// 	}
	// 	$sql = "SELECT a.spt_id,a.pajak_id,a.nomor_spt,a.tahun_pajak,a.masa_pajak1,a.masa_pajak2,
	// 							a.npwpd,a.nama_wp,a.pajak,a.singkatan_spt,b.tgl_bayar,a.status_bayar,b.total_bayar,c.no_urut_sspd,c.kompensasi
	// 							FROM v_spt AS a 
	// 							LEFT JOIN (SELECT spt_id, tgl_bayar, total_bayar FROM transaksi_pajak) AS b ON a.spt_id=b.spt_id
	// 							LEFT JOIN (SELECT spt_id, no_urut_sspd, kompensasi FROM spt) AS c ON a.spt_id=c.spt_id";
	// 	$where = " WHERE pajak_id=$pajak_id AND tahun_pajak='$tahun_pajak' ORDER BY a.spt_id DESC";
	// 	$response = $this->dao->execute(0, $sql . $where)->result_array();
	// 	$data = [
	// 		'response' => $response,
	// 		'tgl_cetak' => $tgl_cetak
	// 	];
	// 	$view_folder = 'taxes/' . $this->menu;
	// 	$this->_ci->load->view($view_folder . '/cetak_daftar_excel', $data);
	// }
}
