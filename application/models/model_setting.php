<?php
/**
 * The MODEL SETTING
 * @author Rossi Erl
 * 2013-12-13
 */
class Model_Setting extends CI_Model {

    public function __construct() {
        parent::__construct();
        $pre = array();
        $ccid = array();
        $CI = &get_instance();

        if ($this->config->item("config_coa") && isLogin) {
            $this->db->where('setcoa_cbid', ses_cabang);
            $pr = $this->db->get("ms_coa_setting")->result();
            foreach ($pr as $p) {
                $pre[addslashes($p->setcoa_specid)] = addslashes($p->setcoa_kode);
            }

            $CI->pref = (object) $pre;
            if (count($CI->pref) > 0) {
//                define('UANGMUKA_UNIT', $this->pref->SC01);
//                define('UANGMUKA_SERVICE', $this->pref->SC02);
//                define('UANGMUKA_SPART', $this->pref->SC03);
//                define('UANGMUKA_BREPAIR', $this->pref->SC04);
//                define('PIUTANG_UNIT', $this->pref->SC05);
//                define('PIUTANG_SERVICE', $this->pref->SC06);
//                define('PIUTANG_SPART', $this->pref->SC07);
//                define('PIUTANG_BREPAIR', $this->pref->SC08);
//                define('HUTANG_UNIT', $this->pref->SC09);
//                define('HUTANG_SPART', $this->pref->SC10);
//                define('HUTANG_PPN', $this->pref->SC11);
//                define('DISKON_UNIT_BARU', $this->pref->SC12);
            }
            /* SETTING COA */


            $this->db->where('cc_cbid', ses_cabang);
            $pr = $this->db->get("ms_cost_center")->result();
            foreach ($pr as $p) {
                $pre[addslashes($p->setcoa_specid)] = addslashes($p->setcoa_kode);
            }

            $CI->cc = (object) $pre;
            /* SETTING COA */
//            define('CC_SALES', $this->cc->SC01);
//            define('CC_SERVICE', $this->cc->SC02);
//            define('CC_SPART', $this->cc->SC03);
//            define('CC_BREPAIR', $this->cc->SC04);
        }
    }

}

?>
