<html>
    <!-- License:  LGPL 2.1 or QZ INDUSTRIES SOURCE CODE LICENSE -->
    <head><title></title>    
        <script type="text/javascript">
            function monitorPrinting() {
                var applet = document.jzebra;
                if (applet != null) {
                    if (!applet.isDonePrinting()) {
                        window.setTimeout('monitorPrinting()', 100);
                    } else {
                        var e = applet.getException();
                        self.close();
                    }
                } else {
                    alert("Applet not loaded!");
                }
            }


            function print() {
<?php $remove = array("\n", "\r\n", "\r"); ?>
        var applet = document.jzebra;
        if (applet != null) {
            applet.setPaperSize('20', '30');
            // applet.setAutoSize(true);
            applet.findPrinter();
            applet.setJobName("Print_wo");
            applet.append("\x1B\x21\x00"); // reset print
            applet.append("\x1D\x12"); // font kecil
            applet.append("\x1B\x46"); // ESC F -> set Bold Off
            applet.append("\n               <?php
$reprint = "";
if ($data['inv_print'] > 0) {
    $reprint = " REPRINT KE " . $data['inv_print'];
} echo sprintf("%' -40s", ses_dealer) . $data['wo_nomer'] . $reprint;
?>");
            applet.append("\n               <?php echo sprintf("%' -40s", " ") . Date('d-M-Y H:i', strtotime($data['inv_tgl'])) . sprintf("%' -3s", " ") . $data['inv_tgl']; ?>");
            applet.append("\n               <?php echo sprintf("%' -55s", str_replace($remove, " ", ses_alamat)); ?>");
            applet.append("\n               <?php echo sprintf("%' -55s", ses_phone); ?>");
            applet.append("\n               <?php echo sprintf("%' -55s", ses_npwp); ?>");
            applet.append("\n");
            applet.append("\n");
            applet.append("\nWORK ORDER = <?php echo $data['wo_nomer']; ?>");
            applet.append("\nTANGGAL    = <?php echo dateToIndo($data['wo_tgl']); ?>");
            applet.append("\nWAKTU      = <?php echo Date('H:i', strtotime($data['wo_createon'])); ?>");
            applet.append("\n                      [INVOICE]                         <?php
echo Date('d-m-Y/H:i');
?> ");
            applet.append("\n<?php echo sprintf("%'--96s", "-"); ?>");
            applet.append("\nKWITANSI PEMBAYARAN (INVOICE)");
            applet.append("\n<?php echo sprintf("%'--96s", "-"); ?>");
            applet.append("\nNAMA PEMILIK  : <?php echo sprintf("%' -50s", str_replace('"', " ", $data['pel_nama'])) . "NO.POLISI  :" . $data['msc_nopol']; ?>");
            applet.append("\nALAMAT        : <?php
$alamat = str_replace($remove, " ", str_replace("\\", "/", strtoupper($data['pel_alamat'])));
echo sprintf("%' -50s", substr($alamat, 0, 49)) . "NO.RANGKA  :" . $data['msc_norangka'];
?>");
            applet.append("\n              : <?php echo sprintf("%' -50s", substr($alamat, 49, 49)) . "NO.MESIN   :" . $data['msc_nomesin']; ?>");
            applet.append("\n              : <?php echo sprintf("%' -50s", substr($alamat, 98, 49)) . "KM.MASUK   :" . $data['wo_km']; ?>");
            applet.append("\nTELPON        : <?php echo sprintf("%' -50s", $data['pel_hp']) . "MEKANIK    : -" ?>");
            applet.append("\nSVC.Ad/FR.MAN : <?php echo sprintf("%' -50s", $sa['kr_nama']) . "TGL. MASUK :" . Date('d-m-Y/H:i', strtotime($data['wo_createon'])); ?>");
            applet.append("\nFINAL CHECKER : <?php echo sprintf("%' -50s", $fc['kr_nama']) . "TGL.SELESAI:" . Date('d-m-Y/H:i', strtotime($data['inv_createon'])); ?>");
            applet.append("\n<?php echo sprintf("%'--96s", "-"); ?>");
            applet.append("\nRINCIAN TAGIHAN<?php echo sprintf("%' -67s", " ") ?>JUMLAH");
            applet.append("\n<?php echo sprintf("%'--96s", "-"); ?>");
            applet.append("\nPEKERJAAN YANG DILAKUKAN");
<?php
$subtot = 0;
$disc = false;
$subtotal = 0;
$persendisc = 0;
if (count($flat) > 0) {
    foreach ($flat as $row) {
        $juals = $row['dinv_harga'];
        if ($row['dinv_diskon'] > 0) {
            $persendisc = $row['dinv_diskon'];
            $disc = true;
        }

        if ($data['inv_tampil_ppn'] == '1') {
            $juals /= 1.1;
            $row['dinv_subtotal'] /= 1.1;
        } else {
            $juals = $row['dinv_harga'];
        }
        $subtot += $juals;
        $subtotal += $row['dinv_subtotal'];
        ?>
                            applet.append("\n<?php echo sprintf("%' -70s", substr($row['flat_deskripsi'], 0, 60)) . " Rp " . sprintf("% 14s", number_format($juals)); ?>");
        <?php
    }
    //  echo substr($ff, 0, -1);
}

$lc = $subtot;
$parts = $data['inv_sm'] + $data['inv_oli'] + $data['inv_so'] + $data['inv_spart'];
if ($data['inv_tampil_ppn'] == '1') {
    $lc /= 1.1;
    $parts /= 1.1;
    $data['inv_lc'] /= 1.1;
    $ppn = $data['inv_total'] / 1.1 * 0.1;
} else {
    $ppn = 0;
}

$total = $data['inv_lc'] + $parts;
?>

            applet.append("\n<?php echo sprintf("%' -70s", " ") . sprintf("%'--19s", "-") . "+"; ?>");
            applet.append("\n<?php echo sprintf("%' -70s", "SUB TOTAL ONGKOS JASA") . " Rp " . sprintf("% 14s", number_format($subtot)); ?>");
<?php if ($disc) {
    ?>
                    applet.append("\n<?php echo sprintf("%' -70s", "DISKON JASA ($persendisc%) ") . " Rp " . sprintf("% 14s", number_format($subtot-$subtotal)); ?>");
                    applet.append("\n<?php echo sprintf("%' -70s", " ") . sprintf("%'--19s", "-") . "-"; ?>");
                    applet.append("\n<?php echo sprintf("%' -70s", "ONGKOS JASA ") . " Rp " . sprintf("% 14s", number_format($data['inv_lc'])); ?>");
<?php }
?>
            applet.append("\n<?php echo sprintf("%' -70s", "PEMAKAIAN S/PARTS, SM, OIL & SO") . " Rp " . sprintf("% 14s", number_format($parts)); ?>");
            applet.append("\n<?php echo sprintf("%' -70s", " ") . sprintf("%'--19s", "-") . "+"; ?>");
            applet.append("\n<?php echo sprintf("%' -70s", "DASAR PENGENAAN PAJAK") . " Rp " . sprintf("% 14s", number_format($total)); ?>");
            applet.append("\n<?php echo sprintf("%' -70s", "PPN (TAX) (10%)") . " Rp " . sprintf("% 14s", number_format($ppn)); ?>");
            applet.append("\n<?php echo sprintf("%' -70s", " ") . sprintf("%'--19s", "-") . "+"; ?>");
            applet.append("\n<?php echo sprintf("%' -70s", "GRAND TOTAL") . " Rp " . sprintf("% 14s", number_format($data['inv_total'])); ?>");
            applet.append("\n<?php echo sprintf("%' -70s", "PEMBAYARAN") . " Rp " . sprintf("% 14s", number_format($data['inv_bayar'])); ?>");
            applet.append("\n<?php echo sprintf("%' -70s", " ") . sprintf("%'--19s", "-") . "-"; ?>");
            applet.append("\n<?php echo sprintf("%' -70s", "SISA TAGIHAN") . " Rp " . sprintf("% 14s", number_format($data['inv_total'] - $data['inv_bayar'])); ?>");
            applet.append("\n\n TERBILANG : <?php echo $this->system->toTerbilang($data['inv_total'] - $data['inv_bayar']) . " rupiah" ?>");
            applet.append("\n UNTUK DIKETAHUI (FOR YOUR REFERENCE)");
            applet.append("\n - <?php echo str_replace('"', "'", $data['inv_catatan']); ?>");
            //                    applet.append("\x1B\x21\x00"); // reset print
            applet.append("\n\n DICETAK OLEH : <?php echo sprintf("%' -50s", ses_nama); ?>Ttd.Pelanggan ;");
            applet.append("\f");
            while (!applet.isDoneAppending()) {
            } //wait for image to download to java
            applet.print(); // send commands to printer
        } else
        {
            alert("Kosong")
        }
        //   applet.append("\x1B\x21\x00"); //reset printer
        monitorPrinting();
        //  applet.append("\x1B\x21\x00"); // reset print
    }
        </script>
    </head>
    <body id="content" bgcolor="#FFF380" onload="print();">
        <object type="application/x-java-applet"
                code="jzebra.PrintApplet.class"
                height="300" width="550" name="jzebra"
                archive="<?php echo base_url(); ?>/zebra/jzebra.jar" id="zebra">
            Applet failed to run.  No Java plug-in was found.
        </object><br />
    </body>
</html>