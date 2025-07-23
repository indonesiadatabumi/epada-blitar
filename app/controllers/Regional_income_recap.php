<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'controllers' . DIRECTORY_SEPARATOR . 'Item_bundle_parent.php';

class regional_income_recap extends item_bundle_parent
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

        $main_data = array('bundle_row' => $this->bundle_row,);

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

        $src_params = $this->collect_input_params($_POST, 'src', false);
        $printAttr_params = $this->collect_input_params($_POST, 'printAttr', false);

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

    function show_report($type)
    {
        $search_type = $_GET['search_type'];
        $src_params = $this->collect_input_params($_GET, 'src');
        $printAttr_params = $this->collect_input_params($_GET, 'printAttr');

        $rows1 = $this->get_rows();
        $tax_year = $src_params['tahun_pajak'];

        $x_process_date = explode('-', $src_params['tgl_proses']);

        $system_params = $this->_ci->database_interactions->get_system_params();
        if ($search_type == 1) {
            $periode_report = get_monthName($x_process_date[1]) . " " . $x_process_date[2];
            $curr_week = week_in_month($x_process_date[2] . '-' . $x_process_date[1] . '-' . $x_process_date[0]);
        } else {
            $periode_report = get_monthName($src_params['tgl_proses']);
        }

        $view_folder = $this->bundle_type . '/' . __CLASS__;

        if ($type == 1 && $search_type == '1') {
            $process_date = $src_params['tgl_proses'];
            $data = array(
                'system_params' => $system_params,
                'tax_year' => $tax_year,
                'process_date' => $process_date,
                'rows1' => $rows1,
                'tax_year' => $src_params['tahun_pajak'],
                'tax_name' => $this->bundle_row['nama_paret'],
                'print_date' => $printAttr_params['print_date'],
                'process_date2' => indo_date_format($x_process_date[2] . '-' . $x_process_date[1] . '-' . $x_process_date[0], 'longDate'),
                'periode_report' => $periode_report,
                'curr_week' => $curr_week,
                'dao' => $this->dao,
            );
            $view_folder .= '/print';
        } else if ($type == 1 && $search_type == '2') {
            $process_date = $src_params['tgl_proses'];
            if ($process_date <= '9') {
                $process_date = '0' . $process_date;
            }
            $data = array(
                'system_params' => $system_params,
                'tax_year' => $tax_year,
                'process_date' => $process_date,
                'rows1' => $rows1,
                'tax_year' => $src_params['tahun_pajak'],
                'tax_name' => $this->bundle_row['nama_paret'],
                'print_date' => $printAttr_params['print_date'],
                'periode_report' => $periode_report,
                'dao' => $this->dao,
            );
            $view_folder .= '/print2';
        } else if ($type == 2 && $search_type == '1') {
            // $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', [215, 330],'orientation'=>'P']);
            $mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'mpdf']);

            $mpdf->SetMargins(10, 10, 10);
            // $data['mpdf'] = $mpdf;
            $process_date = $src_params['tgl_proses'];
            $data = array(
                'system_params' => $system_params,
                'tax_year' => $tax_year,
                'process_date' => $process_date,
                'rows1' => $rows1,
                'tax_year' => $src_params['tahun_pajak'],
                'print_date' => $printAttr_params['print_date'],
                'process_date2' => indo_date_format($x_process_date[2] . '-' . $x_process_date[1] . '-' . $x_process_date[0], 'longDate'),
                'periode_report' => $periode_report,
                'curr_week' => $curr_week,
                'dao' => $this->dao,
                'mpdf' => $mpdf
            );
            $view_folder .= '/pdf';
        } else if ($type == 2 && $search_type == '2') {
            // $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', [215, 330],'orientation'=>'P']);
            $mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'mpdf']);

            $mpdf->SetMargins(10, 10, 10);
            // $data['mpdf'] = $mpdf;
            $process_date = $src_params['tgl_proses'];
            if ($process_date <= '9') {
                $process_date = '0' . $process_date;
            }
            $data = array(
                'system_params' => $system_params,
                'tax_year' => $tax_year,
                'process_date' => $process_date,
                'rows1' => $rows1,
                'tax_year' => $src_params['tahun_pajak'],
                'print_date' => $printAttr_params['print_date'],
                'periode_report' => $periode_report,
                'dao' => $this->dao,
                'mpdf' => $mpdf
            );
            $view_folder .= '/pdf2';
        } else if ($type == 3 && $search_type == '1') {
            $process_date = $src_params['tgl_proses'];
            $data = array(
                'system_params' => $system_params,
                'tax_year' => $tax_year,
                'process_date' => $process_date,
                'rows1' => $rows1,
                'tax_year' => $src_params['tahun_pajak'],
                'tax_name' => $this->bundle_row['nama_paret'],
                'print_date' => $printAttr_params['print_date'],
                'process_date2' => indo_date_format($x_process_date[2] . '-' . $x_process_date[1] . '-' . $x_process_date[0], 'longDate'),
                'periode_report' => $periode_report,
                'curr_week' => $curr_week,
                'dao' => $this->dao,
            );
            $view_folder .= '/excel';
        } elseif ($type == 3 && $search_type == '2') {
            $process_date = $src_params['tgl_proses'];
            if ($process_date <= '9') {
                $process_date = '0' . $process_date;
            }
            $data = array(
                'system_params' => $system_params,
                'tax_year' => $tax_year,
                'process_date' => $process_date,
                'rows1' => $rows1,
                'tax_year' => $src_params['tahun_pajak'],
                'tax_name' => $this->bundle_row['nama_paret'],
                'print_date' => $printAttr_params['print_date'],
                'periode_report' => $periode_report,
                'dao' => $this->dao,
            );
            $view_folder .= '/excel2';
        }

        $this->_ci->load->view($view_folder, $data);
    }

    function get_rows()
    {
        $sql = "SELECT kelurahan_id,nama_kelurahan FROM ref_kelurahan";

        return $this->dao->execute(0, $sql)->result_array();
    }
}
