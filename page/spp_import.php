<?php
session_start();

spl_autoload_register(function ($class) {
	include '../class/' . $class . '.php';
});

require_once '../vendor/PHPExcel/Classes/PHPExcel.php';
require_once '../vendor/PHPExcel/Classes/PHPExcel/IOFactory.php';

$spp = new Spp();

// memanggil koneksi

// memanggil class PHPExcel

// load excel
$file = $_FILES['excel']['tmp_name'];
$load = PHPExcel_IOFactory::load($file);
$sheets = $load->getActiveSheet()->toArray(null, true, true, true);

$i = 1;
$masuk = 1;
foreach ($sheets as $sheet) {

	// karena data yang di excel di mulai dari baris ke 2
	// maka jika $i lebih dari 1 data akan di masukan ke database
	if ($i > 1) {
		// nama ada di kolom A
		// sedangkan alamat ada di kolom B
		$data = array(
			'NIS' => $sheet['A'],
			'BULAN' => $sheet['C'],
			'TAHUN' => $sheet['D'],
			'TANGGAL_BAYAR' => $sheet['E'],
		);

		$spp_insert = $spp->insert($data);
		if ($spp_insert) {
			$masuk++;
		} else {
			return $spp_insert;
		}

	}

	$i++;
}

if ($i >= 2) {
	$spp->updateDateImport();
	// pesan jika data berhasil di input
	// echo '<h1>Data berhasil dimasukan ' . $masuk . '</h1>';
}
$spp->redirect('../index.php?page=spp_admin&masuk=' . $masuk);