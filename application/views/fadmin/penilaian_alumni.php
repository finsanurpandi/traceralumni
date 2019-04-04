
<style>
    canvas {
        width: 100% !important;
        height: auto !important;
    }
</style>
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
<form class="form-inline" method="post">
  <div class="form-group">
    <label for="exampleInputName2">dari</label>
    <input type="text" name="dari" class="form-control" placeholder="2014/2015" required>
  </div>
  <div class="form-group">
    <label for="exampleInputEmail2">sampai</label>
    <input type="text" name="sampai" class="form-control" placeholder="2017/2018" required>
  </div>
  <button type="submit" name="setYear" class="btn btn-default"><i class="fa fa-search"></i> filter</button>
</form>

<hr/>
<a href="<?=base_url().'cetak/cetak_data_alumni/'.$from.'/'.$until?>" class="btn btn-primary btn-sm" target="_blank"><i class="fa fa-print"></i> Cetak</a>
<br/>
<br/>

<?php
  if (@$this->session->flashdata('filter') == true) {
?>
<div class="alert alert-info">Data lulusan dari tahun akademik <?=@$from?> hingga <?=@$until?></div>
<?php
  }
?>
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
        <canvas id="pieChart3"></canvas>
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
        <canvas id="pieChart1"></canvas>
    </div>

    <div class="col-md-6">
        <canvas id="pieChart2"></canvas>
    </div>

    </div>
    </div><!-- /.box-body -->
</div><!-- /.box -->
<!-- END OF DATA ALUMNI MENGISI TRACER -->

<!-- Data Status Alumni -->
<!-- <div class="row">
<div class="col-md-6 col-xs-12"> -->

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
    </div> <!-- col-md-6 -->

    <div class="col-md-6">
        <canvas id="pieChart4"></canvas>
    </div>
    </div> <!-- row -->
    </div><!-- /.box-body -->
</div><!-- /.box info-->


<!-- <div class="col-md-6 col-xs-12"> -->

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Rata-Rata Waktu Tunggu</h3>
    </div>
    <div class="box-body">
    <div class="row">
    <div class="col-md-6">

    <?php
    if ($this->session->kdprodi == '26201') {
        echo "<h1>1.5 Bulan</h1>";
    } else {
    if ($config['value'] == '1') {
    ?>

    <table class="table table-hover">
    <thead>
        <tr>
            <th>#</th>
            <th>Tahun Akademik</th>
            <th>Rata-Rata Waktu Tunggu</th>
        <tr>
    </thead>
    <tbody>
        <tr>
            <td>1</td>
            <td>2013-2014</td>
            <td>3.1 Bulan</td>
        </tr>
        <tr>
            <td>2</td>
            <td>2014-2015</td>
            <td>2.8 Bulan</td>
        </tr>
        <tr>
            <td>3</td>
            <td>2015-2016</td>
            <td>3 Bulan</td>
        </tr>
        <tr>
            <td>4</td>
            <td>2016-2017</td>
            <td>2.6 Bulan</td>
        </tr>
        <tr>
            <td>5</td>
            <td>2017-2018</td>
            <td>2.5 Bulan</td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2" align="right"><strong>Rata-Rata</strong></td>
            <td>2.8 Bulan</td>
        </tr>
    </tfoot>
    </table>

    <?php
    } else {
    ?>

    <table class="table table-hover">
    <thead>
        <tr>
            <th>#</th>
            <th>Tahun Akademik</th>
            <th>Rata-Rata Waktu Tunggu</th>
        <tr>
    </thead>
    <tbody>
<?php
$no = 1;
$jmlBulan = 0;
$jmlNgisi = 0;
$totalWaktuTunggu = 0;
    foreach ($jmlalumni as $key => $value) {
?>
        <tr>
            <td><?=$no++?></td>
            <td><?=$value['thn_akademik']?></td>
            <td><?=round(($value['bln']/$value['ngisi']),2)?> Bulan</td>
        </tr>
<?php 
$jmlBulan += $value['bln'];
$jmlNgisi += $value['ngisi'];
    }
}
    $totalWaktuTunggu = round(($jmlBulan/$jmlNgisi),2);
?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2" align="right"><strong>Rata-Rata</strong></td>
            <td><?=$totalWaktuTunggu?> Bulan</td>
        </tr>
    </tfoot>
    </table>
    
    <?php } ?>

    <!-- hide this for a while -->
    <!-- <h1><?=$ratabulan?> Bulan</h1> -->
    <?php
    if ($this->session->kdprodi == '22201') {
        echo "<h1>2 Bulan</h1>";
    } elseif ($this->session->kdprodi == '26201') {
        // echo "<h1>".$ratabulan." Bulan</h1>";
    } elseif ($this->session->kdprodi == '55201') {
        // echo "<h1>".$ratabulan." Bulan</h1>";
    }
    ?>

    </div> <!-- col-md-6 -->
    

    <div class="col-md-6">
    <?php
        if ($this->session->kdprodi !== '26201') {
        if ($config['value'] == '1') {
    ?>
        <canvas id="pieChart5"></canvas>
    <?php } else { ?>

        <canvas id="pieChart6"></canvas>
    
    <?php } }?>
    <div class="col-md-6">
    </div> <!-- row -->
    </div><!-- /.box-body -->
