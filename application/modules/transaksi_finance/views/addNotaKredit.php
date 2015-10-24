<style type="text/css">
    html .ui-autocomplete { 
        /* without this, the menu expands to 100% in IE6 */
        max-height: 200px;
        padding-right: 20px;
        overflow-y: auto;
        width:300px; 
    }      
</style>
<div id="result"></div>
<div class="page-header">
    <h1>
        <?php echo $etc['judul']; ?>
    </h1>
</div>
<form class="form-horizontal" id="formAdd" method="post" action="<?php echo site_url($etc['targetSave']); ?>" name="formAdd">
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-left" for="form-field-1">No. Transaksi</label>
        <div class="col-sm-3">
            <input type="text" id="trans_docno" name="trans_docno" required="required" maxlength="20" class="upper form-control input-xlarge req" />
            <input type="hidden" id="trans_kstid" name="trans_kstid" value="<?php echo $etc['kstid']; ?>" />
            <input type="hidden" id="trans_purpose" name="trans_purpose" value="<?php echo $etc['purpose']; ?>" />
            <input type="hidden" id="trans_trans" name="trans_trans" value="<?php echo $etc['trans']; ?>" />
            <input type="hidden" id="trans_sub_trans" name="trans_sub_trans" value="<?php echo $etc['sub_trans']; ?>" />
            <input type="hidden" id="trans_type" name="trans_type" value="<?php echo $etc['type']; ?>" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-left" for="form-field-1">Tanggal</label>
        <div class="col-sm-2">
            <div class="input-group">
                <input type="text" id="trans_tgl" name="trans_tgl" readonly="readonly" value="<?php echo date('d-m-Y'); ?>" 
                       class="form-control datepicker req" data-date-format="dd-mm-yyyy" />
                <span class="input-group-addon">
                    <i class="fa fa-calendar bigger-110"></i>
                </span>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-left" for="form-field-1">No. Faktur</label>
        <div class="col-sm-3">
            <input type="text" id="dtrans_nota" name="dtrans_nota[]" required="required" maxlength="50" 
                   onkeyup="acomplete('dtrans_nota', 'auto_faktur_unit', 'dtrans_notaid')"class="req upper form-control input-xlarge" />
            <input type="hidden" id="dtrans_notaid" name="dtrans_notaid[]"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-left" for="form-field-1">No. Kontrak</label>
        <div class="col-sm-3">
            <input type="text" id="dtrans_kontrak" name="dtrans_kontrak[]" readonly maxlength="50" 
                   class="req upper form-control input-xlarge" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-left" for="form-field-1">Pelanggan</label>
        <div class="col-sm-3">
            <input type="text" id="dtrans_pelname" name="dtrans_pelname[]" readonly maxlength="50" 
                   class="req upper form-control input-xlarge" />
            <input type="hidden" id="dtrans_pelid" name="dtrans_pelid[]"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-left" for="form-field-1">Memo</label>
        <div class="col-sm-6">
            <input type="text" id="trans_desc" name="dtrans_desc[]" required="required" maxlength="500" 
                   placeholder="KETERANGAN" class="upper form-control input-xxlarge req" />
        </div>
    </div> 
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-left" for="form-field-1">Sebesar ( Rp. )</label>
        <div class="col-sm-6">
             <input type="text" id="totalTrans" name="totalTrans" required="required" placeholder="0.00"
                   onchange="$('#'+this.id).val(formatCurrency(this.value));" onblur="terbilang(this.value)" 
                   onkeyup="countDisc(this.value);"
                   class="number form-control input-xlarge req align-right" />
            <input type="hidden" id="dtrans_coa1" name="dtrans_coa[]" value="<?php echo DISKON_UNIT_BARU; ?>"/>
            <input type="hidden" id="dtrans_coa2" name="dtrans_coa[]" value="<?php echo HUTANG_PPN; ?>"/>
            <input type="hidden" id="dtrans_desc1" name="dtrans_desc[]" value = "" />
            <input type="hidden" id="dtrans_desc1" name="dtrans_desc[]" value = "" />
            <input type="hidden" id="dtrans_ccid1" name="dtrans_ccid[]" value = "" />
            <input type="hidden" id="dtrans_ccid2" name="dtrans_ccid[]" value = "" />
            <input type="hidden" id="dtrans_nominal1" name="dtrans_nominal[]" value = "0" />
            <input type="hidden" id="dtrans_nominal1" name="dtrans_nominal[]" value = "0" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-left" for="form-field-1">Terbilang</label>
        <div class="col-sm-8" style="padding-top:8px;">
            <i><span id="terbilang"style="font-weight:bold;"></span></i>
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
                Daftar Transaksi
            </button>
        </div>
    </div>
</form>

<script type="text/javascript">
    function redirect(data){
        bootbox.confirm("Anda yakin kembali ?", function(result) {
            if(result) {
                window.location.href = "#transaksi_finance/dataNotaKredit";
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
    function acomplete(id, url, trglocal, trgid, trgname){
        var row = $("#"+id).parents('.item-row');
        $("#" + id).autocomplete({
            minLength: 1,
            source: function(req, add) {
                $.ajax({
                    url: "<?php echo site_url('auto_complete'); ?>/"+url,
                    dataType: 'json',
                    type: 'POST',
                    data: {
                        param : $("#" + id).val(),
                        cbid : '<?php echo ses_cabang; ?>'
                    },
                    success: function(data) {
                        add(data.message);
                    }
                });
            },
            create: function (){
                $(this).data('ui-autocomplete')._renderItem = function (ul, item) {
                    return $('<li></li>')
                    .append("<strong>" + item.value + "</strong><br>" + item.desc + "")
                    .appendTo(ul);
                };
            },select: function(event, ui) {
                $('#' + trglocal ).val(ui.item.trglocal);
                $('#dtrans_kontrak').val(ui.item.trgkontrak);
                $('#dtrans_pelid').val(ui.item.trgpelid);
                $('#dtrans_pelname' ).val(ui.item.trgpelname);
            }
        });
    }
    
    function countDisc(total){
        
    }
    
    function terbilang(total){
        $('#terbilang').html((toWords(total)+" rupiah").toUpperCase());
    }
    
    $(this).ready(function() {
        $( ".datepicker" ).datepicker({
            autoclose: true,
            todayHighlight: true,
            dateFormat:'dd-mm-yy'	
        })
        .next().on(ace.click_event, function(){
            $(this).prev().focus();
        });

        $('#formAdd').submit(function() {
            if($("#totalTrans").val())
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url('transaksi_finance/saveTrans') ?>",
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

    });

    var scripts = [null, null]
    $('.page-content-area').ace_ajax('loadScripts', scripts, function() {
        //inline scripts related to this page
    });
</script> 
