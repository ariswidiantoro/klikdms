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
            <th width="20%">No&nbsp;Bukti</th>
            <th width="20%">Tgl</th>
            <th width="20%">Kode&nbsp;Barang</th>
            <th width="30%">Nama&nbsp;Barang</th>
            <th width="10%">Adj&nbsp;Plus</th>
            <th width="10%">Adj&nbsp;Minus</th>
            <th WIDTH="10%">Hpp</th>
            <th width="10%">Sub&nbsp;Total&nbsp;Hpp</th>
        </tr>
        <?php
        if (count($data) > 0) {
            $no = 1;
            $total = 0;
            $plus = 0;
            $minus = 0;
            foreach ($data as $value) {
                ?><tr>
                    <td><?php echo $no ?></td>
                    <td><?php echo $value['adj_nomer']; ?></td>
                    <td><?php echo date('d-m-Y', strtotime($value['adj_tgl'])); ?></td>
                    <td><?php echo $value['inve_kode']; ?></td>
                    <td><?php echo $value['inve_nama']; ?></td>
                    <td style="text-align: right;"><?php echo $value['dadj_plus']; ?></td>
                    <td style="text-align: right;"><?php echo $value['dadj_minus']; ?></td>
                    <td style="text-align: right;"><?php echo number_format($value['dadj_hpp'], 2); ?></td>
                    <td style="text-align: right;"><?php echo number_format($value['dadj_subtotal_hpp'], 2); ?></td>
                </tr>
                <?php
                $no++;
                $total += $value['dadj_subtotal_hpp'];
                $plus += $value['dadj_plus'];
                $minus += $value['dadj_minus'];
            }
            ?>
            <tr style="font-weight: bold;">
                <td colspan="5" style="text-align: right">TOTAL</td>
                <td style="text-align: right;"><?php echo $plus; ?></td>
                <td style="text-align: right;"><?php echo $minus; ?></td>
                <td>&nbsp;</td>
                <td style="text-align: right;"><?php echo number_format($total,2); ?></td>
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
    header("Content-Disposition: attachment; filename=adjustment_stock.xls");
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