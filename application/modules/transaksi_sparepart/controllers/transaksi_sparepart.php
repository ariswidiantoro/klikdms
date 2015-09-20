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
        $this->load->model(array('model_trspart'));
    }

    public function index() {
//        $this->addProspect();
    }

    public function penerimaanBarang() {
        $this->hakAkses(57);
        $this->load->view('penerimaanBarang', $this->data);
    }

    function jsonFakturTerima() {
        $faktur = $this->input->post('param');
        $cbid = ses_cabang;
        $data['response'] = 'false';
        $query = $this->model_trspart->getFakturTerimaAutoComplete($faktur);
        if (!empty($query)) {
            $data['response'] = 'true';
            $data['message'] = array();
            foreach ($query as $row) {
                $data['message'][] = array(
                    'value' => $row['trbr_faktur'],
                    'supid' => $row['trbr_supid'],
                    'desc' => $row['sup_nama'],
                    'id' => $row['trbrid']);
            }
        } else {
            $data['message'][] = array('value' => '', 'label' => "Data Tidak Ada");
        }
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
                'trbr_faktur' => strtoupper($this->input->post('trbr_faktur')),
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
            $data = array(
                'spp_tgl' => date('Y-m-d'),
                'spp_createon' => date('Y-m-d H:i:s'),
                'spp_createby' => ses_username,
                'spp_pelid' => $this->input->post('spp_pelid'),
                'spp_pay_method' => $this->input->post('spp_pay_method'),
                'spp_kredit_term' => $term,
                'spp_jenis' => $this->input->post('spp_jenis'),
                'spp_total' => numeric($this->input->post('spp_total')),
                'spp_cbid' => ses_cabang,
            );
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
//                    'dsupp_subtotal_hpp' => $subTotalHpp,
                );
            }
            $data['spp_total_hpp'] = $totalHpp;
            $return = $this->model_trspart->saveSupplySlip($data, $detail);
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
        }
        echo json_encode($return);
    }

    function printTerimaBarang($kode) {
        $this->data['faktur'] = $this->model_trspart->dataFakturTerima($kode);
        $this->data['barang'] = $this->model_trspart->dataFakturTerimaDetail($kode);
        $this->load->view('printTerimaBarang', $this->data);
    }

    function printReturBeli($kode) {
        $this->data['faktur'] = $this->model_trspart->dataReturBeli($kode);
        $this->data['barang'] = $this->model_trspart->dataReturBeliDetail($kode);
        $this->load->view('printReturBeli', $this->data);
    }

}

?>
