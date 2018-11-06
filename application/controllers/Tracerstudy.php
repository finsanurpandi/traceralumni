<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tracerstudy extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_feedback');
        $this->load->library('upload');	

        date_default_timezone_set("Asia/Bangkok");

        //$this->check_login();
    }

    function load_view($url, $data = null)
    {
        $this->load->view('falumni/head');
        $this->load->view('falumni/header');
        

        if ($data !== null) {
            $this->load->view('falumni/sidebar', $data);
            $this->load->view($url, $data);
        } else {
            $this->load->view('falumni/sidebar');
            $this->load->view($url);
        }
        
        $this->load->view('falumni/footer');
    }

    function check_login()
    {
        if (($this->session->login_in !== TRUE) && ($this->session->role !== 1)) {
            redirect('login/alumni', 'refresh');
        }
    }

    public function index()
    {
        $this->check_login();

        $user = $this->m_feedback->getAllData('ace_alumni', array('npm' => $this->session->npm))->result_array();
        $data['user'] = $user[0];

        $this->load_view('falumni/dashboard', $data);
    }

    function register()
    {
        $status = $this->m_feedback->getAllData('ace_status')->result_array();
        $data['status'] = $status;

        $this->load->view('FAlumni/register', $data);

        $add = $this->input->post('addAlumni');
        if (isset($add)) {
            // SET PIC
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
            // END OF SET PIC

            //$kdprodi = substr($this->input->post('npm'),0,5);

            $thn_akademik = '';
            if (($this->input->post('bln_lulus') >= '9') || ($this->input->post('bln_lulus') <= '1')) {
                $thn_akademik = $this->input->post('thn_lulus').'/'.((int)$this->input->post('thn_lulus')+1);
            } elseif (($this->input->post('bln_lulus') >= '2') && ($this->input->post('bln_lulus') <= '8')) {
                $thn_akademik = ((int)$this->input->post('thn_lulus')-1).'/'.$this->input->post('thn_lulus');
            }

            $data = array(
                'npm' => $this->input->post('npm'),
                'pass' => sha1($this->input->post('pass')),
                'kd_prodi' => $this->input->post('kdprodi'),
                'nama' => $this->input->post('nama'),
                'alamat' => $this->input->post('alamat'),
                'email' => $this->input->post('email'),
                'no_tlp' => $this->input->post('no_tlp'),
                'bln_lulus' => $this->input->post('bln_lulus'),
                'thn_lulus' => $this->input->post('thn_lulus'),
                'tahun_akademik' => $thn_akademik,
                'status' => $this->input->post('kd_status'),
                'img' => $pic
            );

            $this->m_feedback->insertData('ace_alumni', $data);

            redirect("login/alumni", "refresh");
        }
    }

    // function profil()
    // {
    //     $user = $this->m_feedback->getAllData('ace_alumni', array('npm' => $this->session->npm))->result_array();
    //     $karir = $this->m_feedback->getAllData('ace_detail_alumni', array('npm' => $user[0]['npm']), array('tahun_bekerja' => 'DESC'))->result_array();
    //     $data['karir'] = $karir;
    //     $data['user'] = $user[0];

    //     $this->load_view('falumni/profil', $data);
    // }

    function profil()
    {
        $this->check_login();
        
        $user = $this->m_feedback->getAllData('ace_alumni', array('npm' => $this->session->npm))->result_array();
        $data['user'] = $user[0];

        $perusahaan = $this->m_feedback->getAllData('ace_detail_alumni')->result_array();
        $status = $this->m_feedback->getAllData('ace_status')->result_array();
        // $karir = $this->m_feedback->getDetailKarir($user[0]['npm']);
        $karir = $this->m_feedback->getAllData('ace_detail_alumni', array('npm' => $user[0]['npm']), array('tahun_bekerja' => 'DESC'))->result_array();
        $data['status'] = $status;
        $data['karir'] = $karir;
        $data['perusahaan'] = $perusahaan;

        $this->load_view('falumni/profil', $data);

        // Add Karir
        $add = $this->input->post('addKarir');

        if (isset($add)) {
            //print_r($this->input->post());

            $data = array(
                'npm' => $user[0]['npm'],
                'nama_perusahaan' => $this->input->post('nama_pt'),
                'bidang_usaha' => $this->input->post('bidang_usaha'),
                'lokasi' => $this->input->post('alamat_pt'),
                'email' => $this->input->post('email_pt'),
                'posisi' => $this->input->post('posisi'),
                'bulan_bekerja' => $this->input->post('bulan_bekerja'),
                'tahun_bekerja' => $this->input->post('tahun_bekerja')
            );

            if ($this->input->post('still_works') == '1') {
                $data['bulan_selesai'] = '00';
                $data['tahun_selesai'] = '0000';
            } else {
                $data['bulan_selesai'] = $this->input->post('bulan_selesai');
                $data['tahun_selesai'] = $this->input->post('tahun_selesai');
            }

            if ($this->input->post('kesesuaian') == '1') {
                $data['kesesuaian'] = '1';
            } else {
                $data['kesesuaian'] = '0';
            }

            $this->m_feedback->insertData('ace_detail_alumni', $data);
            redirect($this->uri->uri_string());
        }

        // Edit Karir
        $edit = $this->input->post('editKarir');

        if (isset($edit)) {
            //print_r($this->input->post());

            $data = array(
                'nama_perusahaan' => $this->input->post('nama_pt'),
                'bidang_usaha' => $this->input->post('bidang_usaha'),
                'lokasi' => $this->input->post('alamat_pt'),
                'email' => $this->input->post('email_pt'),
                'posisi' => $this->input->post('posisi'),
                'bulan_bekerja' => $this->input->post('bulan_bekerja'),
                'tahun_bekerja' => $this->input->post('tahun_bekerja')
            );

            if ($this->input->post('still_works') == '1') {
                $data['bulan_selesai'] = '00';
                $data['tahun_selesai'] = '0000';
            } else {
                $data['bulan_selesai'] = $this->input->post('bulan_selesai');
                $data['tahun_selesai'] = $this->input->post('tahun_selesai');
            }

            if ($this->input->post('kesesuaian') == '1') {
                $data['kesesuaian'] = '1';
            } else {
                $data['kesesuaian'] = '0';
            }

            $where = array('id_karir' => $this->input->post('id_karir'));

            $this->m_feedback->updateData('ace_detail_alumni', $data, $where);
            redirect($this->uri->uri_string());
        }

        // Edit Profil
        $editProfil = $this->input->post('editProfil');

        if (isset($editProfil)) {

            $data = array(
                'alamat' => $this->input->post('alamat'),
                'email' => $this->input->post('email'),
                'no_tlp' => $this->input->post('no_tlp')
            );

            $where = array('npm' => $this->session->npm);

            $this->m_feedback->updateData('ace_alumni', $data, $where);
            redirect($this->uri->uri_string());
        }

        // Edit Picture
        $editPicture = $this->input->post('editPicture');

        if (isset($editPicture)) {
            
            $npm = $this->session->npm;
            $nmfile = "img_".$npm."_".time();
            $config['upload_path']   =   "./assets/img/profiles/";
            $config['allowed_types'] =   "jpg|jpeg|png"; 
            $config['max_size']      =   "1000";
            $config['max_width']     =   "1907";
            $config['max_height']    =   "1280";
            $config['file_name']     =   $nmfile;
    
            $this->upload->initialize($config);

            if ($this->upload->do_upload('pic')) {
			// 	$this->m_feedback->updateData('ace_alumni', $data, array('npm' => $this->session->username));

			// 	$this->session->set_flashdata('profilsuccess', true);

			// 	redirect($this->uri->uri_string()."?tab=profile");
			// } else {

                $fileinfo = $this->upload->data();
                
                if ($user[0]['img'] !== 'spongebob.jpg' || $user[0]['img'] !== 'patrick.jpg' || $user[0]['img'] !== 'sandy.jpg' || $user[0]['img'] !== 'crabs.jpg' || $user[0]['img'] !== 'plankton.jpg') {
                    unlink("./assets/img/profiles/". $user[0]['img']);
                }

                $data = array('img' => $fileinfo['file_name']);

				$this->m_feedback->updateData('ace_alumni', $data, array('npm' => $this->session->npm));

				redirect($this->uri->uri_string());
			}

        }

    }


}