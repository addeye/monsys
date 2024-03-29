<?php
$user->cek_admin();
?>
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Data Tahun Pelajaran
      </h1>
      <ol class="breadcrumb">
        <li class="active"><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Data Tahun Pelajaran</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Tambah Tahun Pelajaran</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <form action="page/tahun_ajaran_act.php" method="post">
                        <input type="hidden" name="status" value="No">
                        <input type="hidden" name="aksi" value="add">
                        <div class="form-group">
                            <label for="">Tahun Pelajaran</label>
                            <input type="text" name="nama" class="form-control" placeholder="Contoh : 2018/2019" required>
                        </div>
                        <button class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
                        <a href="index.php?page=tahun_ajaran" class="btn btn-warning"><i class="fa fa-reply"></i> Kembali</a>
                    </form>
                </div>
            </div>

        </div>
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->