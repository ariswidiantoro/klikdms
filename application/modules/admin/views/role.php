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
    function search() {
        $('#tt').treegrid('reload', {menu_nama:$("#nama").val()}); 
    }
    function addMenu()
    {
        document.formMenu.reset();
        $('#Action').val('add');
        $("#AccSubFrom").removeAttr('disabled');
        $('#myModal').modal('show');
    }

    function deleteMenu(id) {
        if (confirm("Yakin ingin menghapus baris ini ?")) {
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('administrator/hapus_menu'); ?>',
                dataType: "json",
                data: {
                    menuid: id
                },
                success: function(data) {
                    if (data) {
                        window.location.href = '<?php echo site_url('administrator/menu') ?>';
                    } else {
                        alert("gagal menghapus");
                    }
                }
            });
        }
    }

    function editMenu(id)
    {
        document.formMenu.reset();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url() ?>administrator/get_menu_by_id",
            dataType: "json",
            async: false,
            data: {
                menuid: id
            },
            success: function(data) {
                if (data) {
                    $('#Action').val('update');
                    $("#menuid").val(id);
                    $("#menu_nama").val(data['menu_nama']);
                    $("#menu_type").val(data['menu_type']);
                    $("#menu_url").val(data['menu_url']);
                    $("#menu_deskripsi").val(data['menu_deskripsi']);
                    $("#menu_icon").val(data['menu_icon']);
                    $('#menu_parentid').val(data['menu_parentid']);
                    if (data['menu_isactive'] == '1') {
                        $("#menu_isactive").attr('checked', true);
                    } else {
                        $('#menu_isactive').attr('checked', false);
                    }
                    $('#myModal').modal('show');
                }
            }
        });
    }

    
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
            height : 300,
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
    
    
    var scripts = [null, null]
    $('.page-content-area').ace_ajax('loadScripts', scripts, function() {
        //inline scripts related to this page
    });
</script> 

