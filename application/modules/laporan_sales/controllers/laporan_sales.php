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
        $this->load->view('penjualanPerSalesForm', $this->data);
    }

    function produktifitasSales() {
        $this->hakAkses(107);
        $this->data['link'] = 'showProduktifitasSales';
        $this->data['merk'] = $this->model_admin->getMerk();
        $this->load->view('produktifitasSalesForm', $this->data);
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

    /**
     * 
     * @param type $output
     */
    public function showSpk($output) {
        $end = dateToIndo($this->input->post('end'));
        $start = dateToIndo($this->input->post('start'));
        $cabang = ses_cabang;
        $this->data['data'] = $this->model_lap_sales->getSpk($start, $end, $cabang);
        $this->data['output'] = $output;
        $this->load->view('showSpk', $this->data);
    }

    /**
     * 
     * @param type $output
     */
    public function showPenjualanPerSales($output) {
        $start = dateToIndo($this->input->post('start'));
        $cabang = ses_cabang;
        $this->data['data'] = $this->model_lap_sales->getPenjualanPerSales($start, $cabang);
        $this->data['output'] = $output;
        $this->load->view('showPenjualanPerSales', $this->data);
    }

    /**
     * 
     * @param type $output
     */
    public function showProduktifitasSales($output) {
        $this->load->model('model_service');
        $tahun = $this->input->post('tahun');
        $bulan = $this->input->post('bulan');
        $merk = $this->input->post('merkid');
        $cabang = ses_cabang;
        $this->data['model'] = $this->model_service->getModelByMerk($merk);
        $this->data['data'] = $this->model_lap_sales->getProduktifitasSales($tahun, $bulan, $cabang);
        $this->data['output'] = $output;
        $this->load->view('showProduktifitasSales', $this->data);
    }

    /**
     * 
     * @param type $output
     */
    public function showReturJual($output) {
        $end = dateToIndo($this->input->post('end'));
        $start = dateToIndo($this->input->post('start'));
        $cabang = ses_cabang;
        $this->data['data'] = $this->model_lap_sales->getReturJual($start, $end, $cabang);
        $this->data['output'] = $output;
        $this->load->view('showReturJual', $this->data);
    }

    /**
     * 
     * @param type $output
     */
    public function showReturBeli($output) {
        $end = dateToIndo($this->input->post('end'));
        $start = dateToIndo($this->input->post('start'));
        $cabang = ses_cabang;
        $this->data['data'] = $this->model_lap_sales->getReturBeli($start, $end, $cabang);
        $this->data['output'] = $output;
        $this->load->view('showReturBeli', $this->data);
    }

    /**
     * 
     * @param type $output
     */
    public function showFakturPenjualan($output) {
        $end = dateToIndo($this->input->post('end'));
        $start = dateToIndo($this->input->post('start'));
        $cabang = ses_cabang;
        $this->data['data'] = $this->model_lap_sales->getFakturPenjualan($start, $end, $cabang);
        $this->data['output'] = $output;
        $this->load->view('showFakturPenjualan', $this->data);
    }

}

?>
