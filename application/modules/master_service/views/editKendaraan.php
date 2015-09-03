<div id="result"></div>
<style>
    .ui-autocomplete {
        max-height: 200px;
        overflow-y: auto;
        overflow-x: hidden;
        color: black;
        padding-right: 20px;
    }
    * html .ui-autocomplete {
        height: 200px;
    }
</style>
<form class="form-horizontal" id="form" method="post" action="<?php echo site_url('master_service/updateKendaraan'); ?>" name="form">
    <div class="page-header">
        <h1>
            <small>
                Data Pelanggan
            </small>
        </h1>
    </div><!-- /.page-header -->
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nama</label>
        <div class="col-sm-8">
            <input type="text" name="pel_nama" value="<?php echo $data['pel_nama']; ?>" id="pel_nama" autocomplete="off" spellcheck="false" required="required" placeholder="Nama" class="upper ace col-xs-10 col-sm-5" />
            <a href="#master_service/addPelanggan" class="btn btn-sm btn-primary">
                <i class="ace-icon fa fa-plus"></i>
                Tambah Pelanggan</a>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Kode Pelanggan</label>
        <div class="col-sm-8">
            <input type="hidden" name="mscid" id="mscid" value="<?php echo $data['mscid'] ?>">
            <input type="text" value="<?php echo $data['pelid']; ?>" name="msc_pelid" required="required" id="pelid" placeholder="Kode Pelanggan" class="upper ace col-xs-10 col-sm-5" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Alamat</label>
        <div class="col-sm-8">
            <textarea name="pel_alamat" id="pel_alamat" class="upper ace col-xs-10 col-sm-7" required="required" rows="4"><?php echo $data['pel_alamat']; ?></textarea>
        </div>
    </div>
    <div class="page-header">
        <h1>
            <small>
                Data Kendaraan
            </small>
        </h1>
    </div><!-- /.page-header -->
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nomor Polisi</label>
        <div class="col-sm-8">
            <input type="text" name="msc_nopol" value="<?php echo $data['msc_nopol']; ?>" autocomplete="off" required="required" id="pelid" placeholder="Nomor Polisi" class="upper ace col-xs-10 col-sm-5" />* TANPA SPASI
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nomor Rangka</label>
        <div class="col-sm-8">
            <input type="text" name="msc_norangka" value="<?php echo $data['msc_norangka']; ?>"  autocomplete="off" required="required" id="msc_norangka" placeholder="Nomor Rangka" class="upper ace col-xs-10 col-sm-5" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nomor Mesin</label>
        <div class="col-sm-8">
            <input type="text" name="msc_nomesin"  autocomplete="off" value="<?php echo $data['msc_nomesin']; ?>" required="required" id="msc_nomesin" placeholder="Nomor Mesin" class="upper ace col-xs-10 col-sm-5" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Warna Kendaraan</label>
        <div class="col-sm-8">
            <select name="msc_warnaid" id="msc_warnaid" class="ace col-xs-10 col-sm-3">
                <option value="">Pilih</option>
                <?php
                if (count($warna) > 0) {
                    foreach ($warna as $value) {
                        $select = ($data['msc_warnaid'] == $value['warnaid']) ? 'selected' : '';
                        ?>
                        <option value="<?php echo $value['warnaid']; ?>" <?php echo $select; ?>><?php echo $value['warna_deskripsi'] ?></option> 
                        <?php
                    }
                }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Merk</label>
        <div class="col-sm-8">
            <select name="merkid" id="merkid" onchange="getModel()" class="ace col-xs-10 col-sm-3">
                <option value="">Pilih</option>
                <?php
                if (count($merk) > 0) {
                    foreach ($merk as $value) {
                        $select = ($data['merkid'] == $value['merkid']) ? 'selected' : '';
                        ?>
                        <option value="<?php echo $value['merkid']; ?>" <?php echo $select; ?>><?php echo $value['merk_deskripsi'] ?></option> 
                        <?php
                    }
                }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Model</label>
        <div class="col-sm-8">
            <select name="modelid" id="modelid" onchange="getType()" class="ace col-xs-10 col-sm-3">
                <option value="">Pilih</option>
                <?php
                if (count($model) > 0) {
                    foreach ($model as $value) {
                        $select = ($data['modelid'] == $value['modelid']) ? 'selected' : '';
                        ?>
                        <option value="<?php echo $value['modelid']; ?>"<?php echo $select; ?>><?php echo $value['model_deskripsi'] ?></option> 
                        <?php
                    }
                }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Type</label>
        <div class="col-sm-8">
            <select name="msc_ctyid" id="msc_ctyid" class="ace col-xs-10 col-sm-3">
                <option value="">Pilih</option>
                <?php
                if (count($type) > 0) {
                    foreach ($type as $value) {
                        $select = ($data['ctyid'] == $value['ctyid']) ? 'selected' : '';
                        ?>
                        <option value="<?php echo $value['ctyid']; ?>"<?php echo $select; ?>><?php echo $value['cty_deskripsi'] ?></option> 
                        <?php
                    }
                }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Tahun</label>
        <div class="col-sm-8">
            <input type="text" name="msc_tahun" value="<?php echo $data['msc_tahun']; ?>" maxlength="4" id="msc_nomesin" placeholder="Tahun" class="number ace col-xs-10 col-sm-2" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">STNK Expired</label>
        <div class="col-sm-8">
            <div class="input-group input-group-sm col-sm-3">
                <input type="text" name="msc_stnkexp" value="<?php if (dateToIndo($data['msc_stnkexp']) != defaultTgl()) echo dateToIndo($data['msc_stnkexp']); ?>" id="datepicker" class="datepicker form-control" />
                <span class="input-group-addon">
                    <i class="ace-icon fa fa-calendar"></i>
                </span>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Type Pelanggan</label>
        <div class="col-sm-8">
            <select name="msc_inextern" required="required" id="msc_inextern" class="ace col-xs-10 col-sm-3">
                <option value="">Pilih</option>
                <option value="1" <?php if ($data['msc_inextern'] == '1') echo 'selected'; ?>>INTERN</option>
                <option value="2" <?php if ($data['msc_inextern'] == '2') echo 'selected'; ?>>EXTERN</option>
                <option value="3" <?php if ($data['msc_inextern'] == '3') echo 'selected'; ?>>GROUP</option>
                <option value="4" <?php if ($data['msc_inextern'] == '4') echo 'selected'; ?>>CABANG</option>
            </select>
        </div>
    </div>


    <div class="clearfix form-actions">
        <div class="col-md-offset-1 col-md-5">
            <button class="btn btn-info" type="submit">
                <i class="ace-icon fa fa-check bigger-50"></i>
                Submit
            </button>

            &nbsp; &nbsp; &nbsp;
            <button class="btn" type="reset">
                <i class="ace-icon fa fa-undo bigger-50"></i>
                Reset
            </button>
        </div>
    </div>
