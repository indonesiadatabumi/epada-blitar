<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Surat_teguran2_model extends CI_Model
{

	private $st_id, $st_jenis_pajak, $st_tgl_proses, $st_jatuh_tempo, $st_periode, $st_nomor, $st_setoran_id, $st_nomor_spt, $st_wp_id, $st_korek_id, $st_periode_jual1, $st_periode_jual2, $st_tgl_setoran, $st_jumlah_setoran, $st_kurang_bayar, $st_bulan_pengenaan, $st_bunga, $st_sanksi, $st_pajak, $st_dibuat_oleh, $st_dibuat_tgl, $st_kode_billing, $status_bayar;

	const pkey = "st_id";
	const tbl_name = "st";

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

	function get_st_id()
	{
		return $this->st_id;
	}

	function get_st_jenis_pajak()
	{
		return $this->st_jenis_pajak;
	}

	function get_st_tgl_proses()
	{
		return $this->st_tgl_proses;
	}

	function get_st_jatuh_tempo()
	{
		return $this->st_jatuh_tempo;
	}

	function get_st_periode()
	{
		return $this->st_periode;
	}

	function get_st_nomor()
	{
		return $this->st_nomor;
	}

	function get_st_wp_id()
	{
		return $this->st_wp_id;
	}

	function get_st_periode_jual2()
	{
		return $this->st_periode_jual2;
	}

	function get_st_korek_id()
	{
		return $this->st_korek_id;
	}

	function get_st_periode_jual1()
	{
		return $this->st_periode_jual1;
	}

	function get_st_tgl_setoran()
	{
		return $this->st_tgl_setoran;
	}

	function get_st_jumlah_setoran()
	{
		return $this->st_jumlah_setoran;
	}

	function get_st_kurang_bayar()
	{
		return $this->st_kurang_bayar;
	}

	function get_st_bulan_pengenaan()
	{
		return $this->st_bulan_pengenaan;
	}

	function get_st_sanksi()
	{
		return $this->st_sanksi;
	}

	function get_st_bunga()
	{
		return $this->st_bunga;
	}

	function get_st_pajak()
	{
		return $this->st_pajak;
	}

	function get_st_dibuat_oleh()
	{
		return $this->st_dibuat_oleh;
	}

	function get_st_dibuat_tgl()
	{
		return $this->st_dibuat_tgl;
	}

	function get_st_kode_billing()
	{
		return $this->st_kode_billing;
	}

	function get_status_bayar()
	{
		return $this->status_bayar;
	}




	function set_st_id($data)
	{
		$this->st_id = $data;
	}

	function set_st_jenis_st_bulan_pengenaan($data)
	{
		$this->st_jenis_st_bulan_pengenaan = $data;
	}

	function set_st_tgl_proses($data)
	{
		$this->st_tgl_proses = $data;
	}

	function set_st_jatuh_tempo($data)
	{
		$this->st_jatuh_tempo = $data;
	}

	function set_st_periode($data)
	{
		$this->st_periode = $data;
	}

	function set_st_nomor($data)
	{
		$this->st_nomor = $data;
	}

	function set_st_wp_id($data)
	{
		$this->st_wp_id = $data;
	}

	function set_st_korek_id($data)
	{
		$this->st_korek_id = $data;
	}

	function set_st_periode_jual2($data)
	{
		$this->st_periode_jual2 = $data;
	}

	function set_st_periode_jual1($data)
	{
		$this->st_periode_jual1 = $data;
	}

	function set_st_tgl_setoran($data)
	{
		$this->st_tgl_setoran = $data;
	}

	function set_st_jumlah_setoran($data)
	{
		$this->st_jumlah_setoran = $data;
	}

	function set_st_kurang_bayar($data)
	{
		$this->st_kurang_bayar = $data;
	}

	function set_st_bulan_pengenaan($data)
	{
		$this->st_bulan_pengenaan = $data;
	}

	function set_st_sanksi($data)
	{
		$this->st_sanksi = $data;
	}

	function set_st_bunga($data)
	{
		$this->st_bunga = $data;
	}

	function set_st_pajak($data)
	{
		$this->st_pajak = $data;
	}

	function set_st_dibuat_oleh($data)
	{
		$this->st_dibuat_oleh = $data;
	}

	function set_st_dibuat_tgl($data)
	{
		$this->st_dibuat_tgl = $data;
	}

	function set_st_kode_billing($data)
	{
		$this->st_kode_billing = $data;
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
