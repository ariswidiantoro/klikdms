<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Model_Util_Service extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 
     * @param type $where
     * @return types
     */
    public function getTotalWo($where) {
        $wh = "WHERE wo_cbid = '" . ses_cabang . "'";
        if ($where != NULL)
            $wh .= " AND " . $where;
        $sql = $this->db->query("SELECT COUNT(woid) AS total FROM svc_wo LEFT JOIN"
                . " ms_pelanggan ON pelid = wo_pelid LEFT JOIN ms_car ON mscid = wo_mscid $wh");
        return $sql->row()->total;
    }

    /**
     * 
     * @param type $where
     * @return type
     */
    public function getTotalFakturService($where) {
        $wh = "WHERE inv_cbid = '" . ses_cabang . "'";
        if ($where != NULL)
            $wh .= " AND " . $where;
        $sql = $this->db->query("SELECT COUNT(invid) AS total FROM svc_invoice LEFT JOIN svc_wo ON woid = inv_woid LEFT JOIN"
                . " ms_pelanggan ON pelid = wo_pelid LEFT JOIN ms_car ON mscid = wo_mscid $wh");
        return $sql->row()->total;
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
    function getAllWo($start, $limit, $sidx, $sord, $where) {
        $this->db->select('woid, wo_nomer, wo_tgl, wo_inv_status, pel_nama,msc_nopol,msc_nomesin, msc_norangka, wo_status');
        $this->db->limit($limit);
        if ($where != NULL)
            $this->db->where($where, NULL, FALSE);
        $this->db->where('wo_cbid', ses_cabang);
        $this->db->from('svc_wo');
        $this->db->join('ms_pelanggan', 'pelid = wo_pelid', 'LEFT');
        $this->db->join('ms_car', 'mscid = wo_mscid', 'LEFT');
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
     * @param type $start
     * @param type $limit
     * @param type $sidx
     * @param type $sord
     * @param type $where
     * @return null
     */
    function getAllFakturService($start, $limit, $sidx, $sord, $where) {
        $this->db->select('woid,wo_nomer, inv_tgl, wo_inv_status, pel_nama,msc_nopol,msc_nomesin, msc_norangka,inv_status, invid');
        $this->db->limit($limit);
        if ($where != NULL)
            $this->db->where($where, NULL, FALSE);
        $this->db->where('inv_cbid', ses_cabang);
        $this->db->from('svc_invoice');
        $this->db->join('svc_wo', 'woid = inv_woid', 'LEFT');
        $this->db->join('ms_pelanggan', 'pelid = wo_pelid', 'LEFT');
        $this->db->join('ms_car', 'mscid = wo_mscid', 'LEFT');
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
     * @param type $woid
     * @return null
     */
    public function getWorkOrderBatal($woid) {
        $sql = $this->db->query("SELECT wo_nomer, btl_alasan"
                . " FROM svc_wo LEFT JOIN tb_pembatalan ON btl_kode = woid WHERE woid = '$woid'");
        if ($sql->num_rows() > 0) {
            return $sql->row_array();
        }
        return null;
    }
    
    /**
     * 
     * @param type $invid
     * @return null
     */
    public function getFakturServiceBatal($invid) {
        $sql = $this->db->query("SELECT wo_nomer, btl_alasan"
                . " FROM svc_invoice LEFT JOIN svc_wo ON woid = inv_woid LEFT JOIN tb_pembatalan ON btl_kode = woid WHERE invid = '$invid'");
        if ($sql->num_rows() > 0) {
            return $sql->row_array();
        }
        return null;
    }

    /**
     * 
     * @param type $woid
     * @param type $alasan
     * @return type
     */
    function batalWo($woid, $alasan) {
        $result = array();
        $sql = $this->db->query("SELECT sppid FROM spa_supply WHERE spp_woid = '$woid' AND spp_status = 0 AND spp_cbid = '" . ses_cabang . "' ");
        if ($sql->num_rows() > 0) {
            $result['result'] = false;
            $result['kode'] = '';
            $result['msg'] = error("Masih ada supply pada wo ini");
            return $result;
        }
        $this->db->trans_begin();
        $pembatalan = array(
            'btl_kode' => $woid,
            'btl_tgl' => date('Y-m-d'),
            'btl_alasan' => $alasan,
            'btl_cbid' => ses_cabang,
            'btl_createby' => ses_username,
            'btl_createon' => date('Y-m-d H:i:s'),
        );
        $this->db->INSERT('tb_pembatalan', $pembatalan);
        // UPDATE SUPPLY
        $this->db->where('woid', $woid);
        $this->db->update('svc_wo', array('wo_status' => 1));


        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            $result['result'] = true;
            $result['kode'] = $woid;
            $result['msg'] = sukses("Berhasil membatalkan wo");
        } else {
            $this->db->trans_rollback();
            $result['result'] = false;
            $result['kode'] = '';
            $result['msg'] = error("Gagal membatalkan wo");
        }
        return $result;
    }

 
    /**
     * 
     * @param type $invid
     * @param type $woid
     * @param type $alasan
     * @return type
     */
    function batalFakturService($invid, $woid, $alasan) {
        $result = array();
        $this->db->trans_begin();
        $pembatalan = array(
            'btl_kode' => $invid,
            'btl_tgl' => date('Y-m-d'),
            'btl_alasan' => $alasan,
            'btl_cbid' => ses_cabang,
            'btl_createby' => ses_username,
            'btl_createon' => date('Y-m-d H:i:s'),
        );
        $this->db->INSERT('tb_pembatalan', $pembatalan);
        // UPDATE INVOICE
        $this->db->where('invid', $invid);
        $this->db->update('svc_invoice', array('inv_status' => 1));

        // UPDATE WO
        $this->db->where('woid', $woid);
        $this->db->update('svc_wo', array('wo_inv_status' => 0));
        
        // UPDATE SUPPLY
        $this->db->where('spp_woid', $woid);
        $this->db->update('spa_supply', array('spp_faktur' => 0, 'spp_tagihan' => 0));


        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            $result['result'] = true;
            $result['kode'] = $invid;
            $result['msg'] = sukses("Berhasil membatalkan wo");
        } else {
            $this->db->trans_rollback();
            $result['result'] = false;
            $result['kode'] = '';
            $result['msg'] = error("Gagal membatalkan wo");
        }
        return $result;
    }

}

?>
