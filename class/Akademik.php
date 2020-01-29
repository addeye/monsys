<?php
class Akademik extends Controller
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
            $stmt = $this->conn->prepare('SELECT * FROM t_akademik');
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
            $stmt = $this->conn->prepare("SELECT * FROM t_akademik WHERE tahun_ajaran = '$ajaran' ");
            $stmt->execute();
            $rowFinger = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rowFinger;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getByAjaranSearch($ajaran, $search)
    {
        try {
            $stmt = $this->conn->prepare("SELECT t_akademik.*, t_relasifp.NAMA as nama FROM t_akademik INNER JOIN t_relasifp ON t_relasifp.NO_INDUK=t_akademik.no_induk WHERE t_akademik.tahun_ajaran = '$ajaran' AND t_akademik.no_induk LIKE '%$search%' OR t_relasifp.NAMA LIKE '%$search%' ");
            $stmt->execute();
            $rowFinger = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rowFinger;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getByKelasAjaran($ajaran, $kelas)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM t_akademik WHERE kelas_id='$kelas' AND tahun_ajaran = '$ajaran' ");
            $stmt->execute();
            $rowFinger = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rowFinger;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getByKelasAjaranAktif($kelas)
    {
        try {
            $stmt = $this->conn->prepare("SELECT t_akademik.id, t_akademik.no_induk, t_relasifp.NAMA as nama, t_relasifp.NO_HP as no_hp
                        FROM t_akademik
                        INNER JOIN t_relasifp ON t_akademik.no_induk=t_relasifp.NO_INDUK
                        WHERE t_akademik.kelas_id='$kelas'
                        AND t_akademik.tahun_ajaran = '$this->tahun'");
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
            $stmt = $this->conn->prepare("SELECT * FROM t_akademik WHERE id = $id ");
            $stmt->execute();
            $rowFinger = $stmt->fetch(PDO::FETCH_ASSOC);

            return $rowFinger;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getByNisAjaran($no_induk, $tahun_ajaran)
    {
        $stmt = $this->conn->prepare("SELECT * FROM t_akademik WHERE no_induk = '$no_induk' AND tahun_ajaran='$tahun_ajaran' ");
        $stmt->execute();
        $rowFinger = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($rowFinger) {
            return $rowFinger;
        }
        return false;
    }

    public function getByNisAjaranAktif($no_induk)
    {
        $stmt = $this->conn->prepare("SELECT * FROM t_akademik WHERE no_induk = '$no_induk' AND tahun_ajaran='$this->tahun' ");
        $stmt->execute();
        $rowFinger = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($rowFinger) {
            return $rowFinger;
        }
        return false;
    }

    public function getByNisAjaranCount($no_induk, $tahun_ajaran)
    {
        $stmt = $this->conn->prepare("SELECT * FROM t_akademik WHERE no_induk = '$no_induk' AND tahun_ajaran='$tahun_ajaran' ");
        $stmt->execute();
        $rowFinger = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($rowFinger) {
            return $rowFinger;
        }
        return false;
    }

    public function getByNisAjaranLimit1($no_induk, $tahun_ajaran)
    {
        $stmt = $this->conn->prepare("SELECT * FROM t_akademik WHERE no_induk = '$no_induk' AND tahun_ajaran='$tahun_ajaran' LIMIT 1");
        $stmt->execute();
        $rowFinger = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($rowFinger) {
            return $rowFinger;
        }
        return false;
    }

    public function store($data = [])
    {
        try {
            $checkAkademik = $this->getByNisAjaranCount($data['no_induk'], $data['tahun_ajaran']);
            if (count($checkAkademik) > 1) {
                $rowakademik = $this->getByNisAjaranLimit1($data['no_induk'], $data['tahun_ajaran']);
                $this->destroy($rowakademik['id']);
            }
            if (!$this->getByNisAjaran($data['no_induk'], $data['tahun_ajaran'])) {
                $data = $this->transformasiData($data);
                $stmt = $this->conn->prepare('INSERT INTO t_akademik (id,no_induk,kelas_id,tahun_ajaran) VALUES (NULL,?,?,?)');
                $stmt->execute($data);
                return true;
            }
            return false;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function update($data = [], $id)
    {
        try {
            $data = $this->transformasiData($data);
            $stmt = $this->conn->prepare("UPDATE t_akademik SET no_induk=?, kelas_id=?, tahun_ajaran=? WHERE id='$id'");
            $stmt->execute($data);
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function destroy($id)
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM t_akademik WHERE id = $id ");
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
        if (isset($data['kelas_id']) && $data['kelas_id'] != '') {
            $result[] = $data['kelas_id'];
        }
        if (isset($data['tahun_ajaran']) && $data['tahun_ajaran'] != '') {
            $result[] = $data['tahun_ajaran'];
        }
        return $result;
    }
}
