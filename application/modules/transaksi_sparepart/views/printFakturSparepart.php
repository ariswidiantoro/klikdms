<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<html>
    <head>
        <title>Print</title> 
        <script type="text/javascript">
            function monitorPrinting() {
                var applet = document.jzebra;
                if (applet != null) {
                    if (!applet.isDonePrinting()) {
                        window.setTimeout('monitorPrinting()', 100);
                    } else {
                        var e = applet.getException();
                        //                        alert("Sukses");
                        self.close();
                    }
                } else {
                    alert("Applet not loaded!");
                }
            }
            function print() {
                var applet = document.jzebra;
                if (applet != null) {
                    //applet.setPaperSize('20', '80');
                    // applet.setAutoSize(true);
                    applet.findPrinter();
                    applet.setJobName("Print_faktur_sparepart");
                    applet.append("\x1B\x21\x00"); // reset print
                    applet.append("\x1D\x12"); // font kecil
                    applet.append("\x1B\x46"); // ESC F -> set Bold Off   
                    applet.append("<?php
echo sprintf("%' -37s", ses_dealer);
echo sprintf("% 57s", ses_kota . ', ' . date('d-M-Y'));
?>\n");
            applet.append("<?php
echo sprintf("%' -80s", substr(ses_alamat, 0, 79));
?>\n");
            applet.append("<?php
echo sprintf("%' -80s", ses_kota);
?>\n");
            applet.append("<?php
echo sprintf("%' -80s", 'TELP : ' . ses_phone);
?>\n\n");
            applet.append("<?php
$reprint = "";
if (intval($data['not_print']) > 1) {
    $reprint = " PRINT KE " . intval($data['not_print']);
}
echo sprintf("%' 55s", "FAKTUR SPAREPART      ") . $reprint;
?>\n");
            applet.append("<?php
echo sprintf("%' -68s", "NO. NOTA       : " . $data['not_nomer']);
?>\n");
            applet.append("<?php
echo sprintf("%' -68s", "TGL NOTA       : " . date('d-M-Y', strtotime($data['not_tgl'])));
?>\n");
            applet.append("<?php
echo sprintf("%' -68s", "DICETAK        : " . date('d-M-Y H:i'));
?>\n");
            applet.append("<?php
echo sprintf("%' -68s", "NAMA PELANGGAN : " . $data['pel_nama']);
?>\n");
            applet.append("----------------------------------------------------------------------------------------------\n");

            applet.append("<?php
echo sprintf("%' -20s", "Kode Part");
echo sprintf("%' -32s", "Nama Part");
echo sprintf("%' -5s", "Qty");
echo sprintf("%' 14s", "Harga");
echo sprintf("%' 5s", "Disc");
echo sprintf("%' 14s", "Sub Total");
?>\n");
            applet.append("----------------------------------------------------------------------------------------------\n");
<?php
$total = 0;
if (count($barang) > 0) {
    foreach ($barang as $row) {
        if ($data['not_tampil_ppn'] == 1) {
            $row['dsupp_harga'] /= 1.1;
            $row['dsupp_subtotal'] /= 1.1;
        }
        echo 'applet.append("' . sprintf("%' -20s", substr($row['inve_kode'], 0, 20)) . '");';
        echo 'applet.append("' . sprintf("%' -32s", substr($row['inve_nama'], 0, 32)) . '");';
        echo 'applet.append("' . sprintf("%' -5s", $row['dsupp_qty']) . '");';
        echo 'applet.append("' . sprintf("%' 14s", number_format(round($row['dsupp_harga']))) . '");';
        echo 'applet.append("' . sprintf("%' 5s", $row['dsupp_diskon']) . '");';
        echo 'applet.append("' . sprintf("%' 14s", number_format(round($row['dsupp_subtotal']))) . '\n");';
        $total += $row['dsupp_subtotal'];
    }
    $ppn = 0;
    if ($data['not_tampil_ppn'] == 1) {
        $ppn = $data['not_total'] - $total;
    }
    echo 'applet.append("----------------------------------------------------------------------------------------------\n");';
    echo 'applet.append("' . sprintf("%' 75s", "TOTAL") . '");';
    echo 'applet.append("' . sprintf("%' 15s", number_format(round($total))) . '\n");';
    echo 'applet.append("' . sprintf("%' 75s", "PPN") . '");';
    echo 'applet.append("' . sprintf("%' 15s", number_format($ppn)) . '\n");';
    echo 'applet.append("' . sprintf("%' 75s", "GRAND TOTAL") . '");';
    echo 'applet.append("' . sprintf("%' 15s", number_format(round($data['not_total']))) . '\n");';
    echo 'applet.append("----------------------------------------------------------------------------------------------\n");';
    $terbilang = strtoupper($this->system->toTerbilang(round($data['not_total']))) . " RUPIAH";
    echo 'applet.append("TERBILANG : ' . substr($terbilang, 0, 60) . '");';
    echo 'applet.append("\n            ' . substr($terbilang, 60, 120) . '\n");';
    echo 'applet.append("----------------------------------------------------------------------------------------------\n");';
    if ($data['not_pay_method'] == 'kredit') {
        echo 'applet.append("UANG MUKA : ' . number_format($data['not_uang_muka']) . ', SISA TAGIHAN : '
        . number_format(round($data['not_total']) - $data['not_uang_muka']) . '");';
    }
}
?>

            applet.print(); // send commands to printer
            applet.append("\f");
        } else {
            alert("Kosong");
        }

        monitorPrinting();
    }
        </script>
    </head>
    <body id="content" bgcolor="#FFF" onload="print();">
        <object type="application/x-java-applet"
                code="jzebra.PrintApplet.class"
                height="150" width="150" name="jzebra"
                archive="<?php echo base_url(); ?>zebra/jzebra.jar" id="zebra">
            Applet failed to run.  No Java plug-in was found.
        </object><br />
    </body>
</html>