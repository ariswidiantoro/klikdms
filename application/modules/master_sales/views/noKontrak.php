<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?> 
<script type="text/javascript">
    var scripts = [null, null]
    $('.page-content-area').ace_ajax('loadScripts', scripts, function() {
        //inline scripts related to this page
    });
    function hapusKontrak(id) {
        bootbox.confirm("Yakin Hapus Data "+id+" ?", function(result) {
            if(result) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo site_url('master_sales/deleteKontrak'); ?>',
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
            url:'<?php echo site_url('master_sales/loadNoKontrak') ?>',     
            mtype : "post",            
            datatype: "json",            
            colNames:['No Kontrak','Nama Pelanggan','Alamat', 'No Telpon', 'Edit', 'Del'],     
            colModel:[
                {name:'kon_nomer',index:'kon_nomer', width:80, align:"left"},
                {name:'pel_nama',index:'pel_nama', width:100, align:"left"},
                {name:'pel_alamat',index:'pel_alamat', width:100, align:"left"},
                {name:'pel_hp',index:'pel_hp', width:100, align:"left"},
                {name:'edit',index:'edit', width:12, align:"center"},
                {name:'hapus',index:'hapus', width:12, align:"center"},
            ],
            rowNum:10,
            height : 300,
            width: $(".page-content").width(),
            rowList:[10,20,30],
            pager: '#pager',
            sortname: 'kon_nomer',
            viewrecords: true,
            rownumbers: true,
            gridview: true,
            caption:"Daftar Nomer Kontrak"
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
            <a href="#master_sales/addNoKontrak" class="btn btn-sm btn-primary">
                <i class="ace-icon fa fa-plus"></i>
                Tambah No Kontrak</a>
        </p>
        <table id="grid-table"></table>
        <div id="pager"></div>
    </div>
</div>


