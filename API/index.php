<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

require_once "koneksi.php";
require_once "functions.php";

$data = json_decode(file_get_contents("php://input"));

if (empty($_GET['Nop']) || empty($_GET['Merchant'])) {
    log_error("Response: Bad Request. Request: " . json_encode($_GET), 'ERROR');
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Bad Request'
    ]);
    exit;
}

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

if (!$query) {
    log_error("Sql cek data tagihan error: " . pg_last_error($link), 'ERROR');
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Sql cek data tagihan error'
    ]);
    exit;
}

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

            // Hitung denda
            $diff_month = get_diff_months($jatuh_tempo, date('Y-m-d'), $row['jenis_spt_id']);

            if ($diff_month === false) {
                http_response_code(500);
                echo json_encode(array("success" => false, "message" => "Tanggal jatuh tempo tidak valid"));
                exit;
            }

            if ($row['pajak_id'] == '6') {
                $get_denda = assess_fine($pokok_pajak, $diff_month);

                if ($get_denda === false) {
                    http_response_code(500);
                    echo json_encode(array("success" => false, "message" => "Denda tidak valid"));
                    exit;
                }
            } else {
                $get_denda = assess_fine_new($pokok_pajak, $diff_month);

                if ($get_denda === false) {
                    http_response_code(500);
                    echo json_encode(array("success" => false, "message" => "Denda tidak valid"));
                    exit;
                }
            }


            $sanksi_lapor = 0;
            $total_bayar = $pokok_pajak + $get_denda + $sanksi_lapor;
        }

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

teller_log('INQUIRY', $_SERVER['REQUEST_METHOD'], $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT'], json_encode($_GET), json_encode($array_rest), $response_code, date('Y-m-d H:i:s'));
echo json_encode($array_rest, JSON_UNESCAPED_SLASHES);
