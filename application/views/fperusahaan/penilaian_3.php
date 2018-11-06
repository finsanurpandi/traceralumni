
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
        <div class="text-center">
          <h4 class="text-center">Terima kasih telah memberikan penilaian untuk alumni kami yang bernama <strong><?=$alumni['nama']?></strong>.</h4> <br/>
            <a href="<?=base_url()?>feedback/penilaian/<?=$this->encrypt->encode('1')?>" class="btn btn-primary btn-lg">Mengisi lagi?</a><br/><br/>
            <a href="<?=base_url()?>feedback/hasil_penilaian" class="btn btn-primary btn-lg">Selesai</a>
        </div>

            <div class="order-process text-center">
            <br/><hr/>
                <span class="dot"></span>
                <span class="dot"></span>
                <span class="dot"></span>
                <span class="dot on-process"></span>
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
