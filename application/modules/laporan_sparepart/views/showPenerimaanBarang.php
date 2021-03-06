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
            <th width="2%">No. Faktur</th>
            <th width="10%">Tgl Faktur</th>
            <th WIDTH="20%">Supplier</th>
            <th width="15%">Total</th>
        </tr>
        <?php
        if (count($data) > 0) {
            $no = 1;
            $total = 0;
            foreach ($data as $value) {
                ?><tr>
                    <td><?php echo $no ?></td>
                    <td><?php echo $value['trbr_faktur']; ?></td>
                    <td style="text-align: center"><?php echo date('d-m-Y', strtotime($value['trbr_tgl'])); ?></td>
                    <td><?php echo $value['sup_nama']; ?></td>
                    <td style="text-align: right;"><?php echo number_format($value['trbr_total']); ?></td>
                </tr>
                <?php
                $no++;
                $total += $value['trbr_total'];
            }
            ?>
            <tr style="font-weight: bold;">
                <td colspan="4" style="text-align: right">TOTAL</td>
                <td style="text-align: right;"><?php echo number_format($total); ?></td>
            </tr>
            <?php
        } else {
            ?>
            <tr>
                <td colspan="5">Data Tidak Ditemukan</td>
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
    header("Content-Disposition: attachment; filename=penerimaan_barang.xls");
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