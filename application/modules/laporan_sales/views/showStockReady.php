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
            <th width="10%">No Mesin</th>
            <th width="15%">Merk</th>
            <th width="15%">Model</th>
            <th width="20%">Type</th>
            <th width="20%">Warna</th>
        </tr>
        <?php
        if (count($data) > 0) {
            $no = 1;

            foreach ($data as $value) {
                ?><tr>
                    <td><?php echo $no ?></td>
                    <td><?php echo $value['msc_norangka']; ?></td>
                    <td><?php echo $value['msc_nomesin']; ?></td>
                    <td><?php echo $value['merk_deskripsi']; ?></td>
                    <td><?php echo $value['model_deskripsi']; ?></td>
                    <td><?php echo $value['cty_deskripsi']; ?></td>
                    <td><?php echo $value['warna_deskripsi']; ?></td>
                </tr>
                <?php
                $no++;
            }
        } else {
            ?>
            <tr>
                <td colspan="7">Data Tidak Ditemukan</td>
            </tr>
        <?php } ?>
    </table>
</div>
<?php
if ($output == 'excel') {
    ?>
    <?php
    header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=stock_ready.xls");
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