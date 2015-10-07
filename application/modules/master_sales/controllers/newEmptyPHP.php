/**
     * Master Aksesories
     * @author Rossi
     * * */
    public function masterAksesories() {
        $this->hakAkses(1098);
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
        $alamat = strtoupper($this->input->post('aks_descrip', TRUE));
        $kota = strtoupper($this->input->post('aks_kotaid', TRUE));
        if (empty($nama) || empty($alamat)|| empty($kota)) {
            $hasil = $this->error('INPUT TIDAK LENGKAP, SILAHKAN CEK KEMBALI');
        } else {
            $save = $this->model_sales->addAksesories(array(
                'aks_nama' => $nama,
                'aks_descrip' => $alamat,
                'aks_cbid' => ses_cabang,
                'aks_hpp' => $this->input->post('aks_hpp', TRUE),
                'aks_harga' => strtoupper($this->input->post('aks_harga',TRUE))
                ));
            if ($save['status'] == TRUE) {
                $hasil = $this->sukses($save['msg']);
            } else {
                $hasil = $this->error($save['msg']);
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
                    $row->aks_hpp,
                    $row->aks_harga,
                    $edit, $hapus);
                $i++;
            }
        echo json_encode($responce);
    }

    public function addAksesories() {
        $this->hakAkses(1092);
        $this->data['propinsi'] = $this->model_sales->cListPropinsi();
        $this->load->view('addAksesories', $this->data);
    }

    public function editAksesories() {
        $this->hakAkses(1092);
        $id = $this->input->get('id');
        $data = $this->model_sales->getAksesories($id);
        $this->data['propinsi'] = $this->model_sales->cListPropinsi();
        $this->data['data'] = $data;
        $this->load->view('editAksesories', $this->data);
    }

    public function updateAksesories() {
        $id = strtoupper($this->input->post('aksid', TRUE));
        $nama = strtoupper($this->input->post('aks_nama', TRUE));
        $nama = strtoupper($this->input->post('aks_nama', TRUE));
        $alamat = strtoupper($this->input->post('aks_descrip', TRUE));
        $kota = strtoupper($this->input->post('aks_kotaid', TRUE));
        if (empty($nama) || empty($alamat)|| empty($kota)|| empty($id)) {
            $hasil = $this->error('INPUT TIDAK LENGKAP, SILAHKAN CEK KEMBALI');
        } else {
            $save = $this->model_sales->updateAksesories(array(
                'aks_nama' => $nama,
                'aks_descrip' => $alamat,
                'aks_cbid' => ses_cabang,
                'aks_hpp' => $this->input->post('aks_hpp', TRUE),
                'aks_harga' => strtoupper($this->input->post('aks_harga',TRUE)),
                'aks_kotaid' => $kota ), $id);
            if ($save['status'] == TRUE) {
                $hasil = $this->sukses($save['msg']);
            } else {
                $hasil = $this->error($save['msg']);
            }
        }
        echo json_encode($hasil);
    }

    public function deleteAksesories() {
        $id = $this->input->post('id', TRUE);
        if (empty($id)) {
            $hasil = $this->error('Hapus data gagal');
        } else {
            if ($this->model_sales->deleteAksesories($id)) {
                $hasil = $this->sukses('Hapus data berhasil');
            } else {
                $hasil = $this->error('Hapus data gagal');
            }
        }
        echo json_encode($hasil);
    }