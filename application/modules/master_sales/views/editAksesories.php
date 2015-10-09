<div id="result"></div>
<div class="page-header">
    <h1>
        Update Aksesories <?php echo $data['aks_nama'] ?>
    </h1>
</div>
<form class="form-horizontal" id="formEdit" method="post" action="<?php echo site_url('master_sales/updateAksesories'); ?>" name="formEdit">
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nama</label>
        <div class="col-sm-8">
            <input type="text" required="required" maxlength="50" amd 
                   name="aks_nama" id="aks_nama" value="<?php echo $data['aks_nama'] ?>" class="ace col-xs-10 col-sm-8" />
        </div>
        <input type="hidden" required="required"  value="<?php echo $data['aksid'] ?>" name="aksid" id="aksid"/>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Deskripsi</label>
        <div class="col-sm-5">
            <textarea id="form-field-8" name="aks_descrip" class="form-control" style='text-transform:uppercase'  placeholder="DESKRIPSI"><?php echo $data['aks_descrip'] ?></textarea>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">HPP</label>
        <div class="col-sm-8">
            <input type="text" required="required" maxlength="20" style='text-transform:uppercase' 
                   name="aks_hpp" id="aks_hpp" value="<?php echo $data['aks_hpp'] ?>"  class="ace col-xs-10 col-sm-8 number align-right" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Kontak</label>
        <div class="col-sm-8">
            <input type="text" required="required" maxlength="50" style='text-transform:uppercase' 
                   name="aks_harga" id="aks_harga"  value="<?php echo $data['aks_harga'] ?>" class="ace col-xs-10 col-sm-8 number align-right" />
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
                window.location.href = "#master_sales/masterAksesories";
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
                url: "<?php echo site_url('master_sales/updateAksesories') ?>",
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
    
    $(".number").keypress(function (e) {
            //if the letter is not digit then display error and don't type anything
            if (e.which != 8 && e.which != 47 && e.which != 0 && (e.which < 46 || e.which > 57)){
                return false;
            }
        });
</script> 