<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        $this->load->model('m_basic');
        $this->load->helper('download');
		
		date_default_timezone_set("Asia/Bangkok");
    }

    function index()
    {
        
    }

	public function alumni()
	{
        
        if ($this->session->login_in == FALSE) {
            $this->load->view('login_alumni');
        } else {
            redirect('tracerstudy', 'refresh');
        }

        $this->session->unset_userdata('npm');

        $rand = rand(1,5);
        $pic = '';

        switch ($rand) {
            case 1:
                $pic = 'spongebob.jpg';
                break;
            case 2:
                $pic = 'patrick.jpg';
                break;
            case 3:
                $pic = 'sandy.jpg';
                break;
            case 4:
                $pic = 'crabs.jpg';
                break;
            case 5:
                $pic = 'plankton.jpg';
                break;
        }
        
        
        $login = $this->input->post('login');

		if (isset($login)) {

			$user = $this->input->post('npm');
            $pass = $this->input->post('pass');

			// check user
            $count = $this->m_basic->getNumRows('ace_alumni', array('npm' => $user, 'pass' => sha1($pass)));

			//set date
			$date = new DateTime();
			$lastlogin = $date->format('Y-m-d H:i:s');

			//check device
			if ($this->agent->is_browser())
			{
				$agent = $this->agent->platform(). ', ' .$this->agent->browser().' '.$this->agent->version();
			}
			elseif ($this->agent->is_robot())
			{
			    $agent = $this->agent->robot();
			}
			elseif ($this->agent->is_mobile())
			{
		        $agent = $this->agent->platform(). ', ' .$this->agent->mobile();
			}
			else
			{
			    $agent = 'Unidentified User Agent';
			}

			// if username and password TRUE
			if ($count == 1) {
            $getUser = $this->m_basic->getAllData('ace_alumni', array('npm' => $user))->result_array();

            $total = (int)$getUser[0]['count'] + 1;

            $user_account = array (
              'login_in' => TRUE,
              'npm' => $user,
              'pic' => $pic,
              'role' => '1'
            );

            $data = array(
              'last_login' => $lastlogin,
              'device' => $agent,
              'count' => $total
            );

            $this->session->set_userdata($user_account);
            $this->m_basic->updateData('ace_alumni', $data, array('npm' => $user));

            redirect('tracerstudy', 'refresh');
				
			} else {

				$this->session->set_flashdata('error', true);
				redirect('login/alumni','refresh');

			}
		}
    }

    public function prodi()
	{
        
        if ($this->session->login_in == FALSE) {
            $this->load->view('login_prodi');
        } else {
            redirect('prodi', 'refresh');
        }

        $rand = rand(1,5);
        $pic = '';

        switch ($rand) {
            case 1:
                $pic = 'spongebob.jpg';
                break;
            case 2:
                $pic = 'patrick.jpg';
                break;
            case 3:
                $pic = 'sandy.jpg';
                break;
            case 4:
                $pic = 'crabs.jpg';
                break;
            case 5:
                $pic = 'plankton.jpg';
                break;
        }
        
        
        $login = $this->input->post('login');

		if (isset($login)) {
			$user = $this->input->post('user');
			$pass = $this->input->post('pass');

			// check user
            $count = $this->m_basic->getNumRows('ace_login', array('username' => $user, 'password' => sha1($pass)));
            $userlogin = $this->m_basic->getAllData('ace_login', array('username' => $user))->result_array();

			//set date
			$date = new DateTime();
			$lastlogin = $date->format('Y-m-d H:i:s');

			//check device
			if ($this->agent->is_browser())
			{
				$agent = $this->agent->platform(). ', ' .$this->agent->browser().' '.$this->agent->version();
			}
			elseif ($this->agent->is_robot())
			{
			    $agent = $this->agent->robot();
			}
			elseif ($this->agent->is_mobile())
			{
		        $agent = $this->agent->platform(). ', ' .$this->agent->mobile();
			}
			else
			{
			    $agent = 'Unidentified User Agent';
			}

			if ($count == 1) {

            $user_account = array (
              'login_in' => TRUE,
              'user' => $user,
              'pic' => $pic,
              'kdprodi' => $userlogin[0]['kd_prodi'],
              'role' => '0'
            );

            $data = array(
              'last_login' => $lastlogin,
              'device' => $agent
            );

            $this->session->set_userdata($user_account);
            $this->m_basic->updateData('ace_login', $data, array('username' => $user));

            redirect('admin', 'refresh');
            //print_r($this->session->userdata());
				
			} else {

				$this->session->set_flashdata('error', true);
				redirect('login/prodi','refresh');

			}
		}
    }
    
    function logout($user)
    {
        $this->session->sess_destroy();

        if ($user == 'alumni') {
            redirect('login/alumni', 'refresh');
        } elseif ($user == 'prodi') {
            redirect('login/prodi', 'refresh');
        }
		
    }

    function download($file)
    {
        $file = $this->encrypt->decode($file);
        force_download($file, 'Manual Book Tracer Alumni');
    }
}
