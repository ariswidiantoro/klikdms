<?php

/**
 * The MODEL FINANCE
 * @author Rossi Erl
 * 2015-08-29
 */
class Model_Finance extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Utility - Finance
     * @author Rossi on 2015-09-25
     * */
    public function cListCostCenter($data) {
        $this->db->where('cc_cbid', $data['cbid']);
        $this->db->order_by('cc_kode', 'ASC');
        $sql = $this->db->get('ms_cost_center');
        return $sql->result_array();
    }

    public function cListKota($data) {
        $this->db->where('cc_cbid', $data['cbid']);
        $sql = $this->db->get('ms_cost_center');
        return $sql->result_array();
    }

    public function cListJenisCoa() {
        $sql = $this->db->get('ms_coa_jenis');
        return $sql->result_array();
    }
    
    public function cListDepartemen() {
        $sql = $this->db->get('ms_departemen');
        return $sql->result_array();
    }

    /** Jenis Chart Of Account (COA) 
     * @author Rossi Erl
     * 2015-09-04
     */
    public function getTotalJenisCoa($where) {
        $wh = "WHERE  jeniscoaid != '' ";
        if ($where != NULL)
            $wh .= " AND " . $where;

        $sql = $this->db->query("SELECT COUNT(*) AS total FROM ms_coa_jenis $wh");
        return $sql->row()->total;
    }

    public function getDataJenisCoa($start, $limit, $sidx, $sord, $where) {
        $this->db->select('*');
        $this->db->limit($limit);
        if ($where != NULL)
            $this->db->where($where, NULL, FALSE);
        $this->db->from('ms_coa_jenis');
        $this->db->order_by($sidx, $sord);
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return null;
    }

    public function deleteJenisCoa($data) {
        if ($this->db->query("DELETE FROM ms_coa_jenis WHERE jeniscoaid = '" . $data . "'")) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function addJenisCoa($data = array()) {
        $this->db->trans_begin();
        $cek = $this->db->query("SELECT jeniscoa_deskripsi FROM ms_coa_jenis 
            WHERE jeniscoa_deskripsi = '" . $data['jeniscoa_deskripsi'] . "'");
        if ($cek->num_rows() > 0) {
            $this->db->trans_rollback();
            return array('status' => FALSE, 'msg' => 'Duplikasi Jenis COA');
        }
        $data['jeniscoaid'] = NUM_JENIS_COA . sprintf("%02s", $this->getCounter(NUM_JENIS_COA));
        $this->db->insert('ms_coa_jenis', $data);
        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            return array('status' => TRUE, 'msg' => 'Data berhasil disimpan');
        } else {
            $this->db->trans_rollback();
            return array('status' => FALSE, 'msg' => 'Data gagal disimpan');
        }
    }

    public function updateJenisCoa($data, $where) {
        $this->db->where('jeniscoaid', $where);
        if ($this->db->update('ms_coa_jenis', $data)) {
            return array('status' => TRUE, 'msg' => 'Data berhasil diupdate');
        } else {
            return array('status' => FALSE, 'msg' => 'Data gagal diupdate');
        }
    }

    public function getJenisCoa($data) {
        $query = $this->db->query("
            SELECT * FROM ms_coa_jenis WHERE jeniscoaid = '" . $data . "'  ");
        return $query->row_array();
    }
    
    /* MASTER DEPARTEMENT */
    /** DEPARTEMENT (COA) 
     * @author Rossi Erl
     * 2015-09-04
     */
    public function getTotalDepartement($where) {
        $wh = "WHERE  deptid != '' ";
        if ($where != NULL)
            $wh .= " AND " . $where;
        
        $sql = $this->db->query("SELECT deptid AS total FROM ms_departement $wh");
        return $sql->row()->total;
    }

    public function getDataDepartement($start, $limit, $sidx, $sord, $where) {
        $this->db->select('*');
        $this->db->limit($limit);
        if ($where != NULL)
            $this->db->where($where, NULL, FALSE);
        $this->db->from('ms_departement');
        $this->db->order_by($sidx, $sord);
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return null;
    }

    public function deleteDepartement($data) {
        if ($this->db->query("DELETE FROM ms_departement WHERE deptid = '" . $data . "'")) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function addDepartement($data = array()) {
        $this->db->trans_begin();
        $cek = $this->db->query("SELECT dept_deskripsi FROM ms_departement 
            WHERE dept_deskripsi = '" . $data['dept_deskripsi'] . "'");
        if ($cek->num_rows() > 0) {
            $this->db->trans_rollback();
            return array('status' => FALSE, 'msg' => 'Duplikasi Departement');
        }
        $data['specid'] = NUM_DEPT . sprintf("%02s", $this->getCounter(NUM_DEPT));
        $this->db->insert('ms_departement', $data);
        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            return array('status' => TRUE, 'msg' => 'Data berhasil disimpan');
        } else {
            $this->db->trans_rollback();
            return array('status' => FALSE, 'msg' => 'Data gagal disimpan');
        }
    }

    public function updateDepartement($data, $where) {
        $this->db->where('deptid', $where);
        if ($this->db->update('ms_departement', $data)) {
            return array('status' => TRUE, 'msg' => 'Data berhasil diupdate');
        } else {
            return array('status' => FALSE, 'msg' => 'Data gagal diupdate');
        }
    }

    public function getDepartement($data) {
        $query = $this->db->query("
            SELECT * FROM ms_departement 
            WHERE deptid = '" . $data . "'  ");
        return $query->row_array();
    }

    /** Special Chart Of Account (COA) 
     * @author Rossi Erl
     * 2015-09-04
     */
    public function getTotalSpecialCoa($where) {
        $wh = "WHERE  specid != '' ";
        if ($where != NULL)
            $wh .= " AND " . $where;

        $sql = $this->db->query("SELECT COUNT(*) AS total FROM ms_coa_special $wh");
        return $sql->row()->total;
    }

    public function getDataSpecialCoa($start, $limit, $sidx, $sord, $where) {
        $this->db->select('*');
        $this->db->limit($limit);
        if ($where != NULL)
            $this->db->where($where, NULL, FALSE);
        $this->db->from('ms_coa_special');
        $this->db->join('ms_coa_setting', "specid = setcoa_specid and setcoa_cbid = '".ses_cabang."'", 'left');
        $this->db->order_by($sidx, $sord);
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return null;
    }

    public function deleteSpecialCoa($data) {
        if ($this->db->query("DELETE FROM ms_coa_special WHERE specid = '" . $data . "'")) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function addSpecialCoa($data = array()) {
        $this->db->trans_begin();
        $cek = $this->db->query("SELECT spec_deskripsi FROM ms_coa_special 
            WHERE spec_deskripsi = '" . $data['spec_deskripsi'] . "'");
        if ($cek->num_rows() > 0) {
            $this->db->trans_rollback();
            return array('status' => FALSE, 'msg' => 'Duplikasi Special COA');
        }
        $data['specid'] = NUM_SPECIAL_COA . sprintf("%02s", $this->getCounter(NUM_SPECIAL_COA));
        $this->db->insert('ms_coa_special', $data);
        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            return array('status' => TRUE, 'msg' => 'Data berhasil disimpan');
        } else {
            $this->db->trans_rollback();
            return array('status' => FALSE, 'msg' => 'Data gagal disimpan');
        }
    }

    public function setSpecialCoa($data = array()) {
        $this->db->trans_begin();
        /*$cek = $this->db->query("SELECT setcoa_kode FROM ms_coa_setting 
            WHERE setcoa_kode = '" . $data['setcoa_kode'] . "' AND setcoa_cbid = '" . $data['setcoa_cbid'] . "'");
        if ($cek->num_rows() > 0) {
            $this->db->trans_rollback();
            return array('status' => FALSE, 'msg' => 'Duplikasi Special COA');
        } */
        $cek = $this->db->query("DELETE FROM ms_coa_setting 
            WHERE setcoa_specid = '" . $data['setcoa_specid'] . "' AND setcoa_cbid = '" . $data['setcoa_cbid'] . "'");
        $this->db->insert('ms_coa_setting', $data);
        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            return array('status' => TRUE, 'msg' => 'Data berhasil disimpan');
        } else {
            $this->db->trans_rollback();
            return array('status' => FALSE, 'msg' => 'Data gagal disimpan');
        }
    }

    public function updateSpecialCoa($data, $where) {
        $this->db->where('specid', $where);
        if ($this->db->update('ms_coa_special', $data)) {
            return array('status' => TRUE, 'msg' => 'Data berhasil diupdate');
        } else {
            return array('status' => FALSE, 'msg' => 'Data gagal diupdate');
        }
    }

    public function getSpecialCoa($data) {
        $query = $this->db->query("
            SELECT * FROM ms_coa_special 
            LEFT JOIN ms_coa_setting ON setcoa_cbid = '" . ses_cabang . "' 
                AND setcoa_specid = specid
            WHERE specid = '" . $data . "'  ");
        return $query->row_array();
    }

    /** Chart Of Account (COA) 
     * @author Rossi Erl
     * 2015-09-04
     */
    public function getTotalCoa($where) {
        $wh = "WHERE coa_cbid = '" . ses_cabang . "' and coa_flag = 1 ";
        if ($where != NULL)
            $wh .= " AND " . $where;

        $sql = $this->db->query("SELECT COUNT(*) AS total FROM ms_coa $wh");
        return $sql->row()->total;
    }

    public function getDataCoa($start, $limit, $sidx, $sord, $where) {
        $this->db->select('*');
        $this->db->limit($limit);
        if ($where != NULL)
            $this->db->where($where, NULL, FALSE);
        $this->db->from('ms_coa');
        $this->db->join('ms_coa_jenis', 'jeniscoaid = coa_jenis', 'left');
        $this->db->where('coa_cbid', ses_cabang);
        $this->db->order_by($sidx, $sord);
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return null;
    }

    public function deleteCoa($data) {
        if ($this->db->query('DELETE FROM ms_coa WHERE coaid = ' . $data)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function addCoa($data = array()) {
        $cek = $this->db->query("SELECT coa_kode FROM ms_coa WHERE coa_kode = '" . $data['coa_kode'] . "'
            AND coa_cbid = '" . $data['coa_cbid'] . "'");
        if ($cek->num_rows() > 0) {
            return array('status' => FALSE, 'msg' => 'Duplikasi Kode COA');
        } else {
            if ($this->db->insert('ms_coa', $data)) {
                return array('status' => TRUE, 'msg' => 'Kode COA ' . $data['coa_kode'] . ' berhasil disimpan');
            } else {
                return array('status' => FALSE, 'msg' => 'Kode COA ' . $data['coa_kode'] . ' gagal disimpan');
            }
        }
    }

    public function updateCoa($data, $where) {
        $this->db->where('coaid', $where);
        if ($this->db->update('ms_coa', $data)) {
            return array('status' => TRUE, 'msg' => 'Kode COA ' . $data['coa_kode'] . ' berhasil diupdate');
        } else {
            return array('status' => FALSE, 'msg' => 'Kode COA ' . $data['coa_kode'] . ' gagal diupdate');
        }
    }

    public function getCoa($data) {
        $query = $this->db->query("
            SELECT * FROM ms_coa WHERE coaid = " . $data . "  ");
        return $query->row_array();
    }

    /** Cost Center 
     * @author Rossi Erl
     * 2015-09-07
     */
    public function getTotalCostCenter($where) {
        $wh = "WHERE cc_cbid = '" . ses_cabang . "' and cc_flag = '1' ";
        if ($where != NULL)
            $wh .= " AND " . $where;

        $sql = $this->db->query("SELECT COUNT(*) AS total FROM ms_cost_center $wh");
        return $sql->row()->total;
    }

    public function getAllCostCenter($start, $limit, $sidx, $sord, $where) {
        $this->db->select('*');
        $this->db->limit($limit);
        if ($where != NULL)
            $this->db->where($where, NULL, FALSE);
        $this->db->from('ms_cost_center');
        $this->db->where('cc_cbid', ses_cabang);
        $this->db->order_by($sidx, $sord);
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return null;
    }

    public function deleteCostCenter($data) {
        if ($this->db->query('DELETE FROM ms_cost_center WHERE ccid = ' . $data)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function addCostCenter($data) {
        $cek = $this->db->query("SELECT cc_kode FROM ms_cost_center WHERE cc_kode = '" . $data['cc_kode'] . "'
            AND cc_cbid = '" . $data['cc_cbid'] . "'");
        if ($cek->num_rows() > 0) {
            return array('status' => FALSE, 'msg' => 'Duplikasi Kode Cost Center');
        } else {
            if ($this->db->insert('ms_cost_center', $data)) {
                return array('status' => TRUE, 'msg' => 'Kode Cost Center ' . $data['cc_kode'] . ' berhasil disimpan');
            } else {
                return array('status' => FALSE, 'msg' => 'Kode Cost Center ' . $data['cc_kode'] . ' gagal disimpan');
            }
        }
    }

    public function updateCostCenter($data, $where) {
        $this->db->where('ccid', $where);
        if ($this->db->update('ms_cost_center', $data)) {
            return array('status' => TRUE, 'msg' => 'Kode cost center berhasil diupdate');
        } else {
            return array('status' => FALSE, 'msg' => 'Kode cost center gagal diupdate');
        }
    }

    public function getCostCenter($data) {
        $query = $this->db->query("
            SELECT * FROM ms_cost_center WHERE ccid = " . $data . "
            ");
        return $query->row_array();
    }

    /** Master Bank
     * @author Rossi Erl
     * 2015-09-07
     */
    public function getTotalBank($where) {
        $wh = "WHERE bank_cbid = '" . ses_cabang . "' and bank_flag = '1' ";
        if ($where != NULL)
            $wh .= " AND " . $where;

        $sql = $this->db->query("SELECT COUNT(*) AS total FROM ms_bank $wh");
        return $sql->row()->total;
    }

    public function getAllBank($start, $limit, $sidx, $sord, $where) {
        $this->db->select('*');
        $this->db->limit($limit);
        if ($where != NULL)
            $this->db->where($where, NULL, FALSE);
        $this->db->from('ms_bank');
        $this->db->where('bank_cbid', ses_cabang);
        $this->db->order_by($sidx, $sord);
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return null;
    }

    public function deleteBank($data) {
        if ($this->db->query('DELETE FROM ms_bank WHERE bankid = ' . $data)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function addBank($data) {
        $cek = $this->db->query("SELECT bank_name FROM ms_bank WHERE bank_name = '" . $data['bank_name'] . "'
            AND bank_cbid = '" . $data['bank_cbid'] . "'");
        if ($cek->num_rows() > 0) {
            return array('status' => FALSE, 'msg' => 'Duplikasi nama bank');
        } else {
            if ($this->db->insert('ms_bank', $data)) {
                return array('status' => TRUE, 'msg' => 'Data bank berhasil disimpan');
            } else {
                return array('status' => FALSE, 'msg' => 'Data bank gagal disimpan');
            }
        }
    }

    public function updateBank($data, $where) {
        $this->db->where('bankid', $where);
        if ($this->db->update('ms_bank', $data)) {
            return array('status' => TRUE, 'msg' => 'Data bank berhasil disimpan');
        } else {
            return array('status' => FALSE, 'msg' => 'Data bank gagal disimpan');
        }
    }

    public function getBank($data) {
        $query = $this->db->query("
            SELECT * FROM ms_bank WHERE bankid = " . $data . "
            ");
        return $query->row_array();
    }

    /** Master Tipe Jurnal 
     * @author Rossi Erl
     * 2015-09-03
     */
    public function getTotalTipeJurnal($where) {
        $wh = "WHERE tipeid != '0' ";
        if ($where != NULL)
            $wh .= " AND " . $where;

        $sql = $this->db->query("SELECT COUNT(*) AS total FROM ms_tipe_jurnal $wh");
        return $sql->row()->total;
    }

    public function getDataTipeJurnal($start, $limit, $sidx, $sord, $where) {
        $this->db->select('*');
        $this->db->limit($limit);
        if ($where != NULL)
            $this->db->where($where, NULL, FALSE);
        $this->db->from('ms_tipe_jurnal');
        $this->db->order_by($sidx, $sord);
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return null;
    }

    public function addTipeJurnal($data) {
        $this->db->trans_begin();
        $data['tipeid'] = NUM_TIPE_JURNAL . sprintf("%03s", $this->getCounter(NUM_TIPE_JURNAL));
        $this->db->insert('ms_tipe_jurnal', $data);
        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            return array('status' => TRUE, 'msg' => 'Data ' . $data['tipe_deskripsi'] . ' berhasil disimpan');
        } else {
            $this->db->trans_rollback();
            return array('status' => FALSE, 'msg' => 'Data ' . $data['tipe_deskripsi'] . ' gagal disimpan');
        }
    }

    public function setTipeJurnal($data) {
        $this->db->trans_begin();
        try {
            if ($this->db->query("DELETE FROM ms_dtipe_jurnal WHERE 
                dtipe_cbid = '" . $data['cbid'] . "' AND dtipe_tipeid = '" . $data['tipeid'] . "'") == FALSE) {
                throw new excetion('GAGAL HAPUS DATA : ' . $data['tipeid']);
            }
            for ($i = 0; $i <= count($data['const']) - 1; $i++) {
                if ($this->db->insert('ms_dtipe_jurnal', array(
                            'dtipe_tipeid' => $data['tipeid'],
                            'dtipe_cbid' => $data['cbid'],
                            'dtipe_constant' => $data['const'][$i],
                            'dtipe_coa' => $data['coa'][$i],
                            'dtipe_flag' => '0'
                        )) == FALSE) {
                    throw new Exception('GAGAL MENYIMPAN DATA : ' . $data['coa'][$i]);
                }
            }
            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                return array('status' => TRUE, 'msg' => 'Data ' . $data['tipeid'] . ' berhasil disimpan');
            } else {
                throw new excetion('GAGAL MENYIMPAN DATA : ' . $data['coa'][$i]);
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            return array('status' => FALSE, 'msg' => $e->getMessage());
        }
    }

    public function getTipeJurnal($data) {
        $query = $this->db->query("
            SELECT * FROM ms_tipe_jurnal WHERE tipeid = '" . $data . "'");
        return $query->row_array();
    }

    public function updateTipeJurnal($data, $where) {
        $this->db->where('tipeid', $where);
        if ($this->db->update('ms_tipe_jurnal', $data)) {
            return array('status' => TRUE, 'msg' => 'Data ' . $data['tipe_deskripsi'] . ' berhasil diupdate');
        } else {
            return array('status' => FALSE, 'msg' => 'Data ' . $data['tipe_deskripsi'] . ' gagal diupdate');
        }
    }

    public function deleteTipeJurnal($data) {
        if ($this->db->query('DELETE FROM ms_tipe_jurnal WHERE tipeid = ' . $data)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getDetailTipeJurnal($data) {
        $query = $this->db->query("
            SELECT * FROM ms_tipe_jurnal 
            LEFT JOIN ms_dtipe_jurnal ON dtipe_tipeid = tipeid AND dtipe_cbid = '" . $data['cbid'] . "'
            WHERE tipeid = '" . $data['id'] . "'");
        return $query->result_array();
    }

    public function getTotalDtipe($data) {
        $query = $this->db->query("
            SELECT count(dtipe_coa) as total FROM ms_dtipe_jurnal WHERE 
            dtipe_tipeid = '" . $data['id'] . "' AND dtipe_cbid = '" . $data['cbid'] . "'");
        return $query->row()->total;
    }

    /** Master Tipe Jurnal 
     * @author Rossi Erl
     * 2015-09-03
     */
    public function getTotalMasterJurnal($where) {
        $wh = "WHERE tipeid != '0' ";
        if ($where != NULL)
            $wh .= " AND " . $where;

        $sql = $this->db->query("SELECT COUNT(*) AS total FROM ms_tipe_jurnal $wh");
        return $sql->row()->total;
    }

    public function getDataMasterJurnal($start, $limit, $sidx, $sord, $where) {
        $this->db->select('*');
        $this->db->limit($limit);
        if ($where != NULL)
            $this->db->where($where, NULL, FALSE);
        $this->db->from('ms_auto_jurnal');
        $this->db->order_by($sidx, $sord);
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return null;
    }

    public function addMasterJurnal($data) {
        if ($this->db->insert('ms_tipe_jurnal', $data)) {
            return array('status' => TRUE, 'msg' => 'Data ' . $data['tipe_deskripsi'] . ' berhasil disimpan');
        } else {
            return array('status' => FALSE, 'msg' => 'Data ' . $data['tipe_deskripsi'] . ' gagal disimpan');
        }
    }

    public function getMasterJurnal($data) {
        $query = $this->db->query("
            SELECT * FROM ms_tipe_jurnal WHERE tipeid = " . $data . "
            ");
        return $query->row_array();
    }

    public function updateMasterJurnal($data, $where) {
        $this->db->where('tipeid', $where);
        if ($this->db->update('ms_tipe_jurnal', $data)) {
            return array('status' => TRUE, 'msg' => 'Data ' . $data['tipe_deskripsi'] . ' berhasil diupdate');
        } else {
            return array('status' => FALSE, 'msg' => 'Data ' . $data['tipe_deskripsi'] . ' gagal diupdate');
        }
    }

    public function deleteMasterJurnal($data) {
        if ($this->db->query('DELETE FROM ms_tipe_jurnal WHERE tipeid = ' . $data)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    

}

?>
