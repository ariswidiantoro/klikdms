<?php

/**
 * The MODEL SALES
 * @author Rossi Erl
 * 2013-12-13
 */
class Model_Trsales extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /** MASTER STOCK UNIT 
     * @author Rossi Erl
     * 2015-09-18
     */
    public function getTotalBpk($where) {
        $wh = "WHERE bpk_cbid = '" . ses_cabang . "'";
        if ($where != NULL)
            $wh = " AND " . $where;
        $sql = $this->db->query("SELECT COUNT(*) AS total FROM pen_bpk ");
        return $sql->row()->total;
    }

    public function getDataBpk($start, $limit, $sidx, $sord, $where) {
        $this->db->select('*');
        $this->db->limit($limit);
        if ($where != NULL)
            $this->db->where($where, NULL, FALSE);
        $this->db->from('pen_bpk');
        $this->db->join('ms_car', 'mscid = bpk_mscid', 'left');
        $this->db->join('ms_car_type', 'ctyid = msc_ctyid', 'left');
        $this->db->where('bpk_cbid', ses_cabang);
        $this->db->order_by($sidx, $sord);
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return null;
    }

    public function addBpk($data) {
        $this->db->trans_begin();
        try {
            $tahun = date('y');
            $data['mscid'] = NUM_BPK . $tahun . sprintf("%08s", $this->getCounter(NUM_BPK . $tahun));

            if ($this->db->insert('pen_bpk', $data) == FALSE) {
                $warn = "FAILED INSERTING DATA : TERIMA KENDARAAN";
                throw new Exception($warn);
            }

            if ($this->db->trans_status() == TRUE) {
                $this->db->trans_commit();
                return array('status' => TRUE, 'msg' => 'TERIMA KENDARAAN BERHASIL DITAMBAHKAN ');
            } else {
                $this->db->trans_rollback();
                return array('status' => FALSE, 'msg' => 'TERIMA KENDARAAN GAGAL DITAMBAHKAN ');
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            return array('status' => FALSE, 'msg' => $e->getMessage());
        }
    }

    public function updateBpk($data, $where) {
        $this->db->where('bpkid', $where);
        if ($this->db->update('pen_bpk', $data)) {
            return array('status' => TRUE, 'msg' => 'TERIMA KENDARAAN BERHASIL DIUPDATE');
        } else {
            return array('status' => FALSE, 'msg' => 'TERIMA KENDARAAN GAGAL DIUPDATE');
        }
    }

    public function getBpk($data) {
        $query = $this->db->query("
            SELECT * FROM pen_bpk
            LEFT JOIN ms_car ON mscid = bpk_mscid
            LEFT JOIN ms_car_type ON ctyid = msc_ctyid
            WHERE bpkid = '" . $data . "'");
        return $query->row_array();
    }

    public function deleteBpk($data) {
        if ($this->db->query("DELETE FROM ms_car WHERE bpkid = ' " . $data . "'")) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}

?>
