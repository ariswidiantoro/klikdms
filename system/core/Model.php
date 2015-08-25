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
        $sql = "SELECT setting_value FROM setting WHERE setting_id = '" . $key . "' FOR UPDATE";
        $sql = $this->db->QUERY($sql);
        if ($sql->num_rows() > 0) {
            $row = $sql->row();
            $counter = intval($row->setting_value) + 1;
            $datas = array(
                'setting_value' => $counter
            );
            $this->db->UPDATE('setting', $datas, array('setting_id' => $key));
        } else {
            $this->db->INSERT('setting', array('setting_id' => $key, 'setting_value' => '1'));
            $counter = '1';
        }
        return $counter;
    }

}

// END Model Class

/* End of file Model.php */
/* Location: ./system/core/Model.php */