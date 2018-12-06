<?php
    // $nilai = array(1,2,3,4,5);
    // $nilai = array(1 => "Kurang",2 => "Cukup",3 => "Baik",4 => "Sangat Baik");
    $nilai = array(4 => "Sangat Baik", 3 => "Baik", 2 => "Cukup", 1 => "Kurang");
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
        <div class="well well-sm">
          <h4>Silahkan mengisi penilaian kinerja dari alumni kami.</h4>
          <h4>Anda sedang mengisi penilaian untuk <strong><?=$alumni['nama']?></strong>.</h4>
        </div>

          <div class="row"> <!-- row start -->
          <div class="col-md-12 col-xs-12"> <!-- col-md and col-xs -->
          <form method="post">
            <div class="table-responsive">
            <table class="table table-border table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Uraian Kinerja Dosen</th>
                    <th>Penilaian</th>
                </tr>
            </thead>
            <tbody>
<?php
$no = 1;
for ($i=0; $i < count($uraian); $i++) { 
?>
            <tr>
                <td><?=$no++?></td>
                <td>
                <?=$uraian[$i]['uraian']?>
                <input type="hidden" name="kd_aspek[<?=$i?>]" value="<?=$uraian[$i]['kd_aspek']?>"/></td>
                <input type="hidden" name="kd_prodi" value="<?=$alumni['kd_prodi']?>"/></td>
                </td>
                <td>
                <?php
                foreach ($nilai as $key => $value) {
                ?>
                <label class="radio-inline">
                    <input type="radio" name="nilai[<?=$i?>]" value="<?=$key?>" required><?=$value?>
                </label>
                <?php } ?>
                </td>
            </tr>
<?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3"><div class="text-center">
                    <input type="submit" value="Kirim" class="btn btn-primary btn-xs" name="sbmtPenilaian"/>
                    </td>
                </tr>
            </tfoot>
            </table>
            </div> <!-- table responsive -->
            </form>
            </div> <!-- col-md and col-xs -->
            </div> <!-- row end -->

            <div class="order-process text-center">
            <br/><hr/>
                <span class="dot"></span>
                <span class="dot"></span>
                <span class="dot on-process"></span>
                <span class="dot"></span>
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
