<?php

function percentase($val, $responden)
{
    $persen = ((int)$val/$responden)*100;
    return round($persen,2);
}

?>
  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Welcome,
      </h1>
      <ol class="breadcrumb">
        <li class="active"><a href="#"><i class="fa fa-dashboard"></i> Welcome</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Selamat Datang</h3>
        </div>
        <div class="box-body">
<!-- conternt here -->
<p>Jumlah tanggapan sebanyak <?=$responden?>
<table class="table table-striped">
<thead>    
    <tr>
        <th>#</th>
        <th>Jenis Kemampuan</th>
        <th>Sangat Baik (%)</th>
        <th>Baik (%)</th>
        <th>Cukup (%)</th>
        <th>Kurang (%)</th>
    </tr>
<thead>
<tbody>
<?php
$no = 1;
    foreach ($data as $key => $value) {
?>
    <tr>
        <td><?=$no++?></td>
        <td><?=$value['uraian']?></td>
        <td><?=percentase($value['sangat_baik'], $responden)?></td>
        <td><?=percentase($value['baik'], $responden)?></td>
        <td><?=percentase($value['cukup'], $responden)?></td>
        <td><?=percentase($value['kurang'], $responden)?></td>
    </tr>
    <?php } ?>
</tbody>
</table>
<br/><br/>
<div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Grafik Tanggapan Pengguna Lulusan</h3>

            </div>
            <div class="box-body">
              <div class="chart">
              <canvas id="myChart" width="400" height="150"></canvas>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
<p>Keterangan:</p>
<p><em>01= Integritas (etika dan moral)</em></p>
<p><em>02= Keahlian Berdasarkan Bidang Ilmu (Profesionalisme)</em></p>
<p><em>03= Bahasa Inggris</em></p>
<p><em>04= Penggunaan Teknologi Informasi</em></p>
<p><em>05= Komunikasi</em></p>
<p><em>06= Kerjasama Tim</em></p>
<p><em>07= Pengembangan Diri</em></p>
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

var sangatbaik = [];
var baik = [];
var cukup = [];
var kurang = [];

<?php foreach ($data as $key => $value) { ?>
    sangatbaik.push(<?=((int)$value['sangat_baik']/$responden)*100?>);
    baik.push(<?=((int)$value['baik']/$responden)*100?>);
    cukup.push(<?=((int)$value['cukup']/$responden)*100?>);
    kurang.push(<?=((int)$value['kurang']/$responden)*100?>);
<?php } ?>


  
    var ctx = document.getElementById("myChart");
    var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ["01", "02", "03", "04", "05", "06", "07"],
        datasets: [{
            label: "Sangat Baik",
            data: sangatbaik,
            backgroundColor: [
                'rgba(75, 192, 192, 0.8)',
                'rgba(75, 192, 192, 0.8)',
                'rgba(75, 192, 192, 0.8)',
                'rgba(75, 192, 192, 0.8)',
                'rgba(75, 192, 192, 0.8)',
                'rgba(75, 192, 192, 0.8)',
                'rgba(75, 192, 192, 0.8)'
            ],
            borderColor: [
                'rgba(75, 192, 192, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(75, 192, 192, 1)'
            ],
            borderWidth: 1
        },
        {
            label: "Baik",
            data: baik,
            backgroundColor: [
                'rgba(54, 162, 235, 0.8)',
                'rgba(54, 162, 235, 0.8)',
                'rgba(54, 162, 235, 0.8)',
                'rgba(54, 162, 235, 0.8)',
                'rgba(54, 162, 235, 0.8)',
                'rgba(54, 162, 235, 0.8)',
                'rgba(54, 162, 235, 0.8)'
            ],
            borderColor: [
                'rgba(54, 162, 235, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(54, 162, 235, 1)'
            ],
            borderWidth: 1
        },
        {
            label: "Cukup",
            data: cukup,
            backgroundColor: [
                'rgba(255, 206, 86, 0.8)',
                'rgba(255, 206, 86, 0.8)',
                'rgba(255, 206, 86, 0.8)',
                'rgba(255, 206, 86, 0.8)',
                'rgba(255, 206, 86, 0.8)',
                'rgba(255, 206, 86, 0.8)',
                'rgba(255, 206, 86, 0.8)'
            ],
            borderColor: [
                'rgba(255, 206, 86, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(255, 206, 86, 1)'
            ],
            borderWidth: 1
        },
        {
            label: "Kurang",
            data: kurang,
            backgroundColor: [
                'rgba(255, 99, 132, 0.8)',
                'rgba(255, 99, 132, 0.8)',
                'rgba(255, 99, 132, 0.8)',
                'rgba(255, 99, 132, 0.8)',
                'rgba(255, 99, 132, 0.8)',
                'rgba(255, 99, 132, 0.8)',
                'rgba(255, 99, 132, 0.8)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(255,99,132,1)',
                'rgba(255,99,132,1)',
                'rgba(255,99,132,1)',
                'rgba(255,99,132,1)',
                'rgba(255,99,132,1)',
                'rgba(255,99,132,1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        legend: {
            position: 'top',
        }
    }
});


</script>