<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class wp_wr_hotel_model extends CI_Model{

		private $wp_wr_hotel_id,$wp_wr_id,$wp_wr_detil_id,$golongan_hotel,$jumlah_kamar,
				$jumlah_standar,$jumlah_standar_ac,$jumlah_double,$jumlah_superior,$jumlah_delux,
				$jumlah_executive_suite,$jumlah_club_room,$jumlah_apartment,$tarif_standar,$tarif_standar_ac,
				$tarif_double,$tarif_superior,$tarif_delux,$tarif_executive_suite,$tarif_club_room,
				$tarif_apartment;

		const pkey = "wp_wr_hotel_id";
		const tbl_name = "wp_wr_hotel";

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

		function get_wp_wr_hotel_id() {
			return $this->wp_wr_hotel_id;
		}

		function get_wp_wr_id() {
	        return $this->wp_wr_id;
	    }

	    function get_wp_wr_detil_id() {
	        return $this->wp_wr_detil_id;
	    }

	    function get_golongan_hotel() {
	        return $this->golongan_hotel;
	    }

	    function get_jumlah_kamar() {
	        return $this->jumlah_kamar;
	    }

	    function get_jumlah_standar() {
	        return $this->jumlah_standar;
	    }

	    function get_jumlah_standar_ac() {
	        return $this->jumlah_standar_ac;
	    }

	    function get_jumlah_double() {
	        return $this->jumlah_double;
	    }

	    function get_jumlah_superior() {
	        return $this->jumlah_superior;
	    }

	    function get_jumlah_delux() {
	        return $this->jumlah_delux;
	    }

	    function get_jumlah_executive_suite() {
	        return $this->jumlah_executive_suite;
	    }

	    function get_jumlah_club_room() {
	        return $this->jumlah_club_room;
	    }

	    function get_jumlah_apartment() {
	        return $this->jumlah_apartment;
	    }

	    function get_tarif_standar() {
	        return $this->tarif_standar;
	    }

	    function get_tarif_standar_ac() {
	        return $this->tarif_standar_ac;
	    }

	    function get_tarif_double() {
	        return $this->tarif_double;
	    }

	    function get_tarif_superior() {
	        return $this->tarif_superior;
	    }

	    function get_tarif_delux() {
	        return $this->tarif_delux;
	    }

	    function get_tarif_executive_suite() {
	        return $this->tarif_executive_suite;
	    }

	    function get_tarif_club_room() {
	        return $this->tarif_club_room;
	    }

	    function get_tarif_apartment() {
	        return $this->tarif_apartment;
	    }



	    

		function set_wp_wr_hotel_id($data) {
			$this->wp_wr_hotel_id=$data;
		}

		function set_wp_wr_id($data) {
	        $this->wp_wr_id=$data;
	    }

	    function set_wp_wr_detil_id($data) {
	        $this->wp_wr_detil_id=$data;
	    }

	    function set_golongan_hotel($data) {
	        $this->golongan_hotel=$data;
	    }

	    function set_jumlah_kamar($data) {
	        $this->jumlah_kamar=$data;
	    }

	    function set_jumlah_standar($data) {
	        $this->jumlah_standar=$data;
	    }

	    function set_jumlah_standar_ac($data) {
	        $this->jumlah_standar_ac=$data;
	    }

	    function set_jumlah_double($data) {
	        $this->jumlah_double=$data;
	    }

	    function set_jumlah_superior($data) {
	        $this->jumlah_superior=$data;
	    }

	    function set_jumlah_delux($data) {
	        $this->jumlah_delux=$data;
	    }

	    function set_jumlah_executive_suite($data) {
	        $this->jumlah_executive_suite=$data;
	    }

	    function set_jumlah_club_room($data) {
	        $this->jumlah_club_room=$data;
	    }

	    function set_jumlah_apartment($data) {
	        $this->jumlah_apartment=$data;
	    }

	    function set_tarif_standar($data) {
	        $this->tarif_standar=$data;
	    }

	    function set_tarif_standar_ac($data) {
	        $this->tarif_standar_ac=$data;
	    }

	    function set_tarif_double($data) {
	        $this->tarif_double=$data;
	    }

	    function set_tarif_superior($data) {
	        $this->tarif_superior=$data;
	    }

	    function set_tarif_delux($data) {
	        $this->tarif_delux=$data;
	    }

	    function set_tarif_executive_suite($data) {
	        $this->tarif_executive_suite=$data;
	    }

	    function set_tarif_club_room($data) {
	        $this->tarif_club_room=$data;
	    }

	    function set_tarif_apartment($data) {
	        $this->tarif_apartment=$data;
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