<?php

/**
 * Class Admin_Controller
 * @author Rossi
 * 2013-11-11
 */
class Transaksi_Service extends Application {

    /**
     * The new Admin_controller
     */
    public function __construct() {
        parent::__construct();
        $this->load->model(array('model_trservice', 'model_trfinance', 'model_finance', 'model_admin'));
    }

    public function index() {
//        $this->addProspect();
    }

    function jsonWoBelumInvoiceAuto() {
        $wo = $this->input->post('param');
        $data = $this->model_trservice->getWoBelumInvoiceAutoComplete(strtoupper($wo));
        if ($data == null) {
            $data[] = array(
                'value' => 'Data Tidak Ditemukan',
                'desc' => '',
            );
        }
        echo json_encode($data);
    }

    function jsonWo() {
        $woNomer = trim(strtoupper($this->input->post('param')));
        $data = $this->model_trservice->getWo($woNomer);
        if (count($data) > 0) {
            $data['response'] = true;
        } else {
            $data['response'] = false;
        }
        echo json_encode($data);
    }

    function getJasaWoByWoNomer() {
        $woNomer = strtoupper($this->input->post('wo'));
        $data = $this->model_trservice->getJasaWoByWoNomer($woNomer);
        echo json_encode($data);
    }

    /**
     * 
     */
    function getTotalSupply() {
        $woNomer = strtoupper($this->input->post('wo'));
        echo json_encode($this->model_trservice->getTotalSupply($woNomer));
    }

    function jsonDataKendaraan() {
        $nopol = strtoupper(str_replace(" ", "", $this->input->post('param')));
        $retur = array();
        $data = $this->model_trservice->getDataKendaraan($nopol);
        $retur['response'] = false;
        if (count($data) > 0) {
            $retur['response'] = true;
            $retur['data'] = $data;
        }
        echo json_encode($retur);
    }

    function jsonFlateRate() {
        $kode = strtoupper(str_replace(" ", "", $this->input->post('param')));
        $retur = array();
        $data = $this->model_trservice->getDataFlateRate($kode);
        $retur['response'] = false;
        if (count($data) > 0) {
            $retur['response'] = true;
            $retur['data'] = $data;
        }
        echo json_encode($retur);
    }

    function jsonNopol() {
        echo json_encode($this->model_trservice->getNopol(strtoupper(str_replace(" ", "", $this->input->post('param')))));
    }

    function getFlateRateAuto() {
        $param = strtoupper(str_replace(" ", "", $this->input->post('term')));
        echo json_encode($this->model_trservice->getFlateRateAuto($param, $this->input->post('type')));
    }

