<?php

/**
 * The MODEL LAPORAN FINANCE
 * @author Rossi Erl
 * 2015-08-29
 */
class Model_Lap_Finance extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /* GROUP CABANG */

    public function getGroupCabang($data = array()) {
        $sql = $this->db->query("
            SELECT group_cbid, cb_nama FROM ms_group_cabang 
                LEFT JOIN ms_cabang ON cbid = group_cbid
            WHERE 
            group_krid = '" . $data['krid'] . "'
        ");
        return $sql->result_array();
    }

    /* LOAD TRANSACTION LEDGER */

    public function logTrans($var_recieve) {
        $this->db->select( "trlid,trl_cbid, trl_nomer, trl_coa, trl_descrip, trl_debit,
            trl_kredit, trl_croscoa, trl_nota, pel_nama as trl_pelid, sup_nama as trl_supid, 
            trl_norangka, cc_name as trl_ccid,
            trl_headstatus, trl_name, trl_trans, trl_createon, trl_date, trl_automatic" );
        $this->db->where("trl_date BETWEEN '" . $var_recieve['dateFrom'] . "' 
            AND '" . $var_recieve['dateTo'] . "'", NULL, FALSE);
        $this->db->join('ms_supplier', 'supid=trl_supid', 'left');
        $this->db->join('ms_pelanggan', 'pelid=trl_pelid', 'left');
        $this->db->join('ms_cost_center', 'cc_kode= trl_ccid and cc_cbid=trl_cbid', 'left');
        if (!empty($var_recieve['cbid'])) {
            $this->db->where('trl_cbid', $var_recieve['cbid']);
        }
        if (!empty($var_recieve['coa'])) {
            $this->db->where('trl_coa', $var_recieve['coa']);
        }
        if (!empty($var_recieve['pelid'])) {
            $this->db->where('trl_nodoc', $var_recieve['pelid']);
        }
        if (!empty($var_recieve['ccid'])) {
            $this->db->where('trl_ccid', $var_recieve['ccid']);
        }
        if (!empty($var_recieve['nota'])) {
            $this->db->where('trl_nota', $var_recieve['nota']);
        }
        $this->db->order_by('trl_date', 'ASC');
        $this->db->order_by('trl_trans', 'ASC');
        $this->db->order_by('trl_nomer', 'ASC');
        $this->db->order_by('trlid', 'ASC');
        $query = $this->db->get('ksr_ledger');
        return $query->result_array();
    }
    
    public function getSaldo($data){
        /*$query = "SELECT sld_saldo FROM ksr_saldo 
            WHERE sld_tahun = ".$data['year']." AND sld_bulan = ".$data['month']."
                AND sld_type = '".$data['type']."' AND sld_nodoc = '".$data['nodoc']."'";
        $sql = $this->db->query($query);
        
        if($sql->num_rows()>0){
           return $sql->row()->sld_saldo; 
        }else{
            return 0;
        }*/
        return 0;
    }
    
    public function getDetailCabang($data){
        $query = "SELECT * FROM ms_cabang WHERE cbid = '".$data."'";
        $sql = $this->db->query($query);
        return $sql->row_array();
    }
    
    public function getDetailCoa($data){
        $query = "SELECT * FROM ms_coa WHERE cbid = '".$data."'";
        $sql = $this->db->query($query);
        return $sql->row_array();
    }
    
    public function getMainCoa($data){
        $query = "SELECT coa_kode, coa_desc FROM ms_coa WHERE coa_cbid = '".$data['cbid']."'
            AND coa_is_kas_bank = ".$data['type']."
            AND coa_flag = 1";
        $sql = $this->db->query($query);
        return $sql->result_array();
    }
    
    public function lapKasir($data){
        $query = "SELECT * FROM ksr_trans WHERE kst_cbid = '".$data['cbid']."' 
            AND kst_trans = '".$data['trans']."' AND kst_type = '".$data['type']."'
            AND kst_tgl BETWEEN '".$data['dateFrom']."' AND '".$data['dateTo']."'
            AND kst_flaga";
        $sql = $this->db->query($query);
        return $sql->result_array();
    }
    
    public function rekapHutang($data){
        $data['month'] = date('m', strtotime($data['dateFrom']));
        $data['year'] = date('Y', strtotime($data['dateFrom']));
        $data['dateFirst'] = date('Y-m-d', strtotime($data['year'] . '-' . $data['month'] . '-01'));
        if($data['coa'] == HUTANG_UNIT){
            $data['type'] = DEPT_SALES;
            $select = "supid as id, ko as faktur, date(spk_createon) as tgl_faktur, kon_nomer as kontrak, 
            sup_nama as nama, sup_alamat as alamat,";
            $detail = "
                LEFT JOIN pen_spk on spkid = kode
                LEFT JOIN ms_kontrak ON kon_nomer = spk_nokontrak and kon_cbid = cbid
                LEFT JOIN ms_pelanggan ON pelid = kon_pelid
                GROUP BY spkid, date(spk_createon), kon_nomer, pel_nama, pel_alamat";
        }else if($data['coa'] == PIUTANG_SERVICE){
            $data['type'] = DEPT_SERVICE;
            $select = "invid as id, wo_nomer as faktur, inv_tgl as tgl_faktur, msc_nopol as kontrak, 
            pel_nama as nama, pel_alamat as alamat,";
            $detail = "
                LEFT JOIN svc_invoice on invid = kode
                LEFT JOIN svc_wo on woid = inv_woid
                LEFT JOIN ms_car ON mscid = wo_mscid
                LEFT JOIN ms_pelanggan ON pelid = wo_pelid
                GROUP BY invid, wo_nomer, inv_tgl, msc_nopol, pel_nama, pel_alamat";
        }
        
        $firsttrans = array();
        $dataout = array();
        
        $query = "SELECT ".$select."
            coalesce(sum(sld_saldo),0) as sld_awal,
            coalesce(sum(trl_debit),0) as debit, 
            coalesce(sum(trl_kredit),0) as kredit
            FROM (
                (SELECT sld_kode as kode, sld_cbid as cbid FROM ksr_saldo 
                WHERE 
                    sld_cbid = '".$data['cbid']."' AND sld_type = '".$data['type']."'
                    AND sld_tahun = ".$data['year']." AND sld_bulan = ".$data['month']."
                UNION 
                SELECT trl_nota as kode, trl_cbid as cbid FROM ksr_ledger WHERE trl_coa = '".$data['coa']."'
                    AND trl_date BETWEEN '".$data['dateFirst']."' AND '".$data['dateTo']."'
                    GROUP BY trl_nota, trl_cbid
                ) ORDER BY kode ASC 
            ) SUBQ
            LEFT JOIN ksr_saldo ON sld_kode = kode AND sld_type = '".$data['type']."' 
                AND sld_tahun = ".$data['year']." AND sld_bulan = ".$data['month']."
                AND sld_cbid = cbid
            LEFT JOIN ksr_ledger ON trl_supid = kode AND trl_coa = '".$data['coa']."' 
                AND trl_date BETWEEN '".$data['dateFrom']."' AND '".$data['dateTo']."'
                AND trl_cbid = cbid
            ".$detail." ";
        
        $sql = $this->db->query($query);
        //log_message('error', 'CEK : '.$this->db->last_query());
        
        if (date('d', strtotime($data['dateFrom'])) != '01') {
            $yearfrom = date('Y', strtotime($data['dateFrom']));
            $monthfrom = date('m', strtotime($data['dateFrom']));
            $datefrom = date('d', strtotime($data['dateFrom']));
            $datefirst = date('Y-m-d', mktime(0, 0, 0, $monthfrom, 1, $yearfrom));
            $datesecond = date('Y-m-d', mktime(0, 0, 0, $monthfrom, $datefrom - 1, $yearfrom));
            $qq = $this->db->query("SELECT trl_nota, SUM(trl_debit-trl_kredit) AS balance
               FROM trledger WHERE trl_kodeid = '".$data['coa']."' AND" .
                    " trl_date BETWEEN '" . $datefirst . "' AND '" . $datesecond . "' AND trl_cbid = " . $data['cbid'] . " 
				GROUP BY trl_nota, trl_kodeid ");
            if ($qq->num_rows() > 0) {
                foreach ($qq->result() as $val) {
                    $firsttrans[$val->trl_nota] = $val->balance;
                }
            }
        }
        
        if(($sql->num_rows()) > 0){
            foreach($sql->result_array() as $rows){
                $awal = $rows['sld_awal'];
                $first = 0;

                if ((date('d', strtotime($data['dateFrom'])) != '01') && (array_key_exists($rows['faktur'], $firsttrans))) {
                    $first = $firsttrans[$rows['faktur']];
                    $awal += $first;
                }
                $dataout[] = array(
                    'faktur' => strtoupper($rows['faktur']),
                    'tgl_faktur' => datetoindo($rows['tgl_faktur']),
                    'kontrak' => strtoupper($rows['kontrak']),
                    'nama' => strtoupper($rows['nama']),
                    'alamat' => strtoupper($rows['alamat']),
                    'sld_awal' => $awal,
                    'debit' => $rows['debit'],
                    'kredit' => $rows['kredit'],
                    'sld_akhir' => $awal+ $rows['debit'] - $rows['kredit'],
                );
            }
        }
        
        return $dataout;

    }
    
    public function rekapHutangSpart($data){
        $data['month'] = date('m', strtotime($data['dateFrom']));
        $data['year'] = date('Y', strtotime($data['dateFrom']));
        $data['dateFirst'] = date('Y-m-d', strtotime($data['year'] . '-' . $data['month'] . '-01'));
        
        $query = "SELECT kode, sup_nama, sup_alamat, sum(sld_saldo) as FROM (
            (SELECT sld_nodoc as kode, sld_cbid as cbid FROM ksr_saldo 
            WHERE 
                sld_cbid = '".$data['cbid']."' AND sld_type = '".$data['type']."'
                AND sld_tahun = ".$data['year']." AND sld_bulan = ".$data['month']."
            UNION 
            SELECT trl_nota as kode, trl_cbid as cbid FROM ksr_ledger WHERE trl_coa = '".$data['coa']."'
                AND trl_date BETWEEN '".$data['dateFirst']."' AND '".$data['dateTo']."'
                GROUP BY trl_pelid) ORDER BY kode ASC ) SUBQ
            LEFT JOIN ksr_saldo ON sld_nodoc = kode AND sld_type = '".$data['type']."' 
                AND sld_tahun = ".$data['year']." AND sld_bulan = ".$data['month']."
                AND sld_cbid = cbid
            LEFT JOIN ksr_ledger ON trl_nota = kode AND trl_coa = '".$data['coa']."' 
                AND trl_date BETWEEN '".$data['dateFrom']."' AND '".$data['dateTo']."'
                AND trl_cbid = cbid
            LEFT JOIN ms_supplier ON supid = kode 
        ";
        
        $sql = $this->db->query($query);
        
        $firsttrans = array();
        if (date('d', strtotime($data['dateFrom'])) != '01') {
            $yearfrom = date('Y', strtotime($data['dateFrom']));
            $monthfrom = date('m', strtotime($data['dateFrom']));
            $datefrom = date('d', strtotime($data['dateFrom']));
            $datefirst = date('Y-m-d', mktime(0, 0, 0, $monthfrom, 1, $yearfrom));
            $datesecond = date('Y-m-d', mktime(0, 0, 0, $monthfrom, $datefrom - 1, $yearfrom));
            $qq = $this->db->query("SELECT trl_supid, SUM(trl_debit-trl_kredit) AS balance
               FROM ksr_ledger WHERE trl_coa = '".$data['coa']."' AND" .
                    " trl_date BETWEEN '" . $datefirst . "' AND '" . $datesecond . "' AND trl_cbid = " . $data['cbid'] . " 
				GROUP BY trl_nota, trl_kodeid ");
            if ($qq->num_rows() > 0) {
                foreach ($qq->result() as $val) {
                    $firsttrans[$val->trl_nota] = $val->balance;
                }
            }
        }

    }
    
    public function rekapHutangUnit($data){
        $data['month'] = date('m', strtotime($data['dateFrom']));
        $data['year'] = date('Y', strtotime($data['dateFrom']));
        $data['dateFirst'] = date('Y-m-d', strtotime($data['year'] . '-' . $data['month'] . '-01'));
        
        $query = "SELECT kode, sup_nama, sup_alamat, sum(sld_saldo) as FROM (
            (SELECT sld_nodoc as kode, sld_cbid as cbid FROM ksr_saldo 
            WHERE 
                sld_cbid = '".$data['cbid']."' AND sld_type = '".$data['type']."'
                AND sld_tahun = ".$data['year']." AND sld_bulan = ".$data['month']."
            UNION 
            SELECT trl_supid as kode, trl_cbid as cbid FROM ksr_ledger WHERE trl_coa = '".$data['coa']."'
                AND trl_date BETWEEN '".$data['dateFirst']."' AND '".$data['dateTo']."'
                GROUP BY trl_pelid) ORDER BY kode ASC ) SUBQ
            LEFT JOIN ksr_saldo ON sld_nodoc = kode AND sld_type = '".$data['type']."' 
                AND sld_tahun = ".$data['year']." AND sld_bulan = ".$data['month']."
                AND sld_cbid = cbid
            LEFT JOIN ksr_ledger ON trl_supid = kode AND trl_coa = '".$data['coa']."' 
                AND trl_date BETWEEN '".$data['dateFrom']."' AND '".$data['dateTo']."'
                AND trl_cbid = cbid
            LEFT JOIN ms_supplier ON supid = kode 
        ";
        
        $sql = $this->db->query($query);
        
        $firsttrans = array();
        if (date('d', strtotime($data['dateFrom'])) != '01') {
            $yearfrom = date('Y', strtotime($data['dateFrom']));
            $monthfrom = date('m', strtotime($data['dateFrom']));
            $datefrom = date('d', strtotime($data['dateFrom']));
            $datefirst = date('Y-m-d', mktime(0, 0, 0, $monthfrom, 1, $yearfrom));
            $datesecond = date('Y-m-d', mktime(0, 0, 0, $monthfrom, $datefrom - 1, $yearfrom));
            $qq = $this->db->query("SELECT trl_supid, SUM(trl_debit-trl_kredit) AS balance
               FROM trledger WHERE trl_kodeid = '101704' AND" .
                    " trl_date BETWEEN '" . $datefirst . "' AND '" . $datesecond . "' AND trl_cbid = " . $data['cbid'] . " 
				GROUP BY trl_nota, trl_kodeid ");
            if ($qq->num_rows() > 0) {
                foreach ($qq->result() as $val) {
                    $firsttrans[$val->trl_nota] = $val->balance;
                }
            }
        }

    }
    
    /* @param array('dateFrom','dateTo','type')
     */
    public function rekapPiutang($data){
        $data['month'] = date('m', strtotime($data['dateFrom']));
        $data['year'] = date('Y', strtotime($data['dateFrom']));
        $data['dateFirst'] = date('Y-m-d', strtotime($data['year'] . '-' . $data['month'] . '-01'));
        if($data['coa'] == PIUTANG_UNIT){
            $data['type'] = DEPT_SALES;
            $select = "spkid as id, spk_no as faktur, date(spk_createon) as tgl_faktur, kon_nomer as kontrak, 
            pel_nama as nama, pel_alamat as alamat,";
            $detail = "
                LEFT JOIN pen_spk on spkid = kode
                LEFT JOIN ms_kontrak ON kon_nomer = spk_nokontrak and kon_cbid = cbid
                LEFT JOIN ms_pelanggan ON pelid = kon_pelid
                GROUP BY spkid, date(spk_createon), kon_nomer, pel_nama, pel_alamat";
        }else if($data['coa'] == PIUTANG_SERVICE){
            $data['type'] = DEPT_SERVICE;
            $select = "invid as id, wo_nomer as faktur, inv_tgl as tgl_faktur, msc_nopol as kontrak, 
            pel_nama as nama, pel_alamat as alamat,";
            $detail = "
                LEFT JOIN svc_invoice on invid = kode
                LEFT JOIN svc_wo on woid = inv_woid
                LEFT JOIN ms_car ON mscid = wo_mscid
                LEFT JOIN ms_pelanggan ON pelid = wo_pelid
                GROUP BY invid, wo_nomer, inv_tgl, msc_nopol, pel_nama, pel_alamat";
        }else if($data['coa'] == PIUTANG_SPART){
            $data['type'] = DEPT_SPART;
            $select = "notid as id, not_numerator as faktur, not_tgl as tgl_faktur, spp_pelid as kontrak, 
            pel_nama as nama, pel_alamat as alamat,";
            $detail = "
                LEFT JOIN spa_nota on notid = kode
                LEFT JOIN spa_supply on sppid = not_sppid
                LEFT JOIN ms_pelanggan ON pelid = spp_pelid
                GROUP BY notid, not_numerator, not_tgl, spp_pelid, pel_nama, pel_alamat";
        }else if($data['coa'] == PIUTANG_BREPAIR){
            $data['type'] = DEPT_BREPAIR;
            $select = "invid as id, wo_nomer as faktur, inv_tgl as tgl_faktur, msc_nopol as kontrak, 
            pel_nama as nama, pel_alamat as alamat,";
            $detail = "
                LEFT JOIN svc_wo on woid = kode
                LEFT JOIN svc_invoice on woid = inv_woid
                LEFT JOIN ms_car ON mscid = wo_mscid
                LEFT JOIN ms_pelanggan ON pelid = wo_pelid
                GROUP BY invid, wo_nomer, inv_tgl, msc_nopol, pel_nama, pel_alamat";
        }
        
        $firsttrans = array();
        $dataout = array();
        
        $query = "SELECT ".$select."
            coalesce(sum(sld_saldo),0) as sld_awal,
            coalesce(sum(trl_debit),0) as debit, 
            coalesce(sum(trl_kredit),0) as kredit
            FROM (
                (SELECT sld_kode as kode, sld_cbid as cbid FROM ksr_saldo 
                WHERE 
                    sld_cbid = '".$data['cbid']."' AND sld_type = '".$data['type']."'
                    AND sld_tahun = ".$data['year']." AND sld_bulan = ".$data['month']."
                UNION 
                SELECT trl_nota as kode, trl_cbid as cbid FROM ksr_ledger WHERE trl_coa = '".$data['coa']."'
                    AND trl_date BETWEEN '".$data['dateFirst']."' AND '".$data['dateTo']."'
                    GROUP BY trl_nota, trl_cbid
                ) ORDER BY kode ASC 
            ) SUBQ
            LEFT JOIN ksr_saldo ON sld_kode = kode AND sld_type = '".$data['type']."' 
                AND sld_tahun = ".$data['year']." AND sld_bulan = ".$data['month']."
                AND sld_cbid = cbid
            LEFT JOIN ksr_ledger ON trl_supid = kode AND trl_coa = '".$data['coa']."' 
                AND trl_date BETWEEN '".$data['dateFrom']."' AND '".$data['dateTo']."'
                AND trl_cbid = cbid
            ".$detail." ";
        
        $sql = $this->db->query($query);
        //log_message('error', 'CEK : '.$this->db->last_query());
        
        if (date('d', strtotime($data['dateFrom'])) != '01') {
            $yearfrom = date('Y', strtotime($data['dateFrom']));
            $monthfrom = date('m', strtotime($data['dateFrom']));
            $datefrom = date('d', strtotime($data['dateFrom']));
            $datefirst = date('Y-m-d', mktime(0, 0, 0, $monthfrom, 1, $yearfrom));
            $datesecond = date('Y-m-d', mktime(0, 0, 0, $monthfrom, $datefrom - 1, $yearfrom));
            $qq = $this->db->query("SELECT trl_nota, SUM(trl_debit-trl_kredit) AS balance
               FROM trledger WHERE trl_kodeid = '".$data['coa']."' AND" .
                    " trl_date BETWEEN '" . $datefirst . "' AND '" . $datesecond . "' AND trl_cbid = " . $data['cbid'] . " 
				GROUP BY trl_nota, trl_kodeid ");
            if ($qq->num_rows() > 0) {
                foreach ($qq->result() as $val) {
                    $firsttrans[$val->trl_nota] = $val->balance;
                }
            }
        }
        
        if(($sql->num_rows()) > 0){
            foreach($sql->result_array() as $rows){
                $awal = $rows['sld_awal'];
                $first = 0;

                if ((date('d', strtotime($data['dateFrom'])) != '01') && (array_key_exists($rows['faktur'], $firsttrans))) {
                    $first = $firsttrans[$rows['faktur']];
                    $awal += $first;
                }
                $dataout[] = array(
                    'faktur' => strtoupper($rows['faktur']),
                    'tgl_faktur' => datetoindo($rows['tgl_faktur']),
                    'kontrak' => strtoupper($rows['kontrak']),
                    'nama' => strtoupper($rows['nama']),
                    'alamat' => strtoupper($rows['alamat']),
                    'sld_awal' => $awal,
                    'debit' => $rows['debit'],
                    'kredit' => $rows['kredit'],
                    'sld_akhir' => $awal+ $rows['debit'] - $rows['kredit'],
                );
            }
        }
        
        return $dataout;

    }
    
    public function rekapPiutangServicet($data){
        $data['month'] = date('m', strtotime($data['dateFrom']));
        $data['year'] = date('Y', strtotime($data['dateFrom']));
        $data['dateFirst'] = date('Y-m-d', strtotime($data['year'] . '-' . $data['month'] . '-01'));
        $firsttrans = array();
        $dataout = array();
        
        if($data['dept'] == '1'){
            $select = "SELECT woid as faktur, date(spk_createon) as tgl_faktur, kon_nomer as kontrak, 
            pel_nama as nama, pel_alamat as alamat ";
        }
        
        $query = "SELECT woid as faktur, date(spk_createon) as tgl_faktur, kon_nomer as kontrak, 
            pel_nama as nama, pel_alamat as alamat,
            coalesce(sum(sld_saldo),0) as sld_awal,
            coalesce(sum(trl_debit),0) as debit, 
            coalesce(sum(trl_kredit),0) as kredit
            FROM (
                (SELECT sld_kode as kode, sld_cbid as cbid FROM ksr_saldo 
                WHERE 
                    sld_cbid = '".$data['cbid']."' AND sld_type = '".$data['type']."'
                    AND sld_tahun = ".$data['year']." AND sld_bulan = ".$data['month']."
                UNION 
                SELECT trl_nota as kode, trl_cbid as cbid FROM ksr_ledger WHERE trl_coa = '".$data['coa']."'
                    AND trl_date BETWEEN '".$data['dateFirst']."' AND '".$data['dateTo']."'
                    GROUP BY trl_nota, trl_cbid
                ) ORDER BY kode ASC 
            ) SUBQ
            LEFT JOIN ksr_saldo ON sld_kode = kode AND sld_type = '".$data['type']."' 
                AND sld_tahun = ".$data['year']." AND sld_bulan = ".$data['month']."
                AND sld_cbid = cbid
            LEFT JOIN ksr_ledger ON trl_supid = kode AND trl_coa = '".$data['coa']."' 
                AND trl_date BETWEEN '".$data['dateFrom']."' AND '".$data['dateTo']."'
                AND trl_cbid = cbid
            LEFT JOIN pen_spk on spkid = kode
            LEFT JOIN ms_kontrak ON kon_nomer = spk_nokontrak and kon_cbid = cbid
            LEFT JOIN ms_pelanggan ON pelid = kon_pelid
            GROUP BY faktur, tgl_faktur, kon_nomer, pel_nama, pel_alamat ";
        
        $sql = $this->db->query($query);
        //log_message('error', 'CEK : '.$this->db->last_query());
        
        if (date('d', strtotime($data['dateFrom'])) != '01') {
            $yearfrom = date('Y', strtotime($data['dateFrom']));
            $monthfrom = date('m', strtotime($data['dateFrom']));
            $datefrom = date('d', strtotime($data['dateFrom']));
            $datefirst = date('Y-m-d', mktime(0, 0, 0, $monthfrom, 1, $yearfrom));
            $datesecond = date('Y-m-d', mktime(0, 0, 0, $monthfrom, $datefrom - 1, $yearfrom));
            $qq = $this->db->query("SELECT trl_nota, SUM(trl_debit-trl_kredit) AS balance
               FROM trledger WHERE trl_kodeid = '".$data['coa']."' AND" .
                    " trl_date BETWEEN '" . $datefirst . "' AND '" . $datesecond . "' AND trl_cbid = " . $data['cbid'] . " 
				GROUP BY trl_nota, trl_kodeid ");
            if ($qq->num_rows() > 0) {
                foreach ($qq->result() as $val) {
                    $firsttrans[$val->trl_nota] = $val->balance;
                }
            }
        }
        
        if(($sql->num_rows()) > 0){
            foreach($sql->result_array() as $rows){
                $awal = $rows['sld_awal'];
                $first = 0;

                if ((date('d', strtotime($data['dateFrom'])) != '01') && (array_key_exists($rows['faktur'], $firsttrans))) {
                    $first = $firsttrans[$rows['faktur']];
                    $awal += $first;
                }
                $dataout[] = array(
                    'faktur' => strtoupper($rows['faktur']),
                    'tgl_faktur' => datetoindo($rows['tgl_faktur']),
                    'kontrak' => strtoupper($rows['kontrak']),
                    'nama' => strtoupper($rows['nama']),
                    'alamat' => strtoupper($rows['alamat']),
                    'sld_awal' => $awal,
                    'debit' => $rows['debit'],
                    'kredit' => $rows['kredit'],
                    'sld_akhir' => $awal+ $rows['debit'] - $rows['kredit'],
                );
            }
        }
        
        return $dataout;

    }
    
    public function umrPiutangUnit(){
        
    }
    
    public function umrPiutangService(){
        
    }
    
    

}

?>
