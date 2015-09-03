<?php

/**
 * Class Admin_Controller
 * @author Aris
 * 2013-11-11
 */
class Admin extends Application {

    /**
     * The new Admin_controller
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('model_admin');
        $this->isLogin();
        $this->hakAkses(6);
    }

    public function index() {
        $this->hakAkses(6);
        $this->data['content'] = 'admin';
        $this->data['menuid'] = '6';
        $this->data['menu'] = 'attribut/menu';
        $this->load->view('template', $this->data);
    }

    /**
     * Function ini digunakan untuk menghapus data acount/kontak kami
     * @since 1.0
     * @author Aris
     */
//    public function getMenu() {
//        $hasil = $this->model_admin->getMenu();
//        echo json_encode($hasil);
//    }

    /**
     * This function is used for display menu form
     * @author Aris
     * @since 1.0
     */
    public function menu() {
        $this->hakAkses(8);
        $this->load->view('menu', $this->data);
    }

    public function departemen() {
        $this->hakAkses(21);
        $this->load->view('departemen', $this->data);
    }

    public function profile() {
//        $this->hakAkses(21);
        $this->data['karyawan'] = $this->model_admin->getKaryawanById(ses_krid);
        $this->load->view('profile', $this->data);
    }

    /**
     * This function is used for display the exmination form
     * @author Aris
     * @since 1.0
     */
    public function dataKaryawan() {
        $this->hakAkses(23);
        $this->load->view('karyawan', $this->data);
    }

    /**
     * This function is used for display the exmination form
     * @author Aris
     * @since 1.0
     */
    public function userRole() {
//        $this->hakAkses(75);
        $this->load->view('userRole', $this->data);
    }

    /**
     * This function is used for display cabang
     * @author Aris
     * @since 1.0
     */
    public function cabang() {
//        $this->hakAkses(76);
        $this->load->view('cabang', $this->data);
    }

    public function jabatan() {
        $this->hakAkses(22);
        $this->load->view('jabatan', $this->data);
    }

    public function perusahaan() {
        $this->hakAkses(20);
        $this->load->view('perusahaan', $this->data);
    }

    /**
     * This function is used for display the role form
     * @author Aris
     * @since 1.0
     */
    public function role() {
        $this->hakAkses(11);
        $this->load->view('role', $this->data);
    }

    /**
     * This function is used for display the role form
     * @author Aris
     * @since 1.0
     */
//    public function groupCabang() {
//        $this->hakAkses(77);
//        $this->load->view('groupCabang', $this->data);
//    }

    public function getMenuSortUrut() {
        echo json_encode($this->model_admin->getSubMenu());
    }

    /**
     * This function is used for display the exmination form
     * @author Aris
     * @since 1.0
     */
    public function addMenu() {
        $this->hakAkses(8);
        $this->data['menu'] = $this->model_admin->getMenuSort('', '');
        $this->load->view('addMenu', $this->data);
    }

    public function addPerusahaan() {
        $this->hakAkses(20);
        $this->load->view('addPerusahaan', $this->data);
    }

    function jsonJabatan() {
        $departemen = $this->input->post('departemen');
        echo json_encode($this->model_admin->getJabatanByDepartemen($departemen));
    }

    function jsonKota() {
        $propid = $this->input->post('propid');
        echo json_encode($this->model_admin->getKotaByPropinsi($propid));
    }

    function jsonKaryawan() {
        $nama = $this->input->post('param');
        $cbid = $this->input->post('cbid');
        $data['response'] = 'false';
        $query = $this->model_admin->getKaryawan($nama, $cbid);
        if (!empty($query)) {
            $data['response'] = 'true';
            $data['message'] = array();
            foreach ($query as $row) {
//                log_message('error', ' errrrr ' . $row['mb_member_id']);
                $data['message'][] = array('value' => $row['kr_nama'], 'krid' => $row['krid'], 'desc' => $row['kr_nama']);
            }
        } else {
            $data['message'][] = array('value' => '', 'label' => "Data Tidak Ada");
        }
        echo json_encode($data);
    }

    /**
     * This function is used for display the exmination form
     * @author Aris
     * @since 1.0
     */
    public function addKaryawan() {
        $this->hakAkses(12);
        $this->data['propinsi'] = $this->model_admin->getPropinsi();
        $this->data['departemen'] = $this->model_admin->getDepartemen();
        $this->data['jabatan'] = $this->model_admin->getJabatan();
        $this->data['cabang'] = $this->model_admin->getCabang();
        $this->load->view('addKaryawan', $this->data);
    }

    public function editKaryawan() {
        $this->hakAkses(12);
        $id = $this->input->GET('id');
        $kar = $this->model_admin->getKaryawanById($id);
        $this->data['kar'] = $kar;
        $this->data['propinsi'] = $this->model_admin->getPropinsi();
        $this->data['kota'] = $this->model_admin->getKotaByPropinsi($kar['kota_propid']);
        $this->data['departemen'] = $this->model_admin->getDepartemen();
        $this->data['jabatan'] = $this->model_admin->getJabatanByDepartemen($kar['jab_deptid']);
        $this->data['atasan'] = $this->model_admin->getKaryawanById($kar['kr_atasan']);
        $this->data['cabang'] = $this->model_admin->getCabang();
        $this->load->view('editKaryawan', $this->data);
    }

