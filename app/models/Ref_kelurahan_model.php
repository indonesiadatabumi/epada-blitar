<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class ref_kelurahan_model extends CI_Model{

		private $kecamatan_id,$kecamatan_id,$nama_kelurahan,$kode_kelurahan;

		const pkey = "kelurahan_id";
		const tbl_name = "ref_kelurahan";

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

		function get_kelurahan_id() {
			return $this->kelurahan_id;
		}

		function get_kecamatan_id() {
	        return $this->kecamatan_id;
	    }

	    function get_nama_kelurahan() {
	        return $this->nama_kelurahan;
	    }

	    function get_kode_kelurahan() {
	        return $this->kode_kelurahan;
	    }

	    

		
		function set_kelurahan_id($data) {
			$this->kelurahan_id=$data;
		}

		function set_kecamatan_id($data) {
	        $this->kecamatan_id=$data;
	    }

	    function set_nama_kelurahan($data) {
	        $this->nama_kelurahan=$data;
	    }

	    function set_kode_kelurahan($data) {
	        $this->kode_kelurahan=$data;
	    }


	    function set_field_list(){
			get_object_vars($this)=$data;
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