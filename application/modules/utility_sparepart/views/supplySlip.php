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
    function batal(id, jenis) {
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
            bootbox.confirm("Yakin ingin membatalkan supply ini?", function(result) {
                if(result) {
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo site_url('utility_sparepart/batalSupply'); ?>',
                        dataType: "json",
                        data: {
                            id: id,
                            jenis: jenis,
                            alasan: $("#alasan"+id).val()
                        },
                        success: function(data) {
                            if (data.result) {
                                $("#grid-table").trigger('reloadGrid');
                                var params  = 'width=1000';
                                params += ', height='+screen.height;
                                params += ', fullscreen=yes,scrollbars=yes';
                                window.open("<?php echo site_url("utility_sparepart/printBatalSupply"); ?>/"+id,'_blank', params);
                            }
                            $("#result").html(data.msg).show().fadeIn("slow");
                        }
                    });
                }
            });
            return false;
        }
    }
    
    function print(sppid,jenis)
    {
        var params  = 'width=1000';
        params += ', height='+screen.height;
        params += ', fullscreen=yes,scrollbars=yes';
        window.open("<?php echo site_url("transaksi_sparepart/printSupplySlip"); ?>/"+sppid+"/"+jenis,'_blank', params);
    }

    $(document).ready(function (){
        jQuery("#grid-table").jqGrid({
            url:'<?php echo site_url('utility_sparepart/loadSupplySlip') ?>',      //another controller function for generating data
            mtype : "post",             //Ajax request type. It also could be GET
            datatype: "json",            //supported formats XML, JSON or Arrray
            colNames:['No Supply','Jenis','Tanggal','Nama Pelanggan','Nomer WO', 'Total','Alasan Batal','Batal', 'Print'],       //Grid column headings
            colModel:[
                {name:'spp_noslip',index:'spp_noslip', width:40, align:"left"},
                {name:'spp_jenis',index:'spp_jenis', width:20, align:"left"},
                {name:'spp_tgl',index:'spp_tgl', width:30, align:"left"},
                {name:'pel_nama',index:'pel_nama', width:60, align:"left"},
                {name:'wo_nomer',index:'wo_nomer', width:30, align:"left"},
                {name:'spp_total',index:'spp_total', width:30, align:"right"},
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
            sortname: 'spp_noslip',
            viewrecords: true,
            rownumbers: true,
            gridview: true,
            caption:"Daftar Supply Slip"
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

