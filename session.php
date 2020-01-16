<?php
/**
 * Created by PhpStorm.
 * User: deyelovi
 * Date: 05/04/2016
 * Time: 17:02
 */
session_start();
date_default_timezone_set('Asia/Jakarta');
spl_autoload_register(function ($class) {
    include 'class/' . $class . '.php';
});

if (!function_exists('kelas')) {
    function kelas()
    {
        return [
            'X', 'XI', 'XII'
        ];
    }
}

if (!function_exists('success')) {
    function success($text = null)
    {
        if ($text) {
            $_SESSION['success'] = $text;
        } else {
            $_SESSION['success'] = 'Berhasil tambah data baru';
        }
    }
}

if (!function_exists('info')) {
    function info($text = null)
    {
        if ($text) {
            $_SESSION['info'] = $text;
        } else {
            $_SESSION['info'] = 'Berhasil perbaruhi data';
        }
    }
}

if (!function_exists('error')) {
    function error($text = null)
    {
        if ($text) {
            $_SESSION['error'] = $text;
        } else {
            $_SESSION['error'] = 'Gagal menghapus data';
        }
    }
}

if (!function_exists('rupiah')) {
    function rupiah($angka)
    {
        $hasil_rupiah = 'Rp. ' . number_format($angka, 0, ',', '.');
        return $hasil_rupiah;
    }
}

if (!function_exists('bulan')) {
    function bulan()
    {
        return [
            '1' => 'Januari',
            '2' => 'Februari',
            '3' => 'Maret',
            '4' => 'April',
            '5' => 'Mei',
            '6' => 'Juni',
            '7' => 'Juli',
            '8' => 'Agustus',
            '9' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
        ];
    }
}

$tajaran = new TahunAjaran();
$th = $tajaran->getByActive();

$user = new Auth();

// // if user session is not active(not loggedin) this page will help 'home.php and profile.php' to redirect to login page
// // put this file within secured pages that users (users can't access without login)

if (!$user->cek_login()) {
    // session no set redirects to login page
    $user->redirect('login.php');
}
