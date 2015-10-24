<?php
echo $this->session->flashdata('msg');
?> 
<script type="text/javascript">
    var scripts = [null, null]
    $('.page-content-area').ace_ajax('loadScripts', scripts, function() {
        //inline scripts related to this page
    });
    function hapus(fpkid) {
        bootbox.confirm("Yakin Hapus Data "+kode+" ?", function(result) {
            if(result) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo site_url('transaksi_sales/deleteFpk'); ?>',
                    dataType: "json",
                    data: {
                        id: fpkid
                    },
                    success: function(data) {
                        $("#result").html(data).show().fadeIn("slow");
                        $("#grid-table").trigger("reloadGrid");
                    }
                });
            }
        });
    }
    
    function print(fptid)
    {
        var params  = 'width=600';
        params += ', height=50';
        params += ', fullscreen=yes,scrollbars=yes';
        window.open("<?php echo site_url("transaksi_sales/printFpk"); ?>/"+fptid,'_blank', params);
    }

    $(document).ready(function (){
        jQuery("#grid-table").jqGrid({
            url:'<?php echo site_url('transaksi_sales/loadFpk') ?>',     
            mtype : "post",            
            datatype: "json",            
            colNames:['No.','Tgl','No Spk','No Kontrak', 'Nama Leasing', 'Edit','Print', 'Hapus'],     
            colModel:[
                {name:'fpk_no',index:'fpk_no', width:25, align:"left"},
                {name:'fpk_tgl',index:'fpk_tgl', width:20, align:"center"},
                {name:'spk_no',index:'spk_no', width:20, align:"left"},
                {name:'spk_nokontrak',index:'spk_nokontrak', width:20, align:"left"},
                {name:'leas_nama',index:'leas_nama', width:70, align:"left"},
                {name:'view',index:'view', width:20, align:"center"},
                {name:'print',index:'print', width:20, align:"center"},
                {name:'hapus',index:'hapus', width:20, align:"center"},
                
            ],
            rowNum:10,
            height : 300,
            width: $(".page-content").width(),
            rowList:[10,20,30],
            pager: '#pager',
            sortname: 'fpkid',
            viewrecords: true,
            rownumbers: true,
            gridview: true,
            caption:"Daftar Po Leasing"
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
<div id="result"></div>
<div class="row">
    <div class="col-xs-12">
        <p>
            <a href="#transaksi_sales/addFakturPenjualan" class="btn btn-sm btn-primary">
                <i class="ace-icon fa fa-plus"></i>
                Tambah Faktur Penjualan</a>
        </p>
        <table id="grid-table"></table>
        <div id="pager"></div>
    </div>
</div>


