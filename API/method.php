<?php
require_once "koneksi.php";
if (function_exists($_GET['function'])) {
   $_GET['function']();
}

function get_diff_months($startDate, $endDate, $determination = 8)
{

   $start_timestamp = strtotime($startDate);
   $end_timestamp = strtotime($endDate);

   if ($end_timestamp > $start_timestamp) {
      //jika SPTPD maka perhitungannya per bulan
      if ($determination == 8) {
         // Assume YYYY-mm-dd - as is common MYSQL format
         $splitStart = explode('-', $startDate);
         $splitEnd = explode('-', $endDate);

         if (is_array($splitStart) && is_array($splitEnd)) {
            $startYear = $splitStart[0];
            $startMonth = $splitStart[1];
            $endYear = $splitEnd[0];
            $endMonth = $splitEnd[1];

            $difYears = $endYear - $startYear;
            $difMonth = $endMonth - $startMonth;

            if (0 == $difYears && $difMonth > 0) { // same year, dif months
               return $difMonth;
            } else if (1 == $difYears) {
               $startToEnd = 12 - $startMonth; // months remaining in start year(13 to include final month
               return ($startToEnd + $endMonth); // above + end month date
            } else if ($difYears > 1) {
               $startToEnd = 12 - $startMonth; // months remaining in start year 
               $yearsRemaing = $difYears - 1;  // minus the years of the start and the end year
               $remainingMonths = 12 * $yearsRemaing; // tally up remaining months
               $totalMonths = $startToEnd + $remainingMonths + $endMonth; // Monthsleft + full years in between + months of last year
               return $totalMonths;
            } else {
               return 0;
            }
         } else {
            return 0;
         }
      } else {
         $difference = $end_timestamp - $start_timestamp;
         $months = ceil($difference / 86400 / 30);
         return $months;
      }
   } else {
      return 0;
   }
}

function assess_fine($tax, $diff_month)
{
   $fine = ceil(0.02 * $tax * $diff_month);
   return $fine;
}

function getPayment()
{
   global $link;
   $sql = "SELECT a.*, b.tgl_jatuh_tempo, b.jenis_spt_id FROM payment.v_payment AS a 
            LEFT JOIN public.v_penyetoran_sspd AS b ON a.kode_billing=b.kode_billing 
            WHERE LENGTH(a.kode_billing)=11";
   $query = pg_query($link, $sql);
   while ($row = pg_fetch_array($query)) {
      $diff_month = get_diff_months($row['tgl_jatuh_tempo'], date('Y-m-d'), $row['jenis_spt_id']);
      $denda = assess_fine($row['pajak'], $diff_month);
      $total_bayar = $row['pajak'] + $denda;
      if ($row['tgl_jatuh_tempo'] == null) {
         $data[] = [
            'npwprd' => $row['npwprd'],
            'nama' => $row['nama'],
            'alamat' => $row['alamat'],
            'nama_pemilik' => $row['nama_pemilik'],
            'nik' => $row['no_tb'],
            'kelurahan' => $row['kelurahan'],
            'kecamatan' => $row['kecamatan'],
            'rek_bank' => $row['rek_bank'],
            'jenis_pajak' => $row['ket'],
            'kegiatan_usaha' => $row['nama_kegus'],
            'kode_rekening' => $row['kode_rekening'],
            'tahun_pajak' => $row['tahun_pajak'],
            'masa_pajak1' => $row['masa_pajak1'],
            'masa_pajak2' => $row['masa_pajak2'],
            'nilai_terkena_pajak' => $row['nilai_terkena_pajak'],
            'pajak' => $row['pajak'],
            'denda' => 0,
            'total_bayar' => $row['pajak'],
            'tgl_jatuh_tempo' => $row['tgl_jatuh_tempo'],
            'persen_tarif' => $row['persen_tarif'],
            'kode_billing' => $row['kode_billing'],
            'status_ketetapan' => $row['status_ketetapan'],
            'status_bayar' => $row['status_bayar'],
            'created_by' => $row['created_by'],
            'created_time' => $row['created_time']
         ];
      } else {
         $data[] = [
            'npwprd' => $row['npwprd'],
            'nama' => $row['nama'],
            'alamat' => $row['alamat'],
            'nama_pemilik' => $row['nama_pemilik'],
            'nik' => $row['no_tb'],
            'kelurahan' => $row['kelurahan'],
            'kecamatan' => $row['kecamatan'],
            'rek_bank' => $row['rek_bank'],
            'jenis_pajak' => $row['ket'],
            'kegiatan_usaha' => $row['nama_kegus'],
            'kode_rekening' => $row['kode_rekening'],
            'tahun_pajak' => $row['tahun_pajak'],
            'masa_pajak1' => $row['masa_pajak1'],
            'masa_pajak2' => $row['masa_pajak2'],
            'nilai_terkena_pajak' => $row['nilai_terkena_pajak'],
            'pajak' => $row['pajak'],
            'denda' => $denda,
            'total_bayar' => $total_bayar,
            'tgl_jatuh_tempo' => $row['tgl_jatuh_tempo'],
            'persen_tarif' => $row['persen_tarif'],
            'kode_billing' => $row['kode_billing'],
            'status_ketetapan' => $row['status_ketetapan'],
            'status_bayar' => $row['status_bayar'],
            'created_by' => $row['created_by'],
            'created_time' => $row['created_time']
         ];
      }
   }
   $response = array(
      'status' => 1,
      'message' => 'Success',
      'data' => $data
   );
   header('Content-Type: application/json');
   echo json_encode($response);
}
