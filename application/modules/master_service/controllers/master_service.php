<?php

/**
 * Class Admin_Controller
 * @author Aris
 * 2013-11-11
 */
class Master_Service extends Application {

    /**
     * The new Admin_controller
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('model_admin');
        $this->load->model('model_service');
//        $this->hakAkses(1);
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
    public function flateRate() {
        $this->hakAkses(26);
        $this->load->view('flateRate', $this->data);
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

    /**
     * This function is used for display menu form
     * @author Aris
     * @since 1.0
     */
    public function supplier() {
        $this->hakAkses(29);
        $this->load->view('supplier', $this->data);
    }

    /**
     * This function is used for display menu form
     * @author Aris
     * @since 1.0
     */
    public function dataKendaraan() {
        $this->hakAkses(33);
        $this->load->view('dataKendaraan', $this->data);
    }

    /**
     * This function is used for display menu form
     * @author Aris
     * @since 1.0
     */
    public function stall() {
        $this->hakAkses(31);
        $this->load->view('stall', $this->data);
    }

    /**
     * This function is used for display menu form
     * @author Aris
     * @since 1.0
     */
    public function absensiMekanik() {
        $this->hakAkses(30);
        $this->data['data'] = $this->model_service->getMekanikBelumAbsen(ses_cabang);
        $this->load->view('absensiMekanik', $this->data);
    }

    /**
     * This function is used for display menu form
     * @author Aris
     * @since 1.0
     */
    public function daftarAbsensi() {
        $this->hakAkses(30);
        $this->data['data'] = $this->model_service->getMekanikSudahAbsen(ses_cabang);
        $this->load->view('daftarAbsensi', $this->data);
    }

    /**
     * Digunakan untuk mengupdate group cabang masing2 user
     */
    function saveAbsensi() {
        $this->form_validation->set_rules('krid', '<b>Fx</b>', 'xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $krid = $this->input->post('krid');
            $start = $this->input->post('start');
            $end = $this->input->post('end');
            $total = $this->input->post('total');
            $keterangan = $this->input->post('keterangan');
            $arr = array();
            for ($i = 0; $i < count($krid); $i++) {
                if ($this->input->post('check' . $krid[$i]) == '1') {
                    $arr[] = array(
                        'abs_tgl' => date('Y-m-d'),
                        'abs_krid' => $krid[$i],
                        'abs_in' => $start[$i],
                        'abs_out' => $end[$i],
                        'abs_total' => $total[$i],
                        'abs_deskripsi' => $keterangan[$i],
                        'abs_cbid' => ses_cabang
                    );
                }
            }
            if ($this->model_service->saveAbsensi($arr)) {
                $hasil['result'] = true;
                $hasil['msg'] = $this->sukses("Berhasil menyimpan absensi");
            } else {
                $hasil['result'] = false;
                $hasil['msg'] = $this->error("Gagal menyimpan absensi");
            }
        }
        echo json_encode($hasil);
    }

    /**
     * This function is used for display menu form
     * @author Aris
     * @since 1.0
     */
    public function freeService() {
        $this->hakAkses(27);
        $this->load->view('freeService', $this->data);
    }

    /**
     * This function is used for display menu form
     * @author Aris
     * @since 1.0
     */
    public function basicRate() {
        $this->hakAkses(48);
        $this->load->view('basicRate', $this->data);
    }

    /**
     * This function is used for display the exmination form
     * @author Aris
     * @since 1.0
     */
    public function addFlateRate() {
        $this->hakAkses(26);
        $this->data['basic'] = $this->model_service->getBasicRate(ses_cabang);
        $this->load->view('addFlateRate', $this->data);
    }

    function jsonPelanggan() {
        $nama = $this->input->post('param');
        $cbid = ses_cabang;
        $data['response'] = 'false';
        $query = $this->model_service->getPelangganByNama($nama, $cbid);
        if (!empty($query)) {
            $data['response'] = 'true';
            $data['message'] = array();
            foreach ($query as $row) {
                $data['message'][] = array('value' => $row['pel_nama'], 'pelid' => $row['pelid'], 'desc' => $row['pel_alamat']);
            }
        } else {
            $data['message'][] = array('value' => '', 'label' => "Data Tidak Ada");
        }
        echo json_encode($data);
    }

