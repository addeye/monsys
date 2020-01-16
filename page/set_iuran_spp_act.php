<?php
require_once '../session.php';

$user->cek_admin();

$data = new SppSet();
$file = 'set_iuran_spp';

switch ($_POST['aksi']) {
    case 'add':
        $sbulan = $_POST['bulan'];
        $stahun = $_POST['tahun'];
        $stahun_ajaran = $_POST['tahun_ajaran'];
        $num = 13;
        $jml = 0;

        $data->deleteByAjaran($stahun_ajaran);

        for ($a = $sbulan; $a < $num; $a++) {
            $dbrow = [
                'bulan' => $a,
                'tahun' => $stahun,
                'tahun_ajaran' => $stahun_ajaran
            ];

            $store = $data->store($dbrow);
            if ($store) {
                $jml++;
            }

            if ($a == 12) {
                $a = 0;
                $num = $sbulan;
                $stahun = $stahun + 1;
            }
        }
        success('Data Baru yang berhasil tersimpan ' . $jml . ' data');
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
