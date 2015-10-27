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
<form class="form-horizontal" name="formAdd" method="post" action="<?php echo site_url('transaksi_sales/savePoLeasing'); ?>" id="formAdd">
    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Tanggal</label>
        <div class="col-sm-7">
            <input type="text" readonly maxlength="30" style='text-transform:uppercase' value="<?php echo date('d-m-Y') ?>" class="col-xs-10 col-sm-5" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1">No Spk</label>
        <div class="col-sm-7">
            <input type="text" required="required" maxlength="30" autofocus name="spk_no"
                   id="spk_no" class="col-xs-10 col-sm-5 upper req" />
            <input type="hidden" value="" name="fpk_spkid" id="fpk_spkid">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Leasing</label>
        <div class="col-sm-7">
            <select name="fpk_leasid" id="fpk_leasid" class="ace col-xs-10 col-sm-4" >
                <option value="">PILIH</option>
                <?php
                if (count($leasing) > 0) {
                    foreach ($leasing as $value) {
                        ?>
                        <option value="<?php echo $value['leasid']; ?>"><?php echo $value['leas_nama'] ?></option> 
                        <?php
                    }
                }
                ?>
            </select> 
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Jenis Asuransi</label>
        <div class="col-sm-7">
            <select name="fpk_jenis_asuransi" class="ace col-xs-10 col-sm-4">
                <option value="">Pilih</option>
                <option value="TLO">TLO</option>
                <option value="ALL RISK">ALL RISK</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Premi Asuransi (%)</label>
        <div class="col-sm-7">
            <input type="text" maxlength="30" name="fpk_premi" id="fpk_premi" class="ace col-xs-10 col-sm-2 number"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Jangka Waktu (Bulan)</label>
        <div class="col-sm-7">
            <input type="text" maxlength="30" name="fpk_jangka" id="fpk_jangka" class="ace col-xs-10 col-sm-2 number"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Bunga (%)</label>
        <div class="col-sm-7">
            <input type="text" maxlength="30" name="fpk_bunga" id="fpk_bunga" class="ace col-xs-10 col-sm-2 number"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Angsuran (Rp)</label>
        <div class="col-sm-7">
            <input type="text" maxlength="30" onchange="$('#'+this.id).val(formatDefault(this.value))" name="fpk_angsuran" name="fpk_angsuran" value="0" id="fpk_angsuran" class="ace col-xs-10 col-sm-5 number right"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Harga OTR (Rp)</label>
        <div class="col-sm-7">
            <input type="text" required="required" readonly maxlength="30" onchange="$('#'+this.id).val(formatDefault(this.value));total()" value="0" name="fpk_hargaotr" id="fpk_hargaotr" class="col-xs-10 col-sm-5 number req right harga" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Uang Muka PO.Leasing (Rp)</label>
        <div class="col-sm-7">
            <input type="text" required="required" maxlength="30" onchange="$('#'+this.id).val(formatDefault(this.value));total()" name="fpk_um"  value="0" id="fpk_um" class="ace col-xs-10 col-sm-5 number req right"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Asuransi (Rp)</label>
        <div class="col-sm-7">
            <input type="text" onchange="$('#'+this.id).val(formatDefault(this.value));total()" value="0" maxlength="30" name="fpk_asuransi" id="fpk_asuransi" class="col-xs-10 col-sm-5 number right" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Administrasi (Rp)</label>
        <div class="col-sm-7">
            <input type="text" value="0" maxlength="30" name="fpk_admin" onchange="$('#'+this.id).val(formatDefault(this.value));total()" id="fpk_admin" class="col-xs-10 col-sm-5 number right" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Jumlah Hutang (Rp)</label>
        <div class="col-sm-7">
            <input type="text" readonly value="0" maxlength="30" name="fpk_total" id="fpk_total" class="col-xs-10 col-sm-5 number right" />
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
                url: "<?php echo site_url('transaksi_sales/savePoLeasing') ?>",
                dataType: "json",
                async: false,
                data: $(this).serialize(),
                success: function(data) {
                    window.scrollTo(0, 0);
                    if(data.result){
                        var params  = 'width=600';
                        params += ', height=50';
                        params += ', fullscreen=yes,scrollbars=yes';
                        window.open("<?php echo site_url("transaksi_sales/printFpk"); ?>/"+data.kode,'_blank', params);
                        $('.page-content-area').ace_ajax('loadUrl', "#transaksi_sales/addPoLeasing", true);
                    }
                    else
                        $("#result").html(data.msg).show().fadeIn("slow");
                }
            })
            return false;
        });
        
        $("#spk_no").autocomplete({
            minLength: 1,
            source: function(req, add) {
                $.ajax({
                    url: '<?php echo site_url('transaksi_sales/autoSpk'); ?>',
                    dataType: 'json',
                    type: 'POST',
                    data: {param : $("#spk_no").val()},
                    success: function(data) {
                        add(data);
                    }
                });
            },
            create: function () {
                $(this).data('ui-autocomplete')._renderItem = function (ul, item) {
                    return $('<li>')
                    .append("<a><strong>" + item.value + "</strong><br>" + item.spk_nokontrak + "</a>")
                    .appendTo(ul);
                };
            },
            select: function(event, ui) {
                $('.page-content-area').ace_ajax('startLoading');
                $.ajax({
                    url: '<?php echo site_url('transaksi_sales/jsonDataSpk'); ?>',
                    dataType: 'json',
                    type: 'POST',
                    data: {param : ui.item.spkid},
                    success: function(data) {
                        $("#fpk_leasid").val(data['fpt_leasid']);
                        $("#fpk_spkid").val(data['spkid']);
                        $("#fpk_jangka").val(data['fpt_jangka']);
                        $("#fpk_um").val(formatDefaultTanpaDecimal(data['spk_uangmuka']));
                        $("#fpk_hargaotr").val(formatDefaultTanpaDecimal(Number(data['fpt_total'])));
//                        $("#fpk_asuransi").val(formatDefaultTanpaDecimal(data['fpt_asuransi']));
//                        $("#fpk_admin").val(formatDefaultTanpaDecimal(data['fpt_administrasi']));
                        $("#fpk_total").val(formatDefaultTanpaDecimal(Number(data['fpt_total'])-Number(data['spk_uangmuka'])));
                        $('.page-content-area').ace_ajax('stopLoading', true);
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
