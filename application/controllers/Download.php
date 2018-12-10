<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Download extends CI_Controller {
	
	function __construct()
    {
        parent::__construct();
        $this->load->helper('download');
    }

    function file($file)
    {
        $file = $this->encrypt->decode($file);

        force_download(FCPATH.'/assets/files/'.$file, null);
    }
}
