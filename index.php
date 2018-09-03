<?php

require_once 'session.php';
require_once 'helpers/helper.php';
ob_start();

$auth = new Auth();
if (isset($_GET['logout'])) {
    $logout = $auth->getLogout();
    if ($logout) {
        $auth->redirect('login.php');
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Monitoring System | Beranda</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="theme/bower_components/jquery-ui/themes/base/css/jquery-ui.css">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="theme/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="theme/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="theme/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="theme/plugins/iCheck/square/blue.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="theme/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="theme/bower_components/select2/dist/css/select2.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="theme/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="theme/dist/css/skins/_all-skins.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <style type="text/css">
    .help-block-red {
      background: red;
    }
    .help-block-blue {
      background: blue;
    }

    .help-block-yellow {
      background: yellow;
    }

    .help-block-green {
      background: green;
    }

    .help-block-orange {
      background: orange;
    }

    @media (max-width: 455px) {
  .callout h4 {
    margin-top: 0;
    font-weight: 600;
    font-size: 13px;
}

.skin-blue .sidebar-menu>li>.treeview-menu {
    margin: 0 1px;
    background: #2c3b41;
}
}

  </style>

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<!-- ADD THE CLASS sidebar-collapse TO HIDE THE SIDEBAR PRIOR TO LOADING THE SITE -->
<body class="hold-transition skin-blue ">
<!-- Site wrapper -->
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="index.php" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>Mon</b>Sys</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Monitoring</b>System</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="theme/dist/img/avatar5.png" class="user-image" alt="User Image">
              <span class="hidden-xs"><?=$_SESSION['user_name']?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="theme/dist/img/avatar5.png" class="img-circle" alt="User Image">

                <p>
                  <?=$_SESSION['user_name']?>
                  <small><?=$_SESSION['level']?></small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="text-center">
                  <a href="index.php?logout" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>

  <!-- =============================================== -->

  <!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image" title="<?=$th['nama']?>">
          <img src="theme/dist/img/avatar5.png" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?=$_SESSION['user_name']?></p>
          <a href="index.php?page=tahun_ajaran"><i class="fa fa-circle text-success"></i> <?=$th['nama']?></a>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <?php include 'menu.php';?>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <?php
    include 'alert.php';
if (isset($_GET['page']) and file_exists('page/' . $_GET['page'] . '.php')) {
    include 'page/' . $_GET['page'] . '.php';
} else {
    include 'page/home.php';
}
?>
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 1.4.0
    </div>
    <strong>Copyright &copy; 2018 | MonSys by <a href="#">ICT Center</a>.</strong> All rights
    reserved.
  </footer>

  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<?php include 'modal.php'?>

<!-- jQuery 3 -->
<script src="theme/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="theme/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="theme/plugins/iCheck/icheck.min.js"></script>
<!-- bootstrap datepicker -->
<script src="theme/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- Select2 -->
<script src="theme/bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- SlimScroll -->
<script src="theme/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="theme/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="theme/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="theme/dist/js/demo.js"></script>

<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });

    //Date picker
    $('.datepicker').datepicker({
      autoclose: true,
      format:'dd-mm-yyyy',
      todayBtn:'linked'
    });
  });

  $('#copy-nominal').click(function(){
    var nom = $('#nominal-copy').val();
    $('.nominal').val(nom);
  });

  function confirmation(id, link) {
            $('#modalConfirmation').modal('show');
            $('#formdelete').attr('action', link + '?id=' + id);
        }

  function confirmation_set_active(id, link) {
          $('#modalConfirmationActive').modal('show');
          $('#form_set_active').attr('action', link + '?id=' + id);
      }
</script>

<script type="text/javascript">

//inisialisasi inputan

$('.nominal').keyup(function(){
  this.value = formatRupiah(this.value, 'Rp. ');
});

$('#nominal-copy').keyup(function(){
  this.value = formatRupiah(this.value, 'Rp. ');
});

$('#investasi-nominal').keyup(function(){
  this.value = formatRupiah(this.value, 'Rp. ');
});

$('#bimbel-nominal').keyup(function(){
  this.value = formatRupiah(this.value, 'Rp. ');
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

$('.js-data-example-ajax').select2();

</script>
<script>
      var $rows = $('#table tr');
      $('#search').keyup(function() {
          var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();

          $rows.show().filter(function() {
              var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
              return !~text.indexOf(val);
          }).hide();
      });
    </script>
</body>
</html>
