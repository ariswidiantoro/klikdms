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
    public function getMenuUser() {
        $sql = $this->db->query("SELECT * FROM ms_user_role LEFT JOIN ms_role_detail "
                . " ON rode_roleid = user_roleid LEFT JOIN ms_menu ON menuid = rode_menuid WHERE menu_isactive = 1 AND user_krid = '" . ses_krid . "' GROUP BY menuid ORDER BY menu_urut");
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
        $sql = $this->db->query("SELECT * FROM ms_user_role LEFT JOIN ms_role_detail "
                . " ON rode_roleid = user_roleid WHERE user_krid = '" . ses_krid . "' AND rode_menuid = '$id'");
        log_message('error', 'SQL = ' . $this->db->last_query());
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
        $sql = $this->db->query("SELECT * FROM ms_role_detail WHERE rode_roleid = '$data'");
//        log_message('error', 'SQL ROLE = '.$this->db->last_query());
        if ($sql->num_rows() > 0) {
            foreach ($sql->result_array() as $value) {
                $hasil[$value['rode_menuid']] = 1;
            }
        }
        return $hasil;
    }

    /**
     * Function ini digunakan untuk mengambil menu
     * @param type $data
     * @return boolean
     */
    public function getMenuByNama($start, $limit, $sidx, $sord, $where) {
        $this->db->select('*');
        $this->db->limit($limit);
        if ($where != NULL)
            $this->db->where($where, NULL, FALSE);
        $this->db->order_by($sidx, $sord);
        $query = $this->db->get('ms_menu', $limit, $start);
        log_message('error', 'SQL = '.$this->db->last_query());
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return null;
    }

    public function getTotalMenu($where) {
        $sql = $this->db->query("SELECT COUNT(*) AS total FROM ms_menu");
        return $sql->row()->total;
    }

    /**
     * Function ini digunakan untuk mengambil menu
     * @param type $data
     * @return boolean
     */
    public function getMenuSort($cari = null) {
        $where = '';
        if (!empty($cari)) {
            $where = "WHERE (menu_deskripsi LIKE '$cari' OR menu_nama LIKE '$cari')";
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
     * Function ini digunakan untuk mengambil menu
     * @param type $data
     * @return boolean
     */
    public function getMenuModule() {
        $sql = $this->db->query("SELECT * FROM ms_menu WHERE menu_parent_id = -1 ORDER BY menu_urut ASC");
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
     * Function ini digunakan untuk mendapatkan total role
     * @param type $where
     * @return int
     */
    public function getTotalRole($where) {
        if ($where['sortby'] != '') {
            $this->db->like('role_menu', $where['sortby']);
        }
        $this->db->from('ms_role');
        $total = $this->db->count_all_results();
        if ($total > 0) {
            return $total;
        }
        return 0;
    }

    /**
     * Function ini digunakan untuk mendapatkan total role
     * @param type $where
     * @return int
     */
    public function getTotalJabatan($where) {
        if ($where['sortby'] != '') {
            $this->db->like('jabatan_deskripsi', $where['sortby']);
        }
        $this->db->from('ms_jabatan');
        $total = $this->db->count_all_results();
        if ($total > 0) {
            return $total;
        }
        return 0;
    }

    /**
     * Function ini digunakan untuk mendapatkan data cabang
     * @param type $where
     * @return int
     */
    public function getTotalCabang($where) {
        if ($where['sortby'] != '') {
            $this->db->like('cb_nama', $where['sortby']);
        }
        $this->db->from('ms_cabang');
        $this->db->where('cb_status', 0);
        $total = $this->db->count_all_results();
        if ($total > 0) {
            return $total;
        }
        return 0;
    }

    /**
     * Function ini digunakan untuk mencari semua role
     * @param type $sort
     * @param type $order
     * @param type $offset
     * @param type $row
     * @param type $where
     * @return type
     */
    function getAllRole($sort = '', $order = '', $offset = '', $row = '', $where = array()) {
        $this->db->select('*');
        if (!empty($where['sortby'])) {
            $this->db->like('role_menu', $where['sortby']);
        }
        $this->db->from('ms_role');
        $this->db->order_by($sort, $order);
        $this->db->limit($row, $offset);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    function getRole() {
        $sql = $this->db->query("SELECT * FROM ms_role ORDER BY role_menu");
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
     * Function ini digunakan untuk mencari semua role
     * @param type $sort
     * @param type $order
     * @param type $offset
     * @param type $row
     * @param type $where
     * @return type
     */
    function getAllJabatan($sort = '', $order = '', $offset = '', $row = '', $where = array()) {
        $this->db->select('*');
        if (!empty($where['sortby'])) {
            $this->db->like('jabatan_deskripsi', $where['sortby']);
        }
        $this->db->from('ms_jabatan');
        $this->db->order_by($sort, $order);
        $this->db->limit($row, $offset);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
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
    function getAllCabang($sort = '', $order = '', $offset = '', $row = '', $where = array()) {
        $this->db->select('*');
        if (!empty($where['sortby'])) {
            $this->db->like('cb_nama', $where['sortby']);
        }
        $this->db->from('ms_cabang');
        $this->db->where('cb_status', 0);
        $this->db->order_by($sort, $order);
        $this->db->limit($row, $offset);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    /**
     * 
     * @param array $data
     * @return boolean
     */
    function simpanRole($data) {
        $this->db->trans_begin();
        $id = sprintf("%05s", $this->getCounter("R"));
        $data['roleid'] = "R" . $id;
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

    function simpanKaryawan($data) {
        $this->db->trans_begin();
        $id = sprintf("%06s", $this->getCounter("K"));
        $data['krid'] = "K-" . $id;
        $this->db->INSERT('ms_karyawan', $data);
        $group = array(
            'group_krid' => $data['krid'],
            'group_cbid' => $data['kr_cbid'],
        );
        $this->db->INSERT('ms_groupcabang', $group);
        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            return true;
        } else {
            $this->db->trans_rollback();
            return false;
        }
        return false;
    }

    function simpanJabatan($data) {
        $this->db->trans_begin();
        $id = sprintf("%05s", $this->getCounter("J"));
        $data['jabatanid'] = "J" . $id;
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

    function simpanCabang($data) {
        $this->db->trans_begin();
        $id = sprintf("%04s", $this->getCounter("CB"));
        $data['cbid'] = $id;
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
        $sql = $this->db->query("SELECT * FROM ms_karyawan LEFT JOIN ms_groupcabang"
                . " ON group_krid = krid WHERE kr_username = '" . $array['username'] . "' AND group_cbid = '" . $array['cbid'] . "' AND kr_password = '" . $array['password'] . "'");
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
        $sql = $this->db->query("SELECT * FROM ms_groupcabang WHERE group_krid = '$id'");
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
        $sql = $this->db->query("SELECT * FROM ms_jabatan ORDER BY jabatan_deskripsi");
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
    public function getCabang() {
        $sql = $this->db->query("SELECT * FROM ms_cabang WHERE cb_status = 0 ORDER BY cb_nama");
        log_message('error', 'DDDDDDDD ' . $this->db->last_query());
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
        $sql = $this->db->query("SELECT * FROM ms_karyawan WHERE kr_username = '$username'");
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
    public function getJabatanById($id) {
        $sql = $this->db->query("SELECT * FROM ms_jabatan WHERE jabatanid = '$id'");
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
    public function getCabangById($id) {
        $sql = $this->db->query("SELECT * FROM ms_cabang WHERE cbid = '$id'");
        if ($sql->num_rows() > 0) {
            return $sql->row_array();
        }
        return null;
    }

    /**
     * Function ini digunakan untuk mendapatkan total testimonial
     * @param type $where
     * @return int
     */
    public function getTotalKaryawan($where) {
        if ($where['sortby'] != '') {
            $this->db->like($where['sortby'], $where['nama']);
        }
        $this->db->where('kr_status', 0);
        $this->db->from('ms_karyawan');
        $total = $this->db->count_all_results();
        if ($total > 0) {
            return $total;
        }
        return 0;
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
        $this->db->trans_begin();
        $this->db->query("UPDATE ms_cabang SET cb_status = 1 WHERE cbid = '$data'");
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
    function hapusKaryawan($data) {
        $this->db->trans_begin();
        $this->db->query("UPDATE ms_karyawan SET kr_status = 1 WHERE krid = '$data'");
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    function updateJabatan($jab) {
        $this->db->trans_begin();
        $this->db->where('jabatanid', $jab['jabatanid']);
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
    function getAllKaryawan($sort = '', $order = '', $offset = '', $row = '', $where = array()) {
        $this->db->select('*');
        if (!empty($where['sortby'])) {
            $this->db->like($where['sortby'], $where['nama']);
        }
        $this->db->where('kr_status', 0);
        $this->db->from('ms_karyawan');
        $this->db->join('ms_jabatan', "jabatanid = kr_jabatanid", 'left');
        $this->db->order_by($sort, $order);
        $this->db->limit($row, $offset);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

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
    public function hapusJabatan($id) {
        $this->db->where('jabatanid', $id);
        $this->db->delete('ms_jabatan');
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        return true;
    }

    function updateRoleDetail($role) {
        $this->db->trans_begin();
        foreach ($role as $det) {
            $this->db->where('rode_menuid', $det['rode_menuid']);
            $this->db->where('rode_roleid', $det['rode_roleid']);
            $this->db->delete('ms_role_detail');
            if ($det['check'] == 1) {
                $array = array(
                    'rode_menuid' => $det['rode_menuid'],
                    'rode_roleid' => $det['rode_roleid'],
                );
                $this->db->INSERT('ms_role_detail', $array);
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
        $this->db->delete('ms_groupcabang');
        foreach ($data as $det) {
            if ($det['check'] == 1) {
                $array = array(
                    'group_krid' => $det['group_krid'],
                    'group_cbid' => $det['group_cbid'],
                );
                $this->db->INSERT('ms_groupcabang', $array);
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
