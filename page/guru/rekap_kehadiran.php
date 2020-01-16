<?php
$user->cek_guru();

$siswa = [];
$kehadiran_row = [];
$kelas_id = '';
$mapel_id = '';
$waktu = '';
$tanggal = date('Y-m-d');
$guru_id = $_SESSION['user_id'];

$kelas = new Kelas();
$akademik = new Akademik();
$kehadiran = new Kehadiran();

// return var_dump($_SESSION['user_id']);

$kelas_row = $kelas->getByMengajarGuru($_SESSION['user_id']);

if (isset($_GET['kelas_id'])) {
    $mapel_id = $_GET['mapel_id'];
    $kelas_id = $_GET['kelas_id'];
    $waktu = $_GET['waktu'];
    $tanggal = $_GET['tanggal'];
}

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
              <input type="hidden" name="page" value="kehadiran">
              <div class="form-group">
                <select class="form-control" name="kelas_id" onchange="showMapelByKelas(this.value,'#mapel_id')" required>
                    <option value="">Pilih Kelas</option>
                    <?php foreach ($kelas_row as $row): ?>
                    <option value="<?=$row['id_kelas']?>" <?=$kelas_id == $row['id_kelas'] ? 'selected' : ''?> ><?=$row['kelas']?></option>
                    <?php endforeach;?>
                </select>
                </div>
                <div class="form-group">
                    <select name="mapel_id" id="mapel_id" class="form-control" required>
                        <option value="">Pilih Mapel</option>
                    </select>
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
                            <th >Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($siswa as $key => $s): ?>
                    <input type="hidden" name="no_induk[]" value="<?=$s['no_induk']?>"/>
                    <tr>
                    <td><?=$key + 1?></td>
                    <td><?=$s['no_induk']?></td>
                    <td><?=$s['nama']?></td>
                    <td><?=$s['kelas']?></td>
                    <td>
                        <select name="status[]">
                        <?php foreach (status_absen() as $sa): ?>
                            <option value="<?=$sa?>" <?=isset($s['status']) ? $s['status'] == $sa ? 'selected' : '' : '' ?> ><?=$sa?></option>
                        <?php endforeach;?>
                        </select>
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
            showMapelByKelas(<?=$kelas_id?>,'#mapel_id',<?=$mapel_id?>);
        });
    </script>