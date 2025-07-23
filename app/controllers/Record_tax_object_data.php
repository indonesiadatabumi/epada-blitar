<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'controllers' . DIRECTORY_SEPARATOR . 'Item_bundle_parent.php';

class record_tax_object_data extends item_bundle_parent
{


	function __construct($bundle_type, $bundle_item_type, $menu)
	{

		//bundle_type => taxes,duties
		//bundle_item_type => hotel,restaurant,entertainment,etc
		//menu => record_taxpayer1,record_taxpayer2,etc			
		parent::__construct($bundle_type, $bundle_item_type, $menu, __CLASS__);

		$this->n_days_year = 365;
		$this->n_days_month = 30;
		$this->tax_year = $this->_ci->database_interactions->get_tax_year();
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

	function load_taxpayer_list()
	{

		$key_search = $_POST['src_form-key'];
		$menu = $_POST['menu'];
		$act = $_POST['act'];
		$showed = $_POST['showed'];

		$src_params = array();
		$src_daterange_params = array();
		foreach ($_POST as $key => $val) {
			$x = explode('-', $key);
			if ($x[0] == 'src' and $val != '') {
				$field = $x[1];
				$src_params[$field] = $val;
			}

			if ($x[0] == 'src_date_range' and $val != '') {
				$field = $x[1];
				$src_daterange_params[$field . '-' . $x[2]] = $val;
			}
		}

		$sql = "SELECT * FROM v_objek_pajak WHERE pajak_id='" . $this->bundle_id . "' AND status=TRUE AND (npwprd LIKE '%" . $key_search . "%' OR nama_wp LIKE '%" . $key_search . "%')";

		$rows = $this->dao->execute(0, $sql)->result_array();

		$data = array('rows' => $rows, 'act' => $act, 'menu' => $menu, 'showed' => $showed, 'src_params' => $src_params, 'src_daterange_params' => $src_daterange_params);

		$view_folder = $this->bundle_type . '/' . $menu;

		$this->_ci->load->view($view_folder . '/taxpayer_list', $data);
	}

	function load_dtl_ads_content($ads_type_id = '', $tax_percentage = '', $order_num = '', $curr_data = array(), $menu = '', $return = false)
	{

		$this->_ci->load->model('spt_detil_reklame_model');
		$m = $this->_ci->spt_detil_reklame_model;

		$ads_type_id = ($ads_type_id == '' ? $_POST['ads_type_id'] : $ads_type_id);
		$menu = ($menu == '' ? $_POST['menu'] : $menu);
		$order_num = ($order_num == '' ? $_POST['order_num'] : $order_num);
		$tax_percentage = ($tax_percentage == '' ? $_POST['tax_percentage'] : $tax_percentage);

		$ads_type_row = array();
		$index1_rows = array();
		$index2_rows = array();
		$index3_rows = array();
		$index4_rows = array();

		if ($ads_type_id != '') {
			$ads_type_row = $this->dao->execute(0, "SELECT * FROM ref_jenis_reklame WHERE ref_jenrek_id='" . $ads_type_id . "'")->row_array();
			$index1_rows = $this->dao->execute(0, "SELECT * FROM ref_indeks_kawasan")->result_array();
			$index2_rows = $this->dao->execute(0, "SELECT * FROM ref_indeks_sudut_pandang")->result_array();
			$index3_rows = $this->dao->execute(0, "SELECT * FROM ref_indeks_kelas_jalan")->result_array();
			$index4_rows = $this->dao->execute(0, "SELECT * FROM ref_indeks_ketinggian")->result_array();
		}

		if (count($curr_data) == 0) {
			$curr_data = $this->dao->get_data_by_id('add', $m, '');
		}

		$data = array(
			'ads_type_id' => $ads_type_id,
			'menu' => $menu,
			'ads_type_row' => $ads_type_row,
			'curr_data' => $curr_data,
			'index1_rows' => $index1_rows,
			'index2_rows' => $index2_rows,
			'index3_rows' => $index3_rows,
			'index4_rows' => $index4_rows,
			'order_num' => $order_num,
			'tax_percentage' => $tax_percentage,
		);


		if ($ads_type_id == '1') {
			$road_class_rows = $this->dao->execute(0, "SELECT * FROM ref_kelas_jalan")->result_array();
			$data['road_class_rows'] = $road_class_rows;
		}

		$view_folder = $this->bundle_type . '/' . $menu;
		if (!$return)
			$this->_ci->load->view($view_folder . '/dtl_ads_content', $data);
		else
			return $this->_ci->load->view($view_folder . '/dtl_ads_content', $data, true);
	}

	function load_class_road_value()
	{

		$class_id = $_POST['class_id'];
		$ads_type_id = $_POST['ads_type_id'];
		$menu = $_POST['menu'];

		$sql = "SELECT nilai FROM nilai_kelas_jalan WHERE jenrek_id='" . $ads_type_id . "' AND kelas_jalan_id='" . $class_id . "'";

		$class_road_value_row = $this->dao->execute(0, $sql)->row_array();

		$data = array('class_road_value_row' => $class_road_value_row);

		$view_folder = $this->bundle_type . '/' . $menu;

		$this->_ci->load->view($view_folder . '/class_road_value', $data);
	}


	function taxpayer_search_panel()
	{
		$this->_ci->admin_access_handler->check_access();

		$act = $_POST['act'];
		$menu = $_POST['menu'];
		$showed = $_POST['showed'];

		$src_params = array();
		$src_daterange_params = array();

		foreach ($_POST as $key => $val) {
			$x = explode('-', $key);
			if ($x[0] == 'src' and $val != '') {
				$field = $x[1];
				$src_params[$field] = $val;
			}
			if ($x[0] == 'src_date_range' and $val != '') {
				$field = $x[1];
				$src_daterange_params[$field . '-' . $x[2]] = $val;
			}
		}

		$view_folder = $this->bundle_type . '/' . $menu;

		$data = array(
			'act' => $act,
			'menu' => $menu,
			'showed' => $showed,
			'src_params' => $src_params,
			'src_daterange_params' => $src_daterange_params,
			'bundle_name' => $this->bundle_row['nama_paret'],
			'bundle_item_type' => $this->bundle_item_type,
			'bundle_id' => $this->bundle_id,
		);

		$this->_ci->load->view($view_folder . '/taxpayer_search_panel', $data);
	}

	function form()
	{

		$this->_ci->admin_access_handler->check_access();

		$act = $_POST['act'];
		$menu = $_POST['menu'];
		$showed = $_POST['showed'];

		$skip_register = (isset($_POST['skip_register']) ? $_POST['skip_register'] : '0');
		$wp_wr_detil_id = ($skip_register == '0' ? $_POST['wp_wr_detil_id'] : '0');

		$res = $menu . '_resources';
		require_once APPPATH . 'libraries' . DIRECTORY_SEPARATOR . 'system_resources' . DIRECTORY_SEPARATOR . $res . '.php';
		$tbl_name = $res::$_TBL_NAME;
		$pk = $res::$_PK;

		$this->_ci->load->model(array($tbl_name . '_model', 'spt_detil_model'));
		$m1 = $this->_ci->{$tbl_name . '_model'};
		$m2 = $this->_ci->spt_detil_model;

		$id_value = ($act == 'edit' ? $_POST['id'] : '');
		$curr_data = $this->dao->get_data_by_id($act, $m1, $id_value);
		$curr_data2 = array();

		// $sql = "SELECT spt_detil_id FROM spt_detil WHERE spt_id='" . ($id_value == '' ? '0' : $id_value) . "'";

		// if ($this->bundle_id != 3) {
		// 	if ($this->bundle_id != 4) {
		// 		$row = $this->dao->execute(0, $sql)->row_array();

		// 		$curr_data2 = ($row != null) ? $this->dao->get_data_by_id($act, $m2, $row['spt_detil_id']) : '';
		// 	} else {
		// 		$sql = "SELECT * FROM spt_detil WHERE spt_id='" . ($id_value == '' ? '0' : $id_value) . "'";
		// 		$curr_data2 = $this->dao->execute(0, $sql)->result_array();
		// 	}
		// }

		if ($this->bundle_id == 4) {
			$sql = "SELECT * FROM spt_detil WHERE spt_id='" . ($id_value == '' ? '0' : $id_value) . "'";
			$curr_data2 = $this->dao->execute(0, $sql)->result_array();
		} elseif ($this->bundle_id == 7) {
			$sql = "SELECT a.*, b.ptnjk_meter_hari_ini, b.ptnjk_meter_bulan_lalu, b.bkn_meter_hari, b.bkn_meter_bulan, 
						b.vol_0_50, b.vol_51_500, b.vol_501_1000, b.vol_1001_2500, b.vol_leb_2500,
						b.hrg_0_50, b.hrg_51_500, b.hrg_501_1000, b.hrg_1001_2500, b.hrg_leb_2500 FROM spt_detil AS a
						LEFT JOIN spt_detil_abt AS b ON a.spt_id=b.spt_id 
						WHERE a.spt_id='" . ($id_value == '' ? '0' : $id_value) . "'";
			$curr_data2 = $this->dao->execute(0, $sql)->row_array();
		} else {
			$sql = "SELECT spt_detil_id FROM spt_detil WHERE spt_id='" . ($id_value == '' ? '0' : $id_value) . "'";
			$row = $this->dao->execute(0, $sql)->row_array();

			$curr_data2 = ($row != null) ? $this->dao->get_data_by_id($act, $m2, $row['spt_detil_id']) : '';
		}

		$taxpayer_detail_row = array();
		if (($act == 'add' and $skip_register == '0') or ($act == 'edit' and $curr_data['wp_wr_paten'])) {
			$sql = "SELECT a.*,b.tarif_dasar FROM v_objek_pajak as a LEFT JOIN ref_kegiatan_usaha as b ON (a.kegus_id=b.ref_kegus_id) 
						WHERE a.wp_wr_detil_id='" . $wp_wr_detil_id . "'";

			$taxpayer_detail_row = $this->dao->execute(0, $sql)->row_array();
		}

		$entertainment_type_rows = array();
		$nonmetalic_mineral_rock_type_rows = array();
		$nonmetalic_mineral_rock_rows = array();
		$ads_type_rows = array();

		if ($this->bundle_id == 4) {
			$entertainment_type_rows = $this->dao->execute(0, "SELECT * FROM ref_kegiatan_usaha WHERE pajak_id='" . $this->bundle_id . "'")->result_array();
		}
		if ($this->bundle_id == 3) {
			$ads_type_rows = $this->dao->execute(0, "SELECT * FROM ref_jenis_reklame ORDER BY ref_jenrek_id ASC")->result_array();
		}
		if ($this->bundle_id == 6) {
			$nonmetalic_mineral_rock_type_rows = $this->dao->execute(0, "SELECT * FROM ref_jenis_mblb")->result_array();
			if ($act == 'edit') {
				$nonmetalic_mineral_rock_rows = $this->dao->execute(0, "SELECT * FROM spt_detil_mblb WHERE spt_id='" . $id_value . "'")->result_array();
			}
		}

		$entertainment_type_rows_json = json_encode($entertainment_type_rows);
		$nonmetalic_mineral_rock_type_rows_json = json_encode($nonmetalic_mineral_rock_type_rows);
		$ads_type_rows_json = json_encode($ads_type_rows);

		$curr_start_date = '01-' . date('m') . '-' . $this->tax_year;


		$x_date = explode('-', $curr_start_date);
		$curr_n_days = cal_days_in_month(CAL_GREGORIAN, $x_date[1], $x_date[2]);
		$curr_last_date = $curr_n_days . '-' . $x_date[1] . '-' . $x_date[2];

		$range_dates = array();
		for ($i = 1; $i <= 12; $i++) {
			$n_days = cal_days_in_month(CAL_GREGORIAN, $i, $x_date[2]);
			$start_date = '01-' . sprintf('%02s', $i);
			$end_date = sprintf('%02s', $n_days) . '-' . sprintf('%02s', $i);

			$range_dates[] = array('start' => $start_date, 'end' => $end_date);
		}

		$main_form_id = "main-form-id";
		$view_folder = $this->bundle_type . '/' . $menu;

		$src_params = array();
		$src_daterange_params = array();

		foreach ($_POST as $key => $val) {
			$x = explode('-', $key);
			if ($x[0] == 'src' and $val != '') {
				$field = $x[1];
				$src_params[$field] = $val;
			}

			if ($x[0] == 'src_date_range' and $val != '') {
				$field = $x[1];
				$src_daterange_params[$field . '-' . $x[2]] = $val;
			}
		}

		$metode_transaksi = "SELECT * FROM ref_method_transak ORDER BY metod_trans_id ASC";
		$metode_transaksi_result = $this->dao->execute(0, $metode_transaksi)->result_array();

		$main_data = array(
			'act' => $act,
			'curr_data' => $curr_data,
			'curr_data2' => $curr_data2,
			'taxpayer_detail_row' => $taxpayer_detail_row,
			'id_value' => $id_value,
			'wp_wr_detil_id' => $wp_wr_detil_id,
			'menu' => $menu,
			'main_form_id' => $main_form_id,
			'showed' => $showed,
			'src_params' => $src_params,
			'src_daterange_params' => $src_daterange_params,
			'bundle_name' => $this->bundle_row['nama_paret'],
			'bundle_id' => $this->bundle_id,
			'entertainment_type_rows' => $entertainment_type_rows,
			'entertainment_type_rows_json' => $entertainment_type_rows_json,
			'nonmetalic_mineral_rock_type_rows' => $nonmetalic_mineral_rock_type_rows,
			'nonmetalic_mineral_rock_type_rows_json' => $nonmetalic_mineral_rock_type_rows_json,
			'nonmetalic_mineral_rock_rows' => $nonmetalic_mineral_rock_rows,
			'ads_type_rows' => $ads_type_rows,
			'ads_type_rows_json' => $ads_type_rows_json,
			'curr_start_date' => $curr_start_date,
			'curr_last_date' => $curr_last_date,
			'range_dates_json' => json_encode($range_dates),
			'skip_register' => $skip_register,
			'taxpayer_info_available' => (count($taxpayer_detail_row) > 0),
			'tax_code' => $this->bundle_row['kode_pajak'],
			'tax_year' => $this->tax_year,
			'metode_transaksi_result' => $metode_transaksi_result,
		);

		if ($this->bundle_id == '3') {

			$this->_ci->load->model(array('spt_detil_reklame_model', 'wp_wr_reklame_model'));
			$m3 = $this->_ci->spt_detil_reklame_model;
			$m4 = $this->_ci->wp_wr_reklame_model;

			$ads_type_rows = $this->dao->execute(0, "SELECT * FROM ref_jenis_reklame ORDER BY ref_jenrek_id ASC")->result_array();
			$business_row = $this->dao->execute(0, "SELECT ref_kegus_id,kode_kegus,nama_kegus,persen_tarif FROM ref_kegiatan_usaha WHERE ref_kegus_id='9'")->row_array();

			$district_rows = $this->_ci->database_interactions->get_district_rows();
			if ($skip_register == '1') {
				array_unshift($district_rows, array(
					'kecamatan_id' => '9999999', 'dt2_id' => '9999',
					'nama_kecamatan' => 'LUAR KOTA', 'kode_kecamatan' => '00'
				));
			}

			$curr_data3 = $this->dao->get_data_by_id($act, $m3, array('spt_id' => $curr_data['spt_id']));
			$curr_data4 = $this->dao->get_data_by_id($act, $m4, array('wp_wr_reklame_id' => $curr_data['wp_wr_reklame_id']));

			$village_rows = array();
			$dtl_ads_content = null;

			if ($act == 'edit') {

				$village_rows = $this->_ci->database_interactions->get_village_rows($curr_data4['kecamatan_id']);

				$curr_data3 = array();
				$rows = $this->dao->execute(0, "SELECT * FROM spt_detil_reklame WHERE spt_id='" . $curr_data['spt_id'] . "'")->result_array();
				$i = 0;
				foreach ($rows as $row) {
					$i++;
					$row['dtl_ads_content'] = $this->load_dtl_ads_content($row['jenis_reklame_id'], $row['persen_tarif'], $i, $row, $menu, true);
					$curr_data3[] = $row;
				}
			}

			$main_data['ads_type_rows'] = $ads_type_rows;
			$main_data['business_id'] = $business_row['ref_kegus_id'];
			$main_data['business_name'] = $business_row['nama_kegus'];
			$main_data['business_code'] = $business_row['kode_kegus'];
			$main_data['tax_percentage'] = $business_row['persen_tarif'];
			$main_data['collection_type'] = $this->bundle_row['nama_jenis_pemungutan'];
			$main_data['collection_type_id'] = $this->bundle_row['jenis_pemungutan'];
			$main_data['spt_type_id'] = $this->bundle_row['jenis_spt_id'];
			$main_data['district_rows'] = $district_rows;
			$main_data['village_rows'] = $village_rows;
			$main_data['curr_data3'] = $curr_data3;
			$main_data['curr_data4'] = $curr_data4;
			$main_data['dtl_ads_content'] = $dtl_ads_content;
		}
		if ($this->bundle_id == '4') {
			$main_data['multiple_entertaiment_tax_row'] = false;
		}

		if ($this->bundle_id == '5') {

			$this->_ci->load->model(array('spt_detil_penerangan_jalan_model'));
			$m3 = $this->_ci->spt_detil_penerangan_jalan_model;
			$curr_data3 = $this->dao->get_data_by_id($act, $m3, array('spt_id' => $curr_data['spt_id']));

			$main_data['curr_data3'] = $curr_data3;
		}

		$compensation_component_weights = array();

		if ($this->bundle_id == '7') {

			// $sql = "SELECT a.*,b.deskripsi as jenis_air,
			// 			b.harga_satuan,
			// 			c.bobot as bobot_sda,
			// 			d.*
			// 			FROM wp_wr_air_tanah as a 
			// 			LEFT JOIN ref_harga_air_baku as b ON (a.hrgab_id=b.ref_hrgab_id) 
			// 			LEFT JOIN ref_komponen_sda_air_tanah as c ON (a.kompsda_id=c.ref_kompsda_id)
			// 			LEFT JOIN ref_komponen_kompensasi_air_tanah as d ON (a.kompkom_id=d.ref_kompkom_id)
			// 			WHERE a.wp_wr_detil_id='" . $wp_wr_detil_id . "'";

			$sql = "SELECT * FROM wp_wr_air_tanah INNER JOIN ref_komponen_kompensasi_air_tanah
			ON wp_wr_air_tanah.kompkom_id = ref_komponen_kompensasi_air_tanah.ref_kompkom_id WHERE wp_wr_detil_id='" . $wp_wr_detil_id . "'";

			$groundwater_wp_row = $this->dao->execute(0, $sql)->row_array();
			$groundwater_component_rows = $this->dao->execute(0, "SELECT bobot FROM ref_komponen_air_tanah ORDER BY ref_komponen_id ASC")->result_array();
			$groundwater_components = array_column($groundwater_component_rows, 'bobot');

			// var_dump($groundwater_wp_row);
			// die;
			// $naturalresources_component_value = ($groundwater_wp_row['bobot_sda'] * $groundwater_components[0] / 100);

			$compensation_component_weights = array(
				0 => array($groundwater_wp_row['bobot_0_50'], 50),
				51 => array($groundwater_wp_row['bobot_51_500'], 500),
				501 => array($groundwater_wp_row['bobot_501_1000'], 1000),
				1001 => array($groundwater_wp_row['bobot_1001_2500'], 2500),
				2501 => array($groundwater_wp_row['bobot_2501_5000'], 5000),
				5000 => array($groundwater_wp_row['bobot_atas_5000'], 0),
			);

			$main_data['groundwater_wp_row'] = $groundwater_wp_row;
			$main_data['groundwater_components'] = $groundwater_components;
			// $main_data['naturalresources_component_value'] = $naturalresources_component_value;

			if ($act == 'edit') {

				$volume = $curr_data2['volume'];
				$tarif_dasar = $curr_data2['tarif_dasar'];
				$compensation_percent = $groundwater_components[1];
				// $sda_value = $naturalresources_component_value;
				// $unit_price = $groundwater_wp_row['harga_satuan'];

				$remain = $volume;
				$tank_volume = 0;
				$step_volume = 0;

				$compensation_component_rows = array();

				foreach ($compensation_component_weights as $key => $val) {

					if ($tank_volume < $volume) {

						$min = $key;
						$max = $val[1];
						$weight = $val[0];

						if ($remain > $max) {
							$step_volume = ($max - $tank_volume <= $max ? $max - $tank_volume : $remain);
						} else {
							$step_volume = (($tank_volume + $remain) <= $max ? $remain : $max - $tank_volume);
						}

						$tank_volume += $step_volume;
						$remain -= $step_volume;


						// $nkp = $weight * $compensation_percent / 100;
						// $nkp = $weight / 100;
						// $nkp = $nkp;
						// $fna = $sda_value + $nkp;
						// $fna = $fna;
						// $npa = $unit_price * $step_volume * $fna;
						// $npa = $unit_price * $step_volume;
						$npa = $weight * $volume;

						$compensation_component_rows[] = array(
							'volume' => 'Volume ' . $min . '-' . $max . ' => ' . $step_volume,
							'weight' => $weight,
							// 'nkp' => number_format($nkp, 2, '.', ','),
							// 'fna' => number_format($fna, 2, '.', ','),
							'npa' => number_format($npa)
						);
					} else {
						break;
					}
				}

				$main_data['compensation_component_rows'] = $compensation_component_rows;
			}
		}

		$main_data['compensation_component_weights_json'] = json_encode($compensation_component_weights);

		$main_data = array_merge($this->main_params, $main_data);
		$data = array_merge($this->main_params, $main_data, $metode_transaksi_result);

		$this->_ci->load->view($view_folder . '/form', $data);
	}

	private function get_ads_installation_dayperiode($unit, $periode)
	{

		$n_days = 0;
		switch ($unit) {
			case 'tahun':
				$n_days = $periode * $this->n_days_year;
				break;
			case 'bulan':
				$n_days = $periode * $this->n_days_month;
				break;
			default:
				$n_days = $periode;
		}
		return $n_days;
	}

	function submit_form()
	{

		$this->_ci->admin_access_handler->check_access();

		$act = $_POST['act'];
		$id_value = $_POST['id_value'];
		$wp_wr_detil_id = $_POST['wp_wr_detil_id'];
		$pajak_id = $_POST['pajak_id'];
		$kode_pajak = $_POST['kode_pajak'];
		$jenis_spt_id = $_POST['jenis_spt_id'];
		$kegus_id = $_POST['kegus_id'];
		$kode_kegus = $_POST['kode_kegus'];
		$menu = $_POST['menu'];
		$showed = $_POST['showed'];
		$tahun_pajak = $_POST['tahun_pajak'];

		$nomor_spt = $this->_ci->database_interactions->generate_spt_number($pajak_id);

		// $curr_year = date('Y');

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

			$this->_ci->load->model(array($tbl_name . '_model', 'spt_detil_model'));
			$m1 = $this->_ci->{$tbl_name . '_model'};
			$m2 = $this->_ci->spt_detil_model;

			$input_params = $this->collect_input_params($_POST, 'input');
			$tp1 = explode('-', $input_params['masa_pajak1']);
			$tp2 = explode('-', $input_params['masa_pajak2']);

			$input_params['masa_pajak1'] = $tahun_pajak . '-' . $tp1[1] . '-' . $tp1[0];
			$input_params['masa_pajak2'] = $tahun_pajak . '-' . $tp2[1] . '-' . $tp2[0];

			$input_params2 = array();

			if ($this->bundle_id == 7) {
				$input_params2['volume'] = str_replace(',', '', $_POST['input2-volume']);
				$input_params2['tarif_dasar'] = str_replace(',', '', $_POST['input2-tarif_dasar']);
			}

			$this->_ci->db->trans_begin();

			if ($act == 'add') {

				$input_params['pajak_id'] = $pajak_id;
				$input_params['wp_wr_detil_id'] = $wp_wr_detil_id;
				$input_params['jenis_spt_id'] = $jenis_spt_id;
				$input_params['nomor_spt'] = $this->_ci->database_interactions->generate_spt_number($pajak_id);
				$input_params['tahun_pajak'] = $tahun_pajak;
				$input_params['kode_billing'] = $this->_ci->database_interactions->generate_billing_code('1', $input_params['jenis_pemungutan_id']);
				// $kode_pajak = "SELECT rek_bank FROM wp_wr 
				// JOIN bundel_pajak_retribusi ON wp_wr.pajak_id = bundel_pajak_retribusi.bundel_id
				// JOIN tbl_ref_rekening ON bundel_pajak_retribusi.kode_pajak = tbl_ref_rekening.rek_epada
				// WHERE wp_wr.wp_wr_id = '" . $input_params['wp_wr_id'] . "' GROUP BY rek_bank";
				// $kode_pajak_result = $this->dao->execute(0, $kode_pajak)->row_array();
				// $input_params['kode_billing'] = $this->_ci->database_interactions->generate_billing_code($kode_pajak_result['rek_bank']);

				$input_params[$pk] = $this->_ci->global_model->get_nextval('spt_spt_id_seq');

				if ($this->bundle_id != '3') {
					$input_params['npwprd'] = $_POST['input-npwprd'];
				}

				// if ($input_params['jenis_pemungutan_id'] == '1') {
				// 	$input_params['kode_billing'] = $this->_ci->database_interactions->generate_billing_code('1', $input_params['jenis_pemungutan_id']);
				// }

				if ($this->bundle_id == '3') {

					$this->_ci->load->model(array('spt_detil_reklame_model', 'wp_wr_reklame_model'));
					$m3 = $this->_ci->spt_detil_reklame_model;
					$m4 = $this->_ci->wp_wr_reklame_model;

					$input_params3 = array();
					$input_params4 = array();

					$n_rows = $_POST['n_ads_detail_rows'];

					for ($i = 1; $i <= $n_rows; $i++) {

						if (isset($_POST['input2-jenis_reklame_id' . $i])) {

							$input_params2['kegus_id'] = $kegus_id;
							$input_params2['nilai_terkena_pajak'] = str_replace(',', '', $_POST['input2-nilai_sewa_reklame' . $i]);
							$input_params2['persen_tarif'] = str_replace(',', '', $_POST['input2-persen_tarif' . $i]);
							$input_params2['pajak'] = str_replace(',', '', $_POST['input2-pajak' . $i]);
							$input_params2['spt_id'] = $input_params[$pk];
							$input_params2['spt_detil_id'] = $this->_ci->global_model->get_nextval('spt_detil_spt_detil_id_seq');

							$this->delegate_postTomodel($input_params2, $m2);

							$result = $this->dao->insert($m2);

							if (!$result) {
								$this->_ci->db->trans_rollback();
								die('ERROR: gagal menambah data');
							}

							$ads_type = $_POST['input2-jenis_reklame_id' . $i];

							$unit_periode = $_POST['input2-satuan_jangka_waktu' . $i];
							$periode = str_replace(',', '', $_POST['input2-jangka_waktu' . $i]);

							$tgl_pasang = us_date_format($_POST['input2-tgl_pasang' . $i]);
							if ($ads_type != '6' and $ads_type != '7' and $ads_type != '16') {
								$tgl_berakhir = dateadd($tgl_pasang, $this->get_ads_installation_dayperiode($unit_periode, $periode));
							} else {
								$tgl_berakhir = null;
							}

							if (($ads_type >= 1 and $ads_type <= 15) or $ads_type == 19) {
								$index1 = explode('_', $_POST['input2-indeks_kawasan_id' . $i]);
								$index2 = explode('_', $_POST['input2-indeks_sudut_pandang_id' . $i]);
								$index3 = explode('_', $_POST['input2-indeks_kelas_jalan_id' . $i]);
								$index4 = explode('_', $_POST['input2-indeks_ketinggian_id' . $i]);
								$index_id1 = $index1[0];
								$index_id2 = $index2[0];
								$index_id3 = $index3[0];
								$index_id4 = $index4[0];
								$index1 = $_POST['input2-indeks_kawasan' . $i];
								$index2 = $_POST['input2-indeks_sudut_pandang' . $i];
								$index3 = $_POST['input2-indeks_kelas_jalan' . $i];
								$index4 = $_POST['input2-indeks_ketinggian' . $i];
							} else {
								$index_id1 = 0;
								$index_id2 = 0;
								$index_id3 = 0;
								$index_id4 = 0;
								$index1 = '';
								$index2 = '';
								$index3 = '';
								$index4 = '';
							}

							$input_params3['jenis_reklame_id'] = $ads_type;
							$input_params3['area'] = $_POST['input2-area' . $i];
							$input_params3['judul'] = $_POST['input2-judul' . $i];
							$input_params3['lokasi'] = $_POST['input2-lokasi' . $i];
							$input_params3['indeks_kawasan_id'] = $index_id1;
							$input_params3['indeks_sudut_pandang_id'] = $index_id2;
							$input_params3['indeks_kelas_jalan_id'] = $index_id3;
							$input_params3['indeks_ketinggian_id'] = $index_id4;
							$input_params3['indeks_kawasan'] = $index1;
							$input_params3['indeks_sudut_pandang'] = $index2;
							$input_params3['indeks_kelas_jalan'] = $index3;
							$input_params3['indeks_ketinggian'] = $index4;
							$input_params3['nsl'] = $_POST['input2-nsl' . $i];
							$input_params3['ukuran'] = str_replace(',', '', $_POST['input2-ukuran' . $i]);
							$input_params3['jangka_waktu'] = $periode;
							$input_params3['jumlah'] = str_replace(',', '', $_POST['input2-jumlah' . $i]);
							$input_params3['harga_satuan'] = str_replace(',', '', $_POST['input2-harga_satuan' . $i]);
							$input_params3['nilai_sewa_reklame'] = str_replace(',', '', $_POST['input2-nilai_sewa_reklame' . $i]);
							$input_params3['persen_tarif'] = str_replace(',', '', $_POST['input2-persen_tarif' . $i]);
							$input_params3['pajak'] = $input_params2['pajak'];
							$input_params3['tgl_pasang'] = $tgl_pasang;
							$input_params3['tgl_berakhir'] = $tgl_berakhir;
							$input_params3['status'] = 'berlangsung';
							$input_params3['spt_id'] = $input_params[$pk];
							$input_params3['spt_detil_id'] = $input_params2['spt_detil_id'];

							$this->delegate_postTomodel($input_params3, $m3);
							$result = $this->dao->insert($m3);

							if (!$result) {
								$this->_ci->db->trans_rollback();
								die('ERROR: gagal menambah data');
							}
						}
					}

					$skip_register = $_POST['skip_register'];

					if ($skip_register == '0') {
						$taxpayer_row = $this->dao->execute(0, "SELECT a.*,b.npwprd FROM wp_wr_detil as a LEFT JOIN wp_wr as b ON (a.wp_wr_id=b.wp_wr_id) 
																   WHERE a.wp_wr_detil_id='" . $wp_wr_detil_id . "'")->row_array();

						$input_params4['npwpd'] = $taxpayer_row['npwprd'];
						$input_params4['nama'] = $taxpayer_row['nama'];
						$input_params4['alamat'] = $taxpayer_row['alamat'];
						$input_params4['no_telepon'] = $taxpayer_row['no_telepon'];
						$input_params4['kelurahan_id'] = $taxpayer_row['kelurahan_id'];
						$input_params4['kecamatan_id'] = $taxpayer_row['kecamatan_id'];
						$input_params4['kelurahan'] = $taxpayer_row['kelurahan'];
						$input_params4['kecamatan'] = $taxpayer_row['kecamatan'];
						$input_params4['kabupaten'] = $taxpayer_row['kabupaten'];

						$input_params['wp_wr_paten'] = 'TRUE';
					} else {

						$x_district = explode('_', $_POST['input3-kecamatan']);
						$x_village = explode('_', $_POST['input3-kelurahan']);

						$input_params4['npwpd'] = $this->_ci->database_interactions->generate_ads_npwpd($x_district[2], $x_village[2], $kode_pajak, $kode_kegus);
						$input_params4['nama'] = $_POST['input3-nama'];
						$input_params4['alamat'] = $_POST['input3-alamat'];
						$input_params4['no_telepon'] = $_POST['input3-no_telepon'];
						$input_params4['kelurahan_id'] = $x_village[0];
						$input_params4['kecamatan_id'] = $x_district[0];
						$input_params4['kelurahan'] = $x_village[1];
						$input_params4['kecamatan'] = $x_district[1];

						$input_params['wp_wr_paten'] = 'FALSE';
					}

					$wp_wr_reklame_id = $this->_ci->global_model->get_nextval('wp_wr_reklame_wp_wr_reklame_id_seq');
					$input_params4['wp_wr_reklame_id'] = $wp_wr_reklame_id;

					$this->delegate_postTomodel($input_params4, $m4);

					$result = $this->dao->insert($m4);

					if (!$result) {
						$this->_ci->db->trans_rollback();
						die('ERROR: gagal menambah data');
					}

					$input_params['wp_wr_reklame_id'] = $wp_wr_reklame_id;
					$input_params['wp_wr_id'] = '0';
					$input_params['npwprd'] = $input_params4['npwpd'];
				} else if ($this->bundle_id == '4') {

					$n_detail1_rows = $_POST['n_detail1_rows'];
					$input_params['nilai_terkena_pajak'] = 0;
					$input_params['persen_tarif'] = 0;

					//this loop only have 1 repetition
					if ($n_detail1_rows == 1) {
						for ($i = 1; $i <= $n_detail1_rows; $i++) {

							if (isset($_POST['input2-kegus_id' . $i])) {

								$x_business = explode('_', $_POST['input2-kegus_id' . $i]);
								$input_params2['kegus_id'] = $x_business[0];
								$input_params2['nilai_terkena_pajak'] =  str_replace(',', '', $_POST['input2-nilai_terkena_pajak' . $i]);
								$input_params2['persen_tarif'] = str_replace(',', '', $_POST['input2-persen_tarif' . $i]);
								$input_params2['pajak'] = str_replace(',', '', $_POST['input2-pajak' . $i]);
								$input_params2[$pk] = $input_params[$pk];
								$input_params2['spt_detil_id'] = $this->_ci->global_model->get_nextval('spt_detil_spt_detil_id_seq');

								$this->delegate_postTomodel($input_params2, $m2);

								$result = $this->dao->insert($m2);

								if (!$result) {
									$this->_ci->db->trans_rollback();
									die('ERROR: gagal menambah data');
								}

								$input_params['nilai_terkena_pajak'] += $input_params2['nilai_terkena_pajak'];
								$input_params['persen_tarif'] = $input_params2['persen_tarif'];
							}
						}
					} else {
						die('ERROR: item pajak hiburan tidak boleh lebih dari 1');
					}
				} else {

					$input_params2['kegus_id'] = $kegus_id;
					$input_params2['nilai_terkena_pajak'] = $input_params['nilai_terkena_pajak'];
					$input_params2['persen_tarif'] = $input_params['persen_tarif'];
					$input_params2['pajak'] = $input_params['pajak'];
					$input_params2['spt_id'] = $input_params[$pk];
					$input_params2['spt_detil_id'] = $this->_ci->global_model->get_nextval('spt_detil_spt_detil_id_seq');

					$this->delegate_postTomodel($input_params2, $m2);

					$result = $this->dao->insert($m2);

					if (!$result) {
						$this->_ci->db->trans_rollback();
						die('ERROR: gagal menambah data');
					}

					if ($this->bundle_id == 5) {

						$this->_ci->load->model('spt_detil_penerangan_jalan_model');
						$m3 = $this->_ci->spt_detil_penerangan_jalan_model;

						$input_params3 = array();

						$input_params3['penggunaan_daya'] = str_replace(',', '', $_POST['input2-penggunaan_daya']);
						$input_params3['tarif_dasar'] = str_replace(',', '', $_POST['input2-tarif_dasar']);
						$input_params3['nilai_jual'] = $input_params['nilai_terkena_pajak'];
						$input_params3['persen_tarif'] = $input_params['persen_tarif'];
						$input_params3['pajak'] = $input_params['pajak'];
						$input_params3['spt_id'] = $input_params[$pk];
						$input_params3['spt_detil_id'] = $input_params2['spt_detil_id'];
						$input_params3['spt_detil_penerangan_jalan_id'] = $this->_ci->global_model->get_nextval('spt_detil_penerangan_jalan_spt_detil_penerangan_jalan_id_seq');

						$this->delegate_postTomodel($input_params3, $m3);

						$result = $this->dao->insert($m3);
						if (!$result) {
							$this->_ci->db->trans_rollback();
							die('ERROR: gagal menambah data');
						}
					}
					//additional manipulation in Non Metalic Mineral and Rock Tax
					if ($this->bundle_id == 6) {

						$this->_ci->load->model('spt_detil_mblb_model');
						$m3 = $this->_ci->spt_detil_mblb_model;

						$n_detail2_rows = $_POST['n_detail2_rows'];
						$input_params3 = array();


						for ($i = 1; $i <= $n_detail2_rows; $i++) {

							if (isset($_POST['input2-mblb_id' . $i])) {

								$x_mblb = explode('_', $_POST['input2-mblb_id' . $i]);
								$input_params3['mblb_id'] = $x_mblb[0];
								$input_params3['volume'] = str_replace(',', '', $_POST['input2-mblb_volume' . $i]);
								$input_params3['tarif_dasar'] = str_replace(',', '', $_POST['input2-mblb_tarif_dasar' . $i]);
								$input_params3['nilai_jual'] = str_replace(',', '', $_POST['input2-mblb_nilai_jual' . $i]);
								$input_params3['spt_detil_id'] = $input_params2['spt_detil_id'];
								$input_params3['spt_id'] = $input_params['spt_id'];
								$input_params3['spt_detil_mblb_id'] = $this->_ci->global_model->get_nextval('spt_detil_mblb_spt_detil_mblb_id_seq');

								$this->delegate_postTomodel($input_params3, $m3);

								$result = $this->dao->insert($m3);
								if (!$result) {
									$this->_ci->db->trans_rollback();
									die('ERROR: gagal menambah data');
								}
							}
						}
					}

					if ($this->bundle_id == 7) {

						$this->_ci->load->model('spt_detil_abt_model');
						$m3 = $this->_ci->spt_detil_abt_model;

						$input_params3 = array();

						$get_spt_detil_abt_id = $this->dao->execute(0, "SELECT MAX(spt_detil_abt_id)+1 AS spt_detil_abt_id FROM spt_detil_abt")->row_array();
						$spt_detil_abt_id = $get_spt_detil_abt_id['spt_detil_abt_id'];
						$input_params3['hrg_leb_2500'] = str_replace(',', '', $_POST['input2-hrg_leb_2500']);
						$input_params3['hrg_1001_2500'] = str_replace(',', '', $_POST['input2-hrg_1001_2500']);
						$input_params3['hrg_501_1000'] = str_replace(',', '', $_POST['input2-hrg_501_1000']);
						$input_params3['hrg_51_500'] = str_replace(',', '', $_POST['input2-hrg_51_500']);
						$input_params3['hrg_0_50'] = str_replace(',', '', $_POST['input2-hrg_0_50']);
						$input_params3['vol_leb_2500'] = str_replace(',', '', $_POST['input2-vol_leb_2500']);
						$input_params3['vol_1001_2500'] = str_replace(',', '', $_POST['input2-vol_1001_2500']);
						$input_params3['vol_501_1000'] = str_replace(',', '', $_POST['input2-vol_501_1000']);
						$input_params3['vol_51_500'] = str_replace(',', '', $_POST['input2-vol_51_500']);
						$input_params3['vol_0_50'] = str_replace(',', '', $_POST['input2-vol_0_50']);
						$input_params3['bkn_meter_bulan'] = str_replace(',', '', $_POST['input2-bkn_meter_bulan']);
						$input_params3['bkn_meter_hari'] = str_replace(',', '', $_POST['input2-bkn_meter_hari']);
						$input_params3['ptnjk_meter_bulan_lalu'] = str_replace(',', '', $_POST['input2-ptnjk_meter_bulan_lalu']);
						$input_params3['ptnjk_meter_hari_ini'] = str_replace(',', '', $_POST['input2-ptnjk_meter_hari_ini']);
						$input_params3['spt_detil_id'] = $input_params2['spt_detil_id'];
						$input_params3['spt_id'] = $input_params['spt_id'];
						$input_params3['spt_detil_abt_id'] = $spt_detil_abt_id;

						$this->delegate_postTomodel($input_params3, $m3);

						$result = $this->dao->insert($m3);
						if (!$result) {
							$this->_ci->db->trans_rollback();
							die('ERROR: gagal menambah data');
						}
					}

					//== END ==//

				}
			} else {
				$input_params['tahun_pajak'] = $tahun_pajak;

				if ($this->bundle_id == '3') {

					$this->_ci->load->model(array('spt_detil_reklame_model', 'wp_wr_reklame_model'));
					$m3 = $this->_ci->spt_detil_reklame_model;
					$m4 = $this->_ci->wp_wr_reklame_model;

					$spt_row = $this->dao->execute(0, "SELECT * FROM spt WHERE spt_id='" . $id_value . "'")->row_array();

					$input_params3 = array();
					$input_params4 = array();

					$result = $this->dao->delete($m2, array('spt_id' => $id_value));
					if (!$result) {
						$this->_ci->db->trans_rollback();
						die('ERROR: gagal menambah data');
					}

					$result = $this->dao->delete($m3, array('spt_id' => $id_value));
					if (!$result) {
						$this->_ci->db->trans_rollback();
						die('ERROR: gagal menambah data');
					}


					$n_rows = $_POST['n_ads_detail_rows'];
					for ($i = 1; $i <= $n_rows; $i++) {

						if (isset($_POST['input2-jenis_reklame_id' . $i])) {

							$input_params2['kegus_id'] = $kegus_id;
							$input_params2['nilai_terkena_pajak'] = str_replace(',', '', $_POST['input2-nilai_sewa_reklame' . $i]);
							$input_params2['persen_tarif'] = str_replace(',', '', $_POST['input2-persen_tarif' . $i]);
							$input_params2['pajak'] = str_replace(',', '', $_POST['input2-pajak' . $i]);
							$input_params2['spt_id'] = $id_value;
							$input_params2['spt_detil_id'] = $this->_ci->global_model->get_nextval('spt_detil_spt_detil_id_seq');

							$this->delegate_postTomodel($input_params2, $m2);

							$result = $this->dao->insert($m2);

							if (!$result) {
								$this->_ci->db->trans_rollback();
								die('ERROR: gagal menambah data');
							}

							$ads_type = $_POST['input2-jenis_reklame_id' . $i];

							if (($ads_type >= 1 and $ads_type <= 15) or $ads_type == 19) {
								$index1 = explode('_', $_POST['input2-indeks_kawasan_id' . $i]);
								$index2 = explode('_', $_POST['input2-indeks_sudut_pandang_id' . $i]);
								$index3 = explode('_', $_POST['input2-indeks_kelas_jalan_id' . $i]);
								$index4 = explode('_', $_POST['input2-indeks_ketinggian_id' . $i]);
								$index_id1 = $index1[0];
								$index_id2 = $index2[0];
								$index_id3 = $index3[0];
								$index_id4 = $index4[0];
								$index1 = $_POST['input2-indeks_kawasan' . $i];
								$index2 = $_POST['input2-indeks_sudut_pandang' . $i];
								$index3 = $_POST['input2-indeks_kelas_jalan' . $i];
								$index4 = $_POST['input2-indeks_ketinggian' . $i];
							} else {
								$index_id1 = 0;
								$index_id2 = 0;
								$index_id3 = 0;
								$index_id4 = 0;
								$index1 = '';
								$index2 = '';
								$index3 = '';
								$index4 = '';
							}

							$ads_type = $_POST['input2-jenis_reklame_id' . $i];
							$input_params3['jenis_reklame_id'] = $ads_type;
							$input_params3['area'] = $_POST['input2-area' . $i];
							$input_params3['judul'] = $_POST['input2-judul' . $i];
							$input_params3['lokasi'] = $_POST['input2-lokasi' . $i];
							$input_params3['indeks_kawasan_id'] = $index_id1;
							$input_params3['indeks_sudut_pandang_id'] = $index_id2;
							$input_params3['indeks_kelas_jalan_id'] = $index_id3;
							$input_params3['indeks_ketinggian_id'] = $index_id4;
							$input_params3['indeks_kawasan'] = $index1;
							$input_params3['indeks_sudut_pandang'] = $index2;
							$input_params3['indeks_kelas_jalan'] = $index3;
							$input_params3['indeks_ketinggian'] = $index4;
							$input_params3['ukuran'] = str_replace(',', '', $_POST['input2-ukuran' . $i]);;
							$input_params3['jangka_waktu'] = str_replace(',', '', $_POST['input2-jangka_waktu' . $i]);
							$input_params3['jumlah'] = str_replace(',', '', $_POST['input2-jumlah' . $i]);
							$input_params3['harga_satuan'] = str_replace(',', '', $_POST['input2-harga_satuan' . $i]);
							$input_params3['nilai_sewa_reklame'] = str_replace(',', '', $_POST['input2-nilai_sewa_reklame' . $i]);
							$input_params3['persen_tarif'] = str_replace(',', '', $_POST['input2-persen_tarif' . $i]);
							$input_params3['pajak'] = $input_params2['pajak'];
							$input_params3['tgl_pasang'] = us_date_format($_POST['input2-tgl_pasang' . $i]);
							$input_params3['spt_id'] = $id_value;
							$input_params3['spt_detil_id'] = $input_params2['spt_detil_id'];

							$this->delegate_postTomodel($input_params3, $m3);
							$result = $this->dao->insert($m3);

							if (!$result) {
								$this->_ci->db->trans_rollback();
								die('ERROR: gagal menambah data');
							}
						}
					}

					$x_district = explode('_', $_POST['input3-kecamatan']);
					$x_village = explode('_', $_POST['input3-kelurahan']);

					$input_params4['nama'] = $_POST['input3-nama'];
					$input_params4['alamat'] = $_POST['input3-alamat'];
					$input_params4['no_telepon'] = $_POST['input3-no_telepon'];
					$input_params4['kelurahan_id'] = $x_village[0];
					$input_params4['kecamatan_id'] = $x_district[0];
					$input_params4['kelurahan'] = $x_village[1];
					$input_params4['kecamatan'] = $x_district[1];

					$this->delegate_postTomodel($input_params4, $m4);
					$result = $this->dao->update($m4, array('wp_wr_reklame_id' => $spt_row['wp_wr_reklame_id']));

					if (!$result) {
						$this->_ci->db->trans_rollback();
						die('ERROR: gagal merubah data');
					}
				} else if ($this->bundle_id == '4') {

					$result = $this->dao->delete($m2, array('spt_id' => $id_value));

					if (!$result) {
						$this->_ci->db->trans_rollback();
						die('ERROR: gagal merubah data');
					}

					$n_detail1_rows = $_POST['n_detail1_rows'];
					$input_params['nilai_terkena_pajak'] = 0;
					$input_params['persen_tarif'] = 0;

					//this loop only have 1 repetition
					if ($n_detail1_rows == 1) {
						for ($i = 1; $i <= $n_detail1_rows; $i++) {

							if (isset($_POST['input2-kegus_id' . $i])) {

								$x_business = explode('_', $_POST['input2-kegus_id' . $i]);
								$input_params2['kegus_id'] = $x_business[0];
								$input_params2['nilai_terkena_pajak'] =  str_replace(',', '', $_POST['input2-nilai_terkena_pajak' . $i]);
								$input_params2['persen_tarif'] = str_replace(',', '', $_POST['input2-persen_tarif' . $i]);
								$input_params2['pajak'] = str_replace(',', '', $_POST['input2-pajak' . $i]);
								$input_params2[$pk] = $id_value;
								$input_params2['spt_detil_id'] = $this->_ci->global_model->get_nextval('spt_detil_spt_detil_id_seq');

								$this->delegate_postTomodel($input_params2, $m2);

								$result = $this->dao->insert($m2);
								if (!$result) {
									$this->_ci->db->trans_rollback();
									die('ERROR: gagal menambah data');
								}
								$input_params['nilai_terkena_pajak'] += $input_params2['nilai_terkena_pajak'];
								$input_params['persen_tarif'] = $input_params2['persen_tarif'];
							}
						}
					} else {
						die('ERROR: item pajak hiburan tidak boleh lebih dari 1');
					}
				} else {

					$input_params2['nilai_terkena_pajak'] = $input_params['nilai_terkena_pajak'];
					$input_params2['persen_tarif'] = $input_params['persen_tarif'];
					$input_params2['pajak'] = $input_params['pajak'];

					$this->delegate_postTomodel($input_params2, $m2);

					$result = $this->dao->update($m2, array('spt_id' => $id_value));

					if (!$result) {
						$this->_ci->db->trans_rollback();
						die('ERROR: gagal merubah data');
					}

					if ($this->bundle_id == 5) {

						$this->_ci->load->model('spt_detil_penerangan_jalan_model');
						$m3 = $this->_ci->spt_detil_penerangan_jalan_model;

						$input_params3 = array();

						$input_params3['penggunaan_daya'] = str_replace(',', '', $_POST['input2-penggunaan_daya']);
						$input_params3['tarif_dasar'] = str_replace(',', '', $_POST['input2-tarif_dasar']);
						$input_params3['nilai_jual'] = $input_params['nilai_terkena_pajak'];
						$input_params3['persen_tarif'] = $input_params['persen_tarif'];
						$input_params3['pajak'] = $input_params['pajak'];

						$this->delegate_postTomodel($input_params3, $m3);

						$result = $this->dao->update($m3, array('spt_id' => $id_value));

						if (!$result) {
							$this->_ci->db->trans_rollback();
							die('ERROR: gagal merubah data');
						}
					}

					//additional manipulation in Non Metalic Mineral and Rock Tax
					if ($this->bundle_id == 6) {

						$spt_detail_row = $this->dao->execute(0, "SELECT spt_detil_id FROM spt_detil WHERE spt_id='" . $id_value . "'")->row_array();

						$this->_ci->load->model('spt_detil_mblb_model');
						$m3 = $this->_ci->spt_detil_mblb_model;

						$result = $this->dao->delete($m3, array('spt_detil_id' => $spt_detail_row['spt_detil_id']));

						if (!$result) {
							$this->_ci->db->trans_rollback();
							die('ERROR: gagal menambah data');
						}

						$n_detail2_rows = $_POST['n_detail2_rows'];
						$input_params3 = array();

						for ($i = 1; $i <= $n_detail2_rows; $i++) {

							if (isset($_POST['input2-mblb_id' . $i])) {

								$x_mblb = explode('_', $_POST['input2-mblb_id' . $i]);
								$input_params3['mblb_id'] = $x_mblb[0];
								$input_params3['volume'] = str_replace(',', '', $_POST['input2-mblb_volume' . $i]);
								$input_params3['tarif_dasar'] = str_replace(',', '', $_POST['input2-mblb_tarif_dasar' . $i]);
								$input_params3['nilai_jual'] = str_replace(',', '', $_POST['input2-mblb_nilai_jual' . $i]);
								$input_params3['spt_detil_id'] = $spt_detail_row['spt_detil_id'];
								$input_params3['spt_id'] = $id_value;
								$input_params3['spt_detil_mblb_id'] = $this->_ci->global_model->get_nextval('spt_detil_mblb_spt_detil_mblb_id_seq');

								$this->delegate_postTomodel($input_params3, $m3);

								$result = $this->dao->insert($m3);

								if (!$result) {
									$this->_ci->db->trans_rollback();
									die('ERROR: gagal menambah data');
								}
							}
						}
					}

					if ($this->bundle_id == 7) {
						$spt_detail_row = $this->dao->execute(0, "SELECT spt_detil_id FROM spt_detil WHERE spt_id='" . $id_value . "'")->row_array();

						$this->_ci->load->model('spt_detil_abt_model');
						$m3 = $this->_ci->spt_detil_abt_model;

						$input_params3 = array();

						$get_spt_detil_abt_id = $this->dao->execute(0, "SELECT spt_detil_abt_id FROM spt_detil_abt")->row_array();
						$spt_detil_abt_id = $get_spt_detil_abt_id['spt_detil_abt_id'];
						$input_params3['hrg_leb_2500'] = str_replace(',', '', $_POST['input2-hrg_leb_2500']);
						$input_params3['hrg_1001_2500'] = str_replace(',', '', $_POST['input2-hrg_1001_2500']);
						$input_params3['hrg_501_1000'] = str_replace(',', '', $_POST['input2-hrg_501_1000']);
						$input_params3['hrg_51_500'] = str_replace(',', '', $_POST['input2-hrg_51_500']);
						$input_params3['hrg_0_50'] = str_replace(',', '', $_POST['input2-hrg_0_50']);
						$input_params3['vol_leb_2500'] = str_replace(',', '', $_POST['input2-vol_leb_2500']);
						$input_params3['vol_1001_2500'] = str_replace(',', '', $_POST['input2-vol_1001_2500']);
						$input_params3['vol_501_1000'] = str_replace(',', '', $_POST['input2-vol_501_1000']);
						$input_params3['vol_51_500'] = str_replace(',', '', $_POST['input2-vol_51_500']);
						$input_params3['vol_0_50'] = str_replace(',', '', $_POST['input2-vol_0_50']);
						$input_params3['bkn_meter_bulan'] = str_replace(',', '', $_POST['input2-bkn_meter_bulan']);
						$input_params3['bkn_meter_hari'] = str_replace(',', '', $_POST['input2-bkn_meter_hari']);
						$input_params3['ptnjk_meter_bulan_lalu'] = str_replace(',', '', $_POST['input2-ptnjk_meter_bulan_lalu']);
						$input_params3['ptnjk_meter_hari_ini'] = str_replace(',', '', $_POST['input2-ptnjk_meter_hari_ini']);

						$this->delegate_postTomodel($input_params3, $m3);

						$result = $this->dao->update($m3, array('spt_id' => $id_value));
						if (!$result) {
							$this->_ci->db->trans_rollback();
							die('ERROR: gagal merubah data');
						}
					}
					//== END ==//
				}
			}

			$this->delegate_postTomodel($input_params, $m1);
			
			if ($act == 'add') {
				$result = $this->dao->insert($m1);
				$label = "menambah";
			} else {
				$result = $this->dao->update($m1, array($pk => $id_value));
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
					array('pajak_id' => $this->bundle_id),
					$this->collect_cond_params($_POST, 'src')
				);


				$src_params = array();
				$src_daterange_params = array();

				foreach ($_POST as $key => $val) {
					$x = explode('-', $key);
					if ($x[0] == 'src' and $val != '') {
						$field = $x[1];
						$src_params[$field] = $val;
					}

					if ($x[0] == 'src_date_range' and $val != '') {
						$field = $x[1];
						$src_daterange_params[$field . '-' . $x[2]] = $val;
					}
				}

				$this->print_list_data($menu, $cond_params, array_merge($src_params, $src_daterange_params));
			}
		} else {
			$this->_ci->load->view('errors/html/error_403', array('type' => $act));
		}
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

			$this->_ci->load->model(array($tbl_name . '_model', 'spt_detil_model'));
			$m1 = $this->_ci->{$tbl_name . '_model'};
			$m2 = $this->_ci->spt_detil_model;

			$this->_ci->db->trans_begin();

			$cond_params = array($pk => $id);

			$result = $this->dao->delete($m2, $cond_params);
			if (!$result) {
				$this->_ci->db->trans_rollback();
				die('ERROR: gagal menghapus data');
			}

			if ($this->bundle_id == '7') {
				$spt_id = $cond_params['spt_id'];
				$this->dao->execute(0, "DELETE FROM spt_detil_abt WHERE spt_id = $spt_id");
			}

			if ($this->bundle_id == '3') {

				$this->_ci->load->model(array('spt_detil_reklame_model', 'wp_wr_reklame_model'));
				$m3 = $this->_ci->spt_detil_reklame_model;
				$m4 = $this->_ci->wp_wr_reklame_model;

				$result = $this->dao->delete($m3, $cond_params);
				if (!$result) {
					$this->_ci->db->trans_rollback();
					die('ERROR: gagal menghapus data');
				}

				$spt_row = $this->dao->execute(0, "SELECT wp_wr_id FROM spt WHERE spt_id='" . $id . "'")->row_array();

				$result = $this->dao->delete($m4, array('wp_wr_reklame_id' => $spt_row['wp_wr_id']));
				if (!$result) {
					$this->_ci->db->trans_rollback();
					die('ERROR: gagal menghapus data');
				}
			}


			if ($this->bundle_id == '6') {
				$this->_ci->load->model('spt_detil_mblb_model');
				$m3 = $this->_ci->spt_detil_mblb_model;

				$result = $this->dao->delete($m3, $cond_params);
				if (!$result) {
					$this->_ci->db->trans_rollback();
					die('ERROR: gagal menghapus data');
				}
			}

			$result = $this->dao->delete($m1, $cond_params);

			if (!$result) {
				$this->_ci->db->trans_rollback();
				die('ERROR: gagal menghapus data');
			}

			$this->_ci->db->trans_commit();


			$cond_params = array_merge(array('pajak_id' => $this->bundle_id), $this->collect_cond_params($_POST, 'src'));

			$src_params = array();
			$src_daterange_params = array();

			foreach ($_POST as $key => $val) {
				$x = explode('-', $key);
				if ($x[0] == 'src' and $val != '') {
					$field = $x[1];
					$src_params[$field] = $val;
				}

				if ($x[0] == 'src_date_range' and $val != '') {
					$field = $x[1];
					$src_daterange_params[$field . '-' . $x[2]] = $val;
				}
			}

			$this->print_list_data($menu, $cond_params, array_merge($src_params, $src_daterange_params));
		} else {
			$this->_ci->load->view('errors/html/error_403', array('type' => $act));
		}
	}
}