    function saveWo() {
        $return = false;
        $this->form_validation->set_rules('nopol', '<b>Fx</b>', 'required|callback_validtelp|xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'wo_tgl' => date('Y-m-d'),
                'wo_createon' => date('Y-m-d H:i:s'),
                'wo_createby' => ses_username,
                'wo_jenis' => $this->input->post('wo_jenis'),
                'wo_mscid' => strtoupper($this->input->post('wo_mscid')),
                'wo_numerator' => $this->input->post('wo_numerator'),
                'wo_pelid' => $this->input->post('wo_pelid'),
                'wo_selesai' => $this->input->post('wo_selesai'),
                'wo_km' => $this->input->post('wo_km'),
                'wo_type' => $this->input->post('wo_type'),
                'wo_pembawa' => $this->input->post('wo_pembawa'),
                'wo_inextern' => $this->input->post('wo_inextern'),
                'wo_stallid' => $this->input->post('wo_stallid'),
                'wo_tunggu' => $this->input->post('wo_tunggu'),
                'wo_sa' => $this->input->post('wo_sa'),
                'wo_cbid' => ses_cabang,
            );
            $jasa = array();
            $sp = array();
            $so = array();
            $woj_keluhan = $this->input->post('woj_keluhan');
            $woj_flatid = $this->input->post('woj_flatid');
            $woj_namajasa = $this->input->post('woj_namajasa');
            $woj_rate = $this->input->post('woj_rate');
            $woj_subtotal = $this->input->post('woj_subtotal');
            // get array spare part from table 
            if (count($woj_namajasa) > 0) {
                for ($i = 0; $i < count($woj_namajasa); $i++) {
                    if (!empty($woj_keluhan[$i]) || !empty($woj_namajasa[$i])) {
                        $jasa[] = array(
                            'woj_keluhan' => strtoupper($woj_keluhan[$i]),
                            'woj_flatid' => $woj_flatid[$i],
                            'woj_namajasa' => strtoupper($woj_namajasa[$i]),
                            'woj_rate' => numeric($woj_rate[$i]),
                            'woj_subtotal' => numeric($woj_subtotal[$i]),
                        );
                    }
                }
            }
            $wop_inveid = $this->input->post('wop_inveid');
            $wop_qty = $this->input->post('wop_qty');
            $wop_harga = $this->input->post('wop_harga');
            $wop_subtotal = $this->input->post('wop_subtotal');
            // get array spare part from table 
            if (count($wop_inveid) > 0) {
                for ($i = 0; $i < count($wop_inveid); $i++) {
                    if (!empty($wop_inveid[$i])) {
                        $sp[] = array(
                            'wop_inveid' => $wop_inveid[$i],
                            'wop_qty' => $wop_qty[$i],
                            'wop_harga' => numeric($wop_harga[$i]),
                            'wop_subtotal' => numeric($wop_subtotal[$i]),
                        );
                    }
                }
            }
            $wos_nama = $this->input->post('wos_nama');
            $wos_harga = $this->input->post('wos_harga');
            // get array spare part from table 
            if (count($wos_nama) > 0) {
                for ($i = 0; $i < count($wos_nama); $i++) {
                    if (!empty($wos_nama[$i])) {
                        $so[] = array(
                            'wos_nama' => strtoupper($wos_nama[$i]),
                            'wos_harga' => numeric($wos_harga[$i]),
                        );
                    }
                }
            }
            $return = $this->model_trservice->saveWo($data, $jasa, $sp, $so);
        }
        echo json_encode($return);
    }

    function saveFakturService() {
        $return = false;
        $this->form_validation->set_rules('msc_nopol', '<b>Fx</b>', 'required|callback_validtelp|xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $woid = $this->input->post('inv_woid');
            $data = array(
                'inv_tgl' => date('Y-m-d'),
                'inv_createon' => date('Y-m-d H:i:s'),
                'inv_createby' => ses_username,
                'inv_woid' => $woid,
                'inv_catatan' => $this->input->post('inv_catatan'),
                'inv_fchecker' => $this->input->post('inv_fchecker'),
                'inv_kasir' => $this->input->post('inv_kasir'),
                'inv_inextern' => $this->input->post('inv_inextern'),
                'inv_tampil_ppn' => $this->input->post('inv_tampil_ppn'),
                'inv_spart' => numeric($this->input->post('total_sp')),
                'inv_oli' => numeric($this->input->post('total_ol')),
                'inv_sm' => numeric($this->input->post('total_sm')),
                'inv_so' => numeric($this->input->post('total_so')),
                'inv_lc' => numeric($this->input->post('total_lc')),
                'inv_total' => numeric($this->input->post('grand_total')),
                'inv_hpp_spart' => numeric($this->input->post('total_sp_hpp')),
                'inv_hpp_oli' => numeric($this->input->post('total_ol_hpp')),
                'inv_hpp_sm' => numeric($this->input->post('total_sm_hpp')),
                'inv_hpp_so' => numeric($this->input->post('total_so_hpp')),
                'inv_cbid' => ses_cabang,
                'inv_print' => 1,
                'inv_status' => 1
            );

            $wo = array(
                'woid' => $woid,
                'wo_inv_status' => 1,
                'wo_inv_tgl' => date('Y-m-d'),
                'wo_km' => $this->input->post('wo_km')
            );

            $jasa = array();
            $dinv_flatid = $this->input->post('dinv_flatid');
            $dinv_kode = $this->input->post('dinv_kode');
            $dinv_harga = $this->input->post('flat_lc');
            $dinv_diskon = $this->input->post('dinv_diskon');
            $dinv_subtotal = $this->input->post('dinv_subtotal');
            // get array spare part from table 
            if (count($dinv_flatid) > 0) {
                for ($i = 0; $i < count($dinv_flatid); $i++) {
                    if (numeric($dinv_harga[$i]) > 0) {
                        $jasa[] = array(
                            'dinv_flatid' => strtoupper($dinv_flatid[$i]),
                            'dinv_harga' => numeric($dinv_harga[$i]),
                            'dinv_diskon' => numeric($dinv_diskon[$i]),
                            'dinv_subtotal' => numeric($dinv_subtotal[$i]),
                        );
                    }
                }
            }
            $return = $this->model_trservice->saveFakturService($data, $wo, $jasa);
        }
        echo json_encode($return);
    }

    public function workOrder() {
        $this->hakAkses(35);
        $this->data['jenis'] = $this->model_trservice->getWoJenis();
        $this->load->view('workOrder', $this->data);
    }

    /**
     * 
     */
    public function fakturService() {
        $this->hakAkses(38);
        $this->data['checker'] = $this->model_admin->getKaryawanByJabatan(JAB_SVC_FINAL_CHECKER);
        $this->data['kasir'] = $this->model_admin->getKaryawanByJabatan(JAB_SVC_KASIR_SERVICE);
        $this->load->view('fakturService', $this->data);
    }

    public function clockOnMekanik() {
        $this->hakAkses(36);
        $this->load->view('clockOnMekanik', $this->data);
    }

    public function lampiranFaktur() {
        $this->hakAkses(37);
        $this->load->view('lampiranFaktur', $this->data);
    }

    public function serviceOrder() {
        $this->hakAkses(57);
        $this->data['stall'] = $this->model_trservice->getStall();
        $this->data['sa'] = $this->model_admin->getKaryawanByJabatan(JAB_SVC_SA_FRONTMAN);
        $this->data['jenis'] = $this->input->GET('jenis');
        $this->data['type'] = $this->input->GET('type');
        $this->load->view('serviceOrder', $this->data);
    }

    /**
     * Function ini digunakan untuk mencetak wo
     * @param type $kode
     */
    function printWo($kode) {
        $this->data['wo'] = $this->model_trservice->getWorkOrder($kode);
        $this->data['jasa'] = $this->model_trservice->getJasaWorkOrder($kode);
        $this->data['sp'] = $this->model_trservice->getSparepartWorkOrder($kode);
        $this->data['so'] = $this->model_trservice->getSoWorkOrder($kode);
        $this->load->view('printWo', $this->data);
    }

    function printInvoice($invid) {
        $data = $this->model_trservice->getFakturService($invid);
        $this->data['data'] = $data;
        $this->data['flat'] = $this->model_trservice->getTrJasa($invid);
        $this->data['sa'] = $this->model_admin->getKaryawanById($data['wo_sa']);
        $this->data['fc'] = $this->model_admin->getKaryawanById($data['inv_fchecker']);
        $this->load->view('printInvoice', $this->data);
    }

    /**
     * Function ini digunakan untuk mencetak lampiran faktur service
     * @param type $kode
     */
    function printLampiranFakturService($woNomer) {
        $this->load->model('model_trspart');
        $this->data['data'] = $this->model_trservice->getWoAll(strtoupper($woNomer));
        $this->data['part'] = $this->model_trspart->getSupplySlipDetailByWo(strtoupper($woNomer));
        $this->data['dataso'] = $this->model_trspart->getSupplySlipSoByWo(strtoupper($woNomer));
        $this->load->view('printLampiranFakturService', $this->data);
    }

    function loadDataWo() {
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $limit = isset($_POST['rows']) ? $_POST['rows'] : 10;
        $sidx = isset($_POST['sidx']) ? $_POST['sidx'] : 'wo_nomer';
        $sord = isset($_POST['sord']) ? $_POST['sord'] : '';
        $start = $limit * $page - $limit;
        $start = ($start < 0) ? 0 : $start;
        $where = whereLoad();
        $count = $this->model_trservice->getTotalWo($where);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;
        $query = $this->model_trservice->getAllWo($start, $limit, $sidx, $sord, $where);
        $mekanik = $this->model_trservice->getDataMekanik();
        $mek = "<option value=''>Pilih Mekanik</option>";
        if (count($mekanik) > 0) {
            foreach ($mekanik as $list) {
                $mek .= "<option value='" . $list['krid'] . "' >" . $list['kr_nama'] . "</option>";
            }
        }
        $responce = new stdClass;
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
        $i = 0;
        if (count($query) > 0)
            foreach ($query as $row) {
                $mknk = '';
                $pending = '-';
                $clock = "<label><input class='ace ace-switch btn-rotate' id='cek$i' onclick='clocking(\"" . $i . "\",\"" . $row['cloid'] . "\")' type='checkbox' name='cek[]'><span class='lbl'></span></label>";

                if ($row['clo_status'] == '0') {
                    $status = 'BELUM CLOCK ON';
                    $mknk = "<select id='krid$i' name='krid' class='ace col-xs-10 col-sm-10' style='width: 100%'>" . $mek . "</select>";
                } else if ($row['clo_status'] == '1') {
                    $status = 'PROSES PENGERJAAN';
                    $clock = "<label><input checked class='ace ace-switch btn-rotate' id='cek$i' onclick='clocking(\"" . $i . "\",\"" . $row['cloid'] . "\")' type='checkbox' name='cek[]'><span class='lbl'></span></label>";
                    $pending = "<a href='javascript:;' title='Pending' onclick='pending(\"" . $i . "\",\"" . $row['cloid'] . "\")'><i class='green ace-icon glyphicon glyphicon-off'></i></a>";
                    $mknk = $row['kr_nama'];
                } else if ($row['clo_status'] == '2') {
                    $status = 'PENDING';
                    $mknk = "<select id='krid$i' name='krid' class='ace col-xs-10 col-sm-10' style='width: 100%'>" . $mek . "</select>";
                } else {
                    $status = 'SELESAI';
                    $clock = 'PROSES NOTA';
                    $mknk = $row['kr_nama'];
                }
                $responce->rows[$i]['id'] = $row['woid'];
                $responce->rows[$i]['cell'] = array(
                    $row['wo_nomer'], $row['msc_nopol'], $row['pel_nama'], $status, $mknk, $clock, $pending);
                $i++;
            }
        echo json_encode($responce);
    }

    function clockingMekanik() {
        $cloid = $this->input->post('clockid');
        $status = $this->input->post('status');
        $krid = $this->input->post('krid');
        $simpan = $this->model_trservice->clockingMekanik($cloid, $status, $krid);
        if ($simpan) {
            $hasil['msg'] = $this->sukses("Berhasil Clock On / Off Mekanik");
            $hasil['response'] = true;
        } else {
            $hasil['msg'] = $this->error("Gagal Clock On / Off Mekanik");
            $hasil['response'] = false;
        }
        echo json_encode($hasil);
    }

    function pendingMekanik() {
        $cloid = $this->input->post('clockid');
        $simpan = $this->model_trservice->pendingMekanik($cloid);
        if ($simpan) {
            $hasil['msg'] = $this->sukses("Berhasil Pending Mekanik");
            $hasil['response'] = true;
        } else {
            $hasil['msg'] = $this->error("Gagal Pending Mekanik");
            $hasil['response'] = false;
        }
        echo json_encode($hasil);
    }

    public function uangmukaService() {
        $this->hakAkses(1122);
        $this->data['etc'] = array(
            'judul' => 'Uangmuka Service',
            'targetSave' => 'transaksi_finance/saveTrans',
            'kstid' => '',
            'purpose' => 'ADD',
            'trans' => 'KAS',
            'type' => 'I',
            'mainCoa' => $this->model_trfinance->getMainCoa(array('cbid' => ses_cabang, 'type' => '-1')),
        );
        $this->load->view('addUangMukaService', $this->data);
    }

    public function pembayaranPiutang() {
        $this->hakAkses(1127);
        $this->data['etc'] = array(
            'judul' => 'Pembayaran Piutang Service',
            'targetSave' => 'transaksi_finance/saveSubTrans',
            'targetListData' => 'transaksi_service/daftarByrPiutang',
            'kstid' => '',
            'subtrans' => '6',
            'crossCoa' => PIUTANG_SERVICE,
            'purpose' => 'ADD',
            'trans' => 'KAS',
            'type' => 'I',
        );
        $this->load->view('addByrPiutangService', $this->data);
    }

    public function pembayaranHutang() {
        $this->hakAkses(1125);
        $this->data['etc'] = array(
            'judul' => 'Pembayaran Hutang Service',
            'targetSave' => 'transaksi_finance/saveSubTrans',
            'targetListData' => 'transaksi_service/daftarByrHutang',
            'kstid' => '',
            'subtrans' => '11',
            'crossCoa' => HUTANG_SPART,
            'purpose' => 'ADD',
            'type' => 'O',
            'mainCoa' => $this->model_trfinance->getMainCoa(array('cbid' => ses_cabang, 'type' => '-1')),
        );
        $this->load->view('addByrHutangService', $this->data);
    }

    public function tagihanService() {
        $this->hakAkses(1133);
        $this->data['etc'] = array(
            'judul' => 'Tagihan Service',
            'targetSave' => 'transaksi_service/saveTagService',
            'targetListData' => 'transaksi_service/daftarTagService',
            'subtrans' => '12',
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
        
        $transToSave = array();
        
        if (count($nominal) > 0) {
            for ($i = 0; $i <= count($nominal) - 1; $i++) {
                if (count($nominal) > 1) {
                    $docno = strtoupper($this->input->post('trans_nota', TRUE)) . '-' . ($i + 1);
                } else {
                    $docno = strtoupper($this->input->post('trans_nota', TRUE));
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
                    $transToSave[] = array('etc' => $etc, 'main' => $main, 'detail' => $detail, 'bank' => $bank);
                }
            }
        }
        
        $save = $this->model_trfinance->saveTagihanService($etc, $transToSave);
        
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
