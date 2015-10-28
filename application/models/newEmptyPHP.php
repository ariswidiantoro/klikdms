/** DEPARTEMENT (COA) 
     * @author Rossi Erl
     * 2015-09-04
     */
    public function getTotalDepartement($where) {
        $wh = "WHERE  specid != '' ";
        if ($where != NULL)
            $wh .= " AND " . $where;

        $sql = $this->db->query("SELECT COUNT(*) AS total FROM ms_departement $wh");
        return $sql->row()->total;
    }

    public function getDataDepartement($start, $limit, $sidx, $sord, $where) {
        $this->db->select('*');
        $this->db->limit($limit);
        if ($where != NULL)
            $this->db->where($where, NULL, FALSE);
        $this->db->from('ms_departement');
        $this->db->order_by($sidx, $sord);
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return null;
    }

    public function deleteDepartement($data) {
        if ($this->db->query("DELETE FROM ms_departement WHERE specid = '" . $data . "'")) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function addDepartement($data = array()) {
        $this->db->trans_begin();
        $cek = $this->db->query("SELECT dept_deskripsi FROM ms_departement 
            WHERE dept_deskripsi = '" . $data['dept_deskripsi'] . "'");
        if ($cek->num_rows() > 0) {
            $this->db->trans_rollback();
            return array('status' => FALSE, 'msg' => 'Duplikasi Departement');
        }
        $data['specid'] = NUM_SPECIAL_COA . sprintf("%02s", $this->getCounter(NUM_DEPT_));
        $this->db->insert('ms_departement', $data);
        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            return array('status' => TRUE, 'msg' => 'Data berhasil disimpan');
        } else {
            $this->db->trans_rollback();
            return array('status' => FALSE, 'msg' => 'Data gagal disimpan');
        }
    }

    public function setDepartement($data = array()) {
        $this->db->trans_begin();
        $cek = $this->db->query("SELECT setcoa_kode FROM ms_coa_setting 
            WHERE setcoa_kode = '" . $data['setcoa_kode'] . "' AND setcoa_cbid = '" . $data['setcoa_cbid'] . "'");
        if ($cek->num_rows() > 0) {
            $this->db->trans_rollback();
            return array('status' => FALSE, 'msg' => 'Duplikasi Departement');
        }
        $cek = $this->db->query("DELETE FROM ms_coa_setting 
            WHERE setcoa_specid = '" . $data['setcoa_specid'] . "' AND setcoa_cbid = '" . $data['setcoa_cbid'] . "'");
        $this->db->insert('ms_coa_setting', $data);
        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            return array('status' => TRUE, 'msg' => 'Data berhasil disimpan');
        } else {
            $this->db->trans_rollback();
            return array('status' => FALSE, 'msg' => 'Data gagal disimpan');
        }
    }

    public function updateDepartement($data, $where) {
        $this->db->where('specid', $where);
        if ($this->db->update('ms_departement', $data)) {
            return array('status' => TRUE, 'msg' => 'Data berhasil diupdate');
        } else {
            return array('status' => FALSE, 'msg' => 'Data gagal diupdate');
        }
    }

    public function getDepartement($data) {
        $query = $this->db->query("
            SELECT * FROM ms_departement 
            LEFT JOIN ms_coa_setting ON setcoa_cbid = '" . ses_cabang . "' 
                AND setcoa_specid = specid
            WHERE specid = '" . $data . "'  ");
        return $query->row_array();
    }