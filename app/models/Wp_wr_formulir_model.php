<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class wp_wr_formulir_model extends CI_Model{

		private $wp_wr_form_id,$no_form,$nama,$alamat,$kelurahan_id,
				$kecamatan_id,$kelurahan,$kecamatan,$kabupaten,$tgl_kirim,
				$tgl_kembali,$created_by,$created_time,$modified_by,$modified_time,
				$status,$pajak_id,$kegus_id;

		const pkey = "wp_wr_form_id";
		const tbl_name = "wp_wr_formulir";

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

		function get_wp_wr_form_id() {
			return $this->wp_wr_form_id;
		}

		function get_no_form() {
	        return $this->no_form;
	    }

	    function get_nama() {
	        return $this->nama;
	    }

	    function get_alamat() {
	        return $this->alamat;
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

	    function get_tgl_kirim() {
	        return $this->tgl_kirim;
	    }

	    function get_tgl_kembali() {
	        return $this->tgl_kembali;
	    }

	    function get_created_by() {
	        return $this->created_by;
	    }

	    function get_created_time() {
	        return $this->created_time;
	    }

	    function get_modified_by() {
	        return $this->modified_by;
	    }

	    function get_modified_time() {
	        return $this->modified_time;
	    }

	    function get_status() {
	        return $this->status;
	    }

	    function get_pajak_id() {
	        return $this->pajak_id;
	    }

	    function get_kegus_id() {
	        return $this->kegus_id;
	    }



	    

		function set_wp_wr_form_id($data) {
			$this->wp_wr_form_id=$data;
		}

		function set_no_form($data) {
	        $this->no_form=$data;
	    }

	    function set_nama($data) {
	        $this->nama=$data;
	    }

	    function set_alamat($data) {
	        $this->alamat=$data;
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

	    function set_tgl_kirim($data) {
	        $this->tgl_kirim=$data;
	    }

	    function set_tgl_kembali($data) {
	        $this->tgl_kembali=$data;
	    }

	    function set_created_by($data) {
	        $this->created_by=$data;
	    }

	    function set_created_time($data) {
	        $this->created_time=$data;
	    }

	    function set_modified_by($data) {
	        $this->modified_by=$data;
	    }

	    function set_modified_time($data) {
	        $this->modified_time=$data;
	    }

	    function set_status($data) {
	        $this->status=$data;
	    }

	    function set_pajak_id($data) {
	        $this->pajak_id=$data;
	    }

	    function set_kegus_id($data) {
	        $this->kegus_id=$data;
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