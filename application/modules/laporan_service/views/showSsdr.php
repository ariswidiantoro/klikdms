<link type="text/css" href="<?php echo path_css(); ?>report.css" rel="stylesheet" />
<style>
    h3 {text-align: center;}
    table {text-align:  left; letter-spacing: 1px; border-collapse: collapse; font-size: 12px;width: 1500px;}
    table th, table td {padding: 2px; vertical-align: top;}

    #tanda {text-align: center;}
    #tanda tr td {height: 50px; }
</style> 
<div  style="width: 100%;">
    <table id="table-detail">
        <tr>
            <th width="2%">No</th>
            <th width="2%">No.&nbsp;Wo</th>
            <th width="2%">No.&nbsp;Polisi</th>

            <th width="15%">Tgl&nbsp;Work&nbsp;Order</th>
            <th width="15%">Tgl&nbsp;Tagihan</th>
            <th width="15%">Jasa</th>
            <th width="15%">Sparepart</th>
            <th width="15%">Oli</th>
            <th width="15%">Sub&nbsp;Material</th>
            <th width="15%">Sub&nbsp;Order</th>
            <th width="15%">Jumlah</th>
            <th width="15%">Ppn</th>
            <th width="15%">Total</th>
            <th width="2%">No.&nbsp;Rangka</th>
            <th width="15%">Nama&nbsp;Pelanggan</th>
            <th width="15%">No&nbsp;Hp</th>
            <th width="15%">Type</th>

        </tr>
        <?php
        if (count($data) > 0) {
            $no = 1;
            $wojenis = '';
            $subtotallc = 0;
            $subtotalspart = 0;
            $subtotaloli = 0;
            $subtotalsm = 0;
            $subtotalso = 0;
            $subtotalppn = 0;
            $subtotaltotal = 0;

            $grandtotallc = 0;
            $grandtotalspart = 0;
            $grandtotaloli = 0;
            $grandtotalsm = 0;
            $grandtotalso = 0;
            $grandtotalppn = 0;
            $grandtotaltotal = 0;
            foreach ($data as $value) {

                if ($wojenis != '' && $wojenis != $value['wo_jenis']) {
                    ?>
                    <tr style="background : #FFE0B2;font-weight: bold;">
                        <td colspan ="5">
                            SUB TOTAL [<?php echo $wojenis; ?>] =====>			
                        </td>
                        <td style="text-align: right"><?php echo number_format($subtotallc); ?></td>
                        <td style="text-align: right"><?php echo number_format($subtotalspart); ?></td>
                        <td style="text-align: right"><?php echo number_format($subtotaloli); ?></td>
                        <td style="text-align: right"><?php echo number_format($subtotalsm); ?></td>
                        <td style="text-align: right"><?php echo number_format($subtotalso); ?></td>
                        <td style="text-align: right"><?php echo number_format($subtotaltotal); ?></td>
                        <td style="text-align: right">0</td>
                        <td style="text-align: right"><?php echo number_format($subtotaltotal); ?></td>
                    </tr>
                    <?php
                    $subtotallc = 0;
                    $subtotalspart = 0;
                    $subtotaloli = 0;
                    $subtotalsm = 0;
                    $subtotalso = 0;
                    $subtotalppn = 0;
                    $subtotaltotal = 0;
                }
                ?><tr>
                    <td><?php echo $no ?></td>
                    <td><?php echo $value['wo_nomer']; ?></td>
                    <td><?php echo $value['msc_nopol']; ?></td>

                    <td style="text-align: center"><?php echo date('d-m-Y', strtotime($value['wo_tgl'])); ?></td>
                    <td style="text-align: center"><?php echo date('d-m-Y', strtotime($value['inv_tgl_tagihan'])); ?></td>
                    <td style="text-align: right"><?php echo number_format($value['inv_lc']); ?></td>
                    <td style="text-align: right"><?php echo number_format($value['inv_spart']); ?></td>
                    <td style="text-align: right"><?php echo number_format($value['inv_oli']); ?></td>
                    <td style="text-align: right"><?php echo number_format($value['inv_sm']); ?></td>
                    <td style="text-align: right"><?php echo number_format($value['inv_so']); ?></td>
                    <td style="text-align: right"><?php echo number_format($value['inv_total']); ?></td>
                    <td style="text-align: right">0</td>
                    <td style="text-align: right"><?php echo number_format($value['inv_total']); ?></td>
                    <td><?php echo $value['msc_norangka']; ?></td>
                    <td><?php echo $value['pel_nama']; ?></td>
                    <td><?php echo $value['pel_hp']; ?></td>
                    <td><?php echo str_replace(" ", '&nbsp;', $value['cty_deskripsi']); ?></td>
                </tr>
                <?php
                $subtotallc += $value['inv_lc'];
                $subtotalspart += $value['inv_spart'];
                $subtotaloli += $value['inv_oli'];
                $subtotalsm += $value['inv_sm'];
                $subtotalso += $value['inv_so'];
                $subtotalppn += 0;
                $subtotaltotal += $value['inv_total'];

                $grandtotallc += $value['inv_lc'];
                $grandtotalspart += $value['inv_spart'];
                $grandtotaloli += $value['inv_oli'];
                $grandtotalsm += $value['inv_sm'];
                $grandtotalso += $value['inv_so'];
                $grandtotalppn += 0;
                $grandtotaltotal += $value['inv_total'];

                $no++;
                $wojenis = $value['wo_jenis'];
            }
            ?>
            <tr style="background : #FFE0B2;font-weight: bold;">
                <td colspan ="5">
                    SUB TOTAL [<?php echo $wojenis; ?>] =====>			
                </td>
                <td style="text-align: right"><?php echo number_format($subtotallc); ?></td>
                <td style="text-align: right"><?php echo number_format($subtotalspart); ?></td>
                <td style="text-align: right"><?php echo number_format($subtotaloli); ?></td>
                <td style="text-align: right"><?php echo number_format($subtotalsm); ?></td>
                <td style="text-align: right"><?php echo number_format($subtotalso); ?></td>
                <td style="text-align: right"><?php echo number_format($subtotaltotal); ?></td>
                <td style="text-align: right">0</td>
                <td style="text-align: right"><?php echo number_format($subtotaltotal); ?></td>
            </tr>
            <tr style="background : #9BEB9B;font-weight: bold;">
                <td colspan ="5">
                    GRAND TOTAL			
                </td>
                <td style="text-align: right"><?php echo number_format($grandtotallc); ?></td>
                <td style="text-align: right"><?php echo number_format($grandtotalspart); ?></td>
                <td style="text-align: right"><?php echo number_format($grandtotaloli); ?></td>
                <td style="text-align: right"><?php echo number_format($grandtotalsm); ?></td>
                <td style="text-align: right"><?php echo number_format($grandtotalso); ?></td>
                <td style="text-align: right"><?php echo number_format($grandtotaltotal); ?></td>
                <td style="text-align: right">0</td>
                <td style="text-align: right"><?php echo number_format($grandtotaltotal); ?></td>
            </tr>
            <?php
        } else {
            ?>
            <tr>
                <td>&nbsp;</td>
                <td colspan="5">Data Tidak Ditemukan</td>
            </tr>
            <?php
        }
        ?>
        <tr>
            <td>&nbsp;</td>
        </tr>
    </table>
</div>
<?php
if ($output == 'excel') {
    ?>
    <script type="text/javascript">
        window.close();
    </script>  
    <?php
    header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=ssdr.xls");
    header("Pragma: no-cache");
    header("Expires: 0");
    $break = "";
} else if ($output == 'print') {
    $break = "<div style='page-break-after: always;'></div>"
    ?>
    <script type="text/javascript">
        window.print();
        history.back();
    </script>               
    <?php
}
?>