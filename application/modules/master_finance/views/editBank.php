<div id="result"></div>
<div class="page-header">
    <h1>
        Update Bank <?php echo $data['bank_name'] ?>
    </h1>
</div>
<form class="form-horizontal" id="formEdit" method="post" action="<?php echo site_url('master_finance/updateBank'); ?>" name="formEdit">
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nama</label>
        <div class="col-sm-8">
            <input type="text" required="required" value="<?php echo $data['bank_name'] ?>" maxlength="50" style='text-transform:uppercase' 
                   name="bank_name" id="bank_name"  class="ace col-xs-10 col-sm-10" />
             <input type="hidden" required="required"  value="<?php echo $data['bankid'] ?>" name="bankid" id="bankid"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Deskripsi</label>
        <div class="col-sm-8">
            <input type="text" required="required" value="<?php echo $data['bank_desc'] ?>" maxlength="50" style='text-transform:uppercase' 
                   name="bank_desc" id="bank_desc"  class="ace col-xs-10 col-sm-10" />
        </div>
    </div>
    <div class="clearfix form-actions">
        <div class="col-md-offset-1 col-md-5">
            <button class="btn btn-info" type="button" onclick="javascript:saveData()">
                <i class="ace-icon fa fa-check bigger-50"></i>
                Update
            </button>

            &nbsp; &nbsp; &nbsp;
            <button class="btn btn-danger" type="button" onclick="javascript:redirect('data');">
                <i class="ace-icon fa 	fa-ban bigger-50"></i>
                Batal
            </button>
        </div>
    </div>
</form>
<script type="text/javascript">
    function saveData(){
        var result = false;
        bootbox.confirm("Anda yakin data sudah benar ?", function(result) {
            if(result) {
                $("#formEdit").submit();
            }
        });
        return false;
    }
        
    function redirect(data){
        bootbox.confirm("Anda yakin kembali ?", function(result) {
            if(result) {
                window.location.href = "#master_finance/bank";
            }});
    }
        
    $(this).ready(function() {
        $(".number").keypress(function (e) {
            //if the letter is not digit then display error and don't type anything
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                //display error message
                //        $("#errmsg").html("Digits Only").show().fadeOut("slow");
                return false;
            }
        });
        
        $('#formEdit').submit(function() {
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url('master_finance/updateBank') ?>",
                dataType: "json",
                async: false,
                data: $(this).serialize(),
                success: function(data) {
                    window.scrollTo(0, 0);
                    document.formEdit.reset();
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