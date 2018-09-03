<?php
require_once '../session.php';

$akademik = new Akademik();
$term = $_REQUEST['term'];
$data = $akademik->getByAjaranSearch($th['nama'], $term);

$collect = [];
foreach ($data as $row) {
    $col = [
        'id' => $row['no_induk'],
        'text' => $row['nama']
    ];
    $collect[] = $col;
}
$final = [
    'result' => $collect,
];

echo json_encode($final);
