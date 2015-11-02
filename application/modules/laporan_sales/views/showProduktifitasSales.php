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
            <th width="20%">Nama&nbsp;Sales</th>
            <?php
            foreach ($model as $value) {
                ?>
            <th width="10%"><?php echo str_replace(" ", "&nbsp;", $value['model_deskripsi']); ?></th>
                <?php
            }
            ?>
            <th width="10%">TOTAL</th>
        </tr>
        <?php
        if (count($data) > 0) {
            $spv = '';
            foreach ($data as $value) {
                $totalRow = 0;
                if ($spv == '' || $spv != $value['supervisor']) {
                    $no = 1;
                    ?>
                    <tr style="background : #FFE0B2;font-weight: bold;">
                        <td colspan ="15">
                            NAMA SUPERVISOR : <?php echo $value['supervisor']; ?>		
                        </td>
                    </tr>
                    <?php
                }
                ?>
                <tr>
                    <td><?php echo $no ?></td>
                    <td><?php echo $value['salesman']; ?></td>
                    <?php
                    foreach ($model as $mm) {
                        ?>
                        <td width="10%">
                            <?php
                            $jumlah = (!empty($value[$mm['modelid']])) ? $value[$mm['modelid']] : 0;
                            echo $jumlah;
                            ?>
                        </td>
                        <?php
                        $totalRow += $jumlah;
                    }
                    ?>
                    <td><?php echo $totalRow ?></td>
                </tr>
                <?php
                $no++;
                $spv = $value['supervisor'];
            }
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