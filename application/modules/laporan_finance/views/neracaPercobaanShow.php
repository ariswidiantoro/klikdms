<?php
define('METHOD', $etc['output']);

function format_number($number) {
    if (METHOD == 'excel') {
        return number_format($number, 2, '.', '');
    } else{
        return number_format($number, 2);
    }
}

$bal = $saldoAwal;
$no = 1;
$adeb = 0;
$akre = 0;
?>

<?php 
if ($etc['output'] != 'show') {
?>
<link type="text/css" href="<?php echo path_css(); ?>report.css" rel="stylesheet" />
<div>
    <table id="table-header-detail">
        <tr>
            <td colspan="7" align="center"><h3><?php echo $etc['judul']?></h3></td>
        </tr>
        <tr>
            <td width="150px">CABANG</td>
            <td width="1px">:</td>
            <td><?php echo $cabang['cb_nama'].' ('.$cabang['cbid'].')'?></td>
            <td width="15px">&nbsp;</td>
            <td width="150px">ACCOUNT</td>
            <td width="1px">:</td>
            <td><?php echo $etc['coa']?></td>
        </tr>
        <tr>
            <td>ALAMAT</td>
            <td>:</td>
            <td><?php echo $cabang['cb_alamat']?></td>
            <td width="15px">&nbsp;</td>
            <td width="150px;">RANGE</td>
            <td width="1px;">:</td>
            <td><?php echo $etc['dateFrom'].' s/d '.$etc['dateTo']?></td>
        </tr>
        <tr>
            <td>TELP</td>
            <td>:</td>
            <td><?php echo $cabang['cb_telpon']?></td>
            <td width="15px">&nbsp;</td>
        </tr>
    </table>
</div>
<br/>
<?php } ?>
<div  style="width: 100%;">
    <table id="table-detail">
        <thead>
            <tr>
                <th width="2%">NO</th>
                <th width="2%">COA</th>
                <th width="10%">DESKRIPSI</th>
                <th width="15%" align="right">SALDO AWAL</th>
                <th WIDTH="15%" align="right">DEBIT</th>
                <th WIDTH="15%" align="right">KREDIT</th>
                <th WIDTH="15%" align="right">SALDO AKHIR</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan ="8">SALDO AWAL</td>
                <td align="right"><?php echo format_number($saldoAwal); ?></td>
                <td colspan="3">&nbsp;</td>
            </tr>
            <?php
            if (count($listData) > 0) {
                foreach ($listData as $value) {
                    $bal += ($value['trl_debit'] - $value['trl_kredit']);
                    $adeb += $value['trl_debit'];
                    $akre += $value['trl_kredit'];
                    ?><tr>
                        <td ><?php echo $no ?></td>
                        <td align="center"><?php echo date('d-m-Y', strtotime($value['trl_date'])); ?></td>
                        <td><?php echo strtoupper($value['trl_nomer']); ?></td>
                        <td><?php echo strtoupper($value['trl_name'].$value['trl_trans']); ?></td>
                        <td><?php echo strtoupper($value['trl_descrip']); ?></td>
                        <td><?php echo strtoupper($value['trl_ccid']); ?></td>
                        <td align="right"><?php echo format_number($value['trl_debit']); ?></td>
                        <td align="right"><?php echo format_number($value['trl_kredit']); ?></td>
                        <td align="right"><?php echo format_number($bal, 2); ?></td>
                        <td><?php echo strtoupper($value['trl_nota']); ?></td>
                        <td><?php echo strtoupper($value['trl_pelid']); ?></td>
                        <td><?php echo strtoupper($value['trl_supid']); ?></td>
                    </tr>
                    <?php
                    $no++;
                }
           } else {
                ?>
                <tr>
                    <td ><?php echo $no ?></td>
                    <td align="center" colspan ="11">TIDAK ADA TRANSAKSI PADA RENTANG TGL TERSEBUT</td>
                </tr>
    <?php } ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan ="6">TOTAL</th>
                <td align="right"><?php echo format_number($adeb); ?></td>
                <td align="right"><?php echo format_number($akre); ?></td>
                <td align="right"><?php echo format_number($bal); ?></td>
                <td colspan="3">&nbsp;</td>
            </tr>
        </tfoot>
    </table>
</div>
<?php
if($etc['output'] != 'show'){
    ?>
<table style='margin-top: 10px;' id='table-footer-detail'>
                <tr><td colspan='5'><p align="left"><?php echo ses_kota . ", " . date('d-m-Y') . ", " . date('H:i:s'); ?> </p></td></tr>
                <tr><td class="sign">Dibuat</td><td class='sign'>Diketahui</td><td class="sign">Diperiksa</td><td class="sign" style="width:3.1cm;">Disetujui</td><td class="sign">Diaudit</td></tr>
                <tr><td colspan="5" height="80"></td></tr>
                <tr>
                    <td class="sign">........................<br/>Kasir</td>
                    <td class="sign">........................<br />Ka.bag/ADH</td>
                    <td class="sign">........................<br/>Accounting</td>
                    <td class="sign">........................<br />Branch Manager</td>
                    <td class="sign">........................<br/>Audit</td>
                </tr>
  </table>  
<?php
}
if ($etc['output'] == 'excel') {
    ?>
    <script type="text/javascript">
        window.close();
    </script>  
    <?php
    header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=TRLEDGER.xls");
    header("Pragma: no-cache");
    header("Expires: 0");
    $break = "";
} else if ($etc['output'] == 'print') {
    $break = "<div style='page-break-after: always;'></div>"
    ?>
    <script type="text/javascript">
        window.print();
        history.back();
    </script>               
<?php
}
?>
