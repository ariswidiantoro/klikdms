<?php

/**
 * Class Admin_Controller
 * @author Aris
 * 2013-11-11
 */
class Utility_Sparepart extends Application {

    /**
     * The new Admin_controller
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('model_util_sparepart');
        $this->isLogin();
    }

    public function index() {
        $this->data['content'] = 'sparepart';
        $this->data['menuid'] = '3';
        $this->load->view('template', $this->data);
    }

    /**
     * This function is used for display menu form
     * @author Aris
     * @since 1.0
     */
    public function supplySlip() {
        $this->hakAkses(90);
        $this->load->view('supplySlip', $this->data);
    }

    public function adjustmentStock() {
        $this->hakAkses(84);
        $this->load->view('adjustmentStock', $this->data);
    }

    /**
     * 
     */
    public function fakturSparepart() {
        $this->hakAkses(83);
        $this->load->view('fakturSparepart', $this->data);
    }

    public function penerimaanBarang() {
        $this->hakAkses(82);
        $this->load->view('penerimaanBarang', $this->data);
    }

    /**
     * 
     */
    function loadSupplySlip() {
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $limit = isset($_POST['rows']) ? $_POST['rows'] : 10;
        $sidx = isset($_POST['sidx']) ? $_POST['sidx'] : 'spp_noslip';
        $sord = isset($_POST['sord']) ? $_POST['sord'] : '';
        $start = $limit * $page - $limit;
        $start = ($start < 0) ? 0 : $start;
        $where = whereLoad();
        $count = $this->model_util_sparepart->getTotalSupply($where);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;
        $query = $this->model_util_sparepart->getAllSupplySlip($start, $limit, $sidx, $sord, $where);
        $responce = new stdClass;
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
        $i = 0;
        if (count($query) > 0)
            foreach ($query as $row) {
                $batal = '-';
                if ($row->spp_faktur == 0 && $row->spp_status == 0) {
                    $batal = '<a href="javascript:;" onclick="batal(\'' . $row->sppid . '\',\'' . $row->spp_jenis . '\')" title="Hapus"><i class="ace-icon fa fa-trash-o bigger-120 orange"></i>';
                }
                $print = '<a href="javascript:;" onclick="print(\'' . $row->sppid . '\',\'' . $row->spp_jenis . '\')" title="Print"><i class="ace-icon glyphicon glyphicon-print bigger-120"></i>';
                $responce->rows[$i]['id'] = $row->sppid;
                $responce->rows[$i]['cell'] = array(
                    $row->spp_noslip,
                    $row->spp_jenis,
                    date('d-m-Y', strtotime($row->spp_tgl)),
                    $row->pel_nama,
                    $row->wo_nomer,
                    number_format($row->spp_total, 2),
                    '<input type="text" autocomplete="off" id="alasan' . $row->sppid . '" name="alasan' . $row->sppid . '" 
                     class="col-xs-10 col-sm-5" style="width:100%" />',
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
    function loadTerimaBarang() {
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $limit = isset($_POST['rows']) ? $_POST['rows'] : 10;
        $sidx = isset($_POST['sidx']) ? $_POST['sidx'] : 'trbr_faktur';
        $sord = isset($_POST['sord']) ? $_POST['sord'] : '';
        $start = $limit * $page - $limit;
        $start = ($start < 0) ? 0 : $start;
        $where = whereLoad();
        $count = $this->model_util_sparepart->getTotalTrbr($where);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;
        $query = $this->model_util_sparepart->getAllTrbr($start, $limit, $sidx, $sord, $where);
        $responce = new stdClass;
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
        $i = 0;
        if (count($query) > 0)
            foreach ($query as $row) {
                $print = '<a href="javascript:;" onclick="print(\'' . $row->trbrid . '\',' . $i . ')" title="Print"><i class="ace-icon glyphicon glyphicon-print bigger-120"></i>';
                $responce->rows[$i]['id'] = $row->trbrid;
                $responce->rows[$i]['cell'] = array(
                    $row->trbr_faktur,
                    date('d-m-Y', strtotime($row->trbr_tgl)),
                    $row->sup_nama,
                    number_format($row->trbr_total),
                    $print
                );
                $i++;
            }
        echo json_encode($responce);
    }
    
    /**
     * 
     */
    function loadAdjustment() {
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $limit = isset($_POST['rows']) ? $_POST['rows'] : 10;
        $sidx = isset($_POST['sidx']) ? $_POST['sidx'] : 'adj_nomer';
        $sord = isset($_POST['sord']) ? $_POST['sord'] : '';
        $start = $limit * $page - $limit;
        $start = ($start < 0) ? 0 : $start;
        $where = whereLoad();
        $count = $this->model_util_sparepart->getTotalAdjustment($where);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;
        $query = $this->model_util_sparepart->getAllAdjustment($start, $limit, $sidx, $sord, $where);
        $responce = new stdClass;
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
        $i = 0;
        if (count($query) > 0)
            foreach ($query as $row) {
                $print = '<a href="javascript:;" onclick="print(\'' . $row->adjid . '\',' . $i . ')" title="Print"><i class="ace-icon glyphicon glyphicon-print bigger-120"></i>';
                $responce->rows[$i]['id'] = $row->adjid;
                $responce->rows[$i]['cell'] = array(
                    $row->adjid,
                    date('d-m-Y', strtotime($row->adj_tgl)),
                    $print
                );
                $i++;
            }
        echo json_encode($responce);
    }

    /**
     * 
     */
    function loadFakturSparepart() {
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $limit = isset($_POST['rows']) ? $_POST['rows'] : 10;
        $sidx = isset($_POST['sidx']) ? $_POST['sidx'] : 'not_nomer';
        $sord = isset($_POST['sord']) ? $_POST['sord'] : '';
        $start = $limit * $page - $limit;
        $start = ($start < 0) ? 0 : $start;
        $where = whereLoad();
        $count = $this->model_util_sparepart->getTotalFaktur($where);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;
        $query = $this->model_util_sparepart->getAllFaktur($start, $limit, $sidx, $sord, $where);
        $responce = new stdClass;
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
        $i = 0;
        if (count($query) > 0)
            foreach ($query as $row) {
                $print = '<a href="javascript:;" onclick="print(\'' . $row->notid . '\',' . $i . ')" title="Print"><i class="ace-icon glyphicon glyphicon-print bigger-120"></i>';
                $responce->rows[$i]['id'] = $row->notid;
                $responce->rows[$i]['cell'] = array(
                    $row->not_nomer,
                    $row->spp_noslip,
                    date('d-m-Y', strtotime($row->not_tgl)),
                    $row->pel_nama,
                    number_format($row->not_total),
                    $print
                );
                $i++;
            }
        echo json_encode($responce);
    }

    function batalSupply() {
        $sppid = strtoupper($this->input->post('id'));
        $alasan = strtoupper($this->input->post('alasan'));
        $jenis = $this->input->post('jenis');
        echo json_encode($this->model_util_sparepart->batalSupply($sppid, $alasan,$jenis));
    }

    function updatePrintFaktur() {
        $notid = strtoupper($this->input->post('id'));
        echo json_encode($this->model_util_sparepart->updatePrintFaktur($notid));
    }

    function printBatalSupply($id) {
        $this->load->model('model_trspart');
        $this->data['data'] = $this->model_trspart->getSupplySlip($id);
        $this->load->view('printBatalSupply', $this->data);
    }

}

?>
