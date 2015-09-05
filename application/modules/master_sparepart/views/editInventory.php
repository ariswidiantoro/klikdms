<div id="result"></div>
<form class="form-horizontal" id="form" method="post" action="<?php echo site_url('master_sparepart/updateInventory'); ?>" name="form">
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Kode Barang</label>
        <div class="col-sm-8">
            <input type="hidden" value="<?php echo $data['inveid']; ?>" name="inveid">
            <input type="text" required="required" value="<?php echo $data['inve_kode']; ?>" name="inve_kode" placeholder="Kode Barang" maxlength="40" class="upper col-xs-10 col-sm-5" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nama Barang</label>
        <div class="col-sm-8">
            <input type="text" required="required" value="<?php echo $data['inve_nama']; ?>" name="inve_nama" placeholder="Nama Barang" maxlength="60" class="upper col-xs-10 col-sm-10" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Barcode</label>
        <div class="col-sm-8">
            <input type="text" name="inve_barcode" value="<?php echo $data['inve_barcode']; ?>" placeholder="Barcode" maxlength="40" class="upper col-xs-10 col-sm-5" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Pilih Gudang</label>
        <div class="col-sm-8">
            <select name="gudang" id="gudang" onchange="getRak()" class="ace col-xs-10 col-sm-3">
                <option value="">Pilih</option>
                <?php
                if (count($gudang) > 0) {
                    foreach ($gudang as $value) {
                        $select = ($data['rak_gdgid'] == $value['gdgid']) ? 'selected' : '';
                        ?>
                        <option value="<?php echo $value['gdgid']; ?>" <?php echo $select; ?>><?php echo $value['gdg_deskripsi'] ?></option> 
                        <?php
                    }
                }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Pilih Rak</label>
        <div class="col-sm-8">
            <select name="inve_rakid" id="inve_rakid" class="ace col-xs-10 col-sm-3">
                <option value="">Pilih</option>
                <?php
                if (count($rak) > 0) {
                    foreach ($rak as $value) {
                        $select = ($data['inve_rakid'] == $value['rakid']) ? 'selected' : '';
                        ?>
                        <option value="<?php echo $value['rakid']; ?>" <?php echo $select; ?>><?php echo $value['rak_deskripsi'] ?></option> 
                        <?php
                    }
                }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Jenis Barang</label>
        <div class="col-sm-8">
            <select name="inve_jenis" required="required" id="inve_jenis" class="ace col-xs-10 col-sm-3">
                <option value="">Pilih</option>
                <option value="sp" <?php if ($data['inve_jenis'] == 'sp') echo 'selected'; ?>>Sparepart</option>
                <option value="sm" <?php if ($data['inve_jenis'] == 'sm') echo 'selected'; ?>>Sub Material</option>
                <option value="ol" <?php if ($data['inve_jenis'] == 'ol') echo 'selected'; ?>>Oli</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Harga Jual</label>
        <div class="col-sm-8">
            <input type="text" value="<?php echo number_format($data['inve_harga']); ?>" required="required" id="inve_harga" onchange="$('#'+this.id).val(formatDefault(this.value))" name="inve_harga" placeholder="0" maxlength="60" class="number col-xs-10 col-sm-3" /> * Harga Include PPN
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Stock Minimum</label>
        <div class="col-sm-8">
            <input type="text" name="inve_qty_min" value="<?php echo $data['inve_qty_min']; ?>" placeholder="0" maxlength="60" class="number col-xs-10 col-sm-2" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Usia Dalam KM</label>
        <div class="col-sm-8">
            <input type="text" name="inve_umur_km" value="<?php echo $data['inve_umur_km']; ?>" placeholder="0" maxlength="60" class="number col-xs-10 col-sm-2" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Usia Dalam Bulan</label>
        <div class="col-sm-8">
            <input type="text" value="<?php echo $data['inve_umur_bulan']; ?>" name="inve_umur_bulan" placeholder="0" maxlength="60" class="number col-xs-10 col-sm-2" />
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
<script type="text/javascript">
    //called when key is pressed in textbox
    $(".number").keypress(function (e) {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 47 && e.which != 0 && (e.which < 46 || e.which > 57)){
            //display error message
            //        $("#errmsg").html("Digits Only").show().fadeOut("slow");
            return false;
        }
    });
    
    function getRak()
    {
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('master_sparepart/jsonRak') ?>',
            dataType: "json",
            async: false,
            data: {
                gudang : $("#gudang").val()
            },
            success: function(data) {
                $('#inve_rakid').html('');
                $.each(data, function(messageIndex, message) {
                    $('#inve_rakid').append('<option value="' + message['rakid'] + '">' + message['rak_deskripsi'] + '</option>');
                });
            }
        })
    }
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
                        document.form.reset();
                    }
                    $("#result").html(data.msg).show().fadeIn("slow");
                }
            })
            return false;
        });

    });
    var scripts = [null, null]
    $('.page-content-area').ace_ajax('loadScripts', scripts, function() {
        //inline scripts related to this page
    });
</script> 