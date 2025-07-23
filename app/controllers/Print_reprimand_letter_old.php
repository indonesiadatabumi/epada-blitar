<?php
// 	defined('BASEPATH') OR exit('No direct script access allowed');

// 	require_once APPPATH.'controllers'.DIRECTORY_SEPARATOR.'Item_bundle_parent.php';

// 	class print_reprimand_letter extends item_bundle_parent{


// 		function __construct($bundle_type,$bundle_item_type,$menu){

// 			//bundle_type => taxes,duties
// 			//bundle_item_type => hotel,restaurant,entertainment,etc
// 			//menu => record_taxpayer1,record_taxpayer2,etc			
// 			parent::__construct($bundle_type,$bundle_item_type,$menu,__CLASS__);			
// 		}


// function index(){
// 	$this->_ci->admin_access_handler->check_access();			

// 	$district_rows = $this->_ci->database_interactions->get_district_rows();			
// 	$sql = "SELECT a.pejda_id,a.nama,b.nama_jabatan FROM pejabat_daerah as a 
// 			LEFT JOIN ref_jabatan_pejabat_daerah as b ON (a.japeda_id=b.ref_japeda_id)";

// 	$official_rows = $this->dao->execute(0,$sql)->result_array();

// 	$main_data = array('bundle_row'=>$this->bundle_row,
// 					   'district_rows'=>$district_rows,
// 					   'official_rows'=>$official_rows,
// 					   );

// 	// no need to modified
// 	$data = array('menu_params'=>$this->menu_params,
// 				  'main_params'=>array_merge($this->main_params,$main_data));

// 	$this->_ci->public_template->render($this->view_folder.'/index',$data);
// }


// function taxobject_list(){

// 	$sql = "SELECT * FROM v_objek_pajak WHERE pajak_id='".$this->bundle_id."'";
// 	$rows = $this->dao->execute(0,$sql)->result_array();

// 	$data = array('rows'=>$rows);

// 	$view_folder = $this->bundle_type.'/'.__CLASS__.'/taxobject_list';

// 	$this->_ci->load->view($view_folder,$data);
// }

// function report_controller(){			

// 	$menu = $_POST['menu'];			
// 	$report_type = $_POST['report_type'];

// 	$src_params = $this->collect_input_params($_POST,'src',false);
// 	$printAttr_params = $this->collect_input_params($_POST,'printAttr',false);

// 	$urlstring_params = $this->generate_urlstring_params(array_merge($src_params,$printAttr_params));
// 	$method = "";

// 	switch ($report_type) {
// 		case '1':$method = "_print";break;
// 		case '2':$method = "pdf";break;
// 		case '3':$method = "excel";break;
// 	}

// 	$this->menu = $menu;

// 	echo "<script type='text/javascript'>

// 		window.open('".base_url()."bundle/".$this->bundle_type."/".$this->bundle_item_type."/".$menu."/".$method.$urlstring_params."');

// 	</script>";
// }

// function _print(){

// 	$this->show_report(1);

// }

// function pdf(){

// 	$this->show_report(2);

// }

// function excel(){
// 	$this->show_report(3);
// }

// function show_report($report_type){			
// 	$src_params = $this->collect_input_params($_GET,'src');
// 	$printAttr_params = $this->collect_input_params($_GET,'printAttr');

// 	$legalitator_row = array();
// 	$evaluator_row = array();

// 	if(isset($printAttr_params['showSignature'])){
// 		$sql = "SELECT a.nama,a.nip,b.pangkat,c.nama_jabatan FROM pejabat_daerah as a 
// 				LEFT JOIN ref_gol_ruang as b ON (a.goru_id=b.ref_goru_id) 
// 				LEFT JOIN ref_jabatan_pejabat_daerah as c ON (a.japeda_id=c.ref_japeda_id)";

// 		if(isset($printAttr_params['legalitator'])){
// 			$cond = " WHERE pejda_id='".$printAttr_params['legalitator']."'";
// 			$_sql = $sql.$cond;				
// 			$legalitator_row = $this->dao->execute(0,$_sql)->row_array();
// 		}

