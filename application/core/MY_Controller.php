<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
  |--------------------------------------------------------------------------
  | Class Application
  | merupakan class dasar atau parent class dari setiap class yang akan dibuat
  | dalam aplikasi Sun Motor System
  |--------------------------------------------------------------------------
 */
class Application extends CI_Controller {

    protected $template;                //variabel untuk menyimpan data nama dari template
    protected $data = array();    //variabel array untuk menyimpan data-data yang akan ditampilkan pada view
    protected $box;
    protected $main;
    protected $cabang;

    public function __construct() {

        /**
          |  fungsi untuk menjalankan session
          |  pada beberapa kasus kadang browser tidak bisa menjalankan fungsi session yang ada di CI
         */
        //session_start();

        parent::__construct();


        $this->template = 'template';
        $this->main = 'main';
        $this->box = 'box';

        /**
          |  memanggil file konfigurasi system_config
          |  file tersebut berisi konfigurasi dasar dari aplikasi seperti nama sistem, nama perusahaan, alamat dll.
          |  lokasi : application/config/
         */
        $this->config->load('system_config');

        /**
          |  memanggil file helper system_helper
          |  file tersebut berisi fungsi-fungsi dasar dari aplikasi seperti :
          |  name_system() yang berfungsi memanggil nama dari sistem
          |  company()     yang berfungsi untuk memanggil nama dari perusahaan, dll.
          |  lokasi : application/helpers/
         */
//        $this->load->helper(array('system_helper'));

        /**
          |  memanggil file library system
          |  merupakan file class yang berisi fungsi-fungsi untuk membantu menjalankan aplikasi seperti :
          |  mengkonversi tanggal dari database ke dalam bentuk tanggal bahasa indonesia, dll.
          |  lokasi : application/libraries/
         */
        $this->load->library(array('cache', 'session'));

        /*
          |  merupakan file model yang berfungsi untuk memanggil data-data yang sering digunakan dari database
         */



        /**
         * fugnsi untuk mengecek user pada posisi sudah login atau belum login
         */
    }

    public function sukses($msg = "") {
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

    public function error($msg = "") {
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

    public function to_indonesia($date) {
        $day_ex = explode('/', $date);
        return $day_ex[2] . '/' . $day_ex[1] . '/' . $day_ex[0];
    }

    /*
     * method untuk menampikan pesan keberhasilan dalam melakukan sesuatu
     */

    public function done($msg = "") {
        return "<div class='alert alert-info'>$msg</div>";
    }

    public function edit($onclick = "") {
        return "<a href='javascript:;' onclick='" . $onclick . "' class='green' title='Edit'><i class='icon-pencil bigger-130'></i></a>";
    }

    public function hapus($onclick = "") {
        return "<a href='javascript:void(0)' onclick='" . $onclick . "' class='red' title='Delete'><i class='icon-trash bigger-130'></i></a>";
    }

    /*
     * method untuk menampikan pesan kesalahan
     */

    protected function isLogin() {
        $login = isLogin;
        if (empty($login)) {
            redirect(site_url("welcome/index"));
        }
    }

    /*
     * method untuk menampikan pesan kesalahan
     */

    protected function hakAkses($id) {
        $this->load->model('model_admin');
        $check = $this->model_admin->hakAkses($id);
        if (!$check) {
//            $this->load->view('attribut/akses', $this->data);
            redirect(site_url("welcome/akses"));
        }
    }

    protected function send_email($data) {
        $this->load->library('phpmailer');
        try {
            $mail = new PHPMailer(true);
            $msg = '<html><body><p>' . $data['message'] . '</p></body></html>';
            $body = preg_replace('/\\\\/', '', $msg);
            $mail->IsSMTP();
            $mail->SMTPAuth = true;
            $this->Port = 465;
            $this->SMTPSecure = "ssl";
            $this->Host = "ssl://smtp.gmail.com";
            $this->Username = "aris.widian@gmail.com";
            $this->Password = "d1d1kpurhartono";
            $mail->IsSendmail();
            $mail->From = "aris.widian@gmail.com";
            $mail->FromName = "OnyxTech";
            if (!empty($data['to2'])) {
                $mail->AddAddress($data['to']);
                $mail->AddAddress($data['to2']);
            } else {
                $mail->AddAddress($data['to']);
            }
            $mail->Subject = $data['subject'];
            $mail->WordWrap = 80;
            $mail->MsgHTML($body);
            $mail->IsHTML(true); // 
            log_message('error', 'test5');
            $mail->Send();
            log_message('error', 'test6');

            return true;
        } catch (phpmailerException $e) {
            return false;
        }
        return false;
    }

}

?>