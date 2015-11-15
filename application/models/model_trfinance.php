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
        if ($data['kst_trans'] != 'ADJUSTMENT') {
            if ($this->isValidCoa(array(
                        'coa' => $data['kst_coa'],
                        'cbid' => ses_cabang)) == FALSE)
                return FALSE;
        }

        if ($this->db->insert("ksr_trans", $data) == FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function editMain($data = array(), $where) {
        if ($data['kst_trans'] != 'ADJUSTMENT') {
            if ($this->isValidCoa(array(
                        'coa' => $data['kst_coa'],
                        'cbid' => ses_cabang)) == FALSE)
                return FALSE;
        }
        $this->db->where('kstid', $where);
        if ($this->db->update("ksr_trans", $data) == FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /* INPUT DETAIL TRANSAKSI */

    public function addDetail($data) {
        /* FILTER KELENGKAPAN TRANSAKSI BY JENIS ACCOUNT */
        if ($this->isValidCoa(array(
                    'coa' => $data['dkst_coa'],
                    'cbid' => ses_cabang)) == FALSE)
            return FALSE;

        if ($this->db->insert("ksr_dtrans", $data) == FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function addBank($data) {
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
                if ($main['kst_trans'] != 'ADJUSTMENT') {
                    if ($main['kst_type'] == 'I') {
                        $main['kst_kredit'] = 0;
                    } else if ($main['kst_type'] == 'O') {
                        $main['kst_debit'] = 0;
                    }
                }

                if ($this->addMain($main) == FALSE) {
                    throw new Exception('DUPLIKAT NO TRANSAKSI');
                }
            } else {
                $this->editMain($main, $etc['kstid']);
                log_message('error', 'CEK : ' . $this->db->last_query());
                $this->flagDetail(0, $etc['kstid']);
                $main['kstid'] = $etc['kstid'];
            }

            if (count($detail) < 1) {
                $e = "DETAIL TRANSAKSI KOSONG";
                throw new Exception($e);
            } else {
                if (!empty($detail['coa'][0]))
                    for ($i = 0; $i <= count($detail['coa']) - 1; $i++) {
                        if ($main['kst_trans'] != 'ADJUSTMENT') {
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
                                    'dkst_descrip' => strtoupper($detail['desc'][$i]),
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
                            "trl_headstatus" => '0',
                            "trl_name" => $main['kst_trans'],
                            "trl_trans" => $main['kst_type'],
                            "trl_createon" => date('Y-m-d H:i:s')
                        );
                        if ($main['kst_trans'] != 'ADJUSTMENT') {
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
                                "trl_headstatus" => '1',
                                "trl_name" => $main['kst_trans'],
                                "trl_trans" => $main['kst_type'],
                                "trl_createon" => date('Y-m-d H:i:s')
                            );
                        }
                    }
            }

            if (count($bank) > 0) {
                if ($etc['purpose'] != 'ADD') {
                    $this->db->query("DELETE FROM ksr_dbnk WHERE dbnk_kstid = '" . $main['kstid'] . "'");
                }
                if (!empty($bank['bank'][0])) {
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

    /* INPUT KWITANSI */

    public function addKwitansi($etc = array(), $main = array(), $detail = array(), $bank = array()) {
        $this->db->trans_begin();
        try {
            if ($etc['purpose'] == 'ADD') {
                $tahun = date('y');
                $main['kstid'] = NUM_TRANS . $tahun . sprintf("%08s", $this->getCounter(NUM_TRANS . $tahun));

                if ($this->addMain($main) == FALSE) {
                    throw new Exception('DUPLIKAT NO TRANSAKSI');
                }
            } else {
                $this->editMain($main, $etc['kstid']);
                $this->flagDetail(0, $etc['kstid']);
                $main['kstid'] = $etc['kstid'];
            }

            if (count($detail) < 1) {
                $e = "DETAIL TRANSAKSI KOSONG";
                throw new Exception($e);
            } else {
                if (!empty($detail['coa'][0])) {
                    for ($i = 0; $i <= count($detail['coa']) - 1; $i++) {
                        $kredit = numeric($detail['nominal'][$i]);
                        $debit = 0;
                        if ($this->addDetail(array(
                                    'dkst_kstid' => $main['kstid'],
                                    'dkst_coa' => $detail['coa'][$i],
                                    'dkst_descrip' => strtoupper($detail['desc'][$i]),
                                    'dkst_nota' => strtoupper($detail['nota'][$i]),
                                    'dkst_pelid' => strtoupper($main['kst_pelid']),
                                    'dkst_supid' => '0',
                                    'dkst_ccid' => $detail['ccid'][$i],
                                    'dkst_debit' => 0,
                                    'dkst_kredit' => numeric($detail['nominal'][$i]),
                                    'dkst_flag' => '1',
                                    'dkst_lastupdate' => date('Y-m-d H:i:s')
                                )) == FALSE) {
                            throw new Exception('GAGAL TAMBAH DETAIL');
                        }

                        $arrLog = array(array(
                                "trl_cbid" => ses_cabang,
                                "trl_nomer" => $main['kst_nomer'],
                                'trl_date' => $main['kst_tgl'],
                                "trl_coa" => $detail['coa'][$i],
                                "trl_descrip" => $detail['desc'][$i],
                                "trl_debit" => $debit,
                                "trl_kredit" => $kredit,
                                "trl_croscoa" => $main['kst_coa'],
                                "trl_nota" => $detail['nota'][$i],
                                "trl_pelid" => $main['kst_pelid'],
                                "trl_ccid" => $detail['ccid'][$i],
                                "trl_supid" => '0',
                                "trl_headstatus" => '0',
                                "trl_name" => $main['kst_trans'],
                                "trl_trans" => $main['kst_type'],
                                "trl_createon" => date('Y-m-d H:i:s')
                            ), array(
                                "trl_cbid" => ses_cabang,
                                "trl_nomer" => $main['kst_nomer'],
                                'trl_date' => $main['kst_tgl'],
                                "trl_coa" => $main['kst_coa'],
                                "trl_descrip" => $detail['desc'][$i],
                                "trl_debit" => $kredit,
                                "trl_kredit" => $debit,
                                "trl_croscoa" => $main['kst_coa'],
                                "trl_nota" => $detail['nota'][$i],
                                "trl_pelid" => $main['kst_pelid'],
                                "trl_ccid" => $detail['ccid'][$i],
                                "trl_supid" => '0',
                                "trl_headstatus" => '1',
                                "trl_name" => $main['kst_trans'],
                                "trl_trans" => $main['kst_type'],
                                "trl_createon" => date('Y-m-d H:i:s')
                                ));
                    }
                    /* INSERTING TO LEDGER */
                    $this->db->insert_batch('ksr_ledger', $arrLog);
                } else {
                    $e = "DETAIL TRANSAKSI KOSONG";
                    throw new Exception($e);
                }
            }

            if (count($bank) > 0) {
                if ($etc['purpose'] != 'ADD') {
                    $this->db->query("DELETE FROM ksr_dbnk WHERE dbnk_kstid = '" . $main['kstid'] . "'");
                }
                if (!empty($bank['bank'][0])) {
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

    /* ADD TAG SERVICE */

    public function addTransSeparated($etc = array(), $main = array(), $detail = array(), $bank = array()) {
        try {
            $tahun = date('y');
            $main['kstid'] = NUM_TRANS . $tahun . sprintf("%08s", $this->getCounter(NUM_TRANS . $tahun));
            if ($main['kst_type'] == 'I') {
                $main['kst_kredit'] = 0;
            } else if ($main['kst_type'] == 'O') {
                $main['kst_debit'] = 0;
            }

            if ($this->addMain($main) == FALSE) {
                throw new Exception('DUPLIKAT NO TRANSAKSI');
            }

            if (count($detail) < 1) {
                $e = "DETAIL TRANSAKSI KOSONG";
                throw new Exception($e);
            } else {
                if (!empty($detail['coa'][0])) {
                    for ($i = 0; $i <= count($detail['coa']) - 1; $i++) {
                        if ($main['kst_type'] == 'I') {
                            $kredit = numeric($detail['nominal'][$i]);
                            $debit = 0;
                        } else {
                            $kredit = 0;
                            $debit = numeric($detail['nominal'][$i]);
                        }
                        if ($this->addDetail(array(
                                    'dkst_kstid' => $main['kstid'],
                                    'dkst_coa' => $detail['coa'][$i],
                                    'dkst_descrip' => strtoupper($detail['desc'][$i]),
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
                            "trl_headstatus" => '0',
                            "trl_name" => $main['kst_trans'],
                            "trl_trans" => $main['kst_type'],
                            "trl_createon" => date('Y-m-d H:i:s')
                        );
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
                            "trl_headstatus" => '1',
                            "trl_name" => $main['kst_trans'],
                            "trl_trans" => $main['kst_type'],
                            "trl_createon" => date('Y-m-d H:i:s')
                        );
                    }
                }
                
                /* INSERTING TO LEDGER */
                if ($this->db->insert_batch('ksr_ledger', $arrLog) == FALSE) {
                    throw new Exception('GAGAL TAMBAH DATA KE LEDGER');
                }
            }

        } catch (Exception $e) {
            throw new Exception('GAGAL TAMBAH DATA KE LEDGER');
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

    /* EDIT HEAD TRANSACTION */

    public function editHead($data, $id) {
        $this->db->where("kstid", $id);
        return $this->db->update("ksr_trans", $data);
    }

    /* FLAG DETAIL TO INCATIVE */

    public function flagDetail($data, $id) {
        $this->db->where('dkst_kstid', $id);
        return $this->db->update('ksr_dtrans', array('dkst_flag' => $data));
    }

    public function cancelTrans($data) {
        $this->db->trans_begin();
        try {
            $this->db->query("UPDATE ksr_trans SET kst_cancel = 1,
                            kst_canceler = '" . ses_username . "', kst_cancelon = '" . date('Y-m-d H:i:s') . "'
                            WHERE kstid = '" . $data['kstid'] . "'");
            $this->db->query("UPDATE ksr_dtrans SET dkst_flag = '0' WHERE dkst_kstid = '" . $data['kstid'] . "'");
            $main = $this->getMainTrans($data);
            $this->db->query("DELETE FROM ksr_ledger WHERE trl_nomer = '" . $main['kst_nomer'] . "'
                    AND trl_name = '" . $main['kst_trans'] . "' AND trl_trans = '" . $main['kst_type'] . "'
                    AND trl_cbid = '" . $main['kst_cbid'] . "'");
            if ($this->db->trans_status() == TRUE) {
                $this->db->trans_commit();
                return TRUE;
            } else {
                throw new Exception('GAGAL BATAL DATA');
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            return FALSE;
        }
    }

    /* FLAG PRINT STATUS */

    public function updatePrintStat($id) {
        $this->db->where('kstid', $id);
        if ($this->db->update('ksr_trans', array('kst_printed' => '1',
                    'kst_printedon' => date('Y-m-d H:i:s'),
                    'kst_printedby' => ses_username)) == TRUE) {
            return array('status' => '1', 'msg' => 'TRANSAKSI BERHASIL DICETAK');
        } else {
            return array('status' => '0', 'msg' => 'TRANSAKSI GAGAL DICETAK');
        }
    }

    public function flagBank($data, $id) {
        $this->db->where('dbnk_kstid', $id);
        return $this->db->update('ksr_dbnk', array('dbnk_flag' => $data));
    }

    /* LOAD DATAGRID TRANSAKSI */

    public function addSubTrans($etc = array(), $main = array(), $detail = array(), $bank = array()) {
        $this->db->trans_begin();
        try {
            if ($etc['purpose'] == 'ADD') {
                $tahun = date('y');
                $main['kstid'] = NUM_TRANS . $tahun . sprintf("%08s", $this->getCounter(NUM_TRANS . $tahun));
                if ($main['kst_type'] == 'I') {
                    $main['kst_kredit'] = 0;
                } else if ($main['kst_type'] == 'O') {
                    $main['kst_debit'] = 0;
                }

                $this->addMain($main);
            } else {
                $this->editMain($main, $etc['kstid']);
                $this->flagDetail(0, $etc['kstid']);
                $main['kstid'] = $etc['kstid'];
            }

            if (count($detail) < 1) {
                $e = "DETAIL TRANSAKSI KOSONG";
                throw new Exception($e);
            } else {
                if (!empty($detail['nota'][0]))
                    for ($i = 0; $i <= count($detail['coa']) - 1; $i++) {
                        if ($main['kst_trans'] != 'ADJUST') {
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
                                    'dkst_coa' => $detail['coa'],
                                    'dkst_descrip' => strtoupper($detail['desc']),
                                    'dkst_nota' => strtoupper($detail['nota'][$i]),
                                    'dkst_pelid' => strtoupper($detail['pelid']),
                                    'dkst_supid' => strtoupper($detail['supid']),
                                    'dkst_ccid' => $detail['ccid'],
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
                            "trl_descrip" => $detail['desc'],
                            "trl_debit" => $debit,
                            "trl_kredit" => $kredit,
                            "trl_croscoa" => $main['kst_coa'],
                            "trl_nota" => $detail['nota'][$i],
                            "trl_pelid" => $detail['pelid'],
                            "trl_ccid" => $detail['ccid'][$i],
                            "trl_supid" => $detail['supid'][$i],
                            "trl_headstatus" => '0',
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
                                "trl_descrip" => $detail['desc'],
                                "trl_debit" => $kredit,
                                "trl_kredit" => $debit,
                                "trl_croscoa" => $main['kst_coa'],
                                "trl_nota" => $detail['nota'][$i],
                                "trl_pelid" => $detail['pelid'],
                                "trl_ccid" => $detail['ccid'],
                                "trl_supid" => $detail['supid'],
                                "trl_headstatus" => '1',
                                "trl_name" => $main['kst_trans'],
                                "trl_trans" => $main['kst_type'],
                                "trl_createon" => date('Y-m-d H:i:s')
                            );
                        }
                    }
            }

            if (count($bank['bank']) > 0) {
                if (!empty($bank['bank'][0]))
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

    public function loadtrans($data) {
        $data['subtrans'] = isset($data['subtrans']) ? $data['subtrans'] : '0';
        $sql = $this->db->query("
            SELECT
                kstid,kst_tgl,kst_nomer,kst_trans,kst_coa,
                coa_desc as kst_desc,kst_debit,kst_kredit,kst_printed,
                kst_cancel,pel_nama, 
                CASE WHEN kst_cancel = 1 THEN 'DIBATALKAN'
                     WHEN kst_printed = '1' THEN 'TERCETAK' 
                     WHEN kst_printed = '0' or kst_printed is null THEN 'BLM DICETAK'
                END AS kst_status
            FROM
                ksr_trans
            LEFT JOIN ksr_dtrans ON dkst_kstid = kstid
            LEFT JOIN ms_pelanggan ON pelid = kst_pelid
            LEFT JOIN ms_coa ON coa_kode = kst_coa and coa_cbid = kst_cbid
            WHERE
                kst_trans LIKE '" . $data['trans'] . "%'
                AND kst_type = '" . $data['type'] . "'
                AND kst_sub_trans = " . $data['subtrans'] . "
            GROUP BY
                kstid,kst_tgl,kst_nomer,kst_trans,kst_coa,
                coa_desc,kst_debit,kst_kredit,kst_printed,
                kst_cancel,pel_nama
            ORDER BY " . $data['sidx'] . " " . $data['sord'] . " 
            LIMIT " . $data['limit'] . " OFFSET " . $data['start'] . " 
        ");

        $sqlCount = $this->db->query("SELECT
                count (kstid) as total
            FROM
                ksr_trans
            LEFT JOIN ksr_dtrans ON dkst_kstid = kstid
            LEFT JOIN ms_pelanggan ON pelid = dkst_pelid
            LEFT JOIN ms_coa ON coa_kode = kst_coa and coa_cbid = kst_cbid
            WHERE
                kst_trans LIKE '" . $data['trans'] . "%'
                AND kst_type = '" . $data['type'] . "'
                AND kst_sub_trans = " . $data['subtrans'] . "
            GROUP BY
                kstid,kst_tgl,kst_nomer,kst_trans,kst_coa,
                coa_desc,kst_debit,kst_kredit,kst_printed,
                kst_cancel,pel_nama
        ");

        return array('result' => $sql->result(), 'numrows' => $sqlCount->row()->total);
    }

    public function loadSubTrans($data) {
        $sql = $this->db->query("
            SELECT
                kstid,kst_tgl,kst_nomer,kst_trans,kst_coa,
                kst_desc,kst_debit,kst_kredit,kst_printed,
                kst_cancel,pel_nama, 
                CASE WHEN kst_printed = '1' THEN 'TERCETAK' 
                ELSE 'BLM DICETAK' END AS kst_status
            FROM
                ksr_trans
            LEFT JOIN ksr_dtrans ON dkst_kstid = kstid
            LEFT JOIN ms_pelanggan ON pelid = dkst_pelid
            WHERE
                kst_sub_trans = " . $data['subtrans'] . "
                AND kst_type = '" . $data['type'] . "'
            GROUP BY
                kstid,kst_tgl,kst_nomer,kst_trans,kst_coa,
                kst_desc,kst_debit,kst_kredit,kst_printed,
                kst_cancel,pel_nama
            ORDER BY " . $data['sidx'] . " " . $data['sord'] . " 
            LIMIT " . $data['limit'] . " OFFSET " . $data['start'] . " 
        ");

        $sqlCount = $this->db->query("SELECT
                count (kstid) as total
            FROM
                ksr_trans
            LEFT JOIN ksr_dtrans ON dkst_kstid = kstid
            LEFT JOIN ms_pelanggan ON pelid = dkst_pelid
            WHERE
                kst_sub_trans = " . $data['subtrans'] . "
                AND kst_type = '" . $data['type'] . "'
            GROUP BY
                kstid,kst_tgl,kst_nomer,kst_trans,kst_coa,
                kst_desc,kst_debit,kst_kredit,kst_printed,
                kst_cancel,pel_nama
        ");

        return array('result' => $sql->result(), 'numrows' => $sqlCount->row()->total);
    }

    public function getMainCoa($data = array()) {
        $type = $data['type'] == '-1' ?
                " AND coa_is_kas_bank != '0' " :
                " AND coa_is_kas_bank = '" . $data['type'] . "'";
        $sql = $this->db->query("
            SELECT * FROM ms_coa 
            WHERE coa_cbid = '" . $data['cbid'] . "' 
                " . $type . " AND coa_level != '1'
        ");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }

    public function getMainTrans($data = array()) {
        $sql = $this->db->query("
            SELECT 
            kstid,kst_cbid,kst_type,kst_nomer,kst_coa,kst_debit,kst_kredit,kst_trans, kst_pelid,
            pel_nama,
            kst_printed,kst_printedon,kst_printedby,kst_createby,kst_createon,kst_cancel,
            kst_canceler,kst_cancelon,kst_lastupdate,kst_desc,kst_noreff,kst_tgl,kst_sub_trans
            FROM 
            ksr_trans 
            LEFT JOIN ms_pelanggan on pelid = kst_pelid
            WHERE kstid = '" . $data['kstid'] . "'");

        return $sql->row_array();
    }

    public function getDetailTrans($data = array()) {
        $sql = $this->db->query("
            SELECT 
            dkst_kstid,dkst_coa,dkst_descrip,dkst_debit,dkst_kredit,dkst_nota,
            dkst_pelid,dkst_supid,dkst_norangka,dkst_bank,dkst_ccid,dkst_flag,
            dkst_lastupdate, pel_nama, sup_nama
            FROM 
            ksr_dtrans 
            LEFT JOIN ms_pelanggan on pelid = dkst_pelid
            LEFT JOIN ms_supplier on supid = dkst_supid
            WHERE dkst_kstid = '" . $data['kstid'] . "'
                AND dkst_flag = 1");

        return $sql->result_array();
    }

    public function getDetailBank($data = array()) {
        $sql = $this->db->query("
            SELECT 
                dbnk_kstid,dbnk_bankid, bank_name as dbnk_banknama, dbnk_norek,dbnk_nocek,dbnk_jtempo,dbnk_kotaid,
                dbnk_nominal,dbnk_flag,dbnk_lastupdate, kota_deskripsi as dbnk_kotanama
            FROM 
            ksr_dbnk
            LEFT JOIN ms_bank on bankid = dbnk_bankid
            LEFT JOIN ms_kota on kotaid = dbnk_kotaid
            WHERE dbnk_kstid = '" . $data['kstid'] . "'
                AND dbnk_flag = 1");

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

    public function saveTagihanService($etc = array(), $data = array()) {
        $this->db->trans_begin();
        try {
            $this->load->model(array('model_auto_jurnal'));
            $dataToJurnal = $this->model_auto_jurnal->getInvoiceForJurnal($etc);
            $this->model_auto_jurnal->autoJurnalService($dataToJurnal);
            if (count($data) > 0) {
                for ($i = 0; $i <= count($data) - 1; $i++) {
                    $this->addTransSeparated($data[$i]['etc'], $data[$i]['main'], $data[$i]['detail'], $data[$i]['bank']);
                }
            }
            if($this->db->trans_status() == TRUE){
                $this->db->trans_commit();
                return array('status' => TRUE, 'msg' => 'Tagihan service berhasil disimpan');
            }else{
                throw new Exception('FAILS AT ALL');
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            return array('status' => FALSE, 'msg' => 'Tagihan service gagal disimpan');
        }
    }

}

?>
