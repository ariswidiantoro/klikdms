<div id="result"></div>
<form class="form-horizontal" id="form" method="post" action="<?php echo site_url('master_sparepart/updateSpesialItem'); ?>" name="form">
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Kode Barang</label>
        <div class="col-sm-8">
            <input type="hidden" value="<?php echo $data['speid'] ?>" name="speid">
            <label>
                <input type="text" readonly="readonly" value="<?php echo $data['inve_kode'] ?>">
            </label>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nama Barang</label>
        <div class="col-sm-8">
            <input type="text" readonly="readonly" value="<?php echo $data['inve_nama'] ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Harga Spesial</label>
        <div class="col-sm-8">
            <input type="text" name="spe_harga" onchange="$('#'+this.id).val(formatDefault(this.value))" required="required" value="<?php echo number_format($data['spe_harga']) ?>" id="spe_harga" class="upper col-xs-10 col-sm-3" />
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