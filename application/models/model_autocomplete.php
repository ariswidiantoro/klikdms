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
        if($data['coa'] == PIUTANG_SERVICE or $data['coa'] == UANGMUKA_SERVICE){
            $query = "SELECT woid as faktur, msc_nopol as kontrak, pel_nama as nama
                FROM svc_wo 
                LEFT JOIN ms_pelanggan ON pelid = wo_pelid 
                LEFT JOIN ms_car ON mscid = wo_mscid
                WHERE wo_nomer LIKE '%".$data['param']."%' AND wo_cbid = '".ses_cabang."'
                    ORDER BY woid ASC LIMIT 20 OFFSET 0";
        }else if ($data['coa'] == PIUTANG_SPART){
            $query = "SELECT notid as faktur, msc_nopol as kontrak, pel_nama as nama
                FROM svc_wo 
                LEFT JOIN ms_pelanggan ON pelid = wo_pelid 
                LEFT JOIN ms_car ON mscid = wo_mscid
                WHERE wo_nomer LIKE '%".$data['param']."%' AND wo_cbid = '".ses_cabang."'
                    ORDER BY notid ASC LIMIT 20 OFFSET 0";
        }else if($data['coa'] == PIUTANG_UNIT){
            $query = "SELECT spkid as faktur, msc_nopol as kontrak, pel_nama as nama
                FROM svc_wo 
                LEFT JOIN ms_pelanggan ON pelid = wo_pelid 
                LEFT JOIN ms_car ON mscid = wo_mscid
                WHERE wo_nomer LIKE '%".$data['param']."%' AND wo_cbid = '".ses_cabang."'
                    ORDER BY spkid ASC LIMIT 20 OFFSET 0";
        }
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
    
    public function autoFakturUnit($data){
        $sql = $this->db->query("
            select pelid, pel_nama, pel_alamat, kon_nomer, fkpid, fkp_nofaktur 
            from pen_faktur
            LEFT JOIN pen_spk ON spkid = fkp_spkid
            LEFT JOIN ms_kontrak ON kon_nomer = spk_nokontrak AND kon_cbid = fkp_cbid
            LEFT JOIN ms_pelanggan ON pelid = kon_pelid
            WHERE fkp_nofaktur LIKE '%".$data['param']."%'
                AND fkp_cbid = '".$data['cbid']."'
            ORDER BY pel_nama ASC LIMIT 20 OFFSET 0
        ");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }
    
    /* AUTO COMPLETE */
    public function autoFakturSvc($data) {
        $sql = $this->db->query("SELECT woid as trglocal, wo_nomer as value, 
                concat(msc_nopol, ' - ', pel_nama) as desc, msc_nopol as trgid, 
                pel_nama as trgname
                FROM svc_wo 
                LEFT JOIN ms_pelanggan ON pelid = wo_pelid 
                LEFT JOIN ms_car ON mscid = wo_mscid
                WHERE wo_nomer LIKE '%".$data['param']."%' 
                     AND wo_cbid = '".ses_cabang."'
                     AND pelid = '".$data['pelid']."'
                     ORDER BY wo_nomer ASC LIMIT 20 OFFSET 0
        ");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }
    
    /* AUTO COMPLETE */
    public function autoFakturTagSvc($data) {
        $sql = $this->db->query("SELECT woid as notaid, wo_nomer as value, 
                concat(msc_nopol, ' - ', pel_nama) as desc, msc_nopol as nopol, 
                pel_nama as trgname, inv_total, (SELECT SUM(trl_kredit - trl_debit) as totUm FROM
                ksr_ledger WHERE trl_coa = '".UANGMUKA_SERVICE."' AND trl_nota = woid 
                    AND trl_cbid = wo_cbid ) as uangmuka
                FROM svc_wo 
                LEFT JOIN ms_pelanggan ON pelid = wo_pelid 
                LEFT JOIN ms_car ON mscid = wo_mscid
                LEFT JOIN svc_invoice on inv_woid = woid
                WHERE wo_nomer LIKE '%".$data['param']."%' 
                     AND wo_cbid = '".ses_cabang."'
                     AND inv_tagihan = 0
                     ORDER BY wo_nomer ASC LIMIT 20 OFFSET 0
        ");
        if ($sql->num_rows() > 0) {
            $ret = $sql->result_array();
        }else {
            $ret[] = array('value' => '', 'desc' => "DATA TIDAK ADA");
        }
        
        return $ret;
    }
    
    /* AUTO COMPLETE */
    public function getDetailTagSvc($data) {
        $sql = $this->db->query("SELECT woid, wo_nomer, invid, inv_total
                FROM svc_wo 
                JOIN ms_pelanggan ON pelid = wo_pelid 
                WHERE wo_nomer LIKE '%".$data['param']."%' 
                     AND wo_cbid = '".ses_cabang."'
                     ORDER BY wo_nomer ASC LIMIT 20 OFFSET 0
        ");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }
    
    
}

?>
