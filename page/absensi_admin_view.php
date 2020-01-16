<?php

session_start();

spl_autoload_register(function ($class) {
	include '../class/' . $class . '.php';
});

$absensi = new Absensi();
$kelas_sel = '';

$from = $_GET['from'];
$to = $_GET['to'];
$kelas_sel = $_GET['kelas'];

$date = $from;

$row_date = array();

while ($date <= $to) {
	$row_date[] = $date;
	// echo $date . "\n";
	$date = date('Y-m-d', strtotime($date . ' +1 day'));
}

$data = $absensi->getAllByRangeDateKelas($kelas_sel, $row_date);

// return var_dump($data);

$user = new User();
$kelas = $user->getKelas();

$row = $user->getById($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?=$from?> - <?=$to?> | <?=$kelas_sel?></title>
</head>
<body>
  <table border="1" cellpadding="5" cellspacing="0">
  <thead>
    <tr>
      <td rowspan="2">NIS</td>
      <td rowspan="2">KELAS</td>
      <td rowspan="2">NAMA</td>
      <?php foreach ($row_date as $key => $value): ?>
      <td colspan="2"><?=date('d-m-Y', strtotime($value))?></td>
      <?php endforeach;?>
    </tr>
    <tr>
      <?php foreach ($row_date as $key => $value): ?>
      <td>Masuk</td>
      <td>Pulang</td>
      <?php endforeach;?>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($data as $key => $value): ?>
    <tr>
      <td><?=$value['NO_INDUK']?></td>
      <td><?=$value['KELAS']?></td>
      <td><?=$value['NAMA']?></td>
      <?php foreach ($value['absensi'] as $k => $val): ?>
        <td><?=isset($val['timein']) ? $val['timein'] : ''?></td>
        <td><?=isset($val['timeout']) ? $val['timeout'] : ''?></td>
      <?php endforeach;?>
    </tr>
    <?php endforeach;?>
  </tbody>
</table>
</body>
</html>