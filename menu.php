<?php
if ($_SESSION['level'] == "siswa") {

  include('menu/siswa.php');

} elseif ($_SESSION['level'] == 'admin') {

  include('menu/admin.php');

} elseif ($_SESSION['level'] == 'guru') {

  include('menu/guru.php');

}  ?>


<!-- ADMIN -->
