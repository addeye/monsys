<?php

class SppBayar extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAll()
    {
        try {
            $stmt = $this->conn->prepare('SELECT * FROM t_spp_bayar');
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
            $stmt = $this->conn->prepare("SELECT * FROM t_spp_bayar WHERE id = $id ");
            $stmt->execute();
            $rowFinger = $stmt->fetch(PDO::FETCH_ASSOC);

            return $rowFinger;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getByNisPeriode($id, $spp_Set_id)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM t_spp_bayar WHERE no_induk = $id AND spp_set_id='$spp_Set_id'");
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
            $stmt = $this->conn->prepare('INSERT INTO t_spp_bayar (id,no_induk,spp_set_id,tanggal,lunas,nominal) VALUES (NULL,?,?,?,?,?)');
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
            $stmt = $this->conn->prepare("UPDATE t_spp_bayar SET no_induk=?, spp_set_id=?, tanggal=?, lunas=?, nominal=? WHERE id='$id'");
            $stmt->execute($data);
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function destroy($nis, $spp_set_id)
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM t_spp_bayar WHERE no_induk = $nis AND spp_set_id= $spp_set_id ");
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
        if ($data['spp_set_id'] != '') {
            $result[] = $data['spp_set_id'];
        }
        if ($data['tanggal'] != '') {
            $result[] = $data['tanggal'];
        }
        if ($data['lunas'] != '') {
            $result[] = $data['lunas'];
        }
        if ($data['nominal'] != '') {
            $result[] = preg_replace('/\D/', '', $data['nominal']);
        }
        return $result;
    }
}
