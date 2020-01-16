<?php
$user->cek_admin();
$akademik = new Akademik();
$data = $akademik->getByAjaran($th['nama']);
$kelasf = new Kelas();
$userf = new User();

?>
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data Siswa dan Guru
      </h1>
      <ol class="breadcrumb">
        <li class="active"><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Data Siswa dan Guru</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    <div class="box">
          <div class="box-header">
            <h3 class="box-title">Import | Tahun Ajaran <?=$th['nama']?></h3>
          </div>
          <div class="box-body">
          <form class="form-inline" method="POST" action="page/data_siswa_import.php" enctype="multipart/form-data">
            <div class="form-group">
                <input type="file" name="file_siswa">
                <p class="help-block"><a target="_blank" href="files/data_siswa_import.xls"><i class="fa fa-file"></i> Download Template</a></p>
            </div>
            <div class="form-group">
              <button class="btn btn-primary">Import</button>
            </div>
            </form>
          </div>
      </div>
    <div class="box">
          <div class="box-header">
            <h3 class="box-title">Filter</h3>
          </div>
          <div class="box-body">
          <form class="form-inline">
            <div class="form-group">
                <input type="text" name="search" id="search" class="form-control" placeholder="Pencarian NIS,NAMA">
            </div>
            </form>
          </div>
      </div>
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Untuk Melihat data Guru terdapat pada menu Pengguna</h3>
        </div>
        <div class="box-body">
          <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table id="table" class="table table-bordered">
              <thead>
                <tr>
                  <th>No Induk</th>
                  <th>Nama</th>
                  <th>Kelas</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($data as $row): ?>
                <tr>
                  <td><?=$row['no_induk']?></td>
                  <td><?=$userf->getById($row['no_induk'])['NAMA']?></td>
                  <td><?=$kelasf->getById($row['kelas_id'])['kelas']?></td>
                </tr>
              <?php endforeach;?>
              </tbody>
            </table>
            </div>
          </div>
          </div>
        </div>
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->