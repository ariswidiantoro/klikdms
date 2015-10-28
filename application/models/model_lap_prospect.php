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
                . " pros_cbid = '$cabang' AND pros_tgl BETWEEN '$start' AND '$end' ORDER BY supervisor, a.kr_nama,pros_tgl");
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

    /**
     * 
     * @param type $tahun
     * @param type $cabang
     * @return null
     */
    function getFptBulanan($tahun, $cabang) {
        $sql = $this->db->query("SELECT date_part('month', fpt_tgl) AS bulan, COUNT(fptid) AS jumlah"
                . " FROM pen_fpt WHERE fpt_cbid = '$cabang' AND date_part('year', fpt_tgl) = '$tahun' GROUP BY bulan ORDER BY bulan");
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
     */
    function getTotalProspect($start, $end, $cabang) {
        $sql = $this->db->query("SELECT COUNT(prosid) AS jumlah, pros_salesman, kr_nama,(SELECT kr_nama AS supervisor FROM ms_karyawan WHERE krid = a.kr_atasan)  FROM  "
                . " pros_data LEFT JOIN ms_karyawan a on a.krid = pros_salesman WHERE pros_tgl BETWEEN '$start' AND '$end' AND pros_cbid = '$cabang' GROUP BY pros_salesman, kr_nama,supervisor ORDER BY supervisor, a.kr_nama ");

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
     * @return type
     */
    function getTotalAgenda($start, $end, $cabang) {
        $return = array();
        $sql = $this->db->query("SELECT COUNT(agen_prosid) AS jumlah, pros_salesman FROM  pros_agenda "
                . "LEFT JOIN pros_data ON prosid = agen_prosid WHERE agen_tgl BETWEEN '$start' AND '$end' AND agen_cbid = '$cabang' GROUP BY pros_salesman");

        if ($sql->num_rows() > 0) {
            foreach ($sql->result_array() as $value) {
                $return[$value['pros_salesman']] = $value['jumlah'];
            }
        }
        return $return;
    }

    /**
     * 
     * @param type $start
     * @param type $end
     * @param type $cabang
     * @return type
     */
    function getTotalFollow($start, $end, $cabang) {
        $return = array();
        $sql = $this->db->query("SELECT COUNT(follow_agenid) AS jumlah, pros_salesman FROM pros_follow "
                . " LEFT JOIN  pros_agenda  ON follow_agenid = agenid "
                . " LEFT JOIN pros_data ON prosid = agen_prosid WHERE follow_tgl BETWEEN '$start' AND '$end' AND agen_cbid = '$cabang' GROUP BY pros_salesman");
        if ($sql->num_rows() > 0) {
            foreach ($sql->result_array() as $value) {
                $return[$value['pros_salesman']] = $value['jumlah'];
            }
        }
        return $return;
    }

    /**
     * 
     * @param type $start
     * @param type $end
     * @param type $cabang
     * @return type
     */
    function getTotalFpt($start, $end, $cabang) {
        $return = array();
        $sql = $this->db->query("SELECT COUNT(fptid) AS jumlah, pros_salesman FROM pen_fpt "
                . " LEFT JOIN pros_data ON prosid = fpt_prosid WHERE fpt_tgl BETWEEN '$start' AND '$end' AND fpt_cbid = '$cabang' AND fpt_status = 0 GROUP BY pros_salesman");
        if ($sql->num_rows() > 0) {
            foreach ($sql->result_array() as $value) {
                $return[$value['pros_salesman']] = $value['jumlah'];
            }
        }
        return $return;
    }

    /**
     * 
     * @param type $start
     * @param type $end
     * @param type $cabang
     * @return type
     */
    function getTotalSpk($start, $end, $cabang) {
        $return = array();
        $sql = $this->db->query("SELECT COUNT(spkid) AS jumlah, spk_salesman FROM pen_spk "
                . " WHERE spk_tgl BETWEEN '$start' AND '$end' AND spk_cbid = '$cabang' AND spk_status = 0 GROUP BY spk_salesman");
        if ($sql->num_rows() > 0) {
            foreach ($sql->result_array() as $value) {
                $return[$value['spk_salesman']] = $value['jumlah'];
            }
        }
        return $return;
    }

    /**
     * 
     * @param type $start
     * @param type $end
     * @param type $cabang
     * @return type
     */
    function getTotalFaktur($start, $end, $cabang) {
        $return = array();
        $sql = $this->db->query("SELECT COUNT(fkpid) AS jumlah, spk_salesman FROM pen_faktur LEFT JOIN pen_spk "
                . " ON spkid = fkp_spkid WHERE fkp_tgl BETWEEN '$start' AND '$end' AND fkp_cbid = '$cabang' AND fkp_status = 0 GROUP BY spk_salesman");
        if ($sql->num_rows() > 0) {
            foreach ($sql->result_array() as $value) {
                $return[$value['spk_salesman']] = $value['jumlah'];
            }
        }
        return $return;
    }

}

?>
