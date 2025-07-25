<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

require_once "koneksi.php";
require_once "functions.php";

$data = json_decode(file_get_contents("php://input"));

if (!$data) {
    payment_log("Invalid JSON Body", 'ERROR');
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Invalid JSON body'
    ]);
    exit;
}
$required_fields = ['Nop', 'Merchant', 'DateTime', 'Masa', 'Tahun', 'Pokok', 'Total'];

foreach ($required_fields as $field) {
    if (empty($data->$field)) {
        payment_log("Missing field: $field. Request: " . json_encode($data), 'ERROR');
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => "Field '$field' wajib diisi"
        ]);
        exit;
    }
}

$kode_billing =  $data->Nop;
$merchant_channel =  $data->Merchant;
$date_time =  $data->DateTime;
$masa =   $data->Masa;
$tahun =  $data->Tahun;
$pokok =  $data->Pokok;
$denda =  $data->Denda;
$total =  $data->Total;
$curr_time = date('Y-m-d H:i:s');


$sql = "SELECT a.*, b.kompensasi, c.hrg_0_50 FROM payment.v_payment AS a
        LEFT JOIN public.spt AS b ON a.kode_billing=b.kode_billing
        LEFT JOIN public.spt_detil_abt AS c ON a.spt_id=c.spt_id
        WHERE a.kode_billing='" . $kode_billing . "'";
$query = pg_query($link, $sql);

if (!$query) {
    payment_log("Sql cek data tagihan error: " . pg_last_error($link), 'ERROR');
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Sql cek data tagihan error'
    ]);
    exit;
}

$row = pg_fetch_array($query);

$pokok_pajak  = round($row['pajak']);
$nilai_terkena_pajak  = round($row['nilai_terkena_pajak']);
$status_bayar = $row['status_bayar'];
$kd_booking      = $row['kode_billing'];
$nama      = $row['nama'];
$kode_rekening = $row['kode_rekening'];
$alamat      = $row['alamat'];
$masa_pajak      = $row['masa_pajak1'];
$tahun_pajak  = $row['tahun_pajak'];


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

