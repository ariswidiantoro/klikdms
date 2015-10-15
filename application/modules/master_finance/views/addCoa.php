<div id="result"></div>
<div class="page-header">
    <h1>
        Tambah Chart of Account
    </h1>
</div>

<form class="form-horizontal" id="formAdd" method="post" action="<?php echo site_url('master_finance/saveCoa'); ?>" name="formAdd">
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Kode COA</label>
        <div class="col-sm-8">
            <input type="text" required="required" maxlength="30" name="coa_kode" id="coa_kode" class="col-xs-10 col-sm-5 upper req" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Deskripsi</label>
        <div class="col-sm-8">
            <input type="text" required="required" maxlength="50" name="coa_desc" id="coa_desc"  class="ace col-xs-10 col-sm-10 upper req" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Tipe</label>
        <div class="col-sm-8">
            <select class="ace col-xs-10 col-sm-5 req" required id="coa_type" name="coa_type" style="width: 120px;">
                <option value="">Pilih</option>
                <option value="AL">Asset</option>
                <option value="LI">Liability</option>    
                <option value="EX">Expend</option>    
                <option value="IN">Increament</option>    
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Level</label>
        <div class="col-sm-8">
            <select class="ace col-xs-10 col-sm-5 req" id="coa_level" name="coa_level" style="width: 120px;">
                <option value="">Pilih</option>
                <option value="1">1</option>
                <option value="2">2</option>    
                <option value="3">3</option>    
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">&nbsp;</label>
        <div class="col-sm-8">
            <label>
                <input class="ace" id="rugi_laba" value="1" type="checkbox" name="rugi_laba">
                <span class="lbl"> Masuk Rugi Laba</span>
            </label>
        
            <label>
                <input class="ace" id="neraca" value="1" type="checkbox" name="neraca">
                <span class="lbl"> Kas / Bank</span>
            </label>
        </div>
    </div>
    <div class="clearfix form-actions">
        <div class="col-md-offset-1 col-md-5">
            <button class="btn btn-success" type="button" onclick="javascript:saveData()">
                <i class="ace-icon fa fa-check bigger-50"></i>
                Simpan
            </button>
            &nbsp; &nbsp; &nbsp;
            <button class="btn" type="reset">
                <i class="ace-icon fa fa-undo bigger-50"></i>
                Reset
            </button>
            &nbsp; &nbsp; &nbsp;
            <button class="btn btn-info" type="button" onclick="javascript:redirect('data');">
                <i class="ace-icon fa 	fa-book bigger-50"></i>
                Daftar Coa
            </button>
        </div>
    </div>
</form>

<script type="text/javascript">
    function redirect(data){
        bootbox.confirm("Anda yakin kembali ?", function(result) {
            if(result) {
                window.location.href = "#master_finance/coa";
            }});
    }
    
    function saveData(){
        var result = false;
        bootbox.confirm("Anda yakin data sudah benar ?", function(result) {
            if(result) {
                $("#formAdd").submit();
            }
        });
        return false;
    }
    
    $(this).ready(function() {
        $('#formAdd').submit(function() {
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url('master_finance/saveCoa') ?>",
                dataType: "json",
                async: false,
                data: $(this).serialize(),
                success: function(data) {
                    window.scrollTo(0, 0);
                    document.formAdd.reset();
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