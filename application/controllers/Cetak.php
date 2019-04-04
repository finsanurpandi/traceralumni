<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cetak extends CI_Controller {

    public $setup;

    function __construct()
    {
        parent::__construct();
        $this->load->model('m_feedback');
        $this->setup = $this->m_feedback->getAllData('ace_configuration')->result_array();
    }

    public function index()
    {
        $this->output->set_output("This is an CETAK endpoint!");
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
                $data[0]['thn_akademik'] = $value['thn_akademik'];
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
                    $data[$arr]['thn_akademik'] = $value['thn_akademik'];
                }
            }
            $i++;
            $same = 0;
        }

        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";

        // for ($i=0; $i < count($data); $i++) { 
        //     $total += $data[$i]['bln'];
        // }

        // $rata = $total/count($data);

        // return round($rata, 2);
        return $data;
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

        //get rata-rata bulan
        $waktuTunggu = $this->getRataBulan();
        $total = 0;
        $rata = 0;
        $blnWaktuTunggu = [];

        for ($i=0; $i < count($waktuTunggu); $i++) { 
            // $total += $waktuTunggu[$i]['bln'];

            for ($j=0; $j < count($jmlalumni); $j++) { 
                if ($waktuTunggu[$i]['thn_akademik'] == $jmlalumni[$j]['thn_akademik']) {
                    @$jmlalumni[$j]['ngisi'] += 1;
                    @$jmlalumni[$j]['bln'] += $waktuTunggu[$i]['bln'];
                    $total += $waktuTunggu[$i]['bln'];
                }
            }
        }

        $rata = $total/count($waktuTunggu);

        $data['jml'] = $jml;
        $data['jmlalumni'] = $jmlalumni;
        $data['totalAlumni'] = $totalAlumni;
        $data['totalTracer'] = $totalTracer;
        $data['totalTracerAngkatan'] = $totalTracerAngkatan;
        $data['statusAlumni'] = $statusAlumni;
        $data['ratabulan'] = round($rata, 2);
        $data['prodi'] = $prodi;
        $data['config'] = $this->setup[0];
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
        $data['prodi'] = $prodi;

        $this->load->view('cetak/cetak_feedback_pengguna', $data);
    }

}