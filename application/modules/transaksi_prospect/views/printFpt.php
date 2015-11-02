<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?>
<script type="text/javascript">
    window.print();
</script>
<style>
    body {background-color: white;}
    .prospek{ font-family:monospace; font-size:12px;

    }
    .prospek td{ line-height:15px}
    hr {
        height: 1px;
        margin: 0.5px 0;
        padding: 0;
        color:black;
        background-color: black;
        border: 0;
    }
</style>

<style>
    .atas{
    }
    .display td {
        height:0.8cm;
        font-size: 12px;
        padding-left:5px ;
        padding-right:5px ;
        border: 1px solid #000000;
    }
    .display1 td {
        font-size: 12px;
        padding-left:5px ;
        padding-right:5px ;
    }
    p{
        font-size: 12px;
        height: 10px;
        padding-left: 5px;
    }
    li{ list-style-type: none; 
        text-align: right;}
    .display table{
        border-collapse: collapse;  
    }
    body {margin:2px 2px 2px 2px; padding:0;}
    .print td {
        text-align: left; 
        height: 0.43cm;
        font-size: 12px;
    }
    table{
        border-collapse: collapse;
    }
    .print1 td {
        font-size: 12px;
        padding-left:5px ;
        padding-right:5px ;
        border: 1px solid #000000;
        text-align: left; 
    } 

    p{
        padding-right:15px ;
        text-align: right;
    }
    .ketentuan pre{
        text-align: left;
        font-size: 8.3px; 
        height:0.1cm; 
    }
    .print1 pre{ font-size: 10px;}
    li{ list-style-type: none; 
        text-align: right;}
    .tab{border: 0px ; font-size: 11px;}
    .tab tr{height: 18px;}
    .tab .conten{font-size: 11px;font-weight: bold;}
    .title{font-size: 15px;font-weight: bold;}
</style>
<?php //if (empty($output)) {
?>
<form method="POST" action="<?php echo site_url(); ?>/transaksi_prospecting/cetak_fpt"> 

<!--    <?php if ($fpt['fpt_print'] != 1) { ?>
        <div  style="align:left;">
            <button type="submit" style="border: 0; background: transparent;cursor: pointer;"  name="jenis" value="printer" id="print">
                <img src="<?php echo path_img(); ?>/printer.png" alt="submit"/> CETAK FPT
            </button>
            <input type="hidden" value="<?php echo $fpt['fptid']; ?>" id="selected" name="selected" >
        </div>
        <div align="right">

        </div><?php } ?>    -->

</form> 
<?php //} ?>
<?php

function dealer($cabang, $alamat, $kota, $telp, $spk, $tglfpt) {
    ?>
    <div style="width: 19cm; padding-right:100px  ; ">
        <table class="display1" style="margin-left:auto; margin-right: auto; font-family:monospace; font-size:12" border="0" width="100%">
            <tr valign="top" style="width: 20cm;">
                <td rowspan="4"><img src="<?php echo path_img() . ses_icon; ?>" width="50" height="50"/></td>

            </tr>
            <tr  >
                <td  style="width:13%;"><b>Nama Dealer</b></td><td>:</td>
                <td><?php echo $cabang; ?></td>


                <td colspan="6"  style="width:300px;"  ><h4><b><?php echo "FORMULIR PERSETUJUAN TRANSAKSI " ?> </b></h4></td>  
            </tr>
            <tr>
                <td  ><b>Alamat</b></td><td  >:</td>
                <td><?php echo $alamat . " " . $kota; ?></td>
                <td   colspan="3"  > <b>No.</b></td><td>:</td><td><?php echo "$spk"; ?></td>

            </tr>
            <tr>

                <td ><b>Telp</b></td><td>:</td>
                <td> <?php echo $telp; ?></td>

                <td colspan="3"><b>Tanggal</b></td><td>:</td>
                <td><?php echo $tglfpt; ?></td>

            </tr>

            <tr>

                <td colspan="12"> </td>

            </tr>

        </table>
    </div>
<?php } ?>

