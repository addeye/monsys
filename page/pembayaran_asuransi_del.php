<?php
require_once '../session.php';
$user->cek_admin();
$data = new AsuransiBayar();
$file = 'pembayaran';
$nis = $_REQUEST['nis'];

$data->destroyByAkademik($_GET['id']);
success('Berhasil hapus pembayaran asuransi');

$data->redirect('../index.php?page=' . $file . '&nis=' . $nis);
