<?php
function convertMonth($checker, $month)
{
    $convert = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember'
    ];

    $month = $convert[$month];

    if ($checker = 1) {
        return $month;
    } else if ($checker = 2) {
        return substr($month, 0, 3);
    }
}

function convertMonth2($checker, $month)
{
    $convert = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember'
    ];

    $month = $convert[$month];

    if ($checker = 1) {
        return $month;
    } else if ($checker = 2) {
        return substr($month, 0, 3);
    }
}
