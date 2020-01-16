<?php
require_once '../session.php';
$user->cek_siswa();

$data = new Jurnal();
$mengajar = new Mengajar();
$file = 'jurnal_siswa';

switch ($_POST['aksi']) {
    case 'add':
        $jml=0;

        $mengajar_row = $mengajar->getByMapelKelasAktif($_POST['mapel_id'],$_POST['kelas_id']);

        $guru_id = $mengajar_row['guru_id'];
        $kelas_id = $_POST['kelas_id'];
        $mapel_id = $_POST['mapel_id'];
        $kd_id = $_POST['kd_id'];
        $kegiatan = $_POST['kegiatan'];
        $waktu = $_POST['waktu'];
        $tanggal = $_POST['tanggal'];
        // return var_dump($_POST);

        for($i=0; $i < count($waktu); $i++){
            $rows = [
                'guru_id' => $guru_id,
                'kelas_id' => $kelas_id,
                'mapel_id' => $mapel_id,
                'kd_id' => $kd_id,
                'kegiatan' => $kegiatan,
                'waktu' => $waktu[$i],
                'tanggal' => $tanggal
            ];

            $store = $data->store($rows);
            if($store){
                $jml++;
            }
        }

        if($jml){
            success('Berhasil masukkan sejumlah '.$jml.' data');
        }else{
            error('Gagal menambahkan data baru');
        }

        break;
    case 'edit':
        $id = $_GET['id'];

        $mengajar_row = $mengajar->getByMapelKelasAktif($_POST['mapel_id'],$_POST['kelas_id']);

        $guru_id = $mengajar_row['guru_id'];
        $kelas_id = $_POST['kelas_id'];
        $mapel_id = $_POST['mapel_id'];
        $kd_id = $_POST['kd_id'];
        $kegiatan = $_POST['kegiatan'];
        $waktu = $_POST['waktu'];
        $tanggal = $_POST['tanggal'];

        $rows = [
            'guru_id' => $guru_id,
            'kelas_id' => $kelas_id,
            'mapel_id' => $mapel_id,
            'kd_id' => $kd_id,
            'kegiatan' => $kegiatan,
            'waktu' => $waktu,
            'tanggal' => $tanggal
        ];
        $update = $data->update($rows, $id);
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
$data->redirect('../../index.php?page=' . $file);
