<?php
$user->cek_admin();
$userdata = new User();
$mapel = new Mapel();
$kelas = new Kelas();

$guru = $userdata->getGuru();
$mapel = $mapel->getAll();
$kelas = $kelas->getAll();
?>
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Tugas Mengajar
      </h1>
      <ol class="breadcrumb">
        <li class="active"><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Tugas Mengajar</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Tambah Tugas Mengajar</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <form action="page/tugas_mengajar_act.php" method="post">
                        <input type="hidden" name="aksi" value="add">
                        <div class="form-group">
                            <label for="">Pilih Guru</label>
                            <select name="guru_id" class="form-control js-data-example-ajax">
                                <option value="">Pilih</option>
                                <?php foreach ($guru as $row): ?>
                                <option value="<?=$row['FPID']?>"><?=$row['NAMA']?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Pilih Mapel</label>
                            <select name="mapel_id" class="form-control js-data-example-ajax">
                                <option value="">Pilih</option>
                                <?php foreach ($mapel as $row): ?>
                                <option value="<?=$row['id']?>"><?=$row['nama']?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Pilih Kelas</label>
                            <select name="kelas_id[]" class="form-control js-data-example-ajax" multiple>
                                <option value="">Pilih</option>
                                <?php foreach ($kelas as $row): ?>
                                <option value="<?=$row['id_kelas']?>"><?=$row['kelas']?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
                        <a href="index.php?page=tugas_mengajar" class="btn btn-warning"><i class="fa fa-reply"></i> Kembali</a>
                    </form>
                </div>
            </div>

        </div>
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->