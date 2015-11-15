<?php

/**
 * Class Admin_Controller
 * @author Rossi
 * 2013-11-11
 */
class Transaksi_Sparepart extends Application {

    /**
     * The new Admin_controller
     */
    public function __construct() {
        parent::__construct();
        $this->load->model(array('model_trspart', 'model_trfinance', 'model_finance'));
    }

    public function index() {
//        $this->addProspect();
    }

    public function penerimaanBarang() {
        $this->hakAkses(57);
        $this->load->view('penerimaanBarang', $this->data);
    }

    public function returPenjualan() {
        $this->hakAkses(61);
        $this->load->view('returPenjualan', $this->data);
    }

    public function claimBarang() {
        $this->hakAkses(63);
        $this->load->view('claimBarang', $this->data);
    }

    public function fakturSparepart() {
        $this->hakAkses(60);
        $this->data['salesman'] = $this->model_admin->getKaryawanByJabatan(JAB_SPAREPART_SALESMAN);
        $this->load->view('fakturSparepart', $this->data);
    }

    public function adjustmentStock() {
        $this->hakAkses(62);
        $this->load->view('adjustmentStock', $this->data);
    }

    function jsonFakturTerima() {
        $faktur = strtoupper($this->input->post('param'));
        echo json_encode($this->model_trspart->getFakturTerimaAutoComplete($faktur));
    }

    function cekFakturTrbr() {
        $param = strtoupper($this->input->post('param'));
        echo json_encode($this->model_trspart->cekFakturTrbr($param));
    }

    function jsonFakturJual() {
        $faktur = strtoupper($this->input->post('param'));
        echo json_encode($this->model_trspart->getFakturJualAutoComplete($faktur));
    }

    /**
     * 
     */
    function jsonSupplyPartShop() {
        $supply = trim(strtoupper($this->input->post('param')));
        echo json_encode($this->model_trspart->getSupplyAutoComplete($supply));
    }

    /**
     * 
     */
    function getDataSupplyPartShop() {
        $supply = trim(strtoupper($this->input->post('param')));
        $data = $this->model_trspart->getDataSupplyPartShop($supply);
        echo json_encode($data);
    }

    public function returPembelian() {
        $this->hakAkses(58);
        $this->load->view('returPembelian', $this->data);
    }

    public function supplySlip() {
        $this->hakAkses(59);
        $this->load->view('supplySlip', $this->data);
    }

    function savePenerimaanBarang() {
        $return = false;
        $this->form_validation->set_rules('trbr_faktur', '<b>Fx</b>', 'required|callback_validtelp|xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $term = $this->input->post('trbr_kredit_term');
            if (empty($term)) {
                $term = 0;
            }
            $data = array(
                'trbr_tgl' => date('Y-m-d'),
                'trbr_createon' => date('Y-m-d H:i:s'),
                'trbr_createby' => ses_username,
                'trbr_faktur' => trim(strtoupper($this->input->post('trbr_faktur'))),
                'trbr_supid' => $this->input->post('trbr_supid'),
                'trbr_total' => numeric($this->input->post('trbr_total')),
                'trbr_pay_method' => $this->input->post('trbr_pay_method'),
                'trbr_inc_pajak' => $this->input->post('trbr_inc_pajak'),
                'trbr_kredit_term' => $term,
                'trbr_cbid' => ses_cabang,
            );
            $dtr_inveid = $this->input->post('dtr_inveid');
            $dtr_inve_kode = $this->input->post('dtr_inve_kode');
            $dtr_qty = $this->input->post('dtr_qty');
            $dtr_harga = $this->input->post('dtr_harga');
            $dtr_diskon = $this->input->post('dtr_diskon');
            $dtr_subtotal = $this->input->post('dtr_subtotal');
            // get array spare part from table 
            $detail = array();
            for ($i = 0; $i < count($dtr_inveid); $i++) {
                $detail[] = array(
                    'dtr_inveid' => $dtr_inveid[$i],
                    'dtr_inve_kode' => $dtr_inve_kode[$i],
                    'dtr_qty' => $dtr_qty[$i],
                    'dtr_harga' => numeric($dtr_harga[$i]),
                    'dtr_diskon' => $dtr_diskon[$i],
                    'dtr_subtotal' => numeric($dtr_subtotal[$i]),
                );
            }
            $return = $this->model_trspart->savePenerimaanBarang($data, $detail);
        }
        echo json_encode($return);
    }

