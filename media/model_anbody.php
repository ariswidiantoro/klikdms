<?php
if( !defined('BASEPATH')) exit('No direct script access allowed');
class Model_anbody extends CI_Model {
    
    private $tab_dttr       = 'brp_dttr';
    private $tab_set_mip    = 'set_mip';
    private $tab_trbr       = 'brp_trbr';
    private $tab_msbrg      = 'brp_msbarang';
    private $tab_brg        = 'spa_barang';
    private $cbid;
    
    public function __construct(){
        parent::__construct();
        $this->cbid = ses_cabang;
    }
    
    public function getMAD($bln, $thn){
        $a = mktime(0, 0, 0, $bln-4, 1, $thn);
        //$b = mktime(0, 0, 0, $bln, date("d"), date("Y"));
        $old  = date("Y-m-d", $a);
        //$now  = date("Y-m-d", $b);
        $this->db->select("brg_kode,brg_nama, (SUM(dsupp_qty)/4) as total");
        $this->db->from("svc_supply");
        $this->db->join("svc_dsupp","sppid=dsupp_noslip");
        $this->db->join($this->tab_msbrg,"dsupp_msbcode=msb_code");
        $this->db->join($this->tab_brg,"msb_code=brg_kode");
        $this->db->where("spp_tgl >=",$old);
        $this->db->group_by("brg_kode, EXTRACT(MONTH FROM spp_tgl)");
        $sql = $this->db->get();
        if($sql->num_rows()>0){
            return $sql->result();
        }
        return array();
    }

    public function mip($date, $cbid, $tipe){
        list($thn, $bln, $day) = explode('-', $date);
        $a = mktime(0, 0, 0, $bln-1, 1, $thn);
        $b = mktime(0, 0, 0, $bln-2, 1, $thn);
        $c = mktime(0, 0, 0, $bln-3, 1, $thn);
        $d = mktime(0, 0, 0, $bln-4, 1, $thn);
        $back = array();
        $sql = "select 
                brg_kode, brg_nama, mip_lt, mip_hk, mip_oc,
                (select ks_total from brp_kartu_stock where ks_cbid = '$cbid' AND ks_msbcode=brg_kode AND date(ks_tgl) <= '$date' ORDER BY ks_tgl DESC limit 1 ) as total
                from
                brp_kartu_stock JOIN spa_barang ON ks_msbcode=brg_kode 
                JOIN brp_msbarang ON ks_msbcode=msb_code   
                LEFT JOIN set_mip ON ks_cbid=mip_cbid AND mip_month='$bln' AND mip_year='$thn'           
                where 
                msb_cbid=ks_cbid AND msb_cbid = '$cbid' AND brg_tipe like '$tipe%' AND date(ks_tgl) <= '$date' 
                group by brg_kode, brg_nama, mip_lt, mip_hk, mip_oc order by brg_kode";
        $get = $this->db->query($sql);
        if($get->num_rows() > 0){
            foreach ($get->result() as $value) {
                $aa = $this->system->maxKartuService($value->brg_kode, $cbid, date("Y-m-01", $a), date("Y-m-t", $a));
                $bb = $this->system->maxKartuService($value->brg_kode, $cbid, date("Y-m-01", $b), date("Y-m-t", $b));
                $cc = $this->system->maxKartuService($value->brg_kode, $cbid, date("Y-m-01", $c), date("Y-m-t", $c));
                $dd = $this->system->maxKartuService($value->brg_kode, $cbid, date("Y-m-01", $d), date("Y-m-t", $d));
                $MAD   = ($aa['total'] + $bb['total'] + $cc['total'] + $dd['total']) / 4;
                $MAX   = max($aa['total'], $bb['total'], $cc['total'], $dd['total']);
                $maxHK = $aa['hk'] + $bb['hk'] + $cc['hk'] + $dd['hk'];
                if($MAD > 0) {
                $SSD   = ($MAX-$MAD)/$MAD;
                }else{
                $SSD   = $MAX-$MAD;    
                }
                $FSS   = ($SSD + $value->mip_lt)/2;
                if($maxHK > 0){
                $DAD   = ($MAD * 4)/$maxHK;
                }else{
                $DAD   = ($MAD * 4);   
                }
                if($value->mip_hk > 0){
                $MIP   = ($MAD * ($value->mip_oc + $value->mip_lt + $FSS)) / $value->mip_hk;
                }else{
                $MIP   = ($MAD * ($value->mip_oc + $value->mip_lt + $FSS));    
                }
                $OV    = $value->total - $MIP;
                if($value->total == 0){
                $OV = 0;    
                }
                if($MIP > 0){
                $back[] = array(
                    'kode' => $value->brg_kode,
                    'nama' => $value->brg_nama,
                    'satu' => $aa['total'],
                    'dua'  => $bb['total'],
                    'tiga' => $cc['total'],
                    'empat'=> $dd['total'],
                    'MAD'  => $MAD,
                    'DAD'  => $DAD,
                    'OC'   => $value->mip_oc,
                    'LT'   => $value->mip_lt,
                    'SS'   => $FSS,
                    'HK'   => $value->mip_hk,
                    'MIP'  => $MIP,
                    'stock'=> $value->total,
                    'OV'   => $OV
                );
                }
            }
			foreach ($back as $key => $val) {
			   $satu[$key] = $val['OV'];
			   $dua[$key]  = $val['kode'];
			}
			array_multisort($satu, SORT_DESC, $dua, SORT_ASC, $back);
        }
        return $back;
    }
    
