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
//        $this->hakAkses(1);
       // $this->check_login();
    }

    public function index() {
        $this->data['content'] = 'service';
        $this->data['header'] = $this->model_admin->getMenuModule();
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
     * This function is used for display the exmination form
     * @author Aris
     * @since 1.0
     */
    public function addFlateRate() {
        $this->hakAkses(26);
        $this->load->view('addFlateRate', $this->data);
    }

    function loadFlateRate() {
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $limit = isset($_POST['rows']) ? $_POST['rows'] : 10;
        $sidx = isset($_POST['sidx']) ? $_POST['sidx'] : 'flat_kode';
        $sord = isset($_POST['sord']) ? $_POST['sord'] : '';
        $start = $limit * $page - $limit;
        $start = ($start < 0) ? 0 : $start;
        $where = whereLoad();
        $count = $this->model_service->getTotalData($where, 'ms_menu');
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

}

?>