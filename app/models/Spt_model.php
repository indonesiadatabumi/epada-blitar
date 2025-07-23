<?php
defined('BASEPATH') or exit('No direct script access allowed');

class spt_model extends CI_Model
{

	private $spt_id, $pajak_id, $wp_wr_id, $wp_wr_detil_id, $npwprd,
		$wp_wr_paten, $jenis_spt_id, $nomor_spt, $tahun_pajak, $masa_pajak1,
		$masa_pajak2, $jenis_pemungutan_id, $nama_penerima, $alamat_penerima, $nilai_terkena_pajak,
		$pajak, $tgl_terima, $tgl_bts_kembali, $tgl_proses, $persen_tarif,
		$tarif_dasar, $wp_wr_reklame_id, $kode_billing, $status_ketetapan, $status_bayar,
		$created_by, $created_time, $modified_by, $modified_time, $metod_trans_id, $kompensasi;

	const pkey = "spt_id";
	const tbl_name = "spt";

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

	function get_wp_wr_paten()
	{
		return $this->wp_wr_paten;
	}

	function get_jenis_spt_id()
	{
		return $this->jenis_spt_id;
	}

	function get_nomor_spt()
	{
		return $this->nomor_spt;
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

	function get_jenis_pemungutan_id()
	{
		return $this->jenis_pemungutan_id;
	}

	function get_nama_penerima()
	{
		return $this->nama_penerima;
	}

	function get_alamat_penerima()
	{
		return $this->alamat_penerima;
	}

	function get_nilai_terkena_pajak()
	{
		return $this->nilai_terkena_pajak;
	}

	function get_pajak()
	{
		return $this->pajak;
	}

	function get_tgl_terima()
	{
		return $this->tgl_terima;
	}

	function get_tgl_bts_kembali()
	{
		return $this->tgl_bts_kembali;
	}

	function get_tgl_proses()
	{
		return $this->tgl_proses;
	}

	function get_persen_tarif()
	{
		return $this->persen_tarif;
	}

	function get_tarif_dasar()
	{
		return $this->tarif_dasar;
	}

	function get_wp_wr_reklame_id()
	{
		return $this->wp_wr_reklame_id;
	}

	function get_kode_billing()
	{
		return $this->kode_billing;
	}

	function get_status_ketetapan()
	{
		return $this->status_ketetapan;
	}

	function get_status_bayar()
	{
		return $this->status_bayar;
	}

	function get_created_by()
	{
		return $this->created_by;
	}

	function get_created_time()
	{
		return $this->created_time;
	}

	function get_modified_by()
	{
		return $this->modified_by;
	}

	function get_modified_time()
	{
		return $this->modified_time;
	}

	function get_metod_trans_id()
	{
		return $this->metod_trans_id;
	}

	function get_kompensasi()
	{
		return $this->kompensasi;
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

	function set_wp_wr_paten($data)
	{
		$this->wp_wr_paten = $data;
	}

	function set_jenis_spt_id($data)
	{
		$this->jenis_spt_id = $data;
	}

	function set_nomor_spt($data)
	{
		$this->nomor_spt = $data;
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

	function set_jenis_pemungutan_id($data)
	{
		$this->jenis_pemungutan_id = $data;
	}

	function set_nama_penerima($data)
	{
		$this->nama_penerima = $data;
	}

	function set_alamat_penerima($data)
	{
		$this->alamat_penerima = $data;
	}

	function set_nilai_terkena_pajak($data)
	{
		$this->nilai_terkena_pajak = $data;
	}

	function set_pajak($data)
	{
		$this->pajak = $data;
	}

	function set_tgl_terima($data)
	{
		$this->tgl_terima = $data;
	}

	function set_tgl_bts_kembali($data)
	{
		$this->tgl_bts_kembali = $data;
	}

	function set_tgl_proses($data)
	{
		$this->tgl_proses = $data;
	}

	function set_persen_tarif($data)
	{
		$this->persen_tarif = $data;
	}

	function set_tarif_dasar($data)
	{
		$this->tarif_dasar = $data;
	}

	function set_wp_wr_reklame_id($data)
	{
		$this->wp_wr_reklame_id = $data;
	}

	function set_kode_billing($data)
	{
		$this->kode_billing = $data;
	}

	function set_status_ketetapan($data)
	{
		$this->status_ketetapan = $data;
	}

	function set_status_bayar($data)
	{
		$this->status_bayar = $data;
	}

	function set_created_by($data)
	{
		$this->created_by = $data;
	}

	function set_created_time($data)
	{
		$this->created_time = $data;
	}

	function set_modified_by($data)
	{
		$this->modified_by = $data;
	}

	function set_modified_time($data)
	{
		$this->modified_time = $data;
	}

	function set_metod_trans_id($data)
	{
		$this->metod_trans_id = $data;
	}

	function set_kompensasi($data)
	{
		$this->kompensasi = $data;
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
