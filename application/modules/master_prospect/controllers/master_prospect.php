<?php

/**
 * Class Master
 * @author Rossi Erl
 * 2013-11-11
 */
class Master_Prospect extends Application {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('model_admin', 'model_prospect', 'model_sales'));
        $this->isLogin();
    }

    public function index() {
        echo " ";
    }
    
    public function area() {
        $this->hakAkses(1070);
        $this->load->view('dataArea', $this->data);
    }

    public function loadArea() {
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $limit = isset($_POST['rows']) ? $_POST['rows'] : 10;
        $sidx = isset($_POST['sidx']) ? $_POST['sidx'] : 'areaid';
        $sord = isset($_POST['sord']) ? $_POST['sord'] : '';
        $start = $limit * $page - $limit;
        $start = ($start < 0) ? 0 : $start;
        $where = whereLoad();
        $count = $this->model_prospect->getTotalArea($where);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;
        $query = $this->model_prospect->getDataArea($start, $limit, $sidx, $sord, $where);
        $responce = new stdClass;
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
        $i = 0;
        if (count($query) > 0)
            foreach ($query as $row) {
                $del = "hapusData('" . $row->areaid . "', '" . $row->area_deskripsi . "')";
                $hapus = '<a href="javascript:void(0);" onclick="' . $del . '" title="Hapus"><i class="ace-icon fa fa-trash-o bigger-120 orange"></i>';
                $edit = '<a href="#master_sales/editArea?id=' . $row->areaid . '" title="Edit"><i class="ace-icon glyphicon glyphicon-pencil bigger-100"></i>';
                $responce->rows[$i]['id'] = $row->areaid;
                $responce->rows[$i]['cell'] = array(
                    $row->areaid,
                    $row->prop_deskripsi,
                    $row->kota_deskripsi,
                    $row->area_deskripsi,
                    $edit, $hapus);
                $i++;
            }
        echo json_encode($responce);
    }

    public function addArea() {
        $this->hakAkses(1070);
        $this->data['propinsi'] = $this->model_sales->cListPropinsi();
        $this->load->view('addArea', $this->data);
    }

    public function editArea() {
        $this->hakAkses(1070);
        $id = $this->input->get('id');
        $data = $this->model_prospect->getArea($id);
        $this->data['data'] = $data;
        $this->load->view('editArea', $this->data);
    }

    public function saveArea() {
        $desc = strtoupper($this->input->post('merk_deskripsi', TRUE));
        if (empty($desc)) {
            $hasil = $this->error('INPUT TIDAK LENGKAP, SILAHKAN CEK KEMBALI');
        } else {
            $save = $this->model_prospect->addArea(array('merk_deskripsi' => $desc));
            if ($save['status'] == TRUE) {
                $hasil = $this->sukses($save['msg']);
            } else {
                $hasil = $this->error($save['msg']);
            }
        }
        echo json_encode($hasil);
    }

    public function updateArea() {
        $areaid = $this->input->post('areaid', TRUE);
        $desc = strtoupper($this->input->post('area_deskripsi', TRUE));
        $kota = strtoupper($this->input->post('area_kotaid', TRUE));
        if (empty($desc)||empty($kota)) {
            $hasil = $this->error('INPUT TIDAK LENGKAP, SILAHKAN CEK KEMBALI');
        } else {
            $save = $this->model_prospect->updateArea(array(
                'area_cbid' => ses_cabang,
                'area_deskripsi' => strtoupper($desc),
                'area_kotaid' => strtoupper($kota)
                ), $areaid);
            if ($save['status'] == TRUE) {
                $hasil = $this->sukses($save['msg']);
            } else {
                $hasil = $this->error($save['msg']);
            }
        }
        echo json_encode($hasil);
    }

    public function deleteArea() {
        $id = $this->input->post('id', TRUE);
        if (empty($id)) {
            $hasil = $this->error('Hapus data gagal');
        } else {
            if ($this->model_prospect->deleteArea($id)) {
                $hasil = $this->sukses('Hapus data berhasil');
            } else {
                $hasil = $this->error('Hapus data gagal');
            }
        }
        echo json_encode($hasil);
    }

    public function getArea() {
        $data = $this->input->get('areaid', TRUE);
        $result = $this->model_prospect->getArea($data);
        $responce = array();
        if (count($result) > 0)
            $responce = $result;
        echo json_encode($responce);
    }

    /**
     * SUMBER INFORMASI 
     * @author Rossi Erl 
     * @since 1.0 2015-09-19
     */
    
    public function sumber_informasi() {
        $this->hakAkses(1070);
        $this->load->view('dataSmbInfo', $this->data);
    }

    public function loadSmbInfo() {
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $limit = isset($_POST['rows']) ? $_POST['rows'] : 10;
        $sidx = isset($_POST['sidx']) ? $_POST['sidx'] : 'areaid';
        $sord = isset($_POST['sord']) ? $_POST['sord'] : '';
        $start = $limit * $page - $limit;
        $start = ($start < 0) ? 0 : $start;
        $where = whereLoad();
        $count = $this->model_prospect->getTotalSmbInfo($where);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;
        $query = $this->model_prospect->getDataSmbInfo($start, $limit, $sidx, $sord, $where);
        $responce = new stdClass;
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
        $i = 0;
        if (count($query) > 0)
            foreach ($query as $row) {
                $del = "hapusData('" . $row->smbinfoid . "', '" . $row->smbinfo_deskripsi . "')";
                $hapus = '<a href="javascript:void(0);" onclick="' . $del . '" title="Hapus"><i class="ace-icon fa fa-trash-o bigger-120 orange"></i>';
                $edit = '<a href="#master_prospect/editSmbInfo?id=' . $row->smbinfoid . '" title="Edit"><i class="ace-icon glyphicon glyphicon-pencil bigger-100"></i>';
                $responce->rows[$i]['id'] = $row->smbinfoid;
                $responce->rows[$i]['cell'] = array(
                    $row->smbinfoid,
                    $row->smbinfo_deskripsi,
                    $edit, $hapus);
                $i++;
            }
        echo json_encode($responce);
    }

    public function addSmbInfo() {
        $this->hakAkses(1070);
        $this->load->view('addSmbInfo', $this->data);
    }

    public function editSmbInfo() {
        $this->hakAkses(1070);
        $id = $this->input->get('id');
        $data = $this->model_prospect->getSmbInfo($id);
        $this->data['data'] = $data;
        $this->load->view('editSmbInfo', $this->data);
    }

    public function saveSmbInfo() {
        $desc = strtoupper($this->input->post('smbinfo_deskripsi', TRUE));
        if (empty($desc)) {
            $hasil = $this->error('INPUT TIDAK LENGKAP, SILAHKAN CEK KEMBALI');
        } else {
            $save = $this->model_prospect->addSmbInfo(array('smbinfo_deskripsi' => $desc));
            if ($save['status'] == TRUE) {
                $hasil = $this->sukses($save['msg']);
            } else {
                $hasil = $this->error($save['msg']);
            }
        }
        echo json_encode($hasil);
    }

    public function updateSmbInfo() {
        $smbinfoid = $this->input->post('smbinfoid', TRUE);
        $desc = strtoupper($this->input->post('smbinfo_deskripsi', TRUE));
        if (empty($desc)) {
            $hasil = $this->error('INPUT TIDAK LENGKAP, SILAHKAN CEK KEMBALI');
        } else {
            $save = $this->model_prospect->updateSmbInfo(array('smbinfo_deskripsi' => strtoupper($desc)), $smbinfoid);
            if ($save['status'] == TRUE) {
                $hasil = $this->sukses($save['msg']);
            } else {
                $hasil = $this->error($save['msg']);
            }
        }
        echo json_encode($hasil);
    }

    public function deleteSmbInfo() {
        $id = $this->input->post('id', TRUE);
        if (empty($id)) {
            $hasil = $this->error('Hapus data gagal');
        } else {
            if ($this->model_prospect->deleteSmbInfo($id)) {
                $hasil = $this->sukses('Hapus data berhasil');
            } else {
                $hasil = $this->error('Hapus data gagal');
            }
        }
        echo json_encode($hasil);
    }

    public function getSmbInfo() {
        $data = $this->input->get('smbinfoid', TRUE);
        $result = $this->model_prospect->getSmbInfo($data);
        $responce = array();
        if (count($result) > 0)
            $responce = $result;
        echo json_encode($responce);
    }
    
    

}

?>
