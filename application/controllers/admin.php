<?php

/**
 * Class Admin_Controller
 * @author Aris
 * 2013-11-11
 */
class admin extends Application {

    // INI TEST ADMINNNNNNNNNNNNNNNNNNNNnn
    /**
     * The new Admin_controller
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('model_admin');
//        $this->hakAkses(1);
//        $this->check_login();
    }
    
    // INI DARI CONTROLLER GITHUB
    // INI JUGA DARI GITHUB
    

    public function index() {
        $this->data['content'] = 'atribut/admin';
        $this->data['parent'] = '6';
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
//        $this->hakAkses(2);
        $this->load->view('menu', $this->data);
    }

    /**
     * This function is used for display the exmination form
     * @author Aris
     * @since 1.0
     */
    public function karyawan() {
        $this->hakAkses(75);
        $this->data['title'] = 'Form Karyawan';
        $this->data['content'] = 'user';
        $this->load->view('template', $this->data);
    }

    /**
     * This function is used for display cabang
     * @author Aris
     * @since 1.0
     */
    public function cabang() {
        $this->hakAkses(76);
        $this->data['title'] = 'Cabang';
        $this->data['content'] = 'cabang';
        $this->load->view('template', $this->data);
    }

    /**
     * This function is used for display the exmination form
     * @author Aris
     * @since 1.0
     */
    public function jabatan() {
        $this->hakAkses(74);
        $this->data['title'] = 'Form Jabatan';
        $this->data['content'] = 'jabatan';
        $this->load->view('template', $this->data);
    }

    /**
     * This function is used for display the role form
     * @author Aris
     * @since 1.0
     */
    public function role() {
//        $this->hakAkses(5);
        $this->load->view('role', $this->data);
    }

    /**
     * This function is used for display the role form
     * @author Aris
     * @since 1.0
     */
    public function groupCabang() {
        $this->hakAkses(77);
        $this->data['title'] = 'Form Group Cabang';
        $this->data['content'] = 'groupCabang';
        $this->load->view('template', $this->data);
    }

    public function getMenuSortUrut() {
        echo json_encode($this->model_admin->getMenuSortUrut());
    }

    /**
     * This function is used for display the exmination form
     * @author Aris
     * @since 1.0
     */
    public function addMenu() {
//        $this->hakAkses(2);
        $this->data['menu'] = $this->model_admin->getMenuSort();
        $this->load->view('addMenu', $this->data);
    }

    /**
     * This function is used for display the exmination form
     * @author Aris
     * @since 1.0
     */
    public function addKaryawan() {
        $this->hakAkses(75);
        $this->data['title'] = 'Tambah Karyawan';
        $this->data['content'] = 'addKaryawan';
        $this->data['jabatan'] = $this->model_admin->getJabatan();
        $this->data['cabang'] = $this->model_admin->getCabang();
        $this->load->view('template', $this->data);
    }

    /**
     * This function is used for display the exmination form
     * @author Aris
     * @since 1.0
     */
    public function addRole() {
        $this->hakAkses(5);
        $this->data['title'] = 'Tambah Role';
        $this->data['content'] = 'addrole';
        $this->load->view('template', $this->data);
    }

    /**
     * This function is used for display tambah cabang
     * @author Aris
     * @since 1.0
     */
    public function addCabang() {
        $this->hakAkses(76);
        $this->data['title'] = 'Tambah Cabang';
        $this->data['content'] = 'addcabang';
        $this->load->view('template', $this->data);
    }

    /**
     * This function is used for display the exmination form
     * @author Aris
     * @since 1.0
     */
    public function addJabatan() {
        $this->hakAkses(74);
        $this->data['title'] = 'Tambah Jabatan';
        $this->data['content'] = 'addjabatan';
        $this->load->view('template', $this->data);
    }

