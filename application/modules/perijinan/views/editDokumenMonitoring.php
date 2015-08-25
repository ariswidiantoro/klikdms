<form class="form-horizontal" id="formMenu" method="post" action="<?php echo site_url('perijinan/updateDokumenMonitoring'); ?>" name="formRole">
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Deskripsi Dokumen</label>
        <div class="col-sm-8">
            <input type="hidden" value="<?php echo $data['monid']; ?>" name="monid">
            <input type="text" name="mon_deskripsi" required="required" value="<?php echo $data['mon_deskripsi'] ?>" placeholder="Deskripsi Dokumen Monitoring" class="col-xs-10 col-sm-9" />
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