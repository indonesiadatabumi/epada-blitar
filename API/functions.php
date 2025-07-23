<?php

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
                $endDay = $splitEnd[2];

                // $tgl1 = new DateTime($startDate);
                // $tgl2 = new DateTime($endDate);
                // $jarak = $tgl2->diff($tgl1);

                // if ($jarak->m > 0) {
                //     if ($startMonth != 12) {
                //         $startMonth = $startMonth + 1;
                //     } else {
                //         $startMonth = 1;
                //         $startYear = $startYear + 1;
                //     }
                // }

                $difYears = $endYear - $startYear;
                $difMonth = $endMonth - $startMonth;

                if (0 == $difYears && $difMonth > 0) { // same year, dif months
                    return $difMonth;
                } else if (0 == $difYears && $difMonth == 0 && $endDay > 10) {
                    $difMonth = 1;
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

function assess_fine_new($tax, $diff_month)
{
    $fine = ceil(0.01 * $tax * $diff_month);
    return $fine;
}
