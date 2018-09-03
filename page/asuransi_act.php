<?php
require_once '../session.php';
$user->cek_admin();

$data = new Asuransi();
$file = 'asuransi';

switch ($_POST['aksi']) {
    case 'add':
        $store = $data->store($_POST);
        if ($store) {
            success();
        } else {
            error('Gagal menambahkan data baru');
        }
        break;
    case 'edit':
        $id = $_GET['id'];
        $update = $data->update($_POST, $id);
        if ($update) {
            info();
        } else {
            error('Gagal perbaruhi data');
        }
        break;
    case 'del':
        $id = $_GET['id'];
        $delete = $data->destroy($id);
        if ($delete) {
            success('Berhasil hapus data');
        } else {
            error();
        }
        break;
}

$data->redirect('../index.php?page=' . $file);
