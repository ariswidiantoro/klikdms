<?php

/**
 * Class Admin_Controller
 * @author Rossi
 * 2013-11-11
 */
class Transaksi_Prospect extends Application {

    /**
     * The new Admin_controller
     */
    public function __construct() {
        parent::__construct();
        $this->load->model(array('model_admin', 'model_prospect', 'model_sales'));
    }

    public function index() {
        $this->addProspect();
    }

    /**
     * This function displays list of prospect datas
     * @author Rossi
     * @since 1.0
     */
    public function daftarProspect() {
        $this->hakAkses(1059);
        $this->data['title'] = 'Daftar Prospect';
        $this->load->view('dataProspect', $this->data);
    }

    public function loadProspect() {
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $limit = isset($_POST['rows']) ? $_POST['rows'] : 10;
        $sidx = isset($_POST['sidx']) ? $_POST['sidx'] : 'prosid';
        $sord = isset($_POST['sord']) ? $_POST['sord'] : 'DESC';
        $start = $limit * $page - $limit;
        $start = ($start < 0) ? 0 : $start;
        $where = whereLoad();
        $count = $this->model_prospect->getTotalProspect($where);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;
        $query = $this->model_prospect->getDataProspect($start, $limit, $sidx, $sord, $where);
        $responce = new stdClass;
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
        $i = 0;
        if (count($query) > 0)
            foreach ($query as $row) {
                $del = "hapusData('" . $row->prosid . "','" . $row->pros_nama . "')";
                $hapus = '<a href="javascript:void(0);" onclick="' . $del . '" title="Hapus"><i class="ace-icon fa fa-trash-o bigger-120 orange"></i>';
                $edit = '<a href="#transaksi_prospect/editProspect?id=' . $row->prosid . '" title="Edit"><i class="ace-icon glyphicon glyphicon-pencil bigger-100"></i>';
                $fpt = '<a href="#transaksi_prospect/addFpt?id=' . $row->prosid . '" title="Detail"><i class="ace-icon glyphicon glyphicon-book bigger-100"></i>';
                $detail = '<a href="#transaksi_prospect/detailProspect?id=' . $row->prosid . '" title="Detail"><i class="ace-icon glyphicon glyphicon-pencil bigger-100"></i>';

                $responce->rows[$i]['id'] = $row->prosid;
                $responce->rows[$i]['cell'] = array(
                    $fpt.'  '.$edit.'  '.$hapus,
                    $row->prosid, 
                    $row->pros_createon, 
                    $row->pros_nama,
                    $row->pros_alamat, 
                    $row->pros_hp, 
                    $row->pros_telpon, 
                    $row->cty_deskripsi, 
                    $row->car_qty);
                $i++;
            }
        echo json_encode($responce);
    }

    public function addProspect() {
        $this->hakAkses(1060);
        $this->data['propinsi'] = $this->model_sales->cListPropinsi();
        $this->data['merk'] = $this->model_sales->cListMerk();
        $this->data['title'] = 'Tambah Prospect';
        $this->load->view('addProspect', $this->data);
    }
    
    public function editProspect() {
        $this->hakAkses(1060);
        $id = $this->input->get('id');
        $this->data['propinsi'] = $this->model_sales->cListPropinsi();
        $this->data['merk'] = $this->model_sales->cListMerk();
        $data = $this->model_sales->getProspect($id);
        $this->data['data'] = $data;
        $this->load->view('editProspect', $this->data);
    }

