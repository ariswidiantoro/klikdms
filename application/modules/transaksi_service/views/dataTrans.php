<div id="result"></div>
<form>
    <div class="row">
        <div class="col-xs-12">
            <div class="well well-sm" style="margin-bottom: 5px; ">
                <div class="row">
                    <div class="col-xs-6 input-medium">
                        <div>
                            <select name="status" class="input-sm input-medium" id="status" >
                                <?php echo $etc['kategori']; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-6 input-medium">
                        <div>
                            <div class="input-group" style="position: static">
                                <input id="from" readonly type="text" value="<?php echo date('01-01-Y') ?>" name="end" class="input-sm input-small" />
                                <span class="input-group-addon">
                                    <i class="ace-icon fa fa-calendar"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 input-medium">
                        <div>
                            <div class="input-group" style="position: static">
                                <input id="to" readonly type="text" value="<?php echo date('d-m-Y') ?>" name="end" class="input-sm input-small" />
                                <span class="input-group-addon">
                                    <i class="ace-icon fa fa-calendar"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-2">
                        <div>
                            <input id="key" class="input-sm" type="text" name="key"  value=""/>
                            <input id="trans" type="hidden" name="trans"  value="<?php echo $etc['trans']; ?>"/>
                            <input id="subtrans" type="hidden" name="subtrans"  value="<?php echo $etc['subtrans']; ?>"/>
                            <input id="type" type="hidden" name="type"  value="<?php echo $etc['type']; ?>"/>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-2">
                        <div>
                            <button onclick="return loadData();" class="btn btn-xs btn-info btn-bol" type="button"><i class="ace-icon fa fa-search"></i>FILTER</button>
                            <button onclick="return addData();" class="btn btn-xs btn-info btn-bol" type="button"><i class="ace-icon fa fa-plus"></i>TAMBAH</button>
                        </div>
                    </div>
                </div>
            </div>
            <table id="grid-table"></table>
            <div id="pager"></div>
            <ul class="list-unstyled spaced">
                <li>
                    <i class="ace-icon glyphicon glyphicon-pencil bigger-110"></i>
                    Edit Transaksi
                </li>
                <li>
                    <i class="ace-icon glyphicon glyphicon-trash bigger-110"></i>
                    Batal Transaksi
                </li>
                <li>
                    <i class="ace-icon glyphicon glyphicon-print bigger-110"></i>
                    Cetak Transaksi
                </li>
                <li>
                    <i class="ace-icon glyphicon glyphicon-list bigger-110"></i>
                    Melihat Detail Transaksi
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
    
    function batalData(id, kode) {
        bootbox.confirm("Yakin batalkan transaksi "+kode+" ?", function(result) {
            if(result) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo site_url($etc['targetCancel']); ?>',
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
    
    function loadData(){
        $("#grid-table").trigger("reloadGrid");
    }
    
    function addData(){
          window.location.href = "#<?php echo $etc['targetNewTrans']; ?>";
    }
    
    function cetakData(id){
        var params  = 'width='+screen.width;
        params += ', height='+screen.height;
        params += ', fullscreen=yes,scrollbars=yes';
        window.open("<?php echo site_url($etc['targetPrint']); ?>/"+id,'_blank', params);
    }
    
    $(document).ready(function (){
         $(function() {
            var dates = $( "#from, #to" ).datepicker({	
                changeMonth: true,
                showAnim: '',
                dateFormat: "dd-mm-yy",
                numberOfMonths: 1,
                onSelect: function( selectedDate ) {
                    var option = this.id == "from" ? "minDate" : "maxDate",
                    instance = $( this ).data( "datepicker" ),
                    date = $.datepicker.parseDate(
                    instance.settings.dateFormat ||
                        $.datepicker._defaults.dateFormat,
                    selectedDate, instance.settings );
                    dates.not( this ).datepicker( "option", option, date );
                    dates.not( this ).datepicker( "option", "datFormat", "dd-mm-yy" );
                }
            });
        });
        
        jQuery("#grid-table").jqGrid({
            url:'<?php echo site_url($etc['targetLoad']) ?>',     
            mtype : "post",             
            datatype: "json",
            postData: {
                kategori: function() { return $("#kategori").val(); },
                dateFrom: function() { return $("#from").val(); },
                dateTo: function() { return $("#to").val(); },
                trans: function() { return $("#trans").val(); },
                type: function() { return $("#type").val(); },
                subtrans: function() { return $("#subtrans").val(); },
                key: function() { return $("#key").val(); }
            },
            colNames:[<?php echo $etc['colNames']; ?>],       
            colModel:[<?php echo $etc['colModel']; ?>],
            rowNum:10,
            height : 300,
            width: $(".page-content").width(),
            rowList:[10,20,30],
            pager: '#pager',
            sortname: 'kstid',
            filters: '1',
            viewrecords: true,
            rownumbers: true,
            gridview: true,
            caption:"<?php echo $etc['judul'];?>"
        }).navGrid('#pager',{edit:false,add:false,del:false,search:false, refresh:false});
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

