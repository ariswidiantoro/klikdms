<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?> 
<script type="text/javascript">
    var scripts = [null, null]
    $('.page-content-area').ace_ajax('loadScripts', scripts, function() {
        //inline scripts related to this page
    });
    function hapusData(id, kode) {
        bootbox.confirm("Yakin Hapus Data "+kode+" ?", function(result) {
            if(result) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo site_url('transaksi_sales/deleteSpk'); ?>',
                    dataType: "json",
                    data: {
                        id: id
                    },
                    success: function(data) {
                       $("#result").html(data).show().fadeIn("slow");
                       $("#grid-table").trigger("reloadGrid");
                    }
                });
            }
        });
    }

    $(document).ready(function (){
        jQuery("#grid-table").jqGrid({
            url:'<?php echo site_url('transaksi_sales/loadSpk') ?>',     
            mtype : "post",            
            datatype: "json",            
            colNames:['No. SPK','Tgl Spk','No Kontrak', 'No. Fpt', 'Nama Customer', 'View','Print', 'Hapus'],     
            colModel:[
                {name:'spk_no',index:'spk_no', width:20, align:"left"},
                {name:'spk_tgl',index:'spk_tgl', width:20, align:"center"},
                {name:'spk_nokontrak',index:'spk_nokontrak', width:20, align:"left"},
                {name:'fpt_kode',index:'fpt_kode', width:20, align:"left"},
                {name:'pel_nama',index:'pel_nama', width:80, align:"left"},
                {name:'view',index:'view', width:20, align:"center"},
                {name:'print',index:'print', width:20, align:"center"},
                {name:'hapus',index:'hapus', width:20, align:"center"},
                
            ],
            rowNum:10,
            height : 300,
            width: $(".page-content").width(),
            rowList:[10,20,30],
            pager: '#pager',
            sortname: 'spkid',
            viewrecords: true,
            rownumbers: true,
            gridview: true,
            caption:"Daftar Pesanan Kendaraan"
        }).navGrid('#pager',{edit:false,add:false,del:false});
        $(window).on('resize.jqGrid', function () {
            $("#grid-table").jqGrid( 'setGridWidth', $(".page-content").width() );
        })
        
        var parent_column = $("#grid-table").closest('[class*="col-"]');
        $(document).on('settings.ace.jqGrid' , function(ev, event_name, collapsed) {
            if( event_name === 'sidebar_collapsed' || event_name === 'main_container_fixed' ) {
                //setTimeout is for webkit only to give time for DOM changes and then redraw!!!
                setTimeout(function() {
                    $("#grid-table").jqGrid( 'setGridWidth', parent_column.width() );
                }, 0);
            }
        })
    });
</script> 
<div id="result"></div>
<div class="row">
    <div class="col-xs-12">
        <p>
            <a href="#transaksi_sales/addSpk" class="btn btn-sm btn-primary">
                <i class="ace-icon fa fa-plus"></i>
                Tambah Pesanan Kendaraan</a>
        </p>
        <table id="grid-table"></table>
        <div id="pager"></div>
    </div>
</div>


