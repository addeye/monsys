<?php
$user->cek_guru();
$user->cek_wakakur();

$kelas_id = '';
$data = [];
$tanggal = date('Y-m-d');
$guru_id = $_SESSION['user_id'];

$kelas = new Kelas();
$akademik = new Akademik();
$kehadiran = new Kehadiran();
$jurnal = new Jurnal();

$kelas_row = $kelas->getAll();

if (isset($_GET['kelas_id'])) {
    $kelas_id = $_GET['kelas_id'];
    $tanggal = $_GET['tanggal'];

    $data = $jurnal->getByGuruPerKelas($kelas_id,$tanggal);
}

?>
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Rekap Absensi Guru
      </h1>
      <ol class="breadcrumb">
        <li class="active"><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Rekap Absensi Guru</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Rekap Absensi Guru</h3>
        </div>
        <div class="box-body">
          <div class="row">
          <div class="col-md-12">
            <form class="form-inline" method="GET">
              <input type="hidden" name="page" value="absensi_guru">
              <div class="form-group">
                <select class="form-control js-data-example-ajax" name="kelas_id" required>
                    <option value="">Pilih Kelas</option>
                    <?php foreach ($kelas_row as $row): ?>
                    <option value="<?=$row['id_kelas']?>" <?=$kelas_id == $row['id_kelas'] ? 'selected' : ''?> ><?=$row['kelas']?></option>
                    <?php endforeach;?>
                </select>
                </div>
                <div class="form-group">
                    <input type="date" name="tanggal" class="form-control" value="<?=$tanggal?>"/>
                </div>
              <button class="btn btn-primary"><i class="fa fa-search"></i></button>
            </form>
            <hr>
            <div class="table-responsive" style="height:400px; overflow-y: scroll;">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th >No</th>
                            <th >Guru</th>
                            <th>Waktu</th>
                            <th >Mapel</th>
                            <th >Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($data as $key => $s): ?>
                    <tr>
                    <td><?=$key + 1?></td>
                    <td><?=$s['guru']?></td>
                    <td><?=$s['waktu']?></td>
                    <td><?=$s['mapel']?></td>
                    <td>
                        <?php if($s['kegiatan']=='Tugas'): ?>
                            <span class="label label-danger">Tidak Hadir</span>
                        <?php else: ?>
                            <span class="label label-success">Hadir</span>
                        <?php endif;?>
                    </td>
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
    <script>
        $(document).ready(function(){
            showMapelByKelasOnly(<?=$kelas_id?>,'#mapel_id',<?=$mapel_id?>);
        });
    </script>