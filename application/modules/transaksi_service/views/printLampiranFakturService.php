<link type="text/css" href="<?php echo path_css(); ?>report.css" rel="stylesheet" />
<link type="text/css" href="<?php echo path_css(); ?>mystyle.css" rel="stylesheet" />
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
    window.print();
</script>
<br>    
<h1 style="font-size: 15px; text-align: center;">LAMPIRAN FAKTUR SERVICE</h1>
<form>
    <table border="0" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td width="20%">No. Work Order</td>
            <td> : </td>
            <td><?php echo $data['wo_nomer']; ?></td>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td width="10%">Tgl Cetak</td>
            <td> : </td>
            <td>
                <?php
                echo date('d-m-Y');
                ?>
            </td>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td width="10%">Waktu Cetak</td>
            <td> : </td>
            <td>
                <?php
                echo date('H:i')
                ?>
            </td>
            <td colspan="2">&nbsp;</td>
        </tr>
    </table>
    <table border="0" width="100%" cellpadding="0" cellspacing="0">
        <tr style="height: 30px">
            <td style="border-bottom: 1px dotted; border-top: 1px dotted;" colspan="6">PEMAKAIAN SPARE PART, SUB MATERIAL, SUB ORDER & OLI </td>
        </tr>
        <tr>
            <td width="10%">No. Polisi</td>
            <td>:<?php echo ' ' . $data['msc_nopol']; ?></td>
            <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
            <td  width="10%">No. Chasis</td>
            <td>:<?php echo ' ' . $data['msc_norangka'] ?></td>
            <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
            <td width="10%">No. Mesin</td>
            <td>:<?php echo ' ' . $data['msc_nomesin'] ?></td>
            <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
            <td width="10%">Nama Pelanggan</td>
            <td>: <?php echo ' ' . $data['pel_nama'] ?></td>
            <td colspan="4">&nbsp;</td>
        </tr>
    </table>
    <table id="table-detail" width="100%" cellpadding="0" cellspacing="0">
        <tr style="height: 25px;">
            <td class="head" width="20%">No Part</td>
            <td class="head" width="35%">Nama Part</td>
            <td class="head" width="10%">Qty</td>
            <td class="head" width="10%">Harga</td>
            <td class="head" width="10%">Diskon</td>
            <td class="head" width="15%">Jumlah</td>
        </tr>
        <?php
        $totalPart = 0;
        $so = 0;
        $oli = 0;
        $sm = 0;
        $laber = 0;
        if (count($part) > 0) {
            foreach ($part as $row) {
                if ($row['spp_jenis'] == 'sp') {
                    ?>
                    <tr>
                        <td><?php echo $row['inve_kode']; ?></td>
                        <td><?php echo $row['inve_nama']; ?></td>
                        <td style="text-align: right;"><?php echo $row['dsupp_qty']; ?></td>
                        <td style="text-align: right;"><?php echo number_format($row['dsupp_harga']); ?></td>
                        <td style="text-align: right;"><?php echo $row['dsupp_diskon']; ?></td>
                        <td style="text-align: right;"><?php echo number_format($row['dsupp_subtotal']); ?></td>
                    </tr>
                    <?php
                    $totalPart += $row['dsupp_subtotal'];
                }
            }

            if ($totalPart > 0) {
                ?>
                <tr style="background-color: #EEE;text-align: right; font-weight: bold; height: 25px;">
                    <td colspan="5">
                        Total Pemakaian Sparepart
                    </td>
                    <td style="text-align: right;">
                        <?php echo number_format($totalPart); ?>
                    </td>
                </tr>
            <?php } ?>
            <?php
            foreach ($part as $row) {
                if ($row['spp_jenis'] == 'ol') {
                    ?>
                    <tr>
                        <td><?php echo $row['inve_kode']; ?></td>
                        <td><?php echo $row['inve_nama']; ?></td>
                        <td style="text-align: right;"><?php echo $row['dsupp_qty']; ?></td>
                        <td style="text-align: right;"><?php echo number_format($row['dsupp_harga']); ?></td>
                        <td style="text-align: right;"><?php echo $row['dsupp_diskon']; ?></td>
                        <td style="text-align: right;"><?php echo number_format($row['dsupp_subtotal']); ?></td>
                    </tr>
                    <?php
                    $oli += $row['dsupp_subtotal'];
                }
            }
            if ($oli > 0) {
                ?>
                <tr style="background-color: #EEE;text-align: right; font-weight: bold; height: 25px; ">
                    <td colspan="5">
                        Total Pemakaian Oli 
                    </td>
                    <td style="text-align: right;"><?php echo number_format($oli); ?>
                    </td>
                </tr>
                <?php
            }
            foreach ($part as $row) {
                if ($row['spp_jenis'] == 'sm') {
                    ?>
                    <tr>
                        <td><?php echo $row['inve_kode']; ?></td>
                        <td><?php echo $row['inve_nama']; ?></td>
                        <td style="text-align: right;"><?php echo $row['dsupp_qty']; ?></td>
                        <td style="text-align: right;"><?php echo number_format($row['dsupp_harga']); ?></td>
                        <td style="text-align: right;"><?php echo $row['dsupp_diskon']; ?></td>
                        <td style="text-align: right;"><?php echo number_format($row['dsupp_subtotal']); ?></td>
                    </tr>
                    <?php
                    $sm += $row['dsupp_subtotal'];
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
        } else if (count($dataso) > 0) {
            foreach ($dataso as $row) {
                if ($row['spp_jenis'] == 'so') {
                    ?>
                    <tr>
                        <td colspan="2"><?php echo $row['so_deskripsi']; ?></td>
                        <td style="text-align: right;"><?php echo '1'; ?></td>
                        <td style="text-align: right;"><?php echo number_format($row['so_harga']); ?></td>
                        <td style="text-align: right;"><?php echo '0'; ?></td>
                        <td style="text-align: right;"><?php echo number_format($row['so_harga']); ?></td>
                    </tr>
                    <?php
                    $so += $row['so_harga'];
                }
            }
            if ($so > 0) {
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
        } else {
            ?>
            <tr style="height: 25px; text-align: center;">
                <td colspan="6"> Belum pernah membuat Supply slip</td>
            </tr>
            <?php
        }
        ?>
    </table>

    <h1 style="font-size: 15px; font-weight: bold;">GRAND TOTAL PEMAKAIAN SPARE PART, SM, OIL & SO  = <?php
        $totals = intval($totalPart) + intval($so) + intval($oli) + intval($sm) + intval($laber);
        echo number_format($totals);
        ?>
    </h1>

</form>