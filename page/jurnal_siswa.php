<?php
$user->cek_siswa();
$jurnal = new Jurnal();
$akademik = new Akademik();
$mapel = new Mapel();

$mapel_id = '';
$waktu = '';
$tanggal = date('Y-m-d');

if(isset($_GET['mapel_id'])){
  $mapel_id = $_GET['mapel_id'];
}

if(isset($_GET['waktu'])){
  $waktu = $_GET['waktu'];
}

if(isset($_GET['tanggal'])){
  $tanggal = $_GET['tanggal'];
}

$siswa = $akademik->getByNisAjaranAktif($_SESSION['user_id']);

$data = $jurnal->getAllBySiswa($siswa['kelas_id'],$mapel_id,$waktu,$tanggal);
$mapel_row = $mapel->getByKelas($siswa['kelas_id']);

?>
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data Jurnal
      </h1>
      <ol class="breadcrumb">
        <li class="active"><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Data Jurnal</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Jurnal</h3>
          <div class="box-tools">
            <div class="form-group">
                <a href="index.php?page=jurnal_siswa_add" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</a>
            </div>
            </div>
        </div>
        <div class="box-body">
          <div class="row">
          <div class="col-md-12">
            <form class="form-inline" method="GET">
                <input type="hidden" name="page" value="jurnal_siswa">
                <div class="form-group">
                  <select class="form-control" name="mapel_id">
                      <option value="">Pilih Mapel</option>
                      <?php foreach($mapel_row as $row): ?>
                      <option value="<?=$row['id']?>" <?=$_GET['mapel_id']==$row['id']?'selected':''?> ><?=$row['nama']?></option>
                      <?php endforeach;?>
                  </select>
                </div>
                <div class="form-group">
                  <input type="date" name="tanggal" class="form-control" value="<?=$tanggal?$tanggal:date('Y-m-d')?>">
                </div>
                <div class="form-group">
                    <select name="waktu" class="form-control">
                    <?php foreach(jamke() as $j): ?>
                        <option value="<?=$j?>" <?=$waktu==$j?'selected':''?> ><?=$j?></option>
                    <?php endforeach;?>
                    </select>
                </div>
                <button class="btn btn-primary"><i class="fa fa-search"></i></button>
            </form>
            <hr>
            <div class="table-responsive">
              <table class="table table-bordered">
              <thead>
                <tr>
                  <th class="col-xs-1"></th>
                  <th class="col-xs-1">No</th>
                  <th>Mapel</th>
                  <th>Waktu</th>
                  <th>Tanggal</th>
                  <th class="col-xs-7">KD</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($data as $key => $value): ?>
                <tr>
                  <td>
                    <a href="index.php?page=jurnal_siswa_edit&id=<?=$value['id']?>" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a>
                    <a href="javascript:void(0)" onclick="confirmation('<?=$value['id']?>','page/jurnal_siswa_act.php')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>
                  </td>
                  <td><?=$key + 1?></td>
                  <td><?=$value['mapel']?></td>
                  <td><?=$value['waktu']?></td>
                  <td><?=$value['tanggal']?></td>
                  <?php if($value['kegiatan']=='Bimbingan Belajar'): ?>
                    Pembahasan Soal USBN/UNBK
                  <?php else: ?>
                    <td><?=$value['no_kd']?> <?=$value['diskripsi_kd']?></td>
                  <?php endif; ?>
                </tr>
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