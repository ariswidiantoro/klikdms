<div id="result"></div>
<form class="form-horizontal" id="formRole" method="post" action="<?php echo site_url('master_service/saveFlateRate'); ?>" name="formRole">
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Kode Flate Rate</label>
        <div class="col-sm-8">
            <input type="text" required="required" maxlength="30" style='text-transform:uppercase' name="flat_kode" id="flat_kode" class="col-xs-10 col-sm-5" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Deskripsi</label>
        <div class="col-sm-8">
            <input type="text" required="required" name="flat_deskripsi" style='text-transform:uppercase' maxlength="50" id="flat_deskripsi" class="ace col-xs-10 col-sm-10" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Basic Rate</label>
        <div class="col-sm-8">
            <input type="text" readonly="readonly" style="text-align: right" name="flat_brate" id="flat_brate" value="<?php echo number_format($basic['br_rate']) ?>" placeholder="0" class="ace col-xs-10 col-sm-3"  />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Jam</label>
        <div class="col-sm-8">
            <input type="text" style="text-align: right" name="flat_jam" id="flat_jam" 
                   onchange="$('#'+this.id).val(formatDefault(this.value));" onkeyup="setTotal(this.value)" value="1" placeholder="0" class="number ace col-xs-10 col-sm-3"  />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Total</label>
        <div class="col-sm-8">
            <input type="text" style="text-align: right" name="flat_total" id="flat_total" 
                   onchange="$('#'+this.id).val(formatDefault(this.value));" onkeyup="setFx(this.value)" value="<?php echo number_format($basic['br_rate']) ?>" placeholder="0" class="number ace col-xs-10 col-sm-3"  />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Fx</label>
        <div class="col-sm-8">
            <input type="text" style="text-align: right" readonly="readonly" name="flat_fx" id="flat_fx" 
                   onchange="$('#'+this.id).val(formatDefault(this.value));" placeholder="0" value="1" class="ace col-xs-10 col-sm-3"  />
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
                    window.scrollTo(0, 0);
                    document.formRole.reset();
                    $("#result").html(data).show().fadeIn("slow");
                }
            })
            return false;
        });

    });
    
    function setTotal(jam)
    {
        var basic = replaceAll($("#flat_brate").val(), ',', '');
        if (basic == '') {
            basic = 0;
        }
        if (jam == '') {
            jam = '1';
        }
        $("#flat_total").val(formatDefault(parseFloat(jam) * parseFloat(basic)));
        $("#flat_fx").val("1");
        //        setFx();
    }

    function setFx(total)
    {
        var basic = replaceAll($("#flat_brate").val(), ',', '');
        var jam = $("#flat_jam").val();
        if (jam == '') {
            jam = '1';
        }
        total = replaceAll(total, ',', '');
        if (total == "") {
            total = "0";
        }
        var fx = 1;
        //        alert(total+"="+"="+jam+"="+basic);
        if (jam == '0') {
            $("#flat_fx").val("0");
        } else
        {
            fx = parseFloat(total) / (parseFloat(jam) * parseFloat(basic));
        }
        if (fx % 1 == 0) {
            $("#flat_fx").val(fx);
        } else
        {
            $("#flat_fx").val(fx.toFixed(2));
        }
    }
    
    var scripts = [null, null]
    $('.page-content-area').ace_ajax('loadScripts', scripts, function() {
        //inline scripts related to this page
    });
</script> 