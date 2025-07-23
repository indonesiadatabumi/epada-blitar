<?php
defined('BASEPATH') or exit('No direct script access allowed');

class spt_detil_mblb_model extends CI_Model
{

	private $spt_detil_mblb_id, $spt_id, $spt_detil_id, $mblb_id, $volume,
		$tarif_dasar, $nilai_jual;

	const pkey = "spt_detil_mblb_id";
	const tbl_name = "spt_detil_mblb";

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

	function get_spt_detil_mblb_id()
	{
		return $this->spt_detil_mblb_id;
	}

	function get_spt_id()
	{
		return $this->spt_id;
	}

	function get_spt_detil_id()
	{
		return $this->spt_detil_id;
	}

	function get_mblb_id()
	{
		return $this->mblb_id;
	}

	function get_volume()
	{
		return $this->volume;
	}

	function get_tarif_dasar()
	{
		return $this->tarif_dasar;
	}

	function get_nilai_jual()
	{
		return $this->nilai_jual;
	}




	function set_spt_detil_mblb_id($data)
	{
		$this->spt_detil_mblb_id = $data;
	}

	function set_spt_id($data)
	{
		$this->spt_id = $data;
	}

	function set_spt_detil_id($data)
	{
		$this->spt_detil_id = $data;
	}

	function set_mblb_id($data)
	{
		$this->mblb_id = $data;
	}

	function set_volume($data)
	{
		$this->volume = $data;
	}

	function set_tarif_dasar($data)
	{
		$this->tarif_dasar = $data;
	}

	function set_nilai_jual($data)
	{
		$this->nilai_jual = $data;
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
