<style type="text/css">
    html .ui-autocomplete { 
        /* without this, the menu expands to 100% in IE6 */
        max-height: 200px;
        padding-right: 20px;
        overflow-y: auto;
        width:300px; 
    }      
</style>
<div class="page-header">
    <h1>
        <?php echo $etc['judul']; ?>
    </h1>
</div>
<form class="form-horizontal" id="form" method="post" action="" name="form">
    <div class="well well-sm" style="margin-bottom: 5px; ">
        <div class="row">
            <div class="col-xs-6 input-medium">
                <div>
                    <select name="cbid" class="input-sm input-medium" id="cbid" >
                        <option value ="">PILIH</option>
                        <?php
                        foreach ($etc['groupCabang'] as $cabang) {
                            echo "<option value='" . $cabang['group_cbid'] . "'";
                            if ($cabang['group_cbid'] == ses_cabang)
                                echo 'selected';
                            echo ">" . $cabang['group_cbid'] . " | " . $cabang['cb_nama'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-xs-6 input-medium">
                <div>
                    <div class="input-group" style="position: static">
                        <input id="from" readonly type="text" value="<?php echo date('01-m-Y') ?>" name="start" class="input-sm input-small" />
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
            <div class="col-xs-6 col-sm-4">
                <div>
                    <button onclick="return lihat();" class="btn btn-xs btn-info btn-bol" type="button"><i class="ace-icon fa fa-search"></i>LIHAT</button>
                    <button onclick="return excel();" class="btn btn-xs btn-info btn-bol" type="button"><i class="ace-icon fa fa-file-excel-o"></i>EXPORT</button>
                    <button onclick="return print();" class="btn btn-xs btn-info btn-bol" type="button"><i class="ace-icon fa fa-print"></i>PRINT</button>
                </div>
            </div>
        </div>
    </div>
    <div id="result" style="overflow-x: auto;margin:-2px 0 0 0;" ></div>
</form>
<script type="text/javascript">
    //isolate event
    function submited(actions) {
        $('#form').bind('submit', function() {
            $('#result').html('');
            $('#loading').show();
            $.ajax({
                type: 'POST',
                url: '' + actions + '',
                data: $(this).serialize(),
                success: function(data) {
                    $('#loading').hide();
                    $('#result').html(data);
                    $('#result').fadeIn('fast');
                }
            })
            return false
        });
    }

    function lihat() {
        submited('<?php echo site_url('laporan_finance/' . $etc['targetLoad'] . '/show'); ?>');
        $('#form').submit();
        $('#form').unbind('submit');
    }

    function excel() {
        $('#form').removeAttr('action');
        $('#form').attr('action', "<?php echo site_url('laporan_finance/' . $etc['targetLoad'] . '/excel'); ?>");
        $('#form').submit();
    }

    function print() {
        $('#form').removeAttr('action');
        $('#form').attr('action', "<?php echo site_url('laporan_finance/' . $etc['targetLoad'] . '/print'); ?>");
        $('#form').attr('target', "_new");
        $('#form').submit();
    }
    
    $(document).ready(function(){
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
    
        $("#coa").autocomplete({
            minLength: 1,
            source: function(req, add) {
                $.ajax({
                    url: "<?php echo site_url('auto_complete/auto_coa'); ?>",
                    dataType: 'json',
                    type: 'POST',
                    data: {
                        param :  $('#coa').val(),
                        cbid : $('#cbid').val()
                    },
                    success: function(data) {
                        add(data.message);
                    }
                });
            },
            create: function () {
                $(this).data('ui-autocomplete')._renderItem = function (ul, item) {
                    return $('<li></li>')
                    .append("<strong>" + item.value + "</strong><br>" + item.desc + "")
                    .appendTo(ul);
                };
            }
        });
    });
        
    var scripts = [null, null]
    $('.page-content-area').ace_ajax('loadScripts', scripts, function() {
        //inline scripts related to this page
    });
</script>
