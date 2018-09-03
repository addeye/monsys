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
            $stmt = $this->conn->prepare('SELECT * FROM t_relasifp WHERE NO_INDUK=:uusername and NO_INDUK=:upassword');
            $stmt->execute([':uusername' => $data['nis'], ':upassword' => $data['password']]);
            $userRow = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($stmt->rowCount() == 1) {
                $_SESSION['user_id'] = $userRow['NO_INDUK'];
                $_SESSION['user_name'] = $userRow['NAMA'];
                if (strlen($userRow['NO_INDUK']) > 4) {
                    $_SESSION['level'] = 'admin';
                } else {
                    $_SESSION['level'] = 'siswa';
                }
                return true;
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

    public function cek_siswa()
    {
        if ($_SESSION['level'] == 'siswa') {
            return true;
        }
        error('Anda tidak memiliki hak akses');
        $this->redirect('/');
    }

    public function getLogout()
    {
        session_destroy();
        // unset($_SESSION['user_session']);
        return true;
    }
}
