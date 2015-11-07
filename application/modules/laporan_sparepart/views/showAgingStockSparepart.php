<link type="text/css" href="<?php echo path_css(); ?>report.css" rel="stylesheet" />
<style>
    h3 {text-align: center;}
    table {text-align:  left; letter-spacing: 1px; border-collapse: collapse; font-size: 12px;width: 1500px;}
    table th, table td {padding: 2px; vertical-align: top;}

    #tanda {text-align: center;}
    #tanda tr td {height: 50px; }
</style> 
<script type="text/javascript">
    function detailKomposisiStock(start, end,cbid, type, status) {
        var params = 'width=' + screen.width;
        params += ', height=' + screen.height;
        params += ', top=0, left=0';
        params += ', fullscreen=yes,scrollbars=yes';
        window.open('<?php echo site_url('laporan_sparepart/detailKomposisiStock'); ?>/' + start + "/" + end + "/" + cbid +"/"+type +"/"+status, 'Prev', params);
    }
</script>
<div  style="width: 100%;">
    <table id="table-detail">
        <tr>
            <th width="2%" rowspan="2">Stock&nbsp;Awal</th>
            <th width="2%" rowspan="2">Pembelian</th>
            <th width="2%" rowspan="2">Adjustment</th>
            <th width="2%" rowspan="2">Penjualan</th>
            <th width="2%" rowspan="2">Stock Akhir</th>
            <th width="2%" colspan="7" style="text-align: center">Komposisi&nbsp;Stock&nbsp;(Moving&nbsp;Parts)</th>
        </tr>
        <tr>
            <th>Very&nbsp;Fast</th>
            <th>Fast</th>
            <th>Medium</th>
            <th>Slow</th>
            <th>No</th>
            <th>Dead&nbsp;Stock</th>
            <th>Scrap&nbsp;Stock</th>
        </tr>
        <tr>
            <td style="text-align: right;"><?php echo number_format($sa, 2); ?></td>
            <td style="text-align: right;"><?php echo number_format($beli - $returBeli, 2); ?></td>
            <td style="text-align: right;"><?php echo number_format($adj, 2); ?></td>
            <td style="text-align: right;"><?php echo number_format($jual - $returJual, 2); ?></td>
            <td style="text-align: right;"><?php echo number_format($sa + $beli + $adj - $jual + $returJual - $returBeli, 2); ?></td>
            <!--<td style="text-align: right;">0</td>-->
            <td style="text-align: right;"><a href="javascript:void(0)" onclick="detailKomposisiStock('<?php echo $start ?>', '<?php echo $end; ?>', '<?php echo $cabang ?>', 'very', 'lihat')"><?php echo number_format($moving['very'], 2) ?></a></td>
            <td style="text-align: right;"><a href="javascript:void(0)" onclick="detailKomposisiStock('<?php echo $start ?>', '<?php echo $end; ?>', '<?php echo $cabang ?>', 'fast', 'lihat')"><?php echo number_format($moving['fast'], 2) ?></a></td>
            <td style="text-align: right;"><a href="javascript:void(0)" onclick="detailKomposisiStock('<?php echo $start ?>', '<?php echo $end; ?>', '<?php echo $cabang ?>', 'medium', 'lihat')"><?php echo number_format($moving['medium'], 2) ?></a></td>
            <td style="text-align: right;"><a href="javascript:void(0)" onclick="detailKomposisiStock('<?php echo $start ?>', '<?php echo $end; ?>', '<?php echo $cabang ?>', 'slow', 'lihat')"><?php echo number_format($moving['slow'], 2) ?></a></td>
            <td style="text-align: right;"><a href="javascript:void(0)" onclick="detailKomposisiStock('<?php echo $start ?>', '<?php echo $end; ?>', '<?php echo $cabang ?>', 'no', 'lihat')"><?php echo number_format($moving['no'], 2) ?></a></td>
            <td style="text-align: right;"><a href="javascript:void(0)" onclick="detailKomposisiStock('<?php echo $start ?>', '<?php echo $end; ?>', '<?php echo $cabang ?>', 'dead', 'lihat')"><?php echo number_format($moving['dead'], 2) ?></a></td>
            <td style="text-align: right;"><a href="javascript:void(0)" onclick="detailKomposisiStock('<?php echo $start ?>', '<?php echo $end; ?>', '<?php echo $cabang ?>', 'scrap', 'lihat')"><?php echo number_format($moving['scrap'], 2) ?></a></td>
        </tr>
    </table>
    <table style="width: 70%">
        <tr>
            <td>Keterangan</td>
        </tr>
        <tr>
            <td>Very Fast</td>
            <td>:</td>
            <td>Rata-Rata barang terjual dalam 3 hari</td>
        </tr>
        <tr>
            <td>Fast</td>
            <td>:</td>
            <td>Rata-Rata barang terjual dalam 3 - 10 Hari</td>
        </tr>
        <tr>
            <td>Medium</td>
            <td>:</td>
            <td>Rata-Rata barang terjual dalam 10 hari - 15 Hari</td>
        </tr>
        <tr>
            <td>Slow</td>
            <td>:</td>
            <td>Rata-Rata barang terjual dalam 15 hari - 30 Hari</td>
        </tr>
        <tr>
            <td>No</td>
            <td>:</td>
            <td>Rata-Rata barang terjual dalam 1 - 6 Bulan</td>
        </tr>
        <tr>
            <td>Dead</td>
            <td>:</td>
            <td>Rata-Rata barang terjual dalam 7 - 12 Bulan</td>
        </tr>
        <tr>
            <td>Scrap</td>
            <td>:</td>
            <td>Tidak ada penjualan lebih dari 1 tahun</td>
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
    header("Content-Disposition: attachment; filename=faktur_sparepart.xls");
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