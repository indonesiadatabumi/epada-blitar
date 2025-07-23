<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class wp_wr_penutupan_model extends CI_Model{

		private $wp_wr_penutupan_id,$wp_wr_detil_id,$no_berita_acara,$tgl_berita_acara,$isi_berita_acara,
				$tgl_tutup,$created_by,$created_time,$modified_by,$modified_time;

		const pkey = "wp_wr_penutupan_id";
		const tbl_name = "wp_wr_penutupan";

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

		function get_wp_wr_penutupan_id() {
			return $this->wp_wr_penutupan_id;
		}

		function get_wp_wr_detil_id() {
	        return $this->wp_wr_detil_id;
	    }

	    function get_no_berita_acara() {
	        return $this->no_berita_acara;
	    }

	    function get_tgl_berita_acara() {
	        return $this->tgl_berita_acara;
	    }

	    function get_isi_berita_acara() {
	        return $this->isi_berita_acara;
	    }

	    function get_tgl_tutup() {
	        return $this->tgl_tutup;
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



		function set_wp_wr_penutupan_id($data) {
			$this->wp_wr_penutupan_id=$data;
		}

		function set_wp_wr_detil_id($data) {
	        $this->wp_wr_detil_id=$data;
	    }

	    function set_no_berita_acara($data) {
	        $this->no_berita_acara=$data;
	    }

	    function set_tgl_berita_acara($data) {
	        $this->tgl_berita_acara=$data;
	    }

	    function set_isi_berita_acara($data) {
	        $this->isi_berita_acara=$data;
	    }

	    function set_tgl_tutup($data) {
	        $this->tgl_tutup=$data;
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