</div><!-- /.box -->

</div>
</div>

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

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
<script>
var tracerAlumni = [<?=count($totalTracer)?>, <?=count($totalAlumni)-count($totalTracer)?>];
var label = [];
var jumlah = [];
var warna = [];
var thnAkademik = [];
var jmlMhs = [];
var statusAlumni = [];
var waktuTunggu = [];
var bgcolor = [];
var lncolor = [];
var setupWaktuTunggu = <?=$config['value']?>;

<?php foreach ($totalTracerAngkatan as $key => $value) { ?>
    label.push("<?=$value['angkatan']?>");
    jumlah.push("<?=$value['jumlah']?>");
<?php } ?>

<?php foreach ($jmlalumni as $key => $value) { ?>
    thnAkademik.push("<?=$value['thn_akademik']?>");
    jmlMhs.push("<?=$value['jumlah']?>");
    waktuTunggu.push("<?=round(($value['bln']/$value['ngisi']),2) ?>");
    bgcolor.push('rgba(54, 162, 235, 1)');
    lncolor.push('rgba(54, 162, 235, 0.8)');
<?php } ?>

<?php foreach ($statusAlumni as $key => $value) { ?>
    // statusAlumni.push("<?=round(($value['jumlah']/count($totalTracer))*100,2)?>");
    statusAlumni.push("<?=$value['jumlah']?>");
<?php } ?>

var dynamicColors = function(){
    var r = Math.floor(Math.random() * 255);
    var g = Math.floor(Math.random() * 255);
    var b = Math.floor(Math.random() * 255);
    return "rgba(" + r + ", " + g + ", " + b + ", 1)";
}

for (var i in jumlah) {
    warna.push(dynamicColors());
}

var ctx1 = document.getElementById("pieChart1");
var ctx2 = document.getElementById("pieChart2");
var ctx3 = document.getElementById("pieChart3");
var ctx4 = document.getElementById("pieChart4");
var ctx5 = document.getElementById("pieChart5");
var ctx6 = document.getElementById("pieChart6");

var pichart1 = new Chart(ctx1, {
    type: 'pie',
    data: {
        labels: ["Mengisi", "Tidak Mengisi"],
        datasets: [{
            data: tracerAlumni,
            backgroundColor: [
                'rgba(54, 162, 235, 1)',
                'rgba(255, 99, 132, 1)'
            ]
        }]
    }
});


var pichart2 = new Chart(ctx2, {
    type: 'doughnut',
    data: {
        labels: label,
        datasets: [{
            data: jumlah,
            backgroundColor: warna
        }]
    }
})

var pichart3 = new Chart(ctx3, {
    type: 'line',
    data: {
        labels: thnAkademik,
        datasets: [{
            data: jmlMhs,
            label: 'Jumlah Lulusan',
            borderColor: ['rgba(54, 162, 235, 1)'],
            pointBackgroundColor: 'rgb(255, 99, 132)',
            pointBorderColor: 'rgb(255, 99, 132)'
        }]
    }
})

var pichart4 = new Chart(ctx4, {
    type: 'pie',
    data: {
        labels: ["Bekerja", "Wirausaha", "Belum Bekerja", "Tidak Bekerja/Berkeluarga"],
        datasets: [{
            data: statusAlumni,
            backgroundColor: [
                'rgba(75, 192, 192, 0.8)',
                'rgba(54, 162, 235, 0.8)',
                'rgba(255, 206, 86, 0.8)',
                'rgba(255, 99, 132, 0.8)'
            ]
        }]
    }
});

if (setupWaktuTunggu == 1) {

var pichart5 = new Chart(ctx5, {
    type: 'bar',
    data: {
        labels: ['2013-2014', '2014-2015', '2015-2016', '2016-2017', '2017-2018'],
        datasets: [{
            data: [3.1, 2.8, 3, 2.6, 2.5],
            label: 'Tahun Akademik',
            borderColor: [
                'rgba(54, 162, 235, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(54, 162, 235, 1)'
                ],
            backgroundColor: [
                'rgba(54, 162, 235, 0.8)',
                'rgba(54, 162, 235, 0.8)',
                'rgba(54, 162, 235, 0.8)',
                'rgba(54, 162, 235, 0.8)',
                'rgba(54, 162, 235, 0.8)'
                ]
        }]
    }
});

} else {

var pichart6 = new Chart(ctx6, {
    type: 'bar',
    data: {
        labels: thnAkademik,
        datasets: [{
            data: waktuTunggu,
            label: 'Rata-rata Bulan',
            borderColor: lncolor,
            backgroundColor: bgcolor
        }]
    }
});

}
</script>