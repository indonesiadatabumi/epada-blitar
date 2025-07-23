<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'controllers' . DIRECTORY_SEPARATOR . 'Item_bundle_parent.php';

class print_berita_acara extends item_bundle_parent
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

	private function get_fine($tax, $due_date, $tgl_bayar, $determination_type, $jenis_pajak)
	{

		$diff_month = get_diff_months($due_date, $tgl_bayar, $determination_type);

		if ($jenis_pajak == '6') {
			$fine = assess_fine($tax, $diff_month);
		} else {
			$fine = assess_fine_new($tax, $diff_month);
		}

		return $fine;
	}

	function _print()
	{

		$id = $_GET['id'];

		$jenis_pajak = $this->bundle_id;
		$sql_kode_pajak = "SELECT b.rek_bank FROM bundel_pajak_retribusi AS a
							LEFT JOIN tbl_ref_rekening AS b ON a.kode_pajak=b.rek_epada
							WHERE a.bundel_id = " . $jenis_pajak . "";
		$data['kode_pajak'] = $this->dao->execute(0, $sql_kode_pajak)->row_array();

		$sql = "SELECT a.*, b.nama_pajak, b.nomor_spt, b.npwpd, b.nama_wp, b.alamat, b.nama_pemilik, b.alamat_pemilik, b.persen_tarif, b.nilai_terkena_pajak, b.pajak, b.jenis_spt_id, c.tgl_jatuh_tempo FROM surat_paksa as a 
				LEFT JOIN v_spt2 as b ON (a.srt_paksa_kode_billing=b.kode_billing)
				LEFT JOIN v_penyetoran_sspd as c ON (a.srt_paksa_kode_billing=c.kode_billing)
				WHERE a.srt_paksa_id='" . $id . "'";
		$rows2 = $this->dao->execute(0, $sql)->row_array();

		$data['rows'] = $rows2;

		$denda = $this->get_fine($rows2['pajak'], $rows2['tgl_jatuh_tempo'], date('Y-m-d'), $rows2['jenis_spt_id'], $jenis_pajak);

		$data['denda'] = $denda;

		$data['grand_total'] = $rows2['pajak'] + $denda;

		$view_folder = $this->bundle_type . '/print_berita_acara';

		$this->_ci->load->view($view_folder . '/print', $data);
	}
}
