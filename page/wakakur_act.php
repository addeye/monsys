<?php
require_once '../session.php';

$user->cek_admin();
$data = new Wakakur();

switch ($_POST['aksi']) {
    case 'add':
    // return var_dump($_POST);
        $guru_id = $_POST['guru_id'];
        $rows = [
            'guru_id' => $guru_id,
        ];
        $store = false;
        // return var_dump($rows);
        if(!$data->getByGuruOnlyOneActive()){
            $store = $data->store($rows);
        }
        if ($store) {
            success('Berhasil Set data');
        } else {
            error("Gagal karena data Wakakur suda di Set");
        }
        break;
    case 'edit':
        $id = $_GET['id'];
        $update = false;
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

$tajaran->redirect('../index.php?page=wakakur');
