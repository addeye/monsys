<?php
//include the file that loads the PhpSpreadsheet classes
require_once '../../session.php';
$user->cek_guru();
require '../../vendor/autoload.php';
require '../../helpers/helper.php';

//include the classes needed to create and write .xlsx file

use PhpOffice\PhpSpreadsheet\Shared\File;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

//object of the Spreadsheet class to create the excel data
$spreadsheet = new Spreadsheet();
$akademik = new Akademik;
$kelas = new Kelas();
$mapel = new Mapel();
$kd = new Kd();

$kdgroup_peng = [];
$kdgroup_kete = [];

$np = new NilaiPengetahuan();
$nk = new NilaiKeterampilan();
$ns = new NilaiSikap();

$kategori = new Kategori();

$nilpengkd = new NilaiPengKd();
$nilketkd = new NilaiKetKd();

$guru_id = $_SESSION['user_id'];
$mapel_id = $_GET['mapel_id'];

$kategori_peng= $kategori->getByKompetensiPengetahuan();
$kategori_kete= $kategori->getByKompetensiKeterampilan();

$file = 'penilaian_import';

if (isset($_GET['kelas_id']) && $_GET['kelas_id']!='' && $_GET['mapel_id']!='') {
    $siswa = $akademik->getByKelasAjaranAktif($_GET['kelas_id']);
    $kelas_row = $kelas->getById($_GET['kelas_id']);
    $mapel_row = $mapel->getById($_GET['mapel_id']);
    // success();

    $nonduk = $siswa[0]['no_induk'];

  if($np->getByNisGuruMapel($nonduk,$guru_id,$mapel_id)){
    $kdgroup_peng = $np->getGroupKdByKelasMapelGuru($nonduk,$mapel_id,$guru_id,count($kategori_peng));
  }

  if($nk->getByNisGuruMapel($nonduk,$guru_id,$mapel_id)){
    $kdgroup_kete = $nk->getGroupKdByKelasMapelGuru($nonduk,$mapel_id,$guru_id,count($kategori_kete));
    }

} else {
    error('Ada kesalahan inputan');
    $akademik->redirect('../../index.php?page=' . $file);
}


// \PhpOffice\PhpSpreadsheet\Shared\File::setUseUploadTempDirectory(true);
File::setUseUploadTempDirectory(true);

//add some data in excel cells
$spreadsheet->setActiveSheetIndex(0)
 ->setCellValue('A1', 'Penilaian Kelas '.$kelas_row['kelas'].' Mapel '.$mapel_row['nama'])
 ->setCellValue('A2', 'Kelas ID')
 ->setCellValue('B2', $kelas_row['id_kelas'])
 ->setCellValue('A3', 'Mapel ID')
 ->setCellValue('B3', $mapel_row['id']);

$top=4;
$spreadsheet->setActiveSheetIndex(0)
 ->setCellValue('A'.$top, 'NIS')
 ->setCellValue('B'.$top, 'Nama Siswa')
 ->setCellValue('C'.$top, 'Pengetahuan')
 ->setCellValue('G'.$top, 'Keterampilan')
 ->setCellValue('K'.$top, 'Sikap');

$top++;
$spreadsheet->setActiveSheetIndex(0)
 ->setCellValue('C'.$top, 'UH 1')
 ->setCellValue('D'.$top, 'UH 2')
 ->setCellValue('E'.$top, 'UH 3')
 ->setCellValue('F'.$top, 'UH 4')
 ->setCellValue('G'.$top, 'Tugas 1')
 ->setCellValue('H'.$top, 'Tugas 2')
 ->setCellValue('I'.$top, 'Tugas 3')
 ->setCellValue('J'.$top, 'Tugas 4');

 $top++;
// $spreadsheet->setActiveSheetIndex(0)
//  ->setCellValue('C'.$top, 'PILIH KD')
//  ->setCellValue('D'.$top, 'PILIH KD')
//  ->setCellValue('E'.$top, 'PILIH KD')
//  ->setCellValue('F'.$top, 'PILIH KD')
//  ->setCellValue('G'.$top, 'PILIH KD')
//  ->setCellValue('H'.$top, 'PILIH KD')
//  ->setCellValue('I'.$top, 'PILIH KD')
//  ->setCellValue('J'.$top, 'PILIH KD');

 $kdcol=2;
 foreach($kdgroup_peng as $row){
    $spreadsheet->setActiveSheetIndex(0)
    ->setCellValue(dataColumn()[$kdcol].$top, showArrayToStringNoKD($nilpengkd->getNoKdByNilPengId($row['id'])));
    $kdcol++;
 }

