<?php
if(isset($_GET['kelas_id'])){
    $kelas = new Kelas();
    $data = $kelas->getById($_GET['kelas_id']);
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