<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Surat_paksa_model extends CI_Model
{

	private $srt_paksa_id, $srt_paksa_jenis_pajak, $srt_paksa_tgl_proses, $srt_paksa_jatuh_tempo, $srt_paksa_periode, $srt_paksa_nomor, $srt_paksa_setoran_id, $srt_paksa_nomor_spt, $srt_paksa_wp_id, $srt_paksa_korek_id, $srt_paksa_periode_jual1, $srt_paksa_periode_jual2, $srt_paksa_tgl_setoran, $srt_paksa_jumlah_setoran, $srt_paksa_kurang_bayar, $srt_paksa_bulan_pengenaan, $srt_paksa_bunga, $srt_paksa_sanksi, $srt_paksa_pajak, $srt_paksa_dibuat_oleh, $srt_paksa_dibuat_tgl, $srt_paksa_kode_billing, $status_bayar;

	const pkey = "srt_paksa_id";
	const tbl_name = "surat_paksa";

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

	function get_srt_paksa_id()
	{
		return $this->srt_paksa_id;
	}

	function get_srt_paksa_jenis_pajak()
	{
		return $this->srt_paksa_jenis_pajak;
	}

	function get_srt_paksa_tgl_proses()
	{
		return $this->srt_paksa_tgl_proses;
	}

	function get_srt_paksa_jatuh_tempo()
	{
		return $this->srt_paksa_jatuh_tempo;
	}

	function get_srt_paksa_periode()
	{
		return $this->srt_paksa_periode;
	}

	function get_srt_paksa_nomor()
	{
		return $this->srt_paksa_nomor;
	}

	function get_srt_paksa_wp_id()
	{
		return $this->srt_paksa_wp_id;
	}

	function get_srt_paksa_periode_jual2()
	{
		return $this->srt_paksa_periode_jual2;
	}

	function get_srt_paksa_korek_id()
	{
		return $this->srt_paksa_korek_id;
	}

	function get_srt_paksa_periode_jual1()
	{
		return $this->srt_paksa_periode_jual1;
	}

	function get_srt_paksa_tgl_setoran()
	{
		return $this->srt_paksa_tgl_setoran;
	}

	function get_srt_paksa_jumlah_setoran()
	{
		return $this->srt_paksa_jumlah_setoran;
	}

	function get_srt_paksa_kurang_bayar()
	{
		return $this->srt_paksa_kurang_bayar;
	}

	function get_srt_paksa_bulan_pengenaan()
	{
		return $this->srt_paksa_bulan_pengenaan;
	}

	function get_srt_paksa_sanksi()
	{
		return $this->srt_paksa_sanksi;
	}

	function get_srt_paksa_bunga()
	{
		return $this->srt_paksa_bunga;
	}

	function get_srt_paksa_pajak()
	{
		return $this->srt_paksa_pajak;
	}

	function get_srt_paksa_dibuat_oleh()
	{
		return $this->srt_paksa_dibuat_oleh;
	}

	function get_srt_paksa_dibuat_tgl()
	{
		return $this->srt_paksa_dibuat_tgl;
	}

	function get_srt_paksa_kode_billing()
	{
		return $this->srt_paksa_kode_billing;
	}

	function get_status_bayar()
	{
		return $this->status_bayar;
	}




	function set_srt_paksa_id($data)
	{
		$this->srt_paksa_id = $data;
	}

	function set_srt_paksa_jenis_srt_paksa_bulan_pengenaan($data)
	{
		$this->srt_paksa_jenis_srt_paksa_bulan_pengenaan = $data;
	}

	function set_srt_paksa_tgl_proses($data)
	{
		$this->srt_paksa_tgl_proses = $data;
	}

	function set_srt_paksa_jatuh_tempo($data)
	{
		$this->srt_paksa_jatuh_tempo = $data;
	}

	function set_srt_paksa_periode($data)
	{
		$this->srt_paksa_periode = $data;
	}

	function set_srt_paksa_nomor($data)
	{
		$this->srt_paksa_nomor = $data;
	}

	function set_srt_paksa_wp_id($data)
	{
		$this->srt_paksa_wp_id = $data;
	}

	function set_srt_paksa_korek_id($data)
	{
		$this->srt_paksa_korek_id = $data;
	}

	function set_srt_paksa_periode_jual2($data)
	{
		$this->srt_paksa_periode_jual2 = $data;
	}

	function set_srt_paksa_periode_jual1($data)
	{
		$this->srt_paksa_periode_jual1 = $data;
	}

	function set_srt_paksa_tgl_setoran($data)
	{
		$this->srt_paksa_tgl_setoran = $data;
	}

	function set_srt_paksa_jumlah_setoran($data)
	{
		$this->srt_paksa_jumlah_setoran = $data;
	}

	function set_srt_paksa_kurang_bayar($data)
	{
		$this->srt_paksa_kurang_bayar = $data;
	}

	function set_srt_paksa_bulan_pengenaan($data)
	{
		$this->srt_paksa_bulan_pengenaan = $data;
	}

	function set_srt_paksa_sanksi($data)
	{
		$this->srt_paksa_sanksi = $data;
	}

	function set_srt_paksa_bunga($data)
	{
		$this->srt_paksa_bunga = $data;
	}

	function set_srt_paksa_pajak($data)
	{
		$this->srt_paksa_pajak = $data;
	}

	function set_srt_paksa_dibuat_oleh($data)
	{
		$this->srt_paksa_dibuat_oleh = $data;
	}

	function set_srt_paksa_dibuat_tgl($data)
	{
		$this->srt_paksa_dibuat_tgl = $data;
	}

	function set_srt_paksa_kode_billing($data)
	{
		$this->srt_paksa_kode_billing = $data;
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