    public function monthMIP($bln, $thn){
        $a = mktime(0, 0, 0, $bln-1, 1, $thn);
        $b = mktime(0, 0, 0, $bln-2, 1, $thn);
        $c = mktime(0, 0, 0, $bln-3, 1, $thn);
        $d = mktime(0, 0, 0, $bln-4, 1, $thn);
        $arr = array(
            'satu' => $this->system->getBulan(date('m', $a)),
            'dua'  => $this->system->getBulan(date('m', $b)),
            'tiga' => $this->system->getBulan(date('m', $c)),
            'empat'=> $this->system->getBulan(date('m', $d)),
        );
        return $arr;
    }
    
    private function getStock($kode, $cbid, $date){
        $this->db->select('ks_total');
        $this->db->from("brp_kartu_stock");
        $this->db->where("ks_msbcode",$kode);
        $this->db->where("ks_cbid",$cbid);
        $this->db->where("date(ks_tgl) <= ",$date);
        $this->db->order_by("ks_tgl", "DESC");
        $this->db->limit(1);
        $sql = $this->db->get();
        if($sql->num_rows()>0){
            return $sql->row()->ks_total;
        }
        return 0;
    }
    
    public function soq($date, $cbid, $tipe){
        $back = array();
        $mip  = $this->mip($date, $cbid, $tipe);
        if(count($mip)>0){
        foreach ($mip as $key => $value) {
            $OH  = $this->getStock($value['kode'], $cbid, $date);
            $SOQ = $value['MIP'] - $OH;
            $back[] = array('kode'=>$value['kode'], 'nama'=>$value['nama'], 'soq'=>$SOQ);
        }
        }
        return $back;
    }
   
   public function serviceRate($date, $cbid){
       $tgl = dateToIndo($date);
       $sql = " SELECT 
                brg_kode, brg_nama, (case when SUM(dsupp_qty) > 0 then ((SUM(wop_qty) / SUM(dsupp_qty)) * 100) else (SUM(wop_qty) * 100) end) as rate 
                FROM 
                svc_woparts 
                JOIN spa_supply ON wop_wonomer=spp_wopno 
                JOIN spa_dsupp ON sppid=dsupp_noslip AND wop_msbcode=dsupp_msbcode
                JOIN spa_barang ON wop_msbcode=brg_kode
                where date(spp_tgl) <= '$tgl' AND spp_cbid='$cbid' AND wop_wonomer LIKE 'IB%'
                GROUP BY brg_kode, brg_nama";
       $get = $this->db->query($sql);
       if($get->num_rows() > 0){
           return $get->result();
       }
       return array();
   }
   
   public function lostSales($month, $year, $cbid){
       $sql = "select brg_kode, brg_nama, SUM(dslo_pending) as total from spa_salorder JOIN spa_dsalorder ON slo_kode=dslo_slokode JOIN spa_barang ON dslo_msbcode=brg_kode JOIN customer ON slo_custkode=cust_kode where EXTRACT(YEAR FROM slo_tgl)='$year' AND EXTRACT(MONTH FROM slo_tgl)='$month' AND slo_cbid='$cbid' AND cust_nodoc='BODY' GROUP BY brg_kode, brg_nama ";
       $get = $this->db->query($sql);
       if($get->num_rows() > 0){
           return $get->result();
       }
       return array();
   }
   