// 		if(isset($printAttr_params['evaluator'])){
// 			$cond = " WHERE pejda_id='".$printAttr_params['evaluator']."'";
// 			$_sql = $sql.$cond;
// 			$evaluator_row = $this->dao->execute(0,$_sql)->row_array();				
// 		}
// 	}

// 	$rows = $this->get_rows($src_params);

// 	$system_params = $this->_ci->database_interactions->get_system_params();

// 	$tax_year = (isset($src_params['tahun_pajak'])?$src_params['tahun_pajak']:date('Y'));

// 	$data = array('rows'=>$rows,
// 				  'print_date'=>us_date_format($printAttr_params['print_date']),
// 				  'system_params'=>$system_params,
// 				  'tax_name'=>$this->bundle_row['nama_paret'],
// 				  'tax_year'=>$tax_year,
// 				  'legalitator_row'=>$legalitator_row,
// 				  'evaluator_row'=>$evaluator_row,
// 				  'show_signature'=>isset($printAttr_params['showSignature']),
// 				  );

// var_dump($data);
// die();

// 	$view_folder = $this->bundle_type.'/'.__CLASS__;

// 	if($report_type==1){
// 		$view_folder .= '/print';
// 	}
// 	else if($report_type==2){
// 		$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', [215, 330],'orientation'=>'L']);
// 		$data['mpdf'] = $mpdf;
// 		$view_folder .= '/pdf';
// 	}else{
// 		$view_folder .='/excel';
// 	}

// 	$this->_ci->load->view($view_folder,$data);
// }


// 		function get_rows($src_params){

// 			$res = __CLASS__.'_resources';
// 			require_once APPPATH.'libraries'.DIRECTORY_SEPARATOR.'system_resources'.DIRECTORY_SEPARATOR.$res.'.php';			

// 			$tbl_name = $res::$_TBL_NAME;
// 			$pk = $res::$_PK;
// 			$sql=$res::$_SQL_LIST;

// 			$tax_year = (isset($src_params['tahun_pajak'])?$src_params['tahun_pajak']:date('Y'));
// 			$cond = " a.pajak_id='".$this->bundle_id."' AND a.tahun_pajak='".$tax_year."'";


// 			if(isset($src_params['tgl_proses']))
// 			{
// 				$cond .= " AND to_char(tgl_proses,'dd-mm-yyyy')='".$src_params['tgl_proses']."'";
// 			}

// 			$sql .=" WHERE ".$cond;			

// 			return $this->dao->execute(0,$sql)->result_array();
// 		}


// 	}

defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'controllers' . DIRECTORY_SEPARATOR . 'Item_bundle_parent.php';

