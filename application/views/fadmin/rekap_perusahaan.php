
  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Rekap Data Pengguna Lulusan
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url()?>admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li>Rekap Data</li>
        <li class="active">Pengguna Lulusan</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Pengguna Lulusan</h3>
        </div>
        <div class="box-body">
<!-- conternt here -->

<p>Di bawah ini merupakan data pengguna lulusan dimana alumni bekerja.<p>
    <hr/>
        <div class="table-responsive">
            <table id="tbl-hello" class="table table-hover ui-corner-tr ui-helper-clearfix">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Perusahaan</th>
                        <th>Bidang Usaha</th>
                        <th>Alamat</th>
                        <th>Email</th>
                        <th>Jumlah Mahasiswa</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
<?php
    $no = 1;
    foreach ($perusahaan as $key => $value) {
?>
                    <tr>
                        <td><?=$no++?></td>
                        <td><?=$value['nama_perusahaan']?></td>
                        <td><?=$value['bidang_usaha']?></td>
                        <td><?=$value['lokasi']?></td>
                        <td><?=$value['email']?></td>
                        <td>
                            <?="<button type='button' id='btn-perusahaan-alumni' class='btn btn-info btn-xs' data-target='#modalDetail' data-toggle='modal' data-pengguna='".$value['nama_perusahaan']."' data-kdprodi='".$value['kd_prodi']."'>".$value['jml_mhs']." Mahasiswa</button>"?></td>
                        <td>
                            <button type="button" class="btn btn-success btn-xs"><i class="fa fa-pencil"></i> buat akun</button>
                        </td>
                    </tr>
<?php } ?>
                </tbody>
            </table>
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


<!-- Modal -->
<div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><div id="text-title"></div></h4>
      </div>
      <div class="modal-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Angkatan</th>
                    <th>Posisi</th>
                    <th>Lama Bekerja</th>
                </tr>
            </thead>
            <tbody id="detail-alumni">

            </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>