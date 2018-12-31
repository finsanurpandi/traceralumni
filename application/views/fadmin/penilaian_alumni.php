

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    <h1>
        Data Alumni
        <!-- <small>it all starts here</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url()?>feedbackadmin"><i class="fa fa-dashboard"></i> Hasil Penilaian</a></li>
        <li class="active">Alumni</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Program Studi <?=$prodi[0]['prodi']?></h3>
        </div>
        <div class="box-body">
<!-- conternt here -->
<form class="form-inline">
  <div class="form-group">
    <label for="exampleInputName2">dari</label>
    <input type="text" name="dari" class="form-control" placeholder="2014/2015">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail2">sampai</label>
    <input type="email" name="sampai" class="form-control" placeholder="2017/2018">
  </div>
  <button type="submit" name="filter" class="btn btn-default">filter</button>
</form>

<hr/>

<!-- Data jumlah lulusan -->
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Data Lulusan</h3>
    </div>
    <div class="box-body">
    <div class="row">
    <div class="col-md-6">

    <table class="table table-hover">
    <thead>
        <tr>
            <th>#</th>
            <th>Tahun Akademik</th>
            <th>Jumlah Lulusan</th>
        <tr>
    </thead>
    <tbody>
<?php
$no = 1;
$jml = 0;
    foreach ($jmlalumni as $key => $value) {
?>
        <tr>
            <td><?=$no++?></td>
            <td><?=$value['thn_akademik']?></td>
            <td><?=$value['jumlah']?></td>
        </tr>
<?php 
$jml += $value['jumlah'];
    }
?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2" align="right"><strong>Total</strong></td>
            <td><?=$jml?></td>
        </tr>
    <tfoot>
    </table>
    </div>
    <div class="col-md-6">
        <canvas id="barChart" style="height:230px"></canvas>
        <!-- <canvas id="lineChart" style="height:250px"></canvas> -->
    </div>
    </div>
    </div><!-- /.box-body -->
</div><!-- /.box -->
<!-- END OF DATA JUMLAH LULUSAN -->


<!-- Data alumni mengisi tracer alumni -->
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Data Alumni Mengisi Tracer Alumni</h3>
    </div>
    <div class="box-body">
    <div class="row">
    <div class="col-md-6">

    <table class="table table-hover">
    <thead>
        <tr>
            <th>Trace Alumni</th>
            <th>Jumlah</th>
        <tr>
    </thead>
    <tbody>
    <?php
    
    ?>
        <tr>
            <td>Mengisi</td>
            <td><?=count($totalTracer)?></td>
        </tr>
        <tr>
            <td>Tidak Mengisi</td>
            <td><?=count($totalAlumni)-count($totalTracer)?></td>
        </tr>
    </tbody>
    </table>
    </div>
    <div class="col-md-6">
    <table class="table table-hover">
    <thead>
        <tr>
            <th>Angkatan</th>
            <th>Jumlah Mengisi</th>
        <tr>
    </thead>
    <tbody>
    <?php
        foreach ($totalTracerAngkatan as $key => $value) {
    ?>
        <tr>
            <td><?=$value['angkatan']?></td>
            <td><?=$value['jumlah']?></td>
        </tr>
                <?php } ?>
    </tbody>
    </table>
    </div>
    </div>

    <div class="row">
    <div class="col-md-6">
        hello, aku adalah pie chart
    </div>

    <div class="col-md-6">
        hello, aku adalah pie chart
    </div>

    </div>
    </div><!-- /.box-body -->
</div><!-- /.box -->
<!-- END OF DATA ALUMNI MENGISI TRACER -->

<!-- Data Status Alumni -->
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Data Status Alumni</h3>
    </div>
    <div class="box-body">
    <div class="row">
    <div class="col-md-6">

    <table class="table table-hover">
    <thead>
        <tr>
            <th>Lulusan</th>
            <th>Persentase</th>
            <th>Jumlah Alumni</th>
        <tr>
    </thead>
    <tbody>
    <?php
        foreach ($statusAlumni as $key => $value) {
    ?>
        <tr>
            <td>
                <?php
                    if ($value['status'] == 1) {
                        echo "Bekerja";
                    } elseif ($value['status'] == 2) {
                        echo "Wirausaha";
                    } elseif ($value['status'] == 3) {
                        echo "Belum Bekerja";
                    } elseif ($value['status'] == 4) {
                        echo "Tidak Bekerja/Berkeluarga";
                    }
                ?>
            </td>
            <td><?=round(($value['jumlah']/count($totalTracer))*100,2)?>%</td>
            <td><?=$value['jumlah']?></td>
        </tr>
                <?php } ?>
    </tbody>
    </table>
    </div>
    <div class="col-md-6">
        
    
    </div>
    </div>
    </div><!-- /.box-body -->
</div><!-- /.box -->
<!-- END OF DATA STATUS ALUMNI -->





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


<script>
let labels = [];
let datas = [];

<?php
foreach ($jmlalumni as $key => $value) {
?>
labels.push("<?=$value['tahun_akademik']?>");
datas.push(<?=$value['jumlah']?>);
<?php } ?>

</script>


