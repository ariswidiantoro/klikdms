<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<link type="text/css" href="<?php echo path_css(); ?>report.css" rel="stylesheet" />
<link type="text/css" href="<?php echo path_css(); ?>mystyle.css" rel="stylesheet" />
<style>
    h3 {text-align: center;}
    table {text-align:  left; letter-spacing: 1px; border-collapse: collapse; font-size: 11px;}
    table th, table td {padding: 2px; vertical-align: top;}
    #tanda {text-align: left;}
    #tanda tr td {height: 50px; }
</style> 
<script type="text/javascript">
    function exportKomposisi() {
        var params = 'width=' + screen.width;
        params += ', height=' + screen.height;
        params += ', top=0, left=0';
        params += ', fullscreen=yes,scrollbars=yes';
        window.open('<?php echo site_url('laporan_sparepart/detailKomposisiStock'); ?>/' + '<?php echo $start; ?>' + "/" + '<?php echo $end; ?>' + "/" + '<?php echo $cbid; ?>' +"/"+'<?php echo $type; ?>' +"/export", 'Prev', params);
    }
    function cetak() {
        document.getElementById('action').innerHTML = "";
        window.print();
        self.close();
    }


</script>
<body>
    <div style="margin:5px; font-family: tahoma; font-size: 11px;height: 100%; overflow: auto">
        <p id="action">
            <a href="javascript:void(0)" onclick="cetak()" class="print" >Cetak</a>    
            <a href="javascript:void(0)" onclick="exportKomposisi()" >Export</a>    
        </p>
        <br /><br />
        <p align='center'><b style='font-size:16px; font-family:sans-serif;'>Laporan Detail Komposisi Stock <?php
if ($type == 'dead') {
    $type .= ' STOCK';
} else {
    $type .= ' MOVING';
} echo strtoupper($type)
?></b></p>
        <table id="table-detail" width="100%" style="overflow: auto">
            <tr>
                <th style="width: 50px;">Nomor</th>
                <th style="width: 100px;">Kode Barang</th>
                <th style="width: 200px;">Nama</th>
                <th style="width: 50px;">Qty</th>
                <th style="width: 100px;">HPP</th>
                <th style="width: 100px;">PRICE LIST</th>
                <th style="width: 150px;">TOTAL HPP</th>
            </tr>
            <?php
            $i = 1;
            $qty = 0;
            $hpp = 0;
            $harga = 0;
            if (count($data) > 0) {
                foreach ($data as $val) {
                    $subtotal = $val['dsupp_qty'] * $val['dsupp_hpp'];
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $val['dsupp_msbcode']; ?></td>
                        <td><?php echo $val['dsupp_name']; ?></td>
                        <td style="text-align: right"><?php echo $val['dsupp_qty']; ?></td>
                        <td style="text-align: right"><?php echo number_format($val['dsupp_hpp'], 2); ?></td>
                        <td style="text-align: right"><?php echo number_format($val['dsupp_harga'], 2); ?></td>
                        <td style="text-align: right"><?php echo number_format($subtotal, 2); ?></td>
                    </tr>
                    <?php
                    $i++;
                    $qty += $val['dsupp_qty'];
                    $harga += $subtotal;
                }
            }
            ?>
            <tfoot>
                <tr>
                    <td style="text-align: right"  colspan="3" >Total</td>
                    <td style="text-align: right"><?php echo $qty; ?></td>
                    <td style="text-align: right">&nbsp;</td>
                    <td style="text-align: right">&nbsp;</td>
                    <td style="text-align: right"><?php echo number_format($harga, 2); ?></td>
                </tr>
            </tfoot>
        </table>
        <br>
        <?php
        if ($output == 'export') {
            ?>
            <script type="text/javascript">
                window.close();
            </script>  
            <?php
            header("Content-type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=komposisi_stock_detail.xls");
            header("Pragma: no-cache");
            header("Expires: 0");
        }
        ?>
    </div>
</body>
