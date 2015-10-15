<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
  |--------------------------------------------------------------------------
  | Helper of System
  |--------------------------------------------------------------------------
 */

/*
  |--------------------------------------------------------------------------
  | function of name system
  |--------------------------------------------------------------------------
 */
if (!function_exists('name_system')) {

    function name_system() {
        $CI = & get_instance();
        return $CI->config->item('name_system');
    }

}


/*
  |--------------------------------------------------------------------------
  | function of company
  |--------------------------------------------------------------------------
 */
if (!function_exists('company')) {

    function company() {
        $CI = & get_instance();
        return $CI->config->item('company');
    }

}

if (!function_exists('menu')) {

    function menu($id, $name, $url, $iconclasss, $spanclass, $ext) {
        $menu = '<li><a href="' . $url . '"><i class="' . $iconclasss . '"></i><span class="' . $spanclass . '">' . $name . '</span>' . $ext . '</a></li>';
        return $menu;
    }

}

/*
  |--------------------------------------------------------------------------
  | function of Address
  |--------------------------------------------------------------------------
 */
if (!function_exists('address')) {

    function address() {
        $CI = & get_instance();
        return $CI->config->item('address');
    }

}

/*
  |--------------------------------------------------------------------------
  | function of telepon
  |--------------------------------------------------------------------------
 */
if (!function_exists('telepon')) {

    function telepon() {
        $CI = & get_instance();
        return $CI->config->item('telepon');
    }

}

/*
  |--------------------------------------------------------------------------
  | function of version
  |--------------------------------------------------------------------------
 */
if (!function_exists('version')) {

    function version() {
        $CI = & get_instance();
        return $CI->config->item('version');
    }

}

/*
  |--------------------------------------------------------------------------
  | function of developer
  |--------------------------------------------------------------------------
 */
if (!function_exists('developer')) {

    function developer() {
        $CI = & get_instance();
        return $CI->config->item('developer');
    }

}

/*
  |--------------------------------------------------------------------------
  | function of path css
  |--------------------------------------------------------------------------
 */
if (!function_exists('path_css')) {

    function path_css() {
        $CI = & get_instance();
        return $CI->config->item('path_css');
    }

}

/*
  |--------------------------------------------------------------------------
  | function of path javascript
  |--------------------------------------------------------------------------
 */
if (!function_exists('path_js')) {

    function path_js() {
        $CI = & get_instance();
        return $CI->config->item('path_js');
    }

}
if (!function_exists('path_asset')) {

    function path_asset() {
        $CI = & get_instance();
        return $CI->config->item('path_asset');
    }

}
if (!function_exists('path_fck')) {

    function path_fck() {
        $CI = & get_instance();
        return $CI->config->item('path_fck');
    }

}

/*
  |--------------------------------------------------------------------------
  | function of path images
  |--------------------------------------------------------------------------
 */
if (!function_exists('path_img')) {

    function path_img() {
        $CI = & get_instance();
        return $CI->config->item('path_img');
    }

}

/*
 * -----------------------------------------------------------------------------
 * fungsi menggubah huruf menjadi kapital
 * oleh : yanun
 * update : 06/03/2012 13:42
 * -----------------------------------------------------------------------------
 */
if (!function_exists('text_upper')) {

    function text_upper($data) {
        $upper = strtoupper($data);
        return $upper;
    }

}
/*
 * -----------------------------------------------------------------------------
 */

/*
 * -----------------------------------------------------------------------------
 * fungsi mengambil data sistem pembayaran
 * by : yanun
 * update : 09/03/2012 05:22
 * -----------------------------------------------------------------------------
 */
if (!function_exists('pay_method')) {

    function pay_method($key = '') {
        if ($key == '') {
            $data = array(
                '' => '- pilih -',
                'CR' => 'Kredit ',
                'CA' => 'Tunai '
            );
        } else {
            switch ($key) {
                case 'CR' : $data = 'Kredit';
                    break;
                case 'CA' : $data = 'Tunai';
            }
        }
        return $data;
    }

}
/*
 * -----------------------------------------------------------------------------
 */

