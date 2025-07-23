<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	require_once APPPATH.'controllers'.DIRECTORY_SEPARATOR.'Item_bundle_parent.php';

	class print_taxpayer_detail extends item_bundle_parent{


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

		function _print(){			

			$id = $_GET['id'];

			$sql = "SELECT a.*, b.golongan, (CASE b.golongan WHEN '1' THEN 'Perorangan' ELSE 'Badan Usaha' END) as nama_golongan, 
					b.nama_pemilik,b.alamat_pemilik,b.kelurahan_pemilik,b.kecamatan_pemilik,
					b.kabupaten_pemilik,b.kode_pos_pemilik,b.no_telepon_pemilik,b.kewarganegaraan, 
					b.jns_tb,b.no_tb,to_char(b.tgl_tb,'yyyy-mm-dd') as tgl_tb,b.no_kk,
					to_char(b.tgl_kk,'yyyy-mm-dd') as tgl_kk, 
					b.pekerjaan,b.nm_instansi,b.alamat_instansi,
					to_char(b.tgl_pendaftaran,'yyyy-mm-dd') as tgl_pendaftaran,b.no_reg,
					c.nama_kegus, d.nama_paret, e.gambar 
					FROM wp_wr_detil as a LEFT JOIN wp_wr as b ON (a.wp_wr_id=b.wp_wr_id) 
					LEFT JOIN ref_kegiatan_usaha as c ON (a.kegus_id=c.ref_kegus_id) 
					LEFT JOIN bundel_pajak_retribusi as d ON (a.pajak_id=d.bundel_id) 
					LEFT JOIN wp_wr_gambar as e ON (a.wp_wr_detil_id=e.wp_wr_detil_id) 
					WHERE a.wp_wr_detil_id='".$id."'";
						
			$row = $this->dao->execute(0,$sql)->row_array();

			$system_params = $this->_ci->database_interactions->get_system_params();

			$data = array('row'=>$row,'system_params'=>$system_params,'api_key'=>($system_params[9]=='-'?'':$system_params[9]),);

			$view_folder = $this->bundle_type.'/print_taxpayer_detail';
			
			$this->_ci->load->view($view_folder.'/print',$data);
		}

		
	}

?>