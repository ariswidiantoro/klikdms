<?php

/**
 * Class Master
 * @author Rossi Erl
 * 2015-09-04
 */
class Master_Finance extends Application {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('model_admin', 'model_sales', 'model_finance'));
        $this->isLogin();
    }

    public function index() {
        echo " ";
    }

    public function coa() {
        $this->hakAkses(1051);
        $this->load->view('dataCoa', $this->data);
    }

    public function loadCoa() {
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $limit = isset($_POST['rows']) ? $_POST['rows'] : 10;
        $sidx = isset($_POST['sidx']) ? $_POST['sidx'] : 'merkid';
        $sord = isset($_POST['sord']) ? $_POST['sord'] : '';
        $start = $limit * $page - $limit;
        $start = ($start < 0) ? 0 : $start;
        $where = whereLoad();
        $count = $this->model_finance->getTotalCoa($where);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;
        $query = $this->model_finance->getDataCoa($start, $limit, $sidx, $sord, $where);
        $responce = new stdClass;
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
        $i = 0;
        if (count($query) > 0)
            foreach ($query as $row) {
                $del = "hapusData('" . $row->coaid . "', '" . $row->coa_kode . "')";
                $hapus = '<a href="javascript:void(0);" onclick="' . $del . '" title="Hapus"><i class="ace-icon fa fa-trash-o bigger-120 orange"></i>';
                $edit = '<a href="#master_finance/editCoa?id=' . $row->coaid . '" title="Edit"><i class="ace-icon glyphicon glyphicon-pencil bigger-100"></i>';
                $responce->rows[$i]['id'] = $row->coaid;
                $responce->rows[$i]['cell'] = array(
                    $row->coa_kode,
                    $row->coa_desc,
                    $row->coa_type,
                    $row->coa_level,
                    $edit, $hapus);
                $i++;
            }
        echo json_encode($responce);
    }

    public function addCoa() {
        $this->hakAkses(1051);
        $this->load->view('addCoa', $this->data);
    }

    public function editCoa() {
        $this->hakAkses(1051);
        $id = $this->input->get('id');
        $data = $this->model_finance->getCoa($id);
        $this->data['data'] = $data;
        $this->load->view('editCoa', $this->data);
    }

    public function getCoa() {
        $data = $this->input->get('coaid', TRUE);
        $result = $this->model_finance->getCoa($data);
        $responce = array();
        if (count($result) > 0)
            $responce = $result;
        echo json_encode($responce);
    }

    public function saveCoa() {
        $kode = strtoupper($this->input->post('coa_kode', TRUE));
        $desc = strtoupper($this->input->post('coa_desc', TRUE));
        $type = strtoupper($this->input->post('coa_type', TRUE));
        $level = strtoupper($this->input->post('coa_level', TRUE));
        if (empty($kode) || empty($desc) || empty($type) || empty($level)) {
            $hasil = $this->error('INPUT TIDAK LENGKAP, SILAHKAN CEK KEMBALI');
        } else {
            $save = $this->model_finance->addCoa(
                    array(
                        'coa_kode' => $kode,
                        'coa_desc' => $desc,
                        'coa_type' => $type,
                        'coa_level' => $level,
                        'coa_is_rugilaba' => $this->input->post('rugi_laba'),
                        'coa_is_neraca' => $this->input->post('neraca'),
                        'coa_cbid' => ses_cabang
                        ));
            if ($save['status'] == TRUE) {
                $hasil = $this->sukses($save['msg']);
            } else {
                $hasil = $this->error($save['msg']);
            }
        }
        echo json_encode($hasil);
    }

    public function updateCoa() {
        $coaid = $this->input->post('coaid', TRUE);
        $kode = strtoupper($this->input->post('coa_kode', TRUE));
        $desc = strtoupper($this->input->post('coa_desc', TRUE));
        $type = strtoupper($this->input->post('coa_type', TRUE));
        $level = strtoupper($this->input->post('coa_level', TRUE));
        if (empty($kode) || empty($desc) || empty($type) || empty($level)) {
            $hasil = $this->error('INPUT TIDAK LENGKAP, SILAHKAN CEK KEMBALI');
        } else {
            $save = $this->model_finance->updateCoa(array('coa_kode' => $kode,
                'coa_desc' => $desc, 'coa_type' => $type, 'coa_level' => $level), $coaid);
            if ($save['status'] == TRUE) {
                $hasil = $this->sukses($save['msg']);
            } else {
                $hasil = $this->error($save['msg']);
            }
        }
        echo json_encode($hasil);
    }

    public function deleteCoa() {
        $coaid = $this->input->post('id', TRUE);
        if (empty($coaid)) {
            $hasil = $this->error('Hapus data gagal');
        } else {
            if ($this->model_finance->deleteCoa($coaid)) {
                $hasil = $this->sukses('Hapus data berhasil');
            } else {
                $hasil = $this->error('Hapus data gagal');
            }
        }
        echo json_encode($hasil);
    }

    /* Function Cost Center
     * @author Rossi 
     * 2015-09-07
     */

    public function cost_center() {
        $this->hakAkses(1052);
        $this->load->view('dataCostCenter', $this->data);
    }

    public function addCostCenter() {
        $this->hakAkses(1052);
        $this->load->view('addCostCenter', $this->data);
    }

    public function loadCostCenter() {
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $limit = isset($_POST['rows']) ? $_POST['rows'] : 10;
        $sidx = isset($_POST['sidx']) ? $_POST['sidx'] : 'ccid';
        $sord = isset($_POST['sord']) ? $_POST['sord'] : '';
        $start = $limit * $page - $limit;
        $start = ($start < 0) ? 0 : $start;
        $where = whereLoad();
        $count = $this->model_finance->getTotalCostCenter($where);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;
        $query = $this->model_finance->getAllCostCenter($start, $limit, $sidx, $sord, $where);
        $responce = new stdClass;
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
        $i = 0;
        if (count($query) > 0)
            foreach ($query as $row) {
                $del = "hapusData('" . $row->ccid . "', '" . $row->cc_name . "')";
                $hapus = '<a href="javascript:void(0);" onclick="' . $del . '" title="Hapus"><i class="ace-icon fa fa-trash-o bigger-120 orange"></i>';
                $edit = '<a href="#master_finance/editCostcenter?id=' . $row->ccid . '" title="Edit"><i class="ace-icon glyphicon glyphicon-pencil bigger-100"></i>';
                $responce->rows[$i]['id'] = $row->ccid;
                $responce->rows[$i]['cell'] = array(
                    $row->cc_kode,
                    $row->cc_name, $edit, $hapus);
                $i++;
            }
        echo json_encode($responce);
    }

    public function geCostCenter() {
        $data = array('ccid' => $this->input->post('ccid', TRUE));
        $result = $this->model_finance->getCostCenter($data);
        $responce = array();
        if (count($result) > 0)
            $responce = $result;
        echo json_encode($responce);
    }

    public function saveCostCenter() {
        $kode = $this->input->post('cc_kode', TRUE);
        $desc = $this->input->post('cc_name', TRUE);
        if (empty($kode) || empty($desc)) {
            $hasil = $this->error('INPUT TIDAK LENGKAP, SILAHKAN CEK KEMBALI');
        } else {
            $save = $this->model_finance->addCostCenter(array('cc_kode' => strtoupper($kode),
                'cc_name' => strtoupper($desc), 'cc_cbid' => ses_cabang, 'cc_flag' => '1'));
            if ($save['status'] == TRUE) {
                $hasil = $this->sukses($save['msg']);
            } else {
                $hasil = $this->error($save['msg']);
            }
        }
        echo json_encode($hasil);
    }

    public function editCostCenter() {
        $this->hakAkses(1052);
        $id = $this->input->get('id');
        $data = $this->model_finance->getCostCenter($id);
        $this->data['data'] = $data;
        $this->load->view('editCostCenter', $this->data);
    }

    public function updateCostCenter() {
        $id = $this->input->post('ccid', TRUE);
        $kode = $this->input->post('cc_kode', TRUE);
        $nama = $this->input->post('cc_name', TRUE);
        if (empty($id) || empty($kode) || empty($nama)) {
            $hasil = $this->error('INPUT TIDAK LENGKAP, SILAHKAN CEK KEMBALI');
        } else {
            $save = $this->model_finance->updateCostCenter(array('cc_kode' => strtoupper($kode),
                'cc_name' => strtoupper($nama), 'cc_cbid' => ses_cabang, 'cc_flag' => '1'), $id);
            if ($save['status'] == TRUE) {
                $hasil = $this->sukses($save['msg']);
            } else {
                $hasil = $this->error($save['msg']);
            }
        }
        echo json_encode($hasil);
    }

    public function deleteCostCenter() {
        $id = $this->input->post('id', TRUE);
        if (empty($id)) {
            $hasil = $this->error('Hapus data gagal');
        } else {
            if ($this->model_finance->deleteCostCenter($id)) {
                $hasil = $this->sukses('Hapus data berhasil');
            } else {
                $hasil = $this->error('Hapus data gagal');
            }
        }
        echo json_encode($hasil);
    }

    /* Function Master Bank
     * @author Rossi 
     * 2015-09-08
     */

    public function bank() {
        $this->hakAkses(1053);
        $this->load->view('dataBank', $this->data);
    }

    public function addBank() {
        $this->hakAkses(1053);
        $this->load->view('addBank', $this->data);
    }

    public function loadBank() {
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $limit = isset($_POST['rows']) ? $_POST['rows'] : 10;
        $sidx = isset($_POST['sidx']) ? $_POST['sidx'] : 'ccid';
        $sord = isset($_POST['sord']) ? $_POST['sord'] : '';
        $start = $limit * $page - $limit;
        $start = ($start < 0) ? 0 : $start;
        $where = whereLoad();
        $count = $this->model_finance->getTotalBank($where);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;
        $query = $this->model_finance->getAllBank($start, $limit, $sidx, $sord, $where);
        $responce = new stdClass;
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
        $i = 0;
        if (count($query) > 0)
            foreach ($query as $row) {
                $del = "hapusData('" . $row->bankid . "', '" . $row->bank_name . "')";
                $hapus = '<a href="javascript:void(0);" onclick="' . $del . '" title="Hapus"><i class="ace-icon fa fa-trash-o bigger-120 orange"></i>';
                $edit = '<a href="#master_finance/editBank?id=' . $row->bankid . '" title="Edit"><i class="ace-icon glyphicon glyphicon-pencil bigger-100"></i>';
                $responce->rows[$i]['id'] = $row->bankid;
                $responce->rows[$i]['cell'] = array(
                    $row->bank_name,
                    $row->bank_desc,
                    $edit, $hapus);
                $i++;
            }
        echo json_encode($responce);
    }

    public function editBank() {
        $this->hakAkses(1053);
        $id = $this->input->get('id');
        $data = $this->model_finance->getBank($id);
        $this->data['data'] = $data;
        $this->load->view('editBank', $this->data);
    }

    public function getBank() {
        $data = array('bankid' => $this->input->post('bankid', TRUE));
        $result = $this->model_finance->getBank($data);
        $responce = array();
        if (count($result) > 0)
            $responce = $result;
        echo json_encode($responce);
    }

    public function saveBank() {
        $name = $this->input->post('bank_name', TRUE);
        $desc = $this->input->post('bank_desc', TRUE);
        if (empty($name) || empty($desc)) {
            $hasil = $this->error('INPUT TIDAK LENGKAP, SILAHKAN CEK KEMBALI');
        } else {
            $save = $this->model_finance->addBank(array('bank_name' => strtoupper($name),
                'bank_desc' => strtoupper($desc),
                'bank_cbid' => ses_cabang, 'bank_flag' => '1'));
            if ($save['status'] == TRUE) {
                $hasil = $this->sukses($save['msg']);
            } else {
                $hasil = $this->error($save['msg']);
            }
        }
        echo json_encode($hasil);
    }

    public function updateBank() {
        $id = $this->input->post('bankid', TRUE);
        $name = $this->input->post('bank_name', TRUE);
        $desc = $this->input->post('bank_desc', TRUE);
        if (empty($id) || empty($name) || empty($desc)) {
            $hasil = $this->error('INPUT TIDAK LENGKAP, SILAHKAN CEK KEMBALI');
        } else {
            $save = $this->model_finance->updateBank(array('bank_name' => strtoupper($name),
                'bank_desc' => strtoupper($desc),
                'bank_cbid' => ses_cabang, 'bank_flag' => '1'), $id);
            if ($save['status'] == TRUE) {
                $hasil = $this->sukses($save['msg']);
            } else {
                $hasil = $this->error($save['msg']);
            }
        }
        echo json_encode($hasil);
    }

    public function deleteBank() {
        $id = $this->input->post('id', TRUE);
        if (empty($id)) {
            $hasil = $this->error('Hapus data gagal');
        } else {
            if ($this->model_finance->deleteBank($id)) {
                $hasil = $this->sukses('Hapus data berhasil');
            } else {
                $hasil = $this->error('Hapus data gagal');
            }
        }
        echo json_encode($hasil);
    }

    /* Function Master Tipe Jurnal
     * @author Rossi 
     * 2015-09-07
     */

    public function tipe_jurnal() {
        $this->hakAkses(1091);
        $this->load->view('dataTipeJurnal', $this->data);
    }

    public function addTipeJurnal() {
        $this->hakAkses(1091);
        $this->load->view('addTipeJurnal', $this->data);
    }

    public function loadTipeJurnal() {
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $limit = isset($_POST['rows']) ? $_POST['rows'] : 10;
        $sidx = isset($_POST['sidx']) ? $_POST['sidx'] : 'ccid';
        $sord = isset($_POST['sord']) ? $_POST['sord'] : '';
        $start = $limit * $page - $limit;
        $start = ($start < 0) ? 0 : $start;
        $where = whereLoad();
        $count = $this->model_finance->getTotalTipeJurnal($where);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;
        $query = $this->model_finance->getDataTipeJurnal($start, $limit, $sidx, $sord, $where);
        $responce = new stdClass;
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
        $i = 0;
        if (count($query) > 0)
            foreach ($query as $row) {
                $del = "hapusData('" . $row->tipeid . "', '" . $row->tipe_deskripsi . "')";
                $vie = "viewData('" . $row->tipeid . "', '" . $row->tipe_deskripsi . "')";
                $hapus = '<a href="javascript:void(0);" onclick="' . $del . '" title="Hapus"><i class="ace-icon fa fa-trash-o bigger-120 orange"></i>';
                $viewjurnal = '<a href="javascript:void(0);" onclick="' . $del . '" title="View"><i class="ace-icon fa fa-book bigger-120 orange"></i>';
                $edit = '<a href="#master_finance/editTipeJurnal?id=' . $row->tipeid . '" title="Edit"><i class="ace-icon glyphicon glyphicon-pencil bigger-100"></i>';
                $setjurnal = '<a href="#master_finance/setTipeJurnal?id=' . $row->tipeid . '" title="Setting"><i class="ace-icon glyphicon glyphicon-list bigger-100"></i>';
                $responce->rows[$i]['id'] = $row->tipeid;
                $responce->rows[$i]['cell'] = array(
                    $row->tipeid,
                    $row->tipe_postcode,
                    $row->tipe_deskripsi,
                    $viewjurnal, $setjurnal, $edit);
                $i++;
            }
        echo json_encode($responce);
    }

    public function editTipeJurnal() {
        $this->hakAkses(1091);
        $id = $this->input->get('id');
        $data = $this->model_finance->getTipeJurnal($id);
        $this->data['data'] = $data;
        $this->load->view('editTipeJurnal', $this->data);
    }

    public function setTipeJurnal() {
        $this->hakAkses(1091);
        $id = array(
            'id' => $this->input->get('id'),
            'cbid' => ses_cabang
        );
        $temp = $this->model_finance->getDetailTipeJurnal($id);
        $totalDtipe = $this->model_finance->getTotalDtipe($id);
        if ($totalDtipe > 0) {
            foreach ($temp as $stemp) {
                $data['tipeid'] = $stemp['tipeid'];
                $data['cbid'] = ses_cabang;
                $data['coa'][$stemp['dtipe_constant']] = $stemp['dtipe_coa'];
            }
        } else {
            $data['tipeid'] = $id['id'];
            $data['cbid'] = ses_cabang;
            $data['coa']['A'] = '0';
            $data['coa']['B'] = '0';
            $data['coa']['C'] = '0';
            $data['coa']['D'] = '0';
            $data['coa']['E'] = '0';
            $data['coa']['F'] = '0';
            $data['coa']['G'] = '0';
            $data['coa']['H'] = '0';
            $data['coa']['I'] = '0';
            $data['coa']['J'] = '0';
            $data['coa']['K'] = '0';
            $data['coa']['L'] = '0';
            $data['coa']['M'] = '0';
            $data['coa']['N'] = '0';
            $data['coa']['O'] = '0';
            $data['coa']['P'] = '0';
        }
        $this->data['data'] = $data;
        $this->load->view('setTipeJurnal', $this->data);
    }

    public function saveSetTipeJurnal() {
        $tipeid = $this->input->post('tipeid', TRUE);
        $cbid = $this->input->post('cbid', TRUE);
        $const = $this->input->post('const', TRUE);
        $coa = $this->input->post('dtipe', TRUE);

        if (empty($tipeid) || empty($cbid)) {
            $hasil = $this->error('INPUT TIDAK LENGKAP, SILAHKAN CEK KEMBALI ');
        } else {
            if (count($coa) > 0) {
                $save = $this->model_finance->setTipeJurnal(array(
                    'tipeid' => strtoupper($tipeid),
                    'cbid' => strtoupper($cbid),
                    'const' => $const,
                    'coa' => $coa
                        ));
            } else {
                $save['status'] = FALSE;
            }
            if ($save['status'] == TRUE) {
                $hasil = $this->sukses($save['msg']);
            } else {
                $hasil = $this->error($save['msg']);
            }
        }
        echo json_encode($hasil);
    }

    public function getTipeJurnal() {
        $data = array('tipeid' => $this->input->post('tipeid', TRUE));
        $result = $this->model_finance->getTipeJurnal($data);
        $responce = array();
        if (count($result) > 0)
            $responce = $result;
        echo json_encode($responce);
    }

    public function saveTipeJurnal() {
        $post = $this->input->post('tipe_postcode', TRUE);
        $desc = $this->input->post('tipe_deskripsi', TRUE);
        if (empty($desc) || empty($post)) {
            $hasil = $this->error('INPUT TIDAK LENGKAP, SILAHKAN CEK KEMBALI ' . $post . ' ' . $desc);
        } else {
            $save = $this->model_finance->addTipeJurnal(array(
                'tipe_postcode' => strtoupper($post),
                'tipe_deskripsi' => strtoupper($desc),
                    ));
            if ($save['status'] == TRUE) {
                $hasil = $this->sukses($save['msg']);
            } else {
                $hasil = $this->error($save['msg']);
            }
        }
        echo json_encode($hasil);
    }

    public function updateTipeJurnal() {
        $id = $this->input->post('tipeid', TRUE);
        $post = $this->input->post('tipe_postcode', TRUE);
        $desc = $this->input->post('tipe_deskripsi', TRUE);
        if (empty($id) || empty($desc) || empty($post)) {
            $hasil = $this->error('INPUT TIDAK LENGKAP, SILAHKAN CEK KEMBALI');
        } else {
            $save = $this->model_finance->updateTipeJurnal(array(
                'tipe_deskripsi' => strtoupper($desc),
                'tipe_postcode' => strtoupper($post)
                    ), $id);
            if ($save['status'] == TRUE) {
                $hasil = $this->sukses($save['msg']);
            } else {
                $hasil = $this->error($save['msg']);
            }
        }
        echo json_encode($hasil);
    }

    public function deleteTipeJurnal() {
        $id = $this->input->post('id', TRUE);
        if (empty($id)) {
            $hasil = $this->error('Hapus data gagal');
        } else {
            if ($this->model_finance->deleteTipeJurnal($id)) {
                $hasil = $this->sukses('Hapus data berhasil');
            } else {
                $hasil = $this->error('Hapus data gagal');
            }
        }
        echo json_encode($hasil);
    }

}

?>
