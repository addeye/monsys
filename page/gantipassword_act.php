<?php
$user->cek_login();

$uuser = new User();

if($_POST){
    $do = $uuser->changePassword($_POST['oldpassword'],$_POST['newpassword'],$_SESSION['user_id']);
    if($do){
        success("Berhasil");
    }else{
        error("Gagal");
    }
}

$user->redirect('../index.php?page=gantipassword');

?>
