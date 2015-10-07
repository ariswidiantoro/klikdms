<div id="result"></div>
<div class="page-header">
    <h1>
        Tambah Warna Model
    </h1>
</div>

<form class="form-horizontal" id="formAdd" method="post" action="<?php echo site_url('master_sales/saveWarnaModel'); ?>" name="formAdd">
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Merk</label>
        <div class="col-sm-8">
            <select name="merkid" id="merkid" onchange="getModel()" class="form-control" style="width: 30%;">
                <option value="">PILIH</option>
                <?php
                if (count($merk) > 0) {
                    foreach ($merk as $value) {
                        ?>
                        <option value="<?php echo $value['merkid']; ?>"><?php echo $value['merk_deskripsi'] ?></option> 
                        <?php
                    }
                }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Model</label>
        <div class="col-sm-8">
            <select name="modelid" id="modelid" class="form-control" style="width: 30%;">
                <option value="">PILIH</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Warna</label>
        <div class="col-sm-8">
            <select name="warnaid" id="warnaid" class="form-control" style="width: 30%;">
                <option value="">PILIH</option>
                <?php
                if (count($warna) > 0) {
                    foreach ($warna as $value) {
                        ?>
                        <option value="<?php echo $value['warnaid']; ?>"><?php echo $value['warna_deskripsi'] ?></option> 
                        <?php
                    }
                }
                ?>
            </select>
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
                Daftar Warna Model
            </button>
        </div>
    </div>
</form>

<script type="text/javascript">
    function redirect(data){
        bootbox.confirm("Anda yakin kembali ?", function(result) {
            if(result) {
                window.location.href = "#master_sales/warnaModel";
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
    
    function getModel(){
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('master_sales/jsonModelKendaraan') ?>',
            dataType: "json",
            async: false,
            data: {
                merkid : $("#merkid").val()
            },
            success: function(data) {
                $('#modelid').html('');
                $('#modelid').append('<option value="">PILIH</option>');
                $.each(data, function(messageIndex, message) {
                    $('#modelid').append('<option value="' + message['modelid'] + '">' + message['model_deskripsi'] + '</option>');
                });
            }
        })
    }
    
    $(this).ready(function() {
        $('#formAdd').submit(function() {
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url('master_sales/saveWarnaModel') ?>",
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