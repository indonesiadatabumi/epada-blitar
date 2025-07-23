<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class laporan_hasil_pemeriksaan_model extends CI_Model{

		private $lhp_id,$pajak_id,$kegus_id,$wp_wr_id,$wp_wr_detil_id,
				$npwprd,$rekening_id,$jenis_spt_id,$tahun_pajak,$nomor,
				$no_pemeriksaan,$tgl_pemeriksaan,$keterangan,$persen_tarif,$pajak,
				$kode_billing,$status_ketetapan,$status_bayar,$created_by,$created_time,
				$modified_by,$modified_time, $hasil_pemeriksaan, $kesimpulan;

		const pkey = "lhp_id";
		const tbl_name = "laporan_hasil_pemeriksaan";

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

		function get_lhp_id() {
			return $this->lhp_id;
		}

		function get_pajak_id() {
	        return $this->pajak_id;
	    }

	    function get_kegus_id() {
	        return $this->kegus_id;
	    }

	    function get_wp_wr_id() {
	        return $this->wp_wr_id;
	    }

	    function get_wp_wr_detil_id() {
	        return $this->wp_wr_detil_id;
	    }

	    function get_npwprd() {
	        return $this->npwprd;
	    }

	    function get_rekening_id() {
	        return $this->rekening_id;
	    }

	    function get_jenis_spt_id() {
	        return $this->jenis_spt_id;
	    }

	    function get_tahun_pajak() {
	        return $this->tahun_pajak;
	    }

	    function get_nomor() {
	        return $this->nomor;
	    }

	    function get_no_pemeriksaan() {
	        return $this->no_pemeriksaan;
	    }

	    function get_tgl_pemeriksaan() {
	        return $this->tgl_pemeriksaan;
	    }

	    function get_keterangan() {
	        return $this->keterangan;
	    }
	    
	    function get_persen_tarif() {
	        return $this->persen_tarif;
	    }

	    function get_pajak() {
	        return $this->pajak;
	    }

	    function get_kode_billing() {
	        return $this->kode_billing;
	    }

	    function get_status_ketetapan() {
	        return $this->status_ketetapan;
	    }

	    function get_status_bayar() {
	        return $this->status_bayar;
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
		
		function get_hasil_pemeriksaan() {
	        return $this->hasil_pemeriksaan;
	    }

		function get_kesimpulan() {
	        return $this->kesimpulan;
	    }



		
		function set_lhp_id($data) {
			$this->lhp_id=$data;
		}

		function set_pajak_id($data) {
	        $this->pajak_id=$data;
	    }

	    function set_kegus_id($data) {
	        $this->kegus_id=$data;
	    }

	    function set_wp_wr_id($data) {
	        $this->wp_wr_id=$data;
	    }

	    function set_wp_wr_detil_id($data) {
	        $this->wp_wr_detil_id=$data;
	    }

	    function set_npwprd($data) {
	        $this->npwprd=$data;
	    }

	    function set_rekening_id($data) {
	        $this->rekening_id=$data;
	    }

	    function set_jenis_spt_id($data) {
	        $this->jenis_spt_id=$data;
	    }

	    function set_nomor($data) {
	        $this->nomor=$data;
	    }

	    function set_tahun_pajak($data) {
	        $this->tahun_pajak=$data;
	    }

	    function set_no_pemeriksaan($data) {
	        $this->no_pemeriksaan=$data;
	    }

	    function set_tgl_pemeriksaan($data) {
	        $this->tgl_pemeriksaan=$data;
	    }

	    function set_keterangan($data) {
	        $this->keterangan=$data;
	    }
	    
	    function set_persen_tarif($data) {
	        $this->persen_tarif=$data;
	    }

	    function set_pajak($data) {
	        $this->pajak=$data;
	    }

	    function set_kode_billing($data) {
	        $this->kode_billing=$data;
	    }

	    function set_status_ketetapan($data) {
	        $this->status_ketetapan=$data;
	    }

	    function set_status_bayar($data) {
	        $this->status_bayar=$data;
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
		
		function set_hasil_pemeriksaan($data) {
	        $this->hasil_pemeriksaan=$data;
	    }

		function set_kesimpulan($data) {
	        $this->kesimpulan=$data;
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
