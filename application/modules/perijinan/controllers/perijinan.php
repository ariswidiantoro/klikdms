<?php

/**
 * Class Admin_Controller
 * @author Aris
 * 2013-11-11
 */
class Perijinan extends Application {

    /**
     * The new Admin_controller
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('model_perijinan');
        $this->check_login();
    }

    public function index() {
        $this->load->view('admin/login');
    }

    function dokumenPerijinan() {
        $this->hakAkses(69);
        $this->data['title'] = 'Form Dokument Perijinan';
        $this->data['content'] = 'dokumenPerijinan';
        $this->load->view('template', $this->data);
    }

    function pilihKontraktor() {
        $this->hakAkses(91);
        $this->data['title'] = 'Form Pilih Kontraktor';
        $this->data['cabang'] = $this->model_perijinan->getGroupCabang();
        $this->data['kontraktor'] = $this->model_perijinan->getKontraktor();
        $this->data['pekerja'] = $this->model_perijinan->getKontraktorByCabang(ses_cabang);
        $this->data['content'] = 'pilihKontraktor';
        $this->load->view('template', $this->data);
    }

    function dokumenMonitoring() {
        $this->data['title'] = 'Form Dokument Monitoring';
        $this->data['content'] = 'dokumenMonitoring';
        $this->load->view('template', $this->data);
    }

    function kontraktor() {
        $this->hakAkses(78);
        $this->data['title'] = 'Form Kontraktor';
        $this->data['content'] = 'kontraktor';
        $this->load->view('template', $this->data);
    }

    function personilLapangan() {
        $this->data['title'] = 'Form Personil Lapangan';
        $this->data['content'] = 'personilLapangan';
        $this->load->view('template', $this->data);
    }

    function perijinanTanah() {
        $this->hakAkses(71);
        $this->data['title'] = 'Form Pengajuan Perijinan Tanah';
//        $this->data['dok'] = $this->model_perijinan->getDokumenPerijinan();
        $this->data['content'] = 'dataPengajuanTanah';
        $this->load->view('template', $this->data);
    }

    function addPengajuan() {
        $this->hakAkses(71);
        $this->data['title'] = 'Form Pengajuan Perijinan Tanah';
        $this->data['dok'] = $this->model_perijinan->getDokumenPerijinan();
        $this->data['content'] = 'pengajuanPerijinan';
        $this->load->view('template', $this->data);
    }

    function persetujuanTanah() {
        $this->hakAkses(72);
        $this->data['title'] = 'Form Persetujuan Tanah';
        $this->data['content'] = 'persetujuanTanah';
        $this->load->view('template', $this->data);
    }
    function surveyLokasiTanah() {
        $this->hakAkses(80);
        $this->data['title'] = 'Form Survey Tanah';
        $this->data['content'] = 'survey';
        $this->load->view('template', $this->data);
    }

    /**
     * Digunakan untuk menambah dokumen perijinan
     */
    function addDokumen() {
        $this->hakAkses(69);
        $this->data['title'] = 'Tambah Dokumen Perijinan';
        $this->data['content'] = 'addDokumen';
        $this->load->view('template', $this->data);
    }

    /**
     * Digunakan untuk menambah dokumen monitoring
     */
    function addDokumenMonitoring() {
        $this->data['title'] = 'Tambah Dokumen Monitoring';
        $this->data['content'] = 'addDokumenMonitoring';
        $this->load->view('template', $this->data);
    }

    /**
     * Digunakan untuk menambah data kontraktor
     */
    function addKontraktor() {
        $this->hakAkses(78);
        $this->data['title'] = 'Tambah Kontraktor';
        $this->data['content'] = 'addKontraktor';
        $this->load->view('template', $this->data);
    }
    /**
     * Digunakan untuk menambah data kontraktor
     */
    function addSurvey() {
        $this->hakAkses(80);
        $this->data['title'] = 'Add Survey';
        $this->data['content'] = 'addSurvey';
        $this->load->view('template', $this->data);
    }

