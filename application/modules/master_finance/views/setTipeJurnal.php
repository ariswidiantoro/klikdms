<div id="result"></div>
<div class="page-header">
    <h1>
        Set Tipe Jurnal <?php echo $data['tipeid'] ?>
    </h1>
</div>
<form class="form-horizontal" id="formEdit" method="post" action="<?php echo site_url('master_finance/saveSetTipeJurnal'); ?>" name="formEdit">
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Jurnal A</label>
        <div class="col-sm-6">
            <input type="text" required="required" value="<?php echo $data['coa']['A'] ?>" maxlength="15" style='text-transform:uppercase' 
                   name="dtipe[]" id="dtipe1"  class="ace col-xs-10 col-sm-6" />
            <input type="hidden" required="required"  value="<?php echo 'A' ?>" name="const[]" id="const1"/>
            <input type="hidden" required="required"  value="<?php echo $data['tipeid'] ?>" name="tipeid" id="tipeid"/>
            <input type="hidden" required="required"  value="<?php echo ses_cabang ?>" name="cbid" id="cbid"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Jurnal B</label>
        <div class="col-sm-6">
            <input type="text" required="required" value="<?php echo $data['coa']['B'] ?>" maxlength="15" style='text-transform:uppercase' 
                   name="dtipe[]" id="dtipe2"  class="ace col-xs-10 col-sm-6" />
            <input type="hidden" required="required"  value="<?php echo 'B' ?>" name="const[]" id="const2"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Jurnal C</label>
        <div class="col-sm-6">
            <input type="text" required="required" value="<?php echo $data['coa']['C'] ?>" maxlength="15" style='text-transform:uppercase' 
                   name="dtipe[]" id="dtipe3"  class="ace col-xs-10 col-sm-6" />
            <input type="hidden" required="required"  value="<?php echo 'C' ?>" name="const[]" id="const3"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Jurnal D</label>
        <div class="col-sm-6">
            <input type="text" required="required" value="<?php echo $data['coa']['D'] ?>" maxlength="15" style='text-transform:uppercase' 
                   name="dtipe[]" id="dtipe4"  class="ace col-xs-10 col-sm-6" />
            <input type="hidden" required="required"  value="<?php echo 'D' ?>" name="const[]" id="const4"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Jurnal E</label>
        <div class="col-sm-6">
            <input type="text" required="required" value="<?php echo $data['coa']['E'] ?>" maxlength="15" style='text-transform:uppercase' 
                   name="dtipe[]" id="dtipe5"  class="ace col-xs-10 col-sm-6" />
            <input type="hidden" required="required"  value="<?php echo 'E' ?>" name="const[]" id="const5"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Jurnal F</label>
        <div class="col-sm-6">
            <input type="text" required="required" value="<?php echo $data['coa']['F'] ?>" maxlength="15" style='text-transform:uppercase' 
                   name="dtipe[]" id="dtipe6"  class="ace col-xs-10 col-sm-6" />
            <input type="hidden" required="required"  value="<?php echo 'F' ?>" name="const[]" id="const6"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Jurnal G</label>
        <div class="col-sm-6">
            <input type="text" required="required" value="<?php echo $data['coa']['G'] ?>" maxlength="15" style='text-transform:uppercase' 
                   name="dtipe[]" id="dtipe7"  class="ace col-xs-10 col-sm-6" />
            <input type="hidden" required="required"  value="<?php echo 'G' ?>" name="const[]" id="const7"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Jurnal H</label>
        <div class="col-sm-6">
            <input type="text" required="required" value="<?php echo $data['coa']['H'] ?>" maxlength="15" style='text-transform:uppercase' 
                   name="dtipe[]" id="dtipe8"  class="ace col-xs-10 col-sm-6" />
            <input type="hidden" required="required"  value="<?php echo 'H' ?>" name="const[]" id="const8"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Jurnal I</label>
        <div class="col-sm-6">
            <input type="text" required="required" value="<?php echo $data['coa']['I'] ?>" maxlength="15" style='text-transform:uppercase' 
                   name="dtipe[]" id="dtipe9"  class="ace col-xs-10 col-sm-6" />
            <input type="hidden" required="required"  value="<?php echo 'I' ?>" name="const[]" id="const9"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Jurnal J</label>
        <div class="col-sm-6">
            <input type="text" required="required" value="<?php echo $data['coa']['J'] ?>" maxlength="15" style='text-transform:uppercase' 
                   name="dtipe[]" id="dtipe10"  class="ace col-xs-10 col-sm-6" />
            <input type="hidden" required="required"  value="<?php echo 'J' ?>" name="const[]" id="const10"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Jurnal K</label>
        <div class="col-sm-6">
            <input type="text" required="required" value="<?php echo $data['coa']['K'] ?>" maxlength="15" style='text-transform:uppercase' 
                   name="dtipe[]" id="dtipe11"  class="ace col-xs-10 col-sm-6" />
            <input type="hidden" required="required"  value="<?php echo 'K' ?>" name="const[]" id="const11"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Jurnal L</label>
        <div class="col-sm-6">
            <input type="text" required="required" value="<?php echo $data['coa']['L'] ?>" maxlength="15" style='text-transform:uppercase' 
                   name="dtipe[]" id="dtipe12"  class="ace col-xs-10 col-sm-6" />
            <input type="hidden" required="required"  value="<?php echo 'L' ?>" name="const[]" id="const12"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Jurnal M</label>
        <div class="col-sm-6">
            <input type="text" required="required" value="<?php echo $data['coa']['M'] ?>" maxlength="15" style='text-transform:uppercase' 
                   name="dtipe[]" id="dtipe13"  class="ace col-xs-10 col-sm-6" />
            <input type="hidden" required="required"  value="<?php echo 'M' ?>" name="const[]" id="const13"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Jurnal N</label>
        <div class="col-sm-6">
            <input type="text" required="required" value="<?php echo $data['coa']['N'] ?>" maxlength="15" style='text-transform:uppercase' 
                   name="dtipe[]" id="dtipe14"  class="ace col-xs-10 col-sm-6" />
            <input type="hidden" required="required"  value="<?php echo 'N' ?>" name="const[]" id="const14"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Jurnal O</label>
        <div class="col-sm-6">
            <input type="text" required="required" value="<?php echo $data['coa']['O'] ?>" maxlength="15" style='text-transform:uppercase' 
                   name="dtipe[]" id="dtipe15"  class="ace col-xs-10 col-sm-6" />
            <input type="hidden" required="required"  value="<?php echo 'O' ?>" name="const[]" id="const15"/>
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
                window.location.href = "#master_finance/tipe_jurnal";
            }});
    }
        
    $(this).ready(function() {
        $('#formEdit').submit(function() {
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url('master_finance/saveSetTipeJurnal') ?>",
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