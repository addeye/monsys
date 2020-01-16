<?php
require_once '../session.php';

$user->cek_admin();
$data = new Piket();

switch ($_POST['aksi']) {
    case 'add':
        // return var_dump($_POST);
        $jml=0;
        $guru_id = $_POST['guru_id'];
        $store = false;

        for($i=0; $i<count($guru_id); $i++ ){
            $rows = [
                'guru_id' => $guru_id[$i],
            ];
            // return var_dump($rows);
            if(!$data->getByGuruAktif($guru_id[$i])){
                $store = $data->store($rows);
            }
            if ($store) {
                $jml++;
            }
        }
        if ($jml > 0) {
            success("Berhasil menambahkan ".$jml." data");
        } else {
            error('Gagal menambahkan data, mungkin sudah ada. cek lagi!');
        }
        break;
    case 'edit':
        $id = $_GET['id'];
        $update = false;
        // return var_dump($data->getByGuruAktif($_POST['guru_id']));
        $check = $data->getByGuruAktif($_POST['guru_id']);
        if(!$check){
            $update = $data->update($_POST, $id);
            if ($update) {
                info();
            } else {
                error('Gagal perbaruhi data');
            }
        }else{
            error('Gagal perbaruhi data, mungkin data sudah ada!');
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

$tajaran->redirect('../index.php?page=guru_piket');
