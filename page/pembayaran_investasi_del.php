<?php
require_once '../session.php';
$user->cek_admin();
$data = new InvestasiBayar();
$investasi = new Investasi();

$file = 'pembayaran';
$id = $_GET['id'];

$rowData = $data->getById($id);
$nis = $rowData['no_induk'];
$old = $rowData['nominal'];

$dataInvest = $investasi->getByNis($nis);
$total = $dataInvest['nominal'];
$new = $dataInvest['bayar'] - $old;

$status = 'No';
if ($new == $total) {
    $status = 'Yes';
}

$investasi->updateByNis($new, $status, $nis);

$data->destroy($id);

success('Berhasil batalkan pembayaran investasi');

$data->redirect('../index.php?page=' . $file . '&nis=' . $nis);
