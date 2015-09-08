<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
echo $this->session->flashdata('msg');
?> 

<div id="result"></div>
<div class="row">
    <div class="col-xs-12">
        <p>
            <a href="#master_sparepart/addInventory" class="btn btn-sm btn-primary">
                <i class="ace-icon fa fa-plus"></i>
                Tambah Inventory</a>
        </p>
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
    function hapusJabatan(id) {
        if (confirm("Yakin ingin menghapus baris ini ?")) {
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('master_service/hapusSparepart'); ?>',
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

    $(document).ready(function (){
        jQuery("#grid-table").jqGrid({
            url:'<?php echo site_url('master_sparepart/loadInventory') ?>',      //another controller function for generating data
            mtype : "post",             //Ajax request type. It also could be GET
            datatype: "json",            //supported formats XML, JSON or Arrray
            colNames:['Kode Barang','Barcode', 'Nama Barang','Jenis', 'Harga Beli Terakhir', 'Hpp', 'Harga Jual', 'Stock','Edit'],       //Grid column headings
            colModel:[
                {name:'inve_kode',index:'inve_kode', width:50, align:"left"},
                {name:'inve_barcode',index:'inve_barcode', width:50, align:"left"},
                {name:'inve_nama',index:'inve_nama', width:50, align:"left"},
                {name:'inve_jenis',index:'inve_jenis', width:50, align:"left"},
                {name:'inve_harga_beli',index:'inve_harga_beli', width:50, align:"right"},
                {name:'inve_hpp',index:'inve_hpp', width:50, align:"right"},
                {name:'inve_harga',index:'inve_harga', width:50, align:"right"},
                {name:'inve_qty',index:'inve_qty', width:50, align:"right"},
                {name:'edit',index:'edit', width:20, align:"center"},
            ],
            rowNum:10,
            height : 300,
            width: $(".page-content").width(),
            //height: 300,
            rowList:[10,20,30],
            pager: '#pager',
            sortname: 'inve_kode',
            viewrecords: true,
            rownumbers: true,
            gridview: true,
            caption:"Daftar Inventory"
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

