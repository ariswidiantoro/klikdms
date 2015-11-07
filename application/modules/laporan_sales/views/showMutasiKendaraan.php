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
            <th width="10%">No Rangka</th>
            <th width="30%">Keterangan</th>
            <th width="10%">In / Out</th>
            <th width="20%">Nomer Transaksi</th>
            <th width="15%">Tgl Transaksi</th>
        </tr>
        <?php
        if (count($data) > 0) {
            $no = 1;

            foreach ($data as $value) {
                ?><tr>
                    <td><?php echo $no ?></td>
                    <td><?php echo $value['msc_norangka']; ?></td>
                    <td><?php echo $value['mut_desc']; ?></td>
                    <td><?php echo $value['mut_inout']; ?></td>
                    <td><?php echo $value['mut_nomer']; ?></td>
                    <td style="text-align: center"><?php echo date('d-m-Y H:i:s',strtotime($value['mut_tgl'])); ?></td>
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
    <?php
    header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=mutasi_kendaraan.xls");
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