<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Model_Lap_Sparepart extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 
     * @param type $start
     * @param type $end
     * @param type $cabang
     * @return null
     */
    function getPenerimaanBarang($start, $end, $cabang) {
        $query = $this->db->query("SELECT trbr_faktur, trbrid,trbr_tgl,sup_nama,trbr_total FROM spa_trbr LEFT JOIN ms_supplier ON trbr_supid = supid WHERE trbr_tgl BETWEEN '$start'"
                . " AND '$end' AND trbr_cbid = '$cabang' ORDER BY trbrid");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return null;
    }

    /**
     * 
     * @param type $start
     * @param type $end
     * @param type $cabang
     * @return null
     */
    function getAdjustmentStock($start, $end, $cabang) {
        $query = $this->db->query("SELECT * FROM spa_adjustment LEFT JOIN spa_adjustment_det"
                . " ON adjid = dadj_adjid LEFT JOIN spa_inventory ON inveid = dadj_inveid WHERE adj_tgl BETWEEN '$start'"
                . " AND '$end' AND adj_cbid = '$cabang' ORDER BY adjid");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return null;
    }

    /**
     * 
     * @param type $start
     * @param type $end
     * @param type $cabang
     * @return null
     */
    function getTotalAdjustmentStock($start, $end, $cabang) {
        $query = $this->db->query("SELECT SUM(dadj_subtotal_hpp) AS sub_total FROM spa_adjustment LEFT JOIN spa_adjustment_det"
                . " ON adjid = dadj_adjid WHERE adj_tgl BETWEEN '$start'"
                . " AND '$end' AND adj_cbid = '$cabang'");
        if ($query->num_rows() > 0) {
            return $query->row()->sub_total;
        }
        return null;
    }

    function getMovingPart($start, $end, $cabang) {
        $hasil['fast'] = 0;
        $hasil['slow'] = 0;
        $hasil['dead'] = 0;
        $posisi = array();
        $inveid = array();

        $start4 = date("Y-m-01", mktime(0, 0, 0, date("m", strtotime($end)) - 4, date("d", strtotime($end)), date("Y", strtotime($end))));

        $posisiStock = $this->getPosisiStock($end, $cabang, '', '');
        log_message('error', 'AAAAAA ' . $this->db->last_query());
        if (count($posisiStock) > 0) {
            foreach ($posisiStock as $value) {
                $posisi[$value['inveid']] = $value['ks_saldo'];
            }
        }

        // DEAD
        $startDead = date("Y-m-01", mktime(0, 0, 0, date("m", strtotime($end)), date("d", strtotime($end)), date("Y", strtotime($end)) - 2));
        $dead = $this->db->query("SELECT inveid FROM"
                . " spa_inventory  WHERE inveid NOT IN(SELECT dsupp_inveid"
                . " FROM spa_supply_det LEFT JOIN spa_supply ON dsupp_sppid = sppid "
                . " WHERE spp_cbid = '$cabang'"
                . " AND spp_tgl BETWEEN '$startDead' AND '$end') AND inve_cbid = '$cabang'");
        if ($dead->num_rows() > 0) {
            foreach ($dead->result_array() as $val) {
                $inveid[$val['inveid']] = 1;
                if (!empty($posisi[$val['inveid']])) {
                    $hasil['dead'] += $posisi[$val['inveid']];
                }
            }
        }

        // FAST
        $fast = $this->db->query("SELECT dsupp_inveid FROM spa_supply_det LEFT "
                . " JOIN spa_supply ON dsupp_sppid = sppid WHERE spp_tgl "
                . " BETWEEN '$start4' AND '$end' AND spp_cbid = '$cabang' GROUP BY spp_cbid,dsupp_inveid"
                . " HAVING COUNT (dsupp_inveid) > 2");
        if ($fast->num_rows() > 0) {
            foreach ($fast->result_array() as $val) {
                $inveid[$val['dsupp_inveid']] = 1;
                if (!empty($posisi[$val['dsupp_inveid']])) {
                    $hasil['fast'] += $posisi[$val['dsupp_inveid']];
                }
            }
        }

        // SLOW
        if (count($posisiStock) > 0) {
            foreach ($posisiStock as $value) {
                if (!array_key_exists($value['inveid'], $inveid)) {
                    $hasil['slow'] += $value['ks_saldo'];
                }
            }
        }
        return $hasil;
    }

    function getMovingPart2($start, $end, $cabang) {
        $data['very'] = 0;
        $data['fast'] = 0;
        $data['medium'] = 0;
        $data['slow'] = 0;
        $data['no'] = 0;
        $data['dead'] = 0;
        $data['scrap'] = 0;
        $sqlAwal = $this->db->query(" 
                    SELECT 
                    ks_inveid, SUM(ks_out) as total, DATE_PART('day', '$end'- MIN(ks_tgl)) AS tgl
                    FROM 
                    spa_kartu_stock 
                    WHERE 
                    DATE(ks_tgl) <= '$end' AND ks_type = 'SP' AND ks_cbid = '$cabang'
                    GROUP BY ks_inveid, ks_cbid
                  ");
        $dataawal = array();
        if ($sqlAwal->num_rows() > 0) {
            foreach ($sqlAwal->result_array() as $val) {
                $dataawal[$val['ks_inveid']] = $val['tgl'] / $val['total'];
            }
        }

        $posisiStock = $this->getPosisiStock($end, $cabang, '', '');
        $total = 0;
        if (count($posisiStock) > 0) {
            foreach ($posisiStock as $value) {
                if (!empty($dataawal[$value['inveid']])) {
                    if (($dataawal[$value['inveid']] <= 3) && ($dataawal[$value['inveid']] > 0 )) {
                        $data['very'] += $value['ks_saldo'];
                    } elseif (($dataawal[$value['inveid']] > 3) && ($dataawal[$value['inveid']] <= 10)) {
                        $data['fast'] += $value['ks_saldo'];
                    } elseif (($dataawal[$value['inveid']] > 10) && ($dataawal[$value['inveid']] <= 15)) {
                        $data['medium'] += $value['ks_saldo'];
                    } elseif (($dataawal[$value['inveid']] > 15) && ($dataawal[$value['inveid']] <= 30)) {
                        $data['slow'] += $value['ks_saldo'];
                    } elseif (($dataawal[$value['inveid']] > 30) && ($dataawal[$value['inveid']] <= 180)) {
                        $data['no'] += $value['ks_saldo'];
                    } elseif (($dataawal[$value['inveid']] > 180) && ($dataawal[$value['inveid']] <= 365)) {
                        $data['dead'] += $value['ks_saldo'];
                    } else {
                        $data['scrap'] += $value['ks_saldo'];
                    }
                } else {
                    $data['scrap'] += $value['ks_saldo'];
                }
            }
        }
        return $data;
    }

    function getDetailKomposisiStock($start, $end, $cabang, $type) {
        $sqlAwal = $this->db->query(" 
                    SELECT 
                    ks_inveid, SUM(ks_out) as total, DATE_PART('day', '$end'-MIN(ks_tgl)) AS tgl
                    FROM 
                    spa_kartu_stock 
                    WHERE 
                    DATE(ks_tgl) <= '$end' AND ks_type = 'SP' AND ks_cbid = '$cabang'
                    GROUP BY ks_inveid, ks_cbid
                  ");
        log_message('error', 'AAAAAAA ' . $this->db->last_query());
        $dataawal = array();
        if ($sqlAwal->num_rows() > 0) {
            foreach ($sqlAwal->result_array() as $val) {
                $dataawal[$val['ks_inveid']] = $val['tgl'] / $val['total'];
            }
        }
        $posisiStock = $this->getPosisiStock($end, $cabang, '', '');
        $arr = array();
        if (count($posisiStock) > 0) {
            foreach ($posisiStock as $val) {
                if (!empty($dataawal[$val['inveid']])) {
                    if ($type == 'very') {
                        if (($dataawal[$val['inveid']] <= 3) && $dataawal[$val['inveid']] > 0) {
                            $arr[] = array(
                                'dsupp_qty' => $val['ks_total'],
                                'dsupp_hpp' => $val['ks_hpp'],
                                'dsupp_harga' => $val['ks_harga'],
                                'dsupp_name' => $val['inve_nama'],
                                'dsupp_msbcode' => $val['inve_kode'],
                            );
                        }
                    } elseif ($type == 'fast') {
                        if (($dataawal[$val['inveid']] > 3) && ($dataawal[$val['inveid']] <= 10)) {
                            $arr[] = array(
                                'dsupp_qty' => $val['ks_total'],
                                'dsupp_hpp' => $val['ks_hpp'],
                                'dsupp_harga' => $val['ks_harga'],
                                'dsupp_name' => $val['inve_nama'],
                                'dsupp_msbcode' => $val['inve_kode'],
                            );
                        }
                    } elseif ($type == 'medium') {
                        if (($dataawal[$val['inveid']] > 10) && ($dataawal[$val['inveid']] <= 15)) {
                            $arr[] = array(
                                'dsupp_qty' => $val['ks_total'],
                                'dsupp_hpp' => $val['ks_hpp'],
                                'dsupp_harga' => $val['ks_harga'],
                                'dsupp_name' => $val['inve_nama'],
                                'dsupp_msbcode' => $val['inve_kode'],
                            );
                        }
                    } elseif ($type == 'slow') {
                        if (($dataawal[$val['inveid']] > 15) && ($dataawal[$val['inveid']] <= 30)) {
                            $arr[] = array(
                                'dsupp_qty' => $val['ks_total'],
                                'dsupp_hpp' => $val['ks_hpp'],
                                'dsupp_harga' => $val['ks_harga'],
                                'dsupp_name' => $val['inve_nama'],
                                'dsupp_msbcode' => $val['inve_kode'],
                            );
                        }
                    } elseif ($type == 'no') {
                        if (($dataawal[$val['inveid']] > 30) && ($dataawal[$val['inveid']] <= 180)) {
                            $arr[] = array(
                                'dsupp_qty' => $val['ks_total'],
                                'dsupp_hpp' => $val['ks_hpp'],
                                'dsupp_harga' => $val['ks_harga'],
                                'dsupp_name' => $val['inve_nama'],
                                'dsupp_msbcode' => $val['inve_kode'],
                            );
                        }
                    } elseif ($type == 'dead') {
                        if (($dataawal[$val['inveid']] > 180) && ($dataawal[$val['inveid']] <= 365)) {
                            $arr[] = array(
                                'dsupp_qty' => $val['ks_total'],
                                'dsupp_hpp' => $val['ks_hpp'],
                                'dsupp_harga' => $val['ks_harga'],
                                'dsupp_name' => $val['inve_nama'],
                                'dsupp_msbcode' => $val['inve_kode'],
                            );
                        }
                    } else {
                        if (($dataawal[$val['inveid']] > 365 ) || $dataawal[$val['inveid']] == 0) {
                            $arr[] = array(
                                'dsupp_qty' => $val['ks_total'],
                                'dsupp_hpp' => $val['ks_hpp'],
                                'dsupp_harga' => $val['ks_harga'],
                                'dsupp_name' => $val['inve_nama'],
                                'dsupp_msbcode' => $val['inve_kode'],
                            );
                        }
                    }
                } else if ($type == 'scrap') {
                    $arr[] = array(
                        'dsupp_qty' => $val['ks_total'],
                        'dsupp_hpp' => $val['ks_hpp'],
                        'dsupp_harga' => $val['ks_harga'],
                        'dsupp_name' => $val['inve_nama'],
                        'dsupp_msbcode' => $val['inve_kode'],
                    );
                }
                log_message('error', 'MASUK ' . $val['inve_nama']);
            }
        }
        return $arr;
    }

    /**
     * 
     * @param type $start
     * @param type $end
     * @param type $cabang
     * @param type $kodeBarang
     * @return null
     */
    function getPembelianBySparepart($start, $end, $cabang, $kodeBarang) {
        $wh = "";
        if (!empty($kodeBarang)) {
            $wh = " AND inve_kode = '$kodeBarang'";
        }
        $query = $this->db->query("SELECT trbr_faktur, trbrid,trbr_tgl,sup_nama,inve_kode,"
                . " inve_nama, dtr_qty,dtr_harga,dtr_diskon,dtr_subtotal FROM spa_trbr"
                . " LEFT JOIN spa_trbr_det ON dtr_trbrid = trbrid LEFT JOIN spa_inventory"
                . " ON inveid = dtr_inveid LEFT JOIN ms_supplier ON trbr_supid = supid WHERE trbr_tgl BETWEEN '$start'"
                . " AND '$end' AND trbr_cbid = '$cabang' $wh ORDER BY inve_kode");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return null;
    }

    /**
     * 
     * @param type $start
     * @param type $end
     * @param type $cabang
     * @param type $kodeBarang
     * @return null
     */
    function getPembelianBySparepartTotal($start, $end, $cabang, $kodeBarang) {
        $wh = "";
        if (!empty($kodeBarang)) {
            $wh = " AND inve_kode = '$kodeBarang'";
        }
        $query = $this->db->query("SELECT inve_kode,"
                . " inve_nama, SUM(dtr_qty) AS dtr_qty,SUM(dtr_subtotal) AS dtr_subtotal, MAX(trbr_tgl) AS trbr_tgl FROM spa_trbr"
                . " LEFT JOIN spa_trbr_det ON dtr_trbrid = trbrid LEFT JOIN spa_inventory"
                . " ON inveid = dtr_inveid LEFT JOIN ms_supplier ON trbr_supid = supid WHERE trbr_tgl BETWEEN '$start'"
                . " AND '$end' AND trbr_cbid = '$cabang' $wh GROUP BY inve_kode, inve_nama ORDER BY inve_kode");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return null;
    }

    /**
     * 
     * @param type $start
     * @param type $end
     * @param type $cabang
     * @return null
     */
    function getTotalPembelian($start, $end, $cabang) {
        $query = $this->db->query("SELECT SUM(trbr_total/1.1) AS trbr_total FROM spa_trbr WHERE trbr_tgl BETWEEN '$start'"
                . " AND '$end' AND trbr_cbid = '$cabang'");
        if ($query->num_rows() > 0) {
            return $query->row()->trbr_total;
        }
        return null;
    }

    function getFakturSparepart($start, $end, $cabang) {
        $query = $this->db->query("SELECT not_nomer, spp_noslip, pel_nama,not_total,not_tgl,not_numerator "
                . "FROM spa_nota LEFT JOIN spa_supply ON sppid = not_sppid LEFT JOIN"
                . " ms_pelanggan ON pelid = spp_pelid WHERE not_tgl BETWEEN '$start'"
                . " AND '$end' AND not_cbid = '$cabang' AND not_status = 0 ORDER BY not_nomer");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return null;
    }

    /**
     * 
     * @param type $start
     * @param type $end
     * @param type $cabang
     * @return null
     */
    function getTotalPenjualanSupply($start, $end, $cabang) {
        $sql = $this->db->query("SELECT SUM(jual) AS jual, spp_cbid"
                . " FROM(SELECT SUM(spp_total_hpp) AS jual,spp_cbid"
                . "  FROM (SELECT SUM(spp_total_hpp) AS spp_total_hpp,spp_cbid FROM spa_supply "
                . "  WHERE spp_jenis != 'so' AND spp_status = 0 AND spp_tgl BETWEEN '$start' AND '$end' AND spp_cbid = '$cabang' GROUP BY spp_cbid) AS sub1 "
                . " GROUP BY spp_cbid UNION"
                . " SELECT SUM(spp_total_hpp) * (-1) AS jual,spp_cbid"
                . "  FROM (SELECT SUM(spp_total_hpp) AS spp_total_hpp,spp_cbid FROM spa_supply"
                . "  WHERE spp_jenis != 'so' AND spp_status = '1' AND DATE(spp_tgl_batal)  BETWEEN '$start' AND '$end'  AND spp_cbid = '$cabang' GROUP BY spp_cbid) AS sub2 "
                . " GROUP BY spp_cbid)AS sub2  GROUP BY spp_cbid");
        if ($sql->num_rows() > 0) {
            return $sql->row()->jual;
        }
        return null;
    }

    function getFakturByPelanggan($start, $end, $cabang, $pelid) {
        $wh = '';
        if (!empty($pelid)) {
            $wh = " AND spp_pelid = '$pelid'";
        }
        $query = $this->db->query("SELECT not_nomer, spp_noslip, pel_nama,pel_alamat,not_total,not_tgl,not_numerator "
                . "FROM spa_nota LEFT JOIN spa_supply ON sppid = not_sppid LEFT JOIN"
                . " ms_pelanggan ON pelid = spp_pelid WHERE not_tgl BETWEEN '$start'"
                . " AND '$end' AND not_cbid = '$cabang' AND not_status = 0 $wh ORDER BY pel_nama,not_tgl");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return null;
    }

    function getFakturBySparepart($start, $end, $cabang, $kodeBarang) {
        $wh = '';
        if (!empty($kodeBarang)) {
            $wh = " AND inve_kode = '$kodeBarang'";
        }
        $query = $this->db->query("SELECT not_nomer, spp_noslip, pel_nama,pel_alamat,not_total,"
                . "not_tgl, inve_kode, inve_nama, dsupp_qty, dsupp_harga, dsupp_diskon,"
                . " dsupp_subtotal, dsupp_hpp, dsupp_subtotal_hpp "
                . " FROM spa_nota LEFT JOIN spa_supply ON sppid = not_sppid LEFT JOIN"
                . " ms_pelanggan ON pelid = spp_pelid LEFT JOIN spa_supply_det ON dsupp_sppid = "
                . "sppid LEFT JOIN spa_inventory ON inveid = dsupp_inveid WHERE not_tgl BETWEEN '$start'"
                . " AND '$end' AND not_cbid = '$cabang' AND not_status = 0 $wh ORDER BY inve_kode,not_tgl");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return null;
    }

    function getFakturBySparepartTotal($start, $end, $cabang, $kodeBarang) {
        $wh = '';
        if (!empty($kodeBarang)) {
            $wh = " AND inve_kode = '$kodeBarang'";
        }
        $query = $this->db->query("SELECT MAX(not_tgl) not_tgl,SUM(dsupp_qty) AS dsupp_qty, inve_kode,"
                . " inve_nama, SUM(dsupp_subtotal) AS dsupp_subtotal, SUM(dsupp_subtotal_hpp) AS dsupp_subtotal_hpp"
                . " FROM spa_nota LEFT JOIN spa_supply ON sppid = not_sppid LEFT JOIN"
                . " ms_pelanggan ON pelid = spp_pelid LEFT JOIN spa_supply_det ON dsupp_sppid = "
                . "sppid LEFT JOIN spa_inventory ON inveid = dsupp_inveid WHERE not_tgl BETWEEN '$start'"
                . " AND '$end' AND not_cbid = '$cabang' AND not_status = 0 $wh GROUP BY inve_kode,inve_nama ORDER BY inve_kode");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return null;
    }

    function getFakturByPelangganTotal($start, $end, $cabang, $pelid) {
        $wh = '';
        if (!empty($pelid)) {
            $wh = " AND spp_pelid = '$pelid'";
        }
        $query = $this->db->query("SELECT pel_nama,SUM(not_total) AS not_total,MAX(not_tgl) AS not_tgl,pel_alamat "
                . "FROM spa_nota LEFT JOIN spa_supply ON sppid = not_sppid LEFT JOIN"
                . " ms_pelanggan ON pelid = spp_pelid WHERE not_tgl BETWEEN '$start'"
                . " AND '$end' AND not_cbid = '$cabang' AND not_status = 0 $wh GROUP BY pel_nama,pel_alamat ORDER BY pel_nama");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return null;
    }

    /**
     * 
     * @param type $start
     * @param type $end
     * @param type $cabang
     * @return null
     */
    function getReturPembelian($start, $end, $cabang) {
        $query = $this->db->query("SELECT rbid,rb_total,rb_total,rb_tgl,trbr_faktur, trbrid,sup_nama,rb_alasan FROM spa_retbeli LEFT JOIN spa_trbr ON rb_trbrid = trbrid"
                . " LEFT JOIN ms_supplier ON trbr_supid = supid WHERE rb_tgl BETWEEN '$start'"
                . " AND '$end' AND rb_cbid = '$cabang' ORDER BY rbid");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return null;
    }

    function getTotalReturPembelian($start, $end, $cabang) {
        $query = $this->db->query("SELECT SUM(rb_total/1.1) AS rb_total FROM spa_retbeli WHERE rb_tgl BETWEEN '$start'"
                . " AND '$end' AND rb_cbid = '$cabang'");
        if ($query->num_rows() > 0) {
            return $query->row()->rb_total;
        }
        return 0;
    }

    /**
     * 
     * @param type $start
     * @param type $end
     * @param type $cabang
     * @return null
     */
    function getReturPenjualan($start, $end, $cabang) {
        $query = $this->db->query("SELECT rjid,rj_total,rj_tgl,not_nomer, notid,pel_nama,rj_alasan FROM spa_retjual LEFT JOIN spa_nota ON rj_notid = notid"
                . " LEFT JOIN spa_supply ON sppid = not_sppid LEFT JOIN ms_pelanggan ON pelid = sppid WHERE rj_tgl BETWEEN '$start'"
                . " AND '$end' AND rj_cbid = '$cabang' ORDER BY rjid");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return null;
    }

    /**
     * Get Total Hpp Retur penjualan
     * @param type $start
     * @param type $end
     * @param type $cabang
     * @return null
     */
    function getTotalReturPenjualan($start, $end, $cabang) {
        $query = $this->db->query("SELECT SUM(rj_total_hpp) AS rj_total_hpp FROM spa_retjual WHERE rj_tgl BETWEEN '$start'"
                . " AND '$end' AND rj_cbid = '$cabang'");
        if ($query->num_rows() > 0) {
            return $query->row()->rj_total_hpp;
        }
        return 0;
    }

    /**
     * 
     * @param type $start
     * @param type $end
     * @param type $cabang
     * @param type $status
     * @return null
     */
    function getSupplySlipRekap($start, $end, $cabang, $jenis) {
        $wh = '';
        if ($jenis != 'all') {
            $wh = " AND spp_jenis = '$jenis'";
        }
        $query = $this->db->query("SELECT spp_total,spp_total_hpp,spp_noslip, pel_nama,spp_tgl, spp_pay_method "
                . "FROM spa_supply LEFT JOIN ms_pelanggan ON pelid = spp_pelid WHERE spp_tgl BETWEEN '$start'"
                . " AND '$end' AND spp_cbid = '$cabang' $wh AND spp_status = 0 ORDER BY spp_noslip");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return null;
    }

    function getSupplySlipDetail($start, $end, $cabang, $jenis) {
        $wh = '';
        if ($jenis != 'all') {
            $wh = " AND spp_jenis = '$jenis'";
        }
        $query = $this->db->query("SELECT inve_kode, inve_nama, dsupp_qty, dsupp_harga,"
                . " dsupp_diskon, dsupp_subtotal,dsupp_subtotal_hpp, dsupp_hpp,spp_noslip, pel_nama,spp_tgl, spp_pay_method "
                . " FROM spa_supply_det LEFT JOIN spa_inventory ON inveid = dsupp_inveid LEFT JOIN spa_supply ON dsupp_sppid = sppid"
                . " LEFT JOIN ms_pelanggan ON pelid = spp_pelid WHERE spp_tgl BETWEEN '$start'"
                . " AND '$end' AND spp_cbid = '$cabang' $wh AND spp_status = 0 ORDER BY spp_noslip");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return null;
    }

    /**
     * 
     * @param type $start
     * @param type $end
     * @param type $cabang
     * @return null
     */
    function getKartuStock($start, $end, $cabang, $kodeBarang) {
        $query = $this->db->query("(SELECT ksid, 'SA' AS ks_type,NULL AS ks_tgl,'' AS transaksi,"
                . " '' AS nama,ks_hpp,0 AS ks_in,0 AS ks_out,ks_total,0 AS ks_debit,0 AS ks_kredit,ks_saldo,"
                . " inve_kode FROM spa_kartu_stock LEFT JOIN suppel ON kode = ks_suppel"
                . " LEFT JOIN no_transaksi ON ks_notrans = kode_trans LEFT JOIN spa_inventory ON inveid = ks_inveid WHERE ks_cbid"
                . " = '$cabang' AND DATE(ks_tgl) < '$start' AND inve_kode = '$kodeBarang' ORDER BY ksid DESC LIMIT 1) UNION"
                . " SELECT ksid, ks_type,ks_tgl,transaksi,nama,ks_hpp,ks_in,ks_out,ks_total,"
                . " ks_debit,ks_kredit,ks_saldo, inve_kode FROM spa_kartu_stock LEFT JOIN suppel ON kode = ks_suppel"
                . " LEFT JOIN no_transaksi ON ks_notrans = kode_trans LEFT JOIN spa_inventory ON inveid = ks_inveid WHERE ks_cbid"
                . " = '$cabang' AND DATE(ks_tgl) BETWEEN '$start' AND '$end' AND inve_kode = '$kodeBarang' ORDER BY ksid");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return null;
    }

    /**
     * 
     * @param type $start
     * @param type $end
     * @param type $cabang
     * @return null
     */
    function getPosisiStock($date, $cabang, $kodeBarang, $type) {
        $wh = '';
        if (!empty($kodeBarang)) {
            $wh = " AND inve_kode = '$kodeBarang'";
        }
        if (!empty($type)) {
            $wh .= " AND inve_jenis = '$type'";
        }
        $query = $this->db->query("SELECT inveid,inve_kode,inve_nama,ks_total,ks_hpp,inve_harga,ks_saldo,ks_harga FROM spa_kartu_stock RIGHT JOIN(select MAX(ksid)"
                . " AS ksid, ks_inveid FROM spa_kartu_stock LEFT JOIN spa_inventory"
                . " ON inveid = ks_inveid WHERE DATE(ks_tgl) <= '$date'"
                . " AND ks_cbid = '$cabang' $wh GROUP BY ks_inveid) AS "
                . " s2 ON s2.ksid = spa_kartu_stock.ksid AND s2.ks_inveid = spa_kartu_stock.ks_inveid"
                . " LEFT JOIN spa_inventory ON inveid = spa_kartu_stock.ks_inveid ORDER BY inve_kode");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return null;
    }

    function getSupplyOutstanding($date, $cabang, $type) {
        $wh = '';
        if (!empty($type)) {
            $wh .= " AND spp_jenis = '$type'";
        }
        $query = $this->db->query("SELECT spp_noslip,spp_tgl,pel_nama,wo_nomer,spp_total,spp_total_hpp FROM spa_supply "
                . " LEFT JOIN ms_pelanggan ON spp_pelid = pelid "
                . " LEFT JOIN svc_wo ON woid = spp_woid WHERE spp_tgl <= '$date'"
                . " AND spp_cbid = '$cabang' AND DATE(spp_tgl_tagihan) > '$date' $wh ORDER BY sppid");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return null;
    }

    /**
     * 
     * @param type $date
     * @param type $cabang
     * @param type $kodeBarang
     * @param type $type
     * @return int
     */
    function getRekapPosisiStock($date, $cabang, $kodeBarang, $type) {
        $wh = '';
        if (!empty($kodeBarang)) {
            $wh = " AND inve_kode = '$kodeBarang'";
        }
        if (!empty($type)) {
            $wh .= " AND inve_jenis = '$type'";
        }
        $query = $this->db->query("SELECT SUM(ks_saldo) AS ks_saldo FROM spa_kartu_stock RIGHT JOIN(select MAX(ksid)"
                . " AS ksid, ks_inveid FROM spa_kartu_stock LEFT JOIN spa_inventory"
                . " ON inveid = ks_inveid WHERE DATE(ks_tgl) <= '$date'"
                . " AND ks_cbid = '$cabang' $wh GROUP BY ks_inveid) AS "
                . " s2 ON s2.ksid = spa_kartu_stock.ksid AND s2.ks_inveid = spa_kartu_stock.ks_inveid"
                . " LEFT JOIN spa_inventory ON inveid = spa_kartu_stock.ks_inveid");
//        log_message('error', 'AAAAAA ' . $this->db->last_query());
        if ($query->num_rows() > 0) {
            return $query->row()->ks_saldo;
        }
        return 0;
    }

}

?>
