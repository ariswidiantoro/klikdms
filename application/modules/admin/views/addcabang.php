<div id="result"></div>
<form class="form-horizontal" id="formRole" method="post" action="<?php echo site_url('admin/saveCabang'); ?>" name="formRole">
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Kode Cabang</label>
        <div class="col-sm-8">
            <input type="text" name="cbid" required="required" maxlength="6" id="cb_nama" placeholder="Kode Cabang" class="col-xs-10 col-sm-5" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nama Cabang</label>
        <div class="col-sm-8">
            <input type="text" name="cb_nama" required="required" id="cb_nama" placeholder="Nama Cabang" class="col-xs-10 col-sm-5" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nama Perusahaan</label>
        <div class="col-sm-8">
            <select name="cb_compid" id="menu_parentid" class="form-control" style="width: 30%" >
                <?php
                if (count($pt) > 0) {
                    foreach ($pt as $value) {
                        ?>
                        <option value="<?php echo $value['compid']; ?>"><?php echo $value['comp_nama'] ?></option> 
                        <?php
                    }
                }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Alamat</label>
        <div class="col-sm-8">
            <textarea name="cb_alamat" class="ace col-xs-10 col-sm-5"></textarea>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Propinsi</label>
        <div class="col-sm-8">
            <select name="propinsi" id="propinsi" onchange="getKota()" class="req form-control" style="width: 30%" >
                <option value="">Pilih</option>
                <?php
                if (count($propinsi) > 0) {
                    foreach ($propinsi as $value) {
                        ?>
                        <option value="<?php echo $value['propid']; ?>"><?php echo $value['prop_deskripsi'] ?></option> 
                        <?php
                    }
                }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Kab / Kota</label>
        <div class="col-sm-8">
            <select name="cb_kotaid" id="cb_kotaid" class="req form-control" style="width: 30%" >
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Npwp</label>
        <div class="col-sm-8">
            <input type="text" name="cb_nama" id="cb_npwp" placeholder="Npwp" class="col-xs-10 col-sm-5" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Telpon</label>
        <div class="col-sm-8">
            <input type="text" name="cb_telpon" id="cb_telpon" placeholder="Nomer Telpon" class="col-xs-10 col-sm-5" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Fax</label>
        <div class="col-sm-8">
            <input type="text" name="cb_fax" id="cb_fax" placeholder="Fax" class="col-xs-10 col-sm-5" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Email</label>
        <div class="col-sm-8">
            <input type="email" name="cb_email" id="cb_email" placeholder="email" class="col-xs-10 col-sm-5" />
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
    
    function getKota()
    {
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('admin/jsonKota') ?>',
            dataType: "json",
            async: false,
            data: {
                propid : $("#propinsi").val()
            },
            success: function(data) {
                $('#cb_kotaid').html('');
                $.each(data, function(messageIndex, message) {
                    $('#cb_kotaid').append('<option value="' + message.kotaid + '">' + message.kota_deskripsi + '</option>');
                });
            }
        })
    }
    $(this).ready(function() {
        $('#formRole').submit(function() {
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                dataType: "json",
                async: false,
                data: $(this)
                .serialize(),
                success: function(data) {
                    //                    document.formRole.reset();
                    $("#result").html(data).show().fadeIn("slow");
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