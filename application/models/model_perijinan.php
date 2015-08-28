<?php

/**
 * The MODEL ADMIN
 * @author Aris Widiantoro
 * 2013-12-13
 */
class Model_Perijinan extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Function ini digunakan untuk mendapatkan data dokumen
     * @param type $where
     * @return int
     */
    public function getTotalDokumen($where) {
        if ($where['sortby'] != '') {
            $this->db->like('dok_deskripsi', $where['sortby']);
        }
        $this->db->from('ms_dokumen_perijinan');
        $this->db->where('dok_status', 0);
        $total = $this->db->count_all_results();
        if ($total > 0) {
            return $total;
        }
        return 0;
    }

    /**
     * Function ini digunakan untuk mendapatkan data dokumen
     * @param type $where
     * @return int
     */
    public function getTotalDokumenMonitoring($where) {
        if ($where['sortby'] != '') {
            $this->db->like('mon_deskripsi', $where['sortby']);
        }
        $this->db->from('ms_dokumen_monitoring');
        $this->db->where('mon_status', 0);
        $total = $this->db->count_all_results();
        if ($total > 0) {
            return $total;
        }
        return 0;
    }

    /**
     * Function ini digunakan untuk mendapatkan data persetujuan
     * @param type $where
     * @return int
     */
    public function getTotalPersetujuan($where) {
        if ($where['sortby'] != '') {
            $this->db->like('pt_nomor', $where['sortby']);
        }
        if ($where['status'] != '') {
            $this->db->where('pt_status', $where['status']);
        }
        $this->db->from('ms_pengajuan_tanah');
        $this->db->join('ms_groupcabang', 'pt_cbid = group_cbid');
        $this->db->where('group_krid', ses_krid);
        $this->db->where('pt_batal', 0);
        $total = $this->db->count_all_results();
        if ($total > 0) {
            return $total;
        }
        return 0;
    }

    /**
     * Function ini digunakan untuk mendapatkan data persetujuan
     * @param type $where
     * @return int
     */
    public function getTotalKontraktor($where) {
        if ($where['sortby'] != '') {
            $this->db->like('kon_nama', $where['sortby']);
        }
        $this->db->from('ms_kontraktor');
        $this->db->where('kon_cbid', ses_cabang);
        $this->db->where('kon_status', 0);
//        $this->db->join('ms_groupcabang', '');
//        $this->db->where('dok_status', 0);
        $total = $this->db->count_all_results();
        if ($total > 0) {
            return $total;
        }
        return 0;
    }

    /**
     * Function ini digunakan untuk mencari dokumen perijinan
     * @param type $sort
     * @param type $order
     * @param type $offset
     * @param type $row
     * @param type $where
     * @return type
     */
    function getAllDokumen($sort = '', $order = '', $offset = '', $row = '', $where = array()) {
        $this->db->select('*');
        if (!empty($where['sortby'])) {
            $this->db->like('dok_deskripsi', $where['sortby']);
        }
        $this->db->from('ms_dokumen_perijinan');
        $this->db->where('dok_status', 0);
        $this->db->order_by($sort, $order);
        $this->db->limit($row, $offset);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    /**
     * Function ini digunakan untuk mencari dokumen perijinan
     * @param type $sort
     * @param type $order
     * @param type $offset
     * @param type $row
     * @param type $where
     * @return type
     */
    function getAllDokumenMonitoring($sort = '', $order = '', $offset = '', $row = '', $where = array()) {
        $this->db->select('*');
        if (!empty($where['sortby'])) {
            $this->db->like('mon_deskripsi', $where['sortby']);
        }
        $this->db->from('ms_dokumen_monitoring');
        $this->db->where('mon_status', 0);
        $this->db->order_by($sort, $order);
        $this->db->limit($row, $offset);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    /**
     * Function ini digunakan untuk mencari dokumen perijinan
     * @param type $sort
     * @param type $order
     * @param type $offset
     * @param type $row
     * @param type $where
     * @return type
     */
    function getAllKontraktor($sort = '', $order = '', $offset = '', $row = '', $where = array()) {
        $this->db->select('*');
        if (!empty($where['sortby'])) {
            $this->db->like('kon_nama', $where['sortby']);
        }
        $this->db->from('ms_kontraktor');
        $this->db->where('kon_status', 0);
        $this->db->where('kon_cbid', ses_cabang);
        $this->db->order_by($sort, $order);
        $this->db->limit($row, $offset);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    /**
     * Function ini digunakan untuk mencari dokumen perijinan
     * @param type $sort
     * @param type $order
     * @param type $offset
     * @param type $row
     * @param type $where
     * @return type
     */
    function getAllPilihKontraktor($sort = '', $order = '', $offset = '', $row = '', $where = array()) {
        $this->db->select('*');
        $this->db->from('ijn_pilih_kontraktor');
        $this->db->join('ms_kontraktor', 'pil_konid = konid', 'LEFT');
        $this->db->join('ms_cabang', 'pil_cbid = cbid', 'LEFT');
        $this->db->where('pil_cbid', ses_cabang);
        $this->db->order_by($sort, $order);
        $this->db->limit($row, $offset);
        $query = $this->db->get();
        log_message('error', 'DDDDDDD ' . $this->db->last_query());
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    /**
     * Function ini digunakan untuk mencari semua perijinan
     * @param type $sort
     * @param type $order
     * @param type $offset
     * @param type $row
     * @param type $where
     * @return type
     */
    function getAllPersetujuan($sort = '', $order = '', $offset = '', $row = '', $where = array()) {
        $this->db->select('*');
        if (!empty($where['sortby'])) {
            $this->db->like('pt_nomor', $where['sortby']);
        }
        if ($where['status'] != '') {
            $this->db->where('pt_status', $where['status']);
        }
        $this->db->from('ms_pengajuan_tanah');
        $this->db->join('ms_groupcabang', 'pt_cbid = group_cbid');
        $this->db->join('ms_cabang', 'cbid = group_cbid');
        $this->db->join('ijn_pilih_kontraktor', 'pil_cbid = group_cbid');
        $this->db->join('ms_kontraktor', 'pil_konid = konid');
        $this->db->where('group_krid', ses_krid);
        $this->db->where('pt_batal', 0);
        $this->db->order_by($sort, $order);
        $this->db->limit($row, $offset);
        $query = $this->db->get();
//        log_message('error', 'DDDDDDDD '.$this->db->last_query());
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    /**
     * 
     * @param array $data
     * @return boolean
     */
    function simpanDokumen($data) {
        $this->db->trans_begin();
        $this->db->INSERT('ms_dokumen_perijinan', $data);
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
     * @param array $data
     * @return boolean
     */
    function simpanDokumenMonitoring($data) {
        $this->db->trans_begin();
        $this->db->INSERT('ms_dokumen_monitoring', $data);
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
     * @param array $data
     * @return boolean
     */
    function simpanKontraktor($data) {
        $this->db->trans_begin();
        $this->db->INSERT('ms_kontraktor', $data);
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
     * @param array $data
     * @return boolean
     */
    function simpanPilihKontraktor($data) {
        $this->db->trans_begin();
        $this->db->where('pil_cbid', $data['pil_cbid']);
        $this->db->delete('ijn_pilih_kontraktor');
        $this->db->INSERT('ijn_pilih_kontraktor', $data);
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
     * @param array $data
     * @return boolean
     */
    function simpanPengajuanPerijinan($data, $detail) {
        $this->db->trans_begin();
        $tgl = date('Y');
        $id = sprintf("%06s", $this->getCounter("PT" . $tgl));
        $data['ptid'] = "PT" . $tgl . $id;
        $this->db->INSERT('ms_pengajuan_tanah', $data);
        foreach ($detail as $det) {
            $det['ptd_ptid'] = $data['ptid'];
            $this->db->INSERT('ms_pengajuan_tanah_detail', $det);
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
     * @param array $data
     * @return boolean
     */
    function simpanPersetujuanPerijinan($detail) {
        $this->db->trans_begin();
        foreach ($detail as $det) {
            $this->db->where('ptdid', $det['ptdid']);
            $this->db->update('ms_pengajuan_tanah_detail', $det);
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
     * @param array $data
     * @return boolean
     */
    function updatePengajuanTanah($data, $detail) {
        $this->db->trans_begin();
        $this->db->where('ptid', $data['ptid']);
        $this->db->update('ms_pengajuan_tanah', $data);
        foreach ($detail as $det) {
            $this->db->where('ptd_ptid', $det['ptd_ptid']);
            $this->db->where('ptd_dok_id', $det['ptd_dok_id']);
            $this->db->update('ms_pengajuan_tanah_detail', $det);
//            log_message('error', 'DDDDDDD '.$this->db->last_query());
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
    public function getDokumenById($id) {
        $sql = $this->db->query("SELECT * FROM ms_dokumen_perijinan WHERE dok_id = '$id'");
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
    public function getGroupCabang() {
        $sql = $this->db->query("SELECT * FROM ms_groupcabang LEFT JOIN ms_cabang"
                . " ON cbid = group_cbid  WHERE group_krid = '" . ses_krid . "' ORDER BY cb_nama");
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
    public function getKontraktor() {
        $sql = $this->db->query("SELECT * FROM ms_kontraktor LEFT JOIN ms_groupcabang"
                . " ON kon_cbid = group_cbid  WHERE group_krid = '" . ses_krid . "'  AND kon_status = 0");
//        log_message('error', 'KONTRAKTOR ' . $this->db->last_query());
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
    public function getKontraktorByCabang($cbid) {
        $sql = $this->db->query("SELECT * FROM ms_kontraktor WHERE kon_cbid = '$cbid' AND kon_status = 0");
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
    public function getDokumenMonitoringById($id) {
        $sql = $this->db->query("SELECT * FROM ms_dokumen_monitoring WHERE monid = '$id'");
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
    public function getKontraktorById($id) {
        $sql = $this->db->query("SELECT * FROM ms_kontraktor WHERE konid = '$id'");
        if ($sql->num_rows() > 0) {
            return $sql->row_array();
        }
        return null;
    }

    /**
     * Function ini digunakan untuk mengambil dokumen perijinan
     * @param type $data
     * @return boolean
     */
    public function getDokumenPerijinan() {
        $sql = $this->db->query("SELECT * FROM ms_dokumen_perijinan WHERE dok_status = 0 ORDER BY dok_deskripsi");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }

    /**
     * Function ini digunakan untuk mengambil dokumen perijinan
     * @param type $data
     * @return boolean
     */
    public function getPengajuanTanah($ptid) {
        $sql = $this->db->query("SELECT * FROM ms_pengajuan_tanah WHERE ptid = '$ptid'");
        if ($sql->num_rows() > 0) {
            return $sql->row_array();
        }
        return null;
    }

    /**
     * Function ini digunakan untuk mengambil dokumen perijinan
     * @param type $data
     * @return boolean
     */
    public function getPengajuanTanahDetail($ptid) {
        $sql = $this->db->query("SELECT * FROM ms_pengajuan_tanah_detail LEFT JOIN "
                . " ms_dokumen_perijinan ON ptd_dok_id = dok_id WHERE ptd_ptid = '$ptid' ORDER BY dok_deskripsi");
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
    function updateDokumen($data) {
        $this->db->trans_begin();
        $this->db->where('dok_id', $data['dok_id']);
        $this->db->update('ms_dokumen_perijinan', $data);
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
    function updateDokumenMonitoring($data) {
        $this->db->trans_begin();
        $this->db->where('monid', $data['monid']);
        $this->db->update('ms_dokumen_monitoring', $data);
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
    function updateKontraktor($data) {
        $this->db->trans_begin();
        $this->db->where('konid', $data['konid']);
        $this->db->update('ms_kontraktor', $data);
//        log_message()
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    /**
     * function in ini digunakan untuk menghapus dokumen
     * @param type $data
     * @return boolean
     */
    public function hapusDokumen($id) {
        $this->db->trans_begin();
        $this->db->query("UPDATE ms_dokumen_perijinan SET dok_status = 1 WHERE dok_id = '$id'");
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    /**
     * function in ini digunakan untuk menghapus dokumen
     * @param type $data
     * @return boolean
     */
    public function hapusDokumenMonitoring($id) {
        $this->db->trans_begin();
        $this->db->query("UPDATE ms_dokumen_monitoring SET mon_status = 1 WHERE monid = '$id'");
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    /**
     * function in ini digunakan untuk menghapus dokumen
     * @param type $data
     * @return boolean
     */
    public function hapusKontraktor($id) {
        $this->db->trans_begin();
        $this->db->query("UPDATE ms_kontraktor SET kon_status = 1 WHERE konid = '$id'");
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    /**
     * function in ini digunakan untuk menghapus dokumen
     * @param type $data
     * @return boolean
     */
    public function hapusPengajuan($id) {
        $this->db->trans_begin();
        $this->db->query("UPDATE ms_pengajuan_tanah SET pt_batal = 1 WHERE ptid = '$id'");
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    /**
     * function in ini digunakan untuk menghapus dokumen
     * @param type $data
     * @return boolean
     */
    public function setujuiPengajuan($id) {
        $this->db->trans_begin();
        $this->db->query("UPDATE ms_pengajuan_tanah SET pt_status = 1 WHERE ptid = '$id'");
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
