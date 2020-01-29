<?php
$user->cek_guru();

$kelas_id = '';
$start = '';
$end = '';
$tanggal = date('Y-m-d');
$guru_id = $_SESSION['user_id'];

$kelas = new Kelas();
$akademik = new Akademik();
$kehadiran = new Kehadiran();
$tanggal_rows = [];
$siswa_rows = [];
$data_rows = [];

// return var_dump($_SESSION['user_id']);

$kelas_row = $kelas->getByMengajarGuru($_SESSION['user_id']);

if (isset($_GET['kelas_id'])) {
    $kelas_id = $_GET['kelas_id'];
    $start = $_GET['start'];
    $end = $_GET['end'];
    // return var_dump($siswa_rows);
}

?>
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Rekap Kehadiran
      </h1>
      <ol class="breadcrumb">
        <li class="active"><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Rekap Kehadiran</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Rekap Kehadiran</h3>
        </div>
        <div class="box-body">
          <div class="row">
          <div class="col-md-12">
            <form class="form-inline" method="GET">
              <input type="hidden" name="page" value="rekap_kehadiran">
              <div class="form-group">
                <select class="form-control" name="kelas_id" required>
                    <option value="">Pilih Kelas</option>
                    <?php foreach ($kelas_row as $row): ?>
                    <option value="<?=$row['id_kelas']?>" <?=$kelas_id == $row['id_kelas'] ? 'selected' : ''?> ><?=$row['kelas']?></option>
                    <?php endforeach;?>
                </select>
                </div>
                <div class="form-group">
                    <input type="date" name="start" class="form-control">
                </div>
                <div class="form-group">
                    <input type="date" name="end" class="form-control">
                </div>
              <button class="btn btn-primary"><i class="fa fa-search"></i></button>
            </form>
            <hr>
            <div class="table-responsive" style="height:400px; overflow-y: scroll;">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th >No</th>
                            <th >NIS</th>
                            <th >NAMA</th>
                            <th>Kelas</th>
                            <?php foreach($tanggal_rows as $tgl): ?>
                            <th><?=date('d-m-Y', strtotime($tgl))?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($siswa_rows as $key => $s): ?>
                    <input type="hidden" name="no_induk[]" value="<?=$s['no_induk']?>"/>
                    <tr>
                    <td><?=$key + 1?></td>
                    <td><?=$s['no_induk']?></td>
                    <td><?=$s['nama']?></td>
                    <td><?=$s['kelas']?></td>
                    <?php foreach($s['status'] as $st): ?>
                    <td>
                        <span class="label <?=status_color($st)?>"><?=$st?></span>
                    </td>
                    <?php endforeach; ?>
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