<?php
require '../../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

require_once '../../session.php';
$user->cek_guru();

$np = new NilaiPengetahuan();
$nk = new NilaiKeterampilan();
$ns = new NilaiSikap();
$kategori = new Kategori();
$npkd = new NilaiPengKd();
$nkkd = new NilaiKetKd();
$kd = new Kd();
$kelas = new Kelas();

$file = 'penilaian';

if (isset($_POST['import'])) {
    $file_mimes = ['text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
    if (isset($_FILES['file']['name']) && in_array($_FILES['file']['type'], $file_mimes)) {
        $arr_file = explode('.', $_FILES['file']['name']);
        $extension = end($arr_file);
        if ('csv' == $extension) {
            $reader = new Csv();
        } elseif ('xlsx' == $extension) {
            $reader = new Xlsx();
        } else {
            $reader = new Xls();
        }
        $spreadsheet = $reader->load($_FILES['file']['tmp_name']);
        $sheetData = $spreadsheet->getActiveSheet();

        // return var_dump($sheetData);

        $count = count($sheetData->toArray());

        $kelas_id = $sheetData->getCell('B2')->getValue();
        $mapel_id = $sheetData->getCell('B3')->getValue();
        $guru_id = $_SESSION['user_id'];

        $kategori_peng = $sheetData->rangeToArray('C5:F5')[0];
        $kategori_kete = $sheetData->rangeToArray('G5:J5')[0];
        // return var_dump($kategori_kete);

        $kd_value_peng = $sheetData->rangeToArray('C6:F6')[0];
        $kd_value_kete = $sheetData->rangeToArray('G6:J6')[0];

        $kelasrow = $kelas->getById((int)$kelas_id);
        $kelastingkat = $kelasrow['tingkat'];

        for ($i = 7; $i <= $count; $i++) {
            $no_induk = $sheetData->getCell('A' . $i)->getValue();

            $nilpeng = $sheetData->rangeToArray('C' . $i . ':F' . $i)[0];

            $nilket = $sheetData->rangeToArray('G' . $i . ':J' . $i)[0];

            $nilsikap = $sheetData->getCell('K' . $i)->getValue();

            $np->deleteByNisGuruMapel((string)$no_induk, (string)$guru_id, (int)$mapel_id); //menghapus data nilai pengetahuan
            //proses input data baru nilai pengetahuan
            foreach ($kategori_peng as $key => $peng) {
                $d = 0;
                $pkd = [];

                //nilai pengetahuan
                $datainsert_peng = [
                    'no_induk' => (string)$no_induk,
                    'guru_id' => (string)$guru_id,
                    'mapel_id' => (int)$mapel_id,
                    'kd_id' => $kd_value_peng[$key] != 'PILIH KD' ? (string)$kd_value_peng[$key] : (string)0,
                    'kategori_id' => $kategori->getByNama($peng)['id'],
                    'nilai' => $nilpeng[$key] ? (int)$nilpeng[$key] : (string)0
                ];
                // return var_dump($datainsert_peng);

                $d = $np->storeWithLastId($datainsert_peng);

                if ($kd_value_peng[$key] != 'PILIH KD') {
                    $pkd = explode(',', $kd_value_peng[$key]);
                }

                if (count($pkd) > 0) {
                    for ($kk = 0; $kk < count($pkd); $kk++) {
                        //memasukkan data kd pada nilai keterampilan

                        $kdrow = $kd->getByMapelNoKd((int)$mapel_id, $kelastingkat, 'Pengetahuan', trim($pkd[$kk]));
                        $kdId = 0;

                        if ($kdrow) {
                            $kdId = $kdrow['id'];

                            $rowkd = [
                                'nil_peng_id' => $d,
                                'kd_id' => (int)$kdId
                            ];
                            // return var_dump($rowkd);
                            $npkd->store($rowkd);
                        }
                    }
                }
            }

            $nk->deleteByNisGuruMapel((string)$no_induk, (string)$guru_id, (int)$mapel_id); //menghapus data nilai keterampilan
            //proses input data baru nilai keterampilan
            foreach ($kategori_kete as $key => $kete) {
                $c = 0;
                $kkd = [];
                //nilai keterampilan
                $datainsert_kete = [
                    'no_induk' => (string)$no_induk,
                    'guru_id' => (string)$guru_id,
                    'mapel_id' => (int)$mapel_id,
                    'kd_id' => $kd_value_kete[$key] != 'PILIH KD' ? (string)$kd_value_kete[$key] : (string)0,
                    'kategori_id' => $kategori->getByNama($kete)['id'],
                    'nilai' => $nilket[$key] ? (int)$nilket[$key] : (string)0
                ];

                $c = $nk->storeWithLastId($datainsert_kete);

                if ($kd_value_kete[$key] != 'PILIH KD') {
                    $kkd = explode(',', $kd_value_kete[$key]);
                }

                // return var_dump($kd_value_kete[1]!= 'PILIH KD');

                if (count($kkd) > 0) {
                    for ($kk = 0; $kk < count($kkd); $kk++) {
                        $kdrow = $kd->getByMapelNoKd((int)$mapel_id, $kelastingkat, 'Ketrampilan', trim($kkd[$kk]));
                        $kdId = 0;
                        //memasukkan data kd pada nilai keterampilan
                        if ($kdrow) {
                            $kdId = $kdrow['id'];

                            $rowkd = [
                                'nil_ket_id' => $c,
                                'kd_id' => (int)$kdId
                            ];
                            // return var_dump($rowkd);
                            $nkkd->store($rowkd);
                        }
                    }
                }
            }

            $datainsert_sikap = [
                'no_induk' => (string)$no_induk,
                'guru_id' => (string)$guru_id,
                'mapel_id' => (int)$mapel_id,
                'nilai' => $nilsikap ? $nilsikap : (string)0
            ];
            $ns->deleteByNisGuruMapel((string)$no_induk, (string)$guru_id, (int)$mapel_id);
            $ns->store($datainsert_sikap);
        }

        success('Berhasil import data sebanyak ' . ($i - 7) . ' Siswa');
        $np->redirect('../../index.php?page=' . $file . '&kelas_id=' . $kelas_id . '&mapel_id=' . $mapel_id);
    }
}
