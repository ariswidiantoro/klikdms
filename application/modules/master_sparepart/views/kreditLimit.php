<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
echo $this->session->flashdata('msg');
?> 

<div id="result"></div>
<div class="row">
    <div class="col-xs-12">
        <p>
            <a href="#master_sparepart/addKreditLimit" class="btn btn-sm btn-primary">
                <i class="ace-icon fa fa-plus"></i>
                Tambah Kredit Limit</a>
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
    function hapusGrade(id) {
        if (confirm("Yakin ingin menghapus baris ini ?")) {
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('master_sparepart/hapusGrade'); ?>',
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
            url:'<?php echo site_url('master_sparepart/loadKreditLimit') ?>',      //another controller function for generating data
            mtype : "post",             //Ajax request type. It also could be GET
            datatype: "json",            //supported formats XML, JSON or Arrray
            colNames:['Nama Pelanggan','Alamat', 'Top', 'Kredit Limit', 'Diskon Limit','Edit','Hapus'],       //Grid column headings
            colModel:[
                {name:'pel_nama',index:'pel_nama', width:40, align:"left"},
                {name:'pel_alamat',index:'pel_alamat', width:70, align:"left"},
                {name:'limit_top',index:'limit_top', width:15, align:"right"},
                {name:'limit_total',index:'limit_total', width:30, align:"right"},
                {name:'limit_diskon',index:'limit_diskon', width:25, align:"right"},
                {name:'edit',index:'edit', width:15, align:"center"},
                {name:'hapus',index:'hapus', width:15, align:"center"},
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
            caption:"Daftar GradeToko"
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