    /**
     * This function is used for display the exmination form
     * @author Aris
     * @since 1.0
     */
    public function addPelanggan() {
//        $this->hakAkses(28);
        $this->data['propinsi'] = $this->model_admin->getPropinsi();
        $this->load->view('addPelanggan', $this->data);
    }

    /**
     * This function is used for display the exmination form
     * @author Aris
     * @since 1.0
     */
    public function addSupplier() {
//        $this->hakAkses(29);
        $this->data['propinsi'] = $this->model_admin->getPropinsi();
        $this->load->view('addSupplier', $this->data);
    }

    function jsonModelKendaraan() {
        $merkid = $this->input->post('merkid');
        echo json_encode($this->model_service->getModelByMerk($merkid));
    }

    function jsonTypeKendaraan() {
        $modelid = $this->input->post('modelid');
        echo json_encode($this->model_service->getTypeByModel($modelid));
    }

    /**
     * This function is used for display the exmination form
     * @author Aris
     * @since 1.0
     */
    public function addKendaraan() {
        $this->hakAkses(33);
        $this->data['merk'] = $this->model_admin->getMerk();
        $this->data['warna'] = $this->model_admin->getWarna();
        $this->load->view('addKendaraan', $this->data);
    }

    /**
     * This function is used for display the exmination form
     * @author Aris
     * @since 1.0
     */
    public function addFreeService() {
        $this->hakAkses(27);
        $this->load->view('addFreeService', $this->data);
    }

    /**
     * This function is used for display the exmination form
     * @author Aris
     * @since 1.0
     */
    public function addBasicRate() {
        $this->hakAkses(48);
        $this->load->view('addBasicRate', $this->data);
    }

    /**
     * This function is used for display the exmination form
     * @author Aris
     * @since 1.0
     */
    public function addStall() {
        $this->hakAkses(31);
        $this->load->view('addStall', $this->data);
    }

    /**
     * This function is used for display the exmination form
     * @author Aris
     * @since 1.0
     */
    public function editBasicRate() {
        $this->hakAkses(48);
        $id = $this->input->GET('id');
        $this->data['data'] = $this->model_service->getBasicRate($id);
        $this->load->view('editBasicRate', $this->data);
    }

    /**
     * This function is used for display the exmination form
     * @author Aris
     * @since 1.0
     */
    public function editStall() {
        $this->hakAkses(31);
        $id = $this->input->GET('id');
        $this->data['data'] = $this->model_service->getStall($id);
        $this->load->view('editStall', $this->data);
    }

    /**
     * This function is used for display the exmination form
     * @author Aris
     * @since 1.0
     */
    public function editFlateRate() {
        $this->hakAkses(26);
        $id = $this->input->GET('id');
        $this->data['data'] = $this->model_service->getFlateRate($id);
        $this->load->view('editFlateRate', $this->data);
    }

    /**
     * This function is used for display the exmination form
     * @author Aris
     * @since 1.0
     */
    public function editPelanggan() {
//        $this->hakAkses(28);
        $id = $this->input->GET('id');
        $data = $this->model_admin->getPelangganById($id);
        $this->data['data'] = $data;

        $this->data['propinsi'] = $this->model_admin->getPropinsi();
        $this->data['kota'] = $this->model_admin->getKotaByPropinsi($data['kota_propid']);
        $this->load->view('editPelanggan', $this->data);
    }

    /**
     * This function is used for display the exmination form
     * @author Aris
     * @since 1.0
     */
    public function editSupplier() {
//        $this->hakAkses(29);
        $id = $this->input->GET('id');
        $data = $this->model_admin->getSupplierById($id);
        $this->data['data'] = $data;

        $this->data['propinsi'] = $this->model_admin->getPropinsi();
        $this->data['kota'] = $this->model_admin->getKotaByPropinsi($data['kota_propid']);
        $this->load->view('editSupplier', $this->data);
    }

    /**
     * This function is used for display the exmination form
     * @author Aris
     * @since 1.0
     */
    public function editKendaraan() {
        $this->hakAkses(28);
        $id = $this->input->GET('id');
        $data = $this->model_service->getKendaraanById($id);
        $this->data['data'] = $data;

        $this->data['merk'] = $this->model_admin->getMerk();
        $this->data['model'] = $this->model_service->getModelByMerk($data['merkid']);
        $this->data['type'] = $this->model_service->getTypeByModel($data['modelid']);
        $this->data['warna'] = $this->model_admin->getWarna();
        $this->load->view('editKendaraan', $this->data);
    }

