<html>
<head><title>Print Transaksi</title>    
        <script type="text/javascript">
			function monitorPrinting() {
					var applet = document.zebra;
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
                var applet = document.jzebra;
                if (applet != null) {
                    applet.findPrinter();    
                    <?php
                    $total_trans = 0;
                    ?>		
					applet.append("\x1B\x21\x00"); 
					applet.append("\x1D\x21"); 
					applet.append("\x1B\x46"); 
                    applet.setPaperSize('20', '30');
                    applet.findPrinter();
                    applet.setJobName("Print_Transaksi");
                    applet.append("\n<?php echo sprintf("%' -15s", "DEALER"); ?> : <?php echo ses_dealer; ?>"); 
                    applet.append("\n<?php echo sprintf("%' -15s", "ALAMAT"); ?> : <?php echo ses_alamat; ?>"); 
                    applet.append("\n<?php echo sprintf("%' -15s", "TELP"); ?> : <?php echo ses_phone; ?>");      
                    applet.append("\n");  
                    applet.append("\n<?php echo sprintf("%' -50s"," "); ?><?php echo $judul; ?>");
                    applet.append("\n<?php echo sprintf("%'=-154s", "="); ?>"); 
                    applet.append("\n<?php echo sprintf("%' -20s", "NO. BUKTI"); ?> : <?php echo $main['kst_nomer']; ?>"); 
                    applet.append("\n<?php echo sprintf("%' -20s", "TANGGAL"); ?> : <?php echo $main['kst_tgl']; ?>"); 
                    applet.append("\n<?php echo sprintf("%' -20s", "ACCOUNT"); ?> : <?php echo $main['kst_coa']; ?>");  
                    applet.append("\n<?php echo sprintf("%' -20s", "KETERANGAN"); ?> : <?php echo $main['kst_desc']; ?>"); 
                    applet.append("\n<?php echo sprintf("%'--154s", "-"); ?>"); 
                    applet.append("\n|<?php echo sprintf("%' -5s", " NO");?>");
                    applet.append("| <?php echo sprintf("%' -20s", " ACCOUNT");?>");
                    applet.append("| <?php echo sprintf("%' -96s", " DESKRIPSI"); ?>");
                    applet.append("| <?php echo sprintf("%' 24s", " NOMINAL "); ?> |");
                    applet.append("\n<?php echo sprintf("%'--154s", "-"); ?>"); 
                    <?php			
                    /* DETAIL TRANS */
                    $no = 1;$x = 1;
                    if(count($detail) > 0){
                        foreach ($detail as $rows) {  
                        ?>
                            applet.append("\n|<?php echo sprintf("%' -5s", " ".$no++);?>");
                            applet.append("| <?php echo sprintf("%' -20s", " ".substr($rows['dkst_coa'],0,15)); ?>");
                            applet.append("| <?php echo sprintf("%' -96s", ' '.substr($rows['dkst_descrip'].' '.$rows['dkst_nota'],0,99)); ?>");
                            applet.append("| <?php
                              if($main['kst_type'] == 'I'){
                                    $lbl = sprintf("%' 24s", number_format($rows['dkst_kredit'],2));
                                    $total_trans= $total_trans +$rows['dkst_kredit'];
                              }else{
                                    $lbl = sprintf("%' 24s", number_format($rows['dkst_debit'],2));
                                    $total_trans= $total_trans + $rows['dkst_debit'];  
                              }
                              echo $lbl; ?> |");  
                        <?php     
                        }
                        for ($x = 1; $x <= 16-count($detail); $x++){
                            ?>
                            applet.append("\n|<?php echo sprintf("%' -5s", " ");?>");
                            applet.append("| <?php echo sprintf("%' -20s", " "); ?>");
                            applet.append("| <?php echo sprintf("%' -96s", " "); ?>");
                            applet.append("| <?php echo sprintf("%' 24s", " "); ?> |");
                            <?php
                        } 
                        ?>
                        <?php
                    }else{     
                        for ($x = 1; $x <= 16; $x++){
                            ?>
                            applet.append("\n|<?php echo sprintf("%' -5s", " ");?>");
                            applet.append("| <?php echo sprintf("%' -20s", " "); ?>");
                            applet.append("| <?php echo sprintf("%' -96s", " "); ?>");
                            applet.append("| <?php echo sprintf("%' 24s", " "); ?> |");
                            <?php
                        } 
                    } ?>
                    applet.append("\n<?php echo sprintf("%'--154s", "-"); ?>"); 
                    applet.append("\n| <?php echo sprintf("%' -130s", " TOTAL ");?> | <?php echo sprintf("%' 24s", number_format($total_trans,2));?> |");
					applet.append("\n<?php echo sprintf("%'--154s", "-"); ?>");
                    <?php if($main['kst_trans'] != 'KAS'){ ?>
                    applet.append("\n|<?php echo sprintf("%' -5s", " NO");?>");
                    applet.append("| <?php echo sprintf("%' -25s", " BANK");?>");
                    applet.append("| <?php echo sprintf("%' -20s", " NO.REK");?>");
                    applet.append("| <?php echo sprintf("%' -20s", " NO.CEK");?>");
                    applet.append("| <?php echo sprintf("%' -12s", " J.TEMPO");?>");
                    applet.append("| <?php echo sprintf("%' -20s", " KOTA");?>");
                    applet.append("| <?php echo sprintf("%' -96s", " DESKRIPSI"); ?>");
                    applet.append("| <?php echo sprintf("%' 24s", " NOMINAL "); ?> |");
                    applet.append("\n<?php echo sprintf("%'--154s", "-"); ?>"); 
                    <?php } ?>
					applet.append("\n");
					applet.append("\nTERBILANG : <?php echo strtoupper($this->system->toTerbilang(round($total_trans,0)))." RUPIAH"; ?>");
					applet.append("\n");
                    applet.append("\n---------------------------------------------------------------------------------------------------"); 
                    applet.append("\n|        DIBUAT        |     DISETUJUI      |       DIPERIKSA         |          DITERIMA         |"); 
                    applet.append("\n---------------------------------------------------------------------------------------------------"); 
                    applet.append("\n|                      |                    |                         |                           |"); 
                    applet.append("\n|                      |                    |                         |                           |"); 
                    applet.append("\n|                      |                    |                         |                           |"); 
                    applet.append("\n---------------------------------------------------------------------------------------------------");  
                    
					applet.append("\f");
                while (!applet.isDoneAppending()) {} //wait for image to download to java
                    applet.print();
                }else{
					alert("Kosong");
				}
               monitorPrinting();
            }
        </script>
    </head>
    <body id="content" bgcolor="#CCC" onLoad="print();">
        <object type="application/x-java-applet" code="jzebra.PrintApplet.class" 
                height="120" width="160" name="jzebra" 
                archive="<?php echo site_url();?>zebra/jzebra.jar" id="zebra">
            Applet failed to run.  No Java plug-in was found.
        </object><br />
    </body>
</html>