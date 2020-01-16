<?php
class Mapel extends Controller
{
    private $tahun_ajaran;
    private $semester;
    private $tahun;

    private $table = 't_mapel';

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
            $stmt = $this->conn->prepare('SELECT * FROM '.$this->table);
            $stmt->execute();
            $rowFinger = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rowFinger;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getByMengajarGuru($guru_id,$kelas_id)
    {
        try {
            $stmt = $this->conn->prepare(
                "SELECT t_mapel.* FROM t_mapel
                INNER JOIN t_mengajar ON t_mapel.id=t_mengajar.mapel_id
                WHERE t_mengajar.guru_id='$guru_id'
                AND t_mengajar.kelas_id='$kelas_id'
                AND t_mengajar.semester = '$this->semester'
                AND t_mengajar.tahun_ajaran = '$this->tahun'
                GROUP BY t_mengajar.mapel_id");

            $stmt->execute();
            $rowFinger = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rowFinger;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getByKelas($kelas_id)
    {
        try {
            $stmt = $this->conn->prepare(
                "SELECT t_mapel.* FROM t_mapel
                INNER JOIN t_mengajar ON t_mapel.id=t_mengajar.mapel_id
                WHERE t_mengajar.kelas_id='$kelas_id'
                AND t_mengajar.semester = '$this->semester'
                AND t_mengajar.tahun_ajaran = '$this->tahun'
                GROUP BY t_mengajar.mapel_id");
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
            $stmt = $this->conn->prepare("SELECT * FROM ".$this->table." WHERE id = $id ");
            $stmt->execute();
            $rowFinger = $stmt->fetch(PDO::FETCH_ASSOC);

            return $rowFinger;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getByNama($nama)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM ".$this->table." WHERE kelas = '$nama' ");
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
            $stmt = $this->conn->prepare("INSERT INTO ".$this->table." (id,nama) VALUES (NULL,?)");
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
            $stmt = $this->conn->prepare("UPDATE t_mapel SET nama=? WHERE id='$id'");
            $stmt->execute($data);
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function destroy($id)
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM t_mapel WHERE id = $id ");
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    private function transformasiData($data = [])
    {
        $result = [];
        if ($data['nama'] != '') {
            $result[] = $data['nama'];
        }
        return $result;
    }
}
