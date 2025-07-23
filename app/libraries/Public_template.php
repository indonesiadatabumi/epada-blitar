<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	Class public_template{

		private $_ci,$dao;

		function __construct(){
			$this->_ci =& get_instance();
			$this->_ci->load->library(array('admin_access_handler'));
		}

		function initialize_dao($dao){
			$this->dao = $dao;
		}

		function render($view,$data = null){			

			$this->_ci->load->model('global_model');
			$this->_ci->load->library(array('admin_access_handler','menu_generator'));

			$this->_ci->admin_access_handler->initialize_dao($this->dao);
			$this->_ci->menu_generator->initialize_dao($this->dao);
			
			$_SYS_PARAMS = $this->_ci->global_model->get_system_params();
			$main_params = $data['main_params'];
			$_data = $main_params;

			if(isset($data['menu_params'])){
				$menu_params = $data['menu_params'];
				$this->_ci->menu_generator->prepare_data($menu_params['bundle_type'],$menu_params['bundle_item_type'],$menu_params['bundle_id']);
				$parsed_tree = $this->_ci->menu_generator->get_parsed_tree();

				$_data['menu_generator'] = $this->_ci->menu_generator;
				$_data['parsed_tree'] = $parsed_tree;

				$_data['banner_info'] = $this->_ci->load->view('global/banner_info',$_data,true);
				$_data['navbar'] = $this->_ci->load->view('global/navbar',$_data,true);

				$url = 'bundle/{bundle}/'.$main_params['menu'];				
				$aah = $this->_ci->admin_access_handler;
				$menu_id = $aah->get_menu_id($menu_params['bundle_id'],$url);				

				$_data['read_priv'] = $aah->check_privilege('read',$menu_id);
				$_data['add_priv'] = $aah->check_privilege('add',$menu_id);
				$_data['update_priv'] = $aah->check_privilege('update',$menu_id);
				$_data['delete_priv'] = $aah->check_privilege('delete',$menu_id);
				$_data['print_priv'] = $aah->check_privilege('print',$menu_id);
				
			}
			
			
			$_data['header_content'] = $this->_ci->load->view('template/header_content',$_data,true);
			$_data['navigation_content'] = $this->_ci->load->view('template/navigation_content',$_data,true);
			$_data['footer_content'] = $this->_ci->load->view('template/footer_content',$_data,true);


			$_data['main_content'] = $this->_ci->load->view($view,$_data,true);

			$this->_ci->load->view('template',$_data);
			
		}

		function get_access_privileges($access,$menu,$bundle_id){
			
			$this->_ci->admin_access_handler->initialize_dao($this->dao);
			$url = 'bundle/{bundle}/'.$menu;

			$aah = $this->_ci->admin_access_handler;
			$menu_id = $aah->get_menu_id($bundle_id,$url);
						

			return $this->_ci->admin_access_handler->check_privilege($access,$menu_id);
		}
	}
?>