foreach($kdgroup_kete as $row){
    $spreadsheet->setActiveSheetIndex(0)
    ->setCellValue(dataColumn()[$kdcol].$top, showArrayToStringNoKD($nilketkd->getNoKdByNilKetId($row['id'])));
    $kdcol++;
}

 $start = $top+1;
 $kp=0;
 foreach($siswa as $key => $row){
    $spreadsheet->setActiveSheetIndex(0)
    ->setCellValue('A'.$start, $row['no_induk'])
    ->setCellValue('B'.$start, $row['nama']);
    // return var_dump($mapel_id);
    if(count($np->getByNisGuruMapel($row['no_induk'],$guru_id,$mapel_id))){
        $kp = 2; //mulai dari C
        // return var_dump(dataColumn()[$kp]);
        foreach($np->getByNisGuruMapel($row['no_induk'],$guru_id,$mapel_id) as $rowp){
            $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue(dataColumn()[$kp].$start,$rowp['nilai']);
            $kp++;
        }
    }

    if(count($nk->getByNisGuruMapel($row['no_induk'],$guru_id,$mapel_id))){
        foreach($nk->getByNisGuruMapel($row['no_induk'],$guru_id,$mapel_id) as $rowk){
            $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue(dataColumn()[$kp].$start,$rowk['nilai']);
            $kp++;
        }
    }
    $nsfinal = $ns->getByNisGuruMapel($row['no_induk'],$guru_id,$mapel_id)['nilai'];
    if($nsfinal){
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue(dataColumn()[$kp].$start,$nsfinal);
    }

    $start++;
 }


 //Pilih KD

//  $spreadsheet->setActiveSheetIndex(0)
//  ->setCellValue('M1', 'ID')
//  ->setCellValue('N1', 'Kompetensi')
//  ->setCellValue('O1', 'No KD')
//  ->setCellValue('P1', 'Diskripsi KD');

//  $startkd = 2;
//  foreach($kd->getByMapelWithTingkat($mapel_row['id'],$kelas_row['tingkat']) as $mp){
//     $spreadsheet->setActiveSheetIndex(0)
//     ->setCellValue('M'.$startkd, $mp['id'])
//     ->setCellValue('N'.$startkd, $mp['kompetensi'])
//     ->setCellValue('O'.$startkd, $mp['no_kd'])
//     ->setCellValue('P'.$startkd, $mp['diskripsi_kd']);
//     $startkd++;
//  }



//set style for A1,B1,C1 cells
$cell_st =[
 'font' =>['bold' => true],
 'alignment' =>['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
 'borders'=>['bottom' =>['style'=> \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM]]
];

$cell_st_sub =[
    'alignment' =>['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
    'borders'=>['bottom' =>['style'=> \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM]]
   ];
$spreadsheet->getActiveSheet()->getStyle('A4:K4')->applyFromArray($cell_st);
$spreadsheet->getActiveSheet()->getStyle('A1:K1')->applyFromArray($cell_st);
$spreadsheet->getActiveSheet()->getStyle('C5:J5')->applyFromArray($cell_st);
$spreadsheet->getActiveSheet()->getStyle('C6:J6')->applyFromArray($cell_st_sub);

$spreadsheet->getActiveSheet()->getStyle('M1:P1')->applyFromArray($cell_st);

$spreadsheet->getActiveSheet()->mergeCells('A1:K1');
$spreadsheet->getActiveSheet()->mergeCells('C4:F4');
$spreadsheet->getActiveSheet()->mergeCells('G4:J4');

$spreadsheet->getActiveSheet()->mergeCells('A4:A6');
$spreadsheet->getActiveSheet()->mergeCells('B4:B6');
$spreadsheet->getActiveSheet()->mergeCells('K4:K6');

$styleArray = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
        ],
    ],
];
$start--;
$spreadsheet->getActiveSheet()->getStyle('A1:K'.$start)->applyFromArray($styleArray);
// $spreadsheet->getActiveSheet()->getStyle('M1:P'.$startkd)->applyFromArray($styleArray);

$spreadsheet->getActiveSheet()->getStyle('A4:B4')
    ->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
    $spreadsheet->getActiveSheet()->getStyle('K4')
    ->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);


//set columns width
// $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(16);
$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(30);
$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(13);
$spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(13);
$spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(13);
$spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(13);
$spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(13);
$spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(13);
$spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(13);
$spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(13);

$spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth(30);
$spreadsheet->getActiveSheet()->getColumnDimension('P')->setWidth(50);

$spreadsheet->getActiveSheet()->setTitle($kelas_row['kelas']); //set a title for Worksheet

//make object of the Xlsx class to save the excel file
$writer = new Xlsx($spreadsheet);
$fxls =$kelas_row['kelas'].'_'.$mapel_row['nama'];
$filepath = "${fxls}_".date("Ymd_Gis").".xlsx";

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$filepath.'"');
header('Cache-Control: max-age=0');

$writer->save('php://output');
// return var_dump($writer->save($filepath));
