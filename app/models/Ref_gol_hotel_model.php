<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class ref_gol_hotel_model extends CI_Model{

		private $ref_kode,$ref_nama;

		const pkey = "ref_kode";
		const tbl_name = "ref_gol_hotel";

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

		function get_ref_kode() {
			return $this->ref_kode;
		}

		function get_ref_nama() {
	        return $this->ref_nama;
	    }	    

	    

		
		function set_ref_kode($data) {
			$this->ref_kode=$data;
		}

		function set_ref_nama($data) {
	        $this->ref_nama=$data;
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