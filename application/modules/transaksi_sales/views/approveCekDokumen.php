<?php
echo $this->session->flashdata('msg');
?> 
<script type="text/javascript">
    var scripts = [null, null]
    $('.page-content-area').ace_ajax('loadScripts', scripts, function() {
        //inline scripts related to this page
    });
    function approve(spkid) {
        bootbox.confirm("Yakin anda akan approve spk ini ?", function(result) {
            if(result) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo site_url('transaksi_sales/saveApproveCekDokumen'); ?>',
                    dataType: "json",
                    data: {
                        id: spkid
                    },
                    success: function(data) {
                        if (data.result) {
                            $("#grid-table").trigger("reloadGrid");
                        }
                        $("#result").html(data.msg).show().fadeIn("slow");
                    }
                });
            }
        });
    }
    function batalApprove(spkid) {
        bootbox.confirm("Yakin anda akan batal approve spk ini ?", function(result) {
            if(result) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo site_url('transaksi_sales/saveBatalApproveCekDokumen'); ?>',
                    dataType: "json",
                    data: {
                        id: spkid
                    },
                    success: function(data) {
                        if (data.result) {
                            $("#grid-table").trigger("reloadGrid");
                        }
                        $("#result").html(data.msg).show().fadeIn("slow");
                    }
                });
            }
        });
    }
    

    $(document).ready(function (){
        jQuery("#grid-table").jqGrid({
            url:'<?php echo site_url('transaksi_sales/loadCekDokumen') ?>',     
            mtype : "post",            
            datatype: "json",    
            postData: {
                status: function() { return $("#spk_approve_status").val(); }
            },
            colNames:['No Spk','No Kontrak', 'Status Approve','Tgl Approve','Approve By',  'Edit', 'Approve', 'Batal Approve'],     
            colModel:[
                {name:'spk_no',index:'spk_no', width:20, align:"left"},
                {name:'spk_nokontrak',index:'spk_nokontrak', width:20, align:"left"},
                {name:'',index:'', width:70, align:"left"},
                {name:'spk_approve_tgl',index:'spk_approve_tgl', width:30, align:"left"},
                {name:'by',index:'by', width:20, align:"left"},
                {name:'edit',index:'edit', width:20, align:"center"},
                {name:'approve',index:'approve', width:20, align:"center"},
                {name:'batal',index:'batal', width:20, align:"center"},
                
            ],
            rowNum:10,
            height : 300,
            width: $(".page-content").width(),
            rowList:[10,20,30],
            pager: '#pager',
            sortname: 'spkid',
            viewrecords: true,
            rownumbers: true,
            gridview: true,
            caption:"Daftar Cek Dokumen"
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
        <div id="header" class="info">
            <select class="form-control input-large" name="spk_approve_status" onchange='$("#grid-table").trigger("reloadGrid");' id="spk_approve_status" >
                <option value="">Semua</option>
                <option value="0" selected>Belum Diupprove</option>
                <option value="1">Sudah Diupprove</option>
            </select>
        </div>
        <table id="grid-table"></table>
        <div id="pager"></div>
    </div>
</div>


