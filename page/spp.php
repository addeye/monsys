<?php
$user->cek_siswa();
$spp = new Spp();
$user = new User();
$kelas = $user->getKelas();

$row = $user->getById($_SESSION['user_id']);
$data = $spp->getByNis($_SESSION['user_id']);

?>
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        SPP & Partisipasi Masyarakat
      </h1>
      <ol class="breadcrumb">
        <li class="active"><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">SPP & Pertsipasi Masyarakat</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="callout callout-warning">
        <h4>Terima Kasih</h4>
        <p>Telah Melunasi SPP & Partisipasi Masyarakat Tepat Waktu. Apabila terdapat perbedaan dalam data yang ditampilkan, maka data yang digunakan adalah Data fisik di Administrasi Sekolah.</p>
      </div>
      <div class="callout callout-danger">
        <p>Update Terakhir</p>
        <h4><?=tanggal_indo($spp->getDateImport(), true)?></h4>
      </div>
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">SPP & Pertsipasi Masyarakat</h3>
          <p><strong><?=$_SESSION['user_id']?> <?=$_SESSION['user_name']?> <?=$row['KELAS']?></strong></p>
        </div>
        <div class="box-body">
          <div class="row">

          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-bordered">
              <thead>
                <tr>
                  <td>No</td>
                  <td>BULAN</td>
                  <td>TAHUN</td>
                  <td>TANGGAL BAYAR</td>
                </tr>
              </thead>
              <tbody>
                <?php $no = 1; foreach ($data as $key => $value): ?>
                <tr>
                  <td><?=$no++;?></td>
                  <td><?=$value['BULAN']?></td>
                  <td><?=$value['TAHUN']?></td>
                  <td><?=date('d/m/Y', strtotime($value['TANGGAL_BAYAR']))?></td>
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