<?php
require_once '../session.php';
$user->cek_admin();
$data = new SppBayar();
$file = 'pembayaran';
$nis = $_REQUEST['nis'];

$asuransiBayar = new AsuransiBayar();
$investasi = new Investasi();
$investasiBayar = new InvestasiBayar();

$bimbel = new BimbelIntensif();
$bimbelBayar = new BimbelIntensifBayar();
$mutu = new Mutu();

switch ($_POST['aksi']) {
    case 'add':
        // print_r($_POST);
        // return false;
        $nominal_spp = $_POST['nominal_spp'];
        $set_spp = $_POST['spp_set_id'];
        $tanggal_spp = $_POST['tanggal_spp'];
        $jml = 0;

        //spp
        foreach ($set_spp as $key => $row) {
            if ($_POST['lunas_' . $key] && $tanggal_spp[$key] != '') {
                $dbrow = [
                    'no_induk' => $nis,
                    'spp_set_id' => $row,
                    'tanggal' => date('Y-m-d', strtotime($tanggal_spp[$key])),
                    'lunas' => $_POST['lunas_' . $key],
                    'nominal' => $nominal_spp[$key]
                ];

                $check = $data->getByNisPeriode($nis, $row);

                if ($check) {
                    $update = $data->update($dbrow, $check['id']);
                    if ($update) {
                        $jml++;
                    }
                } else {
                    $store = $data->store($dbrow);
                    if ($store) {
                        $jml++;
                    }
                }
            }
        }

        //asuransi
        $id_akademik = $_POST['id_akademik'];
        if ($_POST['lunas_asuransi'] && $_POST['tanggal_asuransi'] != '') {
            $dbasuransi = [
                'akademik_id' => $_POST['id_akademik'],
                'nominal' => $_POST['nominal_asuransi'],
                'lunas' => $_POST['lunas_asuransi'],
                'tanggal' => date('Y-m-d', strtotime($_POST['tanggal_asuransi']))
            ];

            $checkAsuransi = $asuransiBayar->getByAkademik($id_akademik);
            if ($checkAsuransi) {
                $updateAsuransi = $asuransiBayar->update($dbasuransi, $checkAsuransi['id']);
            } else {
                $storeAsuransi = $asuransiBayar->store($dbasuransi);
            }
        }

        if ($_POST['tanggal_mutu'] != '' && isset($_POST['lunas_mutu'])) {
            $tanggal_mutu = date('Y-m-d', strtotime($_POST['tanggal_mutu']));
            $mutu->updateMutuChecked($tanggal_mutu, $nis);
        }

        if ($_POST['investasi_nominal'] && $_POST['tanggal_investasi']) {
            $dbinvestasi = [
                'no_induk' => $nis,
                'nominal' => $_POST['investasi_nominal'],
                'tanggal' => date('Y-m-d', strtotime($_POST['tanggal_investasi']))
            ];

            $data_investasi = $investasi->getByNis($nis);
            $old = $data_investasi['bayar'];
            $new = $old + preg_replace('/\D/', '', $_POST['investasi_nominal']);

            $status_lunas = 'No';

            if ($new == $data_investasi['nominal']) {
                $status_lunas = 'Yes';
            }

            $investasi->updateByNis($new, $status_lunas, $nis);

            $investasiBayar->store($dbinvestasi);
        }

        if ($_POST['bimbel_nominal'] && $_POST['tanggal_bimbel']) {
            $dbbimbel = [
                'no_induk' => $nis,
                'nominal' => $_POST['bimbel_nominal'],
                'tanggal' => date('Y-m-d', strtotime($_POST['tanggal_bimbel']))
            ];

            $data_bimbel = $bimbel->getByNis($nis);
            $old = $data_bimbel['bayar'];
            $new = $old + preg_replace('/\D/', '', $_POST['bimbel_nominal']);

            $status_lunas = 'No';

            if ($new == $data_bimbel['nominal']) {
                $status_lunas = 'Yes';
            }

            $bimbel->updateByNis($new, $status_lunas, $nis);

            $bimbelBayar->store($dbbimbel);
        }

        success('data berhasil di simpan');

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
        $delete = $data->destroy($nis, $id);
        if ($delete) {
            success('Berhasil hapus data');
        } else {
            error();
        }
        break;
}
$data->redirect('../index.php?page=' . $file . '&nis=' . $nis);
