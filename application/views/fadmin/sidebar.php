<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="<?=base_url()?>assets/img/user2-160x160.jpg" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p>Prodi <?=ucwords($user['username'])?></p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>
    <!-- search form -->
    <!-- <form action="#" method="get" class="sidebar-form">
      <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="Search...">
        <span class="input-group-btn">
              <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
              </button>
            </span>
      </div>
    </form> -->
    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">MAIN NAVIGATION</li>
      <li id="prodiDash">
        <a href="<?=base_url()?>admin">
          <i class="fa fa-th"></i> <span>Dashboard</span>
        </a>
      </li>
      <li id="prodiMaster" class="treeview">
          <a href="#">
            <i class="fa fa-table"></i> <span>Master Data</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li id="prodiAlumni"><a href="<?=base_url()?>admin/alumni"><i class="fa fa-circle-o"></i> Data Alumni</a></li>
            <li id="prodiJmlAlumni"><a href="<?=base_url()?>admin/jmlalumni"><i class="fa fa-circle-o"></i> Jumlah Alumni</a></li>
            <li id="prodiPerusahaan"><a href="<?=base_url()?>admin/perusahaan"><i class="fa fa-circle-o"></i> Pengguna Lulusan</a></li>
            <li id="prodiUraian"><a href="<?=base_url()?>admin/uraian"><i class="fa fa-circle-o"></i> Uraian Penilaian</a></li>
          </ul>
        </li>
        <li id="prodiRekapData" class="treeview">
          <a href="#">
            <i class="fa fa-table"></i> <span>Rekap Data</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li id="prodiRekapAlumni"><a href="<?=base_url()?>admin/rekap_alumni"><i class="fa fa-circle-o"></i> Alumni</a></li>
            <li id="prodiRekapPerusahaan"><a href="<?=base_url()?>admin/rekap_perusahaan"><i class="fa fa-circle-o"></i> Pengguna Lulusan</a></li>
          </ul>
        </li>
        <li id="prodiHasilPenilaian" class="treeview">
          <a href="#">
            <i class="fa fa-table"></i> <span>Hasil Penilaian</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li id="prodiPenilaianAlumni"><a href="<?=base_url()?>admin/penilaian_alumni"><i class="fa fa-circle-o"></i> Alumni</a></li>
            <li id="prodiPenilaianPerusahaan"><a href="<?=base_url()?>admin/penilaian_perusahaan"><i class="fa fa-circle-o"></i> Pengguna Lulusan</a></li>
          </ul>
        </li>
        <li id="prodiKinerja">
        <a href="<?=base_url()?>feedbackadmin/cetak">
          <i class="fa fa-th"></i> <span>Cetak Laporan</span>
        </a>
      </li>
      </li>
        <li id="prodiUbahPass">
        <a href="<?=base_url()?>admin/ubah_password">
          <i class="fa fa-th"></i> <span>Ubah Password</span>
        </a>
      </li>
      <li>
        <a href="#" data-toggle="modal" data-target="#logoutModal">
          <i class="fa fa-th"></i> <span>Logout</span>
        </a>
      </li>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>

<!-- Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Logout</h4>
      </div>
      <div class="modal-body">
        Apakah anda yakin akan keluar dari halaman ini?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success btn-xs" data-dismiss="modal">Nope</button>
        <a href="<?=base_url()?>login/logout/prodi" class="btn btn-danger btn-xs">Yes, just log me out...</a>
      </div>
    </div>
  </div>
</div>

<script src="<?=base_url()?>assets/bower_components/jquery/dist/jquery.min.js"></script>
<script type="text/javascript">
  var uri = '<?=$this->uri->segment(2)?>';

	if (uri == '') {
            $('#prodiDash').addClass('active');
		} else if (uri == 'alumni') { 
            $('#prodiMaster').addClass('active');
            $('#prodiAlumni').addClass('active');
		} else if (uri == 'jmlalumni') { 
            $('#prodiMaster').addClass('active');
            $('#prodiJmlAlumni').addClass('active');
		} else if (uri == 'perusahaan') {
            $('#prodiMaster').addClass('active');
            $('#prodiPerusahaan').addClass('active');
		} else if (uri == 'uraian') {
            $('#prodiMaster').addClass('active');
            $('#prodiUraian').addClass('active');
		} else if (uri == 'penilaian_alumni') {
            $('#prodiHasilPenilaian').addClass('active');
            $('#prodiPenilaianAlumni').addClass('active');
    } else if (uri == 'penilaian_perusahaan') {
            $('#prodiHasilPenilaian').addClass('active');
            $('#prodiPenilaianPerusahaan').addClass('active');
    } else if (uri == 'rekap_alumni') {
            $('#prodiRekapData').addClass('active');
            $('#prodiRekapAlumni').addClass('active');
    } else if (uri == 'rekap_perusahaan') {
            $('#prodiRekapData').addClass('active');
            $('#prodiRekapPerusahaan').addClass('active');
    }
</script>