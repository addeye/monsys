<?php
if(isset($_GET['kelas_id'])){
    $mapel = new Mapel();
    $data = $mapel->getByMengajarGuru($_SESSION['user_id'],$_GET['kelas_id']);
    if($data){
        $response = array(
            'status' => true,
            'message' => 'Success',
            'data' => $data
        );
    }
}else{
    $response = array(
        'status' => false,
        'message' => 'Ada kesalahan',
    );
}
echo json_encode($response);
?>