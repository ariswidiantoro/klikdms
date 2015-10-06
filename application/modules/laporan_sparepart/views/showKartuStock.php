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
            <th width="2%">Tgl</th>
            <th width="15%">No.&nbsp;Transaksi</th>
            <th width="15%">Type</th>
            <th width="10%">Supplier&nbsp;/&nbsp;Pelanggan</th>
            <th WIDTH="20%">Hpp</th>
            <th WIDTH="20%">Masuk</th>
            <th width="10%">Keluar</th>
            <th width="10%">Saldo&nbsp;Qty</th>
            <th WIDTH="10%">Debit</th>
            <th width="10%">Kredit</th>
            <th width="10%">Saldo&nbsp;(Rp)</th>
        </tr>
        <?php
        if (count($data) > 0) {
            $no = 1;
            $total = 0;
            $saldo = 0;
            foreach ($data as $value) {
                ?><tr>
                    <td><?php echo $no ?></td>
                    <td><?php echo $value['ks_type'] != 'SA' ? date('d-m-Y',strtotime($value['ks_tgl'])) : ''; ?></td>
                    <td><?php echo $value['transaksi']; ?></td>
                    <td><?php echo $value['ks_type']; ?></td>
                    <td><?php echo $value['nama']; ?></td>
                    <td style="text-align: right;"><?php echo number_format($value['ks_hpp'], 2); ?></td>
                    <td style="text-align: right;"><?php echo number_format($value['ks_in'], 2); ?></td>
                    <td style="text-align: right;"><?php echo number_format($value['ks_out'], 2); ?></td>
                    <td style="text-align: right;"><?php echo number_format($value['ks_total'], 2); ?></td>
                    <td style="text-align: right;"><?php echo number_format($value['ks_debit'], 2); ?></td>
                    <td style="text-align: right;"><?php echo number_format($value['ks_kredit'], 2); ?></td>
                    <td style="text-align: right;"><?php echo number_format($value['ks_saldo'], 2); ?></td>
                </tr>
                <?php
                $no++;
                $total = $value['ks_total'];
                $saldo = $value['ks_saldo'];
            }
            ?>
            <tr style="font-weight: bold;">
                <td colspan="8" style="text-align: right">SALDO TERAKHIR</td>
                <td style="text-align: right;"><?php echo number_format($total,2); ?></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td style="text-align: right;"><?php echo number_format($saldo,2); ?></td>
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
    header("Content-Disposition: attachment; filename=kartu_stock.xls");
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