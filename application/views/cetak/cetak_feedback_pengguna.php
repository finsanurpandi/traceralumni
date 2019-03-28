<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Laporan Penilaian Kinerja Dosen</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <style>
        #cetakpenilaian {
            width: 960px;
            margin-left: 50px;
            margin-top: 20px;
            padding: 30px;
            display: block;
            border: 1px solid;
        }
        input{
            margin-left: 50px;
            margin-top: 10px;
        }
        .title > p {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: -10px;
        }
        table {
            margin-top: 20px;
        }

        .table.khusus > thead > tr > th,
        .table.khusus > tbody > tr > th,
        .table.khusus > tfoot > tr > th,
        .table.khusus > thead > tr > td,
        .table.khusus> tbody > tr > td,
        .table.khusus > tfoot > tr > td {
            padding: 0px;
            line-height: 1.42857143;
            vertical-align: top;
            border-top: 0px solid #fff;
        }

        .table > thead > tr > th,
        .table > tbody > tr > th,
        .table > tfoot > tr > th,
        .table > thead > tr > td,
        .table > tbody > tr > td,
        .table > tfoot > tr > td {
            padding: 3px;
            line-height: 1.42857143;
            vertical-align: top;
            border-top: 1px solid #ddd;
        }

        .wrap{
            display: inline-block;
            width:100%;
        }

        .box1{
            display: block;
            width: 100%;
            height: 200px;
            padding-top: 80px;
            border: 1px solid #000;
            float: left;
            margin-bottom: 30px;
        }
        .box2{
            display: block;
            width: 100px;
            height: 100px;
            padding-top: 80px;
            border: 1px solid #000;
            float: left;
            margin-left: 98px;
            margin-top: -111px;
        }
        .box3{
            display: block;
            width: 100px;
            height: 100px;
            padding-top: 80px;
            border: 1px solid #000;
            float: left;
            margin-left: 98px;
            margin-top: -111px;
        }

        .container {
            display: grid;
            grid-template-columns: 0.3fr 3fr;
            grid-auto-rows: minmax(100px, auto);
        }

        .container > div {
            background: #fff;
            padding: 1em;
        }

        .item-a {
            grid-column-start: 1;
            grid-column-end: 2;
            grid-row-start: 1;
            grid-row-end: 2;
        }

        .item-b {
        grid-column-start: 2;
        grid-column-end: 3;
        grid-row-start: 1;
        grid-row-end: 2;
        }

        tbody > tr > td {
            font-size: 12px;
        }

        .row {
            margin-right: -15px;
            margin-left: -15px;
        }

        .row:before, .row:after {
            display: table;
            content: " ";
        }

        .row:after {
            clear: both;
        }

        .col-md-6 {
            position: relative;
            min-height: 1px;
            padding-right: 15px;
            padding-left: 15px;
        }

        @media (min-width: 500px) {
            .col-md-6 {
                float: left;
                width: 50%;
            }
        }



    </style>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
<?php

function percentase($val, $responden)
{
    $persen = ((int)$val/$responden)*100;
    return round($persen,2);
}

?>
<input type="button" class="btn btn-primary btn-xs" onclick="printDiv('cetakpenilaian')" value="Cetak" />
<!-- <a href="#" id="downloadpdf">Download</a> -->
    <div id="cetakpenilaian">
       <h3><img src="<?=base_url()?>assets/img/ft_logo.png" width="8%"/> Fakultas Teknik - Universitas Suryakancana</h3>
       <p style="margin-top:-30px;margin-left:67px;">Jalan Pasir Gede Raya, Bojongherang, Kecamatan Cianjur 43216</p>
       <hr/>
       <div class="text-center">
            <p style="font-size:16px;"><strong>REKAPITULASI <br/>FEEDBACK PENGGUNA LULUSAN <br/>PROGRAM STUDI <?=strtoupper($prodi[0]['prodi'])?>
            </strong>
            </p>
            <hr/>
       </div>
       
       <div class="konten">
       <p class="text-center" style="font-weight:none">Hasil penilaian dilakukan terhadap <?=$responden?> lulusan, yang dinilai oleh <?=count($jumlah)?> perusahan.</p>
       <hr/>
            <div class="row">
                <div class="col-md-12">
                <div class="text-center"><h4>Hasil Penilaian Pengguna Lulusan</h4></div>
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
                </div>
            </div>
<hr/>
            <div class="row">
                <div class="col-md-12">
                <div class="text-center"><h4>Data Pengguna Lulusan</h4></div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Perusahaan</th>
                            <th>Jumlah Feedback Lulusan</th>
                        </tr> 
                    </thead>
                    <tbody>
                    <?php
                        $no = 1;
                        foreach ($jumlah as $key => $value) {
                    ?>
                    <tr>
                        <td><?=$no++?></td>
                        <td><?=$value['nama_perusahaan']?></td>
                        <td><?=$value['jumlah']?> Alumni</td>
                    </tr>
                        <?php } ?>
                        </tbody>
                        </table>
                </div>

                
            </div>
            


<br/><br/>

<div class="text-right">
<p>Cianjur, <?=date("d-M-Y")?></p>
<p style="margin-top:-10px;">Ketua Prodi <?=ucwords($prodi[0]['prodi'])?></p>
<br/><br/><br/>
<p>
<?=$prodi[0]['kaprodi']?>
</p>
</div>
                
       </div>
<hr/>


       
    </div>


    

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
    <script type="text/javascript">
        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }
        
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>

  </body>
</html>