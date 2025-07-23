<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'controllers' . DIRECTORY_SEPARATOR . 'Item_bundle_parent.php';

class payment extends CI_Controller
{

	function __construct()
	{
		parent::__construct();

		$this->load->library(array('session', 'DAO', 'database_interactions', 'public_template', 'admin_access_handler'));
		$this->load->model(array('global_model'));
		$this->load->helper(array('url', 'date_helper', 'mix_helper', 'app_common_function_helper'));

		$this->global_model->reinitialize_dao();
		$this->dao = $this->global_model->get_dao();;

		$this->public_template->initialize_dao($this->dao);
		$this->database_interactions->initialize_dao($this->dao);
		$this->admin_access_handler->initialize_dao($this->dao);

		$this->active_controller = __CLASS__;
	}

	function collect_input_params($post, $prefix, $remove_prefix = true, $sql_real_escape_string = false)
	{
		$input_params = array();
		$prefix_key = ($remove_prefix ? "" : $prefix . "-");
		foreach ($post as $key => $val) {
			$x = explode('-', $key);
			if ($x[0] == $prefix and $val != '') {
				$type = (count($x) > 2 ? $x[2] : 'str');
				if ($type == 'str') {
					$_val = $this->security->xss_clean($val);
					if ($sql_real_escape_string)
						$_val = sql_real_escape_string($_val);
				} else if ($type == 'int') {
					$_val = str_replace(',', '', $this->security->xss_clean($val));
				} else if ($type == 'date') {
					$_val = us_date_format($val);
				}
				$input_params[$prefix_key . $x[1]] = $_val;
			}
		}
		return $input_params;
	}

	function delegate_postTomodel($input_params, &$model)
	{
		foreach ($input_params as $key => $val) {
			$model->{'set_' . $key}($val);
		}
		return $model;
	}

	function index()
	{

		$this->admin_access_handler->check_access();

		$bundle_rows = $this->dao->execute(0, "SELECT * FROM bundel_pajak_retribusi WHERE status='management' ORDER BY bundel_id ASC")->result_array();

		$main_data['bundle_rows'] = $bundle_rows;

		$main_data['bundle_item_type'] = $this->bundle_item_type;

		$main_data['menu'] = 'payment';

		$data = array('main_params' => $main_data);

		$view_folder = 'taxes/' . $this->active_controller;

		$this->public_template->render($view_folder . '/index', $data);
	}

	function load_billing_list()
	{

		$this->admin_access_handler->check_access();

		$kode_billing = $_POST['input-kode_billing'];
		$tgl_setor = us_date_format($_POST['input-tgl_setor']);

		$sql = "SELECT a.*, b.nama_kegus FROM v_penyetoran_sspd a LEFT JOIN payment.v_payment b ON a.kode_billing=b.kode_billing WHERE a.kode_billing = '" . $kode_billing . "'";
		$rows = $this->dao->execute(0, $sql)->result_array();

		$data = array('rows' => $rows, 'tgl_setor' => $tgl_setor);

		$view_folder = 'taxes/' . $this->active_controller;

		$this->load->view($view_folder . '/billing_list', $data);
	}

	function load_billing_list_teller()
	{

		$this->admin_access_handler->check_access();

		$kode_billing = $_POST['input-kode_billing_teller'];
		$tgl_setor = us_date_format($_POST['input-tgl_setor_teller']);

		$sql = "SELECT a.*, b.nama_kegus FROM v_penyetoran_sspd a LEFT JOIN payment.v_payment b ON a.kode_billing=b.kode_billing WHERE a.kode_billing = '" . $kode_billing . "'";
		$rows = $this->dao->execute(0, $sql)->result_array();

		$data = array('rows' => $rows, 'tgl_setor' => $tgl_setor);

		$view_folder = 'taxes/' . $this->active_controller;

		$this->load->view($view_folder . '/billing_list_teller', $data);
	}