<?php
dealer((!empty($dealer['cb_nama'])) ? $dealer['cb_nama'] : "", (!empty($dealer['cb_alamat'])) ? $dealer['cb_alamat'] : "", (!empty($dealer['kota_deskripsi'])) ? $dealer['kota_deskripsi'] : "", (!empty($dealer['cb_telpon'])) ? $dealer['cb_telpon'] : "", (!empty($fpt['fpt_kode'])) ? $fpt['fpt_kode'] : "", date('d-m-Y', strtotime($fpt['fpt_tgl'])));
?>
<hr style="width: 100%;  border-color: black;border: 0.8px solid " ></div>
<!--- tengahhhhhhh ------------>
<div style="margin-top: 7px; width: 100%;">

    <table width="100%" border="0" class="prospek" cellspacing="1" style="font-size:11px ;padding: 0; ">
        <tr>
            <td  style="line-height:10px">Nama Sales</td>
            <td>:</td>
            <td>
                <?php
                if (!empty($fpt['kr_nama'])) {
                    echo strtoupper($fpt['kr_nama']);
                }
                ?>
                <hr />
            </td>
            <td>&nbsp;</td>
            <td>TOP</td>
            <td>:</td>
            <td>&nbsp; <hr /></td>
        </tr>

        <tr>
            <td width="195"  style="line-height:10px">Nama pembeli</td>
            <td width="9">:</td>
            <td width="347">
                <?php
                if (!empty($fpt['pros_nama'])) {
                    echo $fpt['pros_nama'];
                }
                ?>
                <input type="hidden" value="<?php echo $fpt['fpt_kode']; ?>" id="kodefpt" name="kodefpt" >
                <hr/></td>
            <td width="64">&nbsp;</td>
            <td width="66">Diskon</td>
            <td width="7">:</td>
            <td width="366"><div style="text-align:right;"> 
                    <?php
                    if (!empty($fpt['fpt_diskon'])) {
                        echo number_format($fpt['fpt_diskon']);
                    } else {
                        echo "&nbsp;";
                        ;
                    }
                    ?>
                </div><hr /></td>
        </tr>

        <tr>
            <td valign="top">Jenis dan type </td>
            <td>:</td>
            <td valign="top"> <?php echo $fpt['merk_deskripsi']; ?>   <?php echo $fpt['cty_deskripsi'] ?> <hr /></td>
            <td rowspan="2">&nbsp;</td>
            <td>Cost</td>
            <td>:</td>
            <td>&nbsp;<hr /></td>
        </tr>

        <tr>
            <td valign="top">Harga kosong</td>
            <td>:</td>
            <td valign="top"><div style="text-align:right;">
                    <?php
                    if ($fpt['fpt_hargako'] > 0) {
                        echo number_format($fpt['fpt_hargako']);
                    }
                    ?>
                </div><hr /></td>
            <td>OngKir </td>
            <td>:</td>
            <td>&nbsp;<hr />   </td>
        </tr>

        <tr>
            <td>BBN</td>
            <td>:</td>
            <td style="margin-top:100px"><div style="text-align:right;">
                    <?php
                    if ($fpt['fpt_bbn'] > 0) {
                        echo number_format($fpt['fpt_bbn']);
                    } else {
                        echo "&nbsp;";
                    }
                    ?>
                </div>
                <hr /></td>
            <td>&nbsp;</td>
            <td>Insentif</td>
            <td>:</td>
            <td><div style="text-align:right;">&nbsp;</div><hr /></td>
        </tr>
        <tr>
            <td  style="line-height:10px">Warna</td>
            <td>:</td>
            <td>
                <?php echo $fpt['warna_deskripsi']; ?>
                <hr />
            </td>
            <td>&nbsp;</td>
            <td>PDI</td>
            <td>:</td>
            <td><div style="text-align:right;">&nbsp;</div><hr /></td>
        </tr>

        <tr>
            <td valign="top">Komisi</td>
            <td>:</td>
            <td valign="top"><div style="text-align:right;">
                    <?php
                    if ($fpt['fpt_komisi'] > 0) {
                        echo number_format($fpt['fpt_komisi']);
                    } else {
                        echo "&nbsp;";
                        ;
                    }
                    ?> 
                </div><hr /></td>
            <td>&nbsp;</td>
            <td>Bonus Acce </td>
            <td>:</td>
            <td>&nbsp;<hr /></td>
        </tr>

        <tr>
            <td>Penerima </td>
            <td>:</td>
            <td> 
                <?php
                if (!empty($fpt['fpt_penerima_komisi'])) {
                    echo $fpt['fpt_penerima_komisi'];
                } else {
                    echo "&nbsp;";
                    ;
                }
                ?>
                <hr />   </td>
            <td >&nbsp;</td>
            <td>Lain Lain</td>
            <td>:</td>
            <td style="text-align:right;">

                    <?php
                    $lainlain = $fpt['fpt_asuransi'] + $fpt['fpt_karoseri'] + $fpt['fpt_administrasi'];
                    echo number_format($lainlain);
                    ?>
                <hr /></td>
        </tr>
        <!-- Transaksi Fleet ONLY -->
        <tr>
            <td>Jumlah Unit</td>
            <td>:</td>
            <td><div style="text-align:right;"><?php
                    $qty = ($fpt['fpt_qty'] < 1) ? '1' : $fpt['fpt_qty'];
                    echo $qty;
                    ?>
                </div><hr /></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Grand Total</td>
            <td>:</td>
            <td><div style="text-align:right;">
                    <?php
                    echo number_format(($fpt['fpt_hargako'] + $fpt['fpt_bbn']) * $qty);
                    ?>
                </div><hr /></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <!-- END Fleet -->
        <tr>
            <td rowspan="2" valign="top">Keterangan</td>
            <td rowspan="2" valign="top">:</td>
            <td rowspan="2" valign="top">
                <?php
                echo ((empty($fpt['leas_nama'])) ? "( TUNAI ) " : "( LEASING ) ");
                if (!empty($fpt['fpt_note'])) {
                    $keterangan = $fpt['fpt_note'];
                    $hasil = explode(" ", $keterangan);
                    $jumlah = count($hasil) - 1;
                    if ($jumlah > 0) {
                        $hasilbagi = $jumlah / 4;
                        $bagi = number_format($hasilbagi, 0);
                        $next1 = $bagi + $bagi;
                        $next2 = $bagi + $bagi + $bagi;
                        $next3 = $bagi + $bagi + $bagi + $bagi;
                    } else {
                        $bagi = 0;
                        $next1 = 0;
                        $next2 = 0;
                        $next3 = 0;
                    }
                    if ($jumlah > 0) {
                        for ($i = 0; $i <= $jumlah; $i++) {
                            if ($i == 8 or $i == 16 or $i == 24 or $i == 32) {
                                echo $hasil[$i] . "&nbsp;" . '<hr>';
                            } else {
                                echo $hasil[$i] . " ";
                            }
                        }
                    }
                } else {
                    echo "<hr>";
                    echo "<hr>";
                }
                ?>            &nbsp;<hr /></td>
            <td>&nbsp;</td>
            <td>Cashback</td>
            <td>:</td>
            <td><div style="text-align:right;">
                    <?php
                    if ($fpt['fpt_cashback'] > 0) {
                        echo number_format($fpt['fpt_cashback']);
                    } else {
                        echo "&nbsp;";
                        ;
                    }
                    ?>
                </div><hr /></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>Uang Muka</td>
            <td>:</td>
            <td><div style="text-align:right;">
                    <?php
                    if ($fpt['fpt_uangmuka'] > 0) {
                        echo number_format($fpt['fpt_uangmuka']);
                    } else {
                        echo "&nbsp;";
                        ;
                    }
                    ?>
                </div><hr /></td>
        </tr>

    </table>
    <!-- Baris Kedua -->
    <font size="2">Termasuk / Tidak Termasuk</font>
    <table width="100%" border="0" class="prospek" cellspacing="0" style="font-size:11px">
        <tr>
            <td width="17">&nbsp;</td>
            <td width="248">&nbsp;</td>
            <td width="9">&nbsp;</td>
            <td width="21">&nbsp;</td>
            <td width="179">&nbsp;</td>
            <td width="46"></td>
            <td width="91">&nbsp;</td>
            <td width="295" align="center">Cost</td>
            <td width="10"><div></td>
            <td width="142" align="center">Margin</td>
        </tr>
        <?php
        $jumlah = count($asesoris);
        $totalharga = 0;
        $totalcost = 0;
        $totalmargin = 0;
        for ($i = 0; $i <= 10; $i++) {

            // echo ($jumlah > 0 && $i <= ($jumlah-1))? "aksesoris = ".$asesoris[$i]->aks_name:"aksesoris = " ; 
            if ($jumlah > 0 && $i <= ($jumlah - 1)) {
                ?>
                <tr>
                    <td><?php echo $i + 1; ?></td>
                    <td><?php
        if (!empty($asesoris[$i]['aks_nama'])) {
            $namaasesoris = $asesoris[$i]['aks_nama'];
        } else {
            $namaasesoris = "-";
        }

        echo $namaasesoris;
                ?>
                        <hr /></td>
                    <td>&nbsp;</td>
                    <td>Rp</td>
                    <td> <div style="text-align:right;"><?php
                if (!empty($asesoris[$i]['fat_harga'])) {
                    $hargaasesoris = $asesoris[$i]['fat_harga'];
                } else {
                    $hargaasesoris = 0;
                }
                echo number_format($harga = $hargaasesoris);
                $totalharga = $totalharga + $hargaasesoris;
                ?></div><hr /></td>
                    <td>&nbsp;</td>
                    <td>(Paket/Biasa)</td>
                    <td><div style="text-align:right;"><?php
//      if(!empty($asesoris[$i]->fat_hpp)){$hppasesoris=$asesoris[$i]->fat_hpp;}else{$hppasesoris=0;}
//    echo number_format($hpp= $hppasesoris);
//    $totalcost=$totalcost+$asesoris[$i]->fat_hpp;
                    echo "&nbsp;";
                ?></div>
                        <hr /></td>
                    <td width="10"><div style="height:auto;background-color:#0000FF"></div>&nbsp;</td>
                    <td><div style="text-align:right;">
                            <?php
                            echo "&nbsp;";
//    echo number_format($hpp= $harga-$hpp);
// $totalmargin=$totalmargin+$hpp;
                            ?></div>
                        <hr /></td>
                </tr><?php
                } else {
                            ?><tr>
                    <td><?php echo $i + 1; ?></td>
                    <td>
                        <?php
                        if (!empty($asesoris[$i]['aks_nama'])) {
                            $namaasesoris = $asesoris[$i]['aks_nama'];
                        } else {
                            $namaasesoris = "-";
                        }

                        echo $namaasesoris;
                        ?>
                        <hr /></td>
                    <td>&nbsp;</td>
                    <td>Rp</td>
                    <td  > <div style="text-align:right;">&nbsp;</div><hr /></td>
                    <td>&nbsp;</td>
                    <td>(Paket/Biasa)</td>
                    <td><div style="text-align:right;"> &nbsp; </div>
                        <hr /></td>
                    <td width="10"><div style="height:auto;background-color:#0000FF"></div>&nbsp;</td>
                    <td><div style="text-align:right;"> &nbsp;</div>
                        <hr /></td>
                </tr><?php
            }
        }
                ?>
        <tr>
            <td>&nbsp;</td>
            <td>
                Sub Total Asesoris      </td>
            <td>&nbsp;</td>
            <td>Rp </td>
            <td><div style="text-align:right;">
                    <?php
                    $subtotalasesoris = number_format($hargasubtotalasesoris = $totalharga);
                    if ($subtotalasesoris == 0) {
                        echo "&nbsp;";
                    } else {
                        echo $subtotalasesoris;
                    }
                    ?> 
                </div><hr /></td>
            <td></td>
            <td></td>
            <td><div style="text-align:right;"><?php echo "&nbsp;"; // echo number_format($totalcost);                                ?></div>
                <hr /></td>
            <td width="10">&nbsp;</td>
            <td><div style="text-align:right;"><?php echo "&nbsp;"; //number_format($totalmargin);                               ?></div>
                <hr /></td>
        </tr>
        <tr>
            <td></td>
            <td>
                Total Harga      </td>
            <td>&nbsp;</td>
            <td>Rp </td>
            <td><div style="text-align:right;">
                    <?php
