<?php

/**
 * Class Laporan Finance
 * @author Rossi Erl
 * 2015-09-04
 */
class Laporan_Prospect extends Application {

    public function __construct() {
        parent::__construct();
        $this->load->model(array(
            'model_lap_prospect'
        ));
        $this->isLogin();
    }

    public function index() {
        echo "ARE YOU LOST ? ";
    }

    /**
     * 
     */
    function rincianProspect() {
        $this->hakAkses(96);
        $this->data['link'] = 'showRincianProspect';
        $this->load->view('prospectForm', $this->data);
    }

    /**
     * 
     */
    function rincianFpt() {
        $this->hakAkses(99);
        $this->data['link'] = 'showRincianFpt';
        $this->load->view('fptForm', $this->data);
    }

    /**
     * 
     */
    function rekapHarian() {
        $this->hakAkses(97);
        $this->data['link'] = 'showRekapHarian';
        $this->load->view('prospectForm', $this->data);
    }

    /**
     * 
     */
    function rekapBulanan() {
        $this->hakAkses(98);
        $this->data['link'] = 'showRekapBulanan';
        $this->load->view('prospectBulananForm', $this->data);
    }

    /**
     * 
     */
    function rekapFptBulanan() {
        $this->hakAkses(100);
        $this->data['link'] = 'showRekapFptBulanan';
        $this->load->view('prospectBulananForm', $this->data);
    }

    /**
     * 
     */
    function activitySalesman() {
        $this->hakAkses(1066);
        $this->data['link'] = 'showActivitySalesman';
        $this->load->view('prospectForm', $this->data);
    }

    /**
     * 
     */
    function followup() {
        $this->hakAkses(1063);
        $this->data['link'] = 'showFollowUp';
        $this->load->view('prospectForm', $this->data);
    }

    /**
     * 
     * @param type $output
     */
    public function showRincianProspect($output) {
        $end = dateToIndo($this->input->post('end'));
        $start = dateToIndo($this->input->post('start'));
        $cabang = ses_cabang;
        $this->data['data'] = $this->model_lap_prospect->getRincianProspect($start, $end, $cabang);
        $this->data['output'] = $output;
        $this->load->view('showRincianProspect', $this->data);
    }

    public function showFollowUp($output) {
        $end = dateToIndo($this->input->post('end'));
        $start = dateToIndo($this->input->post('start'));
        $cabang = ses_cabang;
        $this->data['data'] = $this->model_lap_prospect->getRincianProspect($start, $end, $cabang);
        $this->data['output'] = $output;
        $this->load->view('showRincianProspect', $this->data);
    }

    /**
     * 
     * @param type $output
     */
    public function showActivitySalesman($output) {
        $end = dateToIndo($this->input->post('end'));
        $start = dateToIndo($this->input->post('start'));
        $cabang = ses_cabang;
        $this->data['data'] = $this->model_lap_prospect->getTotalProspect($start, $end, $cabang);
        $this->data['agenda'] = $this->model_lap_prospect->getTotalAgenda($start, $end, $cabang);
        $this->data['follow'] = $this->model_lap_prospect->getTotalFollow($start, $end, $cabang);
        $this->data['fpt'] = $this->model_lap_prospect->getTotalFpt($start, $end, $cabang);
        $this->data['spk'] = $this->model_lap_prospect->getTotalSpk($start, $end, $cabang);
        $this->data['faktur'] = $this->model_lap_prospect->getTotalFaktur($start, $end, $cabang);
        $this->data['output'] = $output;
        $this->load->view('showActivitySalesman', $this->data);
    }

    /**
     * 
     * @param type $output
     */
    public function showRincianFpt($output) {
        $end = dateToIndo($this->input->post('end'));
        $start = dateToIndo($this->input->post('start'));
        $status = $this->input->post('status');
        $cabang = ses_cabang;
        $this->data['data'] = $this->model_lap_prospect->getRincianFpt($start, $end, $cabang, $status);
        $this->data['output'] = $output;
        $this->load->view('showRincianFpt', $this->data);
    }

    /**
     * 
     * @param type $output
     */
    public function showRekapHarian($output) {
        $end = dateToIndo($this->input->post('end'));
        $start = dateToIndo($this->input->post('start'));
        $cabang = ses_cabang;
        $this->data['data'] = $this->model_lap_prospect->getProspectHarian($start, $end, $cabang);
        $this->data['output'] = $output;
        $this->load->view('showRekapHarian', $this->data);
    }

    /**
     * 
     * @param type $output
     */
    public function showRekapBulanan($output) {
        $tahun = dateToIndo($this->input->post('start'));
        $cabang = ses_cabang;
        $this->data['data'] = $this->model_lap_prospect->getProspectBulanan($tahun, $cabang);
        $this->data['output'] = $output;
        $this->load->view('showRekapBulanan', $this->data);
    }

    /**
     * 
     * @param type $output
     */
    public function showRekapFptBulanan($output) {
        $tahun = dateToIndo($this->input->post('start'));
        $cabang = ses_cabang;
        $this->data['data'] = $this->model_lap_prospect->getFptBulanan($tahun, $cabang);
        $this->data['output'] = $output;
        $this->load->view('showRekapFptBulanan', $this->data);
    }

}

?>