</form>
<script src="http://cdn.jsdelivr.net/typeahead.js/0.9.3/typeahead.min.js"></script>
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">

<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
<script type="text/javascript">
    var scripts = [null, null]
    $('.page-content-area').ace_ajax('loadScripts', scripts, function() {
        //inline scripts related to this page
    
    });
    $(".number").keypress(function (e) {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            //display error message
            //        $("#errmsg").html("Digits Only").show().fadeOut("slow");
            return false;
        }
    });
    
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
                $('#modelid').append('<option value="">Pilih</option>');
                $.each(data, function(messageIndex, message) {
                    $('#modelid').append('<option value="' + message.modelid + '">' + message.model_deskripsi + '</option>');
                });
            }
        })
    }
    function getType()
    {
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('master_service/jsonTypeKendaraan') ?>',
            dataType: "json",
            async: false,
            data: {
                modelid : $("#modelid").val()
            },
            success: function(data) {
                $('#msc_ctyid').html('');
                $('#msc_ctyid').append('<option value="">Pilih</option>');
                $.each(data, function(messageIndex, message) {
                    $('#msc_ctyid').append('<option value="' + message.ctyid + '">' + message.cty_deskripsi + '</option>');
                });
            }
        })
    }
    
    $(document).ready(function(){
        $("#pel_nama").autocomplete({
            minLength: 1,
            source: function(req, add) {
                $.ajax({
                    url: '<?php echo site_url('master_service/jsonPelanggan'); ?>',
                    dataType: 'json',
                    type: 'POST',
                    data: {param : $("#pel_nama").val()},
                    success: function(data) {
                        if (data.response == "true") {
                            add(data.message);
                        } else {
                            add(data.value);
                        }
                    }
                });
            },
            create: function () {
                $(this).data('ui-autocomplete')._renderItem = function (ul, item) {
                    return $('<li>')
                    .append('<a>' + item.label + '<br>' + item.desc + '</a>')
                    .appendTo(ul);
                };
            },
            select: function(event, ui) {
                $("#pelid").val(ui.item.pelid);
                $("#pel_alamat").html(ui.item.desc);
            }
        })
    });
    
    
    $( ".datepicker" ).datepicker({
        showOtherMonths: true,
        selectOtherMonths: false,
        isRTL:true,
        yearRange: "c-5:c+10",
        changeMonth: true,
        changeYear: true,
					
        showButtonPanel: true,
        beforeShow: function() {
            //change button colors
            var datepicker = $(this).datepicker( "widget" );
            setTimeout(function(){
                var buttons = datepicker.find('.ui-datepicker-buttonpane')
                .find('button');
                buttons.eq(0).addClass('btn btn-xs');
                buttons.eq(1).addClass('btn btn-xs btn-success');
                buttons.wrapInner('<span class="bigger-110" />');
            }, 0);
        }
    });
    
    $(this).ready(function() {
        $('#form').submit(function() {
            //  if (confirm("Yakin data sudah benar ?")) {
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                dataType: "json",
                async: false,
                data: $(this)
                .serialize(),
                success: function(data) {
                    window.scrollTo(0, 0);
                    if (data.result) {
//                        document.form.reset();
//                        $("#pel_alamat").html("");
                    }
                    $("#result").html(data.msg).show().fadeIn("slow");
                }
            })
            return false;
        });

    });
   
</script>
