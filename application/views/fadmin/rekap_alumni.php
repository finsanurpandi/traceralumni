<?php
  function getMonth($bln)
  {
    switch ($bln) {
      case '1':
        echo "Jan";
        break;
      case '2':
        echo "Feb";
        break;
      case '3':
        echo "Mar";
        break;
      case '4':
        echo "Apr";
        break;
      case '5':
        echo "May";
        break;
      case '6':
        echo "Jun";
        break;
      case '7':
        echo "Jul";
        break;
      case '8':
        echo "Aug";
        break;
      case '9':
        echo "Sep";
        break;
      case '10':
        echo "Oct";
        break;
      case '11':
        echo "Nov";
        break;
      case '2':
        echo "Dec";
        break;
    }
  }

  function getStatus($stt)
  {
      if ($stt == 1) {
        echo "<div class='label label-success'>Bekerja</div>";
      } elseif ($stt == 2) {
        echo "<div class='label label-info'>Wirausaha</div>";
      } elseif ($stt == 3) {
        echo "<div class='label label-warning'>Belum Bekerja</div>";
      } elseif ($stt == 4) {
        echo "<div class='label label-danger'>Tidak Bekerja/Berkeluarga</div>";
      }
  }
?>
  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Rekap Data Alumni
      </h1>
      <ol class="breadcrumb">
      <li><a href="<?=base_url()?>admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li>Rekap Data</li>
        <li class="active">Tracer Alumni</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Tracer Alumni</h3>
        </div>
        <div class="box-body">
<!-- conternt here -->
<p>Dibawah ini merupakan data alumni yang telah melakukan registrasi ulang, dan telah mengisi tracer alumni.<p>
    <hr/>
        <div class="table-responsive">
            <table id="tbl-hello" class="table table-hover ui-corner-tr ui-helper-clearfix">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>NPM</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Angkatan</th>
                        <th>Lulus</th>
                        <th>Status</th>
                        <th>Detail</th>
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
                        <td><?=$value['email']?></td>
                        <td><?=$value['angkatan']?></td>
                        <td><?=getMonth($value['bln_lulus']).' - '.$value['thn_lulus']?></td>
                        <td><?=getStatus($value['status'])?></td>
                        <td>
                            <button id="btnDetailAlumni" type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modalDetail" data-npm="<?=$value['npm']?>" data-nama="<?=$value['nama']?>"><i class="fa fa-search"></i> detail</button>
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
  <div class="modal-dialog" role="document">
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
                    <th>Nama Perusahaan</th>
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
