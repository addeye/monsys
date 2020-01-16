<?php
spl_autoload_register(function ($class) {
    include '../class/' . $class . '.php';
});

$user = new User();
$data = $user->generateResetPasswordAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Generate Password</title>
</head>
<body>
    <h2>Total <?=count($data)?></h2>
    <?php foreach($data as $value): ?>
    <p><?=$value?></p>
    <?php endforeach; ?>
</body>
</html>