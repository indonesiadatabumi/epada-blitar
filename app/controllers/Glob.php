<?php
defined('BASEPATH') or exit('No direct script access allowed');

class glob extends CI_Controller
{

	function __construct()
	{

		parent::__construct();

		$this->load->library(array('DAO', 'database_interactions'));
		$this->load->helper(array('date_helper'));
		$this->load->model(array('global_model'));

		$this->global_model->reinitialize_dao();
		$this->dao = $this->global_model->get_dao();

		$this->database_interactions->initialize_dao($this->dao);
	}


	function get_villages()
	{
		$district = $this->input->post('district');
		$with_name = false;
		$with_code = false;

		if (strlen($district) > 7) {

			$x_district = explode('_', $district);
			$district = $x_district[0];
			$with_name = true;

			if (count($x_district) > 2) {
				$code = $x_district[2];
				$with_code = true;
			}
		}

		$data['village_rows'] = $this->database_interactions->get_village_rows($district);
		$data['type'] = (!is_null($this->input->post('type')) ? $this->input->post('type') : '0');
		$data['district'] = $district;
		$data['with_name'] = $with_name;
		$data['with_code'] = $with_code;

		$this->load->view('global/village_list', $data);
	}

	function get_zona()
	{
		$district = $this->input->post('district');
		$x_district = explode('_', $district);
		$district = $x_district[0];

		$data['zona_rows'] = $this->database_interactions->get_zona_rows($district);
		$this->load->view('global/get_zona', $data);
	}

	function get_sda()
	{
		$zona_rows = $this->input->post('zona_rows');
		$x_zona_rows = explode('.', $zona_rows);
		$zona_rows = $x_zona_rows[0];

		$sql = "SELECT * FROM ref_komponen_kompensasi_air_tanah WHERE ref_jensat_id='" . $zona_rows . "'";
		$rows = $this->dao->execute(0, $sql)->result_array();
		$data['rows'] = $rows;
		$this->load->view('global/get_sda', $data);
	}

	function get_taxpayers()
	{
		$tax_id = $this->input->post('tax_id');
		$input_element = $this->input->post('input_element');
		$wp_wr_detil = $this->input->post('wp_wr_detil');

		$sql = "SELECT wp_wr_detil_id,npwprd,nama_wp,alamat,nama_kegus FROM v_objek_pajak WHERE pajak_id='" . $tax_id . "'";
		$rows = $this->dao->execute(0, $sql)->result_array();
		$data['rows'] = $rows;
		$data['input_element'] = $input_element;
		$data['wp_wr_detil'] = $wp_wr_detil;
		$this->load->view('global/taxpayer_list', $data);
	}

	function get_business_types()
	{

		$tax_id = $this->input->post('tax');

		$data['business_type_rows'] = $this->database_interactions->get_business_type_rows($tax_id);
		$data['type'] = (!is_null($this->input->post('type')) ? $this->input->post('type') : '0');
		$data['tax_id'] = $tax_id;

		$this->load->view('global/business_type_list', $data);
	}

	function get_groundwater_resources_components()
	{
		$water_type = $this->input->post('water_type');

		$cond = "";
		if (!empty($water_type)) {
			$cond = "WHERE hrgab_id='" . $water_type . "'";
		}
		$sql = "SELECT * FROM ref_komponen_sda_air_tanah " . $cond;

		$rows = $this->dao->execute(0, $sql)->result_array();
		$data['rows'] = $rows;
		$this->load->view('global/groundwater_resources_component_list', $data);
	}

