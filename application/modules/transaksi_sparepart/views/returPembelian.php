<div id="result"></div>
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

</style>
<form class="form-horizontal" id="form" action="<?php echo site_url('transaksi_sparepart/saveReturPembelian'); ?>" method="post" name="form">
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nomer Faktur Terima</label>
        <div class="col-sm-8">
            <div class='input-group col-xs-10 col-sm-10'>
                <input type="text" required="required" autocomplete="off" name="trbr_faktur" maxlength="30" id="trbr_faktur" class="upper ace col-xs-10 col-sm-4 req" />
                <input type="hidden"  autocomplete="off" name="trbrid" id="trbrid"/>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Supplier</label>
        <div class="col-sm-8">
            <div class='input-group col-xs-10 col-sm-10'>
                <input type="text" autocomplete="off" required="required" name="supplier" id="supplier" class="upper col-xs-10 col-sm-6 req" />
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Kode Supplier</label>
        <div class="col-sm-8">
            <div class='input-group col-xs-10 col-sm-10'>
                <input type="text" required="required"  id="trbr_supid" name="trbr_supid" class="upper col-xs-10 col-sm-4 req" />* Otomatis terisi saat nama supplier dipilih
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Alasan Retur</label>
        <div class="col-sm-8">
            <div class='input-group col-xs-10 col-sm-10'>
                <textarea name="rb_alasan" required="required" class="ace col-xs-10 col-sm-5  req" rows="4"></textarea>
            </div>
        </div>
    </div>
    <div class="hr hr-16 hr-dotted"></div>

    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Bantuan</label>
        <div class="col-sm-8">
            <label>
                <input class="ace" id="autocomplete" onclick="cekAutoComplete()" type="checkbox" name="form-field-checkbox">
                <span class="lbl"> Auto Complete</span>
            </label>
            <!--</div>-->
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Kode Barang</label>
        <div class="col-sm-8">
            <input type="text" placeholder="KODE BARANG" autocomplete="off" name="kodeBarang" id="kodeBarang" onchange="getData(this.id)" class="upper ace col-xs-10 col-sm-6">
            <i class="ace-icon fa fa-spinner fa-spin orange bigger-200" id="waiting"></i>
        </div>
    </div>
    <div class="table-header">
        Daftar Barang
    </div>
    <div>
        <table id="simple-table" class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th style="width: 5%">No</th>
                    <th style="width: 20%">Kode Barang</th>
                    <th  style="width: 30%">Nama Barang</th>
                    <th style="width: 7%">Qty</th>
                    <th  style="width: 10%">Harga</th>
                    <th  style="width: 8%">Diskon</th>
                    <th  style="width: 15%">Sub Total</th>
                    <th  style="width: 15%">Hapus</th>
                </tr>
            </thead>

            <tbody>
                <tr  class="item-row" style="display: none">

                </tr>
            </tbody>
            <tfoot>
            <th colspan="6" style="text-align: right">TOTAL</th>
            <th  class="ace col-xs-10 col-sm-10">
                <input type="text" readonly="readonly" style="width: 100%;text-align: right;" value="0" name="trbr_total" id="trbr_total" class="trbr_total col-xs-10 col-sm-10" />  
            </th>
            </tfoot>
        </table>
    </div>
    <div class="clearfix form-actions">
        <div class="col-md-offset-1 col-md-5">
            <button class="btn btn-info" type="button" id="button">
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
    $("#waiting").hide();
    
    function cekAutoComplete()
    {
        if($("#autocomplete").prop("checked") == true){
            $('#kodeBarang').autocomplete("enable");
        }else{
            $('#kodeBarang').autocomplete("disable");
        }
    }
    jQuery(function($) {
        var $validation = true;
        $('#button').on('click', function(e){
            //             window.location = "#transaksi_sparepart/returPembelian";
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



    //called when key is pressed in textbox
    $(".number").keypress(function (e) {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 47 && e.which != 0 && (e.which < 46 || e.which > 57)){
            //display error message
            //        $("#errmsg").html("Digits Only").show().fadeOut("slow");
            return false;
        }
    });
    
                           
    
    var scripts = [null, null]
    $('.page-content-area').ace_ajax('loadScripts', scripts, function() {
        //inline scripts related to this page
    });
    function clearForm()
    {
        //        $("#barang1").val('');
        //        $("#pelkode").val('');
        var otable = document.getElementById('simple-table');
        var counti = otable.rows.length - 2;
        while (counti > 1) {
            otable.deleteRow(counti);
            counti--;
        }
    }
   
        
    //    function simpan()
    //    {
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
                    window.scrollTo(0, 0);
                    if (data.result) {
                        var params  = 'width=1000';
                        params += ', height='+screen.height;
                        params += ', fullscreen=yes,scrollbars=yes';
                        document.form.reset();
                        clearForm();
                        window.open("<?php echo site_url("transaksi_sparepart/printReturBeli"); ?>/"+data.kode,'_blank', params);
                    }
                    $("#result").html(data.msg).show().fadeIn("slow");
                }
            })
            return false;
        });
    });
        
       
        
       

   
    
    var inc = 0;
    function Delete() {
        var par = $(this).parent().parent(); //tr
        par.remove();
        total();
    }
    function subTotal(inc) {
        var qty = cekDefaultNol($("#dtr_qty"+inc).val().replace(/,/g, ""));
        var harga = cekDefaultNol($("#dtr_harga"+inc).val().replace(/,/g, ""));
        var diskon = cekDefaultNol($("#dtr_diskon"+inc).val().replace(/,/g, ""));
        var subtotal = (qty * harga)*((100-diskon)/100);
        $("#dtr_subtotal"+inc).val(formatDefault(subtotal));
        total();
    }
    
    function total()
    {
        var total = 0;
        var price;
        $("input[name^=dtr_subtotal]").each(function() {
            price = $(this).val().replace(/,/g, "");
            total += Number(price);
        });
        $("#trbr_total").val(formatDefault(total));
    }
    
    
    function getData(id){
        var cek = 0;
        $("#waiting").show();
        if($("#"+id).val() !=""){
            $("#wait").attr("style","position: fixed;top: 0;left: 0;right: 0;height: 100%;opacity: 0.4;filter: alpha(opacity=40); background-color: #000;");
            $("input[name^=dtr_inve_kode]").each(function(){
                if($(this).val() == $("#"+id).val()){
                    cek = 1;
                    var str = ($(this).attr("id"));
                    var baris = str.replace('dtr_inve_kode','');
                    /* set QTY if exists */
                    var setqty = parseInt($("#dtr_qty"+baris).val(),10) + 1;
                    $("#dtr_qty"+baris).val(setqty);
                    subTotal(baris);
                    /* set empty */
                    $('#'+id).focus();
                    $("#"+id).val(""); 
                }
            });
            if(cek == 0){
                $.ajax({ 
                    url: '<?php echo site_url('master_sparepart/jsonDataBarangTerima'); ?>',
                    dataType: 'json',
                    type: 'POST',
                    data: {
                        param : $("#kodeBarang").val(),
                        faktur : $("#trbr_faktur").val()},
                    success: function(data){
                        if (data['response']) {
                            inc++;
                            addRow(inc);
                            $("#kodeBrg"+inc).html(data['inve_kode']);
                            $("#dtr_inveid"+inc).val(data['inveid']);
                            $("#dtr_inve_kode"+inc).val(data['inve_kode']);
                            $("#inve_nama"+inc).html(data['inve_nama']);
                            $("#dtr_qty"+inc).val(0);
                            $("#dtr_qty_min"+inc).val(data['dtr_qty']);
                            $("#dtr_diskon"+inc).val(data['dtr_diskon']);
                            $("#dtr_harga"+inc).val(formatDefault(data['dtr_harga']));
                            $("#dtr_subtotal"+inc).val(0);
                            total();
                        }else{
                            bootbox.dialog({
                                message: "<span class='bigger-110'>Kode Barang Ini Tidak Terdaftar</span>",
                                buttons: 			
                                    {
                                    "button" :
                                        {
                                        "label" : "Ok",
                                        "className" : "btn-sm info"
                                    }
                                }
                            });
                        }
                        $("#"+id).val(""); 
                        $('#'+id).focus();
                    }
                });
            }
        }
        $("#waiting").hide();
    }
    
    $(document).ready(function(){
        //        $('#kodeBarang').autocomplete("disable");
        $("#trbr_faktur").autocomplete({
            minLength: 1,
            source: function(req, add) {
                $.ajax({
                    url: '<?php echo site_url('transaksi_sparepart/jsonFakturTerima'); ?>',
                    dataType: 'json',
                    type: 'POST',
                    data: {param : $("#trbr_faktur").val()},
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
                $("#trbr_supid").val(ui.item.supid);
                $("#supplier").val(ui.item.desc);
                $("#trbrid").val(ui.item.id);
            }
        })
        $("#kodeBarang").autocomplete({
            minLength: 1,
            source: function(req, add) {
                $.ajax({
                    url: '<?php echo site_url('master_sparepart/jsonBarang'); ?>',
                    dataType: 'json',
                    type: 'POST',
                    data: {param : $("#kodeBarang").val()},
                    success: function(data) {
                        add(data.message);
                    }
                });
            },
            create: function () {
                $(this).data('ui-autocomplete')._renderItem = function (ul, item) {
                    return $('<li>')
                    .append("<a><strong>" + item.value + "</strong><br> Nama Barang : " + item.desc + "</a>")
                    .appendTo(ul);
                };
            }
        });
        $('#kodeBarang').autocomplete("disable");
    });
    
    function cekQty(inc)
    {
        var qty = $("#dtr_qty"+inc).val();
        var min = $("#dtr_qty_min"+inc).val();
        if (parseFloat(qty) > parseFloat(min)) {
            bootbox.dialog({
                message: "<span class='bigger-110'>Retur Maksimal "+min+"</span>",
                buttons: 			
                    {
                    "button" :
                        {
                        "label" : "Ok",
                        "className" : "btn-sm info"
                    }
                }
            });
            $("#dtr_qty"+inc).val("0");
            $("#dtr_qty"+inc).focus();
        }
        
    }
    
    function addRow(inc) {
        $(".item-row:last").after(
        '<tr class="item-row">\n\
                    <td class="nomororder">' + inc + '<input type="hidden" name="no[]" id="no'+ inc +'"  /></td>\n\
                         <td>\n\
                             <span id="kodeBrg' + inc + '"></span>\n\
                            <input type="hidden" style="width:90%" id="dtr_inve_kode' + inc + '" name="dtr_inve_kode[]" />\n\
                            <input type="hidden" style="width:90%" id="dtr_inveid' + inc + '" name="dtr_inveid[]" />\n\
                         </td>\n\
                         <td>\n\
                                <span id="inve_nama' + inc + '"></span>\n\
                        </td>\n\
                        <td>\n\
                            <input type="text" onchange="cekQty('+inc+')" autocomplete="off" onkeyup="subTotal('+inc+')" class="number ace col-xs-10 col-sm-3" style="width:100%;text-align: right" id="dtr_qty' + inc + '" name="dtr_qty[]" />\n\
                            <input type="hidden" id="dtr_qty_min' + inc + '" name="dtr_qty_min[]" />\n\
                         </td>\n\
                         <td>\n\
                             <input type="text" readonly="readonly" autocomplete="off" onchange="$(\'#\'+this.id).val(formatDefault(this.value));" onkeyup="subTotal('+inc+')" class="number ace col-xs-10 col-sm-3" style="width:100%;text-align: right" id="dtr_harga' + inc + '" name="dtr_harga[]" />\n\
                         </td>\n\
                         <td>\n\
                             <input type="text" readonly="readonly" autocomplete="off" onkeyup="subTotal('+inc+')" class="number ace col-xs-10 col-sm-10" style="width:100%;text-align: right" id="dtr_diskon' + inc + '" name="dtr_diskon[]" />\n\
                         </td>\n\
                         <td>\n\
                             <input type="text" class="subtotal ace col-xs-10 col-sm-10" readonly="readonly" style="width:100%;text-align: right" id="dtr_subtotal' + inc + '" name="dtr_subtotal[]" />\n\
                         </td>\n\
                         <td style="text-align: center">\n\
                             <a class="red btnDelete" href="javascript:;"><i class="ace-icon fa fa-trash-o bigger-130"></i></a>\n\
                         </td>\n\
                       </tr>\n\
                    </tr>');
                                 $(".btnDelete").bind("click", Delete);
                             }
    
    
</script> 
