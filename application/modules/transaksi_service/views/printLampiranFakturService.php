<style>
    .head {
        background-color: #999;
        font-weight: bold;
        font-size: 12px;
        text-align: center;
    }
    .detail{
        background-color: #EEE;
        font-size: 12px;
    }
    .detail tr {
        border: 1px #999 solid;
    }
    .detail td {
        border: 1px #999 solid;
    }
</style>
<script>
    function prints()
    {
        if ("<?php echo ses_brand ?>" == '2') {
            window.open("<?php echo site_url(); ?>/transaksi_service/printLampiranApplet/" + "<?php echo $wo; ?>", "_blank", "width=1000,\n\
                        heigth=500,scrollbars=yes,directories=0,titlebar=0,toolbar=0,\n\
                        location=0,status=0,top=5,  menubar=0,scrollbars=no,resizable=no,");
        } else {
            window.print();
        }
        self.close();
    }
</script>
<br>    
<div>
    <a href="javascript:void(0);"  class="print" id="print" onclick="prints()" >PRINT</a>
</div>
<h1 style="font-size: 15px; text-align: center;">LAMPIRAN FAKTUR SERVICE</h1>
<form>
    <table border="0" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td width="20%">No. Work Order</td>
            <td> : </td>
            <td><?php echo $wo ?></td>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td width="10%">Tgl Cetak</td>
            <td> : </td>
            <td><?php
                $tgl = explode(" ", $time);
                echo $this->system->datePicker($tgl[0]);
                ?></td>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td width="10%">Waktu Cetak</td>
            <td> : </td>
            <td><?php
                $tgl = explode(" ", $time);
                echo $tgl[1]
                ?></td>
            <td colspan="2">&nbsp;</td>
        </tr>
    </table>
    <table border="0" width="100%" cellpadding="0" cellspacing="0">
        <tr style="height: 30px">
            <td style="border-bottom: 1px dotted; border-top: 1px dotted;" colspan="6">PEMAKAIAN SPARE PART, SUB MATERIAL, SUB ORDER & OLI </td>
        </tr>
        <tr>
            <td width="10%">No. Polisi</td>
            <td>:<?php echo ' ' . $cars->msc_nopol ?></td>
            <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
            <td  width="10%">No. Chasis</td>
            <td>:<?php echo ' ' . $cars->msc_norangka ?></td>
            <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
            <td width="10%">No. Mesin</td>
            <td>:<?php echo ' ' . $cars->msc_nomesin ?></td>
            <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
            <td width="10%">Nama</td>
            <td>: <?php echo ' ' . $cars->pel_name ?></td>
            <td colspan="4">&nbsp;</td>
        </tr>
    </table>
    <table style="border: #666 1px solid;" class="detail" width="100%" cellpadding="0" cellspacing="0">
        <tr style="height: 25px;">
            <td class="head" width="20%">No Part</td>
            <td class="head" width="35%">Nama Part</td>
            <td class="head" width="10%">Qty</td>
            <td class="head" width="10%">Price list</td>
            <td class="head" width="10%">Harga</td>
            <td class="head" width="15%">Jumlah</td>
        </tr>
        <?php
        $partss = 0;
        $so = 0;
        $oli = 0;
        $sm = 0;
        $laber = 0;
        if (count($part) > 0) {

            foreach ($part as $row) {
                if ($row->spp_jenis == '1') {
                    $subtotal = $row->dsupp_subtotal;
                    $pricelist = $row->dsupp_harga;
                    $harga = $row->dsupp_harga * (( 100 - $row->dsupp_discp) / 100);
                    if (ses_gudang == '1') {
                        $pricelist = $row->dsupp_harga + $row->dsupp_diskon;
                        $harga = $row->dsupp_harga;
                    }
                    ?>
                    <tr>
                        <td><?php echo $row->dsupp_msbcode; ?></td>
                        <td><span style="float: left;"><?php echo $row->msb_name; ?></span><span style="float: right;" ><?php if (floatval($row->dsupp_discp) > 0) echo "(" . $row->dsupp_discp . ")"; ?></span></td>
                        <td style="text-align: right;"><?php echo $row->dsupp_qty; ?></td>
                        <td style="text-align: right;"><?php echo number_format($pricelist); ?></td>
                        <td style="text-align: right;"><?php echo number_format($harga); ?></td>
                        <td style="text-align: right;"><?php echo number_format($subtotal); ?></td>
                    </tr>
                    <?php
                    $partss += $subtotal;
                }
            }

            if ($part > 0) {
                ?>
                <tr style="background-color: #EEE;text-align: right; font-weight: bold; height: 25px;">
                    <td colspan="5">
                        Total Pemakaian Oli
                    </td>
                    <td style="text-align: right;">
                        <?php echo number_format($partss); ?>
                    </td>
                </tr>
            <?php } ?>
            <?php
            foreach ($part as $row) {
                if ($row->spp_jenis == '3') {
                    $subtotal = $row->dsupp_subtotal;
                    $pricelist = $row->dsupp_harga;
                    $harga = $row->dsupp_harga * (( 100 - $row->dsupp_discp) / 100);
                    if (ses_gudang == '1') {
                        $pricelist = $row->dsupp_harga + $row->dsupp_diskon;
                        $harga = $row->dsupp_harga;
                    }
                    ?>
                    <tr>
                        <td><?php echo $row->dsupp_msbcode; ?></td>
                        <td><span style="float: left;"><?php echo $row->msb_name; ?></span><span style="float: right;" ><?php if (floatval($row->dsupp_discp) > 0) echo "(" . $row->dsupp_discp . ")"; ?></span></td>
                        <td style="text-align: right;"><?php echo $row->dsupp_qty; ?></td>
                        <td style="text-align: right;"><?php echo number_format($pricelist); ?></td>
                        <td style="text-align: right;"><?php echo number_format($harga); ?></td>
                        <td style="text-align: right;"><?php echo number_format($subtotal); ?></td>
                    </tr>
                    <?php
                    $oli += $subtotal;
                }
            }
            if ($oli > 0) {
                ?>
                <tr style="background-color: #EEE;text-align: right; font-weight: bold; height: 25px; ">
                    <td colspan="5">
                        Total Pemakaian Spare part 
                    </td>
                    <td style="text-align: right;"><?php echo number_format($oli); ?>
                    </td>
                </tr>
                <?php
            }
            if (substr($wo, 0, 2) != 'IB') {
                foreach ($part as $row) {
                    if ($row->spp_jenis == '4') {
                        $subtotal = $row->dsupp_subtotal;
                        $pricelist = $row->dsupp_harga;
                        $harga = $row->dsupp_harga * (( 100 - $row->dsupp_discp) / 100);
                        if (ses_gudang == '1') {
                            $pricelist = $row->dsupp_harga + $row->dsupp_diskon;
                            $harga = $row->dsupp_harga;
                        }
                        ?>
                        <tr>
                            <td><?php echo $row->dsupp_msbcode; ?></td>
                            <td><span style="float: left;"><?php echo $row->msb_name; ?></span><span style="float: right;" ><?php if (floatval($row->dsupp_discp) > 0) echo "(" . $row->dsupp_discp . ")"; ?></span></td>
                            <td style="text-align: right;"><?php echo $row->dsupp_qty; ?></td>
                            <td style="text-align: right;"><?php echo number_format($pricelist); ?></td>
                            <td style="text-align: right;"><?php echo number_format($harga); ?></td>
                            <td style="text-align: right;"><?php echo number_format($subtotal); ?></td>
                        </tr>
                        <?php
                        $sm += $subtotal;
                    }
                }
                if ($sm > 0) {
                    ?>
                    <tr style="background-color: #EEE;text-align: right; font-weight: bold; height: 25px; ">
                        <td colspan="5">
                            Total Pemakaian Sub Material
                        </td>
                        <td style="text-align: right;"><?php echo number_format($sm); ?>
                        </td>
                    </tr>
                    <?php
                }
            }
        } else {
            ?>
            <tr style="height: 25px; text-align: center;">
                <td colspan="6"> Belum pernah membuat Supply slip</td>
            </tr>
            <?php
        }
        if (count($sub) > 0) {
            foreach ($sub as $row) {
                ?>
                <tr>
                    <td colspan="2"><?php echo $row->ord_nama; ?></td>
                    <td style="text-align: right;"><?php echo "1"; ?></td>
                    <td style="text-align: right;"><?php echo "0"; ?></td>
                    <td style="text-align: right;"><?php echo number_format($row->ord_hargajual); ?></td>
                    <td style="text-align: right;"><?php echo number_format($row->ord_hargajual); ?></td>
                </tr>

                <?php
                $so += $row->ord_hargajual;
            }
            ?>
            <tr style="background-color: #EEE;text-align: right; font-weight: bold; height: 25px; ">
                <td colspan="5">
                    Total Pemakaian Sub Order
                </td>
                <td style="text-align: right;"><?php echo number_format($so); ?>
                </td>
            </tr>
            <?php
        }
        ?>
    </table>

    <h1 style="font-size: 15px; font-weight: bold;">GRAND TOTAL PEMAKAIAN SPARE PART, SM, OIL & SO  = <?php
        $totals = intval($partss) + intval($so) + intval($oli) + intval($sm) + intval($laber);
        echo number_format($totals);
        ?>
    </h1>

</form>