<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Welcome extends Application {

    // INI WELCOME BAWAH
    // INI BAWAH
    public function __construct() {
        parent::__construct();
    }
    
    // INI WELCOME GITHUB ATAS

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -  
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in 
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function index() {
        $this->load->model('model_admin');
        $this->load->view('attribut/login', $this->data);
    }

//    public function admin() {
//        $this->load->model('model_admin');
//        $this->data['header'] = $this->model_admin->getMenuModule();
//        $this->data['menuid'] = '6';
//        $this->load->view('template', $this->data);
//    }

    public function logout() {
        $arrdata = array('username_adm' => $this->session->userdata('username_adm'),
            'login_administr' => $this->session->userdata('login_administr'));
        $this->session->unset_userdata($arrdata);
        $this->session->sess_destroy();
        redirect('welcome/login');
    }

    public function login() {
        $this->load->model('model_admin');
        $this->load->view('attribut/login', $this->data);
    }

    public function akses() {
        $this->data['content'] = 'attribut/akses';
        $this->load->view('attribut/akses', $this->data);
//        $this->load->view('attribut/akses');
    }

    public function home() {
        $this->load->model('model_admin');
        $this->load->model('model_admin');
        $this->data['header'] = $this->model_admin->getMenuModule();
        $this->data['content'] = 'attribut/home';
        $this->data['menuid'] = '0';
        $this->load->view('template', $this->data);
    }

    public function prosesLogin() {
        $this->load->model('model_admin');
        $this->form_validation->set_rules('cbid', '<b>Fx</b>', 'required|callback_validtelp|xss_clean');
        $this->form_validation->set_rules('username', '<b>Fx</b>', 'required|callback_validtelp|xss_clean');
        $this->form_validation->set_rules('password', '<b>Fx</b>', 'required|callback_validtelp|xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $username = $this->input->post('username');
            $cbid = $this->input->post('cbid');
            $user = array(
                'cbid' => $cbid,
                'username' => $username,
                'password' => sha1($this->input->post('password')),
            );

            $login = $this->model_admin->login($user);
            if ($login) {
                $data_user = $this->model_admin->getUser($username);
                $cbg = $this->model_admin->getCabangById($cbid);
                $this->session->set_userdata('username', $username);
                $this->session->set_userdata('nama', $data_user['kr_nama']);
                $this->session->set_userdata('cbid', $cbid);
                $this->session->set_userdata('dealer', $data_user['cb_nama']);
                $this->session->set_userdata('alamat', $data_user['cb_alamat']);
                $this->session->set_userdata('cb_nama', $cbg['cb_nama']);
                $this->session->set_userdata('phone', $cbg['cb_telpon']);
                $this->session->set_userdata('icon', $cbg['cb_icon']);
                $this->session->set_userdata('npwp', $cbg['cb_npwp']);
                $this->session->set_userdata('kota', $cbg['kota_deskripsi']);
                $this->session->set_userdata('krid', $data_user['krid']);
                $this->session->set_userdata('isLogin', 'true');
                $this->session->set_userdata('settingCoa', $setting);
                redirect('welcome/home');
            } else {
                $this->session->set_flashdata('msg', $this->error("Username / Password Tidak Terdaftar"));
                redirect('welcome/login');
            }
        }
    }

    /**
     * Function ini digunakan untuk menghapus data acount/kontak kami
     * @since 1.0
     * @author Aris
     */
    public function getMenuUser() {
        $this->load->model('model_admin');
        $hasil = $this->model_admin->getMenuUser();
//        $hasil = $this->model_admin->getMenu();
        echo json_encode($hasil);
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
