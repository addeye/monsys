<?php
$user->cek_admin();
$userdata = new User();
$data = new Wakakur();
$data = $data->getById($_GET['id']);

$guru = $userdata->getGuru();
?>
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Ubah Wakakur
      </h1>
      <ol class="breadcrumb">
        <li class="active"><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Ubah Wakakur</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Ubah Wakakur</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                <form action="page/wakakur_act.php?id=<?=$data['id']?>" method="post">
                        <input type="hidden" name="aksi" value="edit">
                        <div class="form-group">
                            <label for="">Pilih Guru</label>
                            <select name="guru_id" class="form-control js-data-example-ajax">
                                <option value="">Pilih</option>
                                <?php foreach ($guru as $row): ?>
                                <option value="<?=$row['FPID']?>" <?=$row['FPID']==$data['guru_id']?'selected':''?> ><?=$row['NAMA']?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
                        <a href="index.php?page=wakakur" class="btn btn-warning"><i class="fa fa-reply"></i> Kembali</a>
                    </form>
                </div>
            </div>

        </div>
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->