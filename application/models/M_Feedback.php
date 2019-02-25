<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_feedback extends CI_Model {

	function __construct()
	{
		parent::__construct();

	}

// GET DATA

	function getAllData($table, $where = null, $order = null)
	{
		if ($where !== null) {
			foreach ($where as $key => $value) {
				$this->db->where($key, $value);
			}
		}

		if ($order !== null) {
			foreach ($order as $key => $value) {
				$this->db->order_by($key, $value);
			}
		}

		$query = $this->db->get($table);

		return $query;
	}

	function getAllDataOr($table, $where = null, $order = null)
	{
		if ($where !== null) {
			foreach ($where as $key => $value) {
				$this->db->or_where($key, $value);
			}
		}

		if ($order !== null) {
			foreach ($order as $key => $value) {
				$this->db->order_by($key, $value);
			}
		}

		$this->db->where('tahun_ajaran', $this->session->tahun_ajaran);
		$query = $this->db->get($table);

		return $query;
	}

	function getDataLike($table, $like)
	{
		foreach ($like as $key => $value) {
			$this->db->like($key, $value);
		}

		$query = $this->db->get($table);

		return $query;
	}

	function getNumRows($table, $where = null)
	{
		if ($where !== null) {
			$query = $this->db->get_where($table, $where);
		} else {
			$query = $this->db->get($table);
		}

		return $query->num_rows();
	}

	function getDistinctData($table, $row, $order = null)
	{
		$this->db->distinct();

		$this->db->select($row);

		if ($order !== null) {
			foreach ($order as $key => $value) {
				$this->db->order_by($key, $value);
			}
		}

		$query = $this->db->get($table);

		return $query;
	}

	function getDistinctWhereData($table, $row, $where)
	{
		$this->db->distinct();

		$this->db->select($row);

		$this->db->where($where);

		//$this->db->order_by('semester', 'DESC');

		$query = $this->db->get($table);

		return $query;
	}

	function getDistinctDataOrder($table, $where = null, $row, $order)
	{
		$this->db->distinct();

		$this->db->select($row);

		if ($where !== null) {
			foreach ($where as $key => $value) {
				$this->db->where($key, $value);
			}
		}

		foreach ($order as $key => $value) {
			$this->db->order_by($key, $value);
		}

		$query = $this->db->get($table);

		return $query;
    }
    
    function getLastRecord()
    {
        $sql = "SELECT * FROM ace_perusahaan ORDER BY kd_perusahaan DESC LIMIT 1";

        $query = $this->db->query($sql);

        return $query->result_array();
    }

    function getAlumniOnDetailPerusahaan($kd_perusahaan)
    {
        $sql = "SELECT ace_alumni.*, ace_pegawai.bulan_bekerja, ace_pegawai.tahun_bekerja FROM ace_alumni LEFT OUTER JOIN ace_pegawai ON ace_alumni.kd_perusahaan = ace_pegawai.kd_perusahaan AND ace_alumni.npm = ace_pegawai.npm WHERE ace_alumni.kd_perusahaan = '".$kd_perusahaan."' GROUP BY ace_alumni.npm";

        $query = $this->db->query($sql);

        return $query->result_array();
	}
	
	function getAllJumlahAlumni($kdprodi)
	{
		$sql = "SELECT `tahun_akademik`, SUM(`jumlah`) AS `jumlah`, `kd_prodi` FROM `ace_jumlah_alumni` WHERE kd_prodi = '".$kdprodi."' GROUP BY `tahun_akademik`";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	function getDetailKarir($npm)
	{
		$sql = "SELECT ace_detail_alumni.*, ace_perusahaan.nama_perusahaan, ace_perusahaan.bidang_usaha AS pt_bidang_usaha FROM `ace_detail_alumni` LEFT JOIN ace_perusahaan ON ace_detail_alumni.kd_perusahaan = ace_perusahaan.kd_perusahaan WHERE ace_detail_alumni.npm = '".$npm."' ORDER BY ace_detail_alumni.log DESC";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	function getPenilaianPerson($kd_alumni)
	{
		$sql = "SELECT ace_penilaian.*, ace_aspek_penilaian.uraian FROM `ace_penilaian` LEFT JOIN ace_aspek_penilaian ON ace_aspek_penilaian.kd_aspek = ace_penilaian.kd_aspek WHERE ace_penilaian.kd_alumni = '".$kd_alumni."'";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	function getTotalAlumni($kdprodi, $keterangan)
	{
		$sql = "SELECT thn_akademik, COUNT(thn_akademik) AS Total FROM `ace_data_alumni` WHERE kd_prodi = '".$kdprodi."' AND keterangan = '".$keterangan."' GROUP BY thn_akademik";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function getJmlAlumni($kdprodi, $from = null, $until = null)
	{
		if ($from !== null && $until !== null) {
			$sql = "SELECT thn_akademik, COUNT(thn_akademik) AS jumlah FROM `ace_data_alumni` WHERE kd_prodi = '".$kdprodi."' AND thn_akademik BETWEEN '".$from."' AND '".$until."' GROUP BY thn_akademik";
		} else {
			$sql = "SELECT thn_akademik, COUNT(thn_akademik) AS jumlah FROM `ace_data_alumni` WHERE kd_prodi = '".$kdprodi."' GROUP BY thn_akademik";
		}
		
		//$sql = "SELECT thn_akademik, COUNT(thn_akademik) AS jumlah FROM `ace_data_alumni` WHERE kd_prodi = '".$kdprodi."' GROUP BY thn_akademik";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function getJumlahFeedback($kdprodi)
	{
		$sql = "SELECT ace_perusahaan.nama_perusahaan, COUNT(ace_alumni_penilaian.kd_perusahaan) AS jumlah FROM `ace_alumni_penilaian` LEFT JOIN ace_perusahaan ON ace_alumni_penilaian.kd_perusahaan = ace_perusahaan.kd_perusahaan WHERE ace_alumni_penilaian.kd_prodi = '".$kdprodi."' GROUP BY ace_alumni_penilaian.kd_perusahaan";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function getDataAlumni($kdprodi)
	{
		// $sql = "SELECT ace_alumni.*, ace_data_alumni.angkatan FROM `ace_alumni` JOIN ace_data_alumni ON ace_alumni.npm = ace_data_alumni.npm WHERE ace_alumni.kd_prodi = '".$kdprodi."'";
		$sql = "SELECT ace_data_alumni.*, ace_alumni.email, ace_alumni.status, ace_alumni.alamat, ace_alumni.no_tlp FROM `ace_alumni` JOIN ace_data_alumni ON ace_alumni.npm = ace_data_alumni.npm WHERE ace_alumni.kd_prodi = '".$kdprodi."'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function getPenggunaLulusan($kdprodi)
	{
		$sql = "SELECT ace_detail_alumni.nama_perusahaan, ace_detail_alumni.bidang_usaha, ace_detail_alumni.lokasi, ace_detail_alumni.email, COUNT(ace_detail_alumni.npm) AS jml_mhs, ace_alumni.kd_prodi FROM `ace_detail_alumni` LEFT JOIN ace_alumni ON ace_alumni.npm = ace_detail_alumni.npm WHERE ace_alumni.kd_prodi = '".$kdprodi."' GROUP BY nama_perusahaan";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function getDetailPengguna($kdprodi, $perusahaan)
	{
		$sql = "SELECT ace_data_alumni.*, ace_detail_alumni.* FROM `ace_data_alumni` JOIN ace_detail_alumni ON ace_data_alumni.npm = ace_detail_alumni.npm WHERE ace_data_alumni.kd_prodi = '".$kdprodi."' AND ace_detail_alumni.nama_perusahaan = '".$perusahaan."'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function getStatusAlumni($kdprodi, $from = null, $until = null)
	{
		if ($from !== null && $until !== null) {
			$sql = "SELECT status, count(status) AS jumlah FROM `v_tracer_alumni` WHERE kd_prodi = '".$kdprodi."' AND `thn_akademik` BETWEEN '".$from."' AND '".$until."' GROUP BY status";
		} else {
			$sql = "SELECT status, count(status) AS jumlah FROM `v_tracer_alumni` WHERE kd_prodi = '".$kdprodi."' GROUP BY status";
		}
		// $sql = "SELECT status, count(status) AS jumlah FROM `ace_alumni` WHERE kd_prodi = '".$kdprodi."' GROUP BY status";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function getJumlahTracerAngkatan($kdprodi, $from = null, $until = null)
	{
		if ($from !== null && $until !== null) {
			$sql = "SELECT angkatan, count(angkatan) AS jumlah FROM `v_tracer_alumni` WHERE kd_prodi = '".$kdprodi."' AND `thn_akademik` BETWEEN '".$from."' AND '".$until."' GROUP BY angkatan";
		} else {
			$sql = "SELECT angkatan, count(angkatan) AS jumlah FROM `v_tracer_alumni` WHERE kd_prodi = '".$kdprodi."' GROUP BY angkatan";
		}
		// $sql = "SELECT angkatan, count(angkatan) AS jumlah FROM `v_tracer_alumni` WHERE kd_prodi = '".$kdprodi."' GROUP BY angkatan";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function getFilterDataAlumni($table, $kdprodi, $from, $until)
	{
		$sql = "SELECT * FROM `".$table."` WHERE `kd_prodi` = '".$kdprodi."' AND `thn_akademik` BETWEEN '".$from."' AND '".$until."'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	


// INSERT DATA

	function insertData($table, $data)
	{
		$this->db->insert($table, $data);
	}

	function insertAllData($table, $data)
	{
		$this->db->insert_batch($table, $data);
	}

	function insertMultiple($table1, $data1, $table2, $data2)
	{
		$this->db->trans_start();
		$this->db->insert_batch($table1, $data1);
		$this->db->insert($table2, $data2);
		$this->db->trans_complete();
    }
    
    function insertTwoTable($table1, $data1, $table2, $data2)
    {
        $this->db->trans_start();
        $this->db->insert($table1, $data1);
        $this->db->insert($table2, $data2);
		$this->db->trans_complete();
	}
	
	function insertThreeTable($table1, $data1, $table2, $data2, $table3, $data3)
    {
        $this->db->trans_start();
        $this->db->insert($table1, $data1);
		$this->db->insert($table2, $data2);
		$this->db->insert($table3, $data3);
		$this->db->trans_complete();
    }

    function insertUpdateTwoTable($table1, $data1, $table2, $data2, $where)
    {
        $this->db->trans_start();
        $this->db->insert($table1, $data1);
        $this->db->update($table2, $data2, $where);
		$this->db->trans_complete();
    }

// UPDATE DATA

	function updateData($table, $data, $where){
		$this->db->where($where);
		$this->db->update($table, $data);
	}

	function updateMultipleData($data1, $data2, $where)
	{
		$this->db->trans_start();
		$this->db->where($where);
		$this->db->update('mhs_profil', $data1);
		$this->db->where($where);
		$this->db->update('mhs', $data2);
		$this->db->trans_complete();
	}

// DELETE DATA

	function deleteData($table, $where)
	{
		$this->db->where($where);
		$this->db->delete($table);
	}


}


