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
        $cbid = $this->input->post('cbid', TRUE);
        $coa = $this->input->post('coa', TRUE);
        $month = date('m', strtotime($start));
        $year = date('Y', strtotime($start));
        $output = $this->uri->segment(3);
        $this->data['etc'] = array(
            'judul' => 'TRANSACTION LEDGER',
            'targetLoad' => 'ledgerShow',
            'output' => $output,
            'dateFrom' => dateToIndo($start),
            'dateTo' => dateToIndo($end),
            'coa' => $coa
        );
        $this->data['cabang'] = $this->model_lap_finance->getDetailCabang($cbid);
        $this->data['listData'] = $this->model_lap_finance->logTrans(array(
            'dateFrom' => $start,
            'dateTo' => $end,
            'cbid' => $cbid,
            'coa' => $coa
                ));
        $this->data['saldoAwal'] = $this->model_lap_finance->getSaldo(array(
            'month' => $month,
            'year' => $year,
            'type' => '1',
            'cbid' => $cbid
                ));
        $this->load->view('ledgerShow', $this->data);
    }

    public function lapKas() {
        $this->hakAkses(1051);
        $this->data['etc'] = array(
            'judul' => 'Laporan Kas',
            'targetLoad' => 'getLapKasir',
            'mainCoa' => $this->model_lap_finance->getMainCoa(array('cbid' => ses_cabang, 'type' => 1)),
            'groupCabang' => $this->model_lap_finance->getGroupCabang(array('krid' => ses_krid)),
        );
        $this->load->view('kasForm', $this->data);
    }

    public function getLapKas($output) {
        $end = dateToIndo($this->input->post('end', TRUE));
        $start = dateToIndo($this->input->post('start', TRUE));
        $cbid = $this->input->post('cbid', TRUE);
        $coa = $this->input->post('coa', TRUE);
        $type = $this->input->post('type', TRUE);
        $this->data['etc'] = array(
            'judul' => 'LAPORAN KAS',
            'output' => $output,
            'dateFrom' => dateToIndo($start),
            'dateTo' => dateToIndo($end),
            'coa' => $coa
        );
        $this->data['cabang'] = $this->model_lap_finance->getDetailCabang($cbid);
        $this->data['listData'] = $this->model_lap_finance->getLapKasir(array(
            'trans' => $trans,
            'type' => $type,
            'dateFrom' => $start,
            'dateTo' => $end,
            'cbid' => $cbid,
            'coa' => $coa
                ));
        $this->load->view('kasShow', $this->data);
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

    public function rkPiutang() {
        $this->hakAkses(1051);
        $this->data['etc'] = array(
            'judul' => 'Rekap Piutang',
            'targetLoad' => 'rkPiutangShow',
            'groupCabang' => $this->model_lap_finance->getGroupCabang(array('krid' => ses_krid)),
        );
        $this->load->view('rkPiutangForm', $this->data);
    }

    public function rkPiutangShow($output) {
        $start = dateToIndo($this->input->post('start', TRUE));
        $end = dateToIndo($this->input->post('end', TRUE));
        $cbid = $this->input->post('cbid', TRUE);
        $coa = $this->input->post('coa', TRUE);
        $this->data['etc'] = array(
            'judul' => 'Rekap Piutang',
            'targetLoad' => 'rkPiutangShow',
            'output' => $output,
            'dateFrom' => dateToIndo($start),
            'dateTo' => dateToIndo($end),
            'coa' => $coa );
        $this->data['cabang'] = $this->model_lap_finance->getDetailCabang($cbid);
        $param = array(
            'dateFrom' => $start,
            'dateTo' => $end,
            'cbid' => $cbid,
            'coa' => $coa);
        $this->data['listData'] = $this->model_lap_finance->rekapPiutang($param);
        $this->load->view('rkPiutangShow', $this->data);
    }

    public function rkHutang() {
        $this->hakAkses(1051);
        $this->data['etc'] = array(
            'judul' => 'Rekap Hutang',
            'targetLoad' => 'rkPiutangShow',
            'groupCabang' => $this->model_lap_finance->getGroupCabang(array('krid' => ses_krid)),
        );
        $this->load->view('rkPiutangForm', $this->data);
    }

    public function rkHutangShow($output) {
        $start = dateToIndo($this->input->post('start', TRUE));
        $end = dateToIndo($this->input->post('end', TRUE));
        $cbid = $this->input->post('cbid', TRUE);
        $dept = $this->input->post('dept', TRUE);
        $this->data['etc'] = array(
            'judul' => 'Rekap Piutang',
            'targetLoad' => 'rkPiutangShow',
            'output' => $output,
            'dateFrom' => dateToIndo($start),
            'dateTo' => dateToIndo($end),
            'dept' => $dept
        );
        $this->data['cabang'] = $this->model_lap_finance->getDetailCabang($cbid);
        if ($dept == '1') {
            $this->data['listData'] = $this->model_lap_finance->rekapPiutangUnit(array(
                'dateFrom' => $start,
                'dateTo' => $end,
                'cbid' => $cbid,
                'type' => 1,
                'coa' => PIUTANG_UNIT
                    ));
        } else {
            $this->data['listData'] = $this->model_lap_finance->rekapPiutangUnit(array(
                'dateFrom' => $start,
                'dateTo' => $end,
                'cbid' => $cbid,
                'coa' => PIUTANG_SERVICE
                    ));
        }
        $this->load->view('rkPiutangShow', $this->data);
    }

}

?>
