<div id="result"></div>
<style type="text/css">
    input:required {
        box-shadow: 4px 4px 20px rgba(200, 0, 0, 0.85);

    }

</style>
<form class="form-horizontal" id="form" action="<?php echo site_url('transaksi_sparepart/saveFakturSparepart'); ?>" method="post" name="form">
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nomer Supply</label>
        <div class="col-sm-8">
            <input type="text" required="required" autocomplete="off" name="trbr_faktur" maxlength="30" id="trbr_faktur" class="upper ace col-xs-10 col-sm-3" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Kode Supplier</label>
        <div class="col-sm-8">
            <input type="text" required="required"  id="trbr_supid" name="trbr_supid" class="upper col-xs-10 col-sm-3" />* Otomatis terisi saat nama supplier dipilih
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Pay Method</label>
        <div class="col-sm-8">
            <select name="trbr_pay_method" required="required" class="ace col-xs-10 col-sm-3">
                <option value="">Pilih</option>
                <option value="tunai">Tunai</option>
                <option value="kredit">Kredit</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Kredit Term</label>
        <div class="col-sm-8">
            <input type="text" value="0" autocomplete="off" name="trbr_credit_term" 
                   id="trbr_credit_term" class="number col-xs-10 col-sm-3" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Include Pajak</label>
        <div class="col-sm-8">
            <select name="trbr_inc_pajak" required="required" class="ace col-xs-10 col-sm-3">
                <option value="">Pilih</option>
                <option value="1">Ya</option>
                <option value="2">Tidak</option>
            </select>
        </div>
    </div>
    <div class="clearfix form-actions">
        <div class="col-md-offset-1 col-md-5">
            <button class="btn btn-info" type="submit" onclick="simpan()">
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
    //    $('#check').click(function() {
    //        if ($(this).is(':checked')) {
    //            $('#kodeBarang').autocomplete("enable");
    //        }
    //    })
    //    $('#noncheck').click(function() {
    //        if ($(this).is(':checked')) {
    //            $('#kodeBarang').autocomplete("disable");
    //        }
    //    })
                             
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
   
        
    function simpan()
    {
        $(this).ready(function() {
            //            bootbox.confirm("Simpan Data ?", function(result) {
            //                if(result) {
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
                            window.open("<?php echo site_url("transaksi_sparepart/printTerimaBarang"); ?>/"+data.kode,'_blank', params);
                        }
                        $("#result").html(data.msg).show().fadeIn("slow");
                    }
                })
                return false;
            });
            //                }
            //            });  
        });
    }
        
       
        
       

   
    
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
    
    $(document).ready(function(){
        $("#supplier").autocomplete({
            minLength: 1,
            source: function(req, add) {
                $.ajax({
                    url: '<?php echo site_url('master_sparepart/jsonSupplier'); ?>',
                    dataType: 'json',
                    type: 'POST',
                    data: {param : $("#supplier").val()},
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
                    .append("<a><strong>" + item.value + "</strong><br>" + item.desc + "</a>")
                    .appendTo(ul);
                };
            },
            select: function(event, ui) {
                $("#trbr_supid").val(ui.item.supid);
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
        })
        $('#kodeBarang').autocomplete("disable");
    });
    
    
    
</script> 
