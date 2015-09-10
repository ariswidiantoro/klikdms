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
    public function returPembelian() {
        $this->hakAkses(58);
        $this->load->view('returPembelian', $this->data);
    }

    function savePenerimaanBarang() {
        $return = false;
        $this->form_validation->set_rules('trbr_faktur', '<b>Fx</b>', 'required|callback_validtelp|xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $term = $this->input->post('trbr_credit_term');
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
                'trbr_credit_term' => $term,
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

    function printTerimaBarang($kode) {
        $this->data['faktur'] = $this->model_trspart->dataFakturTerima($kode);
        $this->data['barang'] = $this->model_trspart->dataFakturTerimaDetail($kode);
        $this->load->view('printTerimaBarang', $this->data);
    }

}

?>