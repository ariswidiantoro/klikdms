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

}

?>