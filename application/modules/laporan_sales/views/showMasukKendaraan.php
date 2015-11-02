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
            <th width="2%">No Bmk</th>
            <th width="2%">Tgl Bmk</th>
            <th width="2%">Nama Supplier</th>
            <th width="2%">Alamat Supplier</th>
            <th width="2%">Nomor Do</th>
            <th width="2%">Tgl Do</th>
            <th width="2%">Merk</th>
            <th width="2%">Model</th>
            <th width="2%">Type</th>
            <th width="2%">No Rangka</th>
            <th width="2%">No Mesin</th>
            <th width="2%">No Seri</th>
            <th width="2%">Warna</th>
            <th width="2%">Kondisi</th>
        </tr>
        <?php
        if (count($data) > 0) {
            $no = 1;

            foreach ($data as $value) {
                ?><tr>
                    <td><?php echo $no ?></td>
                    <td><?php echo $value['bpk_nomer']; ?></td>
                    <td><?php echo dateToIndo($value['bpk_tgl']); ?></td>
                    <td><?php echo $value['sup_nama']; ?></td>
                    <td><?php echo $value['sup_alamat']; ?></td>
                    <td><?php echo $value['bpk_nodo']; ?></td>
                    <td><?php echo (dateToIndo($value['bpk_tgldo']) != DEFAULT_TGL) ? dateToIndo($value['bpk_tgldo']) : ''; ?></td>
                    <td><?php echo $value['merk_deskripsi']; ?></td>
                    <td><?php echo $value['model_deskripsi']; ?></td>
                    <td><?php echo str_replace(' ', '&nbsp;', $value['cty_deskripsi']); ?></td>
                    <td><?php echo $value['msc_norangka']; ?></td>
                    <td><?php echo $value['msc_nomesin']; ?></td>
                    <td><?php echo $value['msc_bodyseri']; ?></td>
                    <td><?php echo str_replace(' ', '&nbsp;', $value['warna_deskripsi']); ?></td>
                    <td><?php echo $value['msc_kondisi']; ?></td>
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
    header("Content-Disposition: attachment; filename=penerimaan_kendaraan.xls");
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