/*
 * -----------------------------------------------------------------------------
 * fungsi mengubah tanggal dari SQL ke format indonesia
 * by : yanun
 * update : 12/03/2012 14:41
 * -----------------------------------------------------------------------------
 */
if (!function_exists('dateToIndo')) {

    function dateToIndo($date = '') {
        $pecah = explode('-', str_replace("/", "-", $date));
        if (count($pecah) > 2) {
            $getDate = $pecah[2] . '-' . $pecah[1] . '-' . $pecah[0];
        } else {
            $getDate = $date;
        }
        return $getDate;
    }

}
/*
 * -----------------------------------------------------------------------------
 */

/*
 * -----------------------------------------------------------------------------
 * fungsi mengambil data type supply
 * by : yanun
 * update : 09/03/2012 05:22
 * -----------------------------------------------------------------------------
 */
if (!function_exists('internExtern')) {

    function internExtern($type = '') {
        if ($type == '') {
            $data = array(
                '' => '- pilih -',
                '1' => 'INTERN ',
                '2' => 'EXTERN ',
                '3' => 'GROUP',
                '4' => 'CABANG'
            );
        } else {
            switch ($type) {
                case '1' : $data = 'INTERN';
                    break;
                case '2' : $data = 'EXTERN';
                    break;
                case '3' : $data = 'GROUP';
                    break;
                case '4' : $data = 'CABANG';
            }
        }
        return $data;
    }

}
/*
 * -----------------------------------------------------------------------------
 */

/*
 * -----------------------------------------------------------------------------
 * fungsi mengenkripsi string
 * by : yanun
 * update : 17/03/2012 09:46
 * -----------------------------------------------------------------------------
 */
if (!function_exists('enkripsi')) {

    function enkripsi($string = '') {
        $string = base64_encode($string);
        $string = base64_encode($string);
        $string = base64_encode($string);
        $string = base64_encode($string);
        $string = base64_encode($string);
        return $string;
    }

}
/*
 * -----------------------------------------------------------------------------
 */

/*
 * -----------------------------------------------------------------------------
 * fungsi mendekripsi string
 * by : yanun
 * update : 17/03/2012 09:49
 * -----------------------------------------------------------------------------
 */
if (!function_exists('dekripsi')) {

    function dekripsi($string = '') {
        $string = base64_decode($string);
        $string = base64_decode($string);
        $string = base64_decode($string);
        $string = base64_decode($string);
        $string = base64_decode($string);
        return $string;
    }

}
/*
 * -----------------------------------------------------------------------------
 */

/*
 * -----------------------------------------------------------------------------
 * fungsi mengubah angka dalam bentuk rupiah
 * by : yanun
 * update : 21/03/2012 14:52
 * -----------------------------------------------------------------------------
 */
if (!function_exists("format_idr")) {

    function format_idr($angka = '') {
        $koma = 0;
        $split = explode(".", $angka);
        $koma = @$split[1];
        if (count($split) == 1 && $koma == 0) {
            return number_format($angka, 0, '.', ',');
        } else {
            return number_format($angka, 0, '.', ',') . '.' . $koma;
        }
    }

}
if (!function_exists("defaultTgl")) {

    function defaultTgl() {
        return '01-01-9999';
    }

}
/*
 * -----------------------------------------------------------------------------
 */

/*
 * -----------------------------------------------------------------------------
 * fungsi menampilkan pop screen
 * by : yanun
 * update 05/04/2012 10:31
 * -----------------------------------------------------------------------------
 */
if (!function_exists("pop_screen")) {

    function pop_screen($teks = '', $back = FALSE) {
        ?>
        <script>
            alert('<?php echo $teks; ?>');
        <?php if ($back == TRUE) { ?>
                history.back();
        <?php } ?>
        </script>

        <?php
    }

}
/*
 * -----------------------------------------------------------------------------
 */

