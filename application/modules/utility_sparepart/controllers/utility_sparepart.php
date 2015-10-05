<?php

/**
 * Class Admin_Controller
 * @author Aris
 * 2013-11-11
 */
class Utility_Sparepart extends Application {

    /**
     * The new Admin_controller
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('model_util_sparepart');
        $this->isLogin();
    }

    public function index() {
        $this->data['content'] = 'sparepart';
        $this->data['menuid'] = '3';
        $this->load->view('template', $this->data);
    }

    /**
     * This function is used for display menu form
     * @author Aris
     * @since 1.0
     */
    public function supplySlip() {
        $this->hakAkses(90);
        $this->load->view('supplySlip', $this->data);
    }


}

?>
