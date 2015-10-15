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
            <th width="5%">Tgl&nbsp;Supply</th>
            <th width="10%">No.&nbsp;Supply</th>
            <th width="20%">Pelanggan</th>
            <th width="10%">Kode&nbsp;Barang</th>
            <th width="10%">Nama&nbsp;Barang</th>
            <th width="10%">Qty</th>
            <th width="10%">Harga</th>
            <th width="10%">Diskon</th>
            <th width="10%">Sub&nbsp;Total</th>
            <th width="10%">Hpp</th>
            <th width="10%">Sub&nbsp;Total&nbsp;Hpp</th>
        </tr>
        <?php
        if (count($data) > 0) {
            $no = 1;
            $total = 0;
            $totalHpp = 0;
            foreach ($data as $value) {
                ?><tr>
                    <td><?php echo $no ?></td>
                    <td><?php echo date('d-m-Y', strtotime($value['spp_tgl'])); ?></td>
                    <td><?php echo $value['spp_noslip']; ?></td>
                    <td><?php echo $value['pel_nama']; ?></td>
                    <td><?php echo $value['inve_kode']; ?></td>
                    <td><?php echo $value['inve_nama']; ?></td>
                    <td style="text-align: right;"><?php echo number_format($value['dsupp_qty'], 2); ?></td>
                    <td style="text-align: right;"><?php echo number_format($value['dsupp_harga'], 2); ?></td>
                    <td style="text-align: right;"><?php echo number_format($value['dsupp_diskon'], 2); ?></td>
                    <td style="text-align: right;"><?php echo number_format($value['dsupp_subtotal'], 2); ?></td>
                    <td style="text-align: right;"><?php echo number_format($value['dsupp_hpp'], 2); ?></td>
                    <td style="text-align: right;"><?php echo number_format($value['dsupp_subtotal_hpp'], 2); ?></td>
                </tr>
                <?php
                $no++;
                $total += $value['dsupp_subtotal'];
                $totalHpp += $value['dsupp_subtotal_hpp'];
            }
            ?>
            <tr style="font-weight: bold;">
                <td colspan="9" style="text-align: right">TOTAL</td>
                <td style="text-align: right;"><?php echo number_format($total, 2); ?></td>
                <td>&nbsp;</td>
                <td style="text-align: right;"><?php echo number_format($totalHpp, 2); ?></td>
            </tr>
            <?php
        } else {
            ?>
            <tr>
                <td colspan="12">Data Tidak Ditemukan</td>
            </tr>
        <?php } ?>
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
    header("Content-Disposition: attachment; filename=supply_slip_detail.xls");
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