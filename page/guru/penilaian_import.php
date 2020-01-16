<?php
$user->cek_guru();
$kelas = new Kelas();
$kelas_row = $kelas->getByMengajarGuru($_SESSION['user_id']);

?>
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Penilaian Import
      </h1>
      <ol class="breadcrumb">
        <li class="active"><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Penilaian Import</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Penilaian Import</h3>
          <div class="box-tools">
            <div class="form-group">
                <a href="index.php?page=penilaian" class="btn btn-warning"><i class="fa fa-arrow-left"></i> Kembali</a>
            </div>
            </div>
        </div>
        <div class="box-body">
            <form class="form-inline" action="page/guru/penilaian_import_act.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="">Upload file</label>
                    <input type="file" name="file" accept=".xls,.xlsx">
                </div>
                <input type="submit" class="btn btn-primary" value="Import" name="import" />
            </form>
        </div>
      </div>
      <!-- /.box -->
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Generate Template</h3>
        </div>
        <div class="box-body">
            <form action="page/guru/penilaian_generate.php" class="form-inline">
                <div class="form-group">
                <select class="form-control" name="kelas_id" onchange="showMapelByKelas(this.value,'#mapel_id')" required>
                    <option value="">Pilih Kelas</option>
                    <?php foreach($kelas_row as $row): ?>
                    <option value="<?=$row['id_kelas']?>" <?=isset($_GET['kelas_id'])?$_GET['kelas_id']==$row['id_kelas']?'selected':'':''?> ><?=$row['kelas']?></option>
                    <?php endforeach;?>
                </select>
                </div>
                <div class="form-group">
                    <select name="mapel_id" id="mapel_id" class="form-control" required>
                        <option value="">Pilih Mapel</option>
                    </select>
                </div>
                <button class="btn btn-primary">Download Template</button>
            </form>
        </div>
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->