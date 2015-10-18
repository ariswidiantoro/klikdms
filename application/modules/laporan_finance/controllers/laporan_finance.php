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
            'targetLoad' => 'ledgerShow',
            'groupCabang' => $this->model_lap_finance->getGroupCabang(array('krid' => ses_krid)),
        );
        $this->load->view('ledgerForm', $this->data);
    }

    public function ledgerShow($output) {
        $end = dateToIndo($this->input->post('end', TRUE));
        $start = dateToIndo($this->input->post('start', TRUE));
        $this->data['etc'] = array(
            'judul' => 'Transaction Ledger',
            'targetLoad' => 'ledgerShow',
            'data' => $this->model_lap_finance->getLedger(array(
                'dateFrom' => $start,
                'dateTo' => $end,
                'cbid' => $cabang
            )),
            'output' => $output
        );
        $this->load->view('ledgerShow', $this->data);
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
