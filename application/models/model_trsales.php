<?php

/**
 * The MODEL SALES
 * @author Rossi Erl
 * 2013-12-13
 */
class Model_Trsales extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /** MASTER STOCK UNIT 
     * @author Rossi Erl
     * 2015-09-18
     */
    public function getTotalBpk($where) {
        $wh = "WHERE bpk_cbid = '" . ses_cabang . "'";
        if ($where != NULL)
            $wh .= " AND " . $where;
        $sql = $this->db->query("SELECT COUNT(bpkid) AS total FROM pen_bpk ");
        return $sql->row()->total;
    }

    /**
     * 
     * @param type $where
     * @return type
     */
    public function getTotalSpk($where) {
        $wh = "WHERE spk_cbid = '" . ses_cabang . "'";
        if ($where != NULL)
            $wh .= " AND " . $where;
        $sql = $this->db->query("SELECT COUNT(spkid) AS total FROM pen_spk $wh");
        return $sql->row()->total;
    }

    /**
     * 
     * @param type $where
     * @return type
     */
    public function getTotalFaktur($where) {
        $wh = " WHERE fkp_cbid = '" . ses_cabang . "'";
        if ($where != NULL)
            $wh .= " AND " . $where;
        $sql = $this->db->query("SELECT COUNT(fkpid) AS total FROM pen_faktur"
                . " LEFT JOIN pen_faktur_payment ON byr_fkpid = fkpid"
                . " LEFT JOIN pen_spk ON spkid = fkp_spkid"
                . " LEFT JOIN ms_pelanggan ON spk_pelid = pelid"
                . " LEFT JOIN ms_car ON fkp_mscid = mscid"
                . " LEFT JOIN ms_car_type ON msc_ctyid = ctyid"
                . " $wh");
        return $sql->row()->total;
    }

    /**
     * 
     * @param type $where
     * @return type
     */
    public function getTotalCekDokumen($where) {
        $wh = "WHERE spk_cbid = '" . ses_cabang . "' AND spk_ceklist_kategory != 0";
        if ($where != NULL)
            $wh .= " AND " . $where;
        $sql = $this->db->query("SELECT COUNT(spkid) AS total FROM pen_spk $wh");
        log_message('error', 'FAFAFA' . $this->db->last_query());
        return $sql->row()->total;
    }

    /**
     * 
     * @param type $where
     * @return type
     */
    public function getTotalFpk($where) {
        $wh = "WHERE fpk_cbid = '" . ses_cabang . "' AND fpk_status = 0";
        if ($where != NULL)
            $wh .= " AND " . $where;
        $sql = $this->db->query("SELECT COUNT(fpkid) AS total FROM pen_fpk LEFT JOIN"
                . " pen_spk ON fpk_spkid = spkid LEFT JOIN ms_leasing ON leasid = fpk_leasid $wh");
        return $sql->row()->total;
    }

    /**
     * 
     * @param type $fpkid
     * @return type
     */
    function getFpkById($fpkid) {
        $sql = $this->db->query("SELECT * FROM pen_fpk LEFT JOIN"
                . " pen_spk ON fpk_spkid = spkid LEFT JOIN ms_leasing ON leasid = fpk_leasid WHERE fpkid = '$fpkid'");
        return $sql->row_array();
    }

    /**
     * 
     * @param type $fkpid
     * @return type
     */
    function getFakturPenjualanById($fkpid) {
        $sql = $this->db->query("SELECT fkpid,pel_nama,mscid,merk_deskripsi,model_deskripsi,
            cty_deskripsi,msc_norangka,msc_nomesin FROM pen_faktur 
            LEFT JOIN ms_car ON mscid = fkp_mscid
            LEFT JOIN pen_spk ON fkp_spkid = spkid
            LEFT JOIN ms_pelanggan ON pelid = spk_pelid
            LEFT JOIN ms_car_type ON ctyid = msc_ctyid
            LEFT JOIN ms_car_model ON modelid = cty_modelid
            LEFT JOIN ms_car_merk ON merkid = model_merkid            
            WHERE fkpid = '$fkpid'");
        return $sql->row_array();
    }

    /**
     * 
     * @param type $spkid
     * @return type
     */
    function getSpkById($spkid) {
        $sql = $this->db->query("SELECT * FROM pen_spk LEFT JOIN ms_ceklist_kategory "
                . " ON ckid = spk_ceklist_kategory LEFT JOIN pen_fpt ON fptid = spk_fptid "
                . " LEFT JOIN ms_karyawan ON krid = spk_salesman WHERE spkid = '$spkid'");
        return $sql->row_array();
    }

    /**
     * 
     * @param type $norangka
     * @param type $cbid
     * @return null
     */
    public function autoRangkaUnit($norangka, $readyStock = null, $cbid) {
        $wh = '';
        if ($readyStock != null) {
            $wh = " AND msc_ready_stock = 1";
        }
        $sql = $this->db->query("SELECT msc_norangka AS value FROM ms_car WHERE msc_cbid = '$cbid'"
                . " AND msc_isstock = 1 $wh AND msc_norangka LIKE '$norangka%'  ORDER BY msc_norangka LIMIT 20");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        } else {
            return array(
                'value' => 'Data Tidak Ditemukan',
            );
        }
        return null;
    }

    public function autoFpt($kodeFpt, $cbid) {
        $sql = $this->db->query("SELECT fptid, fpt_kode AS value, pros_nama AS desc FROM pen_fpt LEFT JOIN pros_data ON prosid = fpt_prosid"
                . " WHERE fpt_cbid = '$cbid'"
                . " AND fpt_status = 0 AND fpt_kode LIKE '$kodeFpt%' ORDER BY fpt_kode LIMIT 20");
        if ($sql->num_rows() > 0) {
            return $sql->result();
        }
        return null;
    }

    public function autoNoKontrak($nokontrak, $cbid) {
        $sql = $this->db->query("SELECT kon_nomer AS value FROM ms_kontrak WHERE kon_cbid = '$cbid' "
                . "AND kon_use = 0 AND kon_nomer LIKE '$nokontrak%' ORDER BY kon_nomer LIMIT 20");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }

    public function autoSpk($noSpk, $cbid, $approve = null) {
        $wh = '';
        if ($approve != null) {
            $wh = " AND spk_approve_status = $approve";
        }
        $sql = $this->db->query("SELECT spk_no AS value, spkid, spk_nokontrak FROM pen_spk WHERE spk_cbid = '$cbid' "
                . " AND spk_faktur_status = 0 AND spk_no LIKE '$noSpk%' $wh ORDER BY spk_no LIMIT 20");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }

    public function autoBmk($noBmk, $cbid) {
        $sql = $this->db->query("SELECT bpk_nomer AS value,bpkid FROM pen_bpk WHERE bpk_cbid = '$cbid' "
                . " AND bpk_nomer LIKE '$noBmk%' ORDER BY bpk_nomer LIMIT 20");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        } else {
            return array(
                'value' => 'Data Tidak Ditemukan',
            );
        }
        return null;
    }

    public function autoFakturJual($noFaktur, $cbid) {
        $sql = $this->db->query("SELECT fkp_nofaktur AS value,fkpid FROM pen_faktur WHERE fkp_cbid = '$cbid' "
                . " AND fkp_nofaktur LIKE '$noFaktur%' ORDER BY fkp_nofaktur LIMIT 20");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        } else {
            return array(
                'value' => 'Data Tidak Ditemukan',
            );
        }
        return null;
    }

    /**
     * 
     * @param type $norangka
     * @param type $cbid
     * @return null
     */
    public function getDataStock($norangka, $cbid) {
        $sql = $this->db->query("SELECT msc_hpp,mscid,warna_deskripsi,msc_nomesin,merk_deskripsi,cty_deskripsi,msc_kondisi,msc_vinlot,msc_bodyseri FROM ms_car LEFT JOIN ms_car_type ON ctyid = msc_ctyid"
                . " LEFT JOIN ms_car_model ON modelid = cty_modelid "
                . " LEFT JOIN ms_car_merk ON model_merkid = merkid"
                . " LEFT JOIN ms_warna ON warnaid = msc_warnaid"
                . " WHERE msc_cbid = '$cbid' AND msc_norangka = '$norangka'");
        if ($sql->num_rows() > 0) {
            return $sql->row_array();
        }
        return null;
    }

    public function getDataNoKontrak($noKontrak, $cbid) {
        $sql = $this->db->query("SELECT * FROM ms_kontrak LEFT JOIN ms_pelanggan ON pelid = kon_pelid"
                . " WHERE kon_cbid = '$cbid' AND kon_nomer = '$noKontrak'");
        if ($sql->num_rows() > 0) {
            return $sql->row_array();
        }
        return null;
    }

    public function getDataSpk($spkid, $cbid) {
        $sql = $this->db->query("SELECT * FROM pen_spk "
                . " LEFT JOIN pen_fpt ON fptid = spk_fptid LEFT JOIN ms_pelanggan ON pelid = spk_pelid "
                . " LEFT JOIN ms_karyawan ON spk_salesman = krid WHERE spkid = '$spkid' AND spk_cbid = '$cbid'");
        if ($sql->num_rows() > 0) {
            return $sql->row_array();
        }
        return null;
    }

    /**
     * 
     * @param type $spkid
     * @param type $cbid
     * @return null
     */
    public function getPoLeasingBySpkid($spkid, $cbid) {
        $sql = $this->db->query("SELECT * FROM pen_fpk WHERE fpk_spkid = '$spkid' AND fpk_cbid = '$cbid' AND fpk_status = 0");
        if ($sql->num_rows() > 0) {
            return $sql->row_array();
        }
        return null;
    }

    /**
     * 
     * @param type $start
     * @param type $limit
     * @param type $sidx
     * @param type $sord
     * @param type $where
     * @return null
     */
    public function getAllBpk($start, $limit, $sidx, $sord, $where) {
        $this->db->select('bpkid,bpk_jenis,msc_norangka,bpk_nomer,msc_bodyseri,bpk_tgl,cty_deskripsi');
        $this->db->limit($limit);
        if ($where != NULL)
            $this->db->where($where, NULL, FALSE);
        $this->db->from('pen_bpk');
        $this->db->join('ms_car', 'mscid = bpk_mscid', 'left');
        $this->db->join('ms_car_type', 'ctyid = msc_ctyid', 'left');
        $this->db->where('bpk_cbid', ses_cabang);
        $this->db->order_by($sidx, $sord);
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return null;
    }

    public function getAllSpk($start, $limit, $sidx, $sord, $where) {
        $this->db->select('spkid,spk_no, spk_tgl, spk_nokontrak, fpt_kode,pel_nama,spk_faktur_status');
        $this->db->limit($limit);
        if ($where != NULL)
            $this->db->where($where, NULL, FALSE);
        $this->db->from('pen_spk');
        $this->db->join('pen_fpt', 'fptid = spk_fptid', 'left');
        $this->db->join('ms_kontrak', 'spk_nokontrak = kon_nomer AND spk_cbid = kon_cbid', 'left');
        $this->db->join('ms_pelanggan', 'spk_pelid = pelid', 'left');
        $this->db->where('spk_cbid', ses_cabang);
        $this->db->order_by($sidx, $sord);
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return null;
    }

    public function getAllFaktur($start, $limit, $sidx, $sord, $where) {
        $this->db->select('fkpid, fkp_nofaktur,fkp_tgl, pel_nama, byr_total, cty_deskripsi');
        $this->db->limit($limit);
        if ($where != NULL)
            $this->db->where($where, NULL, FALSE);
        $this->db->from('pen_faktur');
        $this->db->join('pen_faktur_payment', 'byr_fkpid = fkpid', 'left');
        $this->db->join('pen_spk', 'spkid = fkp_spkid', 'left');
        $this->db->join('ms_pelanggan', 'spk_pelid = pelid', 'left');
        $this->db->join('ms_car', 'fkp_mscid = mscid', 'left');
        $this->db->join('ms_car_type', 'msc_ctyid = ctyid', 'left');
        $this->db->where('spk_cbid', ses_cabang);
        $this->db->order_by($sidx, $sord);
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return null;
    }

    public function getAllCekDokumen($start, $limit, $sidx, $sord, $where) {
        $this->db->select('spkid, spk_no, spk_approve_status, spk_nokontrak, spk_approve_tgl,spk_approve_by,spk_faktur_status');
        $this->db->limit($limit);
        if ($where != NULL)
            $this->db->where($where, NULL, FALSE);
        $this->db->from('pen_spk');
        $this->db->where('spk_cbid', ses_cabang);
        $this->db->where('spk_ceklist_kategory != 0');
        $this->db->order_by($sidx, $sord);
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        log_message('error', 'AAAAAa ' . $this->db->last_query());
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return null;
    }

    public function getAllFpk($start, $limit, $sidx, $sord, $where) {
        $this->db->select('fpkid,fpk_no, fpk_tgl, spk_no, leas_nama, spk_nokontrak');
        $this->db->limit($limit);
        if ($where != NULL)
            $this->db->where($where, NULL, FALSE);
        $this->db->from('pen_fpk');
        $this->db->join('pen_spk', 'spkid = fpk_spkid', 'left');
        $this->db->join('ms_leasing', 'leasid = fpk_leasid', 'left');
        $this->db->where('fpk_cbid', ses_cabang);
        $this->db->where('fpk_status', 0);
        $this->db->order_by($sidx, $sord);
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return null;
    }

    /**
     * 
     * @param string $data
     * @return type
     * @throws Exception
     */
    public function saveBpk($data) {
        $this->db->trans_begin();
        $tahun = date('y');
        $result = array();
        $data['bpkid'] = NUM_BPK . $tahun . sprintf("%08s", $this->getCounter(NUM_BPK . $tahun));
        $str = $this->db->insert('pen_bpk', $data);
        if (!$str) {
            $errMessage = $this->db->_error_message();
            if (strpos($errMessage, "duplicate key value") == TRUE) {
                $this->db->trans_rollback();
                $result['result'] = false;
                $result['kode'] = '';
                $result['msg'] = error("Nomer '" . $data['bpk_nomer'] . "' Sudah Terdaftar");
                return $result;
            }
        }

        $mutasi = array(
            'mut_mscid' => $data['bpk_mscid'],
            'mut_desc' => 'Penerimaan Kendaraan',
            'mut_nomer' => $data['bpk_nomer'],
            'mut_nomerid' => $data['bpkid'],
            'mut_inout' => 'in',
            'mut_tgl' => date('Y-m-d H:i:s')
        );
        $this->db->insert('pen_mutasi', $mutasi);

        $this->db->query("UPDATE ms_car SET msc_ready_stock = 1, msc_hpp = " . $data['bpk_hpp'] . " WHERE mscid = '"
                . $data['bpk_mscid'] . "' AND msc_cbid = '" . $data['bpk_cbid'] . "'");
        if ($this->db->trans_status() == TRUE) {
            $this->db->trans_commit();
            $result['result'] = true;
            $result['kode'] = $data['bpkid'];
            $result['msg'] = sukses("Berhasil menyimpan bpk");
        } else {
            $this->db->trans_rollback();
            $result['result'] = false;
            $result['kode'] = '';
            $result['msg'] = error("Gagal menyimpan bpk");
        }
        return $result;
    }

    /**
     * 
     * @param array $data
     * @param type $fat
     * @return type
     */
    public function saveSpk($data, $fat) {
        $this->db->trans_begin();
        $tahun = date('y');
        $result = array();
        $data['spkid'] = NUM_SPK . $tahun . sprintf("%08s", $this->getCounter(NUM_SPK . $tahun));
        $str = $this->db->insert('pen_spk', $data);
        if (!$str) {
            $errMessage = $this->db->_error_message();
            if (strpos($errMessage, "duplicate key value") == TRUE) {
                $this->db->trans_rollback();
                $result['result'] = false;
                $result['kode'] = '';
                $result['msg'] = error("Nomer Spk '" . $data['spk_no'] . "' Sudah Terdaftar");
                return $result;
            }
        }
        $acc = 0;
        $this->db->query("DELETE FROM pen_fat WHERE fat_fptid = '" . $data['spk_fptid'] . "'");
        if (count($fat) > 0) {
            foreach ($fat as $value) {
                $value['fat_fptid'] = $data['spk_fptid'];
                $this->db->insert('pen_fat', $value);
                $acc += $value['fat_harga'];
            }
        }
        $this->db->query("UPDATE pen_fpt SET fpt_accesories = $acc WHERE fptid = '" . $data['spk_fptid'] . "'");
        $this->db->query("UPDATE ms_kontrak SET kon_use = 1 WHERE kon_cbid = '" . ses_cabang . "' AND kon_nomer = '" . $data['spk_nokontrak'] . "'");
        if ($this->db->trans_status() == TRUE) {
            $this->db->trans_commit();
            $result['result'] = true;
            $result['kode'] = $data['spkid'];
            $result['msg'] = sukses("Berhasil menyimpan spk");
        } else {
            $this->db->trans_rollback();
            $result['result'] = false;
            $result['kode'] = '';
            $result['msg'] = error("Gagal menyimpan spk");
        }
        return $result;
    }

    public function saveFakturPenjualan($data, $payment) {
        $this->db->trans_begin();
        $tahun = date('y');
        $result = array();
        $data['fkpid'] = NUM_FAKTUR_UNIT . $tahun . sprintf("%08s", $this->getCounter(NUM_FAKTUR_UNIT . $tahun));
        $payment['byr_fkpid'] = $data['fkpid'];
        $str = $this->db->insert('pen_faktur', $data);
        if (!$str) {
            $errMessage = $this->db->_error_message();
            if (strpos($errMessage, "duplicate key value") == TRUE) {
                $this->db->trans_rollback();
                $result['result'] = false;
                $result['kode'] = '';
                $result['msg'] = error("Nomer Faktur '" . $data['fkp_nofaktur'] . "' Sudah Terdaftar");
                return $result;
            }
        }

        // Save Mutasi
        $mutasi = array(
            'mut_mscid' => $data['fkp_mscid'],
            'mut_desc' => 'Faktur Penjualan',
            'mut_nomer' => $data['fkp_nofaktur'],
            'mut_nomerid' => $data['fkpid'],
            'mut_inout' => 'out',
            'mut_tgl' => date('Y-m-d H:i:s')
        );
        $this->db->insert('pen_mutasi', $mutasi);

        // Save faktur pembayaran
        $this->db->insert('pen_faktur_payment', $payment);
        // UPDATE SPK
        $this->db->query("UPDATE pen_spk SET spk_faktur_status = 1 WHERE spkid = '" . $data['fkp_spkid'] . "'");
        // UPDATE MS CAR SET STOCK READY TO FALSE
        $this->db->query("UPDATE ms_car SET msc_ready_stock = 0 WHERE mscid = '" . $data['fkp_mscid'] . "'");
        if ($this->db->trans_status() == TRUE) {
            $this->db->trans_commit();
            $result['result'] = true;
            $result['kode'] = $data['fkpid'];
            $result['msg'] = sukses("Berhasil menyimpan faktur");
        } else {
            $this->db->trans_rollback();
            $result['result'] = false;
            $result['kode'] = '';
            $result['msg'] = error("Gagal menyimpan faktur");
        }
        return $result;
    }

    /**
     * 
     * @param array $data
     * @param type $fat
     * @return type
     */
    public function saveCekDokumen($data, $ceklist) {
        $this->db->trans_begin();
        $this->db->where('spkid', $data['spkid']);
        $this->db->update('pen_spk', $data);
        $this->db->query("DELETE FROM pen_spk_ceklist WHERE list_spkid = '" . $data['spkid'] . "'");
        if (count($ceklist) > 0) {
            foreach ($ceklist as $value) {
                $this->db->insert('pen_spk_ceklist', $value);
            }
        }
        if ($this->db->trans_status() == TRUE) {
            $this->db->trans_commit();
            $result['result'] = true;
            $result['msg'] = sukses("Berhasil menyimpan spk");
        } else {
            $this->db->trans_rollback();
            $result['result'] = false;
            $result['msg'] = error("Gagal menyimpan spk");
        }
        return $result;
    }

    public function updateCekDokumen($spkid, $ceklist) {
        $this->db->trans_begin();
        $this->db->query("DELETE FROM pen_spk_ceklist WHERE list_spkid = '$spkid'");
        if (count($ceklist) > 0) {
            foreach ($ceklist as $value) {
                $this->db->insert('pen_spk_ceklist', $value);
            }
        }
        if ($this->db->trans_status() == TRUE) {
            $this->db->trans_commit();
            $result['result'] = true;
            $result['msg'] = sukses("Berhasil menyimpan cek list");
        } else {
            $this->db->trans_rollback();
            $result['result'] = false;
            $result['msg'] = error("Gagal menyimpan cek list");
        }
        return $result;
    }

    public function savePoLeasing($data) {
        $this->db->trans_begin();
        $tahun = date('y');
        $result = array();
        $data['fpkid'] = NUM_FPK_PK . $tahun . sprintf("%08s", $this->getCounter(NUM_FPK_PK . $tahun));
        $data['fpk_no'] = NUM_FPK_NOMER . $tahun . sprintf("%06s", $this->getCounterCabang(NUM_FPK_NOMER . $tahun));
        $this->db->insert('pen_fpk', $data);
        if ($this->db->trans_status() == TRUE) {
            $this->db->trans_commit();
            $result['result'] = true;
            $result['kode'] = $data['fpkid'];
            $result['msg'] = sukses("Berhasil menyimpan PO Leasing");
        } else {
            $this->db->trans_rollback();
            $result['result'] = false;
            $result['kode'] = '';
            $result['msg'] = error("Gagal menyimpan PO Leasing");
        }
        return $result;
    }

    /**
     * 
     * @param type $data
     * @return type
     */
    public function saveReturBeli($data) {
        $this->db->trans_begin();
        $tahun = date('y');
        $result = array();
        $data['rtbid'] = NUM_RETUR_BELI_UNIT . $tahun . sprintf("%08s", $this->getCounter(NUM_RETUR_BELI_UNIT . $tahun));
        $str = $this->db->insert('pen_retbeli', $data);
        $this->db->query("UPDATE ms_car SET msc_ready_stock = 0 WHERE mscid = '" . $data['rtb_mscid'] . "'");
        if (!$str) {
            $errMessage = $this->db->_error_message();
            if (strpos($errMessage, "duplicate key value") == TRUE) {
                $this->db->trans_rollback();
                $result['result'] = false;
                $result['kode'] = '';
                $result['msg'] = error("Nomer Retur '" . $data['rtb_nomer'] . "' Sudah Terdaftar");
                return $result;
            }
        }
        $mutasi = array(
            'mut_mscid' => $data['rtb_mscid'],
            'mut_desc' => 'Retur Beli',
            'mut_nomer' => $data['rtb_nomer'],
            'mut_nomerid' => $data['rtbid'],
            'mut_inout' => 'out',
            'mut_cbid' => ses_cabang,
            'mut_tgl' => date('Y-m-d H:i:s')
        );
        $this->db->insert('pen_mutasi', $mutasi);
        if ($this->db->trans_status() == TRUE) {
            $this->db->trans_commit();
            $result['result'] = true;
            $result['kode'] = '';
            $result['msg'] = sukses("Berhasil menyimpan Retur");
        } else {
            $this->db->trans_rollback();
            $result['result'] = false;
            $result['kode'] = '';
            $result['msg'] = error("Gagal menyimpan Retur");
        }
        return $result;
    }

    public function saveReturJual($data) {
        $this->db->trans_begin();
        $tahun = date('y');
        $result = array();
        $data['rtjid'] = NUM_RETUR_BELI_UNIT . $tahun . sprintf("%08s", $this->getCounter(NUM_RETUR_BELI_UNIT . $tahun));
        $str = $this->db->insert('pen_retjual', $data);
        $this->db->query("UPDATE ms_car SET msc_ready_stock = 1 WHERE mscid = '" . $data['rtj_mscid'] . "'");
        if (!$str) {
            $errMessage = $this->db->_error_message();
            if (strpos($errMessage, "duplicate key value") == TRUE) {
                $this->db->trans_rollback();
                $result['result'] = false;
                $result['kode'] = '';
                $result['msg'] = error("Nomer Retur '" . $data['rtj_nomer'] . "' Sudah Terdaftar");
                return $result;
            }
        }
        $mutasi = array(
            'mut_mscid' => $data['rtj_mscid'],
            'mut_desc' => 'Retur Jual',
            'mut_cbid' => ses_cabang,
            'mut_nomer' => $data['rtj_nomer'],
            'mut_nomerid' => $data['rtjid'],
            'mut_inout' => 'in',
            'mut_tgl' => date('Y-m-d H:i:s')
        );
        $this->db->insert('pen_mutasi', $mutasi);
        if ($this->db->trans_status() == TRUE) {
            $this->db->trans_commit();
            $result['result'] = true;
            $result['kode'] = '';
            $result['msg'] = sukses("Berhasil menyimpan Retur");
        } else {
            $this->db->trans_rollback();
            $result['result'] = false;
            $result['kode'] = '';
            $result['msg'] = error("Gagal menyimpan Retur");
        }
        return $result;
    }

    /**
     * 
     * @param type $data
     * @param type $where
     * @return type
     */
    public function updateBpk($data, $where) {
        $this->db->where('bpkid', $where);
        if ($this->db->update('pen_bpk', $data)) {
            return array('status' => TRUE, 'msg' => 'TERIMA KENDARAAN BERHASIL DIUPDATE');
        } else {
            return array('status' => FALSE, 'msg' => 'TERIMA KENDARAAN GAGAL DIUPDATE');
        }
    }

    public function updatePoLeasing($data) {
        $this->db->where('fpkid', $data['fpkid']);
        $this->db->update('pen_fpk', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        return false;
    }

    public function saveApproveCekDokumen($data) {
        $this->db->where('spkid', $data['spkid']);
        $this->db->update('pen_spk', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        return false;
    }

    /**
     * 
     * @param type $data
     * @return type
     */
    public function getBpk($data) {
        $query = $this->db->query("
            SELECT * FROM pen_bpk
            LEFT JOIN ms_supplier ON supid = bpk_supid
            LEFT JOIN ms_car ON mscid = bpk_mscid
            LEFT JOIN ms_car_type ON ctyid = msc_ctyid
            LEFT JOIN ms_car_model ON modelid = cty_modelid
            LEFT JOIN ms_car_merk ON merkid = model_merkid
            LEFT JOIN ms_warna ON warnaid = msc_warnaid
            WHERE bpkid = '" . $data . "'");
        return $query->row_array();
    }

    /**
     * 
     * @param type $data
     * @return boolean
     */
    public function deleteBpk($data) {
        if ($this->db->query("DELETE FROM ms_car WHERE bpkid = ' " . $data . "'")) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * 
     * @return boolean
     */
    public function getCeklistKategory() {
        $sql = $this->db->query("SELECT * FROM ms_ceklist_kategory ORDER BY ck_deskripsi");
        return $sql->result_array();
    }

    public function getCekdokumenDetail($kategory, $spkid) {
        if ($kategory == 0) {
            $kategory = '0';
        }
        $sql = $this->db->query("SELECT * FROM ms_ceklist_detail LEFT JOIN ms_ceklist ON cekid = detail_cekid "
                . " LEFT JOIN pen_spk_ceklist ON cekid = list_cekid AND list_spkid = '$spkid' WHERE detail_ckid = $kategory ORDER BY cek_deskripsi");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }

    public function getCekdokumenBySpkid($spkid) {
        $sql = $this->db->query("SELECT * FROM pen_spk_ceklist LEFT JOIN ms_ceklist ON cekid = list_cekid "
                . "WHERE list_spkid = '$spkid' ORDER BY cek_deskripsi");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }

    public function deleteFpk($data) {
        if ($this->db->query("UPDATE pen_fpk SET fpk_status = 1 WHERE fpkid = '$data'")) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}

?>
