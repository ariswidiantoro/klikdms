<style type="text/css">
    .req{
        background: #FAEBD7;
    } 
</style>
<div id="result"></div>
<form class="form-horizontal" id="formRole" method="post" action="<?php echo site_url('transaksi_service/saveFakturService'); ?>" name="formRole">
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nomor WO</label>
        <div class="col-sm-8">
            <input type="text" required="required" name="wo" id="wo" class="upper ace col-xs-10 col-sm-3 req" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nomor Polisi</label>
        <div class="col-sm-8">
            <input type="text" readonly="readonly" name="wo" id="wo" class="col-xs-10 col-sm-3" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nama Pelanggan</label>
        <div class="col-sm-8">
            <input type="text" readonly="readonly" name="wo" id="wo" class="col-xs-10 col-sm-5" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Final Checker</label>
        <div class="col-sm-8">
            <select name="inv_fchecker" id="inv_fchecker" required="required" class="ace col-xs-10 col-sm-3 upper req">
                <option value="">Pilih</option>
                <?php
                if (count($checker) > 0) {
                    foreach ($checker as $value) {
                        ?>
                        <option value="<?php echo $value['krid']; ?>"><?php echo $value['kr_nama'] ?></option> 
                        <?php
                    }
                }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Kasir</label>
        <div class="col-sm-8">
            <select name="inv_fchecker" id="inv_fchecker" required="required" class="ace col-xs-10 col-sm-3 upper req">
                <option value="">Pilih</option>
                <?php
                if (count($checker) > 0) {
                    foreach ($checker as $value) {
                        ?>
                        <option value="<?php echo $value['krid']; ?>"><?php echo $value['kr_nama'] ?></option> 
                        <?php
                    }
                }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">&nbsp;</label>
        <div class="col-sm-8">
            <label>
                <input class="ace" type="checkbox" name="form-field-checkbox">
                <span class="lbl"> Tampilkan PPN di cetakan faktur service</span>
            </label>
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
    $(this).ready(function() {
        $('#formRole').submit(function() {
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
                    document.formRole.reset();
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