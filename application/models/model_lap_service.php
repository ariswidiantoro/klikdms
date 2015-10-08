<?php

class Model_Lap_Service extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 
     * @param Date $start
     * @param Date $end
     * @param String $cabang
     * @return null
     */
    public function getAgendaWo($start, $end, $cabang) {
        $query = $this->db->query("SELECT wo_print,wo_km,pel_alamat, wo_nomer, wo_tgl,"
                . " wo_numerator, wo_inv_status,pel_hp,pel_telpon,"
                . " pel_nama, msc_nopol, msc_norangka, msc_nomesin FROM svc_wo LEFT"
                . " JOIN ms_car ON mscid = wo_mscid LEFT JOIN ms_pelanggan ON pelid = wo_pelid "
                . " WHERE wo_tgl BETWEEN '$start'"
                . " AND '$end' AND wo_cbid = '$cabang' ORDER BY wo_nomer");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }

        return null;
    }

    /**
     * 
     * @param Date $tgl
     * @param String $cabang
     * @return null
     */
    public function getWoBelumDitutup($tgl, $cabang) {
        $query = $this->db->query("SELECT wo_print,wo_km,pel_alamat, wo_nomer,kr_nama, wo_tgl,"
                . " wo_numerator, wo_inv_status,pel_hp,pel_telpon,"
                . " pel_nama, msc_nopol, msc_norangka, msc_nomesin FROM svc_wo LEFT"
                . " JOIN ms_car ON mscid = wo_mscid LEFT JOIN ms_pelanggan ON pelid = wo_pelid "
                . " LEFT JOIN ms_karyawan ON krid = wo_sa WHERE wo_tgl <= '$tgl' AND (wo_inv_tgl IS NULL OR (wo_inv_status = 1"
                . " AND wo_inv_tgl > '$tgl') OR wo_inv_status = 0) AND wo_status = 0"
                . "  AND wo_cbid = '$cabang' ORDER BY wo_nomer");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }

        return null;
    }

    public function getFakturBelumDicetak($tgl, $cabang) {
        $query = $this->db->query("SELECT wo_print,wo_km,pel_alamat, wo_nomer,kr_nama, wo_tgl,"
                . " wo_numerator, wo_inv_status,pel_hp,pel_telpon,"
                . " pel_nama, msc_nopol, msc_norangka, msc_nomesin FROM svc_invoice LEFT JOIN svc_wo ON woid = inv_woid LEFT"
                . " JOIN ms_car ON mscid = wo_mscid LEFT JOIN ms_pelanggan ON pelid = wo_pelid "
                . " LEFT JOIN ms_karyawan ON krid = wo_sa WHERE inv_tgl <= '$tgl' AND (inv_tgl_tagihan IS NULL OR (inv_tagihan = 1"
                . " AND inv_tgl_tagihan > '$tgl') OR inv_tagihan = 0)  AND inv_cbid = '$cabang' ORDER BY wo_nomer");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }

        return null;
    }

    /**
     * 
     * @param Date $start
     * @param Datw $end
     * @param String $cabang
     * @return null
     */
    public function getAgendaFakturService($start, $end, $cabang) {
        $query = $this->db->query("SELECT wo_nomer,inv_numerator,inv_print, inv_tgl,wo_tgl, msc_nopol, cty_deskripsi, pel_hp,pel_telpon,"
                . " pel_nama, msc_nopol, msc_norangka, msc_nomesin FROM svc_invoice LEFT JOIN svc_wo ON inv_woid = woid LEFT"
                . " JOIN ms_car ON mscid = wo_mscid LEFT JOIN ms_car_type ON ctyid = msc_ctyid LEFT JOIN ms_pelanggan ON pelid = wo_pelid "
                . " WHERE wo_tgl BETWEEN '$start'"
                . " AND '$end' AND wo_cbid = '$cabang' ORDER BY wo_nomer");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }

        return null;
    }

    /**
     * 
     * @param Date $start
     * @param Date $end
     * @param String $cabang
     * @return null
     */
    public function getStatusWo($start, $end, $cabang) {
        $query = $this->db->query("SELECT clo_status,inv_tagihan, wo_nomer,inv_tgl_tagihan, inv_tgl,wo_tgl, msc_nopol,"
                . " pel_nama, msc_nopol FROM  svc_wo LEFT JOIN svc_invoice ON inv_woid = woid LEFT"
                . " JOIN ms_car ON mscid = wo_mscid LEFT JOIN ms_pelanggan ON pelid = wo_pelid LEFT JOIN svc_clock ON clo_woid = woid "
                . " WHERE wo_tgl BETWEEN '$start'"
                . " AND '$end' AND wo_cbid = '$cabang' ORDER BY wo_nomer");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }

        return null;
    }

    public function getSsdr($param) {

        $start = $param['start'];
        $end = $param['end'];
        $cabang = $param['cbid'];
//        $sort = $param['cbid'];
        $wh = '';
        switch ($param['type']) {
            case 'service':
                $wh = " AND inv_tgl_tagihan BETWEEN '$start' AND '$end' AND inv_status = '0' AND inv_tagihan = 1";
                break;
            case 'batal':
                $wh = " AND inv_tgl_batal BETWEEN '$start' AND '$end' AND inv_status = '1'";
                break;
            case 'outstanding':
                $wh = " AND ((inv_tgl <= '$start' AND inv_tgl_tagihan > '$start' AND inv_tagihan = 1) OR inv_tagihan = 0) AND  AND inv_status = '1'";
                break;
            case 'sa':
                $sa = '';
                if ($param['sa'] != 'all') {
                    $sa = " AND wo_sa = '" . $param['sa'] . "'";
                }
                $wh = " AND inv_tgl_tagihan BETWEEN '$start' AND '$end' $sa AND inv_status = '0' AND inv_tagihan = 1";
                break;
            case 'checker':
                $sa = '';
                if ($param['checker'] != 'all') {
                    $sa = " AND inv_fchecker = '" . $param['checker'] . "'";
                }
                $wh = " AND inv_tgl_tagihan BETWEEN '$start' AND '$end' $sa AND inv_status = '0' AND inv_tagihan = 1";
                break;
            case 'inextern':
                $sa = '';
                if ($param['inextern'] != 'all') {
                    $sa = " AND inv_inextern = '" . $param['inextern'] . "'";
                }
                $wh = " AND inv_tgl_tagihan BETWEEN '$start' AND '$end' $sa AND inv_status = '0' AND inv_tagihan = 1";
                break;
        }
        $query = $this->db->query("SELECT * FROM svc_invoice LEFT JOIN svc_wo ON inv_woid = woid LEFT"
                . " JOIN ms_car ON mscid = wo_mscid LEFT JOIN ms_pelanggan ON pelid = wo_pelid "
                . " LEFT JOIN ms_car_type ON ctyid = msc_ctyid WHERE inv_cbid = '$cabang' $wh ORDER BY wo_nomer");
//        log_message('error', 'AAAA '.$this->db->last_query());
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return null;
    }

}

?>
