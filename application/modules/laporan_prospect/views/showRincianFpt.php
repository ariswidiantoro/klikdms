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
            <th width="10%">No Fpt<br>No Prospek<br>Tgl Fpt</th>
            <th width="20%">Nama Customer<br>Alamat<br>Telpon</th>
            <th width="10%">Merk<br>Type<br>Warna</th>
            <th width="10%">Diskon<br>Cashback<br>Komisi</th>
            <th width="10%">Total Harga<br>Salesman</th>
        </tr>
        <?php
        if (count($data) > 0) {
            $no = 1;
            foreach ($data as $value) {
                ?>
                <tr>
                    <td><?php echo $no ?></td>
                    <td><?php echo $value['fpt_kode'] . "<br>" . $value['pros_kode'] . "<br>" . dateToIndo($value['fpt_tgl']) ?></td>
                    <td><?php echo $value['pros_nama'] . "<br>" . $value['pros_alamat'] . "<br>" . $value['pros_hp'] ?></td>
                    <td><?php echo $value['merk_deskripsi'] . "<br>" . $value['cty_deskripsi'] . "<br>" . $value['warna_deskripsi'] ?></td>
                    <td style="text-align: right"><?php echo number_format($value['fpt_diskon']) . "<br>" . number_format($value['fpt_cashback']) . "<br>" . number_format($value['fpt_komisi']) ?></td>
                    <td  style="text-align: right"><?php echo "<span style='text-align: right'>".number_format($value['fpt_total']) . "</span><br>" . $value['kr_nama'] ?></td>
                </tr>
                <?php
                $no++;
            }
            ?>
            <?php
        } else {
            ?>
            <tr>
                <td>&nbsp;</td>
                <td colspan="5">Data Tidak Ditemukan</td>
            </tr>
            <?php
        }
        ?>
        <tr>
            <td>&nbsp;</td>
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
    header("Content-Disposition: attachment; filename=rincian_prospect.xls");
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