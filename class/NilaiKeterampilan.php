<?php

class NilaiKeterampilan extends Controller {

    private $tahun_ajaran;
    private $semester;
    private $tahun;

    public function __construct()
    {
        parent::__construct();
        $this->tahun_ajaran = new TahunAjaran();
        $aktif = $this->tahun_ajaran->getByActive();
        $this->semester = $aktif['semester_id'];
        $this->tahun = $aktif['nama'];
    }

    public function getAll()
    {
        try {
            $stmt = $this->conn->prepare('SELECT * FROM t_nilai_keterampilan');
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
            $stmt = $this->conn->prepare("SELECT * FROM t_nilai_keterampilan WHERE id = $id ");
            $stmt->execute();
            $rowFinger = $stmt->fetch(PDO::FETCH_ASSOC);

            return $rowFinger;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getByNisGuruMapel($nis,$guru_id,$mapel_id)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM t_nilai_keterampilan WHERE no_induk = '$nis' AND guru_id='$guru_id' AND mapel_id='$mapel_id' AND semester='$this->semester' AND tahun_ajaran='$this->tahun'");
            $stmt->execute();
            $rowFinger = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rowFinger;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


    public function getByNisMapel($nis,$mapel_id)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM t_nilai_keterampilan WHERE no_induk = '$nis' AND mapel_id='$mapel_id' AND semester='$this->semester' AND tahun_ajaran='$this->tahun'");
            $stmt->execute();
            $rowFinger = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rowFinger;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getGroupKdByKelasMapelGuru($no_induk,$mapel_id,$guru_id,$limit)
    {
        try {
            $stmt = $this->conn->prepare("SELECT t_nilai_keterampilan.id, t_kd.id as kd_id, t_kd.no_kd FROM t_nilai_keterampilan LEFT JOIN t_kd ON t_nilai_keterampilan.kd_id=t_kd.id WHERE t_nilai_keterampilan.no_induk='$no_induk' AND t_nilai_keterampilan.guru_id='$guru_id' AND t_nilai_keterampilan.mapel_id='$mapel_id' LIMIT $limit");
            $stmt->execute();
            $rowFinger = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rowFinger;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function deleteByNisGuruMapel($nis,$guru_id,$mapel_id)
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM t_nilai_keterampilan WHERE no_induk = '$nis' AND guru_id='$guru_id' AND mapel_id='$mapel_id' AND semester='$this->semester' AND tahun_ajaran='$this->tahun'");
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
            $stmt = $this->conn->prepare('INSERT INTO t_nilai_keterampilan (id,no_induk,guru_id,mapel_id,kd_id,kategori_id,nilai,semester,tahun_ajaran) VALUES (NULL,?,?,?,?,?,?,?,?)');
            $stmt->execute($data);
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function storeWithLastId($data = [])
    {
        try {
            $data = $this->transformasiData($data);
            $stmt = $this->conn->prepare('INSERT INTO t_nilai_keterampilan (id,no_induk,guru_id,mapel_id,kd_id,kategori_id,nilai,semester,tahun_ajaran) VALUES (NULL,?,?,?,?,?,?,?,?)');
            $stmt->execute($data);
            return $this->conn->lastInsertId();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function update($data = [], $id)
    {
        try {
            $data = $this->transformasiData($data);
            $stmt = $this->conn->prepare("UPDATE t_nilai_keterampilan SET no_induk=?, guru_id=?, mapel_id=?, kd_id=?, kategori_id=?, nilai=?, semester=?, tahun_ajaran=? WHERE id='$id'");
            $stmt->execute($data);
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function destroy($id)
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM t_nilai_keterampilan WHERE id = $id ");
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
        if ($data['guru_id'] != '') {
            $result[] = $data['guru_id'];
        }
        if ($data['mapel_id'] != '') {
            $result[] = $data['mapel_id'];
        }
        /* if ($data['kd_id'] != '') {
            $result[] = $data['kd_id'];
        } */
        $result[] = $data['kd_id'];
        if ($data['kategori_id'] != '') {
            $result[] = $data['kategori_id'];
        }
        if ($data['nilai'] != '') {
            $result[] = $data['nilai'];
        }
        $result[] = $this->semester;
        $result[] = $this->tahun;
        return $result;
    }
}

?>