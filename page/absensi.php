<?php
$user->cek_siswa();
$absensi = new Absensi();
$user = new User();

$row = $user->getById($_SESSION['user_id']);

if ($_POST) {
    $nis = $_SESSION['user_id'];
    $from = $_POST['from'];
    $to = $_POST['to'];
    $data = $absensi->getAllByRangeDate($nis, $from, $to);

    $masuk = 0;
    $pulang = 0;

    foreach ($data as $key => $value) {
        if ($value['timein'] != '') {
            $masuk++;
        }

        if ($value['timeout'] != '') {
            $pulang++;
        }
    }
}
?>
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Absensi
      </h1>
      <ol class="breadcrumb">
        <li class="active"><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Absensi</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="callout callout-warning">
        <h4>Catatan :</h4>
        <p>Biasakan Selalu Melakukan Absensi Fingerprint Ketika Masuk dan Pulang!</p>
      </div>
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Absensi</h3>
          <p><strong><?=$_SESSION['user_id']?> <?=$_SESSION['user_name']?> <?=$row['KELAS']?></strong></p>
        </div>
        <div class="box-body">
          <div class="col-md-12 row">
            <form method="post" class="form-inline">
            <div class="form-group">
              <label>Mulai</label>
              <input type="date" name="from" class="form-control" value="<?=isset($from) ? $from : ''?>">
            </div>
            <div class="form-group">
              <label>Selesai</label>
              <input type="date" name="to" class="form-control" value="<?=isset($to) ? $to : ''?>">
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-primary">Tampilkan</button>
            </div>
          </form>
          </div>
          <hr>
          <div class="row">
            <?php if (isset($data)): ?>
            <div class="col-md-12 row">
              <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?=$masuk?></h3>

              <p>Absen Masuk</p>
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
              <h3><?=$pulang?></h3>

              <p>Absen Pulang</p>
            </div>
            <div class="icon">
              <i class="ion ion-home"></i>
            </div>
          </div>
        </div>
            </div>
          <div class="col-md-12">
              <table class="table table-bordered">
              <thead>
                <tr>
                  <td>Tanggal</td>
                  <td>Masuk</td>
                  <td>Pulang</td>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($data as $key => $value): ?>
                <tr>
                  <td><?=date('d-m-Y', strtotime($value['tdate']))?></td>
                  <td class="<?=$value['timein'] == '' ? 'help-block-green' : ''?>"><?=$value['timein']?></td>
                  <td class="<?=$value['timeout'] == '' ? 'help-block-orange' : ''?>"><?=$value['timeout']?></td>
                </tr>
              <?php endforeach;?>
              </tbody>
            </table>

          </div>
          <?php endif;?>
          </div>
        </div>
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->