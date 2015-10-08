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
     * @param type $kodeBarang
     * @return null
     */
    function getPembelianBySparepart($start, $end, $cabang, $kodeBarang) {
        $wh = "";
        if (!empty($kodeBarang)) {
            $wh = " AND inve_kode = '$kodeBarang'";
        }
        $query = $this->db->query("SELECT trbr_faktur, trbrid,trbr_tgl,sup_nama,inve_kode,"
                . " inve_nama, dtr_qty,dtr_harga,dtr_diskon,dtr_subtotal FROM spa_trbr"
                . " LEFT JOIN spa_trbr_det ON dtr_trbrid = trbrid LEFT JOIN spa_inventory"
                . " ON inveid = dtr_inveid LEFT JOIN ms_supplier ON trbr_supid = supid WHERE trbr_tgl BETWEEN '$start'"
                . " AND '$end' AND trbr_cbid = '$cabang' $wh ORDER BY inve_kode");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return null;
    }
    function getPembelianBySparepartTotal($start, $end, $cabang, $kodeBarang) {
        $wh = "";
        if (!empty($kodeBarang)) {
            $wh = " AND inve_kode = '$kodeBarang'";
        }
        $query = $this->db->query("SELECT inve_kode,"
                . " inve_nama, SUM(dtr_qty) AS dtr_qty,SUM(dtr_subtotal) AS dtr_subtotal, MAX(trbr_tgl) AS trbr_tgl FROM spa_trbr"
                . " LEFT JOIN spa_trbr_det ON dtr_trbrid = trbrid LEFT JOIN spa_inventory"
                . " ON inveid = dtr_inveid LEFT JOIN ms_supplier ON trbr_supid = supid WHERE trbr_tgl BETWEEN '$start'"
                . " AND '$end' AND trbr_cbid = '$cabang' $wh GROUP BY inve_kode, inve_nama ORDER BY inve_kode");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return null;
    }

    function getFakturSparepart($start, $end, $cabang) {
        $query = $this->db->query("SELECT not_nomer, spp_noslip, pel_nama,not_total,not_tgl,not_numerator "
                . "FROM spa_nota LEFT JOIN spa_supply ON sppid = not_sppid LEFT JOIN"
                . " ms_pelanggan ON pelid = spp_pelid WHERE not_tgl BETWEEN '$start'"
                . " AND '$end' AND not_cbid = '$cabang' AND not_status = 0 ORDER BY not_nomer");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return null;
    }

    function getFakturByPelanggan($start, $end, $cabang, $pelid) {
        $wh = '';
        if (!empty($pelid)) {
            $wh = " AND spp_pelid = '$pelid'";
        }
        $query = $this->db->query("SELECT not_nomer, spp_noslip, pel_nama,pel_alamat,not_total,not_tgl,not_numerator "
                . "FROM spa_nota LEFT JOIN spa_supply ON sppid = not_sppid LEFT JOIN"
                . " ms_pelanggan ON pelid = spp_pelid WHERE not_tgl BETWEEN '$start'"
                . " AND '$end' AND not_cbid = '$cabang' AND not_status = 0 $wh ORDER BY pel_nama,not_tgl");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return null;
    }

    function getFakturBySparepart($start, $end, $cabang, $kodeBarang) {
        $wh = '';
        if (!empty($kodeBarang)) {
            $wh = " AND inve_kode = '$kodeBarang'";
        }
        $query = $this->db->query("SELECT not_nomer, spp_noslip, pel_nama,pel_alamat,not_total,"
                . "not_tgl, inve_kode, inve_nama, dsupp_qty, dsupp_harga, dsupp_diskon,"
                . " dsupp_subtotal, dsupp_hpp, dsupp_subtotal_hpp "
                . " FROM spa_nota LEFT JOIN spa_supply ON sppid = not_sppid LEFT JOIN"
                . " ms_pelanggan ON pelid = spp_pelid LEFT JOIN spa_supply_det ON dsupp_sppid = "
                . "sppid LEFT JOIN spa_inventory ON inveid = dsupp_inveid WHERE not_tgl BETWEEN '$start'"
                . " AND '$end' AND not_cbid = '$cabang' AND not_status = 0 $wh ORDER BY inve_kode,not_tgl");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return null;
    }

    function getFakturBySparepartTotal($start, $end, $cabang, $kodeBarang) {
        $wh = '';
        if (!empty($kodeBarang)) {
            $wh = " AND inve_kode = '$kodeBarang'";
        }
        $query = $this->db->query("SELECT MAX(not_tgl) not_tgl,SUM(dsupp_qty) AS dsupp_qty, inve_kode,"
                . " inve_nama, SUM(dsupp_subtotal) AS dsupp_subtotal, SUM(dsupp_subtotal_hpp) AS dsupp_subtotal_hpp"
                . " FROM spa_nota LEFT JOIN spa_supply ON sppid = not_sppid LEFT JOIN"
                . " ms_pelanggan ON pelid = spp_pelid LEFT JOIN spa_supply_det ON dsupp_sppid = "
                . "sppid LEFT JOIN spa_inventory ON inveid = dsupp_inveid WHERE not_tgl BETWEEN '$start'"
                . " AND '$end' AND not_cbid = '$cabang' AND not_status = 0 $wh GROUP BY inve_kode,inve_nama ORDER BY inve_kode");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return null;
    }

    function getFakturByPelangganTotal($start, $end, $cabang, $pelid) {
        $wh = '';
        if (!empty($pelid)) {
            $wh = " AND spp_pelid = '$pelid'";
        }
        $query = $this->db->query("SELECT pel_nama,SUM(not_total) AS not_total,MAX(not_tgl) AS not_tgl,pel_alamat "
                . "FROM spa_nota LEFT JOIN spa_supply ON sppid = not_sppid LEFT JOIN"
                . " ms_pelanggan ON pelid = spp_pelid WHERE not_tgl BETWEEN '$start'"
                . " AND '$end' AND not_cbid = '$cabang' AND not_status = 0 $wh GROUP BY pel_nama,pel_alamat ORDER BY pel_nama");
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
                . " LEFT JOIN ms_supplier ON trbr_supid = supid WHERE rb_tgl BETWEEN '$start'"
                . " AND '$end' AND rb_cbid = '$cabang' ORDER BY rbid");
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
    function getReturPenjualan($start, $end, $cabang) {
        $query = $this->db->query("SELECT rjid,rj_total,rj_tgl,not_nomer, notid,pel_nama,rj_alasan FROM spa_retjual LEFT JOIN spa_nota ON rj_notid = notid"
                . " LEFT JOIN spa_supply ON sppid = not_sppid LEFT JOIN ms_pelanggan ON pelid = sppid WHERE rj_tgl BETWEEN '$start'"
                . " AND '$end' AND rj_cbid = '$cabang' ORDER BY rjid");
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
     * @param type $status
     * @return null
     */
    function getSupplySlipRekap($start, $end, $cabang, $jenis) {
        $wh = '';
        if ($jenis != 'all') {
            $wh = " AND spp_jenis = '$jenis'";
        }
        $query = $this->db->query("SELECT spp_total,spp_total_hpp,spp_noslip, pel_nama,spp_tgl, spp_pay_method "
                . "FROM spa_supply LEFT JOIN ms_pelanggan ON pelid = spp_pelid WHERE spp_tgl BETWEEN '$start'"
                . " AND '$end' AND spp_cbid = '$cabang' $wh AND spp_status = 0 ORDER BY spp_noslip");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return null;
    }

    function getSupplySlipDetail($start, $end, $cabang, $jenis) {
        $wh = '';
        if ($jenis != 'all') {
            $wh = " AND spp_jenis = '$jenis'";
        }
        $query = $this->db->query("SELECT inve_kode, inve_nama, dsupp_qty, dsupp_harga,"
                . " dsupp_diskon, dsupp_subtotal,dsupp_subtotal_hpp, dsupp_hpp,spp_noslip, pel_nama,spp_tgl, spp_pay_method "
                . " FROM spa_supply_det LEFT JOIN spa_inventory ON inveid = dsupp_inveid LEFT JOIN spa_supply ON dsupp_sppid = sppid"
                . " LEFT JOIN ms_pelanggan ON pelid = spp_pelid WHERE spp_tgl BETWEEN '$start'"
                . " AND '$end' AND spp_cbid = '$cabang' $wh AND spp_status = 0 ORDER BY spp_noslip");
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
        log_message('error', 'AAAAAA ' . $this->db->last_query());
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return null;
    }

}

?>
