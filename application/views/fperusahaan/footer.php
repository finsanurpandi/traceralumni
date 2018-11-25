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

  $(function () {
    $('.section-belum').hide();
    $('.section-pernah').hide();

    //autocomplete
    let datamhs = [];

    <?php
    foreach ($mhs as $key => $value) {
    ?>
      datamhs.push("<?=$value['nama']?>");
    <?php } ?>

    $('#namaMhs').autocomplete({
      source: datamhs
    })
  });

  $(document).on('click', '#btn-pernah', function(e){
    $('.section-pernah').show();
    $('.initial-section').hide();
  });

  $(document).on('click', '#btn-belum', function(e){
    $('.section-belum').show();
    $('.initial-section').hide();
  });

  $(document).on('click', '#btn-pernah-mengisi', function(e){
    $('.section-pernah').show();
    $('.section-belum').hide();
  });

  $(document).on('click', '#btn-belum-mengisi', function(e){
    $('.section-belum').show();
    $('.section-pernah').hide();
  });

// GET PRODI

function getProdi()
{
    nama = $('#namaMhs').val();
    
    $.ajax({
      method: "post",
      url: baseurl+"ajax/getprodi",
      dataType: 'json',
      data: {nama: nama},
      success: function(res){
        if (res == 0) {
          $('#prodiMhs').val('DATA ALUMNI TIDAK ADA DI DATABASE');
          $('#addAlumni').prop('disabled', true);
        } else {
          if (res[0]['kd_prodi'] == '55201') {
            $('#prodiMhs').val('TEKNIK INFORMATIKA');
          } else if (res[0]['kd_prodi'] == '22201') {
            $('#prodiMhs').val('TEKNIK SIPIL');
          } else if (res[0]['kd_prodi'] == '26201') {
            $('#prodiMhs').val('TEKNIK INDUSTRI');
          } 

          $('#addAlumni').prop('disabled', false);
        }
        
      }
    });
}
</script>
</body>
</html>
