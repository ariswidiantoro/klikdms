<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?> 
<script type="text/javascript">
    var scripts = [null, null]
    $('.page-content-area').ace_ajax('loadScripts', scripts, function() {
        //inline scripts related to this page
    });
    
    function printData(bpkid)
    {
        var params  = 'width='+screen.width;
        params += ', height='+screen.height;
        params += ', fullscreen=yes,scrollbars=yes';
        window.open("<?php echo site_url("transaksi_sales/printBpk"); ?>/"+bpkid,'_blank', params);
    }
    function hapusData(id, kode) {
        bootbox.confirm("Yakin Hapus Data "+kode+" ?", function(result) {
            if(result) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo site_url('transaksi_sales/deleteBpk'); ?>',
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
            url:'<?php echo site_url('transaksi_sales/loadBpk') ?>',     
            mtype : "post",            
            datatype: "json",            
            colNames:['Print', 'No. BPK', 'No. Rangka', 'No. Seri', 'Tgl. Bpk', 'Jns. Penerimaan', 'Tipe Kendaraan'],     
            colModel:[
                {name:'print',index:'print', width:23, align:"center"},
                {name:'bpk_nomer',index:'bpk_nomer', width:80, align:"left"},
                {name:'msc_norangka',index:'msc_norangka', width:80, align:"left"},
                {name:'msc_bodyseri',index:'msc_bodyseri', width:60, align:"left"},
                {name:'bpk_tgl',index:'bpk_tgl', width:50, align:"left"},
                {name:'bpk_jenis',index:'bpk_jenis', width:70, align:"left"},
                {name:'cty_deskripsi',index:'cty_deskripsi', width:80, align:"left"},
                
            ],
            rowNum:10,
            height : 300,
            width: $(".page-content").width(),
            rowList:[10,20,30],
            pager: '#pager',
            sortname: 'bpkid',
            viewrecords: true,
            rownumbers: true,
            gridview: true,
            caption:"Daftar Penerimaan Kendaraan"
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
            <a href="#transaksi_sales/addBpk" class="btn btn-sm btn-primary">
                <i class="ace-icon fa fa-plus"></i>
                Tambah Penerimaan Kendaraan</a>
        </p>
        <table id="grid-table"></table>
        <div id="pager"></div>
    </div>
</div>


