<?php

/**
 * Class Admin_Controller
 * @author Aris
 * 2013-11-11
 */
class Master_Sparepart extends Application {

    /**
     * The new Admin_controller
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('model_admin');
        $this->load->model('model_sparepart');
        $this->isLogin();
    }

    public function index() {
        $this->data['content'] = 'sparepart';
        $this->data['menuid'] = '3';
        $this->load->view('template', $this->data);
    }

    public function pelanggan() {
        $this->hakAkses(49);
        $this->load->view('master_service/pelanggan', $this->data);
    }

    public function supplier() {
        $this->hakAkses(51);
        $this->load->view('master_service/supplier', $this->data);
    }

    public function addInventory() {
        $this->hakAkses(52);
        $this->data['gudang'] = $this->model_sparepart->getGudang();
        $this->load->view('addInventory', $this->data);
    }

    public function editInventory() {
        $this->hakAkses(52);
        $id = $this->input->GET('id');
        $this->data['gudang'] = $this->model_sparepart->getGudang();
        $data = $this->model_sparepart->getInventoryById($id);
        $this->data['data'] = $data;
        if (!empty($data['rak_gdgid'])) {
            $this->data['rak'] = $this->model_sparepart->getRakByGudang($data['rak_gdgid']);
        }
        $this->load->view('editInventory', $this->data);
    }

    public function editSpesialItem() {
        $this->hakAkses(53);
        $id = $this->input->GET('id');
        $data = $this->model_sparepart->getSpesialItemById($id);
        $this->data['data'] = $data;
        $this->load->view('editSpesialItem', $this->data);
    }

    public function inventory() {
        $this->hakAkses(52);
        $this->load->view('inventory', $this->data);
    }

    public function gudang() {
        $this->hakAkses(64);
        $this->load->view('gudang', $this->data);
    }

    public function gradeToko() {
        $this->hakAkses(50);
        $this->load->view('gradeToko', $this->data);
    }

    /**
     * 
     */
    public function addGudang() {
        $this->hakAkses(64);
        $this->load->view('addGudang', $this->data);
    }

    /**
     * 
     */
    public function editGudang() {
        $this->hakAkses(64);
        $id = $this->input->GET('id');
        $this->data['data'] = $this->model_sparepart->getGudangById($id);
        $this->load->view('editGudang', $this->data);
    }

    /**
     * 
     */
    public function editGradeToko() {
        $this->hakAkses(50);
        $id = $this->input->GET('id');
        $this->data['data'] = $this->model_sparepart->getGradeById($id);
        $this->load->view('editGradeToko', $this->data);
    }

    /**
     * 
     */
    public function addGradeToko() {
        $this->hakAkses(50);
        $this->load->view('addGradeToko', $this->data);
    }

    /**
     * 
     */
    function loadGudang() {
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $limit = isset($_POST['rows']) ? $_POST['rows'] : 10;
        $sidx = isset($_POST['sidx']) ? $_POST['sidx'] : 'gdg_deskripsi';
        $sord = isset($_POST['sord']) ? $_POST['sord'] : '';
        $start = $limit * $page - $limit;
        $start = ($start < 0) ? 0 : $start;
        $where = whereLoad();
        $this->load->model('model_sparepart');
        $count = $this->model_sparepart->getTotalGudang($where);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;
        $query = $this->model_sparepart->getAllGudang($start, $limit, $sidx, $sord, $where);
        $responce = new stdClass;
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
        $i = 0;
        if (count($query) > 0)
            foreach ($query as $row) {
                $del = "hapusGudang('" . $row->gdgid . "')";
                $hapus = '<a href="javascript:;" onclick="' . $del . '" title="Hapus"><i class="ace-icon fa fa-trash-o bigger-120 orange"></i>';
                $edit = '<a href="#master_sparepart/editGudang?id=' . $row->gdgid . '" title="edit"><i class="ace-icon glyphicon glyphicon-pencil bigger-100"></i>';
                $responce->rows[$i]['id'] = $row->gdgid;
                $responce->rows[$i]['cell'] = array(
                    $row->gdg_deskripsi, $edit);
                $i++;
            }
        echo json_encode($responce);
    }

