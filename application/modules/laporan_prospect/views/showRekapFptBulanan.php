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
            <th width="10%">Bulan</th>
            <th width="15%">Jumlah Fpt</th>
        </tr>
        <?php
        if (count($data) > 0) {
            $no = 1;
            $total = 0;
            foreach ($data as $value) {
                ?><tr>
                    <td><?php echo $no ?></td>
                    <td><?php echo getBulan($value['bulan']); ?></td>
                    <td><?php echo $value['jumlah']; ?></td>
                </tr>
                <?php
                $total += $value['jumlah'];
                $no++;
            }
        }
        ?>
        <tr>
            <th width="2%" colspan="2" style="text-align: right">TOTAL</th>
            <th width="15%"><?php echo $total; ?></th>
        </tr>
    </table>
</div>
<?php
if ($output == 'excel') {
    ?>
                <!--    <script type="text/javascript">
                        window.close();
                    </script>  -->
    <?php
    header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=fpt_bulanan.xls");
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