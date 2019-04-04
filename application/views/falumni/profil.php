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
      case '12':
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
      <br/>
      <ol class="breadcrumb">
        <li><a href="<?=base_url()?>tracerstudy"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Profil</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-body">
<!-- conternt here -->
<div class="row">

<div class="col-md-3"> <!--COL MD 3-->

  <br/>
  <button id="btn-edit-karir" type="button" class="close" data-toggle="modal" data-target="#modalEditPicture" data-id="" aria-label="Close"><i class="fa fa-pencil"></i></button>
  <img src="<?=base_url()?>assets/img/profiles/<?=$user['img']?>" class="profile-user-img img-responsive img-circle" alt="User Image">
  <h3 class="text-center"><?=$user['nama']?></h3>
  <!-- <p class="text-center"><?=$user['npm']?></p> -->
  <?php
  if (count($karir) == '0') {
    echo "<p class='text-center'>Silahkan tambahkan karir</p>";
  } else {
    // echo "<p class='text-center'>".$karir[0]['posisi']." <br/>at<br/> ".$karir[0]['nama_perusahaan']."</p>";
    echo "<p class='text-center'>".$karirSekarang[0]['posisi']." <br/>at<br/> ".$karirSekarang[0]['nama_perusahaan']."</p>";
  }
  ?>
  <br/>
  <div class="text-center">
  <button type="button" id="btn-edit-pass" class="btn btn-success btn-xs" data-toggle="modal" data-target="#modalEditPassword">Change Password</button>
  <hr/>
  
  <button id="btn-edit-karir" type="button" class="close" data-toggle="modal" data-target="#modalEditProfil" data-npm="<?=$this->session->npm?>" aria-label="Close"><i class="fa fa-pencil"></i></button>
  <strong style="font-size:18px;">Alamat</strong>
  <p><?=$user['alamat']?></p>

  <strong style="font-size:18px;">Email</strong>
  <p><?=$user['email']?></p>

  <strong style="font-size:18px;">No Telepon</strong>
  <p><?=$user['no_tlp']?></p>

  <strong style="font-size:18px;">Lulus</strong>
  <p>
    <?php
    getMonth($thn_lulus[1]);
    echo " - ".$thn_lulus[2];
    ?>
  </p>
  </div>
  <hr/>
  
  <div class="text-center">
  <strong style="font-size:18px;">Status anda saat ini</strong>
  <form method="post">
  <select class="form-control" id="status" name="sttSkarang" onchange="this.form.submit()">
    <?php
      if ($user['status'] == 1) {
    ?>
      <option value="1" selected="true">Bekerja</option>
      <option value="2">Wirausaha</option>
      <option value="3">Belum Bekerja</option>
      <option value="4">Tidak Bekerja/Berkeluarga</option>
    <?php
      } elseif ($user['status'] == 2) {
    ?>
      <option value="1">Bekerja</option>
      <option value="2" selected="true">Wirausaha</option>
      <option value="3">Belum Bekerja</option>
      <option value="4">Tidak Bekerja/Berkeluarga</option>
    <?php
      } elseif ($user['status'] == 3) {
    ?>
      <option value="1">Bekerja</option>
      <option value="2">Wirausaha</option>
      <option value="3" selected="true">Belum Bekerja</option>
      <option value="4">Tidak Bekerja/Berkeluarga</option>
    <?php
      } elseif ($user['status'] == 4) {
    ?>
      <option value="1">Bekerja</option>
      <option value="2">Wirausaha</option>
      <option value="3">Belum Bekerja</option>
      <option value="4" selected="true">Tidak Bekerja/Berkeluarga</option>
      <?php } ?>
    </select>
    <input type="hidden" name="changeStatus" value="update"/>
    <input type="hidden" name="npm" value="<?=$user['npm']?>"/>
  </form>

  </div>
</div>

<div class="col-md-9"> <!--COL MD 9-->
<?php
  if (@$this->session->flashdata('success') == true) {
?>
    <div class="alert alert-success">Password berhasil diganti.
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>

<?php
  } elseif (@$this->session->flashdata('failed') == true) {
?>

    <div class="alert alert-danger">Password lama atau ulangi password salah!
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>

<?php
  }
?>
          <!-- <button class="btn btn-primary btn-xs pull-right" data-toggle="modal" data-target="#modalAddKarir"><i class="fa fa-plus"></i> Tambah</button> -->
          <button style="margin-right:20px;margin-top:5px;" type="button" class="close" data-toggle="modal" data-target="#modalAddKarir" aria-label="Close"><i class="fa fa-plus"></i></button>
          <br/>

<?php
if (count($karir) == '0') {
  echo "<hr/>";
}