    /**
     * 
     */
    function loadGradeToko() {
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $limit = isset($_POST['rows']) ? $_POST['rows'] : 10;
        $sidx = isset($_POST['sidx']) ? $_POST['sidx'] : 'pel_nama';
        $sord = isset($_POST['sord']) ? $_POST['sord'] : '';
        $start = $limit * $page - $limit;
        $start = ($start < 0) ? 0 : $start;
        $where = whereLoad();
        $this->load->model('model_sparepart');
        $count = $this->model_sparepart->getTotalGradeToko($where);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;
        $query = $this->model_sparepart->getAllGradeToko($start, $limit, $sidx, $sord, $where);
        $responce = new stdClass;
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
        $i = 0;
        if (count($query) > 0)
            foreach ($query as $row) {
                $del = "hapusGrade('" . $row->gradid . "')";
                $hapus = '-';
                $edit = '-';
                if ($row->grad_status == '0') {
                    $hapus = '<a href="javascript:;" onclick="' . $del . '" title="Hapus"><i class="ace-icon fa fa-trash-o bigger-120 orange"></i>';
                    $edit = '<a href="#master_sparepart/editGradeToko?id=' . $row->gradid . '" title="edit"><i class="ace-icon glyphicon glyphicon-pencil bigger-100"></i>';
                }

                $responce->rows[$i]['id'] = $row->gradid;
                $responce->rows[$i]['cell'] = array(
                    $row->pel_nama,
                    $row->pel_alamat,
                    $row->grad_1,
                    $row->grad_2,
                    $row->grad_3,
                    $edit,
                    $hapus
                );
                $i++;
            }
        echo json_encode($responce);
    }

    /**
     * Function ini digunakan untuk menghapus pelanggan
     * @since 1.0
     * @author Aris
     */
    public function hapusGrade() {
        $id = $this->input->post('id');
        $hasil = $this->model_sparepart->hapusGrade($id);
        if ($hasil) {
            $hasil = $this->sukses("Berhasil menghapus Grade");
        } else {
            $hasil = $this->error("Gagal menghapus Grade");
        }
        echo json_encode($hasil);
    }

    function loadInventory() {
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $limit = isset($_POST['rows']) ? $_POST['rows'] : 10;
        $sidx = isset($_POST['sidx']) ? $_POST['sidx'] : 'inve_kode';
        $sord = isset($_POST['sord']) ? $_POST['sord'] : '';
        $start = $limit * $page - $limit;
        $start = ($start < 0) ? 0 : $start;
        $where = whereLoad();
        $this->load->model('model_sparepart');
        $count = $this->model_sparepart->getTotalInventory($where);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;
        $query = $this->model_sparepart->getAllInventory($start, $limit, $sidx, $sord, $where);
        $responce = new stdClass;
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
        $i = 0;
        if (count($query) > 0)
            foreach ($query as $row) {
                $del = "hapusGudang('" . $row->inveid . "')";
                $hapus = '<a href="javascript:;" onclick="' . $del . '" title="Hapus"><i class="ace-icon fa fa-trash-o bigger-120 orange"></i>';
                $edit = '<a href="#master_sparepart/editInventory?id=' . $row->inveid . '" title="edit"><i class="ace-icon glyphicon glyphicon-pencil bigger-100"></i>';
                $responce->rows[$i]['id'] = $row->inveid;
                $responce->rows[$i]['cell'] = array(
                    $row->inve_kode,
                    $row->inve_barcode,
                    $row->inve_nama,
                    $row->inve_jenis,
                    number_format($row->inve_harga_beli),
                    number_format($row->inve_hpp),
                    number_format($row->inve_harga),
                    $row->inve_qty,
                    $edit);
                $i++;
            }
        echo json_encode($responce);
    }

