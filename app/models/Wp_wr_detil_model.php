<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class wp_wr_detil_model extends CI_Model{

		private $wp_wr_detil_id,$wp_wr_id,$pajak_id,$kegus_id,$nama,
				$alamat,$kelurahan_id,$kecamatan_id,$kelurahan,$kecamatan,
				$kabupaten,$kode_pos,$no_telepon,$tgl_pendaftaran,$tgl_terima_form,
				$tgl_bts_kirim,$tgl_form_kembali,$tgl_tutup,$tgl_buka,$utama,
				$created_by,$created_time,$modified_by,$modified_time,$latitude,
				$longitude,$status;

		const pkey = "wp_wr_detil_id";
		const tbl_name = "wp_wr_detil";

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

		function get_wp_wr_detil_id(){
			return $this->wp_wr_detil_id;
		}

		function get_wp_wr_id() {
	        return $this->wp_wr_id;
	    }

		function get_pajak_id() {
	        return $this->pajak_id;
	    }

	    function get_kegus_id() {
	        return $this->kegus_id;
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

	    function get_kode_pos() {
	        return $this->kode_pos;
	    }

	    function get_no_telepon() {
	        return $this->no_telepon;
	    }

	    function get_tgl_pendaftaran() {
	        return $this->tgl_pendaftaran;
	    }

	    function get_tgl_terima_form(){
	    	return $this->tgl_terima_form;
	    }

	    function get_tgl_bts_kirim() {
	        return $this->tgl_bts_kirim;
	    }

	    function get_tgl_form_kembali() {
	        return $this->tgl_form_kembali;
	    }

	    function get_tgl_tutup() {
	        return $this->tgl_tutup;
	    }

	    function get_tgl_buka() {
	        return $this->tgl_buka;
	    }

	    function get_utama() {
	        return $this->utama;
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

	    function get_latitude() {
	        return $this->latitude;
	    }

	    function get_longitude() {
	        return $this->longitude;
	    }

	    function get_status() {
	        return $this->status;
	    }

		

		
		function set_wp_wr_detil_id($data) {
			$this->wp_wr_detil_id=$data;
		}

		function set_wp_wr_id($data) {
	        $this->wp_wr_id=$data;
	    }

		function set_pajak_id($data) {
	        $this->pajak_id=$data;
	    }

	    function set_kegus_id($data) {
	        $this->kegus_id=$data;
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

	    function set_kode_pos($data) {
	        $this->kode_pos=$data;
	    }

	    function set_no_telepon($data) {
	        $this->no_telepon=$data;
	    }

	    function set_tgl_pendaftaran($data) {
	        $this->tgl_pendaftaran=$data;
	    }

	    function set_tgl_terima_form($data){
	    	$this->tgl_terima_form=$data;
	    }

	    function set_tgl_bts_kirim($data) {
	        $this->tgl_bts_kirim=$data;
	    }

	    function set_tgl_form_kembali($data) {
	        $this->tgl_form_kembali=$data;
	    }

	    function set_tgl_tutup($data) {
	        $this->tgl_tutup=$data;
	    }

	    function set_tgl_buka($data) {
	        $this->tgl_buka=$data;
	    }

	    function set_utama($data) {
	        $this->utama=$data;
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

	    function set_latitude($data) {
	        $this->latitude=$data;
	    }

	    function set_longitude($data) {
	        $this->longitude=$data;
	    }

	    function set_status($data) {
	        $this->status=$data;
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