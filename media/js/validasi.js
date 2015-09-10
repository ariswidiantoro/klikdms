function replaceAll(txt, replace, with_this) {
    return parseInt(txt.replace(new RegExp(replace, 'g'), with_this));
}
function nama_field(data){  
    var name= data;   
    var num = $('input[name='+name+']').val();
    num = num.toString().replace(/\$|\,/g,'');
    if(isNaN(num))
        num = "0";
    sign = (num == (num = Math.abs(num)));
    num = Math.floor(num*100+0.50000000001);
    cents = num%100;
    num = Math.floor(num/100).toString();
    if(cents<12)
        cents = "0" + cents;
    for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
        num = num.substring(0,num.length-(4*i+3))+','+
        num.substring(num.length-(4*i+3));
    $('input[name='+name+']').val((((sign)?'':'-') + num));
}
        
function konversi(angka){  
    angka = angka+"";
    var pecah = angka.split(".");
    var uang;
    var pjg;
    var koma;
    if(pecah.length > 1){
        pjg   = pecah[0].length;
        angka = pecah[0];
        koma  = "."+pecah[1];
    }else{
        pjg = angka.length;
        koma = ".00";
    }
    if( pjg == 4 ){
        uang = angka.substr(0,1)+","+angka.substr(1,4);
    }else if( pjg == 5 ){
        uang = angka.substr(0,2)+","+angka.substr(2,5);
    }else if( pjg == 6 ) {
        uang = angka.substr(0,3)+","+angka.substr(3,6); 
    }else if( pjg == 7 ) {
        uang = angka.substr(0,1)+","+angka.substr(1,3)+","+angka.substr(4,3);   
    }else if( pjg == 8 ) {
        uang = angka.substr(0,2)+","+angka.substr(2,3)+","+angka.substr(5,3);   
    }else if( pjg == 9 ) {
        uang = angka.substr(0,3)+","+angka.substr(3,3)+","+angka.substr(6,3);   
    }else if( pjg == 10 ) {
        uang = angka.substr(0,1)+","+angka.substr(1,3)+","+angka.substr(4,3)+","+angka.substr(7,3);   
    }else if( pjg == 11 ) {
        uang = angka.substr(0,2)+","+angka.substr(2,3)+","+angka.substr(5,3)+","+angka.substr(8,3);   
    }else if( pjg == 12 ) {
        uang = angka.substr(0,3)+","+angka.substr(3,3)+","+angka.substr(6,3)+","+angka.substr(9,3);   
    }else if( pjg == 13 ) {
        uang = angka.substr(0,1)+","+angka.substr(1,3)+","+angka.substr(4,3)+","+angka.substr(7,3)+","+angka.substr(10,3);   
    }else{
        uang = angka;
    }
    
    //    var data = uang+koma;
    //    pecah = data.split(".");
    return uang+koma;
}

function cekDefaultNol(data)
{
    if (data.replace(/,/g, "") == '') {
        return 0;
    }
    return data;
}

function formatDefault(num) {
    if (num == "") {
        num = "0";   
    }
    num = num+"";
    num = num.toString().replace( /,/g, "" );
    var pecah = num.split(".");
    var angka =   pecah[0];
    var pjg   = angka.length;
    var uang  = 0;
    if( pjg == 4 ){
        uang = angka.substr(0,1)+","+angka.substr(1,4);
    }else if( pjg == 5 ){
        uang = angka.substr(0,2)+","+angka.substr(2,5);
    }else if( pjg == 6 ) {
        uang = angka.substr(0,3)+","+angka.substr(3,6); 
    }else if( pjg == 7 ) {
        uang = angka.substr(0,1)+","+angka.substr(1,3)+","+angka.substr(4,3);   
    }else if( pjg == 8 ) {
        uang = angka.substr(0,2)+","+angka.substr(2,3)+","+angka.substr(5,3);   
    }else if( pjg == 9 ) {
        uang = angka.substr(0,3)+","+angka.substr(3,3)+","+angka.substr(6,3);   
    }else if( pjg == 10 ) {
        uang = angka.substr(0,1)+","+angka.substr(1,3)+","+angka.substr(4,3)+","+angka.substr(7,3);   
    }else if( pjg == 11 ) {
        uang = angka.substr(0,2)+","+angka.substr(2,3)+","+angka.substr(5,3)+","+angka.substr(8,3);   
    }else if( pjg == 12 ) {
        uang = angka.substr(0,3)+","+angka.substr(3,3)+","+angka.substr(6,3)+","+angka.substr(9,3);   
    }else if( pjg == 13 ) {
        uang = angka.substr(0,1)+","+angka.substr(1,3)+","+angka.substr(4,3)+","+angka.substr(7,3)+","+angka.substr(10,3);   
    }else{
        uang = angka;
    }
    return uang;
}