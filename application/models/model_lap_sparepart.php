<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Model_Lap_Sparepart extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 
     * @param type $start
     * @param type $end
     * @param type $cabang
     * @return null
     */
    function getPenerimaanBarang($start, $end, $cabang) {
        $query = $this->db->query("SELECT trbr_faktur, trbrid,trbr_tgl,sup_nama,trbr_total FROM spa_trbr LEFT JOIN ms_supplier ON trbr_supid = supid WHERE trbr_tgl BETWEEN '$start'"
                . " AND '$end' AND trbr_cbid = '$cabang' ORDER BY trbrid");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return null;
    }

    /**
     * 
     * @param type $start
     * @param type $end
     * @param type $cabang
     * @return null
     */
    function getReturPembelian($start, $end, $cabang) {
        $query = $this->db->query("SELECT rbid,rb_total,rb_total,rb_tgl,trbr_faktur, trbrid,sup_nama,rb_alasan FROM spa_retbeli LEFT JOIN spa_trbr ON rb_trbrid = trbrid"
                . " LEFT JOIN ms_supplier ON trbr_supid = supid WHERE trbr_tgl BETWEEN '$start'"
                . " AND '$end' AND trbr_cbid = '$cabang' ORDER BY rbid");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return null;
    }

    /**
     * 
     * @param type $start
     * @param type $end
     * @param type $cabang
     * @return null
     */
    function getKartuStock($start, $end, $cabang, $kodeBarang) {
        $query = $this->db->query("(SELECT ksid, 'SA' AS ks_type,NULL AS ks_tgl,'' AS transaksi,"
                . " '' AS nama,ks_hpp,0 AS ks_in,0 AS ks_out,ks_total,0 AS ks_debit,0 AS ks_kredit,ks_saldo,"
                . " inve_kode FROM spa_kartu_stock LEFT JOIN suppel ON kode = ks_suppel"
                . " LEFT JOIN no_transaksi ON ks_notrans = kode_trans LEFT JOIN spa_inventory ON inveid = ks_inveid WHERE ks_cbid"
                . " = '$cabang' AND DATE(ks_tgl) < '$start' AND inve_kode = '$kodeBarang' ORDER BY ksid DESC LIMIT 1) UNION"
                . " SELECT ksid, ks_type,ks_tgl,transaksi,nama,ks_hpp,ks_in,ks_out,ks_total,"
                . " ks_debit,ks_kredit,ks_saldo, inve_kode FROM spa_kartu_stock LEFT JOIN suppel ON kode = ks_suppel"
                . " LEFT JOIN no_transaksi ON ks_notrans = kode_trans LEFT JOIN spa_inventory ON inveid = ks_inveid WHERE ks_cbid"
                . " = '$cabang' AND DATE(ks_tgl) BETWEEN '$start' AND '$end' AND inve_kode = '$kodeBarang' ORDER BY ksid");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return null;
    }

    /**
     * 
     * @param type $start
     * @param type $end
     * @param type $cabang
     * @return null
     */
    function getPosisiStock($date, $cabang, $kodeBarang, $type) {
        $wh = '';
        if (!empty($kodeBarang)) {
            $wh = " AND inve_kode = '$kodeBarang'";
        }
        if (!empty($type)) {
            $wh .= " AND inve_jenis = '$type'";
        }
        $query = $this->db->query("SELECT * FROM spa_kartu_stock RIGHT JOIN(select MAX(ksid)"
                . " AS ksid, ks_inveid FROM spa_kartu_stock LEFT JOIN spa_inventory"
                . " ON inveid = ks_inveid WHERE DATE(ks_tgl) <= '$date'"
                . " AND ks_cbid = '$cabang' $wh GROUP BY ks_inveid) AS "
                . " s2 ON s2.ksid = spa_kartu_stock.ksid AND s2.ks_inveid = spa_kartu_stock.ks_inveid"
                . " LEFT JOIN spa_inventory ON inveid = spa_kartu_stock.ks_inveid ORDER BY inve_kode");
        log_message('error', 'AAAAAA '.$this->db->last_query());
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return null;
    }

}

?>
