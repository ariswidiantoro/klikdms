<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Model_Util_Sparepart extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 
     * @param type $where
     * @return type
     */
    public function getTotalSupply($where) {
        $wh = "WHERE spp_cbid = '" . ses_cabang . "'";
        if ($where != NULL)
            $wh = " AND " . $where;
        $sql = $this->db->query("SELECT COUNT(sppid) AS total FROM spa_supply LEFT JOIN"
                . " ms_pelanggan ON pelid = spp_pelid LEFT JOIN svc_wo ON woid = spp_woid $wh");
        return $sql->row()->total;
    }

    public function getTotalFaktur($where) {
        $wh = "WHERE not_cbid = '" . ses_cabang . "'";
        if ($where != NULL)
            $wh = " AND " . $where;
        $sql = $this->db->query("SELECT COUNT(sppid) AS total FROM spa_nota LEFT"
                . " JOIN spa_supply ON sppid = not_sppid LEFT JOIN"
                . " ms_pelanggan ON pelid = spp_pelid $wh");
        return $sql->row()->total;
    }

    /**
     * 
     * @param type $where
     * @return type
     */
    public function getTotalTrbr($where) {
        $wh = "WHERE trbr_cbid = '" . ses_cabang . "'";
        if ($where != NULL)
            $wh = " AND " . $where;
        $sql = $this->db->query("SELECT COUNT(trbrid) AS total FROM spa_trbr LEFT JOIN"
                . " ms_supplier ON supid = trbr_supid $wh");
        return $sql->row()->total;
    }

    /**
     * Function ini digunakan untuk mencari semua Cabang
     * @param type $sort
     * @param type $order
     * @param type $offset
     * @param type $row
     * @param type $where
     * @return type
     */
    function getAllSupplySlip($start, $limit, $sidx, $sord, $where) {
        $this->db->select('sppid,spp_noslip, spp_total,spp_tgl, pel_nama, spp_status,spp_faktur,wo_nomer');
        $this->db->limit($limit);
        if ($where != NULL)
            $this->db->where($where, NULL, FALSE);
        $this->db->where('spp_cbid', ses_cabang);
        $this->db->from('spa_supply');
        $this->db->join('ms_pelanggan', 'pelid = spp_pelid', 'LEFT');
        $this->db->join('svc_wo', 'woid = spp_woid', 'LEFT');
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
    function getAllFaktur($start, $limit, $sidx, $sord, $where) {
        $this->db->select('sppid,spp_noslip,notid, not_tgl, not_nomer, pel_nama, not_total');
        $this->db->limit($limit);
        if ($where != NULL)
            $this->db->where($where, NULL, FALSE);
        $this->db->where('spp_cbid', ses_cabang);
        $this->db->from('spa_nota');
        $this->db->join('spa_supply', 'sppid = not_sppid', 'LEFT');
        $this->db->join('ms_pelanggan', 'pelid = spp_pelid', 'LEFT');
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
    function getAllTrbr($start, $limit, $sidx, $sord, $where) {
        $this->db->select('trbrid,trbr_faktur,trbr_total,trbr_tgl, sup_nama');
        $this->db->limit($limit);
        if ($where != NULL)
            $this->db->where($where, NULL, FALSE);

        $this->db->where('trbr_cbid', ses_cabang);
        $this->db->from('spa_trbr');
        $this->db->join('ms_supplier', 'supid = trbr_supid', 'LEFT');
        $this->db->order_by($sidx, $sord);
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return null;
    }

    function batalSupply($sppid, $alasan) {
        $result = array();
        $this->db->trans_begin();

        // UPDATE SUPPLY
        $this->db->where('sppid', $sppid);
        $this->db->update('spa_supply', array('spp_status' => 1, 'spp_tgl_batal' => date('Y-m-d H:i:s'), 'spp_alasan_batal' => $alasan, 'spp_batalby' => ses_username));

        $sql = $this->db->query("SELECT * FROM spa_supply_det WHERE dsupp_sppid = '$sppid'");
        foreach ($sql->result_array() as $value) {
            $barang = $this->db->query("SELECT * FROM spa_inventory WHERE inveid = '" . $value['dsupp_inveid'] . "' FOR UPDATE");
            $row = $barang->row_array();
            $hpp = (($row['inve_qty'] * $row['inve_hpp']) + ($value['dsupp_subtotal_hpp'])) / ($row['inve_qty'] + $value['dsupp_qty']);
            //INSERT KARTU STOCK
            $kartuStock = array(
                'ks_tgl' => date('Y-m-d H:i:s'),
                'ks_cbid' => ses_cabang,
                'ks_inveid' => $value['dsupp_inveid'],
                'ks_in' => $value['dsupp_qty'],
                'ks_type' => 'BS',
                'ks_hpp' => $hpp,
                'ks_debit' => $value['dsupp_subtotal_hpp'],
                'ks_saldo' => $value['dsupp_subtotal_hpp'] + $row['inve_saldo'],
                'ks_total' => $row['inve_qty'] + $value['dsupp_qty'],
            );
            $this->db->INSERT('spa_kartu_stock', $kartuStock);
            // UDPATE INVENTORY
            $this->db->query("UPDATE spa_inventory SET inve_qty = inve_qty + " . $value['dsupp_qty'] .
                    ",inve_hpp = $hpp, inve_saldo = inve_saldo + " . $value['dsupp_subtotal_hpp'] . " WHERE inveid = '" . $value['dsupp_inveid'] . "'");
        }

        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            $result['result'] = true;
            $result['kode'] = $sppid;
            $result['msg'] = sukses("Berhasil membatalkan supply");
        } else {
            $this->db->trans_rollback();
            $result['result'] = false;
            $result['kode'] = '';
            $result['msg'] = error("Gagal membatalkan supply");
        }
        return $result;
    }

    function updatePrintFaktur($notid) {
        $this->db->query("UPDATE spa_nota SET not_print = not_print + 1 WHERE notid = '$notid'");
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        return false;
    }

}

?>
