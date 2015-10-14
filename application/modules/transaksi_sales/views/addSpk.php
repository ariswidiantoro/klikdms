<div id="result"></div>
<div class="page-header">
    <h1>
        Surat Pesanan Kendaraan (SPK)
    </h1>
</div>
<form class="form-horizontal" id="formAdd" method="post" action="<?php echo site_url('transaksi_sales/saveSpk'); ?>" name="formAdd">
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">No. Spk</label>
        <div class="col-sm-3">
            <input type="text" required="required" name="spk_no" id="spk_no"  
                   class="form-control input-xlarge upper req" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">No. Customer</label>
        <div class="col-sm-3">
            <input type="text" required="required" readonly ="readonly"
                   name="spk_norangka" id="spk_norangka"  class="form-control input-xlarge datepicker upper req" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Merk Kendaraan</label>
        <div class="col-sm-3">
            <input type="text" required="required" readonly ="readonly"
                   name="spk_merk" id="spk_merk"  class="form-control input-xlarge datepicker upper req" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Tipe Kendaraan</label>
        <div class="col-sm-3">
            <input type="text" required="required" readonly ="readonly"
                   name="spk_type" id="spk_type"  class="form-control input-xlarge datepicker upper req" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Warna Kendaraan</label>
        <div class="col-sm-3">
            <input type="text" required="required" readonly ="readonly"
                   name="spk_warna" id="spk_warna"  class="form-control input-xlarge datepicker upper req" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Kondisi</label>
        <div class="col-sm-3">
            <input type="text" required="required" readonly ="readonly"
                   name="spk_kondisi" id="spk_kondisi"  class="form-control input-xlarge datepicker upper req" />
        </div>
    </div>
    <div class="page-header">
        <h1>
            <small>
                DITERIMA DARI :
            </small>
        </h1>
    </div>
    <div id="atpm" style="display: block;"> 
        <div class="form-group">
            <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Supplier</label>
            <div class="col-sm-3">
                <input type="text" maxlength="8" readonly required
                       name="spk_supnama" id="spk_supnama"  class="form-control input-xlarge upper" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label no-padding-right" for="form-field-1">ID. Supplier</label>
            <div class="col-sm-3">
                <input type="text" maxlength="8" readonly
                       name="spk_supid" id="spk_supid"  class="form-control input-xlarge upper" />
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">No. DO</label>
        <div class="col-sm-3">
            <input type="text"  maxlength="50" name="spk_nodo" id="spk_nodo" required="required"  
                   readonly class="form-control input-xlarge upper" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Tgl. DO</label>
        <div class="col-sm-3">
            <input type="text"  maxlength="50" name="spk_tgldo" id="spk_tgldo" required="required"  
                   readonly class="form-control input-xlarge upper" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">No. PO</label>
        <div class="col-sm-3">
            <input type="text" required="required" maxlength="50"  readonly 
                   name="spk_nopo" id="spk_nopo" class="form-control input-xlarge upper" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Tgl. PO</label>
        <div class="col-sm-3">
            <input type="text"  maxlength="50" name="spk_tglpo" id="spk_tglpo" readonly required="required"  
                   class="form-control input-xlarge upper" />
        </div>
    </div>
    <div class="page-header">
        <h1>
            <small>
                RINCIAN HPP :
            </small>
        </h1>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">HPP</label>
        <div class="col-sm-3">
                <input type="text" name="spk_hpp" id="spk_hpp" style="text-align: right;" value="0" 
                       onchange="$('#'+this.id).val(formatDefault(this.value));" onkeyup="total()"  
                       class="form-control harga number input-xlarge upper" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Facility Fund</label>
        <div class="col-sm-3">
                <input type="text" name="spk_ff" id="spk_ff" style="text-align: right;" value="0" 
                       onchange="$('#'+this.id).val(formatDefault(this.value));" onkeyup="total()"  
                       class="form-control harga number input-xlarge upper" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Deposit Promosi</label>
        <div class="col-sm-3">
                <input type="text" name="spk_depro" id="spk_depro" style="text-align: right;" value="0" 
                       onchange="$('#'+this.id).val(formatDefault(this.value));" onkeyup="total()"  
                       class="form-control harga number input-xlarge upper" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Aksesories</label>
        <div class="col-sm-3">
                <input type="text" name="spk_aksesories" id="spk_aksesories" style="text-align: right;" value="0" 
                       onchange="$('#'+this.id).val(formatDefault(this.value));" onkeyup="total()" 
                       class="form-control harga number input-xlarge upper" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Holdback Margin</label>
        <div class="col-sm-3">
                <input type="text" name="spk_hbmargin" id="spk_hbmargin" style="text-align: right;" value="0" 
                       onchange="$('#'+this.id).val(formatDefault(this.value));" onkeyup="total()"  
                       class="form-control harga number input-xlarge upper" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">PPn BM</label>
        <div class="col-sm-3">
                <input type="text" name="spk_ppnbm" id="spk_ppnbm" style="text-align: right;" value="0" 
                       onchange="$('#'+this.id).val(formatDefault(this.value));" onkeyup="total()" 
                       class="form-control harga number input-xlarge upper" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">PPh 22</label>
        <div class="col-sm-3">
                <input type="text" name="spk_pph22" id="spk_pph22" style="text-align: right;" value="0" 
                       onchange="$('#'+this.id).val(formatDefault(this.value));" onkeyup="total()"  
                       class="form-control harga number input-xlarge upper" />
                
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
                window.location.href = "#transaksi_sales/terimaKendaraan";
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
    
    function changeType(){
        if($('#spk_jenis').val() == '1'){
            $('#agac').hide();
            $('#atpm').show();
        }else{
            $('#agac').show();
            $('#atpm').hide();
        }
    }
    
    
    $(this).ready(function() {
        $( ".datepicker" ).datepicker({
            autoclose: true,
            todayHighlight: true
        })
        .next().on(ace.click_event, function(){
            $(this).prev().focus();
        });
        
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
                url: "<?php echo site_url('transaksi_sales/saveSpk') ?>",
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