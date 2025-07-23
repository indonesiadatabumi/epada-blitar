<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Stpd_model extends CI_Model
{

	private $stpd_id, $stpd_jenis_pajak, $stpd_tgl_proses, $stpd_jatuh_tempo, $stpd_periode, $stpd_nomor, $stpd_setoran_id, $stpd_nomor_spt, $stpd_wp_id, $stpd_korek_id, $stpd_periode_jual1, $stpd_periode_jual2, $stpd_tgl_setoran, $stpd_jumlah_setoran, $stpd_kurang_bayar, $stpd_bulan_pengenaan, $stpd_bunga, $stpd_sanksi, $stpd_pajak, $stpd_dibuat_oleh, $stpd_dibuat_tgl, $stpd_kode_billing, $status_bayar;

	const pkey = "stpd_id";
	const tbl_name = "stpd";

	function get_pkey()
	{
		return self::pkey;
	}

	function get_tbl_name()
	{
		return self::tbl_name;
	}

	function __construct(array $init_properties = array())
	{

		if (count($init_properties) > 0) {
			foreach ($init_properties as $key => $val) {
				$this->$key = $val;
			}
		}
	}

	function get_stpd_id()
	{
		return $this->stpd_id;
	}

	function get_stpd_jenis_pajak()
	{
		return $this->stpd_jenis_pajak;
	}

	function get_stpd_tgl_proses()
	{
		return $this->stpd_tgl_proses;
	}

	function get_stpd_jatuh_tempo()
	{
		return $this->stpd_jatuh_tempo;
	}

	function get_stpd_periode()
	{
		return $this->stpd_periode;
	}

	function get_stpd_nomor()
	{
		return $this->stpd_nomor;
	}

	function get_stpd_wp_id()
	{
		return $this->stpd_wp_id;
	}

	function get_stpd_periode_jual2()
	{
		return $this->stpd_periode_jual2;
	}

	function get_stpd_korek_id()
	{
		return $this->stpd_korek_id;
	}

	function get_stpd_periode_jual1()
	{
		return $this->stpd_periode_jual1;
	}

	function get_stpd_tgl_setoran()
	{
		return $this->stpd_tgl_setoran;
	}

	function get_stpd_jumlah_setoran()
	{
		return $this->stpd_jumlah_setoran;
	}

	function get_stpd_kurang_bayar()
	{
		return $this->stpd_kurang_bayar;
	}

	function get_stpd_bulan_pengenaan()
	{
		return $this->stpd_bulan_pengenaan;
	}

	function get_stpd_sanksi()
	{
		return $this->stpd_sanksi;
	}

	function get_stpd_bunga()
	{
		return $this->stpd_bunga;
	}

	function get_stpd_pajak()
	{
		return $this->stpd_pajak;
	}

	function get_stpd_dibuat_oleh()
	{
		return $this->stpd_dibuat_oleh;
	}

	function get_stpd_dibuat_tgl()
	{
		return $this->stpd_dibuat_tgl;
	}

	function get_stpd_kode_billing()
	{
		return $this->stpd_kode_billing;
	}

	function get_status_bayar()
	{
		return $this->status_bayar;
	}




	function set_stpd_id($data)
	{
		$this->stpd_id = $data;
	}

	function set_stpd_jenis_stpd_bulan_pengenaan($data)
	{
		$this->stpd_jenis_stpd_bulan_pengenaan = $data;
	}

	function set_stpd_tgl_proses($data)
	{
		$this->stpd_tgl_proses = $data;
	}

	function set_stpd_jatuh_tempo($data)
	{
		$this->stpd_jatuh_tempo = $data;
	}

	function set_stpd_periode($data)
	{
		$this->stpd_periode = $data;
	}

	function set_stpd_nomor($data)
	{
		$this->stpd_nomor = $data;
	}

	function set_stpd_wp_id($data)
	{
		$this->stpd_wp_id = $data;
	}

	function set_stpd_korek_id($data)
	{
		$this->stpd_korek_id = $data;
	}

	function set_stpd_periode_jual2($data)
	{
		$this->stpd_periode_jual2 = $data;
	}

	function set_stpd_periode_jual1($data)
	{
		$this->stpd_periode_jual1 = $data;
	}

	function set_stpd_tgl_setoran($data)
	{
		$this->stpd_tgl_setoran = $data;
	}

	function set_stpd_jumlah_setoran($data)
	{
		$this->stpd_jumlah_setoran = $data;
	}

	function set_stpd_kurang_bayar($data)
	{
		$this->stpd_kurang_bayar = $data;
	}

	function set_stpd_bulan_pengenaan($data)
	{
		$this->stpd_bulan_pengenaan = $data;
	}

	function set_stpd_sanksi($data)
	{
		$this->stpd_sanksi = $data;
	}

	function set_stpd_bunga($data)
	{
		$this->stpd_bunga = $data;
	}

	function set_stpd_pajak($data)
	{
		$this->stpd_pajak = $data;
	}

	function set_stpd_dibuat_oleh($data)
	{
		$this->stpd_dibuat_oleh = $data;
	}

	function set_stpd_dibuat_tgl($data)
	{
		$this->stpd_dibuat_tgl = $data;
	}

	function set_stpd_kode_billing($data)
	{
		$this->stpd_kode_billing = $data;
	}

	function set_status_bayar($data)
	{
		$this->status_bayar = $data;
	}

	function get_field_list()
	{
		return get_object_vars($this);
	}

	function get_property_collection()
	{
		$field_list = get_object_vars($this);

		$collections = array();
		foreach ($field_list as $key => $val) {
			if ($val != '')
				$collections[$key] = $val;
		}

		return $collections;
	}

	function get_all_data()
	{
		$query = $this->db->query("SELECT * FROM " . $this->get_tbl_name() . " ORDER BY " . $this->get_pkey() . " ASC");
		return $query->result_array();
	}
}
