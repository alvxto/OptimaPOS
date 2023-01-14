





<div class="content-wrapper">

<section class="content-header">
<div class="container-fluid">
<div class="row mb-2">
<div class="col-sm-6">
<h1>User</h1>
</div>
<div class="col-sm-6">
<ol class="breadcrumb float-sm-right">
<li class="breadcrumb-item"><a href="<?php echo base_url()?>C_dashboard/index">Dashboard</a></li>
<li class="breadcrumb-item active">User</li>
</ol>
</div>
</div>
</div>
</section>

<section class="content">
<div class="container-fluid">
<div class="row">
<div class="col-12">
<div class="card">
<div class="card-header">
<a type="button" class="btn btn-primary btn-sm" href="<?php echo base_url() ?>C_user/tambahData">Tambah +</a>
</div>

<div class="card-body">
<table class="table table-bordered table-hover">
<thead>
<tr>
<th>Nomer</th>
<th>Username</th>
<th>Action</th>
</tr>
</thead>
<tbody>
	<?php $no=1; ?>
	<?php foreach ($user as $us) :
		?>
	
<tr>
<td><?php echo $no++ ?></td>
<td><?= $us['username'] ?></td>
<td>
	<a class="btn btn-danger btn-sm ms-2" style="float: right;" href="<?= base_url(); ?>C_user/hapusData/<?php echo $us['id_user']; ?>" onclick="return confirm('apakah anda yakin?')">hapus</a>
	<a class="btn btn-dark btn-sm mx-3" style="float: right;" href="<?= base_url(); ?>C_user/editData/<?php echo $us['id_user']; ?>">edit</a>
</td>
</tr>
	<?php endforeach; ?>
</tfoot>
</table>
</div>

</div>



</section>

</div>

