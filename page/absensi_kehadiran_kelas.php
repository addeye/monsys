<?php
$user->cek_siswa();
$user->cek_siswa_ketua_kelas($_SESSION['user_id']);

$siswa = [];
$kehadiran_row = [];
$mapel_id = '';
$waktu = '';
$tanggal = date('Y-m-d');
$guru_id = '';

$kelas = new Kelas();
$akademik = new Akademik();
$kehadiran = new Kehadiran();
$mapel = new Mapel();
$mengajar = new Mengajar();
// return var_dump($_SESSION['user_id']);

$siswadata = $akademik->getByNisAjaranAktif($_SESSION['user_id']);
$kelas_id = $siswadata['kelas_id'];
$nis = $siswadata['no_induk'];
$mapel = $mapel->getByKelas($kelas_id);

if (isset($_GET['mapel_id'])) {
    $mapel_id = $_GET['mapel_id'];
    $waktu = $_GET['waktu'];
    $tanggal = $_GET['tanggal'];
    $guru = $mengajar->getByMapelKelasAktif($mapel_id, $kelas_id);
    $guru_id = $guru['guru_id'];

    $siswa = $akademik->getByKelasAjaranAktif($kelas_id);

    $kehadiran_row = $kehadiran->getByKelasAjaranAktif($kelas_id, $mapel_id, $waktu, $tanggal);
    if (count($kehadiran_row) > 0) {
        $siswa = $kehadiran->getShowSiswaByKelasAjaranAktif($kelas_id, $mapel_id, $waktu, $tanggal);
    } else {
        $siswa = $akademik->getByKelasAjaranAktif($kelas_id);
    }
}

?>
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Absensi Kehadiran
      </h1>
      <ol class="breadcrumb">
        <li class="active"><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Absensi Kehadiran</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Absensi Kehadiran</h3>
        </div>
        <div class="box-body">
          <div class="row">
          <div class="col-md-12">
            <form class="form-inline" method="GET">
              <input type="hidden" name="page" value="absensi_kehadiran_kelas">
              <div class="form-group">
                    <select name="mapel_id" class="form-control js-data-example-ajax">
                        <option value="">Pilih Mapel</option>
                        <?php foreach ($mapel as $row): ?>
                        <option value="<?=$row['id']?>" <?=isset($_GET['mapel_id']) ? $_GET['mapel_id'] == $row['id'] ? 'selected' : '' : '' ?> ><?=$row['nama']?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <select name="waktu" class="form-control">
                    <?php foreach (jamke() as $j): ?>
                        <option value="<?=$j?>" <?=$waktu == $j ? 'selected' : ''?> ><?=$j?></option>
                    <?php endforeach;?>
                    </select>
                </div>
                <div class="form-group">
                    <input type="date" name="tanggal" class="form-control" value="<?=$tanggal?>"/>
                </div>
                <button class="btn btn-primary"><i class="fa fa-search"></i></button>
            </form>
            <hr>
            <?php if (count($kehadiran_row) > 0): ?>
            <div class="row">
                <div class="col-md-2 col-xs-4">
                    <h4>Total <span class="label label-default"><?=count($siswa)?></span></h4>
                </div>
                <div class="col-md-2 col-xs-4">
                    <h4>Hadir <span class="label label-primary"><?=count(getFilter($siswa, 'status', 'Hadir'))?></span></h4>
                </div>
                <div class="col-md-2 col-xs-4">
                    <h4>Sakit <span class="label label-warning"><?=count(getFilter($siswa, 'status', 'Sakit'))?></span></h4>
                </div>
                <div class="col-md-2 col-xs-4">
                    <h4>Ijin <span class="label label-success"><?=count(getFilter($siswa, 'status', 'Ijin'))?></span></h4>
                </div>
                <div class="col-md-2 col-xs-4">
                    <h4>Alpha <span class="label label-danger"><?=count(getFilter($siswa, 'status', 'Alpha'))?></span></h4>
                </div>
                <div class="col-md-2 col-xs-4">
                    <h4>Terlambat <span class="label" style="background: purple;"><?=count(getFilter($siswa, 'status', 'Terlambat'))?></span></h4>
                </div>
            </div>
            <?php else: ?>
                <?php if ($mapel_id != ''): ?>
                <h4>Total <span class="label label-default"><?=count($siswa)?></span></h4>
                <p class="alert alert-danger">
                    Belum ada absensi ! Silahkan Input Data Baru!
                </p>
                <?php endif;?>
            <?php endif;?>
            <hr>
            <form action="page/absensi_kehadiran_kelas_act.php" method="post">
            <input type="hidden" name="aksi" value="add">
            <input type="hidden" name="mapel_id" value="<?=$mapel_id?>">
            <input type="hidden" name="kelas_id" value="<?=$kelas_id?>">
            <input type="hidden" name="guru_id" value="<?=$guru_id?>">
            <input type="hidden" name="waktu" value="<?=$waktu?>">
            <input type="hidden" name="tanggal" value="<?=$tanggal?>">
            <div class="table-responsive" style="height:400px; overflow-y: scroll;">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th >No</th>
                            <th >NIS</th>
                            <th >NAMA</th>
                            <th >Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($siswa as $key => $s): ?>
                    <input type="hidden" name="no_induk[]" value="<?=$s['no_induk']?>"/>
                    <tr>
                    <td><?=$key + 1?></td>
                    <td><?=$s['no_induk']?></td>
                    <td><?=$s['nama']?></td>
                    <td>
                        <select name="status[]">
                        <?php foreach (status_absen() as $sa): ?>
                            <option value="<?=$sa?>" <?=isset($s['status']) ? $s['status'] == $sa ? 'selected' : '' : '' ?> ><?=$sa?></option>
                        <?php endforeach;?>
                        </select>
                    </td>
                    </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div>
            <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> Simpan</button>
            </form>
          </div>
          </div>
        </div>
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
    <script>
        $(document).ready(function(){
            showMapelByKelas(<?=$kelas_id?>,'#mapel_id',<?=$mapel_id?>);
        });
    </script>