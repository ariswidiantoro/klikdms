<link type="text/css" href="<?php echo path_css(); ?>report.css" rel="stylesheet" />
<?php 
function format_number($number){
    if ($output == 'print') {
        return number_format($number,2);
    }else{
        return number_format($number,2,'','.');
    }
};
$bal = $saldoAwal;
?>
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
            <th width="2%">NO</th>
            <th width="2%">TGL. TRANS</th>
            <th width="10%">NO. BUKTI</th>
            <th width="10%">TRANS</th>
            <th WIDTH="20%">DESKRIPSI</th>
            <th WIDTH="10%">COSTCENTER</th>
            <th WIDTH="20%">DEBIT</th>
            <th WIDTH="20%">KREDIT</th>
            <th WIDTH="20%">BALANCE</th>
            <th width="15%">NO. FAKTUR</th>
            <th width="15%">NO. CUSTOMER</th>
            <th width="15%">NO. SUPLIER</th>
        </tr>
        <tr>
            <td colspan ="8">SALDO AWAL</td>
            <td><?php echo format_number($saldoAwal);?></td>
            <td colspan="3">&nbsp;</td>
        </tr>
        <?php
        if (count($data) > 0) {
            $no = 1;
            foreach ($data as $value) {
                $bal =+ ($value['trl_debit'] - $value['trl_kredit']);
                $adeb =+ 
                ?><tr>
                    <td ><?php echo $no ?></td>
                    <td align="center"><?php echo date('d-m-Y', strtotime($value['trl_date'])); ?></td>
                    <td><?php echo $value['trl_nomer']; ?></td>
                    <td><?php echo $value['trl_name']; ?></td>
                    <td><?php echo $value['trl_desc']; ?></td>
                    <td><?php echo $value['trl_ccid']; ?></td>
                    <td><?php echo format_number($value['trl_debit'], 2); ?></td>
                    <td><?php echo format_number($value['trl_kredit'], 2); ?></td>
                    <td><?php echo $value['msc_norangka']; ?></td>
                    <td><?php echo $value['msc_nomesin']; ?></td>
                    <td><?php echo $value['wo_print']; ?></td>
                    <td><?php echo $value['wo_km']; ?></td>
                </tr>
                <?php
                $no++;
            }
        }
        ?>
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
    header("Content-Disposition: attachment; filename=agenda_wo.xls");
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