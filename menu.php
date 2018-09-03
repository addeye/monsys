<?php 
if ($_SESSION['level'] == "siswa") { 

  include('menu/siswa.php');

} elseif ($_SESSION['level'] == 'admin') { 

  include('menu/admin.php');

} ?>


<!-- ADMIN -->
