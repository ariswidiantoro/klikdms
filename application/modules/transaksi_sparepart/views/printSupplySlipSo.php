<link type="text/css" href="<?php echo path_css(); ?>report.css" rel="stylesheet" />
<link type="text/css" href="<?php echo path_css(); ?>mystyle.css" rel="stylesheet" />
<style>
    h3 {text-align: center;}
    table {text-align:  left; letter-spacing: 1px; border-collapse: collapse; font-size: 12px;}
    table th, table td {padding: 2px; vertical-align: top;}
    #tanda {text-align: center;}
    #tanda tr td {height: 50px; }
</style> 

<div style="margin:35px 5px 0px -8px; font-family: tahoma; font-size: 11px; letter-spacing: 1px;">
    <p>
        <span style="float: left;">
            <?php
            echo ses_cabang_nama;
            ?>
        </span>
        <span style="float: right;margin-right: 50px;">
            <?php echo $this->system->dateID(date('Y-m-d')); ?></span>
    </p>
    <br />
    <h3>SUPPLY SLIP <?php
            if ($data['spp_print'] > 1) {
                echo "(REPRINT KE " . intval($data['spp_print'] + 1) . " )";
            }
            ?></h3>
    <input type="hidden" name="sppid" id="supplay" value="<?php echo $data['sppid']; ?>">

    <table width="100%" border="0">
        <tr>
            <td>NAMA PELANGGAN</td>
            <td>:</td>
            <td><?php echo $data['pel_nama']; ?></td>

            <td width="10%">NO. SS</td>
            <td width="1%">:</td>
            <td width="22%"><?php echo $data['spp_noslip']; ?></td>
        </tr>
        <tr>
            <td width="15%">NO. WO</td>
            <td width="1%">:</td>
            <td width="50%"><?php
        $wo = !empty($data['wo_nomer']) ? $data['wo_nomer'] : '-';
        echo $wo;
            ?></td>
            <td>TGL. SS</td>
            <td>:</td>
            <td><?php echo date("d-m-Y", strtotime($data['spp_tgl'])); ?></td>
        </tr>    
        <tr>
            <td colspan="6" style="padding-top: 10px;">
                <table id="table-detail" >
                    <tr>
                        <th width="2%">No</th>
                        <th width="50%">Deskripsi</th>
                        <th WIDTH="20%">Hpp</th>
                        <th WIDTH="20%">Harga</th>
                    </tr>
                    <?php
                    $no = 1;
                    $total = 0;
                    $total_harga = 0;
                    if (count($so) > 0) {
                        foreach ($so as $value) {
                            ?><tr>
                                <td><?php echo $no ?></td>
                                <td><?php echo $value['so_deskripsi']; ?></td>
                                <td style="text-align: right;"><?php echo format_idr($value['so_hpp']); ?></td>
                                <td style="text-align: right;"><?php echo format_idr($value['so_harga']); ?></td>
                            </tr>
                            <?php
                            $no++;
                            $total_harga += $value['so_harga'];
                        }
                    }
                    ?>
                    <tr>
                        <td colspan="3" style="text-align: right;">TOTAL</td>
                        <td style="text-align: right;">
                            <?php echo number_format($total_harga, 2); ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

    </table> 

<?php if ($data['spp_status'] == 1) { ?>
        <div align="center" style="margin: 100px auto; width: 400px; text-align: center; font-family: tahoma; font-size: 12px; letter-spacing: 1px;">
            SUDAH BATAL <br>
            Tanggal batal : <?php echo date('d-M-Y', strtotime($supply['spp_tgl_batal'])) ?>
        </div>
<?php } else { ?>
        <div style="width:150px; border:0px solid; margin-top: 50px; text-align: center;">
            <p style="margin-bottom: 50px">Diserahkan</p>
            (<span style="margin: 0px 100px 0px 100px;"></span>)
        </div>
<?php } ?>
</div>
<script>
    window.print();
    //        window.close();
</script>
