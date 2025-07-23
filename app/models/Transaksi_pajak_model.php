<?php
defined('BASEPATH') or exit('No direct script access allowed');

class transaksi_pajak_model extends CI_Model
{

	private $transaksi_id, $spt_id, $pajak_id, $wp_wr_id, $wp_wr_detil_id,
		$npwprd, $jenis_spt_id, $loket_pembayaran_id, $rekening_id, $no_transaksi,
		$no_sts, $kode_status, $kode_billing, $tahun_pajak, $masa_pajak1,
		$masa_pajak2, $pokok_pajak, $denda, $total_bayar, $tgl_bayar,
		$tgl_jatuh_tempo, $created_by, $created_time, $no_urut_sts;

	const pkey = "transaksi_id";
	const tbl_name = "transaksi_pajak";

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

	function get_transaksi_id()
	{
		return $this->transaksi_id;
	}

	function get_spt_id()
	{
		return $this->spt_id;
	}

	function get_pajak_id()
	{
		return $this->pajak_id;
	}

	function get_wp_wr_id()
	{
		return $this->wp_wr_id;
	}

	function get_wp_wr_detil_id()
	{
		return $this->wp_wr_detil_id;
	}

	function get_npwprd()
	{
		return $this->npwprd;
	}

	function get_jenis_spt_id()
	{
		return $this->jenis_spt_id;
	}

	function get_loket_pembayaran_id()
	{
		return $this->loket_pembayaran_id;
	}

	function get_rekening_id()
	{
		return $this->rekening_id;
	}

	function get_no_transaksi()
	{
		return $this->no_transaksi;
	}

	function get_no_sts()
	{
		return $this->no_sts;
	}

	function get_kode_sts()
	{
		return $this->kode_sts;
	}

	function get_kode_billing()
	{
		return $this->kode_billing;
	}

	function get_tahun_pajak()
	{
		return $this->tahun_pajak;
	}

	function get_masa_pajak1()
	{
		return $this->masa_pajak1;
	}

	function get_masa_pajak2()
	{
		return $this->masa_pajak2;
	}

	function get_pokok_pajak()
	{
		return $this->pokok_pajak;
	}

	function get_denda()
	{
		return $this->denda;
	}

	function get_total_bayar()
	{
		return $this->total_bayar;
	}

	function get_tgl_bayar()
	{
		return $this->tgl_bayar;
	}

	function get_tgl_jatuh_tempo()
	{
		return $this->tgl_jatuh_tempo;
	}

	function get_created_by()
	{
		return $this->created_by;
	}

	function get_created_time()
	{
		return $this->created_time;
	}

	function get_no_urut_sts()
	{
		return $this->no_urut_sts;
	}






	function set_transaksi_id($data)
	{
		$this->transaksi_id = $data;
	}

	function set_spt_id($data)
	{
		$this->spt_id = $data;
	}

	function set_pajak_id($data)
	{
		$this->pajak_id = $data;
	}

	function set_wp_wr_id($data)
	{
		$this->wp_wr_id = $data;
	}

	function set_wp_wr_detil_id($data)
	{
		$this->wp_wr_detil_id = $data;
	}

	function set_npwprd($data)
	{
		$this->npwprd = $data;
	}

	function set_jenis_spt_id($data)
	{
		$this->jenis_spt_id = $data;
	}

	function set_loket_pembayaran_id($data)
	{
		$this->loket_pembayaran_id = $data;
	}

	function set_rekening_id($data)
	{
		$this->rekening_id = $data;
	}


	function set_no_transaksi($data)
	{
		$this->no_transaksi = $data;
	}

	function set_no_sts($data)
	{
		$this->no_sts = $data;
	}

	function set_kode_sts($data)
	{
		$this->kode_sts = $data;
	}

	function set_kode_billing($data)
	{
		$this->kode_billing = $data;
	}

	function set_tahun_pajak($data)
	{
		$this->tahun_pajak = $data;
	}

	function set_masa_pajak1($data)
	{
		$this->masa_pajak1 = $data;
	}

	function set_masa_pajak2($data)
	{
		$this->masa_pajak2 = $data;
	}

	function set_pokok_pajak($data)
	{
		$this->pokok_pajak = $data;
	}

	function set_denda($data)
	{
		$this->denda = $data;
	}

	function set_total_bayar($data)
	{
		$this->total_bayar = $data;
	}

	function set_tgl_bayar($data)
	{
		$this->tgl_bayar = $data;
	}

	function set_tgl_jatuh_tempo($data)
	{
		$this->tgl_jatuh_tempo = $data;
	}

	function set_created_by($data)
	{
		$this->created_by = $data;
	}

	function set_created_time($data)
	{
		$this->created_time = $data;
	}

	function set_no_urut_sts($data)
	{
		$this->no_urut_sts = $data;
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