if ($status_bayar == '1') {
    // insert log payment teller
    $sql = "INSERT INTO log_payment_teller(kode_billing,merchant_channel,date_time,masa,tahun,pokok,denda,total,messages)
                VALUES('$kode_billing','$merchant_channel','$curr_time','$masa','$tahun',$pokok,$denda,$total,'DATA TAGIHAN TELAH LUNAS')";
    $result = pg_query($link, $sql);

    payment_log("Response: DATA TAGIHAN TELAH LUNAS. Received: " . json_encode($data), 'ERROR');
    $response_code    = "13";
    $message        = "DATA TAGIHAN TELAH LUNAS";
} elseif (empty($kd_booking)) {
    // insert log payment teller
    $sql = "INSERT INTO log_payment_teller(kode_billing,merchant_channel,date_time,masa,tahun,pokok,denda,total,messages)
                VALUES('$kode_billing','$merchant_channel','$curr_time','$masa','$tahun',$pokok,$denda,$total,'DATA TAGIHAN TIDAK DITEMUKAN')";
    $result = pg_query($link, $sql);

    payment_log("Response: DATA TAGIHAN TIDAK DITEMUKAN. Received: " . json_encode($data), 'ERROR');
    $response_code    = "10";
    $message        = "DATA TAGIHAN TIDAK DITEMUKAN";
} elseif ($pokok_pajak != $pokok) {
    // insert log payment teller
    $sql = "INSERT INTO log_payment_teller(kode_billing,merchant_channel,date_time,masa,tahun,pokok,denda,total,messages)
                VALUES('$kode_billing','$merchant_channel','$curr_time','$masa','$tahun',$pokok,$denda,$total,'JUMLAH TAGIHAN YANG DIBAYARKAN TIDAK SESUAI')";
    $result = pg_query($link, $sql);

    payment_log("Response: JUMLAH TAGIHAN YANG DIBAYARKAN TIDAK SESUAI. Received: " . json_encode($data), 'ERROR');
    $response_code    = "14";
    $message        = "JUMLAH TAGIHAN YANG DIBAYARKAN TIDAK SESUAI";
} else {

    $sql = "SELECT a.*, b.rekening_id, c.tgl_jatuh_tempo FROM payment.v_payment AS a 
            LEFT JOIN (SELECT rekening_id, kode_rekening, jenis_rekening FROM v_rekening) AS b ON a.kode_rekening=b.kode_rekening AND jenis_rekening='A' 
            LEFT JOIN (SELECT tgl_jatuh_tempo, kode_billing FROM v_penyetoran_sspd) AS c ON a.kode_billing=c.kode_billing 
            WHERE a.kode_billing='" . $kode_billing . "'";
    $query = pg_query($link, $sql);

    if (!$query) {
        payment_log("Sql cek data tagihan error: " . pg_last_error($link), 'ERROR');
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Sql cek data tagihan error'
        ]);
        exit;
    }

    $row2 = pg_fetch_array($query);
    $spt_id = $row2['spt_id'];
    $pajak_id = $row2['pajak_id'];
    $wp_wr_id = $row2['wp_wr_id'];
    $wp_wr_detil_id = $row2['wp_wr_detil_id'];
    $npwprd = $row2['npwprd'];
    $jenis_spt_id = $row2['jenis_spt_id'];
    $loket_pembayaran = 2;
    $rekening_id = $row2['rekening_id'];
    $kode_sts = "0001/XI/STS/2022";
    $kode_billing = $row2['kode_billing'];
    $tahun_pajak = $row2['tahun_pajak'];
    $masa_pajak1 = $row2['masa_pajak1'];
    $masa_pajak2 = $row2['masa_pajak2'];
    // $tgl_jatuh_tempo = $row2['tgl_jatuh_tempo'];
    $created_by = "Bank Jatim";
    $masa_lapor = date('Y-m-d', strtotime("+1 months", strtotime($masa_pajak1)));

    if (date('m', strtotime($masa_lapor)) == '02') {
        $tgl_jatuh_tempo = date('Y-m-28', strtotime($masa_lapor));
    } else {
        $tgl_jatuh_tempo = date('Y-m-30', strtotime($masa_lapor));
    }

    // if (date('Y', strtotime($masa_pajak1)) <= '2023' && date('m', strtotime($masa_pajak1)) <= '12') {
    //     if (date('m', strtotime($masa_lapor)) == '02') {
    //         $tgl_jatuh_tempo = date('Y-m-28', strtotime($masa_lapor));
    //     } else {
    //         $tgl_jatuh_tempo = date('Y-m-30', strtotime($masa_lapor));
    //     }
    // } else {
    //     $tgl_jatuh_tempo = date('Y-m-10', strtotime($masa_lapor));
    // }

    $sql = "select max(transaksi_id)+1 as newid from transaksi_pajak";

    $get_transaksi_id = pg_query($link, $sql);
    $transaksi_id = pg_fetch_array($get_transaksi_id);

    $newid = $transaksi_id['newid'];
    if ($newid == null) {
        $newid = 1;
    }

    $transaksi_detil_id = $transaksi_detil_id['transaksi_detil_id'];
    if ($transaksi_detil_id == null) {
        $transaksi_detil_id = 1;
    }

    $sql = "select max(no_transaksi)+1 as no_transaksi from transaksi_pajak where pajak_id = '" . $pajak_id . "'";

    $get_no_transaksi = pg_query($link, $sql);
    $no_transaksi = pg_fetch_array($get_no_transaksi);

    $no_tranksaksi = $no_transaksi['no_transaksi'];
    if ($no_tranksaksi == null) {
        $no_tranksaksi = 1;
    }

    $curr_year = date('Y');
    $curr_month = date('m');
    $curr_date = date('Y-m-d');

    $sql = "SELECT MAX(no_sts) as last_numb FROM transaksi_pajak 
					WHERE tahun_pajak='" . $curr_year . "' AND to_char(tgl_bayar,'mm')='" . $curr_month . "'";

    $get_no_sts = pg_query($link, $sql);
    //if(!$get_no_sts) die($db->ErrorMsg());
    $no_sts = pg_fetch_array($get_no_sts);

    $last_numb = $no_sts['last_numb'];
    if ($last_numb == null) {
        $last_numb = 1;
    }

    // Mulai transaksi
    pg_query($link, "BEGIN");

    try {
        //insert transaksi_pajak
        $sql = "INSERT INTO transaksi_pajak(transaksi_id,spt_id,pajak_id,wp_wr_id,wp_wr_detil_id,npwprd,jenis_spt_id,loket_pembayaran_id,rekening_id,no_transaksi,
                        no_sts,kode_sts,kode_billing,tahun_pajak,masa_pajak1,masa_pajak2,pokok_pajak,denda,total_bayar,tgl_bayar,tgl_jatuh_tempo,created_by,created_time,no_urut_sts)
                VALUES($newid,$spt_id,$pajak_id,$wp_wr_id,$wp_wr_detil_id,'$npwprd',$jenis_spt_id, $loket_pembayaran,'$rekening_id',$no_tranksaksi,$last_numb,
                        '$kode_sts','$kode_billing',$tahun_pajak,'$masa_pajak1','$masa_pajak2',$pokok_pajak,$denda,$total,'$curr_date','$tgl_jatuh_tempo','$created_by','$curr_time','$merchant_channel')";
        $result = pg_query($link, $sql);
        if (!$result) {
            throw new Exception("Gagal insert transaksi_pajak: " . pg_last_error($link));
        }

        //insert transaksi_pajak_detil
        $sql = "INSERT INTO transaksi_pajak_detil(transaksi_id,rekening_id,tahun_pajak,jumlah_pajak,tgl_bayar)
                VALUES($newid,'$rekening_id',$tahun_pajak,$pokok_pajak,'$curr_date')";
        $result = pg_query($link, $sql);
        if (!$result) {
            throw new Exception("Gagal insert transaksi_pajak_detil pokok: " . pg_last_error($link));
        }

        if ($denda != 0 || $denda != null) {
            $sql = "SELECT rekening_id FROM v_rekening AS a 
            WHERE pajak_id='" . $pajak_id . "' AND  jenis_rekening='B'";
            $query = pg_query($link, $sql);
            if (!$query) {
                throw new Exception("Gagal select rekening denda: " . pg_last_error($link));
            }

            $row3 = pg_fetch_array($query);
            $rekening_id_denda = $row3['rekening_id'];

            //insert transaksi_pajak_detil
            $sql2 = "INSERT INTO transaksi_pajak_detil(transaksi_id,rekening_id,tahun_pajak,jumlah_pajak,tgl_bayar)VALUES($newid,'$rekening_id_denda',$tahun_pajak,$denda,'$curr_date')";
            $result = pg_query($link, $sql2);
            if (!$result) {
                throw new Exception("Gagal insert transaksi_pajak_detil denda: " . pg_last_error($link));
            }
        }

        if ($row2['jenis_spt_id'] == 1 || $row2['jenis_spt_id'] == 8) {
            $sql = "UPDATE spt SET status_bayar='1' WHERE kode_billing='$kode_billing'";
        } else {
            $sql = "UPDATE laporan_hasil_pemeriksaan SET status_bayar='1' WHERE kode_billing='$kode_billing'";
        }
        $result = pg_query($link, $sql);
        if (!$result) {
            throw new Exception("Gagal update status bayar: " . pg_last_error($link));
        }

        // Commit transaksi jika semua berhasil
        pg_query($link, "COMMIT");
    } catch (Exception $e) {
        // Rollback transaksi jika terjadi error
        pg_query($link, "ROLLBACK");
        payment_log("Terjadi kesalahan insert data: " . $e->getMessage(), 'ERROR');
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Terjadi kesalahan insert data'
        ]);
        exit;
    }

    // insert log payment teller
    $sql = "INSERT INTO log_payment_teller(kode_billing,merchant_channel,date_time,masa,tahun,pokok,denda,total,messages)
                VALUES('$kode_billing','$merchant_channel','$curr_time','$masa','$tahun',$pokok,$denda,$total,'Success')";
    $result = pg_query($link, $sql);

    payment_log("Response: Success. Received: " . json_encode($data), 'INFO');
    $response_code    = "00";
    $message        = "Success";

    $nama_wp        = $nama;
    $alamat        = trim($alamat);
    $masa_pajak        = $masa_pajak;
    $tahun_pajak    = $tahun_pajak;
    $pokok_pajak    = $pokok_pajak;
    $jumlah_bayar   = $pokok_pajak + $denda;
}



$transaction_id = date("YmdHis") . rand("1000", "9999");
$remote_addr    = $_SERVER['REMOTE_ADDR'];

if (empty($response_code)) $response_code = '00';

$arr_stat = array();
$arr_stat['IsError'] = "False";
$arr_stat['ResponseCode'] = $response_code;
$arr_stat['ErrorDesc'] = $message;

if ($response_code == '00') {
    $array_rest = [
        'Nop' => $kd_booking,
        'Masa' => $masa_pajak,
        'Tahun' => $tahun_pajak,
        'JatuhTempo'  => $tgl_jatuh_tempo,
        'KodeRek' => $kode_rekening,
        'Pokok' => $pokok_pajak,
        'Denda'  => $denda,
        'Total' => $jumlah_bayar,
        'Pengesahan' => $transaction_id,
        'Status' => $arr_stat
    ];
} else {
    $array_rest = ['Status' => $arr_stat];
}

echo json_encode($array_rest, JSON_UNESCAPED_SLASHES);
