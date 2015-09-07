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
//        $this->load->model(array('model_admin', 'model_prospect'));
    }

    public function index() {
//        $this->addProspect();
    }

    public function penerimaanBarang() {
        $this->hakAkses(57);
        $this->load->view('penerimaanBarang', $this->data);
    }

}

?>