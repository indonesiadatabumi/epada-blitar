<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class ref_jenis_pemungutan_model extends CI_Model{

		private $ref_jenput_id,$jenis_pemungutan;

		const pkey = "ref_jenput_id";
		const tbl_name = "ref_jenis_pemungutan";

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

		function get_ref_jenput_id() {
			return $this->ref_jenput_id;
		}

		function get_jenis_pemungutan() {
	        return $this->jenis_pemungutan;
	    }	    

	    

		
		function set_ref_jenput_id($data) {
			$this->ref_jenput_id=$data;
		}

		function set_jenis_pemungutan($data) {
	        $this->jenis_pemungutan=$data;
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