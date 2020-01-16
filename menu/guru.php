<ul class="sidebar-menu" data-widget="tree">
  <li class="header">MAIN NAVIGATION</li>
  <li>
    <a href="index.php">
      <i class="fa fa-home"></i> <span>Dashboard</span>
    </a>
  </li>
 <li>
    <a href="index.php?page=penilaian">
      <i class="fa fa-check-square"></i> <span>Monitoring KBM</span>
    </a>
  </li>
  <li>
    <a href="index.php?page=jurnal">
      <i class="fa fa-check-square"></i> <span>Jurnal</span>
    </a>
  </li>
  <li>
    <a href="index.php?page=kehadiran">
      <i class="fa fa-check-square"></i> <span>Absen Kehadiran</span>
    </a>
  </li>
  <li>
    <a href="index.php?page=rekap_kehadiran">
      <i class="fa fa-check-square"></i> <span>Rekap Kehadiran Siswa</span>
    </a>
  </li>
  <?php if($user->guru_piket_checking($_SESSION['user_id'])): ?>
  <li class="treeview">
    <a href="#">
      <i class="fa fa-graduation-cap"></i>
      <span>Guru Piket</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li><a href="index.php?page=kehadiran_piket"><i class="fa fa-circle-o"></i> Absensi</a></li>
      <li><a href="index.php?page=laporan_piket"><i class="fa fa-circle-o"></i> Laporan</a></li>
    </ul>
  </li>
<?php endif; ?>

<?php if($user->wakakur_checking($_SESSION['user_id'])): ?>
  <li class="treeview">
    <a href="#">
      <i class="fa fa-graduation-cap"></i>
      <span>Wakakur</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li><a href="index.php?page=absensi_guru"><i class="fa fa-circle-o"></i> Absensi Guru</a></li>
    </ul>
  </li>
<?php endif; ?>
</ul>