	private function get_fine($tax, $due_date, $tgl_bayar, $determination_type)
	{

		$diff_month = get_diff_months($due_date, $tgl_bayar, $determination_type);

		$fine = assess_fine($tax, $diff_month);
		return $fine;
	}

	function load_billing_data()
	{

		$this->admin_access_handler->check_access();

		$kode_billing = $_POST['kode_billing'];
		$tgl_setor = $_POST['tgl_setor'];

		$sql = "SELECT a.*,b.rekening_id as rekening_id_denda, c.nama_kegus FROM v_penyetoran_sspd as a 
					LEFT JOIN v_rekening as b ON (a.pajak_id=b.pajak_id AND b.jenis_rekening='B')
					LEFT JOIN payment.v_payment as c ON a.kode_billing=c.kode_billing
					WHERE a.kode_billing='" . $kode_billing . "'";

		$row = $this->dao->execute(0, $sql)->row_array();
		$main_tax = 0;
		$fine = 0;
		$grand_total = 0;

		if (count($row) > 0) {

			// $fine = $this->get_fine($row['tot_pajak_terhutang'], $row['tgl_jatuh_tempo'], date('Y-m-d'), $row['jenis_spt_id']);
			if ($row['nama_kegus'] == 'Jasa Boga / Katering dan Sejenisnya') {
				$fine = 0;
				$grand_total = $row['tot_pajak_terhutang'] + $fine;
				$row['fine'] = $fine;
				$row['grand_total'] = $grand_total;
			} else {
				$fine = $this->get_fine($row['tot_pajak_terhutang'], $row['tgl_jatuh_tempo'], $tgl_setor, $row['jenis_spt_id']);
				$grand_total = $row['tot_pajak_terhutang'] + $fine;
				$row['fine'] = $fine;
				$row['grand_total'] = $grand_total;
			}
		}

		$data = array(
			'row' => $row,
			'kode_billing' => $kode_billing,
			'tgl_setor' => $tgl_setor,
		);

		$view_folder = 'taxes/' . $this->active_controller;

		$this->load->view($view_folder . '/billing_data', $data);
	}

