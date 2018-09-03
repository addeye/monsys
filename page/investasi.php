<?php
$user->cek_admin();
$kelas = new Kelas();
$userf = new User();
$mutu = new Investasi();

$data_kelas = $kelas->getAll();

if (isset($_REQUEST['id_kelas'])) {
    $akademik = new Akademik();
    $data = $akademik->getByKelasAjaran($th['nama'], $_REQUEST['id_kelas']);
}

?>
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dana Investasi
      </h1>
      <ol class="breadcrumb">
        <li class="active"><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Dana Investasi</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Pencarian</h3>
        </div>
        <div class="box-body">
          <div class="row">
          <div class="col-md-12">
              <form class="form-inline">
                  <div class="form-group">
                      <select name="id_kelas" id="" class="form-control" onchange="location = this.value;">
                        <option value="">Pilih Kelas</option>
                            <?php foreach ($data_kelas as $row): ?>
                            <option value="index.php?page=investasi&id_kelas=<?=$row['id_kelas']?>" <?=$_REQUEST['id_kelas'] == $row['id_kelas'] ? 'selected' : ''?> ><?=$row['kelas']?></option>
                            <?php endforeach; ?>
                      </select>
                  </div>
              </form>
          </div>
          </div>
        </div>
      </div>
      <!-- /.box -->

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Dana Investasi</h3>
        </div>
        <form action="page/investasi_act.php" method="POST">
        <input type="hidden" name="id_kelas" value="<?=$_REQUEST['id_kelas']?>">
        <div class="box-body">
          <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
            <input type="hidden" name="aksi" value="add">
            <table class="table table-bordered">
                <thead>
                    <tr>
                    <th class="col-xs-1">No</th>
                    <th class="col-xs-1">NIS</th>
                    <th>Nama</th>
                    <th class="col-xs-2">Nominal</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="3" valign="center" align="right"><strong>Duplikat</strong></td>
                        <td>
                            <div class="input-group">
                                <input type="text" class="form-control" id="nominal-copy" placeholder="Nominal">
                                <span class="input-group-btn">
                                    <button type="button" id="copy-nominal" class="btn btn-primary">C</button>
                                </span>
                            </div>
                        </td>
                    </tr>
                    <?php foreach ($data as $key => $row): ?>
                        <input type="hidden" name="nis[]" value="<?=$row['no_induk']?>">
                        <tr>
                            <td><?=$key + 1?></td>
                            <td><?=$row['no_induk']?></td>
                            <td><?=$userf->getById($row['no_induk'])['NAMA']?></td>
                            <td><input type="text" class="form-control nominal" name="nom_mutu[]" value="<?=rupiah($mutu->getByNis($row['no_induk'])['nominal'])?>"></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            </div>
          </div>
          </div>
        </div>
        <div class="box-footer">
            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
            <a href="index.php?page=investasi" class="btn btn-warning"><i class="fa fa-reply"></i> Batal</a>
        </div>
        </form>
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->