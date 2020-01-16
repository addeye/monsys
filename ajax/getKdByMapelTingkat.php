<?php
if(isset($_GET['mapel_id']) && isset($_GET['tingkat'])){
    $kd = new Kd();
    $data = $kd->getByMapelWithTingkat($_GET['mapel_id'],$_GET['tingkat']);
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