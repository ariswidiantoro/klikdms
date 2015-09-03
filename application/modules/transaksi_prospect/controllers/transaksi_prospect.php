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
        $this->load->model(array('model_admin', 'model_prospect'));
    }

    public function index() {
        $this->addProspect();
    }

    /**
     * This function displays list of prospect datas
     * @author Rossi
     * @since 1.0
     */
    public function listProspect() {
        $this->hakAkses(1059);
        $this->data['title'] = 'Daftar Prospect';
        $this->load->view('listProspect', $this->data);
    }

    public function loadDataProspect() {
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $limit = isset($_POST['rows']) ? $_POST['rows'] : 10;
        $sidx = isset($_POST['sidx']) ? $_POST['sidx'] : 'pros_tgl';
        $sord = isset($_POST['sord']) ? $_POST['sord'] : 'DESC';
        $start = $limit * $page - $limit;
        $start = ($start < 0) ? 0 : $start;
        $where = whereLoad();
        $result = $this->model_prospect->loadProspect(array(
            'where' => $where,
            'start' => $start,
            'limit' => $limit,
            'sidx' => $sidx,
            'sord' => $sord
            ));
        if ($result['numrows'] > 0) {
            $total_pages = ceil($result['numrows'] / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages) $page = $total_pages;
        
        $responce = new stdClass;
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $result['numrows'];
        $i = 0;
        if (count($result['numrows']) > 0)
            foreach ($query as $row) {
                $hapus = '-';
                $edit = '-';
                if ($row->kr_status == '0') {
                    $del = "hapusKaryawan('" . $row->krid . "')";
                    $hapus = '<a href="javascript:void(0);" onclick="' . $del . '" title="Hapus"><i class="ace-icon fa fa-trash-o bigger-120 orange"></i>';
                    $edit = '<a href="#admin/editKaryawan?id=' . $row->krid . '" title="edit"><i class="ace-icon glyphicon glyphicon-pencil bigger-100"></i>';
                }
                $responce->rows[$i]['id'] = $row->krid;
                $responce->rows[$i]['cell'] = array(
                    $row->kr_nik, $row->kr_nama, $row->kr_alamat, $row->kr_hp, $row->kr_nomor_ktp, $row->kr_username, $edit, $hapus);
                $i++;
            }
        echo json_encode($responce);
    }

    /**
     * This function is used for display cabang
     * @author Aris
     * @since 1.0
     */
    public function addProspect() {
        $this->hakAkses(76);
        $this->data['title'] = 'Tambah Prospect';
        $this->data['content'] = 'addProspect';
        $this->load->view('template', $this->data);
    }

    /**
     * This function is used for display cabang
     * @author Aris
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
     * @author Aris
     * @since 1.0
     */
    public function searchVehicle() {
        $this->hakAkses(74);
        $this->data['title'] = 'Pencarian Kendaraan';
        $this->data['content'] = 'searchVehicle';
        $this->load->view('template', $this->data);
    }

    /**
     * Function ini digunakan untuk mengambil data jabatan
     */
    public function loadJabatan() {
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 20;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'jabatan_deskripsi';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
        $kode = isset($_POST['sortby']) ? trim($_POST['sortby']) : '';
        $offset = ($page - 1) * $rows;
        $where = array('sortby' => strtolower($kode));
        $result["total"] = $this->model_admin->getTotalJabatan($where);
        $query = $this->model_admin->getAllJabatan($sort, $order, $offset, $rows, $where);
        if (count($query) > 0) {
            foreach ($query as $row) {
                $delete = 'deleteJabatan("' . $row['jabatanid'] . '")';
                $ed = 'editRole("' . $row['jabatanid'] . '")';
                $edit = "<a href='" . site_url('administrator/editJabatan') . "/?id=" . $row['jabatanid'] . "' class='green' title='Edit'><i class='ace-icon fa fa-pencil bigger-130'></i></a>";
                $del = "" . "<a href='javascript:void(0)' onclick='$delete' class='red' title='Delete'><i class='ace-icon fa fa-trash-o bigger-130'></i></a>";
                $result['rows'][] = array(
                    'deskripsi' => $row['jabatan_deskripsi'],
                    'edit' => $edit,
                    'hapus' => $del,
                );
            }
        } else {
            $result['rows'][] = array('id' => "");
        }
        echo json_encode($result);
    }

}

?>