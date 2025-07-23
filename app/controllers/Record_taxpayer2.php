<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'controllers' . DIRECTORY_SEPARATOR . 'Item_bundle_parent.php';

class record_taxpayer2 extends item_bundle_parent
{


	function __construct($bundle_type, $bundle_item_type, $menu)
	{

		//bundle_type => taxes,duties
		//bundle_item_type => hotel,restaurant,entertainment,etc
		//menu => record_taxpayer1,record_taxpayer2,etc			
		parent::__construct($bundle_type, $bundle_item_type, $menu, __CLASS__);
		$this->subject_type = '2';
		$this->default_status = 'TRUE';
	}


	function index()
	{
		$this->_ci->admin_access_handler->check_access();

		$district_rows = $this->_ci->database_interactions->get_district_rows();

		$system_params = $this->_ci->database_interactions->get_system_params();

		$main_data = array(
			'bundle_row' => $this->bundle_row,
			'api_key' => ($system_params[9] == '-' ? '' : $system_params[9]),
			'district_rows' => $district_rows,
			'subject_type' => $this->subject_type
		);

		// no need to modified
		$data = array(
			'menu_params' => $this->menu_params,
			'main_params' => array_merge($this->main_params, $main_data)
		);


		$this->_ci->public_template->render($this->view_folder . '/index', $data);
	}


	function form_taxobject_map()
	{
		$act = 'edit';
		$id_value = $_POST['id'];
		$wp_wr_id = $_POST['wp_wr_id'];
		$menu = $_POST['menu'];

		$this->_ci->load->model(array('wp_wr_detil_model'));
		$m = $this->_ci->wp_wr_detil_model;

		$curr_data = $this->dao->get_data_by_id($act, $m, $id_value);

		$form4_id = "form4-id";

		$data = array(
			'curr_data' => $curr_data,
			'id_value' => $id_value,
			'wp_wr_id' => $wp_wr_id,
			'form4_id' => $form4_id,
			'bundle_type' => $this->bundle_type,
			'bundle_item_type' => $this->bundle_item_type,
			'menu' => $menu,
		);

		$view_folder = $this->bundle_type . '/' . $menu;

		$this->_ci->load->view($view_folder . '/form_taxobject_map', $data);
	}

	function form_taxpayer_detail()
	{
		$act = $_POST['act'];
		$menu = $_POST['menu'];
		$wp_wr_id = $_POST['wp_wr_id'];

		$this->_ci->load->model(array('wp_wr_detil_model'));
		$m1 = $this->_ci->wp_wr_detil_model;

		$id_value = ($act == 'edit' ? $_POST['id'] : '');
		$curr_data = $this->dao->get_data_by_id($act, $m1, $id_value);

		$tax_rows = $this->dao->execute(0, "SELECT * FROM bundel_pajak_retribusi WHERE tipe='pajak' AND status='management' ORDER BY bundel_id ASC")->result_array();

		$district_rows = $this->_ci->database_interactions->get_district_rows();
		$business_type_rows = array();
		$village_rows = array();
		$system_params = $this->_ci->database_interactions->get_system_params();

		if ($act == 'edit') {
			$business_type_rows = $this->dao->execute(0, "SELECT * FROM ref_kegiatan_usaha WHERE pajak_id='" . $curr_data['pajak_id'] . "' ORDER BY ref_kegus_id ASC")->result_array();
			$village_rows = $this->_ci->database_interactions->get_village_rows($curr_data['kecamatan_id']);
		}

		$advanced_form = $this->get_advanced_form($act, ($act == 'edit' ? $curr_data['pajak_id'] : ''), $id_value, $menu);

		$form2_id = "form2-id";

		$data = array(
			'act' => $act,
			'menu' => $menu,
			'curr_data' => $curr_data,
			'id_value' => $id_value,
			'wp_wr_id' => $wp_wr_id,
			'system_params' => $system_params,
			'form2_id' => $form2_id,
			'bundle_type' => $this->bundle_type,
			'bundle_item_type' => $this->bundle_item_type,
			'tax_rows' => $tax_rows,
			'business_type_rows' => $business_type_rows,
			'district_rows' => $district_rows,
			'village_rows' => $village_rows,
			'advanced_form' => $advanced_form,
		);

		$view_folder = $this->bundle_type . '/' . $menu;

		$this->_ci->load->view($view_folder . '/form_taxpayer_detail', $data);
	}

	function get_advanced_form($act, $tax_id, $wp_wr_detil_id, $menu)
	{

		$curr_data = array();

		$hotel_type_rows = $this->dao->execute(0, "SELECT * FROM ref_gol_hotel")->result_array();
		$resto_type_rows = $this->dao->execute(0, "SELECT * FROM ref_jenis_restoran")->result_array();

		$room_types1 = array('standar' => 'Standar', 'standar_ac' => 'Standar AC', 'double' => 'Double/Twin', 'superior' => 'Superior');
		$room_types2 = array('delux' => 'Delux', 'executive_suite' => 'Executive Suite', 'club_room' => 'Club Room', 'apartment' => 'Apartment');

		$water_source_type_rows = $this->dao->execute(0, "SELECT * FROM ref_jenis_sat ORDER BY ref_jensat_id ASC")->result_array();
		$water_type_rows = $this->dao->execute(0, "SELECT * FROM ref_harga_air_baku ORDER BY ref_hrgab_id ASC")->result_array();
		$sda_component_rows = $this->dao->execute(0, "SELECT ref_kompsda_id,kriteria FROM ref_komponen_sda_air_tanah ORDER BY ref_kompsda_id ASC")->result_array();
		$compensation_component_rows = $this->dao->execute(0, "SELECT ref_kompkom_id,peruntukan FROM ref_komponen_kompensasi_air_tanah ORDER BY ref_kompkom_id ASC")->result_array();

		$advanced_form2_content1 = false;
		$advanced_form2_content2 = false;
		$advanced_form2_content3 = false;


		if ($act == 'edit') {
			$advanced_form2_content1 = ($tax_id == '1');
			$advanced_form2_content2 = ($tax_id == '2');
			$advanced_form2_content3 = ($tax_id == '7');
		}

		$this->_ci->load->model(array('wp_wr_hotel_model', 'wp_wr_restoran_model', 'wp_wr_air_tanah_model'));

		$m1 = $this->_ci->{'wp_wr_hotel_model'};
		$m2 = $this->_ci->{'wp_wr_restoran_model'};
		$m3 = $this->_ci->{'wp_wr_air_tanah_model'};

		$curr_data1 = $this->dao->get_data_by_id(($tax_id == '1' ? $act : 'add'), $m1, array('wp_wr_detil_id' => $wp_wr_detil_id));
		$curr_data2 = $this->dao->get_data_by_id(($tax_id == '2' ? $act : 'add'), $m2, array('wp_wr_detil_id' => $wp_wr_detil_id));
		$curr_data3 = $this->dao->get_data_by_id(($tax_id == '7' ? $act : 'add'), $m3, array('wp_wr_detil_id' => $wp_wr_detil_id));

		$data['act'] = $act;
		$data['hotel_type_rows'] = $hotel_type_rows;
		$data['resto_type_rows'] = $resto_type_rows;
		$data['room_types1'] = $room_types1;
		$data['room_types2'] = $room_types2;
		$data['water_source_type_rows'] = $water_source_type_rows;
		$data['water_type_rows'] = $water_type_rows;
		$data['sda_component_rows'] = $sda_component_rows;
		$data['compensation_component_rows'] = $compensation_component_rows;

		$data['advanced_form2_content1'] = $advanced_form2_content1;
		$data['advanced_form2_content2'] = $advanced_form2_content2;
		$data['advanced_form2_content3'] = $advanced_form2_content3;
		$data['curr_data1'] = $curr_data1;
		$data['curr_data2'] = $curr_data2;
		$data['curr_data3'] = $curr_data3;

		$view_folder = $this->bundle_type . '/' . $menu;
		return $this->_ci->load->view($view_folder . '/advanced_form', $data, true);
	}

