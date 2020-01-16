<?php
$user->cek_admin();
$absensi = new Absensi();
$kelas_sel = '';

if ($_POST) {

	$from = date('Y-m-d', strtotime($_POST['from']));
	$to = date('Y-m-d', strtotime($_POST['to']));
	$kelas_sel = $_POST['kelas'];
	// return var_dump($data);
}

$user = new User();
$kelas = $user->getKelas();

$row = $user->getById($_SESSION['user_id']);
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
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Rekap Absensi</h3>
        </div>
        <div class="box-body">
          <div class="col-md-12 row">
            <form method="post" class="form-inline">
            <div class="form-group">
              <label>Tanngal Awal</label>
              <input type="date" name="from" class="form-control" value="<?=isset($from) ? $from : ''?>" required>
            </div>
            <div class="form-group">
              <label>Tanggal Akhir</label>
              <input type="date" name="to" class="form-control" value="<?=isset($to) ? $to : ''?>" required>
            </div>
            <div class="form-group">
              <label>Kelas</label>
              <select name="kelas" id="" class="form-control" required>
                <option value="">Pilih Kelas</option>
                <?php foreach ($kelas as $key => $value): ?>
                  <option value="<?=$value['KELAS']?>" <?=$kelas_sel == $value['KELAS'] ? 'selected' : ''?>><?=$value['KELAS']?></option>
                <?php endforeach?>
              </select>
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-primary">Tampilkan</button>
            </div>
          </form>
          </div>
          <hr>
          <div class="row">
            <?php if ($_POST): ?>
          <div class="col-md-12">
              <a style="color: red;" target="_blank" href="page/absensi_admin_view.php?kelas=<?=$kelas_sel?>&from=<?=$from?>&to=<?=$to?>"><h4><i class="fa fa-list"></i> LIHAT HASILNYA</h4></a>
          </div>
          <?php endif;?>
          </div>
        </div>
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->