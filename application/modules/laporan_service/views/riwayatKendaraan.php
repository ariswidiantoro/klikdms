<form class="form-horizontal" id="form" method="post" action="" name="form">
    <div class="well well-sm">
        <div class="row">
            <div class="col-xs-6 col-sm-2">
                <div>
                    <span>Cari Berdasarkan</span>
                </div>
            </div>
            <div class="col-xs-6 col-sm-2">
                <div>
                    <span></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6 col-sm-2">
                <div>
                    <div class="input-group">
                        <select name="sortby" class="form-control" >
                            <option value="msc_nopol">NOMOR POLISI</option>  
                            <option value="wo_nomer">NOMOR WO</option>  
                            <option value="msc_nomesin">NOMOR MESIN</option>  
                            <option value="msc_norangka">NOMOR RANGKA</option>  
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-xs-6 col-sm-2">
                <div>
                    <div class="input-group" style="position: static">
                        <input type="text" name="end" class="upper form-control" />
                    </div>
                </div>
            </div>
            <div id="default-buttons" class="col-xs-6 col-sm-6">
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
    $( ".datepicker" ).datepicker({
    });
    
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
        submited('<?php echo site_url('laporan_service/' . $link . '/lihat'); ?>');
        if ($('#tranid').val() == '') {
            alert('KODE PERKIRAAN TDK BOLEH KOSONG');
        } else {
            $('#form').submit();
        }
        $('#form').unbind('submit');
    }

    function excel() {
        $('#form').removeAttr('action');
        $('#form').attr('action', "<?php echo site_url('laporan_service/' . $link . '/excel'); ?>");
        if ($('#tranid').val() == '') {
            alert('KODE PERKIRAAN TDK BOLEH KOSONG');
        } else {
            $('#form').submit();
        }
    }

    function print() {
        $('#form').removeAttr('action');
        $('#form').attr('action', "<?php echo site_url('laporan_service/' . $link . '/print'); ?>");
        $('#form').attr('target', "_new");

        if ($('#tranid').val() == '') {
            alert('KODE PERKIRAAN TDK BOLEH KOSONG');
        } else {
            $('#form').submit();
        }
    }
    
    var scripts = [null, null]
    $('.page-content-area').ace_ajax('loadScripts', scripts, function() {
        //inline scripts related to this page
    });
</script>