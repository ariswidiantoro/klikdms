<?php

/**
 * The MODEL FINANCE
 * @author Rossi Erl
 * 2015-08-29
 */
class Model_Finance extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getCoa($data) {
        $order = !empty($data['sort']) ? " ORDER BY " . $data['sort'] . " " . $data['order'] . "" : " ";
        $limit = !empty($data['limit']) ? " LIMIT " . $data['limit'] . " OFFSET " . $data['offset'] . "" : " ";
        $where = !empty($data['where']) ? " AND " . $data['field'] . " ".$data['operation']." " . $data['offset'] . "" : " ";
        $query = "SELECT * FROM ms_coa WHERE 
           coa_cbid = " . $data['cbid'] . " AND coa_status = '1' ".$where." ".$limit;
        $sql = $this->db->query($query);
        return array('result' => $sql->result_array(), 'numrows' => $sql->num_rows());
    }

    public function addCoa($data) {
        $cek = $this->db->query("SELECT coa_kode FROM ms_coa WHERE coa_kode = '" . $data['coa_kode'] . "'
            AND coa_cbid = " . $data['cbid'] . "");
        if ($cek->num_rows() > 0) {
            return array('status' => FALSE, 'msg' => 'Duplikasi Kode COA');
        } else {
            if ($this->db->insert('ms_coa', $data)) {
                return array('status' => TRUE, 'msg' => 'Kode COA berhasil disimpan');
            } else {
                return array('status' => FALSE, 'msg' => 'Kode COA gagal disimpan');
            }
        }
    }

    public function updateCoa($data) {
        $this->db->where('coaid', $data['coaid']);
        if ($this->db->update('ms_coa', $data)) {
            return array('status' => TRUE, 'msg' => 'Kode COA berhasil disimpan');
        } else {
            return array('status' => FALSE, 'msg' => 'Kode COA gagal disimpan');
        }
    }
    
    function getAllFlateRate($start, $limit, $sidx, $sord, $where) {
        $this->db->select('*');
        $this->db->limit($limit);
        if ($where != NULL)
            $this->db->where($where, NULL, FALSE);
        $this->db->from('svc_frate');
        $this->db->where('flat_cbid', ses_cabang);
        $this->db->where('flat_type', 1);
        $this->db->order_by($sidx, $sord);
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return null;
    }

}

?>
