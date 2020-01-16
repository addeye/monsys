<?php
$user->cek_admin();
$kelas = new Kelas();
$rombel = $kelas->getAll();
$siswa = new User();
$sis = $siswa->getSiswa();
?>
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Pengguna
      </h1>
      <ol class="breadcrumb">
        <li class="active"><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Tambah Pengguna</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Tambah Pengguna</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <form action="page/pengguna_act.php" method="post">
                        <input type="hidden" name="aksi" value="add">
                        <div class="form-group">
                            <label for="">NIP Pengguna</label>
                            <input type="text" class="form-control" name="nip" placeholder="NIP Pengguna...">
                            <p class="help-block">Akan jadi username dan password</p>
                        </div>
                        <div class="form-group">
                            <label for="">Nama Pengguna</label>
                            <input type="text" class="form-control" name="nama" placeholder="Nama Pengguna...">
                        </div>
                        <div class="form-group">
                            <label for="">Nomor HP</label>
                            <input type="number" class="form-control" name="no_hp" placeholder="Nomor HP Pengguna...">
                        </div>
                        <div class="form-group">
                            <label for="">Level</label>
                            <select name="kelas" id="kelas" class="form-control">
                                <option value="GURU">GURU</option>
                                <option value="ADMIN">ADMIN</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
                        <a href="index.php?page=pengguna" class="btn btn-warning"><i class="fa fa-reply"></i> Kembali</a>
                    </form>
                </div>
            </div>

        </div>
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->