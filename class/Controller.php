<?php

/**
 *
 */
class controller {

	function __construct() {
		$database = new Koneksi();
		$db = $database->dbKoneksi();
		$this->conn = $db;
	}

	public function redirect($url) {

		header("Location: $url");
	}
}