<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class wp_wr_hiburan_model extends CI_Model{

		private $wp_wr_hiburan_id,$wp_wr_id,$wp_wr_detil_id,$jenis_hiburan,$jumlah_karcis;

		const pkey = "wp_wr_hiburan_id";
		const tbl_name = "wp_wr_hiburan";

		function get_pkey(){
			return self::pkey;
		}

		function get_tbl_name(){
			return self::tbl_name;
		}

		function __construct(array $init_properties=array()){

			if(count($init_properties)>0){
				foreach($init_properties as $key=>$val){
					$this->$key = $val;
				}
			}
		}

		function get_wp_wr_hiburan_id() {
			return $this->wp_wr_hiburan_id;
		}

		function get_wp_wr_id() {
	        return $this->wp_wr_id;
	    }

	    function get_wp_wr_detil_id() {
	        return $this->wp_wr_detil_id;
	    }

	    function get_jenis_hiburan() {
	        return $this->jenis_hiburan;
	    }

	    function get_jumlah_karcis() {
	        return $this->jumlah_karcis;
	    }

	    


	    

		function set_wp_wr_hiburan_id($data) {
			$this->wp_wr_hiburan_id=$data;
		}

		function set_wp_wr_id($data) {
	        $this->wp_wr_id=$data;
	    }

	    function set_wp_wr_detil_id($data) {
	        $this->wp_wr_detil_id=$data;
	    }

	    function set_jenis_hiburan($data) {
	        $this->jenis_hiburan=$data;
	    }

	    function set_jumlah_karcis($data) {
	        $this->jumlah_karcis=$data;
	    }

	    
	    function get_field_list(){
			return get_object_vars($this);
		}

		function get_property_collection(){
			$field_list = get_object_vars($this);

			$collections = array();
			foreach($field_list as $key=>$val){
				if($val!='')
					$collections[$key]=$val;
			}

			return $collections;
		}

		function get_all_data(){
			$query = $this->db->query("SELECT * FROM ".$this->get_tbl_name()." ORDER BY ".$this->get_pkey()." ASC");
			return $query->result_array();
		}
	}
?>