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
                    url: '<?php echo site_url('master_sales/deleteStockUnit'); ?>',
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
            url:'<?php echo site_url('master_sales/loadStockUnit') ?>',     
            mtype : "post",            
            datatype: "json",            
            colNames:[ 'View','Edit', 'Del', 'Merk', 'Tipe', 'Warna', 'No. Rangka', 'No. Mesin', 'Kondisi'],     
            colModel:[
                {name:'view',index:'vew', width:14, align:"center"},
                {name:'edit',index:'edit', width:14, align:"center"},
                {name:'hapus',index:'hapus', width:14, align:"center"},
                {name:'merk_deskripsi',index:'merk_deskripsi', width:80, align:"left"},
                {name:'cty_deskripsi',index:'cty_deskripsi', width:120, align:"left"},
                {name:'warna_deskripsi',index:'warna_deskripsi', width:60, align:"left"},
                {name:'msc_norangka',index:'msc_norangka', width:70, align:"left"},
                {name:'msc_nomesin',index:'msc_nomesin', width:70, align:"left"},
                {name:'msc_kondisi',index:'msc_kondisi', width:40, align:"left"},
                
            ],
            rowNum:10,
            height : 300,
            width: $(".page-content").width(),
            rowList:[10,20,30],
            pager: '#pager',
            sortname: 'merkid',
            viewrecords: true,
            rownumbers: true,
            gridview: true,
            caption:"Daftar Stock Unit"
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
            <a href="#master_sales/addStockUnit" class="btn btn-sm btn-primary">
                <i class="ace-icon fa fa-plus"></i>
                Tambah Stock Unit</a>
        </p>
        <table id="grid-table"></table>
        <div id="pager"></div>
    </div>
</div>