	function submit_form()
	{

		$this->admin_access_handler->check_access();

		$access = '1'; //$this->public_template->get_access_privileges('add',$menu,$this->bundle_id);

		if ($access == '1') {

			$tbl_name = 'transaksi_pajak';
			$pk = 'transaksi_id';

			$kode_billing = $_POST['kode_billing'];
			$get_tgl_bayar = $_POST['tgl_bayar'];
			$tgl_bayar = us_date_format($get_tgl_bayar);
			$no_urut_sts = isset($_POST['no_urut_sts']) ? $_POST['no_urut_sts'] : '';

			$sql = "SELECT a.*,b.rekening_id as rekening_id_denda FROM v_penyetoran_sspd as a 
						LEFT JOIN v_rekening as b ON (a.pajak_id=b.pajak_id AND b.jenis_rekening='B') 
						WHERE a.kode_billing='" . $kode_billing . "'";

			$main_row = $this->dao->execute(0, $sql)->row_array();

			$determination_type = $main_row['jenis_ketetapan'];
			$this->load->model(array($tbl_name . '_model', 'transaksi_pajak_detil_model'));
			$m1 = $this->{$tbl_name . '_model'};
			$m2 = $this->transaksi_pajak_detil_model;

			if ($determination_type == 'SPT') {
				$this->load->model('spt_model');
				$m3 = $this->spt_model;
			} else {
				$this->load->model('laporan_hasil_pemeriksaan_model');
				$m3 = $this->laporan_hasil_pemeriksaan_model;
			}

			// $payment_date = date('Y-m-d');

			$input_params1 = array();
			$input_params1['spt_id'] = $main_row['ketetapan_id'];
			$input_params1['pajak_id'] = $main_row['pajak_id'];
			$input_params1['wp_wr_id'] = $main_row['wp_wr_id'];
			$input_params1['wp_wr_detil_id'] = $main_row['wp_wr_detil_id'];
			$input_params1['npwprd'] = $main_row['npwpd'];
			$input_params1['jenis_spt_id'] = $main_row['jenis_spt_id'];
			$input_params1['loket_pembayaran_id'] = $_POST['input-loket_pembayaran_id'];
			$input_params1['rekening_id'] = $main_row['rekening_id'];
			$input_params1['no_transaksi'] = $this->database_interactions->generate_transaction_number();
			$input_params1['no_sts'] = $this->database_interactions->generate_sts_number();
			$input_params1['kode_sts'] = $this->database_interactions->generate_sts_code($input_params1['no_sts'], NumToRomawi(date('m')), date('Y'));
			$input_params1['kode_billing'] = $main_row['kode_billing'];
			$input_params1['tahun_pajak'] = $main_row['tahun_pajak'];
			$input_params1['masa_pajak1'] = $main_row['masa_pajak1'];
			$input_params1['masa_pajak2'] = $main_row['masa_pajak2'];
			$input_params1['pokok_pajak'] = $main_row['tot_pajak_terhutang'];
			$input_params1['no_urut_sts'] = $no_urut_sts;


			//get fine
			$fine = $this->get_fine($main_row['tot_pajak_terhutang'], $main_row['tgl_jatuh_tempo'], $tgl_bayar, $main_row['jenis_spt_id']);
			$grand_total = $input_params1['pokok_pajak'] + $fine;

			$input_params1['denda'] = $fine;
			$input_params1['total_bayar'] = $grand_total;
			$input_params1['tgl_bayar'] = $tgl_bayar;
			// $input_params1['tgl_bayar'] = $newDate;
			$input_params1['tgl_jatuh_tempo'] = $main_row['tgl_jatuh_tempo'];
			$input_params1['created_by'] = $this->session->userdata('username');
			$input_params1['created_time'] = date('Y-m-d H:i:s');
			// $input_params1[$pk] = $this->global_model->get_nextval('transaksi_pajak_transaksi_id_seq');
			$input_params1[$pk] = $this->global_model->get_id('transaksi_id', 'transaksi_pajak');
			// var_dump($input_params1);
			// die;

			$this->db->trans_begin();

			//main detail
			$input_params2 = array();
			$input_params2['transaksi_id'] = $input_params1['transaksi_id'];
			$input_params2['rekening_id'] = $main_row['rekening_id'];
			$input_params2['tahun_pajak'] = $main_row['tahun_pajak'];
			$input_params2['jumlah_pajak'] = $main_row['tot_pajak_terhutang'];
			$input_params2['tgl_bayar'] = $tgl_bayar;
			// $input_params2['transaksi_detil_id'] = $this->global_model->get_nextval('transaksi_pajak_detil_transaksi_detil_id_seq');
			$input_params2['transaksi_detil_id'] = $this->global_model->get_id('transaksi_detil_id', 'transaksi_pajak_detil');

			$this->delegate_postTomodel($input_params2, $m2);
			$result = $this->dao->insert($m2);

			if (!$result) {
				$this->db->trans_rollback();
				die('ERROR: gagal mengkonfirmasi pembayaran');
			}
			// ======== //

			//check fine
			if ($fine > 0) {
				$input_params2 = array();
				$input_params2['transaksi_id'] = $input_params1['transaksi_id'];
				$input_params2['rekening_id'] = $main_row['rekening_id_denda'];
				$input_params2['tahun_pajak'] = $main_row['tahun_pajak'];
				$input_params2['jumlah_pajak'] = $fine;
				$input_params2['tgl_bayar'] = $tgl_bayar;
				$input_params2['transaksi_detil_id'] = $this->global_model->get_nextval('transaksi_pajak_detil_transaksi_detil_id_seq');

				$this->delegate_postTomodel($input_params2, $m2);
				$result = $this->dao->insert($m2);
				// var_dump($result);
				// die;

				if (!$result) {
					$this->db->trans_rollback();
					die('ERROR: gagal mengkonfirmasi pembayaran');
				}
			}

			$m3->set_status_bayar('1');

			if ($determination_type == 'SPT') {
				$result = $this->dao->update($m3, array('spt_id' => $input_params1['spt_id']));
			} else {
				$result = $this->dao->update($m3, array('lhp_id' => $input_params1['spt_id']));
			}

			if (!$result) {
				$this->db->trans_rollback();
				die('ERROR: gagal mengkonfirmasi pembayaran');
			}

			$this->delegate_postTomodel($input_params1, $m1);

			$result = $this->dao->insert($m1);

			if (!$result) {
				$this->db->trans_rollback();
				die('ERROR: gagal mengkonfirmasi pembayaran');
			}

			$this->db->trans_commit();

			//return response
			$sql = "SELECT * FROM v_spt as a 
						LEFT JOIN (SELECT x.spt_id,TO_CHAR(x.tgl_jatuh_tempo,'yyyy-mm-dd') as tgl_jatuh_tempo,
									TO_CHAR(x.tgl_bayar,'yyyy-mm-dd') as tgl_bayar,x.pokok_pajak,x.denda,x.total_bayar,y.loket_pembayaran FROM transaksi_pajak as x 
								   LEFT JOIN ref_loket_pembayaran as y ON (x.loket_pembayaran_id=y.ref_lokemba_id)) as b ON (a.spt_id=b.spt_id) 
						WHERE a.kode_billing='" . $kode_billing . "'";

			$row = $this->dao->execute(0, $sql)->row_array();

			$data['row'] = $row;
			$view_folder = 'taxes/' . $this->active_controller;

			$this->load->view($view_folder . '/tax_deposit_receipt', $data);
		} else {
			$this->_ci->load->view('errors/html/error_403', array('type' => $act));
			// die('error');
		}
	}

