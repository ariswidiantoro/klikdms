<?php
define('METHOD', $etc['output']);

function format_number($number) {
    if (METHOD == 'excel') {
        return number_format($number, 2, '.', '');
    } else{
        return number_format($number, 2);
    }
}

$no_aktiva = 1;
$no_pasiva = 1;
$no_modal = 1;

$all_aktiva = 0;
$all_pasiva = 0;
$all_modal = 0;
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
            <td width="150px">&nbsp;</td>
            <td width="1px">:</td>
            <td><?php echo '';?></td>
        </tr>
        <tr>
            <td>ALAMAT</td>
            <td>:</td>
            <td><?php echo $cabang['cb_alamat']?></td>
            <td width="15px">&nbsp;</td>
            <td width="150px;">PERIODE</td>
            <td width="1px;">:</td>
            <td><?php echo $etc['bulan']?></td>
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
       <tbody>
            <tr>
                <th colspan="3">AKTIVA</th>
            </tr>
            <?php
                foreach ($aktiva as $row_a) {
                    $all_aktiva += $row_a['saldo'];
                    ?><tr>
                        <td ><?php echo $no_aktiva ?></td>
                        <td ><?php echo strtoupper($row_a['jeniscoa_deskripsi']); ?></td>
                        <td align="right"><?php echo format_number($row_a['saldo']); ?></td>
                    </tr>
                    <?php
                    $no_aktiva++;
                }
            ?>
            <tr>
                <th colspan="2">TOTAL AKTIVA</th>
                <th align="right" style="text-align: right;"><?php echo format_number($all_aktiva)?></th>
            </tr>
            <tr>
                <td colspan="3"></td>
            </tr>
            <tr>
                <th colspan="3">PASIVA</th>
            </tr>
            <?php
                foreach ($pasiva as $row_p) {
                    $all_pasiva += $row_p['saldo'];
                    ?><tr>
                        <td ><?php echo $no_pasiva ?></td>
                        <td ><?php echo strtoupper($row_p['jeniscoa_deskripsi']); ?></td>
                        <td align="right"><?php echo format_number($row_p['saldo']); ?></td>
                    </tr>
                    <?php
                    $no_pasiva++;
                }
            ?>
            <tr>
                <th colspan="2">TOTAL PASIVA</th>
                <th align="right" style="text-align: right;"><?php echo format_number($all_pasiva)?></th>
            </tr>
            <tr>
                <td colspan="3"></td>
            </tr>
            <tr>
                <th colspan="3">MODAL</th>
            </tr>
            <?php
                foreach ($modal as $row_m) {
                    $all_modal += $row_m['saldo'];
                    ?><tr>
                        <td ><?php echo $no_modal ?></td>
                        <td ><?php echo strtoupper($row_m['jeniscoa_deskripsi']); ?></td>
                        <td align="right"><?php echo format_number($row_m['saldo']); ?></td>
                    </tr>
                    <?php
                    $no_modal++;
                }
            ?>
            <tr>
                <th colspan="2">TOTAL MODAL</th>
                <th align="right" style="text-align: right;"><?php echo format_number($all_modal)?></th>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="2">TOTAL PASIVA + MODAL</th>
                <th align="right" style="text-align: right;"><?php echo format_number($all_pasiva+$all_modal)?></th>
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
    header("Content-Disposition: attachment; filename=NERACA.xls");
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
