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
    function hapusRak(id) {
        if (confirm("Yakin ingin menghapus baris ini ?")) {
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('master_service/hapusRak'); ?>',
                dataType: "json",
                data: {
                    id: id
                },
                success: function(data) {
                    $("#result").html(data).show().fadeIn("slow");
                }
            });
        }
    }

    function loadGrid()
    {
        jQuery("#grid-table").jqGrid({
            url:'<?php echo site_url('transaksi_service/loadDataWo') ?>',      //another controller function for generating data
            mtype : "post",             //Ajax request type. It also could be GET
            datatype: "json",            //supported formats XML, JSON or Arrray
            colNames:['Nomor WO', 'Nomor Polisi','Pelanggan','Status', 'Mekanik','Aksi'],       //Grid column headings
            colModel:[
                {name:'wo_nomer',index:'wo_nomer', width:20, align:"left"},
                {name:'msc_nopol',index:'msc_nopol', width:20, align:"left"},
                {name:'pel_nama',index:'pel_nama', width:50, align:"left"},
                {name:'status',index:'status', width:50, align:"left"},
                {name:'mekanik',index:'mekanik', width:40, align:"left"},
                {name:'aksi',index:'aksi', width:20, align:"center"},
            ],
            rowNum:10,
            height : 300,
            width: $(".page-content").width(),
            //height: 300,
            rowList:[10,20,30],
            pager: '#pager',
            sortname: 'wo_nomer',
            viewrecords: true,
            rownumbers: true,
            gridview: true,
            caption:"Daftar WO"
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
    }

    $(document).ready(function (){
        loadGrid();
    });
    

</script> 

