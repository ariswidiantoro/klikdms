<?php

defined('BASEPATH') OR exit('No direct script access allowed');

function path_css() {
    $CI = & get_instance();
    return $CI->config->item('path_css');
}

if (!function_exists('path_css_admin')) {

    function path_css_admin($uri = '') {
        $CI = & get_instance();
        return $CI->config->item('path_css_admin');
    }

}
if (!function_exists('path_avatar')) {

    function path_avatar($uri = '') {
        $CI = & get_instance();
        return $CI->config->item('path_avatar');
    }

}

function sukses($msg = "") {
    return '<div class="alert alert-block alert-success">
											<button type="button" class="close" data-dismiss="alert">
												<i class="ace-icon fa fa-times"></i>
											</button>

											<p>
												<strong>
													<i class="ace-icon fa fa-check"></i>
												</strong>
												' . $msg . '
											</p>
										</div>';
}

function error($msg = "") {
    return '<div class="alert alert-danger">
											<button type="button" class="close" data-dismiss="alert">
												<i class="ace-icon fa fa-times"></i>
											</button>

											<strong>
												<i class="ace-icon fa fa-times"></i>
												Error
											</strong>

											' . $msg . '
											<br />
										</div>';
}

if (!function_exists('path_js')) {

    function path_js($uri = '') {
        $CI = & get_instance();
        return $CI->config->item('path_js');
    }

}

if (!function_exists('path_docs')) {

    function path_docs($uri = '') {
        $CI = & get_instance();
        return $CI->config->item('path_docs');
    }

}

if (!function_exists('path_asset')) {

    function path_asset($uri = '') {
        $CI = & get_instance();
        return $CI->config->item('path_asset');
    }

}

if (!function_exists('path_upload')) {

    function path_upload($uri = '') {
        $CI = & get_instance();
        return $CI->config->item('path_upload');
    }

}

if (!function_exists('path_skin_images')) {

    function path_skin_images() {
        $CI = & get_instance();
        return $CI->config->item('path_skin_images');
    }

}

if (!function_exists('path_slides')) {

    function path_slides() {
        $CI = & get_instance();
        return $CI->config->item('path_slides');
    }

}

if (!function_exists('path_js_plugin')) {

    function path_js_plugin($uri = '') {
        $CI = & get_instance();
        return $CI->config->item('path_js_plugin');
    }

}

if (!function_exists('path_bootstrap')) {

    function path_bootstrap($uri = '') {
        $CI = & get_instance();
        return $CI->config->item('path_bootstrap');
    }

}

if (!function_exists('path_font_icons')) {

    function path_font_icons($uri = '') {
        $CI = & get_instance();
        return $CI->config->item('path_font_icons');
    }

}

if (!function_exists('path_js_admin')) {

    function path_js_admin($uri = '') {
        $CI = & get_instance();
        return $CI->config->item('path_js_admin');
    }

}

/**
 * This function is used for get image path
 */
if (!function_exists('path_img')) {

    function path_img($uri = '') {
        $CI = & get_instance();
        return $CI->config->item('path_img');
    }

}
/**
 * This function is used for get image path
 */
if (!function_exists('path_img_admin')) {

    function path_img_admin($uri = '') {
        $CI = & get_instance();
        return $CI->config->item('path_img_admin');
    }

}
if (!function_exists('path_img')) {

    function done($msg = "") {
        return "<p class='msg done'>$msg</p>";
    }

}

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

if (!function_exists('is_logged_in')) {

    function is_logged_in() {
        $CI = & get_instance();
//            $CI->load->library('session');
        $is_logged_in = $CI->session->userdata('login_administr');
        if (empty($is_logged_in)) {
            echo 'Silahkan Login. <a href="' . site_url('admin') . '">Login</a>';
            die();
        }
    }

}

