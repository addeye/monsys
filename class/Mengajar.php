<?php
class Mengajar extends Controller
{
    private $table = 't_mengajar';
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
            $stmt = $this->conn->prepare('SELECT * FROM '.$this->table);
            $stmt->execute();
            $rowFinger = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rowFinger;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getAllWithRelation()
    {
        try {
            $stmt = $this->conn->prepare("SELECT t_mengajar.id,t_relasifp.FPID as nip, t_relasifp.NAMA as guru, t_kelas.kelas, t_mapel.nama as mapel FROM t_mengajar
            LEFT JOIN t_relasifp ON t_mengajar.guru_id=t_relasifp.FPID
            LEFT JOIN t_kelas ON t_mengajar.kelas_id=t_kelas.id_kelas
            LEFT JOIN t_mapel ON t_mengajar.mapel_id=t_mapel.id");
            $stmt->execute();
            $rowFinger = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rowFinger;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getByGuruMapelKelasAktif($guru_id,$mapel_id,$kelas_id)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE guru_id = '$guru_id' AND kelas_id = '$kelas_id' AND mapel_id = '$mapel_id' AND semester = '$this->semester' AND tahun_ajaran='$this->tahun' ");
            $stmt->execute();
            $rowFinger = $stmt->fetch(PDO::FETCH_ASSOC);

            return $rowFinger;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getByMapelKelasAktif($mapel_id,$kelas_id)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE kelas_id = '$kelas_id' AND mapel_id = '$mapel_id' AND semester = '$this->semester' AND tahun_ajaran='$this->tahun' ");
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
            $stmt = $this->conn->prepare("INSERT INTO ".$this->table." (id,guru_id,kelas_id,mapel_id,semester,tahun_ajaran) VALUES (NULL,?,?,?,?,?)");
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
            $stmt = $this->conn->prepare("UPDATE t_mengajar SET guru_id=?, kelas_id=?, mapel_id=?,semester=?,tahun_ajaran=? WHERE id='$id'");
            $stmt->execute($data);
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function destroy($id)
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM t_mengajar WHERE id = $id ");
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    private function transformasiData($data = [])
    {
        $aktif = $this->tahun_ajaran->getByActive();
        $result = [];
        if ($data['guru_id'] != '') {
            $result[] = $data['guru_id'];
        }
        if ($data['kelas_id'] != '') {
            $result[] = $data['kelas_id'];
        }
        if ($data['mapel_id'] != '') {
            $result[] = $data['mapel_id'];
        }
        $result[] = $aktif['semester_id'];
        $result[] = $aktif['nama'];
        return $result;
    }
}