   public function stockMonth($m, $y, $cbid){
	   $total =0;
       $sql = " select 
					SUM(nota) as jual
					from
					(
					select 
					inv_cbid, SUM(dinv_sm + dinv_oli + dinv_parts) as nota 
					from 
					svc_invoice 
					JOIN svc_dinvoice on inv_nomer= dinv_invnomer
					where 
					EXTRACT(MONTH FROM inv_tgl)=$m 
					and 
					EXTRACT(YEAR FROM inv_tgl)=$y 
					and inv_cbid='$cbid' 
					and inv_batal='N' 
					and inv_wonomer like 'IB%'
					GROUP BY 
					inv_cbid
					) as invoice
			   group by inv_cbid";        
        $query = $this->db->query($sql);
        if($query->num_rows()>0){
            $get = $query->row();
			$total = $get->jual;
        }
        return $total;
   }
   
   public function stockDay($tgl, $cbid, $tipe){
       list($y, $m, $d) = explode("-", $tgl);
       $sql = "select 
                brg_kode,brg_nama, msb_lokasi, model_name, ((SUM(ks_masuk) - SUM(ks_keluar))/$m ) as stock_day
                from 
                brp_kartu_stock JOIN spa_barang ON ks_msbcode=brg_kode 
                JOIN brp_msbarang ON ks_msbcode=msb_code 
                LEFT JOIN mscarmodel ON msb_product=modelid       
                where 
                msb_cbid=ks_cbid AND msb_cbid = '$cbid' AND ks_cbid = '$cbid' AND brg_tipe like '$tipe%' AND date(ks_tgl) <= '$tgl' 
                group by brg_kode,brg_nama, msb_lokasi, model_name order by brg_kode";
        
        $query = $this->db->query($sql);
        if($query->num_rows()>0){
            return $query->result();
        }
        return array();
   }
   
   public function pasIn($date, $cbid){
       list($y, $m, $d) = explode("-", $date);
       $a = mktime(0, 0, 0, $m-3, $d, $y);
       $old  = date("Y-m-d", $a);
       $sql = "select brg_kode, brg_nama, SUM(dslo_pending) as total from spa_salorder JOIN spa_dsalorder ON slo_kode=dslo_slokode JOIN spa_barang ON dslo_msbcode=brg_kode JOIN customer ON slo_custkode=cust_kode where date(slo_tgl) <= '$old' AND slo_cbid='$cbid' AND cust_nodoc='BODY' GROUP BY brg_kode, brg_nama ";
       $get = $this->db->query($sql);
       if($get->num_rows() > 0){
           return $get->result();
       }
       return array();
   }
   
   public function pasOut($date, $cbid){
       $sql = "select brg_kode, brg_nama, msb_jumlah from brp_msbarang JOIN spa_barang ON brg_kode=msb_code where msb_cbid='$cbid' AND date(msb_lastupdate) <= (date '$date' - integer '365')";
       $get = $this->db->query($sql);
       if($get->num_rows() > 0){
           return $get->result();
       }
       return array();
   }
   
   public function umurStock($data=array()){
        $back=array();
        $tgl = $data['end'];
        $sql = "select 
                brg_kode,brg_nama, (SUM(ks_masuk) - SUM(ks_keluar)) as total               
                from 
                brp_kartu_stock LEFT JOIN spa_barang ON ks_msbcode=brg_kode 
                JOIN brp_msbarang ON ks_msbcode=msb_code 
                LEFT JOIN mscarmodel ON msb_product=modelid                 
                where 
                msb_cbid=ks_cbid AND msb_cbid = '".$data['cbg']."' AND ks_cbid = '".$data['cbg']."' AND brg_tipe like '".$data['tipe']."%' AND date(ks_tgl) <= '$tgl' 
                group by brg_kode,brg_nama order by brg_kode";        
        $query = $this->db->query($sql);
        if($query->num_rows()>0){
            foreach ($query->result() as $ks) {
                if($ks->total > 0){
                    $back[] = array(
                        'kode'  => $ks->brg_kode,
                        'nama'  => $ks->brg_nama,
                        'total' => $ks->total
                    );
                }
            }
        }
        return $back;
    }
    
