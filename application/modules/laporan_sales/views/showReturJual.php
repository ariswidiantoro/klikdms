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
            <th width="2%">No&nbsp;Retur</th>
            <th width="2%">Tgl&nbsp;Retur</th>
            <th width="2%">No&nbsp;Faktur</th>
            <th width="2%">Tgl&nbsp;Faktur</th>
            <th width="2%">Nama&nbsp;Pelanggan</th>
            <th width="2%">Alamat&nbsp;Pelanggan</th>
            <th width="2%">Merk</th>
            <th width="2%">Model</th>
            <th width="2%">Type</th>
            <th width="2%">No&nbsp;Rangka</th>
            <th width="2%">No&nbsp;Mesin</th>
            <th width="2%">No&nbsp;Seri</th>
            <th width="2%">Warna</th>
        </tr>
        <?php
        if (count($data) > 0) {
            $no = 1;

            foreach ($data as $value) {
                ?><tr>
                    <td><?php echo $no ?></td>
                    <td><?php echo "'".$value['rtj_nomer']; ?></td>
                    <td><?php echo dateToIndo($value['rtj_tgl']); ?></td>
                    <td><?php echo "'".$value['fkp_nofaktur']; ?></td>
                    <td><?php echo dateToIndo($value['fkp_tgl']); ?></td>
                    <td><?php echo $value['pel_nama']; ?></td>
                    <td><?php echo $value['pel_alamat']; ?></td>
                    <td><?php echo $value['merk_deskripsi']; ?></td>
                    <td><?php echo $value['model_deskripsi']; ?></td>
                    <td><?php echo str_replace(' ', '&nbsp;', $value['cty_deskripsi']); ?></td>
                    <td><?php echo $value['msc_norangka']; ?></td>
                    <td><?php echo $value['msc_nomesin']; ?></td>
                    <td><?php echo $value['msc_bodyseri']; ?></td>
                    <td><?php echo str_replace(' ', '&nbsp;', $value['warna_deskripsi']); ?></td>
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
                                <!--    <script type="text/javascript">
                                        window.close();
                                    </script>  -->
    <?php
    header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=retur_jual.xls");
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