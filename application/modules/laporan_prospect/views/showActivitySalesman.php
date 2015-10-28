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
            <th width="20%">Nama</th>
            <th width="10%">Prospek</th>
            <th width="10%">Agenda</th>
            <th width="10%">Follow Up</th>
            <th width="10%">Fpt</th>
            <th width="10%">SPK</th>
            <th width="10%">Faktur</th>
        </tr>
        <?php
        if (count($data) > 0) {
            $spv = '';
            foreach ($data as $value) {
                if ($spv == '' || $spv != $value['supervisor']) {
                    $no = 1;
                    ?>
                    <tr style="background : #FFE0B2;font-weight: bold;">
                        <td colspan ="8">
                            NAMA SUPERVISOR : <?php echo $value['supervisor']; ?>		
                        </td>
                    </tr>
                    <?php
                }
                ?>
                <tr>
                    <td><?php echo $no ?></td>
                    <td><?php echo $value['kr_nama']; ?></td>
                    <td><?php echo $value['jumlah']; ?></td>
                    <td><?php echo !empty($agenda[$value['pros_salesman']]) ? $agenda[$value['pros_salesman']] : 0; ?></td>
                    <td><?php echo !empty($follow[$value['pros_salesman']]) ? $follow[$value['pros_salesman']] : 0; ?></td>
                    <td><?php echo !empty($fpt[$value['pros_salesman']]) ? $fpt[$value['pros_salesman']] : 0; ?></td>
                    <td><?php echo !empty($spk[$value['pros_salesman']]) ? $spk[$value['pros_salesman']] : 0; ?></td>
                    <td><?php echo !empty($faktur[$value['pros_salesman']]) ? $faktur[$value['pros_salesman']] : 0; ?></td>
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