<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
echo $this->session->flashdata('msg');
?> 

<div id="result"></div>
<div class="row">
    <div class="col-xs-12">
        <table id="grid-table"></table>
        <div id="pager"></div>
    </div>
</div>


</div>


<script type="text/javascript">
    
    var scripts = [null, null]
    $('.page-content-area').ace_ajax('loadScripts', scripts, function() {
        //inline scripts related to this page
    });
    function print(sppid)
    {
        var params  = 'width=1000';
        params += ', height='+screen.height;
        params += ', fullscreen=yes,scrollbars=yes';
        window.open("<?php echo site_url("transaksi_sparepart/printTerimaBarang"); ?>/"+sppid,'_blank', params);
    }

    $(document).ready(function (){
        jQuery("#grid-table").jqGrid({
            url:'<?php echo site_url('utility_sparepart/loadTerimaBarang') ?>',      //another controller function for generating data
            mtype : "post",             //Ajax request type. It also could be GET
            datatype: "json",            //supported formats XML, JSON or Arrray
            colNames:['No Faktur','Tanggal','Supplier', 'Total', 'Print'],       //Grid column headings
            colModel:[
                {name:'trbr_faktur',index:'trbr_faktur', width:40, align:"left"},
                {name:'trbr_tgl',index:'trbr_tgl', width:30, align:"left"},
                {name:'sup_nama',index:'sup_nama', width:60, align:"left"},
                {name:'trbr_total',index:'trbr_total', width:60, align:"left"},
                {name:'print',index:'print', width:15, align:"center"},
            ],
            rowNum:10,
            height : 300,
            width: $(".page-content").width(),
            //height: 300,
            rowList:[10,20,30],
            pager: '#pager',
            sortname: 'trbr_faktur',
            viewrecords: true,
            rownumbers: true,
            gridview: true,
            caption:"Daftar Penerimaan Barang"
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

