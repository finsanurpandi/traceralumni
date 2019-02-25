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
        $prodi = $this->m_feedback->getAllData('ace_prodi', array('kd_prodi' => $this->session->kdprodi))->result_array();
        $data['prodi'] = $prodi;
        $this->load_view('fadmin/default', $data);
    }

    function alumni()
    {
        $data['user'] = $this->user[0];
        $alumni = $this->m_feedback->getAllData('ace_data_alumni',array('kd_prodi' => $this->session->kdprodi))->result_array();
        $totalAlumni = $this->m_feedback->getTotalAlumni($this->session->kdprodi, 'Peserta didik baru');
        $alumniPindahan = $this->m_feedback->getTotalAlumni($this->session->kdprodi, 'Pindahan');
        
        $data['alumni'] = $alumni;
        $data['total'] = $totalAlumni;
        $data['pindahan'] = $alumniPindahan;

        $this->load_view('fadmin/alumni', $data);
    }

    function alumni1()
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
        $busaha = $this->m_feedback->getDistinctData('ace_perusahaan', 'bidang_usaha')->result_array();
        $data['busaha'] = $busaha;
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

            $this->m_feedback->insertData('ace_perusahaan', $data);

            $this->session->set_flashdata('delete', true);

            redirect($this->uri->uri_string());
        }

        // SET PASSWORD
        $setpass = $this->input->post('setPass');
        if (isset($setpass)) {
            $where = array('kd_perusahaan' => $this->input->post('kdPerusahaan'));

            // print_r($this->input->post());
            $this->m_feedback->updateData('ace_perusahaan', array('pass' => sha1('12345')), $where);

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

    function rekap_alumni()
    {
        $data['user'] = $this->user[0];
        $alumni = $this->m_feedback->getDataAlumni($this->session->kdprodi);
        $data['alumni'] = $alumni;
        $this->load_view('fadmin/rekap_alumni', $data);
    }

    function rekap_perusahaan()
    {
        $data['user'] = $this->user[0];
        $perusahaan = $this->m_feedback->getPenggunaLulusan($this->session->kdprodi);
        $hasAccount = $this->m_feedback->getAllData('ace_perusahaan')->result_array();
        $data['perusahaan'] = $perusahaan;
        $data['hasAccount'] = $hasAccount;
        $this->load_view('fadmin/rekap_perusahaan', $data);

        $createAccount = $this->input->post('createAccount');
        if (isset($createAccount)) {
            $data = array(
                'nama_perusahaan' => $this->input->post('nama_perusahaan'),
                'alamat' => $this->input->post('alamat'),
                'bidang_usaha' => $this->input->post('bidang_usaha'),
                'email' => $this->input->post('email'),
                'kd_prodi' => $this->session->kdprodi
            );

            $this->m_feedback->insertData('ace_perusahaan', $data);

            redirect($this->uri->uri_string());
        }
    }

    function penilaian_alumni1()
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

    function getRataBulan()
    {
        $alumni = $this->m_feedback->getAllData('v_detail_alumni', array('kd_prodi' => $this->session->kdprodi))->result_array();
        $data = array();
        $i = 0;
        $same = 0;
        $index = 0;
        $rata = 0;
        $total = 0;

        foreach ($alumni as $key => $value) {
            $tgl = explode('-',$value['tgl_keluar']);
            $bln = 0;
            $arr = count($data);

            // Menghitung Bulan
            if ($tgl[2] == $value['tahun_bekerja']) { //jika tahun keluar sama dengan tahun pertama bekerja
                if ($tgl[1] > $value['bulan_bekerja']) {
                    $bln = (int)$tgl[1] - (int)$value['bulan_bekerja'];
                } elseif ($tgl[1] < $value['bulan_bekerja']) {
                    $bln = (int)$value['bulan_bekerja'] - (int)$tgl[1];
                } elseif ($tgl[1] == $value['bulan_bekerja']) {
                    $bln = 0;
                }
            } elseif ($tgl[2] < $value['tahun_bekerja']) { // jika tahun keluar lebih kecil dari tahun pertama bekerja
                if ((int)$value['tahun_bekerja'] - (int)$tgl[2] == 1) {
                    $bln1 = 12 - (int)$tgl[1];
                    $bln = $bln1 + (int)$value['bulan_bekerja'];
                } else {
                    $thn = (int)$value['tahun_bekerja'] - (int)$tgl[2];
                    
                    $bln1 = 12 - (int)$tgl[1];
                    $bln = ($bln1 + (int)$value['bulan_bekerja']) + (($thn - 1) * 12);
                }
                
            } elseif ($tgl[2] > $value['tahun_bekerja']) { // jika tahun keluar lebih besar dari tahun pertama bekerja
                $bln = 0;
            }

            if ($i == 0) { // mengisi record pertama pada array
                $data[0]['npm'] = $value['npm'];
                $data[0]['bln'] = $bln;
            } else {
                for ($n=0; $n < count($data); $n++) { 
                    if ($data[$n]['npm'] == $value['npm']) { // jika terdapat npm yang sama
                        $same = 1;
                        $index = $n;
                    }
                }

                if ($same == 1) {
                    if ($bln < $data[$index]['bln']) { // jika npm sama, maka...
                        $data[$index]['bln'] = $bln;
                    }
                } else {
                    $data[$arr]['npm'] = $value['npm'];
                    $data[$arr]['bln'] = $bln;
                }
            }
            $i++;
            $same = 0;
        }

        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";

        for ($i=0; $i < count($data); $i++) { 
            $total += $data[$i]['bln'];
        }

        $rata = $total/count($data);

        return round($rata, 2);
    }

    function penilaian_alumni()
    {
        $data['user'] = $this->user[0];
        $prodi = $this->m_feedback->getAllData('ace_prodi', array('kd_prodi' => $this->session->kdprodi))->result_array();
        $data['prodi'] = $prodi;


        // get all data alumni
        // $jmlalumni = $this->m_feedback->getJmlAlumni($this->session->kdprodi); // get jumlah alumni
        // $totalAlumni = $this->m_feedback->getAllData('ace_data_alumni', array('kd_prodi' => $this->session->kdprodi))->result_array();
        // $totalTracer = $this->m_feedback->getAllData('v_tracer_alumni', array('kd_prodi' => $this->session->kdprodi))->result_array();
        // $totalTracerAngkatan = $this->m_feedback->getJumlahTracerAngkatan($this->session->kdprodi);
        // $statusAlumni = $this->m_feedback->getStatusAlumni($this->session->kdprodi);

        //setYear
        $setYear = $this->input->post('setYear');
        
        $fromYear = "unknown";
        $untilYear = "unknown";

        if (isset($setYear)) {
            $fromYear = $this->input->post('dari');
            $untilYear = $this->input->post('sampai');

            $jmlalumni = $this->m_feedback->getJmlAlumni($this->session->kdprodi, $fromYear, $untilYear); 
            $totalAlumni = $this->m_feedback->getFilterDataAlumni('ace_data_alumni', $this->session->kdprodi, $fromYear, $untilYear);
            $totalTracer = $this->m_feedback->getFilterDataAlumni('v_tracer_alumni', $this->session->kdprodi, $fromYear, $untilYear);
            $totalTracerAngkatan = $this->m_feedback->getJumlahTracerAngkatan($this->session->kdprodi, $fromYear, $untilYear);
            $statusAlumni = $this->m_feedback->getStatusAlumni($this->session->kdprodi, $fromYear, $untilYear);
            
            //show years
            $this->session->set_flashdata('filter', true);
            $data['from'] = $fromYear;
            $data['until'] = $untilYear;

        } else {
            $jmlalumni = $this->m_feedback->getJmlAlumni($this->session->kdprodi); 
            $totalAlumni = $this->m_feedback->getAllData('ace_data_alumni', array('kd_prodi' => $this->session->kdprodi))->result_array();
            $totalTracer = $this->m_feedback->getAllData('v_tracer_alumni', array('kd_prodi' => $this->session->kdprodi))->result_array();
            $totalTracerAngkatan = $this->m_feedback->getJumlahTracerAngkatan($this->session->kdprodi);
            $statusAlumni = $this->m_feedback->getStatusAlumni($this->session->kdprodi);

            $data['from'] = $fromYear;
            $data['until'] = $untilYear;
           
        }

        $data['jmlalumni'] = $jmlalumni;
        $data['totalAlumni'] = $totalAlumni;
        $data['totalTracer'] = $totalTracer;
        $data['totalTracerAngkatan'] = $totalTracerAngkatan;
        $data['statusAlumni'] = $statusAlumni;
        $data['ratabulan'] = $this->getRataBulan();
        $this->load_view('fadmin/penilaian_alumni', $data);
    }

    function penilaian_perusahaan()
    {
        $data['user'] = $this->user[0];
        $prodi = $this->m_feedback->getAllData('ace_prodi', array('kd_prodi' => $this->session->kdprodi))->result_array();
        $data['prodi'] = $prodi;

        $company = $this->m_feedback->getAllData('ace_perusahaan', array('kd_perusahaan' => $this->session->user))->result_array();
        $hasil = $this->m_feedback->getAllData('ace_penilaian', array('kd_prodi' => $this->session->kdprodi))->result_array();
        $aspek = $this->m_feedback->getAllData('ace_aspek_penilaian')->result_array();
        $jumlah = $this->m_feedback->getJumlahFeedback($this->session->kdprodi);
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
        $data['jumlah'] = $jumlah;
        $this->load_view('fadmin/penilaian_perusahaan', $data);
    }

    function ubah_password()
    {
        $user = $this->m_feedback->getAllData('ace_login', array('username' => $this->session->user))->result_array();
        $data['user'] = $user[0];
        $this->load_view('fadmin/ubah_password', $data);

        $ubahpass = $this->input->post('ubahpass');
        if (isset($ubahpass)) {
            $pass = $this->input->post('pass');
            $npass = $this->input->post('npass');
            $cpass = $this->input->post('cpass');

            if (sha1($pass) !== $user[0]['password']) {
                $this->session->set_flashdata('wrongpass', true);
                redirect($this->uri->uri_string());
            } elseif ($npass !== $cpass) {
                $this->session->set_flashdata('wrongconfirm', true);
                redirect($this->uri->uri_string());
            } else {
                $this->m_feedback->updateData('ace_login', array('password' => sha1($npass)), array('username' => $this->session->user));
                $this->session->set_flashdata('success', true);
                redirect($this->uri->uri_string());
            }
        }
    }

    function cetak()
    {

    }

}