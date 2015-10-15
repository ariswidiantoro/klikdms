<?php

/**
 * The MODEL AUTOCOMPLETE
 * @author Rossi Erl
 * 2015-08-29
 */
class Model_Autocomplete extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    /* AUTO COMPLETE */
    public function autoCoa($data) {
        $sql = $this->db->query("
            SELECT coa_kode, coa_cbid, coa_desc, coa_type
            FROM ms_coa WHERE (coa_kode LIKE '%".$data['param']."%' OR coa_desc LIKE '%".$data['param']."%') 
                AND coa_cbid = '".$data['cbid']."'
            ORDER BY coa_kode ASC LIMIT 30 OFFSET 0
        ");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }
    
    public function autoKota($data) {
        $sql = $this->db->query("
            select kotaid, propid, kota_deskripsi, prop_deskripsi 
            from ms_kota
            left join ms_propinsi on propid = kota_propid
            WHERE kota_deskripsi LIKE '%".$data['param']."%'
            ORDER BY kota_deskripsi ASC LIMIT 20 OFFSET 0
        ");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }
    
    public function autoBank($data) {
        $sql = $this->db->query("
            select bank_name, bank_deskripsi, bank_flag, bankid 
            from ms_bank
            WHERE bank_name LIKE '%".$data['param']."%'
                AND bank_cbid = '".$data['cbid']."'
            ORDER BY bank_name ASC LIMIT 20 OFFSET 0
        ");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }
    
    
}

?>
