<div id="result"></div>
<form class="form-horizontal" id="formRole" method="post" action="<?php echo site_url('master_service/updateFreeService'); ?>" name="formRole">
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Kode Free Service</label>
        <div class="col-sm-8">
            <input type="hidden" name="flatid" value="<?php echo $data['flatid'] ?>">
            <input type="text" required="required" maxlength="30" value="<?php echo $data['flat_kode']; ?>" style='text-transform:uppercase' name="flat_kode" id="flat_kode" class="ace col-xs-10 col-sm-5" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Deskripsi</label>
        <div class="col-sm-8">
            <input type="text" required="required" maxlength="30" value="<?php echo $data['flat_deskripsi']; ?>" style='text-transform:uppercase' name="flat_deskripsi" id="flat_deskripsi" class="ace col-xs-10 col-sm-10" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Free Service Ke</label>
        <div class="col-sm-8">
            <select name="flat_free_jenis" required="required" class="ace col-xs-10 col-sm-3">
                <option value="">Pilih</option>
                <option value="1" <?php if ($data['flat_free_jenis'] == 1) echo 'selected'; ?>>Free Service Pertama</option>
                <option value="2" <?php if ($data['flat_free_jenis'] == 2) echo 'selected'; ?>>Free Service Kedua</option>
                <option value="3" <?php if ($data['flat_free_jenis'] == 3) echo 'selected'; ?>>Free Service Ketiga</option>
                <option value="4" <?php if ($data['flat_free_jenis'] == 4) echo 'selected'; ?>>> Free Service Ketiga</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Jasa</label>
        <div class="col-sm-8">
            <input type="text" style="text-align: right" name="flat_lc" id="flat_lc" 
                   onchange="$('#'+this.id).val(formatDefault(this.value));setTotal()" value="<?php echo number_format($data['flat_lc']); ?>"  value="0" placeholder="0" class="number ace col-xs-10 col-sm-3"  />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Sparepart</label>
        <div class="col-sm-8">
            <input type="text" style="text-align: right" value="<?php echo number_format($data['flat_part']); ?>" name="flat_part" id="flat_part" 
                   onchange="$('#'+this.id).val(formatDefault(this.value));setTotal()" value="0" placeholder="0" class="number ace col-xs-10 col-sm-3"  />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Oli</label>
        <div class="col-sm-8">
            <input type="text" style="text-align: right" value="<?php echo number_format($data['flat_oli']); ?>" name="flat_oli" id="flat_oli" 
                   onchange="$('#'+this.id).val(formatDefault(this.value));setTotal()" value="0" placeholder="0" class="number ace col-xs-10 col-sm-3"  />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Sub Material</label>
        <div class="col-sm-8">
            <input type="text" style="text-align: right" value="<?php echo number_format($data['flat_sm']); ?>" name="flat_sm" id="flat_sm" 
                   onchange="$('#'+this.id).val(formatDefault(this.value));setTotal()" value="0" placeholder="0" class="number ace col-xs-10 col-sm-3"  />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Sub Order</label>
        <div class="col-sm-8">
            <input type="text" style="text-align: right" name="flat_so" value="<?php echo number_format($data['flat_so']); ?>" id="flat_so" 
                   onchange="$('#'+this.id).val(formatDefault(this.value));setTotal()" value="0" placeholder="0" class="number ace col-xs-10 col-sm-3"  />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Total</label>
        <div class="col-sm-8">
            <input type="text" readonly="readonly" value="<?php echo number_format($data['flat_total']); ?>" style="text-align: right" name="flat_total" id="flat_total" 
                   value="0" placeholder="0" class="number ace col-xs-10 col-sm-3"  />
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
    //called when key is pressed in textbox
    $(".number").keypress(function (e) {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 47 && e.which != 0 && (e.which < 46 || e.which > 57)){
            return false;
        }
    });
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
                    if (data.result) {
                        window.scrollTo(0, 0);
                        $("#result").html(data).show().fadeIn("slow");
                    }else{
                        window.scrollTo(0, 0);
                        $("#result").html(data).show().fadeIn("slow");
                    }
                   
                }
            })
            return false;
        });

    });
    
    function setTotal()
    {
        var part = replaceAll($("#flat_part").val(), ',', '');
        var lc = replaceAll($("#flat_lc").val(), ',', '');
        var oli = replaceAll($("#flat_oli").val(), ',', '');
        var sm = replaceAll($("#flat_sm").val(), ',', '');
        var so = replaceAll($("#flat_so").val(), ',', '');
        $("#flat_total").val(formatDefault(part+lc+oli+sm+so));
    }
    var scripts = [null, null]
    $('.page-content-area').ace_ajax('loadScripts', scripts, function() {
        //inline scripts related to this page
    });
</script> 
