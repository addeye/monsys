<?php
$user->cek_siswa();
$kelas = new Kelas();
$mapel = new Mapel();
$kd = new Kd();
$akademik = new Akademik();


$siswa = $akademik->getByNisAjaranAktif($_SESSION['user_id']);

// $kelas_row = $kelas->getByMengajarGuru($_SESSION['user_id']);
$mapel_row = $mapel->getAll();
$kelas_row = $kelas->getById($siswa['kelas_id']);

?>
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data Jurnal
      </h1>
      <ol class="breadcrumb">
        <li class="active"><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Data Jurnal</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Tambah Jurnal</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <form action="page/jurnal_siswa_act.php" method="post">
                        <input type="hidden" name="aksi" value="add">
                        <div class="form-group">
                            <label for="">Pilih Kelas</label>
                            <select name="kelas_id" onchange="showMapelByKelasOnly(this.value,'#mapel_id')" class="form-control" required>
                                <option value="">Pilih Kelas</option>
                                <option value="<?=$kelas_row['id_kelas']?>"><?=$kelas_row['kelas']?></option>
                            </select>
                        </div>
                        <div class="form-group">
                          <label for="">Jenis Kegiatan</label>
                            <select name="kegiatan" class="form-control">
                            <option value="">Pilih Kegiatan</option>
                            <?php foreach(jenis_kegiatan() as $jk): ?>
                                <option value="<?=$jk?>"><?=$jk?></option>
                            <?php endforeach;?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Tanggal</label>
                            <input type="date" value="<?=date('Y-m-d')?>" class="form-control" name="tanggal" required>
                            <p class="help-block">Default tanggal sekarang</p>
                        </div>
                        <div class="form-group">
                          <label for="">Pilih Jam Pelajaran</label>
                            <select name="waktu[]" multiple class="form-control js-data-example-ajax">
                            <?php foreach(jamke() as $j): ?>
                                <option value="<?=$j?>"><?=$j?></option>
                            <?php endforeach;?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Pilih Mapel</label>
                            <select name="mapel_id" id="mapel_id" onchange="showKdByMapelTingkat(this.value,'#kd_id')" class="form-control" required>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Pilih KD</label>
                            <div id="kd_id">
                            </div>
                        </div>
                        <button class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
                        <a href="index.php?page=jurnal" class="btn btn-warning"><i class="fa fa-reply"></i> Kembali</a>
                    </form>
                </div>
            </div>

        </div>
      </div>
      <!-- /.box -->
    </section>