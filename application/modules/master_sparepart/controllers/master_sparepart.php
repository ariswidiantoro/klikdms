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

    public function inventory() {
        $this->hakAkses(52);
        $this->load->view('inventory', $this->data);
    }

    public function gudang() {
        $this->hakAkses(64);
        $this->load->view('gudang', $this->data);
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

    function jsonRak() {
        $gudang = $this->input->post('gudang');
        echo json_encode($this->model_sparepart->getRakByGudang($gudang));
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

}

?>
