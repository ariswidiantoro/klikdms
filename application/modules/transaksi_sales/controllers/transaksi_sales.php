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
    public function terimaKendaraan() {
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
        $query = $this->model_trsales->getDataBpk($start, $limit, $sidx, $sord, $where);
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

    public function addBpk() {
        $this->hakAkses(1092);
        $this->data['merk'] = $this->model_sales->cListMerk();
        $this->data['segment'] = $this->model_sales->cListSegment();
        $this->load->view('addBpk', $this->data);
    }

    public function printBpk($bpkid) {
        $this->data['bpk'] = $this->model_trsales->getBpk($bpkid);
        $this->data['dealer'] = $this->model_admin->getCabangById(ses_cabang);
//        $this->data['bm'] = $this->Model_transaksi->get_bm();
//        $this->data['adminstock'] = $this->Model_transaksi->ambil_nama(ses_nik);
        $this->load->view('printBpk', $this->data);
    }

    function autoRangkaUnit() {
        $cbid = ses_cabang;
        $query = $this->model_trsales->autoRangkaUnit(strtoupper($this->input->post('param')), $cbid);
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

    public function editHpp() {
        $this->hakAkses(1095);
        $this->load->view('editHpp', $this->data);
    }

    public function spk() {
        $this->hakAkses(1096);
        $this->load->view('dataSpk', $this->data);
    }

    public function addSpk() {
        $this->hakAkses(1096);
        $this->load->view('addSpk', $this->data);
    }

}

?>
