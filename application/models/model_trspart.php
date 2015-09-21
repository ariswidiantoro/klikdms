<?php

class Model_Trspart extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 
     * @param array $data
     * @param type $detail
     * @return type
     */
    function savePenerimaanBarang($data, $detail) {
        $result = array();
        $this->db->trans_begin();
        $tahun = substr(date('Y'), 2, 2);
        $id = sprintf("%08s", $this->getCounter("TB" . $tahun));
        $data['trbrid'] = "TB" . $tahun . $id;
        $this->db->INSERT('spa_trbr', $data);
        foreach ($detail as $value) {
            $value['dtr_trbrid'] = "TB" . $tahun . $id;
            $this->db->INSERT('spa_trbr_det', $value);
        }
        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            $result['result'] = true;
            $result['kode'] = "TB" . $tahun . $id;
            $result['msg'] = sukses("Berhasil menyimpan penerimaan barang");
        } else {
            $this->db->trans_rollback();
            $result['result'] = false;
            $result['kode'] = "TB" . $tahun . $id;
            $result['msg'] = error("Gagal menyimpan penerimaan barang");
        }
        return $result;
    }

    /**
     * 
     * @param array $data
     * @param type $detail
     * @return type
     */
    function saveSupplySlip($data, $detail) {
        $result = array();
        $this->db->trans_begin();
        $tahun = substr(date('Y'), 2, 2);
        // ambil sppid
        $id = sprintf("%08s", $this->getCounter("SS" . $tahun));
        $data['sppid'] = "SS" . $tahun . $id;
        // ambil no slip
        $noslip = sprintf("%06s", $this->getCounter("SP" . $tahun));
        $data['spa_noslip'] = "SP" . $tahun . $noslip;
        // simpan data supply
        $this->db->INSERT('spa_supply', $data);
        foreach ($detail as $value) {
            $value['dsupp_sppid'] = "SS" . $tahun . $id;
            $this->db->INSERT('spa_supply_det', $value);
        }
        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            $result['result'] = true;
            $result['kode'] = "SS" . $tahun . $id;
            $result['msg'] = sukses("Berhasil menyimpan supply");
        } else {
            $this->db->trans_rollback();
            $result['result'] = false;
            $result['kode'] = "";
            $result['msg'] = error("Gagal menyimpan supply");
        }
        return $result;
    }

    /**
     * 
     * @param array $data
     * @param type $detail
     * @return type
     */
    function saveReturPembelian($data, $detail) {
        $result = array();
        $this->db->trans_begin();
        $tahun = substr(date('Y'), 2, 2);
        $id = sprintf("%08s", $this->getCounter("RB" . $tahun));
        $data['rbid'] = "RB" . $tahun . $id;
        $this->db->INSERT('spa_retbeli', $data);
        foreach ($detail as $value) {
            $value['detb_rbid'] = "RB" . $tahun . $id;
            $this->db->INSERT('spa_retbeli_det', $value);
            $this->db->query("UPDATE spa_trbr_det SET dtr_qty_retur = dtr_qty_retur + " .
                    $value['detb_qty'] . " WHERE dtr_trbrid = '" . $data['rb_trbrid'] .
                    "' AND dtr_inveid = '" . $value['detb_inveid'] . "'");
        }
        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            $result['result'] = true;
            $result['kode'] = "RB" . $tahun . $id;
            $result['msg'] = sukses("Berhasil menyimpan retur pembelian");
        } else {
            $this->db->trans_rollback();
            $result['result'] = false;
            $result['kode'] = "RB" . $tahun . $id;
            $result['msg'] = error("Gagal menyimpan retur pembelian");
        }
        return $result;
    }

    /**
     * 
     * @param type $trbrid
     * @return null
     */
    function dataFakturTerima($trbrid) {
        $sql = $this->db->query("SELECT trbr_faktur,trbr_tgl,trbr_pay_method,trbr_supid,trbr_credit_term,sup_nama,trbr_inc_pajak FROM spa_trbr LEFT JOIN ms_supplier ON supid = trbr_supid WHERE trbrid = '$trbrid'");
        if ($sql->num_rows() > 0) {
            return $sql->row_array();
        }
        return null;
    }

    /**
     * 
     * @param type $trbrid
     * @return null
     */
    function dataReturBeli($trbrid) {
        $sql = $this->db->query("SELECT rb_alasan,rb_total,trbr_faktur,rb_tgl,trbr_pay_method,trbr_supid,trbr_credit_term,sup_nama FROM spa_retbeli LEFT JOIN spa_trbr ON rb_trbrid = trbrid LEFT JOIN ms_supplier ON supid = trbr_supid WHERE rbid = '$trbrid'");
        if ($sql->num_rows() > 0) {
            return $sql->row_array();
        }
        return null;
    }

    /**
     * 
     * @param type $trbrid
     * @return null
     */
    function dataFakturTerimaDetail($trbrid) {
        $sql = $this->db->query("SELECT inve_kode, inve_nama, dtr_qty,dtr_harga,dtr_diskon,"
                . " dtr_subtotal FROM spa_trbr_det LEFT JOIN spa_inventory ON inveid = dtr_inveid"
                . " WHERE dtr_trbrid = '$trbrid'");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }

    /**
     * 
     * @param type $trbrid
     * @return null
     */
    function dataReturBeliDetail($trbrid) {
        $sql = $this->db->query("SELECT inve_kode, inve_nama,detb_inveid, detb_qty,"
                . "detb_harga,detb_diskon,detb_subtotal FROM spa_retbeli_det LEFT JOIN"
                . " spa_inventory ON inveid = detb_inveid WHERE detb_rbid = '$trbrid'");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }

    /**
     * Function ini digunakan untuk mengambil rol
     * @param type $data
     * @return boolean
     */
    public function getFakturTerimaAutoComplete($kode) {
        $sql = $this->db->query("SELECT trbrid, trbr_faktur, trbr_supid, sup_nama "
                . "FROM spa_trbr LEFT JOIN ms_supplier ON supid = trbr_supid  "
                . "WHERE trbr_cbid = '" . ses_cabang . "' AND trbr_faktur LIKE '%$kode%' ORDER BY trbr_faktur LIMIT 10");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }

}

?>