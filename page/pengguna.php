<?php
$user = new User();
$data = $user->getAll();

$guru = 0;
$siswa = 0;
$tu = 0;

if (isset($_POST['nama'])) {
}

foreach ($data as $key => $value) {
    if ($value['TINGKAT'] == 'GURU') {
        $guru++;
    } elseif ($value['TINGKAT'] == 'TU') {
        $tu++;
    } elseif ($value['TINGKAT'] == 'X' or $value['TINGKAT'] == 'XI' or $value['TINGKAT'] == 'XII') {
        $siswa++;
    }
}

?>
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Pengguna
      </h1>
      <ol class="breadcrumb">
        <li class="active"><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Pengguna</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Pengguna</h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?=$guru?></h3>
              <p>Staf Guru</p>
            </div>
            <div class="icon">
              <i class="ion ion-person"></i>
            </div>
          </div>

        </div>
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?=$tu?></h3>

              <p>Staf TU</p>
            </div>
            <div class="icon">
              <i class="ion ion-person"></i>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-blue">
            <div class="inner">
              <h3><?=$siswa?></h3>

              <p>Siswa</p>
            </div>
            <div class="icon">
              <i class="ion ion-person"></i>
            </div>
          </div>
        </div>
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-bordered">
              <thead>
                <tr>
                  <th>No Induk</th>
                  <th>Nama</th>
                  <th>No HP</th>
                  <th>Kelas</th>
                  <th>Tingkat</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($data as $key => $value): ?>
                <tr>
                  <td><?=$value['NO_INDUK']?></td>
                  <td><?=$value['NAMA']?></td>
                  <td><?=$value['NO_HP']?></td>
                  <td><?=$value['KELAS']?></td>
                  <td><?=$value['TINGKAT']?></td>
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