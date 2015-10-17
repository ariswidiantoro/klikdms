<?php

/**
 * The MODEL TRANSAKSI FINANCE
 * @author Rossi Erl
 * 2015-08-29
 */
class Model_Trfinance extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /* @param array('coa' => string, 'cbid' => string ) */

    public function isValidCoa($data = array()) {
        $sql = $this->db->query("
            SELECT count(coa_kode) as num FROM ms_coa WHERE 
            coa_kode = '" . $data['coa'] . "' AND coa_cbid = '" . $data['cbid'] . "'
        ");

        if ($sql->row()->num > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /* CEK DUPLIKASI DOCNO */
    
    public function isDuplikat($data = array()){
        $query = "SELECT count(kst_nomer) as tot FROM ksr_trans WHERE 
            kst_trans = '".$data['kst_trans']."' AND kst_cbid = '".$data['kst_cbid']."' AND 
            kst_nomer = '".$data['kst_nomer']."' AND kst_type = '".$data['kst_type']."'";
        $sql = $this->db->query($query);
        if( $sql->row()->tot > 0){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
    /* INPUT MAIN TRANSAKSI */

    public function addMain($data = array()) {
        if ($data['kst_trans'] != 'ADJUST') {
            if ($this->isValidCoa(array(
                        'coa' => $data['kst_coa'],
                        'cbid' => $data['kst_cbid'])) == FALSE)
                return FALSE;
        }

        /* FILTER ACCOUNT BY JENIS TRANSAKSI */

        if ($this->db->insert("ksr_trans", $data) == FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /* INPUT DETAIL TRANSAKSI */

    public function addDetail($data) {
        /* FILTER KELENGKAPAN TRANSAKSI BY JENIS ACCOUNT */

        if ($this->db->insert("ksr_dtrans", $data) == FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /* INPUT TRANSAKSI */

    public function addTrans($etc = array(), $main = array(), $detail = array()) {
        $this->db->trans_begin();
        try {
            if($etc['purpose'] == 'ADD'){
                $tahun = date('y');
                $main['kstid'] = NUM_TRANS . $tahun . sprintf("%08s", $this->getCounter(NUM_TRANS . $tahun));
                $this->addMain($main);
            }else{
                $this->editMain($main, $etc['kstid']);
                $this->flagDetail($detail);
            }
            
            if (count($detail) < 1) {
                $e = "DETAIL TRANSAKSI KOSONG";
                throw new Exception($e);
            } else {
                for ($i = 0; $i <= count($detail['coa']) - 1; $i++) {
                    if($main['kst_type'] == 'I'){
                        $kredit = numeric($detail['nominal'][$i]);
                        $debit  =  0;
                    }else{
                        $kredit =  0;
                        $debit  =  numeric($detail['nominal'][$i]);
                    }
                    if($this->addDetail(array(
                        'dkst_kstid' => $main['kstid'],
                        'dkst_coa' => $detail['coa'][$i],
                        'dkst_decrip' => $detail['desc'][$i],
                        'dkst_nota' => $detail['nota'][$i],
                        'dkst_pelid' => $detail['pelid'][$i],
                        'dkst_supid' => $detail['supid'][$i],
                        'dkst_ccid' => $detail['ccid'][$i],
                        'dkst_debit' => $debit,
                        'dkst_kredit' => $kredit,
                        'dkst_flag' => '1',
                        'dkst_lastupdate' => date('Y-m-d H:i:s')
                    )) == FALSE){
                        throw new Exception('GAGAL TAMBAH DETAIL');
                    }
                }
            }
            
            if (count($bank['bank']) > 0) { 
                for ($i = 0; $i <= count($bank['bank']) - 1; $i++) {
                    if($this->addBank(array(
                        'dbnk_bankid' => $bank['bank'][$i],
                        'dbnk_norek' => $bank['norek'][$i],
                        'dbnk_nocek' => $bank['nocek'][$i],
                        'dbnk_jtempo' => $bank['jtempo'][$i],
                        'dbnk_kotaid' => $bank['kota'][$i],
                        'dbnk_nominal' => numeric($bank['nominal'][$i]),
                        'dbnk_flag' => '1',
                        'dbnk_lastupdate' => date('Y-m-d H:i:s')
                    )) == FALSE){
                        throw new Exception('GAGAL TAMBAH DETAIL BANK');
                    }
                }
            }

            if ($this->db->trans_status() == TRUE) {
                $this->db->trans_commit();
                return array('status' => TRUE, 'msg' => 'INPUT DATA BERHASIL');
            } else {
                $e = "GAGAL MENYIMPAN DATA";
                throw new Exception($e);
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            return array('status' => FALSE, 'msg' => $e->getMessage());
        }
    }
    
    public function editHead($data, $id){
        $this->db->where("kstid", $id);
        return $this->db->update("ksr_trans", $data);
    }
    
    /* FLAG DETAIL TO INCATIVE */
    public function flagDetail($data, $id){
        $this->db->where('dkst_kstid', $id);
        return $this->db->update('ksr_dtrans', array('dkst_flag' => '0'));
    }
    
    /* LOAD DATAGRID TRANSAKSI */

    public function loadtrans($data) {
        if (!empty($data['where']['key'])) {
            $where = " AND " . $data['option'] . " LIKE '%" . $data['key'] . "%'";
        }

        /* if(!empty($data['where']['category'])){
          $where = " AND ".$data['category']." LIKE '%".$data['key']."%'";
          } */

        $sql = $this->db->query("
            SELECT * FROM ksr_trans WHERE 
            kst_trans = '" . $data['trans'] . "' AND
            kst_type = '" . $data['type'] . "' AND
            kst_cbid = '" . $data['cbid'] . "' AND
            kst_trans = '" . $data['trans'] . "' AND
            kst_trans = '" . $data['trans'] . "' 
            WHERE kstid != '' " . $where . "
            ORDER BY " . $data['sort'] . " " . $data['order'] . "
            LIMIT " . $data['limit'] . " OFFSET " . $data['offset'] . "
        ");

        $sqlCount = $this->db->query("
            SELECT count(kstid) as num FROM ksr_trans WHERE 
            kst_trans = '" . $data['trans'] . "' AND
            kst_type = '" . $data['type'] . "' AND
            kst_cbid = '" . $data['cbid'] . "' AND
            kst_trans = '" . $data['trans'] . "' AND
            kst_trans = '" . $data['trans'] . "' 
                WHERE kstid != '' " . $where . "
        ");

        return array('result' => $sql->result_array(), 'numrows' => $sqlCount->row()->num);
    }
    
    public function mainCoa($data = array()){
        $this->db->select('coa_kode, coa_desc, coa_flag');
        $this->db->where('coa_cbid', $data['cbid']);
        $this->db->where('coa_is_kas_bank', '1');
        $this->db->where('coa_level', '3');
        $this->db->order_by('coa_kode', 'ASC');
        $sql = $this->db->get('ms_coa');
        return $sql->result_array();
    }
    
    
    
}

?>
