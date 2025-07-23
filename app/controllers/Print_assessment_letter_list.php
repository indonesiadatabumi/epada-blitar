<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'controllers' . DIRECTORY_SEPARATOR . 'Item_bundle_parent.php';

class print_assessment_letter_list extends item_bundle_parent
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

		$sql = "SELECT * FROM ref_jenis_spt WHERE singkatan LIKE 'SKP%' ORDER BY ref_jenspt_id ASC";
		$spt_type_rows = $this->dao->execute(0, $sql)->result_array();

		$main_data = array(
			'bundle_row' => $this->bundle_row,
			'district_rows' => $district_rows,
			'official_rows' => $official_rows,
			'spt_type_rows' => $spt_type_rows,
		);

		// no need to modified
		$data = array(
			'menu_params' => $this->menu_params,
			'main_params' => array_merge($this->main_params, $main_data)
		);

		$this->_ci->public_template->render($this->view_folder . '/index', $data);
	}

	function report_controller()
	{

		$menu = $_POST['menu'];

		$report_type = $_POST['report_type'];

		$src_params = $this->collect_input_params($_POST, 'src', false);
		$printAttr_params = $this->collect_input_params($_POST, 'printAttr', false);

		$urlstring_params = $this->generate_urlstring_params(array_merge($src_params, $printAttr_params));
		$method = "";

		switch ($report_type) {
			case '1':
				$method = "print";
				break;
			case '2':
				$method = "pdf";
				break;
			case '3':
				$method = "excel";
				break;
		}

		$this->menu = $menu;

		echo "<script type='text/javascript'>

				window.open('" . base_url() . "bundle/" . $this->bundle_type . "/" . $this->bundle_item_type . "/" . $menu . "/" . $method . $urlstring_params . "');

			</script>";
	}

	function _print()
	{

		$this->show_report(1);
	}

	function pdf()
	{

		$this->show_report(2);
	}

	function excel()
	{
		$this->show_report(3);
	}

	function show_report($report_type)
	{

		$src_params = $this->collect_input_params($_GET, 'src');
		$printAttr_params = $this->collect_input_params($_GET, 'printAttr');

		$sql = "SELECT a.nama,a.nip,b.pangkat,c.nama_jabatan FROM pejabat_daerah as a 
					LEFT JOIN ref_gol_ruang as b ON (a.goru_id=b.ref_goru_id) 
					LEFT JOIN ref_jabatan_pejabat_daerah as c ON (a.japeda_id=c.ref_japeda_id)";

		$legalitator_row = array();
		$evaluator_row = array();
		$spt_type_id = $src_params['jenis_spt_id'];

		$show_signature = (isset($printAttr_params['show_signature']));


		if (isset($printAttr_params['legalitator'])) {
			$cond = " WHERE pejda_id='" . $printAttr_params['legalitator'] . "'";
			$_sql = $sql . $cond;
			$legalitator_row = $this->dao->execute(0, $_sql)->row_array();
		}

		if (isset($printAttr_params['evaluator'])) {
			$cond = " WHERE pejda_id='" . $printAttr_params['evaluator'] . "'";
			$_sql = $sql . $cond;
			$evaluator_row = $this->dao->execute(0, $_sql)->row_array();
		}

		$rows = $this->get_rows($src_params);


		$spt_name = $this->_ci->database_interactions->get_arbitrary_data('ref_jenis_spt', 'singkatan', array('ref_jenspt_id' => $spt_type_id));

		$system_params = $this->_ci->database_interactions->get_system_params();

		$zone_searched = false;
		$district_row = array();

		if (isset($src_params['kecamatan_id'])) {
			$sql = "SELECT * FROM ref_kecamatan WHERE kecamatan_id='" . $src_params['kecamatan_id'] . "'";
			$district_row = $this->dao->execute(0, $sql)->row_array();
			$zone_searched = true;
		}


		$data = array(
			'rows' => $rows,
			'print_date' => us_date_format($printAttr_params['print_date']),
			'system_params' => $system_params,
			'tax_name' => $this->bundle_row['nama_paret'],
			'legalitator_row' => $legalitator_row,
			'evaluator_row' => $evaluator_row,
			'show_signature' => $show_signature,
			'district_row' => $district_row,
			'zone_searched' => $zone_searched,
			'bundle_id' => $this->bundle_id,
			'spt_type_id' => $spt_type_id,
			'spt_name' => $spt_name
		);

		$view_folder = $this->bundle_type . '/' . __CLASS__;

		if ($report_type == 1) {
			$view_folder .= '/print';
		} else if ($report_type == 2) {
			// $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', [215, 330],'orientation'=>'P']);
			$mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'mpdf']);

			$mpdf->SetMargins(10, 10, 10);
			// $data['mpdf'] = $mpdf;
			$data = array(
				'rows' => $rows,
				'print_date' => us_date_format($printAttr_params['print_date']),
				'system_params' => $system_params,
				'tax_name' => $this->bundle_row['nama_paret'],
				'legalitator_row' => $legalitator_row,
				'evaluator_row' => $evaluator_row,
				'show_signature' => $show_signature,
				'district_row' => $district_row,
				'zone_searched' => $zone_searched,
				'bundle_id' => $this->bundle_id,
				'spt_type_id' => $spt_type_id,
				'spt_name' => $spt_name,
				'mpdf' => $mpdf
			);
			$view_folder .= '/pdf';
		} else {
			$view_folder .= '/excel';
		}

		$this->_ci->load->view($view_folder, $data);
	}


	function get_rows($src_params)
	{

		$res = __CLASS__ . '_resources';
		require_once APPPATH . 'libraries' . DIRECTORY_SEPARATOR . 'system_resources' . DIRECTORY_SEPARATOR . $res . '.php';

		$tbl_name = $res::$_TBL_NAME;
		$pk = $res::$_PK;
		$sql = $res::$_SQL_LIST;

		$spt_type_id = $src_params['jenis_spt_id'];

		if ($spt_type_id == '1') {

			//Advertisement SKPD
			if ($this->bundle_id == '3') {

				$sql = "SELECT a.penetapan_id,a.tgl_penetapan,a.kohir,a.tgl_jatuh_tempo,b.* FROM penetapan_pajak as a 
							INNER JOIN (SELECT a.*,b.jenis_reklame,b.judul as judul_reklame,b.lokasi as lokasi_reklame FROM v_spt as a 
								LEFT JOIN (SELECT x.spt_id,y.jenis_reklame,x.judul,x.lokasi FROM spt_detil_reklame as x 
									LEFT JOIN ref_jenis_reklame as y ON (x.jenis_reklame_id=y.ref_jenrek_id)) as b ON (a.spt_id=b.spt_id)) as b ON (a.spt_id=b.spt_id)";
			} else { //Non Advertisement SKPD

				$sql = "SELECT a.penetapan_id,a.tgl_penetapan,a.tgl_jatuh_tempo,a.kohir,b.* FROM penetapan_pajak as a 
							INNER JOIN (SELECT a.*,b.dasar_hukum,b.kode_rekening,b.nama_kegus,b.volume,b.diskon,b.denda,b.bunga FROM v_spt as a 
								LEFT JOIN (SELECT x.spt_id,x.volume,x.diskon,x.denda,x.bunga,y.dasar_hukum,y.kode_rekening,y.nama_kegus FROM spt_detil as x 
										   LEFT JOIN ref_kegiatan_usaha as y ON (x.kegus_id=y.ref_kegus_id)) as b ON (a.spt_id=b.spt_id)) as b ON (a.spt_id=b.spt_id)";
			}
		} else { //All of SKPD- but SKPD

			$sql = "SELECT a.penetapan_id,a.tgl_penetapan,a.tgl_jatuh_tempo,a.kohir,b.*,c.singkatan as singkatan_spt,c.keterangan as keterangan_spt FROM penetapan_pajak as a 
						INNER JOIN (SELECT a.*,b.npwprd as npwpd,c.nama as nama_wp,c.alamat,c.kelurahan,c.kecamatan,
									d.dasar_hukum,d.kode_rekening,d.nama_kegus,e.nilai_terkena_pajak,
									f.masa_pajak1,g.masa_pajak2,
									h.nama_paret as nama_pajak  FROM laporan_hasil_pemeriksaan as a 
									LEFT JOIN wp_wr as b ON (a.wp_wr_id=b.wp_wr_id) 
									LEFT JOIN wp_wr_detil as c ON (a.wp_wr_detil_id=c.wp_wr_detil_id)
									LEFT JOIN ref_kegiatan_usaha as d ON (a.kegus_id=d.ref_kegus_id) 
									INNER JOIN (SELECT SUM(nilai_terkena_pajak) as nilai_terkena_pajak,lhp_id FROM laporan_hasil_pemeriksaan_detil GROUP BY lhp_id) as e ON (a.lhp_id=e.lhp_id) 
									INNER JOIN (SELECT MIN(masa_pajak1) as masa_pajak1,lhp_id FROM laporan_hasil_pemeriksaan_detil GROUP BY lhp_id) as f ON (a.lhp_id=f.lhp_id)
									INNER JOIN (SELECT MAX(masa_pajak2) as masa_pajak2,lhp_id FROM laporan_hasil_pemeriksaan_detil GROUP BY lhp_id) as g ON (a.lhp_id=g.lhp_id)
									LEFT JOIN bundel_pajak_retribusi as h ON (a.pajak_id=h.bundel_id)) as b ON (a.lhp_id=b.lhp_id) 
						LEFT JOIN ref_jenis_spt as c ON (a.jenis_spt_id=c.ref_jenspt_id)";
		}

		$cond = " a. pajak_id='" . $this->bundle_id . "' AND a.jenis_spt_id='" . $spt_type_id . "'";

		if (isset($src_params['tgl_penetapan_awal']) && isset($src_params['tgl_penetapan_akhir'])) {
			$cond .= " AND a.tgl_penetapan BETWEEN '" . us_date_format($src_params['tgl_penetapan_awal']) . "' AND '" . us_date_format($src_params['tgl_penetapan_akhir']) . "'";
		} else if (isset($src_params['tgl_penetapan_awal'])) {
			$cond .= " AND a.tgl_penetapan >= '" . us_date_format($src_params['tgl_penetapan_awal']) . "'";
		} else if (isset($src_params['tgl_penetapan_akhir'])) {
			$cond .= " AND a.tgl_penetapan <= '" . us_date_format($src_params['tgl_penetapan_akhir']) . "'";
		}

		if (isset($src_params['kecamatan_id'])) {
			$cond .= "  AND b.kecamatan_id='" . $src_params['kecamatan_id'] . "'";
		}

		$cond .= "ORDER BY kohir ASC";

		$sql .= " WHERE " . $cond;


		return $this->dao->execute(0, $sql)->result_array();
	}
}