    /**
     * This function is used for display the exmination form
     * @author Aris
     * @since 1.0
     */
    public function addRole() {
        $this->hakAkses(11);
        $this->data['content'] = 'addrole';
        $this->load->view('addrole', $this->data);
    }

    /**
     * This function is used for display tambah cabang
     * @author Aris
     * @since 1.0
     */
    public function addCabang() {
        $this->hakAkses(9);
        $this->data['pt'] = $this->model_admin->getPerusahaan();
        $this->load->view('addcabang', $this->data);
    }

    /**
     * This function is used for display the exmination form
     * @author Aris
     * @since 1.0
     */
    public function addJabatan() {
        $this->hakAkses(22);
        $this->data['departemen'] = $this->model_admin->getDepartemen();
        $this->load->view('addjabatan', $this->data);
    }

    function loadMenu() {
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $limit = isset($_POST['rows']) ? $_POST['rows'] : 10;
        $sidx = isset($_POST['sidx']) ? $_POST['sidx'] : 'menu_nama';
        $sord = isset($_POST['sord']) ? $_POST['sord'] : '';
        $start = $limit * $page - $limit;
        $start = ($start < 0) ? 0 : $start;
        $where = whereLoad();
        $this->load->model('model_admin');
        $count = $this->model_admin->getTotalData($where, 'ms_menu');
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;
        $query = $this->model_admin->getAllData($start, $limit, $sidx, $sord, $where, 'ms_menu');
        $responce = new stdClass;
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
        $i = 0;
        if (count($query) > 0)
            foreach ($query as $row) {
                $hapus = '-';
                $edit = '-';
                if ($row->menu_status == '0') {
                    $del = "hapusMenu('" . $row->menuid . "')";
                    $hapus = '<a href="javascript:;" onclick="' . $del . '" title="Hapus"><i class="ace-icon fa fa-trash-o bigger-120 orange"></i>';
                    $edit = '<a href="#admin/editMenu?id=' . $row->menuid . '" title="edit"><i class="ace-icon glyphicon glyphicon-pencil bigger-100"></i>';
                }
                $responce->rows[$i]['id'] = $row->menuid;
                $responce->rows[$i]['cell'] = array(
                    $row->menu_nama, $row->menu_deskripsi, $row->menu_url, $edit, $hapus);
                $i++;
            }
        echo json_encode($responce);
    }

    function loadKaryawan() {
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $limit = isset($_POST['rows']) ? $_POST['rows'] : 10;
        $sidx = isset($_POST['sidx']) ? $_POST['sidx'] : 'kr_nama';
        $sord = isset($_POST['sord']) ? $_POST['sord'] : '';
        $start = $limit * $page - $limit;
        $start = ($start < 0) ? 0 : $start;
        $where = whereLoad();
        $this->load->model('model_admin');
        $count = $this->model_admin->getTotalKaryawan($where);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;
        $query = $this->model_admin->getAllKaryawan($start, $limit, $sidx, $sord, $where);
        $responce = new stdClass;
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
        $i = 0;
        if (count($query) > 0)
            foreach ($query as $row) {
                $hapus = '-';
                $edit = '-';
                if ($row->kr_status == '0') {
                    $del = "hapusKaryawan('" . $row->krid . "')";
                    $hapus = '<a href="javascript:;" onclick="' . $del . '" title="Hapus"><i class="ace-icon fa fa-trash-o bigger-120 orange"></i>';
                    $edit = '<a href="#admin/editKaryawan?id=' . $row->krid . '" title="edit"><i class="ace-icon glyphicon glyphicon-pencil bigger-100"></i>';
                }
                $responce->rows[$i]['id'] = $row->krid;
                $responce->rows[$i]['cell'] = array(
                    $row->kr_nik, $row->kr_nama, $row->kr_alamat, $row->kr_hp, $row->kr_nomor_ktp, $row->kr_username, $edit, $hapus);
                $i++;
            }
        echo json_encode($responce);
    }