    /**
     * This function is used for display the exmination form
     * @author Aris
     * @since 1.0
     */
    public function editFreeService() {
        $this->hakAkses(27);
        $id = $this->input->GET('id');
        $this->data['data'] = $this->model_service->getFlateRate($id);
        $this->load->view('editFreeService', $this->data);
    }

    /**
     * Function ini digunakan untuk menyimpan jabatan
     */
    public function saveBasicRate() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('br_rate', '<b>Fx</b>', 'xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $rate = $this->system->numeric($this->input->post('br_rate'));
            $data = array(
                'br_cbid' => ses_cabang,
                'br_rate' => $rate
            );
            $hasil = $this->model_service->saveBasicRate($data);
            if ($hasil) {
                $hasil = $this->sukses("Berhasil menyimpan basic rate");
            } else {
                $hasil = $this->error("Gagal menyimpan basic rate");
            }
        }
        echo json_encode($hasil);
    }

    /**
     * Function ini digunakan untuk menyimpan jabatan
     */
    public function saveStall() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('stall_nomer', '<b>Fx</b>', 'xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $nomer = $this->input->post('stall_nomer');
            $data = array(
                'stall_cbid' => ses_cabang,
                'stall_nomer' => $nomer
            );
            if ($this->model_service->saveStall($data)) {
                $hasil['result'] = true;
                $hasil['msg'] = $this->sukses("Berhasil menyimpan Stall");
            } else {
                $hasil['result'] = false;
                $hasil['msg'] = $this->error("Gagal menyimpan Stall");
            }
        }
        echo json_encode($hasil);
    }

    /**
     * Function ini digunakan untuk menyimpan jabatan
     */
    public function updateStall() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('stall_nomer', '<b>Fx</b>', 'xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $nomer = $this->input->post('stall_nomer');
            $data = array(
                'stall_cbid' => ses_cabang,
                'stall_nomer' => $nomer,
                'stallid' => $this->input->post('stallid')
            );
            if ($this->model_service->updateStall($data)) {
                $hasil['result'] = true;
                $hasil['msg'] = $this->sukses("Berhasil menyimpan Stall");
            } else {
                $hasil['result'] = false;
                $hasil['msg'] = $this->error("Gagal menyimpan Stall");
            }
        }
        echo json_encode($hasil);
    }

    /**
     * Function ini digunakan untuk menyimpan jabatan
     */
    public function saveKendaraan() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('msc_nopol', '<b>Fx</b>', 'xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $stnkExp = $this->input->post("msc_stnkexp");
            if (empty($stnkExp)) {
                $stnkExp = defaultTgl();
            }
            $data = array(
                'msc_pelid' => strtoupper($this->input->post('msc_pelid')),
                'msc_nopol' => strtoupper(str_replace(' ', '', $this->input->post('msc_nopol'))),
                'msc_norangka' => strtoupper($this->input->post('msc_norangka')),
                'msc_nomesin' => strtoupper($this->input->post('msc_nomesin')),
                'msc_warnaid' => $this->input->post('msc_warnaid'),
                'msc_ctyid' => $this->input->post('msc_ctyid'),
                'msc_tahun' => $this->input->post('msc_tahun'),
                'msc_inextern' => $this->input->post('msc_inextern'),
                'msc_createon' => date('Y-m-d H:i:s'),
                'msc_createby' => ses_username,
                'msc_stnkexp' => dateToIndo($stnkExp),
                'msc_cbid' => ses_cabang
            );
            $return = array();
            $hasil = $this->model_service->saveKendaraan($data);
            if ($hasil) {
                $return['result'] = true;
                $return['msg'] = $this->sukses("Berhasil menyimpan kendaraan");
            } else {
                $return['result'] = false;
                $return['msg'] = $this->error("Gagal menyimpan kendaraan");
            }
        }
        echo json_encode($return);
    }

    /**
     * Function ini digunakan untuk menyimpan kendaraan
     */
    public function updateKendaraan() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('msc_nopol', '<b>Fx</b>', 'xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $stnkExp = $this->input->post("msc_stnkexp");
            if (empty($stnkExp)) {
                $stnkExp = defaultTgl();
            }
            $data = array(
                'mscid' => $this->input->post('mscid'),
                'msc_pelid' => strtoupper($this->input->post('msc_pelid')),
                'msc_nopol' => strtoupper(str_replace(' ', '', $this->input->post('msc_nopol'))),
                'msc_norangka' => strtoupper($this->input->post('msc_norangka')),
                'msc_nomesin' => strtoupper($this->input->post('msc_nomesin')),
                'msc_warnaid' => $this->input->post('msc_warnaid'),
                'msc_ctyid' => $this->input->post('msc_ctyid'),
                'msc_tahun' => $this->input->post('msc_tahun'),
                'msc_inextern' => $this->input->post('msc_inextern'),
                'msc_last_update' => date('Y-m-d H:i:s'),
                'msc_stnkexp' => dateToIndo($stnkExp),
                'msc_cbid' => ses_cabang
            );
            $return = array();
            $hasil = $this->model_service->updateKendaraan($data);
            if ($hasil) {
                $return['result'] = true;
                $return['msg'] = $this->sukses("Berhasil menyimpan kendaraan");
            } else {
                $return['result'] = false;
                $return['msg'] = $this->error("Gagal menyimpan kendaraan");
            }
        }
        echo json_encode($return);
    }

    /**
     * Function ini digunakan untuk menghapus pelanggan
     * @since 1.0
     * @author Aris
     */
    public function hapusPelanggan() {
        $id = $this->input->post('id');
        $hasil = $this->model_service->hapusPelanggan($id);
        if ($hasil) {
            $hasil = $this->sukses("Berhasil menghapus pelanggan");
        } else {
            $hasil = $this->error("Gagal menghapus pelanggan");
        }
        echo json_encode($hasil);
    }

    /**
     * Function ini digunakan untuk menghapus pelanggan
     * @since 1.0
     * @author Aris
     */
    public function hapusSupplier() {
        $id = $this->input->post('id');
        $hasil = $this->model_service->hapusSupplier($id);
        if ($hasil) {
            $hasil = $this->sukses("Berhasil menghapus supplier");
        } else {
            $hasil = $this->error("Gagal menghapus supplier");
        }
        echo json_encode($hasil);
    }

    /**
     * Function ini digunakan untuk menyimpan jabatan
     */
    public function savePelanggan() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('pel_nama', '<b>Fx</b>', 'xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $tgl = $this->input->post('pel_tgl_lahir');
            if (empty($tgl)) {
                $tgl = defaultTgl();
            }
            $data = array(
                'pel_cbid' => ses_cabang,
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
            $hasil = $this->model_service->savePelanggan($data);
            $retur = array();
            if ($hasil) {
                $retur['result'] = true;
                $retur['msg'] = $this->sukses("Berhasil menyimpan pelanggan");
            } else {
                $retur['result'] = false;
                $retur['msg'] = $this->error("Gagal menyimpan pelanggan");
            }
        }
        echo json_encode($retur);
    }

    /**
     * Function ini digunakan untuk menyimpan jabatan
     */
    public function saveSupplier() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('sup_nama', '<b>Fx</b>', 'xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'sup_cbid' => ses_cabang,
                'sup_nama' => strtoupper($this->input->post('sup_nama')),
                'sup_createby' => ses_username,
                'sup_createon' => date('Y-m-d H:i:s'),
                'sup_alamat' => strtoupper($this->input->post('sup_alamat')),
                'sup_kotaid' => $this->input->post('sup_kotaid'),
                'sup_hp' => $this->input->post('sup_hp'),
                'sup_npwp' => $this->input->post('sup_npwp'),
                'sup_telpon' => $this->input->post('sup_telpon'),
                'sup_fax' => $this->input->post('sup_fax'),
            );
            $hasil = $this->model_service->saveSupplier($data);
            $retur = array();
            if ($hasil) {
                $retur['result'] = true;
                $retur['msg'] = $this->sukses("Berhasil menyimpan supplier");
            } else {
                $retur['result'] = false;
                $retur['msg'] = $this->error("Gagal menyimpan supplier");
            }
        }
        echo json_encode($retur);
    }

    /**
     * Function ini digunakan untuk menyimpan jabatan
     */
    public function updateSupplier() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('sup_nama', '<b>Fx</b>', 'xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'sup_cbid' => ses_cabang,
                'sup_nama' => strtoupper($this->input->post('sup_nama')),
                'sup_createby' => ses_username,
                'sup_createon' => date('Y-m-d H:i:s'),
                'sup_alamat' => strtoupper($this->input->post('sup_alamat')),
                'sup_kotaid' => $this->input->post('sup_kotaid'),
                'sup_hp' => $this->input->post('sup_hp'),
                'supid' => $this->input->post('supid'),
                'sup_npwp' => $this->input->post('sup_npwp'),
                'sup_telpon' => $this->input->post('sup_telpon'),
                'sup_fax' => $this->input->post('sup_fax'),
            );
            $hasil = $this->model_service->updateSupplier($data);
            $retur = array();
            if ($hasil) {
                $retur['result'] = true;
                $retur['msg'] = $this->sukses("Berhasil menyimpan supplier");
            } else {
                $retur['result'] = false;
                $retur['msg'] = $this->error("Gagal menyimpan supplier");
            }
        }
        echo json_encode($retur);
    }

    /**
     * Function ini digunakan untuk menyimpan jabatan
     */
    public function updatePelanggan() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('pel_nama', '<b>Fx</b>', 'xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $tgl = $this->input->post('pel_tgl_lahir');
            if (empty($tgl)) {
                $tgl = defaultTgl();
            }
            $data = array(
                'pelid' => $this->input->post('pelid'),
                'pel_cbid' => ses_cabang,
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
            $hasil = $this->model_service->updatePelanggan($data);
            $retur = array();
            if ($hasil) {
                $retur['result'] = true;
                $retur['msg'] = $this->sukses("Berhasil menyimpan pelanggan");
            } else {
                $retur['result'] = false;
                $retur['msg'] = $this->error("Gagal menyimpan pelanggan");
            }
        }
        echo json_encode($retur);
    }

    /**
     * Function ini digunakan untuk menyimpan jabatan
     */
    public function saveFlateRate() {
        $retur = array();
        $this->form_validation->set_rules('flat_kode', '<b>Fx</b>', 'xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'flat_cbid' => ses_cabang,
                'flat_kode' => strtoupper($this->input->post('flat_kode')),
                'flat_type' => 1,
                'flat_createby' => ses_username,
                'flat_createon' => date('Y-m-d H:i:s'),
                'flat_deskripsi' => strtoupper($this->input->post('flat_deskripsi')),
                'flat_brate' => $this->system->numeric($this->input->post('flat_brate')),
                'flat_jam' => $this->system->numeric($this->input->post('flat_jam')),
                'flat_fx' => $this->system->numeric($this->input->post('flat_fx')),
                'flat_total' => $this->system->numeric($this->input->post('flat_total')),
                'flat_lc' => $this->system->numeric($this->input->post('flat_total')),
            );
            if ($this->model_service->saveFlateRate($data)) {
                $retur['result'] = true;
                $retur['msg'] = $this->sukses("Berhasil menyimpan flate rate");
            } else {
                $retur['result'] = false;
                $retur['msg'] = $this->error("Gagal menyimpan flate rate");
            }
        }
        echo json_encode($retur);
    }

    /**
     * Function ini digunakan untuk menyimpan jabatan
     */
    public function saveFreeService() {
        $this->form_validation->set_rules('flat_kode', '<b>Fx</b>', 'xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'flat_cbid' => ses_cabang,
                'flat_kode' => strtoupper($this->input->post('flat_kode')),
                'flat_free_jenis' => $this->input->post('flat_free_jenis'),
                'flat_type' => 2,
                'flat_createby' => ses_username,
                'flat_createon' => date('Y-m-d H:i:s'),
                'flat_deskripsi' => strtoupper($this->input->post('flat_deskripsi')),
                'flat_part' => $this->system->numeric($this->input->post('flat_part')),
                'flat_lc' => $this->system->numeric($this->input->post('flat_lc')),
                'flat_oli' => $this->system->numeric($this->input->post('flat_oli')),
                'flat_sm' => $this->system->numeric($this->input->post('flat_sm')),
                'flat_so' => $this->system->numeric($this->input->post('flat_so')),
                'flat_total' => $this->system->numeric($this->input->post('flat_total'))
            );
            $hasil = $this->model_service->saveFlateRate($data);
            if ($hasil) {
                $hasil = $this->sukses("Berhasil menyimpan Free Service");
            } else {
                $hasil = $this->error("Gagal menyimpan free Service");
            }
        }
        echo json_encode($hasil);
    }

    /**
     * Function ini digunakan untuk menyimpan jabatan
     */
    public function updateFreeService() {
        $this->form_validation->set_rules('flat_kode', '<b>Fx</b>', 'xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'flat_cbid' => ses_cabang,
                'flatid' => strtoupper($this->input->post('flatid')),
                'flat_kode' => strtoupper($this->input->post('flat_kode')),
                'flat_free_jenis' => $this->input->post('flat_free_jenis'),
                'flat_type' => 2,
                'flat_lastupdate' => date('Y-m-d H:i:s'),
                'flat_deskripsi' => strtoupper($this->input->post('flat_deskripsi')),
                'flat_part' => $this->system->numeric($this->input->post('flat_part')),
                'flat_lc' => $this->system->numeric($this->input->post('flat_lc')),
                'flat_oli' => $this->system->numeric($this->input->post('flat_oli')),
                'flat_sm' => $this->system->numeric($this->input->post('flat_sm')),
                'flat_so' => $this->system->numeric($this->input->post('flat_so')),
                'flat_total' => $this->system->numeric($this->input->post('flat_total'))
            );
            $hasil = $this->model_service->updateFlateRate($data);
            if ($hasil) {
                $hasil = $this->sukses("Berhasil menyimpan Free Service");
            } else {
                $hasil = $this->error("Gagal menyimpan free Service");
            }
        }
        echo json_encode($hasil);
    }

    /**
     * Function ini digunakan untuk menyimpan jabatan
     */
    public function updateFlateRate() {
        $this->form_validation->set_rules('flat_kode', '<b>Fx</b>', 'xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'flat_cbid' => ses_cabang,
                'flat_kode' => strtoupper($this->input->post('flat_kode')),
                'flatid' => $this->input->post('flatid'),
                'flat_type' => 1,
                'flat_lastupdate' => date('Y-m-d H:i:s'),
                'flat_deskripsi' => strtoupper($this->input->post('flat_deskripsi')),
                'flat_brate' => $this->system->numeric($this->input->post('flat_brate')),
                'flat_jam' => $this->system->numeric($this->input->post('flat_jam')),
                'flat_fx' => $this->system->numeric($this->input->post('flat_fx')),
                'flat_total' => $this->system->numeric($this->input->post('flat_total')),
                'flat_lc' => $this->system->numeric($this->input->post('flat_total')),
            );
            if ($this->model_service->updateFlateRate($data)) {
                $retur['result'] = true;
                $retur['msg'] = $this->sukses("Berhasil menyimpan flate rate");
            } else {
                $retur['result'] = false;
                $retur['msg'] = $this->error("Gagal menyimpan flate rate");
            }
        }
        echo json_encode($retur);
    }

    function loadFlateRate() {
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $limit = isset($_POST['rows']) ? $_POST['rows'] : 10;
        $sidx = isset($_POST['sidx']) ? $_POST['sidx'] : 'flat_kode';
        $sord = isset($_POST['sord']) ? $_POST['sord'] : '';
        $start = $limit * $page - $limit;
        $start = ($start < 0) ? 0 : $start;
        $where = whereLoad();
        $count = $this->model_service->getTotalFlateRate($where);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;
        $query = $this->model_service->getAllFlateRate($start, $limit, $sidx, $sord, $where);
        $responce = new stdClass;
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
        $i = 0;
        if (count($query) > 0)
            foreach ($query as $row) {
                $del = "hapusFlateRate('" . $row->flatid . "')";
                $hapus = '<a href="javascript:;" onclick="' . $del . '" title="Hapus"><i class="ace-icon fa fa-trash-o bigger-120 orange"></i>';
                $edit = '<a href="#master_service/editFlateRate?id=' . $row->flatid . '" title="edit"><i class="ace-icon glyphicon glyphicon-pencil bigger-100"></i>';
                $responce->rows[$i]['id'] = $row->flatid;
                $responce->rows[$i]['cell'] = array(
                    $row->flat_kode, $row->flat_deskripsi, $row->flat_jam, $row->flat_fx, number_format($row->flat_brate), number_format($row->flat_total), $edit, $hapus);
                $i++;
            }
        echo json_encode($responce);
    }

    function loadPelanggan() {
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $limit = isset($_POST['rows']) ? $_POST['rows'] : 10;
        $sidx = isset($_POST['sidx']) ? $_POST['sidx'] : 'pel_nama';
        $sord = isset($_POST['sord']) ? $_POST['sord'] : '';
        $start = $limit * $page - $limit;
        $start = ($start < 0) ? 0 : $start;
        $where = whereLoad();
        $this->load->model('model_admin');
        $count = $this->model_service->getTotalPelanggan($where, 'ms_pelanggan');
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;
        $query = $this->model_service->getAllPelanggan($start, $limit, $sidx, $sord, $where, 'ms_pelanggan');
        $responce = new stdClass;
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
        $i = 0;
        if (count($query) > 0)
            foreach ($query as $row) {
                $hapus = '-';
                $edit = '-';
                if ($row->pel_status == '0') {
                    $del = "hapusPelanggan('" . $row->pelid . "')";
                    $hapus = '<a href="javascript:;" onclick="' . $del . '" title="Hapus"><i class="ace-icon fa fa-trash-o bigger-120 orange"></i>';
                    $edit = '<a href="#master_service/editPelanggan?id=' . $row->pelid . '" title="edit"><i class="ace-icon glyphicon glyphicon-pencil bigger-100"></i>';
                }
                $responce->rows[$i]['id'] = $row->pelid;
                $responce->rows[$i]['cell'] = array(
                    $row->pelid,
                    $row->pel_nama,
                    $row->pel_alamat,
                    $row->pel_hp,
                    $row->pel_telpon,
                    $row->pel_npwp,
                    $row->pel_email,
                    $edit,
                    $hapus);
                $i++;
            }
        echo json_encode($responce);
    }

    function loadSupplier() {
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $limit = isset($_POST['rows']) ? $_POST['rows'] : 10;
        $sidx = isset($_POST['sidx']) ? $_POST['sidx'] : 'sup_nama';
        $sord = isset($_POST['sord']) ? $_POST['sord'] : '';
        $start = $limit * $page - $limit;
        $start = ($start < 0) ? 0 : $start;
        $where = whereLoad();
        $this->load->model('model_admin');
        $count = $this->model_service->getTotalSupplier($where);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;
        $query = $this->model_service->getAllSupplier($start, $limit, $sidx, $sord, $where);
        $responce = new stdClass;
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
        $i = 0;
        if (count($query) > 0)
            foreach ($query as $row) {
                $hapus = '-';
                $edit = '-';
                if ($row->sup_status == '0') {
                    $del = "hapusSupplier('" . $row->supid . "')";
                    $hapus = '<a href="javascript:;" onclick="' . $del . '" title="Hapus"><i class="ace-icon fa fa-trash-o bigger-120 orange"></i>';
                    $edit = '<a href="#master_service/editSupplier?id=' . $row->supid . '" title="edit"><i class="ace-icon glyphicon glyphicon-pencil bigger-100"></i>';
                }
                $responce->rows[$i]['id'] = $row->supid;
                $responce->rows[$i]['cell'] = array(
                    $row->supid,
                    $row->sup_nama,
                    $row->sup_alamat,
                    $row->sup_hp,
                    $row->sup_telpon,
                    $row->sup_npwp,
                    $edit,
                    $hapus);
                $i++;
            }
        echo json_encode($responce);
    }

    function loadKendaraan() {
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $limit = isset($_POST['rows']) ? $_POST['rows'] : 10;
        $sidx = isset($_POST['sidx']) ? $_POST['sidx'] : 'msc_nopol';
        $sord = isset($_POST['sord']) ? $_POST['sord'] : '';
        $start = $limit * $page - $limit;
        $start = ($start < 0) ? 0 : $start;
        $where = whereLoad();
        $this->load->model('model_admin');
        $count = $this->model_service->getTotalKendaraan($where);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;
        $query = $this->model_service->getAllKendaraan($start, $limit, $sidx, $sord, $where);
        $responce = new stdClass;
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
        $i = 0;
        if (count($query) > 0)
            foreach ($query as $row) {
                $del = "hapusKendaraan('" . $row->mscid . "')";
                $hapus = '<a href="javascript:;" onclick="' . $del . '" title="Hapus"><i class="ace-icon fa fa-trash-o bigger-120 orange"></i>';
                $edit = '<a href="#master_service/editKendaraan?id=' . $row->mscid . '" title="edit"><i class="ace-icon glyphicon glyphicon-pencil bigger-100"></i>';
                $responce->rows[$i]['id'] = $row->mscid;
                $responce->rows[$i]['cell'] = array(
                    $row->pel_nama,
                    $row->msc_nopol,
                    $row->msc_norangka,
                    $row->msc_nomesin,
                    $row->merk_deskripsi,
                    $row->model_deskripsi,
                    $row->cty_deskripsi,
                    $row->msc_tahun,
                    $edit);
                $i++;
            }
        echo json_encode($responce);
    }

    function loadFreeService() {
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $limit = isset($_POST['rows']) ? $_POST['rows'] : 10;
        $sidx = isset($_POST['sidx']) ? $_POST['sidx'] : 'flat_kode';
        $sord = isset($_POST['sord']) ? $_POST['sord'] : '';
        $start = $limit * $page - $limit;
        $start = ($start < 0) ? 0 : $start;
        $where = whereLoad();
        $count = $this->model_service->getTotalFreeService($where);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;
        $query = $this->model_service->getAllFreeService($start, $limit, $sidx, $sord, $where);
        $responce = new stdClass;
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
        $i = 0;
        if (count($query) > 0)
            foreach ($query as $row) {
                $del = "hapusFlateRate('" . $row->flatid . "')";
                $hapus = '<a href="javascript:;" onclick="' . $del . '" title="Hapus"><i class="ace-icon fa fa-trash-o bigger-120 orange"></i>';
                $edit = '<a href="#master_service/editFreeService?id=' . $row->flatid . '" title="edit"><i class="ace-icon glyphicon glyphicon-pencil bigger-100"></i>';
                $responce->rows[$i]['id'] = $row->flatid;
                $responce->rows[$i]['cell'] = array(
                    $row->flat_kode, $row->flat_deskripsi, number_format($row->flat_lc), number_format($row->flat_part), number_format($row->flat_oli), number_format($row->flat_sm), number_format($row->flat_so), number_format($row->flat_total), $edit, $hapus);
                $i++;
            }
        echo json_encode($responce);
    }

    function loadBasicRate() {
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $limit = isset($_POST['rows']) ? $_POST['rows'] : 10;
        $sidx = isset($_POST['sidx']) ? $_POST['sidx'] : 'br_cbid';
        $sord = isset($_POST['sord']) ? $_POST['sord'] : '';
        $start = $limit * $page - $limit;
        $start = ($start < 0) ? 0 : $start;
        $where = whereLoad();
        $this->load->model('model_admin');
        $count = $this->model_admin->getTotalData($where, 'svc_brate');
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;
        $query = $this->model_admin->getAllData($start, $limit, $sidx, $sord, $where, 'svc_brate');
        $responce = new stdClass;
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
        $i = 0;
        if (count($query) > 0)
            foreach ($query as $row) {
                $del = "hapusBasicRate('" . $row->br_cbid . "')";
                $hapus = '<a href="javascript:;" onclick="' . $del . '" title="Hapus"><i class="ace-icon fa fa-trash-o bigger-120 orange"></i>';
                $edit = '<a href="#master_service/editBasicRate?id=' . $row->br_cbid . '" title="edit"><i class="ace-icon glyphicon glyphicon-pencil bigger-100"></i>';
                $responce->rows[$i]['id'] = $row->br_cbid;
                $responce->rows[$i]['cell'] = array(
                    number_format($row->br_rate), $edit);
                $i++;
            }
        echo json_encode($responce);
    }

    function loadStall() {
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $limit = isset($_POST['rows']) ? $_POST['rows'] : 10;
        $sidx = isset($_POST['sidx']) ? $_POST['sidx'] : 'stall_nomer';
        $sord = isset($_POST['sord']) ? $_POST['sord'] : '';
        $start = $limit * $page - $limit;
        $start = ($start < 0) ? 0 : $start;
        $where = whereLoad();
        $this->load->model('model_service');
        $count = $this->model_service->getTotalStall($where);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;
        $query = $this->model_service->getAllStall($start, $limit, $sidx, $sord, $where);
        $responce = new stdClass;
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
        $i = 0;
        if (count($query) > 0)
            foreach ($query as $row) {
                $del = "hapusStall('" . $row->stallid . "')";
                $hapus = '<a href="javascript:;" onclick="' . $del . '" title="Hapus"><i class="ace-icon fa fa-trash-o bigger-120 orange"></i>';
                $edit = '<a href="#master_service/editStall?id=' . $row->stallid . '" title="edit"><i class="ace-icon glyphicon glyphicon-pencil bigger-100"></i>';
                $responce->rows[$i]['id'] = $row->stallid;
                $responce->rows[$i]['cell'] = array(
                    $row->stall_nomer, $edit);
                $i++;
            }
        echo json_encode($responce);
    }

}

?>
