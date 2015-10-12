public function bank() {
        $this->hakAkses(1053);
        $this->load->view('dataTipeJurnal', $this->data);
    }
    
    public function addTipeJurnal() {
        $this->hakAkses(1053);
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
        $query = $this->model_finance->getAllTipeJurnal($start, $limit, $sidx, $sord, $where);
        $responce = new stdClass;
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
        $i = 0;
        if (count($query) > 0)
            foreach ($query as $row) {
                $del = "hapusData('" . $row->bankid . "', '" . $row->bank_name . "')";
                $hapus = '<a href="javascript:void(0);" onclick="' . $del . '" title="Hapus"><i class="ace-icon fa fa-trash-o bigger-120 orange"></i>';
                $edit = '<a href="#master_finance/editTipeJurnal?id=' . $row->bankid . '" title="Edit"><i class="ace-icon glyphicon glyphicon-pencil bigger-100"></i>';
                $responce->rows[$i]['id'] = $row->bankid;
                $responce->rows[$i]['cell'] = array(
                            $row->bankid,
                            $row->bank_name,
                            $row->tipe_desc,
                    $edit, $hapus);
                $i++;
            }
        echo json_encode($responce);
    }

    public function editTipeJurnal() {
        $this->hakAkses(1053);
        $id = $this->input->get('id');
        $data = $this->model_finance->getTipeJurnal($id);
        $this->data['data'] = $data;
        $this->load->view('editTipeJurnal', $this->data);
    }

    public function getTipeJurnal() {
        $data = array('bankid' => $this->input->post('bankid', TRUE));
        $result = $this->model_finance->getTipeJurnal($data);
        $responce = array();
        if (count($result) > 0)
            $responce = $result;
        echo json_encode($responce);
    }

    public function saveTipeJurnal() {
        $name = $this->input->post('bank_name', TRUE);
        $desc = $this->input->post('tipe_desc', TRUE);
        if (empty($name)|| empty($desc)) {
            $hasil = $this->error('INPUT TIDAK LENGKAP, SILAHKAN CEK KEMBALI');
        } else {
            $save = $this->model_finance->addTipeJurnal(array('bank_name' => strtoupper($name),
                'tipe_desc' => strtoupper($desc),
                'bank_cbid' => ses_cabang, 'bank_flag' => '1'));
            if ($save['status'] == TRUE) {
                $hasil = $this->sukses($save['msg']);
            } else {
                $hasil = $this->error($save['msg']);
            }
        }
        echo json_encode($hasil);
    }

    public function updateTipeJurnal() {
        $id = $this->input->post('bankid', TRUE);
        $name = $this->input->post('bank_name', TRUE);
        $desc = $this->input->post('tipe_desc', TRUE);
        if (empty($id) || empty($name) || empty($desc)) {
            $hasil = $this->error('INPUT TIDAK LENGKAP, SILAHKAN CEK KEMBALI');
        } else {
            $save = $this->model_finance->updateTipeJurnal(array('bank_name' => strtoupper($name),
                'tipe_desc' => strtoupper($desc),
                'bank_cbid' => ses_cabang, 'bank_flag' => '1'), $id);
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