    public function saveProspect() {
        $tipe = strtoupper($this->input->post('pros_type', TRUE));
        $nama = strtoupper($this->input->post('pros_nama', TRUE));
        $alamat = strtoupper($this->input->post('pros_alamat', TRUE));
        $hp = strtoupper($this->input->post('pros_hp', TRUE));
        $kota = strtoupper($this->input->post('pros_kotaid', TRUE));
        $tgl = strtoupper($this->input->post('pros_tgl_lahir', TRUE));
        if(empty($tgl)) $tgl = '1970-01-01';
        if (empty($tipe)||empty($nama)||empty($alamat)||empty($hp)||empty($kota)) {
            $hasil = $this->error('INPUT TIDAK LENGKAP, SILAHKAN CEK KEMBALI');
        } else {
            $save = $this->model_prospect->addProspect(array(
                'pros_type' => $tipe,
                'pros_nama' => $nama,
                'pros_alamat' => $alamat,
                'pros_hp' => $hp,
                'pros_kotaid' => $kota,
                'pros_telpon' => $this->input->post('pros_telpon', TRUE),
                'pros_alamat_surat' => $this->input->post('pros_alamat_surat', TRUE),
                'pros_fax' => $this->input->post('pros_fax', TRUE),
                'pros_sumber_info' => $this->input->post('pros_sumber_info', TRUE),
                'pros_email' => $this->input->post('pros_email', TRUE),
                'pros_npwp' => $this->input->post('pros_npwp', TRUE),
                'pros_gender' => $this->input->post('pros_gender', TRUE),
                'pros_tempat_lahir' => $this->input->post('pros_tempat_lahir', TRUE),
                'pros_tgl_lahir' => dateToIndo($tgl),
                'pros_cbid' => ses_cabang,
                'pros_salesman' => ses_krid,
                'pros_status' => 1,
                'pros_status_hot' => 0,
                'pros_createby' => ses_username,
                'pros_createon' => date('Y-m-d H:i:s'),
                ));
            if ($save['status'] == TRUE) {
                $hasil = $this->sukses($save['msg']);
            } else {
                $hasil = $this->error($save['msg']);
            }
        }
        echo json_encode($hasil);
    }

    public function updateProspect() {
        $prosid = $this->input->post('prosid', TRUE);
        $tipe = strtoupper($this->input->post('pros_type', TRUE));
        $nama = strtoupper($this->input->post('pros_nama', TRUE));
        $alamat = strtoupper($this->input->post('pros_alamat', TRUE));
        $hp = strtoupper($this->input->post('pros_hp', TRUE));
        $kota = strtoupper($this->input->post('pros_kotaid', TRUE));
        if (empty($tipe)||empty($nama)||empty($alamat)||empty($hp)||empty($kota)) {
            $hasil = $this->error('INPUT TIDAK LENGKAP, SILAHKAN CEK KEMBALI');
        } else {
           $save = $this->model_prospect->updateProspect(array(
                'pros_type' => $tipe,
                'pros_nama' => $nama,
                'pros_alamat' => $alamat,
                'pros_hp' => $hp,
                'pros_kotaid' => $kota,
                'pros_telpon' => $this->input->post('pros_telpon', TRUE),
                'pros_alamat_surat' => $this->input->post('pros_alamat_surat', TRUE),
                'pros_fax' => $this->input->post('pros_fax', TRUE),
                'pros_sumber_info' => $this->input->post('pros_sumber_info', TRUE),
                'pros_email' => $this->input->post('pros_email', TRUE),
                'pros_npwp' => $this->input->post('pros_npwp', TRUE),
                'pros_gender' => $this->input->post('pros_gender', TRUE),
                'pros_tempat_lahir' => $this->input->post('pros_tempat_lahir', TRUE),
                'pros_tgl_lahir' => $this->input->post('pros_tgl_lahir', TRUE),
                ), $prosid);
            if ($save['status'] == TRUE) {
                $hasil = $this->sukses($save['msg']);
            } else {
                $hasil = $this->error($save['msg']);
            }
        }
        echo json_encode($hasil);
    }

    public function deleteProspect() {
        $id = $this->input->post('id', TRUE);
        if (empty($id)) {
            $hasil = $this->error('Hapus data gagal');
        } else {
            if ($this->model_prospect->deleteProspect($id)) {
                $hasil = $this->sukses('Hapus data berhasil');
            } else {
                $hasil = $this->error('Hapus data gagal');
            }
        }
        echo json_encode($hasil);
    }
    
    public function batalProspect() {
        $id = $this->input->post('id', TRUE);
        if (empty($id)) {
            $hasil = $this->error('Hapus data gagal');
        } else {
            if ($this->model_prospect->updateProspect($id)) {
                $hasil = $this->sukses('Hapus data berhasil');
            } else {
                $hasil = $this->error('Hapus data gagal');
            }
        }
        echo json_encode($hasil);
    }

