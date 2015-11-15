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
                    url: '<?php echo site_url('master_finance/deleteSpecialCoa'); ?>',
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
            url:'<?php echo site_url('master_finance/loadSpecialCoa') ?>',     
            mtype : "post",            
            datatype: "json",            
            colNames:['Kode','Deskripsi', 'Account', 'Breakdown Saldo', 'Edit', 'Setting','Del'],     
            colModel:[
                {name:'specid',index:'specid', width:30, align:"left"},
                {name:'spec_deskripsi',index:'spec_deskripsi', width:100, align:"left"},
                {name:'setcoa_kode',index:'setcoa_kode', width:50, align:"left"},
                {name:'setcoa_is_breakdown',index:'setcoa_is_breakdown', width:50, align:"left"},
                {name:'edit',index:'edit', width:12, align:"center"},
                {name:'setting',index:'setting', width:12, align:"center"},
                {name:'hapus',index:'hapus', width:12, align:"center"},
            ],
            rowNum:10,
            height : 300,
            width: $(".page-content").width(),
            height: 300,
            rowList:[10,20,30],
            pager: '#pager',
            sortname: 'specid',
            viewrecords: true,
            rownumbers: true,
            gridview: true,
            caption:"Special Chart Of Account (COA)"
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
            <a href="#master_finance/addSpecialCoa" class="btn btn-sm btn-primary">
                <i class="ace-icon fa fa-plus"></i>
                Tambah Special COA</a>
        </p>
        <table id="grid-table"></table>
        <div id="pager"></div>
    </div>
</div>


