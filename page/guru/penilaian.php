<?php
$user->cek_guru();

$siswa = [];
$kelas_id = '';
$mapel_id = '';
$kdpeng = [];
$kdkete = [];
$kdgroup_peng = [];
$kdgroup_kete = [];
$guru_id = $_SESSION['user_id'];

$kelas = new Kelas();
$akademik = new Akademik;
$np = new NilaiPengetahuan();
$nk = new NilaiKeterampilan();
$ns = new NilaiSikap();
$kategori = new Kategori();

$nilpengkd = new NilaiPengKd();
$nilketkd = new NilaiKetKd();

$kelas_row = $kelas->getByMengajarGuru($_SESSION['user_id']);
$kategori_peng= $kategori->getByKompetensiPengetahuan();
$kategori_kete= $kategori->getByKompetensiKeterampilan();

if(isset($_GET['kelas_id'])){
  $kelas_id = $_GET['kelas_id'];
  $siswa = $akademik->getByKelasAjaranAktif($_GET['kelas_id']);
}

if(isset($_GET['mapel_id'])){
  $mapel_id = $_GET['mapel_id'];

  //sample for check data by nis
  $nonduk = $siswa[0]['no_induk'];

  if($np->getByNisGuruMapel($nonduk,$guru_id,$mapel_id)){
    $kdgroup_peng = $np->getGroupKdByKelasMapelGuru($nonduk,$mapel_id,$guru_id,count($kategori_peng));
    // return var_dump($kdgroup_peng);
  }

  if($nk->getByNisGuruMapel($nonduk,$guru_id,$mapel_id)){
  $kdgroup_kete = $nk->getGroupKdByKelasMapelGuru($nonduk,$mapel_id,$guru_id,count($kategori_kete));
  // return var_dump($kdgroup_kete);
  }
}

?>
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Monitoring KBM
      </h1>
      <ol class="breadcrumb">
        <li class="active"><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Monitoring KBM</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Monitoring KBM</h3>
          <div class="box-tools">
            <div class="form-group">
                <a href="index.php?page=penilaian_import" class="btn btn-primary"><i class="fa fa-plus"></i> Import</a>
            </div>
            </div>
        </div>
        <div class="box-body">
          <div class="row">
          <div class="col-md-12">
            <form class="form-inline" method="GET">
              <input type="hidden" name="page" value="penilaian">
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
              <button class="btn btn-primary"><i class="fa fa-search"></i></button>
            </form>
            <hr>
            <div class="table-responsive" style="height:400px; overflow-y: scroll;">
              <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th rowspan="3">No</th>
                  <th rowspan="3">NIS</th>
                  <th rowspan="3">NAMA</th>
                  <th colspan="<?=count($kategori_peng)?>">Pengetahuan</th>
                  <th colspan="<?=count($kategori_kete)?>">Keterampilan</th>
                  <th rowspan="3" >Sikap</th>
                </tr>
                <tr>
                  <?php foreach($kategori_peng as $row): ?>
                  <th><?=$row['nama']?></th>
                  <?php endforeach; ?>
                  <?php foreach($kategori_kete as $row): ?>
                  <th><?=$row['nama']?></th>
                  <?php endforeach; ?>
                </tr>
                <tr>
                  <?php foreach($kdgroup_peng as $row): ?>
                  <th><?=showArrayToStringNoKD($nilpengkd->getNoKdByNilPengId($row['id']))?></th>
                  <?php endforeach; ?>
                  <?php foreach($kdgroup_kete as $row): ?>
                  <th><?=showArrayToStringNoKD($nilketkd->getNoKdByNilKetId($row['id']))?></th>
                  <?php endforeach; ?>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($siswa as $key=>$s): ?>
                <tr>
                  <td><?=$key+1?></td>
                  <td><?=$s['no_induk']?></td>
                  <td><?=$s['nama']?></td>
                  <?php if(count($np->getByNisGuruMapel($s['no_induk'],$guru_id,$mapel_id))): ?>
                    <?php foreach($np->getByNisGuruMapel($s['no_induk'],$guru_id,$mapel_id) as $rowp): ?>
                    <td style="background-color: <?=generateColorValue($rowp['nilai'])?>" ><?=$rowp['nilai']?></td>
                    <?php endforeach; ?>
                  <?php else: ?>
                  <td style="background-color: #f77777"></td>
                  <td style="background-color: #f77777"></td>
                  <td style="background-color: #f77777"></td>
                  <td style="background-color: #f77777"></td>
                  <?php endif; ?>

                  <?php if(count($nk->getByNisGuruMapel($s['no_induk'],$guru_id,$mapel_id))): ?>
                    <?php foreach($nk->getByNisGuruMapel($s['no_induk'],$guru_id,$mapel_id) as $rowk): ?>
                    <td style="background-color: <?=generateColorValue($rowk['nilai'])?>" ><?=$rowk['nilai']?></td>
                    <?php endforeach; ?>
                  <?php else: ?>
                  <td style="background-color: #f77777"></td>
                  <td style="background-color: #f77777"></td>
                  <td style="background-color: #f77777"></td>
                  <td style="background-color: #f77777"></td>
                  <?php endif; ?>

                  <td style="background-color: <?=generateColorValue($ns->getByNisGuruMapel($s['no_induk'],$guru_id,$mapel_id)['nilai'])?>"><?=$ns->getByNisGuruMapel($s['no_induk'],$guru_id,$mapel_id)['nilai']?></td>
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