<?php
define('METHOD', $etc['output']);

function format_number($number) {
    if (METHOD == 'excel') {
        return number_format($number, 2, '.', '');
    } else{
        return number_format($number, 2);
    }
}

$no = 1;
$asldawal = 0;
$adeb = 0;
$akre = 0;
$asldakhir = 0;

$departemen[UANGMUKA_UNIT] = 'UNIT';
$departemen[UANGMUKA_SERVICE] = 'SERVICE';
$departemen[UANGMUKA_SPART] = 'SPAREPART';
$departemen[UANGMUKA_BREPAIR] = 'BODYREPAIR';
?>
<?php 
if ($etc['output'] != 'show') {
?>
<div>
    <table id="table-header-detail">
        <tr>
            <td colspan="7" align="center"><h3><?php echo $etc['judul']?></h3></td>
        </tr>
        <tr>
            <td width="150px">CABANG</td>
            <td width="1px">:</td>
            <td><?php echo $cabang['cb_nama']?></td>
            <td width="15px">&nbsp;</td>
            <td width="150px">ACCOUNT</td>
            <td width="1px">:</td>
            <td><?php echo '-'?></td>
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
            <td width="150px;">JENIS PIUTANG</td>
            <td width="1px;">:</td>
            <td><?php echo $departemen[$etc['coa']];?></td>
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
                <th width="10%">NO. BUKTI</th>
                <th width="10%">TGL</th>
                <th width="10%">NO. CUSTOMER</th>
                <th WIDTH="15%">NAMA CUSTOMER</th>
                <th WIDTH="15%" align="right">SALDO AWAL</th>
                <th WIDTH="15%" align="right">DEBIT</th>
                <th WIDTH="15%" align="right">KREDIT</th>
                <th WIDTH="15%" align="right">BALANCE</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (count($listData) > 0) {
                foreach ($listData as $value) {
                    $asldawal += $value['sld_awal'];
                    $adeb += $value['debit'];
                    $akre += $value['kredit'];
                    $asldakhir += $value['sld_akhir'];
                    ?><tr>
                        <td><?php echo $no ?></td>
                        <td><?php echo strtoupper($value['faktur']); ?></td>
                        <td><?php echo strtoupper($value['tgl_faktur']); ?></td>
                        <td><?php echo strtoupper($value['kontrak']); ?></td>
                        <td><?php echo strtoupper($value['nama']); ?></td>
                        <td align="right"><?php echo format_number($value['sld_awal']); ?></td>
                        <td align="right"><?php echo format_number($value['debit']); ?></td>
                        <td align="right"><?php echo format_number($value['kredit']); ?></td>
                        <td align="right"><?php echo format_number($value['sld_akhir']); ?></td>
                    </tr>
                    <?php
                    $no++;
                }
           } else {
                ?>
                <tr>
                    <td ><?php echo $no ?></td>
                    <td align="center" colspan ="8">TIDAK ADA TRANSAKSI PADA RENTANG TGL TERSEBUT</td>
                </tr>
    <?php } ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan ="5">TOTAL</th>
                <td align="right"><?php echo format_number($asldawal); ?></td>
                <td align="right"><?php echo format_number($adeb); ?></td>
                <td align="right"><?php echo format_number($akre); ?></td>
                <td align="right"><?php echo format_number($asldakhir); ?></td>
            </tr>
        </tfoot>
    </table>
</div>
<?php
if ($etc['output'] == 'excel') {
    ?>
    <script type="text/javascript">
        window.close();
    </script>  
    <?php
    header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=RK_UANGMUKA.xls");
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
