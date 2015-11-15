<?php
define('METHOD', $etc['output']);

function format_number($number) {
    if (METHOD == 'excel') {
        return number_format($number, 2, '.', '');
    } else{
        return number_format($number, 2);
    }
}

$all_pend = 0;
$all_penj = 0;
$all_bp = 0;
$all_hpp = 0;
$all_bu = 0;
$all_bo = 0;
$all_bno = 0;
$all_plu = 0;

$no_pend = 1;
$no_penj = 1;
$no_bp = 1;
$no_hpp = 1;
$no_bu = 1;
$no_bo = 1;
$no_bno = 1;
$no_plu = 1;

if ($etc['output'] != 'show') {
?>
<link type="text/css" href="<?php echo path_css(); ?>report.css" rel="stylesheet" />
<div>
    <table id="table-header-detail" >
        <tr>
            <td colspan="7" align="center"><h3><?php echo $etc['judul']?></h3></td>
        </tr>
        <tr>
            <td width="150px">CABANG</td>
            <td width="1px">:</td>
            <td><?php echo $cabang['cb_nama'].' ('.$cabang['cbid'].')'?></td>
            <td width="15px">&nbsp;</td>
            <td width="150px">&nbsp;</td>
            <td width="1px">:</td>
            <td><?php echo '';?></td>
        </tr>
        <tr>
            <td>ALAMAT</td>
            <td>:</td>
            <td><?php echo $cabang['cb_alamat']?></td>
            <td width="15px">&nbsp;</td>
            <td width="150px;">PERIODE</td>
            <td width="1px;">:</td>
            <td><?php echo $etc['bulan']?></td>
        </tr>
        <tr>
            <td>TELP</td>
            <td>:</td>
            <td><?php echo $cabang['cb_telpon']?></td>
            <td width="15px">&nbsp;</td>
        </tr>
    </table>
</div>
<br/>
<?php } ?>
<div  style="width: 100%;">
    <table id="table-header-detail" style="width:500px;">
       <tbody>
            <tr>
                <th colspan="5">PENDAPATAN</th>
            </tr>
                <tr>
                    <td style="width: 10px;">&nbsp;</td>
                    <td colspan="4">PENDAPATAN USAHA</td>
                </tr>
                <?php
                    foreach ($pendapatan as $row_p) {
                        $all_pend += $row_p['saldo']; ?>
                        <tr>
                            <td >&nbsp;</td>
                            <td ><?php echo $no_pend ?></td>
                            <td ><?php echo strtoupper($row_p['coa_kode']); ?></td>
                            <td ><?php echo strtoupper($row_p['coa_desc']); ?></td>
                            <td align="right"><?php echo format_number($row_p['saldo']); ?></td>
                        </tr>
                        <?php
                        $no_pend++;
                    }
                ?>
                <tr>
                    <td >&nbsp;</td>
                    <td colspan="3">TOTAL PENDAPATAN USAHA</td>
                    <td align="right" style="text-align: right;"><?php echo format_number($all_pend)?></td>
                </tr>
                <tr>
                    <td >&nbsp;</td>
                    <td colspan="4">PENJUALAN</td>
                </tr>
                <?php
                    foreach ($penjualan as $row_pj) {
                        $all_penj += $row_pj['saldo']; ?>
                        <tr>
                            <td colspan="2" style="width:10px;">&nbsp;</td>
                            <td style="width:40px;">&nbsp;&nbsp;&nbsp;<?php echo strtoupper($row_pj['coa_kode']); ?></td>
                            <td ><?php echo strtoupper($row_pj['coa_desc']); ?></td>
                            <td align="right"><?php echo format_number($row_pj['saldo']); ?></td>
                        </tr>
                        <?php
                        $no_penj++;
                    }
                ?>
                <tr>
                    <td >&nbsp;</td>
                    <td colspan="3">TOTAL PENJUALAN</td>
                    <td align="right" style="text-align: right;"><?php echo format_number($all_penj)?></td>
                </tr>
                <tr>
                <td colspan="4">TOTAL PENDAPATAN</td>
                <td align="right" style="text-align: right;"><?php 
                    $T_Pendapatan = $all_pend + $all_penj;
                    echo format_number($T_Pendapatan)?></td>
                </tr>
                <tr>
                    <td colspan="5"></td>
                </tr>
                <tr>
                <th colspan="5">BIAYA ATAS PENDAPATAN</th>
            </tr>
                <tr>
                    <td >&nbsp;</td>
                    <td colspan="4">BIAYA PRODUKSI</td>
                </tr>
                <?php
                    foreach ($biayaProduksi as $row_bp) {
                        $all_bp += $row_bp['saldo']; ?>
                        <tr>
                            <td >&nbsp;</td>
                            <td ><?php echo $no_bp ?></td>
                            <td ><?php echo strtoupper($row_bp['coa_kode']); ?></td>
                            <td ><?php echo strtoupper($row_bp['coa_desc']); ?></td>
                            <td align="right"><?php echo format_number($row_bp['saldo']); ?></td>
                        </tr>
                        <?php
                        $no_bp++;
                    }
                ?>
                <tr>
                    <td >&nbsp;</td>
                    <td colspan="3">TOTAL BIAYA PRODUKSI</td>
                    <td align="right" style="text-align: right;"><?php echo format_number($all_bp)?></td>
                </tr>
                <tr>
                    <td >&nbsp;</td>
                    <td colspan="4">HPP</td>
                </tr>
                <?php
                    foreach ($hpp as $row_hpp) {
                        $all_hpp += $row_hpp['saldo']; ?>
                        <tr>
                            <td >&nbsp;</td>
                            <td ><?php echo $no_hpp ?></td>
                            <td ><?php echo strtoupper($row_hpp['coa_kode']); ?></td>
                            <td ><?php echo strtoupper($row_hpp['coa_desc']); ?></td>
                            <td align="right"><?php echo format_number($row_hpp['saldo']); ?></td>
                        </tr>
                        <?php
                        $no_hpp++;
                    }
                ?>
                <tr>
                    <td >&nbsp;</td>
                    <td colspan="3">TOTAL HPP</td>
                    <td align="right" style="text-align: right;"><?php echo format_number($all_hpp)?></td>
                </tr>
                <tr>
                    <td >&nbsp;</td>
                    <td colspan="4">BIAYA LAIN</td>
                </tr>
                <?php
                    foreach ($biayaUsaha as $row_bu) {
                        $all_bu += $row_bu['saldo']; ?>
                        <tr>
                            <td >&nbsp;</td>
                            <td ><?php echo $no_bu?></td>
                            <td ><?php echo strtoupper($row_bu['coa_kode']); ?></td>
                            <td ><?php echo strtoupper($row_bu['coa_desc']); ?></td>
                            <td align="right"><?php echo format_number($row_bu['saldo']); ?></td>
                        </tr>
                        <?php
                        $no_bu++;
                    }
                ?>
                <tr>
                    <td >&nbsp;</td>
                    <td colspan="3">TOTAL BIAYA LAIN</td>
                    <td align="right" style="text-align: right;"><?php echo format_number($all_bu)?></td>
                </tr>
            <tr>
                <td colspan="4">TOTAL BIAYA ATAS PENDAPATAN</td>
                <td align="right" style="text-align: right;"><?php 
                    $T_BiayaAtsPend = $all_hpp+$all_bp+$all_bu;
                    echo format_number($T_BiayaAtsPend)?></td>
            </tr>
            <tr>
                <th colspan="4">RUGI LABA KOTOR</th>
                <th align="right" style="text-align: right;"><?php 
                    $rugilabaKotor = $T_Pendapatan - $T_BiayaAtsPend;
                    echo format_number($rugilabaKotor); ?></th>
            </tr>
            <tr>
                <td colspan="5"></td>
            </tr>
            <tr>
                <th colspan="5">PENGELUARAN OPERASIONAL</th>
            </tr>
                <tr>
                    <td >&nbsp;</td>
                    <td colspan="4">BIAYA OPERASIONAL</td>
                </tr>
                <?php
                    foreach ($biayaOperasional as $row_bo) {
                        $all_bo += $row_bo['saldo']; ?>
                        <tr>
                            <td >&nbsp;</td>
                            <td ><?php echo $no_bo?></td>
                            <td ><?php echo strtoupper($row_bo['coa_kode']); ?></td>
                            <td ><?php echo strtoupper($row_bo['coa_desc']); ?></td>
                            <td align="right"><?php echo format_number($row_bo['saldo']); ?></td>
                        </tr>
                        <?php
                        $no_bo++;
                    }
                ?>
                <tr>
                    <td >&nbsp;</td>
                    <td colspan="3">TOTAL BIAYA OPERASIONAL</td>
                    <td align="right" style="text-align: right;"><?php echo format_number($all_bo)?></td>
                </tr>
                <tr>
                    <td >&nbsp;</td>
                    <td colspan="4">BIAYA NON OPERASIONAL</td>
                </tr>
                <?php
                    foreach ($biayaNonOperasional as $row_bno) {
                        $all_bno += $row_bno['saldo']; ?>
                        <tr>
                            <td >&nbsp;</td>
                            <td ><?php echo $no_bno?></td>
                            <td ><?php echo strtoupper($row_bno['coa_kode']); ?></td>
                            <td ><?php echo strtoupper($row_bno['coa_desc']); ?></td>
                            <td align="right"><?php echo format_number($row_bno['saldo']); ?></td>
                        </tr>
                        <?php
                        $no_bno++;
                    }
                ?>
                <tr>
                    <td >&nbsp;</td>
                    <td colspan="3">TOTAL BIAYA NON OPERASIONAL</td>
                    <td align="right" style="text-align: right;"><?php echo format_number($all_bno)?></td>
                </tr>
                <tr>
                    <td colspan="4">TOTAL PENGELUARAN OPERASIONAL</td>
                    <td align="right" style="text-align: right;"><?php 
                        $pengeluaranOp = ($all_bo + $all_bno);
                        echo format_number($pengeluaranOp); ?></td>
                </tr>
               <tr>
                    <th colspan="4">RUGI LABA OPERASI</th>
                    <th align="right" style="text-align: right;"><?php 
                        $rugilabaOperasi = $rugilabaKotor -$pengeluaranOp ;
                        echo format_number($rugilabaOperasi); ?></th>
                </tr>
                <tr>
                <td colspan="5"></td>
                </tr>
                <tr>
                    <th colspan="5">PENDAPATAN LAIN</th>
                </tr>
                <tr>
                    <td >&nbsp;</td>
                    <td colspan="4">PENDAPATAN LUAR USAHA</td>
                </tr>
                <?php
                    foreach ($pendapatanLuarUsaha as $row_plu) {
                        $all_plu += $row_plu['saldo']; ?>
                        <tr>
                            <td >&nbsp;</td>
                            <td ><?php echo $no_plu?></td>
                            <td ><?php echo strtoupper($row_plu['coa_kode']); ?></td>
                            <td ><?php echo strtoupper($row_plu['coa_desc']); ?></td>
                            <td align="right"><?php echo format_number($row_plu['saldo']); ?></td>
                        </tr>
                        <?php
                        $no_plu++;
                    }
                ?>
                <tr>
                    <td >&nbsp;</td>
                    <td colspan="3">TOTAL PENDAPATAN LUAR USAHA</td>
                    <td align="right" style="text-align: right;"><?php echo format_number($all_plu)?></td>
                </tr>
                <tr>
                    <td colspan="4">TOTAL PENDAPATAN LAIN</td>
                    <td align="right" style="text-align: right;"><?php 
                        $T_PendapatanLain = $all_plu;
                        echo format_number($T_PendapatanLain); ?></td>
                </tr>
        </tbody>
        <tfoot>
            <tr>
                    <th colspan="4">RUGI LABA BERSIH</th>
                    <th align="right" style="text-align: right;"><?php 
                        $rugilabaBersih = $rugilabaOperasi + $T_PendapatanLain;
                        echo format_number($rugilabaBersih); ?></th>
                </tr>
        </tfoot>
    </table>
