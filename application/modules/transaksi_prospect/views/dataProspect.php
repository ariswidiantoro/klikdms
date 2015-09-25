<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?> 
<div id="result"></div>
<div class="row">
    <div class="col-xs-12">
        <p>
            <a href="#transaksi_prospect/addProspect" class="btn btn-sm btn-primary">
                <i class="ace-icon fa fa-plus"></i>
                Tambah Prospect</a>
        </p>
        <table id="grid-table"></table>
        <div id="pager"></div>
    </div>
</div>
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
                    url: '<?php echo site_url('transaksi_prospect/deleteProspect'); ?>',
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
            url:'<?php echo site_url('transaksi_prospect/loadProspect') ?>',     
            mtype : "post",             
            datatype: "json",           
            colNames:['Aksi','Kode','Tgl', 'Nama','Alamat','HP','Telpon','Unit', 'Qty'],       
            colModel:[
                {name:'aksi',index:'detail', width:40, align:"center"},
                {name:'prosid',index:'prosid', width:40, align:"left"},
                {name:'pros_createon',index:'pros_createon', width:30, align:"left"},
                {name:'pros_nama',index:'pel_nama', width:80, align:"left"},
                {name:'pros_alamat',index:'pel_alamat', width:100, align:"left"},
                {name:'pros_hp',index:'pel_hp', width:30, align:"left"},
                {name:'pros_telpon',index:'pel_telpon', width:30, align:"left"},
                {name:'pros_unit_type',index:'pros_unit_type', width:130, align:"left"},
                {name:'pros_qty',index:'pros_qty', width:20, align:"left"},
            ],
            rowNum:10,
            height : 300,
            width: $(".page-content").width(),
            rowList:[10,20,30],
            pager: '#pager',
            sortname: 'prosid',
            viewrecords: true,
            rownumbers: true,
            gridview: true,
            caption:"Daftar Prospect"
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
										
