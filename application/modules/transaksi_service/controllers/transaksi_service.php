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
        $this->load->model(array('model_trservice'));
    }

    public function index() {
//        $this->addProspect();
    }

    function jsonWo() {
        $woNomer = $this->input->post('param');
        $retur = array();
        $data = $this->model_trservice->getWo($woNomer);
        $retur['response'] = false;
        if (count($data) > 0) {
            $retur['response'] = true;
            $retur['data'] = $data;
        }
        echo json_encode($retur);
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
        $data['response'] = 'false';
        $nopol = strtoupper(str_replace(" ", "", $this->input->post('param')));
        $query = $this->model_trservice->getNopol($nopol);
        if (count($query) > 0) {
            $data['response'] = 'true';
            $data['message'] = array();
            foreach ($query as $row) {
                $nopol = $row['msc_nopol'];
                $data['message'][] = array(
                    'value' => $nopol,
                    'mscid' => $row['mscid'],
                    'desc' => $row['msc_norangka']
                );
            }
        } else {
            $data['message'][] = array('value' => 'Data Tidak Ditemukan', 'label' => "Data Tidak Ada", 'desc' => '');
        }
        echo json_encode($data);
    }

    function getFlateRateAuto() {
        $data['response'] = 'false';
        $param = strtoupper(str_replace(" ", "", $this->input->post('term')));
        $query = $this->model_trservice->getFlateRateAuto($param, $this->input->post('type'));
        if (count($query) > 0) {
            $data['response'] = 'true';
            $data['message'] = array();
            foreach ($query as $row) {
                $data['message'][] = array(
                    'value' => $row['flat_kode'],
                    'flatid' => $row['flatid'],
                    'desc' => $row['flat_deskripsi']
                );
            }
        } else {
            $data['message'][] = array('value' => 'Data Tidak Ditemukan', 'label' => "Data Tidak Ada", 'desc' => '');
        }
        echo json_encode($data);
    }

    public function workOrder() {
        $this->hakAkses(57);
        $this->data['jenis'] = $this->model_trservice->getWoJenis();
        $this->load->view('workOrder', $this->data);
    }

    public function serviceOrder() {
        $this->hakAkses(57);
        $this->data['stall'] = $this->model_trservice->getStall();
        $this->data['jenis'] = $this->input->GET('jenis');
        $this->data['type'] = $this->input->GET('type');
        $this->load->view('serviceOrder', $this->data);
    }

}

?>