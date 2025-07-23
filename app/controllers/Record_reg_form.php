<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	require_once APPPATH.'controllers'.DIRECTORY_SEPARATOR.'Item_bundle_parent.php';

	class record_reg_form extends item_bundle_parent{


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

		function form(){

			$this->_ci->admin_access_handler->check_access();

			$act = $_POST['act'];
			$menu = $_POST['menu'];
			$showed = $_POST['showed'];
			
			$res = $menu.'_resources';
			require_once APPPATH.'libraries'.DIRECTORY_SEPARATOR.'system_resources'.DIRECTORY_SEPARATOR.$res.'.php';

			$tbl_name = $res::$_TBL_NAME;
			$pk = $res::$_PK;

			$this->_ci->load->model(array($tbl_name.'_model'));

			$m = $this->_ci->{$tbl_name.'_model'};
			$id_value = ($act=='edit'?$_POST['id']:'');

			$curr_data = $this->dao->get_data_by_id($act,$m,$id_value);

			$main_form_id = "main-form-id";
			$view_folder = $this->bundle_type.'/'.$menu;

			$system_params = $this->_ci->database_interactions->get_system_params();
			$district_rows = $this->_ci->database_interactions->get_district_rows();
			$village_rows = array();

			if($act=='edit'){
				$village_rows = $this->_ci->database_interactions->get_village_rows($curr_data['kecamatan_id']);				
			}

			$sql = "SELECT * FROM ref_kegiatan_usaha WHERE pajak_id='".$this->bundle_id."'";
			$business_type_rows = $this->dao->execute(0,$sql)->result_array();

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
				   			 'id_value'=>$id_value,
				   			 'menu'=>$menu,
				   			 'main_form_id'=>$main_form_id,
				   			 'showed'=>$showed,
				   			 'src_params'=>$src_params,
				   			 'bundle_name'=>$this->bundle_row['nama_paret'],
				   			 'bundle_id'=>$this->bundle_id,
							 'district_rows'=>$district_rows,
							 'system_params'=>$system_params,
							 'village_rows'=>$village_rows,
							 'business_type_rows'=>$business_type_rows,
							 'src_params'=>$src_params
							 );

			$main_data = array_merge($this->main_params,$main_data);
			
			$data = array_merge($this->main_params,$main_data);			

			$this->_ci->load->view($view_folder.'/form',$data);
		}

		function submit_form(){

			$this->_ci->admin_access_handler->check_access();

			$act = $_POST['act'];
			$id_value = $_POST['id_value'];
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

				$this->_ci->load->model(array($tbl_name.'_model'));
				$m = $this->_ci->{$tbl_name.'_model'};
				
				$input_params = $this->collect_input_params($_POST,'input');

				$x_district = explode('_',$input_params['kecamatan']);
				$x_village = explode('_',$input_params['kelurahan']);
		
				$input_params['kecamatan_id'] = $x_district[0];
				$input_params['kelurahan_id'] = $x_village[0];
				$input_params['kecamatan'] = $x_district[1];
				$input_params['kelurahan'] = $x_village[1];
				

				if($act=='add'){
					$x_business = explode('_',$input_params['kegus_id']);

					$input_params['pajak_id'] = $this->bundle_id;
					$input_params['kegus_id'] = $x_business[0];
					$input_params['no_form'] = $this->_ci->database_interactions->generate_regform_number();
					$input_params['wp_wr_form_id'] = $this->_ci->global_model->get_incrementID('wp_wr_form_id','wp_wr_formulir');
				}
				
				$this->delegate_postTomodel($input_params,$m);

				if($act=='add'){					
					$result = $this->dao->insert($m);
					$label = "menyimpan";
				}else{
					$result = $this->dao->update($m,array('wp_wr_form_id'=>$id_value));
					$label = "merubah";
				}
				
				if(!$result){
					die('ERROR: gagal '.$label.' data');
				}

				//return response
				if($showed!='0'){

					$cond_params = array_merge(array('b.pajak_id'=>$this->bundle_id),$this->collect_cond_params($_POST,'src'));
					$this->print_list_data($menu,$cond_params);

				}
			}else{
				$this->_ci->load->view('errors/html/error_403',array('type'=>$act));
			}
		}

		function delete_record(){
			$id = $_POST['id'];
			$act = $_POST['act'];
			$menu = $_POST['menu'];

			$access = $this->_ci->public_template->get_access_privileges('delete',$menu,$this->bundle_id);

			if($access=='1'){
				
				$res = $menu.'_resources';
				require_once APPPATH.'libraries'.DIRECTORY_SEPARATOR.'system_resources'.DIRECTORY_SEPARATOR.$res.'.php';

				$tbl_name = $res::$_TBL_NAME;
				$pk = $res::$_PK;

				$this->_ci->load->model(array($tbl_name.'_model'));

				$m = $this->_ci->{$tbl_name.'_model'};
								
				$cond_params = array($pk=>$id);

				$result = $this->dao->delete($m,$cond_params);
				if(!$result){					
					die('ERROR: gagal menghapus data');
				}

				$cond_params = array_merge(array('b.pajak_id'=>$this->bundle_id),$this->collect_cond_params($_POST,'src_params'));				
				
				$this->print_list_data($menu,$cond_params);

			}else{
				$this->_ci->load->view('errors/html/error_403',array('type'=>$act));
			}
		}

	}

?>