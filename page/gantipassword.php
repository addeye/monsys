<?php
$user->cek_login();

$uuser = new User();

if($_POST){
    $do = $uuser->changePassword($_POST['oldpassword'],$_POST['newpassword'],$_SESSION['user_id']);
    if($do){
        success("Berhasil ganti password");
    }else{
        error("Gagal ganti password, Password lama tidak cocok!");
    }
    $user->redirect('index.php');
}

?>
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Ganti Password
      </h1>
      <ol class="breadcrumb">
        <li class="active"><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Ganti Password</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Masukkan Password</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <form method="post">
                        <input type="hidden" name="aksi" value="add">
                        <div class="form-group">
                            <label for="">Password Lama</label>
                            <input type="text" name="oldpassword" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="">Password Baru</label>
                            <input type="text" name="newpassword" class="form-control" required>
                        </div>
                        <button class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
                        <a href="index.php" class="btn btn-warning"><i class="fa fa-reply"></i> Kembali</a>
                    </form>
                </div>
            </div>

        </div>
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->