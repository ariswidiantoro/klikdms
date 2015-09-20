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
    input:focus {
        background-color: yellow;
    } 
    #wo,#pel_nama,#spp_pelid {background-color: #ffcccc;}
</style>
<form class="form-horizontal" id="form" action="<?php echo site_url('transaksi_sparepart/saveSupplySlip'); ?>" method="post" name="form">
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" required="required" for="form-field-1">Kategori</label>
        <div class="col-sm-8">
            <select name="spp_jenis" id="spp_jenis" class="ace col-xs-10 col-sm-3">
                <option value="">Pilih</option>
                <option value="ps">Part Shop</option>
                <option value="sp">Service -> Sparepart</option>
                <option value="sm">Service -> Sub Material</option>
                <option value="ol">Service -> Oli</option>
                <option value="so">Service -> Sub Order</option>
            </select>
        </div>
    </div>
    <div class="service" id="service" style="display: none">
        <div class="form-group">
            <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Work Order</label>
            <div class="col-sm-8">
                <input type="text" autocomplete="off" name="wo" id="wo" class="upper col-xs-10 col-sm-3" />
                <i id="sukses" class="ace-icon fa fa-check-circle bigger-200 green"></i>
                <i id="error" class="ace-icon fa fa-times-circle bigger-200 red"></i>
            </div>
        </div>
    </div>
    <div class="sparepart">
        <div class="form-group">
            <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nama Pelanggan</label>
            <div class="col-sm-8">
                <input type="text" autocomplete="off" required="required" name="pel_nama" id="pel_nama" class="upper col-xs-10 col-sm-3" />
            </div>
        </div>
    </div>
    <div class="sparepart">
        <div class="form-group">
            <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Kode Pelanggan</label>
            <div class="col-sm-8">
                <input type="text" autocomplete="off" required="required" name="spp_pelid" id="spp_pelid" class="upper col-xs-10 col-sm-3" />
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Pay Method</label>
        <div class="col-sm-8">
            <select name="spp_pay_method" required="required" class="ace col-xs-10 col-sm-3">
                <option value="">Pilih</option>
                <option value="tunai">Tunai</option>
                <option value="kredit">Kredit</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Kredit Term</label>
        <div class="col-sm-8">
            <input type="text" value="0" maxlength="2" autocomplete="off" name="spp_kredit_term" 
                   id="spp_kredit_term" class="number col-xs-10 col-sm-2" />
        </div>
    </div>
    <div class="hr hr-16 hr-dotted"></div>

    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Bantuan</label>
        <div class="col-sm-8">
            <div class="radio" style="margin-left: 0">
                <label>
                    <input name="auto" id="check" type="radio" value="auto" class="ace" />
                    <span class="lbl">Auto Complete</span>
                </label>
            </div>
            <div class="radio" style="margin-left: 0">
                <label>
                    <input name="auto" id="noncheck"  checked type="radio" value="auto" class="ace" />
                    <span class="lbl">Tanpa Auto Complete</span>
                </label>
            </div>


        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Kode Barang</label>
        <div class="col-sm-8">
            <input type="text" placeholder="KODE BARANG" autocomplete="off" name="kodeBarang" id="kodeBarang" onchange="getData(this.id)" class="upper ace col-xs-10 col-sm-6">
            <i class="ace-icon fa fa-spinner fa-spin orange bigger-200" id="waiting"></i>
            <div id="msg" style="font-size: 16px;font-weight: bold" class="msg help-block col-xs-12 col-sm-reset inline">
            </div>
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
                <input type="text" readonly="readonly" style="width: 100%;text-align: right;" value="0" name="spp_total" id="spp_total" class="spp_total col-xs-10 col-sm-10" />  
            </th>
            </tfoot>
        </table>
    </div>
    <div class="clearfix form-actions">
        <div class="col-md-offset-1 col-md-5">
            <button class="btn btn-info" id="button" type="submit">
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
    $('#button').attr("disabled", true);
    document.getElementById("sukses").style.display = 'none';
    document.getElementById("error").style.display = 'none';
    $("#spp_jenis").change(function(e) {
        var jenis = $('#spp_jenis').val();
        if (jenis == 'ps') {
            document.getElementById("service").style.display = 'none';
            document.getElementById("spp_pelid").readOnly = false;
            document.getElementById("pel_nama").readOnly = false;
        } else if (jenis != '') {
            document.getElementById("service").style.display = '';
            document.getElementById("spp_pelid").readOnly = true;
            document.getElementById("pel_nama").readOnly = true;
        }
        $("#spp_pelid").val("");
        $("#pel_nama").val("");
        $("#wo").val("");
        document.getElementById("sukses").style.display = 'none';
        document.getElementById("error").style.display = 'none';
        $('#button').removeAttr("disabled", true);
    })
    
    $("#wo").change(function(e) {
        if ($("#wo").val() != '') {
            $.ajax({
                url: '<?php echo site_url('transaksi_service/jsonWo'); ?>',
                dataType: 'json',
                type: 'POST',
                data: {param : $("#wo").val()},
                success: function(data) {
                    if (data.response) {
                        
                        document.getElementById("sukses").style.display = '';
                        document.getElementById("error").style.display = 'none';
                    } else {
                        //                        $('#button').attr("disabled", true);
                        document.getElementById("sukses").style.display = 'none';
                        document.getElementById("error").style.display = '';
                    }
                }
            });
        }
        
    })
    
    $('#check').click(function() {
        if ($(this).is(':checked')) {
            $('#kodeBarang').autocomplete("enable");
        }
    })
    $('#noncheck').click(function() {
        if ($(this).is(':checked')) {
            $('#kodeBarang').autocomplete("disable");
        }
    })



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
   
        
    $(this).ready(function() {
        $('#form').submit(function() {
            if (confirm("Yakin Data Sudah Benar ?")) {
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
            }
            return false;
        });
    });
        
    //    function simpan()
    //    {
    $(this).ready(function() {
        
        $("#pel_nama").autocomplete({
            minLength: 1,
            source: function(req, add) {
                $.ajax({
                    url: '<?php echo site_url('master_service/jsonPelanggan'); ?>',
                    dataType: 'json',
                    type: 'POST',
                    data: {param : $("#pel_nama").val()},
                    success: function(data) {
                        if (data.response == "true") {
                            add(data.message);
                        } else {
                            add(data.value);
                        }
                    }
                });
            },
            create: function () {
                $(this).data('ui-autocomplete')._renderItem = function (ul, item) {
                    return $('<li>')
                    .append('<a><strong>' + item.label + '</strong><br>' + item.desc + '</a>')
                    .appendTo(ul);
                };
            },
            select: function(event, ui) {
                $("#spp_pelid").val(ui.item.pelid);
            }
        })
        
        
        //                }
        //            });  
    });
    //    }
        
       
        
       

   
    
    var inc = 0;
    function Delete() {
        var par = $(this).parent().parent(); //tr
        par.remove();
        total();
    }
    function subTotal(inc) {
        var qty = cekDefaultNol($("#dsupp_qty"+inc).val().replace(/,/g, ""));
        var harga = cekDefaultNol($("#dsupp_harga"+inc).val().replace(/,/g, ""));
        var diskon = cekDefaultNol($("#dsupp_diskon"+inc).val().replace(/,/g, ""));
        var subtotal = (qty * harga)*((100-diskon)/100);
        $("#dsupp_subtotal"+inc).val(formatDefault(subtotal));
        total();
    }
    
    function total()
    {
        var total = 0;
        var price;
        $("input[name^=dsupp_subtotal]").each(function() {
            price = $(this).val().replace(/,/g, "");
            total += Number(price);
        });
        $("#spp_total").val(formatDefault(total));
    }
    
    
    function getData(id){
        var cek = 0;
        $("#waiting").show();
        $("#msg").show();
        if($("#"+id).val() !=""){
            $("#wait").attr("style","position: fixed;top: 0;left: 0;right: 0;height: 100%;opacity: 0.4;filter: alpha(opacity=40); background-color: #000;");
            $("input[name^=dsupp_inveid]").each(function(){
                if($(this).val() == $("#"+id).val()){
                    cek = 1;
                    var str = ($(this).attr("id"));
                    var baris = str.replace('dsupp_inveid','');
                    /* set QTY if exists */
                    var setqty = parseInt($("#dsupp_qty"+baris).val(),10) + 1;
                    $("#dsupp_qty"+baris).val(setqty);
                    subTotal(baris);
                    /* set empty */
                    $('#'+id).focus();
                    $("#"+id).val(""); 
                }
            });
            if(cek == 0){
                $.ajax({ 
                    url: '<?php echo site_url('master_sparepart/jsonDataBarang'); ?>',
                    dataType: 'json',
                    type: 'POST',
                    data: {
                        param : $("#kodeBarang").val(),
                        jenis : $("#spp_jenis").val()},
                    success: function(data){
                        if (data['response']) {
                            alert(data['inveid']);
                            inc++;
                            addRow(inc);
                            $("#kodeBrg"+inc).html(data['inve_kode']);
                            $("#dsupp_inveid"+inc).val(data['inveid']);
                            $("#inve_nama"+inc).html(data['inve_nama']);
                            $("#dsupp_hpp"+inc).val(data['inve_hpp']);
                            $("#dsupp_qty"+inc).val(1);
                            $("#dsupp_diskon"+inc).val(0);
                            $("#dsupp_harga"+inc).val(formatDefault(data['inve_harga']));
                            $("#dsupp_subtotal"+inc).val(formatDefault(data['inve_harga']));
                            total();
                            $("#msg").html("").show();
                        }else{
                            $("#msg").html("Kode Barang Ini Tidak Terdaftar").show().fadeIn("fast");
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
        $("#kodeBarang").autocomplete({
            minLength: 1,
            source: function(req, add) {
                $.ajax({
                    url: '<?php echo site_url('master_sparepart/jsonBarang'); ?>',
                    dataType: 'json',
                    type: 'POST',
                    data: {
                        param : $("#kodeBarang").val(),
                        jenis : $("#spp_jenis").val()
                    },
                    success: function(data) {
                        if (data.response == "true") {
                            add(data.message);
                        } else {
                            add(data.value);
                        }
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
        var qty = $("#dsupp_qty"+inc).val();
        var min = $("#dsupp_qty_min"+inc).val();
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
            $("#dsupp_qty"+inc).val("0");
            $("#dsupp_qty"+inc).focus();
        }
        
    }
    
    function addRow(inc) {
        $(".item-row:last").after(
        '<tr class="item-row">\n\
                    <td class="nomororder">' + inc + '<input type="hidden" name="no[]" id="no'+ inc +'"  /></td>\n\
                         <td>\n\
                             <span id="kodeBrg' + inc + '"></span>\n\
                            <input type="hidden" style="width:90%" id="dsupp_inveid' + inc + '" name="dsupp_inveid[]" />\n\
                            <input type="hidden" style="width:90%" id="dsupp_hpp' + inc + '" name="dsupp_hpp[]" />\n\
                         </td>\n\
                         <td>\n\
                                <span id="inve_nama' + inc + '"></span>\n\
                        </td>\n\
                        <td>\n\
                            <input type="text" onchange="cekQty('+inc+')" autocomplete="off" onkeyup="subTotal('+inc+')" class="number ace col-xs-10 col-sm-3" style="width:100%;text-align: right" id="dsupp_qty' + inc + '" name="dsupp_qty[]" />\n\
                            <input type="hidden" id="dsupp_qty_min' + inc + '" name="dsupp_qty_min[]" />\n\
                         </td>\n\
                         <td>\n\
                             <input type="text" autocomplete="off" onchange="$(\'#\'+this.id).val(formatDefault(this.value));" onkeyup="subTotal('+inc+')" class="number ace col-xs-10 col-sm-3" style="width:100%;text-align: right" id="dsupp_harga' + inc + '" name="dsupp_harga[]" />\n\
                         </td>\n\
                         <td>\n\
                             <input type="text"  autocomplete="off" onkeyup="subTotal('+inc+')" class="number ace col-xs-10 col-sm-10" style="width:100%;text-align: right" id="dsupp_diskon' + inc + '" name="dsupp_diskon[]" />\n\
                         </td>\n\
                         <td>\n\
                             <input type="text" class="subtotal ace col-xs-10 col-sm-10" readonly="readonly" style="width:100%;text-align: right" id="dsupp_subtotal' + inc + '" name="dsupp_subtotal[]" />\n\
                         </td>\n\
                         <td style="text-align: center">\n\
                             <a class="red btnDelete" href="javascript:;"><i class="ace-icon fa fa-trash-o bigger-130"></i></a>\n\
                         </td>\n\
                       </tr>\n\
                    </tr>');
                                 $(".btnDelete").bind("click", Delete);
                             }
    
    
</script> 