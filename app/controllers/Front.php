<?php
defined('BASEPATH') or exit('No direct script access allowed');

class front extends CI_Controller
{

	public $active_controller;

	function __construct()
	{

		parent::__construct();

		$this->load->library(array('public_template', 'DAO', 'session', 'admin_access_handler'));
		$this->load->model(array('global_model'));
		$this->load->helper('url');

		$controller_list = $this->config->item('controller_list');
		$this->active_controller = __CLASS__;
		$this->taxes_config = $this->config->item('taxes');
		$this->duties_config = $this->config->item('duties');

		$this->dao = $this->global_model->get_dao();

		$this->admin_access_handler->initialize_dao($this->dao);

		$this->admin_access_handler->check_access();

		//THESE ARE TEMPORARY
		// $userdata = array('user_type_id'=>'1','user_id'=>'1','username'=>'developer','nip'=>'1111','fullname'=>'Developer','role'=>'DEVELOPER','payment_locket_id'=>'1');
		// $this->session->set_userdata($userdata);
		// $this->session->sess_destroy();

	}

	function securimage()
	{
		$lib_path = APPPATH . DIRECTORY_SEPARATOR . 'libraries' . DIRECTORY_SEPARATOR . 'securimage/';
		require_once($lib_path . 'securimage.php');
		$img = new Securimage();
		$img->show(); // alternate use: $img->show('/path/to/background.jpg');
	}

	function index()
	{
		$this->load->helper('date_helper');
		$_SYS_PARAMS = $this->global_model->get_system_params();

		$this->global_model->reinitialize_dao();
		$dao = $this->global_model->get_dao();
		$sql = "SELECT * FROM bundel_pajak_retribusi WHERE (bundel_id BETWEEN 1 AND 20) AND aktif=TRUE ORDER BY bundel_id ASC";
		$bundle_rows = $dao->execute(0, $sql)->result_array();

		$sql = "SELECT a.nama_paret as nama_pajak, COALESCE(c.tot_realisasi,'0') as tot_realisasi, COALESCE(d.tot_realisasi_wp,'0') as tot_realisasi_wp, e.target_pajak as target_pajak, f.target_wp as target_wp 
			 FROM bundel_pajak_retribusi as a 
			 LEFT JOIN (SELECT SUM(pajak) as tot_pajak,pajak_id FROM v_spt WHERE tahun_pajak='2022' GROUP BY pajak_id) 
			 as b ON (a.bundel_id=b.pajak_id) 
			 LEFT JOIN (SELECT SUM(pokok_pajak) as tot_realisasi,pajak_id FROM transaksi_pajak WHERE tahun_pajak='2022' 
			 GROUP BY pajak_id) as c
			  ON (a.bundel_id=c.pajak_id) 
				LEFT JOIN (SELECT COUNT(wp_wr_detil_id) as tot_realisasi_wp,pajak_id FROM wp_wr_detil 
			 GROUP BY pajak_id) as d
			  ON (a.bundel_id=d.pajak_id) 
				INNER JOIN ref_target_pajak as e ON a.kode_pajak=e.kode_pajak
				INNER JOIN ref_target_wp as f ON a.kode_pajak=f.kode_pajak 
				WHERE (a.bundel_id BETWEEN 1 AND 11) AND a.aktif=TRUE ORDER BY a.bundel_id ASC";
		$realisasi = $dao->execute(0, $sql)->result_array();

		$data = array('main_params' => array('bundle_rows' => $bundle_rows, 'realisasi' => $realisasi));

		$this->public_template->render('front/index', $data);
	}

	function get_realisasi()
	{
		$this->load->helper('date_helper');
		$_SYS_PARAMS = $this->global_model->get_system_params();

		$this->global_model->reinitialize_dao();
		$dao = $this->global_model->get_dao();
		$tahun_pajak = $_POST['tahun_pajak'];

		$sql = "SELECT a.nama_paret as nama_pajak, COALESCE(c.tot_realisasi,'0') as tot_realisasi, COALESCE(d.tot_realisasi_wp,'0') as tot_realisasi_wp, e.target_pajak as target_pajak, f.target_wp as target_wp 
			 FROM bundel_pajak_retribusi as a 
			 LEFT JOIN (SELECT SUM(pajak) as tot_pajak,pajak_id FROM v_spt WHERE tahun_pajak='$tahun_pajak' GROUP BY pajak_id) 
			 as b ON (a.bundel_id=b.pajak_id) 
			 LEFT JOIN (SELECT SUM(pokok_pajak) as tot_realisasi,pajak_id FROM transaksi_pajak WHERE tahun_pajak='$tahun_pajak' 
			 GROUP BY pajak_id) as c
			  ON (a.bundel_id=c.pajak_id) 
				LEFT JOIN (SELECT COUNT(wp_wr_detil_id) as tot_realisasi_wp,pajak_id FROM wp_wr_detil 
			 GROUP BY pajak_id) as d
			  ON (a.bundel_id=d.pajak_id) 
				INNER JOIN ref_target_pajak as e ON a.kode_pajak=e.kode_pajak
				INNER JOIN ref_target_wp as f ON a.kode_pajak=f.kode_pajak 
				WHERE (a.bundel_id BETWEEN 1 AND 11) AND a.aktif=TRUE ORDER BY a.bundel_id ASC";
		$realisasi = $dao->execute(0, $sql)->result_array();

		echo json_encode($realisasi);
	}

	function login()
	{
		$this->load->helper('mix_helper');
	}

	function logout()
	{

		$dao = $this->global_model->get_dao();

		// $nopes = $this->session->userdata('nopes');

		// $sql = "DELETE FROM user_logins WHERE user_id='".$nopes."'";
		// $result = $dao->execute(0,$sql);	    	

		// $this->session->sess_destroy();

		// redirect('front/');			
	}
}
