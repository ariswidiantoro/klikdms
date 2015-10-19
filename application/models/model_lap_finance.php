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

    /* @param array('coa' => string, 'cbid' => string ) */

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

    public function logTransB($data) {
        
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

        return $sql->result_array();
    }
    
    public function logTrans($var_recieve) {
        $date_from = $var_recieve['date_from'];
        $date_to = $var_recieve['date_to'];
        $cbid = empty($var_recieve['cbid'])?ses_cabang:$var_recieve['cbid'];
        
        $this->db->where("trl_date BETWEEN '$date_from' AND '$date_to'", NULL, FALSE);
        $this->db->where("trl_cbid", $this->input->post('group_cabang'));
        if (!empty($var_recieve['kodeid'])) {
            $this->db->where('trl_kodeid', $var_recieve['kodeid']);
        }
        if (!empty($var_recieve['nodoc'])) {
            $this->db->where('trl_nodoc', $var_recieve['nodoc']);
        }
        if (!empty($var_recieve['ccid'])) {
            $this->db->where('trl_ccid',$var_recieve['ccid']);
        }
        if (!empty($var_recieve['nota'])) {
            $this->db->where('trl_nota', $var_recieve['nota']);
        }
        $this->db->order_by('trl_date', 'ASC');
        $this->db->order_by('trl_name', 'ASC');
        $this->db->order_by('trl_nomer', 'ASC');
        $this->db->order_by('trlid', 'ASC');
        $query = $this->db->get($this->tab_trledger);
        if ($query->num_rows() > 0) {
            return $query->result();
        }
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
            
        ");
    }

}

?>
