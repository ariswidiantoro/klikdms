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
        $this->load->model('model_lap_service');
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
    public function agendaFaktur() {
        $this->hakAkses(41);
        $this->data['link'] = 'showAgendaFaktur';
        $this->load->view('agendaWo', $this->data);
    }

    /**
     * 
     */
    public function statusWo() {
        $this->hakAkses(42);
        $this->data['link'] = 'showStatusWo';
        $this->load->view('agendaWo', $this->data);
    }

    /*
     * 
     */

    public function woBelumDitutup() {
        $this->hakAkses(43);
        $this->data['link'] = 'showWoBelumDitutup';
        $this->load->view('woBelumDitutup', $this->data);
    }

    /**
     * 
     */
    public function agendaWo() {
        $this->hakAkses(40);
        $this->data['link'] = 'showAgendaWo';
        $this->load->view('agendaWo', $this->data);
    }

    /**
     * 
     */
    public function ssdr() {
        $this->load->model('model_admin');
        $this->hakAkses(44);
        $this->data['link'] = 'ssdr';
        $this->data['link'] = 'showSsdr';
        $this->data['sa'] = $this->model_admin->getKaryawanByJabatan(JAB_SVC_SA_FRONTMAN);
        $this->data['mekanik'] = $this->model_admin->getKaryawanByJabatan(JAB_SVC_MEKANIK);
        $this->data['checker'] = $this->model_admin->getKaryawanByJabatan(JAB_SVC_FINAL_CHECKER);
        $this->load->view('ssdr', $this->data);
    }
    /**
     * 
     */
    public function ssdrPlusHpp() {
        $this->load->model('model_admin');
        $this->hakAkses(45);
        $this->data['link'] = 'ssdr';
        $this->data['link'] = 'showssdrPlusHpp';
        $this->data['sa'] = $this->model_admin->getKaryawanByJabatan(JAB_SVC_SA_FRONTMAN);
        $this->data['mekanik'] = $this->model_admin->getKaryawanByJabatan(JAB_SVC_MEKANIK);
        $this->data['checker'] = $this->model_admin->getKaryawanByJabatan(JAB_SVC_FINAL_CHECKER);
        $this->load->view('ssdr', $this->data);
    }

    /**
     * 
     * @param type $output
     */
    public function showAgendaWo($output) {
        $end = dateToIndo($this->input->post('end'));
        $start = dateToIndo($this->input->post('start'));
        $cabang = ses_cabang;
        $this->data['data'] = $this->model_lap_service->getAgendaWo($start, $end, $cabang);
        $this->data['output'] = $output;
        $this->load->view('showAgendaWo', $this->data);
    }

    /**
     * 
     * @param type $output
     */
    public function showSsdr($output) {
        $type = $this->input->post('type');
        $param = array(
            'start' => dateToIndo($this->input->post('start_' . $type)),
            'end' => dateToIndo($this->input->post('end_' . $type)),
            'sa' => $this->input->post('sa'),
            'mekanik' => $this->input->post('mekanik'),
            'checker' => $this->input->post('checker'),
            'inextern' => $this->input->post('inextern'),
            'type' => $type,
            'cbid' => ses_cabang,
        );
        $this->data['data'] = $this->model_lap_service->getSsdr($param);
        $this->data['output'] = $output;
        $this->load->view('showSsdr', $this->data);
    }

    public function showWoBelumDitutup($output) {
        $tgl = dateToIndo($this->input->post('start'));
        $cabang = ses_cabang;
        $this->data['data'] = $this->model_lap_service->getWoBelumDitutup($tgl, $cabang);
        $this->data['output'] = $output;
        $this->load->view('showWoBelumDitutup', $this->data);
    }

    /**
     * 
     * @param type $output
     */
    public function showStatusWo($output) {
        $end = dateToIndo($this->input->post('end'));
        $start = dateToIndo($this->input->post('start'));
        $cabang = ses_cabang;
        $this->data['data'] = $this->model_lap_service->getStatusWo($start, $end, $cabang);
        $this->data['output'] = $output;
        $this->load->view('showStatusWo', $this->data);
    }

    /**
     * 
     * @param type $output
     */
    public function showAgendaFaktur($output) {
        $end = dateToIndo($this->input->post('end'));
        $start = dateToIndo($this->input->post('start'));
        $cabang = ses_cabang;
        $this->data['data'] = $this->model_lap_service->getAgendaFakturService($start, $end, $cabang);
        $this->data['output'] = $output;
        $this->load->view('showAgendaFaktur', $this->data);
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
