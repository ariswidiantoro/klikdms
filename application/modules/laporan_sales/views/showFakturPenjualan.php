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
            <th width="2%">No&nbsp;Faktur</th>
            <th width="2%">Tgl&nbsp;Faktur</th>
            <th width="2%">No&nbsp;Spk</th>
            <th width="2%">No&nbsp;Kontrak</th>
            <th width="2%">Tgl Spk</th>
            <th width="2%">Nama&nbsp;Salesman</th>
            <th width="2%">Nama&nbsp;Customer</th>
            <th width="2%">Alamat&nbsp;Customer</th>
            <th width="2%">Kota</th>
            <th width="2%">Telpon/Hp</th>
            <th width="2%">Merk</th>
            <th width="2%">Model</th>
            <th width="2%">Type</th>
            <th width="2%">Warna</th>
            <th width="2%">Tahun</th>
            <th width="2%">Leasing</th>
            <th width="2%">Refund&nbsp;Leasing</th>
            <th width="2%">Keterangan</th>
            <th width="2%">Harga&nbsp;Kosong</th>
            <th width="2%">Bbn</th>
            <th width="2%">Aksesories</th>
            <th width="2%">Karoseri</th>
            <th width="2%">Administrasi</th>
            <th width="2%">Cashback</th>
            <th width="2%">Diskon</th>
            <th width="2%">Total&nbsp;Harga</th>
            <th width="2%">Uang&nbsp;Muka</th>
            <th width="2%">Sisa&nbsp;Tagihan</th>
        </tr>
        <?php
        if (count($data) > 0) {
            $no = 1;

            foreach ($data as $value) {
                ?><tr>
                    <td><?php echo $no ?></td>
                    <td><?php echo " " . $value['fkp_nofaktur']; ?></td>
                    <td><?php echo dateToIndo($value['fkp_tgl']); ?></td>
                    <td><?php echo " " . $value['spk_no']; ?></td>
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
                    <td><?php echo str_replace(' ', '&nbsp;', $value['warna_deskripsi']); ?></td>
                    <td><?php echo $value['msc_tahun'] ?></td>
                    <td><?php echo $value['leas_nama'] ?></td>
                    <td><?php echo 0 ?></td>
                    <td><?php echo $value['fkp_keterangan'] ?></td>
                    <td class="right"><?php echo number_format($value['byr_hargako']); ?></td>
                    <td class="right"><?php echo number_format($value['byr_bbn']); ?></td>
                    <td class="right"><?php echo number_format($value['byr_aksesoris']); ?></td>
                    <td class="right"><?php echo number_format($value['byr_karoseri']); ?></td>
                    <td class="right"><?php echo number_format($value['byr_admin']); ?></td>
                    <td class="right"><?php echo number_format($value['byr_cashback']); ?></td>
                    <td class="right"><?php echo number_format($value['byr_diskon']); ?></td>
                    <td class="right"><?php echo number_format($value['byr_total']); ?></td>
                    <td class="right"><?php echo number_format($value['byr_um']); ?></td>
                    <td class="right"><?php echo number_format($value['byr_total'] - $value['byr_um']); ?></td>
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