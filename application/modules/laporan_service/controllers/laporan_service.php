<?php

/**
 * Class Admin_Controller
 * @author Aris
 * 2013-11-11
 */
class Laporan_Service extends Application {

    /**
     * The new Admin_controller
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('model_admin');
        $this->load->model('model_service');
        $this->isLogin();
    }

    public function index() {
        $this->data['content'] = 'service';
        $this->data['menuid'] = '4';
        $this->load->view('template', $this->data);
    }

    /**
     * This function is used for display menu form
     * @author Aris
     * @since 1.0
     */
    public function agendaWo() {
        $this->hakAkses(40);
        $this->load->view('agendaWo', $this->data);
    }

    /**
     * This function is used for display menu form
     * @author Aris
     * @since 1.0
     */
    public function pelanggan() {
        $this->hakAkses(28);
        $this->load->view('pelanggan', $this->data);
    }


}

?>
