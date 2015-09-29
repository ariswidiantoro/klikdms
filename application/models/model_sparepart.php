<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Model_Sparepart extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    function getAllGudang($start, $limit, $sidx, $sord, $where) {
        $this->db->select('*');
        $this->db->limit($limit);
        if ($where != NULL)
            $this->db->where($where, NULL, FALSE);
        $this->db->where('gdg_cbid', ses_cabang);
        $this->db->order_by($sidx, $sord);
        $query = $this->db->get('spa_gudang', $limit, $start);
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return null;
    }

    public function getTotalGudang($where) {
        $wh = "WHERE gdg_cbid = '" . ses_cabang . "'";
        if ($where != NULL)
            $wh = " AND " . $where;
        $sql = $this->db->query("SELECT COUNT(*) AS total FROM spa_gudang $wh");
        return $sql->row()->total;
    }

    public function getTotalGradeToko($where) {
        $wh = "WHERE grad_cbid = '" . ses_cabang . "'";
        if ($where != NULL)
            $wh = " AND " . $where;
        $sql = $this->db->query("SELECT COUNT(*) AS total FROM spa_grade "
                . " LEFT JOIN ms_pelanggan ON pelid = grad_pelid $wh");
        return $sql->row()->total;
    }

    /**
     * 
     * @param type $data
     * @return boolean
     */
    function saveGudang($data) {
        $this->db->trans_begin();
        $this->db->INSERT('spa_gudang', $data);
        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            return true;
        } else {
            $this->db->trans_rollback();
            return false;
        }
        return false;
    }

    /**
     * 
     * @param type $data
     * @return boolean
     */
    function updateGudang($data) {
        $this->db->trans_begin();
        $this->db->where('gdgid', $data['gdgid']);
        $this->db->update('spa_gudang', $data);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    /**
     * 
     * @param type $id
     * @return null
     */
    public function getGudangById($id) {
        $sql = $this->db->query("SELECT * FROM spa_gudang WHERE gdgid = '$id'");
        if ($sql->num_rows() > 0) {
            return $sql->row_array();
        }
        return null;
    }

    /**
     * 
     * @param type $id
     * @return null
     */
    public function getGradeById($id) {
        $sql = $this->db->query("SELECT * FROM spa_grade LEFT JOIN ms_pelanggan ON"
                . " pelid = grad_pelid  WHERE gradid = '$id'");
        if ($sql->num_rows() > 0) {
            return $sql->row_array();
        }
        return null;
    }

    /**
     * 
     * @param type $id
     * @return null
     */
    public function getIdInventory() {
        $data = array();
        $sql = $this->db->query("SELECT * FROM spa_inventory WHERE inve_cbid = '" . ses_cabang . "'");
        if ($sql->num_rows() > 0) {
            foreach ($sql->result_array() as $value) {
                $data[$value['inve_kode']] = $value['inveid'];
            }
        }
        return $data;
    }

    public function getGudang() {
        $sql = $this->db->query("SELECT * FROM spa_gudang WHERE gdg_cbid = '" . ses_cabang . "' ORDER BY gdg_deskripsi");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }

    function getAllRak($start, $limit, $sidx, $sord, $where) {
        $this->db->select('*');
        $this->db->limit($limit);
        if ($where != NULL)
            $this->db->where($where, NULL, FALSE);
        $this->db->where('rak_cbid', ses_cabang);
        $this->db->from('spa_rak');
        $this->db->join('spa_gudang', 'rak_gdgid = gdgid', 'LEFT');
        $this->db->order_by($sidx, $sord);
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return null;
    }

    function getAllGradeToko($start, $limit, $sidx, $sord, $where) {
        $this->db->select('pel_nama,gradid,grad_1,grad_2,pel_alamat,grad_3, grad_status');
        $this->db->limit($limit);
        if ($where != NULL)
            $this->db->where($where, NULL, FALSE);
        $this->db->where('grad_cbid', ses_cabang);
        $this->db->from('spa_grade');
        $this->db->join('ms_pelanggan', 'pelid = grad_pelid', 'LEFT');
        $this->db->order_by($sidx, $sord);
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return null;
    }

    function getAllInventory($start, $limit, $sidx, $sord, $where) {
        $this->db->select('*');
        $this->db->limit($limit);
        if ($where != NULL)
            $this->db->where($where, NULL, FALSE);
        $this->db->where('inve_cbid', ses_cabang);
        $this->db->from('spa_inventory');
        $this->db->order_by($sidx, $sord);
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return null;
    }

    function getAllSpesialItem($start, $limit, $sidx, $sord, $where) {
        $this->db->select('*');
        $this->db->limit($limit);
        if ($where != NULL)
            $this->db->where($where, NULL, FALSE);
        $this->db->where('spe_cbid', ses_cabang);
        $this->db->from('spa_spesial');
        $this->db->join('spa_inventory', 'inveid = spe_inveid', 'LEFT');
        $this->db->order_by($sidx, $sord);
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return null;
    }

    public function getTotalRak($where) {
        $wh = "WHERE rak_cbid = '" . ses_cabang . "'";
        if ($where != NULL)
            $wh = " AND " . $where;
        $sql = $this->db->query("SELECT COUNT(rakid) AS total FROM spa_rak LEFT JOIN "
                . "spa_gudang ON gdgid = rak_gdgid $wh");
        return $sql->row()->total;
    }

    public function getTotalInventory($where) {
        $wh = "WHERE inve_cbid = '" . ses_cabang . "'";
        if ($where != NULL)
            $wh = " AND " . $where;
        $sql = $this->db->query("SELECT COUNT(inveid) AS total FROM spa_inventory $wh");
        return $sql->row()->total;
    }

    /**
     * 
     * @param type $where
     * @return type
     */
    public function getTotalSpesialItem($where) {
        $wh = "WHERE spe_cbid = '" . ses_cabang . "'";
        if ($where != NULL)
            $wh = " AND " . $where;
        $sql = $this->db->query("SELECT COUNT(speid) AS total FROM spa_spesial LEFT JOIN spa_inventory ON inveid = spe_inveid $wh");
        return $sql->row()->total;
    }

    /**
     * 
     * @param type $data
     * @return boolean
     */
    function saveRak($data) {
        $this->db->trans_begin();
        $this->db->INSERT('spa_rak', $data);
        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            return true;
        } else {
            $this->db->trans_rollback();
            return false;
        }
        return false;
    }

    /**
     * 
     * @param type $data
     * @return boolean
     */
    function saveSpesialItem($data) {
        $this->db->trans_begin();
        $this->db->query("DELETE FROM spa_spesial WHERE spe_cbid = '" . ses_cabang . "'");
        foreach ($data as $value) {
            $this->db->insert('spa_spesial', $value);
        }
        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            return true;
        } else {
            $this->db->trans_rollback();
            return false;
        }
        return false;
    }

    /**
     * 
     * @param type $data
     * @return boolean
     */
    function savePriceList($data) {
        $this->db->trans_begin();
        $this->db->query("DELETE FROM spa_pricelist WHERE pl_cbid = '" . ses_cabang . "'");
        foreach ($data as $value) {
            $this->db->insert('spa_pricelist', $value);
        }
        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            return true;
        } else {
            $this->db->trans_rollback();
            return false;
        }
        return false;
    }

    /**
     * Function ini digunakan untuk mengambil rol
     * @param type $data
     * @return boolean
     */
    public function getSupplierByNama($nama, $cbid) {
        $sql = $this->db->query("SELECT * FROM ms_supplier WHERE sup_cbid = '$cbid' AND sup_nama LIKE '%" . strtoupper($nama) . "%' ORDER BY sup_nama LIMIT 40");
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
    public function getInventoryAutoComplete($nama, $jenis) {
        $wh = "";
        if ($jenis != 'ps') {
            $wh = "AND inve_jenis = '$jenis'";
        }
        $sql = $this->db->query("SELECT inve_kode, inve_nama FROM spa_inventory WHERE inve_cbid = '" . ses_cabang . "' $wh AND (inve_kode LIKE '%" . strtoupper($nama) . "%' OR inve_nama LIKE '%" . strtoupper($nama) . "%') ORDER BY inve_kode LIMIT 30");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }

    public function getBarangPenjualanAutoComplete($nama, $sppid) {
        $sql = $this->db->query("SELECT inve_kode, inve_nama FROM spa_supply_det LEFT JOIN"
                . "  spa_inventory ON inveid = dsupp_inveid WHERE dsupp_sppid = '$sppid'"
                . " AND (inve_kode LIKE '%" . strtoupper($nama) . "%')"
                . " ORDER BY inve_kode LIMIT 30");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }

    /**
     * 
     * @param type $data
     * @return boolean
     */
    function hapusSpesialItem($id) {
        $this->db->trans_begin();
        $this->db->query("DELETE FROM spa_spesial WHERE speid = '$id'");
        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            return true;
        } else {
            $this->db->trans_rollback();
            return false;
        }
        return false;
    }

    /**
     * 
     * @param type $data
     * @return boolean
     */
    function saveInventory($data) {
        $this->db->trans_begin();
        $tahun = substr(date('Y'), 2, 2);
        $id = sprintf("%08s", $this->getCounter("IN" . $tahun));
        $data['inveid'] = "IN" . $tahun . $id;
        $this->db->INSERT('spa_inventory', $data);
        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            return true;
        } else {
            $this->db->trans_rollback();
            return false;
        }
        return false;
    }

    /**
     * 
     * @param type $data
     * @return boolean
     */
    function saveGradeToko($data) {
        $this->db->trans_begin();
        $tahun = substr(date('Y'), 2, 2);
        $id = sprintf("%06s", $this->getCounter("GD" . $tahun));
        $data['gradid'] = "GD" . $tahun . $id;
        $this->db->INSERT('spa_grade', $data);
        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            return true;
        } else {
            $this->db->trans_rollback();
            return false;
        }
        return false;
    }

    /**
     * 
     * @param type $data
     * @return boolean
     */
    function updateRak($data) {
        $this->db->trans_begin();
        $this->db->where('rakid', $data['rakid']);
        $this->db->update('spa_rak', $data);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    /**
     * 
     * @param type $data
     * @return boolean
     */
    function updateGradeToko($data) {
        $this->db->trans_begin();
        $this->db->where('gradid', $data['gradid']);
        $this->db->update('spa_grade', $data);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    /**
     * 
     * @param type $role
     * @return boolean
     */
    function hapusGrade($data) {
        $this->db->query("UPDATE spa_grade SET grad_status = 1 WHERE gradid = '$data'");
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        return false;
    }

    /**
     * 
     * @param type $data
     * @return boolean
     */
    function updateInventory($data) {
        $this->db->trans_begin();
        $this->db->where('inveid', $data['inveid']);
        $this->db->update('spa_inventory', $data);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    /**
     * 
     * @param type $data
     * @return boolean
     */
    function updateSpesialItem($data) {
        $this->db->trans_begin();
        $this->db->where('speid', $data['speid']);
        $this->db->update('spa_spesial', $data);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    /**
     * 
     * @param type $id
     * @return null
     */
    public function getRakByid($id) {
        $sql = $this->db->query("SELECT * FROM spa_rak WHERE rakid = '$id'");
        if ($sql->num_rows() > 0) {
            return $sql->row_array();
        }
        return null;
    }

    /**
     * 
     * @param type $id
     * @return null
     */
    public function getInventoryById($id) {
        $sql = $this->db->query("SELECT * FROM spa_inventory LEFT JOIN spa_rak ON rakid = inve_rakid WHERE inveid = '$id'");
        if ($sql->num_rows() > 0) {
            return $sql->row_array();
        }
        return null;
    }

    /**
     * 
     * @param type $id
     * @return null
     */
    public function getInventoryByKodeBarang($kodeBarang, $jenis) {
        $wh = "";
        if ($jenis != 'ps') {
            $wh = "AND inve_jenis = '$jenis'";
        }
        $sql = $this->db->query("SELECT inve_kode, inve_nama, inve_qty, inve_harga, inve_hpp,inve_harga_beli, inveid FROM spa_inventory WHERE inve_kode = '$kodeBarang' $wh AND inve_cbid = '" . ses_cabang . "'");
        if ($sql->num_rows() > 0) {
            return $sql->row_array();
        }
        return null;
    }

    /**
     * 
     * @param type $id
     * @return null
     */
    public function getInventoryByKodeBarangSupply($kodeBarang, $jenis, $pelid) {
        $wh = "";
        $result = array();
        if ($jenis != 'ps') {
            $wh = "AND inve_jenis = '$jenis'";
            $sql = $this->db->query("SELECT inve_kode, inve_nama, inve_qty, inve_harga, inve_hpp,inve_harga_beli, inveid, '1' AS spesial FROM spa_inventory WHERE inve_kode = '$kodeBarang' $wh AND inve_cbid = '" . ses_cabang . "'");
            if ($sql->num_rows() > 0) {
                $result = $sql->row_array();
            }
        } else {
            $sql = $this->db->query("SELECT inve_kode, inve_nama, inve_qty, inve_harga, inve_hpp,inve_harga_beli, inveid, '1' AS spesial FROM spa_inventory WHERE inve_kode = '$kodeBarang' $wh AND inve_cbid = '" . ses_cabang . "'");
            if ($sql->num_rows() > 0) {
                $result = $sql->row_array();
            }
            // cek spesial item
            $spesial = $this->db->query("SELECT spe_harga FROM spa_spesial LEFT JOIN "
                    . "spa_inventory ON spe_inveid = inveid WHERE inve_kode = '$kodeBarang'"
                    . " AND inve_cbid = '" . ses_cabang . "'");
            if ($spesial->num_rows() > 0) {
                log_message('error', 'MASUK SPESIAL');
                // CEK GRADE TOKO
                $grade = $this->db->query("SELECT * FROM spa_grade WHERE grad_pelid = '$pelid'"
                        . " AND grad_cbid = '" . ses_cabang . "'");
                if ($grade->num_rows() > 0) {
                    $harga = $spesial->row()->spe_harga;
                    log_message('error', 'MASUK GRADE' . $harga);
                    $get = $grade->row();
                    if ($get->grad_1 > 0) {
                        $harga = $harga * (100 + $get->grad_1) / 100;
                    }
                    log_message('error', 'MASUK GRADE 1' . $harga);
                    if ($get->grad_2 > 0) {
                        $harga = $harga * (100 + $get->grad_2) / 100;
                    }
                    log_message('error', 'MASUK GRADE 2' . $harga);
                    if ($get->grad_3 > 0) {
                        $harga = $harga * (100 + $get->grad_3) / 100;
                    }
                    log_message('error', 'MASUK GRADE 3' . $harga);
                    $result['inve_harga'] = $harga;
                    $result['spesial'] = '2';
                }
            }
        }


        return $result;
    }

    public function getInventoryBarangTerima($kodeBarang, $faktur) {
        $sql = $this->db->query("SELECT inve_kode, inveid,inve_nama,dtr_harga,(dtr_qty-dtr_qty_retur) AS dtr_qty,dtr_diskon FROM spa_trbr_det LEFT JOIN spa_trbr ON trbrid = dtr_trbrid LEFT JOIN"
                . " spa_inventory ON inveid = dtr_inveid WHERE inve_kode = '$kodeBarang' AND trbr_faktur = '$faktur'");
        if ($sql->num_rows() > 0) {
            return $sql->row_array();
        }
        return null;
    }

    /**
     * 
     * @param type $kodeBarang
     * @param type $sppid
     * @return null
     */
    public function getInventoryBarangPenjualan($kodeBarang, $sppid) {
        $sql = $this->db->query("SELECT inve_kode, inveid,inve_nama,dsupp_harga,dsupp_hpp,"
                . "(dsupp_qty-dsupp_qty_retur) AS dsupp_qty,dsupp_diskon,dsupp_subtotal FROM spa_supply_det LEFT JOIN"
                . " spa_inventory ON inveid = dsupp_inveid WHERE inve_kode = '$kodeBarang' AND dsupp_sppid = '$sppid'");
        if ($sql->num_rows() > 0) {
            return $sql->row_array();
        }
        return null;
    }

    /**
     * 
     * @param type $id
     * @return null
     */
    public function getSpesialItemById($id) {
        $sql = $this->db->query("SELECT * FROM spa_spesial LEFT JOIN spa_inventory ON spe_inveid = inveid WHERE speid = '$id'");
        if ($sql->num_rows() > 0) {
            return $sql->row_array();
        }
        return null;
    }

    /**
     * 
     * @param type $id
     * @return null
     */
    public function getRakByGudang($id) {
        $sql = $this->db->query("SELECT * FROM spa_rak WHERE rak_gdgid = '$id'");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }

}

?>
