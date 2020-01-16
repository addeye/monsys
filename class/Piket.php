<?php
class Piket extends Controller
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
            $stmt = $this->conn->prepare('SELECT * FROM t_piket');
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
                "SELECT t_piket.id, t_relasifp.NAMA as guru, t_relasifp.NO_INDUK as nip FROM t_piket
                INNER JOIN t_relasifp ON t_piket.guru_id=t_relasifp.NO_INDUk"
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
            $stmt = $this->conn->prepare("SELECT * FROM t_piket WHERE id = $id ");
            $stmt->execute();
            $rowFinger = $stmt->fetch(PDO::FETCH_ASSOC);

            return $rowFinger;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getByGuruAktif($guru_id)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM t_piket WHERE guru_id ='$guru_id' AND semester='$this->semester' AND tahun_ajaran='$this->tahun'");
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
            $stmt = $this->conn->prepare('INSERT INTO t_piket (id,guru_id,semester,tahun_ajaran) VALUES (NULL,?,?,?)');
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
            $stmt = $this->conn->prepare("UPDATE t_piket SET guru_id=?, semester=?, tahun_ajaran=? WHERE id='$id'");
            $stmt->execute($data);
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function destroy($id)
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM t_piket WHERE id = $id ");
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    private function transformasiData($data = [])
    {
        $result = [];
        if ($data['guru_id'] != '') {
            $result[] = $data['guru_id'];
        }
        $result[] = $this->semester;
        $result[] = $this->tahun;
        return $result;
    }
}
