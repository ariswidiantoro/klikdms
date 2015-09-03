<?php
/**
 * The MODEL SETTING
 * @author Rossi Erl
 * 2013-12-13
 */

class Model_Setting extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function newCode($data) {
        $current_year = date("y");
        if (!empty($data['type'])) {
            $nomer = $data['type'];
        }else{
            $back['status'] = FALSE;
            $back['code'] = 0;
            return $back;
        }
        
        $sql = "SELECT nmr_value FROM ms_numerator WHERE  nmr_key = '" . $nomer . "' FOR UPDATE ";
        $sql = $this->db->query($sql);
        if ($sql->num_rows() > 0) {
            $row = $sql->row();
            $counter = intval($row->nmr_value);
            $counter = sprintf("%09s", $counter + 1);
            $datas = array(
                'nmr_value' => $counter
            );
            $query = "UPDATE " . $this->tab_numerator . " SET nmr_value = '" . $counter . "' WHERE nmr_key = '" . $nomer . "'";
            $cek = $this->db->query($query);
        } else {
            $cek = $this->db->insert($this->tab_numerator, array('nmr_key' => $nomer, 'nmr_value' => '000000001'));
            $counter = '000000001';
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
?>