    /**
     * 
     */
    function loadUserRole() {
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $limit = isset($_POST['rows']) ? $_POST['rows'] : 10;
        $sidx = isset($_POST['sidx']) ? $_POST['sidx'] : 'kr_nama';
        $sord = isset($_POST['sord']) ? $_POST['sord'] : '';
        $start = $limit * $page - $limit;
        $start = ($start < 0) ? 0 : $start;
        $where = whereLoad();
        $this->load->model('model_admin');
        $count = $this->model_admin->getTotalKaryawan($where);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;
        $query = $this->model_admin->getAllKaryawan($start, $limit, $sidx, $sord, $where);
        $responce = new stdClass;
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
        $i = 0;
        if (count($query) > 0)
            foreach ($query as $row) {
                $editRole = '<a href="#admin/editUserRole?id=' . $row->krid . '" title="Edit User Role"><i class="ace-icon fa fa-cogs bigger-120 green"></i>';
                $group = '<a href="#admin/editGroupCabang?id=' . $row->krid . '" title="Edit Group Cabang"><i class="ace-icon fa fa-globe green"></i>';
                $rst = "resetPassword('" . $row->krid . "')";
                $resetPassword = '<a href="javascript:;" onclick="' . $rst . '" title="Reset Password"><i class="ace-icon fa fa-key green"></i>';
                $responce->rows[$i]['id'] = $row->krid;
                $responce->rows[$i]['cell'] = array(
                    $row->kr_nik, $row->kr_nama, $row->kr_username, $editRole, $group, $resetPassword);
                $i++;
            }
        echo json_encode($responce);
    }

    /**
     * Function ini digunakan untuk menyimpan member
     */
    public function saveMenu() {
        $this->form_validation->set_rules('menu_nama', '<b>Fx</b>', 'xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $active = $this->input->post('menu_isactive');
            if ($active == 'on') {
                $active = 1;
            } else {
                $active = 0;
            }
            $menu = array(
                'menu_nama' => $this->input->post('menu_nama'),
                'menu_url' => $this->input->post('menu_url'),
                'menu_deskripsi' => $this->input->post('menu_deskripsi'),
                'menu_parent_id' => $this->input->post('menu_parent_id'),
                'menu_icon' => $this->input->post('menu_icon'),
                'menu_status' => 0,
            );
            $hasil = $this->model_admin->simpanMenu($menu);
            if ($hasil) {
                $hasil = $this->sukses("Berhasil menyimpan menu");
            } else {
                $hasil = $this->error("Gagal menyimpan menu");
            }
        }
        echo json_encode($hasil);
    }

    /**
     * Function ini digunakan untuk menyimpan member
     */
    public function updateMenu() {
        $this->form_validation->set_rules('menu_nama', '<b>Fx</b>', 'xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $active = $this->input->post('menu_isactive');
            if ($active == 'on') {
                $active = 1;
            } else {
                $active = 0;
            }
            $menu = array(
                'menuid' => $this->input->post('menuid'),
                'menu_nama' => $this->input->post('menu_nama'),
                'menu_url' => $this->input->post('menu_url'),
                'menu_deskripsi' => $this->input->post('menu_deskripsi'),
                'menu_parent_id' => $this->input->post('menu_parent_id'),
                'menu_icon' => $this->input->post('menu_icon'),
            );
            $hasil = $this->model_admin->updateMenu($menu);
            if ($hasil) {
                $hasil = $this->sukses("Berhasil menyimpan menu");
            } else {
                $hasil = $this->error("Gagal menyimpan menu");
            }
        }
        echo json_encode($hasil);
    }

