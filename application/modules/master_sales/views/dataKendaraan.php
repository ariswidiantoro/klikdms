<div id="result"></div>
<div class="row">
    <div class="col-xs-12">
        <p>
            <a href="#master_service/addKendaraan" class="btn btn-sm btn-primary">
                <i class="ace-icon fa fa-plus"></i>
                Tambah Kendaraan</a>
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
    
    function hapusKendaraan(id) {
        if (confirm("Yakin ingin menghapus pelanggan ini ?")) {
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('master_service/hapusKendaraan'); ?>',
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
            url:'<?php echo site_url('master_service/loadKendaraan') ?>',      //another controller function for generating data
            mtype : "post",             //Ajax request type. It also could be GET
            datatype: "json",            //supported formats XML, JSON or Arrray
            colNames:['Nama Pemilik','No Polisi','No Rangka', 'No Mesin','Tahun', 'Edit', 'Hapus'],       //Grid column headings
            colModel:[
                {name:'pel_nama',index:'pel_nama', width:100, align:"left"},
                {name:'msc_nopol',index:'msc_nopol', width:50, align:"left"},
                {name:'msc_norangka',index:'msc_norangka', width:70, align:"left"},
                {name:'msc_nomesin',index:'msc_nomesin', width:70, align:"left"},
                {name:'msc_tahun',index:'msc_tahun', width:50, align:"left"},
                {name:'edit',index:'edit', width:20, align:"center"},
                {name:'hapus',index:'hapus', width:20, align:"center"},
            ],
            rowNum:10,
            height : 300,
            width: $(".page-content").width(),
            //height: 300,
            rowList:[10,20,30],
            pager: '#pager',
            sortname: 'msc_nopol',
            viewrecords: true,
            rownumbers: true,
            gridview: true,
            caption:"Daftar Flate Rate"
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

