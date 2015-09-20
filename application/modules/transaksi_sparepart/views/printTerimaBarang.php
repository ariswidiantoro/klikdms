<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<link type="text/css" href="<?php echo path_css(); ?>report.css" rel="stylesheet" />
<link type="text/css" href="<?php echo path_css(); ?>mystyle.css" rel="stylesheet" />
<style>
    h3 {text-align: center;}
    table {text-align:  left; letter-spacing: 1px; border-collapse: collapse; font-size: 12px;}
    table th, table td {padding: 2px; vertical-align: top;}
    #tanda {text-align: center;}
    #tanda tr td {height: 50px; }
</style> 
<div style="margin:10px">
    <div style="width: 100%">
        <span style="float: left;width: 45%">
            <?php echo ses_dealer . "<br />" . ses_alamat; ?>
        </span>
        <span style="float: right;width: 45% "><?php echo date('d-m-Y | H:i:s'); ?></span>
    </div>
    <br /><br />
    <h3>BUKTI PENERIMAAN BARANG</h3>
    <table width="100%" border="0">
        <tr>
            <th width="15%">No. Faktur</th>
            <td width="2%">:</td>
            <td width="33%"><?php echo $faktur['trbr_faktur']; ?></td>
            <th width="15%">&nbsp;</th>
            <td width="2%">&nbsp;</td>
            <td width="33%">&nbsp;</td>
        </tr>
        <tr>
            <th width="15%">Tanggal</th>
            <td width="2%">:</td>
            <td width="33%"><?php echo dateToIndo($faktur['trbr_tgl']); ?></td>
            <th width="15%">Pay Method</th>
            <td width="2%">:</td>
            <td width="33%"><?php echo $faktur['trbr_pay_method']; ?></td>
        </tr>
        <tr>
            <th width="15%">Kode Supplier</th>
            <td width="2%">:</td>
            <td width="33%"><?php echo $faktur['trbr_supid']; ?></td>
            <th width="15%">Credit Term</th>
            <td width="2%">:</td>
            <td width="33%"><?php echo $faktur['trbr_credit_term']; ?> Hari</td>
        </tr>
        <tr>
            <th width="15%">Nama Supplier</th>
            <td width="2%">:</td>
            <td width="33%"><?php echo $faktur['sup_nama']; ?></td>
            <th width="15%">PPN </th>
            <td width="2%">:</td>
            <td width="33%">
                <?php
                if ($faktur['trbr_inc_pajak'] == 1) {
                    echo "Ada (include)";
                } else if ($faktur['trbr_inc_pajak'] == 2) {
                    echo "Tidak Ada";
                }
                ?>
            </td>
        </tr>
        <tr>
            <td colspan="6">
                <table id="table-detail" >
                    <tr>
                        <th width="2%">No</th>
                        <th width="15%">Kode Barang</th>
                        <th width="35%">Nama Barang</th>
                        <th width="5%">Qty</th>
                        <th width="15%">Harga / Pcs</th>
                        <th width="8%">Disc</th>
                        <th width="25%">Jumlah</th>
                    </tr>
                    <?php
                    $no = 1;
                    $data = "";
                    $total = 0;
                    foreach ($barang as $value) {
                        ?>
                        <tr>
                            <td><?php echo $no; ?></td>
                            <td><?php echo $value['inve_kode']; ?></td>
                            <td><?php echo $value['inve_nama']; ?></td>
                            <td style="text-align: right;"><?php echo $value['dtr_qty']; ?></td>
                            <td style="text-align: right;"><?php echo number_format($value['dtr_harga']); ?></td>
                            <td style="text-align: right;"><?php echo $value['dtr_diskon']; ?></td>
                            <td style="text-align: right;"><?php echo number_format($value['dtr_subtotal']); ?></td>
                        </tr>
                        <?php
                        $no++;
                    }
                    ?>
                    <tr>
                        <td colspan="6" style="text-align: right">
                            Grand Total 
                        </td>
                        <td style="text-align: right">
                            <?php echo number_format($faktur['trbr_total']); ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>   
    </table> 
    <!--<p>REPRINT</p>-->
    <table width="100%" id="tanda">
        <tr>
            <th>Diserahkan</th>
            <th>Diterima Oleh</th>
            <th>Diketahui/Diperiksa</th>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>(.......................)</td>
            <td>(.......................)</td>
            <td>(.......................)</td>
        </tr>
    </table>
    <script>
        window.print();
//        window.close();
    </script>
