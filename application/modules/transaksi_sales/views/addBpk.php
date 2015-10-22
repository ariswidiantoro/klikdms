<div id="result"></div>
<?php
echo $this->session->flashdata('msg');
?>
<div class="page-header">
    <h1>
        Tambah Penerimaan Kendaraan
    </h1>
</div>

<form class="form-horizontal" id="formAdd" method="post" action="<?php echo site_url('transaksi_sales/saveBpk'); ?>" name="formAdd">
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Jenis Penerimaan</label>
        <div class="col-sm-3">
            <select name="bpk_jenis" id="bpk_jenis" required="required" onchange="changeType();" class="form-control input-medium req"  >
                <option value="ATPM">ATPM</option>
                <option value="ANTAR CABANG">ANTAR CABANG</option>
                <option value="ANTAR GROUP">ANTAR GROUP</option>
                <option value="PIHAK LAIN">PIHAK LAIN</option>
            </select> 
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">No. Penerimaan</label>
        <div class="col-sm-3">
            <input type="text" required="required" maxlength="50"
                   name="bpk_nomer" id="bpk_nomer"  class="form-control input-xlarge upper req" />
        </div>
    </div>
    <!--    <div class="form-group">
            <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Tanggal</label>
            <div class="col-sm-3">
                <div class="input-group">
                    <input type="text" id="bpk_tgl" name="bpk_tgl" readonly="readonly" value="<?php echo date('d-m-Y'); ?>" 
                           class="form-control datepicker input-small" data-date-format="dd-mm-yyyy" />
                    <span class="input-group-addon">
                        <i class="fa fa-calendar bigger-110"></i>
                    </span>
                    </span>
                </div>
            </div>
        </div>-->
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">No. Rangka</label>
        <div class="col-sm-3">
            <input type="text" required="required" 
                   name="bpk_norangka" id="bpk_norangka"  class="form-control input-xlarge upper req" />
            <input type="hidden" name="bpk_mscid" id="bpk_mscid" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">No. Mesin</label>
        <div class="col-sm-3">
            <input type="text" required="required" readonly ="readonly"
                   name="bpk_norangka" id="bpk_nomesin"  class="form-control input-xlarge datepicker upper req" />
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
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Kondisi</label>
        <div class="col-sm-3">
            <select name="bpk_kondisi" id="bpk_kondisi" class="form-control input-medium">
                <option value="BARU">BARU</option>
                <option value="BEKAS">BEKAS</option>
            </select> 
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Vin / Lot</label>
        <div class="col-sm-3">
            <input type="text"  maxlength="50" name="bpk_vinlot" id="bpk_vinlot"  
                   class="form-control input-xlarge upper" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Body / Seri</label>
        <div class="col-sm-3">
            <input type="text" maxlength="50" name="bpk_bodyseri" 
                   id="bpk_bodyseri"  class="form-control input-xlarge upper" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Top</label>
        <div class="col-sm-3">
            <input type="text"  maxlength="50" placeholder ="TERM OF PAYMENT"
                   name="bpk_top" id="bpk_top"  class="form-control number input-xlarge upper" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Jatuh Tempo</label>
        <div class="col-sm-3">
            <div class="input-group">
                <input type="text" id="bpk_jtempo" name="bpk_jtempo"  readonly="readonly" placeholder ="TGL. JT TEMPO"
                       class="form-control datepicker input-small req" data-date-format="dd-mm-yyyy" />
                <span class="input-group-addon">
                    <i class="fa fa-calendar bigger-110"></i>
                </span>
                </span>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Keterangan</label>
        <div class="col-sm-3">
            <textarea name="bpk_keterangan" id="bpk_keterangan" 
                      class="form-control input-large upper"></textarea>
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
                <input type="text" maxlength="8"
                       name="bpk_supnama" id="bpk_supnama"  class="form-control input-xlarge upper req" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label no-padding-right" for="form-field-1">ID. Supplier</label>
            <div class="col-sm-3">
                <input type="text" maxlength="8" readonly
                       name="bpk_supid" id="bpk_supid"  class="form-control input-xlarge upper" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Alamat Supplier</label>
            <div class="col-sm-3">
                <textarea name="bpk_supaddress" id="bpk_supaddress"  readonly
                          class="form-control input-large upper"></textarea>
            </div>
        </div>
    </div>
    <div id="agac" style="display: none;">
        <div class="form-group">
            <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Cabang</label>
            <div class="col-sm-3">
                <input type="text" maxlength="8"
                       name="bpk_cabnama" id="bpk_cabnama"  class="form-control input-xlarge upper" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Kode Cabang</label>
            <div class="col-sm-3">
                <input type="text" maxlength="8" readonly
                       name="bpk_cabang" id="bpk_cabang"  class="form-control input-xlarge upper" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Alamat Cabang</label>
            <div class="col-sm-3">
                <textarea name="bpk_supaddress" id="bpk_supaddress" readonly
                          class="form-control input-large upper"></textarea>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">No. Delivery Order</label>
        <div class="col-sm-3">
            <input type="text"  maxlength="50" name="bpk_nodo" id="bpk_nodo"  placeholder ="NO. DO"
                   class="form-control input-xlarge upper" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Tgl. Delivery Order</label>
        <div class="col-sm-3">
            <div class="input-group">
                <input type="text" id="bpk_tgldo" name="bpk_tgldo" required="required" readonly="readonly" placeholder ="TGL. DO"
                       class="form-control datepicker input-small" data-date-format="dd-mm-yyyy" />
                <span class="input-group-addon">
                    <i class="fa fa-calendar bigger-110"></i>
                </span>
                </span>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">No. Purchase Order</label>
        <div class="col-sm-3">
            <input type="text" maxlength="50" placeholder ="NO. PO" 
                   name="bpk_nopo" id="bpk_nopo"  class="form-control input-xlarge upper" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Tgl. Purchase Order</label>
        <div class="col-sm-3">
            <div class="input-group">
                <input type="text" id="bpk_tglpo" name="bpk_tglpo" required="required" readonly="readonly" placeholder ="TGL. PO"
                       class="form-control datepicker input-small" data-date-format="dd-mm-yyyy" />
                <span class="input-group-addon">
                    <i class="fa fa-calendar bigger-110"></i>
                </span>
                </span>
            </div>
        </div>
    </div>
    <div class="page-header">
        <h1>
            <small>
                HPP
            </small>
        </h1>
    </div>
    <div id="hpp" style="display: block;"> 
        <div class="form-group">
            <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Hpp</label>
            <div class="col-sm-3">
                <input type="text" name="bpk_hpp" style="text-align: right;" id="bpk_hpp" onchange="$('#'+this.id).val(formatDefault(this.value));" value="0" class="form-control input-xlarge number req" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Facility Fund</label>
            <div class="col-sm-3">
                <input type="text" name="bpk_ff" style="text-align: right;" id="bpk_ff" onchange="$('#'+this.id).val(formatDefault(this.value));" value="0" class="form-control input-xlarge number req" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Deposit Promosi</label>
            <div class="col-sm-3">
                <input type="text" name="bpk_deposit_promosi" style="text-align: right;" onchange="$('#'+this.id).val(formatDefault(this.value));" id="bpk_deposit_promosi" value="0" class="form-control input-xlarge number req" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label no-padding-right" for="form-field-1">PPn BM</label>
            <div class="col-sm-3">
                <input type="text" name="bpk_ppnbm" style="text-align: right;" id="bpk_ppnbm" onchange="$('#'+this.id).val(formatDefault(this.value));" value="0" class="form-control input-xlarge number req" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Pph 22</label>
            <div class="col-sm-3">
                <input type="text"  name="bpk_pph22" style="text-align: right;" id="bpk_pph22" onchange="$('#'+this.id).val(formatDefault(this.value));" value="0" class="form-control input-xlarge number req" />
            </div>
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
    numberOnly();
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
                    if(data.result){
                        var params  = 'width='+screen.width;
                        params += ', height='+screen.height;
                        params += ', fullscreen=yes,scrollbars=yes';
                        window.open("<?php echo site_url("transaksi_sales/printBpk"); ?>/"+data.kode,'_blank', params);
                        $('.page-content-area').ace_ajax('loadUrl', "#transaksi_sales/addBpk", false);
                    }
                    else
                        $("#result").html(data.msg).show().fadeIn("slow");
                }
            })
            return false;
        });

    });
    
    $(this).ready(function() {
        
        
        $("#bpk_supnama").autocomplete({
            minLength: 1,
            source: function(req, add) {
                $.ajax({
                    url: '<?php echo site_url('master_sparepart/jsonSupplier'); ?>',
                    dataType: 'json',
                    type: 'POST',
                    data: {param : $("#bpk_supnama").val()},
                    success: function(data) {
                        add(data.message);
                    }
                });
            },
            create: function () {
                $(this).data('ui-autocomplete')._renderItem = function (ul, item) {
                    return $('<li>')
                    .append("<a><strong>" + item.value + "</strong><br>" + item.desc + "</a>")
                    .appendTo(ul);
                };
            },
            select: function(event, ui) {
                $("#bpk_supid").val(ui.item.supid);
                $("#bpk_supaddress").val(ui.item.desc);
            }
        })
        
        $("#bpk_norangka").autocomplete({
            minLength: 1,
            source: function(req, add) {
                $.ajax({
                    url: '<?php echo site_url('transaksi_sales/autoRangkaUnit'); ?>',
                    dataType: 'json',
                    type: 'POST',
                    data: {param : $("#bpk_norangka").val()},
                    success: function(data) {
                        add(data.message);
                    }
                });
            },
            select: function(event, ui) {
                $("#prosid").val(ui.item.prosid);
                $('.page-content-area').ace_ajax('startLoading');
                $.ajax({
                    url: '<?php echo site_url('transaksi_sales/jsonDataStock'); ?>',
                    dataType: 'json',
                    type: 'POST',
                    data: {
                        param : ui.item.value
                    },
                    success: function(data) {
                        if (data == null) {
                            $("#bpk_mscid").val('');
                            $("#bpk_nomesin").val('');
                            $("#bpk_merk").val('');
                            $("#bpk_type").val('');
                            $("#bpk_kondisi").val('');
                            $("#bpk_vinlot").val('');
                            $("#bpk_bodyseri").val('');
                        }else{
                            $("#bpk_mscid").val(data['mscid']);
                            $("#bpk_nomesin").val(data['msc_nomesin']);
                            $("#bpk_merk").val(data['merk_deskripsi']);
                            $("#bpk_type").val(data['cty_deskripsi']);
                            $("#bpk_kondisi").val(data['msc_kondisi']);
                            $("#bpk_vinlot").val(data['msc_vinlot']);
                            $("#bpk_bodyseri").val(data['msc_bodyseri']);
                        }
                        $('.page-content-area').ace_ajax('stopLoading', true);
                    }
                });
            }
        })
        
    });
    var scripts = [null, null]
    $('.page-content-area').ace_ajax('loadScripts', scripts, function() {
        //inline scripts related to this page
    });
</script> 