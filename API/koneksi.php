<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING); // sembunyikan notice dan warning
ini_set("display_errors", 0); // jangan tampilkan error ke browser

date_default_timezone_set("Asia/Jakarta");

require_once 'functions.php';

$hostname = "localhost";
$database = "e-pada";
$username = "postgres";
$password = "admin";
$port = "5432";
// script cek koneksi   
$link = pg_connect("host=$hostname dbname=$database user=$username password=$password port=$port");

if (!$link) {
    inquiry_log("Koneksi ke database gagal: " . pg_last_error(), 'ERROR');
    http_response_code(500);
    echo json_encode(array("success" => false, "message" => "Koneksi ke database gagal"));
    exit;
}
