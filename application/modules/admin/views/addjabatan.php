<div id="result"></div>
<form class="form-horizontal" id="formRole" method="post" action="<?php echo site_url('admin/saveJabatan'); ?>" name="formRole">
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nama Departemen</label>
        <div class="col-sm-8">
            <select name="jab_deptid" id="jab_deptid" class="form-control" style="width: 30%" >
                <?php
                if (count($departemen) > 0) {
                    foreach ($departemen as $value) {
                        ?>
                        <option value="<?php echo $value['deptid']; ?>"><?php echo $value['dept_deskripsi'] ?></option> 
                        <?php
                    }
                }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nama Jabatan</label>
        <div class="col-sm-8">
            <input type="text" name="jab_deskripsi" id="jab_deskripsi" placeholder="Nama Jabatan" class="upper col-xs-10 col-sm-5" />
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
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                dataType: "json",
                async: false,
                data: $(this)
                .serialize(),
                success: function(data) {
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