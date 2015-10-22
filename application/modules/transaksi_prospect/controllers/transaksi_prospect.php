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

    function printFpt($fptid) {
        $this->data['fpt'] = $this->model_prospect->getFptById($fptid);
        $this->data['asesoris'] = $this->model_prospect->getDetailFat($fptid);
        $this->data['dealer'] = $this->model_admin->getCabangById(ses_cabang);
        $this->load->view('printFpt', $this->data);
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
                $agenda = '-';
                $fpt = '-';
                $edit = '-';

                $detail = '<a href="#transaksi_prospect/detailProspect?id=' . $row->prosid . '" title="Detail"><i class="ace-icon glyphicon glyphicon-list bigger-100"></i>';
                if ($row->pros_salesman == ses_krid) {
                    $agenda = '<a href="#transaksi_prospect/agendaProspect?id=' . $row->prosid . '" title="Agenda"><i class="ace-icon fa fa-calendar"></i>';
                    if ($row->warm > 0) {
                        $fpt = '<a href="#transaksi_prospect/addFpt?id=' . $row->prosid . '" title="FPT"><i class="ace-icon fa fa-book bigger-100"></i>';
                    }
                    $edit = '<a href="#transaksi_prospect/editProspect?id=' . $row->prosid . '" title="Edit"><i class="ace-icon glyphicon glyphicon-pencil bigger-100"></i>';
                }
                $responce->rows[$i]['id'] = $row->prosid;
                if ($row->deal > 0) {
                    $status = '<img src="' . path_img() . 'hot_deal.png" width=20;height=20;>';
                } else if ($row->hot > 0) {
                    $status = '<img src="' . path_img() . 'hot.png" width=20;height=20;>';
                } else if ($row->warm > 0) {
                    $status = '<img src="' . path_img() . 'warm.png" width=20;height=20;>';
                } else {
                    $status = '<img src="' . path_img() . 'prospek.png" width=20;height=20;>';
                }
                $responce->rows[$i]['cell'] = array(
                    $row->pros_kode,
                    $row->pros_nama,
                    $row->kr_nama,
                    $status,
                    $agenda,
                    $fpt,
                    $edit,
                    $detail,
                );
                $i++;
            }
        echo json_encode($responce);
    }

    public function addProspect() {
        $this->hakAkses(1060);
        $this->data['propinsi'] = $this->model_admin->getPropinsi();
        $this->data['merk'] = $this->model_admin->getMerk();
        $this->data['sinfo'] = $this->model_prospect->cListSinfo();
        $this->data['kontak'] = $this->model_prospect->cListKontak();
        $this->data['bisnis'] = $this->model_prospect->cListBisnis();
        $this->data['title'] = 'Tambah Prospect';
        $this->load->view('addProspect', $this->data);
    }

    public function agendaProspect() {
        $this->hakAkses(1060);
        $prosid = $this->input->get('id');
        $this->data['prosid'] = $prosid;
        $this->data['agenda'] = $this->model_prospect->getAgendaByProspek($prosid);
        $this->data['follow'] = $this->model_prospect->getFollowUpByProspek($prosid);
        $this->load->view('agendaProspect', $this->data);
    }

    public function editProspect() {
        $this->hakAkses(1060);
        $id = $this->input->get('id');
        $this->data['propinsi'] = $this->model_admin->getPropinsi();
        $this->data['cars'] = $this->model_prospect->getDetailCars($id);
        $this->data['merk'] = $this->model_admin->getMerk();
        $this->data['sinfo'] = $this->model_prospect->cListSinfo();
        $this->data['kontak'] = $this->model_prospect->cListKontak();
        $this->data['bisnis'] = $this->model_prospect->cListBisnis();
        $data = $this->model_prospect->getProspect($id);
        $this->data['kota'] = $this->model_admin->getKotaByPropinsi($data['kota_propid']);
        $this->data['data'] = $data;
        $this->load->view('editProspect', $this->data);
    }

    public function detailProspect() {
        $this->hakAkses(1060);
        $id = $this->input->get('id');
        $this->data['data'] = $this->model_prospect->getProspect($id);
        $this->data['cars'] = $this->model_prospect->getDetailCars($id);
        $this->load->view('detailProspect', $this->data);
    }

    public function saveProspect() {
        $tipe = strtoupper($this->input->post('pros_type', TRUE));
        $nama = strtoupper($this->input->post('pros_nama', TRUE));
        $alamat = strtoupper($this->input->post('pros_alamat', TRUE));
        $hp = strtoupper($this->input->post('pros_hp', TRUE));
        $kota = strtoupper($this->input->post('pros_kotaid', TRUE));
        $tgl = strtoupper($this->input->post('pros_tgl_lahir', TRUE));
        if (empty($tgl))
            $tgl = defaultTgl();
        if (empty($tipe) || empty($nama) || empty($alamat) || empty($hp) || empty($kota)) {
            $hasil = $this->error('INPUT TIDAK LENGKAP, SILAHKAN CEK KEMBALI FIELD YG BERWARNA MERAH');
        } else {
            $data = array(
                'pros_type' => $tipe,
                'pros_nama' => $nama,
                'pros_alamat' => $alamat,
                'pros_hp' => $hp,
                'pros_kotaid' => $kota,
                'pros_area' => $this->input->post('pros_area', TRUE),
                'pros_telpon' => $this->input->post('pros_telpon', TRUE),
                'pros_alamat_surat' => $this->input->post('pros_alamat_surat', TRUE),
                'pros_fax' => $this->input->post('pros_fax', TRUE),
                'pros_email' => $this->input->post('pros_email', TRUE),
                'pros_gender' => $this->input->post('pros_gender', TRUE),
                'pros_noid' => $this->input->post('pros_nomor_id', TRUE),
                'pros_agama' => $this->input->post('pros_agama', TRUE),
                'pros_tempat_lahir' => $this->input->post('pros_tempat_lahir', TRUE),
                'pros_tgl_lahir' => dateToIndo($tgl),
                'pros_cbid' => ses_cabang,
                'pros_salesman' => ses_krid,
                'pros_bisnis' => $this->input->post('pros_bisnis', TRUE),
                'pros_kontak_awal' => $this->input->post('pros_kontak_awal', TRUE),
                'pros_sumber_info' => $this->input->post('pros_sumber_info', TRUE),
                'pros_npwp' => $this->input->post('pros_npwp', TRUE),
                'pros_keterangan' => $this->input->post('pros_keterangan', TRUE),
                'pros_status' => 1,
                'pros_status_hot' => 0,
                'pros_createby' => ses_username,
                'pros_createon' => date('Y-m-d H:i:s'),
            );

            $type = $this->input->post('car_ctyid', TRUE);
            $qty = $this->input->post('car_qty', TRUE);
            $cars = array();
            for ($i = 0; $i < count($type); $i++) {
                if ($qty[$i] > 0) {
                    $cars[] = array(
                        'car_ctyid' => $type[$i],
                        'car_qty' => numeric($qty[$i]),
                    );
                }
            }

            $save = $this->model_prospect->saveProspect($data, $cars);
            if ($save['status'] == TRUE) {
                $hasil['result'] = true;
                $hasil['msg'] = $this->sukses($save['msg']);
            } else {
                $hasil['result'] = false;
                $hasil['msg'] = $this->error($save['msg']);
            }
        }
        echo json_encode($hasil);
    }

    public function saveAgenda() {
        $agenda = $this->input->post('agenda', TRUE);
        $tglAgenda = $this->input->post('tgl_agenda', TRUE);
        if (empty($agenda) || empty($tglAgenda)) {
            $hasil['result'] = false;
            $hasil['msg'] = $this->error('INPUT TIDAK LENGKAP, SILAHKAN CEK KEMBALI FIELD YG BERWARNA MERAH');
        } else {
            $data = array(
                'agen_prosid' => $this->input->post('prosid'),
                'agen_deskripsi' => $agenda,
                'agen_cbid' => ses_cabang,
                'agen_tgl' => date('Y-m-d H:i:s', strtotime($tglAgenda)),
                'agen_createon' => date('Y-m-d H:i:s'),
            );
            if ($this->model_prospect->saveAgenda($data)) {
                $hasil['result'] = true;
                $this->session->set_flashdata('msg', $this->sukses('Berhasil menambah agenda'));
                $hasil['msg'] = $this->sukses('Berhasil menambah agenda');
            } else {
                $hasil['result'] = false;
                $this->session->set_flashdata('msg', $this->error('Gagal menambah agenda'));
                $hasil['msg'] = $this->error('Gagal menambah agenda');
            }
        }
        echo json_encode($hasil);
    }

    public function saveFollow() {
        $tglAgenda = $this->input->post('follow_tgl', TRUE);
        $deskripsi = $this->input->post('follow_deskripsi');
        if (empty($deskripsi) || empty($tglAgenda)) {
            $hasil['result'] = false;
            $hasil['msg'] = $this->error('INPUT TIDAK LENGKAP, SILAHKAN CEK KEMBALI FIELD YG BERWARNA MERAH');
        } else {
            $data = array(
                'follow_agenid' => $this->input->post('follow_agenid'),
                'follow_metode' => $this->input->post('follow_metode'),
                'follow_deskripsi' => $deskripsi,
                'follow_createby' => ses_username,
                'follow_statement' => $this->input->post('follow_statement'),
                'follow_tgl' => date('Y-m-d H:i:s', strtotime($tglAgenda)),
                'follow_createon' => date('Y-m-d H:i:s'),
            );
            if ($this->model_prospect->saveFollow($data)) {
                $hasil['result'] = true;
                $this->session->set_flashdata('msg', $this->sukses('Berhasil menambah follow'));
                $hasil['msg'] = $this->sukses('Berhasil menambah follow');
            } else {
                $hasil['result'] = false;
                $this->session->set_flashdata('msg', $this->sukses('Gagal menambah follow'));
                $hasil['msg'] = $this->error('Gagal menambah follow');
            }
        }
        echo json_encode($hasil);
    }

    public function updateProspect() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('pros_nama', '<b>Fx</b>', 'xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $tgl = $this->input->post('pros_tgl_lahir');
            if ($tgl == '') {
                $tgl = DEFAULT_TGL;
            }
            $data = array(
                'pros_type' => strtoupper($this->input->post('pros_type', TRUE)),
                'pros_nama' => strtoupper($this->input->post('pros_nama', TRUE)),
                'pros_alamat' => strtoupper($this->input->post('pros_alamat', TRUE)),
                'pros_hp' => $this->input->post('pros_hp', TRUE),
                'pros_kotaid' => $this->input->post('pros_kotaid', TRUE),
                'prosid' => $this->input->post('prosid', TRUE),
                'pros_area' => $this->input->post('pros_area', TRUE),
                'pros_telpon' => $this->input->post('pros_telpon', TRUE),
                'pros_alamat_surat' => $this->input->post('pros_alamat_surat', TRUE),
                'pros_fax' => $this->input->post('pros_fax', TRUE),
                'pros_email' => $this->input->post('pros_email', TRUE),
                'pros_gender' => $this->input->post('pros_gender', TRUE),
                'pros_noid' => $this->input->post('pros_nomor_id', TRUE),
                'pros_agama' => $this->input->post('pros_agama', TRUE),
                'pros_keterangan' => $this->input->post('pros_keterangan', TRUE),
                'pros_tempat_lahir' => $this->input->post('pros_tempat_lahir', TRUE),
                'pros_tgl_lahir' => dateToIndo($tgl),
                'pros_cbid' => ses_cabang,
                'pros_salesman' => ses_krid,
                'pros_bisnis' => $this->input->post('pros_bisnis', TRUE),
                'pros_kontak_awal' => $this->input->post('pros_kontak_awal', TRUE),
                'pros_sumber_info' => $this->input->post('pros_sumber_info', TRUE),
                'pros_npwp' => $this->input->post('pros_npwp', TRUE),
                'pros_status' => 1,
                'pros_status_hot' => 0,
                'pros_createby' => ses_username,
                'pros_createon' => date('Y-m-d H:i:s'),
            );


            $type = $this->input->post('car_ctyid', TRUE);
            $qty = $this->input->post('car_qty', TRUE);
            $detail = array();
            for ($i = 0; $i < count($type); $i++) {
                if ($qty[$i] > 0) {
                    $detail[] = array(
//                        'cars_merkid' => $merk[$i],
//                        'cars_modelid' => $model[$i],
                        'car_ctyid' => $type[$i],
                        'car_qty' => numeric($qty[$i]),
                    );
                }
            }
            $save = $this->model_prospect->updateProspect($data, $detail);
            if ($save['status'] == TRUE) {
                $hasil['result'] = true;
                $hasil['msg'] = $this->sukses($save['msg']);
            } else {
                $hasil['result'] = false;
                $hasil['msg'] = $this->error($save['msg']);
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
    public function addFpt() {
        $this->hakAkses(1060);
        $id = $this->input->get('id', TRUE);
        $this->data['data'] = $this->model_prospect->getProspect($id);
        $this->data['propinsi'] = $this->model_admin->getPropinsi();
        $this->data['merk'] = $this->model_sales->cListMerk();
        $this->data['aksesories'] = $this->model_sales->cListAksesories();
        $this->data['karoseri'] = $this->model_sales->cListKaroseri();
        $this->data['leasing'] = $this->model_sales->cListLeasing();
        $this->data['segment'] = $this->model_sales->cListSegment();
        $this->data['title'] = 'Form Persetujuan Transaksi (FPT)';
        $this->load->view('addFpt', $this->data);
    }

    public function editFpt() {
        $this->hakAkses(1060);
        $this->load->model('model_service');
        $id = $this->input->get('id', TRUE);
        $data = $this->model_prospect->getFptById($id);
        $this->data['data'] = $data;
        $this->data['propinsi'] = $this->model_admin->getPropinsi();
        $this->data['merk'] = $this->model_sales->cListMerk();
        $this->data['model'] = $this->model_service->getModelByMerk($data['fpt_merkid']);
        $this->data['type'] = $this->model_service->getTypeByModel($data['fpt_modelid']);
        $this->data['fat'] = $this->model_prospect->getDetailFat($id);
        $this->data['warna'] = $this->model_admin->getWarna();
        $this->data['aksesories'] = $this->model_sales->cListAksesories();
        $this->data['karoseri'] = $this->model_sales->cListKaroseri();
        $this->data['leasing'] = $this->model_sales->cListLeasing();
        $this->data['segment'] = $this->model_sales->cListSegment();
        $this->data['title'] = 'Form Persetujuan Transaksi (FPT)';
        $this->load->view('editFpt', $this->data);
    }

    public function saveFpt() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('fpt_prosid', '<b>Fx</b>', 'xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'fpt_prosid' => $this->input->post('fpt_prosid'),
                'fpt_tgl' => dateToIndo($this->input->post('fpt_tgl', TRUE)),
                'fpt_cbid' => ses_cabang,
                'fpt_note' => strtoupper($this->input->post('fpt_keterangan', TRUE)),
                'fpt_penerima_komisi' => strtoupper($this->input->post('fpt_penerima_komisi', TRUE)),
                'fpt_komisi' => numeric($this->input->post('fpt_komisi', TRUE)),
                'fpt_kondisi' => $this->input->post('fpt_kondisi', TRUE),
                'fpt_merkid' => $this->input->post('fpt_merkid', TRUE),
                'fpt_modelid' => $this->input->post('fpt_modelid', TRUE),
                'fpt_ctyid' => $this->input->post('fpt_ctyid', TRUE),
                'fpt_leasid' => $this->input->post('fpt_leasid', TRUE),
                'fpt_jangka' => $this->input->post('fpt_jangka', TRUE),
                'fpt_warnaid' => $this->input->post('fpt_warnaid', TRUE),
                'fpt_karoid' => $this->input->post('fpt_karoid', TRUE),
                'fpt_segid' => $this->input->post('fpt_segid', TRUE),
                'fpt_pay_method' => $this->input->post('fpt_pay_method', TRUE),
                'fpt_harga_method' => $this->input->post('fpt_harga_method', TRUE),
                'fpt_qty' => $this->input->post('fpt_qty', TRUE),
                'fpt_diskon' => numeric($this->input->post('fpt_diskon', TRUE)),
                'fpt_cashback' => numeric($this->input->post('fpt_cashback', TRUE)),
                'fpt_uangmuka' => numeric($this->input->post('fpt_uangmuka', TRUE)),
                'fpt_approve' => '1',
                'fpt_hargako' => numeric($this->input->post('fpt_hargako', TRUE)),
                'fpt_bbn' => numeric($this->input->post('fpt_bbn', TRUE)),
                'fpt_asuransi' => numeric($this->input->post('fpt_asuransi', TRUE)),
                'fpt_karoseri' => numeric($this->input->post('fpt_karoseri', TRUE)),
                'fpt_administrasi' => numeric($this->input->post('fpt_administrasi', TRUE)),
                'fpt_total' => numeric($this->input->post('fpt_total', TRUE)),
                'fpt_status' => '0',
                'fpt_createon' => date('Y-m-d H:i:s'),
                'fpt_createby' => ses_krid,
            );

            $id = $this->input->post('dtrans_aksid', TRUE);
            $harga = $this->input->post('dtrans_harga', TRUE);
            $fat = array();
            $acc = 0;
            for ($i = 0; $i < count($id); $i++) {
                if ($id[$i] != 0) {
                    if ($harga[$i] == '') {
                        $harga[$i] = 0;
                    }
                    $fat[] = array(
                        'fat_aksid' => $id[$i],
                        'fat_harga' => numeric($harga[$i]),
                    );
                    $acc += numeric($harga[$i]);
                }
            }
            $data['fpt_accesories'] = $acc;
            $data['fpt_total'] += $acc;
            $save = $this->model_prospect->saveFPT($data, $fat);
            if ($save['status'] == TRUE) {
                $hasil = array('result' => TRUE, 'msg' => $this->sukses($save['msg']));
            } else {
                $hasil = array('result' => FALSE, 'msg' => $this->error($save['msg']));
            }
        }
        echo json_encode($hasil);
    }

    public function updateFpt() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('fpt_prosid', '<b>Fx</b>', 'xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'fptid' => $this->input->post('fptid'),
                'fpt_prosid' => $this->input->post('fpt_prosid'),
                'fpt_tgl' => dateToIndo($this->input->post('fpt_tgl', TRUE)),
                'fpt_cbid' => ses_cabang,
                'fpt_note' => strtoupper($this->input->post('fpt_keterangan', TRUE)),
                'fpt_penerima_komisi' => strtoupper($this->input->post('fpt_penerima_komisi', TRUE)),
                'fpt_komisi' => numeric($this->input->post('fpt_komisi', TRUE)),
                'fpt_kondisi' => $this->input->post('fpt_kondisi', TRUE),
                'fpt_merkid' => $this->input->post('fpt_merkid', TRUE),
                'fpt_modelid' => $this->input->post('fpt_modelid', TRUE),
                'fpt_ctyid' => $this->input->post('fpt_ctyid', TRUE),
                'fpt_leasid' => $this->input->post('fpt_leasid', TRUE),
                'fpt_jangka' => $this->input->post('fpt_jangka', TRUE),
                'fpt_warnaid' => $this->input->post('fpt_warnaid', TRUE),
                'fpt_karoid' => $this->input->post('fpt_karoid', TRUE),
                'fpt_segid' => $this->input->post('fpt_segid', TRUE),
                'fpt_pay_method' => $this->input->post('fpt_pay_method', TRUE),
                'fpt_harga_method' => $this->input->post('fpt_harga_method', TRUE),
                'fpt_qty' => $this->input->post('fpt_qty', TRUE),
                'fpt_diskon' => numeric($this->input->post('fpt_diskon', TRUE)),
                'fpt_cashback' => numeric($this->input->post('fpt_cashback', TRUE)),
                'fpt_uangmuka' => numeric($this->input->post('fpt_uangmuka', TRUE)),
                'fpt_approve' => '1',
                'fpt_hargako' => numeric($this->input->post('fpt_hargako', TRUE)),
                'fpt_bbn' => numeric($this->input->post('fpt_bbn', TRUE)),
                'fpt_asuransi' => numeric($this->input->post('fpt_asuransi', TRUE)),
                'fpt_karoseri' => numeric($this->input->post('fpt_karoseri', TRUE)),
                'fpt_administrasi' => numeric($this->input->post('fpt_administrasi', TRUE)),
                'fpt_total' => numeric($this->input->post('fpt_total', TRUE)),
                'fpt_status' => '0',
                'fpt_createon' => date('Y-m-d H:i:s'),
                'fpt_createby' => ses_krid,
            );

            $id = $this->input->post('dtrans_aksid', TRUE);
            $harga = $this->input->post('dtrans_harga', TRUE);
            $fat = array();
            $acc = 0;
            for ($i = 0; $i < count($id); $i++) {
                if ($harga[$i] > 0) {
                    if ($harga[$i] == '') {
                        $harga[$i] = 0;
                    }
                    $fat[] = array(
                        'fat_aksid' => $id[$i],
                        'fat_harga' => numeric($harga[$i]),
                    );
                    $acc += numeric($harga[$i]);
                }
            }
            $data['fpt_accesories'] = $acc;
            $data['fpt_total'] += $acc;
            $save = $this->model_prospect->updateFpt($data, $fat);
            if ($save['result'] == TRUE) {
                $this->session->set_flashdata('msg', $this->sukses($save['msg']));
                $hasil = array('result' => TRUE, 'msg' => $this->sukses($save['msg']));
            } else {
                $this->session->set_flashdata('msg', $this->error($save['msg']));
                $hasil = array('result' => FALSE, 'msg' => $this->error($save['msg']));
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
        $this->load->view('dataFpt', $this->data);
    }

    public function loadDataFpt() {
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $limit = isset($_POST['rows']) ? $_POST['rows'] : 10;
        $sidx = isset($_POST['sidx']) ? $_POST['sidx'] : 'prosid';
        $status = isset($_POST['status']) ? $_POST['status'] : '';
        $sord = isset($_POST['sord']) ? $_POST['sord'] : 'DESC';
        $start = $limit * $page - $limit;
        $start = ($start < 0) ? 0 : $start;
        $where = "";

//        log_message('error', 'AAAA '.$status);
        $searchField = isset($_POST['searchField']) ? $_POST['searchField'] : false;
        $searchOper = isset($_POST['searchOper']) ? $_POST['searchOper'] : false;
        $searchString = isset($_POST['searchString']) ? $_POST['searchString'] : false;
        if ($_POST['_search'] == 'true') {

            if ($searchField == 'fpt_approve') {
                if (strtoupper($searchString) == 'PROSES') {
                    $searchString = '1';
                } else if (strtoupper($searchString) == 'SETUJU') {
                    $searchString = '2';
                } else if (strtoupper($searchString) == 'DEAL') {
                    $searchString = '3';
                } else if (strtoupper($searchString) == 'TOLAK') {
                    $searchString = '4';
                }
            }

            $ops = array(
                'eq' => '=',
                'ne' => '<>',
                'lt' => '<',
                'le' => '<=',
                'gt' => '>',
                'ge' => '>=',
                'bw' => 'LIKE',
                'bn' => 'NOT LIKE',
                'in' => 'LIKE',
                'ni' => 'NOT LIKE',
                'ew' => 'LIKE',
                'en' => 'NOT LIKE',
                'cn' => 'LIKE',
                'nc' => 'NOT LIKE'
            );
            foreach ($ops as $key => $value) {
                if ($searchOper == $key) {
                    $ops = $value;
                }
            }
            if ($searchOper == 'eq')
                $searchString = $searchString;
            if ($searchOper == 'bw' || $searchOper == 'bn')
                $searchString .= '%';
            if ($searchOper == 'ew' || $searchOper == 'en')
                $searchString = '%' . $searchString;
            if ($searchOper == 'cn' || $searchOper == 'nc' || $searchOper == 'in' || $searchOper == 'ni')
                $searchString = '%' . $searchString . '%';
            $where = "$searchField $ops '$searchString' ";
        }
        if ($where != '') {
            $where .= " AND ";
        }
        if ($status != '0') {
            $where .= " fpt_approve = $status";
        }

        $count = $this->model_prospect->getTotalFpt($where);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;
        $query = $this->model_prospect->getDataFpt($start, $limit, $sidx, $sord, $where);
        $responce = new stdClass;
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
        $i = 0;
        if (count($query) > 0)
            foreach ($query as $row) {
                $validasi = "-";
                if ($row->kr_atasan == ses_krid && $row->fpt_approve == 1) {
                    $val = "validasiData('" . $row->fptid . "','" . $row->pros_nama . "')";
                    $validasi = '<a href="javascript:void(0);" onclick="' . $val . '" title="Validasi"><i class="ace-icon glyphicon glyphicon-check bigger-110 green"></i>';
                }

                $edit = '<a href="#transaksi_prospect/editFpt?id=' . $row->fptid . '" title="Edit"><i class="ace-icon glyphicon glyphicon-pencil bigger-110 orange"></i>';
                $detail = '<a href="#transaksi_prospect/detailFpt?id=' . $row->fptid . '" title="Detail"><i class="ace-icon glyphicon glyphicon-list bigger-110"></i>';

                $print = '<a href="javascript:;" onclick="print(\'' . $row->fptid . '\')" title="Print"><i class="ace-icon glyphicon glyphicon-print bigger-120"></i>';
                $responce->rows[$i]['id'] = $row->fptid;
                $responce->rows[$i]['cell'] = array(
                    $row->fpt_kode,
                    $row->pros_nama,
                    $row->pros_alamat,
                    $row->fpt_status,
                    $row->kr_nama,
                    dateToIndo($row->fpt_tgl),
                    $validasi,
                    $edit,
                    $print,
                    $detail,
                );
                $i++;
            }
        echo json_encode($responce);
    }

    public function detailFpt() {
        $this->hakAkses(1060);
        $id = $this->input->get('id', TRUE);
        $this->data['data'] = $this->model_prospect->getFpt($id);
        $this->load->view('detailFpt', $this->data);
    }

    public function saveValidasiFpt() {
        $id = $this->input->post('id', TRUE);
        if (empty($id)) {
            $hasil = $this->error('GAGAL VALIDASI DATA KOSONG');
        } else {
            $save = $this->model_prospect->saveValidasiFpt(array(
                'fptid' => $id,
                'fpt_approve' => '2',
                'fpt_approve_by' => ses_krid,
                'fpt_approve_tgl' => date('Y-m-d')
                    ));
            if ($save) {
                $hasil = array('status' => TRUE, 'msg' => $this->sukses('DATA BERHASIL DIVALIDASI'));
            } else {
                $hasil = array('status' => FALSE, 'msg' => $this->error('DATA GAGAL DIVALIDASI'));
            }
        }
        echo json_encode($hasil);
    }

    public function saveTolakFPT() {
        $id = $this->input->post('id', TRUE);
        if (empty($id)) {
            $hasil = $this->error('GAGAL TOLAK DATA KOSONG');
        } else {
            $save = $this->model_prospect->updateFpt(array(
                'fptid' => ses_cabang,
                'fpt_approve' => '2',
                'fpt_approve_by' => ses_krid,
                'fpt_approve_tgl' => date('Y-m-d')
                    ), $id);
            if ($save['status'] == TRUE) {
                $hasil = array('status' => TRUE, 'msg' => $this->sukses('DATA BERHASIL DIVALIDASI'));
            } else {
                $hasil = array('status' => FALSE, 'msg' => $this->error('DATA GAGAL DIVALIDASI'));
            }
        }
        echo json_encode($hasil);
    }

    /**
     * This function is used for display cabang
     * @author Rossi
     * @since 1.0
     */
    public function transferProspect() {
        $this->hakAkses(1068);
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
        $this->hakAkses(1069);
        $this->data['title'] = 'Pencarian Kendaraan';
        $this->data['content'] = 'searchVehicle';
        $this->load->view('template', $this->data);
    }

    /* AUTO COMPLETE */

    public function autoAksesories() {
        $param = $this->input->post('param');
        $cbid = $this->input->post('cbid');
        $query = $this->model_prospect->autoAksesories(array('param' => strtoupper($param), 'cbid' => $cbid));
        if (!empty($query)) {
            $data['message'] = array();
            foreach ($query as $row) {
                $data['message'][] = array(
                    'value' => $row['aks_nama'],
                    'desc' => $row['aks_nama'] . '<br/>' . $row['aks_descrip'],
                    'trgone' => $row['aksid'],
                    'trgtwo' => $row['aks_harga']
                );
            }
        } else {
            $data['message'][] = array(
                'value' => 'DATA TIDAK ADA',
                'desc' => "",
                'trgone' => '',
                'trgtwo' => '0');
        }
        echo json_encode($data);
    }

}

?>
