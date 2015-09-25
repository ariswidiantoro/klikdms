<style type="text/css">
    input:required {
        box-shadow: 4px 4px 20px rgba(200, 0, 0, 0.85);

    }
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
<script type="text/javascript">
    function Delete() {
        var par = $(this).parent().parent(); //tr
        par.remove();
        totalLc();
    }
    function addRow() {
        var inc = $('.nomorjasa').length+1;
        $(".item-row:last").after(
        '<tr class="item-row">\n\
                    <td class="nomorjasa center">' + inc + '<input type="hidden" name="no[]" id="no'+ inc +'"  /></td>\n\
                         <td>\n\
                             <input type="text"  autocomplete="off" onkeyup="autoCompleteJasa(' + inc + ')" class="upper ace col-xs-10 col-sm-10" style="width:100%;" id="dinv_kode'+ inc +'"  name="dinv_kode[]" />\n\
                            <input type="hidden" id="dinv_flatid'+ inc +'"  name="dinv_flatid[]" />\n\
                         </td>\n\
                         <td>\n\
                                <input type="text"  readonly="readonly"  class="upper ace col-xs-10 col-sm-10" style="width:100%;"  name="flat_desk[]" id="flat_desk'+ inc +'" />\n\
                        </td>\n\
                        <td>\n\
                            <input type="text"  readonly="readonly"  class="upper ace col-xs-10 col-sm-10" style="width:100%;text-align: right"  name="flat_lc[]" id="flat_lc'+ inc +'" />\n\
                         </td>\n\
                         <td>\n\
                             <input type="text"  autocomplete="off" value="0" onkeyup="subTotal('+inc+')"  class="upper ace col-xs-10 col-sm-10" style="width:100%;"  name="dinv_diskon[]" id="dinv_diskon'+ inc +'" />\n\
                         </td>\n\
                         <td>\n\
                             <input type="text"  readonly="readonly"  class="upper ace col-xs-10 col-sm-10" style="width:100%;text-align: right"  name="dinv_subtotal[]" id="dinv_subtotal'+ inc +'" />\n\
                         </td>\n\
                         <td  class="center">\n\
                             <a class="green btnAdd"  onclick="addRow()" href="javascript:;"><i class="ace-icon fa fa-search-plus bigger-130"></i></a>\n\
                         </td>\n\
                         <td style="text-align: center">\n\
                             <a class="red btnDelete" href="javascript:;"><i class="ace-icon fa fa-trash-o bigger-130"></i></a>\n\
                         </td>\n\
                       </tr>\n\
                    </tr>');
                                 $(".btnDelete").bind("click", Delete);
                                 numberOnly();
                             }
