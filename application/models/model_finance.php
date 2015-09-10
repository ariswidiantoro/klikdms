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
    
    /* Utility */
    
    /** 
     * This function is used for feetching 
     * Costcenter's data on Combo List
     * @author Rossi on 2015-09-08
     **/
    public function cListCostCenter($data){
        $this->db->where('cc_cbid', $data['cbid']);
        $sql = $this->db->get('ms_cost_center');
        return $sql->result_array();
    }
    
    public function cListKota($data){
        $this->db->where('cc_cbid', $data['cbid']);
        $sql = $this->db->get('ms_cost_center');
        return $sql->result_array();
    }
}

?>
