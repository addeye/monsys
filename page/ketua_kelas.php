<?php
$user->cek_admin();
$data = new KetuaKelas();
$data = $data->getAllWithRelationTahunAjaranActive();

if (isset($_POST['nama'])) {
}

?>
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Ketua Kelas <?=$th['semester']?> <?=$th['nama']?>
      </h1>
      <ol class="breadcrumb">
        <li class="active"><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Ketua Kelas</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Ketua Kelas</h3>
          <div class="box-tools">
            <div class="form-group">
                <a href="index.php?page=ketua_kelas_add" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</a>
            </div>
            </div>
        </div>
        <div class="box-body">
          <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-bordered">
              <thead>
                <tr>
                  <th class="col-xs-1"></th>
                  <th>No Induk</th>
                  <th>Nama</th>
                  <th>Kelas</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($data as $key => $value): ?>
                <tr>
                    <td>
                    <a href="index.php?page=ketua_kelas_edit&id=<?=$value['id']?>" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a>
                    <a href="javascript:void(0)" onclick="confirmation('<?=$value['id']?>','page/ketua_kelas_act.php')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>
                  </td>
                  <td><?=$value['no_induk']?></td>
                  <td><?=$value['nama']?></td>
                  <td><?=$value['kelas']?></td>
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