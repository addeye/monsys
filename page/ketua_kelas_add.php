<?php
$user->cek_admin();
$userdata = new User();
$kelas = new Kelas();

$kelas = $kelas->getAll();
?>
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Tambah Ketua Kelas
      </h1>
      <ol class="breadcrumb">
        <li class="active"><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Tambah Ketua Kelas</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Tambah Ketua Kelas</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <form action="page/ketua_kelas_act.php" method="post">
                        <input type="hidden" name="aksi" value="add">
                        <div class="form-group">
                            <label for="">Pilih Kelas</label>
                            <select name="kelas_id" class="form-control js-data-example-ajax" onchange="showSiswaByKelas(this.value,'#no_induk')">
                                <option value="">Pilih</option>
                                <?php foreach ($kelas as $row): ?>
                                <option value="<?=$row['id_kelas']?>"><?=$row['kelas']?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Siswa</label>
                            <select name="no_induk" id="no_induk" class="form-control js-data-example-ajax">
                                <option value="">Pilih Siswa</option>
                            </select>
                        </div>
                        <button class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
                        <a href="index.php?page=ketua_kelas" class="btn btn-warning"><i class="fa fa-reply"></i> Kembali</a>
                    </form>
                </div>
            </div>

        </div>
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->