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
            applet.append("\n               <?php echo sprintf("%' -40s", " ") . Date('d-M-Y H:i', strtotime($data['inv_tgl'])) . sprintf("%' -3s", " ") . $datas['inv_tgl']; ?>");
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
$persendisc = 0;
if (count($flat) > 0) {
    foreach ($flat as $row) {
        $juals = $row->dinv_subtotal;

        if ($row->dinv_diskon > 0) {
            $persendisc = $row->dinv_diskon;
            $disc = true;
        }

        if ($datas->inv_tampil_ppn == '1') {
            $juals /= 1.1;
        } else {
            $juals = $row->dinv_subtotal;
        }
//    $ppn = (intval($datas->dinv_total) - intval($datas->dinv_adm)) / 1.1 * 0.1;
//        if (($datas->inv_incpajak == 'N') || ((substr($pelanggan->wo_nomer, 0, 2) == 'PR') && ($pelanggan->msc_internextern == 'CA'))) {
//            $juals = $row->trj_hargajual;
//        } else {
//            $juals /= 1.1;
//        }
        $subtot += $juals;
        ?>
                            applet.append("\n<?php echo sprintf("%' -70s", substr(clear_string($row->trj_flatename), 0, 60)) . " Rp " . sprintf("% 14s", number_format($juals)); ?>");
        <?php
    }
    //  echo substr($ff, 0, -1);
}

$lc = $datas->dinv_lc;
$parts = intval($datas->dinv_sm) + intval($datas->dinv_oli) +
        intval($datas->dinv_so) +
        intval($datas->dinv_parts);

if ($datas->inv_incpajak == 'Y') {
    $lc = $lc / 1.1;
    $parts = $parts / 1.1;
}
if (ses_brand == '1') {
    $ppn = (intval($datas->dinv_total) - intval($datas->dinv_adm)) / 1.1 * 0.1;
} else {
    if ($datas->inv_incpajak == 'Y') {
        $ppn = (intval($datas->dinv_total) - intval($datas->dinv_adm)) / 1.1 * 0.1;
    } else {
        $ppn = 0;
    }
}

$total = $lc + $parts;
?>

            applet.append("\n<?php echo sprintf("%' -70s", " ") . sprintf("%'--19s", "-") . "+"; ?>");
            applet.append("\n<?php echo sprintf("%' -70s", "SUB TOTAL ONGKOS JASA") . " Rp " . sprintf("% 14s", number_format($subtot)); ?>");
<?php if ($disc) {
    ?>
                    applet.append("\n<?php echo sprintf("%' -70s", "DISKON JASA ($persendisc%) ") . " Rp " . sprintf("% 14s", number_format($subtot - $lc)); ?>");
                    applet.append("\n<?php echo sprintf("%' -70s", " ") . sprintf("%'--19s", "-") . "-"; ?>");
                    applet.append("\n<?php echo sprintf("%' -70s", "ONGKOS JASA ") . " Rp " . sprintf("% 14s", number_format($lc)); ?>");
<?php }
?>
            applet.append("\n<?php echo sprintf("%' -70s", "PEMAKAIAN S/PARTS, SM, OIL & SO") . " Rp " . sprintf("% 14s", number_format($parts)); ?>");
            applet.append("\n<?php echo sprintf("%' -70s", " ") . sprintf("%'--19s", "-") . "+"; ?>");
            applet.append("\n<?php echo sprintf("%' -70s", "DASAR PENGENAAN PAJAK") . " Rp " . sprintf("% 14s", number_format($total)); ?>");
            applet.append("\n<?php echo sprintf("%' -70s", "PPN (TAX) (10%)") . " Rp " . sprintf("% 14s", number_format($ppn)); ?>");
<?php if ($datas->dinv_adm > 0) {
    ?>
                    applet.append("\n<?php echo sprintf("%' -70s", "ADMINISTRASI") . " Rp " . sprintf("% 14s", number_format($datas->dinv_adm)); ?>");
<?php }
?>
            applet.append("\n<?php echo sprintf("%' -70s", " ") . sprintf("%'--19s", "-") . "+"; ?>");
            applet.append("\n<?php echo sprintf("%' -70s", "GRAND TOTAL") . " Rp " . sprintf("% 14s", number_format($datas->dinv_total)); ?>");
<?php if ($datas->dinv_uangmuka > 0) {
    ?>
                    applet.append("\n<?php echo sprintf("%' -70s", "PEMBAYARAN") . " Rp " . sprintf("% 14s", number_format($datas->dinv_uangmuka)); ?>");
                    applet.append("\n<?php echo sprintf("%' -70s", " ") . sprintf("%'--19s", "-") . "-"; ?>");
                    applet.append("\n<?php echo sprintf("%' -70s", "SISA TAGIHAN") . " Rp " . sprintf("% 14s", number_format($datas->dinv_total - $datas->dinv_uangmuka)); ?>");
<?php }
?>
            applet.append("\n\n TERBILANG : <?php echo $this->system->toTerbilang($datas->dinv_total - $datas->dinv_uangmuka) . " rupiah" ?>");
            applet.append("\n UNTUK DIKETAHUI (FOR YOUR REFERENCE)");
            applet.append("\n - <?php echo str_replace('"', "'", $datas->inv_note1); ?>");
            applet.append("\n - <?php echo str_replace('"', "'", $datas->inv_note2); ?>");
<?php
if (count($promo) > 0) {
    ?>
                    //    applet.append("\x1B\x77\x01");
                    //    applet.append("\x1B\x61\x31");
                    //applet.appendHex("x1Bx61x01"); // centering 
    <?php
    foreach ($promo as $row) {
        ?>
                            applet.append("\n<?php echo "         " . clear_string($row['pro_pesan']); ?>");
        <?php
    }
}
?>
            //                    applet.append("\x1B\x21\x00"); // reset print
            applet.append("\n\n DICETAK OLEH : <?php echo sprintf("%' -50s", $datas->inv_kasir); ?>Ttd.Pelanggan ;");
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