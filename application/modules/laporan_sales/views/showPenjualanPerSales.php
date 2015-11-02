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
            <th width="10%">Jan</th>
            <th width="10%">Feb</th>
            <th width="10%">Mar</th>
            <th width="10%">Apr</th>
            <th width="10%">Mei</th>
            <th width="10%">Jun</th>
            <th width="10%">Jul</th>
            <th width="10%">Agu</th>
            <th width="10%">Sep</th>
            <th width="10%">Okt</th>
            <th width="10%">Nop</th>
            <th width="10%">Des</th>
            <th width="10%">TOTAL</th>
        </tr>
        <?php
        if (count($data) > 0) {
            $spv = '';
            foreach ($data as $value) {
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
                    <td><?php $value['1'] = (!empty($value['1'])) ? $value['1'] : 0; echo $value['1']; ?></td>
                    <td><?php $value['2'] = (!empty($value['2'])) ? $value['2'] : 0; echo $value['2'] ?></td>
                    <td><?php $value['3'] = (!empty($value['3'])) ? $value['3'] : 0; echo $value['3'] ?></td>
                    <td><?php $value['4'] = (!empty($value['4'])) ? $value['4'] : 0; echo $value['4'] ?></td>
                    <td><?php $value['5'] = (!empty($value['5'])) ? $value['5'] : 0; echo $value['5'] ?></td>
                    <td><?php $value['6'] = (!empty($value['6'])) ? $value['6'] : 0; echo $value['6'] ?></td>
                    <td><?php $value['7'] = (!empty($value['7'])) ? $value['7'] : 0; echo $value['7'] ?></td>
                    <td><?php $value['8'] = (!empty($value['8'])) ? $value['8'] : 0; echo $value['8'] ?></td>
                    <td><?php $value['9'] = (!empty($value['9'])) ? $value['9'] : 0; echo $value['9'] ?></td>
                    <td><?php $value['10'] = (!empty($value['10'])) ? $value['10'] : 0; echo $value['10'] ?></td>
                    <td><?php $value['11'] = (!empty($value['11'])) ? $value['11'] : 0; echo $value['11'] ?></td>
                    <td><?php $value['12'] = (!empty($value['12'])) ? $value['12'] : 0; echo $value['12'] ?></td>
                    <td><?php echo $value['1']+$value['2']+$value['3']+$value['4']+$value['5']+$value['6']+$value['7']+$value['8']+$value['9']+$value['10']+$value['11']+$value['12']; ?></td>
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