    function saveSupplySlip() {
        $return = false;
        $this->form_validation->set_rules('spp_pelid', '<b>Fx</b>', 'required|callback_validtelp|xss_clean');
        $this->form_validation->set_rules('spp_total', '<b>Fx</b>', 'required|callback_validtelp|xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $term = $this->input->post('spp_kredit_term');
            if (empty($term)) {
                $term = 0;
            }
            $jenis = $this->input->post('spp_jenis');
            $cetakHarga = 0;
            if ($this->input->post('spp_cetak_harga') == '1') {
                $cetakHarga = 1;
            }
            $data = array(
                'spp_tgl' => date('Y-m-d'),
                'spp_createon' => date('Y-m-d H:i:s'),
                'spp_createby' => ses_username,
                'spp_pelid' => $this->input->post('spp_pelid'),
                'spp_woid' => $this->input->post('spp_woid'),
                'spp_cetak_harga' => $cetakHarga,
                'spp_pay_method' => $this->input->post('spp_pay_method'),
                'spp_kredit_term' => $term,
                'spp_jenis' => $jenis,
                'spp_print' => 1,
                'spp_total' => numeric($this->input->post('spp_total')),
                'spp_cbid' => ses_cabang,
            );
            if ($jenis != 'ps') {
                $data['spp_woid'] = $this->input->post('spp_woid');
            }
            if ($jenis != 'so') {
                $dsupp_inveid = $this->input->post('dsupp_inveid');
                $dsupp_qty = $this->input->post('dsupp_qty');
                $dsupp_harga = $this->input->post('dsupp_harga');
                $dsupp_hpp = $this->input->post('dsupp_hpp');
                $dsupp_diskon = $this->input->post('dsupp_diskon');
                $dsupp_subtotal = $this->input->post('dsupp_subtotal');
                // get array spare part from table 
                $detail = array();
                $totalHpp = 0;
                for ($i = 0; $i < count($dsupp_inveid); $i++) {
                    $subTotalHpp = numeric($dsupp_hpp[$i] * $dsupp_qty[$i]);
                    $totalHpp += $subTotalHpp;
                    $detail[] = array(
                        'dsupp_inveid' => $dsupp_inveid[$i],
                        'dsupp_qty' => $dsupp_qty[$i],
                        'dsupp_hpp' => $dsupp_hpp[$i],
                        'dsupp_harga' => numeric($dsupp_harga[$i]),
                        'dsupp_diskon' => $dsupp_diskon[$i],
                        'dsupp_subtotal' => numeric($dsupp_subtotal[$i]),
                        'dsupp_subtotal_hpp' => $subTotalHpp,
                    );
                }
                $data['spp_total_hpp'] = $totalHpp;
                $return = $this->model_trspart->saveSupplySlip($data, $detail);
            } else {
                $deskripsi = $this->input->post('so_deskripsi');
                $harga = $this->input->post('so_harga');
                $hpp = $this->input->post('so_hpp');
                $totalHpp = 0;
                $total = 0;
                for ($i = 0; $i < count($deskripsi); $i++) {
                    if (!empty($deskripsi[$i])) {
                        $detail[] = array(
                            'so_deskripsi' => strtoupper($deskripsi[$i]),
                            'so_harga' => numeric($harga[$i]),
                            'so_hpp' => numeric($hpp[$i]),
                        );
                    }
                    $totalHpp += numeric($hpp[$i]);
                    $total += numeric($harga[$i]);
                }
                $data['spp_total_hpp'] = $totalHpp;
                $data['spp_total'] = $total;
                $return = $this->model_trspart->saveSupplySlip($data, $detail);
            }
        }
        echo json_encode($return);
    }

