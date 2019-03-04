<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Export extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('m_feedback');
        
    }

    public function index()
    {
        $this->output->set_output("This is an EXPORT endpoint!");
    }

    function export_perusahaan_xls()
    {
        $perusahaan = $this->m_feedback->getAllData('ace_perusahaan', array('kd_prodi' => $this->session->kdprodi))->result_array();
        $data['perusahaan'] = $perusahaan;
        $data['title'] = "Data Pengguna Lulusan";
        $this->load->view('export/export_perusahaan', $data);

    }

    function cetak_data_alumni($fromYear, $untilYear)
    {
        //$data['user'] = $this->user[0];
        $prodi = $this->m_feedback->getAllData('ace_prodi', array('kd_prodi' => $this->session->kdprodi))->result_array();
        $data['prodi'] = $prodi;

        if ($fromYear !== "unknown" && $untilYear !== "unknown") {

            $jmlalumni = $this->m_feedback->getJmlAlumni($this->session->kdprodi, $fromYear, $untilYear); 
            $totalAlumni = $this->m_feedback->getFilterDataAlumni('ace_data_alumni', $this->session->kdprodi, $fromYear, $untilYear);
            $totalTracer = $this->m_feedback->getFilterDataAlumni('v_tracer_alumni', $this->session->kdprodi, $fromYear, $untilYear);
            $totalTracerAngkatan = $this->m_feedback->getJumlahTracerAngkatan($this->session->kdprodi, $fromYear, $untilYear);
            $statusAlumni = $this->m_feedback->getStatusAlumni($this->session->kdprodi, $fromYear, $untilYear);
            
            //show years
            // $this->session->set_flashdata('filter', true);
            // $data['from'] = $fromYear;
            // $data['until'] = $untilYear;

        } else {

            $jmlalumni = $this->m_feedback->getJmlAlumni($this->session->kdprodi); 
            $totalAlumni = $this->m_feedback->getAllData('ace_data_alumni', array('kd_prodi' => $this->session->kdprodi))->result_array();
            $totalTracer = $this->m_feedback->getAllData('v_tracer_alumni', array('kd_prodi' => $this->session->kdprodi))->result_array();
            $totalTracerAngkatan = $this->m_feedback->getJumlahTracerAngkatan($this->session->kdprodi);
            $statusAlumni = $this->m_feedback->getStatusAlumni($this->session->kdprodi);

        }

        $key = count($jmlalumni);
        $data['from'] = $jmlalumni[0]['thn_akademik'];
        $data['until'] = $jmlalumni[$key-1]['thn_akademik'];

        $jml = 0;
        foreach ($jmlalumni as $key => $value) {
            $jml += $value['jumlah'];
        }

        $data['jml'] = $jml;
        $data['jmlalumni'] = $jmlalumni;
        $data['totalAlumni'] = $totalAlumni;
        $data['totalTracer'] = $totalTracer;
        $data['totalTracerAngkatan'] = $totalTracerAngkatan;
        $data['statusAlumni'] = $statusAlumni;
        $data['ratabulan'] = $this->getRataBulan();
        $this->load->view('cetak/cetak_data_alumni', $data);
    }

    function cetak_feedback_pengguna()
    {
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

        $this->load->view('cetak/cetak_feedback_pengguna', $data);
    }

}