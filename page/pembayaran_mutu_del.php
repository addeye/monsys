<?php
require_once '../session.php';

$user->cek_admin();

$data = new Mutu();
$file = 'pembayaran';
$nis = $_GET['id'];

$data->updateMutuUnchecked($nis);
success('Berhasil batalkan pembayaran peningkatan mutu');

$data->redirect('../index.php?page=' . $file . '&nis=' . $nis);
