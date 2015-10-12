<form class="form-horizontal" id="form" method="post" action="" name="form">
    <div class="well well-sm">
        <div class="row">
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
            <div class="col-xs-6 col-sm-3">
                <div>
                    <div class="col-xs-12 col-lg-6">
                        Kategory
                    </div>
                    <div class="col-xs-12 col-lg-6">
                        Jenis Barang
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6 col-sm-2">
                <div>
                    <div class="input-group">
                        <input type="text" name="start" value="<?php echo date('01/m/Y') ?>" class="datepicker form-control" style="position: static;"/>
                        <span class="input-group-addon">
                            <i class="ace-icon fa fa-calendar"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-xs-6 col-sm-2">
                <div>
                    <div class="input-group" style="position: static">
                        <input type="text" value="<?php echo date('d/m/Y') ?>" name="end" class="datepicker form-control" />
                        <span class="input-group-addon">
                            <i class="ace-icon fa fa-calendar"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-xs-6 col-sm-3">
                <div>
                    <div class="col-xs-12 col-lg-6">
                        <select name="kategory" class="form-control">
                            <option value="rekap">REKAP</option>  
                            <option value="detail">DETAIL</option>  
                        </select>
                    </div>
                    <div class="col-xs-12 col-lg-6">
                        <select name="jenis" class="form-control">
                            <option value="all">SEMUA</option>  
                            <option value="ol">OLI</option>  
                            <option value="sp">SPAREPART</option>  
                            <option value="sm">SUB MATERIAL</option>  
                            <option value="so">SUB ORDER</option>  
                        </select>
                    </div>
                </div>
            </div>
            <div id="default-buttons" class="col-xs-6 col-sm-3">
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
        submited('<?php echo site_url('laporan_sparepart/' . $link . '/lihat'); ?>');
        if ($('#tranid').val() == '') {
            alert('KODE PERKIRAAN TDK BOLEH KOSONG');
        } else {
            $('#form').submit();
        }
        $('#form').unbind('submit');
    }

    function excel() {
        $('#form').removeAttr('action');
        $('#form').attr('action', "<?php echo site_url('laporan_sparepart/' . $link . '/excel'); ?>");
        if ($('#tranid').val() == '') {
            alert('KODE PERKIRAAN TDK BOLEH KOSONG');
        } else {
            $('#form').submit();
        }
    }

    function print() {
        $('#form').removeAttr('action');
        $('#form').attr('action', "<?php echo site_url('laporan_sparepart/' . $link . '/print'); ?>");
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