<?php

/**
 * Class Master
 * @author Rossi Erl
 * 2013-11-11
 */
class Master_Sales extends Application {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('model_admin', 'model_sales'));
        $this->isLogin();
    }

    public function index() {
        echo " ";
    }

    /* UTILITY */

    public function jsonModelKendaraan() {
        $data = array(
            'merkid' => $this->input->post('merkid', TRUE),
            'segid' => $this->input->post('segid', TRUE));
        echo json_encode($this->model_sales->getModelByMerk($data));
    }

    public function jsonTypeKendaraan() {
        $modelid = $this->input->post('modelid');
        echo json_encode($this->model_sales->getTypeByModel($modelid));
    }

    public function jsonWarnaModel() {
        $modelid = $this->input->post('modelid');
        echo json_encode($this->model_sales->getWarnaByModel($modelid));
    }

    public function addPelanggan() {
        $this->hakAkses(113);
        $this->data['href'] = $this->input->GET('href');
        $this->data['propinsi'] = $this->model_admin->getPropinsi();
        $this->load->view('master_service/addPelanggan', $this->data);
    }

    public function pelanggan() {
        $this->hakAkses(113);
        $this->data['add'] = "master_sales/addPelanggan";
        $this->load->view('master_service/pelanggan', $this->data);
    }

    function jsonNamaProspek() {
        $nama = $this->input->post('param');
        $cbid = ses_cabang;
        $data['response'] = 'false';
        $query = $this->model_sales->getProspekByNama($nama, $cbid);
        if (!empty($query)) {
            $data['response'] = 'true';
            $data['message'] = array();
            foreach ($query as $row) {
                $data['message'][] = array('value' => $row['pros_nama'], 'prosid' => $row['prosid'], 'desc' => $row['pros_alamat']);
            }
        } else {
            $data['message'][] = array('value' => '', 'label' => "Data Tidak Ditemukan", 'desc' => '');
        }
        echo json_encode($data);
    }

    function getDataProspek() {
        $this->load->model('model_prospect');
        echo json_encode($this->model_prospect->getProspect($this->input->post('param')));
    }

    public function jsonKota() {
        $propid = $this->input->post('propid');
        echo json_encode($this->model_sales->getKotaByPropinsi($propid));
    }

    public function jsonArea() {
        $kotaid = $this->input->post('kotaid');
        echo json_encode($this->model_sales->getAreaByKota($kotaid));
    }

    public function noKontrak() {
        $this->hakAkses(93);
        $this->load->view('noKontrak', $this->data);
    }

    public function addNoKontrak() {
        $this->hakAkses(93);
        $this->data['propinsi'] = $this->model_admin->getPropinsi();
        $this->load->view('addNoKontrak', $this->data);
    }

    /* --------------  */

    public function masterMerk() {
        $this->hakAkses(1070);
        $this->load->view('dataMerk', $this->data);
    }

    public function loadMerk() {
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $limit = isset($_POST['rows']) ? $_POST['rows'] : 10;
        $sidx = isset($_POST['sidx']) ? $_POST['sidx'] : 'merkid';
        $sord = isset($_POST['sord']) ? $_POST['sord'] : '';
        $start = $limit * $page - $limit;
        $start = ($start < 0) ? 0 : $start;
        $where = whereLoad();
        $count = $this->model_sales->getTotalMerk($where);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;
        $query = $this->model_sales->getDataMerk($start, $limit, $sidx, $sord, $where);
        $responce = new stdClass;
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
        $i = 0;
        if (count($query) > 0)
            foreach ($query as $row) {
                $del = "hapusData('" . $row->merkid . "', '" . $row->merk_deskripsi . "')";
                $hapus = '<a href="javascript:void(0);" onclick="' . $del . '" title="Hapus"><i class="ace-icon fa fa-trash-o bigger-120 orange"></i>';
                $edit = '<a href="#master_sales/editMerk?id=' . $row->merkid . '" title="Edit"><i class="ace-icon glyphicon glyphicon-pencil bigger-100"></i>';
                $responce->rows[$i]['id'] = $row->merkid;
                $responce->rows[$i]['cell'] = array(
                    $row->merkid,
                    $row->merk_deskripsi,
                    $edit, $hapus);
                $i++;
            }
        echo json_encode($responce);
    }

    /**
     * 
     */
    public function loadNoKontrak() {
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $limit = isset($_POST['rows']) ? $_POST['rows'] : 10;
        $sidx = isset($_POST['sidx']) ? $_POST['sidx'] : 'kon_nomer';
        $sord = isset($_POST['sord']) ? $_POST['sord'] : '';
        $start = $limit * $page - $limit;
        $start = ($start < 0) ? 0 : $start;
        $where = whereLoad();
        $count = $this->model_sales->getTotalKontrak($where);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;
        $query = $this->model_sales->getAllKontrak($start, $limit, $sidx, $sord, $where);
        $responce = new stdClass;
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
        $i = 0;
        if (count($query) > 0)
            foreach ($query as $row) {
                $edit = "-";
                $hapus = "-";
                if ($row->kon_use == 0) {
                    $edit = '<a href="#master_sales/editKontrak?id=' . $row->kon_nomer . '" title="Edit"><i class="ace-icon glyphicon glyphicon-pencil bigger-100"></i>';
                    $hapus = '<a href="javascript:void(0);" onclick="hapusKontrak(\'' . $row->kon_nomer . '\')" title="Hapus"><i class="ace-icon fa fa-trash-o bigger-120 orange"></i>';
                }
                $responce->rows[$i]['id'] = $row->kon_nomer;
                $responce->rows[$i]['cell'] = array(
                    $row->kon_nomer,
                    $row->pel_nama,
                    $row->pel_alamat,
                    $row->pel_hp,
                    $edit,
                    $hapus);
                $i++;
            }
        echo json_encode($responce);
    }

    public function addMerk() {
        $this->hakAkses(1070);
        $this->load->view('addMerk', $this->data);
    }

    public function editMerk() {
        $this->hakAkses(1070);
        $id = $this->input->get('id');
        $data = $this->model_sales->getMerk($id);
        $this->data['data'] = $data;
        $this->load->view('editModel', $this->data);
    }

    public function saveMerk() {
        $desc = strtoupper($this->input->post('merk_deskripsi', TRUE));
        if (empty($desc)) {
            $hasil = $this->error('INPUT TIDAK LENGKAP, SILAHKAN CEK KEMBALI');
        } else {
            $save = $this->model_sales->addMerk(array('merk_deskripsi' => $desc));
            if ($save['status'] == TRUE) {
                $hasil = $this->sukses($save['msg']);
            } else {
                $hasil = $this->error($save['msg']);
            }
        }
        echo json_encode($hasil);
    }

    public function updateMerk() {
        $merkid = $this->input->post('merkid', TRUE);
        $desc = strtoupper($this->input->post('merk_deskripsi', TRUE));
        if (empty($desc)) {
            $hasil = $this->error('INPUT TIDAK LENGKAP, SILAHKAN CEK KEMBALI');
        } else {
            $save = $this->model_sales->updateMerk(array('merk_deskripsi' => strtoupper($desc)), $merkid);
            if ($save['status'] == TRUE) {
                $hasil = $this->sukses($save['msg']);
            } else {
                $hasil = $this->error($save['msg']);
            }
        }
        echo json_encode($hasil);
    }

    public function deleteMerk() {
        $id = $this->input->post('id', TRUE);
        if (empty($id)) {
            $hasil = $this->error('Hapus data gagal');
        } else {
            if ($this->model_sales->deleteMerk($id)) {
                $hasil = $this->sukses('Hapus data berhasil');
            } else {
                $hasil = $this->error('Hapus data gagal');
            }
        }
        echo json_encode($hasil);
    }

    public function getMerk() {
        $data = $this->input->get('merkid', TRUE);
        $result = $this->model_sales->getMerk($data);
        $responce = array();
        if (count($result) > 0)
            $responce = $result;
        echo json_encode($responce);
    }

    /** Master Segment
     * @author Rossi
     * 2015-09-09
     */
    public function masterSegment() {
        $this->hakAkses(1070);
        $this->load->view('dataSegment', $this->data);
    }

    public function loadSegment() {
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $limit = isset($_POST['rows']) ? $_POST['rows'] : 10;
        $sidx = isset($_POST['sidx']) ? $_POST['sidx'] : 'segid';
        $sord = isset($_POST['sord']) ? $_POST['sord'] : '';
        $start = $limit * $page - $limit;
        $start = ($start < 0) ? 0 : $start;
        $where = whereLoad();
        $count = $this->model_sales->getTotalSegment($where);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;
        $query = $this->model_sales->getDataSegment($start, $limit, $sidx, $sord, $where);
        $responce = new stdClass;
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
        $i = 0;
        if (count($query) > 0)
            foreach ($query as $row) {
                $del = "hapusData('" . $row->segid . "', '" . $row->seg_nama . "')";
                $hapus = '<a href="javascript:void(0);" onclick="' . $del . '" title="Hapus"><i class="ace-icon fa fa-trash-o bigger-120 orange"></i>';
                $edit = '<a href="#master_sales/editSegment?id=' . $row->segid . '" title="Edit"><i class="ace-icon glyphicon glyphicon-pencil bigger-100"></i>';
                $responce->rows[$i]['id'] = $row->segid;
                $responce->rows[$i]['cell'] = array(
                    $row->segid,
                    $row->seg_nama,
                    $edit, $hapus);
                $i++;
            }
        echo json_encode($responce);
    }

    public function addSegment() {
        $this->hakAkses(1070);
        $this->load->view('addSegment', $this->data);
    }

    public function editSegment() {
        $this->hakAkses(1070);
        $id = $this->input->get('id');
        $data = $this->model_sales->getSegment($id);
        $this->data['data'] = $data;
        $this->load->view('editModel', $this->data);
    }

    public function saveSegment() {
        $segid = strtoupper($this->input->post('segid', TRUE));
        $desc = strtoupper($this->input->post('seg_nama', TRUE));
        if (empty($segid) || empty($desc)) {
            $hasil = $this->error('INPUT TIDAK LENGKAP, SILAHKAN CEK KEMBALI');
        } else {
            $save = $this->model_sales->addSegment(array(
                'seg_nama' => $desc,
                'segid' => $segid
                    ));
            if ($save['status'] == TRUE) {
                $hasil = $this->sukses($save['msg']);
            } else {
                $hasil = $this->error($save['msg']);
            }
        }
        echo json_encode($hasil);
    }

    function saveNoKontrak() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('pel_nama', '<b>Fx</b>', 'xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $tgl = $this->input->post('pel_tgl_lahir');
            if (empty($tgl)) {
                $tgl = defaultTgl();
            }
            $data = array(
                'pel_cbid' => ses_cabang,
                'pel_prosid' => strtoupper($this->input->post('prosid')),
                'pel_nama' => strtoupper($this->input->post('pel_nama')),
                'pel_alamat' => strtoupper($this->input->post('pel_alamat')),
                'pel_gender' => $this->input->post('pel_gender'),
                'pel_kotaid' => $this->input->post('pel_kotaid'),
                'pel_type' => $this->input->post('pel_type'),
                'pel_alamat_surat' => $this->input->post('pel_alamat_surat'),
                'pel_hp' => $this->input->post('pel_hp'),
                'pel_nomor_id' => $this->input->post('pel_nomor_id'),
                'pel_telpon' => $this->input->post('pel_telpon'),
                'pel_fax' => $this->input->post('pel_fax'),
                'pel_tempat_lahir' => strtoupper($this->input->post('pel_tempat_lahir')),
                'pel_tgl_lahir' => dateToIndo($tgl),
                'pel_email' => $this->input->post('pel_email'),
                'pel_agama' => $this->input->post('pel_agama')
            );

            $kontrak = $this->input->post('kon_nomer');
            $hasil = $this->model_sales->saveNoKontrak($data, $kontrak);
            $retur = array();
            if ($hasil) {
                $retur['result'] = true;
                $this->session->set_flashdata('msg', $this->sukses('Berhasil menambah kontrak'));
                $retur['msg'] = $this->sukses("Berhasil menyimpan kontrak");
            } else {
                $retur['result'] = false;
                $this->session->set_flashdata('msg', $this->error('Gagal menambah kontrak'));
                $retur['msg'] = $this->error("Gagal menyimpan kontrak");
            }
        }
        echo json_encode($retur);
    }

    public function updateSegment() {
        $segid = $this->input->post('segid', TRUE);
        $desc = strtoupper($this->input->post('seg_nama', TRUE));
        if (empty($desc)) {
            $hasil = $this->error('INPUT TIDAK LENGKAP, SILAHKAN CEK KEMBALI');
        } else {
            $save = $this->model_sales->updateSegment(array('seg_nama' => strtoupper($desc)), $segid);
            if ($save['status'] == TRUE) {
                $hasil = $this->sukses($save['msg']);
            } else {
                $hasil = $this->error($save['msg']);
            }
        }
        echo json_encode($hasil);
    }

    public function deleteSegment() {
        $id = $this->input->post('id', TRUE);
        if (empty($id)) {
            $hasil = $this->error('Hapus data gagal');
        } else {
            if ($this->model_sales->deleteSegment($id)) {
                $hasil = $this->sukses('Hapus data berhasil');
            } else {
                $hasil = $this->error('Hapus data gagal');
            }
        }
        echo json_encode($hasil);
    }

    public function deleteKontrak() {
        $id = $this->input->post('id', TRUE);
        if (empty($id)) {
            $hasil = $this->error('Hapus data gagal');
        } else {
            if ($this->model_sales->deleteKontrak($id)) {
                $hasil = $this->sukses('Hapus data berhasil');
            } else {
                $hasil = $this->error('Hapus data gagal');
            }
        }
        echo json_encode($hasil);
    }

    public function getSegment() {
        $data = $this->input->get('segid', TRUE);
        $result = $this->model_sales->getSegment($data);
        $responce = array();
        if (count($result) > 0)
            $responce = $result;
        echo json_encode($responce);
    }

    /**
     * Master Car Model
     * @author Rossi
     * * */
    public function masterModel() {
        $this->hakAkses(1073);
        $this->load->view('dataModel', $this->data);
    }

    public function getModel() {
        $data = $this->input->get('modelid', TRUE);
        $result = $this->model_sales->getModel($data);
        $responce = array();
        if (count($result) > 0)
            $responce = $result;
        echo json_encode($responce);
    }

    public function saveModel() {
        $modelMerkid = strtoupper($this->input->post('model_merkid', TRUE));
        $modelDesc = strtoupper($this->input->post('model_deskripsi', TRUE));
        $modelSeg = strtoupper($this->input->post('model_segment', TRUE));
        if (empty($modelMerkid) || empty($modelDesc) || empty($modelSeg)) {
            $hasil = $this->error('INPUT TIDAK LENGKAP, SILAHKAN CEK KEMBALI');
        } else {
            $save = $this->model_sales->addModel(array(
                'model_deskripsi' => $modelDesc,
                'model_merkid' => $modelMerkid,
                'model_segment' => $modelSeg,
                    ));
            if ($save['status'] == TRUE) {
                $hasil = $this->sukses($save['msg']);
            } else {
                $hasil = $this->error($save['msg']);
            }
        }
        echo json_encode($hasil);
    }

    public function loadModel() {
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $limit = isset($_POST['rows']) ? $_POST['rows'] : 10;
        $sidx = isset($_POST['sidx']) ? $_POST['sidx'] : 'merkid';
        $sord = isset($_POST['sord']) ? $_POST['sord'] : '';
        $start = $limit * $page - $limit;
        $start = ($start < 0) ? 0 : $start;
        $where = whereLoad();
        $count = $this->model_sales->getTotalModel($where);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;
        $query = $this->model_sales->getDataModel($start, $limit, $sidx, $sord, $where);
        $responce = new stdClass;
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
        $i = 0;
        if (count($query) > 0)
            foreach ($query as $row) {
                $del = "hapusData('" . $row->modelid . "', '" . $row->model_deskripsi . "')";
                $hapus = '<a href="javascript:void(0);" onclick="' . $del . '" title="Hapus"><i class="ace-icon fa fa-trash-o bigger-120 orange"></i>';
                $edit = '<a href="#master_sales/editModel?id=' . $row->modelid . '" title="Edit"><i class="ace-icon glyphicon glyphicon-pencil bigger-100"></i>';
                $responce->rows[$i]['id'] = $row->merkid;
                $responce->rows[$i]['cell'] = array(
                    $row->modelid,
                    $row->merk_deskripsi,
                    $row->model_deskripsi,
                    $row->seg_nama,
                    $edit, $hapus);
                $i++;
            }
        echo json_encode($responce);
    }

    public function addModel() {
        $this->hakAkses(1073);
        $this->data['merk'] = $this->model_sales->cListMerk();
        $this->data['segment'] = $this->model_sales->cListSegment();
        $this->load->view('addModel', $this->data);
    }

    public function editModel() {
        $this->hakAkses(1073);
        $id = $this->input->get('id');
        $data = $this->model_sales->getModel($id);
        $this->data['merk'] = $this->model_sales->cListMerk();
        $this->data['segment'] = $this->model_sales->cListSegment();
        $this->data['data'] = $data;
        $this->load->view('editModel', $this->data);
    }

    public function updateModel() {
        $modelid = $this->input->post('modelid', TRUE);
        $modelMerkid = strtoupper($this->input->post('model_merkid', TRUE));
        $modelDesc = strtoupper($this->input->post('model_deskripsi', TRUE));
        $modelSeg = strtoupper($this->input->post('model_segment', TRUE));
        if (empty($modelDesc) || empty($modelMerkid) || empty($modelid) || empty($modelSeg)) {
            $hasil = $this->error('INPUT TIDAK LENGKAP, SILAHKAN CEK KEMBALI');
        } else {
            $save = $this->model_sales->updateModel(array(
                'model_merkid' => strtoupper($modelMerkid),
                'model_deskripsi' => strtoupper($modelDesc),
                'model_segment' => strtoupper($modelSeg)
                    ), $modelid);
            if ($save['status'] == TRUE) {
                $hasil = $this->sukses($save['msg']);
            } else {
                $hasil = $this->error($save['msg']);
            }
        }
        echo json_encode($hasil);
    }

    public function deleteModel() {
        $id = $this->input->post('id', TRUE);
        if (empty($id)) {
            $hasil = $this->error('Hapus data gagal');
        } else {
            if ($this->model_sales->deleteModel($id)) {
                $hasil = $this->sukses('Hapus data berhasil');
            } else {
                $hasil = $this->error('Hapus data gagal');
            }
        }
        echo json_encode($hasil);
    }

    /**
     * Master Car Type
     * @author Rossi
     * * */
    public function masterCarType() {
        $this->hakAkses(1074);
        $this->load->view('dataCarType', $this->data);
    }

    public function getCarType() {
        $data = $this->input->get('ctyid', TRUE);
        $result = $this->model_sales->getCarType($data);
        $responce = array();
        if (count($result) > 0)
            $responce = $result;
        echo json_encode($responce);
    }

    public function saveCarType() {
        $modelid = strtoupper($this->input->post('modelid', TRUE));
        $desc = strtoupper($this->input->post('cty_deskripsi', TRUE));
        if (empty($modelid) || empty($desc)) {
            $hasil = $this->error('INPUT TIDAK LENGKAP, SILAHKAN CEK KEMBALI');
        } else {
            $save = $this->model_sales->addCarType(array(
                'cty_modelid' => $modelid,
                'cty_deskripsi' => $desc
                    ));
            if ($save['status'] == TRUE) {
                $hasil = $this->sukses($save['msg']);
            } else {
                $hasil = $this->error($save['msg']);
            }
        }
        echo json_encode($hasil);
    }

    public function loadCarType() {
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $limit = isset($_POST['rows']) ? $_POST['rows'] : 10;
        $sidx = isset($_POST['sidx']) ? $_POST['sidx'] : 'merkid';
        $sord = isset($_POST['sord']) ? $_POST['sord'] : '';
        $start = $limit * $page - $limit;
        $start = ($start < 0) ? 0 : $start;
        $where = whereLoad();
        $count = $this->model_sales->getTotalCarType($where);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;
        $query = $this->model_sales->getDataCarType($start, $limit, $sidx, $sord, $where);
        $responce = new stdClass;
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
        $i = 0;
        if (count($query) > 0)
            foreach ($query as $row) {
                $del = "hapusData('" . $row->ctyid . "', '" . $row->cty_deskripsi . "')";
                $hapus = '<a href="javascript:void(0);" onclick="' . $del . '" title="Hapus"><i class="ace-icon fa fa-trash-o bigger-120 orange"></i>';
                $edit = '<a href="#master_sales/editCarType?id=' . $row->ctyid . '" title="Edit"><i class="ace-icon glyphicon glyphicon-pencil bigger-100"></i>';
                $responce->rows[$i]['id'] = $row->ctyid;
                $responce->rows[$i]['cell'] = array(
                    $row->merk_deskripsi,
                    $row->model_deskripsi,
                    $row->cty_deskripsi,
                    $edit, $hapus);
                $i++;
            }
        echo json_encode($responce);
    }

    public function addCarType() {
        $this->hakAkses(1074);
        $this->data['merk'] = $this->model_sales->cListMerk();
        $this->load->view('addCarType', $this->data);
    }

    public function editCarType() {
        $this->hakAkses(1074);
        $id = $this->input->get('id');
        $data = $this->model_sales->getCarType($id);
        $this->data['merk'] = $this->model_sales->cListMerk();
        $this->data['data'] = $data;
        $this->load->view('editCarType', $this->data);
    }

    public function updateCarType() {
        $id = strtoupper($this->input->post('ctyid', TRUE));
        $modelid = strtoupper($this->input->post('modelid', TRUE));
        $desc = strtoupper($this->input->post('cty_deskripsi', TRUE));
        if (empty($modelid) || empty($desc)) {
            $hasil = $this->error('INPUT TIDAK LENGKAP, SILAHKAN CEK KEMBALI');
        } else {
            $save = $this->model_sales->updateCarType(array(
                'cty_modelid' => $modelid,
                'cty_deskripsi' => $desc), $id);
            if ($save['status'] == TRUE) {
                $hasil = $this->sukses($save['msg']);
            } else {
                $hasil = $this->error($save['msg']);
            }
        }
        echo json_encode($hasil);
    }

    public function deleteCarType() {
        $id = $this->input->post('id', TRUE);
        if (empty($id)) {
            $hasil = $this->error('Hapus data gagal');
        } else {
            if ($this->model_sales->deleteCarType($id)) {
                $hasil = $this->sukses('Hapus data berhasil');
            } else {
                $hasil = $this->error('Hapus data gagal');
            }
        }
        echo json_encode($hasil);
    }

    /**
     * WARNA KENDARAAN
     * @author Rossi
     * 2015-09-10
     */
    public function masterWarna() {
        $this->hakAkses(1075);
        $this->load->view('dataWarna', $this->data);
    }

    public function loadWarna() {
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $limit = isset($_POST['rows']) ? $_POST['rows'] : 10;
        $sidx = isset($_POST['sidx']) ? $_POST['sidx'] : 'warnaid';
        $sord = isset($_POST['sord']) ? $_POST['sord'] : '';
        $start = $limit * $page - $limit;
        $start = ($start < 0) ? 0 : $start;
        $where = whereLoad();
        $count = $this->model_sales->getTotalWarna($where);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;
        $query = $this->model_sales->getDataWarna($start, $limit, $sidx, $sord, $where);
        $responce = new stdClass;
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
        $i = 0;
        if (count($query) > 0)
            foreach ($query as $row) {
                $del = "hapusData('" . $row->warnaid . "', '" . $row->warna_deskripsi . "')";
                $hapus = '<a href="javascript:void(0);" onclick="' . $del . '" title="Hapus"><i class="ace-icon fa fa-trash-o bigger-120 orange"></i>';
                $edit = '<a href="#master_sales/editWarna?id=' . $row->warnaid . '" title="Edit"><i class="ace-icon glyphicon glyphicon-pencil bigger-100"></i>';
                $responce->rows[$i]['id'] = $row->warnaid;
                $responce->rows[$i]['cell'] = array(
                    $row->warnaid,
                    $row->warna_deskripsi,
                    $edit, $hapus);
                $i++;
            }
        echo json_encode($responce);
    }

    public function addWarna() {
        $this->hakAkses(1075);
        $this->load->view('addWarna', $this->data);
    }

    public function editWarna() {
        $this->hakAkses(1075);
        $id = $this->input->get('id');
        $data = $this->model_sales->getWarna($id);
        $this->data['data'] = $data;
        $this->load->view('editWarna', $this->data);
    }

    public function saveWarna() {
        $desc = strtoupper($this->input->post('warna_deskripsi', TRUE));
        if (empty($desc)) {
            $hasil = $this->error('INPUT TIDAK LENGKAP, SILAHKAN CEK KEMBALI');
        } else {
            $save = $this->model_sales->addWarna(array('warna_deskripsi' => $desc));
            if ($save['status'] == TRUE) {
                $hasil = $this->sukses($save['msg']);
            } else {
                $hasil = $this->error($save['msg']);
            }
        }
        echo json_encode($hasil);
    }

    public function updateWarna() {
        $warnaid = $this->input->post('warnaid', TRUE);
        $desc = strtoupper($this->input->post('warna_deskripsi', TRUE));
        if (empty($desc)) {
            $hasil = $this->error('INPUT TIDAK LENGKAP, SILAHKAN CEK KEMBALI');
        } else {
            $save = $this->model_sales->updateWarna(array('warna_deskripsi' => strtoupper($desc)), $warnaid);
            if ($save['status'] == TRUE) {
                $hasil = $this->sukses($save['msg']);
            } else {
                $hasil = $this->error($save['msg']);
            }
        }
        echo json_encode($hasil);
    }

    public function deleteWarna() {
        $id = $this->input->post('id', TRUE);
        if (empty($id)) {
            $hasil = $this->error('Hapus data gagal');
        } else {
            if ($this->model_sales->deleteWarna($id)) {
                $hasil = $this->sukses('Hapus data berhasil');
            } else {
                $hasil = $this->error('Hapus data gagal');
            }
        }
        echo json_encode($hasil);
    }

    public function getWarna() {
        $data = $this->input->get('warnaid', TRUE);
        $result = $this->model_sales->getWarna($data);
        $responce = array();
        if (count($result) > 0)
            $responce = $result;
        echo json_encode($responce);
    }

    /**
     * Master Warna Model
     * @author Rossi
     * * */
    public function warnaModel() {
        $this->hakAkses(1076);
        $this->load->view('dataWarnaModel', $this->data);
    }

    public function getWarnaModel() {
        $data = $this->input->get('mdlcolorid', TRUE);
        $result = $this->model_sales->getWarnaModel($data);
        $responce = array();
        if (count($result) > 0)
            $responce = $result;
        echo json_encode($responce);
    }

    public function saveWarnaModel() {
        $modelid = strtoupper($this->input->post('modelid', TRUE));
        $warnaid = strtoupper($this->input->post('warnaid', TRUE));
        if (empty($modelid) || empty($warnaid)) {
            $hasil = $this->error('INPUT TIDAK LENGKAP, SILAHKAN CEK KEMBALI');
        } else {
            $save = $this->model_sales->addWarnaModel(array(
                'mdlcolor_modelid' => $modelid,
                'mdlcolor_warnaid' => $warnaid
                    ));
            if ($save['status'] == TRUE) {
                $hasil = $this->sukses($save['msg']);
            } else {
                $hasil = $this->error($save['msg']);
            }
        }
        echo json_encode($hasil);
    }

    public function loadWarnaModel() {
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $limit = isset($_POST['rows']) ? $_POST['rows'] : 10;
        $sidx = isset($_POST['sidx']) ? $_POST['sidx'] : 'merkid';
        $sord = isset($_POST['sord']) ? $_POST['sord'] : '';
        $start = $limit * $page - $limit;
        $start = ($start < 0) ? 0 : $start;
        $where = whereLoad();
        $count = $this->model_sales->getTotalWarnaModel($where);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;
        $query = $this->model_sales->getDataWarnaModel($start, $limit, $sidx, $sord, $where);
        $responce = new stdClass;
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
        $i = 0;
        if (count($query) > 0)
            foreach ($query as $row) {
                $del = "hapusData('" . $row->mdlcolorid . "', '" . $row->warna_deskripsi . "')";
                $hapus = '<a href="javascript:void(0);" onclick="' . $del . '" title="Hapus"><i class="ace-icon fa fa-trash-o bigger-120 orange"></i>';
                $edit = '<a href="#master_sales/editWarnaModel?id=' . $row->mdlcolorid . '" title="Edit"><i class="ace-icon glyphicon glyphicon-pencil bigger-100"></i>';
                $responce->rows[$i]['id'] = $row->mdlcolorid;
                $responce->rows[$i]['cell'] = array(
                    $row->merk_deskripsi,
                    $row->model_deskripsi,
                    $row->warna_deskripsi,
                    $edit, $hapus);
                $i++;
            }
        echo json_encode($responce);
    }

    public function addWarnaModel() {
        $this->hakAkses(1076);
        $this->data['merk'] = $this->model_sales->cListMerk();
        $this->data['warna'] = $this->model_sales->cListWarna();
        $this->load->view('addWarnaModel', $this->data);
    }

    public function editWarnaModel() {
        $this->hakAkses(1076);
        $id = $this->input->get('id');
        $data = $this->model_sales->getWarnaModel($id);
        $this->data['merk'] = $this->model_sales->cListMerk();
        $this->data['warna'] = $this->model_sales->cListWarna();
        $this->data['data'] = $data;
        $this->load->view('editWarnaModel', $this->data);
    }

    public function updateWarnaModel() {
        $id = strtoupper($this->input->post('mdlcolorid', TRUE));
        $modelid = strtoupper($this->input->post('modelid', TRUE));
        $warnaid = strtoupper($this->input->post('warnaid', TRUE));
        if (empty($modelid) || empty($warnaid)) {
            $hasil = $this->error('INPUT TIDAK LENGKAP, SILAHKAN CEK KEMBALI');
        } else {
            $save = $this->model_sales->updateWarnaModel(array(
                'mdlcolor_modelid' => $modelid,
                'mdlcolor_warnaid' => $warnaid), $id);
            if ($save['status'] == TRUE) {
                $hasil = $this->sukses($save['msg']);
            } else {
                $hasil = $this->error($save['msg']);
            }
        }
        echo json_encode($hasil);
    }

    public function deleteWarnaModel() {
        $id = $this->input->post('id', TRUE);
        if (empty($id)) {
            $hasil = $this->error('Hapus data gagal');
        } else {
            if ($this->model_sales->deleteWarnaModel($id)) {
                $hasil = $this->sukses('Hapus data berhasil');
            } else {
                $hasil = $this->error('Hapus data gagal');
            }
        }
        echo json_encode($hasil);
    }

    /**
     * Master Leasing
     * @author Rossi
     * * */
    public function masterLeasing() {
        $this->hakAkses(1077);
        $this->load->view('dataLeasing', $this->data);
    }

    public function getLeasing() {
        $data = $this->input->get('leasid', TRUE);
        $result = $this->model_sales->getLeasing($data);
        $responce = array();
        if (count($result) > 0)
            $responce = $result;
        echo json_encode($responce);
    }

    public function saveLeasing() {
        $nama = strtoupper($this->input->post('leas_nama', TRUE));
        $alamat = strtoupper($this->input->post('leas_alamat', TRUE));
        $kota = strtoupper($this->input->post('leas_kotaid', TRUE));
        if (empty($nama) || empty($alamat) || empty($kota)) {
            $hasil = $this->error('INPUT TIDAK LENGKAP, SILAHKAN CEK KEMBALI');
        } else {
            $save = $this->model_sales->addLeasing(array(
                'leas_nama' => $nama,
                'leas_alamat' => $alamat,
                'leas_cbid' => ses_cabang,
                'leas_telp' => $this->input->post('leas_telp', TRUE),
                'leas_kontak' => strtoupper($this->input->post('leas_kontak', TRUE)),
                'leas_kotaid' => $kota));
            if ($save['status'] == TRUE) {
                $hasil = $this->sukses($save['msg']);
            } else {
                $hasil = $this->error($save['msg']);
            }
        }
        echo json_encode($hasil);
    }

    public function loadLeasing() {
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $limit = isset($_POST['rows']) ? $_POST['rows'] : 10;
        $sidx = isset($_POST['sidx']) ? $_POST['sidx'] : 'merkid';
        $sord = isset($_POST['sord']) ? $_POST['sord'] : '';
        $start = $limit * $page - $limit;
        $start = ($start < 0) ? 0 : $start;
        $where = whereLoad();
        $count = $this->model_sales->getTotalLeasing($where);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;
        $query = $this->model_sales->getDataLeasing($start, $limit, $sidx, $sord, $where);
        $responce = new stdClass;
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
        $i = 0;
        if (count($query) > 0)
            foreach ($query as $row) {
                $del = "hapusData('" . $row->leasid . "', '" . $row->leas_nama . "')";
                $hapus = '<a href="javascript:void(0);" onclick="' . $del . '" title="Hapus"><i class="ace-icon fa fa-trash-o bigger-120 orange"></i>';
                $edit = '<a href="#master_sales/editLeasing?id=' . $row->leasid . '" title="Edit"><i class="ace-icon glyphicon glyphicon-pencil bigger-100"></i>';
                $responce->rows[$i]['id'] = $row->leasid;
                $responce->rows[$i]['cell'] = array(
                    $row->leas_nama,
                    $row->leas_alamat,
                    $row->leas_telp,
                    $row->leas_kontak,
                    $row->kota_deskripsi,
                    $edit, $hapus);
                $i++;
            }
        echo json_encode($responce);
    }

    public function addLeasing() {
        $this->hakAkses(1077);
        $this->data['propinsi'] = $this->model_admin->getPropinsi();
        $this->load->view('addLeasing', $this->data);
    }

    public function editLeasing() {
        $this->hakAkses(1077);
        $id = $this->input->get('id');
        $data = $this->model_sales->getLeasing($id);
        $this->data['propinsi'] = $this->model_admin->getPropinsi();
        $this->data['data'] = $data;
        $this->load->view('editLeasing', $this->data);
    }

    public function updateLeasing() {
        $id = strtoupper($this->input->post('leasid', TRUE));
        $nama = strtoupper($this->input->post('leas_nama', TRUE));
        $nama = strtoupper($this->input->post('leas_nama', TRUE));
        $alamat = strtoupper($this->input->post('leas_alamat', TRUE));
        $kota = strtoupper($this->input->post('leas_kotaid', TRUE));
        if (empty($nama) || empty($alamat) || empty($kota) || empty($id)) {
            $hasil = $this->error('INPUT TIDAK LENGKAP, SILAHKAN CEK KEMBALI');
        } else {
            $save = $this->model_sales->updateLeasing(array(
                'leas_nama' => $nama,
                'leas_alamat' => $alamat,
                'leas_cbid' => ses_cabang,
                'leas_telp' => $this->input->post('leas_telp', TRUE),
                'leas_kontak' => strtoupper($this->input->post('leas_kontak', TRUE)),
                'leas_kotaid' => $kota), $id);
            if ($save['status'] == TRUE) {
                $hasil = $this->sukses($save['msg']);
            } else {
                $hasil = $this->error($save['msg']);
            }
        }
        echo json_encode($hasil);
    }

    public function deleteLeasing() {
        $id = $this->input->post('id', TRUE);
        if (empty($id)) {
            $hasil = $this->error('Hapus data gagal');
        } else {
            if ($this->model_sales->deleteLeasing($id)) {
                $hasil = $this->sukses('Hapus data berhasil');
            } else {
                $hasil = $this->error('Hapus data gagal');
            }
        }
        echo json_encode($hasil);
    }

    /**
     * Master Karoseri
     * @author Rossi
     * * */
    public function masterKaroseri() {
        $this->hakAkses(1078);
        $this->load->view('dataKaroseri', $this->data);
    }

    public function getKaroseri() {
        $data = $this->input->get('leasid', TRUE);
        $result = $this->model_sales->getKaroseri($data);
        $responce = array();
        if (count($result) > 0)
            $responce = $result;
        echo json_encode($responce);
    }

    public function saveKaroseri() {
        $nama = strtoupper($this->input->post('karo_nama', TRUE));
        $alamat = strtoupper($this->input->post('karo_alamat', TRUE));
        $kota = strtoupper($this->input->post('karo_kotaid', TRUE));
        if (empty($nama) || empty($alamat) || empty($kota)) {
            $hasil = $this->error('INPUT TIDAK LENGKAP, SILAHKAN CEK KEMBALI');
        } else {
            $save = $this->model_sales->addKaroseri(array(
                'karo_nama' => $nama,
                'karo_alamat' => $alamat,
                'karo_cbid' => ses_cabang,
                'karo_telp' => $this->input->post('karo_telp', TRUE),
                'karo_kontak' => strtoupper($this->input->post('karo_kontak', TRUE)),
                'karo_kotaid' => $kota));
            if ($save['status'] == TRUE) {
                $hasil = $this->sukses($save['msg']);
            } else {
                $hasil = $this->error($save['msg']);
            }
        }
        echo json_encode($hasil);
    }

    public function loadKaroseri() {
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $limit = isset($_POST['rows']) ? $_POST['rows'] : 10;
        $sidx = isset($_POST['sidx']) ? $_POST['sidx'] : 'merkid';
        $sord = isset($_POST['sord']) ? $_POST['sord'] : '';
        $start = $limit * $page - $limit;
        $start = ($start < 0) ? 0 : $start;
        $where = whereLoad();
        $count = $this->model_sales->getTotalKaroseri($where);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;
        $query = $this->model_sales->getDataKaroseri($start, $limit, $sidx, $sord, $where);
        $responce = new stdClass;
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
        $i = 0;
        if (count($query) > 0)
            foreach ($query as $row) {
                $del = "hapusData('" . $row->karoid . "', '" . $row->karo_nama . "')";
                $hapus = '<a href="javascript:void(0);" onclick="' . $del . '" title="Hapus"><i class="ace-icon fa fa-trash-o bigger-120 orange"></i>';
                $edit = '<a href="#master_sales/editKaroseri?id=' . $row->karoid . '" title="Edit"><i class="ace-icon glyphicon glyphicon-pencil bigger-100"></i>';
                $responce->rows[$i]['id'] = $row->karoid;
                $responce->rows[$i]['cell'] = array(
                    $row->karo_nama,
                    $row->karo_alamat,
                    $row->karo_telp,
                    $row->karo_kontak,
                    $row->kota_deskripsi,
                    $edit, $hapus);
                $i++;
            }
        echo json_encode($responce);
    }

    public function addKaroseri() {
        $this->hakAkses(1078);
        $this->data['propinsi'] = $this->model_admin->getPropinsi();
        $this->load->view('addKaroseri', $this->data);
    }

    public function editKaroseri() {
        $this->hakAkses(1078);
        $id = $this->input->get('id');
        $data = $this->model_sales->getKaroseri($id);
        $this->data['propinsi'] = $this->model_admin->getPropinsi();
        $this->data['data'] = $data;
        $this->load->view('editKaroseri', $this->data);
    }

    public function updateKaroseri() {
        $id = strtoupper($this->input->post('karoid', TRUE));
        $nama = strtoupper($this->input->post('karo_nama', TRUE));
        $nama = strtoupper($this->input->post('karo_nama', TRUE));
        $alamat = strtoupper($this->input->post('karo_alamat', TRUE));
        $kota = strtoupper($this->input->post('karo_kotaid', TRUE));
        if (empty($nama) || empty($alamat) || empty($kota) || empty($id)) {
            $hasil = $this->error('INPUT TIDAK LENGKAP, SILAHKAN CEK KEMBALI');
        } else {
            $save = $this->model_sales->updateKaroseri(array(
                'karo_nama' => $nama,
                'karo_alamat' => $alamat,
                'karo_cbid' => ses_cabang,
                'karo_telp' => $this->input->post('karo_telp', TRUE),
                'karo_kontak' => strtoupper($this->input->post('karo_kontak', TRUE)),
                'karo_kotaid' => $kota), $id);
            if ($save['status'] == TRUE) {
                $hasil = $this->sukses($save['msg']);
            } else {
                $hasil = $this->error($save['msg']);
            }
        }
        echo json_encode($hasil);
    }

    public function deleteKaroseri() {
        $id = $this->input->post('id', TRUE);
        if (empty($id)) {
            $hasil = $this->error('Hapus data gagal');
        } else {
            if ($this->model_sales->deleteKaroseri($id)) {
                $hasil = $this->sukses('Hapus data berhasil');
            } else {
                $hasil = $this->error('Hapus data gagal');
            }
        }
        echo json_encode($hasil);
    }

    /**
     * Master Aksesories
     * @author Rossi
     * * */
    public function aksesories() {
        $this->hakAkses(1092);
        $this->load->view('dataAksesories', $this->data);
    }

    public function getAksesories() {
        $data = $this->input->get('aksid', TRUE);
        $result = $this->model_sales->getAksesories($data);
        $responce = array();
        if (count($result) > 0)
            $responce = $result;
        echo json_encode($responce);
    }

    public function saveAksesories() {
        $nama = strtoupper($this->input->post('aks_nama', TRUE));
        $desc = strtoupper($this->input->post('aks_descrip', TRUE));
        if (empty($nama) || empty($desc)) {
            $hasil = $this->error('INPUT TIDAK LENGKAP, SILAHKAN CEK KEMBALI');
        } else {
            $save = $this->model_sales->addAksesories(array(
                'aks_nama' => $nama,
                'aks_descrip' => $desc,
                'aks_cbid' => ses_cabang,
                'aks_hpp' => numeric($this->input->post('aks_hpp', TRUE)),
                'aks_harga' => numeric($this->input->post('aks_harga', TRUE))
                    ));
            if ($save == TRUE) {
                $hasil = array('status' => '1', 'msg' => $this->sukses('DATA BERHASIL DISIMPAN'));
            } else {
                $hasil = array('status' => '0', 'msg' => $this->error('DATA GAGAL DISIMPAN'));
            }
        }
        echo json_encode($hasil);
    }

    public function loadAksesories() {
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $limit = isset($_POST['rows']) ? $_POST['rows'] : 10;
        $sidx = isset($_POST['sidx']) ? $_POST['sidx'] : 'merkid';
        $sord = isset($_POST['sord']) ? $_POST['sord'] : '';
        $start = $limit * $page - $limit;
        $start = ($start < 0) ? 0 : $start;
        $where = whereLoad();
        $count = $this->model_sales->getTotalAksesories($where);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;
        $query = $this->model_sales->getDataAksesories($start, $limit, $sidx, $sord, $where);
        $responce = new stdClass;
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
        $i = 0;
        if (count($query) > 0)
            foreach ($query as $row) {
                $del = "hapusData('" . $row->aksid . "', '" . $row->aks_nama . "')";
                $hapus = '<a href="javascript:void(0);" onclick="' . $del . '" title="Hapus"><i class="ace-icon fa fa-trash-o bigger-120 orange"></i>';
                $edit = '<a href="#master_sales/editAksesories?id=' . $row->aksid . '" title="Edit"><i class="ace-icon glyphicon glyphicon-pencil bigger-100"></i>';
                $responce->rows[$i]['id'] = $row->aksid;
                $responce->rows[$i]['cell'] = array(
                    $row->aks_nama,
                    $row->aks_descrip,
                    number_format($row->aks_hpp),
                    number_format($row->aks_harga),
                    $edit, $hapus);
                $i++;
            }
        echo json_encode($responce);
    }

    public function addAksesories() {
        $this->hakAkses(1092);
        $this->load->view('addAksesories', $this->data);
    }

    public function editAksesories() {
        $this->hakAkses(1092);
        $id = $this->input->get('id', TRUE);
        $this->data['data'] = $this->model_sales->getAksesories($id);
        $this->load->view('editAksesories', $this->data);
    }

    public function updateAksesories() {
        $id = strtoupper($this->input->post('aksid', TRUE));
        $nama = strtoupper($this->input->post('aks_nama', TRUE));
        $desc = strtoupper($this->input->post('aks_descrip', TRUE));
        $hpp = numeric($this->input->post('aks_harga', TRUE));
        $harga = numeric($this->input->post('aks_hpp', TRUE));
        if (empty($id) || empty($nama) || empty($desc) || empty($hpp) || empty($harga)) {
            $hasil = $this->error('INPUT TIDAK LENGKAP, SILAHKAN CEK KEMBALI');
        } else {
            $save = $this->model_sales->updateAksesories(array(
                'aks_nama' => $nama,
                'aks_descrip' => $desc,
                'aks_cbid' => ses_cabang,
                'aks_hpp' => $hpp,
                'aks_harga' => $harga), $id);
            if ($save == TRUE) {
                $hasil = array('status' => '1', 'msg' => $this->sukses('DATA BERHASIL DIUPDATE'));
            } else {
                $hasil = array('status' => '0', 'msg' => $this->error('DATA GAGAL DIUPDATE'));
            }
        }
        echo json_encode($hasil);
    }

    public function deleteAksesories() {
        $id = $this->input->post('id', TRUE);
        if (empty($id)) {
            $hasil = $this->error('DATA GAGAL DIHAPUS');
        } else {
            if ($this->model_sales->deleteAksesories($id)) {
                $hasil = $this->sukses('DATA BERHASIL DIHAPUS');
            } else {
                $hasil = $this->error('DATA GAGAL DIHAPUS');
            }
        }
        echo json_encode($hasil);
    }

    public function addSupplier() {
        $this->hakAkses(91);
        $this->data['propinsi'] = $this->model_admin->getPropinsi();
        $this->load->view('master_service/addSupplier', $this->data);
    }

    public function supplier() {
        $this->hakAkses(91);
        $this->data['add'] = "master_sales/addSupplier";
        $this->load->view('master_service/supplier', $this->data);
    }

    /**
     * Master Stock Unit
     * @author Rossi
     * * */
    public function stockUnit() {
        $this->hakAkses(1092);
        $this->load->view('dataStockUnit', $this->data);
    }

    public function getStockUnit() {
        $data = $this->input->get('mscid', TRUE);
        $result = $this->model_sales->getStockUnit($data);
        $responce = array();
        if (count($result) > 0)
            $responce = $result;
        echo json_encode($responce);
    }

    public function saveStockUnit() {
        $norangka = strtoupper($this->input->post('msc_norangka', TRUE));
        $nomesin = strtoupper($this->input->post('msc_nomesin', TRUE));
        $jkend = strtoupper($this->input->post('msc_segid', TRUE));
        $type = strtoupper($this->input->post('msc_ctyid', TRUE));
        $warna = strtoupper($this->input->post('msc_warnaid', TRUE));
        $tahun = strtoupper($this->input->post('msc_tahun', TRUE));
        $kondisi = strtoupper($this->input->post('msc_kondisi', TRUE));
        if (empty($norangka) || empty($nomesin) || empty($jkend) || empty($type) ||
                empty($warna) || empty($tahun) || empty($kondisi)) {
            $hasil = array('status' => '0', 'msg' => $this->error('Rangka : ' . $norangka . ' | Mesin : ' . $nomesin .
                        ' | Jkend : ' . $jkend . ' | Type : ' . $type . ' | Warna : ' . $warna . ' | Tahun : ' . $tahun . ' | Kondisi : ' . $kondisi));
        } else {
            $save = $this->model_sales->addStockUnit(array(
                'msc_norangka' => $norangka,
                'msc_nomesin' => $nomesin,
                'msc_jenis' => $jkend,
                'msc_ctyid' => $type,
                'msc_warnaid' => $warna,
                'msc_tahun' => $tahun,
                'msc_kondisi' => $kondisi,
                'msc_cbid' => ses_cabang,
                'msc_isstock' => 1,
                'msc_status' => "B",
                'msc_roda' => strtoupper($this->input->post('msc_roda', TRUE)),
                'msc_chasis' => strtoupper($this->input->post('msc_chasis', TRUE)),
                'msc_vinlot' => strtoupper($this->input->post('msc_vinlot', TRUE)),
                'msc_bodyseri' => strtoupper($this->input->post('msc_bodyseri', TRUE)),
                'msc_nokunci' => strtoupper($this->input->post('msc_nokunci', TRUE)),
                'msc_fuel' => strtoupper($this->input->post('msc_fuel', TRUE)),
                'msc_regckd' => strtoupper($this->input->post('msc_regckd', TRUE)),
                'msc_silinder' => numeric($this->input->post('msc_silinder', TRUE)),
                'msc_createon' => date('Y-m-d H:i:s'),
                'msc_createby' => ses_krid
                    ));
            if ($save['status'] == TRUE) {
                $hasil = array('status' => TRUE, 'msg' => $this->sukses($save['msg']));
            } else {
                $hasil = array('status' => FALSE, 'msg' => $this->error($save['msg']));
            }
        }
        echo json_encode($hasil);
    }

    public function loadStockUnit() {
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $limit = isset($_POST['rows']) ? $_POST['rows'] : 10;
        $sidx = isset($_POST['sidx']) ? $_POST['sidx'] : 'merkid';
        $sord = isset($_POST['sord']) ? $_POST['sord'] : '';
        $start = $limit * $page - $limit;
        $start = ($start < 0) ? 0 : $start;
        $where = whereLoad();
        $count = $this->model_sales->getTotalStockUnit($where);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;
        $query = $this->model_sales->getDataStockUnit($start, $limit, $sidx, $sord, $where);
        $responce = new stdClass;
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
        $i = 0;
        if (count($query) > 0)
            foreach ($query as $row) {
                $del = "hapusData('" . $row->mscid . "', '" . $row->cty_deskripsi . "')";
                $hapus = '<a href="javascript:void(0);" onclick="' . $del . '" title="Hapus"><i class="ace-icon fa fa-trash-o bigger-120 orange"></i>';
                $edit = '<a href="#master_sales/editStockUnit?id=' . $row->mscid . '" title="Edit"><i class="ace-icon glyphicon glyphicon-pencil bigger-100"></i>';
                $view = '<a href="#master_sales/viewStockUnit?id=' . $row->mscid . '" title="View"><i class="ace-icon glyphicon glyphicon-list bigger-100"></i>';
                $responce->rows[$i]['id'] = $row->mscid;
                $responce->rows[$i]['cell'] = array(
                    $view, $edit, $hapus,
                    $row->merk_deskripsi,
                    $row->cty_deskripsi,
                    $row->warna_deskripsi,
                    $row->msc_norangka,
                    $row->msc_nomesin,
                    $row->msc_kondisi);
                $i++;
            }
        echo json_encode($responce);
    }

    public function addStockUnit() {
        $this->hakAkses(1092);
        $this->data['merk'] = $this->model_sales->cListMerk();
        $this->data['segment'] = $this->model_sales->cListSegment();
        $this->load->view('addStockUnit', $this->data);
    }

    public function editStockUnit() {
        $this->hakAkses(1092);
        $this->data['merk'] = $this->model_sales->cListMerk();
        $this->data['segment'] = $this->model_sales->cListSegment();
        $id = $this->input->get('id', TRUE);
        $this->data['data'] = $this->model_sales->getStockUnit($id);
        $this->load->view('editStockUnit', $this->data);
    }

    public function updateStockUnit() {
        $id = strtoupper($this->input->post('mscid', TRUE));
        $norangka = strtoupper($this->input->post('msc_norangka', TRUE));
        $nomesin = strtoupper($this->input->post('msc_nomesin', TRUE));
        $jkend = strtoupper($this->input->post('msc_segid', TRUE));
        $type = strtoupper($this->input->post('msc_ctyid', TRUE));
        $warna = strtoupper($this->input->post('msc_warnaid', TRUE));
        $tahun = strtoupper($this->input->post('msc_tahun', TRUE));
        $kondisi = strtoupper($this->input->post('msc_kondisi', TRUE));
        if (empty($id) || empty($norangka) || empty($nomesin) || empty($jkend) || empty($type) ||
                empty($warna) || empty($tahun) || empty($kondisi)) {
            $hasil = array('status' => '0', 'msg' => $this->error('Rangka : ' . $norangka . ' | Mesin : ' . $nomesin .
                        ' | Jkend : ' . $jkend . ' | Type : ' . $type . ' | Warna : ' . $warna . ' | Tahun : ' . $tahun . ' | Kondisi : ' . $kondisi));
        } else {
            $save = $this->model_sales->updateStockUnit(array(
                'msc_norangka' => $norangka,
                'msc_nomesin' => $nomesin,
                'msc_jenis' => $jkend,
                'msc_ctyid' => $type,
                'msc_warnaid' => $warna,
                'msc_tahun' => $tahun,
                'msc_kondisi' => $kondisi,
                'msc_cbid' => ses_cabang,
                'msc_status' => "B",
                'msc_roda' => strtoupper($this->input->post('msc_roda', TRUE)),
                'msc_chasis' => strtoupper($this->input->post('msc_chasis', TRUE)),
                'msc_vinlot' => strtoupper($this->input->post('msc_vinlot', TRUE)),
                'msc_bodyseri' => strtoupper($this->input->post('msc_bodyseri', TRUE)),
                'msc_nokunci' => strtoupper($this->input->post('msc_nokunci', TRUE)),
                'msc_fuel' => strtoupper($this->input->post('msc_fuel', TRUE)),
                'msc_regckd' => strtoupper($this->input->post('msc_regckd', TRUE)),
                'msc_silinder' => numeric($this->input->post('msc_silinder', TRUE)),
                'msc_createon' => date('Y-m-d H:i:s'),
                'msc_createby' => ses_krid
                    ), $id);
            if ($save['status'] == TRUE) {
                $hasil = array('status' => TRUE, 'msg' => $this->sukses($save['msg']));
            } else {
                $hasil = array('status' => FALSE, 'msg' => $this->error($save['msg']));
            }
        }
        echo json_encode($hasil);
    }

    public function deleteStockUnit() {
        $id = $this->input->post('id', TRUE);
        if (empty($id)) {
            $hasil = $this->error('DATA GAGAL DIHAPUS');
        } else {
            if ($this->model_sales->deleteStockUnit($id)) {
                $hasil = $this->sukses('DATA BERHASIL DIHAPUS');
            } else {
                $hasil = $this->error('DATA GAGAL DIHAPUS');
            }
        }
        echo json_encode($hasil);
    }

}

?>
