<?php

/**
 * The MODEL TRANSAKSI FINANCE
 * @author Rossi Erl
 * 2015-08-29
 */
class Model_Auto_jurnal extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /* @param array('cbid' => string, 'kodeJurnal' => 'string'  ) */

    public function getJurnalCode($data = array()) {
        $sql = $this->db->query(" SELECT
            dtipe_cbid,
            dtipe_tipeid,
            dtipe_constant,
            dtipe_coa,
            dtipe_flag       
            FROM ms_dtipe_jurnal WHERE 
            dtipe_cbid = '" . $data['cbid'] . "' 
                AND dtipe_tipeid = '" . $data['type'] . "'
        ");
        $constant = array();

        if ($sql->num_rows() > 0) {
            $retData['status'] = TRUE;
            foreach ($sql->result_array() as $rows) {
                $constant[$rows['dtipe_constant']] = $rows['dtipe_coa'];
            }

            if ($data['type'] == JURNAL_SELUNIT) {
                $retData['piutang'] = $constant['A'];
                $retData['penjualan'] = $constant['B'];
                $retData['ppn'] = $constant['C'];
                $retData['bbn'] = $constant['D'];
                $retData['aksesoris'] = $constant['E'];
                $retData['hpp'] = $constant['F'];
                $retData['persediaan'] = $constant['G'];
            } else if ($data['type'] == JURNAL_SELSERV) {
                $retData['piutang'] = $constant['A'];
                $retData['penj_lc'] = $constant['B'];
                $retData['penj_oli'] = $constant['C'];
                $retData['penj_spart'] = $constant['D'];
                $retData['penj_sm'] = $constant['E'];
                $retData['penj_so'] = $constant['F'];
                $retData['ppn'] = $constant['G'];
                $retData['hpp_lc'] = $constant['H'];
                $retData['hpp_oli'] = $constant['I'];
                $retData['hpp_spart'] = $constant['J'];
                $retData['hpp_sm'] = $constant['K'];
                $retData['hpp_so'] = $constant['L'];
                $retData['persediaan_oli'] = $constant['M'];
                $retData['pen_so'] = $constant['N'];
            } else if ($data['type'] == JURNAL_SELSPAR) {
                $retData['piutang'] = $constant['A'];
                $retData['penjualan'] = $constant['B'];
                $retData['ppn'] = $constant['C'];
                $retData['hpp'] = $constant['D'];
                $retData['persediaan'] = $constant['E'];
            } else if ($data['type'] == JURNAL_BUYUNIT) {
                $retData['piutang'] = $constant['A'];
                $retData['penjualan'] = $constant['B'];
                $retData['ppn'] = $constant['C'];
                $retData['hpp'] = $constant['D'];
                $retData['persediaan'] = $constant['E'];
            } else if ($data['type'] == JURNAL_BUYSPAR) {
                $retData['hutang'] = $constant['A'];
                $retData[''] = $constant['B'];
                $retData['ppn'] = $constant['C'];
                $retData['hpp'] = $constant['D'];
                $retData['persediaan'] = $constant['E'];
            }

            return $retData;
        } else {
            return array('status' => FALSE);
        }
    }

//    public function getInvoiceForJurnal($data) {
//        $query = ;
//       
//        log_message('error', 'CEK ERROR: '.$this->db->last_query());
//        return $query->row_array();
//    }

    /* AUTO JURNAL PENJUALAN SERVICE */

    public function autoJurnalSelserv($woid) {
        $sql = $this->db->query("SELECT * FROM svc_invoice LEFT JOIN svc_wo ON woid = inv_woid"
                . " LEFT JOIN ms_car ON mscid = wo_mscid LEFT JOIN ms_pelanggan ON pelid = wo_pelid"
                . " WHERE inv_woid = '$woid' AND inv_tagihan = 0");
        $data = $sql->row_array();
        $ppn = $data['inv_lc'] * 0.1;
        $jurnalCode = $this->getJurnalCode(array('type' => JURNAL_SELSERV, 'cbid' => ses_cabang));

        if ($jurnalCode['status'] == FALSE)
            return FALSE;
        $basicArray = array(
            'trl_nomer' => $data['inv_woid'],
            'trl_name' => 'SELSERV',
            'trl_date' => $data['inv_tgl'],
            'trl_descrip' => 'JUAL : SERVICE ' . $data['pel_nama'] . "(" . $data['msc_nopol'] . ")" . $data['wo_nomer'],
            'trl_cbid' => $data['inv_cbid'],
            'trl_nota' => $data['inv_woid'],
            'trl_pelid' => $data['wo_pelid'],
            'trl_supid' => '0',
            'trl_debit' => 0,
            'trl_kredit' => 0,
            'trl_ccid' => 0,
            'trl_automatic' => 0,
            'trl_breakdown_code' => 0
        );

        $orderedArray = array();
        /* PIUTANG SERVICE - DEBIT */
        array_push($orderedArray, $basicArray);
        $orderedArray[0]['trl_coa'] = $jurnalCode['piutang'];
        $orderedArray[0]['trl_debit'] = $data['inv_total'];

        /* PENJUALAN LC - KREDIT */
        array_push($orderedArray, $basicArray);
        $orderedArray[1]['trl_coa'] = $jurnalCode['penj_lc'];
        $orderedArray[1]['trl_kredit'] = $data['inv_lc'] / 1.1;

        /* PENJUALAN OLI - KREDIT */
        array_push($orderedArray, $basicArray);
        $orderedArray[2]['trl_coa'] = $jurnalCode['penj_oli'];
        $orderedArray[2]['trl_kredit'] = $data['inv_oli'] / 1.1;

        /* PENJUALAN SPARTS - KREDIT */
        array_push($orderedArray, $basicArray);
        $orderedArray[3]['trl_coa'] = $jurnalCode['penj_spart'];
        $orderedArray[3]['trl_kredit'] = $data['inv_spart'] / 1.1;

        /* PENJUALAN SUB ORDER - KREDIT */
        array_push($orderedArray, $basicArray);
        $orderedArray[4]['trl_coa'] = $jurnalCode['penj_so'];
        $orderedArray[4]['trl_kredit'] = $data['inv_so'] / 1.1;

        /* PIUTANG PENJUALAN SUB MATERIAL - KREDIT */
        array_push($orderedArray, $basicArray);
        $orderedArray[5]['trl_coa'] = $jurnalCode['penj_sm'];
        $orderedArray[5]['trl_kredit'] = $data['inv_sm'] / 1.1;

        /* HUTANG PAJAK PPN - KREDIT */
        array_push($orderedArray, $basicArray);
        $orderedArray[6]['trl_coa'] = $jurnalCode['ppn'];
        $orderedArray[6]['trl_kredit'] = $ppn;

        /* HPP OLI - DEBIT */
        array_push($orderedArray, $basicArray);
        $orderedArray[7]['trl_coa'] = $jurnalCode['hpp_oli'];
        $orderedArray[7]['trl_debit'] = $data['inv_hpp_oli'];

        /* HPP SPART - DEBIT */
        array_push($orderedArray, $basicArray);
        $orderedArray[8]['trl_coa'] = $jurnalCode['hpp_spart'];
        $orderedArray[8]['trl_debit'] = $data['inv_hpp_spart'];

        /* HPP SUB ORDER - DEBIT */
        array_push($orderedArray, $basicArray);
        $orderedArray[9]['trl_coa'] = $jurnalCode['hpp_so'];
        $orderedArray[9]['trl_debit'] = $data['inv_hpp_so'];

        /* HPP SUB MATERIAL - DEBIT */
        array_push($orderedArray, $basicArray);
        $orderedArray[10]['trl_coa'] = $jurnalCode['hpp_sm'];
        $orderedArray[10]['trl_debit'] = $data['inv_hpp_sm'];

        /* PERSEDIAAN OLI - KREDIT ( hpp_oli + hpp_sm + hpp_spart) */
        array_push($orderedArray, $basicArray);
        $orderedArray[11]['trl_coa'] = $jurnalCode['persediaan_oli'];
        $orderedArray[11]['trl_kredit'] = ($data['inv_hpp_oli'] + $data['inv_hpp_spart'] + $data['inv_hpp_sm'] );

        /* PENERIMAAN SO - KREDIT */
        array_push($orderedArray, $basicArray);
        $orderedArray[12]['trl_coa'] = $jurnalCode['pen_so'];
        $orderedArray[12]['trl_kredit'] = $data['inv_hpp_so'];
        $this->db->insert_batch('ksr_ledger', $orderedArray);
    }

    /* AUTO JURNAL PENJUALAN SERVICE */

    public function autoJurnalSelspar($data = array()) {
        $total = $data['inv_lc'] + $data['inv_oli'] + $data['inv_sm'] + $data['inv_so'] + $data['inv_spart'];
        $ppn = $total * (1 / 10);
        $totalpiutang = $total + $ppn;
        $jurnalCode = $this->getJurnalCode(array('type' => JURNAL_SELSERV, 'cbid' => ses_cabang));

        if ($jurnalCode['status'] == FALSE)
            return FALSE;

        $basicArray = array(
            'trl_nomer' => $data['not_kode'],
            'trl_name' => 'SELSPAR',
            'trl_date' => $data['inv_tgl'],
            'trl_descrip' => 'JUAL : SERVICE ' . $data['pel_nama'] . "(" . $data['msc_nopol'] . ")" . $data['wo_nomer'],
            'trl_cbid' => $data['inv_cbid'],
            'trl_nota' => $data['inv_woid'],
            'trl_pelid' => $data['wo_pelid'],
            'trl_supid' => '0',
            'trl_debit' => 0,
            'trl_kredit' => 0,
            'trl_ccid' => 0,
            'trl_automatic' => 0,
            'trl_breakdown_code' => 0
        );

        $orderedArray = array();

        /* PIUTANG SERVICE - DEBIT */
        array_push($orderedArray, $basicArray);
        $orderedArray[0]['trl_coa'] = $jurnalCode['piutang'];
        $orderedArray[0]['trl_debit'] = $totalpiutang;

        /* PENJUALAN LC - KREDIT */
        array_push($orderedArray, $basicArray);
        $orderedArray[1]['trl_coa'] = $jurnalCode['penj_lc'];
        $orderedArray[1]['trl_kredit'] = $data['inv_lc'];

        /* PENJUALAN OLI - KREDIT */
        array_push($orderedArray, $basicArray);
        $orderedArray[2]['trl_coa'] = $jurnalCode['penj_oli'];
        $orderedArray[2]['trl_kredit'] = $data['inv_oli'];

        /* PENJUALAN SPARTS - KREDIT */
        array_push($orderedArray, $basicArray);
        $orderedArray[3]['trl_coa'] = $jurnalCode['penj_spart'];
        $orderedArray[3]['trl_kredit'] = $data['inv_spart'];

        /* PENJUALAN SUB ORDER - KREDIT */
        array_push($orderedArray, $basicArray);
        $orderedArray[4]['trl_coa'] = $jurnalCode['penj_so'];
        $orderedArray[4]['trl_kredit'] = $data['inv_so'];

        /* PIUTANG PENJUALAN SUB MATERIAL - KREDIT */
        array_push($orderedArray, $basicArray);
        $orderedArray[5]['trl_coa'] = $jurnalCode['penj_sm'];
        $orderedArray[5]['trl_kredit'] = $data['inv_sm'];

        /* HUTANG PAJAK PPN - KREDIT */
        array_push($orderedArray, $basicArray);
        $orderedArray[6]['trl_coa'] = $jurnalCode['ppn'];
        $orderedArray[6]['trl_kredit'] = $ppn;

        /* HPP OLI - DEBIT */
        array_push($orderedArray, $basicArray);
        $orderedArray[7]['trl_coa'] = $jurnalCode['hpp_oli'];
        $orderedArray[7]['trl_debit'] = $data['inv_hpp_oli'];

        /* HPP SPART - DEBIT */
        array_push($orderedArray, $basicArray);
        $orderedArray[8]['trl_coa'] = $jurnalCode['hpp_spart'];
        $orderedArray[8]['trl_debit'] = $data['inv_hpp_spart'];

        /* HPP SUB ORDER - DEBIT */
        array_push($orderedArray, $basicArray);
        $orderedArray[9]['trl_coa'] = $jurnalCode['hpp_so'];
        $orderedArray[9]['trl_debit'] = $data['inv_hpp_so'];

        /* HPP SUB MATERIAL - DEBIT */
        array_push($orderedArray, $basicArray);
        $orderedArray[10]['trl_coa'] = $jurnalCode['hpp_sm'];
        $orderedArray[10]['trl_debit'] = $data['inv_hpp_sm'];

        /* PERSEDIAAN OLI - KREDIT ( hpp_oli + hpp_sm + hpp_spart) */
        array_push($orderedArray, $basicArray);
        $orderedArray[11]['trl_coa'] = $jurnalCode['persediaan_oli'];
        $orderedArray[11]['trl_kredit'] = ($data['inv_hpp_oli'] + $data['inv_hpp_spart'] + $data['inv_hpp_sm'] );

        /* PENERIMAAN SO - KREDIT */
        array_push($orderedArray, $basicArray);
        $orderedArray[12]['trl_coa'] = $jurnalCode['pen_so'];
        $orderedArray[12]['trl_kredit'] = $data['inv_hpp_so'];

        if ($this->db->insert_batch('ksr_ledger', $orderedArray) == FALSE) {
            throw new Exception('AUTO JURNAL PENJUALAN SERVICE GAGAL');
        }
    }

    /* AUTO JURNAL PENERIMAAN KENDARAAN */

    public function autoJurnalTerimaUnit($data, $mode) {
        $kode = ($mode == 'RETURN') ? $data['rtb_no'] : $data['bpk_no'];
        $bpkkode = $data['bpk_kode'];
        $status = $data['bpk_status'];
        $condition = $data['bpk_condition'];
        $cbrid = $data['bpk_cbrid'];
        $supkode = empty($data['bpk_supkode']) ? $data['bpk_cabang'] : $data['bpk_supkode'];
        $norangka = $data['bpk_norangka'];
        $tgl_now = ($mode == 'RETURN') ? $data['rtb_date'] : $data['bpk_date'];
        $month = date('m', strtotime($tgl_now));
        $year = date('Y', strtotime($tgl_now));
        $cbid = ses_cabang;
        $back = array('status' => FALSE, 'errmsg' => 'Fails at All');
        $arrData = array(
            "bpk_hbmrgn" => (empty($data['bpk_holdback'])) ? 0 : $data['bpk_holdback'],
            "bpk_accesor" => (empty($data['bpk_accesor'])) ? 0 : $data['bpk_accesor'],
            "bpk_statin" => (empty($data['bpk_statin'])) ? 0 : $data['bpk_statin'],
            "bpk_hpp" => (empty($data['bpk_hpp'])) ? 0 : $data['bpk_hpp'],
            "bpk_ff" => (empty($data['bpk_ff'])) ? 0 : $data['bpk_ff'],
            "bpk_disc" => (empty($data['bpk_disc'])) ? 0 : $data['bpk_disc'],
            "bpk_ppnbm" => (empty($data['bpk_ppnbm'])) ? 0 : $data['bpk_ppnbm'],
            "bpk_pph22" => (empty($data['bpk_pph22'])) ? 0 : $data['bpk_pph22'],
            "bpk_depro" => (empty($data['bpk_deprom'])) ? 0 : $data['bpk_deprom']
        );

        /* get ONGKIR AGAC 
         * * by ma'ruf
         */
        $ongkir = $this->get_ongkir($bpkkode);
        $hut_ongkir = (!empty($ongkir) && $tgl_now >= "2014-06-01") ? $ongkir : 0;
        /*         * ** END ONGKIR AGAC** */

        /* rumus HPP
         * Hutang = harga tebus + aksesoris
         * Persediaan = (Hutang - (accesor+FF+DePro+HBMargin+ppnbm+pph22))/1,1
         */
        $hutang = $arrData['bpk_hpp'] + $arrData['bpk_accesor'];
        $persediaan = ($hutang - ($arrData['bpk_accesor'] + $arrData['bpk_ff'] + $arrData['bpk_depro'] + $arrData['bpk_hbmrgn'] + $arrData['bpk_ppnbm'] + $arrData['bpk_pph22']) ) / (11 / 10);

        /* rumus ppn
         * PPn = Persediaan * 10%
         */
        $ppn = $persediaan * (1 / 10);

        try {
            /* list kode perkiraan berdasarkan merk dan status kendaraan baru/bekas */
            $code = $this->brand_code($cbrid, $condition);

            /* ANTAR GROUP / ANTAR CABANG */
            if ($status == 'ATPM') {
                if (ses_brand == '1' && ses_cabang != "100608" && ses_cabang != "100637" && ses_cabang != "100097") {
                    $hutkode = '10070101';
                } else if (ses_brand == '1' && (ses_cabang == "100608" || ses_cabang == "100637" || ses_cabang == "100097")) {
                    $hutkode = '101401';
                } else {
                    $hutkode = $code->hutmob;
                }
            } else if ($status == 'ANTAR GROUP' || $status == 'PIHAK LAIN') {
                $hutkode = $code->hutmob;
            } else if ($status == '') {
                $hutkode = $code->hutmob;
            } else {
                $hutkode = $this->model_kasir->getAgacKode(array('cbid' => $supkode));
                //log_message('error', 'TEST ROSSI : '. $hutkode);
                if ($this->model_kasir->isValidKode($hutkode) == FALSE or empty($hutkode)) {
                    $warn = 'Invalid Kode perkiraan AGAC or Code not defined';
                    throw new Exception($warn);
                }
            }

            if ($condition == 'X') {
                //if (ses_cabang == '200200') {
                $codepersediaan = '10130299';
                //} else {
                //   $codepersediaan = $code->persediaan;
                //}
            } else {
                $codepersediaan = $code->persediaan;
            }

            /* deleting previous data if exist */
            $deletejurnal = $this->deleteJurnal(array('kode' => $kode, 'mode' => 'CREATE'));
            if ($deletejurnal['status'] == FALSE) {
                $warn = 'delete jurnal failed : ' . $data['bpk_no'];
                throw new Exception($warn);
            }

            /* ----------------- persediaan */
            if ($this->model_kasir->isValidKode($codepersediaan) == FALSE) {
                $warn = 'Invalid persediaan ' . $cbrid . ' ' . $status . ' Code or Code not defined';
                throw new Exception($warn);
            }
            $arper = array(
                'tr_cbid' => $cbid,
                'tr_nomer' => $kode,
                'tr_kodeid' => $codepersediaan,
                'tr_nota' => $data['bpk_no'],
                'tr_name' => ($mode == 'RETURN') ? 'rbuyunit' : 'buyunit',
                'tr_date' => $tgl_now,
                'tr_descrip' => ($mode == 'RETURN') ? 'RETUR BELI : ' . $norangka . ', ' . $supkode : 'BELI : ' . $norangka . ', ' . $supkode,
                'tr_debit' => ($mode == 'RETURN') ? 0 : $persediaan,
                'tr_kredit' => ($mode == 'RETURN') ? $persediaan : 0,
                'tr_supkode' => $supkode,
                'tr_jurnal' => 1
            );

            /* ----------------- piutang ppn */
            if ($this->model_kasir->isValidKode($code->piuppn) == FALSE) {
                $warn = 'Invalid piuppn Code or Code not defined';
                throw new Exception($warn);
            }
            $arpiuppn = array(
                'tr_cbid' => $cbid,
                'tr_nomer' => $kode,
                'tr_kodeid' => $code->piuppn,
                'tr_nota' => $data['bpk_no'],
                'tr_name' => ($mode == 'RETURN') ? 'rbuyunit' : 'buyunit',
                'tr_date' => $tgl_now,
                'tr_descrip' => ($mode == 'RETURN') ? 'RETUR BELI : ' . $norangka . ', ' . $supkode : 'BELI : ' . $norangka . ', ' . $supkode,
                'tr_debit' => ($mode == 'RETURN') ? 0 : $ppn,
                'tr_kredit' => ($mode == 'RETURN') ? $ppn : 0,
                'tr_supkode' => $supkode,
                'tr_jurnal' => 1
            );

            /* ----------------- persediaan aksesoris */
            if ($this->model_kasir->isValidKode($codepersediaan) == FALSE) {
                $warn = 'Invalid persediaan asesories Code or Code not defined';
                throw new Exception($warn);
            }
            $araccesor = array(
                'tr_cbid' => $cbid,
                'tr_nomer' => $kode,
                'tr_kodeid' => $codepersediaan,
                'tr_nota' => $data['bpk_no'],
                'tr_name' => ($mode == 'RETURN') ? 'rbuyunit' : 'buyunit',
                'tr_date' => $tgl_now,
                'tr_descrip' => ($mode == 'RETURN') ? 'RETUR BELI : ' . $norangka . ', ' . $supkode : 'BELI : ' . $norangka . ', ' . $supkode,
                'tr_debit' => ($mode == 'RETURN') ? 0 : $arrData['bpk_accesor'],
                'tr_kredit' => ($mode == 'RETURN') ? $arrData['bpk_accesor'] : 0,
                'tr_supkode' => $supkode,
                'tr_jurnal' => 1
            );

            /* ----------------- deposit promosi */
            if ($this->model_kasir->isValidKode($code->depro) == FALSE) {
                $warn = 'Invalid promosi Code ' . $code->depro . ' or Code not defined';
                throw new Exception($warn);
            }
            $ardepro = array(
                'tr_cbid' => $cbid,
                'tr_nomer' => $kode,
                'tr_kodeid' => $code->depro,
                'tr_name' => ($mode == 'RETURN') ? 'rbuyunit' : 'buyunit',
                'tr_date' => $tgl_now,
                'tr_nota' => $data['bpk_no'],
                'tr_descrip' => ($mode == 'RETURN') ? 'RETUR BELI : ' . $norangka . ', ' . $supkode : 'BELI : ' . $norangka . ', ' . $supkode,
                'tr_debit' => ($mode == 'RETURN') ? 0 : $arrData['bpk_depro'],
                'tr_kredit' => ($mode == 'RETURN') ? $arrData['bpk_depro'] : 0,
                'tr_supkode' => $supkode,
                'tr_jurnal' => 1
            );

            /* ----------------- deposit deposit facility fund */
            if ($this->model_kasir->isValidKode($code->depff) == FALSE) {
                $warn = 'Invalid facility fund Code or Code not defined';
                throw new Exception($warn);
            }
            $ardepff = array(
                'tr_cbid' => $cbid,
                'tr_nomer' => $kode,
                'tr_kodeid' => $code->depff,
                'tr_name' => ($mode == 'RETURN') ? 'rbuyunit' : 'buyunit',
                'tr_date' => $tgl_now,
                'tr_nota' => $data['bpk_no'],
                'tr_descrip' => ($mode == 'RETURN') ? 'RETUR BELI : ' . $norangka . ', ' . $supkode : 'BELI : ' . $norangka . ', ' . $supkode,
                'tr_debit' => ($mode == 'RETURN') ? 0 : $arrData['bpk_ff'],
                'tr_kredit' => ($mode == 'RETURN') ? $arrData['bpk_ff'] : 0,
                'tr_supkode' => $supkode,
                'tr_jurnal' => 1
            );

            /* ----------------- deposit ppn bm */
            if ($this->model_kasir->isValidKode($code->ppnbm) == FALSE) {
                $warn = 'Invalid ppnbm Code or Code not defined';
                throw new Exception($warn);
            }
            $arppnbm = array(
                'tr_cbid' => $cbid,
                'tr_nomer' => $kode,
                'tr_kodeid' => $code->ppnbm,
                'tr_name' => ($mode == 'RETURN') ? 'rbuyunit' : 'buyunit',
                'tr_date' => $tgl_now,
                'tr_nota' => $data['bpk_no'],
                'tr_descrip' => ($mode == 'RETURN') ? 'RETUR BELI : ' . $norangka . ', ' . $supkode : 'BELI : ' . $norangka . ', ' . $supkode,
                'tr_debit' => ($mode == 'RETURN') ? 0 : $arrData['bpk_ppnbm'],
                'tr_kredit' => ($mode == 'RETURN') ? $arrData['bpk_ppnbm'] : 0,
                'tr_supkode' => $supkode,
                'tr_jurnal' => 1
            );

            /* ----------------- deposit pph 22 */
            if ($this->model_kasir->isValidKode($code->pph22) == FALSE) {
                $warn = 'Invalid pph22 Code or Code not defined';
                throw new Exception($warn);
            }
            $arpph = array(
                'tr_cbid' => $cbid,
                'tr_nomer' => $kode,
                'tr_kodeid' => $code->pph22,
                'tr_name' => ($mode == 'RETURN') ? 'rbuyunit' : 'buyunit',
                'tr_date' => $tgl_now,
                'tr_nota' => $data['bpk_no'],
                'tr_descrip' => ($mode == 'RETURN') ? 'RETUR BELI : ' . $norangka . ', ' . $supkode : 'BELI : ' . $norangka . ', ' . $supkode,
                'tr_debit' => ($mode == 'RETURN') ? 0 : $arrData['bpk_pph22'],
                'tr_kredit' => ($mode == 'RETURN') ? $arrData['bpk_pph22'] : 0,
                'tr_supkode' => $supkode,
                'tr_jurnal' => 1
            );

            /* ----------------- deposit holdback margin */
            if ($this->model_kasir->isValidKode($code->hbmrgn) == FALSE) {
                $warn = 'Invalid hbmrgn Code or Code not defined';
                throw new Exception($warn);
            }
            $arhbmrgn = array(
                'tr_cbid' => $cbid,
                'tr_nomer' => $kode,
                'tr_kodeid' => $code->hbmrgn,
                'tr_name' => ($mode == 'RETURN') ? 'rbuyunit' : 'buyunit',
                'tr_date' => $tgl_now,
                'tr_nota' => $data['bpk_no'],
                'tr_descrip' => ($mode == 'RETURN') ? 'RETUR BELI : ' . $norangka . ', ' . $supkode : 'BELI : ' . $norangka . ', ' . $supkode,
                'tr_debit' => ($mode == 'RETURN') ? 0 : $arrData['bpk_hbmrgn'],
                'tr_kredit' => ($mode == 'RETURN') ? $arrData['bpk_hbmrgn'] : 0,
                'tr_supkode' => $supkode,
                'tr_jurnal' => 1
            );

            /* ----------------- hutang dagang ------------ */
            if ($this->model_kasir->isValidKode($code->hutmob) == FALSE) {
                $warn = 'Invalid hutang dagang code or code not defined';
                throw new Exception($warn);
            }
            $arhutdag = array(
                'tr_cbid' => $cbid,
                'tr_nomer' => $kode,
                'tr_kodeid' => $hutkode,
                'tr_name' => ($mode == 'RETURN') ? 'rbuyunit' : 'buyunit',
                'tr_date' => $tgl_now,
                'tr_nota' => $data['bpk_no'],
                'tr_descrip' => ($mode == 'RETURN') ? 'RETUR BELI : ' . $norangka . ', ' . $supkode : 'BELI : ' . $norangka . ', ' . $supkode,
                'tr_debit' => ($mode == 'RETURN') ? $hutang + $hut_ongkir : 0,
                'tr_kredit' => ($mode == 'RETURN') ? 0 : $hutang + $hut_ongkir,
                'tr_supkode' => $supkode,
                'tr_jurnal' => 1
            );

            /* ---------------- jika Ada PPNBM ----------- */
            if ($arrData['bpk_ppnbm'] != 0) {

                $arperppnbm = array(
                    'tr_cbid' => $cbid,
                    'tr_nomer' => $kode,
                    'tr_kodeid' => $codepersediaan,
                    'tr_nota' => $data['bpk_no'],
                    'tr_name' => ($mode == 'RETURN') ? 'rbuyunit' : 'buyunit',
                    'tr_date' => $tgl_now,
                    'tr_descrip' => ($mode == 'RETURN') ? 'RETUR BELI : ' . $norangka . ', ' . $supkode : 'BELI : ' . $norangka . ', ' . $supkode,
                    'tr_debit' => ($mode == 'RETURN') ? 0 : $arrData['bpk_ppnbm'],
                    'tr_kredit' => ($mode == 'RETURN') ? $arrData['bpk_ppnbm'] : 0,
                    'tr_supkode' => $supkode,
                    'tr_jurnal' => 1
                );

                /* ----------------- deposit ppn bm krdit */
                if ($this->model_kasir->isValidKode($code->ppnbm) == FALSE) {
                    $warn = 'Invalid ppnbm kredit Code or Code not defined';
                    throw new Exception($warn);
                }
                $arppnbmkredit = array(
                    'tr_cbid' => $cbid,
                    'tr_nomer' => $kode,
                    'tr_kodeid' => $code->ppnbm,
                    'tr_name' => ($mode == 'RETURN') ? 'rbuyunit' : 'buyunit',
                    'tr_date' => $tgl_now,
                    'tr_nota' => $data['bpk_no'],
                    'tr_descrip' => ($mode == 'RETURN') ? 'RETUR BELI : ' . $norangka . ', ' . $supkode : 'BELI : ' . $norangka . ', ' . $supkode,
                    'tr_debit' => ($mode == 'RETURN') ? $arrData['bpk_ppnbm'] : 0,
                    'tr_kredit' => ($mode == 'RETURN') ? 0 : $arrData['bpk_ppnbm'],
                    'tr_supkode' => $supkode,
                    'tr_jurnal' => 1
                );
            }

            /*
             * *********************Ongkos Kirim**************************** 
             * ma'ruf
             */
            /* ARRAY ONGKIR */
            $arr_ongkir = array(
                'tr_cbid' => $cbid,
                'tr_nomer' => $kode,
                'tr_kodeid' => '101811',
                'tr_name' => ($mode == 'RETURN') ? 'rbuyunit' : 'buyunit',
                'tr_date' => $tgl_now,
                'tr_descrip' => ($mode == 'RETURN') ? 'RETUR BELI : ' . $norangka . ', ' . $supkode : 'BELI : ' . $norangka . ', ' . $supkode,
                'tr_debit' => ($mode == 'RETURN') ? 0 : $ongkir,
                'tr_kredit' => ($mode == 'RETURN') ? $ongkir : 0,
                'tr_supkode' => $supkode,
                'tr_nota' => $norangka,
                'tr_jurnal' => 1
            );
            //log_message('error', 'CEK nominal ONGKIR : '. $ongkir);

            /*             * ********************** END ONGKIR ********************** */

            /* ----------------- persediaan --------- */
            if ($this->addTrLedger($arper) == FALSE) {
                $warn = 'add persediaan to ledger fails';
                throw new Exception($warn);
            }

            /* ----------------- ppn ----------------- */
            if ($this->addTrLedger($arpiuppn) == FALSE) {
                $warn = 'add ppn to ledger fails';
                throw new Exception($warn);
            }

            /* ---------------- accesories ----------- */
            if ($arrData['bpk_accesor'] != 0) {
                if ($this->addTrLedger($araccesor) == FALSE) {
                    $warn = 'add accessories to ledger fails';
                    throw new Exception($warn);
                }
            }

            /* ----------------- depro -------------- */
            if ($arrData['bpk_depro'] != 0) {
                if ($this->addTrLedger($ardepro) == FALSE) {
                    $warn = 'add depprom to ledger fails';
                    throw new Exception($warn);
                }
            }

            /* ----------------- depff -------------- */
            if ($arrData['bpk_ff'] != 0) {
                if ($this->addTrLedger($ardepff) == FALSE) {
                    $warn = 'add depff to ledger fails';
                    throw new Exception($warn);
                }
            }

            /* ----------------- ppnbm -------------- */
            if ($arrData['bpk_ppnbm'] != 0) {
                if ($this->addTrLedger($arppnbm) == FALSE) {
                    $warn = 'add ppnbm to ledger fails';
                    throw new Exception($warn);
                }
            }

            /* ----------------- pph ---------------- */
            if ($arrData['bpk_pph22'] != 0) {
                if ($this->addTrLedger($arpph) == FALSE) {
                    $warn = 'add pph to ledger fails';
                    throw new Exception($warn);
                }
            }

            /* ----------------- hbmargin ------------ */
            if ($arrData['bpk_hbmrgn'] != 0) {
                if ($this->addTrLedger($arhbmrgn) == FALSE) {
                    $warn = 'add hpmrgn to ledger fails';
                    throw new Exception($warn);
                }
            }

            /*
             * Ongkos Kirim 101811 / 601001
             * by ma'ruf
             */
            if (!empty($ongkir) && $tgl_now >= "2014-06-01") {
                /* ----------------- 15. Ongkir unit ------ */
                if ($this->model_adh->addTrLedger($arr_ongkir) == FALSE) {
                    $warn = 'add Ongkir to ledger fails';
                    throw new Exception($warn);
                }
                //log_message('error', 'CEK ONGKIR : '. $this->db->last_query());
            }
            /*             * ************** END ONGKIR LEDGER ********************************* */

            /* -------------- hutang dagang unit ------ */
            if ($this->addTrLedger($arhutdag) == FALSE) {
                $warn = 'add hutang dagang to ledger fails';
                throw new Exception($warn);
            }

            /* ---------------- jika Ada PPNBM ----------- */
            if ($arrData['bpk_ppnbm'] != 0) {
                /* ---------------- persedian ppnbm ----------- */
                if ($this->addTrLedger($arperppnbm) == FALSE) {
                    $warn = 'add persediaan PPNBM to ledger fails';
                    throw new Exception($warn);
                }

                /* ----------------- ppnbm kredit -------------- */
                if ($this->addTrLedger($arppnbmkredit) == FALSE) {
                    $warn = 'add ppnbm kredit to ledger fails';
                    throw new Exception($warn);
                }
            }

            /* if bpk already factured */
            $this->facturedBpk(array(
                'bpkno' => $kode,
                'persediaanVal' => $persediaan,
                'persediaanCode' => $codepersediaan,
                'hppCode' => $code->hpp,
                'cbid' => $cbid
            ));

            /* ------- committing transaction --------- */
            $back['status'] = TRUE;
            $back['errmsg'] = 'Succeed';
            return $back;
            /*  end saving process */
        } catch (Exception $warn) {
            $back['errmsg'] = $warn->getMessage();
            $back['status'] = FALSE;
            $back['stat'] = '0';
            return $back;
        }
    }

    /* AUTO JURNAL PENJUALAN SERVICE */

    public function autoJurnalTerimaBarang($data = array()) {
        $total = $data['inv_lc'] + $data['inv_oli'] + $data['inv_sm'] + $data['inv_so'] + $data['inv_spart'];
        $ppn = $total * (1 / 10);
        $totalpiutang = $total + $ppn;
        $jurnalCode = $this->getJurnalCode(array('type' => 'SELSERV', 'cbid' => ses_cabang));

        if ($jurnalCode['status'] == FALSE)
            return FALSE;

        $basicArray = array(
            'trl_nomer' => $data['inv_woid'],
            'trl_name' => 'SELSERV',
            'trl_date' => $data['inv_tgl'],
            'trl_descrip' => 'JUAL : SERVICE ' . $data['pel_nama'] . "(" . $data['msc_nopol'] . ")" . $data['wo_nomer'],
            'trl_cbid' => $data['inv_cbid'],
            'trl_nota' => $data['woid'],
            'trl_pelid' => $data['wo_pelid'],
            'trl_supid' => '0',
            'trl_debit' => 0,
            'trl_kredit' => 0,
            'trl_ccid' => 0,
            'trl_automatic' => 0,
            'trl_is_breakdown' => 0
        );

        $orderedArray = array();

        /* PIUTANG SERVICE - DEBIT */
        array_push($orderedArray, $basicArray);
        $orderedArray[0]['trl_coa'] = $jurnalCode['piutang'];
        $orderedArray[0]['trl_debit'] = $data['inv_total'];

        /* PIUTANG PENJUALAN LC - KREDIT */
        array_push($orderedArray, $basicArray);
        $orderedArray[1]['trl_coa'] = $jurnalCode['penj_lc'];
        $orderedArray[1]['trl_kredit'] = $data['inv_lc'];

        /* PIUTANG PENJUALAN OLI - KREDIT */
        array_push($orderedArray, $basicArray);
        $orderedArray[2]['trl_coa'] = $jurnalCode['penj_oli'];
        $orderedArray[2]['trl_kredit'] = $data['inv_oli'];

        /* PIUTANG PENJUALAN SPARTS - KREDIT */
        array_push($orderedArray, $basicArray);
        $orderedArray[3]['trl_coa'] = $jurnalCode['penj_spart'];
        $orderedArray[3]['trl_kredit'] = $data['inv_spart'];

        /* PIUTANG PENJUALAN SUB ORDER - KREDIT */
        array_push($orderedArray, $basicArray);
        $orderedArray[4]['trl_coa'] = $jurnalCode['penj_so'];
        $orderedArray[4]['trl_kredit'] = $data['inv_so'];

        /* PIUTANG PENJUALAN SUB MATERIAL - KREDIT */
        array_push($orderedArray, $basicArray);
        $orderedArray[5]['trl_coa'] = $jurnalCode['penj_sm'];
        $orderedArray[5]['trl_kredit'] = $data['inv_sm'];

        /* HUTANG PAJAK PPN - KREDIT */
        array_push($orderedArray, $basicArray);
        $orderedArray[6]['trl_coa'] = $jurnalCode['ppn'];
        $orderedArray[6]['trl_kredit'] = $data['inv_ppn'];

        /* HPP OLI - DEBIT */
        array_push($orderedArray, $basicArray);
        $orderedArray[6]['trl_coa'] = $jurnalCode['hpp_oli'];
        $orderedArray[6]['trl_debit'] = $data['inv_hpp_oli'];

        /* HPP SPART - DEBIT */
        array_push($orderedArray, $basicArray);
        $orderedArray[7]['trl_coa'] = $jurnalCode['hpp_spart'];
        $orderedArray[7]['trl_debit'] = $data['inv_hpp_spart'];

        /* HPP SUB ORDER - DEBIT */
        array_push($orderedArray, $basicArray);
        $orderedArray[8]['trl_coa'] = $jurnalCode['hpp_so'];
        $orderedArray[8]['trl_debit'] = $data['inv_hpp_so'];

        /* HPP SUB MATERIAL - DEBIT */
        array_push($orderedArray, $basicArray);
        $orderedArray[9]['trl_coa'] = $jurnalCode['hpp_sm'];
        $orderedArray[9]['trl_debit'] = $data['inv_hpp_sm'];

        /* PERSEDIAAN OLI - KREDIT ( hpp_oli + hpp_sm + hpp_spart) */
        array_push($orderedArray, $basicArray);
        $orderedArray[10]['trl_coa'] = $jurnalCode['persediaan_oli'];
        $orderedArray[10]['trl_kredit'] = ($data['inv_hpp_oli'] + $data['inv_hpp_spart'] + $data['inv_hpp_sm'] );

        /* PENERIMAAN SO - KREDIT */
        array_push($orderedArray, $basicArray);
        $orderedArray[11]['trl_coa'] = $jurnalCode['pen_so'];
        $orderedArray[11]['trl_kredit'] = $data['inv_hpp_so'];

        if ($this->db->insert_batch('ksr_ledger', $orderedArray) == FALSE) {
            throw new Exception('AUTO JURNAL PENJUALAN SERVICE GAGAL');
        }
    }

}

?>
