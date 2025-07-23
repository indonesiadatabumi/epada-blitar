<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'controllers' . DIRECTORY_SEPARATOR . 'Item_bundle_parent.php';

class print_stpd_list extends item_bundle_parent
{


    function __construct($bundle_type, $bundle_item_type, $menu)
    {

        //bundle_type => taxes,duties
        //bundle_item_type => hotel,restaurant,entertainment,etc
        //menu => record_taxpayer1,record_taxpayer2,etc			
        parent::__construct($bundle_type, $bundle_item_type, $menu, __CLASS__);
    }


    function index()
    {
        $this->_ci->admin_access_handler->check_access();

        $district_rows = $this->_ci->database_interactions->get_district_rows();
        $sql = "SELECT a.pejda_id,a.nama,b.nama_jabatan FROM pejabat_daerah as a 
					LEFT JOIN ref_jabatan_pejabat_daerah as b ON (a.japeda_id=b.ref_japeda_id)";

        $official_rows = $this->dao->execute(0, $sql)->result_array();


        $main_data = array(
            'bundle_row' => $this->bundle_row,
            'district_rows' => $district_rows,
            'official_rows' => $official_rows,
        );

        // no need to modified
        $data = array(
            'menu_params' => $this->menu_params,
            'main_params' => array_merge($this->main_params, $main_data)
        );

        $this->_ci->public_template->render($this->view_folder . '/index', $data);
    }

    function report_controller()
    {

        $menu = $_POST['menu'];
        $search_type = $_POST['search_type'];
        $report_type = $_POST['report_type'];

        $src_params = $this->collect_input_params($_POST, 'src' . $search_type, false);
        $printAttr_params = $this->collect_input_params($_POST, 'printAttr' . $search_type, false);

        $urlstring_params = $this->generate_urlstring_params(array_merge($src_params, $printAttr_params));
        $method = "";

        switch ($report_type) {
            case '1':
                $method = "_print";
                break;
            case '2':
                $method = "pdf";
                break;
            case '3':
                $method = "excel";
                break;
        }

        $this->menu = $menu;

        $urlstring_params .= (!empty($urlstring_params) ? "&" : "?") . "search_type=" . $search_type;

        echo "<script type='text/javascript'>

				window.open('" . base_url() . "bundle/" . $this->bundle_type . "/" . $this->bundle_item_type . "/" . $menu . "/" . $method . $urlstring_params . "');

			</script>";
    }

    function _print()
    {

        $this->show_report(1);
    }

    function pdf()
    {

        $this->show_report(2);
    }

    function excel()
    {
        $this->show_report(3);
    }

