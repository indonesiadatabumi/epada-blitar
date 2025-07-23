<?php
defined('BASEPATH') or exit('No direct script access allowed');

class database_interactions
{

	private $_ci, $dao;


	function __construct($dao = null)
	{
		$this->_ci = &get_instance();
		$this->dao = $dao;
		$this->official_ids = array(
			'chief' => 1,
			'secratary' => 2,
			'division1' => 3,
			'division2' => 4,
			'division3' => 5,
			'division4' => 6,
			'treasurer' => 7
		);
	}

	function initialize_dao($dao)
	{
		$this->dao = $dao;
	}

	function get_district_rows()
	{
		return $this->dao->execute(0, "SELECT * FROM ref_kecamatan")->result_array();
	}

	function get_village_rows($district_id)
	{
		return $this->dao->execute(0, "SELECT * FROM ref_kelurahan WHERE kecamatan_id='" . $district_id . "'")->result_array();
	}

	function get_zona_rows($district_id)
	{
		return $this->dao->execute(0, "SELECT * FROM ref_kecamatan INNER JOIN ref_jenis_sat
		ON ref_kecamatan.ref_jensat_id = ref_jenis_sat.ref_jensat_id WHERE kecamatan_id='" . $district_id . "'")->row();
	}

	function get_business_type_rows($tax_id)
	{
		return $this->dao->execute(0, "SELECT * FROM ref_kegiatan_usaha WHERE pajak_id='" . $tax_id . "'")->result_array();
	}

	function get_system_params()
	{
		$rows = $this->dao->execute(0, "SELECT id,value FROM system_params")->result_array();

		$system_params = array();
		foreach ($rows as $row) {
			$system_params[$row['id']] = $row['value'];
		}
		return $system_params;
	}

	function generate_npwprd($district_code, $village_code, $tax_code, $business_code)
	{

		$a = $district_code . "." . $village_code . "." . $tax_code . "." . $business_code;
		$sql = "SELECT MAX(npwprd) last_npwprd FROM wp_wr WHERE npwprd LIKE '" . $a . "%'";

		$row = $this->dao->execute(0, $sql)->row_array();

		$order = 1;
		if (!empty($row['last_npwprd'])) {
			$x = explode('.', $row['last_npwprd']);
			$order += ((int)$x[4]);
		}

		$new_npwprd = $a . "." . sprintf('%04s', $order);

		return $new_npwprd;
	}

	function up_npwprd($district_code, $village_code, $tax_code, $business_code)
	{

		$a = $district_code . "." . $village_code . "." . $tax_code . "." . $business_code;
		$sql = "UPDATE NPWPRD SET  WHERE npwprd LIKE '" . $a . "%'";

		$row = $this->dao->execute(0, $sql)->row_array();

		$order = 1;
		if (!empty($row['last_npwprd'])) {
			$x = explode('.', $row['last_npwprd']);
			$order += ((int)$x[4]);
		}

		$new_npwprd = $a . "." . sprintf('%04s', $order);

		return $new_npwprd;
	}

	function generate_ads_npwpd($district_code, $village_code, $tax_code, $business_code)
	{

		$a = $district_code . "." . $village_code . "." . $tax_code . "." . $business_code;
		$sql = "SELECT MAX(npwpd) last_npwpd FROM wp_wr_reklame WHERE npwpd LIKE '" . $a . "%'";

		$row = $this->dao->execute(0, $sql)->row_array();

		$order = 1;
		if (!empty($row['last_npwpd'])) {
			$x = explode('.', $row['last_npwpd']);
			$order += ((int)substr($x[4], 1, 3));
		}

		$new_npwpd = $a . ".B" . sprintf('%03s', $order);

		return $new_npwpd;
	}


	function get_order_number2($type, $tax_id)
	{

		$curr_year = date('Y');
		$field = "";
		$table = "";

		switch ($type) {
			case 1:
				$field = "nomor_spt";
				$table = "spt";
				break;
			case 2:
				$field = "no_transaksi";
				$table = "transaksi_pajak";
				break;
		}

		$sql = "SELECT MAX(" . $field . ") as last_numb FROM " . $table . " WHERE to_char(created_time,'yyyy')='" . $curr_year . "' AND pajak_id='" . $tax_id . "'";

		$row = $this->dao->execute(0, $sql)->row_array();

		$new_numb = 1;
		if (!empty($row['last_numb'])) {
			$new_numb = (int) $row['last_numb'] + 1;
		}

		return $new_numb;
	}


	function generate_spt_number($tax_id)
	{
		return $this->get_order_number2(1, $tax_id);
	}

	function get_order_number($type)
	{
		$curr_year = date('Y');
		$field = "";
		$table = "";

		switch ($type) {
			case 1:
				$field = "no_form";
				$table = "wp_wr_formulir";
				break;
			case 2:
				$field = "no_reg";
				$table = "wp_wr";
				break;
			case 3:
				$field = "no_transaksi";
				$table = "transaksi_pajak";
				break;
			case 4:
				$field = "nomor";
				$table = "laporan_hasil_pemeriksaan";
				break;
		}

		$sql = "SELECT MAX(" . $field . ") as last_numb FROM " . $table . " WHERE to_char(created_time,'yyyy')='" . $curr_year . "'";

		$row = $this->dao->execute(0, $sql)->row_array();

		$order = 1;
		if (!empty($row['last_numb'])) {
			$order += ((int)$row['last_numb']);
		}

		return $order;
	}

	function generate_regform_number()
	{
		return sprintf('%06s', $this->get_order_number(1));
	}

	function generate_regorder_number()
	{
		return sprintf('%06s', $this->get_order_number(2));
	}

	function generate_transaction_number()
	{
		return $this->get_order_number(3);
	}

	function generate_lhp_number()
	{
		return $this->get_order_number(4);
	}

	function generate_sts_number()
	{

		$curr_year = date('Y');
		$curr_month = date('m');

		$sql = "SELECT MAX(no_sts) as last_numb FROM transaksi_pajak 
					WHERE tahun_pajak='" . $curr_year . "' AND to_char(tgl_bayar,'mm')='" . $curr_month . "'";

		$row = $this->dao->execute(0, $sql)->row_array();

		$new_numb = 1;
		if (!empty($row['last_numb'])) {
			$new_numb = (int) $row['last_numb'] + 1;
		}

		return $new_numb;
	}

	function generate_sts_code($numb, $romawi_month, $year)
	{
		return sprintf('%04d', $numb) . "/" . $romawi_month . "/STS/" . $year;
	}

	function generate_lhp_kohir_humb($spt_type)
	{
		$curr_year = date('Y');

		$sql = "SELECT MAX(kohir) as last_number FROM penetapan_pajak WHERE to_char(created_time,'yyyy')='" . $curr_year . "' AND jenis_spt_id='" . $spt_type . "'";
		$row = $this->dao->execute(0, $sql)->row_array();

		$new_numb = 1;
		if (!empty($row['last_number'])) {
			$new_numb = (int) $row['last_number'] + 1;
		}

		return $new_numb;
	}

	function generate_billing_code($doc_type, $collection_type = '')
	{
		$prefix = $doc_type . $collection_type;   // Contoh: "21" atau "2A"
		$stamp1 = date("m");                      // Bulan: 07
		$stamp2 = date("d");                      // Tanggal: 16
		$len = 5 + ($doc_type == '2' ? 1 : 0);     // Panjang kode acak: 5 atau 6

		$code_numeric = date("is") . substr(microtime(), 2, 3); // unik tiap momen
		$unique_part = substr($code_numeric, -$len); // tetap panjang 6

		$billing_code = $prefix . $stamp1 . $unique_part . $stamp2;

		return $billing_code;
	}

	// function generate_billing_code($kode_pajak_result)
	// {
	// 	$kode_bank = '3305';
	// 	$max_urut = "SELECT MAX(RIGHT(kode_billing,11)) AS kode_billing FROM spt
	// 					WHERE substr(kode_billing, 0,5) = '" . $kode_bank . "'";
	// 	$max_urut_result = $this->dao->execute(0, $max_urut)->row_array();
	// 	$no_urut = $max_urut_result['kode_billing'];
	// 	if ($no_urut > 0) {
	// 		$tmp = $no_urut + 1;
	// 		$kd = sprintf("%011s", $tmp);
	// 	} else {
	// 		$kd = "00000000001";
	// 	}
	// 	$billing_code = $kode_bank . $kode_pajak_result . $kd;
	// 	return $billing_code;
	// }

	function get_arbitrary_data($table, $field, array $cond_params)
	{

		$cond = "";
		$s = false;
		foreach ($cond_params as $key => $val) {
			$cond .= ($s ? " AND " : "") . $key . "='" . $val . "'";
			$s = true;
		}

		$sql = "SELECT " . $field . " FROM " . $table . " WHERE " . $cond;

		$row = $this->dao->execute(0, $sql)->row_array();

		$result = (!empty($row[$field]) ? $row[$field] : '');
		return $result;
	}

	function get_official($official_type)
	{

		if (isset($this->official_ids[$official_type])) {
			$sql = "SELECT a.nama,a.nip,b.gol_ruang,b.pangkat FROM pejabat_daerah as a 
						LEFT JOIN ref_gol_ruang as b ON (a.goru_id=b.ref_goru_id) 
						WHERE japeda_id='" . $this->official_ids[$official_type] . "'";
			$row = $this->dao->execute(0, $sql)->row_array();
			return $row;
		} else {
			return false;
		}
	}

	function get_tax_year()
	{
		$tax_year = date('Y');

		return $tax_year;
	}
}
