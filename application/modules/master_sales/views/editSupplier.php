<div id="result"></div>
<div class="page-header">
    <h1>
        Edit Supplier <?php echo $data['sup_nama'] ?>
    </h1>
</div>
<form class="form-horizontal" id="form" method="post" action="<?php echo site_url('master_sales/updateSupplier'); ?>" name="form">
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nama</label>
        <div class="col-sm-8">
            <input type="hidden" name="supid" value="<?php echo $data['supid']; ?>">
            <input type="text" name="sup_nama" value="<?php echo $data['sup_nama']; ?>" required="required" placeholder="NAMA SUPPLIER" class="upper ace col-xs-10 col-sm-10" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Alamat</label>
        <div class="col-sm-8">
            <textarea name="sup_alamat" class="upper ace col-xs-10 col-sm-7" required="required" rows="4"><?php echo $data['sup_alamat']; ?></textarea>
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
            <select name="sup_kotaid" id="sup_kotaid" class="form-control" style="width: 30%;">
                <option value="">PILIH</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nomor HP</label>
        <div class="col-sm-8">
            <input type="text" name="sup_hp" value="<?php echo $data['sup_hp']; ?>"  placeholder="NOMOR HP" class="ace col-xs-10 col-sm-3" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nomor Telpon</label>
        <div class="col-sm-8">
            <input type="text" name="sup_telpon" value="<?php echo $data['sup_telpon']; ?>" placeholder="NOMOR TELPON" class="ace col-xs-10 col-sm-3" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Fax</label>
        <div class="col-sm-8">
            <input type="text" name="sup_fax" value="<?php echo $data['sup_fax']; ?>"  placeholder="NO. FAX" class="ace col-xs-10 col-sm-3" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">NPWP</label>
        <div class="col-sm-8">
            <input type="text" name="sup_npwp" value="<?php echo $data['sup_npwp']; ?>"  placeholder="NOMOR NPWP" class="ace col-xs-10 col-sm-3" />
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
    var scripts = [null, null]
    $('.page-content-area').ace_ajax('loadScripts', scripts, function() {
        //inline scripts related to this page
    });
    
    function getKota(){
        var initModel = '<?php echo $data['sup_kotaid']?>';
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
                $('#sup_kotaid').html('');
                $('#sup_kotaid').append('<option value="">PILIH</option>');
                $.each(data, function(messageIndex, message) {
                    if(initModel == message['kotaid']){
                        selected = 'selected';
                    }else{
                        selected = '';
                    }
                    $('#sup_kotaid').append('<option value="' + message['kotaid'] + '" '+selected+'>' + message['kota_deskripsi'] + '</option>');
                });
            }
        })
    }
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
    
    $(this).ready(function() {
        $('#form').submit(function() {
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
                    if (data.result) {
                        document.form.reset();
                    }
                    $("#result").html(data.msg).show().fadeIn("slow");
                }
            })
            return false;
        });

    });
   
</script>