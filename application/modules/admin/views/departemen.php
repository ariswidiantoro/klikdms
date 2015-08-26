<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
echo $this->session->flashdata('msg');
?> 

<div id="result"></div>
<div class="row">
    <div class="col-xs-12">
<!--        <p>
            <a href="#admin/addDepartemen" class="btn btn-sm btn-primary">
                <i class="ace-icon fa fa-plus"></i>
                Tambah Departemen</a>
        </p>-->
        <table id="grid-table"></table>
        <div id="pager"></div>
    </div>
</div>


</div>


<script type="text/javascript">

    function hapusDepartemen(id) {
        if (confirm("Yakin ingin menghapus baris ini ?")) {
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('admin/hapusCabang'); ?>',
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
                url:'<?php echo site_url('admin/loadDepartemen') ?>',      //another controller function for generating data
                mtype : "post",             //Ajax request type. It also could be GET
                datatype: "json",            //supported formats XML, JSON or Arrray
                colNames:['Kode Departemen','Nama Departemen','Edit', 'Hapus'],       //Grid column headings
                colModel:[
                    {name:'deptid',index:'deptid', width:40, align:"left"},
                    {name:'dept_deskripsi',index:'dept_deskripsi', width:100, align:"left"},
                    {name:'edit',index:'edit', width:30, align:"center"},
                    {name:'hapus',index:'hapus', width:30, align:"center"},
                ],
                rowNum:10,
                height : 300,
                width: $(".page-content").width(),
                //height: 300,
                rowList:[10,20,30],
                pager: '#pager',
                sortname: 'deptid',
                viewrecords: true,
                rownumbers: true,
                gridview: true,
                caption:"Daftar Departemen"
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

