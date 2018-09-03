<?php

/**
 *
 */
class Spp extends Controller {

	function __construct() {
		parent::__construct();
	}

	public function getAll() {
		try
		{
			$stmt = $this->conn->prepare("SELECT ts.*, tr.NAMA, tr.KELAS, tr.TINGKAT FROM t_spp ts LEFT JOIN t_relasifp tr ON ts.NIS=tr.NO_INDUK");
			$stmt->execute();
			$rowFinger = $stmt->fetchAll(PDO::FETCH_ASSOC);

			return $rowFinger;

		} catch (PDOException $e) {
			echo $e->getMessage();
		}

	}

	public function getByNis($id) {
		try
		{
			$stmt = $this->conn->prepare("SELECT ts.*, tr.NAMA, tr.KELAS, tr.TINGKAT FROM t_spp ts LEFT JOIN t_relasifp tr ON ts.NIS=tr.NO_INDUK WHERE ts.NIS='$id'");
			$stmt->execute();
			$rowFinger = $stmt->fetchAll(PDO::FETCH_ASSOC);

			return $rowFinger;
		} catch (PDOException $e) {
			echo $e->getMessage();

		}
	}

	public function insert($data = array()) {
		try
		{
			$data = $this->transformasiData($data);
			$stmt = $this->conn->prepare("INSERT INTO t_spp (ID,NIS,BULAN,TAHUN,TANGGAL_BAYAR) VALUES (NULL,?,?,?,?)");
			$stmt->execute($data);
			return true;
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	public function getDateImport() {
		try
		{
			$stmt = $this->conn->prepare("SELECT * FROM t_import WHERE ID=1");
			$stmt->execute();
			$rowFinger = $stmt->fetch(PDO::FETCH_ASSOC);

			return $rowFinger['TANGGAL_IMPORT'];
		} catch (PDOException $e) {
			echo $e->getMessage();

		}
	}

	public function updateDateImport() {
		$date = date('Y-m-d');
		try
		{
			$stmt = $this->conn->prepare("UPDATE t_import SET TANGGAL_IMPORT=:utglimport WHERE ID=1");
			$stmt->execute(array('utglimport' => $date));
			return true;
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	public function transformasiData($data = array()) {
		$result = array();
		if ($data['NIS'] != '') {
			$result[] = $data['NIS'];
		}
		if ($data['BULAN'] != '') {
			$result[] = $data['BULAN'];
		}
		if ($data['TAHUN'] != '') {
			$result[] = $data['TAHUN'];
		}
		if ($data['TANGGAL_BAYAR'] != '') {
			$data['TANGGAL_BAYAR'] = date('Y-m-d', strtotime($data['TANGGAL_BAYAR']));
			$result[] = $data['TANGGAL_BAYAR'];
		}
		return $result;
	}
}