<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	require_once APPPATH.'controllers'.DIRECTORY_SEPARATOR.'Item_bundle_parent.php';

	class print_reprimand_letter_list extends item_bundle_parent{


		function __construct($bundle_type,$bundle_item_type,$menu){

			//bundle_type => taxes,duties
			//bundle_item_type => hotel,restaurant,entertainment,etc
			//menu => record_taxpayer1,record_taxpayer2,etc			
			parent::__construct($bundle_type,$bundle_item_type,$menu,__CLASS__);			
		}


		function index(){
			$this->_ci->admin_access_handler->check_access();			

			$district_rows = $this->_ci->database_interactions->get_district_rows();			
			$sql = "SELECT a.pejda_id,a.nama,b.nama_jabatan FROM pejabat_daerah as a 
					LEFT JOIN ref_jabatan_pejabat_daerah as b ON (a.japeda_id=b.ref_japeda_id)";

			$official_rows = $this->dao->execute(0,$sql)->result_array();

			
			$main_data = array('bundle_row'=>$this->bundle_row,							   
							   'district_rows'=>$district_rows,
							   'official_rows'=>$official_rows,
							   );
	
			// no need to modified
			$data = array('menu_params'=>$this->menu_params,
						  'main_params'=>array_merge($this->main_params,$main_data));

			$this->_ci->public_template->render($this->view_folder.'/index',$data);
		}

		function report_controller(){			

			$menu = $_POST['menu'];			
			$report_type = $_POST['report_type'];

			$src_params = $this->collect_input_params($_POST,'src',false);
			$printAttr_params = $this->collect_input_params($_POST,'printAttr',false);

			$urlstring_params = $this->generate_urlstring_params(array_merge($src_params,$printAttr_params));
			$method = "";

			switch ($report_type) {
				case '1':$method = "print";break;
				case '2':$method = "pdf";break;
				case '3':$method = "excel";break;
			}

			$this->menu = $menu;

			echo "<script type='text/javascript'>

				window.open('".base_url()."bundle/".$this->bundle_type."/".$this->bundle_item_type."/".$menu."/".$method.$urlstring_params."');

			</script>";
		}

		function print(){

			$this->show_report(1);
			
		}

		function pdf(){
			
			$this->show_report(2);

		}

		function excel(){
			$this->show_report(3);
		}

		function show_report($report_type){			
			$src_params = $this->collect_input_params($_GET,'src');
			$printAttr_params = $this->collect_input_params($_GET,'printAttr');

			$legalitator_row = array();
			$evaluator_row = array();
						
			if(isset($printAttr_params['showSignature'])){
				$sql = "SELECT a.nama,a.nip,b.pangkat,c.nama_jabatan FROM pejabat_daerah as a 
						LEFT JOIN ref_gol_ruang as b ON (a.goru_id=b.ref_goru_id) 
						LEFT JOIN ref_jabatan_pejabat_daerah as c ON (a.japeda_id=c.ref_japeda_id)";

				if(isset($printAttr_params['legalitator'])){
					$cond = " WHERE pejda_id='".$printAttr_params['legalitator']."'";
					$_sql = $sql.$cond;				
					$legalitator_row = $this->dao->execute(0,$_sql)->row_array();
				}

				if(isset($printAttr_params['evaluator'])){
					$cond = " WHERE pejda_id='".$printAttr_params['evaluator']."'";
					$_sql = $sql.$cond;
					$evaluator_row = $this->dao->execute(0,$_sql)->row_array();				
				}
			}

			$rows = $this->get_rows($src_params);

			$system_params = $this->_ci->database_interactions->get_system_params();
			
			$tax_year = (isset($src_params['tahun_pajak'])?$src_params['tahun_pajak']:date('Y'));

			$data = array('rows'=>$rows,
						  'print_date'=>us_date_format($printAttr_params['print_date']),
						  'system_params'=>$system_params,
						  'tax_name'=>$this->bundle_row['nama_paret'],
						  'tax_year'=>$tax_year,
						  'legalitator_row'=>$legalitator_row,
						  'evaluator_row'=>$evaluator_row,
						  'show_signature'=>isset($printAttr_params['showSignature']),
						  );

			$view_folder = $this->bundle_type.'/'.__CLASS__;

			if($report_type==1){
				$view_folder .= '/print';
			}
			else if($report_type==2){
				$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', [215, 330],'orientation'=>'L']);
				$data['mpdf'] = $mpdf;
				$view_folder .= '/pdf';
			}else{
				$view_folder .='/excel';
			}
			
			$this->_ci->load->view($view_folder,$data);
		}
		

		function get_rows($src_params){

			$res = __CLASS__.'_resources';
			require_once APPPATH.'libraries'.DIRECTORY_SEPARATOR.'system_resources'.DIRECTORY_SEPARATOR.$res.'.php';			

			$tbl_name = $res::$_TBL_NAME;
			$pk = $res::$_PK;
			$sql=$res::$_SQL_LIST;

			$tax_year = (isset($src_params['tahun_pajak'])?$src_params['tahun_pajak']:date('Y'));
			$cond = " a.pajak_id='".$this->bundle_id."' AND a.tahun_pajak='".$tax_year."'";
						

			if(isset($src_params['tgl_proses']))
			{
				$cond .= " AND to_char(tgl_proses,'dd-mm-yyyy')='".$src_params['tgl_proses']."'";
			}

			$sql .=" WHERE ".$cond;			

			return $this->dao->execute(0,$sql)->result_array();
		}


	}

?>