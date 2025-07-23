<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class ref_jenis_retribusi_model extends CI_Model{

		private $ref_jenretribusi_id,$kd_rekening,$nama_retribusi,$dasar_hukum_pengenaan,$item,
				$non_karcis,$karcis,$denda,$fk_denda;

		const pkey = "ref_jenretribusi_id";
		const tbl_name = "ref_jenis_retribusi";

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

		function get_ref_jenretribusi_id() {
			return $this->ref_jenretribusi_id;
		}

		function get_kd_rekening() {
	        return $this->kd_rekening;
	    }

	    function get_nama_retribusi() {
	        return $this->nama_retribusi;
	    }

	    function get_dasar_hukum_pengenaan() {
	        return $this->dasar_hukum_pengenaan;
	    }

	    function get_item() {
	        return $this->item;
	    }

	    function get_non_karcis() {
	        return $this->non_karcis;
	    }

	    function get_karcis() {
	        return $this->karcis;
	    }

	    function get_denda() {
	        return $this->denda;
	    }

	    function get_fk_denda() {
	        return $this->fk_denda;
	    }

	    

		
		function set_ref_jenretribusi_id($data) {
			$this->ref_jenretribusi_id=$data;
		}

		function set_kd_rekening($data) {
	        $this->kd_rekening=$data;
	    }

	    function set_nama_retribusi($data) {
	        $this->nama_retribusi=$data;
	    }

	    function set_dasar_hukum_pengenaan($data) {
	        $this->dasar_hukum_pengenaan=$data;
	    }

	    function set_item($data) {
	        $this->item=$data;
	    }

	    function set_non_karcis($data) {
	        $this->non_karcis=$data;
	    }

	    function set_karcis($data) {
	        $this->karcis=$data;
	    }

	    function set_denda($data) {
	        $this->denda=$data;
	    }

	    function set_fk_denda($data) {
	        $this->fk_denda=$data;
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