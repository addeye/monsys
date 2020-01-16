<?php
if(isset($_GET['mapel_id'])){
    $kd = new Kd();
    $data = $kd->getByMapel($_GET['mapel_id']);
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