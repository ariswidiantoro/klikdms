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
        $sql = $this->db->query("SELECT COUNT(bpkid) AS total FROM pen_bpk ");
        return $sql->row()->total;
    }

    /**
     * 
     * @param type $norangka
     * @param type $cbid
     * @return null
     */
    public function autoRangkaUnit($norangka, $cbid) {
        $sql = $this->db->query("SELECT msc_norangka FROM ms_car WHERE msc_cbid = '$cbid'"
                . " AND msc_isstock = 1 AND msc_norangka LIKE '$norangka%' ORDER BY msc_norangka LIMIT 20");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }

    public function autoFpt($kodeFpt, $cbid) {
        $sql = $this->db->query("SELECT fptid, fpt_kode AS value, pros_nama AS desc FROM pen_fpt LEFT JOIN pros_data ON prosid = fpt_prosid"
                . " WHERE fpt_cbid = '$cbid'"
                . " AND fpt_status = 0 AND fpt_kode LIKE '$kodeFpt%' ORDER BY fpt_kode LIMIT 20");
        if ($sql->num_rows() > 0) {
            return $sql->result();
        }
        return null;
    }

    public function autoNoKontrak($nokontrak, $cbid) {
        $sql = $this->db->query("SELECT kon_nomer AS value FROM ms_kontrak WHERE kon_cbid = '$cbid' "
                . "AND kon_use = 0 AND kon_nomer LIKE '$nokontrak%' ORDER BY kon_nomer LIMIT 20");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }

    /**
     * 
     * @param type $norangka
     * @param type $cbid
     * @return null
     */
    public function getDataStock($norangka, $cbid) {
        $sql = $this->db->query("SELECT mscid,msc_nomesin,merk_deskripsi,cty_deskripsi,msc_kondisi,msc_vinlot,msc_bodyseri FROM ms_car LEFT JOIN ms_car_type ON ctyid = msc_ctyid"
                . " LEFT JOIN ms_car_model ON modelid = cty_modelid LEFT JOIN ms_car_merk ON model_merkid = merkid"
                . " WHERE msc_cbid = '$cbid' AND msc_norangka = '$norangka'");
        if ($sql->num_rows() > 0) {
            return $sql->row_array();
        }
        return null;
    }

    public function getDataNoKontrak($noKontrak, $cbid) {
        $sql = $this->db->query("SELECT * FROM ms_kontrak LEFT JOIN ms_pelanggan ON pelid = kon_pelid"
                . " WHERE kon_cbid = '$cbid' AND kon_nomer = '$noKontrak'");
        if ($sql->num_rows() > 0) {
            return $sql->row_array();
        }
        return null;
    }

    /**
     * 
     * @param type $start
     * @param type $limit
     * @param type $sidx
     * @param type $sord
     * @param type $where
     * @return null
     */
    public function getDataBpk($start, $limit, $sidx, $sord, $where) {
        $this->db->select('bpkid,bpk_jenis,msc_norangka,bpk_nomer,msc_bodyseri,bpk_tgl,cty_deskripsi');
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

    /**
     * 
     * @param string $data
     * @return type
     * @throws Exception
     */
    public function saveBpk($data) {
        $this->db->trans_begin();
        $tahun = date('y');
        $result = array();
        $data['bpkid'] = NUM_BPK . $tahun . sprintf("%08s", $this->getCounter(NUM_BPK . $tahun));
        $this->db->insert('pen_bpk', $data);
        $this->db->query("UPDATE ms_car SET msc_ready_stock = 1 WHERE mscid = '"
                . $data['bpk_mscid'] . "' AND msc_cbid = '" . $data['bpk_cbid'] . "'");
        if ($this->db->trans_status() == TRUE) {
            $this->db->trans_commit();
            $result['result'] = true;
            $result['kode'] = $data['bpkid'];
            $result['msg'] = sukses("Berhasil menyimpan bpk");
        } else {
            $this->db->trans_rollback();
            $result['result'] = false;
            $result['kode'] = '';
            $result['msg'] = error("Gagal menyimpan bpk");
        }
        return $result;
    }

    /**
     * 
     * @param type $data
     * @param type $where
     * @return type
     */
    public function updateBpk($data, $where) {
        $this->db->where('bpkid', $where);
        if ($this->db->update('pen_bpk', $data)) {
            return array('status' => TRUE, 'msg' => 'TERIMA KENDARAAN BERHASIL DIUPDATE');
        } else {
            return array('status' => FALSE, 'msg' => 'TERIMA KENDARAAN GAGAL DIUPDATE');
        }
    }

    /**
     * 
     * @param type $data
     * @return type
     */
    public function getBpk($data) {
        $query = $this->db->query("
            SELECT * FROM pen_bpk
            LEFT JOIN ms_supplier ON supid = bpk_supid
            LEFT JOIN ms_car ON mscid = bpk_mscid
            LEFT JOIN ms_car_type ON ctyid = msc_ctyid
            LEFT JOIN ms_car_model ON modelid = cty_modelid
            LEFT JOIN ms_car_merk ON merkid = model_merkid
            LEFT JOIN ms_warna ON warnaid = msc_warnaid
            WHERE bpkid = '" . $data . "'");
        return $query->row_array();
    }

    /**
     * 
     * @param type $data
     * @return boolean
     */
    public function deleteBpk($data) {
        if ($this->db->query("DELETE FROM ms_car WHERE bpkid = ' " . $data . "'")) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}

?>
