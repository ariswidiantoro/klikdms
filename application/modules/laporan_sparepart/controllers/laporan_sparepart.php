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

    /**
     * 
     */
    public function returPembelian() {
        $this->hakAkses(67);
        $this->data['link'] = 'showReturPembelian';
        $this->load->view('returPembelian', $this->data);
    }

    /**
     * 
     */
    public function kartuStock() {
        $this->hakAkses(68);
        $this->data['link'] = 'showKartuStock';
        $this->load->view('kartuStock', $this->data);
    }
    public function supplyOutstanding() {
        $this->hakAkses(112);
        $this->data['link'] = 'showSupplyOutstanding';
        $this->load->view('supplyOutstanding', $this->data);
    }

    /**
     * 
     */
    public function posisiStock() {
        $this->hakAkses(69);
        $this->data['link'] = 'showPosisiStock';
        $this->load->view('posisiStock', $this->data);
    }

    /**
     * 
     */
    public function adjustmentStock() {
        $this->hakAkses(111);
        $this->data['link'] = 'showAdjustmentStock';
        $this->load->view('adjustmentStock', $this->data);
    }

    public function supplySlip() {
        $this->hakAkses(72);
        $this->data['link'] = 'showSupplySlip';
        $this->load->view('supplySlip', $this->data);
    }

    public function agingStockSparepart() {
        $this->hakAkses(78);
        $this->data['link'] = 'showAgingStockSparepart';
        $this->load->view('agingStockSparepart', $this->data);
    }

    public function fakturSparepart() {
        $this->hakAkses(73);
        $this->data['link'] = 'showFakturSparepart';
        $this->load->view('penerimaanBarang', $this->data);
    }

    public function fakturByPelanggan() {
        $this->hakAkses(75);
        $this->data['link'] = 'showFakturByPelanggan';
        $this->load->view('fakturByPelanggan', $this->data);
    }

    public function fakturBySparepart() {
        $this->hakAkses(76);
        $this->data['link'] = 'showFakturBySparepart';
        $this->load->view('fakturBySparepart', $this->data);
    }

    public function pembelianByPart() {
        $this->hakAkses(77);
        $this->data['link'] = 'showPembelianByPart';
        $this->load->view('pembelianByPart', $this->data);
    }

    public function detailKomposisiStock($start, $end, $cbid, $type, $status) {
        $this->data['start'] = $start;
        $this->data['end'] = $end;
        $this->data['cbid'] = $cbid;
        $this->data['type'] = $type;
        $this->data['output'] = $status;
        $this->data['data'] = $this->model_lap_sparepart->getDetailKomposisiStock($start, $end, $cbid, $type);
        $this->load->view('detailKomposisiStock', $this->data);
    }

    /**
     * 
     */
    public function returPenjualan() {
        $this->hakAkses(74);
        $this->data['link'] = 'showReturPenjualan';
        $this->load->view('penerimaanBarang', $this->data);
    }

    /**
     * 
     * @param type $output
     */
    public function showPenerimaanBarang($output) {
        $end = dateToIndo($this->input->post('end'));
        $start = dateToIndo($this->input->post('start'));
        $cabang = ses_cabang;
        $this->data['data'] = $this->model_lap_sparepart->getPenerimaanBarang($start, $end, $cabang);
        $this->data['output'] = $output;
        $this->load->view('showPenerimaanBarang', $this->data);
    }

    /**
     * 
     * @param type $output
     */
    public function showAdjustmentStock($output) {
        $end = dateToIndo($this->input->post('end'));
        $start = dateToIndo($this->input->post('start'));
        $cabang = ses_cabang;
        $this->data['data'] = $this->model_lap_sparepart->getAdjustmentStock($start, $end, $cabang);
        $this->data['output'] = $output;
        $this->load->view('showAdjustmentStock', $this->data);
    }

    /**
     * 
     * @param type $output
     */
    public function showReturPenjualan($output) {
        $end = dateToIndo($this->input->post('end'));
        $start = dateToIndo($this->input->post('start'));
        $cabang = ses_cabang;
        $this->data['data'] = $this->model_lap_sparepart->getReturPenjualan($start, $end, $cabang);
        $this->data['output'] = $output;
        $this->load->view('showReturPenjualan', $this->data);
    }

    /**
     * 
     * @param type $output
     */
    public function showFakturSparepart($output) {
        $end = dateToIndo($this->input->post('end'));
        $start = dateToIndo($this->input->post('start'));
        $cabang = ses_cabang;
        $this->data['data'] = $this->model_lap_sparepart->getFakturSparepart($start, $end, $cabang);
        $this->data['output'] = $output;
        $this->load->view('showFakturSparepart', $this->data);
    }

    public function showFakturByPelanggan($output) {
        $end = dateToIndo($this->input->post('end'));
        $start = dateToIndo($this->input->post('start'));
        $nama = $this->input->post('pelNama');
        $pelid = '';
        if (!empty($nama)) {
            $pelid = $this->input->post('pelid');
        }
        $kategory = $this->input->post('kategory');
        $cabang = ses_cabang;
        $this->data['output'] = $output;

        if ($kategory == 'detail') {
            $this->data['data'] = $this->model_lap_sparepart->getFakturByPelanggan($start, $end, $cabang, $pelid);
            $this->load->view('showFakturByPelangganDetail', $this->data);
        } else {
            $this->data['data'] = $this->model_lap_sparepart->getFakturByPelangganTotal($start, $end, $cabang, $pelid);
            $this->load->view('showFakturByPelangganTotal', $this->data);
        }
    }

    public function showFakturBySparepart($output) {
        $end = dateToIndo($this->input->post('end'));
        $start = dateToIndo($this->input->post('start'));
        $kodeBarang = $this->input->post('kodeBarang');
        $kategory = $this->input->post('kategory');
        $cabang = ses_cabang;
        $this->data['output'] = $output;
        if ($kategory == 'detail') {
            $this->data['data'] = $this->model_lap_sparepart->getFakturBySparepart($start, $end, $cabang, $kodeBarang);
            $this->load->view('showFakturBySparepartDetail', $this->data);
        } else {
            $this->data['data'] = $this->model_lap_sparepart->getFakturBySparepartTotal($start, $end, $cabang, $kodeBarang);
            $this->load->view('showFakturBySparepartTotal', $this->data);
        }
    }

    /**
     * 
     * @param type $output
     */
    public function showPembelianByPart($output) {
        $end = dateToIndo($this->input->post('end'));
        $start = dateToIndo($this->input->post('start'));
        $kodeBarang = $this->input->post('kodeBarang');
        $kategory = $this->input->post('kategory');
        $cabang = ses_cabang;
        $this->data['output'] = $output;
        if ($kategory == 'detail') {
            $this->data['data'] = $this->model_lap_sparepart->getPembelianBySparepart($start, $end, $cabang, $kodeBarang);
            $this->load->view('showPembelianBySparepartDetail', $this->data);
        } else {
            $this->data['data'] = $this->model_lap_sparepart->getPembelianBySparepartTotal($start, $end, $cabang, $kodeBarang);
            $this->load->view('showPembelianBySparepartTotal', $this->data);
        }
    }

    /**
     * 
     * @param type $output
     */
    public function showSupplySlip($output) {
        $end = dateToIndo($this->input->post('end'));
        $start = dateToIndo($this->input->post('start'));
        $kategory = $this->input->post('kategory');
        $jenis = $this->input->post('jenis');
        $cabang = ses_cabang;
        $this->data['output'] = $output;
        if ($kategory == 'rekap') {
            $this->data['data'] = $this->model_lap_sparepart->getSupplySlipRekap($start, $end, $cabang, $jenis);
            $this->load->view('showSupplySlipRekap', $this->data);
        } else {
            $this->data['data'] = $this->model_lap_sparepart->getSupplySlipDetail($start, $end, $cabang, $jenis);
            $this->load->view('showSupplySlipDetail', $this->data);
        }
    }

    /**
     * 
     * @param type $output
     */
    public function showReturPembelian($output) {
        $end = dateToIndo($this->input->post('end'));
        $start = dateToIndo($this->input->post('start'));
        $cabang = ses_cabang;
        $this->data['data'] = $this->model_lap_sparepart->getReturPembelian($start, $end, $cabang);
        $this->data['output'] = $output;
        $this->load->view('showReturPembelian', $this->data);
    }

    /**
     * 
     * @param type $output
     */
    public function showKartuStock($output) {
        $end = dateToIndo($this->input->post('end'));
        $start = dateToIndo($this->input->post('start'));
        $kodeBarang = $this->input->post('kodeBarang');
        $cabang = ses_cabang;
        $this->data['data'] = $this->model_lap_sparepart->getKartuStock($start, $end, $cabang, $kodeBarang);
        $this->data['output'] = $output;
        $this->load->view('showKartuStock', $this->data);
    }

    /**
     * 
     * @param type $output
     */
    public function showPosisiStock($output) {
        $start = dateToIndo($this->input->post('start'));
        $kodeBarang = $this->input->post('kodeBarang');
        $type = $this->input->post('type');
        $cabang = ses_cabang;
        $this->data['data'] = $this->model_lap_sparepart->getPosisiStock($start, $cabang, $kodeBarang, $type);
        $this->data['output'] = $output;
        $this->load->view('showPosisiStock', $this->data);
    }
    
    /**
     * 
     * @param type $output
     */
    public function showSupplyOutstanding($output) {
        $start = dateToIndo($this->input->post('start'));
        $type = $this->input->post('type');
        $cabang = ses_cabang;
        $this->data['data'] = $this->model_lap_sparepart->getSupplyOutstanding($start, $cabang, $type);
        $this->data['output'] = $output;
        $this->load->view('showSupplyOutstanding', $this->data);
    }

    /**
     * 
     * @param type $output
     */
    public function showAgingStockSparepart($output) {
        $end = dateToIndo($this->input->post('end'));
        $start = dateToIndo($this->input->post('start'));
        $cabang = ses_cabang;
        $this->data['start'] = $start;
        $this->data['end'] = $end;
        $this->data['cabang'] = $cabang;
        $datesa = date("Y-m-d", mktime(0, 0, 0, date("m", strtotime($start)), date("d", strtotime($start)) - 1, date("Y", strtotime($start))));
        $this->data['sa'] = $this->model_lap_sparepart->getRekapPosisiStock($datesa, $cabang, '', '');
        $this->data['beli'] = $this->model_lap_sparepart->getTotalPembelian($start, $end, $cabang);
        $this->data['jual'] = $this->model_lap_sparepart->getTotalPenjualanSupply($start, $end, $cabang);
        $this->data['adj'] = $this->model_lap_sparepart->getTotalAdjustmentStock($start, $end, $cabang);
        $this->data['returJual'] = $this->model_lap_sparepart->getTotalReturPenjualan($start, $end, $cabang);
        $this->data['returBeli'] = $this->model_lap_sparepart->getTotalReturPembelian($start, $end, $cabang);
        $this->data['moving'] = $this->model_lap_sparepart->getMovingPart2($start, $end, $cabang);
        $this->data['output'] = $output;
        $this->load->view('showAgingStockSparepart', $this->data);
    }

}

?>
