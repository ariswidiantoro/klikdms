<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Model_Lap_Sales extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 
     * @param Date $start
     * @param Date $end
     * @param String $cabang
     * @return null
     */
    function getMasukKendaran($start, $end, $cabang) {
        $sql = $this->db->query("SELECT bpk_nomer,bpk_tgl,sup_nama,sup_alamat,bpk_nodo,"
                . " bpk_tgldo,merk_deskripsi,model_deskripsi,cty_deskripsi,msc_norangka,"
                . " msc_nomesin,msc_bodyseri,warna_deskripsi,msc_kondisi FROM pen_bpk "
                . " LEFT JOIN ms_car ON bpk_mscid = mscid"
                . " LEFT JOIN ms_car_type ON msc_ctyid = ctyid"
                . " LEFT JOIN ms_car_model ON cty_modelid = modelid"
                . " LEFT JOIN ms_car_merk ON model_merkid = merkid"
                . " LEFT JOIN ms_supplier ON supid = bpk_supid"
                . " LEFT JOIN ms_warna ON warnaid = msc_warnaid"
                . " WHERE bpk_cbid = '$cabang' AND bpk_tgl BETWEEN '$start' AND '$end' ORDER BY bpkid");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }

    /**
     * 
     * @param Date $start
     * @param Date $end
     * @param String $cabang
     * @return null
     */
    function getReturBeli($start, $end, $cabang) {
        $sql = $this->db->query("SELECT rtb_nomer,rtb_alasan_retur,rtb_tgl,bpk_nomer,bpk_tgl,"
                . " sup_nama,sup_alamat,bpk_nodo,"
                . " bpk_tgldo,merk_deskripsi,model_deskripsi,cty_deskripsi,msc_norangka,"
                . " msc_nomesin,msc_bodyseri,warna_deskripsi,msc_kondisi FROM pen_retbeli "
                . " LEFT JOIN pen_bpk ON rtb_bpkid = bpkid "
                . " LEFT JOIN ms_car ON bpk_mscid = mscid"
                . " LEFT JOIN ms_car_type ON msc_ctyid = ctyid"
                . " LEFT JOIN ms_car_model ON cty_modelid = modelid"
                . " LEFT JOIN ms_car_merk ON model_merkid = merkid"
                . " LEFT JOIN ms_supplier ON supid = bpk_supid"
                . " LEFT JOIN ms_warna ON warnaid = msc_warnaid"
                . " WHERE rtb_cbid = '$cabang' AND rtb_tgl BETWEEN '$start' AND '$end' ORDER BY rtbid");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }

    /**
     * 
     * @param Date $start
     * @param Date $end
     * @param String $cabang
     * @return null
     */
    function getSpk($start, $end, $cabang) {
        $sql = $this->db->query("SELECT spk_no,spk_nokontrak,spk_tgl,kr_nama,pel_nama,"
                . " pel_alamat,kota_deskripsi,pel_telpon,pel_hp,merk_deskripsi,model_deskripsi,"
                . " cty_deskripsi,fpt_harga_method,fpt_qty,fpt_hargako,fpt_bbn,fpt_accesories,"
                . " fpt_karoseri,fpt_administrasi,fpt_cashback,fpt_diskon,fpt_total FROM pen_spk "
                . " LEFT JOIN pen_fpt ON fptid = spk_fptid"
                . " LEFT JOIN ms_car_type ON fpt_ctyid = ctyid"
                . " LEFT JOIN ms_car_model ON cty_modelid = modelid"
                . " LEFT JOIN ms_car_merk ON model_merkid = merkid"
                . " LEFT JOIN ms_pelanggan ON pelid = spk_pelid"
                . " LEFT JOIN ms_karyawan ON krid = spk_salesman"
                . " LEFT JOIN ms_kota ON pel_kotaid = kotaid"
                . " WHERE spk_cbid = '$cabang' AND spk_tgl BETWEEN '$start' AND '$end' ORDER BY spkid");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }

    /**
     * 
     * @param Date $start
     * @param Date $end
     * @param String $cabang
     * @return null
     */
    function getFakturPenjualan($start, $end, $cabang) {
        $sql = $this->db->query("SELECT fkp_keterangan,leas_nama,warna_deskripsi,fkp_nofaktur,fkp_tgl,pen_faktur_payment.*, spk_no,spk_nokontrak,spk_tgl,kr_nama,pel_nama,"
                . " pel_alamat,kota_deskripsi,pel_telpon,pel_hp,merk_deskripsi,model_deskripsi,"
                . " cty_deskripsi, msc_tahun"
                . " FROM pen_faktur "
                . " LEFT JOIN pen_faktur_payment ON fkpid = byr_fkpid"
                . " LEFT JOIN pen_spk ON spkid = fkp_spkid"
                . " LEFT JOIN pen_fpk ON fpkid = fkp_fpkid"
                . " LEFT JOIN ms_leasing ON leasid = fpk_leasid"
                . " LEFT JOIN ms_car ON fkp_mscid = mscid"
                . " LEFT JOIN ms_car_type ON msc_ctyid = ctyid"
                . " LEFT JOIN ms_car_model ON cty_modelid = modelid"
                . " LEFT JOIN ms_car_merk ON model_merkid = merkid"
                . " LEFT JOIN ms_pelanggan ON pelid = spk_pelid"
                . " LEFT JOIN ms_karyawan ON krid = spk_salesman"
                . " LEFT JOIN ms_kota ON pel_kotaid = kotaid"
                . " LEFT JOIN ms_warna ON warnaid = msc_warnaid"
                . " WHERE fkp_cbid = '$cabang' AND fkp_tgl BETWEEN '$start' AND '$end' ORDER BY fkpid");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }

    function getPenjualanPerSales($tahun, $cabang) {
        $data = array();
        $sql = $this->db->query("SELECT spk_salesman,COUNT(fkpid) AS jumlah, DATE_PART('month', fkp_tgl) AS bulan, kr_nama,"
                . "(SELECT kr_nama AS supervisor FROM ms_karyawan WHERE krid = a.kr_atasan) "
                . " FROM pen_faktur "
                . " LEFT JOIN pen_spk ON spkid = fkp_spkid"
                . " LEFT JOIN ms_karyawan a ON a.krid = spk_salesman"
                . " WHERE fkp_cbid = '$cabang' AND date_part('year', fkp_tgl) = '$tahun' GROUP BY spk_salesman,supervisor,bulan,kr_nama ORDER BY supervisor,kr_nama,bulan");
        if ($sql->num_rows() > 0) {
            foreach ($sql->result_array() as $value) {
                if (array_key_exists($value['spk_salesman'], $data)) {
                    $key = $data[$value['spk_salesman']];
                    $key[$value['bulan']] = $value['jumlah'];
                    $data[$value['spk_salesman']] = $key;
                } else {
                    $data[$value['spk_salesman']] = array(
                        'supervisor' => $value['supervisor'],
                        'salesman' => $value['kr_nama'],
                        $value['bulan'] => $value['jumlah'],
                    );
                }
            }
        }
        return $data;
    }

    /**
     * 
     * @param Integer $tahun
     * @param integer $bulan
     * @param String $cabang
     * @return type
     */
    function getProduktifitasSales($tahun, $bulan, $cabang) {
        $data = array();
        $sql = $this->db->query("SELECT spk_salesman,COUNT(fkpid) AS jumlah, modelid, kr_nama,"
                . "(SELECT kr_nama AS supervisor FROM ms_karyawan WHERE krid = a.kr_atasan) "
                . " FROM pen_faktur "
                . " LEFT JOIN pen_spk ON spkid = fkp_spkid"
                . " LEFT JOIN ms_karyawan a ON a.krid = spk_salesman"
                . " LEFT JOIN ms_car ON mscid = fkp_mscid"
                . " LEFT JOIN ms_car_type ON msc_ctyid = ctyid"
                . " LEFT JOIN ms_car_model ON cty_modelid = modelid"
                . " WHERE fkp_cbid = '$cabang' AND date_part('year', fkp_tgl) = '$tahun' "
                . " AND date_part('month', fkp_tgl) = '$bulan' GROUP BY spk_salesman,"
                . " supervisor,modelid,kr_nama ORDER BY supervisor,kr_nama,modelid");
        log_message('error', 'FFFFFF '.$this->db->last_query());
        if ($sql->num_rows() > 0) {
            foreach ($sql->result_array() as $value) {
                if (array_key_exists($value['spk_salesman'], $data)) {
                    $key = $data[$value['spk_salesman']];
                    $key[$value['modelid']] = $value['jumlah'];
                    $data[$value['spk_salesman']] = $key;
                } else {
                    $data[$value['spk_salesman']] = array(
                        'supervisor' => $value['supervisor'],
                        'salesman' => $value['kr_nama'],
                        $value['modelid'] => $value['jumlah'],
                    );
                }
            }
        }
        return $data;
    }

    /**
     * 
     * @param Date $start
     * @param Date $end
     * @param String $cabang
     * @return null
     */
    function getReturJual($start, $end, $cabang) {
        $sql = $this->db->query("SELECT * FROM pen_retjual LEFT JOIN pen_faktur ON rtj_fkpid = fkpid "
                . " LEFT JOIN pen_spk ON spkid = fkp_spkid"
                . " LEFT JOIN pen_fpk ON fpkid = fkp_fpkid"
                . " LEFT JOIN ms_leasing ON leasid = fpk_leasid"
                . " LEFT JOIN ms_car ON fkp_mscid = mscid"
                . " LEFT JOIN ms_car_type ON msc_ctyid = ctyid"
                . " LEFT JOIN ms_car_model ON cty_modelid = modelid"
                . " LEFT JOIN ms_car_merk ON model_merkid = merkid"
                . " LEFT JOIN ms_pelanggan ON pelid = spk_pelid"
                . " LEFT JOIN ms_karyawan ON krid = spk_salesman"
                . " LEFT JOIN ms_kota ON pel_kotaid = kotaid"
                . " LEFT JOIN ms_warna ON warnaid = msc_warnaid"
                . " WHERE rtj_cbid = '$cabang' AND rtj_tgl BETWEEN '$start' AND '$end' ORDER BY rtjid");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }

}

?>
