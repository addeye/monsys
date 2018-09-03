<?php
$user->cek_admin();
$kelas = new Kelas();
$data = $kelas->getById($_GET['id']);
?>
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data Kelas
      </h1>
      <ol class="breadcrumb">
        <li class="active"><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Data Kelas</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Perbaruhi Kelas</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <form action="page/data_kelas_act.php?id=<?=$data['id_kelas']?>" method="post">
                        <input type="hidden" name="aksi" value="edit">
                        <div class="form-group">
                            <label for="">Nama Kelas</label>
                            <input type="text" name="kelas" class="form-control" placeholder="Nama Kelas" value="<?=$data['kelas']?>" required>
                        </div>
                        <div class="form-group">
                            <label for="">Tingkat</label>
                            <select name="tingkat" class="form-control" required>
                                <option value="">Pilih</option>
                                <?php foreach (kelas() as $row): ?>
                                    <option value="<?=$row?>" <?= $row == $data['tingkat'] ? 'selected' : '' ?> ><?=$row?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
                        <a href="index.php?page=data_kelas" class="btn btn-warning"><i class="fa fa-reply"></i> Kembali</a>
                    </form>
                </div>
            </div>

        </div>
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->