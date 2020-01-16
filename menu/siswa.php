<ul class="sidebar-menu" data-widget="tree">
  <li class="header">MAIN NAVIGATION</li>
  <li>
    <a href="index.php">
      <i class="fa fa-home"></i> <span>Dashboard</span>
    </a>
  </li>
  <!-- <li>
    <a href="index.php?page=pembayaran_siswa">
      <i class="fa fa-dollar"></i> <span>Pembayaran</span>
    </a>
  </li> -->
  <li>
    <a href="index.php?page=jurnal_siswa">
      <i class="fa fa-file"></i> <span>Jurnal</span>
    </a>
  </li>

  <!-- <li>
    <a href="index.php?page=absensi">
      <i class="fa fa-check-square"></i> <span>Absensi</span>
    </a>
  </li>
  <li>
    <a href="index.php?page=spp">
      <i class="fa fa-list-alt"></i> <span>SPP & Partisipasi Masyarakat</span>
    </a>
  </li> -->

  <?php if($user->ketua_kelas_checking($_SESSION['user_id'])): ?>
      <li>
      <a href="index.php?page=absensi_kehadiran_kelas">
      <i class="fa fa-check-circle"></i> Absensi Kehadiran Kelas
      </a>
    </li>
  <?php endif; ?>
  <li>
    <a href="index.php?page=kehadiran_siswa">
      <i class="fa fa-check-circle"></i> <span>Kehadiran</span>
    </a>
  </li>
  <li>
    <a href="index.php?page=penilaian_siswa">
      <i class="fa fa-check-square"></i> <span>Monitoring KBM</span>
    </a>
  </li>
</ul>