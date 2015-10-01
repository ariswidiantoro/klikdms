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
            <th width="2%">No. Wo</th>
            <th WIDTH="20%">Tgl&nbsp;Work&nbsp;Order</th>
            <th width="15%">Nama&nbsp;Pelanggan</th>
            <th WIDTH="10%">No.&nbsp;Polisi</th>
            <th WIDTH="20%">Service&nbsp;Advisor</th>

        </tr>
        <?php
        if (count($data) > 0) {
            $no = 1;
            foreach ($data as $value) {
                ?><tr>
                    <td><?php echo $no ?></td>
                    <td><?php echo $value['wo_nomer']; ?></td>
                    <td style="text-align: center"><?php echo date('d-m-Y', strtotime($value['wo_tgl'])); ?></td>
                    <td><?php echo $value['pel_nama']; ?></td>
                    <td><?php echo $value['msc_nopol']; ?></td>
                    <td><?php echo $value['kr_nama']; ?></td>
                </tr>
                <?php
                $no++;
            }
        } else {
            ?>
            <tr>
                <td colspan="6">Data Tidak Ditemukan</td>
            </tr>
            <?php
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