</script>
<div id="result"></div>
<form class="form-horizontal" id="form" method="post" action="<?php echo site_url('transaksi_service/saveFakturService'); ?>" name="form">
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nomor WO</label>
        <div class="col-sm-8">
            <div class='input-group col-xs-10 col-sm-10'>
                <input type="text" required="required" onchange="//getDataWo($(this).val())" name="wo" id="wo" class="upper ace col-xs-10 col-sm-3 req" />
                <input type="hidden" name="inv_woid" id="inv_woid"/>
                <input type="hidden" name="inv_inextern" id="inv_inextern"/>
                <input type="hidden"  id="wo_type" name="wo_type"/>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nomor Polisi</label>
        <div class="col-sm-8">
            <input type="text" readonly="readonly" name="msc_nopol" id="msc_nopol" class="col-xs-10 col-sm-3" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nama Pelanggan</label>
        <div class="col-sm-8">
            <input type="text" readonly="readonly" name="pel_nama" id="pel_nama" class="col-xs-10 col-sm-5" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Km</label>
        <div class="col-sm-8">
            <input type="text" name="wo_km" id="wo_km" class="number col-xs-10 col-sm-2" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Final Checker</label>
        <div class="col-sm-8">
            <div class='input-group col-xs-10 col-sm-10'>
                <select name="inv_fchecker" id="inv_fchecker" required="required" class="ace col-xs-10 col-sm-3 upper req">
                    <option value="">Pilih</option>
                    <?php
                    if (count($checker) > 0) {
                        foreach ($checker as $value) {
                            ?>
                            <option value="<?php echo $value['krid']; ?>"><?php echo $value['kr_nama'] ?></option> 
                            <?php
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Kasir</label>
        <div class="col-sm-8">
            <div class='input-group col-xs-10 col-sm-10'>
                <select name="inv_kasir" id="inv_kasir" required="required" class="ace col-xs-10 col-sm-3 upper req">
                    <option value="">Pilih</option>
                    <?php
                    if (count($kasir) > 0) {
                        foreach ($kasir as $value) {
                            ?>
                            <option value="<?php echo $value['krid']; ?>"><?php echo $value['kr_nama'] ?></option> 
                            <?php
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Catatan</label>
        <div class="col-sm-8">
            <input type="text" name="inv_catatan" id="inv_catatan" class="col-xs-10 col-sm-10" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Tampilkan PPN di cetakan</label>
        <div class="col-sm-8">
            <div class='input-group col-xs-10 col-sm-10'>
                <select name="inv_tampil_ppn" id="inv_tampil_ppn" required="required" class="ace col-xs-10 col-sm-3 upper req">
                    <option value="">Pilih</option>
                    <option value="1">Ya</option>
                    <option value="0">Tidak</option>
                </select>
            </div>
        </div>
    </div>
    <div class="hr hr-16 hr-dotted"></div>
    <div id="jasa">
        <div class="table-header">
            Daftar JASA
        </div>
        <div>
            <table id="simple-table-jasa" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th style="width: 2%">No</th>
                        <th style="width: 10%">Kode Jasa</th>
                        <th style="width: 20%">Nama Jasa</th>
                        <th style="width: 10%">Rate</th>
                        <th style="width: 5%">Diskon %</th>
                        <th style="width: 10%">Sub Total</th>
                        <th style="width: 5%">Add</th>
                        <th style="width: 5%">Hapus</th>
                    </tr>
                </thead>

                <tbody>
                    <tr  class="item-row">
                        <td class="nomorjasa" style="text-align: center;">
                            1
                        </td>
                        <td>
                            <input type="text"  autocomplete="off" onkeyup="autoCompleteJasa('1')"  class="upper ace col-xs-10 col-sm-10" style="width:100%;" id="dinv_kode1"  name="dinv_kode[]" />
                            <input type="hidden" id="dinv_flatid1"  name="dinv_flatid[]" />
                        </td>
                        <td>
                            <input type="text"  readonly="readonly"  class="upper ace col-xs-10 col-sm-10" style="width:100%;"  name="flat_desk[]" id="flat_desk1" />
                        </td>
                        <td>
                            <input type="text"  readonly="readonly"  class="ace col-xs-10 col-sm-10" style="width:100%;text-align: right"  name="flat_lc[]" id="flat_lc1" />
                        </td>
                        <td>
                            <input type="text"  autocomplete="off" value="0" onkeyup="subTotal('1')" class="number ace col-xs-10 col-sm-10" style="width:100%;"  name="dinv_diskon[]" id="dinv_diskon1" />
                        </td>
                        <td>
                            <input type="text"  readonly="readonly"  class="ace col-xs-10 col-sm-10" style="width:100%;text-align: right"  name="dinv_subtotal[]" id="dinv_subtotal1" />
                        </td>
                        <td class="center">
                            <a class="green btnAdd"  onclick="addRow()" href="javascript:;"><i class="ace-icon fa fa-search-plus bigger-130"></i></a>
                        </td>
                        <td  class="center">
                            <a class="red btnDelete" href="javascript:;"><i class="ace-icon fa fa-trash-o bigger-130"></i></a>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="5" style="text-align: right">
                            TOTAL
                        </th>
                        <th>
                            <input type="text" readonly="readonly" style="width: 100%;text-align: right;" value="0" name="total_row_lc" id="total_row_lc" class="col-xs-10 col-sm-10" />  
                        </th>
                        <th class="center">
                            &nbsp;
                        </th>
                        <th  class="center">
                            &nbsp;
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <div class="table-header">
        TOTAL
    </div>
    <div>
        <table id="simple-table" class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th style="width: 15%">TOTAL JASA</th>
                    <th style="width: 15%">TOTAL OLI</th>
                    <th style="width: 15%">TOTAL SPAREPART</th>
                    <th style="width: 15%">TOTAL SUB MATERIAL</th>
                    <th style="width: 15%">TOTAL SUB ORDER</th>
                    <th style="width: 25%">GRAND TOTAL</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td>
                        <input type="text" readonly="readonly" style="width: 100%;text-align: right;" value="0" name="total_lc" id="total_lc" class="spp_total col-xs-10 col-sm-10" /> 
                    </td>
                    <td>
                        <input type="text" readonly="readonly" style="width: 100%;text-align: right;" value="0" name="total_ol" id="total_ol" class="spp_total col-xs-10 col-sm-10" />  
                        <input type="hidden" value="0" name="total_ol_hpp" id="total_ol_hpp"/>  
                    </td>
                    <td>
                        <input type="text" readonly="readonly" style="width: 100%;text-align: right;" value="0" name="total_sp" id="total_sp" class="spp_total col-xs-10 col-sm-10" />  
                        <input type="hidden" value="0" name="total_sp_hpp" id="total_sp_hpp"/> 
                    </td>
                    <td>
                        <input type="text" readonly="readonly" style="width: 100%;text-align: right;" value="0" name="total_sm" id="total_sm" class="spp_total col-xs-10 col-sm-10" />   
                        <input type="hidden" value="0" name="total_sm_hpp" id="total_sm_hpp"/> 
                    </td>
                    <td>
                        <input type="text" readonly="readonly" style="width: 100%;text-align: right;" value="0" name="total_so" id="total_so" class="spp_total col-xs-10 col-sm-10" />
                        <input type="hidden" value="0" name="total_so_hpp" id="total_so_hpp"/> 
                    </td>
                    <td>
                        <input type="text" readonly="readonly" style="width: 100%;text-align: right;" value="0" name="grand_total" id="grand_total" class="spp_total col-xs-10 col-sm-10" />
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="clearfix form-actions">
        <div class="col-md-offset-1 col-md-5">
            <button class="btn btn-info" id="button" type="button">
                <i class="ace-icon fa fa-check bigger-50"></i>
                Submit
            </button>

            &nbsp; &nbsp; &nbsp;
            <button class="btn" type="reset">
                <i class="ace-icon fa fa-undo bigger-50"></i>
                Reset
            </button>
        </div>
    </div>
</form>
<script type="text/javascript">
    var scripts = [null, null]

    $("#button").prop('disabled', true);
    //called when key is pressed in textbox
    $(".number").keypress(function (e) {
        if (e.which != 8 && e.which != 47 && e.which != 0 && (e.which < 46 || e.which > 57)){
            return false;
        }
    });
    
    function clearForm()
    {
        var otable = document.getElementById('simple-table-jasa');
        var counti = otable.rows.length - 2;
        while (counti > 1) {
            otable.deleteRow(counti);
            counti--;
        }
    }
    
    jQuery(function($) {
        $('#button').on('click', function(e){
            if(!$('#form').valid())
            {
                e.preventDefault();
            }else
                bootbox.confirm("Anda yakin data sudah benar ?", function(result) {
                    if(result) {
                        $("#form").submit();
                    }
            });
            return false;
        });
        $('#form').validate({
            errorElement: 'div',
            errorClass: 'help-block',
            focusInvalid: false,
            ignore: "",
            rules: {
            },
			
            messages: {
            },
			
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
    
    
    $(document).ready(function(){
        $('#form').submit(function() {
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                dataType: "json",
                async: false,
                data: $(this).serialize(),
                success: function(data) {
                    window.scrollTo(0, 0);
                    if (data.result) {
                        var params  = 'width=1000';
                        params += ', height='+screen.height;
                        params += ', fullscreen=yes,scrollbars=yes';
                        document.form.reset();
                        clearForm();
                        //                        window.open("<?php echo site_url("transaksi_service/printWo"); ?>/"+data.kode,'_blank', params);
                    }
                    $("#result").html(data.msg).show().fadeIn("slow");
                }
            })
        });
        
        $("#wo").autocomplete({
            minLength: 1,
            source: function(req, add) {
                $.ajax({
                    url: '<?php echo site_url('transaksi_service/jsonWoBelumInvoiceAuto'); ?>',
                    dataType: 'json',
                    type: 'POST',
                    data: {
                        param : $("#wo").val()
                    },
                    success: function(data) {
                        add(data.message);
                    }
                });
            },
            create: function () {
                $(this).data('ui-autocomplete')._renderItem = function (ul, item) {
                    return $('<li>')
                    .append("<a><strong>" + item.value + "</strong><br> Nopol : " + item.desc + "</a>")
                    .appendTo(ul);
                };
            },select: function(event, ui) {
                getDataWo(ui.item.value, ui.item.type);
            }
        });
    });
    
    function totalLc()
    {
        var total = 0;
        var price;
        $("input[name^=dinv_subtotal]").each(function() {
            price = $(this).val().replace(/,/g, "");
            total += Number(price);
        });
        $("#total_row_lc").val(formatDefault(total));
        $("#total_lc").val(formatDefault(total));
        grandTotal();
    }
    
    function subTotal(inc) {
        var harga = cekDefaultNol($("#flat_lc"+inc).val().replace(/,/g, ""));
        var diskon = cekDefaultNol($("#dinv_diskon"+inc).val().replace(/,/g, ""));
        var subtotal = harga *((100-diskon)/100);
        $("#dinv_subtotal"+inc).val(formatDefault(subtotal));
        totalLc();
    }
    
    function grandTotal()
    {
        var lc = cekDefaultNol($("#total_lc").val().replace(/,/g, ""));
        var ol = cekDefaultNol($("#total_ol").val().replace(/,/g, ""));
        var sm = cekDefaultNol($("#total_sm").val().replace(/,/g, ""));
        var so = cekDefaultNol($("#total_so").val().replace(/,/g, ""));
        var sp = cekDefaultNol($("#total_sp").val().replace(/,/g, ""));
        $("#grand_total").val(formatDefault(parseFloat(lc)+parseFloat(ol)+parseFloat(sm)+parseFloat(so)+parseFloat(sp)));
    }
    
    function getDataWo(wo, type){
        $('.page-content-area').ace_ajax('startLoading');
        clearForm();
        getJsonWo(wo);  
        getJasa(wo,type);
        getTotalSupply(wo,type);
        $('.page-content-area').ace_ajax('stopLoading', true);
    };
    
    function getJasa(wo, type)
    {
        //        document.getElementById("sparepart").style.display = '';
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('transaksi_service/getJasaWoByWoNomer'); ?>',
            dataType: "json",
            async: false,
            data: {
                wo : wo
            },
            success: function(data) {
                if (data.length > 0) {
                    for (var i = 0; i < data.length; i++) {
                        if (data[i]['flatid'] != '') {
                            $("#dinv_kode" + (i + 1)).val(data[i]['flat_kode']);
                            $("#dinv_flatid" + (i + 1)).val(data[i]['flatid']);
                            $("#flat_desk" + (i + 1)).val(data[i]['flat_deskripsi']);
                            $("#flat_lc" + (i + 1)).val(formatDefault(data[i]['flat_lc']));
                            $("#dinv_subtotal" + (i + 1)).val(formatDefault(data[i]['flat_lc']));
                            // JIKA 2(FREE SERVIC) MAKA total supply diambil
                            if (type == '2') {
                                $("#total_ol").val(formatDefault(data[i]['flat_oli']));
                                $("#total_sp").val(formatDefault(data[i]['flat_part']));
                                $("#total_so").val(formatDefault(data[i]['flat_so']));
                                $("#total_sm").val(formatDefault(data[i]['flat_sm']));
                            }else{
                                addRow();
                            }
                            totalLc();
                        }
                    }
                }
            }
        }) 
    }
    
    function getJsonWo(wo)
    {
        $.ajax({
            url: '<?php echo site_url('transaksi_service/jsonWo'); ?>',
            dataType: 'json',
            type: 'POST',
            data: {param : wo},
            success: function(data) {
                if (data['response']) {
                    if (data['clo_status'] == 0) {
                        bootbox.dialog({
                            message: "<span class='bigger-110'>Silahkan Clock On Mekanik</span>",
                            buttons: 			
                                {
                                "button" :
                                    {
                                    "label" : "Ok",
                                    "className" : "btn-sm info"
                                }
                            }
                        });
                        $("#msc_nopol").val("");
                        $("#wo_km").val(0);
                        $("#pel_nama").val("");
                        $("#inv_woid").val("");
                        document.form.reset();
                        clearForm();
                        return false;
                    }else if (data['clo_status'] == 1) {
                        bootbox.dialog({
                            message: "<span class='bigger-110'>Silahkan Clock Off Mekanik</span>",
                            buttons: 			
                                {
                                "button" :
                                    {
                                    "label" : "Ok",
                                    "className" : "btn-sm info"
                                }
                            }
                        });
                        $("#msc_nopol").val("");
                        $("#wo_km").val(0);
                        $("#pel_nama").val("");
                        $("#inv_woid").val("");
                        document.form.reset();
                        clearForm();
                        return false;
                    }else if (data['clo_status'] == 2) {
                        bootbox.dialog({
                            message: "<span class='bigger-110'>Clock On/Off Masih Di Pending</span>",
                            buttons: 			
                                {
                                "button" :
                                    {
                                    "label" : "Ok",
                                    "className" : "btn-sm info"
                                }
                            }
                        });
                        $("#msc_nopol").val("");
                        $("#wo_km").val(0);
                        $("#pel_nama").val("");
                        $("#inv_woid").val("");
                        document.form.reset();
                        clearForm();
                        return false;
                    }
                    $("#inv_woid").val(data['woid']);
                    $("#msc_nopol").val(data['msc_nopol']);
                    $("#pel_nama").val(data['pel_nama']);
                    $("#wo_type").val(data['wo_type']);
                    $("#wo_km").val(data['wo_km']);
                    $("#inv_inextern").val(data['wo_inextern']);
                    $("#button").prop('disabled', false);
                } else {
                    $("#button").prop('disabled', true);
                    bootbox.dialog({
                        message: "<span class='bigger-110'>Nomor Wo Ini Tidak Terdaftar</span>",
                        buttons: 			
                            {
                            "button" :
                                {
                                "label" : "Ok",
                                "className" : "btn-sm info"
                            }
                        }
                    });
                    $("#msc_nopol").val("");
                    $("#wo_km").val(0);
                    $("#wo_inextern").val(0);
                    $("#pel_nama").val("");
                    $("#wo_type").val("");
                    $("#inv_woid").val("");
                    return false;
                }
            }
                
        });
    }
    
    // get total supply jika wo adalah service umum
    function getTotalSupply(wo,type)
    {
        
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('transaksi_service/getTotalSupply'); ?>',
            dataType: "json",
            async: false,
            data: {
                wo : wo
            },
            success: function(data) {
                if (type == '1') {
                    $("#total_ol").val(formatDefault(data['ol']));
                    $("#total_sp").val(formatDefault(data['sp']));
                    $("#total_so").val(formatDefault(data['so']));
                    $("#total_sm").val(formatDefault(data['sm']));
                }
                $("#total_ol_hpp").val(formatDefault(data['hppol']));
                $("#total_sp_hpp").val(formatDefault(data['hppsp']));
                $("#total_so_hpp").val(formatDefault(data['hppso']));
                $("#total_sm_hpp").val(formatDefault(data['hppsm']));
                grandTotal();
            }
        }); 
    }
    
    $(this).ready(function() {
        $('#form').submit(function() {
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                dataType: "json",
                async: false,
                data: $(this)
                .serialize(),
                success: function(data) {
                   
                }
            })
            return false;
        });

    });
    
    function autoCompleteJasa(inc)
    {
        $("#dinv_kode" + inc).autocomplete({
            minLength: 1,
            source: function(req, add) {
                $.ajax({
                    url: "<?php echo site_url('transaksi_service/getFlateRateAuto'); ?>",
                    dataType: 'json',
                    type: 'POST',
                    data: {
                        term : $("#dinv_kode" + inc).val(),
                        type : $("#wo_type").val()
                    },
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
            },select: function(event, ui) {
                var kode = ui.item.value;
                var valid = 0;
                $("input[name^=dinv_kode]").each(function() {
                    var k = $(this).val().replace(/,/g, "");
                    if (k == kode) {
                        bootbox.dialog({
                            message: "<span class='bigger-110'>Maaf, Kode Ini Sudah dipilih</span>",
                            buttons: 			
                                {
                                "danger" :
                                    {
                                    "label" : "Error !!",
                                    "className" : "btn-sm btn-danger"
                                }
                            }
                        });
                        kode = '';
                        valid = 1;
                        return false;
                    }
                });
                if (valid == 0) {
                    getDataFlateRate(ui.item.value,inc);
                }
            }
        });
    }
    
    function getDataFlateRate(kode, inc)
    {
        $.ajax({ 
            url: '<?php echo site_url('transaksi_service/jsonFlateRate'); ?>',
            dataType: 'json',
            type: 'POST',
            data: {
                param : kode
            },
            success: function(data){
                if (data['response']) {
                    var type = $("#wo_type").val();
                    $("#dinv_flatid" + inc).val(data.data['flatid']);
                    $("#flat_desk" + inc).val(data.data['flat_deskripsi']);
                    $("#flat_lc" + inc).val(formatDefault(data.data['flat_lc']));
                    $("#dinv_subtotal" + inc).val(formatDefault(data.data['flat_lc']));
                    
                    // TOTAL INVOICE
                    if (type == '2') {
                        $("#total_ol").val(formatDefault(data.data['flat_oli']));
                        $("#total_sp").val(formatDefault(data.data['flat_part']));
                        $("#total_sm").val(formatDefault(data.data['flat_sm']));
                        $("#total_so").val(formatDefault(data.data['flat_so']));
                    }
                   
                    totalLc();
                }else{
                    $("#dinv_flatid" + inc).val('');
                    $("#flat_desk" + inc).val('');
                    $("#flat_lc" + inc).val(formatDefault(0));
                    $("#dinv_subtotal" + inc).val(formatDefault(0));
                    totalLc();
                }
            }
        });
    }
    
    $('.page-content-area').ace_ajax('loadScripts', scripts, function() {
        //inline scripts related to this page
    });
</script> 