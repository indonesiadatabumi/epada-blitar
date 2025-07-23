<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class penetapan_pajak_model extends CI_Model{

		private $penetapan_id,$spt_id,$pajak_id,$kohir,$jenis_spt_id,
				$tipe_penetapan,$tahun_pajak,$tgl_penetapan,$tgl_jatuh_tempo,$setoran_sebelumnya,
				$besaran,$rekening_id,$lhp_id,$keterangan,$created_by,
				$created_time;

		const pkey = "penetapan_id";
		const tbl_name = "penetapan_pajak";

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

		function get_penetapan_id() {
			return $this->penetapan_id;
		}

		function get_spt_id() {
	        return $this->spt_id;
	    }

		function get_pajak_id() {
	        return $this->pajak_id;
	    }

	    function get_kohir() {
	        return $this->kohir;
	    }

	    function get_jenis_spt_id() {
	        return $this->jenis_spt_id;
	    }

	    function get_tipe_penetapan() {
	        return $this->tipe_penetapan;
	    }

	    function get_tahun_pajak() {
	        return $this->tahun_pajak;
	    }

	    function get_tgl_penetapan() {
	        return $this->tgl_penetapan;
	    }

	    function get_tgl_jatuh_tempo() {
	        return $this->tgl_jatuh_tempo;
	    }

	    function get_setoran_sebelumnya() {
	        return $this->setoran_sebelumnya;
	    }

	    function get_besaran() {
	        return $this->besaran;
	    }

	    function get_rekening_id() {
	        return $this->rekening_id;
	    }
	    
	    function get_lhp_id() {
	        return $this->lhp_id;
	    }

	    function get_keterangan() {
	        return $this->keterangan;
	    }

	    function get_created_by() {
	        return $this->created_by;
	    }

	    function get_created_time() {
	        return $this->created_time;
	    }


		
		function set_penetapan_id($data) {
			$this->penetapan_id=$data;
		}

		function set_spt_id($data) {
	        $this->spt_id=$data;
	    }

		function set_pajak_id($data) {
	        $this->pajak_id=$data;
	    }

	    function set_kohir($data) {
	        $this->kohir=$data;
	    }

	    function set_jenis_spt_id($data) {
	        $this->jenis_spt_id=$data;
	    }

	    function set_tipe_penetapan($data) {
	        $this->tipe_penetapan=$data;
	    }

	    function set_tahun_pajak($data) {
	        $this->tahun_pajak=$data;
	    }

	    function set_tgl_penetapan($data) {
	        $this->tgl_penetapan=$data;
	    }

	    function set_tgl_jatuh_tempo($data) {
	        $this->tgl_jatuh_tempo=$data;
	    }

	    function set_setoran_sebelumnya($data) {
	        $this->setoran_sebelumnya=$data;
	    }

	    function set_besaran($data) {
	        $this->besaran=$data;
	    }

	    function set_rekening_id($data) {
	        $this->rekening_id=$data;
	    }
	    
	    function set_lhp_id($data) {
	        $this->lhp_id=$data;
	    }

	    function set_keterangan($data) {
	        $this->keterangan=$data;
	    }

	    function set_created_by($data) {
	        $this->created_by=$data;
	    }

	    function set_created_time($data) {
	        $this->created_time=$data;
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