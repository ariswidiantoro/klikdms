<?php

/**
 * The MODEL ADMIN
 * @author Aris Widiantoro
 * 2013-12-13
 */
class Model_Service extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Function ini digunakan untuk mendapatkan data cabang
     * @param type $where
     * @return int
     */
    public function getTotalFlateRate($where) {

        $wh = "WHERE flat_type = 1 AND flat_cbid = '" . ses_cabang . "'";
        if ($where != NULL)
            $wh = " AND " . $where;

        $sql = $this->db->query("SELECT COUNT(*) AS total FROM svc_frate $wh");
        return $sql->row()->total;
    }

    /**
     * Function ini digunakan untuk mendapatkan data cabang
     * @param type $where
     * @return int
     */
    public function getTotalFreeService($where) {

        $wh = "WHERE flat_type = 2 AND flat_cbid = '" . ses_cabang . "'";
        if ($where != NULL)
            $wh = " AND " . $where;

        $sql = $this->db->query("SELECT COUNT(*) AS total FROM svc_frate $wh");
        return $sql->row()->total;
    }

    /**
     * Function ini digunakan untuk mencari semua jabatan
     * @param type $sort
     * @param type $order
     * @param type $offset
     * @param type $row
     * @param type $where
     * @return type
     */
    function getAllFlateRate($start, $limit, $sidx, $sord, $where) {
        $this->db->select('*');
        $this->db->limit($limit);
        if ($where != NULL)
            $this->db->where($where, NULL, FALSE);
        $this->db->from('svc_frate');
        $this->db->where('flat_cbid', ses_cabang);
        $this->db->where('flat_type', 1);
        $this->db->order_by($sidx, $sord);
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return null;
    }

    /**
     * Function ini digunakan untuk mencari semua jabatan
     * @param type $sort
     * @param type $order
     * @param type $offset
     * @param type $row
     * @param type $where
     * @return type
     */
    function getAllFreeService($start, $limit, $sidx, $sord, $where) {
        $this->db->select('*');
        $this->db->limit($limit);
        if ($where != NULL)
            $this->db->where($where, NULL, FALSE);
        $this->db->from('svc_frate');
        $this->db->where('flat_cbid', ses_cabang);
        $this->db->where('flat_type', 2);
        $this->db->order_by($sidx, $sord);
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return null;
    }

    function saveBasicRate($data) {
        try {
            $str = $this->db->INSERT('svc_brate', $data);
            if ($str) {
                return true;
            } else {
                $errMessage = $this->db->_error_message();
                if (strpos($errMessage, "duplicate key value") == TRUE) {
                    $this->db->where('br_cbid', $data['br_cbid']);
                    $this->db->update('svc_brate', $data);
                    return true;
                }
            }
        } catch (Exception $e) {
            $e->getCode();
        }
        return false;
    }

    function saveFlateRate($data) {
        $this->db->trans_begin();
        $tahun = substr(date('Y'), 2, 2);
        $id = sprintf("%08s", $this->getCounter("FL" . $tahun));
        $data['flatid'] = "FL" . $tahun . $id;
        try {
            $str = $this->db->INSERT('svc_frate', $data);
            if (!$str) {
                $errMessage = $this->db->_error_message();
                if (strpos($errMessage, "duplicate key value") == TRUE) {
                    $this->db->trans_rollback();
                    return false;
                }
            }
        } catch (Exception $e) {
            $e->getCode();
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

    function savePelanggan($data) {
        $this->db->trans_begin();
        $tahun = substr(date('Y'), 2, 2);
        $id = sprintf("%08s", $this->getCounter("PE" . $tahun));
        $data['pelid'] = "PE" . $tahun . $id;
        $this->db->INSERT('ms_pelanggan', $data);
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
    public function getBasicRate($id) {
        $sql = $this->db->query("SELECT * FROM svc_brate WHERE br_cbid = '$id'");
        if ($sql->num_rows() > 0) {
            return $sql->row_array();
        }
        return null;
    }

    /**
     * Function ini digunakan untuk mengambil rol
     * @param type $data
     * @return boolean
     */
    public function getFlateRate($id) {
        $sql = $this->db->query("SELECT * FROM svc_frate WHERE flatid = '$id'");
        if ($sql->num_rows() > 0) {
            return $sql->row_array();
        }
        return null;
    }

    /**
     * 
     * @param type $role
     * @return boolean
     */
    function hapusPelanggan($data) {
        $this->db->query("UPDATE ms_pelanggan SET pel_status = 1 WHERE pelid = '$data'");
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        return false;
    }

    function updateFlateRate($data) {
        $this->db->trans_begin();
        $this->db->where('flatid', $data['flatid']);
        $this->db->update('svc_frate', $data);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    function updatePelanggan($data) {
        $this->db->trans_begin();
        $this->db->where('pelid', $data['pelid']);
        $this->db->update('ms_pelanggan', $data);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

}

?>
