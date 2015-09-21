<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Model_Trservice extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Get data wo berdasarkan nomor wo
     * @param String $woNomer Nomor work order
     * @return array of work order
     */
    public function getWo($woNomer) {
        $sql = $this->db->query("SELECT * FROM svc_wo WHERE wo_nomer = '$woNomer' AND wo_cbid = '" . ses_cabang . "'");
        if ($sql->num_rows() > 0) {
            return $sql->row_array();
        }
        return null;
    }

    /**
     * Get data wo berdasarkan nomor wo
     * @param String $woNomer Nomor work order
     * @return array of work order
     */
    public function getNopol($nopol) {
        $sql = $this->db->query("SELECT msc_nopol, mscid,msc_norangka  "
                . " FROM ms_car WHERE msc_nopol LIKE '$nopol%' AND msc_cbid = '"
                . ses_cabang . "' ORDER BY msc_nopol LIMIT 20");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }

    /**
     * 
     * @param type $data
     * @return null
     */
    public function getFlateRateAuto($data, $type) {
        if (!empty($data)) {
            $sql = $this->db->query("SELECT flat_kode, flat_deskripsi,flatid  "
                    . " FROM svc_frate WHERE (flat_kode LIKE '%$data%' OR flat_deskripsi LIKE '%$data%' ) AND flat_cbid = '"
                    . ses_cabang . "' AND flat_type = $type ORDER BY flat_kode LIMIT 20");
//            log_message('error', 'AAAAA '.$this->db->last_query());
            if ($sql->num_rows() > 0) {
                return $sql->result_array();
            }
        }

        return null;
    }

    /**
     * 
     * @param type $kode
     * @return null
     */
    public function getDataFlateRate($kode) {
        $sql = $this->db->query("SELECT * FROM svc_frate WHERE  flat_kode = '$kode' AND flat_cbid = '"
                . ses_cabang . "'");
        if ($sql->num_rows() > 0) {
            return $sql->row_array();
        }
        return null;
    }

    public function getDataKendaraan($nopol) {
        $sql = $this->db->query("SELECT msc_nopol, mscid,msc_norangka,pelid,pel_nama,model_deskripsi,merk_deskripsi   "
                . " FROM ms_car LEFT JOIN ms_car_type ON ctyid = msc_ctyid LEFT JOIN ms_car_model ON modelid = cty_modelid "
                . "LEFT JOIN ms_car_merk ON merkid = model_merkid LEFT JOIN ms_pelanggan ON pelid = msc_pelid WHERE msc_nopol = '$nopol' AND msc_cbid = '"
                . ses_cabang . "'");
        if ($sql->num_rows() > 0) {
            return $sql->row_array();
        }
        return null;
    }

    public function getWoJenis() {
        $sql = $this->db->query("SELECT * FROM svc_wo_jenis WHERE woj_cbid = '" . ses_cabang . "' ORDER BY woj_urut");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }

    public function getStall() {
        $sql = $this->db->query("SELECT * FROM svc_stall WHERE stall_cbid = '" . ses_cabang . "' ORDER BY stall_nomer");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }

}

?>
