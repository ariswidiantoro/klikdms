<div id="result"></div>
<div class="page-header">
    <h1>
        Harga Pokok Penjualan Unit
    </h1>
</div>

<form class="form-horizontal" id="formAdd" method="post" action="<?php echo site_url('transaksi_sales/saveBpk'); ?>" name="formAdd">
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">No. Rangka</label>
        <div class="col-sm-3">
            <input type="text" required="required" 
                   name="bpk_norangka" id="bpk_norangka"  class="form-control input-xlarge datepicker upper req" />
            <input type="hidden" name="bpk_norangka" id="bpk_norangka" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">No. Mesin</label>
        <div class="col-sm-3">
            <input type="text" required="required" readonly ="readonly"
                   name="bpk_norangka" id="bpk_norangka"  class="form-control input-xlarge datepicker upper req" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Merk Kendaraan</label>
        <div class="col-sm-3">
            <input type="text" required="required" readonly ="readonly"
                   name="bpk_merk" id="bpk_merk"  class="form-control input-xlarge datepicker upper req" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Tipe Kendaraan</label>
        <div class="col-sm-3">
            <input type="text" required="required" readonly ="readonly"
                   name="bpk_type" id="bpk_type"  class="form-control input-xlarge datepicker upper req" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Warna Kendaraan</label>
        <div class="col-sm-3">
            <input type="text" required="required" readonly ="readonly"
                   name="bpk_warna" id="bpk_warna"  class="form-control input-xlarge datepicker upper req" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Kondisi</label>
        <div class="col-sm-3">
            <input type="text" required="required" readonly ="readonly"
                   name="bpk_kondisi" id="bpk_kondisi"  class="form-control input-xlarge datepicker upper req" />
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
                       name="bpk_supnama" id="bpk_supnama"  class="form-control input-xlarge upper" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label no-padding-right" for="form-field-1">ID. Supplier</label>
            <div class="col-sm-3">
                <input type="text" maxlength="8" readonly
                       name="bpk_supid" id="bpk_supid"  class="form-control input-xlarge upper" />
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">No. DO</label>
        <div class="col-sm-3">
            <input type="text"  maxlength="50" name="bpk_nodo" id="bpk_nodo" required="required"  
                   readonly class="form-control input-xlarge upper" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Tgl. DO</label>
        <div class="col-sm-3">
            <input type="text"  maxlength="50" name="bpk_tgldo" id="bpk_tgldo" required="required"  
                   readonly class="form-control input-xlarge upper" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">No. PO</label>
        <div class="col-sm-3">
            <input type="text" required="required" maxlength="50"  readonly 
                   name="bpk_nopo" id="bpk_nopo" class="form-control input-xlarge upper" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Tgl. PO</label>
        <div class="col-sm-3">
            <input type="text"  maxlength="50" name="bpk_tglpo" id="bpk_tglpo" readonly required="required"  
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
                <input type="text" name="bpk_hpp" id="bpk_hpp" style="text-align: right;" value="0" 
                       onchange="$('#'+this.id).val(formatDefault(this.value));" onkeyup="total()"  
                       class="form-control harga number input-xlarge upper" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Facility Fund</label>
        <div class="col-sm-3">
                <input type="text" name="bpk_ff" id="bpk_ff" style="text-align: right;" value="0" 
                       onchange="$('#'+this.id).val(formatDefault(this.value));" onkeyup="total()"  
                       class="form-control harga number input-xlarge upper" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Deposit Promosi</label>
        <div class="col-sm-3">
                <input type="text" name="bpk_depro" id="bpk_depro" style="text-align: right;" value="0" 
                       onchange="$('#'+this.id).val(formatDefault(this.value));" onkeyup="total()"  
                       class="form-control harga number input-xlarge upper" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Aksesories</label>
        <div class="col-sm-3">
                <input type="text" name="bpk_aksesories" id="bpk_aksesories" style="text-align: right;" value="0" 
                       onchange="$('#'+this.id).val(formatDefault(this.value));" onkeyup="total()" 
                       class="form-control harga number input-xlarge upper" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Holdback Margin</label>
        <div class="col-sm-3">
                <input type="text" name="bpk_hbmargin" id="bpk_hbmargin" style="text-align: right;" value="0" 
                       onchange="$('#'+this.id).val(formatDefault(this.value));" onkeyup="total()"  
                       class="form-control harga number input-xlarge upper" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">PPn BM</label>
        <div class="col-sm-3">
                <input type="text" name="bpk_ppnbm" id="bpk_ppnbm" style="text-align: right;" value="0" 
                       onchange="$('#'+this.id).val(formatDefault(this.value));" onkeyup="total()" 
                       class="form-control harga number input-xlarge upper" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">PPh 22</label>
        <div class="col-sm-3">
                <input type="text" name="bpk_pph22" id="bpk_pph22" style="text-align: right;" value="0" 
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
        if($('#bpk_jenis').val() == '1'){
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
                url: "<?php echo site_url('transaksi_sales/saveBpk') ?>",
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