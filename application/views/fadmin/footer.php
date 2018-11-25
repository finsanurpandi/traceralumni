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
function getMatkul(){
    var kdprodi = $('#kdprodi').val();
    var matkul = $('#matkul');
    
    matkul
    .find('option')
    .remove()
    .end()

    matkul.append("<option></option>");

        $.ajax({
          method: "post",
          url: "<?=base_url()?>"+"kd_ajax/getMatkul",
          dataType: 'json',
          data: { kdprodi:kdprodi },
          success: function(res){
            for (var i = 0; i < res.length; i++) {
              matkul.append("<option value='"+res[i]['rft_kode_matakuliah']+","+res[i]['rft_nama_matakuliah']+","+res[i]['rft_smtr']+"'>"+res[i]['rft_kode_matakuliah']+" - "+res[i]['rft_nama_matakuliah']+"</option>");
            }
          },
          error: function(error){
            console.log(error);
          }
        });
    };

  $(function () {
    $('.select-add-alumni').select2({
      placeholder: 'Select an option',
      dropdownParent: $('#modalAddAlumni'),
    });

    $('.select-edit-alumni').select2({
      dropdownParent: $('#modalEditAlumni'),
    });

    $('#tbl-data').DataTable({
      'dom' : "<'row'<'col-sm-6'l><'col-sm-6'f>>" +
              "<'row'<'col-sm-12'tr>>" +
              "<'row'<'col-sm-5'i><'col-sm-7'<'pull-right'p>>>",
    });

    

  });

// DETAIL HISTORI ALUMNI
$(document).on('click', '#btnDetailAlumni', function(e){
  e.preventDefault();

  let data = $(this).data();

  $.ajax({
    method: 'post',
    url: baseurl+'ajax/getAlumniPerusahaan',
    async: true,
    dataType: 'json',
    data: {npm:data['npm']},
    success: function (res) {
      var no = 1;
      text = '';
      for (let i = 0; i < res.length; i++) {
        text +=
              "<tr>"+
              "<td>"+ no++ +"</td>"+
              "<td>"+ res[i]['nama_perusahaan'] +"</td>"+
              "<td>"+ res[i]['posisi'] +"</td>"+
              "<td>"+ bekerja(res[i]) +"</td>"+
              "</tr>";
      }
      $('#detail-alumni').html(text);
      $('#text-title').text('Histori Karir '+data['nama']);
      
    }
  });
});

// DETAIL PENGGUNA ALUMNI
$(document).on('click', '#btn-perusahaan-alumni', function(e){
  e.preventDefault();

  let data = $(this).data();
  //console.log(data['kdprodi']);
  $.ajax({
    method: 'post',
    url: baseurl+'ajax/getPerusahaanAlumni',
    async: true,
    dataType: 'json',
    data: {nama:data['pengguna'], kdprodi:data['kdprodi']},
    success: function (res) {

      var no = 1;
      text = '';
      for (let i = 0; i < res.length; i++) {
        text +=
              "<tr>"+
              "<td>"+ no++ +"</td>"+
              "<td>"+ res[i]['nama'] +"</td>"+
              "<td>"+ res[i]['angkatan'] +"</td>"+
              "<td>"+ res[i]['posisi'] +"</td>"+
              "<td>"+ bekerja(res[i]) +"</td>"+
              "</tr>";
      }
      $('#detail-alumni').html(text);
      $('#text-title').text(data['pengguna']);
      
    }
  });
});

function getMonth(data)
{
  var bulan = '';

  switch (data) {
    case "1":
        bulan = "Jan";
      break;
    case "2":
        bulan = "Feb";
      break;
    case "3":
        bulan = "Mar";
      break;
    case "4":
        bulan = "Apr";
      break;
    case "5":
        bulan = "Mei";
      break;
    case "6":
        bulan = "Jun";
      break;
    case "7":
        bulan = "Jul";
      break;
    case "8":
        bulan = "Agu";
      break;
    case "9":
        bulan = "Sep";
      break;
    case "10":
        bulan = "Okt";
      break;
    case "11":
        bulan = "Nov";
      break;
    case "12":
        bulan = "Des";
      break;
  }

  return bulan;
}

function bekerja(res)
{
  blnBekerja = getMonth(res['bulan_bekerja']);
  blnSelesai = getMonth(res['bulan_selesai']);
  thnBekerja = res['tahun_bekerja'];
  thnSelesai = '';

  if (res['tahun_selesai'] == '0000') {
    thnSelesai = "Sekarang";
  } else {
    thnSelesai = res['tahun_selesai'];
  }
  
  return blnBekerja+' '+thnBekerja+' - '+blnSelesai+' '+thnSelesai;
}

</script>
</body>
</html>