    public function getProspect() {
        $data = $this->input->get('merkid', TRUE);
        $result = $this->model_sales->getMerk($data);
        $responce = array();
        if (count($result) > 0)
            $responce = $result;
        echo json_encode($responce);
    }
    
    /**
     * This function is used for display FPT Form
     * @author Rossi <rosoningati@gmail.com>
     * @since 1.0
     * Created on 2015-09-18
     */
    
    public function addFpt(){
        $this->hakAkses(1060);
        $id = $this->input->get('id', TRUE);
        $this->data['data'] = $this->model_prospect->getProspect($id);
        $this->data['propinsi'] = $this->model_sales->cListPropinsi();
        $this->data['merk'] = $this->model_sales->cListMerk();
        $this->data['aksesories'] = $this->model_sales->cListAksesories();
        $this->data['karoseri'] = $this->model_sales->cListKaroseri();
        $this->data['leasing'] = $this->model_sales->cListLeasing();
        $this->data['segment'] = $this->model_sales->cListSegment();
        $this->data['title'] = 'Form Persetujuan Transaksi (FPT)';
        $this->load->view('addFpt', $this->data);
    }
    
    public function saveFpt(){
        $prosid = strtoupper($this->input->post('pros_type', TRUE));
        $fptdate = strtoupper($this->input->post('pros_nama', TRUE));
        $alamat = strtoupper($this->input->post('pros_alamat', TRUE));
        $hp = strtoupper($this->input->post('pros_hp', TRUE));
        $kota = strtoupper($this->input->post('pros_kotaid', TRUE));
        if (empty($tipe)||empty($nama)||empty($alamat)||empty($hp)||empty($kota)) {
            $hasil = $this->error('INPUT TIDAK LENGKAP, SILAHKAN CEK KEMBALI');
        } else {
            $save = $this->model_prospect->addProspect(array(
                'pros_type' => $tipe,
                'pros_nama' => $nama,
                'pros_alamat' => $alamat,
                'pros_hp' => $hp,
                'pros_kotaid' => $kota,
                'pros_telpon' => $this->input->post('pros_telpon', TRUE),
                'pros_alamat_surat' => $this->input->post('pros_alamat_surat', TRUE),
                'pros_fax' => $this->input->post('pros_fax', TRUE),
                'pros_sumber_info' => $this->input->post('pros_sumber_info', TRUE),
                'pros_email' => $this->input->post('pros_email', TRUE),
                'pros_npwp' => $this->input->post('pros_npwp', TRUE),
                'pros_gender' => $this->input->post('pros_gender', TRUE),
                'pros_tempat_lahir' => $this->input->post('pros_tempat_lahir', TRUE),
                'pros_tgl_lahir' => dateToIndo($this->input->post('pros_tgl_lahir', TRUE)),
                'pros_cbid' => ses_cabang,
                'pros_salesman' => ses_krid,
                'pros_status' => 1,
                'pros_status_hot' => 0,
                'pros_createby' => ses_username,
                'pros_createon' => date('Y-m-d H:i:s'),
                ));
            if ($save['status'] == TRUE) {
                $hasil = $this->sukses($save['msg']);
            } else {
                $hasil = $this->error($save['msg']);
            }
        }
        echo json_encode($hasil);
    }
   
    
    /**
     * This function displays list of prospect datas
     * @author Rossi
     * @since 1.0
     */
    public function validasiFpt() {
        $this->hakAkses(1060);
        $this->data['title'] = 'Daftar FPT';
        $this->load->view('dataProspect', $this->data);
    }
    
    /**
     * This function is used for display cabang
     * @author Rossi
     * @since 1.0
     */
    public function transferProspect() {
        $this->hakAkses(76);
        $this->data['title'] = 'Transfer Prospect';
        $this->data['content'] = 'transferProspect';
        $this->load->view('template', $this->data);
    }

    /**
     * This function is used for display the exmination form
     * @author Rossi
     * @since 1.0
     */
    public function searchVehicle() {
        $this->hakAkses(74);
        $this->data['title'] = 'Pencarian Kendaraan';
        $this->data['content'] = 'searchVehicle';
        $this->load->view('template', $this->data);
    }

   

}

?>
