<?php

class AsuransiBayar extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAll()
    {
        try {
            $stmt = $this->conn->prepare('SELECT * FROM t_asuransi_bayar');
            $stmt->execute();
            $rowFinger = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rowFinger;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getByAkademik($id)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM t_asuransi_bayar WHERE akademik_id = '$id' ");
            $stmt->execute();
            $rowFinger = $stmt->fetch(PDO::FETCH_ASSOC);

            return $rowFinger;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getById($id)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM t_asuransi_bayar WHERE id = $id ");
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
            $stmt = $this->conn->prepare('INSERT INTO t_asuransi_bayar (id,akademik_id,nominal,lunas,tanggal) VALUES (NULL,?,?,?,?)');
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
            $stmt = $this->conn->prepare("UPDATE t_asuransi_bayar SET akademik_id=?, nominal=?, lunas=? ,tanggal=? WHERE id='$id'");
            $stmt->execute($data);
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function destroy($id)
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM t_asuransi_bayar WHERE id = $id ");
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function destroyByAkademik($id_akademik)
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM t_asuransi_bayar WHERE akademik_id = '$id_akademik' ");
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    private function transformasiData($data = [])
    {
        $result = [];
        if ($data['akademik_id'] != '') {
            $result[] = $data['akademik_id'];
        }
        if ($data['nominal'] != '') {
            $result[] = preg_replace('/\D/', '', $data['nominal']);
        }
        if (isset($data['lunas']) && $data['lunas'] != '') {
            $result[] = $data['lunas'];
        }
        if (isset($data['tanggal']) && $data['tanggal'] != '') {
            $result[] = $data['tanggal'];
        }
        return $result;
    }
}
