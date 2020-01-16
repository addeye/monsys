<?php
class TahunAjaran extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAll()
    {
        try {
            $stmt = $this->conn->prepare('SELECT * FROM t_ajaran');
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
            $stmt = $this->conn->prepare("SELECT * FROM t_ajaran WHERE id = $id ");
            $stmt->execute();
            $rowFinger = $stmt->fetch(PDO::FETCH_ASSOC);

            return $rowFinger;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getByActive()
    {
        try {
            $stmt = $this->conn->prepare("SELECT t_ajaran.*, t_semester.nama as semester FROM t_ajaran INNER JOIN t_semester ON t_ajaran.semester_id=t_semester.id WHERE status = 'Yes' ");
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
            $stmt = $this->conn->prepare('INSERT INTO `t_ajaran`(`id`, `nama`,`semester_id`, `status`) VALUES (NULL,?,?,?)');
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
            $stmt = $this->conn->prepare("UPDATE t_ajaran SET nama=? WHERE id='$id'");
            $stmt->execute($data);
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function destroy($id)
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM t_ajaran WHERE id = $id ");
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function set_active($id)
    {
        try {
            $stmt = $this->conn->prepare("UPDATE t_ajaran SET status='Yes' WHERE id = $id");
            $stmt->execute();

            $stmt = $this->conn->prepare("UPDATE t_ajaran SET status='No' WHERE id != $id");
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function set_semester($id,$semester_id)
    {
        try {
            $stmt = $this->conn->prepare("UPDATE t_ajaran SET semester_id=$semester_id WHERE id = $id");
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
        //semester_id
        $result[] = 1;

        if ($data['status'] != '') {
            $result[] = $data['status'];
        }
        return $result;
    }
}