    public function stockEfisien($date, $cbid, $tipe){
        list($thn, $bln, $day) = explode('-', $date);
        $x = mktime(0, 0, 0, $bln, $day, $thn-3);
        $a = mktime(0, 0, 0, $bln-1, 1, $thn);
        $b = mktime(0, 0, 0, $bln-2, 1, $thn);
        $c = mktime(0, 0, 0, $bln-3, 1, $thn);
        $d = mktime(0, 0, 0, $bln-4, 1, $thn);
        $dead = date("Y-m-d", $x);
        $back = array();
        $sql = "select 
                brg_kode, mip_lt, mip_hk, mip_oc,
                (select ks_total from brp_kartu_stock where ks_cbid = '$cbid' AND ks_msbcode=brg_kode AND date(ks_tgl) <= '$date' ORDER BY ks_tgl DESC limit 1 ) as total,
                (select ks_total from brp_kartu_stock where ks_cbid = '$cbid' AND ks_msbcode=brg_kode AND date(ks_tgl) <= '$dead' ORDER BY ks_tgl DESC limit 1 ) as dead_stock
                from
                brp_kartu_stock JOIN spa_barang ON ks_msbcode=brg_kode 
                JOIN brp_msbarang ON ks_msbcode=msb_code   
                LEFT JOIN set_mip ON ks_cbid=mip_cbid AND mip_month='$bln' AND mip_year='$thn'           
                where 
                msb_cbid=ks_cbid AND msb_cbid = '$cbid' AND brg_tipe like '$tipe%' AND date(ks_tgl) <= '$date' 
                group by brg_kode, mip_lt, mip_hk, mip_oc order by brg_kode";
        $get = $this->db->query($sql);
        if($get->num_rows() > 0){
            foreach ($get->result() as $value) {
                $aa = $this->system->maxKartuService($value->brg_kode, $cbid, date("Y-m-01", $a), date("Y-m-t", $a));
                $bb = $this->system->maxKartuService($value->brg_kode, $cbid, date("Y-m-01", $b), date("Y-m-t", $b));
                $cc = $this->system->maxKartuService($value->brg_kode, $cbid, date("Y-m-01", $c), date("Y-m-t", $c));
                $dd = $this->system->maxKartuService($value->brg_kode, $cbid, date("Y-m-01", $d), date("Y-m-t", $d));
                $MAD   = ($aa['total'] + $bb['total'] + $cc['total'] + $dd['total']) / 4;
                $MAX   = max($aa['total'], $bb['total'], $cc['total'], $dd['total']);
                if($MAD > 0) {
                $SSD   = ($MAX-$MAD)/$MAD;
                }else{
                $SSD   = $MAX-$MAD;    
                }
                $FSS   = ($SSD + $value->mip_lt)/2;
                if($value->mip_hk > 0){
                $MIP   = ($MAD * ($value->mip_oc + $value->mip_lt + $FSS)) / $value->mip_hk;
                }else{
                $MIP   = ($MAD * ($value->mip_oc + $value->mip_lt + $FSS));    
                }
                $OS    = $value->total - $MIP;
                if($value->total == 0){
                $OS = 0;    
                }
                if($value->total > 0){
                $SE = (($value->total - ($OS+$value->dead_stock))/$value->total) * 100; 
                }else{
                $SE = (($value->total - ($OS+$value->dead_stock))) * 100; 
                }
                if($MIP > 0){
                $back[] = array(
                    'kode' => $value->brg_kode,
                    'stock'=> $value->total,
                    'MIP'  => $MIP,
                    'OV'   => $OS,
                    'DS'   => $value->dead_stock,
                    'SE'   => $SE
                );
                }
            }
        }
        return $back;
    }
    
    public function deadStock($date, $cbid, $tipe){
        list($thn, $bln, $day) = explode('-', $date);
        $x = mktime(0, 0, 0, $bln, $day, $thn-3);
        $dead = date("Y-m-d", $x);
        $sql = "select brg_kode, brg_nama, (SUM(ks_masuk) - SUM(ks_keluar) ) as total from brp_kartu_stock JOIN spa_barang ON ks_msbcode=brg_kode where ks_cbid='$cbid' AND date(ks_tgl) <='$dead' AND brg_tipe like '$tipe%' GROUP BY brg_kode, brg_nama ORDER BY brg_kode ";
        $get = $this->db->query($sql);
        if($get->num_rows()>0){
            return $get->result();
        }
        return array();
    }
    
    public function fillRate($date, $cbid, $tipe){
       $sql = " SELECT 
                brg_kode, brg_nama, (case when SUM(dsupp_qty) > 0 then ((SUM(wop_qty) / SUM(dsupp_qty)) * 100) else (SUM(wop_qty) * 100) end) as rate 
                FROM 
                svc_woparts 
                JOIN spa_supply ON wop_wonomer=spp_wopno 
                JOIN spa_dsupp ON sppid=dsupp_noslip AND wop_msbcode=dsupp_msbcode
                JOIN spa_barang ON wop_msbcode=brg_kode
                where date(spp_tgl) <= '$date' AND spp_cbid='$cbid' AND brg_tipe like '$tipe%'
                GROUP BY brg_kode, brg_nama";
       $get = $this->db->query($sql);
       if($get->num_rows() > 0){
           return $get->result();
       }
       return array();
   }
   