foreach ($karir as $key => $value) {
?>

<div class="bs-callout bs-callout-primary">
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
</div> <!-- COL MD 9 -->
</div> <!-- ROW -->
<!-- end content           -->
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


<!-- ADD MODAL KARIR-->
<div class="modal fade modal-primary-custom" tabindex="-1" role="dialog" id="modalAddKarir">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Tambah Data Karir Alumni</h4>
      </div>

      <div class="modal-body ui-front">
        <form method="post">
            <div class="form-group">
                <label>Posisi</label>
                <input type="text" name="posisi" class="form-control" required/>
            </div>
            <div class="form-group">
                <label>Perusahaan</label>
                <input type="text" name="nama_pt" class="form-control" id="addPerusahaan" required/>
            </div>
            <div class="form-group">
                <label>Bidang Usaha</label>
                <input type="text" name="bidang_usaha" class="form-control" id="addBidangUsaha" required/>
            </div>
            <div class="form-group">
                <label>Lokasi</label>
                <textarea class="form-control" name="alamat_pt"></textarea>
            </div>
            <div class="form-group">
                <label>Email Perusahaan</label>
                <input type="text" name="email_pt" class="form-control"/>
            </div>
            <label>Lama bekerja</label>

            <div class="row">
                <div class="form-group col-md-6">
                    <label>Dari</label>
                    <select name="bulan_bekerja" class="form-control" id="bln_bekerja">
                        <option>Bulan</option>
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
                        <option>Bulan</option>
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
                    <input type="year" name="tahun_bekerja" class="form-control" id="thn_bekerja" placeholder="Tahun"/>
                </div>
                <div class="form-group col-md-6">
                    <input type="year" name="tahun_selesai" class="form-control" id="thn_selesai" placeholder="Tahun"/>
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

<!-- EDIT MODAL KARIR-->
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
        <input type="submit" class="btn btn-success btn-xs" name="editKarir" value="Update"/>
        </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- EDIT MODAL PROFIL-->
<div class="modal fade modal-success-custom" tabindex="-1" role="dialog" id="modalEditProfil">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Data Profil Alumni</h4>
      </div>

      <div class="modal-body">
        <form method="post">
            <div class="form-group">
                <label>Alamat</label>
                <textarea name="alamat" class="form-control" required id="editProfilAlamat"></textarea>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" id="editProfilEmail" required/>
            </div>
            <div class="form-group">
                <label>No Telepon</label>
                <input type="text" name="no_tlp" class="form-control" id="editProfilTlp" required/>
            </div>
      </div>
            

      <div class="modal-footer">
        <input type="reset" class="btn btn-default btn-xs" data-dismiss="modal" value="Close">
        <input type="submit" class="btn btn-success btn-xs" name="editProfil" value="Update"/>
        </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- EDIT MODAL PICTURE-->
<div class="modal fade modal-success-custom" tabindex="-1" role="dialog" id="modalEditPicture">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Profile Picture</h4>
      </div>

      <div class="modal-body">
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>Upload Picture</label>
                <input type="file" name="pic" class="form-control" required/>
                <p class="help-block">- Disarankan menggunakan gambar dengan ratio 1:1</p>
                <p class="help-block">- Maksimal ukuran file sebesar 1MB dengan tipe file JPG/JPEG dan PNG</p>
            </div>
      </div>
            

      <div class="modal-footer">
        <input type="reset" class="btn btn-default btn-xs" data-dismiss="modal" value="Close">
        <input type="submit" class="btn btn-success btn-xs" name="editPicture" value="Upload"/>
        </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- EDIT MODAL PASSWORD-->
<div class="modal fade modal-success-custom" tabindex="-1" role="dialog" id="modalEditPassword">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Ganti Password</h4>
      </div>

      <div class="modal-body">
        <form method="post">
            <div class="form-group">
                <label>Password Lama</label>
                <input type="password" name="pass" class="form-control" id="editPassLama" onchange="getPassword();" required/>
                <span id="helpBlock" class="help-block"></span>
            </div>
            <div class="form-group">
                <label>Password Baru</label>
                <input type="password" name="newPass" class="form-control" id="editPassBaru" required/>
            </div>
            <div class="form-group">
                <label>Konfirmasi Password Baru</label>
                <input type="password" name="confPass" class="form-control" id="editKonfPass" required/>
                <input type="hidden" name="npm" value="<?=$user['npm']?>"/>
                <span id="helpBlock2" class="help-block"></span>
            </div>
      </div>
            

      <div class="modal-footer">
        <input type="reset" class="btn btn-default btn-xs" data-dismiss="modal" value="Tutup">
        <input type="submit" class="btn btn-success btn-xs" name="submit-pass" value="Ganti Password" id="btnGantiPass"/>
        </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->