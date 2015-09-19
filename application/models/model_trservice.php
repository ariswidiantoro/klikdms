<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Model_Trservice extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Get data wo berdasarkan nomor wo
     * @param String $woNomer Nomor work order
     * @return array of work order
     */
    public function getWo($woNomer) {
        $sql = $this->db->query("SELECT * FROM svc_wo WHERE wo_nomer = '$woNomer' AND wo_cbid = '" . ses_cabang . "'");
        if ($sql->num_rows() > 0) {
            return $sql->row_array();
        }
        return null;
    }

    /**
     * Get data wo berdasarkan nomor wo
     * @param String $woNomer Nomor work order
     * @return array of work order
     */
    public function getNopol($nopol) {
        $sql = $this->db->query("SELECT msc_nopol, mscid,msc_norangka  "
                . " FROM ms_car WHERE msc_nopol LIKE '$nopol%' AND msc_cbid = '"
                . ses_cabang . "' ORDER BY msc_nopol LIMIT 20");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }

    /**
     * 
     * @param type $data
     * @return null
     */
    public function getFlateRateAuto($data, $type) {
        if (!empty($data)) {
            $sql = $this->db->query("SELECT flat_kode, flat_deskripsi,flatid  "
                    . " FROM svc_frate WHERE (flat_kode LIKE '%$data%' OR flat_deskripsi LIKE '%$data%' ) AND flat_cbid = '"
                    . ses_cabang . "' AND flat_type = $type ORDER BY flat_kode LIMIT 20");
//            log_message('error', 'AAAAA '.$this->db->last_query());
            if ($sql->num_rows() > 0) {
                return $sql->result_array();
            }
        }

        return null;
    }

    /**
     * 
     * @param type $kode
     * @return null
     */
    public function getDataFlateRate($kode) {
        $sql = $this->db->query("SELECT * FROM svc_frate WHERE  flat_kode = '$kode' AND flat_cbid = '"
                . ses_cabang . "'");
        if ($sql->num_rows() > 0) {
            return $sql->row_array();
        }
        return null;
    }

    public function getDataKendaraan($nopol) {
        $sql = $this->db->query("SELECT msc_nopol,msc_inextern, mscid,msc_norangka,pelid,pel_nama,model_deskripsi,merk_deskripsi   "
                . " FROM ms_car LEFT JOIN ms_car_type ON ctyid = msc_ctyid LEFT JOIN ms_car_model ON modelid = cty_modelid "
                . "LEFT JOIN ms_car_merk ON merkid = model_merkid LEFT JOIN ms_pelanggan ON pelid = msc_pelid WHERE msc_nopol = '$nopol' AND msc_cbid = '"
                . ses_cabang . "'");
        if ($sql->num_rows() > 0) {
            return $sql->row_array();
        }
        return null;
    }

    public function getWoJenis() {
        $sql = $this->db->query("SELECT * FROM svc_wo_jenis WHERE woj_cbid = '" . ses_cabang . "' ORDER BY woj_urut");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }

    public function getStall() {
        $sql = $this->db->query("SELECT * FROM svc_stall WHERE stall_cbid = '" . ses_cabang . "' ORDER BY stall_nomer");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }

    /**
     * 
     * @param type $woid
     * @return null
     */
    public function getJasaWorkOrder($woid) {
        $sql = $this->db->query("SELECT woj_keluhan,woj_namajasa FROM svc_wo_jasa WHERE woj_woid = '$woid' ORDER BY wojid");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }

    /**
     * 
     * @param type $woid
     * @return null
     */
    public function getSparepartWorkOrder($woid) {
        $sql = $this->db->query("SELECT inve_nama FROM svc_wo_part LEFT JOIN spa_inventory ON inveid = wop_inveid WHERE wop_woid = '$woid'");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }

    /**
     * 
     * @param type $woid
     * @return null
     */
    public function getSoWorkOrder($woid) {
        $sql = $this->db->query("SELECT wos_nama FROM svc_wo_suborder WHERE wos_woid = '$woid'");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }

    /**
     * 
     * @param type $woid
     * @return null
     */
    public function getWorkOrder($woid) {
        $sql = $this->db->query("SELECT wo_numerator,wo_status,wo_booking,wo_inextern,wo_nomer,msc_nopol,"
                . " msc_norangka,msc_nomesin,msc_tahun,wo_km,kr_nama,pel_nama,pel_alamat,model_deskripsi,"
                . " pel_hp,wo_createon,wo_selesai,pel_telpon, wo_pembawa"
                . " FROM svc_wo LEFT JOIN ms_car ON mscid = wo_mscid LEFT JOIN ms_car_type"
                . " ON msc_ctyid = ctyid LEFT JOIN ms_car_model ON modelid = cty_modelid"
                . " LEFT JOIN ms_pelanggan ON pelid = wo_pelid LEFT JOIN ms_karyawan ON krid = wo_sa"
                . " WHERE woid = '$woid'");
        if ($sql->num_rows() > 0) {
            return $sql->row_array();
        }
        return null;
    }

    /**
     * 
     * @param type $where
     * @return type
     */
    public function getTotalWo($where) {
        $wh = "WHERE wo_cbid = '" . ses_cabang . "' AND wo_inv_status = 0";
        if ($where != NULL)
            $wh = " AND " . $where;
        $sql = $this->db->query("SELECT COUNT(woid) AS total FROM svc_wo LEFT JOIN "
                . "ms_pelanggan ON pelid = wo_pelid LEFT JOIN ms_car ON mscid = wo_mscid $wh");
        return $sql->row()->total;
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
    function getAllWo($start, $limit, $sidx, $sord, $where) {
        $this->db->select('woid, wo_nomer, msc_nopol,pel_nama,clo_status');
        $this->db->limit($limit);
        if ($where != NULL)
            $this->db->where($where, NULL, FALSE);
        $this->db->where('wo_cbid', ses_cabang);
        $this->db->where('wo_inv_status', 0);
        $this->db->from('svc_wo');
        $this->db->join('ms_pelanggan', 'pelid = wo_pelid', 'LEFT');
        $this->db->join('ms_car', 'mscid = wo_mscid', 'LEFT');
        $this->db->join('svc_clock', 'clo_woid = woid', 'LEFT');
        $this->db->order_by($sidx, $sord);
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return null;
    }

    /**
     *
     * @param type $tgl
     * @param type $timestart
     * @param type $timeend
     * @return type 
     */
    public function getDataMekanik() {
        $query = $this->db->QUERY("SELECT DISTINCT krid, kr_nama FROM svc_absensi"
                . " LEFT JOIN ms_karyawan on abs_krid = krid WHERE"
                . " abs_cbid = '" . ses_cabang . "' AND kr_jabid = '"
                . JAB_MEKANIK . "' AND abs_tgl = '" . date('Y-m-d') . "'"
                . " AND abs_krid NOT IN(SELECT det_mekanikid FROM svc_clock_det "
                . " LEFT JOIN svc_clock ON cloid = det_cloid WHERE clo_status = 1)"
                . " ORDER BY kr_nama");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    /**
     * Function ini digunakan untuk menyimpan data work order
     * @param type $data
     * @param type $jasa
     * @param type $sp
     * @param type $so
     */
    function saveWo($data, $jasa, $sp, $so) {
        $this->db->trans_begin();
        $tahun = substr(date('Y'), 2, 2);
        $id = "WO" . $tahun . sprintf("%08s", $this->getCounter("WO" . $tahun));
        $woNomer = $data['wo_jenis'] . $tahun . sprintf("%06s", $this->getCounterCabang($data['wo_jenis'] . $tahun));
        $data['woid'] = $id;
        $data['wo_nomer'] = $woNomer;
        $this->db->INSERT('svc_wo', $data);

        // SIMPAN WO JASA
        if (count($jasa) > 0) {
            foreach ($jasa as $d) {
                $d['woj_woid'] = $id;
                $this->db->INSERT('svc_wo_jasa', $d);
            }
        }
        // SIMPAN WO SPAREPART
        if (count($sp) > 0) {
            foreach ($sp as $d) {
                $d['wop_woid'] = $id;
                $this->db->INSERT('svc_wo_part', $d);
            }
        }

        // SIMPAN WO SO
        if (count($so) > 0) {
            foreach ($so as $d) {
                $d['wos_woid'] = $id;
                $this->db->INSERT('svc_wo_suborder', $d);
            }
        }

        // SIMPAN CLOCK ON / OFF MEKANIK
        $clock = array(
            'cloid' => $id,
            'clo_woid' => $id,
            'clo_tgl' => date('Y-m-d'),
        );
        $this->db->INSERT('svc_clock', $clock);

        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            $result['result'] = true;
            $result['kode'] = $id;
            $result['msg'] = sukses("Berhasil menyimpan work order");
        } else {
            $this->db->trans_rollback();
            $result['result'] = false;
            $result['kode'] = $id;
            $result['msg'] = error("Gagal menyimpan work order");
        }
        return $result;
    }

}

?>
