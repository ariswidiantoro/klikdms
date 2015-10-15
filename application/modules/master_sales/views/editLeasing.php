<div id="result"></div>
<div class="page-header">
    <h1>
        Update Tipe <?php echo $data['leas_nama'] ?>
    </h1>
</div>
<form class="form-horizontal" id="formEdit" method="post" action="<?php echo site_url('master_sales/updateLeasing'); ?>" name="formEdit">
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nama</label>
        <div class="col-sm-8">
            <input type="text" required="required" maxlength="50" style='text-transform:uppercase' 
                   name="leas_nama" id="leas_nama" value="<?php echo $data['leas_nama'] ?>" class="ace col-xs-10 col-sm-8" />
        </div>
        <input type="hidden" required="required"  value="<?php echo $data['leasid'] ?>" name="leasid" id="leasid"/>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Alamat</label>
        <div class="col-sm-5">
            <textarea id="form-field-8" name="leas_alamat" class="form-control" style='text-transform:uppercase'  placeholder="Alamat"><?php echo $data['leas_alamat'] ?></textarea>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Propinsi</label>
        <div class="col-sm-8">
            <select name="propid" id="propid" onchange="getKota()" class="form-control" style="width: 30%;">
                <option value="">PILIH</option>
                <?php
                if (count($propinsi) > 0) {
                    foreach ($propinsi as $value) {
                        ?>
                        <option value="<?php echo $value['propid']; ?>" <?php if($value['propid'] == $data['propid']){
                            echo 'selected';
                        }?>><?php echo $value['prop_deskripsi'] ?></option> 
                        <?php
                    }
                }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Kota</label>
        <div class="col-sm-8">
            <select name="leas_kotaid" id="leas_kotaid" class="form-control" style="width: 30%;">
                <option value="">PILIH</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Telephone</label>
        <div class="col-sm-8">
            <input type="text" required="required" maxlength="20" style='text-transform:uppercase' 
                   name="leas_telp" id="leas_telp" value="<?php echo $data['leas_telp'] ?>"  class="ace col-xs-10 col-sm-8 number" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Kontak</label>
        <div class="col-sm-8">
            <input type="text" required="required" maxlength="50" style='text-transform:uppercase' 
                   name="leas_kontak" id="leas_kontak"  value="<?php echo $data['leas_kontak'] ?>" class="ace col-xs-10 col-sm-8" />
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
                window.location.href = "#master_sales/masterLeasing";
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
    
    function getKota(){
        var initModel = '<?php echo $data['leas_kotaid']?>';
        var selected = '';
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('master_sales/jsonKota') ?>',
            dataType: "json",
            async: false,
            data: {
                propid : $("#propid").val()
            },
            success: function(data) {
                $('#leas_kotaid').html('');
                $('#leas_kotaid').append('<option value="">PILIH</option>');
                $.each(data, function(messageIndex, message) {
                    if(initModel == message['kotaid']){
                        selected = 'selected';
                    }else{
                        selected = '';
                    }
                    $('#leas_kotaid').append('<option value="' + message['kotaid'] + '" '+selected+'>' + message['kota_deskripsi'] + '</option>');
                });
            }
        })
    }
    
    $(this).ready(function() {
        getKota();
        
        $('#formEdit').submit(function() {
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url('master_sales/updateLeasing') ?>",
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