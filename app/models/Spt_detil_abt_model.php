<?php
defined('BASEPATH') or exit('No direct script access allowed');

class spt_detil_abt_model extends CI_Model
{

	private $spt_detil_abt_id, $spt_id, $spt_detil_id, $ptnjk_meter_hari_ini, $ptnjk_meter_bulan_lalu,
		$bkn_meter_hari, $bkn_meter_bulan, $vol_0_50, $vol_51_500, $vol_501_1000, $vol_1001_2500, $vol_leb_2500,
		$hrg_0_50, $hrg_51_500, $hrg_501_1000, $hrg_1001_2500, $hrg_leb_2500;

	const pkey = "spt_detil_abt_id";
	const tbl_name = "spt_detil_abt";

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

	function get_spt_detil_abt_id()
	{
		return $this->spt_detil_abt_id;
	}

	function get_spt_id()
	{
		return $this->spt_id;
	}

	function get_spt_detil_id()
	{
		return $this->spt_detil_id;
	}

	function get_ptnjk_meter_hari_ini()
	{
		return $this->ptnjk_meter_hari_ini;
	}

	function get_ptnjk_meter_bulan_lalu()
	{
		return $this->ptnjk_meter_bulan_lalu;
	}

	function get_bkn_meter_hari()
	{
		return $this->bkn_meter_hari;
	}

	function get_bkn_meter_bulan()
	{
		return $this->bkn_meter_bulan;
	}

	function get_vol_0_50()
	{
		return $this->vol_0_50;
	}

	function get_vol_51_500()
	{
		return $this->vol_51_500;
	}

	function get_vol_501_1000()
	{
		return $this->vol_501_1000;
	}

	function get_vol_1001_2500()
	{
		return $this->vol_1001_2500;
	}

	function get_vol_leb_2500()
	{
		return $this->vol_leb_2500;
	}

	function get_hrg_0_50()
	{
		return $this->hrg_0_50;
	}

	function get_hrg_51_500()
	{
		return $this->hrg_51_500;
	}

	function get_hrg_501_1000()
	{
		return $this->hrg_501_1000;
	}

	function get_hrg_1001_2500()
	{
		return $this->hrg_1001_2500;
	}

	function get_hrg_leb_2500()
	{
		return $this->hrg_leb_2500;
	}



	function set_spt_detil_abt_id($data)
	{
		$this->spt_detil_abt_id = $data;
	}

	function set_spt_id($data)
	{
		$this->spt_id = $data;
	}

	function set_spt_detil_id($data)
	{
		$this->spt_detil_id = $data;
	}

	function set_ptnjk_meter_hari_ini($data)
	{
		$this->ptnjk_meter_hari_ini = $data;
	}

	function set_ptnjk_meter_bulan_lalu($data)
	{
		$this->ptnjk_meter_bulan_lalu = $data;
	}

	function set_bkn_meter_hari($data)
	{
		$this->bkn_meter_hari = $data;
	}

	function set_bkn_meter_bulan($data)
	{
		$this->bkn_meter_bulan = $data;
	}

	function set_vol_0_50($data)
	{
		$this->vol_0_50 = $data;
	}

	function set_vol_51_500($data)
	{
		$this->vol_51_500 = $data;
	}

	function set_vol_501_1000($data)
	{
		$this->vol_501_1000 = $data;
	}

	function set_vol_1001_2500($data)
	{
		$this->vol_1001_2500 = $data;
	}

	function set_vol_leb_2500($data)
	{
		$this->vol_leb_2500 = $data;
	}

	function set_hrg_0_50($data)
	{
		$this->hrg_0_50 = $data;
	}

	function set_hrg_51_500($data)
	{
		$this->hrg_51_500 = $data;
	}

	function set_hrg_501_1000($data)
	{
		$this->hrg_501_1000 = $data;
	}

	function set_hrg_1001_2500($data)
	{
		$this->hrg_1001_2500 = $data;
	}

	function set_hrg_leb_2500($data)
	{
		$this->hrg_leb_2500 = $data;
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
