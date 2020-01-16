<?php
$user->cek_admin();
$data = new Akademik();
$tajaran = new TahunAjaran();
$kelasf = new Kelas();
$userf = new User();

$th = $tajaran->getByActive();
$kelas = $kelasf->getAll();

if (isset($_REQUEST['kelas_id'])) {
    $data = $data->getByKelasAjaran($th['nama'], $_REQUEST['kelas_id']);
} else {
    $data = $data->getByAjaran($th['nama']);
}

?>
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Kenaikan Kelas
      </h1>
      <ol class="breadcrumb">
        <li class="active"><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Kenaikan Kelas</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="box">
          <div class="box-header">
            <h3 class="box-title">Filter</h3>
          </div>
          <div class="box-body">
          <form class="form-inline">
            <div class="form-group">
                <input type="text" name="search" id="search" class="form-control" placeholder="Pencarian NIS,NAMA">
            </div>
            <div class="form-group">
                <select name="kelas_id" id="" class="form-control" onchange="location = this.value;">
                    <option value="index.php?page=kenaikan_kelas">Semua Kelas</option>
                    <?php foreach ($kelas as $row): ?>
                    <option value="index.php?page=kenaikan_kelas&kelas_id=<?=$row['id_kelas']?>" <?=isset($_REQUEST['kelas_id'])?$_REQUEST['kelas_id'] == $row['id_kelas'] ? 'selected' : '':''?> ><?=$row['kelas']?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            </form>
          </div>
      </div>
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Kenaikan Kelas</h3>
            <div class="box-tools">
                <div class="form-group">
                    <a href="index.php?page=kenaikan_kelas_add" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</a>
                    <!-- <a href="index.php?page=kenaikan_kelas_add" class="btn btn-primary"><i class="fa fa-plus"></i> Rombongan</a> -->
                </div>
            </div>
        </div>
        <div class="box-body">
          <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table id="table" class="table table-bordered">
              <thead>
                <tr>
                  <th class="col-xs-1"></th>
                  <th>No</th>
                  <th>NIS</th>
                  <th>Nama</th>
                  <th>Kelas</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($data as $key => $value): ?>
                <tr>
                  <td>
                    <a href="index.php?page=kenaikan_kelas_edit&id=<?=$value['id']?>" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>
                    <a href="javascript:void(0)" onclick="confirmation('<?=$value['id']?>','page/kenaikan_kelas_act.php')" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>
                  </td>
                  <td><?=$key + 1?></td>
                  <td><?=$value['no_induk']?></td>
                  <td><?=$userf->getById($value['no_induk'])['NAMA']?></td>
                  <td><?=$kelasf->getById($value['kelas_id'])['kelas']?></td>
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