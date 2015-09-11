<?php

/**
 * The MODEL SALES
 * @author Rossi Erl
 * 2013-12-13
 */
class Model_Sales extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /* UTILITY */

    public function cListMerk() {
        $this->db->order_by('merk_deskripsi', 'ASC');
        $query = $this->db->get('ms_car_merk');
        return $query->result_array();
    }
    
    public function cListWarna() {
        $this->db->order_by('warna_deskripsi', 'ASC');
        $query = $this->db->get('ms_warna');
        return $query->result_array();
    }

    public function cListModel($data) {
        $this->db->where('model_merkid', $data['merkid']);
        $query = $this->db->get('ms_car_model');
        return $query->result_array();
    }

    public function cListType($data) {
        $this->db->where('cty_modelid', $data['modelid']);
        $query = $this->db->get('ms_car_type');
        return $query->result_array();
    }

    public function cListSegment() {
        $query = $this->db->get('ms_segment');
        return $query->result_array();
    }

    public function getModelByMerk($merkid) {
        $sql = $this->db->query("SELECT * FROM ms_car_model WHERE model_merkid = '$merkid' ORDER BY model_deskripsi");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }

    /** MERK KENDARAAN 
     * @author Rossi Erl
     * 2015-09-03
     */
    public function getTotalMerk() {
        $sql = $this->db->query("SELECT COUNT(*) AS total FROM ms_car_merk ");
        return $sql->row()->total;
    }

    public function getDataMerk($start, $limit, $sidx, $sord, $where) {
        $this->db->select('*');
        $this->db->limit($limit);
        if ($where != NULL)
            $this->db->where($where, NULL, FALSE);
        $this->db->from('ms_car_merk');
        $this->db->order_by($sidx, $sord);
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return null;
    }

    public function addMerk($data) {
        if ($this->db->insert('ms_car_merk', $data)) {
            return array('status' => TRUE, 'msg' => 'Data ' . $data['merk_deskripsi'] . ' berhasil disimpan');
        } else {
            return array('status' => FALSE, 'msg' => 'Data ' . $data['merk_deskripsi'] . ' gagal disimpan');
        }
    }

    public function getMerk($data) {
        $query = $this->db->query("
            SELECT * FROM ms_car_merk WHERE merkid = " . $data . "
            ");
        return $query->row_array();
    }

    public function updateMerk($data, $where) {
        $this->db->where('merkid', $where);
        if ($this->db->update('ms_car_merk', $data)) {
            return array('status' => TRUE, 'msg' => 'Data ' . $data['merk_deskripsi'] . ' berhasil diupdate');
        } else {
            return array('status' => FALSE, 'msg' => 'Data ' . $data['merk_deskripsi'] . ' gagal diupdate');
        }
    }

    public function deleteMerk($data) {
        if ($this->db->query('DELETE FROM ms_car_merk WHERE merkid = ' . $data)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /** SEGMENT KENDARAAN 
     * @author Rossi Erl
     * 2015-09-03
     */
    public function getTotalSegment() {
        $sql = $this->db->query("SELECT COUNT(*) AS total FROM ms_segment ");
        return $sql->row()->total;
    }

    public function getDataSegment($start, $limit, $sidx, $sord, $where) {
        $this->db->select('*');
        $this->db->limit($limit);
        if ($where != NULL)
            $this->db->where($where, NULL, FALSE);
        $this->db->from('ms_segment');
        $this->db->order_by($sidx, $sord);
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return null;
    }

    public function addSegment($data) {
        if ($this->db->insert('ms_segment', $data)) {
            return array('status' => TRUE, 'msg' => 'Data ' . $data['seg_nama'] . ' berhasil disimpan');
        } else {
            return array('status' => FALSE, 'msg' => 'Data ' . $data['seg_nama'] . ' gagal disimpan');
        }
    }

    public function getSegment($data) {
        $query = $this->db->query("
            SELECT * FROM ms_segment WHERE segid = " . $data . "
            ");
        return $query->row_array();
    }

    public function updateSegment($data, $where) {
        $this->db->where('segid', $where);
        if ($this->db->update('ms_segment', $data)) {
            return array('status' => TRUE, 'msg' => 'Data ' . $data['seg_nama'] . ' berhasil diupdate');
        } else {
            return array('status' => FALSE, 'msg' => 'Data ' . $data['seg_nama'] . ' gagal diupdate');
        }
    }

    public function deleteSegment($data) {
        if ($this->db->query("DELETE FROM ms_segment WHERE segid = '" . $data . "'")) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /** MODEL KENDARAAN 
     * @author Rossi Erl
     * 2015-09-03
     */
    public function getTotalModel($where) {
        $sql = $this->db->query("SELECT COUNT(*) AS total FROM ms_car_model ");
        return $sql->row()->total;
    }

    public function getDataModel($start, $limit, $sidx, $sord, $where) {
        $this->db->select('*');
        $this->db->limit($limit);
        if ($where != NULL)
            $this->db->where($where, NULL, FALSE);
        $this->db->from('ms_car_model');
        $this->db->join('ms_car_merk', 'merkid=model_merkid', 'left');
        $this->db->join('ms_segment', 'segid=model_segment', 'left');
        $this->db->order_by($sidx, $sord);
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return null;
    }

    public function addModel($data) {
        $qcek = $this->db->query("SELECT modelid FROM ms_car_model WHERE 
            model_deskripsi = '" . $data['model_deskripsi'] . "'");
        if ($qcek->num_rows() > 0) {
            return array('status' => FALSE, 'msg' => 'MODEL SUDAH TERDAFTAR');
        } else {
            if ($this->db->insert('ms_car_model', $data)) {
                return array('status' => TRUE, 'msg' => 'Data ' . $data['model_deskripsi'] . ' berhasil ditambahkan');
            } else {
                return array('status' => FALSE, 'msg' => 'Data ' . $data['model_deskripsi'] . ' gagal ditambahkan');
            }
        }
    }

    public function getModel($data) {
        $query = $this->db->query("
            SELECT * FROM ms_car_model WHERE modelid = " . $data . "
            ");
        return $query->row_array();
    }

    public function updateModel($data, $where) {
        $this->db->where('modelid', $where);
        if ($this->db->update('ms_car_model', $data)) {
            return array('status' => TRUE, 'msg' => 'Data ' . $data['model_deskripsi'] . ' berhasil diupdate');
        } else {
            return array('status' => FALSE, 'msg' => 'Data ' . $data['model_deskripsi'] . ' gagal diupdate');
        }
    }

    public function deleteModel($data) {
        if ($this->db->query('DELETE FROM ms_car_model WHERE modelid = ' . $data)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /** TIPE KENDARAAN 
     * @author Rossi Erl
     * 2015-09-03
     */
    public function getTotalCarType($where) {
        $sql = $this->db->query("SELECT COUNT(*) AS total FROM ms_car_type ");
        return $sql->row()->total;
    }

    public function getDataCarType($start, $limit, $sidx, $sord, $where) {
        $this->db->select('*');
        $this->db->limit($limit);
        if ($where != NULL)
            $this->db->where($where, NULL, FALSE);
        $this->db->from('ms_car_type');
        $this->db->join('ms_car_model', 'modelid=cty_modelid', 'left');
        $this->db->join('ms_car_merk', 'merkid=model_merkid', 'left');
        $this->db->order_by($sidx, $sord);
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return null;
    }

    /* public function addCarType($data) {
      $qcek = $this->db->query("SELECT ctyid FROM ms_car_type WHERE
      cty_deskripsi = '" . $data['cty_deskripsi'] . "'");
      if ($qcek->num_rows() > 0) {
      return array('status' => FALSE, 'msg' => 'TIPE KENDARAAN SUDAH TERDAFTAR');
      } else {
      try {
      $this->db->trans_begin();
      $this->load->model('model_setting');
      $code = $this->model_setting->newCode(array('type' => 'CTY'));
      if ($code['status'] == FALSE) {
      $warn = "FAILED GENERATE CODE";
      throw new Exception($warn);
      } else {
      $data['ctyid'] = $code['code'];
      }

      if ($this->db->insert('ms_car_type', $data) == FALSE) {
      $warn = "INPUT TIPE KENDARAAN GAGAL";
      throw new Exception($warn);
      }

      if ($this->db->trans_status() == TRUE) {
      $this->db->trans_commit();
      return array('status' => TRUE, 'msg' => 'TIPE KENDARAAN BERHASIL DITAMBAHKAN');
      } else {
      $warn = "INPUT TIPE KENDARAAN GAGAL";
      throw new Exception($warn);
      }
      } catch (Exception $e) {
      $this->db->trans_rollback();
      return array('status' => 0, 'msg' => $e->getMessage());
      }
      }
      } */

    public function addCarType($data) {
        $qcek = $this->db->query("SELECT ctyid FROM ms_car_type WHERE 
            cty_deskripsi = '" . $data['cty_deskripsi'] . "'");
        if ($qcek->num_rows() > 0) {
            return array('status' => FALSE, 'msg' => 'TIPE KENDARAAN SUDAH TERDAFTAR');
        } else {
            if ($this->db->insert('ms_car_type', $data) == TRUE) {
                return array('status' => TRUE, 'msg' => 'TIPE KENDARAAN BERHASIL DITAMBAHKAN');
            } else {
                return array('status' => FALSE, 'msg' => 'TIPE KENDARAAN GAGAL DITAMBAHKAN');
            }
        }
    }
    
    public function getCarType($data) {
        $query = $this->db->query("
            SELECT * FROM ms_car_type 
            LEFT JOIN ms_car_model ON cty_modelid = modelid
            LEFT JOIN ms_car_merk ON model_merkid = merkid
            WHERE ctyid = " . $data . "
            ");
        return $query->row_array();
    }

    public function updateCarType($data, $where) {
        $this->db->where('ctyid', $where);
        if ($this->db->update('ms_car_type', $data)) {
            return array('status' => TRUE, 'msg' => 'Data ' . $data['cty_deskripsi'] . ' berhasil diupdate');
        } else {
            return array('status' => FALSE, 'msg' => 'Data ' . $data['cty_deskripsi'] . ' gagal diupdate');
        }
    }

    public function deleteCarType($data) {
        if ($this->db->query('DELETE FROM ms_car_type WHERE ctyid = ' . $data)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /** WARNA KENDARAAN 
     * @author Rossi Erl
     * 2015-09-03
     */
    public function getTotalWarna() {
        $sql = $this->db->query("SELECT COUNT(*) AS total FROM ms_warna ");
        return $sql->row()->total;
    }

    public function getDataWarna($start, $limit, $sidx, $sord, $where) {
        $this->db->select('*');
        $this->db->limit($limit);
        if ($where != NULL)
            $this->db->where($where, NULL, FALSE);
        $this->db->from('ms_warna');
        $this->db->order_by($sidx, $sord);
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return null;
    }

    public function addWarna($data) {
        if ($this->db->insert('ms_warna', $data)) {
            return array('status' => TRUE, 'msg' => 'Data ' . $data['warna_deskripsi'] . ' berhasil disimpan');
        } else {
            return array('status' => FALSE, 'msg' => 'Data ' . $data['warna_deskripsi'] . ' gagal disimpan');
        }
    }

    public function getWarna($data) {
        $query = $this->db->query("
            SELECT * FROM ms_warna WHERE warnaid = " . $data . "
            ");
        return $query->row_array();
    }

    public function updateWarna($data, $where) {
        $this->db->where('warnaid', $where);
        if ($this->db->update('ms_warna', $data)) {
            return array('status' => TRUE, 'msg' => 'Data ' . $data['warna_deskripsi'] . ' berhasil diupdate');
        } else {
            return array('status' => FALSE, 'msg' => 'Data ' . $data['warna_deskripsi'] . ' gagal diupdate');
        }
    }

    public function deleteWarna($data) {
        if ($this->db->query('DELETE FROM ms_warna WHERE warnaid = ' . $data)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /** JENIS KENDARAAN 
     * @author Rossi Erl
     * 2015-09-03
     */
    public function getTotalJkendaraan() {
        $sql = $this->db->query("SELECT COUNT(*) AS total FROM ms_jenis_kendaraan ");
        return $sql->row()->total;
    }

    public function getAllJkendaraan($start, $limit, $sidx, $sord, $where) {
        $this->db->select('*');
        $this->db->limit($limit);
        if ($where != NULL)
            $this->db->where($where, NULL, FALSE);
        $this->db->from('ms_jenis_kendaraan');
        $this->db->order_by($sidx, $sord);
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return null;
    }

    public function insertJkendaraan($data) {
        if ($this->db->insert('ms_jenis_kendaraan', $data)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function updateJkendaraan($data, $where) {
        $this->db->where('jknid', $where);
        if ($this->db->update('ms_jenis_kendaraan', $data)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function deleteJkendaraan($data) {
        if ($this->db->query('DELETE FROM ms_jenis_kendaraan WHERE jknid = ' . $data)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /** MASTER AKSESORIES 
     * @author Rossi Erl
     * 2015-09-03
     */
    public function getTotalAksesories($where) {
        $wh = "WHERE aks_status = 1 ";
        if ($where != NULL)
            $wh = " AND " . $where;

        $sql = $this->db->query("SELECT COUNT(*) AS total FROM ms_aksesories $wh");
        return $sql->row()->total;
    }

    public function getAllAksesories($start, $limit, $sidx, $sord, $where) {
        $this->db->select('*');
        $this->db->limit($limit);
        if ($where != NULL)
            $this->db->where($where, NULL, FALSE);
        $this->db->from('ms_aksesories');
        $this->db->where('aks_status', '1');
        $this->db->order_by($sidx, $sord);
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return null;
    }

    public function insertAksesories($data) {
        if ($this->db->insert('ms_aksesories', $data)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function updateAksesories($data, $where) {
        $this->db->where('aksid', $where);
        if ($this->db->update('ms_aksesories', $data)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function deleteAksesories($data) {
        if ($this->db->query('DELETE FROM ms_aksesories WHERE aksid = ' . $data)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /** MASTER KAROSERI 
     * @author Rossi Erl
     * 2015-09-03
     */
    public function getTotalKaroseri() {
        $sql = $this->db->query("SELECT COUNT(*) AS total FROM ms_karoseri ");
        return $sql->row()->total;
    }

    public function getAllKaroseri($start, $limit, $sidx, $sord, $where) {
        $this->db->select('*');
        $this->db->limit($limit);
        if ($where != NULL)
            $this->db->where($where, NULL, FALSE);
        $this->db->from('ms_karoseri');
        $this->db->where('karo_cbid', ses_cabang);
        $this->db->order_by($sidx, $sord);
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return null;
    }

    public function insertKaroseri($data) {
        if ($this->db->insert('ms_karoseri', $data)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function updateKaroseri($data, $where) {
        $this->db->where('karoid', $where);
        if ($this->db->update('ms_karoseri', $data)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function deleteKaroseri($data) {
        if ($this->db->query('DELETE FROM ms_karoseri WHERE karoid = ' . $data)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}

?>