	function form()
	{

		$this->_ci->admin_access_handler->check_access();

		$act = $_POST['act'];
		$menu = $_POST['menu'];
		$showed = $_POST['showed'];

		$res = $menu . '_resources';
		require_once APPPATH . 'libraries' . DIRECTORY_SEPARATOR . 'system_resources' . DIRECTORY_SEPARATOR . $res . '.php';

		$tbl_name = $res::$_TBL_NAME;
		$pk = $res::$_PK;

		$this->_ci->load->model(array($tbl_name . '_model'));

		$m = $this->_ci->{$tbl_name . '_model'};
		$id_value = ($act == 'edit' ? $_POST['id'] : '');

		$curr_data = $this->dao->get_data_by_id($act, $m, $id_value);

		$main_form_id = "main-form-id";
		$view_folder = $this->bundle_type . '/' . $menu;

		$system_params = $this->_ci->database_interactions->get_system_params();
		$district_rows = $this->_ci->database_interactions->get_district_rows();
		$village_rows = array();

		$wp_wr_detil_id = '';

		if ($act == 'edit') {
			$village_rows = $this->_ci->database_interactions->get_village_rows($curr_data['kecamatan_id']);
			$wp_wr_detil_id = trim($_POST['wp_wr_detil_id']);
		}

		$sql = "SELECT * FROM ref_kegiatan_usaha WHERE pajak_id='" . $this->bundle_id . "' ORDER BY ref_kegus_id ASC";
		$business_type_rows = $this->dao->execute(0, $sql)->result_array();

		$metode_transaksi = "SELECT * FROM ref_method_transak ORDER BY metod_trans_id ASC";
		$metode_transaksi_result = $this->dao->execute(0, $metode_transaksi)->result_array();

		$src_params = array();
		foreach ($_POST as $key => $val) {
			$x = explode('-', $key);
			if ($x[0] == 'src' and $val != '') {
				$field = $x[1];
				$src_params[$field] = $val;
			}
		}

		$data_form_content1 = array(
			'curr_data' => $curr_data,
			'id_value' => $id_value,
			'wp_wr_detil_id' => $wp_wr_detil_id,
			'menu' => $menu,
			'main_form_id' => $main_form_id,
			'showed' => $showed,
			'src_params' => $src_params,
			'bundle_name' => $this->bundle_row['nama_paret'],
			'bundle_id' => $this->bundle_id,
			'district_rows' => $district_rows,
			'system_params' => $system_params,
			'village_rows' => $village_rows,
			'business_type_rows' => $business_type_rows,
			'metode_transaksi_result' => $metode_transaksi_result,
		);

		if ($this->bundle_id == '1') {
			$this->_ci->load->model('wp_wr_hotel_model');
			$m2 = $this->_ci->wp_wr_hotel_model;

			$curr_data2 = $this->dao->get_data_by_id($act, $m2, array('wp_wr_detil_id' => $wp_wr_detil_id));

			$room_types1 = array('standar' => 'Standar', 'standar_ac' => 'Standar AC', 'double' => 'Double/Twin', 'superior' => 'Superior');
			$room_types2 = array('delux' => 'Delux', 'executive_suite' => 'Executive Suite', 'club_room' => 'Club Room', 'apartment' => 'Apartment');
			$hotel_type_rows = $this->dao->execute(0, "SELECT * FROM ref_gol_hotel")->result_array();

			$data_form_content1['hotel_type_rows'] = $hotel_type_rows;
			$data_form_content1['curr_data2'] = $curr_data2;
			$data_form_content1['room_types1'] = $room_types1;
			$data_form_content1['room_types2'] = $room_types2;
		}
		if ($this->bundle_id == '2') {
			$this->_ci->load->model('wp_wr_restoran_model');
			$m2 = $this->_ci->wp_wr_restoran_model;
			$curr_data2 = $this->dao->get_data_by_id($act, $m2, array('wp_wr_detil_id' => $wp_wr_detil_id));

			$resto_type_rows = $this->dao->execute(0, "SELECT * FROM ref_jenis_restoran")->result_array();

			$data_form_content1['resto_type_rows'] = $resto_type_rows;
			$data_form_content1['curr_data2'] = $curr_data2;
		}
		if ($this->bundle_id == '7') {
			$this->_ci->load->model('wp_wr_air_tanah_model');
			$m2 = $this->_ci->wp_wr_air_tanah_model;
			$curr_data2 = $this->dao->get_data_by_id($act, $m2, array('wp_wr_detil_id' => $wp_wr_detil_id));

			$water_source_type_rows = $this->dao->execute(0, "SELECT * FROM ref_jenis_sat ORDER BY ref_jensat_id ASC")->result_array();
			$sda_component_rows = $this->dao->execute(0, "SELECT ref_kompsda_id,kriteria FROM ref_komponen_sda_air_tanah ORDER BY ref_kompsda_id ASC")->result_array();
			$compensation_component_rows = $this->dao->execute(0, "SELECT ref_kompkom_id,peruntukan FROM ref_komponen_kompensasi_air_tanah ORDER BY ref_kompkom_id ASC")->result_array();
			$water_type_rows = $this->dao->execute(0, "SELECT * FROM ref_harga_air_baku ORDER BY ref_hrgab_id ASC")->result_array();

			$data_form_content1['water_source_type_rows'] = $water_source_type_rows;
			$data_form_content1['sda_component_rows'] = $sda_component_rows;
			$data_form_content1['compensation_component_rows'] = $compensation_component_rows;
			$data_form_content1['water_type_rows'] = $water_type_rows;
			$data_form_content1['curr_data2'] = $curr_data2;
		}

		$extra_main_data = array('data_form_content1' => $data_form_content1);

		if ($act == 'edit') {

			$list_data_taxpayer_detail = $this->print_list_data_taxpayer_detail($id_value, $menu);
			$data_form_content2 = array(
				'list_data' => $list_data_taxpayer_detail,
				'menu' => $menu,
				'wp_wr_id' => $id_value,
			);

			$list_data_taxobject_image = $this->print_list_data_taxobject_image($id_value, $menu);
			$data_form_content3 = array(
				'list_data' => $list_data_taxobject_image,
				'bundle_type' => $this->bundle_type,
				'bundle_item_type' => $this->bundle_item_type,
				'menu' => $menu,
				'wp_wr_id' => $id_value,
				'form3_id' => 'form3_id',
			);

			$print_list_data_taxobject_map = $this->print_list_data_taxobject_map($id_value, $menu);
			$data_form_content4 = array('list_data' => $print_list_data_taxobject_map);

			$extra_main_data = array_merge($extra_main_data, array('data_form_content2' => $data_form_content2, 'data_form_content3' => $data_form_content3, 'data_form_content4' => $data_form_content4));
		}

		$main_data = array_merge(array(
			'act' => $act,
			'curr_data' => $curr_data,
			'id_value' => $id_value,
			'menu' => $menu,
			'main_form_id' => $main_form_id,
			'showed' => $showed,
			'src_params' => $src_params,
			'view_folder' => $view_folder,
		), $extra_main_data);

		$main_data = array_merge($this->main_params, $main_data);

		$data = array_merge($this->main_params, $main_data);

		$this->_ci->load->view($view_folder . '/form', $data);
	}

