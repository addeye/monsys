<?php
require_once '../session.php';
$user->cek_admin();
$data = new BimbelIntensif();
$file = 'pbi';
$id_kelas = $_POST['id_kelas'];

switch ($_POST['aksi']) {
    case 'add':
        $nis = $_POST['nis'];
        $jml = 0;

        foreach ($nis as $key => $row) {
            $post = [
                'nominal' => $_POST['nom_mutu'][$key],
                'no_induk' => $row
            ];

            $rowdata = $data->getByNis($row);

            if ($rowdata) {
                $update = $data->update($post, $rowdata['id']);
                if ($update) {
                    $jml++;
                }
                success('Data yang berhasil tersimpan ' . $jml . ' data');
            } else {
                $store = $data->store($post);
                if ($store) {
                    $jml++;
                }
                success('Data yang berhasil tersimpan ' . $jml . ' data');
            }
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

$data->redirect('../index.php?page=' . $file . '&id_kelas=' . $id_kelas);
