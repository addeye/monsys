<?php
header("Content-Type: application/json");
session_start();
date_default_timezone_set('Asia/Jakarta');
spl_autoload_register(function ($class) {
    include '../class/' . $class . '.php';
});

$tajaran = new TahunAjaran();
$th = $tajaran->getByActive();

$user = new Auth();
$response=array();

if (!$user->cek_login()) {
    // session no set redirects to login page
    // $user->redirect('login.php');
    $response = array(
        "status" => false,
        "message" => "Tidak punya hak akases!"
    );
    echo json_encode($response);
    return false;
}

ob_start();
if(isset($_GET['req']) && file_exists($_GET['req'] . '.php')){
    include $_GET['req'] . '.php';
}
return false;
?>