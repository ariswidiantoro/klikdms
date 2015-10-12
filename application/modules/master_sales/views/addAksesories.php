<div id="result"></div>
<div class="page-header">
    <h1>
        Tambah Aksesories
    </h1>
</div>

<form class="form-horizontal" id="formAdd" method="post" action="<?php echo site_url('master_sales/saveAksesories'); ?>" name="formAdd">
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nama</label>
        <div class="col-sm-8">
            <input type="text" required="required" maxlength="50"  
                   name="aks_nama" id="aks_nama"  class="ace col-xs-10 col-sm-6 upper req" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Deskripsi</label>
        <div class="col-sm-5">
            <textarea id="aks_descrip" name="aks_descrip" class="autosize-transition form-control upper req"  placeholder="DESKRIPSI"></textarea>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">HPP</label>
        <div class="col-sm-8">
            <input type="text" required="required" placeholder="0" maxlength="15" onchange="$('#'+this.id).val(formatDefault(this.value));"
                   name="aks_hpp" id="aks_hpp"  class="ace col-xs-10 col-sm-6 number align-right req" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Harga Jual</label>
        <div class="col-sm-8">
            <input type="text" required="required" placeholder="0" maxlength="15" onchange="$('#'+this.id).val(formatDefault(this.value));"
                   name="aks_harga" id="aks_harga"  class="ace col-xs-10 col-sm-6 number align-right req" />
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
                Daftar Aksesories
            </button>
        </div>
    </div>
</form>

<script type="text/javascript">
    function redirect(data){
        bootbox.confirm("Anda yakin kembali ?", function(result) {
            if(result) {
                window.location.href = "#master_sales/aksesories";
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
        //called when key is pressed in textbox
        $(".number").keypress(function (e) {
            //if the letter is not digit then display error and don't type anything
            if (e.which != 8 && e.which != 47 && e.which != 0 && (e.which < 46 || e.which > 57)){
                return false;
            }
        });
    
        $('#formAdd').submit(function() {
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url('master_sales/saveAksesories') ?>",
                dataType: "json",
                async: false,
                data: $(this).serialize(),
                success: function(data) {
                    window.scrollTo(0, 0);
                    if(data.status == '1'){
                        document.formAdd.reset();
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