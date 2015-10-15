<?php

/**
 * The MODEL PROSPECT
 * @author Rossi Erl
 * 2015-08-29
 */
class Model_Prospect extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /* UTILITY FUNCTION */

    public function cListSinfo() {
        $this->db->where('smbinfo_cbid', ses_cabang);
        $query = $this->db->get('ms_sumber_info');
        return $query->result_array();
    }

    public function cListKontak() {
        $this->db->where('kontak_cbid', ses_cabang);
        $query = $this->db->get('ms_kontak_awal');
        return $query->result_array();
    }

    public function cListBisnis() {
        $this->db->where('bisnis_cbid', ses_cabang);
        $query = $this->db->get('ms_bisnis');
        return $query->result_array();
    }

    /** TRANSAKSI PROSPECT
     * @author Rossi Erl <rosoningati@gmail.com>
     * Created on 2015-09-04
     */
    public function getTotalProspect($where) {
        $wh = "WHERE pros_cbid = '" . ses_cabang . "' ";
        if ($where != NULL)
            $wh .= " AND " . $where;

        $sql = $this->db->query("SELECT COUNT(*) AS total FROM pros_data " . $wh);
        return $sql->row()->total;
    }

    public function getDataProspect($start, $limit, $sidx, $sord, $where) {

        /* FILTER BY SUPERVISOR 
          if (ses_jabatan == 'supervisor') {
          $filter = $this->getSalesBySpv(array('krid' => ses_krid, 'cbid' => ses_cabang));
          } else if (ses_jabatan == 'sales') {
          $filter = array(ses_krid);
          }
         */


        $this->db->select('prosid, pros_kode, pros_cbid, 
            pros_salesman, pros_nama, pros_alamat, pros_hp, pros_telpon, car_qty,
            cty_deskripsi, kr_nama');
        $this->db->limit($limit);
        if ($where != NULL)
            $this->db->where($where, NULL, FALSE);
        $this->db->from('pros_data');
        $this->db->join('pros_data_car', 'car_prosid=prosid', 'left');
        $this->db->join('ms_car_type', 'ctyid=car_ctyid', 'left');
        $this->db->join('ms_karyawan', 'krid=pros_salesman', 'left');
        $this->db->where('pros_cbid', ses_cabang);
        if (isset($filter)) {
            $this->db->where_in('pros_sales', $filter);
        }
        $this->db->order_by($sidx, $sord);
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return null;
    }

    public function addProspect($data = array(), $cars = array()) {
        $this->db->trans_begin();
        try {
            $tahun = date('y');
            $data['prosid'] = NUM_PROSPECT . $tahun . sprintf("%08s", $this->getCounter(NUM_PROSPECT . $tahun));
            $data['pros_kode'] = NUM_PROSPECT . $tahun . sprintf("%06s", $this->getCounterCabang(NUM_PROSPECT . $tahun));

            if ($this->db->insert('pros_data', $data) == FALSE) {
                $warn = "FAILED INSERTING DATA : PROSPECT";
                throw new Exception($warn);
            }

            if (count($cars) > 0) {
                for ($i = 0; $i <= count($cars['ctyid']) - 1; $i++) {
                    if ($this->db->insert('pros_data_car', array(
                                'car_prosid' => $data['prosid'],
                                'car_ctyid' => $cars['ctyid'][$i],
                                'car_qty' => $cars['qty'][$i],
                            )) == FALSE) {
                        $warn = "FAILED INSERTING DATA CARS";
                        throw new Exception($warn);
                    }
                }
            }

            if ($this->db->trans_status() == TRUE) {
                $this->db->trans_commit();
                return array('status' => TRUE, 'msg' => 'PROSPECT BERHASIL DITAMBAHKAN ');
            } else {
                $this->db->trans_rollback();
                return array('status' => FALSE, 'msg' => 'PROSPECT GAGAL DITAMBAHKAN ');
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            return array('status' => FALSE, 'msg' => $e->getMessage());
        }
    }

    public function updateProspect($data, $where) {
        $this->db->where('prosid', $where);
        if ($this->db->update('pros_data', $data)) {
            return array('status' => TRUE, 'msg' => 'PROSPECT ' . $data['prosid'] . ' BERHASIL DIUPDATE');
        } else {
            return array('status' => FALSE, 'msg' => 'PROSPECT ' . $data['prosid'] . ' GAGAL DIUPDATE');
        }
    }

    public function deleteProspect($data) {
        if ($this->db->query('DELETE FROM pros_data WHERE prosid = ' . $data)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getProspect($data) {
        $query = $this->db->query("
            SELECT
                prosid,
                pros_kode,
                pros_nama,
                pros_alamat,
                pros_createon,
                pros_createby,
                pros_cbid,
                pros_hp,
                pros_gender,
                pros_fax,
                pros_telpon,
                pros_email,
                pros_noid,
                pros_npwp,
                pros_tempat_lahir,
                pros_tgl_lahir,
                pros_type,
                pros_keterangan,
                kr_nama,
                kota_deskripsi,
                prop_deskripsi,
                area_deskripsi,
                kontak_deskripsi,
                smbinfo_deskripsi, 
                bisnis_deskripsi
            FROM
                pros_data
            LEFT JOIN ms_karyawan ON krid = pros_salesman
            LEFT JOIN ms_area ON areaid = pros_area
            LEFT JOIN ms_kota ON kotaid = pros_kotaid
            LEFT JOIN ms_propinsi ON propid = kota_propid
            LEFT JOIN ms_sumber_info ON smbinfoid = pros_sumber_info
            LEFT JOIN ms_kontak_awal ON kontakid = pros_kontak_awal
            LEFT JOIN ms_bisnis ON bisnisid = pros_bisnis
            WHERE prosid = '" . $data . "'  ");
        return $query->row_array();
    }

    public function getDetailCars($data) {
        $query = "SELECT merk_deskripsi, model_deskripsi, cty_deskripsi, car_qty 
            FROM pros_data_car
            LEFT JOIN ms_car_type ON ctyid = car_ctyid
            LEFT JOIN ms_car_model ON modelid = cty_modelid
            LEFT JOIN ms_car_merk ON merkid = model_merkid
            WHERE car_prosid = '" . $data . "'";
        $sql = $this->db->query($query);
        return $sql->result_array();
    }

    /**
     * This function is used for selecting krid by atasan value
     * @author Rossi Erl <rosoningati@gmail.com>
     * Created on 2015-09-15
     */
    public function getSalesBySpv($data) {
        $query = "SELECT krid FROM ms_karyawan 
            WHERE kr_atasan = '" . $data['krid'] . "' 
                AND kr_cbid = '" . $data['cbid'] . "'";
        $sql = $this->db->query($query);
        return $sql->result_array();
    }

    /**
     * FPT ( Form Persetujuan Transaksi )
     * @author Rossi Erl <rosoningati@gmail.com>
     * Created on 2015-09-15
     */
    public function addFPT($data = array()) {
        $this->db->trans_begin();
        try {
            $tahun = date('y');
            $data['fptid'] = NUM_FPT . $tahun . sprintf("%08s", $this->getCounter(NUM_FPT . $tahun));
            $data['fpt_kode'] = NUM_FPT . $tahun . sprintf("%06s", $this->getCounterCabang(NUM_FPT . $tahun));

            if ($this->db->insert('pen_fpt', $data) == FALSE) {
                $warn = "FAILED INSERTING DATA : FPT";
                throw new Exception($warn);
            }

            if ($this->db->trans_status() == TRUE) {
                $this->db->trans_commit();
                return array('status' => TRUE, 'msg' => 'FPT BERHASIL DITAMBAHKAN ');
            } else {
                $this->db->trans_rollback();
                return array('status' => FALSE, 'msg' => 'FPT GAGAL DITAMBAHKAN ');
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            return array('status' => FALSE, 'msg' =>  $e->getMessage());
        }
    }
    
    public function getTotalFpt($where) {
        $wh = "WHERE fpt_cbid = '" . ses_cabang . "' ";
        if ($where != NULL)
            $wh .= " AND " . $where;

        $sql = $this->db->query("SELECT COUNT(*) AS total FROM pen_fpt " . $wh);
        return $sql->row()->total;
    }
    
    public function getDataFpt($start, $limit, $sidx, $sord, $where) {

        /* FILTER BY SUPERVISOR 
          if (ses_jabatan == 'supervisor') {
          $filter = $this->getSalesBySpv(array('krid' => ses_krid, 'cbid' => ses_cabang));
          } else if (ses_jabatan == 'sales') {
          $filter = array(ses_krid);
          }
         */
        $wh = ($where != NULL)?" AND " . $where: " ";
        
        $query = $this->db->query("
            SELECT fptid, fpt_kode, prosid, pros_nama, pros_alamat, 
            CASE WHEN fpt_approve = 1 THEN 'DISETUJUI' 
                WHEN fpt_approve = 2 THEN 'DITOLAK'
                ELSE 'PROSES' END as fpt_status, 
            pros_salesman, pros_hp, fpt_tgl, kr_nama, cty_deskripsi
            FROM pen_fpt
            LEFT JOIN pros_data ON prosid = fpt_prosid
            LEFT JOIN pros_data_car ON car_prosid = fpt_prosid
            LEFT JOIN ms_car_type ON ctyid = car_ctyid
            LEFT JOIN ms_karyawan ON krid = pros_salesman
            WHERE fpt_cbid =  '".ses_cabang."' ".$wh."
            ORDER BY ".$sidx." ".$sord."
            LIMIT ".$limit." OFFSET ".$start."
        ");
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return null;
    }

    public function updateFPT($data, $where) {
        $this->db->where('fptid', $where);
        if ($this->db->update('pen_fpt', $data)) {
            return array('status' => TRUE, 'msg' => 'FPT ' . $where . ' BERHASIL DIUPDATE');
        } else {
            return array('status' => FALSE, 'msg' => 'FPT ' . $where . ' GAGAL DIUPDATE');
        }
    }

    public function deleteFPT($data) {
        if ($this->db->query('DELETE FROM pen_fpt WHERE fptid = ' . $data)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getFPT($data) {
        $query = $this->db->query("
            SELECT * FROM pen_fpt 
            LEFT JOIN pros_data ON prosid = fpt_prosid
            WHERE prosid = '" . $data . "'");
        return $query->row_array();
    }

    /**
     * AGENDA PROSPECT
     * @author Rossi Erl <rosoningati@gmail.com>
     * Created on 2015-09-15
     */
    public function addAgenda($data = array()) {
        if ($this->db->insert('pros_agenda', $data) == TRUE) {
            return array('status' => TRUE, 'msg' => 'AGENDA BERHASIL DITAMBAHKAN ');
        } else {
            return array('status' => FALSE, 'msg' => 'AGENDA GAGAL DITAMBAHKAN ');
        }
    }

    public function updateAgenda($data, $where) {
        $this->db->where('agenid', $where);
        if ($this->db->update('pros_agenda', $data)) {
            return array('status' => TRUE, 'msg' => 'AGENDA BERHASIL DIUPDATE');
        } else {
            return array('status' => FALSE, 'msg' => 'AGENDA GAGAL DIUPDATE');
        }
    }

    public function deleteAgenda($data) {
        if ($this->db->query('DELETE FROM pros_agenda WHERE agenid = ' . $data)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getAgenda($data) {
        $query = $this->db->query("
            SELECT * FROM pros_agenda WHERE agenid = " . $data);
        return $query->row_array();
    }

    /** AREA SALES
     * @author Rossi Erl
     * 2015-09-03
     */
    public function getTotalArea($where) {
        $wh = "WHERE area_cbid = '" . ses_cabang . "'";
        if ($where != NULL)
            $wh = " AND " . $where;
        $sql = $this->db->query("SELECT COUNT(*) AS total FROM ms_area " . $wh);
        return $sql->row()->total;
    }

    public function getDataArea($start, $limit, $sidx, $sord, $where) {
        $this->db->select('*');
        $this->db->limit($limit);
        if ($where != NULL)
            $this->db->where($where, NULL, FALSE);
        $this->db->from('ms_area');
        $this->db->join('ms_kota', 'kotaid = area_kotaid', 'left');
        $this->db->join('ms_propinsi', 'propid = kota_propid', 'left');
        $this->db->where('area_cbid', ses_cabang);
        $this->db->order_by($sidx, $sord);
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return null;
    }

    public function addArea($data) {
        if ($this->db->insert('ms_area', $data)) {
            return array('status' => TRUE, 'msg' => 'Data ' . $data['area_deskripsi'] . ' berhasil disimpan');
        } else {
            return array('status' => FALSE, 'msg' => 'Data ' . $data['area_deskripsi'] . ' gagal disimpan');
        }
    }

    public function getArea($data) {
        $query = $this->db->query("
            SELECT * FROM ms_area 
            LEFT JOIN ms_kota on kotaid = area_kotaid
            LEFT JOIN ms_propinsi on propid = kota_propid
            WHERE areaid = " . $data . "
            ");
        return $query->row_array();
    }

    public function updateArea($data, $where) {
        $this->db->where('areaid', $where);
        if ($this->db->update('ms_area', $data)) {
            return array('status' => TRUE, 'msg' => 'Data ' . $data['area_deskripsi'] . ' berhasil diupdate');
        } else {
            return array('status' => FALSE, 'msg' => 'Data ' . $data['area_deskripsi'] . ' gagal diupdate');
        }
    }

    public function deleteArea($data) {
        if ($this->db->query('DELETE FROM ms_area WHERE areaid = ' . $data)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /** SUMBER INFORMASI
     * @author Rossi Erl
     * 2015-09-03
     */
    public function getTotalSmbInfo($where) {
        $wh = "WHERE smbinfo_cbid = '" . ses_cabang . "'";
        if ($where != NULL)
            $wh = " AND " . $where;
        $sql = $this->db->query("SELECT COUNT(*) AS total FROM ms_sumber_info " . $wh);
        return $sql->row()->total;
    }

    public function getDataSmbInfo($start, $limit, $sidx, $sord, $where) {
        $this->db->select('*');
        $this->db->limit($limit);
        if ($where != NULL)
            $this->db->where($where, NULL, FALSE);
        $this->db->from('ms_sumber_info');
        $this->db->where('smbinfo_cbid', ses_cabang);
        $this->db->order_by($sidx, $sord);
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return null;
    }

    public function addSmbInfo($data) {
        if ($this->db->insert('ms_sumber_info', $data)) {
            return array('status' => TRUE, 'msg' => 'Data ' . $data['smbinfo_deskripsi'] . ' berhasil disimpan');
        } else {
            return array('status' => FALSE, 'msg' => 'Data ' . $data['smbinfo_deskripsi'] . ' gagal disimpan');
        }
    }

    public function getSmbInfo($data) {
        $query = $this->db->query("
            SELECT * FROM ms_sumber_info WHERE smbinfoid = " . $data . "
            ");
        return $query->row_array();
    }

    public function updateSmbInfo($data, $where) {
        $this->db->where('smbinfoid', $where);
        if ($this->db->update('ms_sumber_info', $data)) {
            return array('status' => TRUE, 'msg' => 'Data ' . $data['smbinfo_deskripsi'] . ' berhasil diupdate');
        } else {
            return array('status' => FALSE, 'msg' => 'Data ' . $data['smbinfo_deskripsi'] . ' gagal diupdate');
        }
    }

    public function deleteSmbInfo($data) {
        if ($this->db->query('DELETE FROM ms_sumber_info WHERE smbinfoid = ' . $data)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /** KONTAK AWAL
     * @author Rossi Erl
     * 2015-09-03
     */
    public function getTotalKontakAwal($where) {
        $wh = "WHERE kontak_cbid = '" . ses_cabang . "'";
        if ($where != NULL)
            $wh = " AND " . $where;
        $sql = $this->db->query("SELECT COUNT(*) AS total FROM ms_kontak_awal " . $wh);
        return $sql->row()->total;
    }

    public function getDataKontakAwal($start, $limit, $sidx, $sord, $where) {
        $this->db->select('*');
        $this->db->limit($limit);
        if ($where != NULL)
            $this->db->where($where, NULL, FALSE);
        $this->db->from('ms_kontak_awal');
        $this->db->where('kontak_cbid', ses_cabang);
        $this->db->order_by($sidx, $sord);
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return null;
    }

    public function addKontakAwal($data) {
        if ($this->db->insert('ms_kontak_awal', $data)) {
            return array('status' => TRUE, 'msg' => 'Data ' . $data['kontak_deskripsi'] . ' berhasil disimpan');
        } else {
            return array('status' => FALSE, 'msg' => 'Data ' . $data['kontak_deskripsi'] . ' gagal disimpan');
        }
    }

    public function getKontakAwal($data) {
        $query = $this->db->query("
            SELECT * FROM ms_kontak_awal WHERE kontakid = " . $data . "
            ");
        return $query->row_array();
    }

    public function updateKontakAwal($data, $where) {
        $this->db->where('kontakid', $where);
        if ($this->db->update('ms_kontak_awal', $data)) {
            return array('status' => TRUE, 'msg' => 'Data ' . $data['kontak_deskripsi'] . ' berhasil diupdate');
        } else {
            return array('status' => FALSE, 'msg' => 'Data ' . $data['kontak_deskripsi'] . ' gagal diupdate');
        }
    }

    public function deleteKontakAwal($data) {
        if ($this->db->query('DELETE FROM ms_kontak_awal WHERE kontakid = ' . $data)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /** BISNIS
     * @author Rossi Erl
     * 2015-09-03
     */
    public function getTotalBisnis($where) {
        $wh = "WHERE bisnis_cbid = '" . ses_cabang . "'";
        if ($where != NULL)
            $wh = " AND " . $where;
        $sql = $this->db->query("SELECT COUNT(*) AS total FROM ms_bisnis " . $wh);
        return $sql->row()->total;
    }

    public function getDataBisnis($start, $limit, $sidx, $sord, $where) {
        $this->db->select('*');
        $this->db->limit($limit);
        if ($where != NULL)
            $this->db->where($where, NULL, FALSE);
        $this->db->from('ms_bisnis');
        $this->db->where('bisnis_cbid', ses_cabang);
        $this->db->order_by($sidx, $sord);
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return null;
    }

    public function addBisnis($data) {
        if ($this->db->insert('ms_bisnis', $data)) {
            return array('status' => TRUE, 'msg' => 'Data ' . $data['bisnis_nama'] . ' berhasil disimpan');
        } else {
            return array('status' => FALSE, 'msg' => 'Data ' . $data['bisnis_nama'] . ' gagal disimpan');
        }
    }

    public function getBisnis($data) {
        $query = $this->db->query("
            SELECT * FROM ms_bisnis WHERE bisnisid = " . $data . "
            ");
        return $query->row_array();
    }

    public function updateBisnis($data, $where) {
        $this->db->where('bisnisid', $where);
        if ($this->db->update('ms_bisnis', $data)) {
            return array('status' => TRUE, 'msg' => 'Data ' . $data['bisnis_nama'] . ' berhasil diupdate');
        } else {
            return array('status' => FALSE, 'msg' => 'Data ' . $data['bisnis_nama'] . ' gagal diupdate');
        }
    }

    public function deleteBisnis($data) {
        if ($this->db->query('DELETE FROM ms_bisnis WHERE bisnisid = ' . $data)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /* AUTO COMPLETE */

    public function autoAksesories($data) {
        $sql = $this->db->query("
            SELECT aksid, aks_nama, aks_descrip, aks_harga, aks_status
            FROM ms_aksesories WHERE (aks_nama LIKE '%" . $data['param'] . "%' OR aks_descrip LIKE '%" . $data['param'] . "%') 
                AND aks_cbid = '" . $data['cbid'] . "'
            ORDER BY aks_nama ASC LIMIT 15 OFFSET 0
        ");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }

}

?>
