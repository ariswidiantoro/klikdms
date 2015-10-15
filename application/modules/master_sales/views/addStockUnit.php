<div id="result"></div>
<div class="page-header">
    <h1>
        Tambah Stock Unit
    </h1>
</div>

<form class="form-horizontal" id="formAdd" method="post" action="<?php echo site_url('master_sales/saveStockUnit'); ?>" name="formAdd">
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">No. Rangka</label>
        <div class="col-sm-3">
            <input type="text" required="required" maxlength="50"
                   name="msc_norangka" id="msc_norangka"  class="form-control input-xlarge upper req" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">No. Mesin</label>
        <div class="col-sm-3">
            <input type="text" required="required" maxlength="50"
                   name="msc_nomesin" id="msc_nomesin"  class="form-control input-xlarge upper req" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Merk Kendaraan</label>
        <div class="col-sm-3">
            <select name="msc_merkid" id="msc_merkid" required class="form-control input-xlarge req" onchange="getModel()" >
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
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Segment Kendaraan</label>
        <div class="col-sm-3">
            <select name="msc_segid" id="msc_segid" required class="form-control input-xlarge req" onchange="getModel()" >
                <option value="">PILIH</option>
                <?php
                if (count($segment) > 0) {
                    foreach ($segment as $value) {
                        ?>
                        <option value="<?php echo $value['segid']; ?>"><?php echo $value['seg_nama'] . ' - ' . $value['segid'] ?></option> 
                        <?php
                    }
                }
                ?>
            </select> 
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Model Kendaraan</label>
        <div class="col-sm-3">
            <select name="msc_modelid" id="msc_modelid" onchange="getType()" required class="form-control input-xlarge req">
                <option value="">PILIH</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Tipe Kendaraan</label>
        <div class="col-sm-3">
            <select name="msc_ctyid" id="msc_ctyid" required class="form-control input-xlarge req">
                <option value="">PILIH</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Warna Kendaraan</label>
        <div class="col-sm-3">
            <select name="msc_warnaid" id="msc_warnaid" required class="form-control input-large req" >
                <option value="">PILIH</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Tahun Pembuatan</label>
        <div class="col-sm-3">
            <select name="msc_tahun" id="msc_tahun" required="required" class="form-control input-medium req">
                <?php
                for ($tahun = date('Y'); $tahun >= date('Y') - 30; $tahun--) {
                    $select = ($tahun == date('Y')) ? 'selected' : '';
                    ?>
                    <option value="<?php echo $tahun; ?>" <?php echo $select ?>><?php echo $tahun ?></option> 
                    <?php
                }
                ?>
            </select> 
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Kondisi</label>
        <div class="col-sm-3">
            <select name="msc_kondisi" id="msc_kondisi" required="required" class="form-control input-medium req"  >
                <option value="BARU">BARU</option>
                <option value="BEKAS">BEKAS</option>
            </select> 
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Body / Seri</label>
        <div class="col-sm-3">
            <input type="text" maxlength="50" name="msc_bodyseri" 
                   id="msc_bodyseri"  class="form-control input-xlarge upper" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Vin / Lot</label>
        <div class="col-sm-3">
            <input type="text"  maxlength="50" name="msc_vinlot" id="msc_vinlot"  
                   class="form-control input-xlarge upper" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">No. Kunci</label>
        <div class="col-sm-3">
            <input type="text" required="required" maxlength="50"
                   name="msc_nokunci" id="msc_nokunci"  class="form-control input-xlarge upper" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Reg / CKD</label>
        <div class="col-sm-3">
            <input type="text" required="required" maxlength="50"
                   name="msc_regckd" id="msc_regckd"  class="form-control input-xlarge upper" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Chasis</label>
        <div class="col-sm-3">
            <select name="msc_chasis" id="msc_chasis" class="form-control input-medium">
                <option value="YA">YA</option>
                <option value="TIDAK">TIDAK</option>
            </select> 
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Roda</label>
        <div class="col-sm-3">
            <select name="msc_roda" id="msc_roda" class="form-control input-medium">
                <option value="4">RODA 4</option>
                <option value="2">RODA 2</option>
            </select> 
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Ukuran Silinder</label>
        <div class="col-sm-3">
            <input type="text" maxlength="8"
                   name="msc_silinder" id="msc_silinder"  class="form-control input-xlarge upper number" />
        </div> <i>* CC</i>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Bahan Bakar</label>
        <div class="col-sm-3">
            <select name="msc_fuel" id="msc_fuel" class="form-control input-medium">
                <option value="BENSIN">BENSIN</option>
                <option value="SOLAR">SOLAR</option>
                <option value="PERTAMAX">PERTAMAX</option>
                <option value="GAS">GAS</option>
                <option value="LAIN">LAINNYA</option>
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
                Daftar Stock Unit
            </button>
        </div>
    </div>
