<?php
date_default_timezone_set("Asia/Jakarta");

$hostname = "localhost";
$database = "siprida";
$username = "postgres";
$password = "D4t4bumi2019";
$port = "5432";
// script cek koneksi   
$link = pg_connect("host=$hostname dbname=$database user=$username password=$password port=$port");

if (!$link) {
    echo "Gagal melakukan Koneksi";
}
