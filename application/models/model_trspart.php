<?php

class Model_Trspart extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    function savePenerimaanBarang($data, $detail) {
        $result = array();
        $this->db->trans_begin();
        $tahun = substr(date('Y'), 2, 2);
        $id = sprintf("%08s", $this->getCounter("TB" . $tahun));
        $data['trbrid'] = "TB" . $tahun . $id;
        $this->db->INSERT('spa_trbr', $data);
        foreach ($detail as $value) {
            $value['dtr_trbrid'] = "TB" . $tahun . $id;
            $this->db->INSERT('spa_trbr_det', $value);
        }
        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            $result['result'] = true;
            $result['kode'] = "TB" . $tahun . $id;
            $result['msg'] = sukses("Berhasil menyimpan penerimaan barang");
        } else {
            $this->db->trans_rollback();
            $result['result'] = false;
            $result['kode'] = "TB" . $tahun . $id;
            $result['msg'] = error("Gagal menyimpan penerimaan barang");
        }
        return $result;
    }

    /**
     * 
     * @param type $trbrid
     * @return null
     */
    function dataFakturTerima($trbrid) {
        $sql = $this->db->query("SELECT * FROM spa_trbr LEFT JOIN ms_supplier ON supid = trbr_supid WHERE trbrid = '$trbrid'");
        if ($sql->num_rows() > 0) {
            return $sql->row_array();
        }
        return null;
    }

    /**
     * 
     * @param type $trbrid
     * @return null
     */
    function dataFakturTerimaDetail($trbrid) {
        $sql = $this->db->query("SELECT inve_kode, inve_nama, dtr_qty,dtr_harga,dtr_diskon,dtr_subtotal FROM spa_trbr_det LEFT JOIN spa_inventory ON inveid = dtr_inveid WHERE dtr_trbrid = '$trbrid'");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
        return null;
    }

}

?>
