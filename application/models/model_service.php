<?php

/**
 * The MODEL ADMIN
 * @author Aris Widiantoro
 * 2013-12-13
 */
class Model_Service extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Function ini digunakan untuk mendapatkan data cabang
     * @param type $where
     * @return int
     */
    public function getTotalFlateRate($where) {

        $wh = "WHERE flat_type = 1 AND flat_cbid = '" . ses_cabang . "'";
        if ($where != NULL)
            $wh = " AND " . $where;

        $sql = $this->db->query("SELECT COUNT(*) AS total FROM svc_frate $wh");
        return $sql->row()->total;
    }

    /**
     * Function ini digunakan untuk mendapatkan data cabang
     * @param type $where
     * @return int
     */
    public function getTotalPelanggan($where, $table) {
        $wh = "WHERE pel_cbid = '" . ses_cabang . "'";
        if ($where != NULL)
            $wh = " AND " . $where;
        $sql = $this->db->query("SELECT COUNT(*) AS total FROM $table $wh");
        return $sql->row()->total;
    }

    /**
     * Function ini digunakan untuk mendapatkan data cabang
     * @param type $where
     * @return int
     */
    public function getTotalStall($where) {
        $wh = "WHERE stall_cbid = '" . ses_cabang . "'";
        if ($where != NULL)
            $wh = " AND " . $where;
        $sql = $this->db->query("SELECT COUNT(*) AS total FROM svc_stall $wh");
        return $sql->row()->total;
    }

    /**
     * Function ini digunakan untuk mendapatkan data cabang
     * @param type $where
     * @return int
     */
    public function getTotalSupplier($where) {
        $wh = "WHERE sup_cbid = '" . ses_cabang . "'";
        if ($where != NULL)
            $wh = " AND " . $where;
        $sql = $this->db->query("SELECT COUNT(supid) AS total FROM ms_supplier $wh");
        return $sql->row()->total;
    }

    /**
     * Function ini digunakan untuk mendapatkan data cabang
     * @param type $where
     * @return int
     */
    public function getTotalKendaraan($where) {
        $wh = "WHERE msc_cbid = '" . ses_cabang . "'";
        if ($where != NULL)
            $wh = " AND " . $where;
        $sql = $this->db->query("SELECT COUNT(mscid) AS total FROM ms_car LEFT JOIN "
                . "ms_car_type ON msc_ctyid = ctyid LEFT JOIN ms_car_model " .
                " ON modelid = cty_modelid LEFT JOIN ms_car_merk ON merkid = " .
                " model_merkid LEFT JOIN ms_pelanggan ON pelid = msc_pelid $wh");
        return $sql->row()->total;
    }

    /**
     * Function ini digunakan untuk mendapatkan data cabang
     * @param type $where
     * @return int
     */
    public function getTotalFreeService($where) {

        $wh = "WHERE flat_type = 2 AND flat_cbid = '" . ses_cabang . "'";
        if ($where != NULL)
            $wh = " AND " . $where;

        $sql = $this->db->query("SELECT COUNT(*) AS total FROM svc_frate $wh");
        return $sql->row()->total;
    }

    /**
     * Function ini digunakan untuk mencari semua jabatan
     * @param type $sort
     * @param type $order
     * @param type $offset
     * @param type $row
     * @param type $where
     * @return type
     */
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

    /**
     * Function ini digunakan untuk mencari semua Cabang
     * @param type $sort
     * @param type $order
     * @param type $offset
     * @param type $row
     * @param type $where
     * @return type
     */
    function getAllPelanggan($start, $limit, $sidx, $sord, $where, $table) {
        $this->db->select('*');
        $this->db->limit($limit);
        if ($where != NULL)
            $this->db->where($where, NULL, FALSE);
        $this->db->where('pel_cbid', ses_cabang);
        $this->db->order_by($sidx, $sord);
        $query = $this->db->get($table, $limit, $start);
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return null;
    }

    function getAllStall($start, $limit, $sidx, $sord, $where) {
        $this->db->select('*');
        $this->db->limit($limit);
        if ($where != NULL)
            $this->db->where($where, NULL, FALSE);
        $this->db->where('stall_cbid', ses_cabang);
        $this->db->order_by($sidx, $sord);
        $query = $this->db->get('svc_stall', $limit, $start);
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return null;
    }

    /**
     * Function ini digunakan untuk mencari semua Cabang
     * @param type $sort
     * @param type $order
     * @param type $offset
     * @param type $row
     * @param type $where
     * @return type
     */
    function getAllSupplier($start, $limit, $sidx, $sord, $where) {
        $this->db->select('*');
        $this->db->limit($limit);
        if ($where != NULL)
            $this->db->where($where, NULL, FALSE);
        $this->db->where('sup_cbid', ses_cabang);
        $this->db->order_by($sidx, $sord);
        $query = $this->db->get('ms_supplier', $limit, $start);
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return null;
    }

    /**
     * Function ini digunakan untuk mencari semua Cabang
     * @param type $sort
     * @param type $order
     * @param type $offset
     * @param type $row
     * @param type $where
     * @return type
     */
    function getAllKendaraan($start, $limit, $sidx, $sord, $where) {
        $this->db->select('mscid, pel_nama,msc_nopol,msc_norangka,msc_nomesin,cty_deskripsi,model_deskripsi,merk_deskripsi,msc_tahun');
        $this->db->limit($limit);
        if ($where != NULL)
            $this->db->where($where, NULL, FALSE);
        $this->db->from('ms_car');
        $this->db->join('ms_pelanggan', 'pelid = msc_pelid', 'LEFT');
        $this->db->join('ms_car_type', 'msc_ctyid = ctyid', 'LEFT');
        $this->db->join('ms_car_model', 'modelid = cty_modelid', 'LEFT');
        $this->db->join('ms_car_merk', 'model_merkid = merkid', 'LEFT');
        $this->db->order_by($sidx, $sord);
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return null;
    }

    /**
     * Function ini digunakan untuk mencari semua jabatan
     * @param type $sort
     * @param type $order
     * @param type $offset
     * @param type $row
     * @param type $where
     * @return type
     */
    function getAllFreeService($start, $limit, $sidx, $sord, $where) {
        $this->db->select('*');
        $this->db->limit($limit);
        if ($where != NULL)
            $this->db->where($where, NULL, FALSE);
        $this->db->from('svc_frate');
        $this->db->where('flat_cbid', ses_cabang);
        $this->db->where('flat_type', 2);
        $this->db->order_by($sidx, $sord);
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return null;
    }

    function saveBasicRate($data) {
        try {
            $str = $this->db->INSERT('svc_brate', $data);
            if ($str) {
                return true;
            } else {
                $errMessage = $this->db->_error_message();
                if (strpos($errMessage, "duplicate key value") == TRUE) {
                    $this->db->where('br_cbid', $data['br_cbid']);
                    $this->db->update('svc_brate', $data);
                    return true;
                }
            }
        } catch (Exception $e) {
            $e->getCode();
        }
        return false;
    }

    function saveFlateRate($data) {
        $this->db->trans_begin();
        $tahun = substr(date('Y'), 2, 2);
        $id = sprintf("%08s", $this->getCounter("FL" . $tahun));
        $data['flatid'] = "FL" . $tahun . $id;
        try {
            $str = $this->db->INSERT('svc_frate', $data);
            if (!$str) {
                log_message('error', 'SUDAH ADAAA');
                $errMessage = $this->db->_error_message();
                if (strpos($errMessage, "duplicate key value") == TRUE) {
                    $this->db->trans_rollback();
                    return false;
                }
            }
        } catch (Exception $e) {
            $e->getCode();
        }
        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            return true;
        } else {
            $this->db->trans_rollback();
            return false;
        }
        return false;
    }

    /**
     * Function ini digunakan untuk mengambil model
     * @param type $data
     * @return boolean
     */
    public function getModelByMerk($merkid) {
        $sql = $this->db->query("SELECT * FROM ms_car_model WHERE model_merkid = '$merkid' ORDER BY model_deskripsi");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }

    public function getKendaraanById($id) {
        $sql = $this->db->query("SELECT * FROM ms_car LEFT JOIN ms_pelanggan ON "
                . "pelid = msc_pelid LEFT JOIN ms_car_type ON ctyid = msc_ctyid LEFT"
                . " JOIN ms_car_model ON modelid = cty_modelid LEFT JOIN ms_car_merk ON merkid = model_merkid"
                . " WHERE mscid = '$id'");
        if ($sql->num_rows() > 0) {
            return $sql->row_array();
        }
        return null;
    }

    /**
     * Function ini digunakan untuk mengambil model
     * @param type $data
     * @return boolean
     */
    public function getTypeByModel($modelid) {
        $sql = $this->db->query("SELECT * FROM ms_car_type WHERE cty_modelid = '$modelid' ORDER BY cty_deskripsi");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }

    function savePelanggan($data) {
        $this->db->trans_begin();
        $tahun = substr(date('Y'), 2, 2);
        $id = sprintf("%08s", $this->getCounter("PE" . $tahun));
        $data['pelid'] = "PE" . $tahun . $id;
        $this->db->INSERT('ms_pelanggan', $data);
        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            return true;
        } else {
            $this->db->trans_rollback();
            return false;
        }
        return false;
    }

    function saveSupplier($data) {
        $this->db->trans_begin();
        $tahun = substr(date('Y'), 2, 2);
        $id = sprintf("%08s", $this->getCounter("SU" . $tahun));
        $data['supid'] = "SU" . $tahun . $id;
        $this->db->INSERT('ms_supplier', $data);
        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            return true;
        } else {
            $this->db->trans_rollback();
            return false;
        }
        return false;
    }

    function saveStall($data) {
        $this->db->trans_begin();
        $this->db->INSERT('svc_stall', $data);
        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            return true;
        } else {
            $this->db->trans_rollback();
            return false;
        }
        return false;
    }

    function saveKendaraan($data) {
        $this->db->trans_begin();
        $tahun = date('y');
        $id = sprintf("%08s", $this->getCounter(NUM_CAR. $tahun));
        $data['mscid'] = NUM_CAR . $tahun . $id;
        $this->db->INSERT('ms_car', $data);
        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            return true;
        } else {
            $this->db->trans_rollback();
            return false;
        }
        return false;
    }

    /**
     * Function ini digunakan untuk mengambil rol
     * @param type $data
     * @return boolean
     */
    public function getBasicRate($id) {
        $sql = $this->db->query("SELECT * FROM svc_brate WHERE br_cbid = '$id'");
        if ($sql->num_rows() > 0) {
            return $sql->row_array();
        }
        return null;
    }

    /**
     * Function ini digunakan untuk mengambil rol
     * @param type $data
     * @return boolean
     */
    public function getFlateRate($id) {
        $sql = $this->db->query("SELECT * FROM svc_frate WHERE flatid = '$id'");
        if ($sql->num_rows() > 0) {
            return $sql->row_array();
        }
        return null;
    }

    /**
     * 
     * @param type $id
     * @return null
     */
    public function getStall($id) {
        $sql = $this->db->query("SELECT * FROM svc_stall WHERE stallid = '$id'");
        if ($sql->num_rows() > 0) {
            return $sql->row_array();
        }
        return null;
    }

    /**
     * Function ini digunakan untuk mengambil rol
     * @param type $data
     * @return boolean
     */
    public function getMekanikBelumAbsen($cbid) {
        $sql = $this->db->query("SELECT * FROM ms_karyawan WHERE kr_jabid = 'JAB002'"
                . " AND krid NOT IN(SELECT abs_krid FROM svc_absensi WHERE abs_tgl"
                . " = '" . date('Y-m-d') . "' AND abs_cbid = '$cbid') AND kr_cbid = '$cbid'");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }

    /**
     * Function ini digunakan untuk mengambil rol
     * @param type $data
     * @return boolean
     */
    public function getMekanikSudahAbsen($cbid) {
        $sql = $this->db->query("SELECT * FROM ms_karyawan LEFT JOIN svc_absensi ON abs_krid = krid WHERE kr_jabid = 'JAB002' AND abs_tgl"
                . " = '" . date('Y-m-d') . "' AND kr_cbid = '$cbid'");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }

    /**
     * Function ini digunakan untuk mengambil rol
     * @param type $data
     * @return boolean
     */
    public function getPelangganByNama($nama, $cbid) {
        $sql = $this->db->query("SELECT * FROM ms_pelanggan WHERE pel_cbid = '$cbid' AND pel_nama LIKE '%" . strtoupper($nama) . "%' ORDER BY pel_nama LIMIT 40");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }

    /**
     * 
     * @param type $role
     * @return boolean
     */
    function hapusPelanggan($data) {
        $this->db->query("UPDATE ms_pelanggan SET pel_status = 1 WHERE pelid = '$data'");
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        return false;
    }

    /**
     * 
     * @param type $role
     * @return boolean
     */
    function hapusSupplier($data) {
        $this->db->query("UPDATE ms_supplier SET sup_status = 1 WHERE supid = '$data'");
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        return false;
    }

    /**
     * 
     * @param type $data
     * @return boolean
     */
    function updateFlateRate($data) {
        $this->db->trans_begin();
        $this->db->where('flatid', $data['flatid']);
        $this->db->update('svc_frate', $data);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    /**
     * 
     * @param type $data
     * @return boolean
     */
    function updatePelanggan($data) {
        $this->db->trans_begin();
        $this->db->where('pelid', $data['pelid']);
        $this->db->update('ms_pelanggan', $data);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    /**
     * 
     * @param type $data
     * @return boolean
     */
    function updateSupplier($data) {
        $this->db->trans_begin();
        $this->db->where('supid', $data['supid']);
        $this->db->update('ms_supplier', $data);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    /**
     * 
     * @param type $data
     * @return boolean
     */
    function updatePrintFaktur($notid) {
        $this->db->trans_begin();
        $sql = 
        $this->db->where('notid', $notid);
        $this->db->update('spa_nota', array('not_'));
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    /**
     * 
     * @param type $data
     * @return boolean
     */
    function updateKendaraan($data) {
        $this->db->trans_begin();
        $this->db->where('mscid', $data['mscid']);
        $this->db->update('ms_car', $data);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    /**
     * Digunakan untuk mengupdate group cabang masing2 user
     * @param type $role
     * @return boolean
     */
    function saveAbsensi($data) {
        $this->db->trans_begin();
        foreach ($data as $det) {
            $this->db->INSERT('svc_absensi', $det);
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

}

?>
