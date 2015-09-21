<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class System {

    var $CI;
    private $tab_menu;
    private $tab_userRole;
    private $tab_roleMenu;
    private $tab_city;
    private $krid;
    private $kode_jbtn;
    private $kode_cbg;

    function __construct() {
        $this->CI = & get_instance();
        $this->tab_menu = 'msmenu';
        $this->tab_userRole = 'userrole';
        $this->tab_roleMenu = 'rolemenu';
        $this->tab_city = 'mscity';
//        $this->krid = $this->CI->session->userdata('id');
//        $this->kode_jbtn = $this->CI->session->userdata('jabatan');
//        $this->kode_cbg = $this->CI->session->userdata('cabang');
    }

    /*
     * method untuk memanggil detail menu dari sub menu utama
     */

    public function item($menu_id = "") {
        $data = array();
        $this->CI->load->database();
        $this->CI->db->select('mnid, mn_name,mn_link');
        $this->CI->db->where('mn_flag', '1');
        $this->CI->db->where('mn_sub', $menu_id);
        $this->CI->db->order_by('mn_urut');
        $this->CI->db->from($this->tab_menu);
        $sql = $this->CI->db->get();
        if ($sql->num_rows() > 0) {
            $data = $sql->result();
        }
        return $data;
    }

    /*
     * method untuk mengubah digit angka ke terbilang angka (string)  
     */

    function terbilang_get_valid($str, $from, $to, $min = 1, $max = 9) {
        $val = false;
        $from = ($from < 0) ? 0 : $from;
        for ($i = $from; $i < $to; $i++) {
            if (((int) $str{$i} >= $min) && ((int) $str{$i} <= $max))
                $val = true;
        }
        return $val;
    }

    function terbilang_get_str($i, $str, $len) {
        $numA = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan");
        $numB = array("", "se", "dua ", "tiga ", "empat ", "lima ", "enam ", "tujuh ", "delapan ", "sembilan ");
        $numC = array("", "satu ", "dua ", "tiga ", "empat ", "lima ", "enam ", "tujuh ", "delapan ", "sembilan ");
        $numD = array(0 => "puluh", 1 => "belas", 2 => "ratus", 4 => "ribu", 7 => "juta", 10 => "milyar", 13 => "triliun");
        $buf = "";
        $pos = $len - $i;
        switch ($pos) {
            case 1:
                if (!$this->terbilang_get_valid($str, $i - 1, $i, 1, 1))
                    $buf = $numA[(int) $str{$i}];
                break;
            case 2: case 5: case 8: case 11: case 14:
                if ((int) $str{$i} == 1) {
                    if ((int) $str{$i + 1} == 0)
                        $buf = ($numB[(int) $str{$i}]) . ($numD[0]);
                    else
                        $buf = ($numB[(int) $str{$i + 1}]) . ($numD[1]);
                }
                else if ((int) $str{$i} > 1) {
                    $buf = ($numB[(int) $str{$i}]) . ($numD[0]);
                }
                break;
            case 3: case 6: case 9: case 12: case 15:
                if ((int) $str{$i} > 0) {
                    $buf = ($numB[(int) $str{$i}]) . ($numD[2]);
                }
                break;
            case 4: case 7: case 10: case 13:
                if ($this->terbilang_get_valid($str, $i - 2, $i)) {
                    if (!$this->terbilang_get_valid($str, $i - 1, $i, 1, 1))
                        $buf = $numC[(int) $str{$i}] . ($numD[$pos]);
                    else
                        $buf = $numD[$pos];
                }
                else if ((int) $str{$i} > 0) {
                    if ($pos == 4)
                        $buf = ($numB[(int) $str{$i}]) . ($numD[$pos]);
                    else
                        $buf = ($numC[(int) $str{$i}]) . ($numD[$pos]);
                }
                break;
        }
        return $buf;
    }

    public function toTerbilang($nominal) {
        $buf = "";
        $str = $nominal . "";
        $len = strlen($str);
        for ($i = 0; $i < $len; $i++) {
            $buf = trim($buf) . " " . $this->terbilang_get_str($i, $str, $len);
        }
        return trim($buf);
    }

    /*
     * method untuk menggecek terhadap suatu menu apakak akan ditampilkan atau tidak
     * berdasarkan user role 
     */

    public function check_menu($mnid = "", $krid = "") {
        $this->CI->load->database();
        $this->CI->db->select('urid');
        $this->CI->db->where('rm_mnid', $mnid);
        $this->CI->db->where('ur_krid', $krid);
        $this->CI->db->from($this->tab_userRole);
        $this->CI->db->join($this->tab_roleMenu, 'ur_rlid=rm_rlid');
        $sql = $this->CI->db->get();
        if ($sql->num_rows() > 0) {
            return true;
        }
        return false;
    }

    public function hak_recall() {
        if ($this->kode_jbtn == jab_development) {
            return true;
        } else {
            return false;
        }
    }

    public function hak_super() {
        if ($this->kode_jbtn == jab_direktur || $this->kode_jbtn == jab_development) {
            return true;
        } else {
            return false;
        }
    }
    
    public function hak_akses($mnid = "", $cbg = '') {
        if ($this->kode_jbtn == jab_development && ($cbg == $this->kode_cbg | strlen($cbg) == 0)) {
            return TRUE;
        } else {
            $this->CI->db->select('rm_add');
            $this->CI->db->where('rm_mnid', $mnid);
            $this->CI->db->where('ur_krid', $this->krid);
            $this->CI->db->limit(1);
            $this->CI->db->from($this->tab_userRole);
            $this->CI->db->join($this->tab_roleMenu, 'ur_rlid=rm_rlid');
            $sql = $this->CI->db->get();
            if ($sql->num_rows() > 0) {
                return true;
            }
        }
        return false;
    }

    public function hak_add($mnid = "", $cbg = '') {
        if ($this->kode_jbtn == jab_development && ($cbg == $this->kode_cbg | strlen($cbg) == 0)) {
            return TRUE;
        } else {
            $this->CI->db->select('rm_add');
            $this->CI->db->where('rm_mnid', $mnid);
            $this->CI->db->where('ur_krid', $this->krid);
            $this->CI->db->where('rm_add', '1');
            $this->CI->db->limit(1);
            $this->CI->db->from($this->tab_userRole);
            $this->CI->db->join($this->tab_roleMenu, 'ur_rlid=rm_rlid');
            $sql = $this->CI->db->get();
            if ($sql->num_rows() > 0) {
                if ($cbg == $this->kode_cbg | strlen($cbg) == 0) {
                    return true;
                }
            }
        }
        return false;
    }

    public function hak_edit($mnid = "", $cbg = '') {
        if ($this->kode_jbtn == jab_development && ($cbg == $this->kode_cbg | strlen($cbg) == 0)) {
            return TRUE;
        } else {
            $this->CI->db->select('rm_edit');
            $this->CI->db->where('rm_mnid', $mnid);
            $this->CI->db->where('ur_krid', $this->krid);
            $this->CI->db->where('rm_edit', '1');
            $this->CI->db->limit(1);
            $this->CI->db->from($this->tab_userRole);
            $this->CI->db->join($this->tab_roleMenu, 'ur_rlid=rm_rlid');
            $sql = $this->CI->db->get();
            if ($sql->num_rows() > 0) {
                if ($cbg == $this->kode_cbg | strlen($cbg) == 0) {
                    return true;
                }
            }
        }
        return false;
    }

    public function hak_view($mnid = "", $cbg = '') {
        if ($this->kode_jbtn == jab_development && ($cbg == $this->kode_cbg | strlen($cbg) == 0)) {
            return true;
        } else {
            $this->CI->db->select('rm_view');
            $this->CI->db->where('rm_mnid', $mnid);
            $this->CI->db->where('ur_krid', $this->krid);
            $this->CI->db->where('rm_view', '1');
            $this->CI->db->limit(1);
            $this->CI->db->from($this->tab_userRole);
            $this->CI->db->join($this->tab_roleMenu, 'ur_rlid=rm_rlid');
            $sql = $this->CI->db->get();
            if ($sql->num_rows() > 0) {
                return true;
            }       
        }
        return false;
    }

    public function hak_delete($mnid = "", $cbg = '') {
        if ($this->kode_jbtn == jab_development && ($cbg == $this->kode_cbg | strlen($cbg) == 0)) {
            return true;
        } else {
            $this->CI->db->select('rm_delete');
            $this->CI->db->where('rm_mnid', $mnid);
            $this->CI->db->where('ur_krid', $this->krid);
            $this->CI->db->where('rm_delete', '1');
            $this->CI->db->limit(1);
            $this->CI->db->from($this->tab_userRole);
            $this->CI->db->join($this->tab_roleMenu, 'ur_rlid=rm_rlid');
            $sql = $this->CI->db->get();
            if ($sql->num_rows() > 0) {
                if ($cbg == $this->kode_cbg | strlen($cbg) == 0) {
                    return true;
                }
            }
        }
        return false;
    }

    public function hak_cetak($mnid = "", $cbg = '') {
        if ($this->kode_jbtn == jab_development && ($cbg == $this->kode_cbg | strlen($cbg) == 0)) {
            return true;
        } else {
            $this->CI->db->select('rm_cetak');
            $this->CI->db->where('rm_mnid', $mnid);
            $this->CI->db->where('ur_krid', $this->krid);
            $this->CI->db->where('rm_cetak', '1');
            $this->CI->db->limit(1);
            $this->CI->db->from($this->tab_userRole);
            $this->CI->db->join($this->tab_roleMenu, 'ur_rlid=rm_rlid');
            $sql = $this->CI->db->get();
            if ($sql->num_rows() > 0) {
                if ($cbg == $this->kode_cbg | strlen($cbg) == 0) {
                    return true;
                }
            }
        }
        return false;
    }

    public function hak_setuju($mnid = "", $cbg = '') {
        if ($this->kode_jbtn == jab_development && ($cbg == $this->kode_cbg | strlen($cbg) == 0)) {
            return true;
        } else {
            $this->CI->db->select('rm_setuju');
            $this->CI->db->where('rm_mnid', $mnid);
            $this->CI->db->where('ur_krid', $this->krid);
            $this->CI->db->where('rm_setuju', '1');
            $this->CI->db->limit(1);
            $this->CI->db->from($this->tab_userRole);
            $this->CI->db->join($this->tab_roleMenu, 'ur_rlid=rm_rlid');
            $sql = $this->CI->db->get();
            if ($sql->num_rows() > 0) {
                if ($cbg == $this->kode_cbg | strlen($cbg) == 0) {
                    return true;
                }
            }
            return false;
        }
    }

    public function hak_tidak_setuju($mnid = "", $cbg = '') {
        if ($this->kode_jbtn == jab_development && ($cbg == $this->kode_cbg | strlen($cbg) == 0)) {
            return true;
        } else {
            $this->CI->db->select('rm_tsetuju');
            $this->CI->db->where('rm_mnid', $mnid);
            $this->CI->db->where('ur_krid', $this->krid);
            $this->CI->db->where('rm_tsetuju', '1');
            $this->CI->db->limit(1);
            $this->CI->db->from($this->tab_userRole);
            $this->CI->db->join($this->tab_roleMenu, 'ur_rlid=rm_rlid');
            $sql = $this->CI->db->get();
            if ($sql->num_rows() > 0) {
                if ($cbg == $this->kode_cbg | strlen($cbg) == 0) {
                    return true;
                }
            }
        }
        return false;
    }

    public function hak_batal($mnid = "", $cbg = '') {
        if ($this->kode_jbtn == jab_development && ($cbg == $this->kode_cbg | strlen($cbg) == 0)) {
            return true;
        } else {
            $this->CI->db->select('rm_batal');
            $this->CI->db->where('rm_mnid', $mnid);
            $this->CI->db->where('ur_krid', $this->krid);
            $this->CI->db->where('rm_batal', '1');
            $this->CI->db->limit(1);
            $this->CI->db->from($this->tab_userRole);
            $this->CI->db->join($this->tab_roleMenu, 'ur_rlid=rm_rlid');
            $sql = $this->CI->db->get();
            if ($sql->num_rows() > 0) {
                if ($cbg == $this->kode_cbg | strlen($cbg) == 0) {
                    return true;
                }
            }
        }
        return false;
    }

    public function hak_tidak_batal($mnid = "", $cbg = '') {
        if ($this->kode_jbtn == jab_development && ($cbg == $this->kode_cbg | strlen($cbg) == 0)) {
            return true;
        } else {
            $this->CI->db->select('rm_tbatal');
            $this->CI->db->where('rm_mnid', $mnid);
            $this->CI->db->where('ur_krid', $this->krid);
            $this->CI->db->where('rm_tbatal', '1');
            $this->CI->db->limit(1);
            $this->CI->db->from($this->tab_userRole);
            $this->CI->db->join($this->tab_roleMenu, 'ur_rlid=rm_rlid');
            $sql = $this->CI->db->get();
            if ($sql->num_rows() > 0) {
                if ($cbg == $this->kode_cbg | strlen($cbg) == 0) {
                    return true;
                }
            }
        }
        return false;
    }

    public function hak_validasi($mnid = "", $cbg = '') {
        if ($this->kode_jbtn == jab_development && ($cbg == $this->kode_cbg | strlen($cbg) == 0)) {
            return true;
        } else {
            $this->CI->db->select('rm_validasi');
            $this->CI->db->where('rm_mnid', $mnid);
            $this->CI->db->where('ur_krid', $this->krid);
            $this->CI->db->where('rm_validasi', '1');
            $this->CI->db->limit(1);
            $this->CI->db->from($this->tab_userRole);
            $this->CI->db->join($this->tab_roleMenu, 'ur_rlid=rm_rlid');
            $sql = $this->CI->db->get();
            if ($sql->num_rows() > 0) {
                if ($cbg == $this->kode_cbg | strlen($cbg) == 0) {
                    return true;
                }
            }
        }
        return false;
    }

    public function hak_export($mnid = "", $cbg = '') {
        if ($this->kode_jbtn == jab_development && ($cbg == $this->kode_cbg | strlen($cbg) == 0)) {
            return true;
        } else {
            $this->CI->db->select('rm_export');
            $this->CI->db->where('rm_mnid', $mnid);
            $this->CI->db->where('ur_krid', $this->krid);
            $this->CI->db->where('rm_export', '1');
            $this->CI->db->limit(1);
            $this->CI->db->from($this->tab_userRole);
            $this->CI->db->join($this->tab_roleMenu, 'ur_rlid=rm_rlid');
            $sql = $this->CI->db->get();
            if ($sql->num_rows() > 0) {
                if ($cbg == $this->kode_cbg | strlen($cbg) == 0) {
                    return true;
                }
            }
        }
        return false;
    }

    public function hak_download($mnid = "", $cbg = '') {
        if ($this->kode_jbtn == jab_development && ($cbg == $this->kode_cbg | strlen($cbg) == 0)) {
            return true;
        } else {
            $this->CI->db->select('rm_download');
            $this->CI->db->where('rm_mnid', $mnid);
            $this->CI->db->where('ur_krid', $this->krid);
            $this->CI->db->where('rm_download', '1');
            $this->CI->db->limit(1);
            $this->CI->db->from($this->tab_userRole);
            $this->CI->db->join($this->tab_roleMenu, 'ur_rlid=rm_rlid');
            $sql = $this->CI->db->get();
            if ($sql->num_rows() > 0) {
                if ($cbg == $this->kode_cbg | strlen($cbg) == 0) {
                    return true;
                }
            }
        }
        return false;
    }

    /*
     * method untuk mengubah setiap karakter menjadi huruf kapital
     */

    public function upper($data) {
        $upper = strtoupper($data);
        return $upper;
    }

    /*
     * method untuk menampikan pesan peringatan
     */

    public function warning($msg = "") {
        return "<p class='msg warning'>$msg</p>";
    }

    /*
     * method untuk menampikan pesan informasi
     */

    public function info($msg = "") {
        return "<p class='msg info'>$msg</p>";
    }

    /*
     * method untuk menampikan pesan keberhasilan dalam melakukan sesuatu
     */

    public function done($msg = "") {
        return "<p class='msg done'>$msg</p>";
    }

    /*
     * method untuk menampikan pesan kesalahan
     */

    public function error($msg = "") {
        return "<p class='msg error'>$msg</p>";
    }

    /*
     * =========================================================================
     * methot untuk mengolah tanggal dari sistem
     * getBulan() -> memanggil nama bulan dalam bahasa indonesia
     * dateSql()  -> mengubah tanggal dari format JQuery datePicker menjadi format SQL
     * datePicker()-> kebalikan dari dateSql()
     * dateID()   -> mengubah tanggal dari format SQL menjadi format indonesia
     * day()      -> memanggil nama bulan dalam bahasa indonesia
     * =========================================================================
     */

    function getBulan($bln = "") {
        if (empty($bln)) {
            $data = array(
                '' => 'pilih',
                '01' => 'januari',
                '02' => 'februari',
                '03' => 'maret',
                '04' => 'april',
                '05' => 'mei',
                '06' => 'juni',
                '07' => 'juli',
                '08' => 'agustus',
                '09' => 'september',
                '10' => 'oktober',
                '11' => 'nopember',
                '12' => 'desember'
            );
        } else {
            switch ($bln) {
                case '01': $data = 'Januari';
                    break;
                case '02': $data = 'Februari';
                    break;
                case '03': $data = 'Maret';
                    break;
                case '04': $data = 'April';
                    break;
                case '05': $data = 'Mei';
                    break;
                case '06': $data = 'Juni';
                    break;
                case '07': $data = 'Juli';
                    break;
                case '08': $data = 'Agustus';
                    break;
                case '09': $data = 'September';
                    break;
                case '10': $data = 'Oktober';
                    break;
                case '11': $data = 'Nopember';
                    break;
                case '12': $data = 'Desember';
                    break;
                default : $data = '';
                    break;
            }
        }
        return $data;
    }

    function dateSql($date = "") {
        if ($date <> "") {
            $pecah = explode('-', $date);
            $getDate = $pecah[2] . '-' . $pecah[0] . '-' . $pecah[1];
            return $getDate;
        } else {
            $thn = date('Y');
            $bln = date('m');
            return $getDate = "$thn-$bln-00";
        }
    }

    function datePicker($data = "") {
        $pecah = explode("-", $data);
        $date = $pecah[2] . '-' . $pecah[1] . '-' . $pecah[0];
        if ($pecah[2] != '') {
            return $date;
        } else {
            $pecah = explode('/', $date);
            $date = $pecah[2] . '-' . $pecah[0] . '-' . $pecah[1];
            return $date;
        }
    }

    function dateID($date) {
        $pisah = explode(' ', $date);
        $pecah = explode('-', $pisah[0]);
        if (strlen($date) == 0) {
            $getDate = 0;
        } else {
            $getDate = $pecah[2] . ' ' . $this->getBulan($pecah[1]) . ' ' . $pecah[0];
        }
        return $getDate;
    }

    function day($day = "") {
        if (strlen($day) == 0) {
            $data = array(
                "" => "pilih",
                "1" => "senin",
                "2" => "selasa",
                "3" => "rabu",
                "4" => "kamis",
                "5" => "jum'at",
                "6" => "sabtu",
                "7" => "minggu",
                "8" => "setiap hari"
            );
        } else {
            switch ($day) {
                case "1" : $data = "senin";
                    break;
                case "2" : $data = "selasa";
                    break;
                case "3" : $data = "rabu";
                    break;
                case "4" : $data = "kamis";
                    break;
                case "5" : $data = "jum'at";
                    break;
                case "6" : $data = "sabtu";
                    break;
                case "7" : $data = "minggu";
                    break;
                case "8" : $data = "setiap hari";
                    break;
            }
        }

        return $data;
    }

    function dateIndoToSql($delimiter, $date) {
        $pecah = explode($delimiter, $date);
        $getDate = $pecah[2] . '-' . $pecah[1] . '-' . $pecah[0];
        return $getDate;
    }

    /*
     * ======================== end method tanggal =============================
     */

    public function gender($id = "") {
        if (strlen($id) == 0) {
            $data = array(
                '' => 'Pilih',
                'PRIA' => 'Pria',
                'WANITA' => 'Wanita'
            );
        } else {
            switch ($id) {
                case 'PRIA' : $data = 'Pria';
                    break;
                case 'WANITA' : $data = 'Wanita';
                    break;
            }
        }
        return $data;
    }

    public function agama($id = "") {
        if (strlen($id) == 0) {
            $data = array(
                '' => 'Pilih',
                'ISLAM' => 'Islam',
                'KRISTEN' => 'kristen',
                'KATHOLIK' => 'Katholik',
                'HINDU' => 'Hindu',
                'BUDHA' => 'Budha'
            );
        } else {
            switch ($id) {
                case 'ISLAM' : $data = 'Islam';
                    break;
                case 'KRISTEN' : $data = 'Kristen';
                    break;
                case 'KATHOLIK': $data = 'Khatolik';
                    break;
                case 'HINDU' : $data = 'Hindu';
                    break;
                case 'BUDHA' : $data = 'Budha';
                    break;
                default : $data = $id;
            }
        }
        return $data;
    }

    public function marital($id = "") {
        if (strlen($id) == 0) {
            $data = array(
                '' => 'Pilih',
                'TK' => 'Tidak kawin',
                'K' => 'Kawin',
            );
        } else {
            switch ($id) {
                case 'TK' : $data = 'Tidak Kawin';
                    break;
                case 'K' : $data = 'Kawin ';
                    break;

                default : $data = $id;
            }
        }
        return $data;
    }

    public function jenis_id($id = "") {
        if (strlen($id) == 0) {
            $data = array('' => 'Pilih',
                'KTP' => 'KTP',
                'SIM' => 'SIM',
                'PASSPOR' => 'PASSPOR');
        } else {
            switch ($id) {
                case 'KTP': $data = 'KTP';
                    break;
                case 'SIM': $data = 'SIM';
                    break;
                case 'PASSPOR': $data = 'PASSPOR';
                    break;
            }
        }
        return $data;
    }

    public function selisih_jam($awal = "", $akhir = "") {
        $pecah = explode(" ", $awal);
        $split = explode(" ", $akhir);
        $aw = explode(":", $pecah[1]);
        $ak = explode(":", $split[1]);

        if ($ak[0] > $aw[0])
            $jam = $ak[0] - $aw[0];
        else
            $jam = "0";

        if ($ak[1] > $aw[1]) {
            $menit = $ak[1] - $aw[1];
        } elseif ($aw[1] > $ak[1]) {
            $jam--;
            $menit = 60 - $aw[1] + $ak[1];
        } else {
            $menit = "0";
        }

        if ($ak[2] > $aw[2]) {
            $detik = $ak[2] - $aw[2];
        } elseif ($aw[2] > $ak[2]) {
            $menit--;
            $detik = 60 - $aw[2] + $ak[2];
        } else {
            $detik = "0";
        }

        $waktu = $jam . ':' . $menit . ':' . $detik;
        return $waktu;
    }

    public function data_grid($count = "", $id = "") {
        $page = isset($_POST['page']) ? $_POST['page'] : 1; // get the requested page
        $limit = isset($_POST['rows']) ? $_POST['rows'] : 10; // get how many rows we want to have into the grid
        $sidx = isset($_POST['sidx']) ? $_POST['sidx'] : $id; // get index row - i.e. user click to sort
        $sord = isset($_POST['sord']) ? $_POST['sord'] : ''; // get the direction

        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;
        if ($totalrows) {
            $limit = $totalrows;
        }

        $where = ""; //if there is no search request sent by jqgrid, $where should be empty

        if (!$sidx)
            $sidx = 1;

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        } if ($page > $total_pages)
            $page = $total_pages;
        if ($limit < 0)
            $limit = 0; $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if ($start < 0)
            $start = 0;

        if ($page > $total_pages)
            $page = $total_pages;

        $dataGrid = array(
            'start' => $start,
            'limit' => $limit,
            'sidx' => $sidx,
            'sord' => $sord,
            'where' => $where,
            'page' => $page,
            'total' => $total_pages
        );

        return $dataGrid;
    }

    public function numeric($data) {
        $numeric = str_replace(',', '', $data);
        return $numeric;
    }

    public function cek_value($data) {
        if ($data == '') {
            $value = 0;
        } else {
            $value = $data;
        }
        return $value;
    }

    /*
     * -------------------------------------------------------------------------
     * fungsi : penomoran secara otomatis
     * oleh   : yanun
     * update : 07/02/2012 10:20
     * -------------------------------------------------------------------------
     */

    public function auto_number($nomor = "") {
        $kode = (int) substr($nomor, 0);
        $kode++;
        $newKode = sprintf("%05s", $kode);

        return $newKode;
    }

    /*
     * -------------------------------------------------------------------------
     * fungsi : enkripsi data xml
     * oleh   : yanun
     * update : 11/02/2012 11:39
     * -------------------------------------------------------------------------
     */

    public function enkripsi($data = "") {
        $enkripsi = "";
        for ($i = 0; $i < strlen($data); $i++) {
            $enkripsi = str_replace(" ", "", $data);
            $enkripsi = str_replace("a", "c", $enkripsi);
            $enkripsi = str_replace("b", "e", $enkripsi);
            $enkripsi = str_replace("c", "g", $enkripsi);
        }
    }

    public function selisih_tanggal($tgl_awal = "") {
        $tgl1 = $tgl_awal;  // 1 Oktober 2009
        $tgl2 = date('Y-m-d');  // 10 Oktober 2009
        // memecah tanggal untuk mendapatkan bagian tanggal, bulan dan tahun
        // dari tanggal pertama

        $pecah1 = explode("-", $tgl1);
        $date1 = $pecah1[2];
        $month1 = $pecah1[1];
        $year1 = $pecah1[0];

        // memecah tanggal untuk mendapatkan bagian tanggal, bulan dan tahun
        // dari tanggal kedua

        $pecah2 = explode("-", $tgl2);
        $date2 = $pecah2[2];
        $month2 = $pecah2[1];
        $year2 = $pecah2[0];

        // menghitung JDN dari masing-masing tanggal

        $jd1 = GregorianToJD($month1, $date1, $year1);
        $jd2 = GregorianToJD($month2, $date2, $year2);

        // hitung selisih hari kedua tanggal

        $selisih = $jd2 - $jd1;
        if($selisih<0){
         $selisih ='0';   
        }else{
           $selisih = $jd2 - $jd1; 
        }

        return $selisih;
    }

    public function kota($prov = "") {
        $this->CI->load->database();
        $this->CI->db->select('citid,cit_name');
        $this->CI->db->order_by('cit_name');
        $sql = $this->CI->db->get_where($this->tab_city, array('cit_provid' => $prov));
        return $sql->result();
    }

    public function get_city($kode = "") {
        $this->CI->load->database();
        $this->CI->db->select('cit_name');
        $this->CI->db->limit(1);
        $sql = $this->CI->db->get_where($this->tab_city, array('citid' => $kode));
        if ($sql->num_rows() > 0) {
            return $sql->row()->cit_name;
        } else {
            return $kode = "";
        }
    }

    public function terjemahIntern($type) {
        if ($type == "IN") {
            return "INTERN";
        } elseif ($type == "EX") {
            return "EXTERN";
        } elseif ($type == "GR") {
            return "GROUP";
        } else {
            return "CABANG";
        }
    }

    public function terjemahCodeIntern($type) {
        if ($type == "INTERN") {
            return "IN";
        } elseif ($type == "EXTERN") {
            return "EX";
        } elseif ($type == "GROUP") {
            return "GR";
        } else {
            return "CA";
        }
    }

    public function data_cabang() {
        $this->CI->load->database();
        $this->CI->db->select('cb_descrip, cb_addr1, cb_phone1, cit_name');
        $this->CI->db->limit(1);
        $this->CI->db->from("mscabang");
        $this->CI->db->join($this->tab_city, "cb_city=citid");
        $this->CI->db->where("cbid", $this->kode_cbg);
        $sql = $this->CI->db->get();
        if ($sql->num_rows() > 0) {
            return $sql->row();
        } else {
            return $kode = "";
        }
    }

    /**
     * ------------------------------------------------------------------------
     * mencari pesan baru
     * by : yanun
     * update : 02/07/2012 20:05
     * ------------------------------------------------------------------------
     */
    public function pesan() {
        $total = 0;
        $this->CI->load->database();
        $this->CI->db->where("psn_penerima", ses_nik);
        $this->CI->db->where("psn_status", "N");
        $this->CI->db->from("pesan");
        if($this->CI->db->count_all_results() > 0){
            $total = $this->CI->db->count_all_results();
	}
        return $total;
    }
    
    /**
     * ------------------------------------------------------------------------
     * mencari Fpt Baru
     * by : yanun
     * update : 02/08/2012 12:13
     * ------------------------------------------------------------------------
     */
    public function fpt() {
        $total = 0;
        $this->CI->load->database();
        $this->CI->db->where("fpt_cbid", ses_cabang);
        $this->CI->db->where("fpt_status", "1");
        $this->CI->db->from("pen_fpt");
        if($this->CI->db->count_all_results() > 0){
            $total = $this->CI->db->count_all_results();
	}
        return $total;
    }
    //robi
    //function untuk menentukan minggu keberapa dri satu bulan
    function week_of_month($date) {
    $date_parts = explode('-', $date);
    $date_parts[2] = '01';
    $first_of_month = implode('-', $date_parts);
    $day_of_first = date('N', strtotime($first_of_month));
    $day_of_month = date('j', strtotime($date));
    return floor(($day_of_first + $day_of_month - 1) / 7) + 1;
    }
    //function untuk menentukan hari apa pada tanggal tersebut
    function formatTanggal($date=null)
    {
    //buat array nama hari dalam bahasa Indonesia dengan urutan 1-7
    $array_hari = array(1=>'Senin','Selasa','Rabu','Kamis','Jumat', 'Sabtu','Minggu');
    //buat array nama bulan dalam bahasa Indonesia dengan urutan 1-12
    $array_bulan = array(1=>'Januari','Februari','Maret', 'April', 'Mei', 'Juni','Juli','Agustus',
    'September','Oktober', 'November','Desember');
    if($date == null) {
    //jika $date kosong, makan tanggal yang diformat adalah tanggal hari ini
    $hari = $array_hari[date('N')];
    $tanggal = date ('j');
    $bulan = $array_bulan[date('n')];
    $tahun = date('Y');
    } else {
    //jika $date diisi, makan tanggal yang diformat adalah tanggal tersebut
    $date = strtotime($date);
    $hari = $array_hari[date('N',$date)];
    $tanggal = date ('j', $date);
    $bulan = $array_bulan[date('n',$date)];
    $tahun = date('Y',$date);
    }
    $formatTanggal = $hari ;
    return $formatTanggal;
    }

}

?>
