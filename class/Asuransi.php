<?php

class Asuransi extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAll()
    {
        try {
            $stmt = $this->conn->prepare('SELECT * FROM t_asuransi');
            $stmt->execute();
            $rowFinger = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rowFinger;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getByAjaran($ajaran)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM t_asuransi WHERE tahun_ajaran = '$ajaran' ");
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
            $stmt = $this->conn->prepare("SELECT * FROM t_asuransi WHERE id = $id ");
            $stmt->execute();
            $rowFinger = $stmt->fetch(PDO::FETCH_ASSOC);

            return $rowFinger;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getByTingkatAjaran($tingkat, $tahun_ajaran)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM t_asuransi WHERE tingkat = '$tingkat' AND tahun_ajaran='$tahun_ajaran' ");
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
            $stmt = $this->conn->prepare('INSERT INTO t_asuransi (id,tingkat,nominal,tahun_ajaran) VALUES (NULL,?,?,?)');
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
            $stmt = $this->conn->prepare("UPDATE t_asuransi SET tingkat=?, nominal=? WHERE id='$id'");
            $stmt->execute($data);
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function destroy($id)
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM t_asuransi WHERE id = $id ");
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    private function transformasiData($data = [])
    {
        $result = [];
        if ($data['tingkat'] != '') {
            $result[] = $data['tingkat'];
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
