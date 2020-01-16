<?php
$user->cek_siswa();
$akademik = new Akademik();
$data = $akademik->getByAjaran($th['nama']);
$userf = new User();
$sppset = new SppSet();
$spp = new SppAjaran();
$sppbayar = new SppBayar();
$mutubayar = new MutuBayar();
$asuransi = new Asuransi();
$asuransibayar = new AsuransiBayar();
$mutu = new Mutu();

$investasi = new Investasi();
$investasiBayar = new InvestasiBayar();

$bimbel = new BimbelIntensif();
$bimbelbayar = new BimbelIntensifBayar();

$kelas = new Kelas();
$akademik_aktif = $akademik->getByNisAjaran($_SESSION['user_id'], $th['nama']);
$kel = $kelas->getById($akademik_aktif['kelas_id']);

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
          <h3 class="box-title">Pembayaran</h3>
        </div>
        <div class="box-body">
          <div class="row">
          <div class="col-md-8">
              <div class="box box-primary box-solid">
                  <div class="box-header with-border">
                      <h1 class="box-title">SPP & PM</h1>
                  </div>
                  <div class="box-body">
                  <div class="table-responsive">
                    <?php if ($_SESSION['user_id']): ?>
                      <table class="table">
                          <tr>
                              <th>No</th>
                              <th>Tanggal</th>
                              <th>Bulan</th>
                              <th>SPP</th>
                              <th>PM</th>
                          </tr>
                          <?php foreach ($sppset->getByAjaran($th['nama']) as $key => $row): ?>
                          <tr>
                              <td><?=$key + 1?></td>
                              <td>
                                <?=$sppbayar->getByNisPeriode($_SESSION['user_id'], $row['id'])['tanggal'] ? date('d-m-Y', strtotime($sppbayar->getByNisPeriode($_SESSION['user_id'], $row['id'])['tanggal'])) : ''?>
                              </td>
                              <td><?=bulan()[$row['bulan']]?> <?=$row['tahun']?></td>
                              <td>
                                <div class="checkbox icheck">
                                    <?=$sppbayar->getByNisPeriode($_SESSION['user_id'], $row['id'])['lunas'] == 'Yes' ? '<i class="text-blue fa fa-check"></i>' : ''?>
                                </div>
                              </td>
                              <td>
                                <div class="checkbox icheck">
                                    <?=$mutubayar->getByNisPeriode($_SESSION['user_id'], $row['id'])['lunas'] == 'Yes' ? '<i class="text-blue fa fa-check"></i>' : ''?>
                                </div>
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

          </div>
          <div class="col-md-4">
          <div class="box box-info box-solid">
                <div class="box-header with-border">
                    <h1 class="box-title">Asuransi</h1>
                </div>
                <div class="box-body">
                <div class="table-responsive">
                <?php if ($_SESSION['user_id']): ?>
                    <table class="table">
                        <tr>
                            <th>Tanggal</th>
                            <th>Ket</th>
                        </tr>
                        <tr>
                        <td>
                            <?=$asuransibayar->getByAkademik($akademik_aktif['id'])['tanggal'] ? date('d-m-Y', strtotime($asuransibayar->getByAkademik($akademik_aktif['id'])['tanggal'])) : ''?>
                        </td>
                        <td>
                        <?=$asuransibayar->getByAkademik($akademik_aktif['id'])['lunas'] == 'Yes' ? 'Lunas' : 'Belum Lunas'?>
                        </td>
                        </tr>
                    </table>
                <?php endif; ?>
                </div>
                </div>
              </div>
              <div class="box box-warning box-solid">
                  <div class="box-header with-border">
                      <h1 class="box-title">Investasi</h1>
                  </div>
                  <div class="box-body">
                  <div class="table-responsive">
                    <?php if ($_SESSION['user_id']): ?>
                    <h4>Tagihan : <?=rupiah($investasi->getByNis($_SESSION['user_id'])['nominal'])?></h4>
                      <h4>Jumlah Bayar : <?=rupiah($investasi->getByNis($_SESSION['user_id'])['bayar'])?></h4>
                      <h4>Kekurangan : <?=rupiah($investasi->getByNis($_SESSION['user_id'])['nominal'] - $investasi->getByNis($_SESSION['user_id'])['bayar'])?></h4>
                      <table class="table">
                          <tr>
                              <th>No</th>
                              <th>Tanggal</th>
                              <th>Bayar</th>
                          </tr>
                            <?php $no = 1; foreach ($investasiBayar->getByNis($_SESSION['user_id']) as $row): ?>
                            <tr>
                                <td><?=$no++?></td>
                                <td><?=date('d-m-Y', strtotime($row['tanggal']))?></td>
                                <td><?=rupiah($row['nominal'])?></td>
                            </tr>
                            <?php endforeach; ?>
                      </table>
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
                    <?php if ($_SESSION['user_id']): ?>
                    <h4>Tagihan : <?=rupiah($bimbel->getByNis($_SESSION['user_id'])['nominal'])?></h4>
                      <h4>Jumlah Bayar : <?=rupiah($bimbel->getByNis($_SESSION['user_id'])['bayar'])?></h4>
                      <h4>Kekurangan : <?=rupiah($bimbel->getByNis($_SESSION['user_id'])['nominal'] - $bimbel->getByNis($_SESSION['user_id'])['bayar'])?></h4>
                      <table class="table">
                          <tr>
                              <th>No</th>
                              <th>Tanggal</th>
                              <th>Bayar</th>
                          </tr>
                          <?php $no = 1; foreach ($bimbelbayar->getByNis($_SESSION['user_id']) as $row): ?>
                            <tr>
                                <td><?=$no++?></td>
                                <td><?=date('d-m-Y', strtotime($row['tanggal']))?></td>
                                <td><?=rupiah($row['nominal'])?></td>
                            </tr>
                            <?php endforeach; ?>
                      </table>
                    <?php endif; ?>
                  </div>
                  </div>
              </div>
          </div>
          </div>
        </div>
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->