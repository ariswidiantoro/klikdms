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
                    url: '<?php echo site_url('master_finance/deleteTipeJurnal'); ?>',
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
            url:'<?php echo site_url('master_finance/loadTipeJurnal') ?>',     
            mtype : "post",            
            datatype: "json",            
            colNames:['Kode', 'Postcode', 'Tipe Jurnal', 'View Jurnal', 'Set Jurnal', 'Edit'],     
            colModel:[
                {name:'tipeid',index:'tipeid', width:30, align:"left"},
                {name:'tipe_postcode',index:'tipe_postcode', width:30, align:"left"},
                {name:'tipe_deskripsi',index:'tipe_deskripsi', width:50, align:"left"},
                {name:'view',index:'view', width:12, align:"center"},
                {name:'setting',index:'setting', width:12, align:"center"},
                {name:'edit',index:'edit', width:12, align:"center"},
            ],
            rowNum:10,
            height : 300,
            width: $(".page-content").width(),
            rowList:[10,20,30],
            pager: '#pager',
            sortname: 'tipeid',
            viewrecords: true,
            rownumbers: true,
            gridview: true,
            caption:"Daftar Tipe Jurnal"
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
            <a href="#master_finance/addTipeJurnal" class="btn btn-sm btn-primary">
                <i class="ace-icon fa fa-plus"></i>
                Tambah Tipe Jurnal</a>
        </p>
        <table id="grid-table"></table>
        <div id="pager"></div>
    </div>
</div>


