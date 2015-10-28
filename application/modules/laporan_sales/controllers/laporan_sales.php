<?php

/**
 * Class Laporan Finance
 * @author Rossi Erl
 * 2015-09-04
 */
class Laporan_Sales extends Application {

    public function __construct() {
        parent::__construct();
        $this->load->model(array(
            'model_lap_sales'
        ));
        $this->isLogin();
    }

    public function index() {
        echo "ARE YOU LOST ? ";
    }

    /**
     * 
     */
    function masukKendaraan() {
        $this->hakAkses(101);
        $this->data['link'] = 'showMasukKendaraan';
        $this->load->view('salesForm', $this->data);
    }

    function spk() {
        $this->hakAkses(102);
        $this->data['link'] = 'showSpk';
        $this->load->view('salesForm', $this->data);
    }

    function fakturPenjualan() {
        $this->hakAkses(103);
        $this->data['link'] = 'showFakturPenjualan';
        $this->load->view('salesForm', $this->data);
    }

    function returJual() {
        $this->hakAkses(104);
        $this->data['link'] = 'showReturJual';
        $this->load->view('salesForm', $this->data);
    }

    function returBeli() {
        $this->hakAkses(105);
        $this->data['link'] = 'showReturBeli';
        $this->load->view('salesForm', $this->data);
    }

    function penjualanPerSales() {
        $this->hakAkses(106);
        $this->data['link'] = 'showPenjualanPerSales';
        $this->load->view('salesForm', $this->data);
    }

    function produktifitasSales() {
        $this->hakAkses(107);
        $this->data['link'] = 'showProduktifitasSales';
        $this->load->view('salesForm', $this->data);
    }

    function mutasiKendaraan() {
        $this->hakAkses(108);
        $this->data['link'] = 'showMutasiKendaraan';
        $this->load->view('salesForm', $this->data);
    }

    function stockReady() {
        $this->hakAkses(109);
        $this->data['link'] = 'showStockReady';
        $this->load->view('salesForm', $this->data);
    }

    function posisiStock() {
        $this->hakAkses(110);
        $this->data['link'] = 'showPosisiStock';
        $this->load->view('salesForm', $this->data);
    }

    /**
     * 
     * @param type $output
     */
    public function showMasukKendaraan($output) {
        $end = dateToIndo($this->input->post('end'));
        $start = dateToIndo($this->input->post('start'));
        $cabang = ses_cabang;
        $this->data['data'] = $this->model_lap_sales->getMasukKendaran($start, $end, $cabang);
        $this->data['output'] = $output;
        $this->load->view('showMasukKendaraan', $this->data);
    }

}

?>
