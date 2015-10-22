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
<?php

function dealer($cabang, $alamat, $kota, $telp, $spk, $tglbpk) {
    ?>
    <div style="width: 18cm; padding-right:100px  ;"  >
        <table class="display1" style="margin-left:auto; margin-right: auto;" border="0">
            <tr valign="top" style="width: 22cm;">
                <td rowspan="4"><img src="<?php echo path_img().ses_icon; ?>" width="50" height="50"/></td>
            </tr>
            <tr  >
                <td  style="width:20%;"><b>Nama Dealer</b></td><td>:</td>
                <td><?php echo $cabang; ?></td>


                <td colspan="6"    ><h3><b><?php echo "BUKTI MASUK KENDARAAN (BMK)" ?> </b></h3></td>  
            </tr>
            <tr>
                <td><b>Alamat</b></td><td>:</td>
                <td><?php echo $alamat . " " . $kota; ?></td>
                <td   colspan="3"  > <b>No.</b></td><td>:</td><td><?php echo "$spk"; ?></td>

            </tr>
            <tr>

                <td ><b>Telp</b></td><td>:</td>
                <td> <?php echo $telp; ?></td>

                <td colspan="3"><b>Tanggal</b></td><td>:</td>
                <td><?php echo $tglbpk ?></td>

            </tr>
            <tr>
                <td > </td><td> </td>

                <td colspan="4">

                </td>

            </tr>
            <tr>

                <td colspan="3"></td>

            </tr>

        </table>
    </div>
    <div style="margin-top: 10px; width: 22cm;"><hr style="width: 22cm;"></div>
    <?php
}

$keterangan = $bpk['bpk_keterangan'];
dealer((!empty($dealer['cb_nama'])) ? $dealer['cb_nama'] : "", (!empty($dealer['cb_alamat'])) ? $dealer['cb_alamat'] : "", (!empty($dealer['kota_deskripsi'])) ? $dealer['kota_deskripsi'] : "", (!empty($dealer['cb_telpon'])) ? $dealer['cb_telpon'] : "", (!empty($bpk['bpk_nomer'])) ? $bpk['bpk_nomer'] : "", date('d-m-Y', strtotime($bpk['bpk_tgl'])));
?>
<!--- tengahhhhhhh ------------>
<div style="padding-left:15px ;" >
    <!-- Penerima      -->
    <table border="0"  class="tab" width="100%">
        <tr>
            <td>
                <b  class="title" >Diterima Dari</b>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="conten">
                Nama
            </td>
            <td >
                :
            </td>
            <td>
                <?php echo $bpk['sup_nama']; ?>
            </td>
            <td>NO DO Suplier</td>
            <td>:</td>
            <td> <?php echo $bpk['bpk_nodo']; ?></td>
        </tr>
        <tr>
            <td colspan="2"  class="conten">
                Alamat
            </td>
            <td> :</td>
            <td>
                <?php echo $bpk['sup_alamat'];
                ?>
            </td>
            <td>NO PO</td>
            <td>:</td>
            <td> <?php
                echo $bpk['bpk_nopo'];
                ?></td>
        </tr>

    </table>
    <p style="margin-top: 1px;"></p>
    <!-- data Kendaraan      -->
    <table border="0" class="tab" width="100%" >
        <tr>
            <td>
                <b class="title">Data Kendaraan</b>          </td>
            <td colspan="3">&nbsp;</td>
            <td colspan="5">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2"  class="conten">Merk</td>
            <td >&nbsp;</td>
            <td style="width:300px;" ><?php echo $bpk['merk_deskripsi']; ?></td>
            <td class="conten">No Stock</td>
            <td >:</td>
            <td><span style="width:300px;"><?php echo $bpk['bpk_nomer']; ?></span></td>
        </tr>
        <tr>
            <td colspan="2"  class="conten">Norangka</td>
            <td >
                :          </td>
            <td style="width:300px;" ><?php echo $bpk['msc_norangka']; ?></td>
            <td class="conten">
                Type</td>
            <td >
                :          </td>
            <td><span style="width:300px;"><?php echo $bpk['cty_deskripsi']; ?></span></td>
        </tr>
        <tr>
            <td colspan="2" class="conten">Tahun</td>
            <td>
                :          </td>
            <td><?php echo $bpk['msc_tahun']; ?></td>
            <td class="conten">
                No Mesin</td>
            <td >
                :          </td>
            <td><?php echo $bpk['msc_nomesin']; ?></td>
        </tr>
        <tr>
            <td colspan="2" class="conten">Keadaan</td>
            <td >
                :          </td>
            <td><?php
                echo $bpk['msc_kondisi'];
                ?></td>
            <td class="conten">
                Warna</td>
            <td >
                :          </td>
            <td><?php echo $bpk['warna_deskripsi']; ?></td>
        </tr>
        <tr>
            <td colspan="2" class="conten">&nbsp;</td>
            <td>&nbsp;                       </td>
            <td class="conten">&nbsp;</td>
            <td class="conten">No seri</td>
            <td >
                :          </td>
            <td><?php echo $bpk['msc_bodyseri']; ?></td>
        </tr>
        <tr>
            <td colspan="2" class="conten">&nbsp;</td>
            <td>
                :          </td>
            <td>&nbsp;</td>
        </tr>
    </table>

    <p style="margin-top: 1px;"></p>
    <!-- Perlengkapan       -->
    <table border="0" class="tab" width='100%' >
        <tr>
            <td colspan="11">
                <b class="title">Perlengkapan</b>          </td>
        </tr>
        <tr>
            <td colspan="2"  class="conten">&nbsp;</td>
            <td width="6" >          </td>
            <td width="250">          </td>
            <td colspan="2" class="conten" >&nbsp;          </td>
            <td width="6" >          </td>
            <td width="250">          </td>
            <td width="20" class="conten" >&nbsp;            </td>
        </tr>
        <tr>
            <td colspan="2"  >
                ( &nbsp; )          </td>
            <td>
                :          </td>
            <td style="width:250px;">
                Flashier          </td>
            <td colspan="2"  >
                ( &nbsp; )          </td>
            <td >
                :          </td>
            <td style="width:250px;">
                Karpet</td>
            <td  >
                ( &nbsp; )          </td>
            <td width="6" >
                :          </td>
            <td width="176">
                Buku Service &amp; Petunjuk Service     </td>
        </tr>
        <tr>
            <td colspan="2"  >
                ( &nbsp; )          </td>
            <td >
                :          </td>
            <td>
                Kunci Magnet</td>
            <td colspan="2" >
                ( &nbsp; )          </td>
            <td >
                :          </td>
            <td>
                Pematik Api</td>
            <td  >
                ( &nbsp; )          </td>
            <td >
                :          </td>
            <td>Tool Set:Tang ,Obeng, Kuci Busi</td>
        </tr>
        <tr>
            <td colspan="2"  >
                ( &nbsp; )          </td>
            <td>
                :          </td>
            <td>
                Dop Roda</td>
            <td colspan="2"  >
                ( &nbsp; )          </td>
            <td>
                :          </td>
            <td>
                Cat Serep</td>
            <td colspan="3"  >Lain- Lain</td>
        </tr>
        <tr>
            <td colspan="2"  >
                ( &nbsp; )          </td>
            <td>
                :          </td>
            <td>
                Ban Cadangan dan velg</td>
            <td colspan="2"  >
                ( &nbsp; )          </td>
            <td>
                :          </td>
            <td>
                Kancing Karpet</td>
            <td  >( &nbsp; )</td>
            <td  >:</td>
            <td  >&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2"  >( &nbsp; ) </td>
            <td>:                   </td>
            <td>Kunci Roda,Kunci Pas </td>
            <td colspan="2"  >( &nbsp; ) </td>
            <td>:                    </td>
            <td>Dongkrak Dan Stang</td>
            <td  >( &nbsp; )</td>
            <td  >&nbsp;</td>
            <td  >&nbsp;</td>
        </tr>

        <tr>
            <td colspan="2"  >&nbsp;</td>
            <td>                       </td>
            <td>&nbsp;</td>
        </tr>
    </table>
    <p style="margin-top: 1px;"></p>

    Keterangan :...............................
