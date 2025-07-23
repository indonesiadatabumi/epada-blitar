<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'controllers' . DIRECTORY_SEPARATOR . 'Item_bundle_parent.php';

class print_assessment_letter extends item_bundle_parent
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

		$sql = "SELECT * FROM ref_jenis_spt WHERE singkatan LIKE 'S%' ORDER BY ref_jenspt_id ASC";
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


	function determination_list()
	{

		$spt_type = $_POST['jenis_spt_id'];
		$input_id = $_POST['input_id'];
		$tahun_pajak = $_POST['tahun_pajak'];

		$tipe_penetapan = ($spt_type == '1' ? '1' : '2');

		$sql = "SELECT a.kohir,a.tahun_pajak,to_char(a.tgl_penetapan,'dd-mm-yyyy') as tgl_penetapan,
					to_char(a.tgl_jatuh_tempo,'dd-mm-yyyy') as tgl_jatuh_tempo,b.nama_wp,b.npwpd FROM penetapan_pajak as a 
					LEFT JOIN (SELECT x.lhp_id,y.nama as nama_wp,z.npwprd as npwpd FROM laporan_hasil_pemeriksaan as x 
							   LEFT JOIN wp_wr_detil as y ON (x.wp_wr_detil_id=y.wp_wr_detil_id) 
							   LEFT JOIN wp_wr as z ON (x.wp_wr_id=z.wp_wr_id)) as b ON (a.lhp_id=b.lhp_id) 
							   LEFT JOIN laporan_hasil_pemeriksaan_detil  as c ON (b.lhp_id=c.lhp_id) 
					WHERE a.pajak_id='" . $this->bundle_id . "' AND tipe_penetapan='2' AND a.jenis_spt_id='" . $spt_type . "' AND a.tahun_pajak='" . $tahun_pajak . "' 
					UNION 
					SELECT a.kohir,a.tahun_pajak,to_char(a.tgl_penetapan,'dd-mm-yyyy') as tgl_penetapan,
					to_char(a.tgl_jatuh_tempo,'dd-mm-yyyy') as tgl_jatuh_tempo,b.nama_wp,b.npwpd FROM penetapan_pajak as a 
					LEFT JOIN v_spt as b ON (a.spt_id=b.spt_id) 
					WHERE a.pajak_id='" . $this->bundle_id . "' AND tipe_penetapan='1' AND a.jenis_spt_id='" . $spt_type . "' AND a.tahun_pajak='" . $tahun_pajak . "' ";

		$rows = $this->dao->execute(0, $sql)->result_array();

		$data = array('rows' => $rows, 'input_id' => $input_id);

		$view_folder = $this->bundle_type . '/' . __CLASS__ . '/determination_list';

		$this->_ci->load->view($view_folder, $data);
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
			case '2':
				$method = "pdf";
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

		$legalitator_row = array();
		$evaluator_row = array();
		$spt_type_id = $src_params['jenis_spt_id'];

		$sql = "SELECT a.nama,a.nip,b.pangkat,c.nama_jabatan FROM pejabat_daerah as a 
					LEFT JOIN ref_gol_ruang as b ON (a.goru_id=b.ref_goru_id) 
					LEFT JOIN ref_jabatan_pejabat_daerah as c ON (a.japeda_id=c.ref_japeda_id)";

		if (isset($printAttr_params['legalitator'])) {
			$cond = " WHERE pejda_id='" . $printAttr_params['legalitator'] . "'";
			$_sql = $sql . $cond;
			$legalitator_row = $this->dao->execute(0, $_sql)->row_array();
		}

		$jenis_pajak = $this->bundle_id;

		$sql_kode_pajak = "SELECT b.rek_bank FROM bundel_pajak_retribusi AS a
							LEFT JOIN tbl_ref_rekening AS b ON a.kode_pajak=b.rek_epada
							WHERE a.bundel_id = " . $jenis_pajak . "";
		$kode_pajak = $this->dao->execute(0, $sql_kode_pajak)->row_array();

		$rows = $this->get_rows($src_params);

		$system_params = $this->_ci->database_interactions->get_system_params();

		$tax_year = (isset($src_params['tahun_pajak']) ? $src_params['tahun_pajak'] : date('Y'));

		$data = array(
			'rows' => $rows,
			'system_params' => $system_params,
			'tax_name' => $this->bundle_row['nama_paret'],
			'tax_year' => $tax_year,
			'kode_pajak' => $kode_pajak,
			'legalitator_row' => $legalitator_row,
			'show_signature' => isset($printAttr_params['showSignature']),
			'bundle_type' => $this->bundle_type,
			'bundle_item_type' => $this->bundle_item_type,
			'menu' => $this->menu,
			'spt_type_id' => $spt_type_id,
		);

		$view_folder = $this->bundle_type . '/' . __CLASS__;

		if ($report_type == 2) {
			// $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', [215, 330],'orientation'=>'P']);
			$mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'mpdf']);

			$mpdf->SetMargins(5, 5, 5);
			$data = array(
				'rows' => $rows,
				'system_params' => $system_params,
				'tax_name' => $this->bundle_row['nama_paret'],
				'tax_year' => $tax_year,
				'kode_pajak' => $kode_pajak,
				'legalitator_row' => $legalitator_row,
				'show_signature' => isset($printAttr_params['showSignature']),
				'bundle_type' => $this->bundle_type,
				'bundle_item_type' => $this->bundle_item_type,
				'menu' => $this->menu,
				'spt_type_id' => $spt_type_id,
				'mpdf' => $mpdf,
			);

			// var_dump($data);
			// die();

			$view_folder .= '/pdf';
		}


		if ($spt_type_id == '1') {
			$view_folder .= '1';
		} else {
			$view_folder .= '2';
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

				$sql = "SELECT a.penetapan_id,a.tgl_penetapan,a.tgl_jatuh_tempo,a.kohir,b.* FROM penetapan_pajak as a 
							INNER JOIN (SELECT a.*,b.dasar_hukum,b.kode_rekening,c.jenis_reklame as nama_kegus,c.judul as judul_reklame,
										b.volume,b.nilai_terkena_pajak,b.tarif_dasar,b.diskon,b.denda,b.bunga FROM v_spt as a 
								LEFT JOIN (SELECT x.spt_id,x.volume,x.nilai_terkena_pajak,x.tarif_dasar,x.diskon,x.denda,x.bunga,y.dasar_hukum,y.kode_rekening,y.nama_kegus FROM spt_detil as x 
										   LEFT JOIN ref_kegiatan_usaha as y ON (x.kegus_id=y.ref_kegus_id)) as b ON (a.spt_id=b.spt_id) 
								LEFT JOIN (SELECT x.spt_id,y.jenis_reklame,x.judul FROM spt_detil_reklame as x LEFT JOIN ref_jenis_reklame as y ON (x.jenis_reklame_id=y.ref_jenrek_id)) as c ON (a.spt_id=c.spt_id)) as b ON (a.spt_id=b.spt_id)";
			} elseif ($this->bundle_id == '7') {
				$sql = "SELECT a.penetapan_id,a.tgl_penetapan, a.tgl_jatuh_tempo,a.kohir,b.*, c.kompensasi, d.vol_0_50, d.vol_51_500, d.vol_501_1000, d.vol_1001_2500, d.vol_leb_2500, d.hrg_0_50, d.hrg_51_500, d.hrg_501_1000, d.hrg_1001_2500, d.hrg_leb_2500 FROM penetapan_pajak as a 
							INNER JOIN (SELECT a.*,b.dasar_hukum,b.kode_rekening,b.nama_kegus,b.volume,b.nilai_terkena_pajak,b.tarif_dasar,b.diskon,b.denda,b.bunga FROM v_spt as a 
								LEFT JOIN (SELECT x.spt_id,x.volume,x.nilai_terkena_pajak,x.tarif_dasar,x.diskon,x.denda,x.bunga,y.dasar_hukum,y.kode_rekening,y.nama_kegus FROM spt_detil as x 
										   LEFT JOIN ref_kegiatan_usaha as y ON (x.kegus_id=y.ref_kegus_id)) as b ON (a.spt_id=b.spt_id)) as b ON (a.spt_id=b.spt_id)
							LEFT JOIN spt as c ON a.spt_id=c.spt_id
							LEFT JOIN spt_detil_abt as d ON a.spt_id=d.spt_id";
			} else { //Non Advertisement SKPD

				$sql = "SELECT a.penetapan_id,a.tgl_penetapan,a.tgl_jatuh_tempo,a.kohir,b.*, c.kompensasi FROM penetapan_pajak as a 
							INNER JOIN (SELECT a.*,b.dasar_hukum,b.kode_rekening,b.nama_kegus,b.volume,b.nilai_terkena_pajak,b.tarif_dasar,b.diskon,b.denda,b.bunga FROM v_spt as a 
								LEFT JOIN (SELECT x.spt_id,x.volume,x.nilai_terkena_pajak,x.tarif_dasar,x.diskon,x.denda,x.bunga,y.dasar_hukum,y.kode_rekening,y.nama_kegus FROM spt_detil as x 
										   LEFT JOIN ref_kegiatan_usaha as y ON (x.kegus_id=y.ref_kegus_id)) as b ON (a.spt_id=b.spt_id)) as b ON (a.spt_id=b.spt_id)
							LEFT JOIN spt as c ON a.spt_id=c.spt_id";
			}
		} else { //All of SKPD- but SKPD

			$sql = "SELECT a.penetapan_id,a.tgl_penetapan,a.tgl_jatuh_tempo,a.kohir,b.*,c.singkatan as singkatan_spt,c.keterangan as keterangan_spt, f.masa_pajak1, f.masa_pajak2 FROM penetapan_pajak as a 
						INNER JOIN (SELECT a.*,b.npwprd as npwpd,c.nama as nama_wp,c.alamat,c.kelurahan,c.kecamatan,
									d.dasar_hukum,d.kode_rekening,d.nama_kegus,e.nilai_terkena_pajak,e.pajak_terhutang,
									e.kompensasi,e.setoran,e.kredit_pajak_lain,
									COALESCE(e.bunga,'0') as bunga,COALESCE(e.kenaikan,'0') as diskon,COALESCE(e.denda,'0') as denda,
									f.nama_paret as nama_pajak  FROM laporan_hasil_pemeriksaan as a 
									LEFT JOIN wp_wr as b ON (a.wp_wr_id=b.wp_wr_id) 
									LEFT JOIN wp_wr_detil as c ON (a.wp_wr_detil_id=c.wp_wr_detil_id)
									LEFT JOIN ref_kegiatan_usaha as d ON (a.kegus_id=d.ref_kegus_id) 
									INNER JOIN (SELECT SUM(nilai_terkena_pajak) as nilai_terkena_pajak,SUM(pajak_terhutang) as pajak_terhutang,
												SUM(kompensasi) as kompensasi,SUM(setoran) as setoran,SUM(kredit_pajak_lain) as kredit_pajak_lain,
												SUM(bunga) as bunga,SUM(kenaikan) as kenaikan,SUM(denda) as denda,
												lhp_id FROM laporan_hasil_pemeriksaan_detil GROUP BY lhp_id) as e ON (a.lhp_id=e.lhp_id) 
									LEFT JOIN bundel_pajak_retribusi as f ON (a.pajak_id=f.bundel_id)
									) as b ON (a.lhp_id=b.lhp_id) 
						LEFT JOIN ref_jenis_spt as c ON (a.jenis_spt_id=c.ref_jenspt_id)
						LEFT JOIN laporan_hasil_pemeriksaan_detil as f ON (a.lhp_id=f.lhp_id)";
		}

		$tax_year = (isset($src_params['tahun_pajak']) ? $src_params['tahun_pajak'] : date('Y'));
		$cond = " a.pajak_id='" . $this->bundle_id . "' AND a.jenis_spt_id='" . $spt_type_id . "' AND a.tahun_pajak='" . $tax_year . "' AND ";

		if (isset($src_params['kohir_awal']) && isset($src_params['kohir_akhir'])) {
			$cond .= "kohir BETWEEN '" . $src_params['kohir_awal'] . "' AND '" . $src_params['kohir_akhir'] . "'";
		} else if (isset($src_params['kohir_awal'])) {
			$cond .= "kohir >= '" . $src_params['kohir_awal'] . "'";
		} else if (isset($src_params['kohir_akhir'])) {
			$cond .= "kohir <= '" . $src_params['kohir_akhir'] . "'";
		}

		$sql .= " WHERE " . $cond;

		return $this->dao->execute(0, $sql)->result_array();
	}
}
