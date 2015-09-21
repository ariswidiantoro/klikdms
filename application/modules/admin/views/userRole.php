<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
echo $this->session->flashdata('msg');
?> 

<div id="result"></div>
<div class="row">
    <div class="col-xs-12">
        <p>
            <a href="#admin/addKaryawan" class="btn btn-sm btn-primary">
                <i class="ace-icon fa fa-plus"></i>
                Tambah Karyawan</a>
        </p>
        <table id="grid-table"></table>
        <div id="pager"></div>
    </div>
</div>


</div>


<script type="text/javascript">

    function resetPassword(id) {
        if (confirm("Yakin ingin mereset user ini ?")) {
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('admin/resetPassword'); ?>',
                dataType: "json",
                data: {
                    id: id
                },
                success: function(data) {
                    getData();
                    $("#result").html(data).show().fadeIn("slow");
                }
            });
        }
    }

    $(document).ready(function (){
        getData();
        function getData()
        {
            jQuery("#grid-table").jqGrid({
                url:'<?php echo site_url('admin/loadUserRole') ?>',      //another controller function for generating data
                mtype : "post",             //Ajax request type. It also could be GET
                datatype: "json",            //supported formats XML, JSON or Arrray
                colNames:['NIK','Nama', 'Username','Role','Group Cabang', 'Reset Pswd'],       //Grid column headings
                colModel:[
                    {name:'kr_nik',index:'kr_nik', width:50, align:"left"},
                    {name:'kr_nama',index:'kr_nama', width:90, align:"left"},
                    {name:'kr_username',index:'kr_username', width:70, align:"left"},
                    {name:'role',index:'role', width:20, align:"center"},
                    {name:'group',index:'group', width:30, align:"center"},
                    {name:'password',index:'password', width:20, align:"center"},
                ],
                rowNum:10,
                height : 300,
                width: $(".page-content").width(),
                //height: 300,
                rowList:[10,20,30],
                pager: '#pager',
                sortname: 'kr_nama',
                viewrecords: true,
                rownumbers: true,
                gridview: true,
                caption:"Daftar Karyawan"
            }).navGrid('#pager',{edit:false,add:false,del:false});
        }
    
      
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
    
    
    var scripts = [null, null]
    $('.page-content-area').ace_ajax('loadScripts', scripts, function() {
        //inline scripts related to this page
    });
</script> 

