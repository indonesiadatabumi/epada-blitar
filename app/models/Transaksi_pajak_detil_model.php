<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class transaksi_pajak_detil_model extends CI_Model{

		private $transaksi_detil_id,$transaksi_id,$rekening_id,$tahun_pajak,$jumlah_pajak,
				$tgl_bayar;

		const pkey = "transaksi_detil_id";
		const tbl_name = "transaksi_pajak_detil";

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

		function get_transaksi_detil_id() {
			return $this->transaksi_detil_id;
		}

		function get_transaksi_id() {
			return $this->transaksi_id;
		}

		function get_rekening_id() {
	        return $this->rekening_id;
	    }

	    function get_tahun_pajak() {
	        return $this->tahun_pajak;
	    }

	    function get_jumlah_pajak() {
	        return $this->jumlah_pajak;
	    }

	    function get_tgl_bayar() {
	        return $this->tgl_bayar;
	    }
	    

		
		function set_transaksi_detil_id($data) {
			$this->transaksi_detil_id=$data;
		}

		function set_transaksi_id($data) {
			$this->transaksi_id=$data;
		}

		function set_rekening_id($data) {
	        $this->rekening_id=$data;
	    }

	    function set_tahun_pajak($data) {
	        $this->tahun_pajak=$data;
	    }

	    function set_jumlah_pajak($data) {
	        $this->jumlah_pajak=$data;
	    }

	    function set_tgl_bayar($data) {
	        $this->tgl_bayar=$data;
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
