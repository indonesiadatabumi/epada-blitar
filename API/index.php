<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

require_once "koneksi.php";
require_once "functions.php";

if (function_exists($_GET['function'])) {
    $_GET['function']();
}

$data = json_decode(file_get_contents("php://input"));

$kode_billing =  $_GET['Nop'];
$merchant_channel =  $_GET['Merchant'];
$bank_id    = '01';
$KodeRek = '4110200';

$sql = "SELECT a.*, b.jenis_spt_id, b.jenis_ketetapan, b.tgl_jatuh_tempo, c.kompensasi, d.hrg_0_50 FROM payment.v_payment AS a 
        LEFT JOIN public.v_penyetoran_sspd AS b ON a.kode_billing=b.kode_billing
        LEFT JOIN public.spt AS c ON a.kode_billing=c.kode_billing
        LEFT JOIN public.spt_detil_abt AS d ON a.spt_id=d.spt_id
        WHERE a.kode_billing='" . $kode_billing . "'";
$query = pg_query($link, $sql);
$row = pg_fetch_array($query);

if (!$row) {
    $response_code    = "10";
    $message        = "DATA TAGIHAN TIDAK DITEMUKAN";
} else {
    if ($row['status_bayar'] == '1') {
        $response_code    = "13";
        $message        = "DATA TAGIHAN TELAH LUNAS";
    } else {
        $pokok_pajak  = round($row['pajak']);
        $nilai_terkena_pajak  = round($row['nilai_terkena_pajak']);
        $status_bayar = $row['status_bayar'];
        $kd_booking      = $row['kode_billing'];
        $wp_wr_id = $row['wp_wr_id'];
        $npwprd = $row['npwprd'];
        $nama      = $row['nama'];
        $alamat = preg_replace("/[^a-zA-Z0-9]/", " ", $row['alamat']);
        $nama_pemilik = $row['nama_pemilik'];
        $nik = $row['no_tb'];
        $kelurahan = $row['kelurahan'];
        $kecamatan = $row['kecamatan'];
        $rek_bank = $row['rek_bank'];
        $jenis_pajak = $row['ket'];
        $kegiatan_usaha = $row['nama_kegus'];
        $kode_rekening = $row['kode_rekening'];
        $tahun_pajak = $row['tahun_pajak'];
        $masa_pajak1 = $row['masa_pajak1'];
        $masa_pajak2 = $row['masa_pajak2'];
        $persen_tarif = $row['persen_tarif'];
        $status_ketetapan = $row['status_ketetapan'];
        $created_by = $row['created_by'];
        $created_time = $row['created_time'];

        if ($row['pajak_id'] == '7') {
            if ($row['hrg_0_50'] == null) {
                if ($row['wp_wr_id'] == '40') {
                    $pengurangan_pat = (97 / 100) * $pokok_pajak;
                    $pokok_pajak = (int) $pokok_pajak - (int) $row['kompensasi'] - $pengurangan_pat;
                } else {
                    $pengurangan_pat = (55 / 100) * $pokok_pajak;
                    $pokok_pajak = (int) $pokok_pajak - (int) $row['kompensasi'] - $pengurangan_pat;
                }
            } else {
                $pokok_pajak = (int) $pokok_pajak;
            }
        } else {
            $pokok_pajak = (int) $pokok_pajak - (int) $row['kompensasi'];
        }
        $masa_lapor = date('Y-m-d', strtotime("+1 months", strtotime($masa_pajak1)));

        if ($row['nama_kegus'] == 'Jasa Boga / Katering dan Sejenisnya') {
            if (date('m', strtotime($masa_lapor)) == '02') {
                $jatuh_tempo = date('Y-m-28', strtotime($masa_lapor));
            } else {
                $jatuh_tempo = date('Y-m-30', strtotime($masa_lapor));
            }
            $get_denda = 0;
            $sanksi_lapor = 0;
            $total_bayar = $pokok_pajak + $get_denda + $sanksi_lapor;
        } else {

            if ($row['jenis_ketetapan'] == 'LHP' || $row['ket'] == 'PAJAK AIR TANAH') {
                $jatuh_tempo = $row['tgl_jatuh_tempo'];
            } else {
                if (date('m', strtotime($masa_lapor)) == '02') {
                    $jatuh_tempo = date('Y-m-28', strtotime($masa_lapor));
                } else {
                    $jatuh_tempo = date('Y-m-30', strtotime($masa_lapor));
                }
            }
            $diff_month = get_diff_months($jatuh_tempo, date('Y-m-d'), $row['jenis_spt_id']);
            if ($row['pajak_id'] == '6') {
                $get_denda = assess_fine($pokok_pajak, $diff_month);
            } else {
                $get_denda = assess_fine_new($pokok_pajak, $diff_month);
            }


            $sanksi_lapor = 0;
            $total_bayar = $pokok_pajak + $get_denda + $sanksi_lapor;
        }

        // if ($row['nama_kegus'] == 'Jasa Boga / Katering dan Sejenisnya') {
        //     if (date('m', strtotime($masa_lapor)) == '02') {
        //         $jatuh_tempo = date('Y-m-28', strtotime($masa_lapor));
        //     } else {
        //         $jatuh_tempo = date('Y-m-30', strtotime($masa_lapor));
        //     }
        //     $get_denda = 0;
        //     $sanksi_lapor = 0;
        //     $total_bayar = $pokok_pajak + $get_denda + $sanksi_lapor;
        // } else {

        //     if (date('Y', strtotime($masa_pajak1)) <= '2023' && date('m', strtotime($masa_pajak1)) <= '12') {
        //         if (date('m', strtotime($masa_lapor)) == '02') {
        //             $jatuh_tempo = date('Y-m-28', strtotime($masa_lapor));
        //         } else {
        //             $jatuh_tempo = date('Y-m-30', strtotime($masa_lapor));
        //         }
        //         $diff_month = get_diff_months($jatuh_tempo, date('Y-m-d'), $row['jenis_spt_id']);
        //         $get_denda = assess_fine($pokok_pajak, $diff_month);
        //         $sanksi_lapor = 0;
        //         $total_bayar = $pokok_pajak + $get_denda + $sanksi_lapor;
        //     } else {
        //         $jatuh_tempo = date('Y-m-10', strtotime($masa_lapor));
        //         $diff_month = get_diff_months($jatuh_tempo, date('Y-m-d'), $row['jenis_spt_id']);
        //         $get_denda = assess_fine_new($pokok_pajak, $diff_month);
        //         $masa_kemarin = date('Y-m-d', strtotime("-1 months", strtotime($masa_pajak1)));
        //         // cek tgl lapor pajak bulan kemarin
        //         $sql = "SELECT tgl_proses FROM payment.v_payment WHERE masa_pajak1 = '$masa_kemarin' AND wp_wr_id = '$wp_wr_id'";
        //         $query = pg_query($link, $sql);
        //         $cek_lapor_pajak = pg_fetch_array($query);

        //         $tgl_lapor_lalu = date('d', strtotime($cek_lapor_pajak['tgl_proses']));

        //         if ($tgl_lapor_lalu == null || $tgl_lapor_lalu > '15') {
        //             $sanksi_lapor = 100000;
        //         } else {
        //             $sanksi_lapor = 0;
        //         }
        //         $total_bayar = $pokok_pajak + $get_denda + $sanksi_lapor;
        //     }
        // }

        $transaction_id = date("YmdHis") . rand("1000", "9999");

        $response_code    = "00";
        $message        = "Success";
    }
}

