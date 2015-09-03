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

    /** MERK KENDARAAN 
     * @author Rossi Erl
     * 2015-09-03
     */
    public function getTotalMerk() {
        $sql = $this->db->query("SELECT COUNT(*) AS total FROM ms_car_merk ");
        return $sql->row()->total;
    }

    public function getAllMerk($start, $limit, $sidx, $sord, $where) {
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

    public function insertCarMerk($data) {
        if ($this->db->insert('ms_car_merk', $data)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function updateCarMerk($data, $where) {
        $this->db->where('merkid', $where);
        if ($this->db->update('ms_car_merk', $data)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function deleteCarMerk($data) {
        if ($this->db->query('DELETE FROM ms_car_merk WHERE merkid = ' . $data)) {
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

    public function getAllModel($start, $limit, $sidx, $sord, $where) {
        $this->db->select('*');
        $this->db->limit($limit);
        if ($where != NULL)
            $this->db->where($where, NULL, FALSE);
        $this->db->from('ms_car_model');
        $this->db->order_by($sidx, $sord);
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return null;
    }

    public function insertCarModel($data) {
        $qcek = $this->db->query("SELECT modelid FROM ms_car_model WHERE 
            model_deskripsi = '" . $data['model_deskripsi'] . "'");
        if ($qcek->num_rows() > 0) {
            return array('status' => FALSE, 'msg' => 'MODEL SUDAH TERDAFTAR');
        } else {
            try {
                $this->db->trans_begin();
                $this->load->model('model_setting');
                $code = $this->model_setting->newCode(array('type' => 'MDL'));
                if ($code['status'] == FALSE) {
                    $warn = "FAILED GENERATE CODE";
                    throw new Exception($warn);
                } else {
                    $data['modelid'] = $code['code'];
                }

                if ($this->db->insert('ms_car_model', $data) == FALSE) {
                    $warn = "INSERT CAR MODEL FAILED";
                    throw new Exception($warn);
                }

                if ($this->db->trans_status() == TRUE) {
                    $this->db->trans_commit();
                    return array('status' => TRUE, 'msg' => 'MODEL BERHASIL DITAMBAHKAN');
                } else {
                    $warn = "INSERT CAR MODEL FAILED";
                    throw new Exception($warn);
                }
            } catch (Exception $e) {
                $this->db->trans_rollback();
                return array('status' => 0, 'msg' => $e->getMessage());
            }
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

    public function getAllCarType($start, $limit, $sidx, $sord, $where) {
        $this->db->select('*');
        $this->db->limit($limit);
        if ($where != NULL)
            $this->db->where($where, NULL, FALSE);
        $this->db->from('ms_car_type');
        $this->db->order_by($sidx, $sord);
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return null;
    }

    public function insertCarType($data) {
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
    }

    /** WARNA KENDARAAN 
     * @author Rossi Erl
     * 2015-09-03
     */
    public function getTotalWarna() {
        $sql = $this->db->query("SELECT COUNT(*) AS total FROM ms_warna ");
        return $sql->row()->total;
    }

    public function getAllWarna($start, $limit, $sidx, $sord, $where) {
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

    public function insertWarna($data) {
        if ($this->db->insert('ms_warna', $data)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function updateWarna($data, $where) {
        $this->db->where('warnaid', $where);
        if ($this->db->update('ms_warna', $data)) {
            return TRUE;
        } else {
            return FALSE;
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
