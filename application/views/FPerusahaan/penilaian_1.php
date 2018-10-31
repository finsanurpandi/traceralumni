
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
          <h4>Hai <strong><?=$penilai['nama']?></strong>, silahkan masukan data alumni kami yang bekerja diperusahaan anda.</h4>
        </div >

          <div class="row"> <!-- row start -->
          <div class="col-md-4 col-xs-12"> <!-- col-md and col-xs -->
          <form method="post">
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" class="form-control input-sm" name="nama"/>
                </div>
                <div class="form-group">
                    <label>Program Studi Asal Alumni</label>
                    <select class="form-control input-sm" name="kd_prodi">
                        <option></option>
                        <option value="26201">Teknik Industri</option>
                        <option value="55201">Teknik Informatika</option>
                        <option value="22201">Teknik Sipil</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Posisi/Jabatan</label>
                    <input type="text" class="form-control input-sm" name="posisi"/>
                </div>
                <div class="form-group">
                    <label>Bulan Mulai Bekerja</label>
                    <select class="form-control input-sm" name="bulan">
                        <option></option>
                        <option value="1">Januari</option>
                        <option value="2">Februari</option>
                        <option value="3">Maret</option>
                        <option value="4">April</option>
                        <option value="5">Mei</option>
                        <option value="6">Juni</option>
                        <option value="7">Juli</option>
                        <option value="8">Agustus</option>
                        <option value="9">September</option>
                        <option value="10">Oktober</option>
                        <option value="11">November</option>
                        <option value="12">Desember</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Tahun Mulai Bekerja</label>
                    <input type="year" class="form-control input-sm" name="tahun"/>
                </div>
                <div class="form-group">
                <!-- <button type="submit" class="btn btn-primary btn-xs">Kirim</button> -->
                <input type="submit" value="Kirim" class="btn btn-primary btn-xs" name="add-alumni"/>
                </div>
            </form>
            </div> <!-- col-md and col-xs -->
            </div> <!-- row end -->

            <div class="order-process">
            <br/><hr/>
                <span class="dot"></span>
                <span class="dot on-process"></span>
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
