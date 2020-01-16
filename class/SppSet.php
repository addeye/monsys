<?php
class SppSet extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAll()
    {
        try {
            $stmt = $this->conn->prepare('SELECT * FROM t_spp_set');
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
            $stmt = $this->conn->prepare("SELECT * FROM t_spp_set WHERE tahun_ajaran = '$ajaran' ");
            $stmt->execute();
            $rowFinger = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rowFinger;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getByAjaranBulanTahun($bln, $thn, $ajaran)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM t_spp_set WHERE bulan='$bln' AND tahun='$thn' AND tahun_ajaran = '$ajaran' ");
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
            $stmt = $this->conn->prepare("SELECT * FROM t_spp_set WHERE id = $id ");
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
            $stmt = $this->conn->prepare('INSERT INTO t_spp_set (id,bulan,tahun,tahun_ajaran) VALUES (NULL,?,?,?)');
            $stmt->execute($data);
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function deleteByAjaran($thnajaran)
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM `t_spp_set` WHERE tahun_ajaran='$thnajaran' ");
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function update($data = [], $id)
    {
        try {
            $data = $this->transformasiData($data);
            $stmt = $this->conn->prepare("UPDATE t_spp_set SET bulan=?, tahun=?, tahun_ajaran=? WHERE id='$id'");
            $stmt->execute($data);
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function destroy($id)
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM t_spp_set WHERE id = $id ");
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    private function transformasiData($data = [])
    {
        $result = [];
        if ($data['bulan'] != '') {
            $result[] = $data['bulan'];
        }
        if ($data['tahun'] != '') {
            $result[] = $data['tahun'];
        }
        if ($data['tahun_ajaran'] != '') {
            $result[] = $data['tahun_ajaran'];
        }
        return $result;
    }
}
