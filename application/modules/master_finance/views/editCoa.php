<div id="result"></div>
<div class="page-header">
    <h1>
        Update Chart of Account <?php echo $data['coa_kode'] ?>
    </h1>
</div>
<form class="form-horizontal" id="formEdit" method="post" action="<?php echo site_url('master_finance/updateCoa'); ?>" name="formEdit">
    <div class="form-group">
                            <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Kode COA</label>
                            <div class="col-sm-8">
                                <input type="text" required="required" maxlength="30" value="<?php echo $data['coa_kode']?>" style='text-transform:uppercase' name="coa_kode" id="coa_kode" class="col-xs-10 col-sm-5" />
                                <input type="hidden" required="required"  value="<?php echo $data['coaid']?>" name="coaid" id="coaid"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Deskripsi</label>
                            <div class="col-sm-8">
                                <input type="text" required="required" value="<?php echo $data['coa_desc']?>" maxlength="50" style='text-transform:uppercase' name="coa_desc" id="coa_desc"  class="ace col-xs-10 col-sm-10" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Tipe</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="coa_type" name="coa_type" style="width: 120px;">
                                    <option value="AL" <?php if($data['coa_type'] == 'AL') echo 'selected';?>>Asset</option>
                                    <option value="LI" <?php if($data['coa_type'] == 'LI') echo 'selected';?>>Liability</option>    
                                    <option value="EX" <?php if($data['coa_type'] == 'EX') echo 'selected';?>>Expend</option>    
                                    <option value="IN" <?php if($data['coa_type'] == 'IN') echo 'selected';?>>Increament</option>    
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Level</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="coa_level" name="coa_level" style="width: 120px;">
                                    <option value=""></option>
                                    <option value="1" <?php if($data['coa_level'] == '1') echo 'selected';?>>1</option>
                                    <option value="2" <?php if($data['coa_level'] == '2') echo 'selected';?>>2</option>    
                                    <option value="3" <?php if($data['coa_level'] == '3') echo 'selected';?>>3</option>    
                                </select>
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
                window.location.href = "#master_finance/coa";
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
                url: "<?php echo site_url('master_finance/updateCoa') ?>",
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