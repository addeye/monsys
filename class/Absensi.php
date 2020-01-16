<?php

/**
 *
 */
class Absensi extends Controller {

	function __construct() {
		parent::__construct();
	}

	public function getAll() {
		try
		{
			$stmt = $this->conn->prepare("SELECT flog.tdate,flog.timein,flog.timeout, rl.NAMA, rl.KELAS, rl.TINGKAT FROM t_fingerlog AS flog INNER JOIN t_relasifp AS rl ON flog.fingerid=rl.NO_INDUK LIMIT 0,5");
			$stmt->execute();
			$rowFinger = $stmt->fetchAll(PDO::FETCH_ASSOC);

			return $rowFinger;

		} catch (PDOException $e) {
			echo $e->getMessage();
		}

	}

	public function getAllByNis($nis) {
		try
		{
			$stmt = $this->conn->prepare("SELECT flog.fingerid,flog.tdate,flog.timein,flog.timeout, rl.NAMA, rl.KELAS, rl.TINGKAT FROM t_fingerlog AS flog INNER JOIN t_relasifp AS rl ON flog.fingerid=rl.NO_INDUK WHERE flog.fingerid=$nis");
			$stmt->execute();
			$rowFinger = $stmt->fetchAll(PDO::FETCH_ASSOC);

			return $rowFinger;

		} catch (PDOException $e) {
			echo $e->getMessage();
		}

	}

	public function getAllByRangeDate($nis, $from, $to) {
		$from = date('Y-m-d', strtotime($from));
		$to = date('Y-m-d', strtotime($to));
		try
		{
			$stmt = $this->conn->prepare("SELECT flog.fingerid,flog.tdate,flog.timein,flog.timeout, rl.NAMA, rl.KELAS, rl.TINGKAT FROM t_fingerlog AS flog INNER JOIN t_relasifp AS rl ON flog.fingerid=rl.NO_INDUK WHERE flog.fingerid='$nis' and flog.tdate BETWEEN '$from' AND '$to'");
			$stmt->execute();
			$rowFinger = $stmt->fetchAll(PDO::FETCH_ASSOC);

			return $rowFinger;

		} catch (PDOException $e) {
			echo $e->getMessage();
		}

	}

	public function getAllByRangeDateKelas($kelas, $row_date) {
		try
		{
			$stmt = $this->conn->prepare("SELECT NO_INDUK, NAMA, KELAS FROM t_relasifp WHERE KELAS='$kelas'");
			$stmt->execute();
			$rowKelas = $stmt->fetchAll(PDO::FETCH_ASSOC);

			foreach ($rowKelas as $key => $value) {

				$absensi_row = array();

				foreach ($row_date as $date) {
					$stmt = $this->conn->prepare("SELECT flog.fingerid,flog.tdate,flog.timein,flog.timeout FROM t_fingerlog AS flog WHERE flog.fingerid = '$value[NO_INDUK]' AND flog.tdate = '$date'");
					$stmt->execute();
					$rowFinger = $stmt->fetch(PDO::FETCH_ASSOC);
					$absensi_row[] = $rowFinger;
				}

				$rowKelas[$key]['absensi'] = $absensi_row;
			}

			return $rowKelas;

		} catch (PDOException $e) {
			echo $e->getMessage();
		}

	}

	public function getById($id) {
		try
		{
			$stmt = $this->conn->prepare("SELECT * FROM t_fingerlog WHERE fingerlog_id=$id");
			$stmt->execute();
			$rowFinger = $stmt->fetch(PDO::FETCH_ASSOC);

			return $rowFinger;
		} catch (PDOException $e) {
			echo $e->getMessage();

		}
	}
}