    function saveReturPembelian() {
        $return = false;
        $this->form_validation->set_rules('trbr_faktur', '<b>Fx</b>', 'required|callback_validtelp|xss_clean');
        $this->form_validation->set_rules('supplier', '<b>Fx</b>', 'required|callback_validtelp|xss_clean');
        $this->form_validation->set_rules('trbr_supid', '<b>Fx</b>', 'required|callback_validtelp|xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'rb_tgl' => date('Y-m-d'),
                'rb_createon' => date('Y-m-d H:i:s'),
                'rb_createby' => ses_username,
                'rb_trbrid' => $this->input->post('trbrid'),
                'rb_total' => numeric($this->input->post('trbr_total')),
                'rb_alasan' => $this->input->post('rb_alasan'),
                'rb_cbid' => ses_cabang,
            );
            $dtr_inveid = $this->input->post('dtr_inveid');
            $dtr_inve_kode = $this->input->post('dtr_inve_kode');
            $dtr_qty = $this->input->post('dtr_qty');
            $dtr_harga = $this->input->post('dtr_harga');
            $dtr_diskon = $this->input->post('dtr_diskon');
            $dtr_subtotal = $this->input->post('dtr_subtotal');
            // get array spare part from table 
            $detail = array();
            for ($i = 0; $i < count($dtr_inveid); $i++) {
                $detail[] = array(
                    'detb_inveid' => $dtr_inveid[$i],
                    'detb_inve_kode' => $dtr_inve_kode[$i],
                    'detb_qty' => $dtr_qty[$i],
                    'detb_harga' => numeric($dtr_harga[$i]),
                    'detb_diskon' => $dtr_diskon[$i],
                    'detb_subtotal' => numeric($dtr_subtotal[$i]),
                );
            }
            $return = $this->model_trspart->saveReturPembelian($data, $detail);
        } else {
            $return['result'] = false;
            $return['msg'] = $this->error("Nomer Faktur Tidak Valid");
        }
        echo json_encode($return);
    }

    function saveReturPenjualan() {
        $return = false;
        $this->form_validation->set_rules('not_nomer', '<b>Fx</b>', 'required|callback_validtelp|xss_clean');
        $this->form_validation->set_rules('pelid', '<b>Fx</b>', 'required|callback_validtelp|xss_clean');
        $this->form_validation->set_rules('notid', '<b>Fx</b>', 'required|callback_validtelp|xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'rj_tgl' => date('Y-m-d'),
                'rj_createon' => date('Y-m-d H:i:s'),
                'rj_createby' => ses_username,
                'rj_notid' => $this->input->post('notid'),
                'rj_total' => numeric($this->input->post('grand_total')),
                'rj_alasan' => $this->input->post('rj_alasan'),
                'rj_cbid' => ses_cabang,
            );
            $det_inveid = $this->input->post('dsupp_inveid');
            $det_qty = $this->input->post('dsupp_qty');
            $det_harga = $this->input->post('dsupp_harga');
            $det_hpp = $this->input->post('dsupp_hpp');
            $det_diskon = $this->input->post('dsupp_diskon');
            $det_subtotal = $this->input->post('dsupp_subtotal');
            // get array spare part from table 
            $detail = array();
            $hpp = 0;
            for ($i = 0; $i < count($det_inveid); $i++) {
                $detail[] = array(
                    'det_inveid' => $det_inveid[$i],
                    'det_qty' => $det_qty[$i],
                    'det_harga' => numeric($det_harga[$i]),
                    'det_diskon' => $det_diskon[$i],
                    'det_hpp' => $det_hpp[$i],
                    'det_subtotal' => numeric($det_subtotal[$i]),
                    'det_subtotal_hpp' => numeric(numeric($det_hpp[$i]) * $det_qty[$i]),
                );
                $hpp += (numeric($det_hpp[$i]) * $det_qty[$i]);
            }
            $data['rj_total_hpp'] = $hpp;
            $return = $this->model_trspart->saveReturPenjualan($data, $detail, $this->input->post('sppid'));
        } else {
            $return['result'] = false;
            $return['msg'] = $this->error("Nomer Faktur Tidak Valid");
        }
        echo json_encode($return);
    }

    function saveAdjustmentStock() {
        $return = false;
        $this->form_validation->set_rules('adj_nomer', '<b>Fx</b>', 'required|callback_validtelp|xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'adj_tgl' => date('Y-m-d'),
                'adj_createon' => date('Y-m-d H:i:s'),
                'adj_createby' => ses_username,
                'adj_nomer' => trim(strtoupper($this->input->post('adj_nomer'))),
                'adj_cbid' => ses_cabang,
            );
            $dadj_inveid = $this->input->post('dadj_inveid');
            $dadj_hpp = $this->input->post('dadj_hpp');
            $dadj_subtotal_hpp = $this->input->post('dadj_subtotal_hpp');
            $dadj_plus = $this->input->post('dadj_plus');
            $dadj_minus = $this->input->post('dadj_minus');
            // get array spare part from table 
            $detail = array();
            for ($i = 0; $i < count($dadj_inveid); $i++) {
                $min = empty($dadj_minus[$i]) ? 0 : $dadj_minus[$i];
                $hpp = numeric($dadj_hpp[$i]);
                $subTotal = numeric($dadj_subtotal_hpp[$i]);
                if ($min > 0) {
                    $hpp *= -1;
                    $subTotal *= -1;
                }
                $detail[] = array(
                    'dadj_inveid' => $dadj_inveid[$i],
                    'dadj_plus' => empty($dadj_plus[$i]) ? 0 : $dadj_plus[$i],
                    'dadj_minus' => $min,
                    'dadj_hpp' => $hpp,
                    'dadj_subtotal_hpp' => $subTotal,
                );
            }
            $return = $this->model_trspart->saveAdjustmentStock($data, $detail);
        } else {
            $return['result'] = false;
            $return['msg'] = $this->error("Nomer Faktur Tidak Valid");
        }
        echo json_encode($return);
    }

    function saveFakturSparepart() {
        $return = array();
        $this->form_validation->set_rules('not_sppid', '<b>Fx</b>', 'required|callback_validtelp|xss_clean');
        $this->form_validation->set_rules('supply', '<b>Fx</b>', 'required|callback_validtelp|xss_clean');
        $this->form_validation->set_rules('pel_nama', '<b>Fx</b>', 'required|callback_validtelp|xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'not_tgl' => date('Y-m-d'),
                'not_createon' => date('Y-m-d H:i:s'),
                'not_createby' => ses_username,
                'not_cbid' => ses_cabang,
                'not_numerator' => $this->input->post('not_numerator'),
                'not_salesman' => $this->input->post('not_salesman'),
                'not_sppid' => $this->input->post('not_sppid'),
                'not_kredit_term' => numeric($this->input->post('not_kredit_term')),
                'not_nokwitansi_um' => $this->input->post('not_nokwitansi_um'),
                'not_tampil_ppn' => $this->input->post('not_tampil_ppn'),
                'not_pay_method' => $this->input->post('not_pay_method'),
                'not_total' => $this->input->post('total'),
            );
            $return = $this->model_trspart->saveFakturSparepart($data);
        }
        echo json_encode($return);
    }

    /**
     * 
     * @param type $kode
     */
    function printTerimaBarang($kode) {
        $this->data['faktur'] = $this->model_trspart->getFakturTerima($kode);
        $this->data['barang'] = $this->model_trspart->getFakturTerimaDetail($kode);
        $this->load->view('printTerimaBarang', $this->data);
    }

    /**
     * 
     * @param type $kode
     */
    function printReturBeli($kode) {
        $this->data['faktur'] = $this->model_trspart->getReturBeli($kode);
        $this->data['barang'] = $this->model_trspart->getReturBeliDetail($kode);
        $this->load->view('printReturBeli', $this->data);
    }

    /**
     * 
     * @param type $kode
     */
    function printAdjustmentStock($kode) {
        $this->data['faktur'] = $this->model_trspart->getAdjustmentStock($kode);
        $this->data['barang'] = $this->model_trspart->getAdjustmentStockDetail($kode);
        $this->load->view('printAdjustmentStock', $this->data);
    }

    /**
     * 
     * @param type $kode
     */
    function printReturJual($kode) {
        $this->data['faktur'] = $this->model_trspart->getReturJual($kode);
        $this->data['barang'] = $this->model_trspart->getReturJualDetail($kode);
        $this->load->view('printReturJual', $this->data);
    }

    /**
     * 
     * @param type $kode
     */
    function printFakturSparepart($kode) {
        $this->data['data'] = $this->model_trspart->getFakturSparepart($kode);
        $this->data['barang'] = $this->model_trspart->getFakturSparepartDetail($kode);
        $this->load->view('printFakturSparepart', $this->data);
    }

    /**
     * 
     * @param type $kode
     */
    function printSupplySlip($kode, $jenis) {
        $this->data['data'] = $this->model_trspart->getSupplySlip($kode);
        if ($jenis == 'so') {
            $this->data['so'] = $this->model_trspart->getSupplySlipSo($kode);
            $this->load->view('printSupplySlipSo', $this->data);
        } else {
            $this->data['barang'] = $this->model_trspart->getSupplySlipDetail($kode);
            $this->load->view('printSupplySlip', $this->data);
        }
    }

    public function uangmukaSparepart() {
        $this->hakAkses(1123);
        $this->data['etc'] = array(
            'judul' => 'Uangmuka Sparepart',
            'targetSave' => 'transaksi_finance/saveUangMuka',
            'kstid' => '',
            'purpose' => 'ADD',
            'trans' => 'KAS',
            'type' => 'I',
            'mainCoa' => $this->model_trfinance->getMainCoa(array('cbid' => ses_cabang, 'type' => '-1')),
            'costcenter' => $this->model_finance->cListCostCenter(array('cbid' => ses_cabang)),
        );
        $this->load->view('addUangMukaSpart', $this->data);
    }
    
    public function pembayaranPiutang() {
        $this->hakAkses(1127);
        $this->data['etc'] = array(
            'judul' => 'Pembayaran Piutang Sparepart',
            'targetSave' => 'transaksi_finance/saveSubTrans',
            'targetListData' => 'transaksi_sparepart/daftarByrPiutang',
            'subtrans' => '6',
            'crossCoa' => PIUTANG_SPART,
            'purpose' => 'ADD',
            'type' => 'I',
        );
        $this->load->view('addByrPiutangSparepart', $this->data);
    }

    public function pembayaranHutang() {
        $this->hakAkses(1125);
        $this->data['etc'] = array(
            'judul' => 'Pembayaran Hutang Sparepart',
            'targetSave' => 'transaksi_finance/saveSubTrans',
            'targetListData' => 'transaksi_sparepart/daftarByrHutang',
            'kstid' => '',
            'subtrans' => '11',
            'crossCoa' => HUTANG_SPART,
            'purpose' => 'ADD',
            'type' => 'O',
            'mainCoa' => $this->model_trfinance->getMainCoa(array('cbid' => ses_cabang, 'type' => '-1')),
        );
        $this->load->view('addByrHutangSparepart', $this->data);
    }

    public function tagihanSparepart() {
        $this->hakAkses(1133);
        $this->data['etc'] = array(
            'judul' => 'Tagihan Sparepart',
            'targetSave' => 'transaksi_sparepart/saveTagSparepart',
            'targetListData' => 'transaksi_service/daftarTagSparepart',
            'subtrans' => '13',
            'purpose' => 'ADD',
            'type' => 'I',
            'mainCoa' => $this->model_trfinance->getMainCoa(array('cbid' => ses_cabang, 'type' => '-1')),
        );
        $this->load->view('addTagService', $this->data);
    }

    public function daftarByrPiutang() {
        $this->hakAkses(1127);
        $this->data['etc'] = array(
            'judul' => 'DAFTAR TRANSAKSI PEMBAYARAN PIUTANG SERVICE',
            'trans' => 'BYRPIUTANG',
            'type' => 'I',
            'subtrans' => '6',
            'targetNewTrans' => 'transaksi_service/pembayaranPiutang',
            'targetLoad' => 'transaksi_service/loadTrans',
            'targetPrint' => 'transaksi_service/printBayarPiutang',
            'targetCancel' => 'transaksi_service/cancelTrans',
            'colNames' => "'TGL','NO.TRANS ','COA', 'DESC','NOMINAL', 'STAT', 'EDIT','DETAIL','PRINT','BATAL'",
            'colModel' => "{name:'kst_tgl',index:'kst_tgl', width:30, align:'left'},
                {name:'kst_nomer',index:'kst_nomer', width:40, align:'left'},
                {name:'kst_coa',index:'kst_coa', width:20, align:'left'},
                {name:'kst_desc',index:'kst_desc', width:70, align:'left'},
                {name:'kst_debit',index:'kst_debit', width:50, align:'right'},
                {name:'kst_status',index:'kst_status', width:30, align:'left'},
                {name:'edit',index:'validasi', width:14, align:'center'},
                {name:'print',index:'edit', width:14, align:'center'},
                {name:'detail',index:'print', width:14, align:'center'},
                {name:'batal',index:'detail', width:14, align:'center'}",
            'kategori' => " <option value=''>PILIH</option>
                            <option value='TERCETAK'>TERCETAK</option>
                            <option value='BLM_DICETAK'>BLM DICETAK</option>
                            <option value='BATAL'>BATAL</option>"
        );
        $this->load->view('dataTrans', $this->data);
    }

    public function daftarByrHutang() {
        $this->hakAkses(1127);
        $this->data['etc'] = array(
            'judul' => 'DAFTAR TRANSAKSI PEMBAYARAN HUTANG SERVICE',
            'trans' => 'BYRHUTANG',
            'type' => 'O',
            'subtrans' => '11',
            'targetNewTrans' => 'transaksi_service/pembayaranHutang',
            'targetLoad' => 'transaksi_service/loadTrans',
            'targetPrint' => 'transaksi_service/printBayarHutang',
            'targetCancel' => 'transaksi_service/cancelTrans',
            'colNames' => "'TGL','NO.TRANS ','COA', 'DESC','NOMINAL', 'STAT', 'EDIT','DETAIL','PRINT','BATAL'",
            'colModel' => "{name:'kst_tgl',index:'kst_tgl', width:30, align:'left'},
                {name:'kst_nomer',index:'kst_nomer', width:40, align:'left'},
                {name:'kst_coa',index:'kst_coa', width:20, align:'left'},
                {name:'kst_desc',index:'kst_desc', width:70, align:'left'},
                {name:'kst_debit',index:'kst_debit', width:50, align:'right'},
                {name:'kst_status',index:'kst_status', width:30, align:'left'},
                {name:'edit',index:'validasi', width:14, align:'center'},
                {name:'print',index:'edit', width:14, align:'center'},
                {name:'detail',index:'print', width:14, align:'center'},
                {name:'batal',index:'detail', width:14, align:'center'}",
            'kategori' => " <option value=''>PILIH</option>
                            <option value='TERCETAK'>TERCETAK</option>
                            <option value='BLM_DICETAK'>BLM DICETAK</option>
                            <option value='BATAL'>BATAL</option>"
        );
        $this->load->view('dataTrans', $this->data);
    }

    public function saveTagService() {
        $coa = $this->input->post('dtrans_coa', TRUE);
        $desc = $this->input->post('dtrans_desc', TRUE);
        $nominal = $this->input->post('dtrans_nominal', TRUE);
        $trans = $this->input->post('dtrans_trans', TRUE);
        
        $etc = array(
                'numerator' => $this->input->post('trans_numerator', TRUE),
                'purpose' => 'ADD',
                'woid' => $this->input->post('trans_notaid', TRUE)
            );
        
        if (count($nominal) > 0) {
            for ($i = 0; $i <= count($detail['nominal']) - 1; $i++) {
                if (count($nominal) > 1) {
                    $docno = strtoupper($this->input->post('trans_docno', TRUE)) . '-' . ($i + 1);
                } else {
                    $docno = strtoupper($this->input->post('trans_docno', TRUE));
                }
                
                $main = array(
                    'kst_trans' => $trans[$i],
                    'kst_type' => $this->input->post('trans_type', TRUE),
                    'kst_nomer' => $docno,
                    'kst_noreff' => '',
                    'kst_tgl' => dateToIndo($this->input->post('trans_tgl', TRUE)),
                    'kst_coa' => $coa[$i],
                    'kst_desc' => strtoupper($desc[$i]),
                    'kst_debit' => numeric($nominal[$i]),
                    'kst_kredit' => numeric($nominal[$i]),
                    'kst_createon' => date('Y-m-d H:i:s'),
                    'kst_sub_trans' => $this->input->post('trans_sub_trans', TRUE),
                    'kst_createby' => ses_krid,
                    'kst_cbid' => ses_cabang,
                );
                
                $detail = array(
                    'coa'   => array(0 => PIUTANG_SERVICE ),
                    'desc'  => array(0 => $desc[$i]),
                    'nota'  => array(0 => $this->input->post('trans_notaid', TRUE)),
                    'pelid' => array(0 => $this->input->post('trans_pelid', TRUE)),
                    'supid' => array(0 => '0'),
                    'ccid'  => array(0 => '0'),
                    'nominal' => array(0 => $nominal[$i])
                );
                
                $bank = array();
                
                if($nominal[$i] != 0 ){
                    $save = $this->model_trfinance->addTrans($etc, $main, $detail, $bank);
                }
            }
        }
        
        if ($save['status'] == TRUE) {
            $result = array('status' => TRUE, 'msg' => $this->sukses($save['msg']));
        } else {
            $result = array('status' => FALSE, 'msg' => $this->error($save['msg']));
        }

        echo json_encode($result);
    }

    public function loadTrans() {
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $limit = isset($_POST['rows']) ? $_POST['rows'] : 10;
        $sidx = isset($_POST['sidx']) ? $_POST['sidx'] : 'kstid';
        $sord = isset($_POST['sord']) ? $_POST['sord'] : 'DESC';
        $start = $limit * $page - $limit;
        $start = ($start < 0) ? 0 : $start;
        $param = array(
            'start' => $start,
            'limit' => $limit,
            'sidx' => $sidx,
            'sord' => $sord,
            'kategori' => isset($_POST['kategori']) ? $_POST['kategori'] : '',
            'dateFrom' => isset($_POST['dateFrom']) ? dateToIndo($_POST['dateFrom']) : date('Y-01-01'),
            'dateTo' => isset($_POST['dateTo']) ? dateToIndo($_POST['dateTo']) : date('Y-m-d'),
            'trans' => isset($_POST['trans']) ? $_POST['trans'] : '',
            'type' => isset($_POST['type']) ? $_POST['type'] : '',
            'subtrans' => isset($_POST['subtrans']) ? $_POST['subtrans'] : '0',
            'key' => isset($_POST['key']) ? $_POST['key'] : '',
        );
        $query = $this->model_trfinance->loadSubTrans($param);
        $count = $query['numrows'];
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;
        $responce = new stdClass;
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
        $i = 0;
        if (count($query['result']) > 0) {
            foreach ($query['result'] as $row) {
                $nominal = ($param['type'] == 'I') ? $row->kst_debit : $row->kst_kredit;
                $del = "hapusData('" . $row->kstid . "', '" . $row->kst_nomer . "')";
                $pr = "cetakData('" . $row->kstid . "', '" . $row->kst_nomer . "')";
                $hapus = '<a href="javascript:void(0);" onclick="' . $del . '" title="Hapus"><i class="ace-icon fa fa-trash-o bigger-120 orange"></i>';
                $print = '<a href="javascript:void(0);" onclick="' . $pr . '" title="Cetak"><i class="ace-icon fa fa-print bigger-120 blue"></i>';
                $detail = '<a href="#transaksi_finance/detailTrans?id=' . $row->kstid . '" title="Detail"><i class="ace-icon glyphicon glyphicon-list bigger-100"></i>';
                $edit = '<a href="#transaksi_finance/editTrans?id=' . $row->kstid . '" title="Edit"><i class="ace-icon glyphicon glyphicon-pencil bigger-100"></i>';
                $responce->rows[$i]['id'] = $row->kstid;
                $responce->rows[$i]['cell'] = array(
                    dateToIndo($row->kst_tgl),
                    strtoupper($row->kst_nomer),
                    $row->kst_coa,
                    $row->kst_desc,
                    number_format($nominal, 2),
                    $row->kst_status,
                    $edit, $detail, $print, $hapus);
                $i++;
            }
        }
        echo json_encode($responce);
    }

}

?>
