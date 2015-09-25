/**
     * BISNIS
     * @author Rossi Erl 
     * @since 1.0 2015-09-19
     */
    
    public function bisnis_awal() {
        $this->hakAkses(1070);
        $this->load->view('dataBisnis', $this->data);
    }

    public function loadBisnis() {
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $limit = isset($_POST['rows']) ? $_POST['rows'] : 10;
        $sidx = isset($_POST['sidx']) ? $_POST['sidx'] : 'areaid';
        $sord = isset($_POST['sord']) ? $_POST['sord'] : '';
        $start = $limit * $page - $limit;
        $start = ($start < 0) ? 0 : $start;
        $where = whereLoad();
        $count = $this->model_prospect->getTotalBisnis($where);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;
        $query = $this->model_prospect->getDataBisnis($start, $limit, $sidx, $sord, $where);
        $responce = new stdClass;
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
        $i = 0;
        if (count($query) > 0)
            foreach ($query as $row) {
                $del = "hapusData('" . $row->bisnisid . "', '" . $row->bisnis_deskripsi . "')";
                $hapus = '<a href="javascript:void(0);" onclick="' . $del . '" title="Hapus"><i class="ace-icon fa fa-trash-o bigger-120 orange"></i>';
                $edit = '<a href="#master_prospect/editBisnis?id=' . $row->bisnisid . '" title="Edit"><i class="ace-icon glyphicon glyphicon-pencil bigger-100"></i>';
                $responce->rows[$i]['id'] = $row->bisnisid;
                $responce->rows[$i]['cell'] = array(
                    $row->bisnis_deskripsi,
                    $edit, $hapus);
                $i++;
            }
        echo json_encode($responce);
    }

    public function addBisnis() {
        $this->hakAkses(1070);
        $this->load->view('addBisnis', $this->data);
    }

    public function editBisnis() {
        $this->hakAkses(1070);
        $id = $this->input->get('id');
        $data = $this->model_prospect->getBisnis($id);
        $this->data['data'] = $data;
        $this->load->view('editBisnis', $this->data);
    }

    public function saveBisnis() {
        $desc = strtoupper($this->input->post('bisnis_nama', TRUE));
        $desc = strtoupper($this->input->post('bisnis_deskripsi', TRUE));
        if (empty($desc)) {
            $hasil = $this->error('INPUT TIDAK LENGKAP, SILAHKAN CEK KEMBALI');
        } else {
            $save = $this->model_prospect->addBisnis(array(
                'nama_deskripsi' => $nama, 
                'bisnis_deskripsi' => $desc, 
                'bisnis_cbid' => ses_cabang
                ));
            if ($save['status'] == TRUE) {
                $hasil = $this->sukses($save['msg']);
            } else {
                $hasil = $this->error($save['msg']);
            }
        }
        echo json_encode($hasil);
    }

    public function updateBisnis() {
        $bisnisid = $this->input->post('bisnisid', TRUE);
        $nama = strtoupper($this->input->post('bisnis_nama', TRUE));
        $desc = strtoupper($this->input->post('bisnis_deskripsi', TRUE));
        if (empty($desc)) {
            $hasil = $this->error('INPUT TIDAK LENGKAP, SILAHKAN CEK KEMBALI');
        } else {
            $save = $this->model_prospect->updateBisnis(array(
                'bisnis_nama' => strtoupper($nama),
                'bisnis_deskripsi' => strtoupper($desc),
                'bisnis_cbid' => ses_cabang), $bisnisid);
            if ($save['status'] == TRUE) {
                $hasil = $this->sukses($save['msg']);
            } else {
                $hasil = $this->error($save['msg']);
            }
        }
        echo json_encode($hasil);
    }

    public function deleteBisnis() {
        $id = $this->input->post('id', TRUE);
        if (empty($id)) {
            $hasil = $this->error('Hapus data gagal');
        } else {
            if ($this->model_prospect->deleteBisnis($id)) {
                $hasil = $this->sukses('Hapus data berhasil');
            } else {
                $hasil = $this->error('Hapus data gagal');
            }
        }
        echo json_encode($hasil);
    }

    public function getBisnis() {
        $data = $this->input->get('bisnisid', TRUE);
        $result = $this->model_prospect->getBisnis($data);
        $responce = array();
        if (count($result) > 0)
            $responce = $result;
        echo json_encode($responce);
    }