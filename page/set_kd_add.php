<?php
$user->cek_admin();
$mapel = new Mapel();
$mapel = $mapel->getAll();
?>
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      SET KD
      </h1>
      <ol class="breadcrumb">
        <li class="active"><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">SET KD</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Tambah KD</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <form action="page/set_kd_act.php" method="post">
                        <input type="hidden" name="aksi" value="add">
                        <div class="form-group">
                            <label for="">Pilih Mapel</label>
                            <select name="mapel_id" class="form-control js-data-example-ajax" required>
                                <option value="">Pilih</option>
                                <?php foreach ($mapel as $row): ?>
                                <option value="<?=$row['id']?>"><?=$row['nama']?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Tingkat</label>
                            <br>
                            <?php foreach(tingkat() as $key=>$t): ?>
                            <label class="radio-inline">
                                <input type="radio" name="tingkat" id="inlineRadioTingkat<?=$key?>" value="<?=$t?>" required> <?=$t?>
                            </label>
                            <?php endforeach; ?>
                        </div>
                        <div class="form-group">
                            <label for="">Kompetensi</label>
                            <br>
                            <?php foreach(kompetensi() as $key=>$k): ?>
                            <label class="radio-inline">
                                <input type="radio" name="kompetensi" id="inlineRadio<?=$key?>" value="<?=$k?>" required> <?=$k?>
                            </label>
                            <?php endforeach; ?>
                        </div>
                        <div class="form-group">
                            <label for="">No KD</label>
                            <input type="text" name="no_kd" placeholder="Nomor KD" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="">Deskripsi KD</label>
                            <textarea name="diskripsi_kd" class="form-control" required></textarea>
                        </div>
                        <button class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
                        <a href="index.php?page=set_kd" class="btn btn-warning"><i class="fa fa-reply"></i> Kembali</a>
                    </form>
                </div>
            </div>

        </div>
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->