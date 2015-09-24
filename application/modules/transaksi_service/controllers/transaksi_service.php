<?php

/**
 * Class Admin_Controller
 * @author Rossi
 * 2013-11-11
 */
class Transaksi_Service extends Application {

    /**
     * The new Admin_controller
     */
    public function __construct() {
        parent::__construct();
        $this->load->model(array('model_trservice'));
    }

    public function index() {
//        $this->addProspect();
    }

    function jsonWoBelumInvoiceAuto() {
        $wo = $this->input->post('param');
        $query = $this->model_trservice->getWoBelumInvoiceAutoComplete(strtoupper($wo));
        if (!empty($query)) {
            $data['message'] = array();
            foreach ($query as $row) {
                $data['message'][] = array('value' => $row['wo_nomer'], 'desc' => $row['msc_nopol'], 'type' => $row['wo_type']);
            }
        } else {
            $data['message'][] = array('value' => 'Wo Tidak Ditemukan', 'desc' => "");
        }
        echo json_encode($data);
    }

    function jsonWo() {
        $woNomer = strtoupper($this->input->post('param'));
        $data = $this->model_trservice->getWo($woNomer);
        if (count($data) > 0) {
            $data['response'] = true;
        } else {
            $data['response'] = false;
        }
        echo json_encode($data);
    }

    function getJasaWoByWoNomer() {
        $woNomer = strtoupper($this->input->post('wo'));
        $data = $this->model_trservice->getJasaWoByWoNomer($woNomer);
        echo json_encode($data);
    }

    /**
     * 
     */
    function getTotalSupply() {
        $woNomer = strtoupper($this->input->post('wo'));
        echo json_encode($this->model_trservice->getTotalSupply($woNomer));
    }

    function jsonDataKendaraan() {
        $nopol = strtoupper(str_replace(" ", "", $this->input->post('param')));
        $retur = array();
        $data = $this->model_trservice->getDataKendaraan($nopol);
        $retur['response'] = false;
        if (count($data) > 0) {
            $retur['response'] = true;
            $retur['data'] = $data;
        }
        echo json_encode($retur);
    }

    function jsonFlateRate() {
        $kode = strtoupper(str_replace(" ", "", $this->input->post('param')));
        $retur = array();
        $data = $this->model_trservice->getDataFlateRate($kode);
        $retur['response'] = false;
        if (count($data) > 0) {
            $retur['response'] = true;
            $retur['data'] = $data;
        }
        echo json_encode($retur);
    }

    function jsonNopol() {
        $data['response'] = 'false';
        $nopol = strtoupper(str_replace(" ", "", $this->input->post('param')));
        $query = $this->model_trservice->getNopol($nopol);
        if (count($query) > 0) {
            $data['response'] = 'true';
            $data['message'] = array();
            foreach ($query as $row) {
                $nopol = $row['msc_nopol'];
                $data['message'][] = array(
                    'value' => $nopol,
                    'mscid' => $row['mscid'],
                    'desc' => $row['msc_norangka']
                );
            }
        } else {
            $data['message'][] = array('value' => 'Data Tidak Ditemukan', 'label' => "Data Tidak Ada", 'desc' => '');
        }
        echo json_encode($data);
    }

    function getFlateRateAuto() {
        $data['response'] = 'false';
        $param = strtoupper(str_replace(" ", "", $this->input->post('term')));
        $query = $this->model_trservice->getFlateRateAuto($param, $this->input->post('type'));
        if (count($query) > 0) {
            $data['response'] = 'true';
            $data['message'] = array();
            foreach ($query as $row) {
                $data['message'][] = array(
                    'value' => $row['flat_kode'],
                    'flatid' => $row['flatid'],
                    'desc' => $row['flat_deskripsi']
                );
            }
        } else {
            $data['message'][] = array('value' => 'Data Tidak Ditemukan', 'label' => "Data Tidak Ada", 'desc' => '');
        }
        echo json_encode($data);
    }