/*
 * -------------------------------------------------------------------------
 * fungsi : penomoran secara otomatis (panjang nomor 10 karakter)
 * 1. menghitung panjang karakter
 * 2. menghitung panjang string awal
 * 3. mencari sisa panjang karakter
 * 4. menentukan sisa karakter
 * 5. lakukan pemanbahan nomor pada karakter sisa
 * 6. gabungkan string awal dengan sisa karakter yang telah ditambah
 * oleh   : yanun
 * update : 07/02/2012 10:20
 * -------------------------------------------------------------------------
 */
if (!function_exists("auto_number")) {

    function auto_number($nomor = "", $prefix = '') {
        $integer = '';
        $long = strlen($nomor);
        $shot = strlen($prefix);
        $sisa = ($long - $shot);
        if ($long == 0) {
            $sufix = 12 - $shot;
            for ($i = 1; $i <= $sufix; $i++) {
                $integer .= '0';
            }
        } else {
            $integer = substr($nomor, $shot, $sisa);
        }

        $kode = (int) substr($integer, 0);
        $kode++;
        $newKode = sprintf("%0" . strlen($integer) . "s", $kode);

        $auto_number = $prefix . $newKode;
        return $auto_number;
    }

}
/*
 * -------------------------------------------------------------------------
 * end penomoran otomatis
 * -------------------------------------------------------------------------
 */

/**
 * ------------------------------------------------------------------------
 * prefix for auto number
 * by : yanun
 * update : 17/04/2012 13:47
 * ------------------------------------------------------------------------
 */
if (!function_exists("prefix")) {

    function prefix($char = "") {
        $CI = & get_instance();
        $kode_cbg = substr($CI->session->userdata('cabang'), 3, 3);
        $prefix = $char . $kode_cbg . date('y');
        return $prefix;
    }

}
/**
 * ------------------------------------------------------------------------
 * end prefix
 * ------------------------------------------------------------------------
 */
/**
 * -----------------------------------------------------------------------------
 * fungsi mengambil data jenis dari type supply external
 * by : yanun
 * update : 18/04/2012 09:56
 * -----------------------------------------------------------------------------
 */
if (!function_exists('external_type')) {

    function external_type($type = '') {
        if ($type == '') {
            $data = array(
                '' => '- pilih -',
                'TK' => 'Toko ',
                'PK' => 'Pemakai ',
                'BU' => 'Bengkel Umum',
                'LL' => 'Lain - Lain'
            );
        } else {
            switch ($type) {
                case 'TK' : $data = 'Toko';
                    break;
                case 'PK' : $data = 'Pemakai';
                    break;
                case 'BU' : $data = 'Bengkel Umum';
                    break;
                case 'LL' : $data = 'Lain - Lain';
            }
        }
        return $data;
    }

}
/**
 * -----------------------------------------------------------------------------
 */
/**
 * -----------------------------------------------------------------------------
 * fungsi mengambil data jenis kelamin
 * by : yanun
 * update : 18/04/2012 09:56
 * -----------------------------------------------------------------------------
 */
if (!function_exists('gender')) {

    function gender($type = '') {
        if ($type == '') {
            $data = array(
                '' => '- pilih -',
                'P' => 'Pria',
                'W' => 'Wanita',
                'C' => 'C-Corporate'
            );
        } else {
            switch ($type) {
                case 'P' : $data = 'Pria';
                    break;
                case 'W' : $data = 'Wanita';
                    break;
                case 'C' : $data = 'C-Corporate';
                    break;
                default : $data = "";
            }
        }
        return $data;
    }

}
/**
 * -----------------------------------------------------------------------------
 */
/**
 * -----------------------------------------------------------------------------
 * fungsi untuk mencari selisih tanggal
 * by : yanun
 * update : 03/05/2012 09:22
 * -----------------------------------------------------------------------------
 */
if (!function_exists('date_differ')) {

    function date_differ($data = array()) {
        if (is_array($data)) {
            $date_diff = (strtotime($data[0]) - strtotime($data[1])) / 86400;
        } else {
            $date_diff = "0";
        }
        return $date_diff;
    }

}
/**
 * -----------------------------------------------------------------------------
 */
