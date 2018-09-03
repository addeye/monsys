<?php
$spp = new Spp();

$user = new User();
$kelas = $user->getKelas();

$row = $user->getById($_SESSION['user_id']);
?>
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        SPP
      </h1>
      <ol class="breadcrumb">
        <li class="active"><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">SPP & Partisipasi Masyarakat</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="callout callout-warning">
        <p>Update Terakhir</p>
        <h4><?=tanggal_indo($spp->getDateImport(), true)?></h4>
      </div>
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">SPP & Partisipasi Masyarakat</h3>
        </div>
        <div class="box-body">

          <?php if (isset($_GET['masuk'])): ?>
            <div class="callout callout-info">
              <h4>Data berhasil dimasukkan <?=$_GET['masuk']?> record</h4>
            </div>
          <?php endif;?>

          <div class="col-md-12 row">
            <form method="post" action="page/spp_import.php" class="form-inline" enctype="multipart/form-data">
            <div class="form-group">
              <input type="file" name="excel" placeholder="File" required>
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-primary">Import</button>
            </div>
          </form>
          <a target="_blank" href="files/master_import_spp.xls"><i class="fa fa-download"></i> Donwload Template Excel</a>
          </div>
          <hr>
          <div class="row">
            <?php if ($_POST): ?>
          <div class="col-md-12">
            <h4><?=$alert?></h4>
          </div>
          <?php endif;?>
          </div>
        </div>
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->