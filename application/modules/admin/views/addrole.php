<form class="form-horizontal" id="formMenu" method="post" action="<?php echo site_url('administrator/simpanRole'); ?>" name="formRole">
    <div class="form-group">
        <label class="col-sm-1 control-label no-padding-right" for="form-field-1">Nama Role</label>
        <div class="col-sm-9">
            <input type="text" required="required" name="role_menu" id="role_menu" placeholder="Nama Role" class="col-xs-10 col-sm-5" />
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