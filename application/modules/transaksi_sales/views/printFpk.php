<style>
    .atas{ }
    .display td { height:0.8cm;font-size: 12px; padding-left:5px ;padding-right:5px ;border: 1px solid #000000;}
    .display1 td {font-size: 12px;padding-left:5px ;padding-right:5px ; }
    p{ font-size: 12px; height: 10px;padding-left: 5px;}
    li{ list-style-type: none;  text-align: right;}
    .display table{border-collapse: collapse; }
    body {margin:3px 3px 3px 3px; padding:0;font-family: monospace;}
    .print td {text-align: left; height: 0.43cm; font-size: 12px; }
    table{ border-collapse: collapse; }
    .print1 td {font-size: 12px; padding-left:5px ; padding-right:5px ;border: 1px solid #000000;text-align: left; } 
    p{ padding-right:0px ;text-align: right;}
    .ketentuan pre{ text-align: left; font-size: 8.3px; height:0.1cm; }
    .print1 pre{ font-size: 10px;}
    td{font-weight: bold;}
    li{ list-style-type: none; text-align: right;}
</style>
<!--- tengahhhhhhh ------------>
<table style="width: 15cm; margin-left: auto;margin-right: auto;" >
    <tr>
        <td style="font-size: 11px;">
            <?php
            echo "NO.Kontrak : " . $fpk['spk_nokontrak'] . "," . date("d-m-Y", strtotime($fpk['fpk_tgl'])) . ", OTR: " . number_format($fpk['fpk_hargaotr'], 2);
            echo ", UM: " . number_format($fpk['fpk_um'], 2) . "</br> TOTAL: " . number_format($fpk['fpk_total'], 2);
            ?> 
        </td>
    </tr>
</table>

<script>
    window.print();
    //window.open('transaksi_penjualan/print_blank','form', 'width=1200,height=600,resizeable,menubar=yes,scrollbars');
    window.close();
</script>