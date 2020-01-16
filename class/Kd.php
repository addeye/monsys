<?php
class Kd extends Controller
{
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
            $stmt = $this->conn->prepare("SELECT t_kd.*, t_mapel.nama as mapel FROM t_kd LEFT JOIN t_mapel ON t_kd.mapel_id=t_mapel.id WHERE t_kd.semester='".$this->semester."' AND t_kd.tahun_ajaran='".$this->tahun."'");
            $stmt->execute();
            $rowFinger = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $rowFinger;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getByMapel($mapel_id)
    {
        try {
            $stmt = $this->conn->prepare("SELECT t_kd.*, t_mapel.nama as mapel FROM t_kd LEFT JOIN t_mapel ON t_kd.mapel_id=t_mapel.id WHERE t_kd.semester='$this->semester' AND t_kd.tahun_ajaran='$this->tahun' AND t_kd.mapel_id='$mapel_id' ");
            $stmt->execute();
            $rowFinger = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $rowFinger;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getByMapelWithTingkat($mapel_id,$tingkat)
    {
        try {
            $stmt = $this->conn->prepare("SELECT t_kd.*, t_mapel.nama as mapel FROM t_kd LEFT JOIN t_mapel ON t_kd.mapel_id=t_mapel.id WHERE t_kd.semester='$this->semester' AND t_kd.tahun_ajaran='$this->tahun' AND t_kd.mapel_id='$mapel_id' AND t_kd.tingkat='$tingkat' ");
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
            $stmt = $this->conn->prepare("SELECT * FROM t_kd WHERE id = $id ");
            $stmt->execute();
            $rowFinger = $stmt->fetch(PDO::FETCH_ASSOC);

            return $rowFinger;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getByMapelNoKd($mapel_id,$tingkat,$kompetensi,$no_kd)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM t_kd WHERE mapel_id='$mapel_id' AND tingkat='$tingkat' AND kompetensi='$kompetensi' AND no_kd='$no_kd' AND semester='$this->semester' AND tahun_ajaran='$this->tahun' ");
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
            $stmt = $this->conn->prepare('INSERT INTO `t_kd`(`id`, `mapel_id`, `tingkat`, `kompetensi`, `no_kd`, `diskripsi_kd`, `semester`, `tahun_ajaran`) VALUES (NULL,?,?,?,?,?,?,?)');
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
            $stmt = $this->conn->prepare("UPDATE t_kd SET mapel_id=?, tingkat=?, kompetensi=?, no_kd=?, diskripsi_kd=?, semester=?, tahun_ajaran=? WHERE id='$id'");
            $stmt->execute($data);
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function destroy($id)
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM t_kd WHERE id = $id ");
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    private function transformasiData($data = [])
    {
        $result = [];
        if ($data['mapel_id'] != '') {
            $result[] = $data['mapel_id'];
        }
        if ($data['tingkat'] != '') {
            $result[] = $data['tingkat'];
        }
        if ($data['kompetensi'] != '') {
            $result[] = $data['kompetensi'];
        }
        if ($data['no_kd'] != '') {
            $result[] = $data['no_kd'];
        }
        if ($data['diskripsi_kd'] != '') {
            $result[] = $data['diskripsi_kd'];
        }
        $result[] = $this->semester;
        $result[] = $this->tahun;
        return $result;
    }
}
