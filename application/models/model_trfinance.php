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

    /* INPUT MAIN TRANSAKSI */

    public function addMain($data = array()) {
        if ($data['kst_trans'] != 'ADJUST') {
            if ($this->isValidCoa(array(
                        'coa' => $data['kst_coa'],
                        'cbid' => $data['kst_cbid'])) == FALSE)
                return FALSE;
        }

        /* FILTER ACCOUNT BY JENIS TRANSAKSI */

        if ($this->db->insert("kst_trans", $data) == FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /* INPUT DETAIL TRANSAKSI */

    public function addDetail($data) {
        /* FILTER KELENGKAPAN TRANSAKSI BY JENIS ACCOUNT */

        if ($this->db->insert("kst_dtrans", $data) == FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /* INPUT TRANSAKSI */

    public function addTrans($main = array(), $detail = array()) {
        $this->db->trans_begin();
        try {

            $this->addMain($main);

            if (count($detail) < 1) {
                $e = "DETAIL TRANSAKSI KOSONG";
                throw new Exception($e);
            } else {
                for ($i = 0; $i <= count($detail) - 1; $i++) {
                    $this->addDetail(array(
                        'dkst_kstid' => $main['kst_kstid'],
                        'dkst_coa' => $detail['coa'][$i],
                        'dkst_decrip' => $detail['coa'][$i],
                        'dkst_nota' => $detail['coa'][$i],
                        'dkst_pelid' => $detail['coa'][$i],
                        'dkst_supkode' => $detail['coa'][$i],
                        'dkst_lastupdate' => $detail['coa'][$i]
                    ));
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
            return array('status' => TRUE, 'msg' => 'INPUT DATA BERHASIL');
        }
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
}

?>
