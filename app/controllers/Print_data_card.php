
<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	require_once APPPATH.'controllers'.DIRECTORY_SEPARATOR.'Item_bundle_parent.php';

	class print_data_card extends item_bundle_parent{


		function __construct($bundle_type,$bundle_item_type,$menu){

			//bundle_type => taxes,duties
			//bundle_item_type => hotel,restaurant,entertainment,etc
			//menu => record_taxpayer1,record_taxpayer2,etc			
			parent::__construct($bundle_type,$bundle_item_type,$menu,__CLASS__);

		}


		function index(){
			$this->_ci->admin_access_handler->check_access();			

			$district_rows = $this->_ci->database_interactions->get_district_rows();			
			
			$main_data = array('bundle_row'=>$this->bundle_row,
							   'district_rows'=>$district_rows);
	
			// no need to modified
			$data = array('menu_params'=>$this->menu_params,
						  'main_params'=>array_merge($this->main_params,$main_data));

			$this->_ci->public_template->render($this->view_folder.'/index',$data);
		}

		function report_controller(){



		}	


		function pdf(){

			$type = $_GET['type'];

			$rows = array();

			//$sql = "SELECT jenis, golongan,npwprd,no_reg,nama,alamat,kecamatan,tgl_pendaftaran FROM wp_wr";
			$sql = "SELECT jenis, golongan,npwprd,no_reg,nama,alamat_pemilik alamat,kecamatan_pemilik kecamatan,tgl_pendaftaran FROM wp_wr";


			if($type=='single'){
				$_sql = $sql." WHERE wp_wr_id='".$_GET['id']."'";
				$rows[] = $this->dao->execute(0,$_sql)->row_array();
			}else{
				$n_rows = $_POST['n_rows'];
				for($i=1;$i<=$n_rows;$i++){

					if(isset($_POST['input-choice'.$i])){
						$id = $_POST['input-id'.$i];
						$_sql = $sql." WHERE wp_wr_id='".$id."'";
						$rows[] = $this->dao->execute(0,$_sql)->row_array();
					}
				}
			}

			$system_params = $this->_ci->database_interactions->get_system_params();

			//$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'fomat'=>[210, 297]]);	
			$mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir().DIRECTORY_SEPARATOR.'mpdf']); 		

			$data = array('rows'=>$rows,'system_params'=>$system_params,'mpdf'=>$mpdf);

			$view_folder = $this->bundle_type.'/'.__CLASS__;
			
			$this->_ci->load->view($view_folder.'/pdf',$data);

		}

		
	}
