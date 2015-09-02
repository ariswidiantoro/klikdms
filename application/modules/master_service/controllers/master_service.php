<?php

/**
 * Class Admin_Controller
 * @author Aris
 * 2013-11-11
 */
class Master_Service extends Application {

    /**
     * The new Admin_controller
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('model_admin');
        $this->load->model('model_service');
//        $this->hakAkses(1);
        $this->isLogin();
    }

    public function index() {
        $this->data['content'] = 'service';
        $this->data['menuid'] = '4';
        $this->load->view('template', $this->data);
    }

    /**
     * This function is used for display menu form
     * @author Aris
     * @since 1.0
     */
    public function flateRate() {
        $this->hakAkses(26);
        $this->load->view('flateRate', $this->data);
    }

    /**
     * This function is used for display menu form
     * @author Aris
     * @since 1.0
     */
    public function basicRate() {
        $this->hakAkses(48);
        $this->load->view('basicRate', $this->data);
    }

    /**
     * This function is used for display the exmination form
     * @author Aris
     * @since 1.0
     */
    public function addFlateRate() {
        $this->hakAkses(26);
        $this->data['basic'] = $this->model_service->getBasicRate(ses_cabang);
        $this->load->view('addFlateRate', $this->data);
    }

    /**
     * This function is used for display the exmination form
     * @author Aris
     * @since 1.0
     */
    public function addBasicRate() {
        $this->hakAkses(48);
        $this->load->view('addBasicRate', $this->data);
    }

    /**
     * This function is used for display the exmination form
     * @author Aris
     * @since 1.0
     */
    public function editBasicRate() {
        $this->hakAkses(48);
        $id = $this->input->GET('id');
        $this->data['data'] = $this->model_service->getBasicRate($id);
        $this->load->view('editBasicRate', $this->data);
    }

    /**
     * Function ini digunakan untuk menyimpan jabatan
     */
    public function saveBasicRate() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('br_rate', '<b>Fx</b>', 'xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $rate = $this->system->numeric($this->input->post('br_rate'));
            $data = array(
                'br_cbid' => ses_cabang,
                'br_rate' => $rate
            );
            $hasil = $this->model_service->saveBasicRate($data);
            if ($hasil) {
                $hasil = $this->sukses("Berhasil menyimpan basic rate");
            } else {
                $hasil = $this->error("Gagal menyimpan basic rate");
            }
        }
        echo json_encode($hasil);
    }
    /**
     * Function ini digunakan untuk menyimpan jabatan
     */
    public function saveFlateRate() {
        $this->form_validation->set_rules('flat_kode', '<b>Fx</b>', 'xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'flat_cbid' => ses_cabang,
                'flat_kode' => $this->input->post('flat_kode'),
                'flat_type' => 1,
                'flat_deskripsi' => $this->input->post('flat_deskripsi'),
                'flat_brate' => $this->system->numeric($this->input->post('flat_brate')),
                'flat_jam' => $this->system->numeric($this->input->post('flat_jam')),
                'flat_fx' => $this->system->numeric($this->input->post('flat_fx')),
                'flat_total' => $this->system->numeric($this->input->post('flat_total')),
                'flat_lc' => $this->system->numeric($this->input->post('flat_lc')),
            );
            $hasil = $this->model_service->saveFlateRate($data);
            if ($hasil) {
                $hasil = $this->sukses("Berhasil menyimpan flate rate");
            } else {
                $hasil = $this->error("Gagal menyimpan flate rate");
            }
        }
        echo json_encode($hasil);
    }

    function loadFlateRate() {
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $limit = isset($_POST['rows']) ? $_POST['rows'] : 10;
        $sidx = isset($_POST['sidx']) ? $_POST['sidx'] : 'flat_kode';
        $sord = isset($_POST['sord']) ? $_POST['sord'] : '';
        $start = $limit * $page - $limit;
        $start = ($start < 0) ? 0 : $start;
        $where = whereLoad();
        $count = $this->model_service->getTotalFlateRate($where);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;
        $query = $this->model_admin->getAllFlateRate($start, $limit, $sidx, $sord, $where);
        $responce = new stdClass;
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
        $i = 0;
        if (count($query) > 0)
            foreach ($query as $row) {
                $hapus = '-';
                $edit = '-';
                if ($row->flatid == '0') {
                    $del = "hapusFlateRate('" . $row->flatid . "')";
                    $hapus = '<a href="javascript:;" onclick="' . $del . '" title="Hapus"><i class="ace-icon fa fa-trash-o bigger-120 orange"></i>';
                    $edit = '<a href="#admin/editFlateRate?id=' . $row->flatid . '" title="edit"><i class="ace-icon glyphicon glyphicon-pencil bigger-100"></i>';
                }
                $responce->rows[$i]['id'] = $row->flatid;
                $responce->rows[$i]['cell'] = array(
                    $row->flat_kode, $row->flat_deskripsi, $row->flat_jam, $row->flat_fx, $row->flat_brate, $row->flat_total, $edit, $hapus);
                $i++;
            }
        echo json_encode($responce);
    }

    function loadBasicRate() {
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $limit = isset($_POST['rows']) ? $_POST['rows'] : 10;
        $sidx = isset($_POST['sidx']) ? $_POST['sidx'] : 'br_cbid';
        $sord = isset($_POST['sord']) ? $_POST['sord'] : '';
        $start = $limit * $page - $limit;
        $start = ($start < 0) ? 0 : $start;
        $where = whereLoad();
        $this->load->model('model_admin');
        $count = $this->model_admin->getTotalData($where, 'svc_brate');
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;
        $query = $this->model_admin->getAllData($start, $limit, $sidx, $sord, $where, 'svc_brate');
        $responce = new stdClass;
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
        $i = 0;
        if (count($query) > 0)
            foreach ($query as $row) {
                $del = "hapusBasicRate('" . $row->br_cbid . "')";
                $hapus = '<a href="javascript:;" onclick="' . $del . '" title="Hapus"><i class="ace-icon fa fa-trash-o bigger-120 orange"></i>';
                $edit = '<a href="#master_service/editBasicRate?id=' . $row->br_cbid . '" title="edit"><i class="ace-icon glyphicon glyphicon-pencil bigger-100"></i>';
                $responce->rows[$i]['id'] = $row->br_cbid;
                $responce->rows[$i]['cell'] = array(
                    number_format($row->br_rate), $edit);
                $i++;
            }
        echo json_encode($responce);
    }

}

?>
