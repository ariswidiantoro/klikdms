<?php

/**
 * Class Master
 * @author Rossi Erl
 * 2015-09-04
 */
class Transaksi_Finance extends Application {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('model_admin', 'model_sales', 'model_finance', 'model_trfinance'));
        $this->isLogin();
    }

    public function index() {
        echo "";
    }

    public function kasin() {
        $this->hakAkses(1055);
        $this->data['etc'] = array(
            'judul' => 'Penerimaan Kas',
            'targetSave' => 'saveTrans',
            'targetListdata' => 'daftarKasin',
            'kstid' => '',
            'purpose' => 'ADD',
            'trans' => 'KAS',
            'subTrans' => '0',
            'type' => 'I',
            'mainCoa' => $this->model_trfinance->getMainCoa(array('cbid' => ses_cabang, 'type' => 1)),
            'costcenter' => $this->model_finance->cListCostCenter(array('cbid' => ses_cabang)),
        );
        $this->load->view('addTrans', $this->data);
    }

    public function daftarKasin() {
        $this->hakAkses(1055);
        $this->data['etc'] = array(
            'judul' => 'DAFTAR TRANSAKSI PENERIMAAN KAS',
            'trans' => 'KAS',
            'type' => 'I',
            'subtrans' => '0',
            'newTrans' => 'kasin',
            'targetLoad' => 'loadTrans',
            'targetPrint' => 'printTrans',
            'targetCancel' => 'cancelTrans',
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

    public function kasout() {
        $this->hakAkses(1054);
        $this->data['etc'] = array(
            'judul' => 'Pengeluaran Kas',
            'targetSave' => 'transaksi_finance/saveTrans',
            'targetListdata' => 'daftarKasout',
            'kstid' => '',
            'purpose' => 'ADD',
            'trans' => 'KAS',
            'subTrans' => '0',
            'type' => 'O',
            'mainCoa' => $this->model_trfinance->getMainCoa(array('cbid' => ses_cabang, 'type' => 1)),
            'costcenter' => $this->model_finance->cListCostCenter(array('cbid' => ses_cabang)),
        );
        $this->load->view('addTrans', $this->data);
    }
    
    public function daftarKasout() {
        $this->hakAkses(1054);
        $this->data['etc'] = array(
            'judul' => 'DAFTAR TRANSAKSI PENGELUARAN KAS',
            'trans' => 'KAS',
            'type' => 'O',
            'subtrans' => '0',
            'newTrans' => 'kasout',
            'targetLoad' => 'loadTrans',
            'targetPrint' => 'printTrans',
            'targetCancel' => 'cancelTrans',
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

    public function bankin() {
        $this->hakAkses(1071);
        $this->data['etc'] = array(
            'judul' => 'Penerimaan Bank',
            'targetSave' => 'transaksi_finance/saveTrans',
            'targetListdata' => 'daftarBnkin',
            'kstid' => '',
            'purpose' => 'ADD',
            'trans' => 'BNK',
            'subTrans' => '0',
            'type' => 'I',
            'mainCoa' => $this->model_trfinance->getMainCoa(array('cbid' => ses_cabang, 'type' => 2)),
            'costcenter' => $this->model_finance->cListCostCenter(array('cbid' => ses_cabang)),
        );
        $this->load->view('addTrans', $this->data);
    }
    
    public function daftarBnkin() {
        $this->hakAkses(1071);
        $this->data['etc'] = array(
            'judul' => 'DAFTAR TRANSAKSI PENERIMAAN BANK',
            'trans' => 'BNK',
            'type' => 'I',
            'subtrans' => '0',
            'newTrans' => 'bankin',
            'targetLoad' => 'loadTrans',
            'targetPrint' => 'printTrans',
            'targetCancel' => 'cancelTrans',
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

    public function bankout() {
        $this->hakAkses(1072);
        $this->data['etc'] = array(
            'judul' => 'Pengeluaran Bank',
            'targetSave' => 'transaksi_finance/saveTrans',
            'targetListdata' => 'daftarBnkout',
            'kstid' => '',
            'purpose' => 'ADD',
            'trans' => 'BNK',
            'type' => 'O',
            'mainCoa' => $this->model_trfinance->getMainCoa(array('cbid' => ses_cabang, 'type' => 2)),
            'costcenter' => $this->model_finance->cListCostCenter(array('cbid' => ses_cabang)),
        );
        $this->load->view('addTrans', $this->data);
    }
    
    public function daftarBnkout() {
        $this->hakAkses(1072);
        $this->data['etc'] = array(
            'judul' => 'DAFTAR TRANSAKSI PENGELUARAN BANK',
            'trans' => 'BNK',
            'type' => 'O',
            'subtrans' => '0',
            'newTrans' => 'bankout',
            'targetLoad' => 'loadTrans',
            'targetPrint' => 'printTrans',
            'targetCancel' => 'cancelTrans',
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

    public function cekin() {
        $this->hakAkses(1086);
        $this->data['etc'] = array(
            'judul' => 'Penerimaan Cek',
            'targetSave' => 'transaksi_finance/saveTrans',
            'targetListdata' => 'daftarCekin',
            'kstid' => '',
            'purpose' => 'ADD',
            'trans' => 'CEK',
            'type' => 'I',
            'subTrans' => '0',
            'mainCoa' => $this->model_trfinance->getMainCoa(array('cbid' => ses_cabang, 'type' => 3)),
            'costcenter' => $this->model_finance->cListCostCenter(array('cbid' => ses_cabang)),
        );
        $this->load->view('addTrans', $this->data);
    }
    
    public function daftarCekin() {
        $this->hakAkses(1086);
        $this->data['etc'] = array(
            'judul' => 'DAFTAR TRANSAKSI PENERIMAAN CEK',
            'trans' => 'CEK',
            'type' => 'I',
            'subtrans' => '0',
            'newTrans' => 'cekin',
            'targetLoad' => 'loadTrans',
            'targetPrint' => 'printTrans',
            'targetCancel' => 'cancelTrans',
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

    public function cekout() {
        $this->hakAkses(1051);
        $this->data['etc'] = array(
            'judul' => 'Pengeluaran Cek',
            'targetSave' => 'transaksi_finance/saveTrans',
            'targetListdata' => 'daftarCekout',
            'kstid' => '',
            'purpose' => 'ADD',
            'trans' => 'CEK',
            'subTrans' => '0',
            'type' => 'O',
            'mainCoa' => $this->model_trfinance->getMainCoa(array('cbid' => ses_cabang, 'type' => 3)),
            'costcenter' => $this->model_finance->cListCostCenter(array('cbid' => ses_cabang)),
        );
        $this->load->view('addTrans', $this->data);
    }
    
    public function daftarCekout() {
        $this->hakAkses(1086);
        $this->data['etc'] = array(
            'judul' => 'DAFTAR TRANSAKSI PENGELUARAN CEK',
            'trans' => 'CEK',
            'type' => 'O',
            'subtrans' => '0',
            'newTrans' => 'cekout',
            'targetLoad' => 'loadTrans',
            'targetPrint' => 'printTrans',
            'targetCancel' => 'cancelTrans',
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

    /* UANG MUKA */

    public function uangMuka() {
        $this->hakAkses(1101);
        $this->data['etc'] = array(
            'judul' => 'Uangmuka Penjualan',
            'targetSave' => 'transaksi_finance/saveTrans',
            'kstid' => '',
            'purpose' => 'ADD',
            'trans' => 'KAS',
            'type' => 'I',
            'subTrans' => '0',
            'mainCoa' => $this->model_trfinance->getMainCoa(array('cbid' => ses_cabang, 'type' => '-1')),
            'costcenter' => $this->model_finance->cListCostCenter(array('cbid' => ses_cabang)),
        );
        $this->load->view('addUangMuka', $this->data);
    }

    /* NOTA KREDIT */

    public function notaKredit() {
        $this->hakAkses(1088);
        $this->data['etc'] = array(
            'judul' => 'Nota Kredit',
            'targetSave' => 'transaksi_finance/saveTrans',
            'kstid' => '',
            'purpose' => 'ADD',
            'trans' => 'NOTAKREDIT',
            'subTrans' => '0',
            'type' => 'O',
        );
        $this->load->view('addNotaKredit', $this->data);
    }

    /* KWITANSI */

    public function kwitansi() {
        $this->hakAkses(1106);
        $this->data['etc'] = array(
            'judul' => 'Kwitansi',
            'targetSave' => 'transaksi_finance/saveKwitansi',
            'kstid' => '',
            'purpose' => 'ADD',
            'trans' => 'KWI',
            'subTrans' => '0',
            'type' => 'I',
            'mainCoa' => $this->model_trfinance->getMainCoa(array('cbid' => ses_cabang, 'type' => '-1')),
            'costcenter' => $this->model_finance->cListCostCenter(array('cbid' => ses_cabang)),
        );
        $this->load->view('addKwitansi', $this->data);
    }
    
    public function daftarKwitansi() {
        $this->hakAkses(1106);
        $this->data['etc'] = array(
            'judul' => 'DAFTAR TRANSAKSI KWITANSI',
            'trans' => 'KWI',
            'type' => 'I',
            'subtrans' => '0',
            'newTrans' => 'kwitansi',
            'targetLoad' => 'loadTrans',
            'targetPrint' => 'printKwitansi',
            'targetCancel' => 'cancelTrans',
            'colNames' => "'TGL','NO.TRANS','JENIS', 'COA', 'NAMA','NOMINAL', 'STATUS', 'EDIT','DETAIL','PRINT','BATAL'",
            'colModel' => "{name:'kst_tgl',index:'kst_tgl', width:30, align:'left'},
                {name:'kst_nomer',index:'kst_nomer', width:40, align:'left'},
                {name:'kst_trans',index:'kst_trans', width:20, align:'left'},
                {name:'kst_coa',index:'kst_coa', width:20, align:'left'},
                {name:'pel_nama',index:'pel_nama', width:50, align:'left'},
                {name:'kst_debit',index:'kst_debit', width:50, align:'right'},
                {name:'kst_status',index:'kst_status', width:30, align:'left'},
                {name:'edit',index:'validasi', width:14, align:'center'},
                {name:'print',index:'edit', width:14, align:'center'},
                {name:'detail',index:'print', width:14, align:'center'},
                {name:'batal',index:'detail', width:14, align:'center'}",
            'kategori' => " <option value='KWI'>PILIH</option>
                            <option value='KWIKAS'>KAS</option>
                            <option value='KWICEK'>CEK</option>
                            <option value='BANK'>BANK</option>
                            <option value='TERCETAK'>TERCETAK</option>
                            <option value='BLM DICETAK'>BLM DICETAK</option>
                            <option value='BATAL'>BATAL</option>"
        );
        $this->load->view('dataTrans', $this->data);
    }
    
    public function editKwitansi() {
        $this->hakAkses(1106);
        $id = strtoupper($this->input->get('id', TRUE));
        $dataMain = $this->model_trfinance->getMainTrans(array('kstid' => $id));
        if($dataMain['kst_type'] == 'I'){
            $daftar = "daftar".$dataMain['kst_trans']."in";
        }else{
            $daftar = "daftar".$dataMain['kst_trans']."out";
        }
        $this->data['etc'] = array(
            'judul' => 'Edit Kwitansi : '.$dataMain['kst_nomer'],
            'targetSave' => 'transaksi_finance/saveKwitansi',
            'targetListdata' => $daftar,
            'kstid' => $dataMain['kstid'],
            'purpose' => 'EDIT',
            'trans' => $dataMain['kst_trans'],
            'type' => $dataMain['kst_type'],
            'mainCoa' => $this->model_trfinance->getMainCoa(array('cbid' => ses_cabang, 'type' => -1)),
            'costcenter' => $this->model_finance->cListCostCenter(array('cbid' => ses_cabang)),
        );
        $this->load->view('editKwitansi', $this->data);
    }
    
    public function saveKwitansi() {
        $main = array(
            'kst_trans' => $this->input->post('trans_trans', TRUE),
            'kst_type' => $this->input->post('trans_type', TRUE),
            'kst_pelid' => strtoupper($this->input->post('trans_pelid', TRUE)),
            'kst_nomer' => strtoupper($this->input->post('trans_docno', TRUE)),
            'kst_noreff' => $this->input->post('trans_noreff', TRUE),
            'kst_tgl' => dateToIndo($this->input->post('trans_tgl', TRUE)),
            'kst_coa' => $this->input->post('trans_coa', TRUE),
            'kst_desc' => strtoupper($this->input->post('trans_desc', TRUE)),
            'kst_debit' => numeric($this->input->post('totalTrans', TRUE)),
            'kst_kredit' => numeric(0),
            'kst_createon' => date('Y-m-d H:i:s'),
            'kst_sub_trans' => $this->input->post('trans_sub_trans', TRUE),
            'kst_createby' => ses_krid,
            'kst_cbid' => ses_cabang,
        );

        $detail = array(
            'coa' => $this->input->post('dtrans_coa', TRUE),
            'desc' => $this->input->post('dtrans_desc', TRUE),
            'nota' => $this->input->post('dtrans_notaid', TRUE),
            'ccid' => $this->input->post('dtrans_ccid', TRUE),
            'nominal' => $this->input->post('dtrans_nominal', TRUE)
        );

        $bank = array(
            'bank' => $this->input->post('dbnk_bankid', TRUE),
            'norek' => $this->input->post('dbnk_norek', TRUE),
            'nocek' => $this->input->post('dbnk_nocek', TRUE),
            'jtempo' => $this->input->post('dbnk_jtempo', TRUE),
            'kota' => $this->input->post('dbnk_kotaid', TRUE),
            'nominal' => $this->input->post('dbnk_nominal', TRUE)
        );

        $etc = array(
            'purpose' => $this->input->post('trans_purpose', TRUE),
            'kstid' => $this->input->post('trans_kstid', TRUE)
        );

        $save = $this->model_trfinance->addKwitansi($etc, $main, $detail, $bank);

        if ($save['status'] == TRUE) {
            $result = array('status' => TRUE, 'msg' => $this->sukses($save['msg']));
        } else {
            $result = array('status' => FALSE, 'msg' => $this->error($save['msg']));
        }

        echo json_encode($result);
    }
    
    /* PENYESUAIAN */

    public function penyesuaian() {
        $this->hakAkses(1107);
        $this->data['etc'] = array(
            'judul' => 'Jurnal Penyesuaian',
            'targetSave' => 'transaksi_finance/savePenyesuaian',
            'targetListdata' => 'daftarPenyesuaian',
            'kstid' => '',
            'subtrans' => '0',
            'purpose' => 'ADD',
            'trans' => 'ADJUSTMENT',
            'type' => 'I',
            'mainCoa' => '',
            'costcenter' => $this->model_finance->cListCostCenter(array('cbid' => ses_cabang)),
        );
        $this->load->view('addPenyesuaian', $this->data);
    }
    
    public function daftarPenyesuaian() {
        $this->hakAkses(1107);
        $this->data['etc'] = array(
            'judul' => 'DAFTAR TRANSAKSI PENYESUAIAN',
            'trans' => 'ADJUSTMENT',
            'type' => 'I',
            'subtrans' => '0',
            'newTrans' => 'penyesuaian',
            'targetLoad' => 'loadTrans',
            'targetPrint' => 'printPenyesuaian',
            'targetCancel' => 'cancelTrans',
            'colNames' => "'TGL','NO.TRANS','DEBIT','KREDIT','STATUS','EDIT','DETAIL','PRINT','BATAL'",
            'colModel' => "{name:'kst_tgl',index:'kst_tgl', width:30, align:'left'},
                {name:'kst_nomer',index:'kst_nomer', width:40, align:'left'},
                {name:'kst_debit',index:'kst_debit', width:50, align:'right'},
                {name:'kst_kredit',index:'kst_kredit', width:50, align:'right'},
                {name:'kst_status',index:'kst_status', width:30, align:'left'},
                {name:'edit',index:'edit', width:14, align:'center'},
                {name:'print',index:'print', width:14, align:'center'},
                {name:'detail',index:'detail', width:14, align:'center'},
                {name:'batal',index:'batal', width:14, align:'center'}",
            'kategori' => " <option value='ADJUSTMENT'>PILIH</option>
                            <option value='TERCETAK'>TERCETAK</option>
                            <option value='BLM DICETAK'>BLM DICETAK</option>
                            <option value='BATAL'>BATAL</option>"
        );
        $this->load->view('dataTrans', $this->data);
    }
    
    public function editPenyesuaian() {
        $this->hakAkses(1107);
        $id = strtoupper($this->input->get('id', TRUE));
        $dataMain = $this->model_trfinance->getMainTrans(array('kstid' => $id));
        $this->data['etc'] = array(
            'judul' => 'Edit Penyesuaian : '.$dataMain['kst_nomer'],
            'targetSave' => 'transaksi_finance/savePenyesuaian',
            'targetListdata' => 'daftarPenyesuaian',
            'kstid' => $dataMain['kstid'],
            'purpose' => 'EDIT',
            'trans' => $dataMain['kst_trans'],
            'type' => $dataMain['kst_type'],
            'mainCoa' => $this->model_trfinance->getMainCoa(array('cbid' => ses_cabang, 'type' => -1)),
            'costcenter' => $this->model_finance->cListCostCenter(array('cbid' => ses_cabang)),
        );
        $this->load->view('editPenyesuaian', $this->data);
    }
    
    /* DAFTAR KAS */

    public function loadTrans() {
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $limit = isset($_POST['rows']) ? $_POST['rows'] : 10;
        $sidx = isset($_POST['sidx']) ? $_POST['sidx'] : 'kasid';
        $sord = isset($_POST['sord']) ? $_POST['sord'] : '';
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
            'subtrans' => isset($_POST['subtrans']) ? $_POST['subtrans'] : '',
            'key' => isset($_POST['key']) ? $_POST['key'] : '',
        );
        $query = $this->model_trfinance->loadtrans($param);
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
            if ($param['trans'] == 'KWI') {
                foreach ($query['result'] as $row) {
                    $del = "batalData('" . $row->kstid . "', '" . $row->kst_nomer . "')";
                    $pr = "cetakData('" . $row->kstid . "', '" . $row->kst_nomer . "')";
                    $hapus = ($row->kst_cancel == 1) ?'-':'<a href="javascript:void(0);" onclick="' . $del . '" title="Hapus"><i class="ace-icon fa fa-trash-o bigger-120 orange"></i>';
                    $print = ($row->kst_cancel == 1) ?'-':'<a href="javascript:void(0);" onclick="' . $pr . '" title="Cetak"><i class="ace-icon fa fa-print bigger-120 blue"></i>';
                    $detail = '<a href="#transaksi_finance/detailTrans?id=' . $row->kstid . '" title="Detail"><i class="ace-icon glyphicon glyphicon-list bigger-100"></i>';
                    $detail2 = '<a href="javascript:void(0);" onClick="detailTrans(\''.$row->kstid.'\')" title="Detail"><i class="ace-icon glyphicon glyphicon-list bigger-100"></i>';
                    $edit = ($row->kst_cancel == 1 or $row->kst_printed == 1) ?'-':'<a href="#transaksi_finance/editKwitansi?id=' . $row->kstid . '" title="Edit"><i class="ace-icon glyphicon glyphicon-pencil bigger-100"></i>';
                    $responce->rows[$i]['id'] = $row->kstid;
                    $responce->rows[$i]['cell'] = array(
                        dateToIndo($row->kst_tgl),
                        strtoupper($row->kst_nomer),
                        $row->kst_trans,
                        $row->kst_coa,
                        $row->pel_nama,
                        number_format($row->kst_debit, 2),
                        $row->kst_status,
                        $edit, $detail2, $print, $hapus);
                    $i++;
                }
            } else if ($param['trans'] == 'KAS' || $param['trans'] == 'BNK' || $param['trans'] == 'CEK') {
                foreach ($query['result'] as $row) {
                    $nominal = ($param['type'] == 'I')?$row->kst_debit:$row->kst_kredit;
                    $del = "batalData('" . $row->kstid . "', '" . $row->kst_nomer . "')";
                    $pr = "cetakData('" . $row->kstid . "', '" . $row->kst_nomer . "')";
                    $hapus = ($row->kst_cancel == 1) ?'-':'<a href="javascript:void(0);" onclick="' . $del . '" title="Hapus"><i class="ace-icon fa fa-trash-o bigger-120 orange"></i>';
                    $print = ($row->kst_cancel == 1) ?'-':'<a href="javascript:void(0);" onclick="' . $pr . '" title="Cetak"><i class="ace-icon fa fa-print bigger-120 blue"></i>';
                    $detail = '<a href="#transaksi_finance/detailTrans?id=' . $row->kstid . '" title="Detail"><i class="ace-icon glyphicon glyphicon-list bigger-100"></i>';
                     $detail2 = '<a href="javascript:void(0);" onClick="detailTrans(\''.$row->kstid.'\')" title="Detail"><i class="ace-icon glyphicon glyphicon-list bigger-100"></i>';
                    $edit = ($row->kst_cancel == 1 or $row->kst_printed == 1) ?'-':'<a href="#transaksi_finance/editTrans?id=' . $row->kstid . '" title="Edit"><i class="ace-icon glyphicon glyphicon-pencil bigger-100"></i>';
                    $responce->rows[$i]['id'] = $row->kstid;
                    $responce->rows[$i]['cell'] = array(
                        dateToIndo($row->kst_tgl),
                        strtoupper($row->kst_nomer),
                        $row->kst_coa,
                        $row->kst_desc,
                        number_format($nominal, 2),
                        $row->kst_status,
                        $edit, $detail2, $print, $hapus);
                    $i++;
                }
            } else if ($param['trans'] == 'ADJUSTMENT') {
                foreach ($query['result'] as $row) {
                    $del = "batalData('" . $row->kstid . "', '" . $row->kst_nomer . "')";
                    $pr = "cetakData('" . $row->kstid . "', '" . $row->kst_nomer . "')";
                    $hapus = ($row->kst_cancel == 1) ?'-':'<a href="javascript:void(0);" onclick="' . $del . '" title="Hapus"><i class="ace-icon fa fa-trash-o bigger-120 orange"></i>';
                    $print = ($row->kst_cancel == 1) ?'-':'<a href="javascript:void(0);" onclick="' . $pr . '" title="Cetak"><i class="ace-icon fa fa-print bigger-120 blue"></i>';
                    $detail = '<a href="#transaksi_finance/detailTrans?id=' . $row->kstid . '" title="Detail"><i class="ace-icon glyphicon glyphicon-list bigger-100"></i>';
                    $edit = ($row->kst_cancel == 1 or $row->kst_printed == 1) ?'-':'<a href="#transaksi_finance/editPenyesuaian?id=' . $row->kstid . '" title="Edit"><i class="ace-icon glyphicon glyphicon-pencil bigger-100"></i>';
                    $responce->rows[$i]['id'] = $row->kstid;
                    $responce->rows[$i]['cell'] = array(
                        dateToIndo($row->kst_tgl),
                        strtoupper($row->kst_nomer),
                        number_format($row->kst_debit, 2),
                        number_format($row->kst_kredit, 2),
                        $row->kst_status,
                        $edit, $detail, $print, $hapus);
                    $i++;
                }
            }
        }
        echo json_encode($responce);
    }

    public function saveTrans() {
        $main = array(
            'kst_trans' => $this->input->post('trans_trans', TRUE),
            'kst_type' => $this->input->post('trans_type', TRUE),
            'kst_nomer' => strtoupper($this->input->post('trans_docno', TRUE)),
            'kst_noreff' => $this->input->post('trans_noreff', TRUE),
            'kst_tgl' => dateToIndo($this->input->post('trans_tgl', TRUE)),
            'kst_coa' => $this->input->post('trans_coa', TRUE),
            'kst_desc' => strtoupper($this->input->post('trans_desc', TRUE)),
            'kst_debit' => numeric($this->input->post('totalTrans', TRUE)),
            'kst_kredit' => numeric($this->input->post('totalTrans', TRUE)),
            'kst_createon' => date('Y-m-d H:i:s'),
            'kst_sub_trans' => $this->input->post('trans_sub_trans', TRUE),
            'kst_createby' => ses_krid,
            'kst_cbid' => ses_cabang,
        );

        $detail = array(
            'coa' => $this->input->post('dtrans_coa', TRUE),
            'desc' => $this->input->post('dtrans_desc', TRUE),
            'nota' => $this->input->post('dtrans_notaid', TRUE),
            'pelid' => $this->input->post('dtrans_pelid', TRUE),
            'supid' => $this->input->post('dtrans_supid', TRUE),
            'ccid' => $this->input->post('dtrans_ccid', TRUE),
            'nominal' => $this->input->post('dtrans_nominal', TRUE)
        );

        $bank = array(
            'bank' => $this->input->post('dbnk_bankid', TRUE),
            'norek' => $this->input->post('dbnk_norek', TRUE),
            'nocek' => $this->input->post('dbnk_nocek', TRUE),
            'jtempo' => $this->input->post('dbnk_jtempo', TRUE),
            'kota' => $this->input->post('dbnk_kotaid', TRUE),
            'nominal' => $this->input->post('dbnk_nominal', TRUE)
        );

        $etc = array(
            'purpose' => $this->input->post('trans_purpose', TRUE),
            'kstid' => $this->input->post('trans_kstid', TRUE)
        );

        $save = $this->model_trfinance->addTrans($etc, $main, $detail, $bank);

        if ($save['status'] == TRUE) {
            $result = array('status' => TRUE, 'msg' => $this->sukses($save['msg']));
        } else {
            $result = array('status' => FALSE, 'msg' => $this->error($save['msg']));
        }

        echo json_encode($result);
    }
    
    public function savePenyesuaian() {
        $main = array(
            'kst_trans' => $this->input->post('trans_trans', TRUE),
            'kst_type' => $this->input->post('trans_type', TRUE),
            'kst_coa' => '',
            'kst_nomer' => strtoupper($this->input->post('trans_docno', TRUE)),
            'kst_noreff' => $this->input->post('trans_noreff', TRUE),
            'kst_tgl' => dateToIndo($this->input->post('trans_tgl', TRUE)),
            'kst_desc' => strtoupper($this->input->post('trans_desc', TRUE)),
            'kst_debit' => numeric($this->input->post('totalDebit', TRUE)),
            'kst_kredit' => numeric($this->input->post('totalKredit', TRUE)),
            'kst_createon' => date('Y-m-d H:i:s'),
            'kst_sub_trans' => $this->input->post('trans_sub_trans', TRUE),
            'kst_createby' => ses_krid,
            'kst_cbid' => ses_cabang,
        );

        $detail = array(
            'coa' => $this->input->post('dtrans_coa', TRUE),
            'desc' => $this->input->post('dtrans_desc', TRUE),
            'nota' => $this->input->post('dtrans_notaid', TRUE),
            'pelid' => $this->input->post('dtrans_pelid', TRUE),
            'supid' => $this->input->post('dtrans_supid', TRUE),
            'ccid' => $this->input->post('dtrans_ccid', TRUE),
            'debit' => $this->input->post('dtrans_debit', TRUE),
            'kredit' => $this->input->post('dtrans_kredit', TRUE)
        );

        $bank = array();

        $etc = array(
            'purpose' => $this->input->post('trans_purpose', TRUE),
            'kstid' => $this->input->post('trans_kstid', TRUE)
        );

        $save = $this->model_trfinance->addTrans($etc, $main, $detail, $bank);

        if ($save['status'] == TRUE) {
            $result = array('status' => TRUE, 'msg' => $this->sukses($save['msg']));
        } else {
            $result = array('status' => FALSE, 'msg' => $this->error($save['msg']));
        }

        echo json_encode($result);
    }
    
    public function saveSubTrans() {
        $main = array(
            'kst_trans' => $this->input->post('trans_trans', TRUE),
            'kst_type' => $this->input->post('trans_type', TRUE),
            'kst_nomer' => strtoupper($this->input->post('trans_docno', TRUE)),
            'kst_noreff' => $this->input->post('trans_noreff', TRUE),
            'kst_tgl' => dateToIndo($this->input->post('trans_tgl', TRUE)),
            'kst_coa' => $this->input->post('trans_coa', TRUE),
            'kst_desc' => strtoupper($this->input->post('trans_desc', TRUE)),
            'kst_debit' => numeric($this->input->post('totalTrans', TRUE)),
            'kst_kredit' => numeric($this->input->post('totalTrans', TRUE)),
            'kst_createon' => date('Y-m-d H:i:s'),
            'kst_sub_trans' => $this->input->post('trans_subtrans', TRUE),
            'kst_createby' => ses_krid,
            'kst_cbid' => ses_cabang,
        );

        $detail = array(
            'coa' => $this->input->post('dtrans_coa', TRUE),
            'desc' => $this->input->post('trans_desc', TRUE),
            'nota' => $this->input->post('dtrans_nota', TRUE),
            'pelid' => $this->input->post('dtrans_pelid', TRUE),
            'supid' => $this->input->post('dtrans_supid', TRUE),
            'ccid' => $this->input->post('dtrans_ccid', TRUE),
            'nominal' => $this->input->post('dtrans_nominal', TRUE)
        );

        $bank = array(
            'bank' => $this->input->post('dbnk_bankid', TRUE),
            'norek' => $this->input->post('dbnk_norek', TRUE),
            'nocek' => $this->input->post('dbnk_nocek', TRUE),
            'jtempo' => $this->input->post('dbnk_jtempo', TRUE),
            'kota' => $this->input->post('dbnk_kotaid', TRUE),
            'nominal' => $this->input->post('dbnk_nominal', TRUE)
        );

        $etc = array(
            'purpose' => $this->input->post('trans_purpose', TRUE),
            'kstid' => $this->input->post('trans_kstid', TRUE)
        );

        $save = $this->model_trfinance->addSubTrans($etc, $main, $detail, $bank);

        if ($save['status'] == TRUE) {
            $result = array('status' => TRUE, 'msg' => $this->sukses($save['msg']));
        } else {
            $result = array('status' => FALSE, 'msg' => $this->error($save['msg']));
        }

        echo json_encode($result);
    }

    public function cancelTrans() {
        $id = $this->input->post('id', TRUE);
        if (empty($id)) {
            $hasil = array('status' => true, 'msg' => $this->error('Hapus data gagal'));
        } else {
            if ($this->model_trfinance->cancelTrans(array('kstid' => $id))) {
                $hasil = array('status' => true, 'msg' => $this->sukses('PEMBATALAN TRANSAKSI BERHASIL'));
            } else {
                $hasil = array('status' => false, 'msg' => $this->error('PEMBATALAN TRANSAKSI GAGAL'));
            }
        }
        echo json_encode($hasil);
    }

    public function editTrans() {
        $this->hakAkses(1051);
        $id = strtoupper($this->input->get('id', TRUE));
        $dataMain = $this->model_trfinance->getMainTrans(array('kstid' => $id));
        if($dataMain['kst_type'] == 'I'){
            $daftar = "daftar".ucwords(strtolower($dataMain['kst_trans']))."in";
        }else{
            $daftar = "daftar".ucwords(strtolower($dataMain['kst_trans']))."out";
        }
        $this->data['etc'] = array(
            'judul' => 'Edit Transaksi '.$dataMain['kst_nomer'],
            'targetSave' => 'transaksi_finance/saveTrans',
            'targetListdata' => $daftar,
            'kstid' => $dataMain['kstid'],
            'purpose' => 'EDIT',
            'trans' => $dataMain['kst_trans'],
            'type' => $dataMain['kst_type'],
            'mainCoa' => $this->model_trfinance->getMainCoa(array('cbid' => ses_cabang, 'type' => -1)),
            'costcenter' => $this->model_finance->cListCostCenter(array('cbid' => ses_cabang)),
        );
        $this->load->view('editTrans', $this->data);
    }
    
    public function getDetailTrans(){
        $kstid = $this->input->post('kstid', TRUE);
        $data['main'] = $this->model_trfinance->getMainTrans(array('kstid' => $kstid)); 
        $data['detail'] = $this->model_trfinance->getDetailTrans(array('kstid' => $kstid)); 
        $data['bank'] = $this->model_trfinance->getDetailBank(array('kstid' => $kstid)); 
        
        header("content-type: Application/json");
        echo json_encode($data);
    }

    public function getMainCoa() {
        $type = $this->input->post('type', TRUE);
        $data = $this->model_trfinance->getMainCoa($type);
        if (count($data) > 0) {
            foreach ($data as $rows) {
                echo "<option value='" . $rows['coa_kode'] . "'></option>";
            }
        }
    }

    public function jsonMainCoa() {
        $type = $this->input->post('type', TRUE);
        echo json_encode($this->model_trfinance->getMainCoa(array(
                    'cbid' => ses_cabang,
                    'type' => $type
                )));
    }

    public function saveUmTrans() {
        $t_trans = $this->input->post('trans_trans', TRUE);
        if ($t_trans == '1') {
            $trans = 'KAS';
        } else if ($t_trans == '2') {
            $trans = 'BNK';
        } else {
            $trans = 'CEK';
        }

        $main = array(
            'kst_trans' => $trans,
            'kst_type' => $this->input->post('trans_type', TRUE),
            'kst_nomer' => strtoupper($this->input->post('trans_docno', TRUE)),
            'kst_noreff' => $this->input->post('trans_noreff', TRUE),
            'kst_tgl' => $this->input->post('trans_tgl', TRUE),
            'kst_coa' => $this->input->post('trans_coa', TRUE),
            'kst_desc' => $this->input->post('trans_desc', TRUE),
            'kst_debit' => numeric($this->input->post('totalTrans', TRUE)),
            'kst_kredit' => numeric($this->input->post('totalTrans', TRUE)),
            'kst_createon' => date('Y-m-d H:i:s'),
            'kst_createby' => ses_krid,
            'kst_cbid' => ses_cabang,
        );

        $detail = array(
            'coa' => $this->input->post('dtrans_coa', TRUE),
            'desc' => $this->input->post('dtrans_desc', TRUE),
            'nota' => $this->input->post('dtrans_notaid', TRUE),
            'pelid' => $this->input->post('dtrans_pelid', TRUE),
            'supid' => $this->input->post('dtrans_supid', TRUE),
            'ccid' => $this->input->post('dtrans_ccid', TRUE),
            'nominal' => $this->input->post('dtrans_nominal', TRUE)
        );

        $bank = array(
            'bank' => $this->input->post('dbnk_bankid', TRUE),
            'norek' => $this->input->post('dbnk_norek', TRUE),
            'nocek' => $this->input->post('dbnk_nocek', TRUE),
            'jtempo' => $this->input->post('dbnk_jtempo', TRUE),
            'kota' => $this->input->post('dbnk_kotaid', TRUE),
            'nominal' => $this->input->post('dbnk_nominal', TRUE)
        );

        $etc = array(
            'purpose' => $this->input->post('trans_purpose', TRUE),
            'kstid' => $this->input->post('trans_id', TRUE)
        );

        $save = $this->model_trfinance->addTrans($etc, $main, $detail, $bank);

        if ($save['status'] == TRUE) {
            $result = array('status' => TRUE, 'msg' => $this->sukses($save['msg']));
        } else {
            $result = array('status' => FALSE, 'msg' => $this->error($save['msg']));
        }

        echo json_encode($result);
    }
    
    public function updatePrint(){
        $id = $this->input->post('id', TRUE);
        $data = $this->model_trfinance->updatePrintStat($id);
        echo json_encode($data);
    }

    public function printTrans($id) {
        $this->data['main'] = $this->model_trfinance->getMainTrans(array('kstid' => $id));
        $judul = "BUKTI ";
        if($this->data['main']['kst_type'] == 'I'){
            $judul .= "PENERIMAAN ".$this->data['main']['kst_trans'];
        }else{
            $judul .= "PENGELUARAN ".$this->data['main']['kst_trans'];
        }
        $this->data['judul'] = $judul;
        $this->data['detail'] = $this->model_trfinance->getDetailTrans(array('kstid' => $id));
        $this->data['bank'] = $this->model_trfinance->getDetailBank(array('kstid' => $id));
        $this->load->view('printTrans', $this->data);
    }
    
    public function printKwitansi($id){
        $this->data['main'] = $this->model_trfinance->getMainTrans($id);
        $this->data['detail'] = $this->model_trfinance->getDataTrans($id);
        $this->data['bank'] = $this->model_trfinance->getDetailBank($id);
        $this->load->view('printKwitansi', $this->data);
    }
    
    public function printPenyesuaian($id){
        $this->data['main'] = $this->model_trfinance->getMainTrans($id);
        $this->data['detail'] = $this->model_trfinance->getDataTrans($id);
        $this->data['bank'] = $this->model_trfinance->getDetailBank($id);
        $this->load->view('printPenyesuaian', $this->data);
    }
    
    public function viewDetailTrans(){
        $kstid = $this->input->post('kstid', TRUE);
        $data['main'] = $this->model_trfinance->getMainTrans(array('kstid' => $kstid)); 
        $data['detail'] = $this->model_trfinance->getDetailTrans(array('kstid' => $kstid)); 
        $data['bank'] = $this->model_trfinance->getDetailBank(array('kstid' => $kstid)); 
        
        $this->load->view('viewDetailTrans');
    }
}

?>