	function print_sts()
	{
		$id = $_GET['id'];

		$sql = "SELECT * FROM v_spt as a 
					LEFT JOIN (SELECT x.transaksi_id,x.spt_id,TO_CHAR(x.tgl_jatuh_tempo,'yyyy-mm-dd') as tgl_jatuh_tempo,
								TO_CHAR(x.tgl_bayar,'yyyy-mm-dd') as tgl_bayar,x.pokok_pajak,x.denda,x.total_bayar,x.no_urut_sts,y.loket_pembayaran,
								y.no_rekening FROM transaksi_pajak as x 
							   LEFT JOIN ref_loket_pembayaran as y ON (x.loket_pembayaran_id=y.ref_lokemba_id)) as b ON (a.spt_id=b.spt_id)
					WHERE a.spt_id='" . $id . "'";

		$row = $this->dao->execute(0, $sql)->row_array();

		$bundle_rows = $this->dao->execute(0, "SELECT * FROM bundel_pajak_retribusi WHERE status='management' ORDER BY bundel_id ASC")->row_array();

		$sql = "SELECT a.*,b.kode_rekening,b.nama_rekening,b.jenis_rekening FROM 
					transaksi_pajak_detil as a LEFT JOIN v_rekening as b ON (a.rekening_id=b.rekening_id) 
					WHERE a.transaksi_id='" . $row['transaksi_id'] . "' ORDER BY transaksi_detil_id ASC";
		$detail_rows = $this->dao->execute(0, $sql)->result_array();

		$system_params = $this->database_interactions->get_system_params();

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
		$data['bundle_row'] = $bundle_rows;
		$data['chief_official_row'] = $this->database_interactions->get_official('chief');
		$data['treasurer_official_row'] = $this->database_interactions->get_official('treasurer');
		$data['division1_official_row'] = $this->database_interactions->get_official('division1');
		$data['detail_rows'] = $detail_rows;
		$data['system_params'] = $system_params;
		// var_dump($data['bundle_row']);
		// die();

		$view_folder = 'taxes/print_sts';
		$this->load->view($view_folder . '/print', $data);
	}
}
