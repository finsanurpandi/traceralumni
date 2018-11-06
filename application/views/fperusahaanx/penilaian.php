
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

          <div class="initial-section well well-sm">
            <h4>Apakah anda sudah pernah mengisi penilaian sebelumnya?</h4>
            <button type="button" class="btn btn-primary btn-xs" id="btn-pernah">Ya, sudah</button>
            <button type="button" class="btn btn-primary btn-xs" id="btn-belum">Belum pernah</button>
          </div>

          <div class="section-belum">
            <div class="well well-sm">
                <h4>Sebelum mengisi form penilaian, silahkan melakukan pengisian data terlebih dahulu.</h4>
            </div>
            
            <div class="row"> <!-- row start -->
            <div class="col-md-4 col-xs-12"> <!-- col-md and col-xs -->
            <form method="post">
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" class="form-control input-sm" name="nama"/>
                </div>
                <div class="form-group">
                    <label>Nomor Induk Kepegawaian</label>
                    <input type="number" class="form-control input-sm" name="nik"/>
                </div>
                <div class="form-group">
                    <label>Posisi/Jabatan</label>
                    <input type="text" class="form-control input-sm" name="posisi"/>
                </div>
                <div class="form-group">
                <button type="button" id="btn-pernah-mengisi" class="btn btn-link btn-xs">Sudah pernah mengisi</button>
                <input type="submit" value="Kirim" class="btn btn-primary btn-xs" name="submit_penilai"/>
                </div>
            </form>
            </div> <!-- col-md and col-xs -->
            </div> <!-- row end -->
          </div>

          <div class="section-pernah">
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

          <div class="order-process">
          <br/><hr/>
            <span class="dot on-process"></span>
            <span class="dot"></span>
            <span class="dot"></span>
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
