<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Model_Lap_Prospect extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 
     * @param type $start
     * @param type $end
     * @param type $cabang
     * @return null
     */
    function getRincianProspect($start, $end, $cabang) {
        $sql = $this->db->query("SELECT pros_tgl,kr_nama,pros_type,pros_nama,pros_alamat,pros_hp,bisnis_deskripsi,smbinfo_deskripsi, (SELECT kr_nama AS supervisor FROM ms_karyawan WHERE krid = a.kr_atasan)"
                . " FROM pros_data LEFT JOIN ms_karyawan a on a.krid = pros_salesman "
                . " LEFT JOIN ms_sumber_info ON smbinfoid = pros_sumber_info "
                . " LEFT JOIN ms_bisnis ON bisnisid = pros_bisnis WHERE"
                . " pros_cbid = '$cabang' AND pros_tgl BETWEEN '$start' AND '$end' ORDER BY supervisor, a.kr_nama");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }

    /**
     * 
     * @param type $start
     * @param type $end
     * @param type $cabang
     * @param type $status
     * @return null
     */
    function getRincianFpt($start, $end, $cabang, $status) {
        $wh = "";
        if ($status != '0') {
            $wh = " AND fpt_approve = $status ";
        }
        $sql = $this->db->query("SELECT * "
                . " FROM pen_fpt LEFT JOIN pros_data ON prosid = fpt_prosid LEFT JOIN ms_karyawan a on a.krid = pros_salesman "
                . " LEFT JOIN ms_car_type ON ctyid = fpt_ctyid LEFT JOIN ms_car_merk ON merkid = fpt_merkid LEFT JOIN ms_warna ON fpt_warnaid = warnaid  WHERE"
                . " fpt_cbid = '$cabang' AND fpt_tgl BETWEEN '$start' AND '$end' $wh ORDER BY fpt_tgl");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }

    /**
     * 
     * @param type $start
     * @param type $end
     * @param type $cabang
     * @return null
     */
    function getProspectHarian($start, $end, $cabang) {
        $sql = $this->db->query("select pros_tgl, COUNT(prosid) AS jumlah, COUNT(DISTINCT pros_salesman)"
                . " AS salesman FROM pros_data WHERE pros_cbid = '$cabang' AND pros_tgl BETWEEN '$start' AND '$end' GROUP BY pros_tgl ORDER BY pros_tgl");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }

    /**
     * 
     * @param type $tahun
     * @param type $cabang
     * @return null
     */
    function getProspectBulanan($tahun, $cabang) {
        $sql = $this->db->query("SELECT date_part('month', pros_tgl) AS bulan, COUNT(prosid) AS jumlah, COUNT(DISTINCT pros_salesman)"
                . " AS salesman FROM pros_data WHERE pros_cbid = '$cabang' AND date_part('year', pros_tgl) = '$tahun' GROUP BY bulan ORDER BY bulan");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }

    function getFptBulanan($tahun, $cabang) {
        $sql = $this->db->query("SELECT date_part('month', fpt_tgl) AS bulan, COUNT(fptid) AS jumlah"
                . " FROM pen_fpt WHERE fpt_cbid = '$cabang' AND date_part('year', fpt_tgl) = '$tahun' GROUP BY bulan ORDER BY bulan");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }

}

?>
