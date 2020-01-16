<?php
require_once '../session.php';
$user->cek_siswa();

$data = new Kehadiran();
$file = 'absensi_kehadiran_kelas';

switch ($_POST['aksi']) {
    case 'add':
        $jml = 0;
        $kelas_id = $_POST['kelas_id'];
        $mapel_id = $_POST['mapel_id'];
        $waktu = $_POST['waktu'];
        $tanggal = $_POST['tanggal'];
        $data->deleteByKelasMapel($kelas_id,$mapel_id,$waktu,$tanggal);
        for($i=0; $i < count($_POST['no_induk']); $i++){

            $input_row = [
                'no_induk' => $_POST['no_induk'][$i],
                'guru_id' => $_POST['guru_id'],
                'mapel_id' => $_POST['mapel_id'],
                'kelas_id' => $_POST['kelas_id'],
                'status' => $_POST['status'][$i],
                'waktu' => $_POST['waktu'],
                'tanggal' => $_POST['tanggal']
            ];

            $store = $data->store($input_row);
            if ($store) {
                $jml++;
            }
        }

        if ($store) {
            success("Berhasil menyimpan data sebanyak ".$jml);
        } else {
            error('Gagal menambahkan data baru');
        }

        break;
    case 'edit':
        // $id = $_GET['id'];
        // $update = $data->update($_POST, $id);
        // if ($update) {
        //     info();
        // } else {
        //     error('Gagal perbaruhi data');
        // }
        break;
    case 'del':
        // $id = $_GET['id'];
        // $delete = $data->destroy($id);
        // if ($delete) {
        //     success('Berhasil hapus data');
        // } else {
        //     error();
        // }
        break;
}
$data->redirect('../index.php?page=' . $file.'&kelas_id='.$kelas_id.'&mapel_id='.$mapel_id.'&waktu='.$waktu.'&tanggal='.$tanggal);
