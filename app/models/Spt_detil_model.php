<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class spt_detil_model extends CI_Model{

		private $spt_detil_id,$spt_id,$kegus_id,$volume,$nilai_terkena_pajak,
				$tarif_dasar,$persen_tarif,$pajak,$lokasi,$diskon,
				$denda,$bunga;

		const pkey = "spt_detil_id";
		const tbl_name = "spt_detil";

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

		function get_spt_detil_id(){
			return $this->spt_detil_id;
		}

		function get_spt_id() {
	        return $this->spt_id;
	    }

		function get_kegus_id() {
	        return $this->kegus_id;
	    }

	    function get_volume() {
	        return $this->volume;
	    }

	    function get_nilai_terkena_pajak() {
	        return $this->nilai_terkena_pajak;
	    }	    

	    function get_tarif_dasar() {
	        return $this->tarif_dasar;
	    }

	    function get_persen_tarif() {
	        return $this->persen_tarif;
	    }

	    function get_pajak() {
	        return $this->pajak;
	    }

	    function get_lokasi() {
	        return $this->lokasi;
	    }

	    function get_diskon() {
	        return $this->diskon;
	    }

	    function get_denda() {
	        return $this->denda;
	    }

	    function get_bunga() {
	        return $this->bunga;
	    }



		
		function set_spt_detil_id($data){
			$this->spt_detil_id=$data;
		}

		function set_spt_id($data) {
	        $this->spt_id=$data;
	    }

		function set_kegus_id($data) {
	        $this->kegus_id=$data;
	    }

	    function set_volume($data) {
	        $this->volume=$data;
	    }

	    function set_nilai_terkena_pajak($data) {
	        $this->nilai_terkena_pajak=$data;
	    }	    

	    function set_tarif_dasar($data) {
	        $this->tarif_dasar=$data;
	    }

	    function set_persen_tarif($data) {
	        $this->persen_tarif=$data;
	    }

	    function set_pajak($data) {
	        $this->pajak=$data;
	    }

	    function set_lokasi($data) {
	        $this->lokasi=$data;
	    }

	    function set_diskon($data) {
	        $this->diskon=$data;
	    }

	    function set_denda($data) {
	        $this->denda=$data;
	    }

	    function set_bunga($data) {
	        $this->bunga=$data;
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