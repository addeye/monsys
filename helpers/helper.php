<?php
function tanggal_indo($tanggal, $cetak_hari = false)
{
    $hari = [1 => 'Senin',
        'Selasa',
        'Rabu',
        'Kamis',
        'Jumat',
        'Sabtu',
        'Minggu',
    ];

    $bulan = [1 => 'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember',
    ];
    $split = explode('-', $tanggal);
    $tgl_indo = $split[2] . ' ' . $bulan[(int) $split[1]] . ' ' . $split[0];

    if ($cetak_hari) {
        $num = date('N', strtotime($tanggal));
        return $hari[$num] . ', ' . $tgl_indo;
    }
    return $tgl_indo;
}
// echo tanggal_indo ('2016-03-20'); // Hasil: 20 Maret 2016;
// echo tanggal_indo ('2016-03-20', true); // Hasil: Minggu, 20 Maret 2016

function tingkat()
{
    return [
        'X', 'XI', 'XII'
    ];
}

function kompetensi()
{
    return [
        'Pengetahuan', 'Ketrampilan'
    ];
}

function jenis_kegiatan()
{
    return [
        'Materi',
        'Praktik',
        'UH',
        'Tugas',
        'Kegiatan Kesiswaan',
        'Pembahasan Soal USBN/UNBK',
    ];
}

function status_absen()
{
    return [
        'Hadir',
        'Sakit',
        'Ijin',
        'Alpha',
        'Terlambat'
    ];
}

function status_color($text)
{
    if ($text == 'Hadir') {
        return 'label-primary';
    } elseif ($text == 'Sakit') {
        return 'label-warning';
    } elseif ($text == 'Ijin') {
        return 'label-success';
    } elseif ($text == 'Alpha') {
        return 'label-danger';
    } elseif ($text == 'Telat') {
        return 'label-purple';
    }
}

function jamke()
{
    return [
        'Jam Ke-1',
        'Jam Ke-2',
        'Jam Ke-3',
        'Jam Ke-4',
        'Jam Ke-5',
        'Jam Ke-6',
        'Jam Ke-7',
        'Jam Ke-8',
        'Jam Ke-9',
        'Jam Ke-10',
    ];
}

function getFilter($data, $field, $text)
{
    $new = array_filter($data, function ($var) use ($text,$field) {
        return ($var[$field] == $text);
    });
    return $new;
}

function generateColorValue($value)
{
    $color = '#FFF';
    if ($value >= 92 && $value <= 100) {
        $color = '#74bff5';
    } elseif ($value >= 83 && $value <= 91) {
        $color = '#73e8a9';
    } elseif ($value >= 75 && $value <= 82) {
        $color = '#EFEF8E';
    } else {
        $color = '#f77777';
    }
    return $color;
}

function showArrayToStringNoKD($data)
{
    $d = [];
    if (count($data) > 0) {
        foreach ($data as $ro) {
            $d[] = $ro['no_kd'];
        }
        return implode(', ', $d);
    } else {
        return 'No KD';
    }
}

function dataColumn()
{
    return [
        'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'
    ];
}
