<?php
function check_akun($akun, $perusahaan){
  $company = $perusahaan;

  foreach ($akun as $key => $value) {
    $perusahaan = strtolower($perusahaan);
    $isPerusahaan = strtolower($value['nama_perusahaan']);
    
    $doFind = array('pt.', 'pt. ', 'pt ');
    $perusahaan = str_replace($doFind, '', $perusahaan);
    $isPerusahaan = str_replace($doFind, '', $isPerusahaan);

    if ($perusahaan == ltrim($isPerusahaan)) {
      return "1";
    }
  }
}
?>
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
    <a href="<?=base_url('export/export_perusahaan_xls')?>" class="btn btn-primary btn-xs" target="_blank">export to xls</a>
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
                        <?php
                        $isCheck = check_akun($hasAccount, $value['nama_perusahaan']);

                          if ($isCheck == '1') {
                            echo "<div class='label label-info'>Akun sudah ada</div>";
                          } else {
                        ?>
                        <form method="post">
                            <input type="hidden" name="nama_perusahaan" value="<?=$value['nama_perusahaan']?>"/>
                            <input type="hidden" name="bidang_usaha" value="<?=$value['bidang_usaha']?>"/>
                            <input type="hidden" name="alamat" value="<?=$value['lokasi']?>"/>
                            <input type="hidden" name="email" value="<?=$value['email']?>"/>
                            <input type="submit" name="createAccount" value="Buat Akun" class="btn btn-success btn-xs"/>
                        </form>
                            
                          <?php } ?>
                        </td>
                    </tr>
<?php 

} 
?>
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

<!-- Modal Buat Akun-->
<div class="modal fade" id="modalBuatAkun" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Buat Akun Feedback Pengguna</h4>
      </div>
      <div class="modal-body">
        <div class="isi-detail">
          
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>