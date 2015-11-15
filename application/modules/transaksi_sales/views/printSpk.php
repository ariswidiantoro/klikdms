<style>
    .atas{ }
    .display td { height:0.8cm;font-size: 12px; padding-left:5px ;padding-right:5px ;border: 1px solid #000000;}
    .display1 td {font-size: 12px;padding-left:5px ;padding-right:5px ; }
    p{ font-size: 12px; height: 10px;padding-left: 5px;}
    li{ list-style-type: none;  text-align: right;}
    .display table{border-collapse: collapse; }
    body {margin:3px 3px 3px 3px; padding:0;font-family: monospace;}
    .print td {text-align: left; height: 0.43cm; font-size: 12px; }
    table{ border-collapse: collapse; }
    .print1 td {font-size: 12px; padding-left:5px ; padding-right:5px ;border: 1px solid #000000;text-align: left; } 
    p{ padding-right:20px ;text-align: right;}
    .ketentuan pre{ text-align: left; font-size: 8.3px; height:0.1cm; }
    .print1 pre{ font-size: 10px;}
    li{ list-style-type: none; text-align: right;}
</style>
<?php

function dealer($cabang, $alamat, $kota, $telp, $spk,$reprint) {
    ?>
<?php echo $reprint; ?>
    <div style="width: 100%;border:2px dotted #000000;">
        <table class="display1" style="margin-left:auto; margin-right: auto;">
            <tr valign="top" style="width: 18cm;">
                <td colspan="5" class="judul"></h2><h2 style=" text-align: center;"><b><?php echo "SURAT PESANAN KENDARAAN (SPK)" ?> </b></h2></td>    
            </tr>
        </table>
    </div>
    <?php
}

//$keterangan = (!empty($faktur->spk_descrip)) ? $faktur->spk_descrip : "";
//$jum = strlen($keterangan);
//$ket1 = substr($keterangan, 0, 30);
//$ket2 = substr($keterangan, 30, 30);
//$ket3 = substr($keterangan, 60, 30);
//$ket4 = substr($keterangan, 90, 30);
//$ket5 = substr($keterangan, 120, 30);
//$bayar = $faktur->byr_accessories + $faktur->byr_asuransi + $faktur->byr_um + $faktur->byr_lain;
//dealer((!empty($dealer->cb_name)) ? $dealer->cb_name : "", (!empty($dealer->cb_addr1)) ? $dealer->cb_addr1 : "", (!empty($dealer->cit_name)) ? $dealer->cit_name : "", (!empty($dealer->cb_phone1)) ? $dealer->cb_phone1 : "", (!empty($faktur->spk_spksno)) ? $faktur->spk_spksno : "",$reprint);
?>
<table style="width: 15cm; margin-left: auto;margin-right: auto;" >
    <tr>
        <td style="font-size: 11px; padding-left: 200px;">
            <?php
            echo "No.SPK:".$data['spk_no'] . "," . date("d-m-Y", strtotime($data['spk_tgl'])) . ", OTR: " . format_idr($data['fpt_total']);
            ?> 
        </td>
    </tr>
    <tr>
        <td style="font-size: 11px; padding-left: 200px;">
            <?php
            echo "No.kontrak:".$data['spk_nokontrak'] . ", Sales: " . $data['kr_nama'];
            ?> 
        </td>
    </tr>
</table>
<script>
    window.print();
    //window.open('transaksi_penjualan/print_blank','form', 'width=1200,height=600,resizeable,menubar=yes,scrollbars');
//    window.close();
</script>
