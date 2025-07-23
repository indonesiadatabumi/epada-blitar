<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class ref_uptd_model extends CI_Model{

		private $ref_uptd_id,$nama,$uptd_alamat;

		const pkey = "ref_uptd_id";
		const tbl_name = "ref_uptd";

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

		function get_ref_uptd_id() {
			return $this->ref_uptd_id;
		}

		function get_nama() {
	        return $this->nama;
	    }

	    function get_uptd_alamat() {
	        return $this->uptd_alamat;
	    }

	    

		
		function set_ref_uptd_id($data) {
			$this->ref_uptd_id=$data;
		}

		function set_nama($data) {
	        $this->nama=$data;
	    }

	    function set_uptd_alamat($data) {
	        $this->uptd_alamat=$data;
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