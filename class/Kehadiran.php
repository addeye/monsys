<?php
class Kehadiran extends Controller
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
            $stmt = $this->conn->prepare('SELECT * FROM t_kehadiran');
            $stmt->execute();
            $rowFinger = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rowFinger;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getShowSiswaByKelasAjaranAktif($kelas,$mapel,$waktu,$tanggal)
    {
        try {
            $stmt = $this->conn->prepare("SELECT t_akademik.id, t_akademik.no_induk, t_relasifp.NAMA as nama, t_relasifp.NO_HP as no_hp, t_kehadiran.status
                        FROM t_akademik INNER JOIN t_relasifp ON t_akademik.no_induk=t_relasifp.NO_INDUK
                        LEFT JOIN t_kehadiran ON t_akademik.no_induk=t_kehadiran.no_induk
                        WHERE t_akademik.kelas_id='$kelas'
                        AND t_akademik.tahun_ajaran = '$this->tahun'
                        AND t_kehadiran.semester='$this->semester'
                        AND t_kehadiran.tahun_ajaran='$this->tahun'
                        AND t_kehadiran.waktu='$waktu'
                        AND t_kehadiran.tanggal='$tanggal'
                        AND t_kehadiran.mapel_id='$mapel'");
            $stmt->execute();
            $rowFinger = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rowFinger;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getShowSiswaByKelasAjaranAktifJustFirstTime($kelas,$tanggal)
    {
        try {
            $stmt = $this->conn->prepare("SELECT t_akademik.id, t_akademik.no_induk, t_relasifp.NAMA as nama, t_relasifp.NO_HP as no_hp, t_kehadiran.status
                        FROM t_akademik INNER JOIN t_relasifp ON t_akademik.no_induk=t_relasifp.NO_INDUK
                        LEFT JOIN t_kehadiran ON t_akademik.no_induk=t_kehadiran.no_induk
                        WHERE t_akademik.kelas_id='$kelas'
                        AND t_akademik.tahun_ajaran = '$this->tahun'
                        AND t_kehadiran.semester='$this->semester'
                        AND t_kehadiran.tahun_ajaran='$this->tahun'
                        AND t_kehadiran.waktu='Jam Ke-1'
                        AND t_kehadiran.tanggal='$tanggal'");
            $stmt->execute();
            $rowFinger = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rowFinger;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getShowByKelasSiswaTodayAjaranAktif($kelas,$nis,$tanggal)
    {
        try {
            $stmt = $this->conn->prepare(
                "SELECT t_kehadiran.waktu, t_relasifp.NAMA as guru, t_mapel.nama as mapel, t_kehadiran.status
                FROM t_kehadiran
                INNER JOIN t_relasifp ON t_relasifp.NO_INDUK=t_kehadiran.guru_id
                INNER JOIN t_mapel ON t_mapel.id=t_kehadiran.mapel_id
                WHERE t_kehadiran.kelas_id='$kelas'
                AND t_kehadiran.no_induk='$nis'
                AND t_kehadiran.tanggal='$tanggal'
                AND t_kehadiran.semester='$this->semester'
                AND t_kehadiran.tahun_ajaran='$this->tahun'");
            $stmt->execute();
            $rowFinger = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rowFinger;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getByKelasAjaranAktif($kelas,$mapel,$waktu,$tanggal)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM t_kehadiran WHERE kelas_id='$kelas' AND semester='$this->semester' AND tahun_ajaran='$this->tahun' AND mapel_id = '$mapel' AND kelas_id='$kelas' AND waktu='$waktu' AND tanggal='$tanggal'");
            $stmt->execute();
            $rowFinger = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rowFinger;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getByKelasAjaranAktifFirstTime($kelas,$tanggal)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM t_kehadiran WHERE kelas_id='$kelas' AND semester='$this->semester' AND tahun_ajaran='$this->tahun' AND waktu='Jam Ke-1' AND tanggal='$tanggal'");
            $stmt->execute();
            $rowFinger = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rowFinger;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getDateGroupByKelasMapel($kelas_id,$mapel_id)
    {
        try {
            $stmt = $this->conn->prepare("SELECT tanggal
                        FROM t_kehadiran
                        WHERE kelas_id='$kelas_id'
                        AND mapel_id='$mapel_id'
                        AND semester='$this->semester'
                        AND tahun_ajaran='$this->tahun'
                        GROUP BY tanggal");
            $stmt->execute();
            $rowFinger = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rowFinger;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getSiswaGroupByKelasMapel($kelas_id,$mapel_id)
    {
        try {
            $stmt = $this->conn->prepare(
                "SELECT t_kehadiran.no_induk, t_relasifp.NAMA as nama, t_kelas.kelas
                FROM t_kehadiran
                INNER JOIN t_relasifp ON t_relasifp.NO_INDUK=t_kehadiran.no_induk
                INNER JOIN t_mapel ON t_mapel.id=t_kehadiran.mapel_id
                INNER JOIN t_kelas ON t_kelas.id_kelas=t_kehadiran.kelas_id
                WHERE t_kehadiran.kelas_id='$kelas_id'
                AND t_kehadiran.mapel_id='$mapel_id'
                AND t_kehadiran.semester='$this->semester'
                AND t_kehadiran.tahun_ajaran='$this->tahun'
                GROUP BY t_kehadiran.no_induk");
            $stmt->execute();
            $rowFinger = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rowFinger;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getStatusByIndukKelasMapel($no_induk,$kelas_id,$mapel_id,$tanggal)
    {
        try {
            $stmt = $this->conn->prepare(
                "SELECT t_kehadiran.status
                FROM t_kehadiran
                INNER JOIN t_relasifp ON t_relasifp.NO_INDUK=t_kehadiran.no_induk
                INNER JOIN t_mapel ON t_mapel.id=t_kehadiran.mapel_id
                INNER JOIN t_kelas ON t_kelas.id_kelas=t_kehadiran.kelas_id
                WHERE t_kehadiran.kelas_id='$kelas_id'
                AND t_kehadiran.mapel_id='$mapel_id'
                AND t_kehadiran.no_induk='$no_induk'
                AND t_kehadiran.tanggal = '$tanggal'
                -- AND t_kehadiran.waktu = 'Jam Ke-1'
                AND t_kehadiran.semester='$this->semester'
                AND t_kehadiran.tahun_ajaran='$this->tahun'");
            $stmt->execute();
            $rowFinger = $stmt->fetch(PDO::FETCH_ASSOC);

            return $rowFinger['status'];
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getById($id)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM t_kehadiran WHERE id = $id ");
            $stmt->execute();
            $rowFinger = $stmt->fetch(PDO::FETCH_ASSOC);

            return $rowFinger;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function deleteByKelasMapel($kelas,$mapel,$waktu,$tanggal)
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM t_kehadiran WHERE mapel_id='$mapel' AND kelas_id='$kelas' AND waktu='$waktu' AND tanggal='$tanggal' AND semester='$this->semester' AND tahun_ajaran='$this->tahun'");
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
            $stmt = $this->conn->prepare('INSERT INTO t_kehadiran (id,no_induk,guru_id,mapel_id,kelas_id,`status`,waktu,tanggal,semester,tahun_ajaran) VALUES (NULL,?,?,?,?,?,?,?,?,?)');
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
            $stmt = $this->conn->prepare("UPDATE t_kehadiran SET no_induk=?, guru_id=?, mapel_id=?, kelas_id=?, `status`=?, waktu=?, tanggal=?, semester=?, tahun_ajaran=? WHERE id='$id'");
            $stmt->execute($data);
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function destroy($id)
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM t_kehadiran WHERE id = $id ");
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
        if ($data['kelas_id'] != '') {
            $result[] = $data['kelas_id'];
        }
        if ($data['status'] != '') {
            $result[] = $data['status'];
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
