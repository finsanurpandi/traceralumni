<footer class="main-footer">
  <div class="pull-right hidden-xs">
    <b>Version</b> 1.0.0
  </div>
  <strong>Copyright &copy; 2018 <a href="https://ft.unsur.ac.id">Fakultas Teknik</a>.</strong> All rights
  reserved.
</footer>


<div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="<?=base_url()?>assets/bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI -->
<script src="<?=base_url()?>assets/bower_components/jquery-ui/usethis/jquery-ui.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?=base_url()?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="<?=base_url()?>assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?=base_url()?>assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- Select2 -->
<script src="<?=base_url()?>assets/bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- InputMask -->
<script src="<?=base_url()?>assets/plugins/input-mask/jquery.inputmask.js"></script>
<script src="<?=base_url()?>assets/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="<?=base_url()?>assets/plugins/input-mask/jquery.inputmask.extensions.js"></script>
<!-- date-range-picker -->
<script src="<?=base_url()?>assets/bower_components/moment/min/moment.min.js"></script>
<script src="<?=base_url()?>assets/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- bootstrap datepicker -->
<script src="<?=base_url()?>assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- bootstrap color picker -->
<script src="<?=base_url()?>assets/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
<!-- bootstrap time picker -->
<script src="<?=base_url()?>assets/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<!-- SlimScroll -->
<script src="<?=base_url()?>assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- iCheck 1.0.1 -->
<script src="<?=base_url()?>assets/plugins/iCheck/icheck.min.js"></script>
<!-- FastClick -->
<script src="<?=base_url()?>assets/bower_components/fastclick/lib/fastclick.js"></script>
<!-- ChartJS -->
<script src="<?=base_url()?>assets/bower_components/chart.js/Chart.js"></script>
<!-- AdminLTE App -->
<script src="<?=base_url()?>assets/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?=base_url()?>assets/js/demo.js"></script>
<!-- Page script -->
<script src="<?=base_url()?>assets/js/custom-feedback.js"></script>
<!-- Page script -->

<script>
baseurl = "<?=base_url()?>";

let uri = '<?=$this->uri->segment(2)?>';

$(function(){
  var perusahaan = [];
  var bidangusaha = [];

  <?php
  foreach ($perusahaan as $key => $value) {
  ?>
      perusahaan.push("<?=$value['nama_perusahaan']?>");
      bidangusaha.push("<?=$value['bidang_usaha']?>");
  <?php } ?>

  $('#addPerusahaan').autocomplete({
    source: perusahaan
  });

  $('#addBidangUsaha').autocomplete({
    source: bidangusaha,
    appendTo: '#modalAddKarir'
  });

  //$( "#addPerusahaan" ).autocomplete( "option", "appendTo", ".eventInsForm" );
});

function AlumniClearMenu(){
  $('#dashboard').remove('.active');
  $('#profil').remove('.active');
  $('#karir').remove('.active');
}

if (uri == '') {
          AlumniClearMenu();
          $('#dashboard').addClass('active');
  } else if (uri == 'profil') { 
          $('#informasi').addClass('active');
          $('#profil').addClass('active');
  } else if (uri == 'karir') { 
          $('#informasi').addClass('active');
          $('#karir').addClass('active');
  };

$('#tbl-data').DataTable({
      'dom' : "<'row'<'col-sm-6'l><'col-sm-6'f>>" +
              "<'row'<'col-sm-12'tr>>" +
              "<'row'<'col-sm-5'i><'col-sm-7'<'pull-right'p>>>",
    });

// CLEAR ALL INPUT MODAL
$('#modalEditKarir').on('hidden.bs.modal', function (e) {
  $(this)
    .find("input[type=text],input[type=password],input[type=number],input[type=year],textarea,select")
       .val('')
       .end()
    .find("input[type=checkbox], input[type=radio]")
       .prop("checked", "")
       .end();
})

// EDIT ALUMNI KARIR
$(document).on('click', '#btn-edit-karir', function(e){

  let id = $(this).data('id');
      
  $.ajax({
        method: "post",
        url: baseurl+"ajax/getKarir",
        data: {id: id},
        success: function(res){
          let data = JSON.parse(res);

          $('#editKarirPosisi').val(data[0]['posisi']);
          $('#editKarirPerusahaan').val(data[0]['nama_perusahaan']);
          $('#editKarirUsaha').val(data[0]['bidang_usaha']);
          $('#editKarirLokasi').val(data[0]['lokasi']);
          $('#editKarirEmail').val(data[0]['email']);
          $('#idKarir').val(id);

          $('#editThnBekerja').val(data[0]['tahun_bekerja']);

          // get selected bulan bekerja
          $('#editBulanBekerja option').filter(function(){
            return ($(this).val() == data[0]['bulan_bekerja']);
          }).prop('selected', true);

          // check checkbox masih bekerja atau tidak
          if (data[0]['tahun_selesai'] == '0000') {
            $('#editStillWorks').prop('checked', true);
            $('#editBulanSelesai').prop('disabled', true);
            $('#editThnSelesai').prop('disabled', true);
          } else {
            $('#editBulanSelesai option').filter(function(){
              return ($(this).val() == data[0]['bulan_bekerja']);
            }).prop('selected', true);

            $('#editBulanSelesai').prop('disabled', false);
            $('#editThnSelesai').prop('disabled', false);
            $('#editThnSelesai').val(data[0]['tahun_selesai']);
          }
          
          // check checkbox kesesuaian
          if (data[0]['kesesuaian'] == '1') {
            $('#editKesesuaian').prop('checked', true);
          } else {
            $('#editKesesuaian').prop('checked', false);
          }
        }
    });
});

// EDIT ALUMNI PROFIL
$(document).on('click', '#btn-edit-karir', function(e){

let npm = $(this).data('npm');
    
$.ajax({
      method: "post",
      url: baseurl+"ajax/getAlumni",
      data: {npm:npm},
      success: function(res){
        let data = JSON.parse(res);

        $('#editProfilAlamat').val(data[0]['alamat']);
        $('#editProfilEmail').val(data[0]['email']);
        $('#editProfilTlp').val(data[0]['no_tlp']);
      }
  });
});

$('#editStillWorks').click(function(e){

if ($('#editStillWorks').is(':checked')) {
    $('#editBulanSelesai').prop('disabled', true);
    $('#editThnSelesai').prop('disabled', true);
} else {
    $('#editBulanSelesai').prop('disabled', false);
    $('#editThnSelesai').prop('disabled', false);
}
});

</script>
</body>
</html>
