<div id="result"></div>
<form class="form-horizontal" id="form" method="post" action="<?php echo site_url('master_sparepart/saveRak'); ?>" name="form">
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nama Rak</label>
        <div class="col-sm-8">
            <input type="text" name="rak_deskripsi" required="required" id="rak_deskripsi" placeholder="Nama Rak" class="upper col-xs-10 col-sm-5" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Pilih Gudang</label>
        <div class="col-sm-8">
            <select name="rak_gdgid" id="rak_gdgid" required="required" class="ace col-xs-10 col-sm-3">
                <option value="">Pilih</option>
                <?php
                if (count($gudang) > 0) {
                    foreach ($gudang as $value) {
                        ?>
                        <option value="<?php echo $value['gdgid']; ?>"><?php echo $value['gdg_deskripsi'] ?></option> 
                        <?php
                    }
                }
                ?>
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
<script type="text/javascript">
    $(this).ready(function() {
        $('#form').submit(function() {
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