</div>
<?php
if($etc['output'] != 'show'){
    ?>
<table style='margin-top: 10px;' id='table-footer-detail'>
                <tr><td colspan='5'><p align="left"><?php echo ses_kota . ", " . date('d-m-Y') . ", " . date('H:i:s'); ?> </p></td></tr>
                <tr><td class="sign">Dibuat</td><td class='sign'>Diketahui</td><td class="sign">Diperiksa</td><td class="sign" style="width:3.1cm;">Disetujui</td><td class="sign">Diaudit</td></tr>
                <tr><td colspan="5" height="80"></td></tr>
                <tr>
                    <td class="sign">........................<br/>Kasir</td>
                    <td class="sign">........................<br />Ka.bag/ADH</td>
                    <td class="sign">........................<br/>Accounting</td>
                    <td class="sign">........................<br />Branch Manager</td>
                    <td class="sign">........................<br/>Audit</td>
                </tr>
  </table>  
<?php
}
if ($etc['output'] == 'excel') {
    ?>
    <script type="text/javascript">
        window.close();
    </script>  
    <?php
    header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=RUGILABA_STANDAR.xls");
    header("Pragma: no-cache");
    header("Expires: 0");
    $break = "";
} else if ($etc['output'] == 'print') {
    $break = "<div style='page-break-after: always;'></div>"
    ?>
    <script type="text/javascript">
        window.print();
        history.back();
    </script>               
<?php
}
?>
