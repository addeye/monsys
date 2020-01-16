<?php
$user->cek_siswa();

$siswa = [];
$kelas_id = '';
$mapel_id = '';
$kdpeng = [];
$kdkete = [];
$kdgroup_peng = [];
$kdgroup_kete = [];
$guru_id = $_SESSION['user_id'];
$nilaibase = [];

$kelas = new Kelas();
$akademik = new Akademik;
$np = new NilaiPengetahuan();
$nk = new NilaiKeterampilan();
$ns = new NilaiSikap();
$kategori = new Kategori();

$nilpengkd = new NilaiPengKd();
$nilketkd = new NilaiKetKd();
$mapel = new Mapel();

$kelas_row = $kelas->getByMengajarGuru($_SESSION['user_id']);
$kategori_peng= $kategori->getByKompetensiPengetahuan();
$kategori_kete= $kategori->getByKompetensiKeterampilan();


$siswa = $akademik->getByNisAjaranAktif($_SESSION['user_id']);
// return var_dump($siswa['kelas_id']);

// $kelas_id = $_GET['kelas_id'];
// $siswa = $akademik->getByKelasAjaranAktif($_GET['kelas_id']);
$mapel_row = $mapel->getByKelas($siswa['kelas_id']);
// return var_dump($mapel_row);
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

foreach($mapel_row as $key=>$row){
    $nilaibase[$key] = [
        'mapel' => $row['nama']
    ];

    if(count($np->getByNisMapel($siswa['no_induk'],$row['id']))):
        foreach($np->getByNisMapel($siswa['no_induk'],$row['id']) as $rowp):
        $nilaibase[$key]['nilai'][] = $rowp['nilai'];
        endforeach;
    else:
        for ($i=0; $i < 4; $i++) {
            $nilaibase[$key]['nilai'][] = "";
        }
    endif;

    if(count($nk->getByNisMapel($siswa['no_induk'],$row['id']))):
     foreach($nk->getByNisMapel($siswa['no_induk'],$row['id']) as $rowk):
      $nilaibase[$key]['nilai'][] = $rowk['nilai'];
      endforeach;
    else:
      for ($k=0; $k < 4; $k++) {
        $nilaibase[$key]['nilai'][] = "";
      }
    endif;

    if($ns->getByNisMapel($siswa['no_induk'],$row['id'])['nilai']){
      $nilaibase[$key]['nilai'][] = $ns->getByNisMapel($siswa['no_induk'],$row['id'])['nilai'];
    }else{
      $nilaibase[$key]['nilai'][] = "";
    }
}

// return var_dump($nilaibase);

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
        </div>
        <div class="box-body">
          <div class="row">
          <div class="col-md-12">
            <div class="table-responsive" style="height:400px; overflow-y: scroll;">
              <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th rowspan="3">No</th>
                  <th rowspan="3">MAPEL</th>
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
                <?php foreach ($nilaibase as $key=>$s): ?>
                <tr>
                  <td><?=$key+1?></td>
                  <td><?=$s['mapel']?></td>
                  <?php foreach($s['nilai'] as $n): ?>
                  <td style="background: <?=generateColorValue($n)?>"><?=$n?></td>
                  <?php endforeach ?>
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
            showMapelByKelas(`<?=$kelas_id?>`,'#mapel_id',<?=$mapel_id?>);
        });
    </script>