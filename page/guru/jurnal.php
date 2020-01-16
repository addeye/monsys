<?php
$user->cek_guru();
$kelas_id = '';
$tanggal = '';
$waktu = '';
$jurnal = new Jurnal();
$data=[];

if(isset($_GET['kelas_id'])){
  $kelas_id = $_GET['kelas_id'];
  $data = $jurnal->getAllOwnByKelas($kelas_id);
}
// if(isset($_GET['tanggal'])){
//   $tanggal = $_GET['tanggal'];
// }

// if(isset($_GET['waktu'])){
//   $waktu = $_GET['waktu'];
// }



$kelas = new Kelas();
$kelas_row = $kelas->getByMengajarGuru($_SESSION['user_id']);
// return var_dump($data);
?>
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data Jurnal <?=$th['semester']?> <?=$th['nama']?>
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
                <a href="index.php?page=jurnal_add" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</a>
            </div>
            </div>
        </div>
        <div class="box-body">
          <div class="row">
          <div class="col-md-12">
            <form class="form-inline" method="GET">
              <input type="hidden" name="page" value="jurnal">
              <div class="form-group">
                <select class="form-control" name="kelas_id">
                  <option value="">Pilih Kelas</option>
                  <?php foreach($kelas_row as $row): ?>
                  <option value="<?=$row['id_kelas']?>" <?=$kelas_id==$row['id_kelas']?'selected':''?> ><?=$row['kelas']?></option>
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
                  <th>No</th>
                  <th>Kelas</th>
                  <th>Kegiatan</th>
                  <th>Waktu</th>
                  <th>Tanggal</th>
                  <th class="col-xs-7">Deskripsi KD</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($data as $key => $value): ?>
                <tr>
                  <td>
                    <a href="index.php?page=jurnal_edit&id=<?=$value['id']?>" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a>
                    <a href="javascript:void(0)" onclick="confirmation('<?=$value['id']?>','page/guru/jurnal_act.php')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>
                  </td>
                  <td><?=$key + 1?></td>
                  <td><?=$value['kelas']?></td>
                  <td><?=$value['kegiatan']?></td>
                  <td><?=$value['waktu']?></td>
                  <td><?=$value['tanggal']?></td>
                  <?php if($value['kegiatan']=='Bimbingan Belajar'): ?>
                    Pembahasan Soal USBN/UNBK
                  <?php else: ?>
                    <td><?=$value['no_kd']?> <?=$value['diskripsi_kd']?></td>
                  <?php endif; ?>
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