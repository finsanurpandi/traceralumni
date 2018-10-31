<?php
    // $nilai = array(1,2,3,4,5);
    $nilai = array(1 => "Kurang",2 => "Cukup",3 => "Baik",4 => "Sangat Baik");
  ?>
  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Selamat Datang <small><?=$company['nama_perusahaan']?></small>
      </h1>
      <ol class="breadcrumb">
        <li class="active"><a href="#"><i class="fa fa-dashboard"></i> Penilaian</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Penilaian Pengguna Alumni</h3>
        </div>
        <div class="box-body">
<!-- conternt here -->
<?php
// check session
$sessionNik = $this->session->penilai;
if (!isset($sessionNik)) {
?>
        <div class="section-submit-nik">
            <div class="well well-sm">
                <h4>Masukan Nomor Induk Kepegawaian</h4>
            </div>

            <div class="row"> <!-- row start -->
            <div class="col-md-4 col-xs-12"> <!-- col-md and col-xs -->
            <form method="post">
                <div class="form-group">
                    <label>Nomor Induk Kepegawaian</label>
                    <input type="number" class="form-control input-sm" name="nik" id="nikPenilai"/>
                    <div id="status-nik"></div>
                </div>
                <div class="form-group">
                    <button type="button" id="btn-belum-mengisi" class="btn btn-link btn-xs">Belum pernah mengisi</button>
                    <input type="submit" value="Kirim" class="btn btn-primary btn-xs" name="submit_nik" id="submit-nik" disabled="true"/>
                </div>
            </form>
            </div> <!-- col-md and col-xs -->
            </div> <!-- row end -->
          </div>

<?php } else { ?>

        <div class="well well-sm">
          <h4>Terima kasih karena telah melakukan penilaian.</h4>
        </div>

        <h4>Data penilai</h4>
        <strong>Nama</strong>
        <p><?=$penilai['nama']?></p>

        <strong>NIK</strong>
        <p><?=$penilai['nik']?></p>

        <strong>Posisi</strong>
        <p><?=$penilai['posisi']?></p>

        <hr/>
        <p>Telah melakukan penilaian untuk alumni sebagai berikut:</p>

        <div class="table-responsive">
            <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>NAMA</th>
                    <th>POSISI/JABATAN</th>
                    <th>HASIL PENILAIAN</th>
                </tr>
            </thead>
            <tbody>
<?php
$no = 1;
    foreach ($alumni as $key => $value) {
?>
                <tr>
                    <td><?=$no++?></td>
                    <td><?=$value['nama']?></td>
                    <td><?=$value['posisi']?></td>
                    <td>
                        <button id="btn-detail-penilaian" type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#myModal" data-alumni="<?=$value['kd_alumni']?>" data-nama="<?=$value['nama']?>">detail</button>
                    </td>
                </tr>
    <?php } ?>
            </tbody>
            </table>
        </div>

         
<?php } ?>
<!-- end content           -->
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


<!-- MODAL -->
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Hasil Penilaian untuk <span class="text-title"></span></h4>
      </div>
      <div class="modal-body">
        <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Aspek Penilaian</th>
                <th>Hasil Penilaian</th>
            </tr>
        <tbody class="isi-modal">
            
        </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>