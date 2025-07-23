<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class ref_kegiatan_usaha_model extends CI_Model{

		private $ref_kegus_id,$pajak_id,$nama_kegus,$kode_kegus,$persen_tarif,
				$tarif_dasar,$volume_dasar,$tarif_tambahan,$kategori,$term_bayar,
				$status;

		const pkey = "ref_kegus_id";
		const tbl_name = "ref_kegiatan_usaha";

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

		function get_ref_kegus_id() {
			return $this->ref_kegus_id;
		}

		function get_pajak_id() {
	        return $this->pajak_id;
	    }

	    function get_nama_kegus() {
	        return $this->nama_kegus;
	    }

	    function get_kode_kegus() {
	        return $this->kode_kegus;
	    }

	    function get_persen_tarif() {
	        return $this->persen_tarif;
	    }

	    function get_tarif_dasar() {
	        return $this->tarif_dasar;
	    }

	    function get_volume_dasar() {
	        return $this->volume_dasar;
	    }

	    function get_tarif_tambahan() {
	        return $this->tarif_tambahan;
	    }

	    function get_kategori() {
	        return $this->kategori;
	    }

	    function get_term_bayar() {
	        return $this->term_bayar;
	    }

	    function get_status() {
	        return $this->status;
	    }

	    

		
		function set_ref_kegus_id($data) {
			$this->ref_kegus_id=$data;
		}

		function set_pajak_id($data) {
	        $this->pajak_id=$data;
	    }

	    function set_nama_kegus($data) {
	        $this->nama_kegus=$data;
	    }

	    function set_kode_kegus($data) {
	        $this->kode_kegus=$data;
	    }

	    function set_persen_tarif($data) {
	        $this->persen_tarif=$data;
	    }

	    function set_tarif_dasar($data) {
	        $this->tarif_dasar=$data;
	    }

	    function set_volume_dasar($data) {
	        $this->volume_dasar=$data;
	    }

	    function set_tarif_tambahan($data) {
	        $this->tarif_tambahan=$data;
	    }

	    function set_kategori($data) {
	        $this->kategori=$data;
	    }

	    function set_term_bayar($data) {
	        $this->term_bayar=$data;
	    }

	    function set_status($data) {
	        $this->status=$data;
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