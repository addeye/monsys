<?php
require_once '../session.php';
$user->cek_admin();
$data = new User();
$file = 'pengguna';

switch ($_POST['aksi']) {
    case 'add':
        $row = [
            "FPID" => $_POST['nip'],
            "NO_INDUK" => $_POST['nip'],
            "NAMA" => $_POST['nama'],
            "NO_HP" => $_POST['no_hp'],
            "KELAS" => $_POST['kelas'],
            "TINGKAT" => $_POST['kelas']
        ];
        // print_r($row);
        // return false;
        $store = $data->store($row);
        if ($store) {
            success();
        } else {
            error('Gagal menambahkan data baru. Data doubel!');
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
