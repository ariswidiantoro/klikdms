<?php

/**
 * Class Admin_Controller
 * @author Aris
 * 2013-11-11
 */
class Laporan_Sparepart extends Application {

    /**
     * The new Admin_controller
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('model_lap_sparepart');
        $this->isLogin();
    }

    public function index() {
        $this->data['content'] = 'service';
        $this->data['menuid'] = '3';
        $this->load->view('template', $this->data);
    }

    /**
     * This function is used for display menu form
     * @author Aris
     * @since 1.0
     */
    public function penerimaanBarang() {
        $this->hakAkses(66);
        $this->data['link'] = 'showPenerimaanBarang';
        $this->load->view('penerimaanBarang', $this->data);
    }

    public function returPembelian() {
        $this->hakAkses(67);
        $this->data['link'] = 'showReturPembelian';
        $this->load->view('returPembelian', $this->data);
    }

    public function kartuStock() {
        $this->hakAkses(68);
        $this->data['link'] = 'showKartuStock';
        $this->load->view('kartuStock', $this->data);
    }

    public function showPenerimaanBarang($output) {
        $end = dateToIndo($this->input->post('end'));
        $start = dateToIndo($this->input->post('start'));
        $cabang = ses_cabang;
        $this->data['data'] = $this->model_lap_sparepart->getPenerimaanBarang($start, $end, $cabang);
        $this->data['output'] = $output;
        $this->load->view('showPenerimaanBarang', $this->data);
    }

    public function showReturPembelian($output) {
        $end = dateToIndo($this->input->post('end'));
        $start = dateToIndo($this->input->post('start'));
        $cabang = ses_cabang;
        $this->data['data'] = $this->model_lap_sparepart->getReturPembelian($start, $end, $cabang);
        $this->data['output'] = $output;
        $this->load->view('showReturPembelian', $this->data);
    }

}

?>
