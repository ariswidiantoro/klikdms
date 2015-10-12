<div id="result"></div>
<form class="form-horizontal" id="formRole" method="post" action="<?php echo site_url('master_service/saveBasicRate'); ?>" name="formRole">
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Total Basic Rate</label>
        <div class="col-sm-8">
            <input type="text" required="required" style="text-align: right" name="br_rate" id="br_rate" onchange="$('#'+this.id).val(formatDefault(this.value));" placeholder="0" class="number col-xs-10 col-sm-5" />
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
            //display error message
            //        $("#errmsg").html("Digits Only").show().fadeOut("slow");
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
    var scripts = [null, null]
    $('.page-content-area').ace_ajax('loadScripts', scripts, function() {
        //inline scripts related to this page
    });
</script> 