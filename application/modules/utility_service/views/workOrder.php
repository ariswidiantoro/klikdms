<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
echo $this->session->flashdata('msg');
?> 

<div id="result"></div>
<div class="row">
    <div class="col-xs-12">
        <table id="grid-table"></table>
        <div id="pager"></div>
    </div>
</div>

<script type="text/javascript">
    
    var scripts = [null, null]
    $('.page-content-area').ace_ajax('loadScripts', scripts, function() {
        //inline scripts related to this page
    });
    function batal(id) {
        if ($("#alasan"+id).val() == "") {
            bootbox.dialog({
                message: "<span class='bigger-110'>Silahkan Masukkan Alasan</span>",
                buttons: 			
                    {
                    "button" :
                        {
                        "label" : "Ok",
                        "className" : "btn-sm info"
                    }
                }
            });
            $("#alasan"+id).focus();
        }else {
            bootbox.confirm("Yakin ingin membatalkan wo ini?", function(result) {
                if(result) {
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo site_url('utility_service/batalWo'); ?>',
                        dataType: "json",
                        data: {
                            id: id,
                            alasan: $("#alasan"+id).val()
                        },
                        success: function(data) {
                            if (data.result) {
                                $("#grid-table").trigger('reloadGrid');
                                var params  = 'width=1000';
                                params += ', height='+screen.height;
                                params += ', fullscreen=yes,scrollbars=yes';
                                window.open("<?php echo site_url("utility_service/printBatalWo"); ?>/"+id,'_blank', params);
                            }
                            $("#result").html(data.msg).show().fadeIn("slow");
                        }
                    });
                }
            });
            return false;
        }
    }
    
    function print(woid)
    {
        var params  = 'width=1000';
        params += ', height='+screen.height;
        params += ', fullscreen=yes,scrollbars=yes';
        document.form.reset();
        clearForm();
        window.open("<?php echo site_url("transaksi_service/printWo"); ?>/"+woid,'_blank', params);
    }

    $(document).ready(function (){
        jQuery("#grid-table").jqGrid({
            url:'<?php echo site_url('utility_service/loadWorkOrder') ?>',      //another controller function for generating data
            mtype : "post",             //Ajax request type. It also could be GET
            datatype: "json",            //supported formats XML, JSON or Arrray
            colNames:['Wo Nomer','Nama Pelanggan','Tanggal','Nopol','No Mesin','Alasan Batal','Batal', 'Print'],       //Grid column headings
            colModel:[
                {name:'wo_nomer',index:'wo_nomer', width:40, align:"left"},
                {name:'pel_nama',index:'pel_nama', width:50, align:"left"},
                {name:'wo_tgl',index:'wo_tgl', width:30, align:"left"},
                {name:'msc_nopol',index:'msc_nopol', width:60, align:"left"},
                {name:'msc_nomesin',index:'msc_nomesin', width:30, align:"left"},
                {name:'alasan',index:'alasan', width:50, align:"right"},
                {name:'batal',index:'batal', width:15, align:"center"},
                {name:'print',index:'print', width:15, align:"center"},
            ],
            rowNum:10,
            height : 300,
            width: $(".page-content").width(),
            //height: 300,
            rowList:[10,20,30],
            pager: '#pager',
            sortname: 'wo_nomer',
            viewrecords: true,
            rownumbers: true,
            gridview: true,
            caption:"Daftar Work Order"
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

