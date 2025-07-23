<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class ref_ref_jenis_mblb_model extends CI_Model{

		private $ref_mblb_id,$nama;

		const pkey = "ref_mblb_id";
		const tbl_name = "ref_jenis_mblb";

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

		function get_ref_mblb_id() {
			return $this->ref_mblb_id;
		}

		function get_jenis_mblb() {
	        return $this->jenis_mblb;
	    }	    

	    

		
		function set_ref_mblb_id($data) {
			$this->ref_mblb_id=$data;
		}

		function set_jenis_mblb($data) {
	        $this->jenis_mblb=$data;
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