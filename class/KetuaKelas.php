<?php
class KetuaKelas extends Controller
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
            $stmt = $this->conn->prepare('SELECT * FROM t_ketua_kelas');
            $stmt->execute();
            $rowFinger = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rowFinger;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getAllByTahunAjaranActive()
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM t_ketua_kelas WHERE tahun_ajaran='$this->tahun'");
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
            $stmt = $this->conn->prepare(
                'SELECT t_ketua_kelas.id, t_relasifp.NAMA as nama, t_relasifp.NO_INDUK as no_induk, t_kelas.kelas FROM t_ketua_kelas
                INNER JOIN t_relasifp ON t_ketua_kelas.no_induk=t_relasifp.NO_INDUk
                INNER JOIN t_kelas ON t_ketua_kelas.kelas_id=t_kelas.id_kelas'
            );
            $stmt->execute();
            $rowFinger = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rowFinger;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getAllWithRelationTahunAjaranActive()
    {
        try {
            $stmt = $this->conn->prepare(
                "SELECT t_ketua_kelas.id, t_relasifp.NAMA as nama, t_relasifp.NO_INDUK as no_induk, t_kelas.kelas FROM t_ketua_kelas
                INNER JOIN t_relasifp ON t_ketua_kelas.no_induk=t_relasifp.NO_INDUk
                INNER JOIN t_kelas ON t_ketua_kelas.kelas_id=t_kelas.id_kelas
                WHERE t_ketua_kelas.tahun_ajaran='$this->tahun'"
            );
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
            $stmt = $this->conn->prepare("SELECT * FROM t_ketua_kelas WHERE id = $id ");
            $stmt->execute();
            $rowFinger = $stmt->fetch(PDO::FETCH_ASSOC);

            return $rowFinger;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getBySiswaAktif($no_induk)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM t_ketua_kelas WHERE no_induk ='$no_induk' AND tahun_ajaran='$this->tahun'");
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
            $stmt = $this->conn->prepare('INSERT INTO t_ketua_kelas (id,no_induk, kelas_id,tahun_ajaran) VALUES (NULL,?,?,?)');
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
            $stmt = $this->conn->prepare("UPDATE t_ketua_kelas SET no_induk=?, kelas_id=?, tahun_ajaran=? WHERE id='$id'");
            $stmt->execute($data);
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function destroy($id)
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM t_ketua_kelas WHERE id = $id ");
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

        if ($data['kelas_id'] != '') {
            $result[] = $data['kelas_id'];
        }
        $result[] = $this->tahun;
        return $result;
    }
}
