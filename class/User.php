<?php

/**
 *
 */
class User extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAll()
    {
        try {
            $stmt = $this->conn->prepare('SELECT * FROM t_relasifp ORDER BY TINGKAT');
            $stmt->execute();
            $rowFinger = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rowFinger;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getSiswa()
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM t_relasifp WHERE TINGKAT IN ('X','XI','XII') ORDER BY TINGKAT");
            $stmt->execute();
            $rowFinger = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rowFinger;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getGuru()
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM t_relasifp WHERE TINGKAT='GURU' ");
            $stmt->execute();
            $rowFinger = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rowFinger;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function store($data = [])
    {
        try {
            $data = $this->transformasiData($data);
            $stmt = $this->conn->prepare('INSERT INTO t_relasifp(FPID,NO_INDUK,NAMA,NO_HP,KELAS,TINGKAT,`PASSWORD`) VALUES (?,?,?,?,?,?,?)');
            $stmt->execute($data);
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function updateKelas($data = [], $id)
    {
        try {
            $data = $this->transformasiUpdate($data);
            $stmt = $this->conn->prepare("UPDATE t_relasifp SET KELAS=?, TINGKAT=? WHERE NO_INDUK='$id'");
            $stmt->execute($data);
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getById($id)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM t_relasifp WHERE NO_INDUK=$id");
            $stmt->execute();
            $rowFinger = $stmt->fetch(PDO::FETCH_ASSOC);

            return $rowFinger;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getKelas()
    {
        try {
            $stmt = $this->conn->prepare("SELECT DISTINCT KELAS FROM t_relasifp WHERE TINGKAT != 'GURU' AND TINGKAT != 'TU' AND TINGKAT != 'PERHU' ORDER BY KELAS");
            $stmt->execute();
            $rowFinger = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rowFinger;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function destroy($id)
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM t_relasifp WHERE FPID = $id ");
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function generateResetPasswordOne($id){
        try {
            $data = $this->getById($id);
            $newpassword = trim(password_hash(md5($data['NO_INDUK']), PASSWORD_BCRYPT, [12]));
            $stmt = $this->conn->prepare("UPDATE t_relasifp SET `PASSWORD`='$newpassword' WHERE FPID='$id'");
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function generateResetPasswordAll(){
        try {
            $data = $this->getAll();
            $rows = [];
            foreach($data as $u){
                $newpassword = trim(password_hash(md5($u['NO_INDUK']), PASSWORD_BCRYPT, [12]));
                $stmt = $this->conn->prepare("UPDATE t_relasifp SET `PASSWORD`='$newpassword' WHERE NO_INDUK='$u[NO_INDUK]'");
                $stmt->execute();
                $rowFinger = $this->getById($u['NO_INDUK']);
                $rows[] = $rowFinger['NAMA']." Selesai Generate Password";
            }
            return $rows;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function changePassword($oldpassword,$newpassword,$id)
    {
        try {
            $data = $this->getById($id);

            //check match oldpassword
            if(password_verify(md5($oldpassword),$data['PASSWORD'])){

                $newpassword = trim(password_hash(md5($newpassword), PASSWORD_BCRYPT, [12]));
                $stmt = $this->conn->prepare("UPDATE t_relasifp SET `PASSWORD`='$newpassword' WHERE NO_INDUK='$id'");
                $stmt->execute();
                return true;
            }else{
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    private function transformasiData($data = [])
    {
        $result = [];
        if ($data['FPID'] != '') {
            $result[] = $data['FPID'];
        }
        if ($data['NO_INDUK'] != '') {
            $result[] = $data['NO_INDUK'];
        }
        if ($data['NAMA'] != '') {
            $result[] = $data['NAMA'];
        }
        if ($data['NO_HP'] != '') {
            $result[] = $data['NO_HP'];
        }
        if ($data['KELAS'] != '') {
            $result[] = $data['KELAS'];
        }
        if ($data['TINGKAT'] != '') {
            $result[] = $data['TINGKAT'];
        }
        $result[] = trim(password_hash(md5($data['FPID']), PASSWORD_BCRYPT, [12]));
        return $result;
    }

    private function transformasiUpdate($data = [])
    {
        $result = [];
        if ($data['KELAS'] != '') {
            $result[] = $data['KELAS'];
        }
        if ($data['TINGKAT'] != '') {
            $result[] = $data['TINGKAT'];
        }
        return $result;
    }
}
