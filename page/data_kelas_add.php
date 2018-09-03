<?php
$user->cek_admin();
?>
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data Kelas
      </h1>
      <ol class="breadcrumb">
        <li class="active"><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Data Kelas</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Tambah Kelas</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <form action="page/data_kelas_act.php" method="post">
                        <input type="hidden" name="aksi" value="add">
                        <div class="form-group">
                            <label for="">Nama Kelas</label>
                            <input type="text" name="kelas" class="form-control" placeholder="Nama Kelas" required>
                        </div>
                        <div class="form-group">
                            <label for="">Tingkat</label>
                            <select name="tingkat" class="form-control" required>
                                <option value="">Pilih</option>
                                <option value="X">X</option>
                                <option value="XI">XI</option>
                                <option value="XII">XII</option>
                            </select>
                        </div>
                        <button class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
                        <a href="index.php?page=data_kelas" class="btn btn-warning"><i class="fa fa-reply"></i> Kembali</a>
                    </form>
                </div>
            </div>

        </div>
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->