	function nonnpwpd()
	{

		$view_folder = $this->bundle_type . '/record_taxpayer2';
		$pajak_id = $_POST['pajak_id'];

		$sql = "SELECT a.wp_wr_form_id,a.no_form,a.nama,a.alamat,a.kecamatan,a.kelurahan,
									to_char(a.tgl_kirim,'dd-mm-yyyy') as tgl_kirim, 
									to_char(a.tgl_kembali,'dd-mm-yyyy') as tgl_kembali,
									(CASE a.status WHEN '0' THEN 'Dikirim' WHEN '1' THEN 'Kembali' ELSE 'Tidak Kembali' END) as status,
									b.nama_kegus FROM wp_wr_formulir as a 
									LEFT JOIN ref_kegiatan_usaha as b ON (a.kegus_id=b.ref_kegus_id) WHERE a.pajak_id = '" . $pajak_id . "'";

		$list_nonnpwpd = $this->dao->execute(0, $sql)->result_array();

		$data = [
			'list_nonnpwpd' => $list_nonnpwpd
		];

		$this->_ci->load->view($view_folder . '/nonnpwpd', $data);
	}

	function addnonnpwpd()
	{

		$view_folder = $this->bundle_type . '/record_taxpayer2';

		$id = $_POST['id'];

		$sql = "SELECT nama, alamat, kelurahan_id, kecamatan_id, kelurahan, kecamatan, kabupaten, tgl_kirim, tgl_kembali, created_by, created_time,
				 pajak_id, kegus_id FROM wp_wr_formulir
				WHERE wp_wr_form_id = '" . $id . "'";

		$get_wp_non_npwpd = $this->dao->execute(0, $sql)->row_array();

		$sql_max_wp_id = "SELECT MAX(wp_wr_id) FROM wp_wr";
		$get_max_wp_id = $this->dao->execute(0, $sql_max_wp_id)->row_array();

		$sql_max_wp_detil_id = "SELECT MAX(wp_wr_detil_id) FROM wp_wr_detil";
		$get_max_wp_detil_id = $this->dao->execute(0, $sql_max_wp_detil_id)->row_array();

		$sql_max_wp_restoran_id = "SELECT MAX(wp_wr_restoran_id) FROM wp_wr_restoran";
		$get_max_wp_restoran_id = $this->dao->execute(0, $sql_max_wp_restoran_id)->row_array();

		$sql_max_wp_hotel_id = "SELECT MAX(wp_wr_hotel_id) FROM wp_wr_hotel";
		$get_max_wp_hotel_id = $this->dao->execute(0, $sql_max_wp_hotel_id)->row_array();

		$sql_max_wp_abt_id = "SELECT MAX(wp_wr_air_tanah_id) FROM wp_wr_air_tanah";
		$get_max_wp_abt_id = $this->dao->execute(0, $sql_max_wp_abt_id)->row_array();

		$explode_kd_kecamatan = substr($get_wp_non_npwpd['kecamatan_id'], -3);
		$explode_kd_kelurahan = substr($get_wp_non_npwpd['kelurahan_id'], -3);

		$sql_kegus_code = "SELECT kode_kegus FROM ref_kegiatan_usaha WHERE ref_kegus_id = '" . $get_wp_non_npwpd['kegus_id'] . "'";
		$get_kegus_code = $this->dao->execute(0, $sql_kegus_code)->row_array();

		$wp_wr_id = $get_max_wp_id['max'] + 1;
		$wp_wr_detil_id = $get_max_wp_detil_id['max'] + 1;
		$wp_wr_restoran_id = $get_max_wp_restoran_id['max'] + 1;
		$wp_wr_hotel_id = $get_max_wp_hotel_id['max'] + 1;
		$wp_wr_abt_id = $get_max_wp_abt_id['max'] + 1;
		$jenis = 'p';
		$golongan = '2';
		$npwprd = $this->_ci->database_interactions->generate_npwprd($explode_kd_kecamatan, $explode_kd_kelurahan, $this->bundle_code, $get_kegus_code['kode_kegus']);
		$nama = $get_wp_non_npwpd['nama'];
		$alamat = $get_wp_non_npwpd['alamat'];
		$kelurahan_id = $get_wp_non_npwpd['kelurahan_id'];
		$kecamatan_id = $get_wp_non_npwpd['kecamatan_id'];
		$kelurahan = $get_wp_non_npwpd['kelurahan'];
		$kecamatan = $get_wp_non_npwpd['kecamatan'];
		$kabupaten = $get_wp_non_npwpd['kabupaten'];
		$no_telepon = '-';
		$tgl_pendaftaran = $get_wp_non_npwpd['tgl_kirim'];
		$tgl_terima_form = $get_wp_non_npwpd['tgl_kirim'];
		$tgl_bts_kirim = $get_wp_non_npwpd['tgl_kirim'];
		$tgl_form_kembali = $get_wp_non_npwpd['tgl_kembali'];
		$created_by = $get_wp_non_npwpd['created_by'];
		$created_time = $get_wp_non_npwpd['created_time'];
		$modified_time = $get_wp_non_npwpd['tgl_kirim'];
		$status = 't';
		$pajak_id = $get_wp_non_npwpd['pajak_id'];
		$kegus_id = $get_wp_non_npwpd['kegus_id'];

		// insert tabel wp_wr
		$sql_wp_wr = "INSERT INTO wp_wr (wp_wr_id, jenis, golongan, npwprd, nama, alamat, kelurahan_id, kecamatan_id, kelurahan, kecamatan, kabupaten,
						no_telepon, tgl_pendaftaran, tgl_terima_form, tgl_bts_kirim, tgl_form_kembali, created_by, created_time, modified_time, status, pajak_id, kegus_id)
						VALUES ('" . $wp_wr_id . "', '" . $jenis . "', '" . $golongan . "', '" . $npwprd . "', '" . $nama . "', '" . $alamat . "', '" . $kelurahan_id . "', '" . $kecamatan_id . "', '" . $kelurahan . "',
						'" . $kecamatan . "', '" . $kabupaten . "', '" . $no_telepon . "', '" . $tgl_pendaftaran . "', '" . $tgl_terima_form . "', '" . $tgl_bts_kirim . "', 
						'" . $tgl_form_kembali . "', '" . $created_by . "', '" . $created_time . "', '" . $modified_time . "', '" . $status . "', '" . $pajak_id . "', '" . $kegus_id . "')";

