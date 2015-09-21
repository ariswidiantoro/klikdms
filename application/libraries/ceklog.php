<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ceklog {

    var $CI;

    function __construct() {
        $this->CI = & get_instance();
    }

    function isLogin() {
        if ($this->CI->session->userdata('admin_usersentolo') and $this->CI->session->userdata('admin_passsentolo') and $this->CI->session->userdata('admin_idsentolo') == TRUE) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function isLoginsiswa() {
        if ($this->CI->session->userdata('siswa_usersentolo') and $this->CI->session->userdata('siswa_passsentolo') and $this->CI->session->userdata('siswa_idsentolo') == TRUE) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function checkAdmin() {
        if ($this->isLogin() != TRUE) {
            $this->CI->session->set_flashdata('msg', '<p class="msg error">Maaf, Anda tidak Berhak Mengakses</p>');
            redirect('sentolo_adm');
        }
    }

    function checksiswa() {
        if ($this->isLoginsiswa() != TRUE) {
            $this->CI->session->set_flashdata('msg', '<p class="msg error">Maaf, Anda tidak Berhak Mengakses</p>');
            redirect('index.php');
        }
    }

    function path_fck() {
        return path_js() . 'fckeditor/';
    }

    function path_highslide() {
        return '/dev_sma/media/js/highslide/graphics/';
    }

}

?>