    function loadSpesialItem() {
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $limit = isset($_POST['rows']) ? $_POST['rows'] : 10;
        $sidx = isset($_POST['sidx']) ? $_POST['sidx'] : 'inve_kode';
        $sord = isset($_POST['sord']) ? $_POST['sord'] : '';
        $start = $limit * $page - $limit;
        $start = ($start < 0) ? 0 : $start;
        $where = whereLoad();
        $this->load->model('model_sparepart');
        $count = $this->model_sparepart->getTotalSpesialItem($where);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;
        $query = $this->model_sparepart->getAllSpesialItem($start, $limit, $sidx, $sord, $where);
        $responce = new stdClass;
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
        $i = 0;
        if (count($query) > 0)
            foreach ($query as $row) {
                $del = "hapusSpesialItem('" . $row->speid . "')";
                $hapus = '<a href="javascript:;" onclick="' . $del . '" title="Hapus"><i class="ace-icon fa fa-trash-o bigger-120 orange"></i>';
                $edit = '<a href="#master_sparepart/editSpesialItem?id=' . $row->speid . '" title="edit"><i class="ace-icon glyphicon glyphicon-pencil bigger-100"></i>';
                $responce->rows[$i]['id'] = $row->speid;
                $responce->rows[$i]['cell'] = array(
                    $row->inve_kode,
                    $row->inve_barcode,
                    $row->inve_nama,
                    number_format($row->inve_harga),
                    number_format($row->spe_harga),
                    $edit,
                    $hapus
                );
                $i++;
            }
        echo json_encode($responce);
    }

