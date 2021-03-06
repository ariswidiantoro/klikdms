<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
echo $this->session->flashdata('msg');
?> 

<div class="row">
    <div class="col-xs-12">
        <p>
            <a href="#admin/addRole" class="btn btn-sm btn-primary">
                <i class="ace-icon fa fa-plus"></i>
                Tambah Role</a>
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

    $(document).ready(function (){
        
        jQuery("#grid-table").jqGrid({
            url:'<?php echo site_url('admin/loadRole') ?>',      //another controller function for generating data
            mtype : "post",             //Ajax request type. It also could be GET
            datatype: "json",            //supported formats XML, JSON or Arrray
            colNames:['Deskripsi','Edit Menu', 'Edit', 'Hapus'],       //Grid column headings
            colModel:[
                {name:'role_nama',index:'role_nama', width:100, align:"left"},
                {name:'menu',index:'menu', width:10, align:"center"},
                {name:'edit',index:'edit', width:10, align:"center"},
                {name:'hapus',index:'hapus', width:10, align:"center"},
            ],
            rowNum:10,
            height : 250,
            width: $(".page-content").width(),
            //height: 300,
            rowList:[10,20,30],
            pager: '#pager',
            sortname: 'role_nama',
            viewrecords: true,
            rownumbers: true,
            gridview: true,
            caption:"Daftar Role"
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