    /**
     * Function ini digunakan untuk menyimpan member
     */
    public function saveRole() {
        $this->form_validation->set_rules('role_menu', '<b>Fx</b>', 'xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $role = array(
                'role_nama' => $this->input->post('role_nama')
            );
            $hasil = $this->model_admin->saveRole($role);
            if ($hasil) {
                $hasil = $this->sukses("Berhasil menyimpan role");
            } else {
                $hasil = $this->error("Gagal menyimpan role");
            }
        }
        echo json_encode($hasil);
    }

    /**
     * Function ini digunakan untuk menyimpan jabatan
     */
    public function saveJabatan() {
        $this->form_validation->set_rules('jab_deskripsi', '<b>Fx</b>', 'xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'jab_deskripsi' => $this->input->post('jab_deskripsi'),
                'jab_deptid' => $this->input->post('jab_deptid')
            );
            $hasil = $this->model_admin->saveJabatan($data);
            if ($hasil) {
                $hasil = $this->sukses("Berhasil menyimpan jabatan");
            } else {
                $hasil = $this->error("Gagal menyimpan jabatan");
            }
        }
        echo json_encode($hasil);
    }

    /**
     * Function ini digunakan untuk menyimpan cabang
     */
    public function saveCabang() {
        $this->form_validation->set_rules('cb_nama', '<b>Fx</b>', 'xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'cb_nama' => $this->input->post('cb_nama'),
                'cbid' => $this->input->post('cbid'),
                'cb_compid' => $this->input->post('cb_compid'),
                'cb_telpon' => $this->input->post('cb_telpon'),
                'cb_fax' => $this->input->post('cb_fax'),
                'cb_npwp' => $this->input->post('cb_npwp'),
                'cb_email' => $this->input->post('cb_email'),
                'cb_alamat' => $this->input->post('cb_alamat')
            );
            $hasil = $this->model_admin->saveCabang($data);
            if ($hasil) {
                $hasil = $this->sukses("Berhasil menyimpan Cabang");
            } else {
                $hasil = $this->error("Gagal menyimpan Cabang");
            }
        }
        echo json_encode($hasil);
    }

    /**
     * Function ini digunakan untuk menyimpan cabang
     */
    public function savePerusahaan() {
        $this->form_validation->set_rules('comp_nama', '<b>Fx</b>', 'xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'comp_nama' => $this->input->post('comp_nama'),
                'comp_alamat' => $this->input->post('comp_alamat')
            );
            $hasil = $this->model_admin->savePerusahaan($data);
            if ($hasil) {
                $hasil = $this->sukses("Berhasil menyimpan Cabang");
            } else {
                $hasil = $this->error("Gagal menyimpan Cabang");
            }
        }
        echo json_encode($hasil);
    }

    /**
     * Function ini digunakan untuk menyimpan karyawan
     */
    public function saveKaryawan() {
        $this->form_validation->set_rules('kr_nama', '<b>Fx</b>', 'xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $tgl = $this->input->post('kr_tgl_lahir');
            if (empty($tgl)) {
                $tgl = defaultTgl();
            }
            $data = array(
                'kr_nik' => $this->input->post('kr_nik'),
                'kr_nama' => $this->input->post('kr_nama'),
                'kr_kotaid' => $this->input->post('kr_kotaid'),
                'kr_alamat' => $this->input->post('kr_alamat'),
                'kr_jabid' => $this->input->post('kr_jabid'),
                'kr_atasan' => $this->input->post('kr_atasanid'),
                'kr_nomor_ktp' => $this->input->post('kr_nomor_ktp'),
                'kr_cbid' => $this->input->post('kr_cbid'),
                'kr_username' => $this->input->post('kr_username'),
                'kr_password' => sha1('123456'),
                'kr_hp' => $this->input->post('kr_hp'),
                'kr_email' => $this->input->post('kr_email'),
                'kr_tempat_lahir' => $this->input->post('kr_tempat_lahir'),
                'kr_tgl_lahir' => dateToIndo($tgl),
            );
            $hasil = $this->model_admin->saveKaryawan($data);
            if ($hasil) {
                $hasil = $this->sukses("Berhasil menyimpan karyawan");
            } else {
                $hasil = $this->error("Gagal menyimpan karyawan");
            }
        }
        echo json_encode($hasil);
    }

    /**
     * Function ini digunakan untuk menyimpan karyawan
     */
    public function updateKaryawan() {
        $this->form_validation->set_rules('kr_nama', '<b>Fx</b>', 'xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $tgl = $this->input->post('kr_tgl_lahir');
            if (empty($tgl)) {
                $tgl = defaultTgl();
            }
//            $kota = $this->input->post('kr_kotaid');
//            log_message('error', 'KOTA '.$kota);
            $data = array(
                'krid' => $this->input->post('krid'),
                'kr_nik' => $this->input->post('kr_nik'),
                'kr_nama' => $this->input->post('kr_nama'),
                'kr_kotaid' => $this->input->post('kr_kotaid'),
                'kr_alamat' => $this->input->post('kr_alamat'),
                'kr_jabid' => $this->input->post('kr_jabid'),
                'kr_atasan' => $this->input->post('kr_atasanid'),
                'kr_nomor_ktp' => $this->input->post('kr_nomor_ktp'),
                'kr_cbid' => $this->input->post('kr_cbid'),
                'kr_username' => $this->input->post('kr_username'),
                'kr_password' => sha1('123456'),
                'kr_hp' => $this->input->post('kr_hp'),
                'kr_email' => $this->input->post('kr_email'),
                'kr_tempat_lahir' => $this->input->post('kr_tempat_lahir'),
                'kr_tgl_lahir' => dateToIndo($tgl),
            );
            $hasil = $this->model_admin->updateKaryawan($data);
            if ($hasil) {
                $hasil = $this->sukses("Berhasil menyimpan karyawan");
            } else {
                $hasil = $this->error("Gagal menyimpan karyawan");
            }
        }
        echo json_encode($hasil);
    }

    /**
     * Function ini digunakan untuk mengambil data kota
     */
    public function loadRole() {
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $limit = isset($_POST['rows']) ? $_POST['rows'] : 10;
        $sidx = isset($_POST['sidx']) ? $_POST['sidx'] : 'role_nama';
        $sord = isset($_POST['sord']) ? $_POST['sord'] : '';
        $start = $limit * $page - $limit;
        $start = ($start < 0) ? 0 : $start;
        $where = whereLoad();
        $this->load->model('model_admin');
        $count = $this->model_admin->getTotalData($where, 'ms_role');
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
            $page = $total_pages;
        $query = $this->model_admin->getAllData($start, $limit, $sidx, $sord, $where, 'ms_role');
        $responce = new stdClass;
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
        $i = 0;
        if (count($query) > 0)
            foreach ($query as $row) {
                $hapus = '-';
                $edit = '-';
                $menu = '-';
                if ($row->role_status == '0') {
                    $del = "hapusRole('" . $row->roleid . "')";
                    $menu = '<a href="#admin/editRoleDetail?id=' . $row->roleid . '" title="edit menu"><i class="ace-icon fa fa-folder-open bigger-120 green"></i>';
                    $hapus = '<a href="javascript:;" onclick="' . $del . '" title="Hapus"><i class="ace-icon fa fa-trash-o bigger-120 orange"></i>';
                    $edit = '<a href="#admin/editRole?id=' . $row->roleid . '" title="edit"><i class="ace-icon glyphicon glyphicon-pencil bigger-100"></i>';
                }
                $responce->rows[$i]['id'] = $row->roleid;
                $responce->rows[$i]['cell'] = array(
                    $row->role_nama, $menu, $edit, $hapus);
                $i++;
            }
        echo json_encode($responce);
    }

    /**
     * Function ini digunakan untuk mengambil data kota
     */
    public function loadPerusahaan() {
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $limit = isset($_POST['rows']) ? $_POST['rows'] : 10;
        $sidx = isset($_POST['sidx']) ? $_POST['sidx'] : 'comp_nama';
        $sord = isset($_POST['sord']) ? $_POST['sord'] : '';
        $start = $limit * $page - $limit;
        $start = ($start < 0) ? 0 : $start;
        $where = whereLoad();
        $this->load->model('model_admin');
        $count = $this->model_admin->getTotalData($where, 'ms_company');
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
            $page = $total_pages;
        $query = $this->model_admin->getAllData($start, $limit, $sidx, $sord, $where, 'ms_company');
        $responce = new stdClass;
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
        $i = 0;
        if (count($query) > 0)
            foreach ($query as $row) {
                $hapus = 'Sudah Dihapus';
                $edit = '-';
                if ($row->comp_status == '0') {
                    $del = "hapusPerusahaan('" . $row->compid . "')";
                    $hapus = '<a href="javascript:;" onclick="' . $del . '" title="Hapus"><i class="ace-icon fa fa-trash-o bigger-120 orange"></i>';
                    $edit = '<a href="#admin/editRole?id=' . $row->compid . '" title="edit"><i class="ace-icon glyphicon glyphicon-pencil bigger-100"></i>';
                }
                $responce->rows[$i]['id'] = $row->compid;
                $responce->rows[$i]['cell'] = array(
                    $row->compid, $row->comp_nama, $row->comp_alamat, $edit, $hapus);
                $i++;
            }
        echo json_encode($responce);
    }

    /**
     * Function ini digunakan untuk mengambil data jabatan
     */
    public function loadJabatan() {
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $limit = isset($_POST['rows']) ? $_POST['rows'] : 10;
        $sidx = isset($_POST['sidx']) ? $_POST['sidx'] : 'comp_nama';
        $sord = isset($_POST['sord']) ? $_POST['sord'] : '';
        $start = $limit * $page - $limit;
        $start = ($start < 0) ? 0 : $start;
        $where = whereLoad();
        $this->load->model('model_admin');
        $count = $this->model_admin->getTotalJabatan($where, 'ms_jabatan');
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
            $page = $total_pages;
        $query = $this->model_admin->getAllJabatan($start, $limit, $sidx, $sord, $where, 'ms_jabatan');
        $responce = new stdClass;
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
        $i = 0;
        if (count($query) > 0)
            foreach ($query as $row) {
                $hapus = 'Sudah Dihapus';
                $edit = '-';
                if ($row->jab_status == '0') {
                    $del = "hapusJabatan('" . $row->jabid . "')";
                    $hapus = '<a href="javascript:;" onclick="' . $del . '" title="Hapus"><i class="ace-icon fa fa-trash-o bigger-120 orange"></i>';
                    $edit = '<a href="#admin/editJabatan?id=' . $row->jabid . '" title="edit"><i class="ace-icon glyphicon glyphicon-pencil bigger-100"></i>';
                }
                $responce->rows[$i]['id'] = $row->jabid;
                $responce->rows[$i]['cell'] = array(
                    $row->jabid, $row->dept_deskripsi, $row->jab_deskripsi, $edit, $hapus);
                $i++;
            }
        echo json_encode($responce);
    }

    /**
     * Function ini digunakan untuk mengambil data jabatan
     */
    public function loadCabang() {
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $limit = isset($_POST['rows']) ? $_POST['rows'] : 10;
        $sidx = isset($_POST['sidx']) ? $_POST['sidx'] : 'menu_nama';
        $sord = isset($_POST['sord']) ? $_POST['sord'] : '';
        $start = $limit * $page - $limit;
        $start = ($start < 0) ? 0 : $start;
        $where = whereLoad();
        $this->load->model('model_admin');
        $count = $this->model_admin->getTotalData($where, 'ms_cabang');
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;
        $query = $this->model_admin->getAllData($start, $limit, $sidx, $sord, $where, 'ms_cabang');
        $responce = new stdClass;
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
        $i = 0;
        if (count($query) > 0)
            foreach ($query as $row) {
                $hapus = 'Dihapus';
                $edit = '-';
                if ($row->cb_status == '0') {
                    $del = "hapusCabang('" . $row->cbid . "')";
                    $hapus = '<a href="javascript:;" onclick="' . $del . '" title="Hapus"><i class="ace-icon fa fa-trash-o bigger-120 orange"></i>';
                    $edit = '<a href="#admin/editCabang?id=' . $row->cbid . '" title="edit"><i class="ace-icon glyphicon glyphicon-pencil bigger-100"></i>';
                }
                $responce->rows[$i]['id'] = $row->cbid;
                $responce->rows[$i]['cell'] = array(
                    $row->cbid, $row->cb_nama, $row->cb_alamat, $row->cb_telpon, $row->cb_npwp, $edit, $hapus);
                $i++;
            }
        echo json_encode($responce);
    }

    /**
     * Function ini digunakan untuk mengambil data jabatan
     */
    public function loadDepartemen() {
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $limit = isset($_POST['rows']) ? $_POST['rows'] : 10;
        $sidx = isset($_POST['sidx']) ? $_POST['sidx'] : 'deptid';
        $sord = isset($_POST['sord']) ? $_POST['sord'] : '';
        $start = $limit * $page - $limit;
        $start = ($start < 0) ? 0 : $start;
        $where = whereLoad();
        $this->load->model('model_admin');
        $count = $this->model_admin->getTotalData($where, 'ms_departemen');
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;
        $query = $this->model_admin->getAllData($start, $limit, $sidx, $sord, $where, 'ms_departemen');
        $responce = new stdClass;
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
        $i = 0;
        if (count($query) > 0)
            foreach ($query as $row) {
                $del = "hapusDepartemen('" . $row->deptid . "')";
                $hapus = '<a href="javascript:;" onclick="' . $del . '" title="Hapus"><i class="ace-icon fa fa-trash-o bigger-120 orange"></i>';
                $edit = '<a href="#admin/editDepartemen?id=' . $row->deptid . '" title="edit"><i class="ace-icon glyphicon glyphicon-pencil bigger-100"></i>';
                $responce->rows[$i]['id'] = $row->deptid;
                $responce->rows[$i]['cell'] = array(
                    $row->deptid, $row->dept_deskripsi, $edit, $hapus);
                $i++;
            }
        echo json_encode($responce);
    }

    function editRole() {
        $this->hakAkses(11);
        $id = $this->input->GET('id');
        $this->data['content'] = 'editRole';
        $this->data['role'] = $this->model_admin->getRoleById($id);
        $this->load->view("editRole", $this->data);
    }

    function editMenu() {
        $this->hakAkses(8);
        $id = $this->input->GET('id');
        $this->data['title'] = 'Edit Menu';
        $this->data['content'] = 'editMenu';
        $this->data['data'] = $this->model_admin->getMenuById($id);
        $this->data['menu'] = $this->model_admin->getMenuSort('', '');
        $this->load->view("editMenu", $this->data);
    }

    /**
     * Digunakan untuk menampilkan form edit jabatan
     */
    function editJabatan() {
        $this->hakAkses(22);
        $id = $this->input->GET('id');
        $this->data['departemen'] = $this->model_admin->getDepartemen();
        $this->data['jab'] = $this->model_admin->getJabatanById($id);
        $this->load->view("editJabatan", $this->data);
    }

    /**
     * Digunakan untuk menampilkan form edit cabang
     */
    function editCabang() {
        $this->hakAkses(9);
        $id = $this->input->GET('id');
        $this->data['pt'] = $this->model_admin->getPerusahaan();
        $this->data['cabang'] = $this->model_admin->getCabangById($id);
        $this->load->view("editcabang", $this->data);
    }

    /**
     * Dgunakan untuk edit role detail
     */
    function editRoleDetail() {
        $this->hakAkses(11);
        $id = $this->input->GET('id');
        $cari = $this->input->GET('cari');
        $this->data['roleid'] = $id;
        $this->data['role'] = $this->model_admin->getRoleById($id);
        $this->data['menu'] = $this->model_admin->getMenuSort($cari);
        $this->data['detail'] = $this->model_admin->getDetailRole($id);
        $this->load->view("editRoleDetail", $this->data);
    }

    /**
     * Dgunakan untuk edit role
     */
    function editUserRole() {
        $this->hakAkses(25);
        $id = $this->input->GET('id');
        $role = $this->model_admin->getUserRoleByKrid($id);
        $isi = array();
        if (count($role) > 0) {
            foreach ($role as $value) {
                $isi[$value['userro_roleid']] = '1';
            }
        }
        $this->data['user'] = $isi;
        $this->data['role'] = $this->model_admin->getRole();
        $this->data['karyawan'] = $this->model_admin->getKaryawanById($id);
        $this->load->view("editUserRole", $this->data);
    }