function whereLoad() {
    $searchField = isset($_POST['searchField']) ? $_POST['searchField'] : false;
    $searchOper = isset($_POST['searchOper']) ? $_POST['searchOper'] : false;
    $searchString = isset($_POST['searchString']) ? $_POST['searchString'] : false;

    if ($_POST['_search'] == 'true') {
        $ops = array(
            'eq' => '=',
            'ne' => '<>',
            'lt' => '<',
            'le' => '<=',
            'gt' => '>',
            'ge' => '>=',
            'bw' => 'LIKE',
            'bn' => 'NOT LIKE',
            'in' => 'LIKE',
            'ni' => 'NOT LIKE',
            'ew' => 'LIKE',
            'en' => 'NOT LIKE',
            'cn' => 'LIKE',
            'nc' => 'NOT LIKE'
        );
        foreach ($ops as $key => $value) {
            if ($searchOper == $key) {
                $ops = $value;
            }
        }
        if ($searchOper == 'eq')
            $searchString = $searchString;
        if ($searchOper == 'bw' || $searchOper == 'bn')
            $searchString .= '%';
        if ($searchOper == 'ew' || $searchOper == 'en')
            $searchString = '%' . $searchString;
        if ($searchOper == 'cn' || $searchOper == 'nc' || $searchOper == 'in' || $searchOper == 'ni')
            $searchString = '%' . $searchString . '%';
        return "$searchField $ops '$searchString' ";
    }
}

function numeric($data) {
    if ($data == '') {
        $data = 0;
    }
    $numeric = str_replace(',', '', $data);
    return $numeric;
}

function datenotimes($tgl, $jam = true) {
    //Contoh Format : 2007-08-15 01:27:45
    if ($tgl == '0000-00-00' || empty($tgl)) {
        return '-';
    } else {
        $tanggal = strtotime($tgl);
        /* $bln_array = array (
          '01'=>'Januari',
          '02'=>'Februari',
          '03'=>'Maret',
          '04'=>'April',
          '05'=>'Mei',
          '06'=>'Juni',
          '07'=>'Juli',
          '08'=>'Agustus',
          '09'=>'September',
          '10'=>'Oktober',
          '11'=>'November',
          '12'=>'Desember'
          ); */
        $bln_array = array(
            '01' => 'JAN',
            '02' => 'FEB',
            '03' => 'MAR',
            '04' => 'APR',
            '05' => 'MEI',
            '06' => 'JUN',
            '07' => 'JUL',
            '08' => 'AGU',
            '09' => 'SEP',
            '10' => 'OKT',
            '11' => 'NOV',
            '12' => 'DES'
        );
        $hari_arr = array(
            '0' => 'Minggu',
            '1' => 'Senin',
            '2' => 'Selasa',
            '3' => 'Rabu',
            '4' => 'Kamis',
            '5' => 'Jum`at',
            '6' => 'Sabtu'
        );
        $tggl = date('d', $tanggal);
        $bln = @$bln_array[date('m', $tanggal)];
        //$bln = date('m', $tanggal);
        $thn = date('Y', $tanggal);
        $Jam = $jam ? date('H:i:s', $tanggal) : '';
        return "$tggl $bln $thn";
    }
}

function datetimes($tgl, $jam = true) {
    //Contoh Format : 2007-08-15 01:27:45
    if ($tgl == '0000-00-00' || empty($tgl)) {
        return '-';
    } else {
        $tanggal = strtotime($tgl);
        $bln_array = array(
            '01' => 'JAN',
            '02' => 'FEB',
            '03' => 'MAR',
            '04' => 'APR',
            '05' => 'MEI',
            '06' => 'JUN',
            '07' => 'JUL',
            '08' => 'AGU',
            '09' => 'SEP',
            '10' => 'OKT',
            '11' => 'NOV',
            '12' => 'DES'
        );
        $hari_arr = array(
            '0' => 'Minggu',
            '1' => 'Senin',
            '2' => 'Selasa',
            '3' => 'Rabu',
            '4' => 'Kamis',
            '5' => 'Jum`at',
            '6' => 'Sabtu'
        );
        $tggl = date('d', $tanggal);
        $bln = @$bln_array[date('m', $tanggal)];
        //$bln = date('m', $tanggal);
        $thn = date('y', $tanggal);
        $Jam = $jam ? date('H:i:s', $tanggal) : '';
        return "$Jam - $tggl $bln $thn";
    }
}

?>
