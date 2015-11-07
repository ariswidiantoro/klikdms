<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
echo $this->session->flashdata('msg');
?> 

<div id="result"></div>
<div class="row">
    <div class="col-xs-12">
        <p>
            <a href="#<?php echo $add; ?>" class="btn btn-sm btn-primary">
                <i class="ace-icon fa fa-plus"></i>
                Tambah Pelanggan</a>
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
    
    function hapusPelanggan(id) {
        if (confirm("Yakin ingin menghapus pelanggan ini ?")) {
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('master_service/hapusPelanggan'); ?>',
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
            url:'<?php echo site_url('master_service/loadPelanggan') ?>',      //another controller function for generating data
            mtype : "post",             //Ajax request type. It also could be GET
            datatype: "json",            //supported formats XML, JSON or Arrray
            colNames:['Kode','Nama','Alamat', 'HP', 'Telpon', 'NPWP', 'Email', 'Edit', 'Hapus'],       //Grid column headings
            colModel:[
                {name:'pelid',index:'pelid', width:40, align:"left"},
                {name:'pel_nama',index:'pel_nama', width:80, align:"left"},
                {name:'pel_alamat',index:'pel_alamat', width:100, align:"left"},
                {name:'pel_hp',index:'pel_hp', width:40, align:"left"},
                {name:'pel_telpon',index:'pel_telpon', width:40, align:"left"},
                {name:'pel_npwp',index:'pel_npwp', width:40, align:"left"},
                {name:'pel_email',index:'pel_email', width:40, align:"left"},
                {name:'edit',index:'edit', width:20, align:"center"},
                {name:'hapus',index:'hapus', width:20, align:"center"},
            ],
            rowNum:10,
            height : 300,
            width: $(".page-content").width(),
            //height: 300,
            rowList:[10,20,30],
            pager: '#pager',
            sortname: 'pel_nama',
            viewrecords: true,
            rownumbers: true,
            gridview: true,
            caption:"Daftar Pelanggan"
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