</form>

<script type="text/javascript">
    function redirect(data){
        bootbox.confirm("Anda yakin kembali ?", function(result) {
            if(result) {
                window.location.href = "#master_sales/stockUnit";
            }});
    }
    
    function saveData(){
        var result = false;
        if(!$('#formAdd').valid()){
            e.preventDefault();
        }else{
            bootbox.confirm("Anda yakin data sudah benar ?", function(result) {
                if(result) {
                    $("#formAdd").submit();
                }
            });
        }
        return false;
    }
    
    function getModel(){
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('master_sales/jsonModelKendaraan') ?>',
            dataType: "json",
            async: false,
            data: {
                merkid : $("#msc_merkid").val(),
                segid : $("#msc_segid").val()
            },
            success: function(data) {
                $('#msc_modelid').html('');
                $('#msc_modelid').append('<option value="">PILIH</option>');
                $.each(data, function(messageIndex, message) {
                    $('#msc_modelid').append('<option value="' + message['modelid'] + '">' + message['model_deskripsi'] + '</option>');
                });
            }
        })
    }
    
    function getType(){
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('master_sales/jsonTypeKendaraan') ?>',
            dataType: "json",
            async: false,
            data: {
                modelid : $("#msc_modelid").val()
            },
            success: function(data) {
                getWarnaModel();
                $('#msc_ctyid').html('');
                $('#msc_ctyid').append('<option value="">PILIH</option>');
                $.each(data, function(messageIndex, message) {
                    $('#msc_ctyid').append('<option value="' + message['ctyid'] + '">' + message['cty_deskripsi'] + '</option>');
                });
            }
        })
    }
    
    function getWarnaModel(){
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('master_sales/jsonWarnaModel') ?>',
            dataType: "json",
            async: false,
            data: {
                modelid : $("#msc_modelid").val()
            },
            success: function(data) {
                $('#msc_warnaid').html('');
                $('#msc_warnaid').append('<option value="">PILIH</option>');
                $.each(data, function(messageIndex, message) {
                    $('#msc_warnaid').append('<option value="' + message['warnaid'] + '">' + message['warna_deskripsi'] + '</option>');
                });
            }
        })
    }
    
    $(this).ready(function() {
        $('#formAdd').validate({
            errorElement: 'div',
            errorClass: 'help-block',
            focusInvalid: false,
            ignore: "",
            rules: {},
            messages: {},
            highlight: function (e) {
                $(e).closest('.form-group').removeClass('has-info').addClass('has-error');
            },
            success: function (e) {
                $(e).closest('.form-group').removeClass('has-error');//.addClass('has-info');
                $(e).remove();
            },
            errorPlacement: function (error, element) {
                if(element.is('input[type=checkbox]') || element.is('input[type=radio]')) {
                    var controls = element.closest('div[class*="col-"]');
                    if(controls.find(':checkbox,:radio').length > 1) controls.append(error);
                    else error.insertAfter(element.nextAll('.lbl:eq(0)').eq(0));
                }
                else if(element.is('.chosen-select')) {
                    error.insertAfter(element.siblings('[class*="chosen-container"]:eq(0)'));
                }
                else error.insertAfter(element.parent());
            },
            submitHandler: function (form) {
            },
            invalidHandler: function (form) {
            }
        });
        
        $('#formAdd').submit(function() {
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url('master_sales/saveStockUnit') ?>",
                dataType: "json",
                async: false,
                data: $(this).serialize(),
                success: function(data) {
                    window.scrollTo(0, 0);
                    if(data.status == true)
                    document.formAdd.reset();
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