<?php
defined('BASEPATH') or exit('No direct script access allowed');

class config extends CI_Controller
{
	protected $_ci;
	public $active_controller;

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
		$this->_ci = &get_instance();
		$this->active_controller = __CLASS__;
	}

	function index()
	{

		$this->admin_access_handler->check_access();

		$bundle_rows = $this->dao->execute(0, "SELECT * FROM bundel_pajak_retribusi WHERE status='management' ORDER BY bundel_id ASC");

		$data_user = $this->dao->execute(0, "SELECT * FROM users");

		$data_user_type = $this->dao->execute(0, "SELECT * FROM user_types");

		$gol_hotel = $this->dao->execute(0, "SELECT * FROM ref_gol_hotel");

		$gol_ruang = $this->dao->execute(0, "SELECT * FROM ref_gol_ruang");

		$harga_air = $this->dao->execute(0, "SELECT * FROM ref_harga_air_baku");

		$indeks_kawasan = $this->dao->execute(0, "SELECT * FROM ref_indeks_kawasan");

		$indeks_kelasjalan = $this->dao->execute(0, "SELECT * FROM ref_indeks_kelas_jalan");

		$indeks_ketinggian = $this->dao->execute(0, "SELECT * FROM ref_indeks_ketinggian");

		$indeks_sudutpandang = $this->dao->execute(0, "SELECT * FROM ref_indeks_sudut_pandang");

		$jabatan_pejabatdaerah = $this->dao->execute(0, "SELECT * FROM ref_jabatan_pejabat_daerah");

		$jenis_kamarhotel = $this->dao->execute(0, "SELECT * FROM ref_jenis_kamar_hotel");

		$jenis_mblb = $this->dao->execute(0, "SELECT * FROM ref_jenis_mblb");

		$jenis_pemungutan = $this->dao->execute(0, "SELECT * FROM ref_jenis_pemungutan INNER JOIN ref_jenis_spt ON ref_jenis_pemungutan.jenis_spt_id=ref_jenis_spt.ref_jenspt_id");

		$jenis_restoran = $this->dao->execute(0, "SELECT * FROM ref_jenis_restoran");

		$jenis_sat = $this->dao->execute(0, "SELECT * FROM ref_jenis_sat");

		$kelas_jalan = $this->dao->execute(0, "SELECT * FROM ref_kelas_jalan");

		$komponen_airtanah = $this->dao->execute(0, "SELECT * FROM ref_komponen_air_tanah");

		$loket_pembayaran = $this->dao->execute(0, "SELECT * FROM ref_loket_pembayaran");

		$uptd = $this->dao->execute(0, "SELECT * FROM ref_uptd");

		$kegiatan_usaha = $this->dao->execute(0, "SELECT * FROM bundel_pajak_retribusi INNER JOIN ref_kegiatan_usaha ON bundel_pajak_retribusi.bundel_id=ref_kegiatan_usaha.pajak_id");

		$target_pajak = $this->dao->execute(0, "SELECT nama_paret as nama_pajak, id_target, target_pajak FROM bundel_pajak_retribusi INNER JOIN ref_target_pajak ON bundel_pajak_retribusi.kode_pajak=ref_target_pajak.kode_pajak");

		$target_wp = $this->dao->execute(0, "SELECT nama_paret as nama_pajak, id_target, target_wp FROM bundel_pajak_retribusi INNER JOIN ref_target_wp ON bundel_pajak_retribusi.kode_pajak=ref_target_wp.kode_pajak");

		$pejabat_daerah = $this->dao->execute(0, "SELECT a.pejda_id ,a.nama, a.nip, b.nama_jabatan_id as jabatan, c.pangkat FROM pejabat_daerah as a INNER JOIN ref_jabatan_pejabat_daerah as b ON a.japeda_id=ref_japeda_id INNER JOIN ref_gol_ruang as c ON a.goru_id=c.ref_goru_id ORDER BY pejda_id ASC");

		$main_data['bundle_rows'] = $bundle_rows;

		$main_data['user_data'] = $data_user;

		$main_data['user_type_data'] = $data_user_type;

		$main_data['gol_hotel'] = $gol_hotel;

		$main_data['gol_ruang'] = $gol_ruang;

		$main_data['harga_air'] = $harga_air;

		$main_data['indeks_kawasan'] = $indeks_kawasan;

		$main_data['indeks_kelasjalan'] = $indeks_kelasjalan;

		$main_data['indeks_ketinggian'] = $indeks_ketinggian;

		$main_data['indeks_sudutpandang'] = $indeks_sudutpandang;

		$main_data['jabatan_pejabatdaerah'] = $jabatan_pejabatdaerah;

		$main_data['jenis_kamarhotel'] = $jenis_kamarhotel;

		$main_data['jenis_mblb'] = $jenis_mblb;

		$main_data['jenis_pemungutan'] = $jenis_pemungutan;

		$main_data['jenis_restoran'] = $jenis_restoran;

		$main_data['jenis_sat'] = $jenis_sat;

		$main_data['kelas_jalan'] = $kelas_jalan;

		$main_data['komponen_airtanah'] = $komponen_airtanah;

		$main_data['loket_pembayaran'] = $loket_pembayaran;

		$main_data['uptd'] = $uptd;

		$main_data['kegiatan_usaha'] = $kegiatan_usaha;

		$main_data['target_pajak'] = $target_pajak;

		$main_data['target_wp'] = $target_wp;

		$main_data['pejabat_daerah'] = $pejabat_daerah;

		$data = array('main_params' => $main_data);

		$view_folder = $this->active_controller;

		$this->public_template->render($view_folder . '/index', $data);

		// echo json_encode($data_user->result_array());
	}

	function form_privilege($id = 0)
	{
		$this->admin_access_handler->check_access();
		$bundle_rows = $this->dao->execute(0, "SELECT * FROM bundel_pajak_retribusi WHERE status='management' ORDER BY bundel_id ASC");
		$main_data['bundle_rows'] = $bundle_rows;
		$main_data['user_type_id'] = $id;
		$data = array('main_params' => $main_data);

		$view_folder = $this->active_controller;
		$this->_ci->load->view($view_folder . '/form_privilege', $main_data);
	}

	function form_user()
	{
		$this->admin_access_handler->check_access();
		$view_folder = $this->active_controller;
		$this->_ci->load->view($view_folder . '/form_user');
	}

	function create_user()
	{
		$this->admin_access_handler->check_access();
		$parampost = $this->security->xss_clean($this->input->post());

		$getId = $this->dao->execute(0, "SELECT * FROM users")->result_array();

		$create = $this->dao->execute(0, "INSERT INTO users (
				user_id, username, fullname, password, phone, email, nip, user_code, user_type_id, created_by, created_time, modified_time
			) values (
				" . (count($getId) + 1) . ",
				'" . $parampost['username'] . "', 
				'" . $parampost['fullname'] . "', 
				'" . md5($parampost['password']) . "', 
				'" . $parampost['phone'] . "', 
				'" . $parampost['email'] . "', 
				'" . $parampost['nip'] . "', 
				'-',
				'1',
				'" . $this->_ci->session->userdata('username') . "',
				'" . date('Y-m-d H:i:s') . "',
				'" . date('Y-m-d H:i:s') . "'
			)");
		if ($create) {
			echo json_encode("{'status': 'success'}");
		} else {
			// failed to create user
			echo json_encode("{'status': 'failed'}");
		}
	}

	function reset_password()
	{
		$this->admin_access_handler->check_access();
		$parampost = $this->security->xss_clean($this->input->post());
	}

	function form_add_akses($id_user_type, $id)
	{
		$this->admin_access_handler->check_access();

		$bundle_rows = $this->dao->execute(0, "SELECT * FROM menu_bundles JOIN menu_navigations ON menu_bundles.menu_navigation_id=menu_navigations.menu_id WHERE bundle_id = $id");

		$main_data['bundle_rows'] = $bundle_rows;

		$main_data['id_user_type'] = $id_user_type;

		$main_data['bundle_id'] = $id;

		// var_dump($bundle_rows);
		// die;

		$data = array('main_params' => $main_data);

		$view_folder = $this->active_controller;
		$this->_ci->load->view($view_folder . '/form_add_akses', $main_data);
		// $this->public_template->render($view_folder.'/form', $data);
	}

	function add_akses()
	{
		$this->admin_access_handler->check_access();
		$parampost = $this->security->xss_clean($this->input->post());

		$user_type_id = $parampost['user_type_id'];
		$bundle_id = $parampost['bundle_id'];
		$menu_bundle_id = $parampost['menu_bundle_id'];
		$read_priv = $parampost['read_priv'];
		$add_priv = $parampost['add_priv'];
		$update_priv = $parampost['update_priv'];
		$delete_priv = $parampost['delete_priv'];
		$print_priv = $parampost['print_priv'];

		// var_dump($data);
		// die;

		$getId = $this->dao->execute(0, "SELECT * FROM user_privileges")->result_array();
		$privilege_id = count($getId) + 1;
		$bundle_rows = $this->dao->execute(0, "INSERT INTO user_privileges (privilege_id, user_type_id, menu_bundle_id, read_priv, add_priv, update_priv, delete_priv, print_priv, bundle_id) VALUES ($privilege_id, '$user_type_id', '$menu_bundle_id', '$read_priv', '$add_priv', '$update_priv', '$delete_priv', '$print_priv', '$bundle_id') ");

		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}

	function form($id_user_type, $id = 0)
	{
		$this->admin_access_handler->check_access();

		$bundle_rows = $this->dao->execute(0, "SELECT * FROM bundel_pajak_retribusi WHERE status='management' ORDER BY bundel_id ASC");

		$list_privileges = $this->dao->execute(
			0,
			"SELECT a.privilege_id, b.menu_id, b.level, b.reference, b.title, b.url, b.description, b.image, a.read_priv, a.add_priv, a.update_priv, a.delete_priv, a.print_priv
				FROM user_privileges as a 
				INNER JOIN (
				  SELECT x.menu_bundle_id,y.* 
				  FROM menu_bundles as x 
				  INNER JOIN (
					SELECT * FROM menu_navigations 
					WHERE showed=TRUE
				  ) as y 
				  ON (x.menu_navigation_id=y.menu_id) WHERE x.showed=TRUE) as b 
				  ON (a.menu_bundle_id=b.menu_bundle_id) WHERE (a.user_type_id='$id_user_type') AND (a.bundle_id='$id')
				  ORDER BY a.privilege_id;"
		);
		$main_data['bundle_rows'] = $bundle_rows;
		$main_data['list_privileges'] = $list_privileges;

		$data = array('main_params' => $main_data);

		$view_folder = $this->active_controller;
		$this->_ci->load->view($view_folder . '/form', $main_data);
		// $this->public_template->render($view_folder.'/form', $data);
	}

	function form_user_types($userTypeId = null)
	{
		$this->admin_access_handler->check_access();
		if ($userTypeId == null) {
			// show create form
			$view_folder = $this->active_controller;
			$this->_ci->load->view($view_folder . '/form_new_user_types');
		} else {
			// fetch data user type
			$bundle_rows = $this->dao->execute(0, "SELECT * FROM user_types WHERE user_type_id=$userTypeId");
			$main_data['detail_user_types'] = $bundle_rows->result()[0];
			$data = array('main_params' => $main_data);
			$view_folder = $this->active_controller;
			$this->_ci->load->view($view_folder . '/form_user_types', $main_data);
		}
	}

	function updatePrivileges($privId, $which, $state)
	{
		$this->admin_access_handler->check_access();
		$boolState = $state == 'true' ? 1 : 0;
		$bundle_rows = $this->dao->execute(0, "UPDATE user_privileges SET $which = $boolState WHERE privilege_id=$privId");

		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}

	function update_user_type($userId, $typeId)
	{
		$this->admin_access_handler->check_access();
		$bundle_rows = $this->dao->execute(0, "UPDATE users SET user_type_id = $typeId WHERE user_id=$userId");

		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}

	function update_user_status($userId, $status)
	{
		$this->admin_access_handler->check_access();
		$bundle_rows = $this->dao->execute(0, "UPDATE users SET status = $status WHERE user_id=$userId");

		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}

	function update_type()
	{
		$this->admin_access_handler->check_access();
		$parampost = $this->security->xss_clean($this->input->post());
		$userTypeId = $parampost['user_type_id'];
		$name = $parampost['name'];
		$bundle_rows = $this->dao->execute(0, "UPDATE user_types SET name = '$name' WHERE user_type_id = $userTypeId");

		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}

	function add_type()
	{
		$this->admin_access_handler->check_access();
		$parampost = $this->security->xss_clean($this->input->post());

		$name = $parampost['name'];

		$getId = $this->dao->execute(0, "SELECT * FROM user_types")->result_array();
		$userTypeId = count($getId) + 1;
		$bundle_rows = $this->dao->execute(0, "INSERT INTO user_types (user_type_id, name) VALUES ($userTypeId, '$name') ");

		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}

	function delete_type($userTypeId)
	{
		$this->admin_access_handler->check_access();
		$bundle_rows = $this->dao->execute(0, "DELETE FROM user_types WHERE user_type_id=$userTypeId");

		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}

	function form_gol_hotel($ref_kode = null)
	{
		$this->admin_access_handler->check_access();
		if ($ref_kode == null) {
			// show create form
			$view_folder = $this->active_controller;
			$this->_ci->load->view($view_folder . '/form_new_gol_hotel');
		} else {
			// fetch data gol hotel
			$bundle_rows = $this->dao->execute(0, "SELECT * FROM ref_gol_hotel WHERE ref_kode=$ref_kode");
			$main_data['detail_gol_hotel'] = $bundle_rows->result()[0];
			$data = array('main_params' => $main_data);
			$view_folder = $this->active_controller;
			$this->_ci->load->view($view_folder . '/form_gol_hotel', $main_data);
		}
	}

	function add_gol_hotel()
	{
		$this->admin_access_handler->check_access();
		$parampost = $this->security->xss_clean($this->input->post());

		$golongan = $parampost['golongan'];

		$getId = $this->dao->execute(0, "SELECT * FROM ref_gol_hotel")->result_array();
		$ref_kode = count($getId) + 1;
		$bundle_rows = $this->dao->execute(0, "INSERT INTO ref_gol_hotel (ref_kode, golongan) VALUES ($ref_kode,'$golongan') ");

		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}

	function update_gol_hotel()
	{
		$this->admin_access_handler->check_access();
		$parampost = $this->security->xss_clean($this->input->post());
		$ref_kode = $parampost['ref_kode'];
		$golongan = $parampost['golongan'];
		$bundle_rows = $this->dao->execute(0, "UPDATE ref_gol_hotel SET golongan = '$golongan' WHERE ref_kode = $ref_kode");

		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}

	function delete_gol_hotel($ref_kode)
	{
		$this->admin_access_handler->check_access();
		$bundle_rows = $this->dao->execute(0, "DELETE FROM ref_gol_hotel WHERE ref_kode=$ref_kode");

		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}

	function form_gol_ruang($ref_goru_id = null)
	{
		$this->admin_access_handler->check_access();
		if ($ref_goru_id == null) {
			// show create form
			$view_folder = $this->active_controller;
			$this->_ci->load->view($view_folder . '/form_new_gol_ruang');
		} else {
			// fetch data gol ruang
			$bundle_rows = $this->dao->execute(0, "SELECT * FROM ref_gol_ruang WHERE ref_goru_id=$ref_goru_id");
			$main_data['detail_gol_ruang'] = $bundle_rows->result()[0];
			$data = array('main_params' => $main_data);
			$view_folder = $this->active_controller;
			$this->_ci->load->view($view_folder . '/form_gol_ruang', $main_data);
		}
	}

	function add_gol_ruang()
	{
		$this->admin_access_handler->check_access();
		$parampost = $this->security->xss_clean($this->input->post());

		$gol_ruang = $parampost['gol_ruang'];
		$pangkat = $parampost['pangkat'];

		$getId = $this->dao->execute(0, "SELECT * FROM ref_gol_ruang")->result_array();
		$ref_goru_id = count($getId) + 1;
		$bundle_rows = $this->dao->execute(0, "INSERT INTO ref_gol_ruang (ref_goru_id, gol_ruang, pangkat) VALUES ($ref_goru_id, '$gol_ruang', '$pangkat') ");

		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}

	function update_gol_ruang()
	{
		$this->admin_access_handler->check_access();
		$parampost = $this->security->xss_clean($this->input->post());
		$ref_goru_id = $parampost['ref_goru_id'];
		$gol_ruang = $parampost['gol_ruang'];
		$pangkat = $parampost['pangkat'];
		$bundle_rows = $this->dao->execute(0, "UPDATE ref_gol_ruang SET gol_ruang = '$gol_ruang', pangkat = '$pangkat' WHERE ref_goru_id = $ref_goru_id");

		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}

	function delete_gol_ruang($ref_goru_id)
	{
		$this->admin_access_handler->check_access();
		$bundle_rows = $this->dao->execute(0, "DELETE FROM ref_gol_ruang WHERE ref_goru_id=$ref_goru_id");

		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}

	function form_harga_air($ref_hrgab_id = null)
	{
		$this->admin_access_handler->check_access();
		if ($ref_hrgab_id == null) {
			// show create form
			$view_folder = $this->active_controller;
			$this->_ci->load->view($view_folder . '/form_new_harga_air');
		} else {
			// fetch data harga air
			$bundle_rows = $this->dao->execute(0, "SELECT * FROM ref_harga_air_baku WHERE ref_hrgab_id=$ref_hrgab_id");
			$main_data['detail_harga_air'] = $bundle_rows->result()[0];
			$data = array('main_params' => $main_data);
			$view_folder = $this->active_controller;
			$this->_ci->load->view($view_folder . '/form_harga_air', $main_data);
		}
	}

	function add_harga_air()
	{
		$this->admin_access_handler->check_access();
		$parampost = $this->security->xss_clean($this->input->post());

		$deskripsi = $parampost['deskripsi'];
		$harga_satuan = $parampost['harga_satuan'];

		$getId = $this->dao->execute(0, "SELECT * FROM ref_harga_air_baku")->result_array();
		$ref_hrgab_id = count($getId) + 1;
		$bundle_rows = $this->dao->execute(0, "INSERT INTO ref_harga_air_baku (ref_hrgab_id, deskripsi, harga_satuan) VALUES ($ref_hrgab_id, '$deskripsi', '$harga_satuan') ");

		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}

	function update_harga_air()
	{
		$this->admin_access_handler->check_access();
		$parampost = $this->security->xss_clean($this->input->post());
		$ref_hrgab_id = $parampost['ref_hrgab_id'];
		$deskripsi = $parampost['deskripsi'];
		$harga_satuan = $parampost['harga_satuan'];
		$bundle_rows = $this->dao->execute(0, "UPDATE ref_harga_air_baku SET deskripsi = '$deskripsi', harga_satuan = '$harga_satuan' WHERE ref_hrgab_id = $ref_hrgab_id");

		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}

	function delete_harga_air($ref_hrgab_id)
	{
		$this->admin_access_handler->check_access();
		$bundle_rows = $this->dao->execute(0, "DELETE FROM ref_harga_air_baku WHERE ref_hrgab_id=$ref_hrgab_id");

		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}

	function form_indeks_kawasan($ref_indeks_id = null)
	{
		$this->admin_access_handler->check_access();
		if ($ref_indeks_id == null) {
			// show create form
			$view_folder = $this->active_controller;
			$this->_ci->load->view($view_folder . '/form_new_indeks_kawasan');
		} else {
			// fetch data kawasan
			$bundle_rows = $this->dao->execute(0, "SELECT * FROM ref_indeks_kawasan WHERE ref_indeks_id=$ref_indeks_id");
			$main_data['detail_indeks_kawasan'] = $bundle_rows->result()[0];
			$data = array('main_params' => $main_data);
			$view_folder = $this->active_controller;
			$this->_ci->load->view($view_folder . '/form_indeks_kawasan', $main_data);
		}
	}

	function add_indeks_kawasan()
	{
		$this->admin_access_handler->check_access();
		$parampost = $this->security->xss_clean($this->input->post());

		$kawasan = $parampost['kawasan'];
		$skor = $parampost['skor'];
		$indeks = $parampost['indeks'];

		$getId = $this->dao->execute(0, "SELECT * FROM ref_indeks_kawasan")->result_array();
		$ref_indeks_id = count($getId) + 1;
		$bundle_rows = $this->dao->execute(0, "INSERT INTO ref_indeks_kawasan (ref_indeks_id, kawasan, skor, indeks) VALUES ($ref_indeks_id, '$kawasan', '$skor', '$indeks') ");

		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}

	function update_indeks_kawasan()
	{
		$this->admin_access_handler->check_access();
		$parampost = $this->security->xss_clean($this->input->post());
		$ref_indeks_id = $parampost['ref_indeks_id'];
		$kawasan = $parampost['kawasan'];
		$skor = $parampost['skor'];
		$indeks = $parampost['indeks'];
		$bundle_rows = $this->dao->execute(0, "UPDATE ref_indeks_kawasan SET kawasan = '$kawasan', skor = '$skor', indeks = '$indeks' WHERE ref_indeks_id = $ref_indeks_id");

		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}

	function delete_indeks_kawasan($ref_indeks_id)
	{
		$this->admin_access_handler->check_access();
		$bundle_rows = $this->dao->execute(0, "DELETE FROM ref_indeks_kawasan WHERE ref_indeks_id=$ref_indeks_id");

		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}

	function form_indeks_kelasjalan($ref_indeks_id = null)
	{
		$this->admin_access_handler->check_access();
		if ($ref_indeks_id == null) {
			// show create form
			$view_folder = $this->active_controller;
			$this->_ci->load->view($view_folder . '/form_new_indeks_kelasjalan');
		} else {
			// fetch data kelas jalan
			$bundle_rows = $this->dao->execute(0, "SELECT * FROM ref_indeks_kelas_jalan WHERE ref_indeks_id=$ref_indeks_id");
			$main_data['detail_indeks_kelasjalan'] = $bundle_rows->result()[0];
			$data = array('main_params' => $main_data);
			$view_folder = $this->active_controller;
			$this->_ci->load->view($view_folder . '/form_indeks_kelasjalan', $main_data);
		}
	}

	function add_indeks_kelasjalan()
	{
		$this->admin_access_handler->check_access();
		$parampost = $this->security->xss_clean($this->input->post());

		$kelas_jalan = $parampost['kelas_jalan'];
		$skor = $parampost['skor'];
		$indeks = $parampost['indeks'];

		$getId = $this->dao->execute(0, "SELECT * FROM ref_indeks_kelas_jalan")->result_array();
		$ref_indeks_id = count($getId) + 1;
		$bundle_rows = $this->dao->execute(0, "INSERT INTO ref_indeks_kelas_jalan (ref_indeks_id, kelas_jalan, skor, indeks) VALUES ($ref_indeks_id, '$kelas_jalan', '$skor', '$indeks') ");

		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}

	function update_indeks_kelasjalan()
	{
		$this->admin_access_handler->check_access();
		$parampost = $this->security->xss_clean($this->input->post());
		$ref_indeks_id = $parampost['ref_indeks_id'];
		$kelas_jalan = $parampost['kelas_jalan'];
		$skor = $parampost['skor'];
		$indeks = $parampost['indeks'];
		$bundle_rows = $this->dao->execute(0, "UPDATE ref_indeks_kelas_jalan SET kelas_jalan = '$kelas_jalan', skor = '$skor', indeks = '$indeks' WHERE ref_indeks_id = $ref_indeks_id");

		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}

	function delete_indeks_kelasjalan($ref_indeks_id)
	{
		$this->admin_access_handler->check_access();
		$bundle_rows = $this->dao->execute(0, "DELETE FROM ref_indeks_kelas_jalan WHERE ref_indeks_id=$ref_indeks_id");

		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}

	function form_indeks_ketinggian($ref_indeks_id = null)
	{
		$this->admin_access_handler->check_access();
		if ($ref_indeks_id == null) {
			// show create form
			$view_folder = $this->active_controller;
			$this->_ci->load->view($view_folder . '/form_new_indeks_ketinggian');
		} else {
			// fetch data ketinggian
			$bundle_rows = $this->dao->execute(0, "SELECT * FROM ref_indeks_ketinggian WHERE ref_indeks_id=$ref_indeks_id");
			$main_data['detail_indeks_ketinggian'] = $bundle_rows->result()[0];
			$data = array('main_params' => $main_data);
			$view_folder = $this->active_controller;
			$this->_ci->load->view($view_folder . '/form_indeks_ketinggian', $main_data);
		}
	}

	function add_indeks_ketinggian()
	{
		$this->admin_access_handler->check_access();
		$parampost = $this->security->xss_clean($this->input->post());

		$ketinggian = $parampost['ketinggian'];
		$skor = $parampost['skor'];
		$indeks = $parampost['indeks'];

		$getId = $this->dao->execute(0, "SELECT * FROM ref_indeks_ketinggian")->result_array();
		$ref_indeks_id = count($getId) + 1;
		$bundle_rows = $this->dao->execute(0, "INSERT INTO ref_indeks_ketinggian (ref_indeks_id, ketinggian, skor, indeks) VALUES ($ref_indeks_id, '$ketinggian', '$skor', '$indeks') ");

		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}

	function update_indeks_ketinggian()
	{
		$this->admin_access_handler->check_access();
		$parampost = $this->security->xss_clean($this->input->post());
		$ref_indeks_id = $parampost['ref_indeks_id'];
		$ketinggian = $parampost['ketinggian'];
		$skor = $parampost['skor'];
		$indeks = $parampost['indeks'];
		$bundle_rows = $this->dao->execute(0, "UPDATE ref_indeks_ketinggian SET ketinggian = '$ketinggian', skor = '$skor', indeks = '$indeks' WHERE ref_indeks_id = $ref_indeks_id");

		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}

	function delete_indeks_ketinggian($ref_indeks_id)
	{
		$this->admin_access_handler->check_access();
		$bundle_rows = $this->dao->execute(0, "DELETE FROM ref_indeks_ketinggian WHERE ref_indeks_id=$ref_indeks_id");
		echo json_encode("{status:'$bundle_rows'}");
	}

	function form_indeks_sudutpandang($ref_indeks_id = null)
	{
		$this->admin_access_handler->check_access();
		if ($ref_indeks_id == null) {
			// show create form
			$view_folder = $this->active_controller;
			$this->_ci->load->view($view_folder . '/form_new_indeks_sudutpandang');
		} else {
			// fetch data sudut pandang
			$bundle_rows = $this->dao->execute(0, "SELECT * FROM ref_indeks_sudut_pandang WHERE ref_indeks_id=$ref_indeks_id");
			$main_data['detail_indeks_sudutpandang'] = $bundle_rows->result()[0];
			$data = array('main_params' => $main_data);
			$view_folder = $this->active_controller;
			$this->_ci->load->view($view_folder . '/form_indeks_sudutpandang', $main_data);
		}
	}

	function add_indeks_sudutpandang()
	{
		$this->admin_access_handler->check_access();
		$parampost = $this->security->xss_clean($this->input->post());

		$sudut_pandang = $parampost['sudut_pandang'];
		$skor = $parampost['skor'];
		$indeks = $parampost['indeks'];

		$getId = $this->dao->execute(0, "SELECT * FROM ref_indeks_sudut_pandang")->result_array();
		$ref_indeks_id = count($getId) + 1;
		$bundle_rows = $this->dao->execute(0, "INSERT INTO ref_indeks_sudut_pandang (ref_indeks_id, sudut_pandang, skor, indeks) VALUES ($ref_indeks_id, '$sudut_pandang', '$skor', '$indeks') ");

		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}

	function update_indeks_sudutpandang()
	{
		$this->admin_access_handler->check_access();
		$parampost = $this->security->xss_clean($this->input->post());
		$ref_indeks_id = $parampost['ref_indeks_id'];
		$sudut_pandang = $parampost['sudut_pandang'];
		$skor = $parampost['skor'];
		$indeks = $parampost['indeks'];
		$bundle_rows = $this->dao->execute(0, "UPDATE ref_indeks_sudut_pandang SET sudut_pandang = '$sudut_pandang', skor = '$skor', indeks = '$indeks' WHERE ref_indeks_id = $ref_indeks_id");

		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}

	function delete_indeks_sudutpandang($ref_indeks_id)
	{
		$this->admin_access_handler->check_access();
		$bundle_rows = $this->dao->execute(0, "DELETE FROM ref_indeks_sudut_pandang WHERE ref_indeks_id=$ref_indeks_id");
		echo json_encode("{status:'$bundle_rows'}");
	}

	function form_jabatan_pejabatdaerah($ref_japeda_id = null)
	{
		$this->admin_access_handler->check_access();
		if ($ref_japeda_id == null) {
			// show create form
			$view_folder = $this->active_controller;
			$this->_ci->load->view($view_folder . '/form_new_jabatan_pejabatdaerah');
		} else {
			// fetch data jabatan pejabat
			$bundle_rows = $this->dao->execute(0, "SELECT * FROM ref_jabatan_pejabat_daerah WHERE ref_japeda_id=$ref_japeda_id");
			$main_data['detail_jabatan_pejabatdaerah'] = $bundle_rows->result()[0];
			$data = array('main_params' => $main_data);
			$view_folder = $this->active_controller;
			$this->_ci->load->view($view_folder . '/form_jabatan_pejabatdaerah', $main_data);
		}
	}

	function add_jabatan_pejabatdaerah()
	{
		$this->admin_access_handler->check_access();
		$parampost = $this->security->xss_clean($this->input->post());

		$nama_jabatan = $parampost['nama_jabatan'];

		$getId = $this->dao->execute(0, "SELECT * FROM ref_jabatan_pejabat_daerah")->result_array();
		$ref_japeda_id = count($getId) + 1;
		$bundle_rows = $this->dao->execute(0, "INSERT INTO ref_jabatan_pejabat_daerah (ref_japeda_id, nama_jabatan) VALUES ($ref_japeda_id, '$nama_jabatan') ");

		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}

	function update_jabatan_pejabatdaerah()
	{
		$this->admin_access_handler->check_access();
		$parampost = $this->security->xss_clean($this->input->post());
		$ref_japeda_id = $parampost['ref_japeda_id'];
		$nama_jabatan = $parampost['nama_jabatan'];
		$bundle_rows = $this->dao->execute(0, "UPDATE ref_jabatan_pejabat_daerah SET nama_jabatan = '$nama_jabatan' WHERE ref_japeda_id = $ref_japeda_id");

		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}

	function delete_jabatan_pejabatdaerah($ref_japeda_id)
	{
		$this->admin_access_handler->check_access();
		$bundle_rows = $this->dao->execute(0, "DELETE FROM ref_jabatan_pejabat_daerah WHERE ref_japeda_id=$ref_japeda_id");
		echo json_encode("{status:'$bundle_rows'}");
	}

	function form_jenis_kamarhotel($ref_jenmartel_id = null)
	{
		$this->admin_access_handler->check_access();
		if ($ref_jenmartel_id == null) {
			// show create form
			$view_folder = $this->active_controller;
			$this->_ci->load->view($view_folder . '/form_new_jenis_kamarhotel');
		} else {
			// fetch data jenis kamar
			$bundle_rows = $this->dao->execute(0, "SELECT * FROM ref_jenis_kamar_hotel WHERE ref_jenmartel_id=$ref_jenmartel_id");
			$main_data['detail_jenis_kamarhotel'] = $bundle_rows->result()[0];
			$data = array('main_params' => $main_data);
			$view_folder = $this->active_controller;
			$this->_ci->load->view($view_folder . '/form_jenis_kamarhotel', $main_data);
		}
	}

	function add_jenis_kamarhotel()
	{
		$this->admin_access_handler->check_access();
		$parampost = $this->security->xss_clean($this->input->post());

		$jenis_martel = $parampost['jenis_martel'];

		$getId = $this->dao->execute(0, "SELECT * FROM ref_jenis_kamar_hotel")->result_array();
		$ref_jenmartel_id = count($getId) + 1;
		$bundle_rows = $this->dao->execute(0, "INSERT INTO ref_jenis_kamar_hotel (ref_jenmartel_id, jenis_martel) VALUES ($ref_jenmartel_id, '$jenis_martel') ");

		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}

	function update_jenis_kamarhotel()
	{
		$this->admin_access_handler->check_access();
		$parampost = $this->security->xss_clean($this->input->post());
		$ref_jenmartel_id = $parampost['ref_jenmartel_id'];
		$jenis_martel = $parampost['jenis_martel'];
		$bundle_rows = $this->dao->execute(0, "UPDATE ref_jenis_kamar_hotel SET jenis_martel = '$jenis_martel' WHERE ref_jenmartel_id = $ref_jenmartel_id");

		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}

	function delete_jenis_kamarhotel($ref_jenmartel_id)
	{
		$this->admin_access_handler->check_access();
		$bundle_rows = $this->dao->execute(0, "DELETE FROM ref_jenis_kamar_hotel WHERE ref_jenmartel_id=$ref_jenmartel_id");
		echo json_encode("{status:'$bundle_rows'}");
	}

	function form_jenis_mblb($ref_mblb_id = null)
	{
		$this->admin_access_handler->check_access();
		if ($ref_mblb_id == null) {
			// show create form
			$view_folder = $this->active_controller;
			$this->_ci->load->view($view_folder . '/form_new_jenis_mblb');
		} else {
			// fetch data jenis mblb
			$bundle_rows = $this->dao->execute(0, "SELECT * FROM ref_jenis_mblb WHERE ref_mblb_id=$ref_mblb_id");
			$main_data['detail_jenis_mblb'] = $bundle_rows->result()[0];
			$data = array('main_params' => $main_data);
			$view_folder = $this->active_controller;
			$this->_ci->load->view($view_folder . '/form_jenis_mblb', $main_data);
		}
	}

	function add_jenis_mblb()
	{
		$this->admin_access_handler->check_access();
		$parampost = $this->security->xss_clean($this->input->post());

		$jenis_mblb = $parampost['jenis_mblb'];
		$tarif_kubik = $parampost['tarif_kubik'];
		$tarif_ton = $parampost['tarif_ton'];

		$getId = $this->dao->execute(0, "SELECT * FROM ref_jenis_mblb")->result_array();
		$ref_mblb_id = count($getId) + 1;
		$bundle_rows = $this->dao->execute(0, "INSERT INTO ref_jenis_mblb (ref_mblb_id, jenis_mblb, tarif_kubik, tarif_ton) VALUES ($ref_mblb_id, '$jenis_mblb', '$tarif_kubik', '$tarif_ton') ");

		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}

	function update_jenis_mblb()
	{
		$this->admin_access_handler->check_access();
		$parampost = $this->security->xss_clean($this->input->post());
		$ref_mblb_id = $parampost['ref_mblb_id'];
		$jenis_mblb = $parampost['jenis_mblb'];
		$tarif_kubik = $parampost['tarif_kubik'];
		$tarif_ton = $parampost['tarif_ton'];
		$bundle_rows = $this->dao->execute(0, "UPDATE ref_jenis_mblb SET jenis_mblb = '$jenis_mblb', tarif_kubik = '$tarif_kubik', tarif_ton = '$tarif_ton' WHERE ref_mblb_id = $ref_mblb_id");

		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}

	function delete_jenis_mblb($ref_mblb_id)
	{
		$this->admin_access_handler->check_access();
		$bundle_rows = $this->dao->execute(0, "DELETE FROM ref_jenis_mblb WHERE ref_mblb_id=$ref_mblb_id");
		echo json_encode("{status:'$bundle_rows'}");
	}

	function form_jenis_pemungutan($ref_jenput_id = null)
	{
		$this->admin_access_handler->check_access();
		if ($ref_jenput_id == null) {
			// show create form
			$jenis_spt = $this->dao->execute(0, "SELECT * FROM ref_jenis_spt")->result_array();
			$main_data['jenis_spt'] = $jenis_spt;
			$view_folder = $this->active_controller;
			$this->_ci->load->view($view_folder . '/form_new_jenis_pemungutan', $main_data);
		} else {
			// fetch data jenis pemungutan
			$bundle_rows = $this->dao->execute(0, "SELECT * FROM ref_jenis_pemungutan WHERE ref_jenput_id=$ref_jenput_id");
			$main_data['detail_jenis_pemungutan'] = $bundle_rows->result()[0];
			$jenis_spt = $this->dao->execute(0, "SELECT * FROM ref_jenis_spt")->result_array();
			$main_data['jenis_spt'] = $jenis_spt;
			$data = array('main_params' => $main_data);
			$view_folder = $this->active_controller;
			$this->_ci->load->view($view_folder . '/form_jenis_pemungutan', $main_data);
		}
	}

	function add_jenis_pemungutan()
	{
		$this->admin_access_handler->check_access();
		$parampost = $this->security->xss_clean($this->input->post());

		$jenis_pemungutan = $parampost['jenis_pemungutan'];
		$jenis_spt_id = $parampost['jenis_spt_id'];

		$getId = $this->dao->execute(0, "SELECT * FROM ref_jenis_pemungutan")->result_array();
		$ref_jenput_id = count($getId) + 1;
		$bundle_rows = $this->dao->execute(0, "INSERT INTO ref_jenis_pemungutan (ref_jenput_id, jenis_pemungutan, jenis_spt_id) VALUES ($ref_jenput_id, '$jenis_pemungutan', '$jenis_spt_id') ");

		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}

	function update_jenis_pemungutan()
	{
		$this->admin_access_handler->check_access();
		$parampost = $this->security->xss_clean($this->input->post());
		$ref_jenput_id = $parampost['ref_jenput_id'];
		$jenis_pemungutan = $parampost['jenis_pemungutan'];
		$jenis_spt_id = $parampost['jenis_spt_id'];
		$bundle_rows = $this->dao->execute(0, "UPDATE ref_jenis_pemungutan SET jenis_pemungutan = '$jenis_pemungutan', jenis_spt_id = '$jenis_spt_id' WHERE ref_jenput_id = $ref_jenput_id");

		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}

	function delete_jenis_pemungutan($ref_jenput_id)
	{
		$this->admin_access_handler->check_access();
		$bundle_rows = $this->dao->execute(0, "DELETE FROM ref_jenis_pemungutan WHERE ref_jenput_id=$ref_jenput_id");
		echo json_encode("{status:'$bundle_rows'}");
	}

	function form_jenis_restoran($ref_kode = null)
	{
		$this->admin_access_handler->check_access();
		if ($ref_kode == null) {
			// show create form
			$view_folder = $this->active_controller;
			$this->_ci->load->view($view_folder . '/form_new_jenis_restoran');
		} else {
			// fetch data jenis restoran
			$bundle_rows = $this->dao->execute(0, "SELECT * FROM ref_jenis_restoran WHERE ref_kode=$ref_kode");
			$main_data['detail_jenis_restoran'] = $bundle_rows->result()[0];
			$data = array('main_params' => $main_data);
			$view_folder = $this->active_controller;
			$this->_ci->load->view($view_folder . '/form_jenis_restoran', $main_data);
		}
	}

	function add_jenis_restoran()
	{
		$this->admin_access_handler->check_access();
		$parampost = $this->security->xss_clean($this->input->post());

		$jenis_restoran = $parampost['jenis_restoran'];

		$getId = $this->dao->execute(0, "SELECT * FROM ref_jenis_restoran")->result_array();
		$ref_kode = count($getId) + 1;
		$bundle_rows = $this->dao->execute(0, "INSERT INTO ref_jenis_restoran (ref_kode, jenis_restoran) VALUES ($ref_kode,'$jenis_restoran') ");

		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}

	function update_jenis_restoran()
	{
		$this->admin_access_handler->check_access();
		$parampost = $this->security->xss_clean($this->input->post());
		$ref_kode = $parampost['ref_kode'];
		$jenis_restoran = $parampost['jenis_restoran'];
		$bundle_rows = $this->dao->execute(0, "UPDATE ref_jenis_restoran SET jenis_restoran = '$jenis_restoran' WHERE ref_kode = $ref_kode");

		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}

	function delete_jenis_restoran($ref_kode)
	{
		$this->admin_access_handler->check_access();
		$bundle_rows = $this->dao->execute(0, "DELETE FROM ref_jenis_restoran WHERE ref_kode=$ref_kode");
		echo json_encode("{status:'$bundle_rows'}");
	}

	function form_jenis_sat($ref_jensat_id = null)
	{
		$this->admin_access_handler->check_access();
		if ($ref_jensat_id == null) {
			// show create form
			$view_folder = $this->active_controller;
			$this->_ci->load->view($view_folder . '/form_new_jenis_sat');
		} else {
			// fetch data jenis sat
			$bundle_rows = $this->dao->execute(0, "SELECT * FROM ref_jenis_sat WHERE ref_jensat_id=$ref_jensat_id");
			$main_data['detail_jenis_sat'] = $bundle_rows->result()[0];
			$data = array('main_params' => $main_data);
			$view_folder = $this->active_controller;
			$this->_ci->load->view($view_folder . '/form_jenis_sat', $main_data);
		}
	}

	function add_jenis_sat()
	{
		$this->admin_access_handler->check_access();
		$parampost = $this->security->xss_clean($this->input->post());

		$jenis_sat = $parampost['jenis_sat'];

		$getId = $this->dao->execute(0, "SELECT * FROM ref_jenis_sat")->result_array();
		$ref_jensat_id = count($getId) + 1;
		$bundle_rows = $this->dao->execute(0, "INSERT INTO ref_jenis_sat (ref_jensat_id, jenis_sat) VALUES ($ref_jensat_id,'$jenis_sat') ");

		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}

	function update_jenis_sat()
	{
		$this->admin_access_handler->check_access();
		$parampost = $this->security->xss_clean($this->input->post());
		$ref_jensat_id = $parampost['ref_jensat_id'];
		$jenis_sat = $parampost['jenis_sat'];
		$bundle_rows = $this->dao->execute(0, "UPDATE ref_jenis_sat SET jenis_sat = '$jenis_sat' WHERE ref_jensat_id = $ref_jensat_id");

		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}

	function delete_jenis_sat($ref_jensat_id)
	{
		$this->admin_access_handler->check_access();
		$bundle_rows = $this->dao->execute(0, "DELETE FROM ref_jenis_sat WHERE ref_jensat_id=$ref_jensat_id");
		echo json_encode("{status:'$bundle_rows'}");
	}

	function form_kelas_jalan($ref_kelas_jalan_id = null)
	{
		$this->admin_access_handler->check_access();
		if ($ref_kelas_jalan_id == null) {
			// show create form
			$view_folder = $this->active_controller;
			$this->_ci->load->view($view_folder . '/form_new_kelas_jalan');
		} else {
			// fetch data kelas jalan
			$bundle_rows = $this->dao->execute(0, "SELECT * FROM ref_kelas_jalan WHERE ref_kelas_jalan_id=$ref_kelas_jalan_id");
			$main_data['detail_kelas_jalan'] = $bundle_rows->result()[0];
			$data = array('main_params' => $main_data);
			$view_folder = $this->active_controller;
			$this->_ci->load->view($view_folder . '/form_kelas_jalan', $main_data);
		}
	}

	function add_kelas_jalan()
	{
		$this->admin_access_handler->check_access();
		$parampost = $this->security->xss_clean($this->input->post());

		$kelas_jalan = $parampost['kelas_jalan'];

		$getId = $this->dao->execute(0, "SELECT * FROM ref_kelas_jalan")->result_array();
		$ref_kelas_jalan_id = count($getId) + 1;
		$bundle_rows = $this->dao->execute(0, "INSERT INTO ref_kelas_jalan (ref_kelas_jalan_id, kelas_jalan) VALUES ($ref_kelas_jalan_id,'$kelas_jalan') ");

		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}

	function update_kelas_jalan()
	{
		$this->admin_access_handler->check_access();
		$parampost = $this->security->xss_clean($this->input->post());
		$ref_kelas_jalan_id = $parampost['ref_kelas_jalan_id'];
		$kelas_jalan = $parampost['kelas_jalan'];
		$bundle_rows = $this->dao->execute(0, "UPDATE ref_kelas_jalan SET kelas_jalan = '$kelas_jalan' WHERE ref_kelas_jalan_id = $ref_kelas_jalan_id");

		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}

	function delete_kelas_jalan($ref_kelas_jalan_id)
	{
		$this->admin_access_handler->check_access();
		$bundle_rows = $this->dao->execute(0, "DELETE FROM ref_kelas_jalan WHERE ref_kelas_jalan_id=$ref_kelas_jalan_id");
		echo json_encode("{status:'$bundle_rows'}");
	}

	function form_komponen_airtanah($ref_komponen_id = null)
	{
		$this->admin_access_handler->check_access();
		if ($ref_komponen_id == null) {
			// show create form
			$view_folder = $this->active_controller;
			$this->_ci->load->view($view_folder . '/form_new_komponen_airtanah');
		} else {
			// fetch data komponen air tanah
			$bundle_rows = $this->dao->execute(0, "SELECT * FROM ref_komponen_air_tanah WHERE ref_komponen_id=$ref_komponen_id");
			$main_data['detail_komponen_airtanah'] = $bundle_rows->result()[0];
			$data = array('main_params' => $main_data);
			$view_folder = $this->active_controller;
			$this->_ci->load->view($view_folder . '/form_komponen_airtanah', $main_data);
		}
	}

	function add_komponen_airtanah()
	{
		$this->admin_access_handler->check_access();
		$parampost = $this->security->xss_clean($this->input->post());

		$komponen = $parampost['komponen'];
		$bobot = $parampost['bobot'];

		$getId = $this->dao->execute(0, "SELECT * FROM ref_komponen_air_tanah")->result_array();
		$ref_komponen_id = count($getId) + 1;
		$bundle_rows = $this->dao->execute(0, "INSERT INTO ref_komponen_air_tanah (ref_komponen_id, komponen, bobot) VALUES ($ref_komponen_id,'$komponen', '$bobot') ");

		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}

	function update_komponen_airtanah()
	{
		$this->admin_access_handler->check_access();
		$parampost = $this->security->xss_clean($this->input->post());
		$ref_komponen_id = $parampost['ref_komponen_id'];
		$komponen = $parampost['komponen'];
		$bobot = $parampost['bobot'];
		$bundle_rows = $this->dao->execute(0, "UPDATE ref_komponen_air_tanah SET komponen = '$komponen', bobot = '$bobot' WHERE ref_komponen_id = $ref_komponen_id");

		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}

	function delete_komponen_airtanah($ref_komponen_id)
	{
		$this->admin_access_handler->check_access();
		$bundle_rows = $this->dao->execute(0, "DELETE FROM ref_komponen_air_tanah WHERE ref_komponen_id=$ref_komponen_id");
		echo json_encode("{status:'$bundle_rows'}");
	}

	function form_loket_pembayaran($ref_lokemba_id = null)
	{
		$this->admin_access_handler->check_access();
		if ($ref_lokemba_id == null) {
			// show create form
			$view_folder = $this->active_controller;
			$this->_ci->load->view($view_folder . '/form_new_loket_pembayaran');
		} else {
			// fetch data loket pembayaran
			$bundle_rows = $this->dao->execute(0, "SELECT * FROM ref_loket_pembayaran WHERE ref_lokemba_id=$ref_lokemba_id");
			$main_data['detail_loket_pembayaran'] = $bundle_rows->result()[0];
			$data = array('main_params' => $main_data);
			$view_folder = $this->active_controller;
			$this->_ci->load->view($view_folder . '/form_loket_pembayaran', $main_data);
		}
	}

	function add_loket_pembayaran()
	{
		$this->admin_access_handler->check_access();
		$parampost = $this->security->xss_clean($this->input->post());

		$loket_pembayaran = $parampost['loket_pembayaran'];
		$no_rekening = $parampost['no_rekening'];

		$getId = $this->dao->execute(0, "SELECT * FROM ref_loket_pembayaran")->result_array();
		$ref_lokemba_id = count($getId) + 1;
		$bundle_rows = $this->dao->execute(0, "INSERT INTO ref_loket_pembayaran (ref_lokemba_id, loket_pembayaran, no_rekening) VALUES ($ref_lokemba_id,'$loket_pembayaran', '$no_rekening') ");

		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}

	function update_loket_pembayaran()
	{
		$this->admin_access_handler->check_access();
		$parampost = $this->security->xss_clean($this->input->post());
		$ref_lokemba_id = $parampost['ref_lokemba_id'];
		$loket_pembayaran = $parampost['loket_pembayaran'];
		$no_rekening = $parampost['no_rekening'];
		$bundle_rows = $this->dao->execute(0, "UPDATE ref_loket_pembayaran SET loket_pembayaran = '$loket_pembayaran', no_rekening = '$no_rekening' WHERE ref_lokemba_id = $ref_lokemba_id");

		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}

	function delete_loket_pembayaran($ref_lokemba_id)
	{
		$this->admin_access_handler->check_access();
		$bundle_rows = $this->dao->execute(0, "DELETE FROM ref_loket_pembayaran WHERE ref_lokemba_id=$ref_lokemba_id");
		echo json_encode("{status:'$bundle_rows'}");
	}

	function form_uptd($ref_uptd_id = null)
	{
		$this->admin_access_handler->check_access();
		if ($ref_uptd_id == null) {
			// show create form
			$view_folder = $this->active_controller;
			$this->_ci->load->view($view_folder . '/form_new_uptd');
		} else {
			// fetch data uptd
			$bundle_rows = $this->dao->execute(0, "SELECT * FROM ref_uptd WHERE ref_uptd_id=$ref_uptd_id");
			$main_data['detail_uptd'] = $bundle_rows->result()[0];
			$data = array('main_params' => $main_data);
			$view_folder = $this->active_controller;
			$this->_ci->load->view($view_folder . '/form_uptd', $main_data);
		}
	}

	function add_uptd()
	{
		$this->admin_access_handler->check_access();
		$parampost = $this->security->xss_clean($this->input->post());

		$nama = $parampost['nama'];
		$uptd_alamat = $parampost['uptd_alamat'];

		$getId = $this->dao->execute(0, "SELECT * FROM ref_uptd")->result_array();
		$ref_uptd_id = count($getId) + 1;
		$bundle_rows = $this->dao->execute(0, "INSERT INTO ref_uptd (ref_uptd_id, nama, uptd_alamat) VALUES ($ref_uptd_id,'$nama', '$uptd_alamat') ");

		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}

	function update_uptd()
	{
		$this->admin_access_handler->check_access();
		$parampost = $this->security->xss_clean($this->input->post());
		$ref_uptd_id = $parampost['ref_uptd_id'];
		$nama = $parampost['nama'];
		$uptd_alamat = $parampost['uptd_alamat'];
		$bundle_rows = $this->dao->execute(0, "UPDATE ref_uptd SET nama = '$nama', uptd_alamat = '$uptd_alamat' WHERE ref_uptd_id = $ref_uptd_id");

		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}

	function delete_uptd($ref_uptd_id)
	{
		$this->admin_access_handler->check_access();
		$bundle_rows = $this->dao->execute(0, "DELETE FROM ref_uptd WHERE ref_uptd_id=$ref_uptd_id");
		echo json_encode("{status:'$bundle_rows'}");
	}

	function form_kegiatan_usaha($ref_kegus_id = null)
	{
		$this->admin_access_handler->check_access();
		if ($ref_kegus_id == null) {
			// show create form
			$jenis_pajak = $this->dao->execute(0, "SELECT bundel_id, nama_paret FROM bundel_pajak_retribusi WHERE status = 'management'");
			$main_data['jenis_pajak'] = $jenis_pajak;
			$data = array('main_params' => $main_data);
			$view_folder = $this->active_controller;
			$this->_ci->load->view($view_folder . '/form_new_kegiatan_usaha', $main_data);
		} else {
			// fetch data kegiatan usaha
			$bundle_rows = $this->dao->execute(0, "SELECT * FROM ref_kegiatan_usaha WHERE ref_kegus_id=$ref_kegus_id");
			$jenis_pajak = $this->dao->execute(0, "SELECT bundel_id, nama_paret FROM bundel_pajak_retribusi WHERE status = 'management'");
			$main_data['detail_kegiatan_usaha'] = $bundle_rows->result()[0];
			$main_data['jenis_pajak'] = $jenis_pajak;
			$data = array('main_params' => $main_data);
			$view_folder = $this->active_controller;
			$this->_ci->load->view($view_folder . '/form_kegiatan_usaha', $main_data);
		}
	}

	function add_kegiatan_usaha()
	{
		$this->admin_access_handler->check_access();
		$parampost = $this->security->xss_clean($this->input->post());

		$pajak_id = $parampost['pajak_id'];
		$nama_kegus = $parampost['nama_kegus'];
		$persen_tarif = $parampost['persen_tarif'];
		$tarif_dasar = $parampost['tarif_dasar'];
		$tarif_tambahan = $parampost['tarif_tambahan'];
		$volume_dasar = $parampost['volume_dasar'];
		$kode_rekening = $parampost['kode_rekening'];
		$status = TRUE;

		$get_kode_kegus = $this->dao->execute(0, "SELECT MAX (kode_kegus) FROM ref_kegiatan_usaha WHERE pajak_id = $pajak_id")->result()[0];
		$valuekode_kegus = $get_kode_kegus->max;
		$countkode_kegus = $valuekode_kegus + 1;
		$kode_kegus = sprintf("%02d", $countkode_kegus);

		$getId = $this->dao->execute(0, "SELECT * FROM ref_kegiatan_usaha")->result_array();
		$ref_kegus_id = count($getId) + 1;
		$bundle_rows = $this->dao->execute(0, "INSERT INTO ref_kegiatan_usaha (ref_kegus_id, pajak_id, nama_kegus, kode_kegus, persen_tarif, tarif_dasar, volume_dasar, tarif_tambahan, status, kode_rekening) VALUES ($ref_kegus_id,'$pajak_id', '$nama_kegus', '$kode_kegus', '$persen_tarif', '$tarif_dasar', '$volume_dasar', '$tarif_tambahan', '$status', '$kode_rekening') ");

		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}

	function update_kegiatan_usaha()
	{
		$this->admin_access_handler->check_access();
		$parampost = $this->security->xss_clean($this->input->post());
		$ref_kegus_id = $parampost['ref_kegus_id'];
		$pajak_id = $parampost['pajak_id'];
		$nama_kegus = $parampost['nama_kegus'];
		$persen_tarif = $parampost['persen_tarif'];
		$tarif_dasar = $parampost['tarif_dasar'];
		$tarif_tambahan = $parampost['tarif_tambahan'];
		$volume_dasar = $parampost['volume_dasar'];
		$kode_rekening = $parampost['kode_rekening'];
		$status = TRUE;

		$get_kode_kegus = $this->dao->execute(0, "SELECT MAX (kode_kegus) FROM ref_kegiatan_usaha WHERE pajak_id = $pajak_id")->result()[0];
		$valuekode_kegus = $get_kode_kegus->max;
		$countkode_kegus = $valuekode_kegus + 1;
		$kode_kegus = sprintf("%02d", $countkode_kegus);

		$bundle_rows = $this->dao->execute(0, "UPDATE ref_kegiatan_usaha SET pajak_id = '$pajak_id', nama_kegus = '$nama_kegus', kode_kegus = '$kode_kegus', persen_tarif = '$persen_tarif', tarif_dasar = '$tarif_dasar',  volume_dasar = '$volume_dasar', tarif_tambahan = '$tarif_tambahan', status = '$status', kode_rekening = '$kode_rekening' WHERE ref_kegus_id = $ref_kegus_id");

		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}

	function delete_kegiatan_usaha($ref_kegus_id)
	{
		$this->admin_access_handler->check_access();
		$bundle_rows = $this->dao->execute(0, "DELETE FROM ref_kegiatan_usaha WHERE ref_kegus_id=$ref_kegus_id");
		echo json_encode("{status:'$bundle_rows'}");
	}

	function form_target_pajak($id_target)
	{
		$this->admin_access_handler->check_access();
		// fetch data target pajak
		$bundle_rows = $this->dao->execute(0, "SELECT nama_paret, id_target, target_pajak FROM ref_target_pajak INNER JOIN bundel_pajak_retribusi
					 ON ref_target_pajak.kode_pajak=bundel_pajak_retribusi.kode_pajak WHERE id_target='$id_target'");
		$main_data['detail_target_pajak'] = $bundle_rows->result()[0];
		$data = array('main_params' => $main_data);
		$view_folder = $this->active_controller;
		$this->_ci->load->view($view_folder . '/form_target_pajak', $main_data);
	}

	function update_target_pajak()
	{
		$this->admin_access_handler->check_access();
		$parampost = $this->security->xss_clean($this->input->post());
		$id_target = $parampost['id_target'];
		$target_pajak = $parampost['target_pajak'];

		$bundle_rows = $this->dao->execute(0, "UPDATE ref_target_pajak SET target_pajak = '$target_pajak' WHERE id_target = '$id_target'");

		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}

	function form_target_wp($id_target)
	{
		$this->admin_access_handler->check_access();
		// fetch data target pajak
		$bundle_rows = $this->dao->execute(0, "SELECT nama_paret, id_target, target_wp FROM ref_target_wp INNER JOIN bundel_pajak_retribusi
					 ON ref_target_wp.kode_pajak=bundel_pajak_retribusi.kode_pajak WHERE id_target='$id_target'");
		$main_data['detail_target_wp'] = $bundle_rows->result()[0];
		$data = array('main_params' => $main_data);
		$view_folder = $this->active_controller;
		$this->_ci->load->view($view_folder . '/form_target_wp', $main_data);
	}

	function update_target_wp()
	{
		$this->admin_access_handler->check_access();
		$parampost = $this->security->xss_clean($this->input->post());
		$id_target = $parampost['id_target'];
		$target_wp = $parampost['target_wp'];

		$bundle_rows = $this->dao->execute(0, "UPDATE ref_target_wp SET target_wp = '$target_wp' WHERE id_target = '$id_target'");

		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}

	function form_pejabat_daerah($pejda_id = null)
	{
		$this->admin_access_handler->check_access();
		if ($pejda_id == null) {
			// show create form
			$jabatan = $this->dao->execute(0, "SELECT ref_japeda_id, nama_jabatan_id FROM ref_jabatan_pejabat_daerah");
			$main_data['jabatan'] = $jabatan;
			$golongan = $this->dao->execute(0, "SELECT ref_goru_id, pangkat FROM ref_gol_ruang");
			$main_data['golongan'] = $golongan;
			$data = array('main_params' => $main_data);
			$view_folder = $this->active_controller;
			$this->_ci->load->view($view_folder . '/form_new_pejabat_daerah', $main_data);
		} else {
			// fetch data kegiatan usaha
			$bundle_rows = $this->dao->execute(0, "SELECT a.pejda_id ,a.nama, a.nip, b.nama_jabatan_id as jabatan, c.pangkat FROM pejabat_daerah as a INNER JOIN ref_jabatan_pejabat_daerah as b ON a.japeda_id=ref_japeda_id INNER JOIN ref_gol_ruang as c ON a.goru_id=c.ref_goru_id WHERE pejda_id=$pejda_id");
			$main_data['detail_pejabat_daerah'] = $bundle_rows->result()[0];
			$jabatan = $this->dao->execute(0, "SELECT ref_japeda_id, nama_jabatan_id FROM ref_jabatan_pejabat_daerah");
			$main_data['jabatan'] = $jabatan;
			$golongan = $this->dao->execute(0, "SELECT ref_goru_id, pangkat FROM ref_gol_ruang");
			$main_data['golongan'] = $golongan;
			$data = array('main_params' => $main_data);
			$view_folder = $this->active_controller;
			$this->_ci->load->view($view_folder . '/form_pejabat_daerah', $main_data);
		}
	}

	function add_pejabat_daerah()
	{
		$this->admin_access_handler->check_access();
		$parampost = $this->security->xss_clean($this->input->post());

		$japeda_id = $parampost['japeda_id'];
		$goru_id = $parampost['goru_id'];
		$nama = $parampost['nama'];
		$nip = $parampost['nip'];
		$status = 't';

		$getId = $this->dao->execute(0, "SELECT MAX(pejda_id) as id FROM pejabat_daerah")->row_array();
		$pejda_id = $getId['id'] + 1;
		$bundle_rows = $this->dao->execute(0, "INSERT INTO pejabat_daerah (pejda_id, japeda_id, goru_id, nama, nip, status) VALUES ($pejda_id,'$japeda_id', '$goru_id', '$nama', '$nip', '$status') ");

		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}

	function update_pejabat_daerah()
	{
		$this->admin_access_handler->check_access();
		$parampost = $this->security->xss_clean($this->input->post());
		$pejda_id = $parampost['pejda_id'];
		$japeda_id = $parampost['japeda_id'];
		$goru_id = $parampost['goru_id'];
		$nama = $parampost['nama'];
		$nip = $parampost['nip'];
		$status = 't';

		$bundle_rows = $this->dao->execute(0, "UPDATE pejabat_daerah SET japeda_id = '$japeda_id', goru_id = '$goru_id', nama = '$nama', nip = '$nip' WHERE pejda_id = $pejda_id");

		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}

	function delete_pejabat_daerah($pejda_id)
	{
		$this->admin_access_handler->check_access();
		$bundle_rows = $this->dao->execute(0, "DELETE FROM pejabat_daerah WHERE pejda_id=$pejda_id");
		echo json_encode("{status:'success'}");
	}
}
