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
        <div class="row">
            <div class="col-xs-6 col-sm-2">
                <div>
                    <span>Merk</span>
                </div>
            </div>
            <div class="col-xs-6 col-sm-2">
                <div>
                    <span>Model</span>
                </div>
            </div>
            <div class="col-xs-6 col-sm-2">
                <div>
                    <span>Warna</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6 col-sm-2">
                <div>
                    <select name="merkid" id="merkid" onchange="getModel()" class="form-control col-sm-10">
                        <option value="01">Semua Merk</option>
                        <?php
                        if (count($merk) > 0) {
                            foreach ($merk as $value) {
                                ?>
                                <option value="<?php echo $value['merkid']; ?>"><?php echo $value['merk_deskripsi'] ?></option> 
                                <?php
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-xs-6 col-sm-2">
                <div>
                    <select name="modelid" id="modelid" class="form-control col-sm-10">
                        <option value="01">Pilih</option>
                    </select>
                </div>
            </div>
            <div class="col-xs-6 col-sm-2">
                <div>
                    <select name="warnaid" id="warnaid" class="form-control col-sm-10">
                        <option value="01">Semua Warna</option>
                        <?php
                        if (count($warna) > 0) {
                            foreach ($warna as $value) {
                                ?>
                                <option value="<?php echo $value['warnaid']; ?>"><?php echo $value['warna_deskripsi'] ?></option> 
                                <?php
                            }
                        }
                        ?>
                    </select>
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
        submited('<?php echo site_url('laporan_sales/' . $link . '/lihat'); ?>');
        if ($('#tranid').val() == '') {
            alert('KODE PERKIRAAN TDK BOLEH KOSONG');
        } else {
            $('#form').submit();
        }
        $('#form').unbind('submit');
    }

    function excel() {
        $('#form').removeAttr('action');
        $('#form').attr('action', "<?php echo site_url('laporan_sales/' . $link . '/excel'); ?>");
        if ($('#tranid').val() == '') {
            alert('KODE PERKIRAAN TDK BOLEH KOSONG');
        } else {
            $('#form').submit();
        }
    }

    function print() {
        $('#form').removeAttr('action');
        $('#form').attr('action', "<?php echo site_url('laporan_sales/' . $link . '/print'); ?>");
        $('#form').attr('target', "_new");

        if ($('#tranid').val() == '') {
            alert('KODE PERKIRAAN TDK BOLEH KOSONG');
        } else {
            $('#form').submit();
        }
    }
    
    function getModel()
    {
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('master_service/jsonModelKendaraan') ?>',
            dataType: "json",
            async: false,
            data: {
                merkid : $("#merkid").val()
            },
            success: function(data) {
                $('#modelid').html('');
                $('#modelid').append('<option value="01">Semua Model</option>');
                $.each(data, function(messageIndex, message) {
                    $('#modelid').append('<option value="' + message['modelid'] + '">' + message['model_deskripsi'] + '</option>');
                });
            }
        })
    }
    
    $(document).ready(function(){
        $("#kodeBarang").autocomplete({
            minLength: 1,
            source: function(req, add) {
                $.ajax({
                    url: '<?php echo site_url('master_sparepart/jsonBarang'); ?>',
                    dataType: 'json',
                    type: 'POST',
                    data: {param : $("#kodeBarang").val()},
                    success: function(data) {
                        add(data);
                    }
                });
            },
            create: function () {
                $(this).data('ui-autocomplete')._renderItem = function (ul, item) {
                    return $('<li>')
                    .append("<a><strong>" + item.value + "</strong><br> Nama Barang : " + item.desc + "</a>")
                    .appendTo(ul);
                };
            }
        })
    });
    var scripts = [null, null]
    $('.page-content-area').ace_ajax('loadScripts', scripts, function() {
        //inline scripts related to this page
    });
</script>