</div>

<div     >
    <table class="tab"  width="100%" >
        <tdead>
            <tr align="top">
                <td width="1%" style=" text-align: center; ">  </td>
                <td width="33%" style="text-align: center;"> DIKETAHUI </td>
                <td width="16%" style="text-align: center;"> DISETUJUI </td>
                <td width="15%" style="text-align: center;"> DIPERIKSA</td>   
                <td width="15%" style="text-align: center;"> DITERIMA</td>  
                <td width="20%" style="text-align: center;"> DISERAHKAN</td>              
            </tr>
            <tr>
                <td style="height: 1.5cm;"> </td>
                <td style="height: 1.5cm;"></td>
                <td style="height: 1.5cm;"></td>
                <td style="height: 1.5cm;"></td> 
                <td style="height: 1.5cm;"></td>
                <td style="height: 1.5cm;"></td>
            </tr>
            <tr>
                <td style=" text-align: center;"> </td>
                <td style="text-align: center;">(BRANCH MANAGER)</td>
                <td style="text-align: center;">(STOCK)</td>
                <td style="text-align: center;">(P.D.I)</td>
                <td style="text-align: center;">(GUDANG)</td>
                <td style="text-align: center;">(PEMBAWA)</td>

            </tr>
        </tdead>
    </table>
</div>
<?php //if ($output == 'export') {  ?> <?php
//    $namafile = "prospek" . date("d-m-Y");
//    header("Content-type: application/vnd.ms-excel");
//    header("Content-Disposition: attachment; filename=$namafile.xls");
//    header("Pragma: no-cache");
//    header("Expires: 0");
//     
?> 

<?php
//} else if ($output == 'printer') {
?>
<script type="text/javascript">
    window.print();
//    window.close();
</script>               
<?php
//}
?>