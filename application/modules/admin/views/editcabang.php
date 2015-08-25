<form class="form-horizontal" id="formMenu" method="post" action="<?php echo site_url('administrator/updateCabang'); ?>" name="formRole">
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Kode Cabang</label>
        <div class="col-sm-8">
            <input type="text" name="cbid" id="cbid" readonly="readonly" value="<?php echo $cabang['cbid'] ?>" class="col-xs-10 col-sm-5" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nama Cabang</label>
        <div class="col-sm-8">
            <input type="text" name="cb_nama" id="cb_nama" placeholder="Nama Cabang" value="<?php echo $cabang['cb_nama'] ?>" class="col-xs-10 col-sm-5" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Alamat</label>
        <div class="col-sm-8">
            <textarea name="cb_alamat" class="ace col-xs-10 col-sm-5"><?php echo $cabang['cb_alamat'] ?></textarea>
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