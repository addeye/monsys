<?php
require_once '../session.php';
$user->cek_admin();
$data = new User();
$file = 'pengguna';

switch ($_POST['aksi']) {
    case 'del':
        $id = $_GET['id'];
        $delete = $data->generateResetPasswordOne($id);
        if ($delete) {
            success('Berhasil reset password data');
        } else {
            error();
        }
        break;
}

$data->redirect('../index.php?page=' . $file);
