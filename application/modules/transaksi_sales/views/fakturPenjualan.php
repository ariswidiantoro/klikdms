
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
            url:'<?php echo site_url('transaksi_sales/loadFaktur') ?>',     
            mtype : "post",            
            datatype: "json",            
            colNames:['No.','Tgl','Nama Pelanggan','Type Kendaraan', 'Total Harga','Print'],     
            colModel:[
                {name:'fkp_nofaktur',index:'fkp_nofaktur', width:25, align:"left"},
                {name:'fkp_tgl',index:'fkp_tgl', width:20, align:"center"},
                {name:'pel_nama',index:'pel_nama', width:60, align:"left"},
                {name:'cty_deskripsi',index:'cty_deskripsi', width:70, align:"left"},
                {name:'byr_total',index:'byr_total', width:20, align:"right"},
                {name:'print',index:'print', width:10, align:"center"},
                
            ],
            rowNum:10,
            height : 300,
            width: $(".page-content").width(),
            rowList:[10,20,30],
            pager: '#pager',
            sortname: 'fkpid',
            viewrecords: true,
            rownumbers: true,
            gridview: true,
            caption:"Daftar Faktur Penjualan"
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


