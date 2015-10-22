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

    public function isDuplikat($data = array()) {
        $query = "SELECT count(kst_nomer) as tot FROM ksr_trans WHERE 
            kst_trans = '" . $data['kst_trans'] . "' AND kst_cbid = '" . $data['kst_cbid'] . "' AND 
            kst_nomer = '" . $data['kst_nomer'] . "' AND kst_type = '" . $data['kst_type'] . "'";
        $sql = $this->db->query($query);
        if ($sql->row()->tot > 0) {
            return TRUE;
        } else {
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

    public function addBank($data) {
        /* FILTER KELENGKAPAN TRANSAKSI BY JENIS ACCOUNT */

        if ($this->db->insert("ksr_dbnk", $data) == FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /* INPUT TRANSAKSI */

    public function addTrans($etc = array(), $main = array(), $detail = array(), $bank = array()) {
        $this->db->trans_begin();
        try {
            if ($etc['purpose'] == 'ADD') {
                $tahun = date('y');
                $main['kstid'] = NUM_TRANS . $tahun . sprintf("%08s", $this->getCounter(NUM_TRANS . $tahun));
                if ($main['kst_type'] == 'I') {
                    $main['kst_kredit'] = 0;
                } else {
                    $main['kst_debit'] = 0;
                }
                $this->addMain($main);
            } else {
                $this->editMain($main, $etc['kstid']);
                $this->flagDetail($detail);
            }

            if (count($detail) < 1) {
                $e = "DETAIL TRANSAKSI KOSONG";
                throw new Exception($e);
            } else {
                if(!empty($detail['coa'][0]))
                for ($i = 0; $i <= count($detail['coa']) - 1; $i++) {
                    if ($main['kst_trans'] != 'ADJ') {
                        if ($main['kst_type'] == 'I') {
                            $kredit = numeric($detail['nominal'][$i]);
                            $debit = 0;
                        } else {
                            $kredit = 0;
                            $debit = numeric($detail['nominal'][$i]);
                        }
                    } else {
                        $debit = numeric($detail['debit'][$i]);
                        $kredit = numeric($detail['kredit'][$i]);
                    }
                    if ($this->addDetail(array(
                                'dkst_kstid' => $main['kstid'],
                                'dkst_coa' => $detail['coa'][$i],
                                'dkst_decrip' => strtoupper($detail['desc'][$i]),
                                'dkst_nota' => strtoupper($detail['nota'][$i]),
                                'dkst_pelid' => strtoupper($detail['pelid'][$i]),
                                'dkst_supid' => strtoupper($detail['supid'][$i]),
                                'dkst_ccid' => $detail['ccid'][$i],
                                'dkst_debit' => $debit,
                                'dkst_kredit' => $kredit,
                                'dkst_flag' => '1',
                                'dkst_lastupdate' => date('Y-m-d H:i:s')
                            )) == FALSE) {
                        throw new Exception('GAGAL TAMBAH DETAIL');
                    }

                    $arrLog[] = array(
                        "trl_cbid" => ses_cabang,
                        "trl_nomer" => $main['kst_nomer'],
                        'trl_date' => $main['kst_tgl'],
                        "trl_coa" => $detail['coa'][$i],
                        "trl_descrip" => $detail['desc'][$i],
                        "trl_debit" => $debit,
                        "trl_kredit" => $kredit,
                        "trl_croscoa" => $main['kst_coa'],
                        "trl_nota" => $detail['nota'][$i],
                        "trl_pelid" => $detail['pelid'][$i],
                        "trl_ccid" => $detail['ccid'][$i],
                        "trl_supid" => $detail['supid'][$i],
                        "trl_headstatus" => '1',
                        "trl_name" => $main['kst_trans'],
                        "trl_trans" => $main['kst_type'],
                        "trl_createon" => date('Y-m-d H:i:s')
                    );
                    if ($main['kst_trans'] != 'ADJ') {
                        $arrLog[] = array(
                            "trl_cbid" => ses_cabang,
                            "trl_nomer" => $main['kst_nomer'],
                            'trl_date' => $main['kst_tgl'],
                            "trl_coa" => $main['kst_coa'],
                            "trl_descrip" => $detail['desc'][$i],
                            "trl_debit" => $kredit,
                            "trl_kredit" => $debit,
                            "trl_croscoa" => $main['kst_coa'],
                            "trl_nota" => $detail['nota'][$i],
                            "trl_pelid" => $detail['pelid'][$i],
                            "trl_ccid" => $detail['ccid'][$i],
                            "trl_supid" => $detail['supid'][$i],
                            "trl_headstatus" => '0',
                            "trl_name" => $main['kst_trans'],
                            "trl_trans" => $main['kst_type'],
                            "trl_createon" => date('Y-m-d H:i:s')
                        );
                    }
                }
            }

            if (count($bank['bank']) > 0) {
                if(!empty($bank['bank'][0]))
                for ($i = 0; $i <= count($bank['bank']) - 1; $i++) {
                    if ($this->addBank(array(
                                'dbnk_kstid' => $main['kstid'],
                                'dbnk_bankid' => $bank['bank'][$i],
                                'dbnk_norek' => $bank['norek'][$i],
                                'dbnk_nocek' => $bank['nocek'][$i],
                                'dbnk_jtempo' => dateToIndo($bank['jtempo'][$i]),
                                'dbnk_kotaid' => $bank['kota'][$i],
                                'dbnk_nominal' => numeric($bank['nominal'][$i]),
                                'dbnk_flag' => '1',
                                'dbnk_lastupdate' => date('Y-m-d H:i:s')
                            )) == FALSE) {
                        throw new Exception('GAGAL TAMBAH DETAIL BANK');
                    }
                }
            }

            /* INSERTING TO LEDGER */
            $this->db->insert_batch('ksr_ledger', $arrLog);
            

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

    /* ADD TRANSACTION TO LEDGER */

    public function addLedger($etc = array(), $data = array()) {
        $this->db->insert('ksr_ledger', $data);
    }

    /* ADD TO LEDGER COUPLES TRANSACTION */

    public function addSiblingLedger($arrLog = array(), $arrCLog = array()) {
        $arrLog = array(
            'tr_cbid' => $main->tr_cbid,
            'tr_nomer' => $main->tr_nomer,
            'tr_kodeid' => $detail['tr_kodeid'],
            'tr_croskode' => $main->tr_kodeid,
            'tr_name' => $transname,
            'tr_date' => $main->tr_date,
            'tr_descrip' => $detail['tr_descrip'],
            'tr_nota' => strtoupper($detail['tr_nospk']),
            'tr_nodoc' => strtoupper($detail['tr_nodoc']),
            'tr_supkode' => strtoupper($supkode),
            'tr_ccid' => $detail['tr_ccid'],
            'tr_debit' => $detail['tr_debit'],
            'tr_kredit' => $detail['tr_kredit'],
            'tr_head' => 0,
            'tr_flag' => $main->tr_flag
        );
        $arrCLog = array(
            'tr_cbid' => $main->tr_cbid,
            'tr_nomer' => $main->tr_nomer,
            'tr_kodeid' => $main->tr_kodeid,
            'tr_croskode' => $detail['tr_kodeid'],
            'tr_name' => $transname,
            'tr_date' => $main->tr_date,
            'tr_descrip' => $detail['tr_descrip'],
            'tr_nota' => strtoupper($detail['tr_nospk']),
            'tr_nodoc' => strtoupper($detail['tr_nodoc']),
            'tr_supkode' => strtoupper($supkode),
            'tr_ccid' => $detail['tr_ccid'],
            'tr_debit' => $detail['tr_kredit'],
            'tr_kredit' => $detail['tr_debit'],
            'tr_head' => 1,
            'tr_flag' => $main->tr_flag
        );
    }

    public function getDetailTrans($data) {
        $query = "SELECT dkst_kstid, dkst_ FROM dkst_dtrans 
            WHERE 
            dkst_kstid = '" . $data['kstid'] . "'";
    }

    /* EDIT HEAD TRANSACTION */

    public function editHead($data, $id) {
        $this->db->where("kstid", $id);
        return $this->db->update("ksr_trans", $data);
    }

    /* FLAG DETAIL TO INCATIVE */

    public function flagDetail($data, $id) {
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

    public function getMainCoa($data = array()) {
        $type = $data['type'] == '-1' ? 
            " AND coa_is_kas_bank != '0' " :
            " AND coa_is_kas_bank = '".$data['type']."'";
        $sql = $this->db->query("
            SELECT * FROM ms_coa 
            WHERE coa_cbid = '" . $data['cbid'] . "' 
                ".$type." AND coa_level != '1'
        ");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }
    
    public function getMainTrans($data = array()){
        $sql = $this->db->query("
            SELECT * FROM ksr_trans WHERE kst_id = '".$data['kstid']."'
        ");
        return $sql->result_array();
    }
    
    public function getSettingCoa($data) {
        $query = $this->db->query("SELECT setcoa_kode, setcoa_specid FROM ms_coa_setting 
            WHERE setcoa_cbid = '" . $data . "'");
        $sql = $query->result_array();
        $temp = array();
        foreach ($sql as $row) {
            $temp[$row['setcoa_specid']] = $row['setcoa_kode'];
        }

        return $temp;
    }

}

?>
