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
    <div class="well well-sm">
        <div class="row">
            <div class="col-xs-6 col-sm-2">
                <div>
                    <span>Cabang</span>
                </div>
            </div>
            <div class="col-xs-6 col-sm-2">
                <div>
                    <span>Mulai Tgl</span>
                </div>
            </div>
            <div class="col-xs-6 col-sm-2">
                <div>
                    <span>Sampai Dengan</span>
                </div>
            </div>
            <div class="col-xs-6 col-sm-2">
                <div>
                    <span>COA</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6 col-sm-2">
                <div>
                    <div class="input-group" style="width:100%;">
                        <select id="cbid" name="cbid" class="form-control input-small">
                            <option value ="">PILIH</option>
                            <?php
                            foreach ($etc['groupCabang'] as $cabang) {
                                echo "<option value='" . $cabang['group_cbid'] . "'"; 
                                    if($cabang['group_cbid'] == ses_cabang) echo 'selected';
                                echo ">" . $cabang['group_cbid']." | ". $cabang['cb_nama'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-xs-6 col-sm-2">
                <div>
                    <div class="input-group">
                        <input id="from" type="text" name="start" value="<?php echo date('01/m/Y') ?>" class="datepicker form-control input-small" style="position: static;"/>
                        <span class="input-group-addon">
                            <i class="ace-icon fa fa-calendar"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-xs-6 col-sm-2">
                <div>
                    <div class="input-group" style="position: static">
                        <input id="end" type="text" value="<?php echo date('d/m/Y') ?>" name="end" class="datepicker form-control input-small" />
                        <span class="input-group-addon">
                            <i class="ace-icon fa fa-calendar"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-xs-6 col-sm-2">
                <div>
                    <div class="input-group">
                        <input type="text" name="coa" id="coa" class="form-control input-small req"/>
                    </div>
                </div>
            </div>
            <div id="default-buttons" class="col-xs-6 col-sm-4">
                <button onclick="return lihat();" class="btn btn-white btn-info btn-bol" type="button"><i class="ace-icon fa fa-eye bigger-110 blue"></i>Lihat</button>
                <button onclick="return excel();" class="btn btn-white btn-info btn-bol" type="button"><i class="ace-icon fa fa-file-excel-o  bigger-110 blue"/></i>Export</button>
                <button onclick="return print();" class="btn btn-white btn-info btn-bol" type="button"><i class="ace-icon glyphicon glyphicon-print bigger-110 blue"></i>Print</button>
            </div>
        </div>
    </div>
    <div id="result" style="overflow-x: auto;margin:-2px 0 0 0;" >
    </div>
</form>
<!-- page specific plugin scripts -->
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
        if ($('#coa').val() == '') {
            alert('KODE PERKIRAAN TDK BOLEH KOSONG');
        } else {
            $('#form').submit();
        }
        $('#form').unbind('submit');
    }

    function excel() {
        $('#form').removeAttr('action');
        $('#form').attr('action', "<?php echo site_url('laporan_finance/' . $etc['targetLoad'] . '/excel'); ?>");
        if ($('#coa').val() == '') {
            alert('KODE PERKIRAAN TDK BOLEH KOSONG');
        } else {
            $('#form').submit();
        }
    }

    function print() {
        $('#form').removeAttr('action');
        $('#form').attr('action', "<?php echo site_url('laporan_finance/' . $etc['targetLoad'] . '/print'); ?>");
        $('#form').attr('target', "_new");

        if ($('#coa').val() == '') {
            alert('KODE PERKIRAAN TDK BOLEH KOSONG');
        } else {
            $('#form').submit();
        }
    }
    
    $(document).ready(function(){
        $( ".datepicker" ).datepicker();
    
        $("#coa").autocomplete({
            minLength: 1,
            source: function(req, add) {
                $.ajax({
                    url: "<?php echo site_url('auto_complete/auto_coa'); ?>",
                    dataType: 'json',
                    type: 'POST',
                    data: {
                        param : this.value,
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