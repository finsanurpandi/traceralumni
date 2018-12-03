<?php
  function getProdi($kdprodi)
  {
    if ($kdprodi == '22201') {
      echo "TEKNIK SIPIL";
    } elseif ($kdprodi == '26201') {
      echo "TEKNIK INDUSTRI";
    } elseif ($kdprodi == '55201') {
      echo "TEKNIK INFORMATIKA";
    }
  }
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- ICON -->
  <link rel="icon" href="<?=base_url()?>assets/img/ico_ft.png" type="image/x-icon" />
  <title>Alumni Registration Form</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?=base_url()?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=base_url()?>assets/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?=base_url()?>assets/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?=base_url()?>assets/css/AdminLTE.min.css">
  

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
<style>
    .register-box {
        width: 900px;
    }
</style>
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <a href="../../index2.html"><b>Pendaftaran</b>Alumni</a>
  </div>

  <div class="register-box-body">

    <form method="post">
    <div class="row"> <!-- ROW -->
    <div class="col-md-6 col-xs-12"> <!-- COL -->
      <div class="form-group has-feedback">
        <label>NPM</label>
        <input type="number" name="npm" class="form-control" value="<?=$alumni[0]['npm']?>" readonly>
      </div>
      <div class="form-group has-feedback">
        <label>Nama Lengkap</label>
        <input type="text" name="nama" class="form-control" value="<?=$alumni[0]['nama']?>" readonly>
      </div>
      <div class="form-group has-feedback">
        <label>Set Password</label>
        <input type="password" name="pass" id="pass" class="form-control" placeholder="******" required>
      </div>
      <div class="form-group has-feedback">
        <label>Konfirmasi Password</label>
        <input type="password" name="c_pass" id="c_pass" class="form-control" placeholder="******" onkeyup="check_pass();" required>
        <div id="status-pass"></div>
      </div>
      <div class="form-group has-feedback">
        <label>Alamat Tempat Tinggal</label>
        <textarea name="alamat" class="form-control" rows="3" placeholder="Jl. Inajadulu No.3" required></textarea>
      </div>
    </div> <!-- END of COL -->
    <div class="col-md-6 col-xs-12"> <!-- COL -->
      <div class="form-group has-feedback">
        <label>Program Studi</label>
        <input type="text" name="kdprodi" class="form-control" value="<?php getProdi($alumni[0]['kd_prodi'])?>" readonly>
      </div>
      <div class="form-group has-feedback">
        <label>Email</label>
        <input type="email" name="email" class="form-control" placeholder="Alamat email aktif" required>
      </div>
      <div class="form-group has-feedback">
        <label>No Telepon</label>
        <input type="number" name="no_tlp" class="form-control" placeholder="No Telepon yang bisa dihubungi" required>
      </div>
      <!-- <div class="row">
        <div class="col-xs-12 col-md-6">
            <label>Bulan Lulus</label>
            <select name="bln_lulus" class="form-control" required>
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
        </div> -->
        <!-- /.col -->
        <!-- <div class="col-xs-12 col-md-6">
            <label>Tahun</label>
            <input type="year" name="thn_lulus" class="form-control" placeholder="20XX" required>
        </div> -->
        <!-- /.col -->
      <!-- </div> -->
      <!-- <br/> -->
      <div class="form-group">
        <label>Status Sekarang?</label>
        <select class="form-control" name="kd_status">
            <option></option>
            <?php
                foreach ($status as $key => $value) {
                    echo "<option value=".$value['kd_status'].">".$value['keterangan']."</option>";
                }
            ?>
        </select>
                
            </div>
      <br/>
      <div class="row">
        <div class="col-xs-8">
          
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <input type="submit" class="btn btn-primary btn-block btn-flat" disabled="true" id="btn-add-mhs" value="Registrasi" name="addAlumni">
        </div>
        <!-- /.col -->
      </div>
    </form>
    

    <a href="<?=base_url()?>login/alumni" class="text-center"><small>sudah mendaftar?</small></a>
  </div>
  </div> <!-- END of COL -->
                </div>
  <!-- /.form-box -->
</div>
<!-- /.register-box -->

<!-- jQuery 2.2.3 -->
<script src="<?=base_url()?>assets/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Custom javacript -->
<!-- Bootstrap 3.3.6 -->
<script src="<?=base_url()?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->

<script>
  $(function () {
    
  });

function check_npm1()
{
    var npm = $('#npm').val();
    var baseurl = "<?=base_url()?>";

    $.ajax({
        method: "post",
        url: baseurl+"ajax/checkNpm",
        data: {npm: npm},
        success: function(res){
            if (res == 1 || npm == "") {
                $('#status-npm').html("<p class='text-danger'><i class='fa fa-remove'></i> NPM sudah digunakan!!!</p>");
                $('#btn-add-mhs').prop('disabled', true);
            } else {
                $('#status-npm').html("<p class='text-success'><i class='fa fa-check'></i> NPM tersedia!!!</p>");
                $('#btn-add-mhs').prop('disabled', false);
            }
        }
    })
}

function check_pass()
{
    let pass = $('#pass').val();
    let cpass = $('#c_pass').val();

    if (pass !== cpass) {
        $('#status-pass').html("<p class='text-danger'><i class='fa fa-remove'></i> Password tidak sama</p>");
        $('#btn-add-mhs').prop('disabled', true);
    } else {
        $('#status-pass').html("");
        $('#btn-add-mhs').prop('disabled', false);
    }
}

</script>
</body>
</html>
