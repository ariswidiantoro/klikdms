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
            trl_kredit, trl_croscoa, trl_nota, trl_pelid, trl_ccid, trl_supid, trl_norangka, 
            trl_headstatus, trl_name, trl_trans, trl_createon, trl_date, trl_automatic" );
        $this->db->where("trl_date BETWEEN '" . $var_recieve['dateFrom'] . "' 
            AND '" . $var_recieve['dateTo'] . "'", NULL, FALSE);
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
    
    
    public function rekapPiutang($data){
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
               FROM trledger WHERE trl_kodeid = '".$data['coa']."' AND" .
                    " trl_date BETWEEN '" . $datefirst . "' AND '" . $datesecond . "' AND trl_cbid = " . $data['cbid'] . " 
				GROUP BY trl_nota, trl_kodeid ");
            if ($qq->num_rows() > 0) {
                foreach ($qq->result() as $val) {
                    $firsttrans[$val->trl_nota] = $val->balance;
                }
            }
        }
        
        

    }
    
    

}

?>
