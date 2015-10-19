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
        <ul class="list-unstyled spaced">
            <li>
                <img src="<?php echo path_img() ?>prospek.png" width=20;height=20;>
                Prospek
            </li>
            <li>
                <img src="<?php echo path_img() ?>warm.png" width=20;height=20;>
                Warm
            </li>
            <li>
                <img src="<?php echo path_img() ?>hot.png" width=20;height=20;>
                Hot
            </li>
            <li>
                <img src="<?php echo path_img() ?>hot_deal.png" width=20;height=20;>
                Hot Deal
            </li>
<!--            <li>
                <i class="ace-icon glyphicon glyphicon-plus bigger-110"></i>
                Menambahkan Form Persetujuan Transaksi (FPT)
            </li>-->

<!--            <li>
                <i class="ace-icon glyphicon glyphicon-pencil bigger-110"></i>
                Mengubah data prospect
            </li>-->

<!--            <li>
                <i class="ace-icon glyphicon glyphicon-list bigger-110"></i>
                Melihat detail data prospect 
            </li>-->
        </ul>
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
            colNames:['Kode Prospek','Nama Prospek','Salesman','Status','Agenda','Fpt','Edit', 'Detail'],       
            colModel:[
                {name:'pros_kode',index:'pros_kode', width:30, align:"left"},
                {name:'pros_nama',index:'pros_nama', width:60, align:"left"},
                {name:'pros_sales',index:'pros_sales', width:80, align:"left"},
                {name:'status',index:'status', width:15, align:"center"},
                {name:'agenda',index:'agenda', width:20, align:"center"},
                {name:'fpt',index:'fpt', width:20, align:"center"},
                {name:'edit',index:'edit', width:20, align:"center"},
                {name:'detail',index:'detail', width:20, align:"center"},
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
        //        jQuery("#grid-table").jqGrid('setGroupHeaders', {
        //            useColSpanStyle: false, 
        //            groupHeaders:[
        //                {startColumnName: 'prospek', numberOfColumns: 5, titleText: 'Status Fpt'},
        //            ]
        //        });
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

