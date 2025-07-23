<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class wp_wr_restoran_model extends CI_Model{

		private $wp_wr_restoran_id,$wp_wr_id,$wp_wr_detil_id,$jenis_restoran,$jumlah_meja,
				$jumlah_kursi,$kapasitas_pengunjung,$jumlah_karyawan;

		const pkey = "wp_wr_restoran_id";
		const tbl_name = "wp_wr_restoran";

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

		function get_wp_wr_restoran_id() {
			return $this->wp_wr_restoran_id;
		}

		function get_wp_wr_id() {
	        return $this->wp_wr_id;
	    }

	    function get_wp_wr_detil_id() {
	        return $this->wp_wr_detil_id;
	    }

	    function get_jenis_restoran() {
	        return $this->jenis_restoran;
	    }

	    function get_jumlah_meja() {
	        return $this->jumlah_meja;
	    }

	    function get_jumlah_kursi() {
	        return $this->jumlah_kursi;
	    }

	    function get_kapasitas_pengunjung() {
	        return $this->kapasitas_pengunjung;
	    }

	    function get_jumlah_karyawan() {
	        return $this->jumlah_karyawan;
	    }


	    

		function set_wp_wr_restoran_id($data) {
			$this->wp_wr_restoran_id=$data;
		}

		function set_wp_wr_id($data) {
	        $this->wp_wr_id=$data;
	    }

	    function set_wp_wr_detil_id($data) {
	        $this->wp_wr_detil_id=$data;
	    }

	    function set_jenis_restoran($data) {
	        $this->jenis_restoran=$data;
	    }

	    function set_jumlah_meja($data) {
	        $this->jumlah_meja=$data;
	    }

	    function set_jumlah_kursi($data) {
	        $this->jumlah_kursi=$data;
	    }

	    function set_kapasitas_pengunjung($data) {
	        $this->kapasitas_pengunjung=$data;
	    }

	    function set_jumlah_karyawan($data) {
	        $this->jumlah_karyawan=$data;
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