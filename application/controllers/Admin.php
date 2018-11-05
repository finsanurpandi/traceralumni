<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

    public $user;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_feedback');

		$this->check_login();
        date_default_timezone_set("Asia/Bangkok");
        $this->user = $this->m_feedback->getAllData('ace_login', array('username' => $this->session->user))->result_array();
        
    }

    function load_view($url, $data = null)
    {
        $this->load->view('fadmin/head');
        $this->load->view('fadmin/header');
        

        if ($data !== null) {
            $this->load->view('fadmin/sidebar', $data);
            $this->load->view($url, $data);
        } else {
            $this->load->view('fadmin/sidebar');
            $this->load->view($url);
        }
        
        $this->load->view('fadmin/footer');
    }

    function check_login()
    {
        if (($this->session->login_in !== TRUE) && ($this->session->role !== '0')) {
            redirect('feedback', 'refresh');
        }
    }

    public function index()
    {
        $data['user'] = $this->user[0];
        $this->load_view('default', $data);
    }

    function alumni()
    {
        $data['user'] = $this->user[0];

        $alumni = $this->m_feedback->getAllData('ace_alumni', array('kd_prodi' => $this->session->kdprodi))->result_array();
        $perusahaan = $this->m_feedback->getAllData('ace_perusahaan', array('kd_prodi' => $this->session->kdprodi))->result_array();
        $prodi = $this->m_feedback->getAllData('ace_prodi', array('kd_prodi' => $this->session->kdprodi))->result_array();
        $status = $this->m_feedback->getAllData('ace_status')->result_array();

        
        $bekerja = $this->m_feedback->getAllData('v_alumni_bekerja', array('kd_prodi' => $this->session->kdprodi))->result_array();
        $kesesuaian = $this->m_feedback->getAllData('v_alumni_bekerja', array('kd_prodi' => $this->session->kdprodi, 'kesesuaian' => '1'))->result_array();
        $wirausaha = $this->m_feedback->getAllData('v_alumni_wirausaha', array('kd_prodi' => $this->session->kdprodi))->result_array();
        $belumbekerja = $this->m_feedback->getAllData('v_alumni_jobless', array('kd_prodi' => $this->session->kdprodi, 'kd_status' => '3'))->result_array();
        $tidakbekerja = $this->m_feedback->getAllData('v_alumni_jobless', array('kd_prodi' => $this->session->kdprodi, 'kd_status' => '4'))->result_array();

        // RATA-RATA WAKTU TUNGGU BEKERJA
        $waktutunggu = 0;
        foreach ($bekerja as $key => $value) {
            if ($value['tahun_bekerja'] > $value['thn_lulus']) {
                $waktutunggu += ($value['bulan_bekerja'] + (12 - $value['bln_lulus']));
            } elseif ($value['tahun_bekerja'] == $value['thn_lulus']) {
                $waktutunggu += ($value['bulan_bekerja'] - $value['bln_lulus']);
            }
        }
        $ratawaktutunggu = round($waktutunggu/count($bekerja), 1);

        // PERSENTASE STATUS

        $data['alumni'] = $alumni;
        $data['perusahaan'] = $perusahaan;
        $data['prodi'] = $prodi;
        $data['status'] = $status;
        $data['waktutunggu'] = $ratawaktutunggu;
        $data['bekerja'] = round((count($bekerja)/count($alumni))*100,2);
        $data['jml_bekerja'] = count($bekerja);
        $data['wirausaha'] = round((count($wirausaha)/count($alumni))*100,2);
        $data['jml_wirausaha'] = count($wirausaha);
        $data['belumbekerja'] = round((count($belumbekerja)/count($alumni))*100,2);
        $data['tidakbekerja'] = round((count($tidakbekerja)/count($alumni))*100,2);
        $data['sesuaibidang'] = round((count($kesesuaian)/count($bekerja))*100,2);
        $this->load_view('fadmin/alumni', $data);

        // add alumni
        $addAlumni = $this->input->post('addAlumni');
        if (isset($addAlumni)) {
            $dataAlumni = array(
                'npm' => $this->input->post('npm'),
                'kd_prodi' => $this->input->post('kd_prodi'),
                'nama' => $this->input->post('nama'),
                'alamat' => $this->input->post('alamat_mhs'),
                'no_tlp' => $this->input->post('no_tlp'),
                'email' => $this->input->post('email_mhs'),
                'bln_lulus' => $this->input->post('bln_lulus'),
                'thn_lulus' => $this->input->post('thn_lulus'),
                'kd_status' => $this->input->post('kd_status')
            );

            $thn_akademik = '';
            if (($this->input->post('bln_lulus') >= '9') || ($this->input->post('bln_lulus') <= '1')) {
                $thn_akademik = $this->input->post('thn_lulus').'/'.((int)$this->input->post('thn_lulus')+1);
            } elseif (($this->input->post('bln_lulus') >= '2') && ($this->input->post('bln_lulus') <= '6')) {
                $thn_akademik = ((int)$this->input->post('thn_lulus')-1).'/'.$this->input->post('thn_lulus');
            }

            $dataAlumni['tahun_akademik'] = $thn_akademik;

            $dataDetail = array(
                'npm' => $this->input->post('npm'),
                'kd_status' => $this->input->post('kd_status'),
                'kd_perusahaan' => $this->input->post('kd_perusahaan'),
                'posisi' => $this->input->post('posisi'),
                'kesesuaian' => $this->input->post('kesesuaian'),
                'nama_tempat_usaha' => $this->input->post('nama_tempat_usaha'),
                'bidang_usaha' => $this->input->post('bidang_usaha_wirausaha')
            );

            if ($this->input->post('kd_status') == '1') {
                $dataDetail['bulan_bekerja'] = $this->input->post('bulan_bekerja');
                $dataDetail['tahun_bekerja'] = $this->input->post('tahun_bekerja');
            } elseif ($this->input->post('kd_status') == '2') {
                $dataDetail['bulan_bekerja'] = $this->input->post('bulan_wirausaha');
                $dataDetail['tahun_bekerja'] = $this->input->post('tahun_wirausaha');
            }

            if (!empty($this->input->post('nama_perusahaan'))) {
                $lastrecord = $this->m_feedback->getLastRecord();

                $dataPerusahaan = array(
                    'kd_perusahaan' => $lastrecord[0]['kd_perusahaan']+1,
                    'nama_perusahaan' => $this->input->post('nama_perusahaan'),
                    'alamat' => $this->input->post('alamat_pt'),
                    'bidang_usaha' => $this->input->post('bidang_usaha_pt'),
                    'email' => $this->input->post('email_pt'),
                    'kd_prodi' => $this->session->kdprodi
                );

                $dataDetail['kd_perusahaan'] = $lastrecord[0]['kd_perusahaan']+1;

                $this->m_feedback->insertThreeTable('ace_perusahaan', $dataPerusahaan,'ace_alumni', $dataAlumni, 'ace_detail_alumni', $dataDetail);
                // print_r($dataAlumni);
                // print_r($dataPerusahaan);
            } else {
                $this->m_feedback->insertTwoTable('ace_alumni', $dataAlumni, 'ace_detail_alumni', $dataDetail);
                 //print_r($dataAlumni);
            }
            //print_r($dataAlumni);
            $this->session->set_flashdata('success', true);

            redirect($this->uri->uri_string());
        }

        // EDIT ALUMNI
        $editAlumni = $this->input->post('editAlumni');
        if (isset($editAlumni)) {
            $dataAlumni = array(
                'nama' => $this->input->post('nama'),
                'alamat' => $this->input->post('alamat_mhs'),
                'no_tlp' => $this->input->post('no_tlp'),
                'email' => $this->input->post('email_mhs'),
                'thn_lulus' => $this->input->post('thn_lulus'),
                'kd_perusahaan' => $this->input->post('kd_perusahaan'),
                'posisi' => $this->input->post('posisi'),
                'bulan_bekerja' => $this->input->post('bulan_bekerja'),
                'tahun_bekerja' => $this->input->post('tahun_bekerja')
            );

            if (!empty($this->input->post('nama_perusahaan'))) {
                $lastrecord = $this->m_feedback->getLastRecord();

                $dataPerusahaan = array(
                    'kd_perusahaan' => $lastrecord[0]['kd_perusahaan']+1,
                    'nama_perusahaan' => $this->input->post('nama_perusahaan'),
                    'alamat' => $this->input->post('alamat_pt'),
                    'bidang_usaha' => $this->input->post('bidang_usaha'),
                    'email' => $this->input->post('email_pt')
                );

                $dataAlumni['kd_perusahaan'] = $lastrecord[0]['kd_perusahaan']+1;

                $this->m_feedback->insertUpdateTwoTable('ace_perusahaan', $dataPerusahaan,'ace_alumni', $dataAlumni, array('npm' => $this->input->post('npm')));
                // print_r($dataAlumni);
                // print_r($dataPerusahaan);
            } else {
                $this->m_feedback->updateData('ace_alumni', $dataAlumni, array('npm' => $this->input->post('npm')));
                print_r($dataAlumni);
            }
            
            $this->session->set_flashdata('warning', true);

            redirect($this->uri->uri_string());
        }

        
    }

    function detail_alumni($npm)
    {
        $npm = $this->encrypt->decode($npm);

        $data['user'] = $this->user[0];

        $alumni = $this->m_feedback->getAllData('ace_alumni', array('npm' => $npm))->result_array();
        
        if ($alumni[0]['kd_status'] == '1') { // bekerja
            $detail = $this->m_feedback->getAllData('v_alumni_bekerja', array('npm' => $npm))->result_array();
            $status = 'Sudah Bekerja';
        } elseif ($alumni[0]['kd_status'] == '2') { // wirausaha
            $detail = $this->m_feedback->getAllData('v_alumni_wirausaha', array('npm' => $npm))->result_array();
            $status = 'Wirausaha';
        } else { // jobless
            $detail = $this->m_feedback->getAllData('v_alumni_jobless', array('npm' => $npm))->result_array();

            if ($alumni[0]['kd_status'] == '3') {
                $status = 'Belum Bekerja';
            } else {
                $status = 'Tidak Bekerja/Berkeluarga';
            }
        }
        
        $data['detail'] = $detail;
        $data['status'] = $status;
        $this->load_view('fadmin/detail_alumni', $data);
    }

    function jmlalumni()
    {
        $data['user'] = $this->user[0];

        $jmlalumni = $this->m_feedback->getAllData('ace_jumlah_alumni', array('kd_prodi' => $this->session->kdprodi))->result_array();
        $data['jmlalumni'] = $jmlalumni;
        $this->load_view('fadmin/jmlalumni', $data);

        // add jumlah alumni
        $addJumlah = $this->input->post('addJmlAlumni');
        if (isset($addJumlah)) {
            $data = array(
                'tahun_akademik' => $this->input->post('tahun_akademik'),
                'bulan' => $this->input->post('bulan'),
                'periode' => $this->input->post('periode'),
                'jumlah' => $this->input->post('jumlah'),
                'kd_prodi' => $this->session->kdprodi
            );

            $this->m_feedback->insertData('ace_jumlah_alumni', $data);

            $this->session->set_flashdata('success', true);

            redirect($this->uri->uri_string());
        }
    }

    function perusahaan()
    {
        $data['user'] = $this->user[0];

        $perusahaan = $this->m_feedback->getAllData('ace_perusahaan', array('status' => '1', 'kd_prodi' => $this->session->kdprodi))->result_array();
        $data['perusahaan'] = $perusahaan;
        $this->load_view('fadmin/perusahaan', $data);

        // ADD PERUSAHAAN
        $addPt = $this->input->post('addPerusahaan');
        if (isset($addPt)) {
            $lastrecord = $this->m_feedback->getLastRecord();

            $data = array(
                'kd_perusahaan' => $lastrecord[0]['kd_perusahaan']+1,
                'nama_perusahaan' => $this->input->post('nama_perusahaan'),
                'alamat' => $this->input->post('alamat'),
                'bidang_usaha' => $this->input->post('bidang_usaha'),
                'email' => $this->input->post('email'),
                'kd_prodi' => $this->session->kdprodi
            );

            $this->m_feedback->insertData('ace_perusahaan', $data);

            $this->session->set_flashdata('success', true);

            redirect($this->uri->uri_string());
        }

        // EDIT PERUSAHAAN
        $editPt = $this->input->post('editPerusahaan');
        if (isset($editPt)) {
            $data = array(
                'nama_perusahaan' => $this->input->post('nama_perusahaan'),
                'alamat' => $this->input->post('alamat'),
                'bidang_usaha' => $this->input->post('bidang_usaha'),
                'email' => $this->input->post('email')
            );

            $this->m_feedback->updateData('ace_perusahaan', $data, array('kd_perusahaan' => $this->input->post('kd_perusahaan')));

            $this->session->set_flashdata('warning', true);

            redirect($this->uri->uri_string());
        }

        // EDIT HAPUS
        $deletePt = $this->input->post('deletePerusahaan');
        if (isset($deletePt)) {
            # code...

            $this->m_feedback->insertData('ace_perusahaan', $data);

            $this->session->set_flashdata('delete', true);

            redirect($this->uri->uri_string());
        }
    }

    function detail_perusahaan($kd_perusahaan)
    {
        $kd_perusahaan = $this->encrypt->decode($kd_perusahaan);

        $data['user'] = $this->user[0];

        $perusahaan = $this->m_feedback->getAllData('v_alumni_bekerja', array('kd_perusahaan' => $kd_perusahaan))->result_array();
        // $alumni = $this->m_feedback->getAlumniOnDetailPerusahaan($kd_perusahaan);
        // $alumni = $this->m_feedback->getAllData('ace_alumni', array('kd_perusahaan' => $kd_perusahaan))->result_array();
        $data['perusahaan'] = $perusahaan;
        // $data['alumni'] = $alumni;
        $this->load_view('fadmin/detail_perusahaan', $data);
    }

    function uraian()
    {
        $uraian = $this->m_feedback->getAllData('ace_kategori')->result_array();
        $data['uraian'] = $uraian;
        $data['user'] = $this->user[0];
        $this->load_view('fadmin/uraian', $data);
    }

    function penilaian_alumni()
    {
        $data['user'] = $this->user[0];

        $alumni = $this->m_feedback->getAllData('ace_alumni', array('kd_prodi' => $this->session->kdprodi))->result_array();
        $jmlalumni = $this->m_feedback->getAllJumlahAlumni($this->session->kdprodi);
        $perusahaan = $this->m_feedback->getAllData('ace_perusahaan', array('kd_prodi' => $this->session->kdprodi))->result_array();
        $prodi = $this->m_feedback->getAllData('ace_prodi', array('kd_prodi' => $this->session->kdprodi))->result_array();
        $status = $this->m_feedback->getAllData('ace_status')->result_array();

        
        $bekerja = $this->m_feedback->getAllData('v_alumni_bekerja', array('kd_prodi' => $this->session->kdprodi))->result_array();
        $kesesuaian = $this->m_feedback->getAllData('v_alumni_bekerja', array('kd_prodi' => $this->session->kdprodi, 'kesesuaian' => '1'))->result_array();
        $wirausaha = $this->m_feedback->getAllData('v_alumni_wirausaha', array('kd_prodi' => $this->session->kdprodi))->result_array();
        $belumbekerja = $this->m_feedback->getAllData('v_alumni_jobless', array('kd_prodi' => $this->session->kdprodi, 'kd_status' => '3'))->result_array();
        $tidakbekerja = $this->m_feedback->getAllData('v_alumni_jobless', array('kd_prodi' => $this->session->kdprodi, 'kd_status' => '4'))->result_array();

        // RATA-RATA WAKTU TUNGGU BEKERJA
        $waktutunggu = 0;
        foreach ($bekerja as $key => $value) {
            if ($value['tahun_bekerja'] > $value['thn_lulus']) {
                $waktutunggu += ($value['bulan_bekerja'] + (12 - $value['bln_lulus']));
            } elseif ($value['tahun_bekerja'] == $value['thn_lulus']) {
                $waktutunggu += ($value['bulan_bekerja'] - $value['bln_lulus']);
            }
        }
        $ratawaktutunggu = round($waktutunggu/count($bekerja), 1);

        // PERSENTASE STATUS

        $data['alumni'] = $alumni;
        $data['perusahaan'] = $perusahaan;
        $data['jmlalumni'] = $jmlalumni;
        $data['prodi'] = $prodi;
        $data['status'] = $status;
        $data['waktutunggu'] = $ratawaktutunggu;
        $data['bekerja'] = round((count($bekerja)/count($alumni))*100,2);
        $data['jml_bekerja'] = count($bekerja);
        $data['wirausaha'] = round((count($wirausaha)/count($alumni))*100,2);
        $data['jml_wirausaha'] = count($wirausaha);
        $data['belumbekerja'] = round((count($belumbekerja)/count($alumni))*100,2);
        $data['tidakbekerja'] = round((count($tidakbekerja)/count($alumni))*100,2);
        $data['sesuaibidang'] = round((count($kesesuaian)/count($bekerja))*100,2);
        $this->load_view('fadmin/penilaian_alumni', $data);
    }

    function penilaian_perusahaan()
    {
        $data['user'] = $this->user[0];
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
        $this->load_view('fadmin/penilaian_perusahaan', $data);
    }

    function cetak()
    {

    }

}