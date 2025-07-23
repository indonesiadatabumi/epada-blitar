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

$kode_billing =  $_GET['kode_billing'];

$sql = "SELECT * FROM transaksi_pajak
        WHERE kode_billing='" . $kode_billing . "'";
$query = pg_query($link, $sql);
$row = pg_fetch_array($query);

if (!$row) {
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

    $response_code    = "00";
    $message        = "Success";
}

$arr_stat = array();
$arr_stat['IsError'] = "False";
$arr_stat['ResponseCode'] = $response_code;
$arr_stat['ErrorDesc'] = $message;

$array_rest = ['Status' => $arr_stat];

echo json_encode($array_rest, JSON_UNESCAPED_SLASHES);
