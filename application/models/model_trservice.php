<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Model_Trservice extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Get data wo berdasarkan nomor wo
     * @param String $woNomer Nomor work order
     * @return array of work order
     */
    public function getWo($woNomer) {
        $sql = $this->db->query("SELECT * FROM svc_wo WHERE wo_nomer = '$woNomer' AND wo_cbid = '".ses_cabang."'");
        if ($sql->num_rows() > 0) {
            return $sql->row_array();
        }
        return null;
    }

}

?>