    function show_report($report_type)
    {

        $search_type = $_GET['search_type'];
        $src_params = $this->collect_input_params($_GET, 'src' . $search_type);
        $printAttr_params = $this->collect_input_params($_GET, 'printAttr' . $search_type);

        $sql = "SELECT a.nama,a.nip,b.pangkat,c.nama_jabatan FROM pejabat_daerah as a 
					LEFT JOIN ref_gol_ruang as b ON (a.goru_id=b.ref_goru_id) 
					LEFT JOIN ref_jabatan_pejabat_daerah as c ON (a.japeda_id=c.ref_japeda_id)";

        $legalitator_row = array();
        $evaluator_row = array();

        if (isset($printAttr_params['legalitator'])) {
            $cond = " WHERE pejda_id='" . $printAttr_params['legalitator'] . "'";
            $_sql = $sql . $cond;
            $legalitator_row = $this->dao->execute(0, $_sql)->row_array();
        }

        if (isset($printAttr_params['evaluator'])) {
            $cond = " WHERE pejda_id='" . $printAttr_params['evaluator'] . "'";
            $_sql = $sql . $cond;
            $evaluator_row = $this->dao->execute(0, $_sql)->row_array();
        }

        $rows = $this->get_rows($src_params);

        $system_params = $this->_ci->database_interactions->get_system_params();

        $district_row = array();
        if (isset($src_params['kecamatan_id'])) {
            $district_row = $this->dao->execute(0, "SELECT nama_kecamatan FROM ref_kecamatan WHERE kecamatan_id='" . $src_params['kecamatan_id'] . "'")->row_array();
        }

        if ($search_type == '1') {
            $header_attr = array(
                'tax_year' => (isset($src_params['tahun_pajak']) ? $src_params['tahun_pajak'] : date('Y')),
                'tax_period' => $src_params['masa_pajak']
            );
        } else {
            $date_period = "";

            if (isset($src_params['tgl_proses_awal']) && isset($src_params['tgl_proses_akhir'])) {
                $date_period = "Periode Tanggal " . mix_2Date(us_date_format($src_params['tgl_proses_awal']), us_date_format($src_params['tgl_proses_akhir']));
            } else if (isset($src_params['tgl_proses_awal'])) {
                $date_period = "Periode Tanggal " . mix_2Date(us_date_format($src_params['tgl_proses_awal']), date('Y-m-d'));
            } else if (isset($src_params['tgl_proses_akhir'])) {
                $date_period = "S.D Tanggal " . indo_date_format(us_date_format($src_params['tgl_proses_akhir']), 'longDate');
            }

            if (isset($src_params['kecamatan_id'])) {
                $district = "Kecamatan : " . $district_row['nama_kecamatan'];
            } else {
                $district = "";
            }

            $header_attr = array('date_period' => $date_period, 'district' => $district);
        }

        $data = array(
            'rows' => $rows,
            'print_date' => us_date_format($printAttr_params['print_date']),
            'system_params' => $system_params,
            'tax_name' => $this->bundle_row['nama_paret'],
            'legalitator_row' => $legalitator_row,
            'evaluator_row' => $evaluator_row,
            'search_type' => $search_type,
            'header_attr' => $header_attr,
            'district_row' => $district_row,
        );
        $view_folder = $this->bundle_type . '/' . __CLASS__;

        if ($report_type == 1) {
            $view_folder .= '/print';
        } else if ($report_type == 2) {
            $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', [215, 330], 'orientation' => 'L']);
            $data['mpdf'] = $mpdf;
            $view_folder .= '/pdf';
        } else {
            $view_folder .= '/excel';
        }

        $this->_ci->load->view($view_folder, $data);
    }


    function get_rows($src_params)
    {

        $res = __CLASS__ . '_resources';
        require_once APPPATH . 'libraries' . DIRECTORY_SEPARATOR . 'system_resources' . DIRECTORY_SEPARATOR . $res . '.php';

        $tbl_name = $res::$_TBL_NAME;
        $pk = $res::$_PK;
        $sql = $res::$_SQL_LIST;

        $cond = " a.pajak_id='" . $this->bundle_id . "'";

        if (isset($src_params['kecamatan_id'])) {
            $cond .= " AND a.kecamatan_id='" . $src_params['kecamatan_id'] . "'";
        }

        if (isset($src_params['status'])) {

            if ($src_params['status'] != '2') {

                $tax_year = (isset($src_params['tahun_pajak']) ? $src_params['tahun_pajak'] : date('Y'));
                $cond .= " AND ((EXTRACT(MONTH FROM masa_pajak1)='" . $src_params['masa_pajak'] . "' AND tahun_pajak='" . $tax_year . "')";

                if ($src_params['status'] == '3') {
                    $cond .= " OR spt_id IS NULL";
                } else {
                    $cond .= " AND spt_id IS NOT NULL";
                }

                $cond .= ")";
            } else {
                $cond .= " AND spt_id IS NULL";
            }
        } else {
            $cond .= " AND spt_id IS NOT NULL";
        }

        if (isset($src_params['tgl_proses_awal']) && isset($src_params['tgl_proses_akhir'])) {
            $cond .= " AND tgl_proses BETWEEN '" . us_date_format($src_params['tgl_proses_awal']) . "' AND '" . us_date_format($src_params['tgl_proses_akhir']) . "'";
        } else if (isset($src_params['tgl_proses_awal'])) {
            $cond .= " AND tgl_proses >= '" . us_date_format($src_params['tgl_proses_awal']) . "'";
        } else if (isset($src_params['tgl_proses_akhir'])) {
            $cond .= " AND tgl_proses <= '" . us_date_format($src_params['tgl_proses_akhir']) . "'";
        }

        $sql .= " WHERE " . $cond;

        return $this->dao->execute(0, $sql)->result_array();
    }
}
