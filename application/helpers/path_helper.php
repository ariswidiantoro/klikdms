<?php

defined('BASEPATH') OR exit('No direct script access allowed');

//if (!function_exists('path_css')) {

function path_css() {
    $CI = & get_instance();
    return $CI->config->item('path_css');
}

//}

if (!function_exists('path_css_admin')) {

    function path_css_admin($uri = '') {
        $CI = & get_instance();
        return $CI->config->item('path_css_admin');
    }

}

/**
 * 
 */
if (!function_exists('path_js')) {

    function path_js($uri = '') {
        $CI = & get_instance();
        return $CI->config->item('path_js');
    }

}
/**
 * 
 */
if (!function_exists('path_docs')) {

    function path_docs($uri = '') {
        $CI = & get_instance();
        return $CI->config->item('path_docs');
    }

}
/**
 * 
 */
if (!function_exists('path_asset')) {

    function path_asset($uri = '') {
        $CI = & get_instance();
        return $CI->config->item('path_asset');
    }

}
/**
 * 
 */
if (!function_exists('path_upload')) {

    function path_upload($uri = '') {
        $CI = & get_instance();
        return $CI->config->item('path_upload');
    }

}
/**
 * 
 */
if (!function_exists('path_skin_images')) {

    function path_skin_images() {
        $CI = & get_instance();
        return $CI->config->item('path_skin_images');
    }

}
/**
 * 
 */
if (!function_exists('path_slides')) {

    function path_slides() {
        $CI = & get_instance();
        return $CI->config->item('path_slides');
    }

}

/**
 * 
 */
if (!function_exists('path_js_plugin')) {

    function path_js_plugin($uri = '') {
        $CI = & get_instance();
        return $CI->config->item('path_js_plugin');
    }

}
/**
 * 
 */
if (!function_exists('path_bootstrap')) {

    function path_bootstrap($uri = '') {
        $CI = & get_instance();
        return $CI->config->item('path_bootstrap');
    }

}
/**
 * 
 */
if (!function_exists('path_font_icons')) {

    function path_font_icons($uri = '') {
        $CI = & get_instance();
        return $CI->config->item('path_font_icons');
    }

}
/**
 * 
 */
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

//if (!function_exists('dateToIndo')) {
//    function dateToIndo($date = '') {
//        $part = explode(' ', $date);
//        if (count($part) > 1) {
//            $pecah = explode('-', $part[0]);
//            if (count($pecah) > 2) {
//                $getDate = $pecah[2] . '-' . $pecah[1] . '-' . $pecah[0];
//            } else {
//                $getDate = $date;
//            }
//            $getDate .= ' ' . $part[1];
//        } else {
//            $pecah = explode('-', $date);
//            if (count($pecah) > 2) {
//                $getDate = $pecah[2] . '-' . $pecah[1] . '-' . $pecah[0];
//            } else {
//                $getDate = $date;
//            }
//        }
//        return $getDate;
//    }

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

//}
?>
