<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class ref_jenis_reklame_model extends CI_Model{

		private $ref_jenrek_id,$kode,$nama,$skor,$bobot;

		const pkey = "ref_jenrek_id";
		const tbl_name = "ref_jenis_reklame";

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

		function get_ref_jenrek_id() {
			return $this->ref_jenrek_id;
		}

		function get_kode() {
	        return $this->kode;
	    }

	    function get_nama() {
	        return $this->nama;
	    }

	    function get_skor() {
	        return $this->skor;
	    }

	    function get_bobot() {
	        return $this->bobot;
	    }

	    

		
		function set_ref_jenrek_id($data) {
			$this->ref_jenrek_id=$data;
		}

		function set_kode($data) {
	        $this->kode=$data;
	    }

	    function set_nama($data) {
	        $this->nama=$data;
	    }

	    function set_skor($data) {
	        $this->skor=$data;
	    }

	    function set_bobot($data) {
	        $this->bobot=$data;
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