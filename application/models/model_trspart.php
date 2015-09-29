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
        $id = sprintf("%08s", $this->getCounter(NUM_TERIMA_BARANG . $tahun));
        $data['trbrid'] = NUM_TERIMA_BARANG . $tahun . $id;
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
    function saveFakturSparepart($data) {
        $result = array();
        $this->db->trans_begin();
        $tahun = substr(date('Y'), 2, 2);
        $id = sprintf("%08s", $this->getCounter(NUM_NOTA_SPAREPART . $tahun));
        $data['notid'] = NUM_NOTA_SPAREPART . $tahun . $id;
        $data['not_nomer'] = NUM_NUMERATOR_SPAREPART . $tahun . sprintf("%06s", $this->getCounterCabang(NUM_NUMERATOR_SPAREPART . $tahun));
        $this->db->INSERT('spa_nota', $data);

        // UPDATE SUPPLY
        $this->db->where('sppid', $data['not_sppid']);
        $this->db->update('spa_supply', array('spp_tagihan' => 1, 'spp_tgl_tagihan' => date('Y-m-d H:i:s'), 'spp_faktur' => 1));

        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            $result['result'] = true;
            $result['kode'] = NUM_NOTA_SPAREPART . $tahun . $id;
            $result['msg'] = sukses("Berhasil menyimpan faktur sparepart");
        } else {
            $this->db->trans_rollback();
            $result['result'] = false;
            $result['kode'] = '';
            $result['msg'] = error("Gagal menyimpan faktur sparepart");
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
        try {
            $this->db->trans_begin();
            $tahun = substr(date('Y'), 2, 2);
            // ambil sppid
            $id = sprintf("%08s", $this->getCounter(NUM_SUPPLY_PK . $tahun));
            $data['sppid'] = NUM_SUPPLY_PK . $tahun . $id;
            // ambil no slip
            $noslip = sprintf("%06s", $this->getCounter(NUM_SUPPLY_NOMER . $tahun));
            $data['spp_noslip'] = NUM_SUPPLY_NOMER . $tahun . $noslip;
            // simpan data supply
            $this->db->INSERT('spa_supply', $data);
            foreach ($detail as $value) {
                $value['dsupp_sppid'] = NUM_SUPPLY_PK . $tahun . $id;
                $insert = $this->db->INSERT('spa_supply_det', $value);
                if (!$insert) {
                    throw new Exception($this->db->_error_message());
                }
            }
            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                $result['result'] = true;
                $result['kode'] = NUM_SUPPLY_PK . $tahun . $id;
                $result['msg'] = sukses("Berhasil menyimpan supply");
            } else {
                $this->db->trans_rollback();
                $result['result'] = false;
                $result['kode'] = "";
                $result['msg'] = error("Gagal menyimpan supply");
            }
        } catch (Exception $ex) {
            $result['result'] = false;
            $result['kode'] = "";
            $result['msg'] = error(str_replace("ERROR: ", "", $ex->getMessage()));
            $this->db->trans_rollback();
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
        $id = sprintf("%08s", $this->getCounter(NUM_RETUR_BELI_SPAREPART . $tahun));
        $data['rbid'] = NUM_RETUR_BELI_SPAREPART . $tahun . $id;
        $this->db->INSERT('spa_retbeli', $data);
        foreach ($detail as $value) {
            $value['detb_rbid'] = NUM_RETUR_BELI_SPAREPART . $tahun . $id;
            $this->db->INSERT('spa_retbeli_det', $value);
            $this->db->query("UPDATE spa_trbr_det SET dtr_qty_retur = dtr_qty_retur + " .
                    $value['detb_qty'] . " WHERE dtr_trbrid = '" . $data['rb_trbrid'] .
                    "' AND dtr_inveid = '" . $value['detb_inveid'] . "'");
        }
        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            $result['result'] = true;
            $result['kode'] = NUM_RETUR_BELI_SPAREPART . $tahun . $id;
            $result['msg'] = sukses("Berhasil menyimpan retur pembelian");
        } else {
            $this->db->trans_rollback();
            $result['result'] = false;
            $result['kode'] = '';
            $result['msg'] = error("Gagal menyimpan retur pembelian");
        }
        return $result;
    }

    /**
     * 
     * @param array $data
     * @param type $detail
     * @return type
     */
    function saveReturPenjualan($data, $detail, $sppid) {
        $result = array();
        $this->db->trans_begin();
        $tahun = substr(date('Y'), 2, 2);
        $id = sprintf("%08s", $this->getCounter(NUM_RETUR_JUAL_SPAREPART . $tahun));
        $data['rjid'] = NUM_RETUR_JUAL_SPAREPART . $tahun . $id;
        $this->db->INSERT('spa_retjual', $data);
        foreach ($detail as $value) {
            $value['det_rjid'] = NUM_RETUR_JUAL_SPAREPART . $tahun . $id;
            $this->db->INSERT('spa_retjual_det', $value);
            $this->db->query("UPDATE spa_supply_det SET dsupp_qty_retur = dsupp_qty_retur + " .
                    $value['det_qty'] . " WHERE dsupp_sppid = '$sppid' AND dsupp_inveid = '" . $value['det_inveid'] . "'");
        }
        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            $result['result'] = true;
            $result['kode'] = NUM_RETUR_JUAL_SPAREPART . $tahun . $id;
            $result['msg'] = sukses("Berhasil menyimpan retur penjualan");
        } else {
            $this->db->trans_rollback();
            $result['result'] = false;
            $result['kode'] = '';
            $result['msg'] = error("Gagal menyimpan retur penjualan");
        }
        return $result;
    }

    /**
     * 
     * @param string $data
     * @param type $detail
     * @return type
     * @throws Exception
     */
    function saveAdjustmentStock($data, $detail) {
        $result = array();
        try {
            $this->db->trans_begin();
            $tahun = substr(date('Y'), 2, 2);
            $id = sprintf("%08s", $this->getCounter(NUM_ADJUSTMENT_STOCK . $tahun));
            $data['adjid'] = NUM_ADJUSTMENT_STOCK . $tahun . $id;
            $this->db->INSERT('spa_adjustment', $data);
            foreach ($detail as $value) {
                $value['dadj_adjid'] = NUM_ADJUSTMENT_STOCK . $tahun . $id;
                $insert = $this->db->INSERT('spa_adjustment_det', $value);
                if (!$insert) {
                    throw new Exception($this->db->_error_message());
                }
            }
            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                $result['result'] = true;
                $result['kode'] = NUM_ADJUSTMENT_STOCK . $tahun . $id;
                $result['msg'] = sukses("Berhasil menyimpan adjustment stock");
            } else {
                $this->db->trans_rollback();
                $result['result'] = false;
                $result['kode'] = '';
                $result['msg'] = error("Gagal menyimpan adjustment stock");
            }
        } catch (Exception $ex) {
            $result['result'] = false;
            $result['kode'] = "";
            $result['msg'] = error(str_replace("ERROR: ", "", $ex->getMessage()));
            $this->db->trans_rollback();
        }
        return $result;
    }

    /**
     * 
     * @param type $trbrid
     * @return null
     */
    function getFakturTerima($trbrid) {
        $sql = $this->db->query("SELECT trbr_faktur,trbr_tgl,trbr_pay_method,trbr_supid,trbr_kredit_term,sup_nama,trbr_inc_pajak,trbr_total FROM spa_trbr LEFT JOIN ms_supplier ON supid = trbr_supid WHERE trbrid = '$trbrid'");
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
    function getReturBeli($rbid) {
        $sql = $this->db->query("SELECT rb_alasan,rb_total,trbr_faktur,rb_tgl,trbr_pay_method,trbr_supid,trbr_credit_term,sup_nama FROM spa_retbeli LEFT JOIN spa_trbr ON rb_trbrid = trbrid LEFT JOIN ms_supplier ON supid = trbr_supid WHERE rbid = '$rbid'");
        if ($sql->num_rows() > 0) {
            return $sql->row_array();
        }
        return null;
    }

    /**
     * 
     * @param type $rjid
     * @return null
     */
    function getReturJual($rjid) {
        $sql = $this->db->query("SELECT rj_alasan,rj_total,not_nomer,rj_tgl,pel_nama,rjid FROM spa_retjual"
                . " LEFT JOIN spa_nota ON rj_notid = notid LEFT JOIN spa_supply ON sppid = not_sppid LEFT JOIN ms_pelanggan"
                . " ON pelid = spp_pelid WHERE rjid = '$rjid'");
        if ($sql->num_rows() > 0) {
            return $sql->row_array();
        }
        return null;
    }

    /**
     * 
     * @param String $sppid
     * @return null
     */
    function getSupplySlip($sppid) {
        $sql = $this->db->query("SELECT sppid,spp_noslip,spp_print,spp_status,spp_tgl,spp_cetak_harga,spp_tgl_batal, spp_total,pel_nama, wo_nomer "
                . "FROM spa_supply LEFT JOIN svc_wo ON woid = spp_woid LEFT JOIN "
                . "ms_pelanggan ON pelid = spp_pelid WHERE sppid = '$sppid'");
        if ($sql->num_rows() > 0) {
            return $sql->row_array();
        }
        return null;
    }

    /**
     * 
     * @param type $adjid
     * @return null
     */
    function getAdjustmentStock($adjid) {
        $sql = $this->db->query("SELECT * FROM spa_adjustment WHERE adjid = '$adjid'");
        if ($sql->num_rows() > 0) {
            return $sql->row_array();
        }
        return null;
    }

    /**
     * 
     * @param String $sppid
     * @return null
     */
    function getFakturSparepart($notid) {
        $sql = $this->db->query("SELECT not_total, not_tgl, pel_nama,not_pay_method,not_print,not_uang_muka, not_nomer,not_tampil_ppn "
                . "FROM spa_supply LEFT JOIN spa_nota ON not_sppid = sppid LEFT JOIN "
                . "ms_pelanggan ON pelid = spp_pelid WHERE notid = '$notid'");
        if ($sql->num_rows() > 0) {
            return $sql->row_array();
        }
        return null;
    }

    /**
     * 
     * @param String $sppid
     * @return null
     */
    function getSupplySlipDetail($sppid) {
        $sql = $this->db->query("SELECT dsupp_qty,inve_kode,inve_nama, dsupp_harga,"
                . " dsupp_diskon,dsupp_hpp,dsupp_subtotal,rak_deskripsi "
                . " FROM spa_supply_det LEFT JOIN spa_inventory ON inveid = dsupp_inveid"
                . " LEFT JOIN spa_rak ON rakid = inve_rakid WHERE dsupp_sppid = '$sppid'");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }

    /**
     * 
     * @param String $sppid
     * @return null
     */
    function getAdjustmentStockDetail($adjid) {
        $sql = $this->db->query("SELECT dadj_plus,dadj_minus,dadj_hpp,dadj_subtotal_hpp, inve_nama,"
                . " inve_kode FROM spa_adjustment_det LEFT JOIN spa_inventory ON inveid = dadj_inveid"
                . " WHERE dadj_adjid = '$adjid'");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }

    /**
     * 
     * @param type $sppid
     * @return null
     */
    function getFakturSparepartDetail($notid) {
        $sql = $this->db->query("SELECT dsupp_qty,inve_kode,inve_nama, dsupp_harga,"
                . " dsupp_diskon,dsupp_hpp,dsupp_subtotal "
                . " FROM spa_supply_det LEFT JOIN spa_inventory ON inveid = dsupp_inveid"
                . " LEFT JOIN spa_nota ON not_sppid = dsupp_sppid WHERE notid = '$notid' ORDER BY inve_kode");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }

    /**
     * 
     * @param String $woNomer
     * @return null
     */
    function getSupplySlipDetailByWo($woNomer) {
        $sql = $this->db->query("SELECT dsupp_qty,inve_kode,inve_nama, dsupp_harga,"
                . " dsupp_diskon,dsupp_hpp,dsupp_subtotal,spp_jenis "
                . " FROM spa_supply_det LEFT JOIN spa_inventory ON inveid = dsupp_inveid"
                . " LEFT JOIN spa_rak ON rakid = inve_rakid LEFT JOIN spa_supply"
                . " ON sppid = dsupp_sppid LEFT JOIN svc_wo ON woid = spp_woid "
                . "WHERE wo_nomer = '$woNomer' AND wo_cbid = '" . ses_cabang . "' AND spp_status = 0 ORDER BY spp_jenis,inve_kode ");
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
    function getFakturTerimaDetail($trbrid) {
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
    function getReturBeliDetail($trbrid) {
        $sql = $this->db->query("SELECT inve_kode, inve_nama,detb_inveid, detb_qty,"
                . "detb_harga,detb_diskon,detb_subtotal FROM spa_retbeli_det LEFT JOIN"
                . " spa_inventory ON inveid = detb_inveid WHERE detb_rbid = '$trbrid'");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }

    function getReturJualDetail($rjid) {
        $sql = $this->db->query("SELECT inve_kode, inve_nama,det_inveid, det_qty,"
                . "det_harga,det_diskon,det_subtotal FROM spa_retjual_det LEFT JOIN"
                . " spa_inventory ON inveid = det_inveid WHERE det_rjid = '$rjid'");
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

    /**
     * 
     * @param type $kode
     * @return null
     */
    public function getFakturJualAutoComplete($kode) {
        $sql = $this->db->query("SELECT not_nomer,notid, not_sppid, pelid, pel_nama "
                . "FROM spa_nota LEFT JOIN spa_supply ON not_sppid = sppid LEFT JOIN ms_pelanggan ON pelid = spp_pelid  "
                . "WHERE not_cbid = '" . ses_cabang . "' AND not_nomer LIKE '%$kode%' ORDER BY not_nomer LIMIT 10");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }

    /**
     * 
     * @param type $kode
     * @return null
     */
    public function getSupplyAutoComplete($kode) {
        $sql = $this->db->query("SELECT spp_noslip,pel_nama "
                . "FROM spa_supply  LEFT JOIN ms_pelanggan ON pelid = spp_pelid WHERE spp_cbid = '" . ses_cabang . "' AND spp_status = 0"
                . " AND spp_faktur = 0 AND spp_noslip LIKE '$kode%' AND spp_jenis = 'ps' "
                . "  ORDER BY spp_noslip LIMIT 20");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }

    public function getDataSupplyPartShop($kode) {
        $sql = $this->db->query("SELECT spp_noslip,sppid,pel_nama,spp_inextern,spp_pay_method,spp_total,spp_kredit_term "
                . "FROM spa_supply LEFT JOIN ms_pelanggan ON pelid = spp_pelid"
                . " WHERE spp_cbid = '" . ses_cabang . "' AND spp_noslip = '$kode'");
        if ($sql->num_rows() > 0) {
            return $sql->row_array();
        }
        return null;
    }

}

?>
