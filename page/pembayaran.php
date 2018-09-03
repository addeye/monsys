<?php
$user->cek_admin();

$akademik = new Akademik();
$data = $akademik->getByAjaran($th['nama']);
$userf = new User();
$sppset = new SppSet();
$spp = new SppAjaran();
$sppbayar = new SppBayar();
$asuransi = new Asuransi();
$asuransibayar = new AsuransiBayar();
$mutu = new Mutu();

$investasi = new Investasi();
$investasiBayar = new InvestasiBayar();

$bimbel = new BimbelIntensif();
$bimbelbayar = new BimbelIntensifBayar();

if (isset($_REQUEST['nis'])) {
    $kelas = new Kelas();
    $akademik_aktif = $akademik->getByNisAjaran($_REQUEST['nis'], $th['nama']);
    $kel = $kelas->getById($akademik_aktif['kelas_id']);
}

?>
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Pembayaran
      </h1>
      <ol class="breadcrumb">
        <li class="active"><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Pembayaran</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Cari Siswa</h3>
        </div>
        <div class="box-body">
          <div class="row">
          <div class="col-md-12">
              <form action="" class="form-inline">
                  <div class="form-group">
                      <select name="" class="form-control js-data-example-ajax" onchange="location = this.value;">
                          <option value="">NIS/NAMA SISWA</option>
                          <?php foreach ($data as $row): ?>
                          <option value="index.php?page=pembayaran&nis=<?=$row['no_induk']?>" <?=$_REQUEST['nis'] == $row['no_induk'] ? 'selected' : ''?> ><?=$row['no_induk']?> <?=$userf->getById($row['no_induk'])['NAMA']?></option>
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
          <h3 class="box-title">Pembayaran</h3>
        </div>
        <form action="page/pembayaran_act.php?nis=<?=$_REQUEST['nis']?>" method="post">
        <input type="hidden" value="<?=$akademik_aktif['id']?>" name="id_akademik">
        <input type="hidden" name="aksi" value="add">
        <div class="box-body">
          <div class="row">
          <div class="col-md-4">
              <div class="box box-primary box-solid">
                  <div class="box-header with-border">
                      <h1 class="box-title">SPP</h1>
                  </div>
                  <div class="box-body">
                  <div class="table-responsive">
                    <?php if (isset($_REQUEST['nis'])): ?>
                      <table class="table">
                          <tr>
                              <th>No</th>
                              <th>Tanggal</th>
                              <th>Nominal</th>
                              <th>Bulan</th>
                              <th>Bayar</th>
                          </tr>
                          <?php foreach ($sppset->getByAjaran($th['nama']) as $key => $row): ?>
                          <input type="hidden" name="nominal_spp[]" value="<?=rupiah($spp->getByTingkat($kel['tingkat'], $th['nama'])['nominal'])?>">
                          <input type="hidden" name="spp_set_id[]" value="<?=$row['id']?>">
                          <tr>
                              <td><?=$key + 1?></td>
                              <td class="col-xs-2"><input type="text" name="tanggal_spp[]" class="form-control datepicker" value="<?=$sppbayar->getByNisPeriode($_REQUEST['nis'], $row['id'])['tanggal'] ? date('d-m-Y', strtotime($sppbayar->getByNisPeriode($_REQUEST['nis'], $row['id'])['tanggal'])) : ''?>"></td>
                              <td><?=rupiah($spp->getByTingkat($kel['tingkat'], $th['nama'])['nominal'])?></td>
                              <td><?=bulan()[$row['bulan']]?> <?=$row['tahun']?></td>
                              <td>
                                <div class="checkbox icheck">
                                    <input type="checkbox" name="lunas_<?=$key?>" value="Yes" <?=$sppbayar->getByNisPeriode($_REQUEST['nis'], $row['id'])['lunas'] == 'Yes' ? 'checked' : ''?>>
                                </div>
                              </td>
                              <td>
                                <?php if ($sppbayar->getByNisPeriode($_REQUEST['nis'], $row['id'])): ?>
                                <a href="javascript:void(0)" onclick="confirmation('<?=$row['id'] . '&nis=' . $_REQUEST['nis']?>','page/pembayaran_act.php')" class="btn btn-danger btn-md"><i class="fa fa-trash"></i></a>
                                <?php endif; ?>
                              </td>
                          </tr>
                            <?php endforeach; ?>
                      </table>
                    <?php endif; ?>
                  </div>
                  </div>
              </div>
          </div>
          <div class="col-md-4">
              <div class="box box-info box-solid">
                  <div class="box-header with-border">
                      <h1 class="box-title">Asuransi</h1>
                  </div>
                  <div class="box-body">
                    <div class="table-responsive">
                    <?php if (isset($_REQUEST['nis'])): ?>
                      <table class="table">
                          <tr>
                              <th>Tanggal</th>
                              <th>Nominal</th>
                              <th>Bayar</th>
                              <th></th>
                          </tr>
                          <tr>
                            <td><input type="text" class="form-control datepicker" name="tanggal_asuransi" value="<?=$asuransibayar->getByAkademik($akademik_aktif['id'])['tanggal'] ? date('d-m-Y', strtotime($asuransibayar->getByAkademik($akademik_aktif['id'])['tanggal'])) : ''?>"></td>
                            <td>
                                <?=rupiah($asuransi->getByTingkatAjaran($akademik_aktif['tingkat'], $th['nama'])['nominal'])?>
                                <input type="hidden" name="nominal_asuransi" value="<?=rupiah($asuransi->getByTingkatAjaran($akademik_aktif['tingkat'], $th['nama'])['nominal'])?>">
                            </td>
                            <td>
                              <div class="checkbox icheck">
                                  <input type="checkbox" name="lunas_asuransi" value="Yes" <?=$asuransibayar->getByAkademik($akademik_aktif['id'])['lunas'] == 'Yes' ? 'checked' : ''?>>
                              </div>
                            </td>
                            <td>
                              <?php if ($asuransibayar->getByAkademik($akademik_aktif['id'])): ?>
                                <a href="javascript:void(0)" onclick="confirmation('<?=$akademik_aktif['id'] . '&nis=' . $_REQUEST['nis']?>','page/pembayaran_asuransi_del.php')" class="btn btn-danger btn-md"><i class="fa fa-trash"></i></a>
                              <?php endif; ?>
                            </td>
                          </tr>
                      </table>
                    <?php endif; ?>
                    </div>
                  </div>
              </div>
              <div class="box box-success box-solid">
                  <div class="box-header with-border">
                      <h1 class="box-title">Peningkatan Mutu</h1>
                  </div>
                  <div class="box-body">
                  <div class="table-responsive">
                    <?php if (isset($_REQUEST['nis'])): ?>
                      <table class="table">
                          <tr>
                              <th>Tanggal</th>
                              <th>Nominal</th>
                              <th>Bayar</th>
                              <th></th>
                          </tr>
                          <tr>
                              <td><input type="text" class="form-control datepicker" name="tanggal_mutu" value="<?=$mutu->getByNis($_REQUEST['nis'])['tanggal'] ? date('d-m-Y', strtotime($mutu->getByNis($_REQUEST['nis'])['tanggal'])) : ''?>"></td>
                              <td><?=rupiah($mutu->getByNis($_REQUEST['nis'])['nominal'])?></td>
                              <td>
                                <div class="checkbox icheck">
                                    <input type="checkbox" name="lunas_mutu" value="Yes" <?=$mutu->getByNis($_REQUEST['nis'])['lunas'] == 'Yes' ? 'checked' : ''?>>
                                </div>
                              </td>
                              <td>
                              <?php if ($mutu->getByNis($_REQUEST['nis'])['lunas'] == 'Yes'): ?>
                                <a href="javascript:void(0)" onclick="confirmation('<?=$_REQUEST['nis']?>','page/pembayaran_mutu_del.php')" class="btn btn-danger btn-md"><i class="fa fa-trash"></i></a>
                              <?php endif; ?>
                              </td>
                          </tr>
                      </table>
                    <?php endif; ?>
                  </div>
                  </div>
              </div>
          </div>
          <div class="col-md-4">
              <div class="box box-warning box-solid">
                  <div class="box-header with-border">
                      <h1 class="box-title">Investasi</h1>
                  </div>
                  <div class="box-body">
                  <div class="table-responsive">
                    <?php if (isset($_REQUEST['nis'])): ?>
                      <table class="table">
                          <tr>
                              <th>No</th>
                              <th>Tanggal</th>
                              <th>Bayar</th>
                              <th></th>
                          </tr>
                            <?php $no = 1; foreach ($investasiBayar->getByNis($_REQUEST['nis']) as $row): ?>
                            <tr>
                                <td><?=$no++?></td>
                                <td><?=date('d-m-Y', strtotime($row['tanggal']))?></td>
                                <td><?=rupiah($row['nominal'])?></td>
                                <td>
                                    <a href="javascript:void(0)" onclick="confirmation('<?=$row['id']?>','page/pembayaran_investasi_del.php')" class="btn btn-danger btn-md"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                          <tr>
                              <td>#</td>
                              <td><input type="text" class="form-control datepicker" name="tanggal_investasi"></td>
                              <td><input type="text" class="form-control" name="investasi_nominal" id="investasi-nominal"></td>
                          </tr>
                      </table>
                      <h4>Tagihan : <?=rupiah($investasi->getByNis($_REQUEST['nis'])['nominal'])?></h4>
                      <h4>Jumlah Bayar : <?=rupiah($investasi->getByNis($_REQUEST['nis'])['bayar'])?></h4>
                      <h4>Kekurangan : <?=rupiah($investasi->getByNis($_REQUEST['nis'])['nominal'] - $investasi->getByNis($_REQUEST['nis'])['bayar'])?></h4>
                    <?php endif; ?>
                  </div>
                  </div>
              </div>
              <div class="box box-danger box-solid">
                  <div class="box-header with-border">
                      <h1 class="box-title">PBI</h1>
                  </div>
                  <div class="box-body">
                  <div class="table-responsive">
                    <?php if (isset($_REQUEST['nis'])): ?>
                      <table class="table">
                          <tr>
                              <th>No</th>
                              <th>Tanggal</th>
                              <th>Bayar</th>
                          </tr>
                          <?php $no = 1; foreach ($bimbelbayar->getByNis($_REQUEST['nis']) as $row): ?>
                            <tr>
                                <td><?=$no++?></td>
                                <td><?=date('d-m-Y', strtotime($row['tanggal']))?></td>
                                <td><?=rupiah($row['nominal'])?></td>
                                <td>
                                    <a href="javascript:void(0)" onclick="confirmation('<?=$row['id']?>','page/pembayaran_bimbel_del.php')" class="btn btn-danger btn-md"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <tr>
                              <td>#</td>
                              <td><input type="text" class="form-control datepicker" name="tanggal_bimbel"></td>
                              <td><input type="text" class="form-control" name="bimbel_nominal" id="bimbel-nominal"></td>
                          </tr>
                      </table>
                      <h4>Tagihan : <?=rupiah($bimbel->getByNis($_REQUEST['nis'])['nominal'])?></h4>
                      <h4>Jumlah Bayar : <?=rupiah($bimbel->getByNis($_REQUEST['nis'])['bayar'])?></h4>
                      <h4>Kekurangan : <?=rupiah($bimbel->getByNis($_REQUEST['nis'])['nominal'] - $bimbel->getByNis($_REQUEST['nis'])['bayar'])?></h4>
                    <?php endif; ?>
                  </div>
                  </div>
              </div>
          </div>
          </div>
        </div>
        <div class="box-footer">
          <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> SIMPAN</button>
        </div>
        </form>
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->