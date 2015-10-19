<?php

/**
 * The MODEL ADMIN
 * @author Aris Widiantoro
 * 2013-12-13
 */
class Model_Admin extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /** TEST ARISSSS
      /**
     * Function ini digunakan untuk mengambil menu
     * @param type $data
     * @return boolean
     */
    public function getMenu() {
        $sql = $this->db->query("SELECT * FROM ms_menu WHERE menu_isactive = 1 ORDER BY menu_urut");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }

    public function getPelangganById($id) {
        $sql = $this->db->query("SELECT * FROM ms_pelanggan LEFT JOIN ms_kota ON kotaid = pel_kotaid WHERE pelid = '$id'");
        if ($sql->num_rows() > 0) {
            return $sql->row_array();
        }
        return null;
    }
    public function getSupplierById($id) {
        $sql = $this->db->query("SELECT * FROM ms_supplier LEFT JOIN ms_kota ON kotaid = sup_kotaid WHERE supid = '$id'");
        if ($sql->num_rows() > 0) {
            return $sql->row_array();
        }
        return null;
    }

    /**
     * Function ini digunakan untuk mengambil menu
     * @param type $data
     * @return boolean
     */
    public function getMenuById($id) {
        $sql = $this->db->query("SELECT * FROM ms_menu WHERE menuid = '$id'");
        if ($sql->num_rows() > 0) {
            return $sql->row_array();
        }
        return null;
    }

    /**
     * Function ini digunakan untuk mengambil menu
     * @param type $data
     * @return boolean
     */
    public function getMenuUser($data) {
        $sql = $this->db->query("SELECT * FROM ms_user_role LEFT JOIN ms_role_detail "
                . " ON rode_roleid = user_roleid LEFT JOIN ms_menu ON menuid = rode_menuid 
                    WHERE menu_isactive = 1 
                        AND user_krid = '" . ses_krid . "' GROUP BY menuid ORDER BY menu_urut");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }

    /**
     * Function ini digunakan untuk mengambil menu
     * @param type $data
     * @return boolean
     */
    public function hakAkses($id) {
        $sql = $this->db->query("SELECT * FROM ms_user_role LEFT JOIN ms_role_det ON"
                . " userro_roleid = roledet_roleid LEFT JOIN ms_menu ON menuid = roledet_menuid"
                . " WHERE userro_krid = '" . ses_krid . "' AND menuid = '$id'");
        if ($sql->num_rows() > 0) {
            return true;
        }
        return false;
    }

    /**
     * Function ini digunakan untuk mengambil menu
     * @param type $data
     * @return boolean
     */
    public function getDetailRole($data) {
        $hasil = array();
        $sql = $this->db->query("SELECT * FROM ms_role_det WHERE roledet_roleid = '$data'");
        if ($sql->num_rows() > 0) {
            foreach ($sql->result_array() as $value) {
                $hasil[$value['roledet_menuid']] = 1;
            }
        }
        return $hasil;
    }

    /**
     * Function ini digunakan untuk mengambil menu
     * @param type $data
     * @return boolean
     */
    public function getMenuSort($sortby, $cari = null) {
        $where = '';
        if (!empty($cari)) {
            $where = "WHERE $sortby LIKE '%$cari%'";
        }
        $sql = $this->db->query("SELECT * FROM ms_menu $where ORDER BY menu_deskripsi ASC");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }

    /**
     * Function ini digunakan untuk mengambil menu
     * @param type $data
     * @return boolean
     */
    public function getMenuSortUrut() {
        $sql = $this->db->query("SELECT * FROM ms_menu WHERE menu_parent_id != -1 ORDER BY menu_urut ASC");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }

    /**
     * Function ini digunakan untuk mengambil perusahan
     * @param type $data
     * @return boolean
     */
    public function getPerusahaan() {
        $sql = $this->db->query("SELECT * FROM ms_company WHERE comp_status = 0 ORDER BY comp_nama ASC");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }

    /**
     * Function ini digunakan untuk mengambil propinsi
     * @param type $data
     * @return boolean
     */
    public function getPropinsi() {
        $sql = $this->db->query("SELECT * FROM ms_propinsi ORDER BY prop_deskripsi");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }

    /**
     * Function ini digunakan untuk mengambil departemen
     * @param type $data
     * @return boolean
     */
    public function getDepartemen() {
        $sql = $this->db->query("SELECT * FROM ms_departemen ORDER BY dept_deskripsi ASC");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }

    /**
     * Function ini digunakan untuk mengambil menu
     * @param type $data
     * @return boolean
     */
    public function getMenuModule() {

        $sql = $this->db->query("SELECT * FROM ms_user_role LEFT JOIN ms_role_det ON"
                . " userro_roleid = roledet_roleid LEFT JOIN ms_menu ON menuid = roledet_menuid"
                . " WHERE menu_parent_id = -1 AND userro_krid = '" . ses_krid . "' ORDER BY menu_urut ASC");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }

    /**
     * Function ini digunakan untuk mengambil menu
     * @param type $data
     * @return boolean
     */
    public function getSubMenu($data) {

        $sql = $this->db->query("SELECT menu_nama,menu_parent_id,menuid,menu_icon,menu_deskripsi,menu_url FROM ms_user_role LEFT JOIN ms_role_det ON"
                . " userro_roleid = roledet_roleid LEFT JOIN ms_menu ON menuid = roledet_menuid"
                . " WHERE menu_parent_id != -1 AND menu_module = ".$data." AND userro_krid = '" . ses_krid . "' ORDER BY menu_urut, menuid ASC");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }

    /**
     * Function ini digunakan untuk menyimpan menu baru
     * @param type $data
     * @return boolean
     */
    public function simpanMenu($data) {
        $sql = $this->db->query("SELECT MAX(menuid) AS id FROM ms_menu");
        $id = $sql->row()->id + 1;
        $data['menuid'] = $id;
        $data['menu_urut'] = $id;
        $this->db->INSERT('ms_menu', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        return false;
    }

    /**
     * Function ini digunakan untuk mendapatkan data cabang
     * @param type $where
     * @return int
     */
    public function getTotalData($where, $table) {
        if ($where != NULL)
            $where = " WHERE " . $where;
        $sql = $this->db->query("SELECT COUNT(*) AS total FROM $table $where");
        return $sql->row()->total;
    }

    /**
     * Function ini digunakan untuk mendapatkan data cabang
     * @param type $where
     * @return int
     */
    public function getTotalJabatan($where, $table) {
        if ($where != NULL)
            $where = " WHERE " . $where;
        $sql = $this->db->query("SELECT COUNT(*) AS total FROM $table LEFT JOIN ms_departemen ON deptid = jab_deptid $where");
        return $sql->row()->total;
    }

    /**
     * Function ini digunakan untuk mendapatkan data karyawab
     * @param type $where
     * @return int
     */
    public function getTotalKaryawan($where) {
        $wh = " WHERE kr_cbid = '".ses_cabang."'";
        if ($where != NULL)
            $wh .= $where;
        $sql = $this->db->query("SELECT COUNT(krid) AS total FROM ms_karyawan LEFT JOIN ms_jabatan ON jabid = kr_jabid $wh");
        return $sql->row()->total;
    }

    /**
     * Function ini digunakan untuk mendapatkan data karyawab
     * @param type $where
     * @return int
     */
    public function getKaryawanById($id) {
        $sql = $this->db->query("SELECT * FROM ms_karyawan LEFT JOIN ms_kota ON kr_kotaid"
                . " = kotaid LEFT JOIN ms_jabatan ON jabid = kr_jabid WHERE krid = '$id'");
        return $sql->row_array();
    }
    /**
     * Function ini digunakan untuk mendapatkan data karyawab
     * @param type $where
     * @return int
     */
    public function getKaryawanByJabatan($id) {
        $sql = $this->db->query("SELECT * FROM ms_karyawan WHERE kr_jabid = '$id' AND kr_cbid = '".ses_cabang."'");
        return $sql->result_array();
    }

    function getRole() {
        $sql = $this->db->query("SELECT * FROM ms_role ORDER BY role_nama");
        return $sql->result_array();
    }

    /**
     * Digunakan untuk mengambil user role
     * @param type $krid
     * @return type
     */
    function getUserRole($krid) {
        $data = array();
        $sql = $this->db->query("SELECT * FROM ms_user_role WHERE user_krid = '$krid'");
        if ($sql->num_rows() > 0) {
            foreach ($sql->result_array() as $value) {
                $data[$value['user_roleid']] = 1;
            }
        }
        return $data;
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
    function getAllData($start, $limit, $sidx, $sord, $where, $table) {
        $this->db->select('*');
        $this->db->limit($limit);
        if ($where != NULL)
            $this->db->where($where, NULL, FALSE);
        $this->db->order_by($sidx, $sord);
        $query = $this->db->get($table, $limit, $start);
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
    function getAllJabatan($start, $limit, $sidx, $sord, $where, $table) {
        $this->db->select('*');
        $this->db->limit($limit);
        if ($where != NULL)
            $this->db->where($where, NULL, FALSE);
        $this->db->from($table);
        $this->db->join('ms_departemen', 'jab_deptid = deptid', 'LEFT');
        $this->db->order_by($sidx, $sord);
        $this->db->limit($limit, $start);
        $query = $this->db->get();
//        $this->db->order_by($sidx, $sord);
//        $query = $this->db->get($table, $limit, $start);
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
    function getAllKaryawan($start, $limit, $sidx, $sord, $where) {
        $this->db->select('kr_nik, kr_nama,kr_status, krid,kr_alamat,kr_hp,kr_nomor_ktp,kr_username,jab_deskripsi');
        $this->db->limit($limit);
        if ($where != NULL)
            $this->db->where($where, NULL, FALSE);
//        $this->db->where('kr_cbid', ses_cabang);
        $this->db->from('ms_karyawan');
        $this->db->join('ms_jabatan', 'kr_jabid = jabid', 'LEFT');
        $this->db->order_by($sidx, $sord);
        $this->db->limit($limit, $start);
        $query = $this->db->get();
//        $this->db->order_by($sidx, $sord);
//        $query = $this->db->get($table, $limit, $start);
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return null;
    }

    /**
     * 
     * @param array $data
     * @return boolean
     */
    function saveRole($data) {
        $this->db->trans_begin();
        $id = $this->getCounter("R");
        $data['roleid'] = $id;
        $this->db->INSERT('ms_role', $data);
        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            return true;
        } else {
            $this->db->trans_rollback();
            return false;
        }
        return false;
    }

    function saveKaryawan($data) {
        $this->db->trans_begin();
        $tahun = substr(date('Y'), 2, 2);
        $id = sprintf("%08s", $this->getCounter("KR" . $tahun));
        $data['krid'] = "KR" . $tahun . $id;
        $this->db->INSERT('ms_karyawan', $data);
        $group = array(
            'group_krid' => $data['krid'],
            'group_cbid' => $data['kr_cbid'],
        );
        $this->db->INSERT('ms_group_cabang', $group);
        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            return true;
        } else {
            $this->db->trans_rollback();
            return false;
        }
        return false;
    }

    function saveJabatan($data) {
        $this->db->trans_begin();
        $id = sprintf("%03s", $this->getCounter("JAB"));
        $data['jabid'] = "JAB" . $id;
        $this->db->INSERT('ms_jabatan', $data);
        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            return true;
        } else {
            $this->db->trans_rollback();
            return false;
        }
        return false;
    }

    function savePerusahaan($data) {
        $this->db->trans_begin();
        $id = sprintf("%03s", $this->getCounter("C"));
        $data['compid'] = "C" . $id;
        $this->db->INSERT('ms_company', $data);
        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            return true;
        } else {
            $this->db->trans_rollback();
            return false;
        }
        return false;
    }

    function saveCabang($data) {
        $this->db->trans_begin();
        $this->db->INSERT('ms_cabang', $data);
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
    public function getRoleById($id) {
        $sql = $this->db->query("SELECT * FROM ms_role WHERE roleid = '$id'");
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
    public function login($array) {
        $sql = $this->db->query("SELECT * FROM ms_karyawan LEFT JOIN ms_group_cabang"
                . " ON group_krid = krid WHERE kr_username = '" . $array['username'] . "' AND group_cbid = '" . $array['cbid'] . "' ");
        if ($sql->num_rows() > 0) {
            return true;
        }
        return false;
    }

    /**
     * Function ini digunakan untuk mengambil rol
     * @param type $data
     * @return boolean
     */
    public function getGroupCabangByUserId($id) {
        $data = array();
        $sql = $this->db->query("SELECT * FROM ms_group_cabang WHERE group_krid = '$id'");
        if ($sql->num_rows() > 0) {
            foreach ($sql->result_array() as $value) {
                $data[$value['group_cbid']] = 1;
            }
        }
        return $data;
    }

    /**
     * Function ini digunakan untuk mengambil jabatan
     * @param type $data
     * @return boolean
     */
    public function getJabatan() {
        $sql = $this->db->query("SELECT * FROM ms_jabatan ORDER BY jab_deskripsi");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }

    /**
     * Function ini digunakan untuk mengambil User Role
     * @param type $data
     * @return boolean
     */
    public function getUserRoleByKrid($krid) {
        $sql = $this->db->query("SELECT * FROM ms_user_role WHERE userro_krid = '$krid'");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }

    /**
     * Function ini digunakan untuk mengambil jabatan
     * @param type $data
     * @return boolean
     */
    public function getKaryawan($nama, $cbid) {
        $sql = $this->db->query("SELECT * FROM ms_karyawan WHERE kr_nama LIKE '%$nama%' AND kr_cbid = '$cbid' ORDER BY kr_nama");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }

    /**
     * Function ini digunakan untuk mengambil jabatan
     * @param type $data
     * @return boolean
     */
    public function getJabatanByDepartemen($departemen) {
        $sql = $this->db->query("SELECT * FROM ms_jabatan WHERE jab_deptid = '$departemen' ORDER BY jab_deskripsi");
        if ($sql->num_rows() > 0) {
            return $sql->result();
        }
        return null;
    }

    /**
     * Function ini digunakan untuk mengambil cabang
     * @param type $data
     * @return boolean
     */
    public function getCabang() {
        $sql = $this->db->query("SELECT * FROM ms_cabang WHERE cb_status = 0 ORDER BY cb_nama");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }

    /**
     * Function ini digunakan untuk mengambil merk
     * @param type $data
     * @return boolean
     */
    public function getMerk() {
        $sql = $this->db->query("SELECT * FROM ms_car_merk ORDER BY merk_deskripsi");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }

    /**
     * Function ini digunakan untuk mengambil warna
     * @param type $data
     * @return boolean
     */
    public function getWarna() {
        $sql = $this->db->query("SELECT * FROM ms_warna ORDER BY warna_deskripsi");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }

    /**
     * Function ini digunakan untuk mengambil cabang
     * @param type $data
     * @return boolean
     */
    public function getUser($username) {
        $sql = $this->db->query("SELECT * FROM ms_karyawan LEFT JOIN ms_cabang ON 
            cbid = kr_cbid LEFT JOIN ms_kota ON kotaid = cb_kotaid WHERE kr_username = '$username'");
        if ($sql->num_rows() > 0) {
            return $sql->row_array();
        }
//        $this->db->close();
        return null;
    }

    /**
     * Function ini digunakan untuk mengambil rol
     * @param type $data
     * @return boolean
     */
    public function getJabatanById($id) {
        $sql = $this->db->query("SELECT * FROM ms_jabatan WHERE jabid = '$id'");
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
    public function getKotaByPropinsi($propid) {
        $sql = $this->db->query("SELECT * FROM ms_kota WHERE kota_propid = '$propid' ORDER BY kota_deskripsi");
        if ($sql->num_rows() > 0) {
            return $sql->result();
        }
        return null;
    }

    /**
     * Function ini digunakan untuk mengambil rol
     * @param type $data
     * @return boolean
     */
    public function getCabangById($id) {
        $sql = $this->db->query("SELECT * FROM ms_cabang LEFT JOIN ms_kota ON kotaid = cb_kotaid WHERE cbid = '$id'");
        if ($sql->num_rows() > 0) {
            return $sql->row_array();
        }
        return null;
    }

    /**
     * 
     * @param type $role
     * @return boolean
     */
    function updateRole($role) {
        $this->db->trans_begin();
        $this->db->where('roleid', $role['roleid']);
        $this->db->update('ms_role', $role);
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
     * @param type $role
     * @return boolean
     */
    function updateKaryawan($data) {
        $this->db->trans_begin();
        $this->db->where('krid', $data['krid']);
        $this->db->update('ms_karyawan', $data);
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
     * @param type $role
     * @return boolean
     */
    function updateMenu($data) {
        $this->db->trans_begin();
        $this->db->where('menuid', $data['menuid']);
        $this->db->update('ms_menu', $data);
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
     * @param type $role
     * @return boolean
     */
    function updateCabang($data) {
        $this->db->trans_begin();
        $this->db->where('cbid', $data['cbid']);
        $this->db->update('ms_cabang', $data);
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
     * @param type $role
     * @return boolean
     */
    function hapusCabang($data) {
        $this->db->query("UPDATE ms_cabang SET cb_status = 1 WHERE cbid = '$data'");
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
    function hapusKaryawan($data) {
        $this->db->query("UPDATE ms_karyawan SET kr_status = 1 WHERE krid = '$data'");
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
    function resetPassword($data) {
        $password = sha1("123456");
        $this->db->query("UPDATE ms_karyawan SET kr_password = '$password' WHERE krid = '$data'");
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        return false;
    }

    function updateJabatan($jab) {
        $this->db->trans_begin();
        $this->db->where('jabid', $jab['jabid']);
        $this->db->update('ms_jabatan', $jab);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    /**
     * Function ini digunakan untuk mencari semua user
     * @param type $sort
     * @param type $order
     * @param type $offset
     * @param type $row
     * @param type $where
     * @return type
     */
//    function getAllKaryawan($sort = '', $order = '', $offset = '', $row = '', $where = array()) {
//        $this->db->select('*');
//        if (!empty($where['sortby'])) {
//            $this->db->like($where['sortby'], $where['nama']);
//        }
//        $this->db->where('kr_status', 0);
//        $this->db->from('ms_karyawan');
//        $this->db->join('ms_jabatan', "jabatanid = kr_jabatanid", 'left');
//        $this->db->order_by($sort, $order);
//        $this->db->limit($row, $offset);
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//            return $query->result_array();
//        }
//    }

    /**
     * function in ini digunakan untuk menghapus user
     * @param type $data
     * @return boolean
     */
    public function hapusRole($id) {
        $this->db->where('roleid', $id);
        $this->db->delete('ms_role');
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        return true;
    }

    /**
     * function in ini digunakan untuk menghapus user
     * @param type $data
     * @return boolean
     */
    public function hapusMenu($id) {
        $this->db->query("UPDATE ms_menu SET menu_status = 1 WHERE menuid = '$id'");
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        return true;
    }

    /**
     * function in ini digunakan untuk menghapus user
     * @param type $data
     * @return boolean
     */
    public function hapusPerusahaan($id) {
        $this->db->query("UPDATE ms_company SET comp_status = 1 WHERE compid = '$id'");
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        return false;
    }

    /**
     * function in ini digunakan untuk menghapus user
     * @param type $data
     * @return boolean
     */
    public function hapusJabatan($id) {
        $this->db->query("UPDATE ms_jabatan SET jab_status = 1 WHERE jabid = '$id'");
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        return true;
    }

    function updateRoleDetail($role) {
        $this->db->trans_begin();
        foreach ($role as $det) {
            $this->db->where('roledet_menuid', $det['roledet_menuid']);
            $this->db->where('roledet_roleid', $det['roledet_roleid']);
            $this->db->delete('ms_role_det');
            if ($det['check'] == 1) {
                $array = array(
                    'roledet_menuid' => $det['roledet_menuid'],
                    'roledet_roleid' => $det['roledet_roleid'],
                );
                $this->db->INSERT('ms_role_det', $array);
            }
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    function updateUserRole($role) {
        $this->db->trans_begin();
        foreach ($role as $det) {
            $this->db->where('userro_krid', $det['userro_krid']);
            $this->db->where('userro_roleid', $det['userro_roleid']);
            $this->db->delete('ms_user_role');
            if ($det['check'] == 1) {
                $array = array(
                    'userro_krid' => $det['userro_krid'],
                    'userro_roleid' => $det['userro_roleid'],
                );
                $this->db->INSERT('ms_user_role', $array);
            }
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    /**
     * Digunakan untk menyimpan user role
     * @param type $role
     * @return boolean
     */
    function simpanUserRole($role) {
        $this->db->trans_begin();
        foreach ($role as $det) {
            $this->db->where('user_krid', $det['user_krid']);
            $this->db->where('user_roleid', $det['user_roleid']);
            $this->db->delete('ms_user_role');
            if ($det['check'] == 1) {
                $array = array(
                    'user_krid' => $det['user_krid'],
                    'user_roleid' => $det['user_roleid'],
                );
                $this->db->INSERT('ms_user_role', $array);
            }
        }
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
    function updateGroupCabang($data, $krid) {
        $this->db->trans_begin();
        $this->db->where('group_krid', $krid);
        $this->db->delete('ms_group_cabang');
        foreach ($data as $det) {
            if ($det['check'] == 1) {
                $array = array(
                    'group_krid' => $det['group_krid'],
                    'group_cbid' => $det['group_cbid'],
                );
                $this->db->INSERT('ms_group_cabang', $array);
            }
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
