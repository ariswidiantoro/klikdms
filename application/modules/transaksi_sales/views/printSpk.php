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
$harga = (($faktur->spk_aksesoris + $faktur->spk_bbn + $faktur->spk_hargako + $faktur->spk_lain + $faktur->spk_admin + $faktur->spk_asuransi + $faktur->spk_karharga) - ($faktur->spk_disc));

//dealer((!empty($dealer->cb_name)) ? $dealer->cb_name : "", (!empty($dealer->cb_addr1)) ? $dealer->cb_addr1 : "", (!empty($dealer->cit_name)) ? $dealer->cit_name : "", (!empty($dealer->cb_phone1)) ? $dealer->cb_phone1 : "", (!empty($faktur->spk_spksno)) ? $faktur->spk_spksno : "",$reprint);
?>
<table style="width: 15cm; margin-left: auto;margin-right: auto;" >
    <tr>
        <td style="font-size: 11px; padding-left: 200px;">
            <?php
            echo "No.SPK:".$faktur->spk_spksno . "," . date("d-m-Y", strtotime($faktur->spk_date)) . ", OTR: " . format_idr($harga);
            ?> 
        </td>
    </tr>
    <tr>
        <td style="font-size: 11px; padding-left: 200px;">
            <?php
            echo "No.kontrak:".$faktur->spk_no . ", Sales: " . $faktur->kr_fullname;
            ?> 
        </td>
    </tr>
</table>
<!--- tengahhhhhhh ------------>
<!--<div style="border:2px dotted #000000;">
    <div id="tengah" class="print" style="margin-top: 0.2cm; width:  100%; border: 0px solid #000000;">
        <table cellpadding="0" cellspacing="0" border="0" class="example" style="width: 15cm; margin-left: auto;margin-right: auto;" >
            <tr>
                <td style="width:2.8cm;">Nama Pembeli</td>
                <td style="width:0.5cm;">:</td>
                <td style="width:6.2cm;"><?php echo $faktur->pros_name; ?></td>
                <td style="width:1.8cm;"></td>
                <td style="width:0.5cm;"></td>
                <td colspan="3" style="width:5.2cm;"</td>
            </tr>
            <tr>
                <td style="width:2.8cm;">Nomer Pemesanan</td>
                <td style="width:0.5cm;">:</td>
                <td style="width:6.2cm;"><?php echo $faktur->spk_spksno; ?></td>
                <td style="width:1.8cm;"></td>
                <td style="width:0.5cm;"></td>
                <td colspan="3" style="width:5.2cm;"</td>
            </tr>
            <tr>
                <td style="width:2.8cm;">Tanggal</td>
                <td style="width:0.5cm;">:</td>
                <td style="width:6.2cm;"><?php echo date("d-m-Y", strtotime($faktur->spk_date)); ?></td>
                <td style="width:1.8cm;"></td>
                <td style="width:0.5cm;"></td>
                <td colspan="3" style="width:5.2cm;"</td>
            </tr>
            <tr>
                <td style="width:2.8cm;">Sales</td>
                <td style="width:0.5cm;">:</td>
                <td style="width:6.2cm;"><?php echo $faktur->kr_fullname; ?></td>
                <td style="width:1.8cm;"></td>
                <td style="width:0.5cm;"></td>
                <td colspan="3" style="width:5.2cm;"</td>
            </tr>
            <tr>
                <td style="width:2.8cm;">Merk</td>
                <td style="width:0.5cm;">:</td>
                <td style="width:6.2cm;"><?php echo $faktur->cbr_name; ?></td>
                <td style="width:1.8cm;"></td>
                <td style="width:0.5cm;"></td>
                <td colspan="3" style="width:5.2cm;"</td>
            </tr>
            <tr>
                <td style="width:2.8cm;">Type</td>
                <td style="width:0.5cm;">:</td>
                <td style="width:6.2cm;"><?php echo $faktur->cty_type; ?> </td>
                <td style="width:1.8cm;"></td>
                <td style="width:0.5cm;"></td>
                <td colspan="3" style="width:5.2cm;"</td>
            </tr>
            <tr>
                <td style="width:2.8cm;">Warna</td>
                <td style="width:0.5cm;">:</td>
                <td style="width:6.2cm;"><?php echo $faktur->cco_name; ?></td>
                <td style="width:1.8cm;"></td>
                <td style="width:0.5cm;"></td>
                <td colspan="3" style="width:5.2cm;"</td>
            </tr>
            <tbody>        
            </tbody>
        </table>
    </div>
    <div align="left" class="print1" id="harga" style="margin-top: 0.42cm; width: 100%;  ">
        <table style="width: 15cm; margin-left: auto;margin-right: auto;" >
            <tr>
                <td style=" border-top: 0; border-left: 0; width: 60%;"></td>
                <td style="text-align: center; font-size: 13px;">HARGA</td>

            </tr>
            <tr>
                <td style="width: 6cm;">1. Harga Mobil</td>
                <td style="width: 4cm;"><p><?php echo format_idr($faktur->spk_hargako); ?></p></td>

            </tr>
            <tr>
                <td> 2. Bea Balik Nama</td>
                <td><p><?php echo format_idr($faktur->spk_bbn); ?></p></td>

            </tr>
            <tr>
                <td> 3. Accesoris</td>
                <td><p><?php echo format_idr($faktur->spk_aksesoris); ?></p></td>

            </tr>
            <tr>
                <td> 4. Asuransi</td>
                <td><p><?php echo format_idr($faktur->spk_asuransi); ?></p></td>

            </tr>
            <tr>
                <td> 5. Karoseri</td>
                <td><p><?php echo format_idr($faktur->spk_karharga); ?></p></td>

            </tr>
            <tr>
                <td> 6. Administrasi</td>
                <td><p><?php echo format_idr($faktur->spk_admin); ?></p></td>

            </tr>
            <tr>
                <td> 7. Diskon</td>
                <td><p><?php echo format_idr($faktur->spk_disc); ?></p></td>

            </tr>
            <tr>
                <td> 8. Cashback</td>
                <td><p><?php echo format_idr($faktur->spk_cback); ?></p></td>

            </tr>
            <tr valign="top">
                <td>9. Lain-Lain</td>
                <td><p><?php echo format_idr($faktur->spk_lain); ?></p></td>

            </tr>
            <tr>
                <td style=" border-bottom: 0; border-left: 0; text-align: right;"> JUMLAH</td>
                <td><p><?php echo format_idr($harga); ?></p></td>

            </tr>
        </table>

    </div>

    <div class="print" style="width: 100%; border: 0px solid #000000; margin-top: 0.1cm;">
        <table style="width: 18cm;" border="0" cellpadding="0" cellspacing="0">
            <tr><td colspan="3"></td></tr>
            <tr><td colspan="3" style="padding-left: 0.7cm;"><?php echo date('d-m-Y H:i:s'); ?></td></tr>
        </table>
    </div>
                           ////////////////////////////////////////////////// TTUTJ
</div>-->
<script>
    window.print();
    //window.open('transaksi_penjualan/print_blank','form', 'width=1200,height=600,resizeable,menubar=yes,scrollbars');
    window.close();
</script>