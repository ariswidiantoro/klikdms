<div id="result"></div>
<div class="page-header">
    <h1>
        Update Segment <?php echo $data['seg_nama'] ?>
    </h1>
</div>
<form class="form-horizontal" id="formEdit" method="post" action="<?php echo site_url('master_sales/updateSegment'); ?>" name="formEdit">
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Kode</label>
        <div class="col-sm-2">
            <input type="text" required="required" value="<?php echo $data['segid'] ?>" readonly  maxlength="50" style='text-transform:uppercase' 
                   name="segid" id="segid"  class="ace col-xs-10 col-sm-10" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Segment Kendaraan</label>
        <div class="col-sm-8">
            <input type="text" required="required" value="<?php echo $data['seg_nama'] ?>" maxlength="50" style='text-transform:uppercase' 
                   name="seg_nama" id="seg_nama"  class="ace col-xs-10 col-sm-10" />
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
    function redirect(data){
        bootbox.confirm("Anda yakin ?", function(result) {
            if(result) {
                window.location.href = "#master_sales/masterSegment";
            }});
    }
    
    function saveData(){
        var result = false;
        bootbox.confirm("Anda yakin data sudah benar ?", function(result) {
            if(result) {
                $("#formEdit").submit();
            }
        });
        return false;
    }
    
    $(this).ready(function() {
        $('#formEdit').submit(function() {
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url('master_sales/updateSegment') ?>",
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