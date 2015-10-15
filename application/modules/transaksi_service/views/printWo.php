<html>
    <!-- License:  LGPL 2.1 or QZ INDUSTRIES SOURCE CODE LICENSE -->
    <head><title> <?php echo base_url(); ?>zebra/jzebra.jar</title>    
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
                    applet.append("\n               <?php echo sprintf("%' -55s", ses_dealer) . $wo['wo_numerator']; if($wo['wo_status'] == '1') { echo ' [ BATAL ]'; } ?>");            
                    applet.append("\n               <?php if($wo['wo_booking'] == "1") echo sprintf("%' -55s", " ") ."BOOKING"; ?>");            
                    applet.append("\n               <?php echo sprintf("%' -55s", str_replace($remove, " ", ses_alamat)) . "|---------------------|"; ?>");  
                    applet.append("\n               <?php echo sprintf("%' -55s", ses_phone) . "|".sprintf("%' -21s", "WO / ".  internExtern($wo['wo_inextern']))."|"; ?>");  
                    applet.append("\n               <?php echo sprintf("%' -55s", ses_npwp) . "|---------------------|"; ?>");  
                    applet.append("\n<?php echo sprintf("%' -70s", " ") . "|     " . sprintf("%' -16s", $wo['wo_nomer']) . "|"; ?>");  
                    applet.append("\n<?php echo sprintf("%' -70s", " ") . "|---------------------|"; ?> ");  
                    applet.append("\n<?php echo sprintf("%'--96s", "-"); ?>");  
                    applet.append("\n<?php echo "|NO POLISI |TYPE KENDARAAN|NO CHASIS           |"; ?>");  
                    applet.append("<?php echo "NO.ENGINE            |THN.PR|STAND.KM|FRMN / SA|"; ?>");  
                    applet.append("\n<?php echo "|" . sprintf("%' -10s", substr($wo['msc_nopol'], 0, 10)) . "|"; ?>");  
                    applet.append("<?php echo sprintf("%' -14s", substr($wo['model_deskripsi'], 0, 14)) . "|"; ?>");  
                    applet.append("<?php echo sprintf("%' -20s", substr($wo['msc_norangka'], 0, 20)) . "|"; ?>");  
                    applet.append("<?php echo sprintf("%' -21s", substr($wo['msc_nomesin'], 0, 20)) . "|"; ?>");  
                    applet.append("<?php echo sprintf("%' -6s", substr($wo['msc_tahun'], 0, 6)) . "|"; ?>");  
                    applet.append("<?php echo sprintf("%' -8s", substr($wo['wo_km'], 0, 8)) . "|"; ?>");  
                    applet.append("<?php echo sprintf("%' -9s", substr($wo['kr_nama'], 0, 9)) . "|"; ?>");
                    applet.append("\n<?php echo sprintf("%'--96s", "-"); ?>"); 
                    
                    applet.append("\n<?php echo "|NO. LANGGANAN   = " . sprintf("%' -43s", $wo['msc_nopol']) . "|TGL.MASUK       |T.ESTIMASI"; ?>     |"); 
                    applet.append("\n<?php echo "|NAMA. LANGGANAN = " . sprintf("%' -43s", str_replace('"', " ", $wo['pel_nama'])) . "|" . date("d-m-Y h:i", strtotime($wo['wo_createon'])) . "|". date("d-m-y h:i", strtotime($wo['wo_selesai'])); ?> |");
                    applet.append("\n<?php
                    $alamat = str_replace($remove, " ", strtoupper($wo['pel_alamat']));
                    echo "|ALAMAT          = " . sprintf("%' -43s", substr($alamat, 0, 43))."|".sprintf("%'--32s", "-") ; ?>|");
                    applet.append("\n|<?php echo sprintf("%' -17s", " ").sprintf("%' -44s", substr($alamat, 45, 90))."|PARAF"; ?>                           |"); 
                    applet.append("\n<?php echo "|TELP/FAX        = ".sprintf("%' -43s", $wo['pel_hp']."/".$wo['pel_telpon'])."|".sprintf("%' -30s", $wo['wo_pembawa']); ?>  |"); 
                    applet.append("\n|<?php echo sprintf("%'--94s", "-"); ?>|"); 
                    applet.append("\n<?php echo "|".sprintf("%' -46s", " KELUHAN PELANGGAN")."|".sprintf("%' -47s", "PERINTAH PERBAIKAN")."|"; ?>"); 
                   <?php
                   $n = 1;
                   if (Count($jasa)>0) {
                         foreach ($jasa as $cntent) {
                                   echo 'applet.append("\n|'.sprintf("%' -46s", "-".substr(str_replace('"', '\'', $cntent['woj_keluhan']), 0, 45))."|".sprintf("%' -47s", "-".substr(str_replace('"', '\'',$cntent['woj_namajasa']), 0, 45))."|".'");'; 
                                   $n++;
                         }
                   }
                    if (count($sp) > 0) {
                        echo 'applet.append("\n|'.sprintf("%' -46s", " ")."|".sprintf("%' -47s"," ")."|".'");';
                         echo 'applet.append("\n|'.sprintf("%' -46s", " ")."|".sprintf("%' -47s", "SPARE PART")."|".'");'; 
                       $n += 2;
                         foreach ($sp as $cntent) {
                          echo 'applet.append("\n|'.sprintf("%' -46s", " ")."|".sprintf("%' -47s",substr(str_replace('"', '\'',$cntent['inve_nama']), 0, 47))."|".'");'; 
                        $n++;
                       }
                     }
                     
                     if (count($so) > 0) {
                         echo 'applet.append("\n|'.sprintf("%' -46s", " ")."|".sprintf("%' -47s"," ")."|".'");';
                           echo 'applet.append("\n|'.sprintf("%' -46s", " ")."|".sprintf("%' -47s", "SUB ORDER ")."|".'");'; 
                       $n += 2;
                        foreach ($so as $cntent) {
                             echo 'applet.append("\n|'.sprintf("%' -46s", " ")."|".sprintf("%' -47s",substr($cntent['wos_nama'], 0, 47))."|".'");'; 
                              $n++;
                            }
                         }
                         
                         if ($n < 15) {
                             for($i = $n;$i <=15;$i++)    
                             {
                                  echo 'applet.append("\n|'.sprintf("%' -46s", " ")."|".sprintf("%' -47s"," ")."|".'");';
                             }
                         }
                   
                   ?>
                     
                     applet.append("\n|<?php echo sprintf("%'=-94s", "="); ?>|"); 
                     applet.append("\n| Perbaikan yang dilakukan<?php echo sprintf("%' -21s", " ")."|   MEKANIK   |   LEADER   |   F.CHECKER        |";?>");
                     applet.append("\n|<?php echo sprintf("%' -46s", " ")."|             |            |                    |";?>");
                     applet.append("\n|<?php echo sprintf("%' -46s", " ")."|-------------|------------|--------------------|";?>");
                     applet.append("\n|<?php echo sprintf("%' -46s", " ")."|".sprintf("%' -47s","UNTUK DIKETAHUI")."|";?>");
                     applet.append("\n|<?php echo sprintf("%' -46s", " ")."|".sprintf("%' -47s"," ")."|";?>");
                     applet.append("\n|<?php echo sprintf("%' -46s", " ")."|".sprintf("%' -47s"," ")."|";?>");
                     applet.append("\n|<?php echo sprintf("%' -46s", " ")."|".sprintf("%' -47s"," ")."|";?>");
                     applet.append("\n|<?php echo sprintf("%' -46s", " ")."|".sprintf("%' -47s"," ")."|";?>");
                     applet.append("\n|<?php echo sprintf("%' -46s", " ")."|".sprintf("%' -47s"," ")."|";?>");
                     applet.append("\n|<?php echo sprintf("%' -46s", " ")."|".sprintf("%' -47s"," ")."|";?>");
                     applet.append("\n|<?php echo sprintf("%' -46s", " ")."|".sprintf("%' -47s"," ")."|";?>");
                     applet.append("\n|<?php echo sprintf("%' -46s", " ")."|".sprintf("%' -47s"," ")."|";?>");
                     applet.append("\n|<?php echo sprintf("%' -46s", " ")."|".sprintf("%' -47s"," ")."|";?>");
                     applet.append("\n|<?php echo sprintf("%' -46s", " ")."|".sprintf("%' -47s"," ")."|";?>");
                     applet.append("\n|<?php echo sprintf("%'--94s", "-"); ?>|"); 
                     applet.append("\n|[SM] Sub material [BAT] Dibatalkan [SO] Sub order [X] Penggantian [L] Pelumasan [A] Penyetelan|"); 
                     applet.append("\n|[R] Perbaikan [V] Inspeksi [T] Pengencangan [C] Pembersihan [OH] Over Haul                    |"); 
                     applet.append("\n------------------------------------------------------------------------------------------------"); 
                     <?php if($wo['wo_status'] == '1') {?>
//                     applet.append("\n Alasan Batal : $wo->cwo_alasan");
                     <?php } ?>					 
                    applet.append("\n");
                    applet.append("\f"); 
                    while (!applet.isDoneAppending()) {} //wait for image to download to java
                    applet.print(); // send commands to printer
                }else
                {alert("Kosong")}
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
                archive="<?php echo base_url(); ?>zebra/jzebra.jar" id="zebra">
            Applet failed to run.  No Java plug-in was found.
        </object><br />
    </body>
</html>