$arr_stat = array();
$arr_stat['IsError'] = "False";
$arr_stat['ResponseCode'] = $response_code;
$arr_stat['ErrorDesc'] = $message;

if ($response_code == '00') {
    $array_rest = [
        'Nop' => $kd_booking,
        'Npwprd' => $npwprd,
        'Nama'  => $nama,
        'Alamat' => $alamat,
        'Nama Pemilik' => $nama_pemilik,
        'NIK' => $nik,
        'Kelurahan' => $kelurahan,
        'Kecamatan' => $kecamatan,
        'Rek bank' => $rek_bank,
        'Jenis Pajak' => $jenis_pajak,
        'Kegiatan Usaha' => $kegiatan_usaha,
        'Kode Rekening' => $kode_rekening,
        'Masa Pajak1' => $masa_pajak1,
        'Masa Pajak2' => $masa_pajak2,
        'Tahun' => $tahun_pajak,
        'NoSk' => $transaction_id,
        'JatuhTempo'  => $jatuh_tempo,
        'KodeRek' => $KodeRek,
        'Pokok' => $pokok_pajak,
        'Denda'  => $get_denda,
        'Sanksi Lapor'  => $sanksi_lapor,
        'Total' => $total_bayar,
        'Tarif Persen' => $persen_tarif,
        'Status Ketetapan' => $status_ketetapan,
        'Status Bayar' => $status_bayar,
        'Created By' => $created_by,
        'Created Time' => $created_time,
        'Status' => $arr_stat
    ];
} else {
    $array_rest = ['Status' => $arr_stat];
}

echo json_encode($array_rest, JSON_UNESCAPED_SLASHES);
