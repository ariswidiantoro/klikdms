<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		EllisLab Dev Team
 * @copyright		Copyright (c) 2008 - 2014, EllisLab, Inc.
 * @copyright		Copyright (c) 2014 - 2015, British Columbia Institute of Technology (http://bcit.ca/)
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */
// ------------------------------------------------------------------------

/**
 * CodeIgniter Model Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		EllisLab Dev Team
 * @link		http://codeigniter.com/user_guide/libraries/config.html
 */
class CI_Model {

    /**
     * Constructor
     *
     * @access public
     */
    function __construct() {
        log_message('debug', "Model Class Initialized");
    }

    /**
     * __get
     *
     * Allows models to access CI's loaded classes using the same
     * syntax as controllers.
     *
     * @param	string
     * @access private
     */
    function __get($key) {
        $CI = & get_instance();
        return $CI->$key;
    }

    function getCounter($key) {
        $sql = "SELECT set_value FROM setting WHERE set_key = '" . $key . "' FOR UPDATE";
        $sql = $this->db->QUERY($sql);
        if ($sql->num_rows() > 0) {
            $row = $sql->row();
            $counter = intval($row->set_value) + 1;
            $datas = array(
                'set_value' => $counter
            );
            $this->db->UPDATE('setting', $datas, array('set_key' => $key));
        } else {
            $this->db->INSERT('setting', array('set_key' => $key, 'set_value' => '1'));
            $counter = '1';
        }
        return $counter;
    }
    
    function getCounterCabang($key) {
        $sql = "SELECT set_value FROM setting WHERE set_key = '" . $key . "' AND set_cbid = '".ses_cabang."' FOR UPDATE";
        $sql = $this->db->QUERY($sql);
        if ($sql->num_rows() > 0) {
            $row = $sql->row();
            $counter = intval($row->set_value) + 1;
            $datas = array(
                'set_value' => $counter
            );
            $this->db->UPDATE('setting', $datas, array('set_key' => $key, 'set_cbid' => ses_cabang));
        } else {
            $this->db->INSERT('setting', array('set_key' => $key, 'set_value' => '1', 'set_cbid' => ses_cabang));
            $counter = '1';
        }
        return $counter;
    }
    
    public function newCode($data) {
        $current_year = date("y");
        //$data['cbid'] = (empty($data['cbid']))?ses_cabang:$data['cbid'];
        if(empty($data['cbid'])){
            $filter = " ";
        }else{
            $filter = " AND nmr_cbid = '".$data['cbid']."' ";
        }
        if (!empty($data['type'])) {
            $nomer = $data['type'].$current_year;
        }else{
            $back['status'] = FALSE;
            $back['code'] = 0;
            return $back;
        }
        
        $sql = "SELECT nmr_value FROM ms_numerator WHERE  nmr_key = '" . $nomer . "' 
            ".$filter." FOR UPDATE ";
        $sql = $this->db->query($sql);
        if ($sql->num_rows() > 0) {
            $row = $sql->row();
            $counter = intval($row->nmr_value);
            $counter = sprintf("%08s", $counter + 1);
            $datas = array(
                'nmr_value' => $counter
            );
            $query = "UPDATE ms_numerator SET nmr_value = '" . $counter . "' 
                WHERE nmr_key = '" . $nomer . "' ".$filter;
            $cek = $this->db->query($query);
        } else {
            $dataInsert = array(
                            'nmr_key' => $nomer, 
                            'nmr_value' => '00000001'
                            );
            if(!empty($data['cbid'])) $dataInsert['nmr_cbid'] = $data['cbid'];
            $cek = $this->db->insert('ms_numerator', $dataInsert);
            $counter = '00000001';
        }

        if ($cek > 0) {
            $nomer = $nomer . $counter;
            $back['status'] = TRUE;
            $back['code'] = $nomer;
        } else {
            $back['status'] = FALSE;
            $back['code'] = 0;
        }
        return $back;
    }

}

// END Model Class

/* End of file Model.php */
/* Location: ./system/core/Model.php */
