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
            <th width="2%">Tgl</th>
            <th width="10%">Nama&nbsp;Sales</th>
            <th width="10%">Jenis</th>
            <th width="40%">Kontak</th>
            <!--<th width="15%">Type Kendaraan</th>-->
            <th width="15%">Bisnis</th>
            <th width="15%">Sumber&nbsp;Info</th>
        </tr>
        <?php
        if (count($data) > 0) {
            $spv = '';
            foreach ($data as $value) {
                if ($spv == '' || $spv != $value['supervisor']) {
                    $no = 1;
                    ?>
                    <tr style="background : #FFE0B2;font-weight: bold;">
                        <td colspan ="7">
                            NAMA SUPERVISOR : <?php echo $value['supervisor']; ?>		
                        </td>
                    </tr>
                    <?php
                }
                ?>
                <tr>
                    <td><?php echo $no ?></td>
                    <td><?php echo dateToIndo($value['pros_tgl']); ?></td>
                    <td><?php echo $value['kr_nama']; ?></td>
                    <td><?php echo $value['pros_type']; ?></td>
                    <td><?php echo $value['pros_nama'] . "</br>" . $value['pros_alamat'] . '</br>' . $value['pros_hp']; ?></td>
                    <!--<td></td>-->
                    <td><?php echo $value['bisnis_deskripsi']; ?></td>
                    <td><?php echo $value['smbinfo_deskripsi']; ?></td>
                </tr>
                <?php
                $no++;
                $spv = $value['supervisor'];
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