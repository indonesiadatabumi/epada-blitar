<?php
defined('BASEPATH') or exit('No direct script access allowed');

class wp_wr_model extends CI_Model
{

	private $wp_wr_id, $jenis, $golongan, $npwprd, $nama,
		$alamat, $kelurahan_id, $kecamatan_id, $kelurahan, $kecamatan,
		$kabupaten, $kode_pos, $no_telepon, $nama_pemilik, $alamat_pemilik,
		$kelurahan_pemilik, $kecamatan_pemilik, $kabupaten_pemilik, $kode_pos_pemilik, $no_telepon_pemilik,
		$kewarganegaraan, $jns_tb, $no_tb, $tgl_tb, $no_kk,
		$tgl_kk, $pekerjaan, $nm_instansi, $alamat_instansi, $tgl_pendaftaran,
		$tgl_terima_form, $tgl_bts_kirim, $tgl_form_kembali, $created_by, $created_time,
		$modified_by, $modified_time, $status, $latitude, $longitude,
		$pajak_id, $kegus_id, $no_reg, $no_bpjs, $ijin_usaha, $metod_trans_id;

	const pkey = "wp_wr_id";
	const tbl_name = "wp_wr";

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

	function get_wp_wr_id()
	{
		return $this->wp_wr_id;
	}

	function get_jenis()
	{
		return $this->jenis;
	}

	function get_golongan()
	{
		return $this->golongan;
	}

	function get_npwprd()
	{
		return $this->npwprd;
	}

	function get_nama()
	{
		return $this->nama;
	}

	function get_alamat()
	{
		return $this->alamat;
	}

	function get_kelurahan_id()
	{
		return $this->kelurahan_id;
	}

	function get_kecamatan_id()
	{
		return $this->kecamatan_id;
	}

	function get_kelurahan()
	{
		return $this->kelurahan;
	}

	function get_kecamatan()
	{
		return $this->kecamatan;
	}

	function get_kabupaten()
	{
		return $this->kabupaten;
	}

	function get_kode_pos()
	{
		return $this->kode_pos;
	}

	function get_no_telepon()
	{
		return $this->no_telepon;
	}

	function get_nama_pemilik()
	{
		return $this->nama_pemilik;
	}

	function get_alamat_pemilik()
	{
		return $this->alamat_pemilik;
	}

	function get_kelurahan_pemilik()
	{
		return $this->kelurahan_pemilik;
	}

	function get_kecamatan_pemilik()
	{
		return $this->kecamatan_pemilik;
	}

	function get_kabupaten_pemilik()
	{
		return $this->kabupaten_pemilik;
	}

	function get_kode_pos_pemilik()
	{
		return $this->kode_pos_pemilik;
	}

	function get_no_telepon_pemilik()
	{
		return $this->no_telepon_pemilik;
	}

	function get_kewarganegaraan()
	{
		return $this->kewarganegaraan;
	}

	function get_jns_tb()
	{
		return $this->jns_tb;
	}

	function get_no_tb()
	{
		return $this->no_tb;
	}

	function get_tgl_tb()
	{
		return $this->tgl_tb;
	}

	function get_no_kk()
	{
		return $this->no_kk;
	}

	function get_tgl_kk()
	{
		return $this->tgl_kk;
	}

	function get_pekerjaan()
	{
		return $this->pekerjaan;
	}
	function get_nm_instansi()
	{
		return $this->nm_instansi;
	}

	function get_alamat_instansi()
	{
		return $this->alamat_instansi;
	}

	function get_tgl_pendaftaran()
	{
		return $this->tgl_pendaftaran;
	}

	function get_tgl_terima_form()
	{
		return $this->tgl_terima_form;
	}

	function get_tgl_bts_kirim()
	{
		return $this->tgl_bts_kirim;
	}

