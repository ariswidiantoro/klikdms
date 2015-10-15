<?php
/**
 * Class Auto_Complete
 * @author rosoningati@gmail.com 
 * 2015-09-04
 */
class Auto_Complete extends Application {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('model_autocomplete'));
        $this->isLogin();
    }

    public function index() {
        echo "";
    }
    
    /* FINANCE */
    
    public function auto_coa() {
        $param = $this->input->post('param');
        $cbid = $this->input->post('cbid');
        $query = $this->model_autocomplete->autoCoa(array('param' => strtoupper($param), 'cbid' => $cbid));
        if (!empty($query)) {
            $data['message'] = array();
            foreach ($query as $row) {
                $data['message'][] = array(
                    'value' => $row['coa_kode'], 
                    'desc' => $row['coa_desc'], 
                    'type' => $row['coa_type'],
                    'trglocal' => $row['coa_kode'], 
                    'trgid' => $row['coa_desc'], 
                    'trgname' => $row['coa_desc'], 
                    );
            }
        } else {
            $data['message'][] = array('value' => '', 'desc' => "DATA TIDAK ADA");
        }
        echo json_encode($data);
    }
    
    public function auto_bank() {
        $param = $this->input->post('param');
        $cbid = $this->input->post('cbid');
        $query = $this->model_autocomplete->autoBank(array('param' => strtoupper($param), 'cbid' => $cbid));
        if (!empty($query)) {
            $data['message'] = array();
            foreach ($query as $row) {
                $data['message'][] = array(
                    'value' => $row['bank_name'], 
                    'desc' => $row['bank_desc'], 
                    'type' => $row['bankid'],
                    'trglocal' => $row['bankid'], 
                    'trgid' => $row['bankid'], 
                    'trgname' => $row['bankid'], 
                    );
            }
        } else {
            $data['message'][] = array('value' => '', 'desc' => "DATA TIDAK ADA");
        }
        echo json_encode($data);
    }
    
    public function auto_pelid() {
        $param = $this->input->post('param');
        $cbid = $this->input->post('cbid');
        $query = $this->model_autocomplete->autoPelid(array('param' => strtoupper($param), 'cbid' => $cbid));
        if (!empty($query)) {
            $data['message'] = array();
            foreach ($query as $row) {
                $data['message'][] = array(
                    'value' => $row['pel_nama'], 
                    'desc' => substr($row['pel_alamat'],0,20), 
                    'trglocal' => $row['pelid'], 
                    'trgid' => $row['pelid'], 
                    'trgname' => $row['pelid'], 
                    );
            }
        } else {
            $data['message'][] = array('value' => '', 'desc' => "DATA TIDAK ADA");
        }
        echo json_encode($data);
    }
    
    public function auto_kota() {
        $param = $this->input->post('param');
        $cbid = $this->input->post('cbid');
        $query = $this->model_autocomplete->autoKota(array('param' => strtoupper($param), 'cbid' => $cbid));
        if (!empty($query)) {
            $data['message'] = array();
            foreach ($query as $row) {
                $data['message'][] = array(
                    'value' => $row['kota_deskripsi'], 
                    'desc' => $row['prop_deskripsi'], 
                    'trglocal' => $row['kotaid'], 
                    'trgid' => $row['propid'], 
                    'trgname' => $row['prop_deskripsi'], 
                    );
            }
        } else {
            $data['message'][] = array('value' => '', 'desc' => "DATA TIDAK ADA");
        }
        echo json_encode($data);
    }

    public function auto_wo() {
        $param = $this->input->post('param');
        $cbid = $this->input->post('cbid');
        $query = $this->model_autocomplete->autoWo(array('param' => strtoupper($param), 'cbid' => $cbid));
        if (!empty($query)) {
            $data['message'] = array();
            foreach ($query as $row) {
                $data['message'][] = array('value' => $row['wo_nomer'], 'desc' => $row['msc_nopol'], 'type' => $row['wo_type']);
            }
        } else {
            $data['message'][] = array('value' => 'DATA TIDAK ADA', 'desc' => "");
        }
        echo json_encode($data);
    }

    public function auto_do() {
        $param = $this->input->post('param');
        $cbid = $this->input->post('cbid');
        $query = $this->model_autocomplete->autoDo(array('param' => strtoupper($param), 'cbid' => $cbid));
        if (!empty($query)) {
            $data['message'] = array();
            foreach ($query as $row) {
                $data['message'][] = array('value' => $row['wo_nomer'], 'desc' => $row['msc_nopol'], 'type' => $row['wo_type']);
            }
        } else {
            $data['message'][] = array('value' => 'DATA TIDAK ADA', 'desc' => "");
        }
        echo json_encode($data);
    }

}

?>
