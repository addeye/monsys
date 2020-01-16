<?php
$user->cek_guru();
$kelas = new Kelas();
$mapel = new Mapel();
$kd = new Kd();
$jurnal = new Jurnal();

$kelas_row = $kelas->getByMengajarGuru($_SESSION['user_id']);
$mapel_row = $mapel->getAll();
$data = $jurnal->getById($_GET['id']);

?>
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data Jurnal
      </h1>
      <ol class="breadcrumb">
        <li class="active"><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Data Jurnal</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Ubah Jurnal</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <form action="page/guru/jurnal_act.php?id=<?=$data['id']?>" method="post">
                        <input type="hidden" name="aksi" value="edit">
                        <input type="hidden" name="guru_id" value="<?=$_SESSION['user_id']?>">
                        <div class="form-group">
                            <label for="">Pilih Kelas</label>
                            <select name="kelas_id" onchange="showMapelByKelas(this.value,'#mapel_id')" class="form-control" required>
                                <option value="">Pilih Kelas</option>
                                <?php foreach($kelas_row as $row): ?>
                                <option value="<?=$row['id_kelas']?>" <?=$data['kelas_id']==$row['id_kelas']?'selected':''?> ><?=$row['kelas']?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                        <div class="form-group">
                          <label for="">Jenis Kegiatan</label>
                            <select name="kegiatan" class="form-control" onchange="showKdOrNot()">
                            <option value="">Pilih Kegiatan</option>
                            <?php foreach(jenis_kegiatan() as $j): ?>
                                <option value="<?=$j?>" <?=$data['kegiatan']==$j?'selected':''?>><?=$j?></option>
                            <?php endforeach;?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Tanggal</label>
                            <input type="date" value="<?=$data['tanggal']?>" class="form-control" name="tanggal" required>
                            <p class="help-block">Default tanggal sekarang</p>
                        </div>
                        <div class="form-group">
                          <label for="">Pilih Jam Pelajaran</label>
                            <select name="waktu" class="form-control">
                            <?php foreach(jamke() as $j): ?>
                                <option value="<?=$j?>" <?=$data['waktu']==$j?'selected':''?> ><?=$j?></option>
                            <?php endforeach;?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Pilih Mapel</label>
                            <select name="mapel_id" id="mapel_id" onchange="showKdByMapel(this.value,'#kd_id')" class="form-control" required>
                            </select>
                        </div>
                        <div class="form-group" id="kdId">
                            <label for="">Pilih KD</label>
                            <div id="kd_id">
                            </div>
                        </div>
                        <button class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
                        <a href="javascript:" onclick="window.history.go(-1); return false;" class="btn btn-warning"><i class="fa fa-reply"></i> Kembali</a>
                    </form>
                </div>
            </div>

        </div>
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
    <script>
        $(document).ready(function(){
            showMapelByKelas(<?=$data['kelas_id']?>,'#mapel_id',<?=$data['mapel_id']?>);
            showKdByMapel(<?=$data['mapel_id']?>,'#kd_id',<?=$data['kd_id']?>);

            if(kegiatan.val()=='Kegiatan Kesiswaan'){
              $('#kdId').hide();
            }else if(kegiatan.val()=='Pembahasan Soal USBN/UNBK'){
              $('#kdId').hide();
            }else{
              $('#kdId').show();
            }
        });

        var kegiatan = $("select[name='kegiatan']");
        function showKdOrNot(){
          if(kegiatan.val()=='Kegiatan Kesiswaan'){
            $('#kdId').hide();
          }else if(kegiatan.val()=='Pembahasan Soal USBN/UNBK'){
            $('#kdId').hide();
          }else{
            $('#kdId').show();
          }
        }
    </script>