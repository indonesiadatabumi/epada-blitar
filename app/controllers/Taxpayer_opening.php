<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	require_once APPPATH.'controllers'.DIRECTORY_SEPARATOR.'Item_bundle_parent.php';

	class taxpayer_opening extends item_bundle_parent{


		function __construct($bundle_type,$bundle_item_type,$menu){

			//bundle_type => taxes,duties
			//bundle_item_type => hotel,restaurant,entertainment,etc
			//menu => record_taxpayer1,record_taxpayer2,etc			
			parent::__construct($bundle_type,$bundle_item_type,$menu,__CLASS__);
			$this->subject_type = '1';
		}


		function index(){
			$this->_ci->admin_access_handler->check_access();			

			$district_rows = $this->_ci->database_interactions->get_district_rows();			

			$main_data = array('bundle_row'=>$this->bundle_row,							   
							   'district_rows'=>$district_rows,
							   'subject_type'=>$this->subject_type);
	
			// no need to modified
			$data = array('menu_params'=>$this->menu_params,
						  'main_params'=>array_merge($this->main_params,$main_data));

			$this->_ci->public_template->render($this->view_folder.'/index',$data);
		}

		function load_taxpayer_list(){

			$key = $_POST['src_form-key'];
			$menu = $_POST['menu'];
			$act = $_POST['act'];
			$showed = $_POST['showed'];

			$sql = "SELECT a.wp_wr_detil_id,b.npwprd,c.nama_paret,d.nama_kegus,a.nama,a.alamat,a.kelurahan,a.kecamatan 
					FROM wp_wr_detil as a 
					LEFT JOIN wp_wr as b ON (a.wp_wr_id=b.wp_wr_id) 
					LEFT JOIN bundel_pajak_retribusi as c ON (a.pajak_id=c.bundel_id) 
					LEFT JOIN ref_kegiatan_usaha as d ON (a.kegus_id=d.ref_kegus_id) 
					WHERE a.pajak_id='".$this->bundle_id."' AND a.status=FALSE AND (b.npwprd LIKE '%".$key."%' OR a.nama LIKE '%".$key."%')";
			
			$rows = $this->dao->execute(0,$sql)->result_array();

			$src_params = array();
			foreach($_POST as $key=>$val){
				$x = explode('-',$key);				
				if($x[0]=='src' and $val!=''){					
					$field = $x[1];
					$src_params[$field]=$val;
				}
			}

			$data = array('rows'=>$rows,'act'=>$act,'menu'=>$menu,'showed'=>$showed,'src_params'=>$src_params);

			$view_folder = $this->bundle_type.'/'.$menu;

			$this->_ci->load->view($view_folder.'/taxpayer_list',$data);

		}


		function taxpayer_search_panel(){
			$this->_ci->admin_access_handler->check_access();

			$act = $_POST['act'];
			$menu = $_POST['menu'];
			$showed = $_POST['showed'];			

			$src_params = array();
			foreach($_POST as $key=>$val){
				$x = explode('-',$key);				
				if($x[0]=='src' and $val!=''){					
					$field = $x[1];
					$src_params[$field]=$val;
				}
			}

			$view_folder = $this->bundle_type.'/'.$menu;

			$data = array(
							 'act'=>$act,
				   			 'menu'=>$menu,
				   			 'showed'=>$showed,
				   			 'src_params'=>$src_params,
				   			 'bundle_name'=>$this->bundle_row['nama_paret'],
				   			 'bundle_item_type'=>$this->bundle_item_type,
				   			 'bundle_id'=>$this->bundle_id,
							 );

			$this->_ci->load->view($view_folder.'/taxpayer_search_panel',$data);
		}

		function form(){

			$this->_ci->admin_access_handler->check_access();

			$act = $_POST['act'];
			$menu = $_POST['menu'];
			$showed = $_POST['showed'];
			$wp_wr_detil_id = $_POST['wp_wr_detil_id'];

			$res = $menu.'_resources';
			require_once APPPATH.'libraries'.DIRECTORY_SEPARATOR.'system_resources'.DIRECTORY_SEPARATOR.$res.'.php';

			$tbl_name = $res::$_TBL_NAME;
			$pk = $res::$_PK;

			$this->_ci->load->model(array($tbl_name.'_model'));

			$m = $this->_ci->{$tbl_name.'_model'};
			$id_value = ($act=='edit'?$_POST['id']:'');

			$curr_data = $this->dao->get_data_by_id($act,$m,$id_value);

			$sql = "SELECT a.nama,a.alamat,a.kecamatan,a.kelurahan,b.npwprd,c.nama_paret,d.nama_kegus FROM wp_wr_detil as a 
					LEFT JOIN wp_wr as b ON (a.wp_wr_id=b.wp_wr_id) 
					LEFT JOIN bundel_pajak_retribusi as c ON (a.pajak_id=c.bundel_id) 
					LEFT JOIN ref_kegiatan_usaha as d ON (a.kegus_id=d.ref_kegus_id) 
					WHERE wp_wr_detil_id='".$wp_wr_detil_id."'";

			$taxpayer_detail_row = $this->dao->execute(0,$sql)->row_array();

			$main_form_id = "main-form-id";
			$view_folder = $this->bundle_type.'/'.$menu;			

			$src_params = array();
			foreach($_POST as $key=>$val){
				$x = explode('-',$key);
				if($x[0]=='src' and $val!=''){					
					$field = $x[1];
					$src_params[$field]=$val;
				}
			}

			$main_data = array(
							 'act'=>$act,
							 'curr_data'=>$curr_data,
							 'taxpayer_detail_row'=>$taxpayer_detail_row,
				   			 'id_value'=>$id_value,
				   			 'wp_wr_detil_id'=>$wp_wr_detil_id,
				   			 'menu'=>$menu,
				   			 'main_form_id'=>$main_form_id,
				   			 'showed'=>$showed,
				   			 'src_params'=>$src_params,
				   			 'bundle_name'=>$this->bundle_row['nama_paret'],
				   			 'bundle_id'=>$this->bundle_id,							 
							 );

			$main_data = array_merge($this->main_params,$main_data);
			
			$data = array_merge($this->main_params,$main_data);			

			$this->_ci->load->view($view_folder.'/form',$data);
		}

		function submit_form(){

			$this->_ci->admin_access_handler->check_access();

			$act = $_POST['act'];
			$id_value = $_POST['id_value'];
			$wp_wr_detil_id = $_POST['wp_wr_detil_id'];
			$menu = $_POST['menu'];
			$showed = $_POST['showed'];

			if($act=='add'){
				$access = $this->_ci->public_template->get_access_privileges('add',$menu,$this->bundle_id);
			}else{
				$access = $this->_ci->public_template->get_access_privileges('update',$menu,$this->bundle_id);
			}

			if($access=='1'){
				
				$res = $menu.'_resources';
				require_once APPPATH.'libraries'.DIRECTORY_SEPARATOR.'system_resources'.DIRECTORY_SEPARATOR.$res.'.php';
				$tbl_name = $res::$_TBL_NAME;
				$pk = $res::$_PK;


				$this->_ci->load->model(array($tbl_name.'_model','wp_wr_detil_model'));
				$m1 = $this->_ci->{$tbl_name.'_model'};
				$m2 = $this->_ci->wp_wr_detil_model;
				
				$input_params = $this->collect_input_params($_POST,'input');
								
				if($act=='add'){					
					$input_params['wp_wr_detil_id'] = $wp_wr_detil_id;
					$input_params[$pk] = $this->_ci->global_model->get_incrementID($pk,$tbl_name);
				}
				
				$this->delegate_postTomodel($input_params,$m1);

				$this->_ci->db->trans_begin();


				if($act=='add'){
					$result = $this->dao->insert($m1);
					$label = "menyimpan";
				}else{
					$result = $this->dao->update($m1,array($pk=>$id_value));
					$label = "merubah";
				}
				
				if(!$result){
					$this->_ci->db->trans_rollback();
					die('ERROR: gagal '.$label.' data');
				}

				$input_params2 = array('status'=>'TRUE','tgl_buka'=>$input_params['tgl_buka']);
				$this->delegate_postTomodel($input_params2,$m2);
				$result = $this->dao->update($m2,array('wp_wr_detil_id'=>$wp_wr_detil_id));
				if(!$result){
					$this->_ci->db->trans_rollback();
					die('ERROR: gagal '.$label.' data');
				}


				$taxpayer_detail_row = $this->dao->execute(0,"SELECT wp_wr_id,utama FROM wp_wr_detil WHERE wp_wr_detil_id='".$wp_wr_detil_id."'")->row_array();

				if($taxpayer_detail_row['utama']=='TRUE'){
					$this->_ci->load->model('wp_wr_model');
					$m3 = $this->_ci->wp_wr_model;
					$input_params3 = array('status'=>'TRUE');
					$this->delegate_postTomodel($input_params3,$m3);

					$result = $this->dao->update($m3,array('wp_wr_id'=>$taxpayer_detail_row['wp_wr_id']));
					if(!$result){
						$this->_ci->db->trans_rollback();
						die('ERROR: gagal '.$label.' data');
					}
				}

				$this->_ci->db->trans_commit();

				//return response
				if($showed!='0'){
					$cond_params = array_merge(array('b.pajak_id'=>$this->bundle_id),
													$this->collect_cond_params($_POST,'src'));

					$this->print_list_data($menu,$cond_params);
				}
			}else{
				$this->_ci->load->view('errors/html/error_403',array('type'=>$act));
			}
		}

		function delete_record(){
			$id = $_POST['id'];
			$wp_wr_detil_id = $_POST['wp_wr_detil_id'];
			$act = $_POST['act'];
			$menu = $_POST['menu'];

			$access = $this->_ci->public_template->get_access_privileges('delete',$menu,$this->bundle_id);

			if($access=='1'){
				
				$res = $menu.'_resources';
				require_once APPPATH.'libraries'.DIRECTORY_SEPARATOR.'system_resources'.DIRECTORY_SEPARATOR.$res.'.php';

				$tbl_name = $res::$_TBL_NAME;
				$pk = $res::$_PK;

				$this->_ci->load->model(array($tbl_name.'_model','wp_wr_detil_model'));
				$m1 = $this->_ci->{$tbl_name.'_model'};
				$m2 = $this->_ci->wp_wr_detil_model;

				$this->_ci->db->trans_begin();

				$cond_params = array($pk=>$id);
				$result = $this->dao->delete($m1,$cond_params);
				if(!$result){
					$this->_ci->db->trans_rollback();
					die('ERROR: gagal menghapus data');
				}

				$input_params = array('status'=>'FALSE','tgl_buka'=>'');
				$this->delegate_postTomodel($input_params,$m2);
				$result = $this->dao->update($m2,array('wp_wr_detil_id'=>$wp_wr_detil_id));
				if(!$result){
					$this->_ci->db->trans_rollback();
					die('ERROR: gagal menghapus data');
				}

				$taxpayer_detail_row = $this->dao->execute(0,"SELECT wp_wr_id,utama FROM wp_wr_detil WHERE wp_wr_detil_id='".$wp_wr_detil_id."'")->row_array();
				if($taxpayer_detail_row['utama']=='TRUE'){
					$this->_ci->load->model('wp_wr_model');
					$m3 = $this->_ci->wp_wr_model;
					$input_params2 = array('status'=>'FALSE');
					$this->delegate_postTomodel($input_params2,$m3);

					$result = $this->dao->update($m3,array('wp_wr_id'=>$taxpayer_detail_row['wp_wr_id']));
					if(!$result){
						$this->_ci->db->trans_rollback();
						die('ERROR: gagal '.$label.' data');
					}
				}

				$this->_ci->db->trans_commit();

				$cond_params = array_merge(array('b.pajak_id'=>$this->bundle_id),
													$this->collect_cond_params($_POST,'src'));
				
				$this->print_list_data($menu,$cond_params);

			}else{
				$this->_ci->load->view('errors/html/error_403',array('type'=>$act));
			}
		}

	}

?>