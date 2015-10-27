<?php

/**
 * Class Transaksi Sales
 * @author Rossi Erl
 * 2015-09-30
 */
class Transaksi_Sales extends Application {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('model_admin', 'model_sales', 'model_trsales'));
        $this->isLogin();
    }

    public function index() {
        echo " ";
    }

    /**
     * Bukti Penerimaan Kendaraan (BPK)
     * @author Rossi
     * * */
    public function masukKendaraan() {
        $this->hakAkses(1092);
        $this->load->view('dataBpk', $this->data);
    }

    public function getBpk() {
        $data = $this->input->get('bpkid', TRUE);
        $result = $this->model_sales->getBpk($data);
        $responce = array();
        if (count($result) > 0)
            $responce = $result;
        echo json_encode($responce);
    }

    /**
     * 
     */
    public function jsonDataStock() {
        echo json_encode($this->model_trsales->getDataStock(strtoupper($this->input->post('param')), ses_cabang));
    }

    public function jsonDataFpt() {
        $this->load->model('model_prospect');
        echo json_encode($this->model_prospect->getFptById(strtoupper($this->input->post('param'))));
    }

    public function jsonDataSpk() {
        echo json_encode($this->model_trsales->getDataSpk(strtoupper($this->input->post('param')), ses_cabang));
    }

    public function jsonDataBmk() {
        echo json_encode($this->model_trsales->getBpk(strtoupper($this->input->post('param'))));
    }
    public function jsonDataFaktur() {
        echo json_encode($this->model_trsales->getFakturPenjualanById(strtoupper($this->input->post('param'))));
    }

    public function jsonPoLeasing() {
        echo json_encode($this->model_trsales->getPoLeasingBySpkid(strtoupper($this->input->post('param')), ses_cabang));
    }

    /**
     * 
     */
    public function jsonDataNoKontrak() {
        echo json_encode($this->model_trsales->getDataNoKontrak(strtoupper($this->input->post('param')), ses_cabang));
    }

    public function saveBpk() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('bpk_nomer', '<b>Fx</b>', 'xss_clean');
        $this->form_validation->set_rules('bpk_mscid', '<b>Fx</b>', 'xss_clean');
        $this->form_validation->set_rules('bpk_norangka', '<b>Fx</b>', 'xss_clean');
        $this->form_validation->set_rules('bpk_nomesin', '<b>Fx</b>', 'xss_clean');
        $this->form_validation->set_rules('bpk_supid', '<b>Fx</b>', 'xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $tglPo = $this->input->post('bpk_tgldo');
            if (empty($tglPo)) {
                $tglPo = defaultTgl();
            }
            $tglDo = $this->input->post('bpk_tgldo');
            if (empty($tglDo)) {
                $tglDo = defaultTgl();
            }
            $hpp = numeric($this->input->post('bpk_hpp'));
            $ff = numeric($this->input->post('bpk_ff'));
            $ppnbm = numeric($this->input->post('bpk_ppnbm'));
            $pph22 = numeric($this->input->post('bpk_pph22'));
            $dp = numeric($this->input->post('bpk_deposit_promosi'));
            $data = array(
                'bpk_cbid' => ses_cabang,
                'bpk_nomer' => strtoupper($this->input->post('bpk_nomer')),
                'bpk_tgl' => date('Y-m-d'),
                'bpk_mscid' => $this->input->post('bpk_mscid'),
                'bpk_supid' => $this->input->post('bpk_supid'),
                'bpk_jenis' => $this->input->post('bpk_jenis'),
                'bpk_nopo' => strtoupper($this->input->post('bpk_nopo')),
                'bpk_nodo' => strtoupper($this->input->post('bpk_nodo')),
                'bpk_hpp' => $hpp,
                'bpk_ff' => $ff,
                'bpk_ppnbm' => $ppnbm,
                'bpk_pph22' => $pph22,
                'bpk_deposit_promosi' => $dp,
                'bpk_total' => $hpp + $ff + $ppnbm + $pph22 + $dp,
                'bpk_createon' => date('Y-m-d H:i:s'),
                'bpk_createby' => ses_username,
                'bpk_tgldo' => dateToIndo($tglDo),
                'bpk_tglpo' => dateToIndo($tglPo),
            );
            $hasil = $this->model_trsales->saveBpk($data);
            if ($hasil['result']) {
                $this->session->set_flashdata('msg', $this->sukses('Berhasil menambah bpk'));
            } else {
                $this->session->set_flashdata('msg', $this->error('Gagal menambah bpk'));
            }
        } else {
            $hasil['result'] = false;
            $hasil['msg'] = $this->error("Data Tidak Lengkap");
        }
        echo json_encode($hasil);
    }

    public function saveSpk() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('spk_no', '<b>Fx</b>', 'xss_clean');
        $this->form_validation->set_rules('spk_nokontrak', '<b>Fx</b>', 'xss_clean');
        $this->form_validation->set_rules('fpt_no', '<b>Fx</b>', 'xss_clean');
        $this->form_validation->set_rules('spk_fptid', '<b>Fx</b>', 'xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'spk_cbid' => ses_cabang,
                'spk_fptid' => $this->input->post("spk_fptid"),
                'spk_no' => $this->input->post("spk_no"),
                'spk_tgl' => date('Y-m-d'),
                'spk_nokontrak' => $this->input->post("spk_nokontrak"),
                'spk_pelid' => $this->input->post("spk_pelid"),
                'spk_salesman' => $this->input->post("spk_salesman"),
                'spk_uangmuka' => numeric($this->input->post("spk_uangmuka")),
                'spk_decrip' => strtoupper($this->input->post("spk_decrip")),
                'spk_createby' => ses_username,
                'spk_createon' => date('Y-m-d H:i:s'),
            );
            $id = $this->input->post('dtrans_aksid', TRUE);
            $harga = $this->input->post('dtrans_harga', TRUE);
            $fat = array();
            for ($i = 0; $i < count($id); $i++) {
                if ($id[$i] != 0) {
                    if ($harga[$i] == '') {
                        $harga[$i] = 0;
                    }
                    $fat[] = array(
                        'fat_aksid' => $id[$i],
                        'fat_harga' => numeric($harga[$i]),
                    );
                }
            }
            $hasil = $this->model_trsales->saveSpk($data, $fat);
            if ($hasil['result']) {
                $this->session->set_flashdata('msg', $this->sukses('Berhasil menambah spk'));
            } else {
                $this->session->set_flashdata('msg', $this->error('Gagal menambah spk'));
            }
        } else {
            $hasil['result'] = false;
            $hasil['msg'] = $this->error("Data Tidak Lengkap");
        }
        echo json_encode($hasil);
    }

    /**
     * 
     */
    public function saveFakturPenjualan() {
        $this->load->library('form_validation');
        log_message('error', 'MASUK SAVE FAKTUR ');
        $this->form_validation->set_rules('fkp_nofaktur', '<b>Fx</b>', 'xss_clean');
        $this->form_validation->set_rules('spk_no', '<b>Fx</b>', 'xss_clean');
        $this->form_validation->set_rules('fkp_spkid', '<b>Fx</b>', 'xss_clean');
        $this->form_validation->set_rules('fkp_norangka', '<b>Fx</b>', 'xss_clean');
        $this->form_validation->set_rules('fkp_mscid', '<b>Fx</b>', 'xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'fkp_cbid' => ses_cabang,
                'fkp_spkid' => $this->input->post("fkp_spkid"),
                'fkp_nofaktur' => $this->input->post("fkp_nofaktur"),
                'fkp_tgl' => date('Y-m-d'),
                'fkp_namabpkb' => $this->input->post("fkp_namabpkb"),
                'fkp_fpkid' => $this->input->post("fkp_fpkid"),
                'fkp_alamat_bpkb' => trim($this->input->post("fkp_alamat_bpkb")),
                'fkp_print' => 1,
                'fkp_createby' => ses_username,
                'fkp_mscid' => $this->input->post("fkp_mscid"),
                'fkp_createon' => date('Y-m-d H:i:s'),
            );

            $payment = array(
                'byr_um' => numeric($this->input->post("byr_um")),
                'byr_diskon' => numeric($this->input->post("byr_diskon")),
                'byr_cashback' => numeric($this->input->post("byr_cashback")),
                'byr_asuransi' => numeric($this->input->post("byr_asuransi")),
                'byr_aksesoris' => numeric($this->input->post("byr_aksesoris")),
                'byr_admin' => numeric($this->input->post("byr_admin")),
                'byr_lain' => numeric($this->input->post("byr_lain")),
                'byr_hargako' => numeric($this->input->post("byr_hargako")),
                'byr_karoseri' => numeric($this->input->post("byr_karoseri")),
                'byr_bbn' => numeric($this->input->post("byr_bbn")),
                'byr_tunai' => numeric($this->input->post("byr_tunai")),
                'byr_total' => numeric($this->input->post("byr_total")),
                'byr_sisa' => numeric($this->input->post("byr_sisa")),
            );

            $hasil = $this->model_trsales->saveFakturPenjualan($data, $payment);
            if ($hasil['result']) {
                $this->session->set_flashdata('msg', $this->sukses('Berhasil menambah faktur'));
            } else {
                $this->session->set_flashdata('msg', $this->error('Gagal menambah faktur'));
            }
        } else {
            $hasil['result'] = false;
            $hasil['msg'] = $this->error("Data Tidak Lengkap");
        }
        echo json_encode($hasil);
    }

    public function savePoLeasing() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('spk_no', '<b>Fx</b>', 'xss_clean');
        $this->form_validation->set_rules('fpk_spkid', '<b>Fx</b>', 'xss_clean');
        $this->form_validation->set_rules('fpk_hargaotr', '<b>Fx</b>', 'xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'fpk_cbid' => ses_cabang,
                'fpk_createby' => ses_username,
                'fpk_createon' => date('Y-m-d H:i:s'),
                'fpk_spkid' => $this->input->post("fpk_spkid"),
                'fpk_um' => numeric($this->input->post("fpk_um")),
                'fpk_hargaotr' => numeric($this->input->post("fpk_hargaotr")),
                'fpk_angsuran' => numeric($this->input->post("fpk_angsuran")),
                'fpk_admin' => numeric($this->input->post("fpk_admin")),
                'fpk_asuransi' => numeric($this->input->post("fpk_asuransi")),
                'fpk_bunga' => numeric($this->input->post("fpk_bunga")),
                'fpk_jangka' => numeric($this->input->post("fpk_jangka")),
                'fpk_premi' => numeric($this->input->post("fpk_premi")),
                'fpk_total' => numeric($this->input->post("fpk_total")),
                'fpk_tgl' => date('Y-m-d'),
                'fpk_leasid' => $this->input->post("fpk_leasid"),
                'fpk_jenis_asuransi' => $this->input->post("fpk_jenis_asuransi"),
            );
            $hasil = $this->model_trsales->savePoLeasing($data);
            if ($hasil['result']) {
                $this->session->set_flashdata('msg', $this->sukses('Berhasil menambah po leasing'));
            } else {
                $this->session->set_flashdata('msg', $this->error('Gagal menambah po leasing'));
            }
        } else {
            $hasil['result'] = false;
            $hasil['msg'] = $this->error("Data Tidak Lengkap");
        }
        echo json_encode($hasil);
    }

    public function saveReturBeli() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('rtb_bpkid', '<b>Fx</b>', 'xss_clean');
        $this->form_validation->set_rules('rtb_nomer', '<b>Fx</b>', 'xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'rtb_cbid' => ses_cabang,
                'rtb_createby' => ses_username,
                'rtb_createon' => date('Y-m-d H:i:s'),
                'rtb_tgl' => date('Y-m-d'),
                'rtb_nomer' => trim(strtoupper($this->input->post("rtb_nomer"))),
                'rtb_bpkid' => $this->input->post("rtb_bpkid"),
                'rtb_mscid' => $this->input->post("rtb_mscid"),
                'rtb_alasan_retur' => trim(strtoupper($this->input->post("rtb_alasan_retur"))),
            );
            $hasil = $this->model_trsales->saveReturBeli($data);
            if ($hasil['result']) {
                $this->session->set_flashdata('msg', $this->sukses('Berhasil retur beli'));
            }
        } else {
            $hasil['result'] = false;
            $hasil['msg'] = $this->error("Data Tidak Lengkap");
        }
        echo json_encode($hasil);
    }
    public function saveReturJual() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('no_faktur', '<b>Fx</b>', 'xss_clean');
        $this->form_validation->set_rules('rtj_nomer', '<b>Fx</b>', 'xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'rtj_cbid' => ses_cabang,
                'rtj_createby' => ses_username,
                'rtj_createon' => date('Y-m-d H:i:s'),
                'rtj_tgl' => date('Y-m-d'),
                'rtj_nomer' => trim(strtoupper($this->input->post("rtj_nomer"))),
                'rtj_fkpid' => $this->input->post("rtj_fkpid"),
                'rtj_mscid' => $this->input->post("rtj_mscid"),
                'rtj_alasan_retur' => trim(strtoupper($this->input->post("rtj_alasan_retur"))),
            );
            $hasil = $this->model_trsales->saveReturJual($data);
            if ($hasil['result']) {
                $this->session->set_flashdata('msg', $this->sukses('Berhasil retur jual'));
            }
        } else {
            $hasil['result'] = false;
            $hasil['msg'] = $this->error("Data Tidak Lengkap");
        }
        echo json_encode($hasil);
    }

    function saveCekDokumen() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('spk_nokontrak', '<b>Fx</b>', 'xss_clean');
        $this->form_validation->set_rules('spk_no', '<b>Fx</b>', 'xss_clean');
        $this->form_validation->set_rules('spkid', '<b>Fx</b>', 'xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $spkid = $this->input->post("spkid");
            $kategory = $this->input->post("kategory");
            $data = array(
                'spkid' => $spkid,
                'spk_ceklist_kategory' => $kategory
            );
            $id = $this->input->post('id', TRUE);
            $dokumen = $this->input->post('dokumen', TRUE);
            $list = array();
            for ($i = 0; $i < count($id); $i++) {
                $list[] = array(
                    'list_spkid' => $spkid,
                    'list_cekid' => $id[$i],
                    'list_nomer' => $dokumen[$i],
                );
            }
            $hasil = $this->model_trsales->saveCekDokumen($data, $list);
            if ($hasil['result']) {
                $this->session->set_flashdata('msg', $this->sukses('Berhasil menambah cek dokumen'));
            } else {
                $this->session->set_flashdata('msg', $this->error('Gagal menambah cek dokumen'));
            }
        } else {
            $hasil['result'] = false;
            $hasil['msg'] = $this->error("Data Tidak Lengkap");
        }
        echo json_encode($hasil);
    }

    function updateCekDokumen() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('spk_nokontrak', '<b>Fx</b>', 'xss_clean');
        $this->form_validation->set_rules('spk_no', '<b>Fx</b>', 'xss_clean');
        $this->form_validation->set_rules('spkid', '<b>Fx</b>', 'xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $spkid = $this->input->post("spkid");
            $id = $this->input->post('id', TRUE);
            $dokumen = $this->input->post('dokumen', TRUE);
            $list = array();
            for ($i = 0; $i < count($id); $i++) {
                $list[] = array(
                    'list_spkid' => $spkid,
                    'list_cekid' => $id[$i],
                    'list_nomer' => $dokumen[$i],
                );
            }
            $hasil = $this->model_trsales->updateCekDokumen($spkid, $list);
            if ($hasil['result']) {
                $this->session->set_flashdata('msg', $this->sukses('Berhasil mengubah cek dokumen'));
            } else {
                $this->session->set_flashdata('msg', $this->error('Gagal mengubah cek dokumen'));
            }
        } else {
            $hasil['result'] = false;
            $hasil['msg'] = $this->error("Data Tidak Lengkap");
        }
        echo json_encode($hasil);
    }

    /**
     * 
     */
    public function updatePoLeasing() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('spk_no', '<b>Fx</b>', 'xss_clean');
        $this->form_validation->set_rules('fpk_spkid', '<b>Fx</b>', 'xss_clean');
        $this->form_validation->set_rules('fpk_hargaotr', '<b>Fx</b>', 'xss_clean');
        $hasil = array();
        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'fpk_cbid' => ses_cabang,
                'fpk_createby' => ses_username,
                'fpk_createon' => date('Y-m-d H:i:s'),
                'fpkid' => $this->input->post("fpkid"),
                'fpk_spkid' => $this->input->post("fpk_spkid"),
                'fpk_um' => numeric($this->input->post("fpk_um")),
                'fpk_hargaotr' => numeric($this->input->post("fpk_hargaotr")),
                'fpk_angsuran' => numeric($this->input->post("fpk_angsuran")),
                'fpk_admin' => numeric($this->input->post("fpk_admin")),
                'fpk_asuransi' => numeric($this->input->post("fpk_asuransi")),
                'fpk_bunga' => numeric($this->input->post("fpk_bunga")),
                'fpk_jangka' => numeric($this->input->post("fpk_jangka")),
                'fpk_premi' => numeric($this->input->post("fpk_premi")),
                'fpk_total' => numeric($this->input->post("fpk_total")),
                'fpk_tgl' => date('Y-m-d'),
                'fpk_leasid' => $this->input->post("fpk_leasid"),
                'fpk_jenis_asuransi' => $this->input->post("fpk_jenis_asuransi"),
            );
            if ($this->model_trsales->updatePoLeasing($data)) {
                $hasil['result'] = true;
                $this->session->set_flashdata('msg', $this->sukses('Berhasil mengubah po leasing'));
            } else {
                $hasil['result'] = false;
                $hasil['msg'] = $this->error('Gagal mengubah po leasing');
                $this->session->set_flashdata('msg', $this->error('Gagal mmengubah po leasing'));
            }
        } else {
            $hasil['result'] = false;
            $hasil['msg'] = $this->error("Data Tidak Lengkap");
        }
        echo json_encode($hasil);
    }

    public function loadBpk() {
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $limit = isset($_POST['rows']) ? $_POST['rows'] : 10;
        $sidx = isset($_POST['sidx']) ? $_POST['sidx'] : 'merkid';
        $sord = isset($_POST['sord']) ? $_POST['sord'] : '';
        $start = $limit * $page - $limit;
        $start = ($start < 0) ? 0 : $start;
        $where = whereLoad();
        $count = $this->model_trsales->getTotalBpk($where);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;
        $query = $this->model_trsales->getAllBpk($start, $limit, $sidx, $sord, $where);
        $responce = new stdClass;
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
        $i = 0;
        if (count($query) > 0)
            foreach ($query as $row) {
                $del = "batalData('" . $row->bpkid . "', '" . $row->msc_norangka . "')";
                $hapus = '<a href="javascript:void(0);" onclick="' . $del . '" title="Hapus"><i class="ace-icon fa fa-cross bigger-120 red"></i>';
                $print = '<a href="javascript:void(0);" onclick="printData(\'' . $row->bpkid . '\')" title="Print"><i class="ace-icon fa fa-print bigger-120 green"></i>';
                $view = '<a href="#transaksi_sales/viewBpk?id=' . $row->bpkid . '" title="View"><i class="ace-icon glyphicon glyphicon-list bigger-100"></i>';
                $responce->rows[$i]['id'] = $row->bpkid;
                $responce->rows[$i]['cell'] = array(
                    $view, $print, $hapus,
                    $row->bpk_nomer,
                    $row->msc_norangka,
                    $row->msc_bodyseri,
                    dateToIndo($row->bpk_tgl),
                    $row->bpk_jenis,
                    $row->cty_deskripsi);
                $i++;
            }
        echo json_encode($responce);
    }

    /**
     * 
     */
    public function loadSpk() {
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $limit = isset($_POST['rows']) ? $_POST['rows'] : 10;
        $sidx = isset($_POST['sidx']) ? $_POST['sidx'] : 'spkid';
        $sord = isset($_POST['sord']) ? $_POST['sord'] : '';
        $start = $limit * $page - $limit;
        $start = ($start < 0) ? 0 : $start;
        $where = whereLoad();
        $count = $this->model_trsales->getTotalSpk($where);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;
        $query = $this->model_trsales->getAllSpk($start, $limit, $sidx, $sord, $where);
        $responce = new stdClass;
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
        $i = 0;
        if (count($query) > 0)
            foreach ($query as $row) {
                $hapus = '-';
                if ($row->spk_faktur_status == 0) {
                    $del = "batalData('" . $row->spkid . "')";
                    $hapus = '<a href="javascript:void(0);" onclick="' . $del . '" title="Hapus"><i class="ace-icon fa fa-trash bigger-120 red"></i>';
                }

                $print = '<a href="javascript:void(0);" onclick="print(\'' . $row->spkid . '\')" title="Print"><i class="ace-icon fa fa-print bigger-120 green"></i>';
                $view = '<a href="#transaksi_sales/viewSpk?id=' . $row->spkid . '" title="View"><i class="ace-icon glyphicon glyphicon-list bigger-100"></i>';
                $responce->rows[$i]['id'] = $row->spkid;
                $responce->rows[$i]['cell'] = array(
                    $row->spk_no,
                    date('d-m-Y', strtotime($row->spk_tgl)),
                    $row->spk_nokontrak,
                    $row->fpt_kode,
                    $row->pel_nama,
                    $view,
                    $print,
                    $hapus
                );
                $i++;
            }
        echo json_encode($responce);
    }

    /**
     * 
     */
    public function loadFaktur() {
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $limit = isset($_POST['rows']) ? $_POST['rows'] : 10;
        $sidx = isset($_POST['sidx']) ? $_POST['sidx'] : 'fkpid';
        $sord = isset($_POST['sord']) ? $_POST['sord'] : '';
        $start = $limit * $page - $limit;
        $start = ($start < 0) ? 0 : $start;
        $where = whereLoad();
        $count = $this->model_trsales->getTotalFaktur($where);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;
        $query = $this->model_trsales->getAllFaktur($start, $limit, $sidx, $sord, $where);
        $responce = new stdClass;
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
        $i = 0;
        if (count($query) > 0)
            foreach ($query as $row) {
                $print = '<a href="javascript:void(0);" onclick="printData(\'' . $row->fkpid . '\')" title="Print"><i class="ace-icon fa fa-print bigger-120 green"></i>';
//                $view = '<a href="#transaksi_sales/viewBpk?id=' . $row->fkpid . '" title="View"><i class="ace-icon glyphicon glyphicon-list bigger-100"></i>';
                $responce->rows[$i]['id'] = $row->fkpid;
                $responce->rows[$i]['cell'] = array(
                    $row->fkp_nofaktur,
                    date('d-m-Y', strtotime($row->fkp_tgl)),
                    $row->pel_nama,
                    $row->cty_deskripsi,
                    number_format($row->byr_total),
                    $print
                );
                $i++;
            }
        echo json_encode($responce);
    }

    public function loadCekDokumen() {
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $limit = isset($_POST['rows']) ? $_POST['rows'] : 10;
        $sidx = isset($_POST['sidx']) ? $_POST['sidx'] : 'spkid';
        $sord = isset($_POST['sord']) ? $_POST['sord'] : '';
        $status = isset($_POST['status']) ? $_POST['status'] : '0';
        $start = $limit * $page - $limit;
        $start = ($start < 0) ? 0 : $start;
        $where = whereLoad();
        if ($where != '') {
            $where .= " AND ";
        }
        if ($status != '') {
            $where .= " spk_approve_status = $status ";
        }
        $count = $this->model_trsales->getTotalCekDokumen($where);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }


        if ($page > $total_pages)
            $page = $total_pages;
        $query = $this->model_trsales->getAllCekDokumen($start, $limit, $sidx, $sord, $where);
        $responce = new stdClass;
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
        $i = 0;
        if (count($query) > 0)
            foreach ($query as $row) {
                $approve = '<a href="javascript:void(0);" onclick="approve(\'' . $row->spkid . '\')" title="Approve"><i class="ace-icon fa fa-check-square-o green bigger-120"></i>';
                $edit = '<a href="#transaksi_sales/editCekDokumen?id=' . $row->spkid . '" title="Edit"><i class="ace-icon glyphicon glyphicon-pencil bigger-120"></i>';
                $responce->rows[$i]['id'] = $row->spkid;
                $status = "BELUM DIUPPROVE";
                $batalApprove = '-';
                if ($row->spk_approve_status == 1) {
                    $status = "SUDAH DIUPPROVE";
                    $approve = '-';
                    $edit = '-';
                    $batalApprove = '<a href="javascript:void(0);" onclick="batalApprove(\'' . $row->spkid . '\')" title="Batal Approve"><i class="ace-icon fa fa-times red2 bigger-120"></i>';
                }
                $responce->rows[$i]['cell'] = array(
                    $row->spk_no,
                    $row->spk_nokontrak,
                    $status,
                    ($row->spk_approve_status == 0) ? '' : date('d-m-Y', strtotime($row->spk_approve_tgl)),
                    $row->spk_approve_by,
                    $edit,
                    $approve,
                    $batalApprove
                );
                $i++;
            }
        echo json_encode($responce);
    }

    public function loadFpk() {
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $limit = isset($_POST['rows']) ? $_POST['rows'] : 10;
        $sidx = isset($_POST['sidx']) ? $_POST['sidx'] : 'fpkid';
        $sord = isset($_POST['sord']) ? $_POST['sord'] : '';
        $start = $limit * $page - $limit;
        $start = ($start < 0) ? 0 : $start;
        $where = whereLoad();
        $count = $this->model_trsales->getTotalFpk($where);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;
        $query = $this->model_trsales->getAllFpk($start, $limit, $sidx, $sord, $where);
        $responce = new stdClass;
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
        $i = 0;
        if (count($query) > 0)
            foreach ($query as $row) {
                $del = "hapus('" . $row->fpkid . "')";
                $hapus = '<a href="javascript:void(0);" onclick="' . $del . '" title="Hapus"><i class="ace-icon fa fa-trash bigger-120 red"></i>';
                $print = '<a href="javascript:void(0);" onclick="print(\'' . $row->fpkid . '\')" title="Print"><i class="ace-icon fa fa-print bigger-120 green"></i>';
                $edit = '<a href="#transaksi_sales/editPoLeasing?id=' . $row->fpkid . '" title="View"><i class="ace-icon glyphicon glyphicon-pencil bigger-100"></i>';
                $responce->rows[$i]['id'] = $row->fpkid;
                $responce->rows[$i]['cell'] = array(
                    $row->fpk_no,
                    date('d-m-Y', strtotime($row->fpk_tgl)),
                    $row->spk_no,
                    $row->spk_nokontrak,
                    $row->leas_nama,
                    $edit,
                    $print,
                    $hapus
                );
                $i++;
            }
        echo json_encode($responce);
    }

    public function addBpk() {
        $this->hakAkses(1092);
        $this->data['merk'] = $this->model_sales->cListMerk();
        $this->data['segment'] = $this->model_sales->cListSegment();
        $this->load->view('addBpk', $this->data);
    }

    public function printBpk($bpkid) {
        $this->data['bpk'] = $this->model_trsales->getBpk($bpkid);
        $this->data['dealer'] = $this->model_admin->getCabangById(ses_cabang);
        $this->load->view('printBpk', $this->data);
    }

    public function printSpk($spkid) {
        $this->data['data'] = $this->model_trsales->getSpkById($spkid);
        $this->data['dealer'] = $this->model_admin->getCabangById(ses_cabang);
        $this->load->view('printSpk', $this->data);
    }

    public function printFpk($fpkid) {
        $this->data['fpk'] = $this->model_trsales->getFpkById($fpkid);
        $this->load->view('printFpk', $this->data);
    }

    function autoRangkaUnit() {
        $cbid = ses_cabang;
        $query = $this->model_trsales->autoRangkaUnit(strtoupper($this->input->post('param')), $this->input->post('ready_stock'), $cbid);
        if (!empty($query)) {
            $data['message'] = array();
            foreach ($query as $row) {
                $data['message'][] = array('value' => $row['msc_norangka']);
            }
        } else {
            $data['message'][] = array('value' => 'Data Tidak Ditemukan');
        }
        echo json_encode($data);
    }

    function autoNoKontrak() {
        $data = $this->model_trsales->autoNoKontrak(strtoupper($this->input->post('param')), ses_cabang);
        if ($data == null) {
            $data[] = array(
                'value' => 'Data Tidak Ditemukan',
                'desc' => '',
            );
        }
        echo json_encode($data);
    }

    function autoSpk() {
        $data = $this->model_trsales->autoSpk(strtoupper($this->input->post('param')), ses_cabang, $this->input->post('approve'));
        if ($data == null) {
            $data[] = array(
                'value' => 'Data Tidak Ditemukan',
                'desc' => '',
            );
        }
        echo json_encode($data);
    }

    function autoBmk() {
        $data = $this->model_trsales->autoBmk(strtoupper($this->input->post('param')), ses_cabang);
        echo json_encode($data);
    }

    function autoFakturJual() {
        echo json_encode($this->model_trsales->autoFakturJual(strtoupper($this->input->post('param')), ses_cabang));
    }

    function autoFpt() {
        $data = $this->model_trsales->autoFpt(strtoupper($this->input->post('param')), ses_cabang);
        if ($data == null) {
            $data[] = array(
                'value' => 'Data Tidak Ditemukan',
                'desc' => '',
            );
        }
        echo json_encode($data);
    }

    function jsonAccesories() {
        $this->load->model('model_prospect');
        echo json_encode($this->model_prospect->getDetailFat(($this->input->post('fptid'))));
    }

    public function editBpk() {
        $this->hakAkses(1092);
        $this->data['merk'] = $this->model_sales->cListMerk();
        $this->data['segment'] = $this->model_sales->cListSegment();
        $id = $this->input->get('id', TRUE);
        $this->data['data'] = $this->model_sales->getBpk($id);
        $this->load->view('editBpk', $this->data);
    }

    public function updateBpk() {
        $id = strtoupper($this->input->post('bpkid', TRUE));
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
            $save = $this->model_sales->updateBpk(array(
                'msc_norangka' => $norangka,
                'msc_nomesin' => $nomesin,
                'msc_jenis' => $jkend,
                'msc_ctyid' => $type,
                'msc_warnaid' => $warna,
                'msc_tahun' => $tahun,
                'msc_kondisi' => $kondisi,
                'msc_cbid' => ses_cabang,
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

    public function deleteBpk() {
        $id = $this->input->post('id', TRUE);
        if (empty($id)) {
            $hasil = $this->error('DATA GAGAL DIHAPUS');
        } else {
            if ($this->model_sales->deleteBpk($id)) {
                $hasil = $this->sukses('DATA BERHASIL DIHAPUS');
            } else {
                $hasil = $this->error('DATA GAGAL DIHAPUS');
            }
        }
        echo json_encode($hasil);
    }

    public function deleteFpk() {
        $id = $this->input->post('id', TRUE);
        if (empty($id)) {
            $hasil = $this->error('DATA GAGAL DIHAPUS');
        } else {
            if ($this->model_trsales->deleteFpk($id)) {
                $hasil = $this->sukses('DATA BERHASIL DIHAPUS');
            } else {
                $hasil = $this->error('DATA GAGAL DIHAPUS');
            }
        }
        echo json_encode($hasil);
    }

    public function saveApproveCekDokumen() {
        $id = $this->input->post('id', TRUE);
        $data = array(
            'spkid' => $id,
            'spk_approve_status' => 1,
            'spk_approve_by' => ses_username,
            'spk_approve_tgl' => date('Y-m-d H:i:s'),
        );
        $hasil = $this->model_trsales->saveApproveCekDokumen($data);
        if ($hasil) {
            $retur['result'] = true;
            $retur['msg'] = $this->sukses('DATA BERHASIL DIUPPROVE');
        } else {
            $retur['result'] = false;
            $retur['msg'] = $this->error('DATA GAGAL DIUPPROVE');
        }
        echo json_encode($retur);
    }

    public function saveBatalApproveCekDokumen() {
        $id = $this->input->post('id', TRUE);
        $data = array(
            'spkid' => $id,
            'spk_approve_status' => 0,
            'spk_approve_by' => ses_username,
            'spk_approve_tgl' => date('Y-m-d H:i:s'),
        );
        $hasil = $this->model_trsales->saveApproveCekDokumen($data);
        if ($hasil) {
            $retur['result'] = true;
            $retur['msg'] = $this->sukses('DATA BERHASIL DIBATALKAN');
        } else {
            $retur['result'] = false;
            $retur['msg'] = $this->error('DATA GAGAL DIBATALKAN');
        }
        echo json_encode($retur);
    }

    public function editHpp() {
        $this->hakAkses(1095);
        $this->load->view('editHpp', $this->data);
    }

    /**
     * 
     */
    public function spk() {
        $this->hakAkses(1096);
        $this->load->view('dataSpk', $this->data);
    }

    /**
     * 
     */
    public function returBeli() {
        $this->hakAkses(1099);
        $this->load->view('returBeli', $this->data);
    }

    public function returJual() {
        $this->hakAkses(1100);
        $this->load->view('returJual', $this->data);
    }

    /**
     * 
     */
    public function addReturBeli() {
        $this->hakAkses(1099);
        $this->load->view('addReturBeli', $this->data);
    }

    public function cekDokumen() {
        $this->hakAkses(94);
        $this->data['kategory'] = $this->model_trsales->getCeklistKategory();
        $this->load->view('cekDokumen', $this->data);
    }

    public function editCekDokumen() {
        $this->hakAkses(94);
        $id = $this->input->get('id', TRUE);
        $this->data['data'] = $this->model_trsales->getSpkById($id);
        $this->data['cek'] = $this->model_trsales->getCekdokumenBySpkid($id);
        $this->load->view('editCekDokumen', $this->data);
    }

    public function approveCekDokumen() {
        $this->hakAkses(95);
        $this->load->view('approveCekDokumen', $this->data);
    }

    public function dataCekDokumen() {
        $spkid = $this->input->post('spkid', TRUE);
        $this->data['data'] = $this->model_trsales->getCekdokumenDetail($this->input->post('kategory'), $spkid);
        $this->load->view('dataCekDokumen', $this->data);
    }

    public function poLeasing() {
        $this->hakAkses(1097);
        $this->load->view('poLeasing', $this->data);
    }

    public function fakturPenjualan() {
        $this->hakAkses(1098);
        $this->load->view('fakturPenjualan', $this->data);
    }

    public function addFakturPenjualan() {
        $this->hakAkses(1098);
        $this->load->view('addFakturPenjualan', $this->data);
    }

    public function addSpk() {
        $this->hakAkses(1096);
        $this->load->view('addSpk', $this->data);
    }

    public function addPoLeasing() {
        $this->hakAkses(1096);
        $this->data['leasing'] = $this->model_sales->cListLeasing();
        $this->load->view('addPoLeasing', $this->data);
    }

    public function editPoLeasing() {
        $this->hakAkses(1096);
        $id = $this->input->get('id', TRUE);
        $this->data['data'] = $this->model_trsales->getFpkById($id);
        $this->data['leasing'] = $this->model_sales->cListLeasing();
        $this->load->view('editPoLeasing', $this->data);
    }

}

?>
