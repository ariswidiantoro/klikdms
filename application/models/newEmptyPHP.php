public function getTotalMasterJurnal($where) {
        $wh = "WHERE tipeid != '0' ";
        if ($where != NULL)
            $wh .= " AND " . $where;

        $sql = $this->db->query("SELECT COUNT(*) AS total FROM ms_tipe_jurnal $wh");
        return $sql->row()->total;
    }

    public function getDataMasterJurnal($start, $limit, $sidx, $sord, $where) {
        $this->db->select('*');
        $this->db->limit($limit);
        if ($where != NULL)
            $this->db->where($where, NULL, FALSE);
        $this->db->from('ms_tipe_jurnal');
        $this->db->order_by($sidx, $sord);
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return null;
    }

    public function addMasterJurnal($data) {
        if ($this->db->insert('ms_tipe_jurnal', $data)) {
            return array('status' => TRUE, 'msg' => 'Data ' . $data['tipe_deskripsi'] . ' berhasil disimpan');
        } else {
            return array('status' => FALSE, 'msg' => 'Data ' . $data['tipe_deskripsi'] . ' gagal disimpan');
        }
    }

    public function getMasterJurnal($data) {
        $query = $this->db->query("
            SELECT * FROM ms_tipe_jurnal WHERE tipeid = " . $data . "
            ");
        return $query->row_array();
    }

    public function updateMasterJurnal($data, $where) {
        $this->db->where('tipeid', $where);
        if ($this->db->update('ms_tipe_jurnal', $data)) {
            return array('status' => TRUE, 'msg' => 'Data ' . $data['tipe_deskripsi'] . ' berhasil diupdate');
        } else {
            return array('status' => FALSE, 'msg' => 'Data ' . $data['tipe_deskripsi'] . ' gagal diupdate');
        }
    }

    public function deleteMasterJurnal($data) {
        if ($this->db->query('DELETE FROM ms_tipe_jurnal WHERE tipeid = ' . $data)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }