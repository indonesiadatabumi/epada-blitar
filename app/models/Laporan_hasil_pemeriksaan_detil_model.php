<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class laporan_hasil_pemeriksaan_detil_model extends CI_Model{

		private $lhp_detil_id,$lhp_id,$masa_pajak1,$masa_pajak2,$nilai_terkena_pajak,
				$pajak_terhutang,$persen_tarif,$setoran,$kompensasi,$kredit_pajak_lain,
				$total_kredit_pajak,$pokok_pajak,$bunga,$kenaikan,$denda,
				$total_sanksi,$pajak,$spt_id;

		const pkey = "lhp_detil_id";
		const tbl_name = "laporan_hasil_pemeriksaan_detil";

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

		function get_lhp_detil_id() {
			return $this->lhp_detil_id;
		}

		function get_lhp_id() {
	        return $this->lhp_id;
	    }

	    function get_masa_pajak1() {
	        return $this->masa_pajak1;
	    }

	    function get_masa_pajak2() {
	        return $this->masa_pajak2;
	    }

	    function get_nilai_terkena_pajak() {
	        return $this->nilai_terkena_pajak;
	    }

	    function get_pajak_terhutang() {
	        return $this->pajak_terhutang;
	    }

	    function get_persen_tarif() {
	        return $this->persen_tarif;
	    }

	    function get_setoran() {
	        return $this->setoran;
	    }

	    function get_kompensasi() {
	        return $this->kompensasi;
	    }

	    function get_kredit_pajak_lain() {
	        return $this->kredit_pajak_lain;
	    }

	    function get_total_kredit_pajak() {
	        return $this->total_kredit_pajak;
	    }

	    function get_pokok_pajak() {
	        return $this->pokok_pajak;
	    }

	    function get_bunga() {
	        return $this->bunga;
	    }
	    
	    function get_kenaikan() {
	        return $this->kenaikan;
	    }

	    function get_denda() {
	        return $this->denda;
	    }

	    function get_total_sanksi() {
	        return $this->total_sanksi;
	    }

	    function get_pajak() {
	        return $this->pajak;
	    }

	    function get_spt_id() {
	        return $this->spt_id;
	    }


		
		function set_lhp_detil_id($data) {
			$this->lhp_detil_id=$data;
		}

		function set_lhp_id($data) {
	        $this->lhp_id=$data;
	    }

	    function set_masa_pajak1($data) {
	        $this->masa_pajak1=$data;
	    }

	    function set_masa_pajak2($data) {
	        $this->masa_pajak2=$data;
	    }

	    function set_nilai_terkena_pajak($data) {
	        $this->nilai_terkena_pajak=$data;
	    }

	    function set_pajak_terhutang($data) {
	        $this->pajak_terhutang=$data;
	    }

	    function set_persen_tarif($data) {
	        $this->persen_tarif=$data;
	    }

	    function set_setoran($data) {
	        $this->setoran=$data;
	    }

	    function set_kompensasi($data) {
	        $this->kompensasi=$data;
	    }

	    function set_kredit_pajak_lain($data) {
	        $this->kredit_pajak_lain=$data;
	    }

	    function set_total_kredit_pajak($data) {
	        $this->total_kredit_pajak=$data;
	    }

	    function set_pokok_pajak($data) {
	        $this->pokok_pajak=$data;
	    }

	    function set_bunga($data) {
	        $this->bunga=$data;
	    }
	    
	    function set_kenaikan($data) {
	        $this->kenaikan=$data;
	    }

	    function set_denda($data) {
	        $this->denda=$data;
	    }

	    function set_total_sanksi($data) {
	        $this->total_sanksi=$data;
	    }

	    function set_pajak($data) {
	        $this->pajak=$data;
	    }

	    function set_spt_id($data) {
	        $this->spt_id=$data;
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