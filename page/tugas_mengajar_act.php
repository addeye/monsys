<?php
require_once '../session.php';

$user->cek_admin();
$data = new Mengajar();

switch ($_POST['aksi']) {
    case 'add':
    // return var_dump($_POST);
        $jml=0;
        $guru_id = $_POST['guru_id'];
        $mapel_id = $_POST['mapel_id'];
        $kelas_id = $_POST['kelas_id'];
        $store = false;
        // return var_dump(count($kelas_id));

        for($i=0; $i<count($kelas_id); $i++ ){
            $rows = [
                'guru_id' => $guru_id,
                'kelas_id' => $kelas_id[$i],
                'mapel_id' => $mapel_id
            ];

            if(!$data->getByGuruMapelKelasAktif($guru_id,$mapel_id,$kelas_id[$i])){
                $store = $data->store($rows);
            }else{
                $store = false;
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
        // return var_dump($_POST);
        $id = $_GET['id'];
        $update = $data->update($_POST, $id);
        // return var_dump($update);
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

$tajaran->redirect('../index.php?page=tugas_mengajar');