		$this->dao->execute(0, $sql_wp_wr);

		//insert tabel wp_wr_detil
		$sql_wp_wr_detil = "INSERT INTO wp_wr_detil (wp_wr_detil_id, wp_wr_id, pajak_id, kegus_id, nama, alamat, kelurahan_id, kecamatan_id, kelurahan, kecamatan, kabupaten,
							no_telepon, tgl_pendaftaran, tgl_terima_form, tgl_bts_kirim, utama, created_by, created_time, modified_time)
						VALUES ('" . $wp_wr_detil_id . "', '" . $wp_wr_id . "', '" . $pajak_id . "', '" . $kegus_id . "', '" . $nama . "', '" . $alamat . "', '" . $kelurahan_id . "', '" . $kecamatan_id . "', '" . $kelurahan . "',
						'" . $kecamatan . "', '" . $kabupaten . "', '" . $no_telepon . "', '" . $tgl_pendaftaran . "', '" . $tgl_terima_form . "', '" . $tgl_bts_kirim . "', '" . $status . "', '" . $created_by . "', '" . $created_time . "', '" . $modified_time . "')";

		$this->dao->execute(0, $sql_wp_wr_detil);

		// insert tabel pajak detail
		if ($pajak_id == '1') {
			$sql_wp_wr_hotel = "INSERT INTO wp_wr_hotel (wp_wr_hotel_id, wp_wr_id, wp_wr_detil_id, golongan_hotel, jumlah_kamar)
						VALUES ('" . $wp_wr_hotel_id . "', '" . $wp_wr_id . "', '" . $wp_wr_detil_id . "', 6, 0)";

			$this->dao->execute(0, $sql_wp_wr_hotel);
		}
		if ($pajak_id == '2') {
			$sql_wp_wr_restoran = "INSERT INTO wp_wr_restoran (wp_wr_restoran_id, wp_wr_id, wp_wr_detil_id, jenis_restoran, jumlah_meja, jumlah_kursi, kapasitas_pengunjung, jumlah_karyawan)
						VALUES ('" . $wp_wr_restoran_id . "', '" . $wp_wr_id . "', '" . $wp_wr_detil_id . "', 4, 0, 0, 0, 0)";

			$this->dao->execute(0, $sql_wp_wr_restoran);
		}
		if ($pajak_id == '7') {
			$sql_wp_wr_air_tanah = "INSERT INTO wp_wr_air_tanah (wp_wr_air_tanah_id, wp_wr_id, wp_wr_detil_id, jenis_sat_id, kompkom_id)
						VALUES ('" . $wp_wr_abt_id . "', '" . $wp_wr_id . "', '" . $wp_wr_detil_id . "', 1, 12)";

			$this->dao->execute(0, $sql_wp_wr_air_tanah);
		}
		echo "Sukses";
	}

	function delete_record()
	{
		$id = $_POST['id'];
		$act = $_POST['act'];
		$menu = $_POST['menu'];

		$access = $this->_ci->public_template->get_access_privileges('delete', $menu, $this->bundle_id);

		if ($access == '1') {

			$res = $menu . '_resources';
			require_once APPPATH . 'libraries' . DIRECTORY_SEPARATOR . 'system_resources' . DIRECTORY_SEPARATOR . $res . '.php';

			$tbl_name = $res::$_TBL_NAME;
			$pk = $res::$_PK;

			$this->_ci->load->model(array($tbl_name . '_model'));
			$m = $this->_ci->{$tbl_name . '_model'};

			$this->_ci->db->trans_begin();

			$cond_params = array($pk => $id);

			$result = $this->dao->delete($m, $cond_params);
			if (!$result) {
				$this->_ci->db->trans_rollback();
				die('ERROR: gagal menghapus data');
			}

			$this->_ci->load->model(array(
				'wp_wr_detil_model', 'wp_wr_gambar_model', 'wp_wr_hotel_model', 'wp_wr_restoran_model',
				'wp_wr_air_tanah_model'
			));

			$m2_1 = $this->_ci->wp_wr_detil_model;
			$m2_2 = $this->_ci->wp_wr_gambar_model;
			$m2_3 = $this->_ci->wp_wr_hotel_model;
			$m2_4 = $this->_ci->wp_wr_restoran_model;
			$m2_5 = $this->_ci->wp_wr_air_tanah_model;


			$result = $this->dao->delete($m2_1, $cond_params);
			if (!$result) {
				$this->_ci->db->trans_rollback();
				die('ERROR: gagal menghapus data');
			}

			$result = $this->dao->delete($m2_2, $cond_params);
			if (!$result) {
				$this->_ci->db->trans_rollback();
				die('ERROR: gagal menghapus data');
			}

			$result = $this->dao->delete($m2_3, $cond_params);
			if (!$result) {
				$this->_ci->db->trans_rollback();
				die('ERROR: gagal menghapus data');
			}

			$result = $this->dao->delete($m2_4, $cond_params);
			if (!$result) {
				$this->_ci->db->trans_rollback();
				die('ERROR: gagal menghapus data');
			}

			$result = $this->dao->delete($m2_5, $cond_params);
			if (!$result) {
				$this->_ci->db->trans_rollback();
				die('ERROR: gagal menghapus data');
			}

			$this->_ci->db->trans_commit();

			$cond_params = array_merge(
				array('a.pajak_id' => $this->bundle_id, 'a.golongan' => $this->subject_type, 'a.status' => $this->default_status),
				$this->collect_cond_params($_POST, 'src_params')
			);

			$this->print_list_data($menu, $cond_params);
		} else {
			$this->_ci->load->view('errors/html/error_403', array('type' => $act));
		}
	}

	function delete_taxobject_image()
	{
		$id = $_POST['id'];
		$menu = $_POST['menu'];
		$wp_wr_id = $_POST['wp_wr_id'];
		$filename = $_POST['filename'];

		$access = $this->_ci->public_template->get_access_privileges('delete', $menu, $this->bundle_id);

		if ($access == '1') {

			$this->_ci->load->model('wp_wr_gambar_model');
			$m = $this->_ci->wp_wr_gambar_model;

			$result = $this->dao->delete($m, array('wp_wr_gambar_id' => $id));
			if (!$result) {
				die('ERROR: gagal menghapus data');
			}

			$upload_dir = 'uploads/tax_objects';

			if (file_exists($upload_dir . '/' . $filename)) {
				unlink($upload_dir . '/' . $filename);
			}

			$this->print_list_data_taxobject_image($wp_wr_id, $menu, false);
		} else {
			$this->_ci->load->view('errors/html/error_403', array('type' => 'delete'));
		}
	}

	function delete_record_taxpayer_detail()
	{
		$id = $_POST['id'];
		$menu = $_POST['menu'];
		$wp_wr_id = $_POST['wp_wr_id'];

		$access = $this->_ci->public_template->get_access_privileges('delete', $menu, $this->bundle_id);

		if ($access == '1') {

			$this->_ci->load->model(array('wp_wr_detil_model', 'wp_wr_hotel_model', 'wp_wr_restoran_model', 'wp_wr_air_tanah_model'));

			$m1 = $this->_ci->wp_wr_detil_model;
			$m2 = $this->_ci->wp_wr_hotel_model;
			$m3 = $this->_ci->wp_wr_restoran_model;
			$m4 = $this->_ci->wp_wr_air_tanah_model;

			$this->_ci->db->trans_begin();

			$cond_params = array('wp_wr_detil_id' => $id);

			$result = $this->dao->delete($m1, $cond_params);
			if (!$result) {
				$this->_ci->db->trans_rollback();
				die('ERROR: gagal menghapus data');
			}

			$result = $this->dao->delete($m2, $cond_params);
			if (!$result) {
				$this->_ci->db->trans_rollback();
				die('ERROR: gagal menghapus data');
			}

			$result = $this->dao->delete($m3, $cond_params);
			if (!$result) {
				$this->_ci->db->trans_rollback();
				die('ERROR: gagal menghapus data');
			}

			$result = $this->dao->delete($m4, $cond_params);
			if (!$result) {
				$this->_ci->db->trans_rollback();
				die('ERROR: gagal menghapus data');
			}

			$this->_ci->db->trans_commit();

			$this->print_list_data_taxpayer_detail($wp_wr_id, $menu, false);
		} else {
			$this->_ci->load->view('errors/html/error_403', array('type' => 'delete'));
		}
	}

	//new add
	function submit_form_taxobject_map()
	{
		$this->_ci->admin_access_handler->check_access();

		$act = 'edit';
		$id_value = $_POST['id_value'];
		$menu = $_POST['menu'];
		$wp_wr_id = $_POST['wp_wr_id'];

		$access = $this->_ci->public_template->get_access_privileges('update', $menu, $this->bundle_id);

		if ($access == '1') {
			$this->_ci->load->model('wp_wr_detil_model');
			$m = $this->_ci->wp_wr_detil_model;

			$input_params = $this->collect_input_params($_POST, 'input5');

			$this->delegate_postTomodel($input_params, $m);

			$result = $this->dao->update($m, array('wp_wr_detil_id' => $id_value));

			if (!$result) {
				die('ERROR: gagal merubah data');
			}

			$this->print_list_data_taxobject_map($wp_wr_id, $menu, false);
		} else {
			$this->_ci->load->view('errors/html/error_403', array('type' => $act));
		}
	}

	function submit_form_taxpayer_detail()
	{

		$this->_ci->admin_access_handler->check_access();
		$act = $_POST['act'];
		$id_value = $_POST['id_value'];
		$menu = $_POST['menu'];
		$wp_wr_id = $_POST['wp_wr_id'];

		if ($act == 'add') {
			$access = $this->_ci->public_template->get_access_privileges('add', $menu, $this->bundle_id);
		} else {
			$access = $this->_ci->public_template->get_access_privileges('update', $menu, $this->bundle_id);
		}

		if ($access == '1') {
			$this->_ci->load->model('wp_wr_detil_model');
			$m = $this->_ci->wp_wr_detil_model;

			$input_params = $this->collect_input_params($_POST, 'input2');

			$x_district = explode('_', $input_params['kecamatan']);
			$x_village = explode('_', $input_params['kelurahan']);
			$x_business = explode('_', $input_params['kegus_id']);

			$input_params['kecamatan_id'] = $x_district[0];
			$input_params['kelurahan_id'] = $x_village[0];
			$input_params['kecamatan'] = $x_district[1];
			$input_params['kelurahan'] = $x_village[1];

			$bundle_id = $_POST['input2-pajak_id'];

			if ($bundle_id == '1') {
				$this->_ci->load->model('wp_wr_hotel_model');
				$m2 = $this->_ci->wp_wr_hotel_model;
				$type_dtl_name = 'hotel';

				$input_params2 = $this->collect_input_params($_POST, 'input3');
				// var_dump($input_params2);
				// die();
			}
			if ($bundle_id == '2') {

				$this->_ci->load->model('wp_wr_restoran_model');
				$m2 = $this->_ci->wp_wr_restoran_model;
				$type_dtl_name = 'restoran';

				$input_params2 = $this->collect_input_params($_POST, 'input3');
			} else if ($bundle_id == '7') {
				$this->_ci->load->model('wp_wr_air_tanah_model');
				$m2 = $this->_ci->wp_wr_air_tanah_model;
				$type_dtl_name = 'air_tanah';

				$input_params2 = $this->collect_input_params($_POST, 'input3');
			}

			$bundle_need_trans = array('1', '2', '7');

			if (in_array($bundle_id, $bundle_need_trans)) {
				$this->_ci->db->trans_begin();
			}

			if ($act == 'add') {

				$input_params['wp_wr_id'] = $_POST['wp_wr_id'];
				$input_params['wp_wr_detil_id'] = $this->_ci->global_model->get_incrementID('wp_wr_detil_id', 'wp_wr_detil');
				$input_params['created_by'] = $this->_ci->session->userdata('username');
				$input_params['created_time'] = date('Y-m-d H:i:s');
				$input_params['modified_time'] = $input_params['created_time'];
				$input_params['status'] = 'TRUE';

				if ($bundle_id == '1' or $bundle_id == '2' or $bundle_id == '7') {

					$input_params2['wp_wr_id'] = $input_params['wp_wr_id'];
					$input_params2['wp_wr_detil_id'] = $input_params['wp_wr_detil_id'];
					$input_params2['wp_wr_' . $type_dtl_name . '_id'] = $this->_ci->global_model->get_incrementID('wp_wr_' . $type_dtl_name . '_id', 'wp_wr_' . $type_dtl_name);

					$this->delegate_postTomodel($input_params2, $m2);
					$result = $this->dao->insert($m2);

					if (!$result) {
						$this->_ci->db->trans_rollback();
						die('ERROR: gagal menambah data');
					}
				}
			} else {

				if ($bundle_id == '1' or $bundle_id == '2' or $bundle_id == '7') {

					$this->delegate_postTomodel($input_params2, $m2);
					$result = $this->dao->update($m2, array('wp_wr_detil_id' => $id_value));

					if (!$result) {
						$this->_ci->db->trans_rollback();
						die('ERROR: gagal merubah data');
					}
				}
			}

			$this->delegate_postTomodel($input_params, $m);

			if ($act == 'add') {
				$result = $this->dao->insert($m);
				$label = "menyimpan";
			} else {
				$result = $this->dao->update($m, array('wp_wr_detil_id' => $id_value));
				$label = "merubah";
			}

			if (!$result) {
				if (in_array($bundle_id, $bundle_need_trans))
					$this->_ci->db->trans_rollback();
				die('ERROR: gagal ' . $label . ' data');
			}

			if (in_array($bundle_id, $bundle_need_trans))
				$this->_ci->db->trans_commit();

			$this->print_list_data_taxpayer_detail($wp_wr_id, $menu, false);
		} else {
			$this->_ci->load->view('errors/html/error_403', array('type' => $act));
		}
	}

	function submit_form()
	{

		$this->_ci->admin_access_handler->check_access();

		$act = $_POST['act'];
		$id_value = $_POST['id_value'];
		$menu = $_POST['menu'];
		$showed = $_POST['showed'];

		if ($act == 'add') {
			$access = $this->_ci->public_template->get_access_privileges('add', $menu, $this->bundle_id);
		} else {
			$access = $this->_ci->public_template->get_access_privileges('update', $menu, $this->bundle_id);
		}

		if ($access == '1') {

			$res = $menu . '_resources';
			require_once APPPATH . 'libraries' . DIRECTORY_SEPARATOR . 'system_resources' . DIRECTORY_SEPARATOR . $res . '.php';
			$tbl_name = $res::$_TBL_NAME;
			$pk = $res::$_PK;

			$this->_ci->load->model(array($tbl_name . '_model'));
			$m = $this->_ci->{$tbl_name . '_model'};

			$input_params = $this->collect_input_params($_POST, 'input');

			$x_district = explode('_', $input_params['kecamatan']);
			$x_village = explode('_', $input_params['kelurahan']);
			$x_business = explode('_', $input_params['kegus_id']);

			$input_params['kecamatan_id'] = $x_district[0];
			$input_params['kelurahan_id'] = $x_village[0];
			$input_params['kecamatan'] = $x_district[1];
			$input_params['kelurahan'] = $x_village[1];
			$input_params['jenis'] = 'p';
			$input_params['golongan'] = '2';
			// $input_params['ref_kegus_id'] = $x_business[0];
			// $input_params['kegus_id'] = $x_business[0];
			if ($act != 'add') {
				$input_params['kegus_id'] = $x_business[0];
			} else {
			}

			$this->_ci->load->model('wp_wr_detil_model');
			$m2 = $this->_ci->wp_wr_detil_model;

			$input_params2 = array(
				'nama' => $input_params['nama'],
				'alamat' => $input_params['alamat'],
				'kelurahan_id' => $input_params['kelurahan_id'],
				'kecamatan_id' => $input_params['kecamatan_id'],
				'kelurahan' => $input_params['kelurahan'],
				'kecamatan' => $input_params['kecamatan'],
				'kabupaten' => $input_params['kabupaten'],
				'kode_pos' => $input_params['kode_pos'],
				'no_telepon' => $input_params['no_telepon'],
				// 'ref_kegus_id' => $input_params['ref_kegus_id'],
				'kegus_id' => $input_params['kegus_id'],
				'tgl_pendaftaran' => $input_params['tgl_pendaftaran'],
				'tgl_terima_form' => $input_params['tgl_terima_form'],
				'tgl_bts_kirim' => $input_params['tgl_bts_kirim'],
				'tgl_form_kembali' => $input_params['tgl_form_kembali'],
			);
			// var_dump($input_params2);
			// die();

			if ($this->bundle_id == '1') {
				$this->_ci->load->model('wp_wr_hotel_model');
				$m3 = $this->_ci->wp_wr_hotel_model;
				$type_dtl_name = 'hotel';

				$input_params3 = $this->collect_input_params($_POST, 'input1');
			}
			if ($this->bundle_id == '2') {
				$this->_ci->load->model('wp_wr_restoran_model');
				$m3 = $this->_ci->wp_wr_restoran_model;
				// var_dump($m3);
				// die;
				$type_dtl_name = 'restoran';

				$input_params3 = $this->collect_input_params($_POST, 'input1');
			}
			if ($this->bundle_id == '7') {
				$this->_ci->load->model('wp_wr_air_tanah_model');
				$m3 = $this->_ci->wp_wr_air_tanah_model;
				$type_dtl_name = 'air_tanah';
				// var_dump($m3);
				// die();

				$input_params3 = $this->collect_input_params($_POST, 'input1');
				// var_dump($input_params3);
				// die();
			}

			$this->_ci->db->trans_begin();

			if ($act == 'add') {
				$x_business = explode('_', $input_params['kegus_id']);

				$input_params['pajak_id'] = $this->bundle_id;
				$input_params['kegus_id'] = $x_business[0];
				$input_params['status'] = 'true';
				$input_params[$pk] = $this->_ci->global_model->get_incrementID($pk, $tbl_name);
				$input_params['npwprd'] = $this->_ci->database_interactions->generate_npwprd($x_district[2], $x_village[2], $this->bundle_code, $x_business[1]);
				$input_params['no_reg'] = $this->_ci->database_interactions->generate_regorder_number();
				$input_params2['pajak_id'] = $this->bundle_id;
				$input_params2['kegus_id'] = $x_business[0];
				$input_params2['utama'] = 'true';
				$input_params2['created_by'] = $input_params['created_by'];
				$input_params2['created_time'] = $input_params['created_time'];
				$input_params2['modified_time'] = $input_params['created_time'];
				$input_params2['status'] = 'true';
				$input_params2['wp_wr_detil_id'] = $this->_ci->global_model->get_incrementID('wp_wr_detil_id', 'wp_wr_detil');
				$input_params2['wp_wr_id'] = $input_params[$pk];
				// var_dump($input_params);
				// die();

				$this->delegate_postTomodel($input_params2, $m2);

				$result = $this->dao->insert($m2);
				if (!$result) {
					$this->_ci->db->trans_rollback();
					die('ERROR: gagal menambah data');
				}

				if ($this->bundle_id == '1' or $this->bundle_id == '2' or $this->bundle_id == '7') {
					$input_params3['wp_wr_id'] = $input_params[$pk];
					$input_params3['wp_wr_detil_id'] = $input_params2['wp_wr_detil_id'];
					$input_params3['wp_wr_' . $type_dtl_name . '_id'] = $this->_ci->global_model->get_incrementID('wp_wr_' . $type_dtl_name . '_id', 'wp_wr_' . $type_dtl_name);

					$this->delegate_postTomodel($input_params3, $m3);
					$result = $this->dao->insert($m3);

					if (!$result) {
						$this->_ci->db->trans_rollback();
						die('ERROR: gagal menambah data');
					}
				}
			} else {
				// $x_business = explode('_', $input_params['kegus_id']);
				// $x_business = explode('_', $input_params2['kegus_id']);
				$wp_wr_detil_id = $_POST['wp_wr_detil_id'];
				// $input_params['kegus_id'] = $x_business[0];

				// $input_params['kegus_id'] = $x_business[0];

				// $input_params['npwprd'] = $this->_ci->database_interactions->generate_npwprd($x_district[2], $x_village[2], $this->bundle_code, $x_business[1]);
				// $input_params2['modified_by'] = $this->_ci->session->userdata('username');
				// $input_params2['modified_time'] = date('Y-m-d H:i:s');
				// // $input_params2['kegus_id'] = $x_business[0];

				// $this->delegate_postTomodel($input_params2, $m2);

				// $result = $this->dao->update($m2, array('wp_wr_detil_id' => $wp_wr_detil_id));
				if ($this->bundle_id != '7') {
					$input_params['kegus_id'] = $x_business[0];

					// $input_params['npwprd'] = $this->_ci->database_interactions->generate_npwprd($x_district[2], $x_village[2], $this->bundle_code, $x_business[1]);
					$input_params2['modified_by'] = $this->_ci->session->userdata('username');
					$input_params2['modified_time'] = date('Y-m-d H:i:s');
					// $input_params2['kegus_id'] = $x_business[0];

					$this->delegate_postTomodel($input_params2, $m2);

					$result = $this->dao->update($m2, array('wp_wr_detil_id' => $wp_wr_detil_id));
				} else {
					$input_params['kegus_id'] = $x_business[0];
					$input_params2['modified_by'] = $this->_ci->session->userdata('username');
					$input_params2['modified_time'] = date('Y-m-d H:i:s');
					// $input_params2['kegus_id'] = $x_business[0];

					$this->delegate_postTomodel($input_params2, $m2);

					$result = $this->dao->update($m2, array('wp_wr_detil_id' => $wp_wr_detil_id));
				}

				if (!$result) {
					$this->_ci->db->trans_rollback();
					die('ERROR: gagal merubah data');
				}

				$this->delegate_postTomodel($input_params3, $m3);

				if ($this->bundle_id == '1' or $this->bundle_id == '2' or $this->bundle_id == '7') {
					$result = $this->dao->update($m3, array('wp_wr_detil_id' => $wp_wr_detil_id));
				}

				if (!$result) {
					$this->_ci->db->trans_rollback();
					die('ERROR: gagal merubah data');
				}
			}

			$this->delegate_postTomodel($input_params, $m);

			if ($act == 'add') {
				$result = $this->dao->insert($m);
				$label = "menyimpan";
			} else {
				$result = $this->dao->update($m, array($pk => $id_value));
				$label = "merubah";
			}

			if (!$result) {

				$this->_ci->db->trans_rollback();

				die('ERROR: gagal ' . $label . ' data');
			}

			$this->_ci->db->trans_commit();

			//return response
			if ($showed != '0') {
				$cond_params = array_merge(
					array('a.pajak_id' => $this->bundle_id, 'a.golongan' => $this->subject_type, 'a.status' => $this->default_status),
					$this->collect_cond_params($_POST, 'src')
				);

				$this->print_list_data($menu, $cond_params);
			}
		} else {
			$this->_ci->load->view('errors/html/error_403', array('type' => $act));
		}
	}

	function upload_taxobject_image()
	{

		if (isset($_GET['files'])) {
			$FILES = $_FILES[0];

			$err_msg = "";
			$error = false;


			if ($FILES['error'] == 0) {
				$tmp_name = $FILES['tmp_name'];

				$ext = get_extension($FILES['name']);

				$upload_dir = "uploads/tax_objects";

				$file_name = date('Ymdhis') . rand(0, 999) . '.' . $ext;

				$fullpath_name = $upload_dir . '/' . $file_name;

				move_uploaded_file($tmp_name, $fullpath_name);

				$files = [$file_name];
			} else {
				$error = true;
				$err_msg = 'Terjadi kesalahan saat mengupload file';
			}

			$data = ($error) ? array('error' => $err_msg) : array('files' => $files);

			echo json_encode($data);
		} else {

			$menu = $_POST['menu'];
			$wp_wr_id = $_POST['wp_wr_id'];
			$wp_wr_detil_id = $_POST['input4-wp_wr_detil_id'];
			$filename = $_POST['filename'];

			$this->_ci->load->model('wp_wr_gambar_model');
			$m = $this->_ci->wp_wr_gambar_model;

			$input_params['wp_wr_detil_id'] = $wp_wr_detil_id;
			$input_params['wp_wr_id'] = $wp_wr_id;
			$input_params['gambar'] = $filename;
			$input_params['wp_wr_gambar_id'] = $this->_ci->global_model->get_incrementID('wp_wr_gambar_id', 'wp_wr_gambar');

			$this->delegate_postTomodel($input_params, $m);

			$result = $this->dao->insert($m);

			if (!$result) {
				die('ERROR: gagal mengunggah file');
			}

			$this->print_list_data_taxobject_image($wp_wr_id, $menu, false);
		}
	}

	function print_list_data_taxpayer_detail($subject_id, $menu, $return = true)
	{

		$sql = "SELECT * FROM v_objek_pajak WHERE wp_wr_id='" . $subject_id . "' AND status='TRUE' ORDER BY wp_wr_detil_id ASC";

		$taxpayer_detail_rows = $this->dao->execute(0, $sql)->result_array();

		$update_priv = $this->_ci->public_template->get_access_privileges('update', $menu, $this->bundle_id);
		$delete_priv = $this->_ci->public_template->get_access_privileges('delete', $menu, $this->bundle_id);

		$data = array('taxpayer_detail_rows' => $taxpayer_detail_rows, 'update_priv' => $update_priv, 'delete_priv' => $delete_priv, 'menu' => $menu, 'wp_wr_id' => $subject_id);

		$view_folder = $this->bundle_type . '/' . $menu;

		if ($return) {
			return $this->_ci->load->view($view_folder . '/list_data2', $data, true);
		} else {
			$this->_ci->load->view($view_folder . '/list_data2', $data);
		}
	}


	function print_list_data_taxobject_image($subject_id, $menu, $return = true)
	{

		$sql = "SELECT * FROM v_objek_pajak WHERE wp_wr_id='" . $subject_id . "' AND status='TRUE'";
		
		$taxpayer_detail_rows = $this->dao->execute(0, $sql)->result_array();

		$delete_priv = $this->_ci->public_template->get_access_privileges('delete', $menu, $this->bundle_id);

		$sql = "SELECT * FROM wp_wr_gambar WHERE wp_wr_detil_id=?";
		$dao = $this->dao;
		$dao->reset_object();
		$dao->set_sql_with_params($sql);

		$data = array(
			'delete_priv' => $delete_priv,
			'taxpayer_detail_rows' => $taxpayer_detail_rows,
			'dao' => $dao,
			'menu' => $menu
		);

		$view_folder = $this->bundle_type . '/' . $menu;

		if ($return) {
			return $this->_ci->load->view($view_folder . '/list_data3', $data, true);
		} else {
			$this->_ci->load->view($view_folder . '/list_data3', $data);
		}
	}

	//new add
	function print_list_data_taxobject_map($subject_id, $menu, $return = true)
	{

		$sql = "SELECT * FROM v_objek_pajak WHERE wp_wr_id='" . $subject_id . "' AND status='TRUE'";

		$taxpayer_detail_rows = $this->dao->execute(0, $sql)->result_array();

		$update_priv = $this->_ci->public_template->get_access_privileges('update', $menu, $this->bundle_id);
		$delete_priv = $this->_ci->public_template->get_access_privileges('delete', $menu, $this->bundle_id);

		$data = array('taxpayer_detail_rows' => $taxpayer_detail_rows, 'update_priv' => $update_priv, 'delete_priv' => $delete_priv, 'menu' => $menu, 'wp_wr_id' => $subject_id);

		$view_folder = $this->bundle_type . '/' . $menu;

		if ($return) {
			return $this->_ci->load->view($view_folder . '/list_data4', $data, true);
		} else {
			$this->_ci->load->view($view_folder . '/list_data4', $data);
		}
	}

	function balik_nama() {
		$id = $_POST['id'];
		$menu = $_POST['menu'];

		$sql_balik_nama = "UPDATE wp_wr SET golongan = 1 WHERE wp_wr_id = $id";

		try {
			$return = $this->dao->execute(0, $sql_balik_nama);
			if (!$return) {
				die('Gagal balik nama data');
			}
		} catch (Exception $e) {
			die('Gagal balik nama data: ' . $e->getMessage());
		}
	}
}
