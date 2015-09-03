<?php

/**
 * Class Admin_Controller
 * @author Rossi
 * 2013-11-11
 */
class Prospect extends Application {

    /**
     * The new Admin_controller
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('model_admin');
    }

    public function index() {
        $this->data['content'] = 'prospect';
        $this->data['header'] = $this->model_admin->getMenuModule();
        $this->data['menuid'] = '1057';
        $this->load->view('template', $this->data);
    }
}
?>