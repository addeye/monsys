<?php
require_once '../session.php';
$user->cek_admin();
$data = new BimbelIntensifBayar();
$bimbel = new BimbelIntensif();

$file = 'pembayaran';
$id = $_GET['id'];

$rowData = $data->getById($id);
$nis = $rowData['no_induk'];
$old = $rowData['nominal'];

$dataBimbel = $bimbel->getByNis($nis);
$total = $dataBimbel['nominal'];
$new = $dataBimbel['bayar'] - $old;

$status = 'No';
if ($new == $total) {
    $status = 'Yes';
}

$bimbel->updateByNis($new, $status, $nis);

$data->destroy($id);

success('Berhasil batalkan pembayaran investasi');

$data->redirect('../index.php?page=' . $file . '&nis=' . $nis);
