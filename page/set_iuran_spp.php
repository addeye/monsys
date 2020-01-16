<?php
$user->cek_admin();
$spp = new SppSet();

$data = $spp->getByAjaran($th['nama']);
?>
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Set Periode SPP
      </h1>
      <ol class="breadcrumb">
        <li class="active"><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Set Periode SPP</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Set Periode</h3>
        </div>
        <div class="box-body">
          <div class="row">
          <div class="col-md-12">
              <form action="page/set_iuran_spp_act.php" method="POST" class="form-inline">
                <input type="hidden" name="aksi" value="add">
                <input type="hidden" name="tahun_ajaran" value="<?=$th['nama']?>">
                  <div class="form-group">
                      <select name="bulan" id="" class="form-control">
                          <option value="">Pilih Bulan</option>
                            <?php foreach (bulan() as $key => $row): ?>
                                <option value="<?=$key?>"><?=$row?></option>
                            <?php endforeach; ?>
                      </select>
                  </div>
                  <div class="form-group">
                      <input type="number" name="tahun" class="form-control" placeholder="Tahun">
                    </div>
                    <button class="btn btn-primary">SET</button>
              </form>
          </div>
          </div>
        </div>
      </div>
      <!-- /.box -->
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Set Periode</h3>
        </div>
        <div class="box-body">
          <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Bulan</th>
                  <th>Tahun</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($data as $key => $value): ?>
                <tr>
                  <td><?=bulan()[$value['bulan']]?></td>
                  <td><?=$value['tahun']?></td>
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