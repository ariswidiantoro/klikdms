<div id="result"></div>
<form class="form-horizontal" id="formMenu" method="post" action="<?php echo site_url('admin/saveMenu'); ?>" name="formMenu">
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nama Menu</label>
        <div class="col-sm-8">
            <input type="text" name="menu_nama" maxlength="20" id="menu_nama" placeholder="Nama Menu" class="col-xs-10 col-sm-5" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Url</label>
        <div class="col-sm-8">
            <input type="text" id="menu_url" name="menu_url" placeholder="Url" class="col-xs-10 col-sm-5" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Deskripsi</label>
        <div class="col-sm-8">
            <input type="text" id="menu_deskripsi" name="menu_deskripsi" class="col-xs-10 col-sm-5" placeholder="Deskripsi" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Icon</label>
        <div class="col-sm-8">
            <input type="text" id="menu_icon" name="menu_icon" class="col-xs-10 col-sm-5" placeholder="Icon" />
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Parent</label>
        <div class="col-sm-8">
            <select name="menu_parent_id" id="menu_parentid" class="form-control col-xs-10 col-sm-5 upper" style="width: 40%" >
                <option value="-1">NONE</option>
                <?php
                if (count($menu) > 0) {
                    foreach ($menu as $value) {
                        ?>
                        <option value="<?php echo $value['menuid']; ?>"><?php echo $value['menu_deskripsi'] ?></option> 
                        <?php
                    }
                }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Module</label>
        <div class="col-sm-8">
            <select name="menu_module" id="menu_module" class="form-control col-xs-10 col-sm-5 upper" style="width: 40%" >
                <option value="-1">NONE</option>
                <?php
                if (count($menu) > 0) {
                    foreach ($menu as $value) {
                        if($value['menu_parent_id'] != '-1')
                                                        continue;
                        ?>
                        <option value="<?php echo $value['menuid']; ?>" ><?php echo $value['menu_deskripsi'] ?></option> 
                        <?php
                    }
                }
                ?>
            </select>
        </div>
    </div>
    <!--    <div class="form-group">
            <label class="col-sm-2 control-label no-padding-right" for="form-field-1">&nbsp;</label>
            <div class="col-sm-8">
                <label>
                    <input name="form-field-checkbox" type="checkbox" class="ace" />
                    <span class="lbl">Active</span>
                </label>
            </div>
        </div>-->
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
        $('#formMenu').submit(function() {
            //  if (confirm("Yakin data sudah benar ?")) {
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                dataType: "json",
                async: false,
                data: $(this)
                .serialize(),
                beforeSend: function() {
                    $("#imgAjaxLoader")
                    .show();
                },
                success: function(data) {
                    window.scrollTo(0, 0);
                    document.formMenu.reset();
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