/**
 * -----------------------------------------------------------------------------
 * fungsi untuk mengolah cookies
 * by :  yanun
 * update : 06/06/2012 20:03
 * -----------------------------------------------------------------------------
 */
if (!function_exists('create_cookie')) {

    function create_cookie($data = array(), $time = '') {
        if (is_null($time))
            $time = 360000;
        if (is_array($data) && count($data) > 0) {
            foreach ($data as $key => $val) {
                $val = enkripsi($val);
                if (!isset($_COOKIE[$key])) {
                    setcookie($key, $val, time() + $time, '/');
                } else {
                    $this->destroy_cookie($key);
                    setcookie($key, $val, time() + $time, '/');
                }
            }
        } else {
            if (!isset($_COOKIE[$data])) {
                setcookie($data, enkripsi($data), time() + $time, '/');
            } else {
                $this->destroy_cookie($data);
                setcookie($data, enkripsi($data), time() + $time, '/');
            }
        }
    }

}

if (!function_exists('data_cookie')) {

    function data_cookie($name = array()) {
        $data = "";
        if (is_array($name) && count($name) > 0) {
            foreach ($name as $value) {
                if (isset($_COOKIE[$value])) {
                    $data[$name] = dekripsi($_COOKIE[$value]);
                }
            }
        } else {
            if (isset($_COOKIE[$name])) {
                $data = dekripsi($_COOKIE[$name]);
            }
        }
        return $data;
    }

}

if (!function_exists('destroy_cookie')) {

    function destroy_cookie($data = array(), $time = '') {
        if ($time == '')
            $time = 370000;
        if (is_array($data) && count($data) > 0) {
            foreach ($data as $key => $val) {
                setcookie($key, '', time() - $time, '/');
                setcookie($val, '', time() - $time, '/');
                unset($_COOKIE[$key]);
                unset($_COOKIE[$val]);
            }
        } else {
            setcookie($data, '', time() - $time, '/');
            unset($_COOKIE[$data]);
        }
    }

}
/**
 * -----------------------------------------------------------------------------
 */
/**
 * ----------------------------------------------------------------------------
 * convert array to object array
 * by : yanun
 * update : 29/06/2012 09:51
 * ----------------------------------------------------------------------------
 */
if (!function_exists("arrayToObject")) {

    function arrayToObject($array) {
        if (!is_array($array)) {
            return $array;
        }

        $object = new stdClass();
        if (is_array($array) && count($array) > 0) {
            foreach ($array as $name => $value) {
                $name = strtolower(trim($name));
                if (!empty($name)) {
                    $object->$name = arrayToObject($value);
                }
            }
            return $object;
        } else {
            return FALSE;
        }
    }

}

/**
 * -----------------------------------------------------------------------------
 * membuat data konstant dari session
 * by : yanun
 * update : 13/07/2012 10:50
 * -----------------------------------------------------------------------------
 */
//$CI = & get_instance();

$CI = & get_instance();

$CI->load->library('session');

//user id
if (!defined('ses_userid')) {
    $userid = $CI->session->userdata('userid');
    if ($userid == "") {
        $userid = data_cookie("userid");
    }
    define("ses_userid", $userid);
}


$CI = & get_instance();
//user id
if (!defined('isLogin')) {
    $userid = $CI->session->userdata('isLogin');
    if ($userid == "") {
        $userid = data_cookie("isLogin");
    }
    define("isLogin", $userid);
}

//id karyawan
if (!defined('ses_krid')) {
    $id = $CI->session->userdata('krid');
    if ($id == "") {
        $id = data_cookie("krid");
    }
    define("ses_krid", $id);
}
//id karyawan
if (!defined('ses_nama')) {
    $id = $CI->session->userdata('nama');
    if ($id == "") {
        $id = data_cookie("nama");
    }
    define("ses_nama", $id);
}
//id karyawan
if (!defined('ses_member_id')) {
    $id = $CI->session->userdata('member_id_log');
    if ($id == "") {
        $id = data_cookie("member_id_log");
    }
    define("ses_member_id", $id);
}
//id karyawan
if (!defined('ses_parent_menu')) {
    $id = $CI->session->userdata('parent_menu');
    if ($id == "") {
        $id = 0;
    }
    define("ses_parent_menu", $id);
}

