<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?> 
<div id="result"></div>
<div class="row">
    <div class="col-xs-12">
        <table id="grid-table"></table>
        <div id="pager"></div>
        <ul class="list-unstyled spaced">
            <li>
                <i class="ace-icon glyphicon glyphicon-check bigger-110"></i>
                Validasi Pengajuan FPT
            </li>

            <li>
                <i class="ace-icon glyphicon glyphicon-remove bigger-110"></i>
                Tolak Pengajuan FPT
            </li>

            <li>
                <i class="ace-icon glyphicon glyphicon-list bigger-110"></i>
                Melihat detail FPT
            </li>
        </ul>
    </div>
</div>
<script type="text/javascript">
    var scripts = [null, null]
    $('.page-content-area').ace_ajax('loadScripts', scripts, function() {
        //inline scripts related to this page
    });  
    
    function validasiData(id, kode) {
        bootbox.confirm("Yakin validasi data "+kode+" ?", function(result) {
            if(result) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo site_url('transaksi_prospect/saveValidasiFPT'); ?>',
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
    
    function tolakData(id, kode) {
        bootbox.confirm("Anda tidak menyetujui data "+kode+" ?", function(result) {
            if(result) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo site_url('transaksi_prospect/saveTolakFPT'); ?>',
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
            colNames:['','', '' ,'Nama','Alamat','HP','Salesman','Unit', 'Qty'],       
            colModel:[
                {name:'fpt',index:'fpt', width:14, align:"center"},
                {name:'edit',index:'edit', width:14, align:"center"},
                {name:'detail',index:'detail', width:14, align:"center"},
                {name:'pros_nama',index:'pros_nama', width:80, align:"left"},
                {name:'pros_alamat',index:'pros_alamat', width:100, align:"left"},
                {name:'pros_hp',index:'pel_hp', width:30, align:"left"},
                {name:'pros_sales',index:'pros_sales', width:80, align:"left"},
                {name:'cty_deskripsi',index:'cty_deskripsi', width:130, align:"left"},
                {name:'car_qty',index:'car_qty', width:20, align:"left"},
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
            caption:"Daftar FPT"
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

