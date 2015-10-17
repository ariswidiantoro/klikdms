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
            'targetSave' => 'transaksi_finance/saveTrans',
            'kstid' => '',
            'purpose' => 'ADD',
            'trans' => 'KAS',
            'type' => 'I',
            'mainCoa' => $this->model_trfinance->mainCoa(array('cbid' => ses_cabang)),
            'costcenter' => $this->model_finance->cListCostCenter(array('cbid' => ses_cabang)),
        );
        $this->load->view('addTrans', $this->data);
    }

    public function kasout() {
        $this->hakAkses(1051);
        $this->data['etc'] = array(
            'judul' => 'Pengeluaran Kas',
            'targetSave' => 'transaksi_finance/saveTrans',
            'kstid' => '',
            'purpose' => 'ADD',
            'trans' => 'KAS',
            'type' => 'O',
            'costcenter' => $this->model_finance->cListCostCenter(array('cbid' => ses_cabang)),
        );
        $this->load->view('addTrans', $this->data);
    }

    public function bankin() {
        $this->hakAkses(1051);
        $this->data['etc'] = array(
            'judul' => 'Penerimaan Bank',
            'targetSave' => 'transaksi_finance/saveTrans',
            'kstid' => '',
            'purpose' => 'ADD',
            'trans' => 'BNK',
            'type' => 'I',
            'costcenter' => $this->model_finance->cListCostCenter(array('cbid' => ses_cabang)),
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
    
    public function saveTrans() {
        $main = array(
            'kst_trans' => $this->input->post('trans_trans', TRUE),
            'kst_type' => $this->input->post('trans_type', TRUE),
            'kst_nomer' => strtoupper($this->input->post('trans_docno', TRUE)),
            'kst_noreff' => $this->input->post('trans_noreff', TRUE),
            'kst_tgl' => $this->input->post('trans_tgl', TRUE),
            'kst_coa' => $this->input->post('trans_coa', TRUE),
            'kst_desc' => $this->input->post('trans_desc', TRUE),
            'kst_debit' => numeric($this->input->post('totalTrans', TRUE)),
            'kst_kredit' => numeric($this->input->post('totalTrans', TRUE)),
            'kst_createon' => date('Y-m-d H:i:s'),
            'kst_createby' => ses_krid,
            'kst_cbid' => ses_cabang,
        );
        
        $detail = array(
            'coa' => $this->input->post('dtrans_coa', TRUE),
            'desc' => $this->input->post('dtrans_desc', TRUE),
            'nota' => $this->input->post('dtrans_notaid', TRUE),
            'pelid' => $this->input->post('dtrans_pelid', TRUE),
            'supid' => $this->input->post('dtrans_supid', TRUE),
            'ccid' => $this->input->post('dtrans_ccid', TRUE),
            'nominal' => $this->input->post('dtrans_nominal', TRUE)
        );
        
        $bank = array(
            'bank' => $this->input->post('dbnk_bankid', TRUE),
            'norek' => $this->input->post('dbnk_norek', TRUE),
            'nocek' => $this->input->post('dbnk_nocek', TRUE),
            'jtempo' => $this->input->post('dbnk_jtempo', TRUE),
            'kota' => $this->input->post('dbnk_kotaid', TRUE),
            'nominal' => $this->input->post('dbnk_nominal', TRUE)
        );
        
        $etc = array(
            'purpose' => $this->input->post('trans_purpose', TRUE),
            'kstid' => $this->input->post('trans_id', TRUE)
        );
        
        $save = $this->model_trfinance->addTrans($etc, $main, $detail, $bank);
        if($save['status'] == TRUE){
            $result = array('status' => TRUE, 'msg' => $this->sukses($save['msg']));
        }else{
            $result = array('status' => FALSE, 'msg' => $this->error($save['msg']));
        }
        
        echo json_encode($result);
    }
    
    public function cancelTrans() {
        $id = $this->input->post('id', TRUE);
        if (empty($id)) {
            $hasil = array('status' => true, 'msg' => $this->error('Hapus data gagal'));
        } else {
            if ($this->model_trfinance->cancelTrans($id)) {
                $hasil = array('status' => true, 'msg' => $this->sukses('PEMBATALAN TRANSAKSI BERHASIL'));
            } else {
                $hasil = array('status' => true, 'msg' => $this->error('PEMBATALAN TRANSAKSI GAGAL'));
            }
        }
        echo json_encode($hasil);
    }

   

}

?>
