<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class spt_detil_penerangan_jalan_model extends CI_Model{

		private $spt_detil_penerangan_jalan_id,$spt_id,$spt_detil_id,$penggunaan_daya,$tarif_dasar,
				$nilai_jual,$persen_tarif,$pajak;

		const pkey = "spt_detil_penerangan_jalan_id";
		const tbl_name = "spt_detil_penerangan_jalan";

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

		function get_spt_detil_penerangan_jalan_id(){
			return $this->spt_detil_penerangan_jalan_id;
		}

		function get_spt_id() {
	        return $this->spt_id;
	    }

		function get_spt_detil_id() {
	        return $this->spt_detil_id;
	    }

	    function get_penggunaan_daya() {
	        return $this->penggunaan_daya;
	    }

	    function get_tarif_dasar() {
	        return $this->tarif_dasar;
	    }	    

	    function get_nilai_jual() {
	        return $this->nilai_jual;
	    }

	    function get_persen_tarif() {
	        return $this->persen_tarif;
	    }

	    function get_pajak() {
	        return $this->pajak;
	    }



		
		function set_spt_detil_penerangan_jalan_id($data){
			$this->spt_detil_penerangan_jalan_id=$data;
		}

		function set_spt_id($data) {
	        $this->spt_id=$data;
	    }

		function set_spt_detil_id($data) {
	        $this->spt_detil_id=$data;
	    }

	    function set_penggunaan_daya($data) {
	        $this->penggunaan_daya=$data;
	    }

	    function set_tarif_dasar($data) {
	        $this->tarif_dasar=$data;
	    }	    

	    function set_nilai_jual($data) {
	        $this->nilai_jual=$data;
	    }

	    function set_persen_tarif($data) {
	        $this->persen_tarif=$data;
	    }

	    function set_pajak($data) {
	        $this->pajak=$data;
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