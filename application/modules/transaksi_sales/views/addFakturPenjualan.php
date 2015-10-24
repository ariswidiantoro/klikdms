<link rel="stylesheet" href="<?php echo path_css(); ?>select2.css" />
<div class="row">
    <div class="col-xs-12">
        <div class="widget-box">
            <!--            <div class="widget-header widget-header-blue widget-header-flat">
                            <h4 class="widget-title lighter">Tambah Faktur Penjualan</h4>
                        </div>-->

            <div class="widget-body">
                <div class="widget-main">
                    <!-- #section:plugins/fuelux.wizard -->
                    <div id="fuelux-wizard-container">
                        <div>
                            <!-- #section:plugins/fuelux.wizard.steps -->
                            <ul class="steps">
                                <li data-step="1" class="active">
                                    <span class="step">1</span>
                                    <span class="title">Info Kendaraan & Pelanggan</span>
                                </li>
                                <li data-step="2">
                                    <span class="step">2</span>
                                    <span class="title">Harga & Pembayaran</span>
                                </li>
                            </ul>
                        </div>
                        <hr />
                        <!-- #section:plugins/fuelux.wizard.container -->
                        <div class="step-content pos-rel">
                            <form class="form-horizontal" id="validation-form" method="get">
                                <div class="step-pane active" data-step="1">
                                    <table style="width: 100%">
                                        <tr>
                                            <td  style="width: 48%">
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1">No Faktur</label>
                                                    <div class="col-sm-7">
                                                        <input type="text" required autofocus name="fkp_nofaktur" id="fkp_nofaktur"  
                                                               class="ace col-xs-10 col-sm-10 upper req" />
                                                    </div>
                                                </div>  
                                            </td>
                                            <td  style="width: 48%">
                                                &nbsp;
                                            </td>
                                        </tr>
                                        <tr>
                                            <td  style="width: 48%">
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1">No Spk</label>
                                                    <div class="col-sm-7">
                                                        <input type="text" required="required" name="spk_no" id="spk_no"  
                                                               class="ace col-xs-10 col-sm-7 upper req"  />
                                                        <input type="hidden" name="fkp_spkid" id="fkp_spkid">
                                                        <input type="hidden" name="fpk_mscid" id="fpk_mscid">
                                                    </div>
                                                </div>  
                                            </td>
                                            <td  style="width: 48%">
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1">No Rangka</label>
                                                    <div class="col-sm-7">
                                                        <input type="text" required="required" name="fkp_norangka" id="fkp_norangka"  
                                                               class="ace col-xs-10 col-sm-10 upper req"  />

                                                    </div>
                                                </div>  
                                            </td>
                                        </tr>
                                        <tr>
                                            <td  style="width: 48%">
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1">No Kontrak</label>
                                                    <div class="col-sm-7">
                                                        <input type="text" readonly name="spk_nokontrak" id="spk_nokontrak"  
                                                               class="ace col-xs-10 col-sm-7 upper req"  />
                                                    </div>
                                                </div>  
                                            </td>
                                            <td  style="width: 48%">
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1">No Mesin</label>
                                                    <div class="col-sm-7">
                                                        <input type="text" readonly id="nomesin"  
                                                               class="ace col-xs-10 col-sm-10 upper req"  />
                                                    </div>
                                                </div>  
                                            </td>
                                        </tr>
                                        <tr>
                                            <td  style="width: 48%">
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Nama Sales</label>
                                                    <div class="col-sm-7">
                                                        <input type="text" readonly name="spk_salesman" id="spk_salesman"  
                                                               class="ace col-xs-10 col-sm-10 upper req"  />
                                                    </div>
                                                </div>  
                                            </td>
                                            <td  style="width: 48%">
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Merk</label>
                                                    <div class="col-sm-7">
                                                        <input type="text" readonly name="merk" id="merk"  
                                                               class="ace col-xs-10 col-sm-10 upper req"  />
                                                    </div>
                                                </div>  
                                            </td>
                                        </tr>
                                        <tr>
                                            <td  style="width: 48%">
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Nama Pelanggan</label>
                                                    <div class="col-sm-7">
                                                        <input type="text" readonly name="pel_nama"  id="pel_nama" 
                                                               class="ace col-xs-10 col-sm-10 upper req"  />
                                                    </div>
                                                </div>  
                                            </td>
                                            <td  style="width: 48%">
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Type Kendaraan</label>
                                                    <div class="col-sm-7">
                                                        <input type="text" readonly id="cty_deskripsi"  
                                                               class="ace col-xs-10 col-sm-10 upper req"  />
                                                    </div>
                                                </div>  
                                            </td>
                                        </tr>
                                        <tr>
                                            <td  style="width: 48%">
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Alamat Pelanggan</label>
                                                    <div class="col-sm-7">
                                                        <textarea name="pel_alamat" id="pel_alamat" readonly class="ace col-xs-10 col-sm-10 upper">
                                                        </textarea>
                                                    </div>
                                                </div>  
                                            </td>
                                            <td  style="width: 48%">
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Warna</label>
                                                    <div class="col-sm-7">
                                                        <input type="text" readonly name="warna" id="warna"  
                                                               class="ace col-xs-10 col-sm-10 upper req"  />
                                                    </div>
                                                </div> 
                                            </td>
                                        </tr>
                                        <tr>
                                            <td  style="width: 48%">
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Nama Bpkb</label>
                                                    <div class="col-sm-7">
                                                        <input type="text" required="required" name="fkp_namabpkb"  id="fkp_namabpkb" 
                                                               class="ace col-xs-10 col-sm-10 upper req"  />
                                                    </div>
                                                </div>  
                                            </td>
                                            <td  style="width: 48%">
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Kondisi</label>
                                                    <div class="col-sm-7">
                                                        <input type="text" readonly id="kondisi"  
                                                               class="ace col-xs-10 col-sm-10 upper req"  />
                                                    </div>
                                                </div> 
                                            </td>
                                        </tr>
                                        <tr>
                                            <td  style="width: 48%">
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Alamat Bpkb</label>
                                                    <div class="col-sm-7">
                                                        <textarea name="fkp_alamat_bpkb" id="fkp_alamat_bpkb" class="ace col-xs-10 col-sm-10 upper">
                                                        </textarea>
                                                    </div>
                                                </div>  
                                            </td>
                                            <td  style="width: 48%">
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Warna Plat</label>
                                                    <div class="col-sm-7">
                                                        <select required class="ace col-xs-10 col-sm-7 upper req">
                                                            <option value="">PILIH</option>
                                                            <option value="HITAM">HITAM</option>
                                                            <option value="KUNING">KUNING</option>
                                                            <option value="MERAH">MERAH</option>
                                                        </select>
                                                    </div>
                                                </div> 
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                                <div class="step-pane" data-step="2">

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Harga Kosong</label>
                                        <div class="col-sm-8">
                                            <div class="input-group col-sm-6">
                                                <input type="text" name="byr_hargako" id="byr_hargako" style="text-align: right;" value="0" onchange="$('#'+this.id).val(formatDefault(this.value));" onkeyup="total()"  class="form-control harga number upper" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">BBN</label>
                                        <div class="col-sm-8">
                                            <div class="input-group col-sm-6">
                                                <input type="text" name="byr_bbn" id="byr_bbn" style="text-align: right;" value="0" onchange="$('#'+this.id).val(formatDefault(this.value));" onkeyup="total()"  class="form-control harga number upper" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Asuransi</label>
                                        <div class="col-sm-8">
                                            <div class="input-group col-sm-6">
                                                <input type="text" name="byr_asuransi" id="byr_asuransi" style="text-align: right;" value="0" onchange="$('#'+this.id).val(formatDefault(this.value));" onkeyup="total()"  class="form-control harga number upper" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Aksesories</label>
                                        <div class="col-sm-8">
                                            <div class="input-group col-sm-6">
                                                <input type="text" name="byr_aksesoris" id="byr_aksesoris" style="text-align: right;" value="0" onchange="$('#'+this.id).val(formatDefault(this.value));" onkeyup="total()" class="form-control harga number upper" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Karoseri</label>
                                        <div class="col-sm-8">
                                            <div class="input-group col-sm-6">
                                                <input type="text" name="byr_karoseri" id="byr_karoseri" style="text-align: right;" value="0" onchange="$('#'+this.id).val(formatDefault(this.value));" onkeyup="total()"  class="form-control harga number upper" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Administrasi</label>
                                        <div class="col-sm-8">
                                            <div class="input-group col-sm-6">
                                                <input type="text" name="byr_admin" id="byr_admin" style="text-align: right;" value="0" onchange="$('#'+this.id).val(formatDefault(this.value));" onkeyup="total()"  class="form-control harga number upper" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Lain-Lain</label>
                                        <div class="col-sm-8">
                                            <div class="input-group col-sm-6">
                                                <input type="text" name="byr_lain" id="byr_lain" style="text-align: right;" value="0" onchange="$('#'+this.id).val(formatDefault(this.value));" onkeyup="total()"  class="form-control harga number upper" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"><b>TOTAL HARGA</b></label>
                                        <div class="col-sm-8">
                                            <div class="input-group col-sm-6">
                                                <input type="text" name="byr_total" id="byr_total" style="text-align: right;font-weight: bold" value="0" readonly  class="form-control number upper" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="hr hr-16 hr-dotted"></div>
                                    <div class="space-2"></div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Cashback</label>
                                        <div class="col-sm-8">
                                            <div class="input-group col-sm-6">
                                                <input type="text" name="byr_cashback" readonly id="byr_cashback" style="text-align: right;" value="0" onchange="$('#'+this.id).val(formatDefault(this.value));" class="form-control number upper" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Diskon</label>
                                        <div class="col-sm-8">
                                            <div class="input-group col-sm-6">
                                                <input type="text" name="byr_diskon" readonly id="byr_diskon" style="text-align: right;" value="0" onchange="$('#'+this.id).val(formatDefault(this.value));" class="form-control number upper" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="hr hr-16 hr-dotted"></div>
                                    <div class="space-2"></div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Uang Muka</label>
                                        <div class="col-sm-8">
                                            <div class="input-group col-sm-6">
                                                <input type="text" name="byr_um" id="byr_um" readonly style="text-align: right;" value="0" onchange="$('#'+this.id).val(formatDefault(this.value));" class="form-control number upper" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="hr hr-16 hr-dotted"></div>
                                    <div class="space-2"></div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Jumlah Dibayar Pelanggan</label>
                                        <div class="col-sm-8">
                                            <div class="input-group col-sm-6">
                                                <input type="text" name="byr_cashback" id="byr_cashback" style="text-align: right;" value="0" onchange="$('#'+this.id).val(formatDefault(this.value));" class="form-control number upper" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"><b>Sisa Pembayaran</b></label>
                                        <div class="col-sm-8">
                                            <div class="input-group col-sm-6">
                                                <input type="text" name="byr_diskon" readonly id="byr_diskon" style="text-align: right;font-weight: bold" value="0" onchange="$('#'+this.id).val(formatDefault(this.value));" class="form-control number upper" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <hr />
                    <div class="wizard-actions">
                        <!-- #section:plugins/fuelux.wizard.buttons -->
                        <button class="btn btn-prev">
                            <i class="ace-icon fa fa-arrow-left"></i>
                            Prev
                        </button>

                        <button class="btn btn-success btn-next" data-last="Finish">
                            Next
                            <i class="ace-icon fa fa-arrow-right icon-on-right"></i>
                        </button>

                        <!-- /section:plugins/fuelux.wizard.buttons -->
                    </div>

                    <!-- /section:plugins/fuelux.wizard -->
                </div><!-- /.widget-main -->
            </div><!-- /.widget-body -->
        </div>

        <!-- PAGE CONTENT ENDS -->
    </div><!-- /.col -->