//nik
if (!defined('ses_nik')) {
    $nik = $CI->session->userdata('nik');
    if ($nik == "") {
        $nik = data_cookie("nik");
    }
    define("ses_nik", $nik);
}

//username
if (!defined('ses_username')) {
    $username = $CI->session->userdata('username');
    if ($username == "") {
        $username = data_cookie("username");
    }
    define("ses_username", $username);
}
//username
if (!defined('ses_login')) {
    $login = $CI->session->userdata('login');
    if ($login == "") {
        $login = data_cookie("login");
    }
    define("ses_login", $login);
}

//fullname
if (!defined('ses_realname')) {
    $fullname = $CI->session->userdata('realname');
    if ($fullname == "") {
        $fullname = data_cookie("realname");
    }
    define("ses_realname", $fullname);
}


//posisi
if (!defined('ses_posisi')) {
    $posisi = $CI->session->userdata('posisi');
    if ($posisi == "") {
        $posisi = data_cookie("posisi");
    }
    define("ses_posisi", $posisi);
}

//jabatan
if (!defined('ses_jabatan')) {
    $jabatan = $CI->session->userdata('jabatan');
    if ($jabatan == "") {
        $jabatan = data_cookie("jabatan");
    }
    define("ses_jabatan", $jabatan);
}

//departement
if (!defined('ses_dept')) {
    $dept = $CI->session->userdata('dept');
    if ($dept == "") {
        $dept = data_cookie("dept");
    }
    define("ses_dept", $dept);
}

//gudang
if (!defined('ses_gudang')) {
    $gudang = $CI->session->userdata('gudang');
    if ($gudang == "") {
        $gudang = data_cookie("gudang");
    }
    define("ses_gudang", $gudang);
}

//dealer
if (!defined('ses_dealer')) {
    $dealer = $CI->session->userdata('dealer');
    if ($dealer == "") {
        $dealer = data_cookie("dealer");
    }
    define("ses_dealer", $dealer);
}
//phone
if (!defined('ses_phone')) {
    $phone = $CI->session->userdata('phone');
    if ($phone == "") {
        $phone = data_cookie("phone");
    }
    define("ses_phone", $phone);
}
//dealer
if (!defined('ses_npwp')) {
    $npwp = $CI->session->userdata('npwp');
    if ($npwp == "") {
        $npwp = data_cookie("npwp");
    }
    define("ses_npwp", $phone);
}

//alamat
if (!defined('ses_alamat')) {
    $alamat = $CI->session->userdata('alamat');
    if ($alamat == "") {
        $alamat = data_cookie("alamat");
    }
    define("ses_alamat", $alamat);
}


//cabang
if (!defined('ses_cabang')) {
    $cabang = $CI->session->userdata('cbid');
    if ($cabang == "") {
        $cabang = data_cookie("cbid");
    }
    define("ses_cabang", $cabang);
}
//cabang
if (!defined('ses_cabang_nama')) {
    $cabang = $CI->session->userdata('cb_nama');
    if ($cabang == "") {
        $cabang = data_cookie("cb_nama");
    }
    define("ses_cabang_nama", $cabang);
}
//deskripsi
if (!defined('ses_deskripsi')) {
    $deskripsi = $CI->session->userdata('deskripsi');
    if ($deskripsi == "") {
        $deskripsi = data_cookie("deskripsi");
    }
    define("ses_deskripsi", $deskripsi);
}

//kota
if (!defined('ses_kota')) {
    $kota = trim($CI->session->userdata('kota'));
    if ($kota == "") {
        $kota = trim(data_cookie("kota"));
    }

    define("ses_kota", $kota);
}
//robi
if (!function_exists("prefix_cabang")) {

    function prefix_cabang($char = "", $cabang = "") {
        $CI = & get_instance();
        $kode_cbg = substr($cabang, 3, 3);
        $prefix = $char . $kode_cbg . date('y');
        return $prefix;
    }

}
?>
