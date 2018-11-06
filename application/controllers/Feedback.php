<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Feedback extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_tracer');

        date_default_timezone_set("Asia/Bangkok");
    }

    function load_view($url, $data = null)
    {
        $this->load->view('fperusahaan/head');
        $this->load->view('fperusahaan/header');
        

        if ($data !== null) {
            $this->load->view('fperusahaan/sidebar', $data);
            $this->load->view($url, $data);
        } else {
            $this->load->view('fperusahaan/sidebar');
            $this->load->view($url);
        }
        
        $this->load->view('fperusahaan/footer');
    }

    function check_login()
    {
        if (($this->session->login_in !== TRUE) && ($this->session->role !== '3')) {
            redirect('feedback', 'refresh');
        }
    }

    function index()
    {
        $this->login();
    }

    function login()
    {
        if ($this->session->login_in == FALSE) {
            $this->load->view('fperusahaan/login');
        } else {
            redirect('feedback/welcome', 'refresh');
        }
        
        $login = $this->input->post('submit');

		if (isset($login)) {
			$user = $this->input->post('username');
			$pass = $this->input->post('password');

			// check user
            $count = $this->m_feedback->getNumRows('ace_perusahaan', array('kd_perusahaan' => $user, 'pass' => sha1($pass)));
            $userlogin = $this->m_feedback->getAllData('ace_perusahaan', array('kd_perusahaan' => $user))->result_array();

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
              'role' => '3'
            );

            $data = array(
              'last_login' => $lastlogin,
              'device' => $agent
            );

            $this->session->set_userdata($user_account);
            $this->m_feedback->updateData('ace_perusahaan', $data, array('kd_perusahaan' => $user));

            redirect('feedback/welcome', 'refresh');
				
			} else {

				$this->session->set_flashdata('error', true);
				redirect('feedback','refresh');

			}
		}

        // $this->load->view('fperusahaan/login');
    }

    function welcome()
    {
        $this->check_login();

        $company = $this->m_feedback->getAllData('ace_perusahaan', array('kd_perusahaan' => $this->session->user))->result_array();

        $data['company'] = $company[0];
        $this->load_view('fperusahaan/welcome', $data);
        //print($this->session->user);
    }

    function penilaian($fase = null)
    {
        $this->check_login();

        $fase = $this->encrypt->decode($fase);
        $company = $this->m_feedback->getAllData('ace_perusahaan', array('kd_perusahaan' => $this->session->user))->result_array();
        $uraian = $this->m_feedback->getAllData('ace_aspek_penilaian', null, array('kd_aspek' => 'ASC'))->result_array();

        $data['company'] = $company[0];
        $data['uraian'] = $uraian;

        if ($fase == null) { // mengisi nik pegawai
            $sessionpegawai = $this->session->penilai;
            @$alumni = $this->m_feedback->getAllData('ace_alumni_penilaian', array('kd_alumni' => $this->session->alumni, 'nik' => $this->session->penilai))->result_array();
            $sessionalumni = $this->session->alumni;
            
            if (isset($sessionalumni) && $alumni[0]['status'] == '0') {
                $url = "feedback/penilaian/".$this->encrypt->encode('2');
                redirect($url, 'refresh');
            } elseif (isset($sessionpegawai)) {
                $url = "feedback/penilaian/".$this->encrypt->encode('1');
                redirect($url, 'refresh');
            } else {
                $this->load_view('fperusahaan/penilaian', $data);    
            }
        } elseif ($fase == '1') { // mengisi data mahasiswa
            @$alumni = $this->m_feedback->getAllData('ace_alumni_penilaian', array('kd_alumni' => $this->session->alumni, 'nik' => $this->session->penilai))->result_array();
            $sessionalumni = $this->session->alumni;

            if (isset($sessionalumni) && $alumni[0]['status'] == '0') {
                $url = "feedback/penilaian/".$this->encrypt->encode('2');
                redirect($url, 'refresh');
            } else {
                $penilai = $this->m_feedback->getAllData('ace_pegawai', array('nik' => $this->session->penilai))->result_array();
                $data['penilai'] = $penilai[0];
                $this->load_view('fperusahaan/penilaian_1', $data);
            }
            
        } elseif ($fase == '2') { // mengisi penilaian
            $alumni = $this->m_feedback->getAllData('ace_alumni_penilaian', array('kd_alumni' => $this->session->alumni))->result_array();
            $data['alumni'] = $alumni[0];
            $this->load_view('fperusahaan/penilaian_2', $data);
        } elseif ($fase == '3') { // hasil akhir penilaian
            $alumni = $this->m_feedback->getAllData('ace_alumni_penilaian', array('kd_alumni' => $this->session->alumni))->result_array();
            $data['alumni'] = $alumni[0];
            $this->load_view('fperusahaan/penilaian_3', $data);
        }

        // submit penilai
        $addPenilai = $this->input->post('submit_penilai');
        if (isset($addPenilai)) {
            $data = array(
                'nama' => $this->input->post('nama'),
                'nik' => $this->input->post('nik'),
                'posisi' => $this->input->post('posisi'),
            );

            $this->m_feedback->insertData('ace_pegawai', $data);
            $this->session->set_userdata('penilai', $this->input->post('nik')); // set session penilai

            $url = "feedback/penilaian/".$this->encrypt->encode('1');
            redirect($url, 'refresh');
        }

        // submit nik
        $setNik = $this->input->post('submit_nik');
        if (isset($setNik)) {
            $this->session->set_userdata('penilai', $this->input->post('nik')); // set session penilai

            $url = "feedback/penilaian/".$this->encrypt->encode('1');
            redirect($url, 'refresh');
        }

        // submit alumni
        $addAlumni = $this->input->post('add-alumni');
        if (isset($addAlumni)) {
            $data = array(
                'kd_perusahaan' => $company[0]['kd_perusahaan'],
                'kd_prodi' => $this->input->post('kd_prodi'),
                'nik' => $this->session->penilai,
                'nama' => $this->input->post('nama'),
                'posisi' => $this->input->post('posisi'),
                'bulan' => $this->input->post('bulan'),
                'tahun' => $this->input->post('tahun')
            );

            $this->m_feedback->insertData('ace_alumni_penilaian', $data);
            $last_record = $this->m_feedback->getAllData('ace_alumni_penilaian', array('kd_perusahaan' => $company[0]['kd_perusahaan'], 'nik' => $this->session->penilai), array('kd_alumni' => 'DESC'))->result_array();

            $this->session->set_userdata('alumni', $last_record[0]['kd_alumni']);
            $this->session->set_userdata('kd_prodi', $last_record[0]['kd_prodi']);

            $url = "feedback/penilaian/".$this->encrypt->encode('2');
            redirect($url, 'refresh');
        }

        // submit penilaian
        $addPenilaian = $this->input->post('sbmtPenilaian');
        if (isset($addPenilaian)) {
            for ($i=0; $i < count($this->input->post('nilai')); $i++) { 
                $penilaian[$i] = array(
                    'kd_perusahaan' => $company[0]['kd_perusahaan'],
                    'nik' => $this->session->penilai,
                    'kd_alumni' => $this->session->alumni,
                    'kd_prodi' => $this->input->post('kd_prodi'),
                    'kd_aspek' => $this->input->post('kd_aspek')[$i],
                    'nilai' => $this->input->post('nilai')[$i]
                );
            }

            $dataupdate = array(
                'status' => '1'
            );

            $this->m_feedback->insertAllData('ace_penilaian', $penilaian);
            $this->m_feedback->updateData('ace_alumni_penilaian', $dataupdate, array('kd_alumni' => $this->session->alumni));

            $url = "feedback/penilaian/".$this->encrypt->encode('3');
            redirect($url, 'refresh');
        }
        
    }

    function hasil_penilaian()
    {
        $this->check_login();

        // submit nik
        $setNik = $this->input->post('submit_nik');
        if (isset($setNik)) {
            $this->session->set_userdata('penilai', $this->input->post('nik')); // set session penilai

            redirect($this->uri->uri_string());
        }

        $company = $this->m_feedback->getAllData('ace_perusahaan', array('kd_perusahaan' => $this->session->user))->result_array();
        $penilai = $this->m_feedback->getAllData('ace_pegawai', array('nik' => $this->session->penilai))->result_array();
        $alumni = $this->m_feedback->getAllData('ace_alumni_penilaian', array('nik' => $this->session->penilai))->result_array();
        
        $data['penilai'] = @$penilai[0];
        $data['company'] = $company[0];
        $data['alumni'] = @$alumni;
        $this->load_view('fperusahaan/hasil_penilaian', $data);
    }

    function query()
    {
        $company = $this->m_feedback->getAllData('ace_perusahaan', array('kd_perusahaan' => $this->session->user))->result_array();
        $hasil = $this->m_feedback->getAllData('ace_penilaian', array('kd_prodi' => '55201'))->result_array();
        $aspek = $this->m_feedback->getAllData('ace_aspek_penilaian')->result_array();
        $datahasil = array();

        for ($i=0; $i < count($aspek); $i++) { 
            foreach ($hasil as $key => $value) {
                if ($value['kd_aspek'] == $aspek[$i]['kd_aspek']) {
                    @$datahasil[$i]['kd_aspek'] = $aspek[$i]['kd_aspek'];
                    @$datahasil[$i]['uraian'] = $aspek[$i]['uraian'];
                    if ($value['nilai'] == '1') {
                        @$datahasil[$i]['kurang'] += 1;
                        @$datahasil[$i]['cukup'] += 0;
                        @$datahasil[$i]['baik'] += 0;
                        @$datahasil[$i]['sangat_baik'] += 0;
                    } elseif ($value['nilai'] == '2') {
                        @$datahasil[$i]['kurang'] += 0;
                        @$datahasil[$i]['cukup'] += 1;
                        @$datahasil[$i]['baik'] += 0;
                        @$datahasil[$i]['sangat_baik'] += 0;
                    } elseif ($value['nilai'] == '3') {
                        @$datahasil[$i]['kurang'] += 0;
                        @$datahasil[$i]['cukup'] += 0;
                        @$datahasil[$i]['baik'] += 1;
                        @$datahasil[$i]['sangat_baik'] += 0;
                    } elseif ($value['nilai'] == '4') {
                        @$datahasil[$i]['kurang'] += 0;
                        @$datahasil[$i]['cukup'] += 0;
                        @$datahasil[$i]['baik'] += 0;
                        @$datahasil[$i]['sangat_baik'] += 1;
                    }
                }
            }    
        }

        $responden = count($hasil)/count($aspek);

        $data['data'] = $datahasil;
        // $data['company'] = $company[0];
        $data['responden'] = $responden;
        $data['aspek'] = $aspek;
        $this->load_view('fperusahaan/query', $data);
    }

    function logout()
    {
        $this->session->sess_destroy();
        redirect('feedback', 'refresh');
    }


}