    /**
     * Function ini digunakan untuk mengambil data menus
     */
//    public function loadMenu() {
//        $nama = isset($_POST['menu_nama']) ? trim($_POST['menu_nama']) : '';
//        $result = array();
//        $data = $this->model_admin->getMenuByNama($nama);
//        $row = array();
//        $result['total'] = count($data);
//        if (count($data) > 0) {
//            foreach ($data as $val) {
//                $delete = 'deleteMenu("' . $val['menuid'] . '")';
//                $ed = 'editMenu("' . $val['menuid'] . '")';
//                $edit = "<a href='" . site_url('administrator/editMenu') . "/?id=" . $val['menuid'] . "' class='green' title='Edit'><i class='ace-icon fa fa-pencil bigger-130'></i></a>";
//                $del = "" . "<a href='javascript:void(0)' onclick='$delete' class='red' title='Delete'><i class='ace-icon fa fa-trash-o bigger-130'></i></a>";
//                if ($val['menu_parentid'] == '-1') {
//                    $row[] = array(
//                        'menuid' => $val['menuid'],
//                        'menu_nama' => '<STRONG>' . $val['menu_nama'] . '</STRONG>',
//                        'menu_url' => $val['menu_url'],
//                        'menu_type' => $val['menu_type'],
//                        'menu_deskripsi' => $val['menu_deskripsi'],
//                        'menu_icon' => $val['menu_icon'],
//                        'menu_isactive' => $val['menu_isactive'],
//                        'edit' => $edit,
//                        'delete' => $del,
//                    );
//                } else {
//                    $row[] = array(
//                        'menuid' => $val['menuid'],
//                        'menu_nama' => '<STRONG>' . $val['menu_nama'] . '</STRONG>',
//                        'menu_url' => $val['menu_url'],
//                        'menu_type' => $val['menu_type'],
//                        'menu_deskripsi' => $val['menu_deskripsi'],
//                        'menu_icon' => $val['menu_icon'],
//                        '_parentId' => $val['menu_parentid'],
//                        'menu_isactive' => $val['menu_isactive'],
//                        'edit' => $edit,
//                        'delete' => $del,
//                    );
//                }
//            }
//        } else {
//            $row[] = array(
//                'description' => 'Data Not Found',
//            );
//        }
//
//        $result['rows'] = $row;
//        echo json_encode($result);
//    }

