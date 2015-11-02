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
            <th width="2%">No Spk</th>
            <th width="2%">No Kontrak</th>
            <th width="2%">Tgl Spk</th>
            <th width="2%">Nama&nbsp;Salesman</th>
            <th width="2%">Nama&nbsp;Customer</th>
            <th width="2%">Alamat&nbsp;Customer</th>
            <th width="2%">Kota</th>
            <th width="2%">Telpon/Hp</th>
            <th width="2%">Merk</th>
            <th width="2%">Model</th>
            <th width="2%">Type</th>
            <th width="2%">Jenis Harga</th>
            <th width="2%">Qty&nbsp;Unit</th>
            <th width="2%">Harga Kosong</th>
            <th width="2%">Bbn</th>
            <th width="2%">Aksesories</th>
            <th width="2%">Karoseri</th>
            <th width="2%">Administrasi</th>
            <th width="2%">Cashback</th>
            <th width="2%">Diskon</th>
            <th width="2%">Total Harga</th>
        </tr>
        <?php
        if (count($data) > 0) {
            $no = 1;

            foreach ($data as $value) {
                ?><tr>
                    <td><?php echo $no ?></td>
                    <td><?php echo " ".$value['spk_no']; ?></td>
                    <td><?php echo $value['spk_nokontrak']; ?></td>
                    <td><?php echo dateToIndo($value['spk_tgl']); ?></td>
                    <td><?php echo str_replace(' ', '&nbsp;', $value['kr_nama']); ?></td>
                    <td><?php echo str_replace(' ', '&nbsp;', $value['pel_nama']); ?></td>
                    <td><?php echo str_replace(' ', '&nbsp;', $value['pel_alamat']); ?></td>
                    <td><?php echo str_replace(' ', '&nbsp;', $value['kota_deskripsi']); ?></td>
                    <td><?php echo $value['pel_telpon'] . '/' . $value['pel_hp']; ?></td>
                    <td><?php echo $value['merk_deskripsi']; ?></td>
                    <td><?php echo $value['model_deskripsi']; ?></td>
                    <td><?php echo str_replace(' ', '&nbsp;', $value['cty_deskripsi']); ?></td>
                    <td><?php echo ($value['fpt_harga_method'] == 1) ? 'ON&nbsp;THE&nbsp;ROAD' : 'OFF&nbsp;THE&nbsp;ROAD'; ?></td>
                    <td class="right"><?php echo number_format($value['fpt_qty']); ?></td>
                    <td class="right"><?php echo number_format($value['fpt_hargako']); ?></td>
                    <td class="right"><?php echo number_format($value['fpt_bbn']); ?></td>
                    <td class="right"><?php echo number_format($value['fpt_accesories']); ?></td>
                    <td class="right"><?php echo number_format($value['fpt_karoseri']); ?></td>
                    <td class="right"><?php echo number_format($value['fpt_administrasi']); ?></td>
                    <td class="right"><?php echo number_format($value['fpt_cashback']); ?></td>
                    <td class="right"><?php echo number_format($value['fpt_diskon']); ?></td>
                    <td class="right"><?php echo number_format($value['fpt_total']); ?></td>
                </tr>
                <?php
                $no++;
            }
        }
        ?>
        <tr>
            <td>

            </td>
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
    header("Content-Disposition: attachment; filename=surat_pesanan_kendaraan.xls");
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