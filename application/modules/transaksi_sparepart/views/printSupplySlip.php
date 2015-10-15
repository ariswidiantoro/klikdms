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
            <td width="50%"><?php $wo = !empty($data['wo_nomer']) ? $data['wo_nomer'] : '-';echo $wo; ?></td>
            <td>TGL. SS</td>
            <td>:</td>
            <td><?php echo date("d-m-Y", strtotime($data['spp_tgl'])); ?></td>
        </tr>    
        <tr>
            <td colspan="6" style="padding-top: 10px;">
                <table id="table-detail" >
                    <tr>
                        <th width="2%">No</th>
                        <th width="15%">Kode Barang</th>
                        <th WIDTH="20%">Nama Barang</th>
                        <th width="5%">Qty</th>  
                        <?php if ($data['spp_cetak_harga'] == '1') { ?>
                            <th width="10%">Harga</th>
                            <th width="7%">Diskon</th>
                            <th width="10%">Hpp</th>
                            <th width="15%">Sub total</th> 
                        <?php } ?>
                        <th width="8%">Rak/Lokasi</th>
                    </tr>
                    <?php
                    $no = 1;
                    $total = 0;
                    $total_harga = 0;
                    if (count($barang) > 0) {
                        foreach ($barang as $value) {
                            $total += $value['dsupp_qty'];
                            ?><tr>
                                <td><?php echo $no ?></td>
                                <td><?php echo $value['inve_kode']; ?></td>
                                <td><?php echo $value['inve_nama']; ?></td>
                                <td><?php echo $value['dsupp_qty']; ?></td>
                                <?php if ($data['spp_cetak_harga'] == '1') { ?>
                                    <td style="text-align: right;"><?php echo format_idr($value['dsupp_harga']); ?></td>
                                    <td style="text-align: right;"><?php echo format_idr($value['dsupp_diskon']); ?></td>
                                    <td style="text-align: right;"><?php echo format_idr($value['dsupp_hpp']); ?></td>
                                    <td style="text-align: right;"><?php echo format_idr($value['dsupp_subtotal']); ?></td>
                                <?php } ?>
                                <td><?php echo $value['rak_deskripsi']; ?></td>
                            </tr>
                            <?php
                            $no++;
                            $total_harga += $value['dsupp_subtotal'];
                        }
                    }
                    ?>
                    <tr>
                        <td colspan="3" style="text-align: right;">TOTAL</td>
                        <td colspan="1" style="text-align: left;">
                            <?php echo number_format($total); ?>
                        </td>
                        <?php if ($data['spp_cetak_harga'] == '1') { ?>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td style="text-align: right;"><?php echo number_format($total_harga, 2); ?></td>
                        <?php } ?>
                        <td></td>
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
