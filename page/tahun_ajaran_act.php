<?php
require_once '../session.php';

$user->cek_admin();
$tajaran = new TahunAjaran();

switch ($_POST['aksi']) {
    case 'add':
        $store = $tajaran->store($_POST);
        if ($store) {
            success();
        } else {
            error('Gagal menambahkan data baru');
        }
        break;
    case 'edit':
        $id = $_GET['id'];
        $update = $tajaran->update($_POST, $id);
        if ($update) {
            info();
        } else {
            error('Gagal perbaruhi data');
        }
        break;
    case 'del':
        $id = $_GET['id'];
        $delete = $tajaran->destroy($id);
        if ($delete) {
            success('Berhasil hapus data');
        } else {
            error();
        }
        break;
    case 'set':
        $id = $_GET['id'];
        $set = $tajaran->set_active($id);
        if ($set) {
            success('Berhasil ganti tahun ajaran aktif');
        } else {
            error();
        }
        break;
}
$tajaran->redirect('../index.php?page=tahun_ajaran');
