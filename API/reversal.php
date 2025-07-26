<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

require_once "koneksi.php";
require_once "functions.php";

$data = json_decode(file_get_contents("php://input"));

if (empty($_GET['kode_billing'])) {
    reversal_log("Response: Bad Request. Request: " . json_encode($_GET), 'ERROR');
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Bad Request'
    ]);
    exit;
}

$kode_billing =  $_GET['kode_billing'];

$sql = "SELECT * FROM transaksi_pajak
        WHERE kode_billing='" . $kode_billing . "'";
$query = pg_query($link, $sql);

if (!$query) {
    reversal_log("Sql cek data transaksi error: " . pg_last_error($link), 'ERROR');
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Sql cek data transaksi error'
    ]);
    exit;
}

$row = pg_fetch_array($query);

if (!$row) {
    reversal_log("Response: DATA TAGIHAN TIDAK DITEMUKAN. Received: " . json_encode($_GET), 'ERROR');
    $response_code    = "10";
    $message        = "DATA TAGIHAN TIDAK DITEMUKAN";
} else {
    $transaksi_id  = $row['transaksi_id'];

    //hapus tabel transaksi_pajak
    $sql = "DELETE FROM transaksi_pajak WHERE transaksi_id = $transaksi_id";
    $result = pg_query($link, $sql);

    //hapus tabel transaksi_pajak_detil
    $sql = "DELETE FROM transaksi_pajak_detil WHERE transaksi_id = $transaksi_id";
    $result = pg_query($link, $sql);

    //unflag tabel spt
    $sql = "UPDATE spt SET status_bayar='0' WHERE kode_billing='$kode_billing'";
    $result = pg_query($link, $sql);

    reversal_log("Response: Success. Received: " . json_encode($_GET), 'INFO');
    $response_code    = "00";
    $message        = "Success";
}

$arr_stat = array();
$arr_stat['IsError'] = "False";
$arr_stat['ResponseCode'] = $response_code;
$arr_stat['ErrorDesc'] = $message;

$array_rest = ['Status' => $arr_stat];

teller_log('REVERSAL', $_SERVER['REQUEST_METHOD'], $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT'], json_encode($_GET), json_encode($array_rest), $response_code, date('Y-m-d H:i:s'));
echo json_encode($array_rest, JSON_UNESCAPED_SLASHES);