</div><!-- /.row -->
<script src="<?php echo path_js(); ?>ace/elements.wizard.js"></script>
<script src="<?php echo path_js(); ?>fuelux/fuelux.wizard.js"></script>
<!--<script src="<?php echo path_js(); ?>select2.js"></script>-->
<script src="<?php echo path_js(); ?>jquery.validate.js"></script>
<!--<script src="<?php echo path_js(); ?>additional-methods.js"></script>-->
<script type="text/javascript">
    numberOnly();
    var scripts = [null];
    $('.page-content-area').ace_ajax('loadScripts', scripts, function() {
        //inline scripts related to this page
        jQuery(function($) {
            $('[data-rel=tooltip]').tooltip();
            var $validation = true;
            $('#fuelux-wizard-container')
            .ace_wizard({
                //step: 2 //optional argument. wizard will jump to step "2" at first
                //buttons: '.wizard-actions:eq(0)'
            })
            .on('actionclicked.fu.wizard' , function(e, info){
                if(info.step == 1 && $validation) {
                    if(!$('#validation-form').valid()) e.preventDefault();
                }
            })
            .on('finished.fu.wizard', function(e) {
                bootbox.dialog({
                    message: "Thank you! Your information was successfully saved!", 
                    buttons: {
                        "success" : {
                            "label" : "OK",
                            "className" : "btn-sm btn-primary"
                        }
                    }
                });
            }).on('stepclick.fu.wizard', function(e){
                //e.preventDefault();//this will prevent clicking and selecting steps
            });
	
            $('#validation-form').validate({
                errorElement: 'div',
                errorClass: 'help-block',
                focusInvalid: false,
                ignore: "",
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
                    else if(element.is('.select2')) {
                        error.insertAfter(element.siblings('[class*="select2-container"]:eq(0)'));
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
		
            $(document).one('ajaxloadstart.page', function(e) {
                //in ajax mode, remove remaining elements before leaving page
            });
            $("#spk_no").autocomplete({
                minLength: 1,
                source: function(req, add) {
                    $.ajax({
                        url: '<?php echo site_url('transaksi_sales/autoSpk'); ?>',
                        dataType: 'json',
                        type: 'POST',
                        data: {
                            param : $("#spk_no").val(),
                            approve : 1
                        },
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
                            $("#spk_nokontrak").val(data['spk_nokontrak']);
                            $("#pel_alamat").html(data['pel_alamat']);
                            $("#pel_alamatbpkb").html(data['pel_alamat']);
                            $("#fkp_spkid").val(data['spkid']);
                            $("#fkp_alamat_bpkb").html(data['pel_alamat']);
                            $("#fkp_namabpkb").val(data['pel_nama']);
                            $("#pel_nama").val(data['pel_nama']);
                            $("#spk_salesman").val(data['kr_nama']);
                            
                            $("#byr_diskon").val(formatDefaultTanpaDecimal(data['fpt_diskon']));
                            $("#byr_cashback").val(formatDefaultTanpaDecimal(data['fpt_cashback']));
                            $("#byr_um").val(formatDefaultTanpaDecimal(data['spk_uangmuka']));
                            $("#byr_hargako").val(formatDefaultTanpaDecimal(data['fpt_hargako']));
                            $("#byr_bbn").val(formatDefaultTanpaDecimal(data['fpt_bbn']));
                            $("#byr_asuransi").val(formatDefaultTanpaDecimal(data['fpt_asuransi']));
                            $("#byr_admin").val(formatDefaultTanpaDecimal(data['fpt_administrasi']));
                            $("#byr_total").val(formatDefaultTanpaDecimal(Number(data['fpt_total'])-Number(data['spk_uangmuka'])));
                            $('.page-content-area').ace_ajax('stopLoading', true);
                        }
                    });
                }
            });
            
            $("#fkp_norangka").autocomplete({
                minLength: 1,
                source: function(req, add) {
                    $.ajax({
                        url: '<?php echo site_url('transaksi_sales/autoRangkaUnit'); ?>',
                        dataType: 'json',
                        type: 'POST',
                        data: {
                            param : $("#bpk_norangka").val(),
                            ready_stock : 1
                        },
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
                                $("#fkp_mscid").val(data['mscid']);
                                $("#nomesin").val(data['msc_nomesin']);
                                $("#merk").val(data['merk_deskripsi']);
                                $("#cty_deskripsi").val(data['cty_deskripsi']);
                                $("#kondisi").val(data['msc_kondisi']);
                                $("#warna").val(data['warna_deskripsi']);
                            }
                            $('.page-content-area').ace_ajax('stopLoading', true);
                        }
                    });
                }
            })
            
        })
    });
</script>