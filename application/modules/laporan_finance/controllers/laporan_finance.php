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
    
    public function neraca() {
        $this->hakAkses(1051);
        $this->data['etc'] = array(
            'judul' => 'Neraca',
            'targetLoad' => 'neracaShow',
            'groupCabang' => $this->model_lap_finance->getGroupCabang(array('krid' => ses_krid)),
        );
        $this->load->view('neracaForm', $this->data);
    }

    public function neracaShow($output) {
        $bulan = dateToIndo($this->input->post('bulan', TRUE));
        $cbid = $this->input->post('cbid', TRUE);
        $tgl = explode('-', $bulan);
        $month = $tgl['0'];
        $year = $tgl['1'];
        $output = $this->uri->segment(3);
        $this->data['etc'] = array(
            'judul' => 'NERACA',
            'targetLoad' => 'neracaShow',
            'output' => $output,
            'periode' => $bulan
        );
        $this->data['cabang'] = $this->model_lap_finance->getDetailCabang($cbid);
        $this->data['aktiva'] = $this->model_lap_finance->loadNeraca(array(
            'month' => $month,
            'year' => $year,
            'cbid' => $cbid,
            'kategori' => 1
                ));
        $this->data['pasiva'] = $this->model_lap_finance->loadNeraca(array(
            'month' => $month,
            'year' => $year,
            'cbid' => $cbid,
            'kategori' => 3
                ));
        $this->data['modal'] = $this->model_lap_finance->loadNeraca(array(
            'month' => $month,
            'year' => $year,
            'cbid' => $cbid,
            'kategori' => 4
                ));
        $this->load->view('neracaShow', $this->data);
    }
    
    public function lapKwitansi() {
        $this->hakAkses(1051);
        $this->data['etc'] = array(
            'judul' => 'Laporan Agenda Kwitansi',
            'targetLoad' => 'kwitansiShow',
            'groupCabang' => $this->model_lap_finance->getGroupCabang(array('krid' => ses_krid)),
        );
        $this->load->view('kwitansiForm', $this->data);
    }

    public function kwitansiShow($output) {
        $end = dateToIndo($this->input->post('end', TRUE));
        $start = dateToIndo($this->input->post('start', TRUE));
        $cbid = $this->input->post('cbid', TRUE);
        $type = $this->input->post('jenis', TRUE);
        $month = date('m', strtotime($start));
        $year = date('Y', strtotime($start));
        $output = $this->uri->segment(3);
        $this->data['etc'] = array(
            'judul' => 'AGENDA KWITANSI',
            'targetLoad' => 'kwitansiShow',
            'output' => $output,
            'dateFrom' => dateToIndo($start),
            'dateTo' => dateToIndo($end),
            'type' => $type
        );
        $this->data['cabang'] = $this->model_lap_finance->getDetailCabang($cbid);
        $this->data['listData'] = $this->model_lap_finance->agendaKwitansi(array(
            'dateFrom' => $start,
            'dateTo' => $end,
            'cbid' => $cbid,
            'type' => $type
                ));
        $this->load->view('kwitansiShow', $this->data);
    }
    
    public function lapPenyesuaian() {
        $this->hakAkses(1051);
        $this->data['etc'] = array(
            'judul' => 'Laporan Jurnal Penyesuaian',
            'targetLoad' => 'penyesuaianShow',
            'groupCabang' => $this->model_lap_finance->getGroupCabang(array('krid' => ses_krid)),
        );
        $this->load->view('penyesuaianForm', $this->data);
    }

    public function penyesuaianShow($output) {
        $end = dateToIndo($this->input->post('end', TRUE));
        $start = dateToIndo($this->input->post('start', TRUE));
        $cbid = $this->input->post('cbid', TRUE);
        $type = $this->input->post('jenis', TRUE);
        $month = date('m', strtotime($start));
        $year = date('Y', strtotime($start));
        $output = $this->uri->segment(3);
        $this->data['etc'] = array(
            'judul' => 'LAPORAN JURNAL PENYESUAIAN',
            'targetLoad' => 'penyesuaianShow',
            'output' => $output,
            'dateFrom' => dateToIndo($start),
            'dateTo' => dateToIndo($end),
            'type' => $type
        );
        $this->data['cabang'] = $this->model_lap_finance->getDetailCabang($cbid);
        $this->data['listData'] = $this->model_lap_finance->lapPenyesuaian(array(
            'dateFrom' => $start,
            'dateTo' => $end,
            'cbid' => $cbid,
            'type' => $type
                ));
        $this->load->view('penyesuaianShow', $this->data);
    }
    
    public function rkUangmuka() {
        $this->hakAkses(1051);
        $this->data['etc'] = array(
            'judul' => 'Rekap Uangmuka',
            'targetLoad' => 'rkUangmukaShow',
            'groupCabang' => $this->model_lap_finance->getGroupCabang(array('krid' => ses_krid)),
        );
        $this->load->view('rkUangmukaForm', $this->data);
    }

    public function rkUangmukaShow($output) {
        $start = dateToIndo($this->input->post('start', TRUE));
        $end = dateToIndo($this->input->post('end', TRUE));
        $cbid = $this->input->post('cbid', TRUE);
        $coa = $this->input->post('coa', TRUE);
        $this->data['etc'] = array(
            'judul' => 'Rekap Uangmuka',
            'targetLoad' => 'rkUangmukaShow',
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
        $this->data['listData'] = $this->model_lap_finance->rekapUangmuka($param);
        $this->load->view('rkUangmukaShow', $this->data);
    }
    
    public function rugiLaba() {
        $this->hakAkses(1051);
        $this->data['etc'] = array(
            'judul' => 'Rugi Laba',
            'targetLoad' => 'rugilabaShow',
            'groupCabang' => $this->model_lap_finance->getGroupCabang(array('krid' => ses_krid)),
        );
        $this->load->view('rugilabaForm', $this->data);
    }

    public function rugilabaShow($output) {
        $bulan = dateToIndo($this->input->post('bulan', TRUE));
        $cbid = $this->input->post('cbid', TRUE);
        $tgl = explode('-', $bulan);
        $month = $tgl['0'];
        $year = $tgl['1'];
        $output = $this->uri->segment(3);
        $this->data['cabang'] = $this->model_lap_finance->getDetailCabang($cbid);
        log_message('error', 'CEK : '.$this->db->last_query());
        $this->data['etc'] = array(
            'judul' => 'RUGI LABA',
            'targetLoad' => 'rugilabaShow',
            'output' => $output,
            'periode' => $bulan
        );
        $datasubject = array(
            'month' => $month,
            'year' => $year,
            'cbid' => $cbid);
        $datasubject['jenis'] = 'JC15';
        $this->data['penjualan'] = $this->model_lap_finance->loadRugiLaba($datasubject);
        $datasubject['jenis'] = 'JC17';
        $this->data['pendapatan'] = $this->model_lap_finance->loadRugiLaba($datasubject);
        $datasubject['jenis'] = 'JC19';
        $this->data['biayaProduksi'] = $this->model_lap_finance->loadRugiLaba($datasubject);
        $datasubject['jenis'] = 'JC16';
        $this->data['hpp'] = $this->model_lap_finance->loadRugiLaba($datasubject);
        $datasubject['jenis'] = 'JC20';
        $this->data['biayaUsaha'] = $this->model_lap_finance->loadRugiLaba($datasubject);
        $datasubject['jenis'] = 'JC21';
        $this->data['biayaOperasional'] = $this->model_lap_finance->loadRugiLaba($datasubject);
        $datasubject['jenis'] = 'JC22';
        $this->data['biayaNonOperasional'] = $this->model_lap_finance->loadRugiLaba($datasubject);
        $datasubject['jenis'] = 'JC23';
        $this->data['pendapatanLuarUsaha'] = $this->model_lap_finance->loadRugiLaba($datasubject);
        
        
        $this->load->view('rugilabaShow', $this->data);
    }
    

}

?>
