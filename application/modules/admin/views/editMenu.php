<div id="result"></div>
<form class="form-horizontal" id="formMenu" method="post" action="<?php echo site_url('admin/updateMenu'); ?>" name="formMenu">
    <div class="form-group">
        <input type="hidden" name="menuid" value="<?php echo $data['menuid'] ?>" class="col-xs-10 col-sm-5" />
        <label class="col-sm-1 control-label no-padding-right" for="form-field-1">Nama Menu</label>
        <div class="col-sm-9">
            <input type="text" name="menu_nama" value="<?php echo $data['menu_nama'] ?>" id="menu_nama" placeholder="Nama Menu" class="col-xs-10 col-sm-5" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-1 control-label no-padding-right" for="form-field-1">Url</label>
        <div class="col-sm-9">
            <input type="text" id="menu_url" value="<?php echo $data['menu_url'] ?>"  name="menu_url" placeholder="Url" class="col-xs-10 col-sm-5" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-1 control-label no-padding-right" for="form-field-1">Deskripsi</label>
        <div class="col-sm-9">
            <input type="text" id="menu_deskripsi" value="<?php echo $data['menu_deskripsi'] ?>"  name="menu_deskripsi" class="col-xs-10 col-sm-5" placeholder="Deskripsi" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-1 control-label no-padding-right" for="form-field-1">Icon</label>
        <div class="col-sm-9">
            <input type="text" id="menu_icon" value="<?php echo $data['menu_icon'] ?>" name="menu_icon" class="col-xs-10 col-sm-5" placeholder="Icon" />
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-1 control-label no-padding-right" for="form-field-1">Parent</label>
        <div class="col-sm-9">
            <select name="menu_parent_id" id="menu_parent_id" class="col-xs-10 col-sm-5 upper" >
                <option value="-1">None</option>
                <?php
                if (count($menu) > 0) {
                    foreach ($menu as $value) {
                        $select = ($data['menu_parent_id'] == $value['menuid']) ? 'selected' : '';
                        ?>
                        <option value="<?php echo $value['menuid']; ?>" <?php echo $select; ?>><?php echo $value['menu_deskripsi'] ?></option> 
                        <?php
                    }
                }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-1 control-label no-padding-right" for="form-field-1">Module</label>
        <div class="col-sm-9">
            <select name="menu_module" id="menu_module" class="col-xs-10 col-sm-5 upper" >
                <?php
                if (count($menu) > 0) {
                    foreach ($menu as $value) {
                        $select = ($data['menu_module'] == $value['menuid']) ? 'selected' : '';
                        if($value['menu_parent_id'] != '-1')
                                                        continue;
                        ?>
                        <option value="<?php echo $value['menuid']; ?>" <?php echo $select; ?>><?php echo $value['menu_deskripsi'] ?></option> 
                        <?php
                    }
                }
                ?>
            </select>
        </div>
    </div>
    <!--    <div class="form-group">
            <label class="col-sm-1 control-label no-padding-right" for="form-field-1">&nbsp;</label>
            <div class="col-sm-9">
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
