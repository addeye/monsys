<?php
class Jurnal extends Controller
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
            $stmt = $this->conn->prepare('SELECT * FROM t_jurnal');
            $stmt->execute();
            $rowFinger = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rowFinger;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getAllOwn($kelas_id=0,$waktu,$tanggal='')
    {
        try {
            if($kelas_id==0){
                $stmt = $this->conn->prepare("SELECT t_jurnal.id, t_jurnal.tanggal, t_jurnal.kegiatan, t_jurnal.waktu, t_kd.no_kd, t_kd.diskripsi_kd, t_kelas.kelas FROM t_jurnal LEFT JOIN t_kd ON t_jurnal.kd_id=t_kd.id INNER JOIN t_kelas ON t_jurnal.kelas_id=t_kelas.id_kelas WHERE t_jurnal.guru_id='$_SESSION[user_id]' AND t_jurnal.semester=$this->semester AND t_jurnal.tahun_ajaran='$this->tahun'");
            }else{
                $stmt = $this->conn->prepare("SELECT t_jurnal.id, t_jurnal.tanggal, t_jurnal.kegiatan, t_jurnal.waktu, t_kd.no_kd, t_kd.diskripsi_kd, t_kelas.kelas FROM t_jurnal LEFT JOIN t_kd ON t_jurnal.kd_id=t_kd.id INNER JOIN t_kelas ON t_jurnal.kelas_id=t_kelas.id_kelas WHERE t_jurnal.guru_id='$_SESSION[user_id]' AND t_jurnal.kelas_id=$kelas_id AND t_jurnal.waktu='$waktu' AND t_jurnal.tanggal='$tanggal' AND t_jurnal.semester=$this->semester AND t_jurnal.tahun_ajaran='$this->tahun'");
            }

            $stmt->execute();
            $rowFinger = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rowFinger;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getAllOwnByKelas($kelas_id=0)
    {
        try {
            $stmt = $this->conn->prepare("SELECT t_jurnal.id, t_jurnal.tanggal, t_jurnal.kegiatan, t_jurnal.waktu, t_kd.no_kd, t_kd.diskripsi_kd, t_kelas.kelas
                    FROM t_jurnal
                    LEFT JOIN t_kd ON t_jurnal.kd_id=t_kd.id
                    INNER JOIN t_kelas ON t_jurnal.kelas_id=t_kelas.id_kelas
                    WHERE t_jurnal.guru_id='$_SESSION[user_id]'
                    AND t_jurnal.kelas_id=$kelas_id
                    AND t_jurnal.semester=$this->semester
                    AND t_jurnal.tahun_ajaran='$this->tahun'
                    ORDER BY t_jurnal.tanggal DESC");
            $stmt->execute();
            $rowFinger = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rowFinger;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getByGuruPerKelas($kelas_id,$tanggal)
    {
        try {
            $stmt = $this->conn->prepare("SELECT t_relasifp.NAMA as guru, t_kelas.kelas, t_mapel.nama as mapel, t_jurnal.kegiatan, t_jurnal.waktu
                    FROM t_jurnal LEFT JOIN t_kd ON t_jurnal.kd_id=t_kd.id
                    LEFT JOIN t_kelas ON t_jurnal.kelas_id=t_kelas.id_kelas
                    LEFT JOIN t_mapel ON t_jurnal.mapel_id=t_mapel.id
                    LEFT JOIN t_relasifp ON t_jurnal.guru_id=t_relasifp.NO_INDUk
                    WHERE t_jurnal.kelas_id='$kelas_id'
                    AND t_jurnal.tanggal = '$tanggal'
                    AND t_jurnal.semester=$this->semester
                    AND t_jurnal.tahun_ajaran='$this->tahun'");

            $stmt->execute();
            $rowFinger = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rowFinger;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getAllBySiswa($kelas_id,$mapel_id=0,$waktu,$tanggal)
    {
        try {
            if($mapel_id==0){
                $stmt = $this->conn->prepare(
                    "SELECT t_jurnal.id, t_jurnal.tanggal,t_jurnal.kegiatan, t_jurnal.waktu, t_kd.no_kd, t_kd.diskripsi_kd, t_kelas.kelas, t_mapel.nama as mapel
                    FROM t_jurnal
                    INNER JOIN t_kd ON t_jurnal.kd_id=t_kd.id
                    INNER JOIN t_kelas ON t_jurnal.kelas_id=t_kelas.id_kelas
                    INNER JOIN t_mapel ON t_jurnal.mapel_id=t_mapel.id
                    WHERE t_jurnal.semester=$this->semester
                    AND t_jurnal.tahun_ajaran='$this->tahun'
                    AND t_jurnal.tanggal='$tanggal'
                    AND t_jurnal.kelas_id='$kelas_id' ");
            }else{
                $stmt = $this->conn->prepare(
                    "SELECT t_jurnal.id, t_jurnal.tanggal,t_jurnal.kegiatan, t_jurnal.waktu, t_kd.no_kd, t_kd.diskripsi_kd, t_kelas.kelas, t_mapel.nama as mapel
                    FROM t_jurnal
                    INNER JOIN t_kd ON t_jurnal.kd_id=t_kd.id
                    INNER JOIN t_kelas ON t_jurnal.kelas_id=t_kelas.id_kelas
                    INNER JOIN t_mapel ON t_jurnal.mapel_id=t_mapel.id
                    WHERE t_jurnal.kelas_id=$kelas_id
                    AND t_jurnal.waktu='$waktu'
                    AND t_jurnal.semester=$this->semester
                    AND t_jurnal.tahun_ajaran='$this->tahun'
                    AND t_jurnal.kelas_id='$kelas_id'
                    AND t_jurnal.tanggal='$tanggal'
                    AND t_jurnal.mapel_id='$mapel_id'");
            }

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
            $stmt = $this->conn->prepare("SELECT * FROM t_jurnal WHERE id = $id ");
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
            $stmt = $this->conn->prepare('INSERT INTO t_jurnal (id,guru_id,kelas_id,mapel_id,kd_id,kegiatan,waktu,tanggal,semester,tahun_ajaran) VALUES (NULL,?,?,?,?,?,?,?,?,?)');
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
            $stmt = $this->conn->prepare("UPDATE t_jurnal SET guru_id=?, kelas_id=?, mapel_id=?, kd_id=?, kegiatan=?, waktu=?, tanggal=?, semester=?, tahun_ajaran=? WHERE id='$id'");
            $stmt->execute($data);
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function destroy($id)
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM t_jurnal WHERE id = $id ");
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
        if ($data['kelas_id'] != '') {
            $result[] = $data['kelas_id'];
        }
        if ($data['mapel_id'] != '') {
            $result[] = $data['mapel_id'];
        }
        // if ($data['kd_id'] != '') {
            $result[] = $data['kd_id'];
        // }
        if ($data['kegiatan'] != '') {
            $result[] = $data['kegiatan'];
        }
        if ($data['waktu'] != '') {
            $result[] = $data['waktu'];
        }
        if ($data['tanggal'] != '') {
            $result[] = $data['tanggal'];
        }
        $result[] = $this->semester;
        $result[] = $this->tahun;
        return $result;
    }
}