    /**
     * Function ini digunakan untuk mengambil data jabatan
     */
    public function loadDokumen() {
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 20;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'dok_deskripsi';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
        $kode = isset($_POST['sortby']) ? trim($_POST['sortby']) : '';
        $offset = ($page - 1) * $rows;
        $where = array('sortby' => strtolower($kode));
        $result["total"] = $this->model_perijinan->getTotalDokumen($where);
        $query = $this->model_perijinan->getAllDokumen($sort, $order, $offset, $rows, $where);
        if (count($query) > 0) {
            foreach ($query as $row) {
                $delete = 'deleteDokumen("' . $row['dok_id'] . '")';
                $edit = "<a href='" . site_url('perijinan/editDokumen') . "/?id=" . $row['dok_id'] . "' class='green' title='Edit'><i class='ace-icon fa fa-pencil bigger-130'></i></a>";
                $del = "" . "<a href='javascript:void(0)' onclick='$delete' class='red' title='Delete'><i class='ace-icon fa fa-trash-o bigger-130'></i></a>";
                $result['rows'][] = array(
                    'dok_id' => $row['dok_id'],
                    'dok_deskripsi' => $row['dok_deskripsi'],
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
    public function loadDokumenMonitoring() {
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 20;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'mon_deskripsi';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
        $kode = isset($_POST['sortby']) ? trim($_POST['sortby']) : '';
        $offset = ($page - 1) * $rows;
        $where = array('sortby' => strtolower($kode));
        $result["total"] = $this->model_perijinan->getTotalDokumenMonitoring($where);
        $query = $this->model_perijinan->getAllDokumenMonitoring($sort, $order, $offset, $rows, $where);
        if (count($query) > 0) {
            foreach ($query as $row) {
                $delete = 'deleteDokumen("' . $row['monid'] . '")';
                $edit = "<a href='" . site_url('perijinan/editDokumenMonitoring') . "/?id=" . $row['monid'] . "' class='green' title='Edit'><i class='ace-icon fa fa-pencil bigger-130'></i></a>";
                $del = "" . "<a href='javascript:void(0)' onclick='$delete' class='red' title='Delete'><i class='ace-icon fa fa-trash-o bigger-130'></i></a>";
                $result['rows'][] = array(
                    'mon_id' => $row['monid'],
                    'mon_deskripsi' => $row['mon_deskripsi'],
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
    public function loadKontraktor() {
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 20;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'kon_nama';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
        $kode = isset($_POST['sortby']) ? trim($_POST['sortby']) : '';
        $offset = ($page - 1) * $rows;
        $where = array('sortby' => strtolower($kode));
        $result["total"] = $this->model_perijinan->getTotalKontraktor($where);
        $query = $this->model_perijinan->getAllKontraktor($sort, $order, $offset, $rows, $where);
        if (count($query) > 0) {
            foreach ($query as $row) {
                $delete = 'deleteKontraktor("' . $row['konid'] . '")';
                $edit = "<a href='" . site_url('perijinan/editKontraktor') . "/?id=" . $row['konid'] . "' class='green' title='Edit'><i class='ace-icon fa fa-pencil bigger-130'></i></a>";
                $del = "<a href='javascript:void(0)' onclick='$delete' class='red' title='Delete'><i class='ace-icon fa fa-trash-o bigger-130'></i></a>";
                $npwp = 'gambarLegalitas("' . $row['kon_npwp_gambar'] . '")';
                $siup = 'gambarLegalitas("' . $row['kon_siup_gambar'] . '")';
                $siujk = 'gambarLegalitas("' . $row['kon_siujk_gambar'] . '")';
                $tdp = 'gambarLegalitas("' . $row['kon_tdp_gambar'] . '")';
                $domisili = 'gambarLegalitas("' . $row['kon_domisili_gambar'] . '")';
                $akta = 'gambarLegalitas("' . $row['kon_akta_gambar'] . '")';
                $result['rows'][] = array(
                    'kon_nama' => $row['kon_nama'],
                    'kon_lokasi' => $row['kon_lokasi'],
                    'kon_alamat' => $row['kon_alamat'],
                    'kon_direktur' => $row['kon_direktur'],
                    'kon_npwp_gambar' => "<a href='javascript:void(0)' onclick='$npwp' class='blue' title='Lihat Gambar'><i class='ace-icon fa fa-info-circle  bigger-130'></i></a>",
                    'kon_siup_gambar' => "<a href='javascript:void(0)' onclick='$siup' class='blue' title='Lihat Gambar'><i class='ace-icon fa fa-info-circle  bigger-130'></i></a>",
                    'kon_siujk_gambar' => "<a href='javascript:void(0)' onclick='$siujk' class='blue' title='Lihat Gambar'><i class='ace-icon fa fa-info-circle  bigger-130'></i></a>",
                    'kon_tdp_gambar' => "<a href='javascript:void(0)' onclick='$tdp' class='blue' title='Lihat Gambar'><i class='ace-icon fa fa-info-circle  bigger-130'></i></a>",
                    'kon_domisili_gambar' => "<a href='javascript:void(0)' onclick='$domisili' class='blue' title='Lihat Gambar'><i class='ace-icon fa fa-info-circle  bigger-130'></i></a>",
                    'kon_akta_gambar' => "<a href='javascript:void(0)' onclick='$akta' class='blue' title='Lihat Gambar'><i class='ace-icon fa fa-info-circle  bigger-130'></i></a>",
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
    public function loadPilihKontraktor() {
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 20;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'kon_nama';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
        $kode = isset($_POST['sortby']) ? trim($_POST['sortby']) : '';
        $offset = ($page - 1) * $rows;
        $where = array('sortby' => strtolower($kode));
//        $result["total"] = $this->model_perijinan->getTotalKontraktor($where);
        $query = $this->model_perijinan->getAllPilihKontraktor($sort, $order, $offset, $rows, $where);
        if (count($query) > 0) {
            foreach ($query as $row) {
                $delete = 'deletePilihKontraktor("' . $row['pilid'] . '")';
                $delete = 'editPilihKontraktor("' . $row['pilid'] . '")';
                $edit = "<a href='javascript:;' class='green' title='Edit'><i class='ace-icon fa fa-pencil bigger-130'></i></a>";
                $del = "" . "<a href='javascript:void(0)' onclick='$delete' class='red' title='Delete'><i class='ace-icon fa fa-trash-o bigger-130'></i></a>";
                $result['rows'][] = array(
                    'cb_nama' => $row['cb_nama'],
                    'kon_nama' => $row['kon_nama'],
                    'kon_lokasi' => $row['kon_lokasi'],
                    'kon_alamat' => $row['kon_alamat'],
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
    public function loadPersetujuan() {
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 20;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'pt_createon';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'DESC';
        $kode = isset($_POST['sortby']) ? trim($_POST['sortby']) : '';
        $status = isset($_POST['status']) ? trim($_POST['status']) : '';
        $offset = ($page - 1) * $rows;
        $where = array('sortby' => strtolower($kode), 'status' => $status);
        $result["total"] = $this->model_perijinan->getTotalPersetujuan($where);
        $query = $this->model_perijinan->getAllPersetujuan($sort, $order, $offset, $rows, $where);
        if (count($query) > 0) {
            foreach ($query as $row) {
                $setuju = 'setujui("' . $row['ptid'] . '")';
                $printClick = 'print("' . $row['ptid'] . '")';
                $status = 'Belum Disetujui';
                $validasi = "<a href='" . site_url('perijinan/validasiPersetujuan') . "/?id=" . $row['ptid'] . "' class='blue' title='Edit'><i class='ace-icon fa fa-eye bigger-130'></i></a>";
                $setujui = "" . "<a href='javascript:void(0)' onclick='$setuju' class='blue' title='Setujui Pengajuan tanah'><i class='ace-icon fa fa-play-circle bigger-130'></i></a>";
                $print = "" . "<a href='javascript:void(0)' onclick='$printClick' class='blue' title='Cetak Form'><i class='ace-icon glyphicon glyphicon-print bigger-130'></i></a>";
                if ($row['pt_status'] == 1) {
                    $status = 'Sudah Disetujui';
                    $setujui = '-';
                    $validasi = '-';
                }
//                $lihat = "<a href='" . site_url('perijinan/lihatPersetujuan') . "/?id=" . $row['ptid'] . "' class='green' title='Edit'><i class='ace-icon fa fa-eye bigger-130'></i></a>";
                $result['rows'][] = array(
                    'pt_nomor' => $row['pt_nomor'],
                    'cb_nama' => $row['cb_nama'],
                    'kon_nama' => $row['kon_nama'],
                    'pt_tgl' => date('d-m-Y', strtotime($row['pt_tgl'])),
                    'setujui' => $setujui,
                    'print' => $print,
                    'status' => $status,
                    'validasi' => $validasi,
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
    public function loadPengajuan() {
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 20;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'pt_createon';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'DESC';
        $kode = isset($_POST['sortby']) ? trim($_POST['sortby']) : '';
        $status = isset($_POST['status']) ? trim($_POST['status']) : '';
        $offset = ($page - 1) * $rows;
        $where = array('sortby' => strtolower($kode),'status' => $status);
        $result["total"] = $this->model_perijinan->getTotalPersetujuan($where);
        $query = $this->model_perijinan->getAllPersetujuan($sort, $order, $offset, $rows, $where);
        if (count($query) > 0) {
            foreach ($query as $row) {
                $status = 'Menunggu Persetujuan';
                $edit = "<a href='" . site_url('perijinan/editPengajuan') . "/?id=" . $row['ptid'] . "' class='green' title='Edit'><i class='ace-icon fa fa-pencil bigger-130'></i></a>";
                $delete = 'deletePengajuan("' . $row['ptid'] . '")';
                $del = "" . "<a href='javascript:void(0)' onclick='$delete' class='red' title='Delete'><i class='ace-icon fa fa-trash-o bigger-130'></i></a>";
                if ($row['pt_status'] == 1) {
                    $status = 'Sudah Disetujui';
                    $edit = '-';
                    $del = '-';
                }
//                $validasi = "<a href='" . site_url('perijinan/validasiPersetujuan') . "/?id=" . $row['ptid'] . "' class='green' title='Edit'><i class='ace-icon fa fa-play-circle bigger-130'></i></a>";
                $lihat = "<a href='" . site_url('perijinan/lihatPersetujuan') . "/?id=" . $row['ptid'] . "' class='green' title='Edit'><i class='ace-icon fa fa-eye bigger-130'></i></a>";
                $result['rows'][] = array(
                    'pt_nomor' => $row['pt_nomor'],
                    'cb_nama' => $row['cb_nama'],
                    'pt_tgl' => date('d-m-Y', strtotime($row['pt_tgl'])),
                    'lihat' => $lihat,
                    'edit' => $edit,
                    'batal' => $del,
                    'kon_nama' => $row['kon_nama'],
                    'status' => $status,
//                    'validasi' => $validasi,
                );
            }
        } else {
            $result['rows'][] = array('id' => "");
        }
        echo json_encode($result);
    }

    function editDokumen() {
        $this->hakAkses(69);
        $id = $this->input->GET('id');
        $this->data['title'] = 'Edit Dokumen';
        $this->data['content'] = 'editDokumen';
        $this->data['data'] = $this->model_perijinan->getDokumenById($id);
        $this->load->view("template", $this->data);
    }

    function editDokumenMonitoring() {
        $id = $this->input->GET('id');
        $this->data['title'] = 'Edit Dokumen Monitoring';
        $this->data['content'] = 'editDokumenMonitoring';
        $this->data['data'] = $this->model_perijinan->getDokumenMonitoringById($id);
        $this->load->view("template", $this->data);
    }

    function editKontraktor() {
        $this->hakAkses(78);
        $id = $this->input->GET('id');
        $this->data['title'] = 'Edit Kontraktor';
        $this->data['content'] = 'editKontraktor';
        $this->data['data'] = $this->model_perijinan->getKontraktorById($id);
        $this->load->view("template", $this->data);
    }

    function validasiPersetujuan() {
        $this->hakAkses(72);
        $id = $this->input->GET('id');
        $this->data['title'] = 'Validasi Persetujuan';
        $this->data['content'] = 'validasiPersetujuan';
        $this->data['data'] = $this->model_perijinan->getPengajuanTanah($id);
        $this->data['detail'] = $this->model_perijinan->getPengajuanTanahDetail($id);
        $this->load->view("template", $this->data);
    }

    function lihatPersetujuan() {
        $id = $this->input->GET('id');
        $this->data['title'] = 'Lihat Pengajuan';
        $this->data['content'] = 'lihatPersetujuan';
        $this->data['data'] = $this->model_perijinan->getPengajuanTanah($id);
        $this->data['detail'] = $this->model_perijinan->getPengajuanTanahDetail($id);
        $this->load->view("template", $this->data);
    }

    function editPengajuan() {
        $this->hakAkses(71);
        $id = $this->input->GET('id');
        $this->data['title'] = 'Lihat Pengajuan';
        $this->data['content'] = 'editPengajuan';
        $this->data['data'] = $this->model_perijinan->getPengajuanTanah($id);
        $this->data['detail'] = $this->model_perijinan->getPengajuanTanahDetail($id);
        $this->load->view("template", $this->data);
    }

    function lihatGambar() {
        $this->data['id'] = $this->uri->segment(3);
        $this->load->view("lihatGambar", $this->data);
    }

    function simpanDokumen() {
        $this->form_validation->set_rules('dok_deskripsi', '<b>Fx</b>', 'xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'dok_deskripsi' => $this->input->post('dok_deskripsi')
            );
            $hasil = $this->model_perijinan->simpanDokumen($data);
            if ($hasil) {
                $this->session->set_flashdata('msg', $this->sukses("Berhasil menyimpan dokumen"));
            } else {
                $this->session->set_flashdata('msg', $this->error("Gagal menyimpan dokumen"));
            }
        }
        redirect('perijinan/dokumenPerijinan');
    }

    function simpanDokumenMonitoring() {
        $this->form_validation->set_rules('mon_deskripsi', '<b>Fx</b>', 'xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'mon_deskripsi' => $this->input->post('mon_deskripsi')
            );
            $hasil = $this->model_perijinan->simpanDokumenMonitoring($data);
            if ($hasil) {
                $this->session->set_flashdata('msg', $this->sukses("Berhasil menyimpan dokumen"));
            } else {
                $this->session->set_flashdata('msg', $this->error("Gagal menyimpan dokumen"));
            }
        }
        redirect('perijinan/dokumenMonitoring');
    }

    function simpanKontraktor() {
        $this->form_validation->set_rules('kon_nama', '<b>Fx</b>', 'xss_clean');
        if ($this->form_validation->run() == TRUE) {

            $npwp = '';
            if (!empty($_FILES["kon_npwp_gambar"]["name"])) {
                $npwp = 'file_' . rand(0, 100000) . '.' . end(explode(".", $_FILES["kon_npwp_gambar"]["name"]));
                $tmp_lock = $_FILES["kon_npwp_gambar"]["tmp_name"];
                move_uploaded_file($tmp_lock, 'media/upload/' . $npwp);
            }
            $siup = '';
            if (!empty($_FILES["kon_siup_gambar"]["name"])) {
                $siup = 'file_' . rand(0, 100000) . '.' . end(explode(".", $_FILES["kon_siup_gambar"]["name"]));
                $tmp_lock = $_FILES["kon_siup_gambar"]["tmp_name"];
                move_uploaded_file($tmp_lock, 'media/upload/' . $siup);
            }
            $siujk = '';
            if (!empty($_FILES["kon_siujk_gambar"]["name"])) {
                $siujk = 'file_' . rand(0, 100000) . '.' . end(explode(".", $_FILES["kon_siujk_gambar"]["name"]));
                $tmp_lock = $_FILES["kon_siujk_gambar"]["tmp_name"];
                move_uploaded_file($tmp_lock, 'media/upload/' . $siujk);
            }
            $tdp = '';
            if (!empty($_FILES["kon_tdp_gambar"]["name"])) {
                $tdp = 'file_' . rand(0, 100000) . '.' . end(explode(".", $_FILES["kon_tdp_gambar"]["name"]));
                $tmp_lock = $_FILES["kon_tdp_gambar"]["tmp_name"];
                move_uploaded_file($tmp_lock, 'media/upload/' . $tdp);
            }
            $domisili = '';
            if (!empty($_FILES["kon_domisili_gambar"]["name"])) {
                $domisili = 'file_' . rand(0, 100000) . '.' . end(explode(".", $_FILES["kon_domisili_gambar"]["name"]));
                $tmp_lock = $_FILES["kon_domisili_gambar"]["tmp_name"];
                move_uploaded_file($tmp_lock, 'media/upload/' . $domisili);
            }

            $akta = '';
            if (!empty($_FILES["kon_akta_gambar"]["name"])) {
                $akta = 'file_' . rand(0, 100000) . '.' . end(explode(".", $_FILES["kon_akta_gambar"]["name"]));
                $tmp_lock = $_FILES["kon_akta_gambar"]["tmp_name"];
                move_uploaded_file($tmp_lock, 'media/upload/' . $akta);
            }
            $data = array(
                'kon_nama' => $this->input->post('kon_nama'),
                'kon_lokasi' => $this->input->post('kon_lokasi'),
                'kon_npwp_nomor' => $this->input->post('kon_npwp_nomor'),
                'kon_siup_nomor' => $this->input->post('kon_siup_nomor'),
                'kon_siujk_nomor' => $this->input->post('kon_siujk_nomor'),
                'kon_tdp_nomor' => $this->input->post('kon_tdp_nomor'),
                'kon_akta_nomor' => $this->input->post('kon_akta_nomor'),
                'kon_domisili_nomor' => $this->input->post('kon_domisili_nomor'),
                'kon_npwp_gambar' => $npwp,
                'kon_siup_gambar' => $siup,
                'kon_siujk_gambar' => $siujk,
                'kon_tdp_gambar' => $tdp,
                'kon_akta_gambar' => $akta,
                'kon_domisili_gambar' => $domisili,
                'kon_direktur' => $this->input->post('kon_direktur'),
                'kon_cbid' => ses_cabang,
                'kon_alamat' => $this->input->post('kon_alamat')
            );
            $hasil = $this->model_perijinan->simpanKontraktor($data);
            if ($hasil) {
                $this->session->set_flashdata('msg', $this->sukses("Berhasil menambah kontraktor"));
            } else {
                $this->session->set_flashdata('msg', $this->error("Gagal menambah kontraktor"));
            }
        }
        redirect('perijinan/kontraktor');
    }

    function simpanPilihKontraktor() {
        $this->form_validation->set_rules('cabang', '<b>Fx</b>', 'xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'pil_cbid' => $this->input->post('cabang'),
                'pil_konid' => $this->input->post('kontraktor')
            );
            $hasil = $this->model_perijinan->simpanPilihKontraktor($data);
            if ($hasil) {
                $this->session->set_flashdata('msg', $this->sukses("Berhasil menambah kontraktor"));
            } else {
                $this->session->set_flashdata('msg', $this->error("Gagal menambah kontraktor"));
            }
        }
        redirect('perijinan/pilihKontraktor');
    }

    function updateKontraktor() {
        $this->form_validation->set_rules('kon_nama', '<b>Fx</b>', 'xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'konid' => $this->input->post('konid'),
                'kon_nama' => $this->input->post('kon_nama'),
                'kon_direktur' => $this->input->post('kon_direktur'),
                'kon_lokasi' => $this->input->post('kon_lokasi'),
                'kon_alamat' => $this->input->post('kon_alamat'),
                'kon_npwp_nomor' => $this->input->post('kon_npwp_nomor'),
                'kon_siup_nomor' => $this->input->post('kon_siup_nomor'),
                'kon_siujk_nomor' => $this->input->post('kon_siujk_nomor'),
                'kon_tdp_nomor' => $this->input->post('kon_tdp_nomor'),
                'kon_akta_nomor' => $this->input->post('kon_akta_nomor'),
                'kon_domisili_nomor' => $this->input->post('kon_domisili_nomor'),
            );
            if (!empty($_FILES["kon_npwp_gambar"]["name"])) {
                $npwp = 'file_' . rand(0, 100000) . '.' . end(explode(".", $_FILES["kon_npwp_gambar"]["name"]));
                $tmp_lock = $_FILES["kon_npwp_gambar"]["tmp_name"];
                move_uploaded_file($tmp_lock, 'media/upload/' . $npwp);
                $data['kon_npwp_gambar'] = $npwp;
            }
            $siup = '';
            if (!empty($_FILES["kon_siup_gambar"]["name"])) {
                $siup = 'file_' . rand(0, 100000) . '.' . end(explode(".", $_FILES["kon_siup_gambar"]["name"]));
                $tmp_lock = $_FILES["kon_siup_gambar"]["tmp_name"];
                move_uploaded_file($tmp_lock, 'media/upload/' . $siup);
                $data['kon_siup_gambar'] = $npwp;
            }
            $siujk = '';
            if (!empty($_FILES["kon_siujk_gambar"]["name"])) {
                $siujk = 'file_' . rand(0, 100000) . '.' . end(explode(".", $_FILES["kon_siujk_gambar"]["name"]));
                $tmp_lock = $_FILES["kon_siujk_gambar"]["tmp_name"];
                move_uploaded_file($tmp_lock, 'media/upload/' . $siujk);
                $data['kon_siujk_gambar'] = $siujk;
            }
            $tdp = '';
            if (!empty($_FILES["kon_tdp_gambar"]["name"])) {
                $tdp = 'file_' . rand(0, 100000) . '.' . end(explode(".", $_FILES["kon_tdp_gambar"]["name"]));
                $tmp_lock = $_FILES["kon_tdp_gambar"]["tmp_name"];
                move_uploaded_file($tmp_lock, 'media/upload/' . $tdp);
            }
            $domisili = '';
            if (!empty($_FILES["kon_domisili_gambar"]["name"])) {
                $domisili = 'file_' . rand(0, 100000) . '.' . end(explode(".", $_FILES["kon_domisili_gambar"]["name"]));
                $tmp_lock = $_FILES["kon_domisili_gambar"]["tmp_name"];
                move_uploaded_file($tmp_lock, 'media/upload/' . $domisili);
                $data['kon_domisili_gambar'] = $domisili;
            }

            $akta = '';
            if (!empty($_FILES["kon_akta_gambar"]["name"])) {
                $akta = 'file_' . rand(0, 100000) . '.' . end(explode(".", $_FILES["kon_akta_gambar"]["name"]));
                $tmp_lock = $_FILES["kon_akta_gambar"]["tmp_name"];
                move_uploaded_file($tmp_lock, 'media/upload/' . $akta);
                $data['kon_akta_gambar'] = $akta;
            }
            $hasil = $this->model_perijinan->updateKontraktor($data);
            if ($hasil) {
                $this->session->set_flashdata('msg', $this->sukses("Berhasil merubah kontraktor"));
            } else {
                $this->session->set_flashdata('msg', $this->error("Gagal merubah kontraktor"));
            }
        }
        redirect('perijinan/kontraktor');
    }

    function simpanPengajuanPerijinan() {
        $this->form_validation->set_rules('pt_nomor', '<b>Fx</b>', 'xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $tgl = $this->input->post('pt_tgl');
            $data = array(
                'pt_nomor' => $this->input->post('pt_nomor'),
                'pt_cbid' => ses_cabang,
                'pt_createby' => ses_username,
                'pt_tgl' => dateToIndo($tgl)
            );

            $dokId = $this->input->post('ptd_dok_id', true);
            $nodoc = $this->input->post('ptd_nomor', true);
            $tglTerbit = $this->input->post('ptd_tgl_terbit', true);
            $ket = $this->input->post('ptd_ketpengajuan', true);
            // get array spare part from table 
            $detail = array();
            for ($i = 0; $i < count($dokId); $i++) {
                $gambar = '';
                if (!empty($_FILES["ptd_gambar$dokId[$i]"]["name"])) {
                    $gambar = 'file_' . rand(0, 100000) . '.' . end(explode(".", $_FILES["ptd_gambar$dokId[$i]"]["name"]));
                    $tmp_lock = $_FILES["ptd_gambar$dokId[$i]"]["tmp_name"];
                    move_uploaded_file($tmp_lock, 'media/upload/' . $gambar);
                }
                $detail[] = array(
                    'ptd_dok_id' => $dokId[$i],
                    'ptd_nomor' => $nodoc[$i],
                    'ptd_gambar' => $gambar,
                    'ptd_tgl_terbit' => dateToIndo($tglTerbit[$i]),
                    'ptd_ketpengajuan' => $ket[$i]
                );
            }

            $hasil = $this->model_perijinan->simpanPengajuanPerijinan($data, $detail);
            if ($hasil) {
                $this->session->set_flashdata('msg', $this->sukses("Berhasil menyimpan pengajuan tanah"));
            } else {
                $this->session->set_flashdata('msg', $this->error("Gagal menyimpan pengajuan tanah"));
            }
        }
        redirect('perijinan/perijinanTanah');
    }

    function updatePengajuanTanah() {
        $this->form_validation->set_rules('pt_nomor', '<b>Fx</b>', 'xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $tgl = $this->input->post('pt_tgl');
            $ptid = $this->input->post('ptid');
            $data = array(
                'ptid' => $ptid,
                'pt_nomor' => $this->input->post('pt_nomor'),
                'pt_cbid' => ses_cabang,
                'pt_createby' => ses_username,
                'pt_tgl' => dateToIndo($tgl)
            );

            $dokId = $this->input->post('ptd_dok_id', true);
            $nodoc = $this->input->post('ptd_nomor', true);
            $tglTerbit = $this->input->post('ptd_tgl_terbit', true);
            $ket = $this->input->post('ptd_ketpengajuan', true);
            // get array spare part from table 
            $detail = array();
            for ($i = 0; $i < count($dokId); $i++) {
                $gambar = '';
                if (!empty($_FILES["ptd_gambar$dokId[$i]"]["name"])) {
                    $gambar = 'file_' . rand(0, 100000) . '.' . end(explode(".", $_FILES["ptd_gambar$dokId[$i]"]["name"]));
                    $tmp_lock = $_FILES["ptd_gambar$dokId[$i]"]["tmp_name"];
                    move_uploaded_file($tmp_lock, 'media/upload/' . $gambar);
                }
                $detail[] = array(
                    'ptd_ptid' => $ptid,
                    'ptd_dok_id' => $dokId[$i],
                    'ptd_nomor' => $nodoc[$i],
                    'ptd_gambar' => $gambar,
                    'ptd_tgl_terbit' => dateToIndo($tglTerbit[$i]),
                    'ptd_ketpengajuan' => $ket[$i]
                );
            }
            $hasil = $this->model_perijinan->updatePengajuanTanah($data, $detail);
            if ($hasil) {
                $this->session->set_flashdata('msg', $this->sukses("Berhasil merubah perijinan"));
            } else {
                $this->session->set_flashdata('msg', $this->error("Gagal merubah perijinan"));
            }
        }
        redirect('perijinan/perijinanTanah');
    }

    /**
     * 
     */
    function simpanPersetujuanPerijinan() {
        $this->form_validation->set_rules('pt_nomor', '<b>Fx</b>', 'xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $nomor = $this->input->post('pt_nomor');

            $dokId = $this->input->post('ptdid', true);
            $kelengkapan = $this->input->post('ptd_kelengkapan', true);
            $tglProses = $this->input->post('ptd_tglproses', true);
            $tglSelesai = $this->input->post('ptd_tglselesai', true);
            $ket = $this->input->post('ptd_ketpersetujuan', true);
            // get array spare part from table 
            $detail = array();
            for ($i = 0; $i < count($dokId); $i++) {
                $detail[] = array(
                    'ptdid' => $dokId[$i],
                    'ptd_updateby' => ses_username,
                    'ptd_kelengkapan' => $kelengkapan[$i],
                    'ptd_tglproses' => dateToIndo($tglProses[$i]),
                    'ptd_tglselesai' => dateToIndo($tglSelesai[$i]),
                    'ptd_ketpersetujuan' => $ket[$i]
                );
            }

            $hasil = $this->model_perijinan->simpanPersetujuanPerijinan($detail);
            if ($hasil) {
                $this->session->set_flashdata('msg', $this->sukses("Berhasil menyimpan Persetujuan tanah"));
            } else {
                $this->session->set_flashdata('msg', $this->error("Gagal menyimpan Persetujuan tanah"));
            }
        }
        redirect('perijinan/persetujuanTanah');
    }

    /**
     * Function ini digunakan untuk menyimpan member
     */
    public function updateDokumen() {
        $this->form_validation->set_rules('dok_deskripsi', '<b>Fx</b>', 'xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'dok_id' => $this->input->post('dok_id'),
                'dok_deskripsi' => $this->input->post('dok_deskripsi'),
            );
            $hasil = $this->model_perijinan->updateDokumen($data);
            if ($hasil) {
                $this->session->set_flashdata('msg', $this->sukses("Berhasil mengupdate dokumen"));
            } else {
                $this->session->set_flashdata('msg', $this->error("Gagal mengupdate dokumen"));
            }
        }
        redirect('perijinan/dokumenPerijinan');
    }

    /**
     * Function ini digunakan untuk menyimpan member
     */
    public function updateDokumenMonitoring() {
        $this->form_validation->set_rules('mon_deskripsi', '<b>Fx</b>', 'xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'monid' => $this->input->post('monid'),
                'mon_deskripsi' => $this->input->post('mon_deskripsi'),
            );
            $hasil = $this->model_perijinan->updateDokumenMonitoring($data);
            if ($hasil) {
                $this->session->set_flashdata('msg', $this->sukses("Berhasil mengupdate dokumen"));
            } else {
                $this->session->set_flashdata('msg', $this->error("Gagal mengupdate dokumen"));
            }
        }
        redirect('perijinan/dokumenMonitoring');
    }

    /**
     * Function ini digunakan untuk menghapus data produk
     * @since 1.0
     * @author Aris
     */
    public function hapusDokumen() {
        $id = $this->input->post('id');
        $hasil = $this->model_perijinan->hapusDokumen($id);
        if ($hasil) {
            $this->session->set_flashdata('msg', $this->sukses("Berhasil menghapus dokumen"));
        } else {
            $this->session->set_flashdata('msg', $this->error("Gagal menghapus dokumen"));
        }
        echo json_encode("a");
    }

    /**
     * Function ini digunakan untuk menghapus data produk
     * @since 1.0
     * @author Aris
     */
    public function hapusDokumenMonitoring() {
        $id = $this->input->post('id');
        $hasil = $this->model_perijinan->hapusDokumenMonitoring($id);
        if ($hasil) {
            $this->session->set_flashdata('msg', $this->sukses("Berhasil menghapus dokumen"));
        } else {
            $this->session->set_flashdata('msg', $this->error("Gagal menghapus dokumen"));
        }
        echo json_encode("a");
    }

    /**
     * Function ini digunakan untuk menghapus data produk
     * @since 1.0
     * @author Aris
     */
    public function hapusKontraktor() {
        $id = $this->input->post('id');
        $hasil = $this->model_perijinan->hapusKontraktor($id);
        if ($hasil) {
            $this->session->set_flashdata('msg', $this->sukses("Berhasil menghapus kontraktor"));
        } else {
            $this->session->set_flashdata('msg', $this->error("Gagal menghapus kontraktor"));
        }
        echo json_encode("a");
    }

    /**
     * Function ini digunakan untuk menghapus data produk
     * @since 1.0
     * @author Aris
     */
    public function setujuiPengajuan() {
        $id = $this->input->post('id');
        $hasil = $this->model_perijinan->setujuiPengajuan($id);
        if ($hasil) {
            $this->session->set_flashdata('msg', $this->sukses("Nomor Dokumen Ini berhasil disetujui"));
        } else {
            $this->session->set_flashdata('msg', $this->error("Gagal meyimpan data"));
        }
        echo json_encode("a");
    }

    /**
     * Function ini digunakan untuk menghapus data produk
     * @since 1.0
     * @author Aris
     */
    public function hapusPengajuan() {
        $id = $this->input->post('id');
        $hasil = $this->model_perijinan->hapusPengajuan($id);
        if ($hasil) {
            $this->session->set_flashdata('msg', $this->sukses("Berhasil menghapus pengajuan"));
        } else {
            $this->session->set_flashdata('msg', $this->error("Gagal menghapus pengajuan"));
        }
        echo json_encode("a");
    }

}

?>