class print_reprimand_letter_old extends item_bundle_parent
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

		$main_data = array(
			'bundle_row' => $this->bundle_row,
			'district_rows' => $district_rows,
			'official_rows' => $official_rows,
		);

		// no need to modified
		$data = array(
			'menu_params' => $this->menu_params,
			'main_params' => array_merge($this->main_params, $main_data)
		);

		$this->_ci->public_template->render($this->view_folder . '/index', $data);
	}


	function taxobject_list()
	{

		$sql = "SELECT * FROM v_objek_pajak WHERE pajak_id='" . $this->bundle_id . "'";
		$rows = $this->dao->execute(0, $sql)->result_array();

		$data = array('rows' => $rows);

		$view_folder = $this->bundle_type . '/' . __CLASS__ . '/taxobject_list';

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
			case '1':
				$method = "_print_laporan";
				break;
			case '2':
				$method = "_print_bayar";
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

	function _print_laporan()
	{

		$this->show_report(1);
	}

	function _print_bayar()
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
		$get_tgl_cetak = $src_params['tgl_cetak'];
		$tgl_cetak = us_date_format($get_tgl_cetak);

		// insert surat teguran
		$sql_data_wp = "SELECT npwprd, nama, alamat, pajak_id FROM wp_wr WHERE npwprd='" . $src_params['npwprd'] . "'";
		$data_wp = $this->dao->execute(0, $sql_data_wp)->row_array();
		$npwprd = $data_wp['npwprd'];
		$nama = $data_wp['nama'];
		$alamat = $data_wp['alamat'];
		$pajak_id = $data_wp['pajak_id'];

		$sql_id_teguran = "select max(id_teguran)+1 as id_teguran from surat_teguran";
		$get_id_teguran = $this->dao->execute(0, $sql_id_teguran)->row_array();

		$id_teguran = $get_id_teguran['id_teguran'];
		if ($id_teguran == null) {
			$id_teguran = 1;
		}

		$sql_insert_teguran = "INSERT INTO surat_teguran(id_teguran, npwprd, nama, alamat, pajak_id)VALUES
								($id_teguran, '$npwprd', '$nama', '$alamat', $pajak_id)";

		$result = $this->dao->execute(0, $sql_insert_teguran);

		if (isset($printAttr_params['showSignature'])) {
			$sql = "SELECT a.nama,a.nip,b.pangkat,c.nama_jabatan FROM pejabat_daerah as a 
						LEFT JOIN ref_gol_ruang as b ON (a.goru_id=b.ref_goru_id) 
						LEFT JOIN ref_jabatan_pejabat_daerah as c ON (a.japeda_id=c.ref_japeda_id)";

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
		}


		$rows = $this->get_rows($src_params);

		$system_params = $this->_ci->database_interactions->get_system_params();

		// var_dump($tgl_cetak);
		// die();

		$tax_year = (isset($src_params['tahun_pajak']) ? $src_params['tahun_pajak'] : date('Y'));

		// $curr_date = date('Y-m-d');

		$data = array(
			'rows' => $rows,
			// 'print_date'=>us_date_format($printAttr_params['print_date']),
			'system_params' => $system_params,
			'tax_name' => $this->bundle_row['nama_paret'],
			'tax_year' => $tax_year,
			'legalitator_row' => $legalitator_row,
			'evaluator_row' => $evaluator_row,
			// 'curr_date' => $curr_date,
			'show_signature' => isset($printAttr_params['showSignature']),
			'tgl_cetak' => $tgl_cetak,
		);

		$view_folder = $this->bundle_type . '/' . __CLASS__;

		if ($report_type == 1) {
			$view_folder .= '/print_teguran_lapor';
		} else if ($report_type == 2) {
			$view_folder .= '/print_teguran_bayar';
		} else {
			$view_folder .= '/excel';
		}

		$this->_ci->load->view($view_folder, $data);
	}

	// function pdf(){

	// 	$type = $_GET['type'];

	// 	$rows = array();

	// 	//$sql = "SELECT jenis, golongan,npwprd,no_reg,nama,alamat,kecamatan,tgl_pendaftaran FROM wp_wr";
	// 	$sql = "SELECT jenis, golongan,npwprd,no_reg,nama,alamat_pemilik alamat,kecamatan_pemilik kecamatan,tgl_pendaftaran FROM wp_wr";


	// 	if($type=='single'){
	// 		$_sql = $sql." WHERE wp_wr_id='".$_GET['id']."'";
	// 		$rows[] = $this->dao->execute(0,$_sql)->row_array();
	// 	}else{
	// 		$n_rows = $_POST['n_rows'];
	// 		for($i=1;$i<=$n_rows;$i++){

	// 			if(isset($_POST['input-choice'.$i])){
	// 				$id = $_POST['input-id'.$i];
	// 				$_sql = $sql." WHERE wp_wr_id='".$id."'";
	// 				$rows[] = $this->dao->execute(0,$_sql)->row_array();
	// 			}
	// 		}
	// 	}

	// 	$system_params = $this->_ci->database_interactions->get_system_params();

	// 	//$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'fomat'=>[210, 297]]);	
	// 	$mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir().DIRECTORY_SEPARATOR.'mpdf']); 		

	// 	$data = array('rows'=>$rows,'system_params'=>$system_params,'mpdf'=>$mpdf);

	// 	$view_folder = $this->bundle_type.'/'.__CLASS__;

	// 	$this->_ci->load->view($view_folder.'/pdf',$data);

	// }

	function get_rows($src_params)
	{

		$res = __CLASS__ . '_resources';
		require_once APPPATH . 'libraries' . DIRECTORY_SEPARATOR . 'system_resources' . DIRECTORY_SEPARATOR . $res . '.php';

		$tbl_name = $res::$_TBL_NAME;
		$pk = $res::$_PK;
		$sql = $res::$_SQL_LIST;

		$tax_year = (isset($src_params['tahun_pajak']) ? $src_params['tahun_pajak'] : date('Y'));
		$cond = " a.npwprd='" . $src_params['npwprd'] . "'";


		if (isset($src_params['tgl_proses'])) {
			$cond .= " AND to_char(tgl_proses,'dd-mm-yyyy')='" . $src_params['tgl_proses'] . "'";
		}

		$sql .= " WHERE " . $cond;

		return $this->dao->execute(0, $sql)->row_array();
	}

	function list_teguran()
	{
		$view_folder = $this->bundle_type . '/' . __CLASS__;
		$pajak_id = $_POST['pajak_id'];
		$sql = "SELECT * FROM surat_teguran WHERE pajak_id='" . $pajak_id . "' ORDER BY id_teguran ASC";
		$list_teguran = $this->dao->execute(0, $sql)->result_array();
		$today = date('Y-m-d');
		$data = [
			'list_teguran' => $list_teguran,
			'today' => $today
		];

		$this->_ci->load->view($view_folder . '/list_teguran', $data);
	}

	function insert_penetapan()
	{
		$view_folder = $this->bundle_type . '/' . __CLASS__;
		$id_teguran = $_POST['id_teguran'];
		$data = [
			'bundle_item_type' => $this->bundle_item_type,
			'menu' => $this->menu,
			'id_teguran' => $id_teguran
		];

		$this->_ci->load->view($view_folder . '/penetapan_teguran', $data);
	}

	function update_penetapan()
	{
		$id_teguran = $_POST['id_teguran'];
		$get_created_time = $_POST['created_time'];
		$created_time = us_date_format($get_created_time);
		$jatuh_tempo = date('Y-m-d', strtotime('+5 days', strtotime($created_time)));

		$sql = "UPDATE surat_teguran SET created_time = '$created_time', jatuh_tempo = '$jatuh_tempo' WHERE id_teguran = $id_teguran";
		$this->dao->execute(0, $sql);

		echo "Sukses";
	}

	function cetak_surat()
	{
		$id_teguran = $_POST['id_teguran'];

		//ambil npwprd pada tabel surat_teguran
		$sql_npwprd = "SELECT npwprd FROM surat_teguran WHERE id_teguran=" . $id_teguran . "";
		$result_npwprd = $this->dao->execute(0, $sql_npwprd)->row_array();

		$src_params = [
			'npwprd' => $result_npwprd['npwprd'],
			'tgl_cetak' => date('Y-m-d'),
			'tahun_pajak' => date('Y')
		];
		$rows = $this->get_rows($src_params);

		$system_params = $this->_ci->database_interactions->get_system_params();

		// var_dump($tgl_cetak);
		// die();

		$tax_year = (isset($src_params['tahun_pajak']) ? $src_params['tahun_pajak'] : date('Y'));
		$tgl_cetak = $src_params['tgl_cetak'];

		// $curr_date = date('Y-m-d');

		$data = array(
			'rows' => $rows,
			// 'print_date'=>us_date_format($printAttr_params['print_date']),
			'system_params' => $system_params,
			'tax_name' => $this->bundle_row['nama_paret'],
			'tax_year' => $tax_year,
			// 'curr_date' => $curr_date,
			'show_signature' => isset($printAttr_params['showSignature']),
			'tgl_cetak' => $tgl_cetak,
		);

		$view_folder = $this->bundle_type . '/' . __CLASS__;

		$view_folder .= '/print_teguran_bayar';

		$this->_ci->load->view($view_folder, $data);
	}
}
