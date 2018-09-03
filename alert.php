<?php if (isset($_SESSION['success']) && $_SESSION['success'] != ''): ?>
<div class="alert alert-success alert-dismissible">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
<h4><i class="icon fa fa-check"></i> Berhasil!</h4>
<?=$_SESSION['success']?>
</div>
<?php $_SESSION['success'] = ''; endif; ?>

<?php if (isset($_SESSION['info']) && $_SESSION['info'] != ''): ?>
<div class="alert alert-info alert-dismissible">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
<h4><i class="icon fa fa-check"></i> Perbaruhi !</h4>
<?=$_SESSION['info']?>
</div>
<?php $_SESSION['info'] = ''; endif; ?>


<?php if (isset($_SESSION['error']) && $_SESSION['error'] != ''): ?>
<div class="alert alert-danger alert-dismissible">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
<h4><i class="icon fa fa-check"></i> Gagal!</h4>
<?=$_SESSION['error']?>
</div>
<?php $_SESSION['error'] = ''; endif; ?>