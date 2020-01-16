<?php
require_once '../session.php';
$user->cek_admin();
require_once '../vendor/PHPExcel/Classes/PHPExcel.php';
require_once '../vendor/PHPExcel/Classes/PHPExcel/IOFactory.php';

$akademik = new Akademik();
$thajaran = $th['nama'];
$kelas = new Kelas();
$dbuser = new User();

// memanggil koneksi

// memanggil class PHPExcel

// load excel
$file = $_FILES['file_siswa']['tmp_name'];
$load = PHPExcel_IOFactory::load($file);
$sheets = $load->getActiveSheet()->toArray(null, true, true, true);

$i = 1;
$masuk = 0;
$updatelama = 0;
foreach ($sheets as $sheet) {
    // karena data yang di excel di mulai dari baris ke 2
    // maka jika $i lebih dari 1 data akan di masukan ke database
    if ($i > 1) {
        // nama ada di kolom A
        // sedangkan alamat ada di kolom B

        $nis = $sheet['A'];
        $nama = $sheet['B'];
        $no_hp = $sheet['C'];
        $kelas_nama = $sheet['D'];
        $tingkat = $sheet['E'];

        $kelas_id = $kelas->getByNama($kelas_nama)['id_kelas'];

        $checkuser = $dbuser->getById($nis);

        if ($checkuser) {
            $dbrow = [
                'KELAS' => $kelas_nama,
                'TINGKAT' => $tingkat
            ];
            $update = $dbuser->updateKelas($dbrow, $nis);
            if ($update) {
                $updatelama++;
            }
        } else {
            $dbrow = [
                'FPID' => $nis,
                'NO_INDUK' => $nis,
                'NAMA' => $nama,
                'NO_HP' => $no_hp,
                'KELAS' => $kelas_nama,
                'TINGKAT' => $tingkat
            ];
            $dbuser->store($dbrow);
            $masuk++;
        }

        $data = [
            'no_induk' => $nis,
            'kelas_id' => $kelas_id,
            'tahun_ajaran' => $thajaran,
        ];

        $status = $akademik->store($data);
    }

    $i++;
}
success('Berhasil import  data baru sebanyak ' . $masuk . '| Berhasil update data lama sebanyak ' . $updatelama);
$akademik->redirect('../index.php?page=data_siswa');
