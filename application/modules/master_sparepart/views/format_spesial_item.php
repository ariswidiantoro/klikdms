<?php

//require_once('/format/Worksheet.php');
//require_once('/format/Workbook.php');
//function HeaderingExcel($filename) {
//    header("Content-type: application/vnd.ms-excel");
//    header("Content-Disposition: attachment; filename=$filename");
//    header("Expires: 0");
//    header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
//    header("Pragma: public");
//}

function xlsBOF() {
    echo pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0);
    return;
}

// Function penanda akhir file (End Of File) Excel

function xlsEOF() {
    echo pack("ss", 0x0A, 0x00);
    return;
}

function xlsWriteNumber($Row, $Col, $Value) {
    echo pack("sssss", 0x203, 14, $Row, $Col, 0x0);
    echo pack("d", $Value);
    return;
}

// Function untuk menulis data (text) ke cell excel

function xlsWriteLabel($Row, $Col, $Value) {
    $L = strlen($Value);
    echo pack("ssssss", 0x204, 8 + $L, $Row, $Col, 0x0, $L);
    echo $Value;
    return;
}

//function xlsWriteDate($Row, $Col, $Value) {
//
//    $day_difference = 25568; //Day difference between 1 January 1900 to 1 January 1970
//    $day_to_seconds = 86400; // no. of seconds in a day
//    $unixtime = ($Value - $day_difference) * $day_to_seconds;
//    echo date('Y-m-d', $unixtime);
//    return;
//}

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=spesial_item.xls");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
header("Pragma: public");

// memanggil function penanda awal file excel
xlsBOF();

xlsWriteLabel(0, 0, "KODE BARANG");

// mengisi pada cell A2 (baris ke-0, kolom ke-1)
xlsWriteLabel(0, 1, "NAMA BARANG");
xlsWriteLabel(0, 2, "HARGA SPESIAL");

// mengisi pada cell A3 (baris ke-0, kolom ke-2)
xlsWriteLabel(1, 0, "N15001212");
xlsWriteLabel(1, 1, "OIL FILTER");
xlsWriteLabel(1, 2, 100000);


xlsEOF();
exit();
?>
