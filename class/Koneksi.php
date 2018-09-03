<?php

/**
 * Created by PhpStorm.
 * User: deyelovi
 * Date: 05/04/2016
 * Time: 15:14
 */
class Koneksi {
	private $host = "localhost";
	private $db_name = "fingerprint";
	private $username = "root";
	private $password = "";
	public $conn;

	public function dbKoneksi() {
		$this->conn = null;

		try
		{
			$this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $exception) {
			echo "Connection error : " . $exception->getMessage();

		}
		return $this->conn;
	}

}
