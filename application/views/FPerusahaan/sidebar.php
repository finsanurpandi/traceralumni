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
        <p><?=$company['nama_perusahaan']?></p>
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
      <li id="feedbackWelcome">
        <a href="<?=base_url()?>feedback">
          <i class="fa fa-th"></i> <span>Welcome</span>
        </a>
      </li>
      <li id="feedbackPenilaian">
        <a href="<?=base_url()?>feedback/penilaian">
          <i class="fa fa-th"></i> <span>Penilaian</span>
        </a>
      </li>
      <li id="feedbackHasil">
        <a href="<?=base_url()?>feedback/hasil_penilaian">
          <i class="fa fa-th"></i> <span>Hasil Penilaian</span>
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
        <a href="<?=base_url()?>feedback/logout" class="btn btn-danger btn-xs">Yes, just log me out...</a>
      </div>
    </div>
  </div>
</div>

<script src="<?=base_url()?>assets/bower_components/jquery/dist/jquery.min.js"></script>
<script type="text/javascript">
  var uri = '<?=$this->uri->segment(2)?>';

  function ProdiClearMenu(){
    $('#feedbackWelcome').remove('.active');
    $('#feedbackPenilaian').remove('.active');
    $('#feedbackHasil').remove('.active');
  }

	if (uri == '' || uri == 'welcome') {
            ProdiClearMenu();
            $('#feedbackWelcome').addClass('active');
		} else if (uri == 'penilaian') { 
            $('#feedbackPenilaian').addClass('active');
		} else if (uri == 'hasil_penilaian') { 
            $('#feedbackHasil').addClass('active');
		};
</script>