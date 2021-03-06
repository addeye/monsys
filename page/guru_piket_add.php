<?php
$user->cek_admin();
$userdata = new User();

$guru = $userdata->getGuru();
?>
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Tambah Guru Piket
      </h1>
      <ol class="breadcrumb">
        <li class="active"><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Tambah Guru Piket</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Tambah Guru Piket</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <form action="page/guru_piket_act.php" method="post">
                        <input type="hidden" name="aksi" value="add">
                        <div class="form-group">
                            <label for="">Pilih Guru</label>
                            <select name="guru_id[]" class="form-control js-data-example-ajax" multiple>
                                <option value="">Pilih</option>
                                <?php foreach ($guru as $row): ?>
                                <option value="<?=$row['FPID']?>"><?=$row['NAMA']?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
                        <a href="index.php?page=guru_piket" class="btn btn-warning"><i class="fa fa-reply"></i> Kembali</a>
                    </form>
                </div>
            </div>

        </div>
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->