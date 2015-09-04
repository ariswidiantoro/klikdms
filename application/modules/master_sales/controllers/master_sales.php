<?php

/**
 * Class Master
 * @author Rossi Erl
 * 2013-11-11
 */
class Master_Sales extends Application {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('model_admin', 'model_sales'));
        $this->isLogin();
    }

    public function index() {
        echo " ";
    }
    
    public function masterMerk(){
        $this->hakAkses('7050');
    }
    
    function loadMerk() {
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $limit = isset($_POST['rows']) ? $_POST['rows'] : 10;
        $sidx = isset($_POST['sidx']) ? $_POST['sidx'] : 'merkid';
        $sord = isset($_POST['sord']) ? $_POST['sord'] : '';
        $start = $limit * $page - $limit;
        $start = ($start < 0) ? 0 : $start;
        $where = whereLoad();
        $count = $this->model_sales->getTotalMerk($where);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;
        $query = $this->model_sales->getAllData($start, $limit, $sidx, $sord, $where);
        $responce = new stdClass;
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
        $i = 0;
        if (count($query) > 0) 
            foreach ($query as $row) {
                $del = "hapusMerk('" . $row->br_cbid . "')";
                $hapus = '<a href="javascript:;" onclick="' . $del . '" title="Hapus"><i class="ace-icon fa fa-trash-o bigger-120 orange"></i>';
                $edit = '<a href="#master_sales/editMerk?id=' . $row->merkid . '" title="edit"><i class="ace-icon glyphicon glyphicon-pencil bigger-100"></i>';
                $responce->rows[$i]['id'] = $row->br_cbid;
                $responce->rows[$i]['cell'] = array(
                    number_format($row->br_rate), $edit);
                $i++;
            }
        echo json_encode($responce);
    }

}

?>