//                    if ($lainlain > 0 or $fpt['fpt_hargako'] or $hargasubtotalasesoris > 0) {

                    echo number_format($fpt['fpt_total']);
//                    }
                    ?> 
                </div><hr /></td>
            <td></td>
            <td></td>
            <td>Total Margin Kendaraan +Acc</td>
            <td width="10">&nbsp;</td>
            <td><div style="text-align:right;">
                    <?php
                    echo "&nbsp;";
//       if(!empty($fpt->cty_hpp)){$hpptype=$fpt->cty_hpp;}else{$hpptype=0;}
//      $total_kendaraanacc=$hargakosong-$hpptype+$totalmargin;
//     echo number_format($total_kendaraanacc)
                    ?>
                </div>
                <hr /></td>
        </tr>
    </table>
    <div style="margin-top:20px"></div>
    <font size="1"><?php
                    date_default_timezone_set("Asia/Jakarta");
                    echo "&nbsp;";
                    echo "&nbsp;";
                    echo ses_kota . ", ";
                    echo date("d-m-Y") . "," . date("h:i");
                    ?></font>
    <table width="69%" border="0" class="prospek">
        <tr>
            <td width="31%" align="center">Diperiksa</td>
            <td width="8%" align="center">&nbsp;</td>
            <td width="28%" align="center">Diajukan</td>
            <td width="8%" align="center">&nbsp;</td>
            <td width="25%" align="center">Disetujui</td>
        </tr>
        <tr>
            <td style="height:1cm">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td align="center"><hr />Kasir/Keuangan ADH </td>
            <td align="center">&nbsp;</td>
            <td align="center"><hr />Supervisor </td>
            <td align="center">&nbsp;</td>
            <td align="center"><hr />Pimpinan Cabang</td>
        </tr>
    </table>


    <p>&nbsp;</p>
