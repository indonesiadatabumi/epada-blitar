<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class spt_detil_reklame_model extends CI_Model{

		private $spt_detil_reklame_id,$spt_id,$spt_detil_id,$jenis_reklame_id,$area,
				$judul,$lokasi,$indeks_kawasan_id,$indeks_sudut_pandang_id,$indeks_kelas_jalan_id,
				$indeks_ketinggian_id,$indeks_kawasan,$indeks_sudut_pandang,$indeks_kelas_jalan,$indeks_ketinggian,
				$nsl,$ukuran,$jangka_waktu,$jumlah,$harga_satuan,
				$nilai_sewa_reklame,$persen_tarif,$pajak,$tgl_pasang,$tgl_berakhir,$status;

		const pkey = "spt_detil_reklame_id";
		const tbl_name = "spt_detil_reklame";

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

		function get_spt_detil_reklame_id(){
			return $this->spt_detil_reklame_id;
		}

		function get_spt_id() {
	        return $this->spt_id;
	    }

		function get_spt_detil_id() {
	        return $this->spt_detil_id;
	    }

	    function get_jenis_reklame_id() {
	        return $this->jenis_reklame_id;
	    }

	    function get_area() {
	        return $this->area;
	    }	    

	    function get_judul() {
	        return $this->judul;
	    }

	    function get_lokasi() {
	        return $this->lokasi;
	    }

	    function get_indeks_kawasan_id() {
	        return $this->indeks_kawasan_id;
	    }

	    function get_indeks_sudut_pandang_id() {
	        return $this->indeks_sudut_pandang_id;
	    }

	    function get_indeks_kelas_jalan_id() {
	        return $this->indeks_kelas_jalan_id;
	    }

	    function get_indeks_ketinggian_id() {
	        return $this->indeks_ketinggian_id;
	    }

	    function get_indeks_kawasan() {
	        return $this->indeks_kawasan;
	    }

	    function get_indeks_sudut_pandang() {
	        return $this->indeks_sudut_pandang;
	    }

	    function get_indeks_kelas_jalan() {
	        return $this->indeks_kelas_jalan;
	    }

	    function get_indeks_ketinggian() {
	        return $this->indeks_ketinggian;
	    }

	    function get_nsl() {
	        return $this->nsl;
	    }

	    function get_ukuran() {
	        return $this->ukuran;
	    }

	    function get_jangka_waktu() {
	        return $this->jangka_waktu;
	    }

	    function get_jumlah() {
	        return $this->jumlah;
	    }

	    function get_harga_satuan() {
	        return $this->harga_satuan;
	    }

	    function get_nilai_sewa_reklame() {
	        return $this->nilai_sewa_reklame;
	    }

	    function get_persen_tarif() {
	        return $this->persen_tarif;
	    }

	    function get_pajak() {
	        return $this->pajak;
	    }

	    function get_tgl_pasang() {
	        return $this->tgl_pasang;
	    }

	    function get_tgl_berakhir() {
	        return $this->tgl_berakhir;
	    }

	    function get_status() {
	        return $this->status;
	    }

	    



		
		function set_spt_detil_reklame_id($data){
			$this->spt_detil_reklame_id=$data;
		}

		function set_spt_id($data) {
	        $this->spt_id=$data;
	    }

		function set_spt_detil_id($data) {
	        $this->spt_detil_id=$data;
	    }

	    function set_jenis_reklame_id($data) {
	        $this->jenis_reklame_id=$data;
	    }

	    function set_area($data) {
	        $this->area=$data;
	    }	    

	    function set_judul($data) {
	        $this->judul=$data;
	    }

	    function set_lokasi($data) {
	        $this->lokasi=$data;
	    }

	    function set_indeks_kawasan_id($data) {
	        $this->indeks_kawasan_id=$data;
	    }

	    function set_indeks_sudut_pandang_id($data) {
	        $this->indeks_sudut_pandang_id=$data;
	    }

	    function set_indeks_kelas_jalan_id($data) {
	        $this->indeks_kelas_jalan_id=$data;
	    }

	    function set_indeks_ketinggian_id($data) {
	        $this->indeks_ketinggian_id=$data;
	    }

	    function set_indeks_kawasan($data) {
	        $this->indeks_kawasan=$data;
	    }

	    function set_indeks_sudut_pandang($data) {
	        $this->indeks_sudut_pandang=$data;
	    }

	    function set_indeks_kelas_jalan($data) {
	        $this->indeks_kelas_jalan=$data;
	    }

	    function set_indeks_ketinggian($data) {
	        $this->indeks_ketinggian=$data;
	    }

	    function set_nsl($data) {
	        $this->nsl=$data;
	    }

	    function set_ukuran($data) {
	        $this->ukuran=$data;
	    }

	    function set_jangka_waktu($data) {
	        $this->jangka_waktu=$data;
	    }

	    function set_jumlah($data) {
	        $this->jumlah=$data;
	    }

	    function set_harga_satuan($data) {
	        $this->harga_satuan=$data;
	    }

	    function set_nilai_sewa_reklame($data) {
	        $this->nilai_sewa_reklame=$data;
	    }

	    function set_persen_tarif($data) {
	        $this->persen_tarif=$data;
	    }

	    function set_pajak($data) {
	        $this->pajak=$data;
	    }

	    function set_tgl_pasang($data) {
	        $this->tgl_pasang=$data;
	    }

	    function set_tgl_berakhir($data) {
	        $this->tgl_berakhir=$data;
	    }

	    function set_status($data) {
	        $this->status=$data;
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