	function get_tgl_form_kembali()
	{
		return $this->tgl_form_kembali;
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

	function get_status()
	{
		return $this->status;
	}

	function get_latitude()
	{
		return $this->latitude;
	}

	function get_longitude()
	{
		return $this->longitude;
	}

	function get_pajak_id()
	{
		return $this->pajak_id;
	}

	function get_kegus_id()
	{
		return $this->kegus_id;
	}

	function get_no_reg()
	{
		return $this->no_reg;
	}

	function get_no_bpjs()
	{
		return $this->no_bpjs;
	}

	function get_ijin_usaha()
	{
		return $this->ijin_usaha;
	}

	function get_metod_trans_id()
	{
		return $this->metod_trans_id;
	}




	function set_wp_wr_id($data)
	{
		$this->wp_wr_id = $data;
	}

	function set_jenis($data)
	{
		$this->jenis = $data;
	}

	function set_golongan($data)
	{
		$this->golongan = $data;
	}

	function set_npwprd($data)
	{
		$this->npwprd = $data;
	}

	function set_nik($data)
	{
		$this->nik = $data;
	}

	function set_nama($data)
	{
		$this->nama = $data;
	}

	function set_alamat($data)
	{
		$this->alamat = $data;
	}

	function set_kelurahan_id($data)
	{
		$this->kelurahan_id = $data;
	}

	function set_kecamatan_id($data)
	{
		$this->kecamatan_id = $data;
	}

	function set_kelurahan($data)
	{
		$this->kelurahan = $data;
	}

	function set_kecamatan($data)
	{
		$this->kecamatan = $data;
	}

	function set_kabupaten($data)
	{
		$this->kabupaten = $data;
	}

	function set_kode_pos($data)
	{
		$this->kode_pos = $data;
	}

	function set_no_telepon($data)
	{
		$this->no_telepon = $data;
	}

	function set_nama_pemilik($data)
	{
		$this->nama_pemilik = $data;
	}

	function set_alamat_pemilik($data)
	{
		$this->alamat_pemilik = $data;
	}

	function set_kelurahan_pemilik($data)
	{
		$this->kelurahan_pemilik = $data;
	}

	function set_kecamatan_pemilik($data)
	{
		$this->kecamatan_pemilik = $data;
	}

	function set_kabupaten_pemilik($data)
	{
		$this->kabupaten_pemilik = $data;
	}

	function set_kode_pos_pemilik($data)
	{
		$this->kode_pos_pemilik = $data;
	}

	function set_no_telepon_pemilik($data)
	{
		$this->no_telepon_pemilik = $data;
	}

	function set_kewarganegaraan($data)
	{
		$this->kewarganegaraan = $data;
	}

	function set_jns_tb($data)
	{
		$this->jns_tb = $data;
	}

	function set_no_tb($data)
	{
		$this->no_tb = $data;
	}

	function set_tgl_tb($data)
	{
		$this->tgl_tb = $data;
	}

	function set_no_kk($data)
	{
		$this->no_kk = $data;
	}

	function set_tgl_kk($data)
	{
		$this->tgl_kk = $data;
	}

	function set_pekerjaan($data)
	{
		$this->pekerjaan = $data;
	}
	function set_nm_instansi($data)
	{
		$this->nm_instansi = $data;
	}

	function set_alamat_instansi($data)
	{
		$this->alamat_instansi = $data;
	}

	function set_tgl_pendaftaran($data)
	{
		$this->tgl_pendaftaran = $data;
	}

	function set_tgl_terima_form($data)
	{
		$this->tgl_terima_form = $data;
	}

	function set_tgl_bts_kirim($data)
	{
		$this->tgl_bts_kirim = $data;
	}

	function set_tgl_form_kembali($data)
	{
		$this->tgl_form_kembali = $data;
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

	function set_status($data)
	{
		$this->status = $data;
	}

	function set_latitude($data)
	{
		$this->latitude = $data;
	}

	function set_longitude($data)
	{
		$this->longitude = $data;
	}

	function set_pajak_id($data)
	{
		$this->pajak_id = $data;
	}

	function set_kegus_id($data)
	{
		$this->kegus_id = $data;
	}

	function set_no_reg($data)
	{
		$this->no_reg = $data;
	}

	function set_no_bpjs($data)
	{
		$this->no_bpjs = $data;
	}

	function set_ijin_usaha($data)
	{
		$this->ijin_usaha = $data;
	}

	function set_metod_trans_id($data)
	{
		$this->metod_trans_id = $data;
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
