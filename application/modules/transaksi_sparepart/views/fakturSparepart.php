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
            <div class='input-group col-xs-10 col-sm-10'>
                <input type="text" required="required" autocomplete="off" name="supply" maxlength="30" id="supply" class="req upper ace col-xs-10 col-sm-6" />
                <input type="hidden" name="not_sppid" id="not_sppid"/>
                <input type="hidden" name="total" id="total"/>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Salesman</label>
        <div class="col-sm-8">
            <div class='input-group col-xs-10 col-sm-10'>
                <select name="not_salesman" required class="ace col-xs-10 col-sm-5 upper req">
                    <option value="">Pilih</option>
                    <?php
                    if (count($salesman) > 0) {
                        foreach ($salesman as $value) {
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
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nama Pelanggan</label>
        <div class="col-sm-8">
            <div class='input-group col-xs-10 col-sm-10'>
                <input type="text" required="required" readonly="readonly" name="pel_nama" 
                       id="pel_nama" class="upper col-xs-10 col-sm-5" />
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Kredit Term</label>
        <div class="col-sm-8">
            <div class='input-group col-xs-10 col-sm-10'>
                <input type="text" value="0" required="required" readonly="readonly" name="not_kredit_term" 
                       id="not_kredit_term" class="number col-xs-10 col-sm-3" />
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">No. Kwitansi Uang Muka</label>
        <div class="col-sm-8">
            <div class='input-group col-xs-10 col-sm-10'>
                <input type="text" id="not_nokwitansi_um" name="not_nokwitansi_um" class="upper col-xs-10 col-sm-4" />
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Total</label>
        <div class="col-sm-8">
            <input type="text" value="0" readonly="readonly" name="not_total" 
                   id="not_total" class="number col-xs-10 col-sm-3" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">No. Numerator</label>
        <div class="col-sm-8">
            <div class='input-group col-xs-10 col-sm-10'>
                <input type="text" required="required"  id="not_numerator" name="not_numerator" class="req upper col-xs-10 col-sm-3" />
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Pay Method</label>
        <div class="col-sm-8">
            <div class='input-group col-xs-10 col-sm-10'>
                <select name="not_pay_method" id="not_pay_method" required="required" class="ace col-xs-10 col-sm-3 upper req">
                    <option value="">Pilih</option>
                    <option value="tunai">Tunai</option>
                    <option value="kredit">Kredit</option>
                </select>
            </div>
        </div>
    </div>


    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Tampilkan PPN di cetakan</label>
        <div class="col-sm-8">
            <div class='input-group col-xs-10 col-sm-10'>
                <select name="not_tampil_ppn" id="not_tampil_ppn" required="required" class="ace col-xs-10 col-sm-3 upper req">
                    <option value="">Pilih</option>
                    <option value="1">Ya</option>
                    <option value="0">Tidak</option>
                </select>
            </div>
        </div>
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
    //called when key is pressed in textbox
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
                pel_nama: {
                    required: true
                }
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
    
                           
    
    var scripts = [null, null]
    $('.page-content-area').ace_ajax('loadScripts', scripts, function() {
        //inline scripts related to this page
    });
   
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
                        //                        clearForm();
                        window.open("<?php echo site_url("transaksi_sparepart/printFakturSparepart"); ?>/"+data.kode,'_blank', params);
                    }
                    $("#result").html(data.msg).show().fadeIn("slow");
                }
            })
            return false;
        });

    });
        
   
    function getDataSupply(noslip)
    {
        $.ajax({
            url: '<?php echo site_url('transaksi_sparepart/getDataSupplyPartShop'); ?>',
            dataType: 'json',
            type: 'POST',
            data: {param : noslip},
            success: function(data) {
                $("#not_sppid").val(data['sppid']);
                $("#not_kredit_term").val(data['spp_kredit_term']);
                $("#not_pay_method").val(data['spp_pay_method']);
                $("#pel_nama").val(data['pel_nama']);
                $("#not_total").val(formatDefault(data['spp_total']));
                $("#total").val(data['spp_total']);
                $('.page-content-area').ace_ajax('stopLoading', true);
            }
        });
    }
        
       

   
    
    $(document).ready(function(){
        $("#supply").autocomplete({
            minLength: 1,
            source: function(req, add) {
                $.ajax({
                    url: '<?php echo site_url('transaksi_sparepart/jsonSupplyPartShop'); ?>',
                    dataType: 'json',
                    type: 'POST',
                    data: {param : $("#supply").val()},
                    success: function(data) {
                        add(data);
                    }
                });
            },create: function () {
                $(this).data('ui-autocomplete')._renderItem = function (ul, item) {
                    return $('<li>')
                    .append("<a><strong>" + item.value + "</strong><br> Pelanggan : " + item.label + "</a>")
                    .appendTo(ul);
                };
            },
            select: function(event, ui) {
                $('.page-content-area').ace_ajax('startLoading');
                getDataSupply(ui.item.value);
            }
        })
        
        
        $("#salesman").autocomplete({
            minLength: 1,
            source: function(req, add) {
                $.ajax({
                    url: '<?php echo site_url('transaksi_sparepart/autoSalesmanSparepart'); ?>',
                    dataType: 'json',
                    type: 'POST',
                    data: {param : $("#salesman").val()},
                    success: function(data) {
                        add(data.message);
                    }
                });
            },create: function () {
                $(this).data('ui-autocomplete')._renderItem = function (ul, item) {
                    return $('<li>')
                    .append("<a><strong>" + item.value + "</strong><br> Pelanggan : " + item.label + "</a>")
                    .appendTo(ul);
                };
            },
            select: function(event, ui) {
                $('.page-content-area').ace_ajax('startLoading');
                getDataSupply(ui.item.value);
            }
        })
    });
    
    
    
</script> 
