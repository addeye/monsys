<?php

class Mutu extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAll()
    {
        try {
            $stmt = $this->conn->prepare('SELECT * FROM t_mutu');
            $stmt->execute();
            $rowFinger = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rowFinger;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getById($id)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM t_mutu WHERE id = $id ");
            $stmt->execute();
            $rowFinger = $stmt->fetch(PDO::FETCH_ASSOC);

            return $rowFinger;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getByNis($id, $tahun_ajaran)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM t_mutu WHERE no_induk = $id and tahun_ajaran='$tahun_ajaran'");
            $stmt->execute();
            $rowFinger = $stmt->fetch(PDO::FETCH_ASSOC);

            return $rowFinger;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function store($data = [])
    {
        try {
            $data = $this->transformasiData($data);
            $stmt = $this->conn->prepare('INSERT INTO t_mutu (id,no_induk,nominal,tahun_ajaran) VALUES (NULL,?,?,?)');
            $stmt->execute($data);
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function update($data = [], $id)
    {
        try {
            $data = $this->transformasiData($data);
            $stmt = $this->conn->prepare("UPDATE t_mutu SET no_induk=?, nominal=? WHERE id='$id'");
            $stmt->execute($data);
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function updateMutuUnchecked($nis)
    {
        try {
            $stmt = $this->conn->prepare("UPDATE t_mutu SET lunas='No', tanggal='' WHERE no_induk='$nis'");
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function updateMutuChecked($tgl, $nis)
    {
        try {
            $stmt = $this->conn->prepare("UPDATE t_mutu SET lunas='Yes', tanggal='$tgl' WHERE no_induk='$nis'");
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function destroy($id)
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM t_mutu WHERE id = $id ");
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    private function transformasiData($data = [])
    {
        $result = [];
        if ($data['no_induk'] != '') {
            $result[] = $data['no_induk'];
        }
        if ($data['nominal'] != '') {
            $result[] = preg_replace('/\D/', '', $data['nominal']);
        }
        if (isset($data['tahun_ajaran']) && $data['tahun_ajaran'] != '') {
            $result[] = $data['tahun_ajaran'];
        }
        return $result;
    }
}
