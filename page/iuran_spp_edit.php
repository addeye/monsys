<?php
$user->cek_admin();
$data = new SppAjaran();
$data = $data->getById($_GET['id']);
?>
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      DATA IURAN SPP
      </h1>
      <ol class="breadcrumb">
        <li class="active"><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Perbaruhi Iuran SPP</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Perbaruhi Iuran SPP</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <form action="page/iuran_spp_act.php?id=<?=$data['id']?>" method="post">
                        <input type="hidden" name="aksi" value="edit">
                        <div class="form-group">
                            <label for="">Th. Ajaran Aktif <?=$th['nama']?></label>
                        </div>
                        <div class="form-group">
                            <label for="">Tingkat</label>
                            <select name="tingkat" class="form-control" required>
                                <option value="">Pilih</option>
                                <?php foreach (kelas() as $row): ?>
                                    <option value="<?=$row?>" <?=$data['tingkat'] == $row ? 'selected' : ''?> ><?=$row?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Nominal</label>
                            <input type="text" id="bayar" name="nominal" class="form-control" value="<?=$data['nominal']?>" placeholder="Jumlah nominal" required>
                        </div>
                        <button class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
                        <a href="index.php?page=iuran_spp" class="btn btn-warning"><i class="fa fa-reply"></i> Kembali</a>
                    </form>
                </div>
            </div>

        </div>
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
<script type="text/javascript">

//inisialisasi inputan
var bayar = document.getElementById('bayar');

bayar.value = formatRupiah(bayar.value, 'Rp. ');

bayar.addEventListener('keyup', function (e) {
    bayar.value = formatRupiah(this.value, 'Rp. ');
    // harga = cleanRupiah(dengan_rupiah.value);
    // calculate(harga,service.value);
});

//generate dari inputan angka menjadi format rupiah

function formatRupiah(angka, prefix) {
    var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split = number_string.split(','),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
}

//generate dari inputan rupiah menjadi angka

function cleanRupiah(rupiah) {
    var clean = rupiah.replace(/\D/g, '');
    return clean;
    // console.log(clean);
}
</script>