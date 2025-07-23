<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class wp_wr_reklame_model extends CI_Model{

		private $wp_wr_reklame_id,$npwpd,$nama,
				$alamat,$no_telepon,$kelurahan_id,$kecamatan_id,$kelurahan,
				$kecamatan,$kabupaten;

		const pkey = "wp_wr_reklame_id";
		const tbl_name = "wp_wr_reklame";

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

		function get_wp_wr_reklame_id() {
			return $this->wp_wr_reklame_id;
		}		

	    function get_npwpd() {
	        return $this->npwpd;
	    }

	    function get_nama() {
	        return $this->nama;
	    }

	    function get_alamat() {
	        return $this->alamat;
	    }

	    function get_no_telepon() {
	        return $this->no_telepon;
	    }

	    function get_kelurahan_id() {
	        return $this->kelurahan_id;
	    }

	    function get_kecamatan_id() {
	        return $this->kecamatan_id;
	    }

	    function get_kelurahan() {
	        return $this->kelurahan;
	    }

	    function get_kecamatan() {
	        return $this->kecamatan;
	    }

	    function get_kabupaten() {
	        return $this->kabupaten;
	    }

	    

		function set_wp_wr_reklame_id($data) {
			$this->wp_wr_reklame_id=$data;
		}
		
	    function set_npwpd($data) {
	        $this->npwpd=$data;
	    }

	    function set_nama($data) {
	        $this->nama=$data;
	    }

	    function set_alamat($data) {
	        $this->alamat=$data;
	    }

	    function set_no_telepon($data) {
	        $this->no_telepon=$data;
	    }

	    function set_kelurahan_id($data) {
	        $this->kelurahan_id=$data;
	    }

	    function set_kecamatan_id($data) {
	        $this->kecamatan_id=$data;
	    }

	    function set_kelurahan($data) {
	        $this->kelurahan=$data;
	    }

	    function set_kecamatan($data) {
	        $this->kecamatan=$data;
	    }

	    function set_kabupaten($data) {
	        $this->kabupaten=$data;
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