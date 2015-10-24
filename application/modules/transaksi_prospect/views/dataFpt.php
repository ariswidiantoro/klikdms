<div id="result"></div>
<?php
echo $this->session->flashdata('msg');
?>
<form>
    <div class="row">
        <div class="col-xs-12">
            <div id="header" class="info">
                <select class="form-control input-large" name="status" onchange='$("#grid-table").trigger("reloadGrid");' id="status" >
                    <option value="0">Semua</option>
                    <option value="1" selected>Menunggu Persetujuan</option>
                    <option value="2">Disetujui</option>
                    <option value="4">Ditolak</option>
                    <option value="3">Spk</option>
                </select>
            </div>
            <table id="grid-table"></table>
            <div id="pager"></div>
            <ul class="list-unstyled spaced">
                <li>
                    <i class="ace-icon glyphicon glyphicon-check bigger-110"></i>
                    Validasi Pengajuan FPT
                </li>

                <li>
                    <i class="ace-icon glyphicon glyphicon-remove bigger-110"></i>
                    Tolak Pengajuan FPT
                </li>

                <li>
                    <i class="ace-icon glyphicon glyphicon-list bigger-110"></i>
                    Melihat detail FPT
                </li>
            </ul>
        </div>
    </div>
</form>
<script type="text/javascript">
    var scripts = [null, null]
    $('.page-content-area').ace_ajax('loadScripts', scripts, function() {
        //inline scripts related to this page
    });  
    
    function validasiData(id, kode) {
        bootbox.confirm("Yakin validasi data "+kode+" ?", function(result) {
            if(result) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo site_url('transaksi_prospect/saveValidasiFPT'); ?>',
                    dataType: "json",
                    data: {
                        id: id
                    },
                    success: function(data) {
                        $("#result").html(data.msg).show().fadeIn("slow");
                        $("#grid-table").trigger("reloadGrid");
                    }
                });
            }
        });
    }
    
    function print(fptid)
    {
        var params  = 'width='+screen.width;
        params += ', height='+screen.height;
        params += ', fullscreen=yes,scrollbars=yes';
        window.open("<?php echo site_url("transaksi_prospect/printFpt"); ?>/"+fptid,'_blank', params);
    }
    
    function tolakData(id, kode) {
        bootbox.confirm("Anda tidak menyetujui data "+kode+" ?", function(result) {
            if(result) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo site_url('transaksi_prospect/saveTolakFPT'); ?>',
                    dataType: "json",
                    data: {
                        id: id
                    },
                    success: function(data) {
                        $("#result").html(data.msg).show().fadeIn("slow");
                        $("#grid-table").trigger("reloadGrid");
                    }
                });
            }
        });
    }

    $(document).ready(function (){
        //    alert($("#status").val());
        jQuery("#grid-table").jqGrid({
            url:'<?php echo site_url('transaksi_prospect/loadDataFpt') ?>',     
            mtype : "post",             
            datatype: "json",
            postData: {
                status: function() { return $("#status").val(); }
            },
            colNames:['Kode Fpt','Nama','Alamat','Status','Salesman', 'Tgl FPT','Validasi','Edit','Print', 'Detail'],       
            colModel:[
                {name:'fpt_kode',index:'fpt_kode', width:30, align:"left"},
                {name:'pros_nama',index:'pros_nama', width:60, align:"left"},
                {name:'pros_alamat',index:'pros_alamat', width:80, align:"left"},
                {name:'fpt_approve',index:'fpt_approve', width:25, align:"left"},
                {name:'pros_sales',index:'pros_sales', width:60, align:"left"},
                {name:'fpt_tgl',index:'fpt_tgl', width:25, align:"left"},
                {name:'validasi',index:'validasi', width:25, align:"center"},
                {name:'edit',index:'edit', width:14, align:"center"},
                {name:'print',index:'print', width:14, align:"center"},
                {name:'detail',index:'detail', width:14, align:"center"},
            ],
            rowNum:10,
            height : 300,
            width: $(".page-content").width(),
            rowList:[10,20,30],
            pager: '#pager',
            sortname: 'fptid',
            filters: '1',
            viewrecords: true,
            rownumbers: true,
            gridview: true,
            caption:"Daftar FPT"
        }).navGrid('#pager',{edit:false,add:false,del:false});
        $("#pager").append("<input type='button' value='Click Me' style='height:20px;font-size:-3'/>");
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