    function loadMenu() {
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $limit = isset($_POST['rows']) ? $_POST['rows'] : 10;
        $sidx = isset($_POST['sidx']) ? $_POST['sidx'] : 'menu_nama';
        $sord = isset($_POST['sord']) ? $_POST['sord'] : '';
        $start = $limit * $page - $limit;
        $start = ($start < 0) ? 0 : $start;
//
//        $where = "";
//        $searchField = isset($_POST['searchField']) ? $_POST['searchField'] : false;
//        $searchOper = isset($_POST['searchOper']) ? $_POST['searchOper'] : false;
//        $searchString = isset($_POST['searchString']) ? $_POST['searchString'] : false;
//
//        if ($_POST['_search'] == 'true') {
//            $ops = array(
//                'eq' => '=',
//                'ne' => '<>',
//                'lt' => '<',
//                'le' => '<=',
//                'gt' => '>',
//                'ge' => '>=',
//                'bw' => 'LIKE',
//                'bn' => 'NOT LIKE',
//                'in' => 'LIKE',
//                'ni' => 'NOT LIKE',
//                'ew' => 'LIKE',
//                'en' => 'NOT LIKE',
//                'cn' => 'LIKE',
//                'nc' => 'NOT LIKE'
//            );
//            foreach ($ops as $key => $value) {
//                if ($searchOper == $key) {
//                    $ops = $value;
//                }
//            }
//            if ($searchOper == 'eq')
//                $searchString = $searchString;
//            if ($searchOper == 'bw' || $searchOper == 'bn')
//                $searchString .= '%';
//            if ($searchOper == 'ew' || $searchOper == 'en')
//                $searchString = '%' . $searchString;
//            if ($searchOper == 'cn' || $searchOper == 'nc' || $searchOper == 'in' || $searchOper == 'ni')
//                $searchString = '%' . $searchString . '%';
//
//            $where = "$searchField $ops '$searchString' ";
//        }

        if (!$sidx)
            $sidx = 1;
        $where = array();
        $this->load->model('model_admin');
        $count = $this->model_admin->getTotalMenu($where);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;
        $query = $this->model_admin->getMenuByNama($start, $limit, $sidx, $sord, $where);
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
        $i = 0;
        if (count($query) > 0)
            foreach ($query as $row) {
                $responce->rows[$i]['id'] = $row->menuid;
                $responce->rows[$i]['cell'] = array(
                    $row->menu_nama, $row->menu_deskripsi, $row->menu_url);
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
                $this->session->set_flashdata('msg', $this->sukses("Berhasil menyimpan menu"));
            } else {
                $this->session->set_flashdata('msg', $this->error("Gagal menyimpan menu"));
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
                'menu_type' => $this->input->post('menu_type'),
                'menu_deskripsi' => $this->input->post('menu_deskripsi'),
                'menu_parentid' => $this->input->post('menu_parentid'),
                'menu_icon' => $this->input->post('menu_icon'),
                'menu_isactive' => 1,
            );
            $hasil = $this->model_admin->updateMenu($menu);
            if ($hasil) {
                $this->session->set_flashdata('msg', $this->sukses("Berhasil menyimpan menu"));
            } else {
                $this->session->set_flashdata('msg', $this->error("Gagal menyimpan menu"));
            }
        }
        redirect('administrator/menu');
    }

    /**
     * Function ini digunakan untuk menyimpan member
     */
    public function simpanRole() {
        $this->form_validation->set_rules('role_menu', '<b>Fx</b>', 'xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $role = array(
                'role_menu' => $this->input->post('role_menu')
            );
            $hasil = $this->model_admin->simpanRole($role);
            if ($hasil) {
                $this->session->set_flashdata('msg', $this->sukses("Berhasil menyimpan role"));
            } else {
                $this->session->set_flashdata('msg', $this->error("Gagal menyimpan role"));
            }
        }
        redirect('administrator/role');
    }

    /**
     * Function ini digunakan untuk menyimpan jabatan
     */
    public function simpanJabatan() {
        $this->form_validation->set_rules('jabatan_deskripsi', '<b>Fx</b>', 'xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $role = array(
                'jabatan_deskripsi' => $this->input->post('jabatan_deskripsi')
            );
            $hasil = $this->model_admin->simpanJabatan($role);
            if ($hasil) {
                $this->session->set_flashdata('msg', $this->sukses("Berhasil menyimpan jabatan"));
            } else {
                $this->session->set_flashdata('msg', $this->error("Gagal menyimpan jabatan"));
            }
        }
        redirect('administrator/jabatan');
    }

    /**
     * Function ini digunakan untuk menyimpan cabang
     */
    public function simpanCabang() {
        $this->form_validation->set_rules('cb_nama', '<b>Fx</b>', 'xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'cb_nama' => $this->input->post('cb_nama'),
                'cb_alamat' => $this->input->post('cb_alamat')
            );
            $hasil = $this->model_admin->simpanCabang($data);
            if ($hasil) {
                $this->session->set_flashdata('msg', $this->sukses("Berhasil menyimpan Cabang"));
            } else {
                $this->session->set_flashdata('msg', $this->error("Gagal menyimpan Cabang"));
            }
        }
        redirect('administrator/cabang');
    }

    /**
     * Function ini digunakan untuk menyimpan karyawan
     */
    public function simpanKaryawan() {
        $this->form_validation->set_rules('kr_nama', '<b>Fx</b>', 'xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'kr_nik' => $this->input->post('kr_nik'),
                'kr_nama' => $this->input->post('kr_nama'),
                'kr_alamat' => $this->input->post('kr_alamat'),
                'kr_jabatanid' => $this->input->post('kr_jabatanid'),
                'kr_nomorktp' => $this->input->post('kr_nomorktp'),
                'kr_cbid' => $this->input->post('kr_cbid'),
                'kr_username' => $this->input->post('kr_username'),
                'kr_password' => sha1('123456'),
                'kr_hp' => $this->input->post('kr_hp'),
                'kr_email' => $this->input->post('kr_email'),
                'kr_tempat_lahir' => $this->input->post('kr_tempat_lahir'),
                'kr_tgl_lahir' => dateToIndo($this->input->post('kr_tgl_lahir')),
            );
            $hasil = $this->model_admin->simpanKaryawan($data);
            if ($hasil) {
                $this->session->set_flashdata('msg', $this->sukses("Berhasil menyimpan karyawan"));
            } else {
                $this->session->set_flashdata('msg', $this->error("Gagal menyimpan karyawan"));
            }
        }
        redirect('administrator/karyawan');
    }

    /**
     * Function ini digunakan untuk mengambil data kota
     */
    public function loadRole() {
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 20;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'role_menu';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
        $kode = isset($_POST['sortby']) ? trim($_POST['sortby']) : '';
        $offset = ($page - 1) * $rows;
        $where = array('sortby' => strtolower($kode));
        $result["total"] = $this->model_admin->getTotalRole($where);
        $query = $this->model_admin->getAllRole($sort, $order, $offset, $rows, $where);
        if (count($query) > 0) {
            foreach ($query as $row) {
                $delete = 'deleteRole("' . $row['roleid'] . '")';
                $ed = 'editRole("' . $row['roleid'] . '")';
                $edit = "<a href='" . site_url('administrator/editRole') . "/?id=" . $row['roleid'] . "' class='green' title='Edit'><i class='ace-icon fa fa-pencil bigger-130'></i></a>";
                $menu = "<a href='" . site_url('administrator/editRoleDetail') . "/" . $row['roleid'] . "' class='green' title='Lihat Menu Akses'><span class='ace-icon fa fa-cog bigger-130'></span></a>";
                $del = "" . "<a href='javascript:void(0)' onclick='$delete' class='red' title='Delete'><i class='ace-icon fa fa-trash-o bigger-130'></i></a>";
                $result['rows'][] = array(
                    'role_menu' => $row['role_menu'],
                    'edit' => $edit,
                    'menu' => $menu,
                    'hapus' => $del,
                );
            }
        } else {
            $result['rows'][] = array('id' => "");
        }
        echo json_encode($result);
    }

    /**
     * Function ini digunakan untuk mengambil data jabatan
     */
    public function loadJabatan() {
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 20;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'jabatan_deskripsi';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
        $kode = isset($_POST['sortby']) ? trim($_POST['sortby']) : '';
        $offset = ($page - 1) * $rows;
        $where = array('sortby' => strtolower($kode));
        $result["total"] = $this->model_admin->getTotalJabatan($where);
        $query = $this->model_admin->getAllJabatan($sort, $order, $offset, $rows, $where);
        if (count($query) > 0) {
            foreach ($query as $row) {
                $delete = 'deleteJabatan("' . $row['jabatanid'] . '")';
                $ed = 'editRole("' . $row['jabatanid'] . '")';
                $edit = "<a href='" . site_url('administrator/editJabatan') . "/?id=" . $row['jabatanid'] . "' class='green' title='Edit'><i class='ace-icon fa fa-pencil bigger-130'></i></a>";
                $del = "" . "<a href='javascript:void(0)' onclick='$delete' class='red' title='Delete'><i class='ace-icon fa fa-trash-o bigger-130'></i></a>";
                $result['rows'][] = array(
                    'deskripsi' => $row['jabatan_deskripsi'],
                    'edit' => $edit,
                    'hapus' => $del,
                );
            }
        } else {
            $result['rows'][] = array('id' => "");
        }
        echo json_encode($result);
    }

    /**
     * Function ini digunakan untuk mengambil data jabatan
     */
    public function loadCabang() {
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 20;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'cb_nama';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
        $kode = isset($_POST['sortby']) ? trim($_POST['sortby']) : '';
        $offset = ($page - 1) * $rows;
        $where = array('sortby' => strtolower($kode));
        $result["total"] = $this->model_admin->getTotalCabang($where);
        $query = $this->model_admin->getAllCabang($sort, $order, $offset, $rows, $where);
        if (count($query) > 0) {
            foreach ($query as $row) {
                $delete = 'deleteCabang("' . $row['cbid'] . '")';
                $edit = "<a href='" . site_url('administrator/editCabang') . "/?id=" . $row['cbid'] . "' class='green' title='Edit'><i class='ace-icon fa fa-pencil bigger-130'></i></a>";
                $del = "" . "<a href='javascript:void(0)' onclick='$delete' class='red' title='Delete'><i class='ace-icon fa fa-trash-o bigger-130'></i></a>";
                $result['rows'][] = array(
                    'cbid' => $row['cbid'],
                    'cb_nama' => $row['cb_nama'],
                    'cb_alamat' => $row['cb_alamat'],
                    'edit' => $edit,
                    'hapus' => $del,
                );
            }
        } else {
            $result['rows'][] = array('id' => "");
        }
        echo json_encode($result);
    }

    function editRole() {
        $this->hakAkses(5);
        $id = $this->input->GET('id');
        $this->data['title'] = 'Edit Role';
        $this->data['content'] = 'editRole';
        $this->data['role'] = $this->model_admin->getRoleById($id);
        $this->load->view("template", $this->data);
    }

    function editMenu() {
        $this->hakAkses(2);
        $id = $this->input->GET('id');
        $this->data['title'] = 'Edit Menu';
        $this->data['content'] = 'editMenu';
        $this->data['data'] = $this->model_admin->getMenuById($id);
        $this->data['menu'] = $this->model_admin->getMenuSort();
        $this->load->view("template", $this->data);
    }

    /**
     * Digunakan untuk menampilkan form edit jabatan
     */
    function editJabatan() {
        $this->hakAkses(74);
        $id = $this->input->GET('id');
        $this->data['title'] = 'Edit Jabatan';
        $this->data['content'] = 'editJabatan';
        $this->data['jabatan'] = $this->model_admin->getJabatanById($id);
        $this->load->view("template", $this->data);
    }

    /**
     * Digunakan untuk menampilkan form edit cabang
     */
    function editCabang() {
        $this->hakAkses(76);
        $id = $this->input->GET('id');
        $this->data['title'] = 'Edit Cabang';
        $this->data['content'] = 'editcabang';
        $this->data['cabang'] = $this->model_admin->getCabangById($id);
        $this->load->view("template", $this->data);
    }

    /**
     * Dgunakan untuk edit role detail
     */
    function editRoleDetail() {
        $id = $this->uri->segment(3);
        $cari = $this->uri->segment(4);
        $this->data['title'] = 'Edit Role';
        $this->data['content'] = 'editRoleDetail';
        $this->data['role'] = $this->model_admin->getRoleById($id);
        $this->data['menu'] = $this->model_admin->getMenuSort($cari);
        $this->data['detail'] = $this->model_admin->getDetailRole($id);
        $this->load->view("template", $this->data);
    }

    /**
     * Digunakan untk menambah user role
     */
    function addUserRole() {
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
        $this->hakAkses(77);
        $id = $this->input->GET('id');
        $this->data['title'] = 'Edit Group Cabang';
        $this->data['krid'] = $id;
        $this->data['content'] = 'editGroupCabang';
        $this->data['cbid'] = $this->model_admin->getGroupCabangByUserId($id);
        $this->data['cabang'] = $this->model_admin->getCabang();
        $this->load->view("template", $this->data);
    }

    /**
     * Function ini digunakan untuk menyimpan member
     */
    public function updateRole() {
        $this->form_validation->set_rules('role_menu', '<b>Fx</b>', 'xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $role = array(
                'roleid' => $this->input->post('roleid'),
                'role_menu' => $this->input->post('role_menu'),
            );
            $hasil = $this->model_admin->updateRole($role);
            if ($hasil) {
                $this->session->set_flashdata('msg', $this->sukses("Berhasil mengupdate role menu"));
            } else {
                $this->session->set_flashdata('msg', $this->error("Gagal mengupdate role menu"));
            }
        }
        redirect('administrator/role');
    }

    /**
     * Function ini digunakan untuk menyimpan Cabang
     */
    public function updateCabang() {
        $this->form_validation->set_rules('cb_nama', '<b>Fx</b>', 'xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'cbid' => $this->input->post('cbid'),
                'cb_nama' => $this->input->post('cb_nama'),
                'cb_alamat' => $this->input->post('cb_alamat'),
            );
            $hasil = $this->model_admin->updateCabang($data);
            if ($hasil) {
                $this->session->set_flashdata('msg', $this->sukses("Berhasil mengupdate cabang"));
            } else {
                $this->session->set_flashdata('msg', $this->error("Gagal mengupdate role menu"));
            }
        }
        redirect('administrator/cabang');
    }

    /**
     * Function ini digunakan untuk menyimpan jabatan
     */
    public function updateJabatan() {
        $this->form_validation->set_rules('jabatan_deskripsi', '<b>Fx</b>', 'xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $role = array(
                'jabatanid' => $this->input->post('jabatanid'),
                'jabatan_deskripsi' => $this->input->post('jabatan_deskripsi'),
            );
            $hasil = $this->model_admin->updateJabatan($role);
            if ($hasil) {
                $this->session->set_flashdata('msg', $this->sukses("Berhasil mengupdate jabatan"));
            } else {
                $this->session->set_flashdata('msg', $this->error("Gagal mengupdate jabatan"));
            }
        }
        redirect('administrator/jabatan');
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
     * Function ini digunakan untuk menghapus data produk
     * @since 1.0
     * @author Aris
     */
    public function hapusKaryawan() {
        $id = $this->input->post('id');
        $hasil = $this->model_admin->hapusKaryawan($id);
        if ($hasil) {
            $this->session->set_flashdata('msg', $this->sukses("Berhasil menghapus karyawan"));
        } else {
            $this->session->set_flashdata('msg', $this->error("Gagal menghapus karyawan"));
        }
        echo json_encode("a");
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
            $this->session->set_flashdata('msg', $this->sukses("Berhasil menghapus Cabang"));
        } else {
            $this->session->set_flashdata('msg', $this->error("Gagal menghapus Cabang"));
        }
        echo json_encode("a");
    }

    /**
     * Function ini digunakan untuk menghapus data produk
     * @since 1.0
     * @author Aris
     */
    public function hapusJabatan() {
        $id = $this->input->post('id');
        $hasil = $this->model_admin->hapusJabatan($id);
        if ($hasil) {
            $this->session->set_flashdata('msg', $this->sukses("Berhasil menghapus jabatan"));
        } else {
            $this->session->set_flashdata('msg', $this->error("Gagal menghapus jabatan"));
        }
        echo json_encode("a");
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
                    'rode_roleid' => $roleid,
                    'rode_menuid' => $menu[$i],
                    'check' => $check,
                );
            }
            $hasil = $this->model_admin->updateRoleDetail($arr);
            if ($hasil) {
                $this->session->set_flashdata('msg', $this->sukses("Berhasil mengupdate role menu"));
            } else {
                $this->session->set_flashdata('msg', $this->error("Gagal mengupdate role menu"));
            }
        }
        echo json_encode($hasil);
    }

    function simpanUserRole() {
        $this->form_validation->set_rules('krid', '<b>Fx</b>', 'xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $krid = $this->input->post('user_krid');
            $roleid = $this->input->post('roleid');
            $arr = array();
            for ($i = 0; $i < count($roleid); $i++) {
                $check = 0;
                if ($this->input->post('check' . $roleid[$i]) == '1') {
                    $check = 1;
                }
                $arr[] = array(
                    'user_krid' => $krid,
                    'user_roleid' => $roleid[$i],
                    'check' => $check,
                );
            }
            $hasil = $this->model_admin->simpanUserRole($arr);
            if ($hasil) {
                $this->session->set_flashdata('msg', $this->sukses("Berhasil mengupdate user role"));
            } else {
                $this->session->set_flashdata('msg', $this->error("Gagal mengupdate user role"));
            }
        }
        redirect('administrator/karyawan');
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
                $this->session->set_flashdata('msg', $this->sukses("Berhasil mengupdate group cabang"));
            } else {
                $this->session->set_flashdata('msg', $this->error("Gagal mengupdate group cabang"));
            }
        }
        echo json_encode($hasil);
    }

    /**
     * Function ini digunakan untuk mengambil data produk untuk ditampilkan di member manager
     */
    public function loadKaryawan() {
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 20;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'kr_nama';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
        $nama = isset($_POST['isi']) ? trim($_POST['isi']) : ' ';
        $kode = isset($_POST['kode']) ? trim($_POST['kode']) : '';
        $offset = ($page - 1) * $rows;
        $where = array('nama' => strtoupper($nama), 'sortby' => strtolower($kode));
        $result["total"] = $this->model_admin->getTotalKaryawan($where);
        $query = $this->model_admin->getAllKaryawan($sort, $order, $offset, $rows, $where);
        if (count($query) > 0) {
            foreach ($query as $row) {

                $role = "<a href='" . site_url('administrator/addUserRole') . "/?id=" . $row['krid'] . "' class='green' title='Edit Role'><i class='ace-icon fa fa-cog  bigger-130'></i></a>";
                $password = "<a href='javascript:;' onclick='updatePasword(" . $row['krid'] . ")' class='green' title='Edit Role'><i class='icon-road bigger-130'></i></a>";
                $delete = 'deleteKaryawan("' . $row['krid'] . '")';
                $edit = "<a href='" . site_url('administrator/editKaryawan') . "/?id=" . $row['krid'] . "' class='green' title='Edit'><i class='ace-icon fa fa-pencil bigger-130'></i></a>";
                $group = "<a href='" . site_url('administrator/editGroupCabang') . "/?id=" . $row['krid'] . "' class='green' title='Edit'><i class='ace-icon fa fa-cog bigger-130'></i></a>";
                $del = "" . "<a href='javascript:void(0)' onclick='$delete' class='red' title='Delete'><i class='ace-icon fa fa-trash-o bigger-130'></i></a>";
                $result['rows'][] = array(
                    'nama' => $row['kr_nama'],
                    'username' => $row['kr_username'],
                    'nik' => $row['kr_nik'],
                    'alamat' => $row['kr_alamat'],
                    'hp' => $row['kr_hp'],
                    'group' => $group,
                    'ktp' => $row['kr_nomorktp'],
                    'role' => $role,
                    'jabatan' => $row['jabatan_deskripsi'],
                    'password' => $password,
                    'hapus' => $del,
                    'edit' => $edit,
                );
            }
        } else {
            $result['rows'][] = array('id' => "");
        }
        echo json_encode($result);
    }

}

?>
