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
?>
  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Histori Karir
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url()?>alumni"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li>Informasi</li>
        <li class="active">Karir</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"><?=$user['nama']?></h3>
        </div>
        <div class="box-body">
<!-- conternt here -->

          <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modalAddKarir"><i class="fa fa-plus"></i> Tambah</button>
          <hr/>
<?php
foreach ($karir as $key => $value) {
?>

<div class="bs-callout bs-callout-default">
<button id="btn-edit-karir" type="button" class="close" data-toggle="modal" data-target="#modalEditKarir" data-id="<?=$value['id_karir']?>" aria-label="Close"><i class="fa fa-pencil"></i></button>
  <h4><?=$value['posisi']?></h4>
  <p><?=$value['nama_perusahaan']?> (<small><?=$value['bidang_usaha']?></small>)</p>
  <p><?=$value['lokasi']?></p>
  <p>
  <?php
 

  if ($value['tahun_selesai'] == '0000') {
    getMonth($value['bulan_bekerja']);
    echo " ".$value['tahun_bekerja']." - Sekarang";
  } else {
    getMonth($value['bulan_bekerja']);
    echo " ".$value['tahun_bekerja']." - ";
    getMonth($value['bulan_selesai']);
    echo " ".$value['tahun_selesai'];
  }
  ?>
  </p>
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


<!-- ADD MODAL -->
<div class="modal fade modal-primary-custom" tabindex="-1" role="dialog" id="modalAddKarir">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Tambah Data Karir Alumni</h4>
      </div>

      <div class="modal-body">
        <form method="post">
            <div class="form-group">
                <label>Posisi</label>
                <input type="text" name="posisi" class="form-control" required/>
            </div>
            <div class="form-group">
                <label>Perusahaan</label>
                <input type="text" name="nama_pt" class="form-control" required/>
            </div>
            <div class="form-group">
                <label>Bidang Usaha</label>
                <input type="text" name="bidang_usaha" class="form-control" required/>
            </div>
            <div class="form-group">
                <label>Lokasi</label>
                <textarea class="form-control" name="alamat_pt"></textarea>
            </div>
            <div class="form-group">
                <label>Email Perusahaan</label>
                <input type="text" name="email_pt" class="form-control" required/>
            </div>
            <label>Lama bekerja</label>

            <div class="row">
                <div class="form-group col-md-6">
                    <label>Dari</label>
                    <select name="bulan_bekerja" class="form-control" id="bln_bekerja">
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
                <div class="form-group col-md-6">
                    <label>Sampai</label>
                    <select name="bulan_selesai" class="form-control" id="bln_selesai">
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
            </div>
            <div class="row">
                
                <div class="form-group col-md-6">
                    <input type="year" name="tahun_bekerja" class="form-control" id="thn_bekerja"/>
                </div>
                <div class="form-group col-md-6">
                    <input type="year" name="tahun_selesai" class="form-control" id="thn_selesai"/>
                </div>
                
            </div>
            <div class="checkbox">
                  <label>
                    <input type="checkbox" value="1" name="still_works" id="still_works">
                    Saya masih bekerja di perusahaan ini sampai sekarang.
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" value="1" name="kesesuaian">
                    Pekerjaan ini sesuai dengan bidang keahlian saya
                  </label>
                </div>
</div>
            

      <div class="modal-footer">
        <input type="reset" class="btn btn-default btn-xs" data-dismiss="modal" value="Close">
        <input type="submit" class="btn btn-primary btn-xs" name="addKarir" value="Submit"/>
        </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- EDIT MODAL -->
<div class="modal fade modal-success-custom" tabindex="-1" role="dialog" id="modalEditKarir">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Data Karir Alumni</h4>
      </div>

      <div class="modal-body">
        <form method="post">
            <div class="form-group">
                <label>Posisi</label>
                <input type="text" name="posisi" class="form-control" required id="editKarirPosisi"/>
            </div>
            <div class="form-group">
                <label>Perusahaan</label>
                <input type="text" name="nama_pt" class="form-control" required id="editKarirPerusahaan"/>
            </div>
            <div class="form-group">
                <label>Bidang Usaha</label>
                <input type="text" name="bidang_usaha" class="form-control" required id="editKarirUsaha"/>
            </div>
            <div class="form-group">
                <label>Lokasi</label>
                <textarea class="form-control" name="alamat_pt" id="editKarirLokasi"></textarea>
            </div>
            <div class="form-group">
                <label>Email Perusahaan</label>
                <input type="text" name="email_pt" class="form-control" required id="editKarirEmail"/>
            </div>
            <label>Lama bekerja</label>

            <div class="row">
                <div class="form-group col-md-6">
                    <label>Dari</label>
                    <select name="bulan_bekerja" class="form-control" id="editBulanBekerja">
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
                <div class="form-group col-md-6">
                    <label>Sampai</label>
                    <select name="bulan_selesai" class="form-control" id="editBulanSelesai">
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
            </div>
            <div class="row">
                
                <div class="form-group col-md-6">
                    <input type="year" name="tahun_bekerja" class="form-control" id="editThnBekerja"/>
                </div>
                <div class="form-group col-md-6">
                    <input type="year" name="tahun_selesai" class="form-control" id="editThnSelesai"/>
                </div>
                
            </div>
            <div class="checkbox">
                  <label>
                    <input type="checkbox" value="1" name="still_works" id="editStillWorks">
                    Saya masih bekerja di perusahaan ini sampai sekarang.
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" value="1" name="kesesuaian" id="editKesesuaian">
                    Pekerjaan ini sesuai dengan bidang keahlian saya
                  </label>
                </div>
</div>
            

      <div class="modal-footer">
        <input type="hidden" name="id_karir" id="idKarir"/>
        <input type="reset" class="btn btn-default btn-xs" data-dismiss="modal" value="Close">
        <input type="submit" class="btn btn-success btn-xs" name="editKarir" value="Submit"/>
        </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->