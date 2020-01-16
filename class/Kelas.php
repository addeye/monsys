<?php
class Kelas extends Controller
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
            $stmt = $this->conn->prepare('SELECT * FROM t_kelas');
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
            $stmt = $this->conn->prepare("SELECT * FROM t_kelas WHERE id_kelas = $id ");
            $stmt->execute();
            $rowFinger = $stmt->fetch(PDO::FETCH_ASSOC);

            return $rowFinger;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getByMengajarGuru($id_guru)
    {
        try {
            $stmt = $this->conn->prepare("SELECT t_kelas.id_kelas, t_kelas.kelas FROM t_mengajar INNER JOIN t_kelas ON t_mengajar.kelas_id=t_kelas.id_kelas WHERE t_mengajar.guru_id='$id_guru' AND t_mengajar.semester='$this->semester' AND t_mengajar.tahun_ajaran='$this->tahun' GROUP BY t_mengajar.kelas_id");
            $stmt->execute();
            $rowFinger = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rowFinger;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getByNama($nama)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM t_kelas WHERE kelas = '$nama' ");
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
            $stmt = $this->conn->prepare('INSERT INTO t_kelas (id_kelas,kelas,tingkat) VALUES (NULL,?,?)');
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
            $stmt = $this->conn->prepare("UPDATE t_kelas SET kelas=?, tingkat=? WHERE id_kelas='$id'");
            $stmt->execute($data);
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function destroy($id)
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM t_kelas WHERE id_kelas = $id ");
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    private function transformasiData($data = [])
    {
        $result = [];
        if ($data['kelas'] != '') {
            $result[] = $data['kelas'];
        }
        if ($data['tingkat'] != '') {
            $result[] = $data['tingkat'];
        }
        return $result;
    }
}
