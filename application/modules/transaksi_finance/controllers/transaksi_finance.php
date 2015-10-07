<?php

/**
 * Class Master
 * @author Rossi Erl
 * 2015-09-04
 */
class Transaksi_Finance extends Application {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('model_admin', 'model_sales', 'model_finance', 'model_trfinance'));
        $this->isLogin();
    }

    public function index() {
        echo "";
    }

    public function kasin() {
        $this->hakAkses(1051);
        $this->data['etc'] = array(
            'judul' => 'Penerimaan Kas',
            'targetSave' => 'transaksi_finance/kasinSave',
            'trans' => 'KAS',
            'type' => 'I',
        );
        $this->load->view('addTrans', $this->data);
    }

    public function kasinSave() {
        $mainVar = array(
            'kst_trans' => 'KAS',
            'kst_type' => 'I',
            'kst_nomer' => $this->input->post('trans_nomer', TRUE),
            'kst_noreff' => $this->input->post('trans_noreff', TRUE),
            'kst_tgl' => $this->input->post('trans_tgl', TRUE),
            'kst_coa' => $this->input->post('trans_coa', TRUE),
            'kst_desc' => $this->input->post('trans_desc', TRUE),
            'kst_debit' => $this->input->post('trans_debit', TRUE),
            'kst_kredit' => $this->input->post('trans_kredit', TRUE),
            'kst_createon' => $this->input->post('trans_nomer', TRUE),
            'kst_createby' => $this->input->post('trans_nomer', TRUE),
        );
    }

    public function kasout() {
        $this->hakAkses(1051);
        $this->data['etc'] = array(
            'judul' => 'Pengeluaran Kas',
            'targetSave' => 'transaksi_finance/kasoutSave',
            'trans' => 'kas',
            'type' => 'O',
        );
        $this->load->view('addTrans', $this->data);
    }

    public function bankin() {
        $this->hakAkses(1051);
        $this->data['etc'] = array(
            'judul' => 'Penerimaan Bank',
            'targetSave' => 'transaksi_finance/bankinSave',
            'trans' => 'bnk',
            'type' => 'I',
        );
        $this->load->view('addTrans', $this->data);
    }

    public function bankout() {
        $this->hakAkses(1051);
        $this->data['etc'] = array(
            'judul' => 'Pengeluaran Bank',
            'targetSave' => 'transaksi_finance/bankoutSave',
            'trans' => 'bnk',
            'type' => 'O',
        );
        $this->load->view('addTrans', $this->data);
    }

    public function cekin() {
        $this->hakAkses(1051);
        $this->data['etc'] = array(
            'judul' => 'Penerimaan Kas',
            'targetSave' => 'transaksi_finance/cekinSave',
            'type' => 'I',
        );
        $this->load->view('addTrans', $this->data);
    }

    public function cekout() {
        $this->hakAkses(1051);
        $this->data['etc'] = array(
            'judul' => 'Penerimaan Kas',
            'targetSave' => 'transaksi_finance/kasinSave',
            'type' => 'I',
        );
        $this->load->view('addTrans', $this->data);
    }

    public function loadTrans() {
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $limit = isset($_POST['rows']) ? $_POST['rows'] : 10;
        $sidx = isset($_POST['sidx']) ? $_POST['sidx'] : 'kasid';
        $sord = isset($_POST['sord']) ? $_POST['sord'] : '';
        $start = $limit * $page - $limit;
        $start = ($start < 0) ? 0 : $start;
        $where = whereLoad();
        $count = $this->model_finance->getTotalKasin($where);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;
        $query = $this->model_finance->getDataKasin($start, $limit, $sidx, $sord, $where);
        $responce = new stdClass;
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
        $i = 0;
        if (count($query) > 0)
            foreach ($query as $row) {
                $del = "hapusData('" . $row->kasid . "', '" . $row->kas_nomer . "')";
                $hapus = '<a href="javascript:void(0);" onclick="' . $del . '" title="Hapus"><i class="ace-icon fa fa-trash-o bigger-120 orange"></i>';
                $edit = '<a href="#master_finance/editCoa?id=' . $row->coaid . '" title="Edit"><i class="ace-icon glyphicon glyphicon-pencil bigger-100"></i>';
                $responce->rows[$i]['id'] = $row->coaid;
                $responce->rows[$i]['cell'] = array(
                    $row->coa_kode,
                    $row->coa_desc,
                    $row->coa_type,
                    $row->coa_level,
                    $edit, $hapus);
                $i++;
            }
        echo json_encode($responce);
    }

    /* AUTO COMPLETE FUNCTION */

    public function auto_coa() {
        $param = $this->input->post('param');
        $cbid = $this->input->post('cbid');
        $query = $this->model_trfinance->autoCoa(array('param' => strtoupper($param), 'cbid' => $cbid));
        if (!empty($query)) {
            $data['message'] = array();
            foreach ($query as $row) {
                $data['message'][] = array(
                    'value' => $row['coa_kode'], 
                    'desc' => $row['coa_desc'], 
                    'type' => $row['coa_type'],
                    'trglocal' => $row['coa_kode'], 
                    'trgid' => $row['coa_desc'], 
                    'trgname' => $row['coa_desc'], 
                    );
            }
        } else {
            $data['message'][] = array('value' => 'DATA TIDAK ADA', 'desc' => "");
        }
        echo json_encode($data);
    }

    public function auto_wo() {
        $param = $this->input->post('param');
        $cbid = $this->input->post('cbid');
        $query = $this->model_trfinance->autoWo(array('param' => strtoupper($param), 'cbid' => $cbid));
        if (!empty($query)) {
            $data['message'] = array();
            foreach ($query as $row) {
                $data['message'][] = array('value' => $row['wo_nomer'], 'desc' => $row['msc_nopol'], 'type' => $row['wo_type']);
            }
        } else {
            $data['message'][] = array('value' => 'DATA TIDAK ADA', 'desc' => "");
        }
        echo json_encode($data);
    }

    public function auto_do() {
        $param = $this->input->post('param');
        $cbid = $this->input->post('cbid');
        $query = $this->model_trfinance->autoDo(array('param' => strtoupper($param), 'cbid' => $cbid));
        if (!empty($query)) {
            $data['message'] = array();
            foreach ($query as $row) {
                $data['message'][] = array('value' => $row['wo_nomer'], 'desc' => $row['msc_nopol'], 'type' => $row['wo_type']);
            }
        } else {
            $data['message'][] = array('value' => 'DATA TIDAK ADA', 'desc' => "");
        }
        echo json_encode($data);
    }

}

?>
