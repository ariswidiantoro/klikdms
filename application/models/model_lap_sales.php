<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Model_Lap_Sales extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    function getMasukKendaran($start, $end, $cabang) {
        $sql = $this->db->query("SELECT * FROM pen_bpk "
                . " LEFT JOIN ms_car ON bpk_mscid = mscid"
                . " LEFT JOIN ms_car_type ON msc_ctyid = ctyid"
                . " LEFT JOIN ms_supplier ON supid = bpk_supid"
                . " WHERE bpk_cbid = '$cabang' AND bpk_tgl BETWEEN '$start' AND '$end' ORDER BY bpk_tgl");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }

}

?>
