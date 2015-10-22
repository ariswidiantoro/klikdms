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
            SELECT coa_kode, coa_cbid, coa_desc, coa_jenis
            FROM ms_coa WHERE (coa_kode LIKE '%".$data['param']."%' OR coa_desc LIKE '%".$data['param']."%') 
                AND coa_cbid = '".$data['cbid']."'
            ORDER BY coa_kode ASC LIMIT 30 OFFSET 0
        ");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }
    
    public function autoUangmuka($data) {
        $sql = $this->db->query("
            select coa_kode, coa_cbid, coa_desc, coa_jenis
            from ms_coa_setting 
            LEFT JOIN ms_coa on coa_kode = setcoa_kode and coa_cbid = setcoa_cbid
            WHERE (coa_kode LIKE '%".$data['param']."%' OR coa_desc LIKE '%".$data['param']."%') 
                AND setcoa_cbid = '".$data['cbid']."'
                AND (setcoa_specid = '".UANGMUKA_UNIT."' or setcoa_specid = '".UANGMUKA_SERVICE."' or
                    setcoa_specid = '".UANGMUKA_SPART."' or setcoa_specid = '".UANGMUKA_BREPAIR."')
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
            select bank_name, bank_desc, bank_flag, bankid 
            from ms_bank
            WHERE bank_name LIKE '%".$data['param']."%'
                AND bank_cbid = '".$data['cbid']."'
                AND bank_flag = '1'
            ORDER BY bank_name ASC LIMIT 20 OFFSET 0
        ");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }
    
    public function autoPelid($data) {
        $sql = $this->db->query("
            select pelid, pel_nama, pel_alamat 
            from ms_pelanggan
            WHERE pel_nama LIKE '%".$data['param']."%'
                AND pel_cbid = '".$data['cbid']."'
            ORDER BY pel_nama ASC LIMIT 20 OFFSET 0
        ");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }
    
    public function autoSupid($data) {
        $sql = $this->db->query("
            select supid, sup_nama, sup_alamat 
            from ms_supplier
            WHERE sup_nama LIKE '%".$data['param']."%'
                AND sup_cbid = '".$data['cbid']."'
            ORDER BY sup_nama ASC LIMIT 20 OFFSET 0
        ");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }
    
    public function autoFaktur($data) {
        $sql = $this->db->query("
            select supid, sup_nama, sup_alamat 
            from ms_supplier
            WHERE sup_nama LIKE '%".$data['param']."%'
                AND sup_cbid = '".$data['cbid']."'
            ORDER BY sup_nama ASC LIMIT 20 OFFSET 0
        ");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }
    
    
}

?>
