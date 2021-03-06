

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Master Data Alumni
        <!-- <small>it all starts here</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url()?>kd_prodi"><i class="fa fa-dashboard"></i> Master Data</a></li>
        <li class="active">Alumni</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Master Data Alumni</h3>
        </div>
        <div class="box-body">
<!-- conternt here -->
<div class="row">
    <!-- LULUS -->
<div class="col-md-6">
    <div class="callout callout-success"><h5>Jumlah Total Mahasiswa Peserta Didik Baru</h5></div>
    <hr/>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Tahun Akademik</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
<?php
foreach ($total as $key => $value) {
?>
        <tr>
            <td><?=$value['thn_akademik']?></td>
            <td><?=$value['Total']?></td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>

 <!-- Mengundurkan Diri -->
 <div class="col-md-6">
 <div class="callout callout-warning"><h5>Jumlah Total Mahasiswa Pindahan</h5></div>
    <hr/>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Tahun Akademik</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
<?php
foreach ($pindahan as $key => $value) {
?>
        <tr>
            <td><?=$value['thn_akademik']?></td>
            <td><?=$value['Total']?></td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>

</div>
<hr/>



<button class="btn btn-primary btn-xs" type="button" data-toggle="modal" data-target="#modalAddAlumni"><i class="fa fa-plus"></i> Tambah Alumni</button>
<?php
  if (@$this->session->flashdata('success') == true) {
?>
    <br/><br/>
    <div class="alert alert-success">Data berhasil ditambahkan!
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <br/>
    </div>

<?php
  } elseif (@$this->session->flashdata('warning') == true) {
?>
    <br/><br/>
    <div class="alert alert-warning">Data berhasil diubah!
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <br/>
    </div>
<?php
  } elseif (@$this->session->flashdata('danger') == true) {
?>
    <br/><br/>
    <div class="alert alert-danger">Data berhasil dihapus!
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <br/>
    </div>
<?php
  }
?> 
<hr/>
<div class="table-responsive">
<table id="tbl-hello" class="table table-hover ui-corner-tr ui-helper-clearfix">
<thead>
    <tr>
        <th>#</th>
        <th>NPM</th>
        <th>Nama Mahasiswa</th>
        <th>Angkatan</th>
        <th>Keterangan</th>
        <th>Jenis Kelamin</th>
        <th>Tanggal Keluar</th>
        <th>IPK</th>
    </tr>
</thead>
<tbody>
<?php
$no = 1;
foreach ($alumni as $key => $value) {

?>
<tr>
      <td><?=$no++?></td>
      <td><?=$value['npm']?></td>
      <td><?=$value['nama']?></td>
      <td><?=$value['angkatan']?></td>
      <td><?=$value['keterangan']?></td>
      <td><?=$value['jk']?></td>
      <td><?=$value['tgl_keluar']?></td>
      <td><?=$value['ipk']?></td>
</tr>
<?php 
            
}
?>
    
</tbody>
</table>

<hr/>





</div>
<!-- end content           -->
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


