<div id="result"></div>
<?php
echo $this->session->flashdata('msg');
?>
<style type="text/css">
    .ui-autocomplete {
        max-height: 200px;
        overflow-y: auto;
        overflow-x: hidden;
        padding-right: 20px;
    }
    * html .ui-autocomplete {
        height: 200px;
    }
    input:focus {
        background-color: yellow;
    } 
</style>
<form class="form-horizontal" name="formAdd" method="post" action="" id="formAdd">
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Tanggal</label>
        <div class="col-sm-8">
            <input type="text" readonly maxlength="30" style='text-transform:uppercase' value="<?php echo date('d-m-Y') ?>" class="col-xs-10 col-sm-5" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">No Retur Beli</label>
        <div class="col-sm-8">
            <input type="text" required maxlength="20" autofocus name="rtb_nomer"
                   id="rtb_nomer" class="col-xs-10 col-sm-5 upper req" />
            <input type="hidden" value="" name="rtb_bpkid" id="rtb_bpkid">
            <input type="hidden" value="" name="rtb_mscid" id="rtb_mscid">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Alasan Retur</label>
        <div class="col-sm-8">
            <textarea name="rtb_alasan_retur" class="col-xs-10 col-sm-5 upper req">
            </textarea>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nomer BMK</label>
        <div class="col-sm-8">
            <input type="text" required maxlength="30" name="no_bmk" id="no_bmk" class="col-xs-10 col-sm-5 req upper" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nama Supplier</label>
        <div class="col-sm-8">
            <input type="text" readonly id="supplier" class="col-xs-10 col-sm-10" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nomer Rangka</label>
        <div class="col-sm-8">
            <input type="text" readonly id="rangka" class="col-xs-10 col-sm-5" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nomer Mesin</label>
        <div class="col-sm-8">
            <input type="text" readonly id="mesin" class="col-xs-10 col-sm-5" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Merk</label>
        <div class="col-sm-8">
            <input type="text" readonly id="merk" class="col-xs-10 col-sm-5" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Model</label>
        <div class="col-sm-8">
            <input type="text" readonly id="model" class="col-xs-10 col-sm-5" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Type Kendaraan</label>
        <div class="col-sm-8">
            <input type="text" readonly id="type" class="col-xs-10 col-sm-10" />
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
        </div>
    </div>
</form>
<script type="text/javascript">
    //called when key is pressed in textbox
    numberOnly();
    
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
    
    function total(){    
        var total = 0;
        var price;
        $(".harga").each(function() {
            price = $(this).val().replace(/,/g, "");
            total += Number(price);
        });
        total -= Number($("#fpk_um").val().replace(/,/g, ""));
        $("#fpk_total").val(formatDefaultTanpaDecimal(total));
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
                url: "<?php echo site_url('transaksi_sales/saveReturBeli') ?>",
                dataType: "json",
                async: false,
                data: $(this).serialize(),
                success: function(data) {
                    window.scrollTo(0, 0);
                    if(data.result){
                        $('.page-content-area').ace_ajax('loadUrl', "#transaksi_sales/returBeli", true);
                    }
                    else
                        $("#result").html(data.msg).show().fadeIn("slow");
                }
            })
            return false;
        });
        
        $("#no_bmk").autocomplete({
            minLength: 1,
            source: function(req, add) {
                $.ajax({
                    url: '<?php echo site_url('transaksi_sales/autoBmk'); ?>',
                    dataType: 'json',
                    type: 'POST',
                    data: {param : $("#no_bmk").val()},
                    success: function(data) {
                        add(data);
                    }
                });
            },
            select: function(event, ui) {
                $('.page-content-area').ace_ajax('startLoading');
                $.ajax({
                    url: '<?php echo site_url('transaksi_sales/jsonDataBmk'); ?>',
                    dataType: 'json',
                    type: 'POST',
                    data: {param : ui.item.bpkid},
                    success: function(data) {
                        if (data['msc_ready_stock'] == 0) {
                            $('.page-content-area').ace_ajax('stopLoading', true);
                            infoDialog("Unit ini sudah terjual");
                        }else{
                            $("#rtb_bpkid").val(data['bpkid']);
                            $("#supplier").val(data['sup_nama']);
                            $("#rtb_mscid").val(data['mscid']);
                            $("#merk").val(data['merk_deskripsi']);
                            $("#model").val(data['model_deskripsi']);
                            $("#type").val(data['cty_deskripsi']);
                            $("#rangka").val(data['msc_norangka']);
                            $("#mesin").val(data['msc_nomesin']);
                            $('.page-content-area').ace_ajax('stopLoading', true);
                        }
                    }
                });
            }
        });
        
    });
    
    var scripts = [null, null]
    $('.page-content-area').ace_ajax('loadScripts', scripts, function() {
        //inline scripts related to this page
    });
</script> 
