<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class ref_kecamatan_model extends CI_Model{

		private $kecamatan_id,$dt2_id,$nama_kecamatan,$kode_kecamatan;

		const pkey = "kecamatan_id";
		const tbl_name = "ref_kecamatan";

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

		function get_kecamatan_id() {
			return $this->kecamatan_id;
		}

		function get_dt2_id() {
	        return $this->dt2_id;
	    }

	    function get_nama_kecamatan() {
	        return $this->nama_kecamatan;
	    }

	    function get_kode_kecamatan() {
	        return $this->kode_kecamatan;
	    }

	    

		
		function set_kecamatan_id($data) {
			$this->kecamatan_id=$data;
		}

		function set_dt2_id($data) {
	        $this->dt2_id=$data;
	    }

	    function set_nama_kecamatan($data) {
	        $this->nama_kecamatan=$data;
	    }

	    function set_kode_kecamatan($data) {
	        $this->kode_kecamatan=$data;
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