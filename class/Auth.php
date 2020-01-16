<?php

/**
 *
 */
class Auth extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function do_login($data = [])
    {
        try {

            $user=$data['nis'];
            $pass=$data['password'];

            $stmt = $this->conn->prepare('SELECT * FROM t_relasifp WHERE NO_INDUK=:uusername');
            $stmt->execute([':uusername' => $user]);
            $userRow = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($stmt->rowCount() == 1) {

                if(password_verify(md5($pass),$userRow['PASSWORD'])){

                    $_SESSION['user_id'] = $userRow['NO_INDUK'];
                    $_SESSION['user_name'] = $userRow['NAMA'];

                    if($userRow['KELAS']=='ADMIN'){
                        $_SESSION['level'] = 'admin';
                    }elseif($userRow['KELAS']=='GURU'){
                        $_SESSION['level'] = 'guru';
                    } elseif(strlen($userRow['NO_INDUK'])==4) {
                        $_SESSION['level'] = 'siswa';
                    }
                    return true;
                }
            }
            return false;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function cek_login()
    {
        if (isset($_SESSION['user_id'])) {
            return true;
        }
    }

    public function cek_admin()
    {
        if ($_SESSION['level'] == 'admin') {
            return true;
        }
        error('Anda tidak memiliki hak akses');
        $this->redirect('/');
    }

    public function cek_guru()
    {
        if ($_SESSION['level'] == 'guru') {
            return true;
        }
        error('Anda tidak memiliki hak akses');
        $this->redirect('/');
    }

    public function cek_guru_piket()
    {
        if ($_SESSION['level'] == 'guru') {
            $p = new Piket();
            $check = $p->getByGuruAktif($_SESSION['user_id']);
            if($check){
                return true;
            }
        }
        error('Anda tidak memiliki hak akses');
        $this->redirect('/');
    }

    public function cek_wakakur()
    {
        if ($_SESSION['level'] == 'guru') {
            $p = new Wakakur();
            $check = $p->getByGuruAktif($_SESSION['user_id']);
            if($check){
                return true;
            }
        }
        error('Anda tidak memiliki hak akses');
        $this->redirect('/');
    }

    public function cek_siswa()
    {
        if ($_SESSION['level'] == 'siswa') {
            return true;
        }
        error('Anda tidak memiliki hak akses');
        $this->redirect('/');
    }

    public function cek_siswa_ketua_kelas($no_induk)
    {
        $p = new KetuaKelas();
        $check = $p->getBySiswaAktif($no_induk);
        if($check){
            return true;
        }
        error('Anda tidak memiliki hak akses');
        $this->redirect('/');
    }

    public function ketua_kelas_checking($no_induk)
    {
        $p = new KetuaKelas();
        $check = $p->getBySiswaAktif($no_induk);
        if($check){
            return true;
        }
        return false;
    }

    public function guru_piket_checking($id)
    {
        $p = new Piket();
        $check = $p->getByGuruAktif($id);
        if($check){
            return true;
        }
        return false;
    }

    public function wakakur_checking($id)
    {
        $p = new Wakakur();
        $check = $p->getByGuruAktif($id);
        if($check){
            return true;
        }
        return false;
    }

    public function getLogout()
    {
        session_destroy();
        // unset($_SESSION['user_session']);
        return true;
    }
}