//    /**
//     * Dgunakan untuk edit role detail
//     */
//    function editGroupCabang() {
//        $id = $this->input->GET('id');
//        $this->data['karyawan'] = $this->model_admin->getKaryawanById($id);
//
//        $role = $this->model_admin->getGroupByKrid($id);
//        $isi = array();
//        if (count($role) > 0) {
//            foreach ($role as $value) {
//                $isi[$value['userro_roleid']] = '1';
//            }
//        }
//        $this->data['user'] = $isi;
//        $this->data['role'] = $this->model_admin->getRole();
//        $this->load->view("editUserRole", $this->data);
//    }

    /**
     * Dgunakan untuk edit role detail
     */
    function getMenuDetail() {
        $id = $this->input->post('roleid');
        $cari = $this->input->post('cari_menu');
        $sortby = $this->input->post('sortby');
        $this->data['roleid'] = $id;
        $this->data['menu'] = $this->model_admin->getMenuSort($sortby, $cari);
        $this->data['detail'] = $this->model_admin->getDetailRole($id);
        $this->load->view("getMenuDetail", $this->data);
    }

    /**
     * Digunakan untk menambah user role
     */
    function addUserRole() {
        $this->hakAkses(25);
        $id = $this->input->GET('id');
        $this->data['title'] = 'Edit Role';
        $this->data['content'] = 'addUserRole';
        $this->data['krid'] = $id;
        $this->data['role'] = $this->model_admin->getRole($id);
        $this->data['user'] = $this->model_admin->getUserRole($id);
        $this->load->view("template", $this->data);
    }

    /**
     * Digunakan untuk mengedit grouo cabang
     */
    function editGroupCabang() {
        $this->hakAkses(25);
        $id = $this->input->GET('id');
        $this->data['karyawan'] = $this->model_admin->getKaryawanById($id);
        $this->data['krid'] = $id;
        $this->data['cbid'] = $this->model_admin->getGroupCabangByUserId($id);
        $this->data['cabang'] = $this->model_admin->getCabang();
        $this->load->view("editGroupCabang", $this->data);
    }

    /**
     * Function ini digunakan untuk menyimpan member
     */
    public function updateRole() {
        $this->form_validation->set_rules('role_nama', '<b>Fx</b>', 'xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $role = array(
                'roleid' => $this->input->post('roleid'),
                'role_nama' => $this->input->post('role_nama'),
            );
            $hasil = $this->model_admin->updateRole($role);
            if ($hasil) {
                $hasil = $this->sukses("Berhasil mengupdate role menu");
            } else {
                $hasil = $this->error("Gagal mengupdate role menu");
            }
        }
        echo json_encode($hasil);
    }

    /**
     * Function ini digunakan untuk menyimpan Cabang
     */
    public function updateCabang() {
        $this->form_validation->set_rules('cb_nama', '<b>Fx</b>', 'xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'cb_nama' => $this->input->post('cb_nama'),
                'cbid' => $this->input->post('cbid'),
                'cb_compid' => $this->input->post('cb_compid'),
                'cb_telpon' => $this->input->post('cb_telpon'),
                'cb_fax' => $this->input->post('cb_fax'),
                'cb_npwp' => $this->input->post('cb_npwp'),
                'cb_email' => $this->input->post('cb_email'),
                'cb_alamat' => $this->input->post('cb_alamat')
            );
            $hasil = $this->model_admin->updateCabang($data);
            if ($hasil) {
                $hasil = $this->sukses("Berhasil mengupdate cabang");
            } else {
                $hasil = $this->error("Gagal mengupdate role menu");
            }
        }
        echo json_encode($hasil);
    }

    /**
     * Function ini digunakan untuk menyimpan jabatan
     */
    public function updateJabatan() {
        $this->form_validation->set_rules('jab_deskripsi', '<b>Fx</b>', 'xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'jabid' => $this->input->post('jabid'),
                'jab_deptid' => $this->input->post('jab_deptid'),
                'jab_deskripsi' => $this->input->post('jab_deskripsi'),
            );
            $hasil = $this->model_admin->updateJabatan($data);
            if ($hasil) {
                $hasil = $this->sukses("Berhasil mengupdate jabatan");
            } else {
                $hasil = $this->error("Gagal mengupdate jabatan");
            }
        }
        echo json_encode($hasil);
    }

    /**
     * Function ini digunakan untuk menghapus data produk
     * @since 1.0
     * @author Aris
     */
    public function hapusRole() {
        $id = $this->input->post('id');
        $hasil = $this->model_admin->hapusRole($id);
        if ($hasil) {
            $this->session->set_flashdata('msg', $this->sukses("Berhasil menghapus role"));
        } else {
            $this->session->set_flashdata('msg', $this->error("Gagal menghapus role"));
        }
        echo json_encode("a");
    }

    /**
     * Function ini digunakan untuk menghapus data jabatan
     * @since 1.0
     * @author Aris
     */
    public function hapusJabatan() {
        $id = $this->input->post('id');
        $hasil = $this->model_admin->hapusJabatan($id);
        if ($hasil) {
            $hasil = $this->sukses("Berhasil menghapus jabatan");
        } else {
            $hasil = $this->error("Gagal menghapus jabatan");
        }
        echo json_encode($hasil);
    }

    /**
     * Function ini digunakan untuk menghapus data produk
     * @since 1.0
     * @author Aris
     */
    public function hapusMenu() {
        $id = $this->input->post('id');
        $hasil = $this->model_admin->hapusMenu($id);
        if ($hasil) {
            $hasil = $this->sukses("Berhasil menghapus menu");
        } else {
            $hasil = $this->error("Gagal menghapus menu");
        }
        echo json_encode($hasil);
    }

    /**
     * Function ini digunakan untuk menghapus data produk
     * @since 1.0
     * @author Aris
     */
    public function hapusCabang() {
        $id = $this->input->post('id');
        $hasil = $this->model_admin->hapusCabang($id);
        if ($hasil) {
            $hasil = $this->sukses("Berhasil menghapus cabang");
        } else {
            $hasil = $this->error("Gagal menghapus cabang");
        }
        echo json_encode($hasil);
    }

    /**
     * Function ini digunakan untuk menghapus data produk
     * @since 1.0
     * @author Aris
     */
    public function resetPassword() {
        $id = $this->input->post('id');
        $hasil = $this->model_admin->resetPassword($id);
        if ($hasil) {
            $hasil = $this->sukses("Berhasil menghapus cabang");
        } else {
            $hasil = $this->error("Gagal menghapus cabang");
        }
        echo json_encode($hasil);
    }

    /**
     * Function ini digunakan untuk menghapus data produk
     * @since 1.0
     * @author Aris
     */
    public function hapusKaryawan() {
        $id = $this->input->post('id');
        $hasil = $this->model_admin->hapusKaryawan($id);
        if ($hasil) {
            $hasil = $this->sukses("Berhasil menghapus Karyawan");
        } else {
            $hasil = $this->error("Gagal menghapus cabang");
        }
        echo json_encode($hasil);
    }

    /**
     * Function ini digunakan untuk menghapus data produk
     * @since 1.0
     * @author Aris
     */
    public function hapusPerusahaan() {
        $id = $this->input->post('id');
        $hasil = $this->model_admin->hapusPerusahaan($id);
        if ($hasil) {
            $hasil = $this->sukses("Berhasil menghapus perusahaan");
        } else {
            $hasil = $this->error("Gagal menghapus perusahaan");
        }
        echo json_encode($hasil);
    }

    function updateRoleDetail() {
        $this->form_validation->set_rules('roleid', '<b>Fx</b>', 'xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $roleid = $this->input->post('roleid');
            $menu = $this->input->post('menuid');
            $arr = array();
            for ($i = 0; $i < count($menu); $i++) {
                $check = 0;
                if ($this->input->post('check' . $menu[$i]) == '1') {
                    $check = 1;
                }
                $arr[] = array(
                    'roledet_roleid' => $roleid,
                    'roledet_menuid' => $menu[$i],
                    'check' => $check,
                );
            }
            $hasil = $this->model_admin->updateRoleDetail($arr);
            if ($hasil) {
                $hasil = $this->sukses("Berhasil mengupdate role menu");
            } else {
                $hasil = $this->error("Gagal mengupdate role menu");
            }
        }
        echo json_encode($hasil);
    }

    function updateUserRole() {
        $this->form_validation->set_rules('krid', '<b>Fx</b>', 'xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $krid = $this->input->post('krid');
            $role = $this->input->post('roleid');
            $arr = array();
            for ($i = 0; $i < count($role); $i++) {
                $check = 0;
                if ($this->input->post('check' . $role[$i]) == '1') {
                    $check = 1;
                }
                $arr[] = array(
                    'userro_krid' => $krid,
                    'userro_roleid' => $role[$i],
                    'check' => $check,
                );
            }
            $hasil = $this->model_admin->updateUserRole($arr);
            if ($hasil) {
                $hasil = $this->sukses("Berhasil mengupdate role");
            } else {
                $hasil = $this->error("Gagal mengupdate role");
            }
        }
        echo json_encode($hasil);
    }

    /**
     * Digunakan untuk mengupdate group cabang masing2 user
     */
    function updateGroupCabang() {
        $this->form_validation->set_rules('krid', '<b>Fx</b>', 'xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $krid = $this->input->post('krid');
            $cbid = $this->input->post('cbid');
            $arr = array();
            for ($i = 0; $i < count($cbid); $i++) {
                $check = 0;
                if ($this->input->post('check' . $cbid[$i]) == '1') {
                    $check = 1;
                }
//                log_message('error', 'CBID ' . $cbid[$i] . 'CHECK = ' . $check);
                $arr[] = array(
                    'group_krid' => $krid,
                    'group_cbid' => $cbid[$i],
                    'check' => $check,
                );
            }
            $hasil = $this->model_admin->updateGroupCabang($arr, $krid);
            if ($hasil) {
                $hasil = $this->sukses("Berhasil mengupdate group cabang");
            } else {
                $hasil = $this->error("Gagal mengupdate group cabang");
            }
        }
        echo json_encode($hasil);
    }

}

?>