    function saveWo() {
        $return = false;
        $this->form_validation->set_rules('nopol', '<b>Fx</b>', 'required|callback_validtelp|xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'wo_tgl' => date('Y-m-d'),
                'wo_createon' => date('Y-m-d H:i:s'),
                'wo_createby' => ses_username,
                'wo_jenis' => $this->input->post('wo_jenis'),
                'wo_mscid' => strtoupper($this->input->post('wo_mscid')),
                'wo_numerator' => $this->input->post('wo_numerator'),
                'wo_pelid' => $this->input->post('wo_pelid'),
                'wo_selesai' => $this->input->post('wo_selesai'),
                'wo_km' => $this->input->post('wo_km'),
                'wo_type' => $this->input->post('wo_type'),
                'wo_pembawa' => $this->input->post('wo_pembawa'),
                'wo_inextern' => $this->input->post('wo_inextern'),
                'wo_stallid' => $this->input->post('wo_stallid'),
                'wo_tunggu' => $this->input->post('wo_tunggu'),
                'wo_sa' => ses_krid,
                'wo_cbid' => ses_cabang,
            );
            $jasa = array();
            $sp = array();
            $so = array();
            $woj_keluhan = $this->input->post('woj_keluhan');
            $woj_flatid = $this->input->post('woj_flatid');
            $woj_namajasa = $this->input->post('woj_namajasa');
            $woj_rate = $this->input->post('woj_rate');
            $woj_subtotal = $this->input->post('woj_subtotal');
            // get array spare part from table 
            if (count($woj_namajasa) > 0) {
                for ($i = 0; $i < count($woj_namajasa); $i++) {
                    if (!empty($woj_keluhan[$i]) || !empty($woj_namajasa[$i])) {
                        $jasa[] = array(
                            'woj_keluhan' => strtoupper($woj_keluhan[$i]),
                            'woj_flatid' => $woj_flatid[$i],
                            'woj_namajasa' => strtoupper($woj_namajasa[$i]),
                            'woj_rate' => numeric($woj_rate[$i]),
                            'woj_subtotal' => numeric($woj_subtotal[$i]),
                        );
                    }
                }
            }
            $wop_inveid = $this->input->post('wop_inveid');
            $wop_qty = $this->input->post('wop_qty');
            $wop_harga = $this->input->post('wop_harga');
            $wop_subtotal = $this->input->post('wop_subtotal');
            // get array spare part from table 
            if (count($wop_inveid) > 0) {
                for ($i = 0; $i < count($wop_inveid); $i++) {
                    if (!empty($wop_inveid[$i])) {
                        $sp[] = array(
                            'wop_inveid' => $wop_inveid[$i],
                            'wop_qty' => $wop_qty[$i],
                            'wop_harga' => numeric($wop_harga[$i]),
                            'wop_subtotal' => numeric($wop_subtotal[$i]),
                        );
                    }
                }
            }
            $wos_nama = $this->input->post('wos_nama');
            $wos_harga = $this->input->post('wos_harga');
            // get array spare part from table 
            if (count($wos_nama) > 0) {
                for ($i = 0; $i < count($wos_nama); $i++) {
                    if (!empty($wos_nama[$i])) {
                        $so[] = array(
                            'wos_nama' => strtoupper($wos_nama[$i]),
                            'wos_harga' => numeric($wos_harga[$i]),
                        );
                    }
                }
            }
            $return = $this->model_trservice->saveWo($data, $jasa, $sp, $so);
        }
        echo json_encode($return);
    }

    function saveFakturService() {
        $return = false;
        $this->form_validation->set_rules('msc_nopol', '<b>Fx</b>', 'required|callback_validtelp|xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $woid = $this->input->post('inv_woid');
            $data = array(
                'inv_tgl' => date('Y-m-d'),
                'inv_createon' => date('Y-m-d H:i:s'),
                'inv_createby' => ses_username,
                'inv_woid' => $woid,
                'inv_catatan' => $this->input->post('inv_catatan'),
                'inv_fchecker' => $this->input->post('inv_fchecker'),
                'inv_kasir' => $this->input->post('inv_kasir'),
                'inv_inextern' => $this->input->post('inv_inextern'),
                'inv_tampil_ppn' => $this->input->post('inv_tampil_ppn'),
                'inv_spart' => numeric($this->input->post('total_sp')),
                'inv_oli' => numeric($this->input->post('total_ol')),
                'inv_sm' => numeric($this->input->post('total_sm')),
                'inv_so' => numeric($this->input->post('total_so')),
                'inv_lc' => numeric($this->input->post('total_lc')),
                'inv_total' => numeric($this->input->post('grand_total')),
                'inv_spart_hpp' => numeric($this->input->post('total_sp_hpp')),
                'inv_oli_hpp' => numeric($this->input->post('total_ol_hpp')),
                'inv_sm_hpp' => numeric($this->input->post('total_sm_hpp')),
                'inv_so_hpp' => numeric($this->input->post('total_so_hpp')),
                'inv_cbid' => ses_cabang,
            );

            $wo = array(
                'woid' => $woid,
                'wo_inv_status' => 1,
                'wo_km' => $this->input->post('wo_km')
            );

            $jasa = array();
            $dinv_flatid = $this->input->post('dinv_flatid');
            $dinv_kode = $this->input->post('dinv_kode');
            $dinv_harga = $this->input->post('flat_lc');
            $dinv_diskon = $this->input->post('dinv_diskon');
            $dinv_subtotal = $this->input->post('dinv_subtotal');
            // get array spare part from table 
            if (count($dinv_flatid) > 0) {
                for ($i = 0; $i < count($dinv_flatid); $i++) {
                    if (numeric($dinv_harga[$i]) > 0) {
                        $jasa[] = array(
                            'dinv_flatid' => strtoupper($dinv_flatid[$i]),
                            'dinv_harga' => numeric($dinv_harga[$i]),
                            'dinv_diskon' => numeric($dinv_diskon[$i]),
                            'dinv_subtotal' => numeric($dinv_subtotal[$i]),
                        );
                    }
                }
            }
            $return = $this->model_trservice->saveFakturService($data, $wo, $jasa);
        }
        echo json_encode($return);
    }

    public function workOrder() {
        $this->hakAkses(35);
        $this->data['jenis'] = $this->model_trservice->getWoJenis();
        $this->load->view('workOrder', $this->data);
    }

    /**
     * 
     */
    public function fakturService() {
        $this->hakAkses(38);
        $this->data['checker'] = $this->model_admin->getKaryawanByJabatan(JAB_SVC_FINAL_CHECKER);
        $this->data['kasir'] = $this->model_admin->getKaryawanByJabatan(JAB_SVC_KASIR_SERVICE);
        $this->load->view('fakturService', $this->data);
    }

    public function clockOnMekanik() {
        $this->hakAkses(36);
        $this->load->view('clockOnMekanik', $this->data);
    }

    public function lampiranFaktur() {
        $this->hakAkses(37);
        $this->load->view('lampiranFaktur', $this->data);
    }

    public function serviceOrder() {
        $this->hakAkses(57);
        $this->data['stall'] = $this->model_trservice->getStall();
        $this->data['jenis'] = $this->input->GET('jenis');
        $this->data['type'] = $this->input->GET('type');
        $this->load->view('serviceOrder', $this->data);
    }

    /**
     * Function ini digunakan untuk mencetak wo
     * @param type $kode
     */
    function printWo($kode) {
        $this->data['wo'] = $this->model_trservice->getWorkOrder($kode);
        $this->data['jasa'] = $this->model_trservice->getJasaWorkOrder($kode);
        $this->data['sp'] = $this->model_trservice->getSparepartWorkOrder($kode);
        $this->data['so'] = $this->model_trservice->getSoWorkOrder($kode);
        $this->load->view('printWo', $this->data);
    }

    /**
     * Function ini digunakan untuk mencetak lampiran faktur service
     * @param type $kode
     */
    function printLampiranFakturService($woNomer) {
        $this->load->model('model_trspart');
        $this->data['data'] = $this->model_trservice->getWo(strtoupper($woNomer));
        $this->data['part'] = $this->model_trspart->getSupplySlipDetailByWo(strtoupper($woNomer));
        $this->load->view('printLampiranFakturService', $this->data);
    }

    function loadDataWo() {
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $limit = isset($_POST['rows']) ? $_POST['rows'] : 10;
        $sidx = isset($_POST['sidx']) ? $_POST['sidx'] : 'wo_nomer';
        $sord = isset($_POST['sord']) ? $_POST['sord'] : '';
        $start = $limit * $page - $limit;
        $start = ($start < 0) ? 0 : $start;
        $where = whereLoad();
        $count = $this->model_trservice->getTotalWo($where);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;
        $query = $this->model_trservice->getAllWo($start, $limit, $sidx, $sord, $where);
        $mekanik = $this->model_trservice->getDataMekanik();
        $mek = "<option value=''>Pilih Mekanik</option>";
        if (count($mekanik) > 0) {
            foreach ($mekanik as $list) {
                $mek .= "<option value='" . $list['krid'] . "' >" . $list['kr_nama'] . "</option>";
            }
        }
        $responce = new stdClass;
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
        $i = 0;
        if (count($query) > 0)
            foreach ($query as $row) {
                $mknk = '';
                $pending = '-';
                $clock = "<label><input class='ace ace-switch btn-rotate' id='cek$i' onclick='clocking(\"" . $i . "\",\"" . $row['cloid'] . "\")' type='checkbox' name='cek[]'><span class='lbl'></span></label>";

                if ($row['clo_status'] == '0') {
                    $status = 'BELUM CLOCK ON';
                    $mknk = "<select id='krid$i' name='krid' class='ace col-xs-10 col-sm-10' style='width: 100%'>" . $mek . "</select>";
                } else if ($row['clo_status'] == '1') {
                    $status = 'PROSES PENGERJAAN';
                    $clock = "<label><input checked class='ace ace-switch btn-rotate' id='cek$i' onclick='clocking(\"" . $i . "\",\"" . $row['cloid'] . "\")' type='checkbox' name='cek[]'><span class='lbl'></span></label>";
                    $pending = "<a href='javascript:;' title='Pending' onclick='pending(\"" . $i . "\",\"" . $row['cloid'] . "\")'><i class='green ace-icon glyphicon glyphicon-off'></i></a>";
                    $mknk = $row['kr_nama'];
                } else if ($row['clo_status'] == '2') {
                    $status = 'PENDING';
                    $mknk = "<select id='krid$i' name='krid' class='ace col-xs-10 col-sm-10' style='width: 100%'>" . $mek . "</select>";
                } else {
                    $status = 'SELESAI';
                    $clock = 'PROSES NOTA';
                    $mknk = $row['kr_nama'];
                }
                $responce->rows[$i]['id'] = $row['woid'];
                $responce->rows[$i]['cell'] = array(
                    $row['wo_nomer'], $row['msc_nopol'], $row['pel_nama'], $status, $mknk, $clock, $pending);
                $i++;
            }
        echo json_encode($responce);
    }

    function clockingMekanik() {
        $cloid = $this->input->post('clockid');
        $status = $this->input->post('status');
        $krid = $this->input->post('krid');
        $simpan = $this->model_trservice->clockingMekanik($cloid, $status, $krid);
        if ($simpan) {
            $hasil['msg'] = $this->sukses("Berhasil Clock On / Off Mekanik");
            $hasil['response'] = true;
        } else {
            $hasil['msg'] = $this->error("Gagal Clock On / Off Mekanik");
            $hasil['response'] = false;
        }
        echo json_encode($hasil);
    }

    function pendingMekanik() {
        $cloid = $this->input->post('clockid');
        $simpan = $this->model_trservice->pendingMekanik($cloid);
        if ($simpan) {
            $hasil['msg'] = $this->sukses("Berhasil Pending Mekanik");
            $hasil['response'] = true;
        } else {
            $hasil['msg'] = $this->error("Gagal Pending Mekanik");
            $hasil['response'] = false;
        }
        echo json_encode($hasil);
    }

}

?>
