<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class database_manipulation extends CI_Controller{

		function __construct(){
			parent::__construct();
		}

		function index(){
			echo "there is no any activity here";
		}

		function reset_spt(){
			$this->load->library('DAO');
			$this->load->model(array('global_model'));
			$dao = $this->global_model->get_dao();

			$sql = "TRUNCATE table transaksi_pajak";
			$result = $dao->execute(0,$sql);

			$sql = "TRUNCATE table transaksi_pajak_detil";
			$result = $dao->execute(0,$sql);

			$sql = "UPDATE spt SET status_bayar='0' WHERE status_bayar='1'";
			$result = $dao->execute(0,$sql);

			if($result && $result){
				echo 'success';
			}else{
				echo 'failed';
			}
		}

		function fill_menu_bundle(){
			$this->load->library('DAO');
			$this->load->model(array('global_model'));
			$dao = $this->global_model->get_dao();

			$sql = "SELECT * FROM menu_navigations ORDER BY sequence_number ASC";
			$rows1 = $dao->execute(0,$sql)->result_array();

			$sql = "SELECT * FROM bundel_pajak_retribusi WHERE bundel_id<>8 and bundel_id<>9 ORDER BY bundel_id ASC";
			$rows2 = $dao->execute(0,$sql)->result_array();
			
			foreach($rows1 as $row1){

				foreach($rows2 as $row2){

					$id = $this->global_model->get_incrementID('menu_bundle_id','menu_bundles');
					$sql = "INSERT INTO menu_bundles VALUES('".$id."','".$row1['menu_id']."','".$row2['bundel_id']."','TRUE')";
					echo $sql."<br />";
					$result = $dao->execute(0,$sql);
				}
			}
		}

		function fill_user_privileges(){
			$this->load->library('DAO');
			$this->load->model(array('global_model'));
			$dao = $this->global_model->get_dao();

			$sql = "SELECT * FROM menu_bundles";
			$rows1 = $dao->execute(0,$sql)->result_array();			
			
			foreach($rows1 as $row1){
				$id = $this->global_model->get_incrementID('privilege_id','user_privileges');
				$sql = "INSERT INTO user_privileges VALUES('".$id."','1','".$row1['menu_bundle_id']."','1','1','1','1','1','".$row1['bundle_id']."')";
				echo $sql."<br />";
				$result = $dao->execute(0,$sql);				
			}
		}


	}
?>