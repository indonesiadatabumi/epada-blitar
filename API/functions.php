<?php

function inquiry_log($pesan, $level = 'INFO')
{
    $log_file = 'logs/inquiry.log';

    $timestamp = date('Y-m-d H:i:s');
    $log_entry = "[$timestamp] [$level] $pesan\n";

    file_put_contents($log_file, $log_entry, FILE_APPEND);
}

function payment_log($pesan, $level = 'INFO')
{
    $log_file = 'logs/payment.log';

    $timestamp = date('Y-m-d H:i:s');
    $log_entry = "[$timestamp] [$level] $pesan\n";

    file_put_contents($log_file, $log_entry, FILE_APPEND);
}

function reversal_log($pesan, $level = 'INFO')
{
    $log_file = 'logs/reversal.log';

    $timestamp = date('Y-m-d H:i:s');
    $log_entry = "[$timestamp] [$level] $pesan\n";

    file_put_contents($log_file, $log_entry, FILE_APPEND);
}

function get_diff_months($startDate, $endDate, $determination = 8)
{
    try {
        if (empty($startDate) || empty($endDate)) {
            throw new Exception("Tanggal tidak boleh kosong");
        }

        $start_timestamp = strtotime($startDate);
        $end_timestamp = strtotime($endDate);

        if (!$start_timestamp || !$end_timestamp) {
            throw new Exception("Format tanggal tidak valid: $startDate / $endDate");
        }

        if ($end_timestamp <= $start_timestamp) {
            return 0;
        }

        if ($determination == 8) {
            $splitStart = explode('-', $startDate);
            $splitEnd = explode('-', $endDate);

            if (count($splitStart) != 3 || count($splitEnd) != 3) {
                throw new Exception("Format tanggal tidak sesuai (YYYY-MM-DD)");
            }

            list($startYear, $startMonth) = $splitStart;
            list($endYear, $endMonth, $endDay) = $splitEnd;

            $difYears = $endYear - $startYear;
            $difMonth = $endMonth - $startMonth;

            if ($difYears == 0 && $difMonth > 0) {
                return $difMonth;
            } else if ($difYears == 0 && $difMonth == 0 && $endDay > 10) {
                return 1;
            } else if ($difYears == 1) {
                return (12 - $startMonth) + $endMonth;
            } else if ($difYears > 1) {
                return (12 - $startMonth) + (12 * ($difYears - 1)) + $endMonth;
            } else {
                return 0;
            }
        } else {
            $difference = $end_timestamp - $start_timestamp;
            $months = ceil($difference / 86400 / 30);
            return $months;
        }
    } catch (Exception $e) {
        inquiry_log("ERROR in get_diff_months: " . $e->getMessage(), "ERROR");
        return false;
    }
}

function assess_fine($tax, $diff_month)
{
    if (!is_numeric($tax) || !is_numeric($diff_month)) {
        inquiry_log("Nilai pajak atau selisih bulan tidak valid di assess_fine", "ERROR");
        return false;
    }

    return ceil(0.02 * $tax * $diff_month);
}

function assess_fine_new($tax, $diff_month)
{
    if (!is_numeric($tax) || !is_numeric($diff_month)) {
        inquiry_log("Nilai pajak atau selisih bulan tidak valid di assess_fine_new", "ERROR");
        return false;
    }

    return ceil(0.01 * $tax * $diff_month);
}
