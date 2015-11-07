<style  type="text/css">
    .ui-autocomplete {
        max-height: 200px;
        overflow-y: auto;
        overflow-x: hidden;
        padding-right: 20px;
    }
    * html .ui-autocomplete {
        height: 200px;
    }
    input:focus {
        background-color: yellow;
    } 
</style>
<form class="form-horizontal" id="form" method="post" action="" name="form">
    <div class="well well-sm">
        <table class="table">
            <tr>
                <td style="width: 15%"><span>Mulai Tgl</span></td>
                <td style="width: 15%"><span>Sampai Dengan</span></td>
                <td>Nama Pelanggan</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>
                    <div class="input-group">
                        <input type="text" name="start" value="<?php echo date('01/m/Y') ?>" class="datepicker form-control" style="position: static;"/>
                        <span class="input-group-addon">
                            <i class="ace-icon fa fa-calendar"></i>
                        </span>
                    </div>
                </td>
                <td>
                    <div class="input-group" style="position: static">
                        <input type="text" value="<?php echo date('d/m/Y') ?>" name="end" class="datepicker form-control" />
                        <span class="input-group-addon">
                            <i class="ace-icon fa fa-calendar"></i>
                        </span>
                    </div>
                </td>
                <td>
                    <input type="text" name="pelNama" id="pelNama" class="form-control upper" />
                    <input type="hidden" name="pelid" id="pelid"/>
                </td>
                <td>
                    <select name="kategory" id="kategory"  class="form-control">
                        <option value="detail">Detail</option>
                        <option value="total">Total</option>
                    </select>
                </td>
                <td>
                    <!--<div id="default-buttons" class="col-xs-6 col-sm-5">-->
                    <button onclick="return lihat();" class="btn btn-white btn-info btn-bol" type="button"><i class="ace-icon fa fa-eye bigger-110 blue"></i>Lihat</button>
                    <button onclick="return excel();" class="btn btn-white btn-info btn-bol" type="button"><i class="ace-icon fa fa-file-excel-o  bigger-110 blue"/></i>Export</button>
                    <button onclick="return print();" class="btn btn-white btn-info btn-bol" type="button"><i class="ace-icon glyphicon glyphicon-print bigger-110 blue"></i>Print</button>
                    <!--</div>-->
                </td>
            </tr>
        </table>
    </div>
    <div id="result" style="overflow-x: auto;margin:-2px 0 0 0;" >
    </div>
</form>
<div id="loading" >
    <div class="loading-img"><i class="ace-icon fa fa-spinner fa-spin orange bigger-200"></i></div> <div class="loading-text">Mengambil Data ...</div>
</div>
<!-- page specific plugin scripts -->
<script type="text/javascript">
    $( ".datepicker" ).datepicker({
    });
    $('#loading').hide();
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
    
    $(this).ready(function() {
        
        $("#pelNama").autocomplete({
            minLength: 1,
            source: function(req, add) {
                $.ajax({
                    url: '<?php echo site_url('master_service/jsonPelanggan'); ?>',
                    dataType: 'json',
                    type: 'POST',
                    data: {param : $("#pelNama").val()},
                    success: function(data) {
                        add(data);
                    }
                });
            },
            create: function () {
                $(this).data('ui-autocomplete')._renderItem = function (ul, item) {
                    return $('<li>')
                    .append('<a><strong>' + item.label + '</strong><br>' + item.desc + '</a>')
                    .appendTo(ul);
                };
            },
            select: function(event, ui) {
                $("#pelid").val(ui.item.pelid);
            }
        })
        
    });
    var scripts = [null, null]
    $('.page-content-area').ace_ajax('loadScripts', scripts, function() {
        //inline scripts related to this page
    });
</script>