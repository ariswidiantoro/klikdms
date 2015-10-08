<?php

/**
 * The MODEL SALES
 * @author Rossi Erl
 * 2013-12-13
 */
class Model_Trales extends CI_Model {

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
    
    public function cListPropinsi() {
        $query = $this->db->get('ms_propinsi');
        return $query->result_array();
    }
    
    public function cListAksesories() {
        $this->db->where('aks_cbid', ses_cabang);
        $query = $this->db->get('ms_aksesories');
        return $query->result_array();
    }
    
    public function cListKaroseri() {
        $this->db->where('karo_cbid', ses_cabang);
        $query = $this->db->get('ms_karoseri');
        return $query->result_array();
    }
    
    public function cListLeasing() {
        $this->db->where('leas_cbid', ses_cabang);
        $query = $this->db->get('ms_leasing');
        return $query->result_array();
    }

    public function getModelByMerk($data) {
        $segid = empty($data['segid'])?"": " AND model_segment = '".$data['segid']."'";
        $sql = $this->db->query("SELECT * FROM ms_car_model WHERE 
            model_merkid = '".$data['merkid']."' ".$segid." ORDER BY model_deskripsi ASC");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }
    
    public function getTypeByModel($modelid) {
        $sql = $this->db->query("SELECT * FROM ms_car_type WHERE cty_modelid = '$modelid' ORDER BY cty_deskripsi ASC");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }
    
    public function getWarnaByModel($modelid) {
        $sql = $this->db->query("SELECT * FROM ms_warna_model 
            LEFT JOIN ms_warna ON warnaid = mdlcolor_warnaid
            WHERE mdlcolor_modelid = '$modelid' ORDER BY warna_deskripsi ASC");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }

    public function getKotaByPropinsi($data){
        $sql = $this->db->query("SELECT * FROM ms_kota WHERE kota_propid = '$data' ORDER BY kota_deskripsi");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }
    
    public function getAreaByKota($data){
        $sql = $this->db->query("SELECT * FROM ms_area WHERE area_kotaid = '$data' ORDER BY area_deskripsi");
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

    /** WARNA MODEL KENDARAAN 
     * @author Rossi Erl
     * 2015-09-10
     */
    public function getTotalWarnaModel($where) {
        $sql = $this->db->query("SELECT COUNT(*) AS total FROM ms_warna_model ");
        return $sql->row()->total;
    }

    public function getDataWarnaModel($start, $limit, $sidx, $sord, $where) {
        $this->db->select('*');
        $this->db->limit($limit);
        if ($where != NULL)
            $this->db->where($where, NULL, FALSE);
        $this->db->from('ms_warna_model');
        $this->db->join('ms_car_model', 'modelid=mdlcolor_modelid', 'left');
        $this->db->join('ms_car_merk', 'merkid=model_merkid', 'left');
        $this->db->join('ms_warna', 'warnaid=mdlcolor_warnaid', 'left');
        $this->db->order_by($sidx, $sord);
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return null;
    }

    public function addWarnaModel($data) {
        $qcek = $this->db->query("SELECT mdlcolorid FROM ms_warna_model WHERE 
            mdlcolor_modelid = '" . $data['mdlcolor_modelid'] . "' AND 
            mdlcolor_warnaid = '".$data['mdlcolor_warnaid']."'");
        if ($qcek->num_rows() > 0) {
            return array('status' => FALSE, 'msg' => 'TIPE KENDARAAN SUDAH TERDAFTAR');
        } else {
            if ($this->db->insert('ms_warna_model', $data) == TRUE) {
                return array('status' => TRUE, 'msg' => 'WARNA MODEL BERHASIL DITAMBAHKAN');
            } else {
                return array('status' => FALSE, 'msg' => 'WARNA MODEL GAGAL DITAMBAHKAN');
            }
        }
    }
    
    public function getWarnaModel($data) {
        $query = $this->db->query("
            SELECT * FROM ms_warna_model 
            LEFT JOIN ms_car_model ON mdlcolor_modelid = modelid
            LEFT JOIN ms_car_merk ON model_merkid = merkid
            LEFT JOIN ms_warna ON mdlcolor_warnaid = warnaid
            WHERE mdlcolorid = " . $data . "
            ");
        return $query->row_array();
    }

    public function updateWarnaModel($data, $where) {
        $this->db->where('mdlcolorid', $where);
        if ($this->db->update('ms_warna_model', $data)) {
            return array('status' => TRUE, 'msg' => 'DATA BERHASIL DIUPDATE');
        } else {
            return array('status' => FALSE, 'msg' => 'DATA GAGAL DIUPDATE');
        }
    }

    public function deleteWarnaModel($data) {
        if ($this->db->query('DELETE FROM ms_warna_model WHERE mdlcolorid = ' . $data)) {
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

    public function getDataJkendaraan($start, $limit, $sidx, $sord, $where) {
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

    public function addJkendaraan($data) {
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

    public function getDataAksesories($start, $limit, $sidx, $sord, $where) {
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

    public function addAksesories($data) {
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
    public function getTotalKaroseri($where) {
        $wh = "WHERE karo_cbid = '".ses_cabang."'";
        if ($where != NULL)
            $wh = " AND " . $where;
        $sql = $this->db->query("SELECT COUNT(*) AS total FROM ms_karoseri ".$wh);
        return $sql->row()->total;
    }

    public function getDataKaroseri($start, $limit, $sidx, $sord, $where) {
        $this->db->select('*');
        $this->db->limit($limit);
        if ($where != NULL)
            $this->db->where($where, NULL, FALSE);
        $this->db->from('ms_karoseri');
        $this->db->join('ms_kota', 'kotaid = karo_kotaid', 'left');
        $this->db->where('karo_cbid', ses_cabang);
        $this->db->order_by($sidx, $sord);
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return null;
    }

    public function addKaroseri($data) {
        if ($this->db->insert('ms_karoseri', $data)) {
             return array('status' => TRUE, 'msg' => 'DATA KAROSERI '.$data['karo_nama'].' BERHASIL DIUPDATE');
        } else {
            return array('status' => FALSE, 'msg' => 'DATA KAROSERI '.$data['karo_nama'].' GAGAL DIUPDATE');
        }
    }

    public function updateKaroseri($data, $where) {
        $this->db->where('karoid', $where);
        if ($this->db->update('ms_karoseri', $data)) {
            return array('status' => TRUE, 'msg' => 'DATA KAROSERI '.$data['karo_nama'].' BERHASIL DIUPDATE');
        } else {
            return array('status' => FALSE, 'msg' => 'DATA KAROSERI '.$data['karo_nama'].' GAGAL DIUPDATE');
        }
    }
    
    public function getKaroseri($data) {
        $query = $this->db->query("
            SELECT * FROM ms_karoseri 
            LEFT JOIN ms_kota ON kotaid = karo_kotaid
            LEFT JOIN ms_propinsi ON propid = kota_propid
            WHERE karoid = " . $data . "
            ");
        return $query->row_array();
    }

    public function deleteKaroseri($data) {
        if ($this->db->query('DELETE FROM ms_karoseri WHERE karoid = ' . $data)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    /** MASTER LEASING 
     * @author Rossi Erl
     * 2015-09-18
     */
    public function getTotalLeasing($where) {
        $wh = "WHERE leas_cbid = '".ses_cabang."'";
        if ($where != NULL)
            $wh = " AND " . $where;
        $sql = $this->db->query("SELECT COUNT(*) AS total FROM ms_leasing ");
        return $sql->row()->total;
    }

    public function getDataLeasing($start, $limit, $sidx, $sord, $where) {
        $this->db->select('*');
        $this->db->limit($limit);
        if ($where != NULL)
            $this->db->where($where, NULL, FALSE);
        $this->db->from('ms_leasing');
        $this->db->join('ms_kota', 'kotaid = leas_kotaid', 'left');
        $this->db->where('leas_cbid', ses_cabang);
        $this->db->order_by($sidx, $sord);
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return null;
    }

    public function addLeasing($data) {
        if ($this->db->insert('ms_leasing', $data)) {
                return array('status' => TRUE, 'msg' => 'DATA LEASING BERHASIL DITAMBAHKAN');
            } else {
                return array('status' => FALSE, 'msg' => 'DATA LEASING GAGAL DITAMBAHKAN');
            }
    }

    public function updateLeasing($data, $where) {
        $this->db->where('leasid', $where);
        if ($this->db->update('ms_leasing', $data)) {
            return array('status' => TRUE, 'msg' => 'DATA LEASING '.$data['leas_nama'].' BERHASIL DIUPDATE');
        } else {
            return array('status' => FALSE, 'msg' => 'DATA LEASING '.$data['leas_nama'].' GAGAL DIUPDATE');
        }
    }
    
    public function getLeasing($data) {
        $query = $this->db->query("
            SELECT * FROM ms_leasing 
            LEFT JOIN ms_kota ON kotaid = leas_kotaid
            LEFT JOIN ms_propinsi ON propid = kota_propid
            WHERE leasid = " . $data . "
            ");
        return $query->row_array();
    }

    public function deleteLeasing($data) {
        if ($this->db->query('DELETE FROM ms_leasing WHERE leasid = ' . $data)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    /** MASTER LEASING 
     * @author Rossi Erl
     * 2015-09-18
     */
    public function getTotalCar($where) {
        $wh = "WHERE leas_cbid = '".ses_cabang."'";
        if ($where != NULL)
            $wh = " AND " . $where;
        $sql = $this->db->query("SELECT COUNT(*) AS total FROM ms_leasing ");
        return $sql->row()->total;
    }

    public function getDataCar($start, $limit, $sidx, $sord, $where) {
        $this->db->select('*');
        $this->db->limit($limit);
        if ($where != NULL)
            $this->db->where($where, NULL, FALSE);
        $this->db->from('ms_leasing');
        $this->db->join('ms_kota', 'kotaid = leas_kotaid', 'left');
        $this->db->where('leas_cbid', ses_cabang);
        $this->db->order_by($sidx, $sord);
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return null;
    }

    public function addCar($data) {
        if ($this->db->insert('ms_car', $data)) {
                return array('status' => TRUE, 'msg' => 'DATA KENDARAAN BERHASIL DITAMBAHKAN');
            } else {
                return array('status' => FALSE, 'msg' => 'DATA KENDARAAN GAGAL DITAMBAHKAN');
            }
    }

    public function updateCar($data, $where) {
        $this->db->where('mscid', $where);
        if ($this->db->update('ms_car', $data)) {
            return array('status' => TRUE, 'msg' => 'DATA KENDARAAN BERHASIL DIUPDATE');
        } else {
            return array('status' => FALSE, 'msg' => 'DATA KENDARAAN GAGAL DIUPDATE');
        }
    }
    
    public function getCar($data) {
        $query = $this->db->query("
            SELECT * FROM ms_car
            WHERE mscid = " . $data . "
            ");
        return $query->row_array();
    }

    public function deleteCar($data) {
        if ($this->db->query("DELETE FROM ms_car WHERE mscid = ' ". $data."'")) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}

?>
