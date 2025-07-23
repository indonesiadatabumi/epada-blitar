<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class wp_wr_air_tanah_model extends CI_Model{

		private $wp_wr_air_tanah_id,$wp_wr_id,$wp_wr_detil_id,$jenis_sat_id,$hrgab_id,
				$kompsda_id,$kompkom_id,$sumber_alternatif;

		const pkey = "wp_wr_air_tanah_id";
		const tbl_name = "wp_wr_air_tanah";

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

		function get_wp_wr_air_tanah_id() {
			return $this->wp_wr_air_tanah_id;
		}

		function get_wp_wr_id() {
	        return $this->wp_wr_id;
	    }

	    function get_wp_wr_detil_id() {
	        return $this->wp_wr_detil_id;
	    }

	    function get_jenis_sat_id() {
	        return $this->jenis_sat_id;
	    }

	    function get_hrgab_id() {
	        return $this->hrgab_id;
	    }

	    function get_kompsda_id() {
	        return $this->kompsda_id;
	    }

	    function get_kompkom_id() {
	        return $this->kompkom_id;
	    }

	    function get_sumber_alternatif() {
	        return $this->sumber_alternatif;
	    }


	    

		function set_wp_wr_air_tanah_id($data) {
			$this->wp_wr_air_tanah_id=$data;
		}

		function set_wp_wr_id($data) {
	        $this->wp_wr_id=$data;
	    }

	    function set_wp_wr_detil_id($data) {
	        $this->wp_wr_detil_id=$data;
	    }

	    function set_jenis_sat_id($data) {
	        $this->jenis_sat_id=$data;
	    }

	    function set_hrgab_id($data) {
	        $this->hrgab_id=$data;
	    }

	    function set_kompsda_id($data) {
	        $this->kompsda_id=$data;
	    }

	    function set_kompkom_id($data) {
	        $this->kompkom_id=$data;
	    }

	    function set_sumber_alternatif($data) {
	        $this->sumber_alternatif=$data;
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