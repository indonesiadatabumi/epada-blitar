<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'controllers' . DIRECTORY_SEPARATOR . 'Item_bundle_parent.php';

class record_tax_deposit extends item_bundle_parent
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

	function load_billing_data()
	{

		$this->_ci->admin_access_handler->check_access();

		$menu = $_POST['menu'];
		$kode_billing = $_POST['kode_billing'];

		$sql = "SELECT * FROM v_penyetoran_sspd WHERE kode_billing='" . $kode_billing . "'";

		$row = $this->dao->execute(0, $sql)->row_array();
		$main_tax = 0;
		$fine = 0;
		$grand_total = 0;

		if (count($row) > 0) {
			$diff_month = get_diff_months($row['tgl_jatuh_tempo'], date('Y-m-d'), $row['jenis_spt_id']);
			$fine = assess_fine($row['tot_pajak_terhutang'], $diff_month);
			$grand_total = $row['tot_pajak_terhutang'] + $fine;
			$row['fine'] = $fine;
			$row['grand_total'] = $grand_total;
		}

		$data = array(
			'row' => $row,
			'menu' => $menu,
			'kode_billing' => $kode_billing,
			'bundle_id' => $this->bundle_id,
			'bundle_type' => $this->bundle_type,
			'bundle_item_type' => $this->bundle_item_type,
		);

		$view_folder = $this->bundle_type . '/' . $menu;

		$this->_ci->load->view($view_folder . '/billing_data', $data);
	}

	function load_billing_list()
	{

		$this->_ci->admin_access_handler->check_access();

		$menu = $_POST['menu'];
		$kode_billing = $_POST['input-kode_billing'];

		$sql = "SELECT * FROM v_penyetoran_sspd WHERE kode_billing LIKE '" . $kode_billing . "%'";
		$rows = $this->dao->execute(0, $sql)->result_array();

		$data = array('rows' => $rows, 'menu' => $menu);

		$view_folder = $this->bundle_type . '/' . $menu;
		$this->_ci->load->view($view_folder . '/billing_list', $data);
	}

	function submit_form()
	{

		$this->_ci->admin_access_handler->check_access();

		$menu = $_POST['menu'];

		$access = $this->_ci->public_template->get_access_privileges('add', $menu, $this->bundle_id);

		if ($access == '1') {

			$res = $menu . '_resources';
			require_once APPPATH . 'libraries' . DIRECTORY_SEPARATOR . 'system_resources' . DIRECTORY_SEPARATOR . $res . '.php';
			$tbl_name = $res::$_TBL_NAME;
			$pk = $res::$_PK;

			$determination_type = $_POST['jenis_ketetapan'];
			$kode_billing = $_POST['kode_billing'];

			$this->_ci->load->model(array($tbl_name . '_model', 'transaksi_pajak_detil_model'));
			$m1 = $this->_ci->{$tbl_name . '_model'};
			$m2 = $this->_ci->transaksi_pajak_detil_model;


			if ($determination_type == 'SPT') {
				$this->_ci->load->model('spt_model');
				$m3 = $this->_ci->spt_model;
			} else {
				$this->_ci->load->model('laporan_hasil_pemeriksaan_model');
				$m3 = $this->_ci->laporan_hasil_pemeriksaan_model;
			}

			$input_params1 = $this->collect_input_params($_POST, 'input');
			$input_params1['no_transaksi'] = $this->_ci->database_interactions->generate_transaction_number($input_params1['pajak_id']);
			$input_params1['created_by'] = $this->_ci->session->userdata('username');
			$input_params1['created_time'] = date('Y-m-d H:i:s');
			$input_params1[$pk] = $this->_ci->global_model->get_nextval('transaksi_pajak_transaksi_id_seq');

			$this->_ci->db->trans_begin();

			$n_detail = $_POST['n_detail'];

			for ($i = 1; $i <= $n_detail; $i++) {
				$input_params2 = array();
				$input_params2['transaksi_id'] = $input_params1['transaksi_id'];
				$input_params2['rekening_id'] = $_POST['input2-rekening_id' . $i];
				$input_params2['tahun_pajak'] = $_POST['input-tahun_pajak'];
				$input_params2['jumlah_pajak'] = $_POST['input2-jumlah_pajak' . $i];
				$input_params2['tgl_bayar'] = $input_params1['created_time'];
				$input_params2['transaksi_detil_id'] = $this->_ci->global_model->get_nextval('transaksi_pajak_detil_transaksi_detil_id_seq');

				$this->delegate_postTomodel($input_params2, $m2);

				$result = $this->dao->insert($m2);
				if (!$result) {
					$this->_ci->db->trans_rollback();
					die('ERROR: gagal mengkonfirmasi pembayaran');
				}
			}

			$m3->set_status_bayar('1');
			$result = $this->dao->update($m3, array('spt_id' => $input_params1['spt_id']));

			if (!$result) {
				$this->_ci->db->trans_rollback();
				die('ERROR: gagal mengkonfirmasi pembayaran');
			}

			$this->delegate_postTomodel($input_params1, $m1);

			$result = $this->dao->insert($m1);

			if (!$result) {
				$this->_ci->db->trans_rollback();
				die('ERROR: gagal mengkonfirmasi pembayaran');
			}

			$this->_ci->db->trans_commit();

			//return response
			$sql = "SELECT a.*,b.pokok_pajak,b.denda,b.total_bayar,b.loket_pembayaran,b.tgl_bayar FROM v_penyetoran_sspd as a 
						LEFT JOIN (SELECT x.kode_billing,x.pokok_pajak,x.denda,x.total_bayar,x.tgl_bayar,y.loket_pembayaran FROM transaksi_pajak as x 
									LEFT JOIN ref_loket_pembayaran as y ON (x.loket_pembayaran_id=y.ref_lokemba_id)) as b ON (a.kode_billing=b.kode_billing) 
						WHERE a.kode_billing='" . $kode_billing . "'";

			$row = $this->dao->execute(0, $sql)->row_array();

			$view_folder = $this->bundle_type . '/' . $menu;
			$this->_ci->load->view($view_folder . '/tax_deposit_receipt', $data);
		} else {
			$this->_ci->load->view('errors/html/error_403', array('type' => $act));
		}
	}
}
