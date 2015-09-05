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
    public function getRakByGudang($id) {
        $sql = $this->db->query("SELECT * FROM spa_rak WHERE rak_gdgid = '$id'");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }

}

?>