   public function komposisiStock($date, $cbid, $tipe){
        list($thn, $bln, $day) = explode('-', $date);
        $fast=0;
        $slow=0;
        $dead=0;
        $x = mktime(0, 0, 0, $bln, $day, $thn-3);
        $a = mktime(0, 0, 0, $bln-1, 1, $thn);
        $b = mktime(0, 0, 0, $bln-2, 1, $thn);
        $c = mktime(0, 0, 0, $bln-3, 1, $thn);
        $d = mktime(0, 0, 0, $bln-4, 1, $thn);
        $e = mktime(0, 0, 0, $bln-5, 1, $thn);
        $f = mktime(0, 0, 0, $bln-6, 1, $thn);
        $m1 = date('m', $a); $t1 = date('Y', $a);
        $m2 = date('m', $b); $t2 = date('Y', $b);
        $m3 = date('m', $c); $t3 = date('Y', $c);
        $m4 = date('m', $d); $t4 = date('Y', $d);
        $sql = "SELECT 
                brg_kode, brg_nama, ks_total, ks_hr,
                (select SUM(ks_keluar) as keluar from brp_kartu_stock WHERE ks_cbid='$cbid' AND ks_tipe='SP' AND ks_msbcode=brg_kode AND extract(MONTH from ks_tgl)='$m1' AND extract(YEAR from ks_tgl)='$t1' GROUP BY ks_msbcode ) as satu,
                (select SUM(ks_keluar) as keluar from brp_kartu_stock WHERE ks_cbid='$cbid' AND ks_tipe='SP' AND ks_msbcode=brg_kode AND extract(MONTH from ks_tgl)='$m2' AND extract(YEAR from ks_tgl)='$t2' GROUP BY ks_msbcode ) as dua,
                (select SUM(ks_keluar) as keluar from brp_kartu_stock WHERE ks_cbid='$cbid' AND ks_tipe='SP' AND ks_msbcode=brg_kode AND extract(MONTH from ks_tgl)='$m3' AND extract(YEAR from ks_tgl)='$t3' GROUP BY ks_msbcode ) as tiga,
                (select SUM(ks_keluar) as keluar from brp_kartu_stock WHERE ks_cbid='$cbid' AND ks_tipe='SP' AND ks_msbcode=brg_kode AND extract(MONTH from ks_tgl)='$m4' AND extract(YEAR from ks_tgl)='$t4' GROUP BY ks_msbcode ) as empat,
                (select SUM(ks_keluar) as keluar from brp_kartu_stock WHERE ks_cbid='$cbid' AND ks_tipe='SP' AND ks_msbcode=brg_kode AND date(ks_tgl)>='".date('Y-m-01', $a)."' AND date(ks_tgl)>='".date('Y-m-t', $b)."' GROUP BY ks_msbcode ) as x,
                (select SUM(ks_keluar) as keluar from brp_kartu_stock WHERE ks_cbid='$cbid' AND ks_tipe='SP' AND ks_msbcode=brg_kode AND date(ks_tgl)>='".date('Y-m-01', $c)."' AND date(ks_tgl)>='".date('Y-m-t', $d)."' GROUP BY ks_msbcode ) as y,
                (select SUM(ks_keluar) as keluar from brp_kartu_stock WHERE ks_cbid='$cbid' AND ks_tipe='SP' AND ks_msbcode=brg_kode AND date(ks_tgl)>='".date('Y-m-01', $e)."' AND date(ks_tgl)>='".date('Y-m-t', $f)."' GROUP BY ks_msbcode ) as z,
                (select (SUM(ks_masuk) - SUM(ks_keluar) ) as total from brp_kartu_stock where ks_cbid='$cbid' AND ks_msbcode=brg_kode AND date(ks_tgl) <='".date("Y-m-d", $x)."' GROUP BY ks_msbcode) as dead_stock    
                FROM 
                brp_kartu_stock
                join spa_barang on ks_msbcode=brg_kode 
                where 
                ks_cbid='$cbid' AND ks_tipe='SP' AND brg_tipe like '$tipe%' AND date(ks_tgl) <= '$date' ";
        $get = $this->db->query($sql);
        if($get->num_rows() > 0){
            foreach ($get->result() as $value) {
                if($value->satu >0 && $value->dua >0 && $value->tiga>0 && $value->empat >0){
                    $fast += ($value->ks_total * $value->ks_hr);
                }
                if($value->x > 1 && $value->y >1 && $value->z >1){
                    $slow += ($value->ks_total * $value->ks_hr);
                }
                if($value->dead_stock > 0){
                    $dead += ($value->ks_total * $value->ks_hr);
                }
            }
            return array('fast' => $fast, 'slow' => $slow, 'dead' => $dead);
        }
        return array();
    }
    
}

?>
