<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'controllers' . DIRECTORY_SEPARATOR . 'Item_bundle_parent.php';

class print_sts extends item_bundle_parent
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
			'kegus' => $kegus
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

		$sql = "SELECT * FROM v_spt as a 
					LEFT JOIN (SELECT x.transaksi_id,x.spt_id,TO_CHAR(x.tgl_jatuh_tempo,'yyyy-mm-dd') as tgl_jatuh_tempo,
								TO_CHAR(x.tgl_bayar,'yyyy-mm-dd') as tgl_bayar,x.pokok_pajak,x.denda,x.total_bayar,x.no_urut_sts,y.loket_pembayaran,
								y.no_rekening FROM transaksi_pajak as x 
							   LEFT JOIN ref_loket_pembayaran as y ON (x.loket_pembayaran_id=y.ref_lokemba_id)) as b ON (a.spt_id=b.spt_id)
					WHERE a.spt_id='" . $id . "'";

		$row = $this->dao->execute(0, $sql)->row_array();

		$sql = "SELECT a.*,b.kode_rekening,b.nama_rekening,b.jenis_rekening FROM 
					transaksi_pajak_detil as a LEFT JOIN v_rekening as b ON (a.rekening_id=b.rekening_id) 
					WHERE a.transaksi_id='" . $row['transaksi_id'] . "' ORDER BY transaksi_detil_id ASC";

		$detail_rows = $this->dao->execute(0, $sql)->result_array();

		$system_params = $this->_ci->database_interactions->get_system_params();

		if ($row['pajak_id'] == '3') {
			$sql = "SELECT b.jenis_reklame,a.nilai_sewa_reklame,a.persen_tarif,a.pajak FROM spt_detil_reklame as a 
						LEFT JOIN ref_jenis_reklame as b ON (a.jenis_reklame_id=b.ref_jenrek_id) 
						WHERE a.spt_id='" . $row['spt_id'] . "'";
			$data['ads_rows'] = $this->dao->execute(0, $sql)->result_array();
		}
		if ($row['pajak_id'] == '5') {
			$sql = "SELECT * FROM spt_detil_penerangan_jalan WHERE spt_id='" . $row['spt_id'] . "'";
			$data['lighting_row'] = $this->dao->execute(0, $sql)->row_array();
		}
		if ($row['pajak_id'] == '6') {
			$sql = "SELECT a.volume,a.tarif_dasar,a.nilai_jual,b.jenis_mblb FROM spt_detil_mblb as a 
						LEFT JOIN ref_jenis_mblb as b ON (a.mblb_id=b.ref_mblb_id) 
						WHERE a.spt_id='" . $row['spt_id'] . "'";

			$data['mblb_rows'] = $this->dao->execute(0, $sql)->result_array();
		}

		$data['row'] = $row;
		$data['bundle_row'] = $this->bundle_row;
		$data['chief_official_row'] = $this->_ci->database_interactions->get_official('chief');
		$data['treasurer_official_row'] = $this->_ci->database_interactions->get_official('treasurer');
		$data['division1_official_row'] = $this->_ci->database_interactions->get_official('division1');
		$data['detail_rows'] = $detail_rows;
		$data['system_params'] = $system_params;

		$view_folder = 'taxes/' . $this->menu;
		$this->_ci->load->view($view_folder . '/print', $data);
	}

	function pdf()
	{

		$id = $_GET['id'];

		$sql = "SELECT * FROM v_spt as a 
					LEFT JOIN (SELECT x.transaksi_id,x.spt_id,TO_CHAR(x.tgl_jatuh_tempo,'yyyy-mm-dd') as tgl_jatuh_tempo,
								TO_CHAR(x.tgl_bayar,'yyyy-mm-dd') as tgl_bayar,x.pokok_pajak,x.denda,x.total_bayar,y.loket_pembayaran,
								y.no_rekening FROM transaksi_pajak as x 
							   LEFT JOIN ref_loket_pembayaran as y ON (x.loket_pembayaran_id=y.ref_lokemba_id)) as b ON (a.spt_id=b.spt_id)
					WHERE a.spt_id='" . $id . "'";

		$row = $this->dao->execute(0, $sql)->row_array();

		$sql = "SELECT a.*,b.kode_rekening,b.nama_rekening,b.jenis_rekening FROM 
					transaksi_pajak_detil as a LEFT JOIN v_rekening as b ON (a.rekening_id=b.rekening_id) 
					WHERE a.transaksi_id='" . $row['transaksi_id'] . "' ORDER BY transaksi_detil_id ASC";

		$detail_rows = $this->dao->execute(0, $sql)->result_array();

		$system_params = $this->_ci->database_interactions->get_system_params();

		if ($row['pajak_id'] == '3') {
			$sql = "SELECT b.jenis_reklame,a.nilai_sewa_reklame,a.persen_tarif,a.pajak FROM spt_detil_reklame as a 
						LEFT JOIN ref_jenis_reklame as b ON (a.jenis_reklame_id=b.ref_jenrek_id) 
						WHERE a.spt_id='" . $row['spt_id'] . "'";
			$data['ads_rows'] = $this->dao->execute(0, $sql)->result_array();
		}
		if ($row['pajak_id'] == '5') {
			$sql = "SELECT * FROM spt_detil_penerangan_jalan WHERE spt_id='" . $row['spt_id'] . "'";
			$data['lighting_row'] = $this->dao->execute(0, $sql)->row_array();
		}
		if ($row['pajak_id'] == '6') {
			$sql = "SELECT a.volume,a.tarif_dasar,a.nilai_jual,b.jenis_mblb FROM spt_detil_mblb as a 
						LEFT JOIN ref_jenis_mblb as b ON (a.mblb_id=b.ref_mblb_id) 
						WHERE a.spt_id='" . $row['spt_id'] . "'";

			$data['mblb_rows'] = $this->dao->execute(0, $sql)->result_array();
		}

		$data['row'] = $row;
		$data['bundle_row'] = $this->bundle_row;
		$data['chief_official_row'] = $this->_ci->database_interactions->get_official('chief');
		$data['treasurer_official_row'] = $this->_ci->database_interactions->get_official('treasurer');
		$data['division1_official_row'] = $this->_ci->database_interactions->get_official('division1');
		$data['detail_rows'] = $detail_rows;
		$data['system_params'] = $system_params;

		$mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'mpdf']);

		$data = array(
			'row' => $row,
			'bundle_row' => $this->bundle_row,
			'chief_official_row' => $this->_ci->database_interactions->get_official('chief'),
			'treasurer_official_row' => $this->_ci->database_interactions->get_official('treasurer'),
			'division1_official_row' => $this->_ci->database_interactions->get_official('division1'),
			'detail_rows' => $detail_rows,
			'system_params' => $system_params,
			'mpdf' => $mpdf
		);

		$view_folder = $this->bundle_type . '/' . __CLASS__;

		$this->_ci->load->view($view_folder . '/pdf', $data);
	}

	function change_no_sts()
	{
		$transaksi_id = $_POST['id'];
		$no_sts = $_POST['no_sts'];
		if ($no_sts == 'null' || $no_sts == '') {
			echo '<script type="text/JavaScript">alert("Kode sts tidak boleh kosong")</script>';
		}

		$sql_sts = "UPDATE transaksi_pajak SET no_urut_sts ='" . $no_sts . "' WHERE transaksi_id='" . $transaksi_id . "'";

		$this->dao->execute(0, $sql_sts);

		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}
}
