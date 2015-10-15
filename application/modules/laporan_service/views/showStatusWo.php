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
            <th width="15%">Nama&nbsp;Pelanggan</th>
            <th WIDTH="10%">No.&nbsp;Polisi</th>
            <th WIDTH="10%">Tgl&nbsp;Work&nbsp;Order</th>
            <th WIDTH="10%">Tgl&nbsp;Tutup&nbsp;Wo</th>
            <th WIDTH="10%">Tgl&nbsp;Tagihan</th>
            <th WIDTH="20%">Status</th>


        </tr>
        <?php
        if (count($data) > 0) {
            $no = 1;

            foreach ($data as $value) {
                $status = '';
                if ($value['inv_tagihan'] == 1) {
                    $status = 'Sudah&nbsp;Tagihan';
                } else if ($value['inv_tagihan'] == '') {
                    if ($value['clo_status'] == 0) {
                        $status = 'Belum&nbsp;Clock&nbsp;On';
                    } else if ($value['clo_status'] == 1) {
                        $status = 'Proses&nbsp;Pengerjaan';
                    } else if ($value['clo_status'] == 2) {
                        $status = 'Pending';
                    } else {
                        $status = 'Proses&nbsp;Nota';
                    }
                } else if ($value['inv_tagihan'] == 0) {
                    $status = 'Menunggu&nbsp;Tagihan';
                }
                ?><tr>
                    <td><?php echo $no ?></td>
                    <td><?php echo $value['wo_nomer']; ?></td>
                    <td><?php echo $value['pel_nama']; ?></td>
                    <td><?php echo $value['msc_nopol']; ?></td>
                    <td style="text-align: center"><?php echo date('d-m-Y', strtotime($value['wo_tgl'])); ?></td>
                    <td style="text-align: center"><?php echo!empty($value['inv_tgl']) ? date('d-m-Y', strtotime($value['inv_tgl'])) : ''; ?></td>
                    <td style="text-align: center"><?php echo $value['inv_tagihan'] == 1 ? date('d-m-Y', strtotime($value['inv_tgl_tagihan'])) : ''; ?></td>
                    <td><?php echo $status; ?></td>
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
    header("Content-Disposition: attachment; filename=status_wo.xls");
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