    /**
     * Function ini digunakan untuk menyimpan jabatan
     */
    public function saveGudang() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('gdg_deskripsi', '<b>Fx</b>', 'xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'gdg_cbid' => ses_cabang,
                'gdg_deskripsi' => strtoupper($this->input->post('gdg_deskripsi'))
            );
            if ($this->model_sparepart->saveGudang($data)) {
                $hasil['result'] = true;
                $hasil['msg'] = $this->sukses("Berhasil menyimpan Gudang");
            } else {
                $hasil['result'] = false;
                $hasil['msg'] = $this->error("Gagal menyimpan Gudang");
            }
        }
        echo json_encode($hasil);
    }

    /**
     * Function ini digunakan untuk menyimpan jabatan
     */
    public function updateGudang() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('gdg_deskripsi', '<b>Fx</b>', 'xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'gdgid' => $this->input->post('gdgid'),
                'gdg_cbid' => ses_cabang,
                'gdg_deskripsi' => strtoupper($this->input->post('gdg_deskripsi'))
            );
            if ($this->model_sparepart->updateGudang($data)) {
                $hasil['result'] = true;
                $hasil['msg'] = $this->sukses("Berhasil menyimpan Gudang");
            } else {
                $hasil['result'] = false;
                $hasil['msg'] = $this->error("Gagal menyimpan Gudang");
            }
        }
        echo json_encode($hasil);
    }

    public function rak() {
        $this->hakAkses(65);
        $this->load->view('rak', $this->data);
    }

    public function spesialItem() {
        $this->hakAkses(53);
        $this->load->view('spesialItem', $this->data);
    }

    public function uploadPriceList() {
        $this->hakAkses(54);
        $this->load->view('uploadPriceList', $this->data);
    }

    public function uploadSpesialItem() {
        $this->hakAkses(53);
        $this->load->view('uploadSpesialItem', $this->data);
    }

    function jsonRak() {
        $gudang = $this->input->post('gudang');
        echo json_encode($this->model_sparepart->getRakByGudang($gudang));
    }

    function jsonSupplier() {
        $nama = $this->input->post('param');
        $cbid = ses_cabang;
        $data['response'] = 'false';
        $query = $this->model_sparepart->getSupplierByNama($nama, $cbid);
        if (!empty($query)) {
            $data['response'] = 'true';
            $data['message'] = array();
            foreach ($query as $row) {
                $data['message'][] = array('value' => $row['sup_nama'], 'supid' => $row['supid'], 'desc' => $row['sup_alamat']);
            }
        } else {
            $data['message'][] = array('value' => '', 'label' => "Data Tidak Ada");
        }
        echo json_encode($data);
    }

    function jsonBarang() {
        $nama = $this->input->post('param');
        $jenis = isset($_POST['jenis']) ? $_POST['jenis'] : 'ps';
        $data['response'] = 'false';
        $query = $this->model_sparepart->getInventoryAutoComplete(strtoupper($nama), $jenis);
        if (!empty($query)) {
            $data['response'] = 'true';
            $data['message'] = array();
            foreach ($query as $row) {
                $data['message'][] = array('value' => $row['inve_kode'], 'desc' => $row['inve_nama']);
            }
        } else {
            $data['message'][] = array('value' => '', 'label' => "Data Tidak Ada");
        }
        echo json_encode($data);
    }

    /**
     * 
     */
    function jsonDataBarang() {
        $nama = $this->input->post('param');
        $jenis = isset($_POST['jenis']) ? $_POST['jenis'] : 'ps';
        $query = $this->model_sparepart->getInventoryByKodeBarang(strtoupper($nama), $jenis);
        if (count($query) > 0) {
            $query['response'] = true;
        } else {
            $query['response'] = false;
        }
        echo json_encode($query);
    }

    function jsonDataBarangTerima() {
        $nama = $this->input->post('param');
        $faktur = $this->input->post('faktur');
        $query = $this->model_sparepart->getInventoryBarangTerima(strtoupper($nama), strtoupper($faktur));
        if (count($query) > 0) {
            $query['response'] = true;
        } else {
            $query['response'] = false;
        }
        echo json_encode($query);
    }

    public function addRak() {
        $this->hakAkses(65);
        $this->data['gudang'] = $this->model_sparepart->getGudang();
        $this->load->view('addRak', $this->data);
    }

    public function editRak() {
        $this->hakAkses(65);
        $id = $this->input->GET('id');
        $this->data['gudang'] = $this->model_sparepart->getGudang();
        $this->data['data'] = $this->model_sparepart->getRakByid($id);
        $this->load->view('editRak', $this->data);
    }

    function loadRak() {
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $limit = isset($_POST['rows']) ? $_POST['rows'] : 10;
        $sidx = isset($_POST['sidx']) ? $_POST['sidx'] : 'gdg_deskripsi';
        $sord = isset($_POST['sord']) ? $_POST['sord'] : '';
        $start = $limit * $page - $limit;
        $start = ($start < 0) ? 0 : $start;
        $where = whereLoad();
        $this->load->model('model_sparepart');
        $count = $this->model_sparepart->getTotalRak($where);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;
        $query = $this->model_sparepart->getAllRak($start, $limit, $sidx, $sord, $where);
        $responce = new stdClass;
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
        $i = 0;
        if (count($query) > 0)
            foreach ($query as $row) {
                $del = "hapusRak('" . $row->rakid . "')";
                $hapus = '<a href="javascript:;" onclick="' . $del . '" title="Hapus"><i class="ace-icon fa fa-trash-o bigger-120 orange"></i>';
                $edit = '<a href="#master_sparepart/editRak?id=' . $row->rakid . '" title="edit"><i class="ace-icon glyphicon glyphicon-pencil bigger-100"></i>';
                $responce->rows[$i]['id'] = $row->gdgid;
                $responce->rows[$i]['cell'] = array(
                    $row->rak_deskripsi, $row->gdg_deskripsi, $edit);
                $i++;
            }
        echo json_encode($responce);
    }

    /**
     * Function ini digunakan untuk menyimpan jabatan
     */
    public function saveRak() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('rak_deskripsi', '<b>Fx</b>', 'xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'rak_cbid' => ses_cabang,
                'rak_gdgid' => $this->input->post('rak_gdgid'),
                'rak_deskripsi' => strtoupper($this->input->post('rak_deskripsi'))
            );
            if ($this->model_sparepart->saveRak($data)) {
                $hasil['result'] = true;
                $hasil['msg'] = $this->sukses("Berhasil menyimpan Rak");
            } else {
                $hasil['result'] = false;
                $hasil['msg'] = $this->error("Gagal menyimpan Rak");
            }
        }
        echo json_encode($hasil);
    }

    /**
     * Function ini digunakan untuk menyimpan jabatan
     */
    public function saveGradeToko() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('pelid', '<b>Fx</b>', 'xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'grad_cbid' => ses_cabang,
                'grad_pelid' => $this->input->post('pelid'),
                'grad_1' => $this->input->post('grad_1'),
                'grad_2' => $this->input->post('grad_2'),
                'grad_3' => $this->input->post('grad_3')
            );
            if ($this->model_sparepart->saveGradeToko($data)) {
                $hasil['result'] = true;
                $hasil['msg'] = $this->sukses("Berhasil menyimpan Grade Toko");
            } else {
                $hasil['result'] = false;
                $hasil['msg'] = $this->error("Gagal menyimpan Grade Toko");
            }
        }
        echo json_encode($hasil);
    }

    /**
     * Function ini digunakan untuk menyimpan jabatan
     */
    public function updateGradeToko() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('pelid', '<b>Fx</b>', 'xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'grad_cbid' => ses_cabang,
                'grad_pelid' => $this->input->post('pelid'),
                'gradid' => $this->input->post('gradid'),
                'grad_1' => $this->input->post('grad_1'),
                'grad_2' => $this->input->post('grad_2'),
                'grad_3' => $this->input->post('grad_3')
            );
            if ($this->model_sparepart->updateGradeToko($data)) {
                $hasil['result'] = true;
                $hasil['msg'] = $this->sukses("Berhasil menyimpan Grade Toko");
            } else {
                $hasil['result'] = false;
                $hasil['msg'] = $this->error("Gagal menyimpan Grade Toko");
            }
        }
        echo json_encode($hasil);
    }

    /**
     * Function ini digunakan untuk menyimpan jabatan
     */
    public function saveInventory() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('inve_kode', '<b>Fx</b>', 'xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $min = $this->input->post('inve_qty_min');
            if ($min == '') {
                $min = 0;
            }
            $km = $this->input->post('inve_umur_km');
            if ($km == '') {
                $km = 0;
            }
            $bulan = $this->input->post('inve_umur_bulan');
            if ($bulan == '') {
                $bulan = 0;
            }
            $data = array(
                'inve_cbid' => ses_cabang,
                'inve_kode' => strtoupper($this->input->post('inve_kode')),
                'inve_nama' => strtoupper($this->input->post('inve_nama')),
                'inve_barcode' => $this->input->post('inve_barcode'),
                'inve_rakid' => $this->input->post('inve_rakid'),
                'inve_jenis' => $this->input->post('inve_jenis'),
                'inve_qty_min' => $min,
                'inve_umur_km' => $km,
                'inve_umur_bulan' => $bulan,
                'inve_harga' => $this->system->numeric($this->input->post('inve_harga')),
            );
            if ($this->model_sparepart->saveInventory($data)) {
                $hasil['result'] = true;
                $hasil['msg'] = $this->sukses("Berhasil menyimpan Inventory");
            } else {
                $hasil['result'] = false;
                $hasil['msg'] = $this->error("Gagal menyimpan Inventory");
            }
        }
        echo json_encode($hasil);
    }

    public function updateInventory() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('inve_kode', '<b>Fx</b>', 'xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $min = $this->input->post('inve_qty_min');
            if ($min == '') {
                $min = 0;
            }
            $km = $this->input->post('inve_umur_km');
            if ($km == '') {
                $km = 0;
            }
            $bulan = $this->input->post('inve_umur_bulan');
            if ($bulan == '') {
                $bulan = 0;
            }
            $data = array(
                'inve_cbid' => ses_cabang,
                'inve_kode' => strtoupper($this->input->post('inve_kode')),
                'inve_nama' => strtoupper($this->input->post('inve_nama')),
                'inve_barcode' => $this->input->post('inve_barcode'),
                'inve_rakid' => $this->input->post('inve_rakid'),
                'inve_jenis' => $this->input->post('inve_jenis'),
                'inveid' => $this->input->post('inveid'),
                'inve_qty_min' => $min,
                'inve_umur_km' => $km,
                'inve_umur_bulan' => $bulan,
                'inve_harga' => $this->system->numeric($this->input->post('inve_harga')),
            );
            if ($this->model_sparepart->updateInventory($data)) {
                $hasil['result'] = true;
                $hasil['msg'] = $this->sukses("Berhasil menyimpan Inventory");
            } else {
                $hasil['result'] = false;
                $hasil['msg'] = $this->error("Gagal menyimpan Inventory");
            }
        }
        echo json_encode($hasil);
    }

    /**
     * Function ini digunakan untuk menyimpan jabatan
     */
    public function updateRak() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('rak_deskripsi', '<b>Fx</b>', 'xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'rak_cbid' => ses_cabang,
                'rakid' => $this->input->post('rakid'),
                'rak_deskripsi' => strtoupper($this->input->post('rak_deskripsi'))
            );
            if ($this->model_sparepart->updateRak($data)) {
                $hasil['result'] = true;
                $hasil['msg'] = $this->sukses("Berhasil menyimpan Rak");
            } else {
                $hasil['result'] = false;
                $hasil['msg'] = $this->error("Gagal menyimpan Rak");
            }
        }
        echo json_encode($hasil);
    }

    /**
     * Function ini digunakan untuk menyimpan jabatan
     */
    public function updateSpesialItem() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('speid', '<b>Fx</b>', 'xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'speid' => $this->input->post('speid'),
                'spe_harga' => $this->system->numeric($this->input->post('spe_harga'))
            );
            if ($this->model_sparepart->updateSpesialItem($data)) {
                $hasil['result'] = true;
                $hasil['msg'] = $this->sukses("Berhasil menyimpan Spesial Item");
            } else {
                $hasil['result'] = false;
                $hasil['msg'] = $this->error("Gagal menyimpan Spesial Item");
            }
        }
        echo json_encode($hasil);
    }

    public function get_format_spesial() {
        $this->load->view('format_spesial_item', $this->data);
    }

    public function get_format_pricelist() {
        $this->load->view('format_pricelist', $this->data);
    }

    public function saveSpesialItem() {
        $hasil = array();
        if (isset($_FILES['spesial'])) {
            $this->load->library("Spreadsheet_Excel_Reader");
            $data = new Spreadsheet_Excel_Reader();
            chmod($_FILES['spesial']['tmp_name'], 0755);
            $data->read($_FILES['spesial']['tmp_name']);
            $data->setOutputEncoding('CP1251');
            $baris = $data->sheets[0]['numRows'];
            $inventory = $this->model_sparepart->getIdInventory();
            $spesial = array();
            for ($i = 2; $i <= $baris; $i++) {
                if (!empty($data->sheets[0]['cells'][$i][1])) {
                    $inveid = $inventory[str_replace(" ", "", $data->sheets[0]['cells'][$i][1])];
                    $harga = $data->sheets[0]['cells'][$i][3];
                    $spesial[] = array(
                        'spe_inveid' => $inveid,
                        'spe_cbid' => ses_cabang,
                        'spe_harga' => $this->system->numeric($harga),
                    );
                }
            }
            if ($this->model_sparepart->saveSpesialItem($spesial)) {
                $hasil['result'] = true;
                $hasil['msg'] = $this->sukses("Berhasil menyimpan spesial item");
            } else {
                $hasil['result'] = false;
                $hasil['msg'] = $this->error("Gagal menyimpan spesial item");
            }
        }
        echo json_encode($hasil);
    }

    public function savePriceList() {
        $hasil = array();
        if (isset($_FILES['price'])) {
            $this->load->library("Spreadsheet_Excel_Reader");
            $data = new Spreadsheet_Excel_Reader();
            chmod($_FILES['price']['tmp_name'], 0755);
            $data->read($_FILES['spesial']['tmp_name']);
            $data->setOutputEncoding('CP1251');
            $baris = $data->sheets[0]['numRows'];
            $inventory = $this->model_sparepart->getIdInventory();
            $spesial = array();
            for ($i = 2; $i <= $baris; $i++) {
                if (!empty($data->sheets[0]['cells'][$i][1])) {
                    $inveid = $inventory[str_replace(" ", "", $data->sheets[0]['cells'][$i][1])];
                    $harga = $data->sheets[0]['cells'][$i][3];
                    $spesial[] = array(
                        'pl_inveid' => $inveid,
                        'pl_cbid' => ses_cabang,
                        'pl_harga' => $this->system->numeric($harga),
                    );
                }
            }
            if ($this->model_sparepart->savePriceList($spesial)) {
                $hasil['result'] = true;
                $hasil['msg'] = $this->sukses("Berhasil menyimpan spesial item");
            } else {
                $hasil['result'] = false;
                $hasil['msg'] = $this->error("Gagal menyimpan spesial item");
            }
        }
        echo json_encode($hasil);
    }

    /**
     * Function ini digunakan untuk menghapus pelanggan
     * @since 1.0
     * @author Aris
     */
    public function hapusSpesialItem() {
        $id = $this->input->post('id');
        $hasil = $this->model_sparepart->hapusSpesialItem($id);
        if ($hasil) {
            $hasil = $this->sukses("Berhasil menghapus spesial Item");
        } else {
            $hasil = $this->error("Gagal menghapus spesial item");
        }
        echo json_encode($hasil);
    }

}

?>
