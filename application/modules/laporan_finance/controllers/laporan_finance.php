<?php
/**
 * Class Laporan Finance
 * @author Rossi Erl
 * 2015-09-04
 */
class Laporan_Finance extends Application {

    public function __construct() {
        parent::__construct();
        $this->load->model(array(
            'model_admin', 
            'model_sales', 
            'model_finance', 
            'model_trfinance',
            'model_lap_finance'
            ));
        $this->isLogin();
    }

    public function index() {
        echo "ARE YOU LOST ? ";
    }

    public function transLedger() {
        $this->hakAkses(1051);
        $this->data['etc'] = array(
            'judul' => 'Transaction Ledger',
            'targetLoad' => 'getTransLedger',
            'groupCabang' => $this->model_lap_finance->getGroupCabang(array('krid' => ses_krid)),
        );
        $this->load->view('ledgerForm', $this->data);
    }

    public function getTransLedger() {
        $query = $this->model_finance->getDataTrans($data);
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
    
     public function lapKas() {
        $this->hakAkses(1051);
        $this->data['etc'] = array(
            'judul' => 'Laporan Kas',
            'targetLoad' => 'getLapKas',
            'groupCabang' => $this->model_lap_finance->getGroupCabang(array('krid' => ses_krid)),
        );
        $this->load->view('kasirForm', $this->data);
    }
    
    public function lapBank() {
        $this->hakAkses(1051);
        $this->data['etc'] = array(
            'judul' => 'Laporan Kas',
            'targetLoad' => 'getLapKas',
            'groupCabang' => $this->model_lap_finance->getGroupCabang(array('krid' => ses_krid)),
        );
        $this->load->view('kasirForm', $this->data);
    }

}

?>
