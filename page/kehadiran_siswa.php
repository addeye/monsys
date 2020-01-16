<?php
$user->cek_siswa();

$akademik = new Akademik();
$kehadiran = new Kehadiran();

$tanggal = date('Y-m-d');

if(isset($_GET['tanggal'])){
    $tanggal = $_GET['tanggal'];
}

$siswa = $akademik->getByNisAjaranAktif($_SESSION['user_id']);
$kelas_id = $siswa['kelas_id'];
$nis = $siswa['no_induk'];
$data = $kehadiran->getShowByKelasSiswaTodayAjaranAktif($kelas_id,$nis,$tanggal);
?>
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Kehadiran
      </h1>
      <ol class="breadcrumb">
        <li class="active"><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Kehadiran</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Kehadiran</h3>
        </div>
        <div class="box-body">
          <div class="row">
          <div class="col-md-12">
            <form class="form-inline" method="GET">
              <input type="hidden" name="page" value="kehadiran_siswa">
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
                            <th >Waktu</th>
                            <th >Guru</th>
                            <th >Mapel</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($data as $key => $value): ?>
                    <tr>
                        <td><?=$value['waktu']?></td>
                        <td><?=$value['guru']?></td>
                        <td><?=$value['mapel']?></td>
                        <td><label class="label <?=status_color($value['status'])?>"><?=$value['status']?></label></td>
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
            showMapelByKelas(<?=$kelas_id?>,'#mapel_id',<?=$mapel_id?>);
        });
    </script>