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

}

?>
