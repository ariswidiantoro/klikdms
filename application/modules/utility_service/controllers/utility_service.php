<?php

/**
 * Class Admin_Controller
 * @author Aris
 * 2013-11-11
 */
class Utility_Service extends Application {

    /**
     * The new Admin_controller
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('model_util_service');
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
    public function workOrder() {
        $this->hakAkses(86);
        $this->load->view('workOrder', $this->data);
    }
    public function fakturService() {
        $this->hakAkses(87);
        $this->load->view('fakturService', $this->data);
    }

    function loadWorkOrder() {
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $limit = isset($_POST['rows']) ? $_POST['rows'] : 10;
        $sidx = isset($_POST['sidx']) ? $_POST['sidx'] : 'wo_nomer';
        $sord = isset($_POST['sord']) ? $_POST['sord'] : '';
        $start = $limit * $page - $limit;
        $start = ($start < 0) ? 0 : $start;
        $where = whereLoad();
        $count = $this->model_util_service->getTotalWo($where);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;
        $query = $this->model_util_service->getAllWo($start, $limit, $sidx, $sord, $where);
        $responce = new stdClass;
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
        $i = 0;
        if (count($query) > 0)
            foreach ($query as $row) {
                $batal = '-';
                if ($row->wo_inv_status == 0 && $row->wo_status == 0) {
                    $batal = '<a href="javascript:;" onclick="batal(\'' . $row->woid . '\')" title="Hapus"><i class="ace-icon fa fa-trash-o bigger-120 orange"></i>';
                }
                $print = '<a href="javascript:;" onclick="print(\'' . $row->woid . '\')" title="Print"><i class="ace-icon glyphicon glyphicon-print bigger-120"></i>';
                $responce->rows[$i]['id'] = $row->woid;
                $responce->rows[$i]['cell'] = array(
                    $row->wo_nomer,
                    $row->pel_nama,
                    date('d-m-Y', strtotime($row->wo_tgl)),
                    $row->msc_nopol,
                    $row->msc_nomesin,
                    '<input type="text" autocomplete="off" id="alasan' . $row->woid . '" name="alasan' . $row->woid . '" 
                     class="col-xs-10 col-sm-10 upper" style="width:100%" />',
                    $batal,
                    $print
                );
                $i++;
            }
        echo json_encode($responce);
    }
    
    /**
     * 
     */
    function loadFakturService() {
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $limit = isset($_POST['rows']) ? $_POST['rows'] : 10;
        $sidx = isset($_POST['sidx']) ? $_POST['sidx'] : 'wo_nomer';
        $sord = isset($_POST['sord']) ? $_POST['sord'] : '';
        $start = $limit * $page - $limit;
        $start = ($start < 0) ? 0 : $start;
        $where = whereLoad();
        $count = $this->model_util_service->getTotalFakturService($where);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;
        $query = $this->model_util_service->getAllFakturService($start, $limit, $sidx, $sord, $where);
        $responce = new stdClass;
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
        $i = 0;
        if (count($query) > 0)
            foreach ($query as $row) {
                $batal = '-';
                if ($row->inv_status == 0) {
                    $batal = '<a href="javascript:;" onclick="batal(\'' . $row->invid . '\',\'' . $row->woid . '\')" title="Hapus"><i class="ace-icon fa fa-trash-o bigger-120 orange"></i>';
                }
                $print = '<a href="javascript:;" onclick="print(\'' . $row->invid . '\')" title="Print"><i class="ace-icon glyphicon glyphicon-print bigger-120"></i>';
                $responce->rows[$i]['id'] = $row->invid;
                $responce->rows[$i]['cell'] = array(
                    $row->wo_nomer,
                    $row->pel_nama,
                    date('d-m-Y', strtotime($row->inv_tgl)),
                    $row->msc_nopol,
                    $row->msc_nomesin,
                    '<input type="text" autocomplete="off" id="alasan' . $row->invid . '" name="alasan' . $row->invid . '" 
                     class="col-xs-10 col-sm-10 upper" style="width:100%" />',
                    $batal,
                    $print
                );
                $i++;
            }
        echo json_encode($responce);
    }

    function batalWo() {
        $woid = strtoupper($this->input->post('id'));
        $alasan = strtoupper($this->input->post('alasan'));
        echo json_encode($this->model_util_service->batalWo($woid, $alasan));
    }
    function batalFakturService() {
        $invid = strtoupper($this->input->post('id'));
        $woid = strtoupper($this->input->post('woid'));
        $alasan = strtoupper($this->input->post('alasan'));
        echo json_encode($this->model_util_service->batalFakturService($invid,$woid, $alasan));
    }

    function printBatalWo($id) {
        $this->data['data'] = $this->model_util_service->getWorkOrderBatal($id);
        $this->load->view('printBatalWo', $this->data);
    }
    function printBatalFakturService($id) {
        $this->data['data'] = $this->model_util_service->getFakturServiceBatal($id);
        $this->load->view('printBatalWo', $this->data);
    }

}

?>