	public function get_banner_info()
	{


		$bundle_id = $this->input->post('bundle_id');

		$start_date = date('Y-m') . '-01';
		$end_date = date('Y-m-d');
		$curr_year = date('Y');

		$sql = "SELECT SUM(total_bayar) tot_tax FROM transaksi_pajak WHERE pajak_id='" . $bundle_id . "' AND to_char(masa_pajak1,'mm')='" . sprintf('%02s', date('m')) . "' AND to_char(masa_pajak1, 'yyyy') = '" . date('Y') . "'";
		$row1 = $this->dao->execute(0, $sql)->row_array();

		// $sql = "SELECT SUM(total_bayar) tot_tax FROM transaksi_pajak WHERE pajak_id='".$bundle_id."' AND (tgl_bayar BETWEEN '".$start_date."' AND '".$end_date."')";
		$sql = "SELECT SUM(total_bayar) tot_tax FROM transaksi_pajak WHERE pajak_id='" . $bundle_id . "' AND to_char(masa_pajak1, 'yyyy') = '" . date('Y') . "'";
		$row2 = $this->dao->execute(0, $sql)->row_array();

		$sql = "SELECT SUM(pajak) tot_receivables FROM spt WHERE pajak_id='" . $bundle_id . "' AND tahun_pajak='" . $curr_year . "' 
					AND (spt_id NOT IN (SELECT spt_id FROM transaksi_pajak WHERE pajak_id='" . $bundle_id . "') AND tahun_pajak='" . $curr_year . "')";
		$row3 = $this->dao->execute(0, $sql)->row_array();

		$curr_month_revenue = $row1['tot_tax'];
		$tot_revenue = $row2['tot_tax'];
		$tot_receivables = $row3['tot_receivables'];

		$label_chart = "['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agt','Sep','Okt','Nov','Des']";

		$sql = "SELECT SUM(total_bayar) tot_tax FROM transaksi_pajak WHERE pajak_id='" . $bundle_id . "'";
		$data_chart = "[";

		$s = false;
		for ($i = 1; $i <= 12; $i++) {

			$_sql = $sql . " AND to_char(masa_pajak1,'mm')='" . sprintf('%02s', $i) . "' AND to_char(masa_pajak1,'yyyy')='" . date('Y') . "'";

			$row = $this->dao->execute(0, $_sql)->row_array();

			$data_chart .= ($s ? "," : "") . (!empty($row['tot_tax']) ? $row['tot_tax'] : '0');
			$s = true;
		}
		$data_chart .= "]";


		$data['label_chart'] = $label_chart;
		$data['data_chart'] = $data_chart;
		$data['curr_month_revenue'] = $curr_month_revenue;
		$data['tot_revenue'] = $tot_revenue;
		$data['tot_receivables'] = $tot_receivables;

		$this->load->view('global/banner_info_content', $data);
	}

	function get_general_info()
	{

		$bundle_id = $_POST['bundle_id'];

		$data['bundle_id'] = $bundle_id;
		$curr_month = date('m');
		$curr_year = date('Y');

		if ($bundle_id != '3') {

			$sql1 = "SELECT COALESCE(SUM(pajak),'0') AS tot_tagihan FROM spt WHERE pajak_id='" . $bundle_id . "' and tahun_pajak = '$curr_year'";
			$sql2 = "SELECT COALESCE(SUM(pajak),'0') AS tot_terbayar FROM spt WHERE pajak_id='" . $bundle_id . "' AND status_bayar='1' and tahun_pajak = '$curr_year'";

			$tax_deposits = array();
			$j = 0;
			for ($i = 1; $i <= 12; $i++) {

				$_sql1 = $sql1 . " AND to_char(masa_pajak1,'mm')='" . sprintf('%02d', $i) . "'";
				$_sql2 = $sql2 . " AND to_char(masa_pajak1,'mm')='" . sprintf('%02d', $i) . "'";

				$row1 = $this->dao->execute(0, $_sql1)->row_array();
				$row2 = $this->dao->execute(0, $_sql2)->row_array();

				$tax_deposits[$j]['bill'] = $row1['tot_tagihan'];
				$tax_deposits[$j]['paid'] = $row2['tot_terbayar'];
				$j++;
			}

			$sql = "SELECT npwpd,nama_wp,alamat,pajak FROM v_spt WHERE pajak_id='" . $bundle_id . "' AND status_bayar='0' 
						AND to_char(masa_pajak1,'mm')='" . sprintf('%02d', $curr_month) . "' ORDER BY spt_id OFFSET 0 LIMIT 10";

			$tax_bills = $this->dao->execute(0, $sql)->result_array();

			$data['tax_deposits'] = $tax_deposits;
			$data['tax_bills'] = $tax_bills;
		} else {

			$sql = "SELECT a.tgl_pasang,a.tgl_berakhir,to_char(a.tgl_pasang,'dd-mm-yyyy') as tgl_pasang_indo,to_char(a.tgl_berakhir,'dd-mm-yyyy') as tgl_berakhir_indo,a.lokasi,
						b.*,c.jenis_reklame,a.jangka_waktu,c.satuan_jangka_waktu
						FROM spt_detil_reklame as a 
						LEFT JOIN (SELECT x.spt_id,x.tahun_pajak,y.nama as nama_wp FROM spt as x LEFT JOIN wp_wr_detil as y ON (x.wp_wr_detil_id=y.wp_wr_detil_id)) as b ON (a.spt_id=b.spt_id) 
						LEFT JOIN ref_jenis_reklame as c ON (a.jenis_reklame_id=c.ref_jenrek_id) 
						WHERE a.status='berlangsung'";

			$rows = $this->dao->execute(0, $sql)->result_array();
			$data['ads_installation_status_rows'] = $rows;
		}

		$this->load->view('global/general_info', $data);
	}
}
