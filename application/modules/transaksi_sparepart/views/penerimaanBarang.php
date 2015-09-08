<div id="result"></div>
<style type="text/css">
    input:required {
        box-shadow: 4px 4px 20px rgba(200, 0, 0, 0.85);
    }
</style>
<form class="form-horizontal" id="formRole" method="post" action="<?php echo site_url('transaksi_sparepart/savePenerimaanBarang'); ?>" name="formRole">
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nomer Faktur</label>
        <div class="col-sm-8">
            <input type="text" required="required" name="br_rate" id="br_rate" class="upper col-xs-10 col-sm-3" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Supplier</label>
        <div class="col-sm-8">
            <input type="text" required="required" name="supplier" id="supplier" class="upper col-xs-10 col-sm-3" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Kode Supplier</label>
        <div class="col-sm-8">
            <input type="text" required="required" name="supid" id="supid" class="upper col-xs-10 col-sm-3" />* Otomatis terisi saat nama supplier dipilih
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Pay Method</label>
        <div class="col-sm-8">
            <select name="trbr_pmethod" required="required" class="ace col-xs-10 col-sm-3">
                <option value="">Pilih</option>
                <option value="tunai">Tunai</option>
                <option value="kredit">Kredit</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Kredit Term</label>
        <div class="col-sm-8">
            <input type="text" required="required" name="trbr_credit_term" placeholder="0"
                   id="trbr_credit_term" class="number col-xs-10 col-sm-3" />
        </div>
    </div>
    <table id="simple-table" class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th width="10%">Qty</th>
                <th>Harga</th>
                <th width="10%">Diskon</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="center" width="10%">
                    <input type="text" name="" class="upper ace col-xs-10 col-sm-10">
                </td>
                <td class="center" width="10%">
                    <label>Nama Barang</label>
                </td>
                <td class="center" width="10%">
                    <input type="text" name="" class="upper ace col-xs-10 col-sm-10">
                </td>
                <td class="center" width="10%">
                    <input type="text" name="" class="upper ace col-xs-10 col-sm-10">
                </td>
                <td class="center" width="10%">
                    <input type="text" name="" class="upper ace col-xs-10 col-sm-10">
                </td>
                <td class="center" width="10%">
                    <input type="text" name="" class="upper ace col-xs-10 col-sm-10">
                </td>
            </tr>
            <tr>
                <td class="center" width="10%">
                    <input type="text" name="" class="upper ace col-xs-10 col-sm-10">
                </td>
                <td class="center" width="10%">
                   <label>Nama Barang</label>
                </td>
                <td class="center" width="10%">
                    <input type="text" name="" class="upper ace col-xs-10 col-sm-10">
                </td>
                <td class="center" width="10%">
                    <input type="text" name="" class="upper ace col-xs-10 col-sm-10">
                </td>
                <td class="center" width="10%">
                    <input type="text" name="" class="upper ace col-xs-10 col-sm-10">
                </td>
                <td class="center" width="10%">
                    <input type="text" name="" class="upper ace col-xs-10 col-sm-10">
                </td>
            </tr>
            <tr>
                <td class="center" width="10%">
                    <input type="text" name="" class="upper ace col-xs-10 col-sm-10">
                </td>
                <td class="center" width="10%">
                    <label>Nama Barang</label>
                </td>
                <td class="center" width="10%">
                    <input type="text" name="" class="upper ace col-xs-10 col-sm-10">
                </td>
                <td class="center" width="10%">
                    <input type="text" name="" class="upper ace col-xs-10 col-sm-10">
                </td>
                <td class="center" width="10%">
                    <input type="text" name="" class="upper ace col-xs-10 col-sm-10">
                </td>
                <td class="center" width="10%">
                    <input type="text" name="" class="upper ace col-xs-10 col-sm-10">
                </td>
            </tr>
        </tbody>
    </table>
    <div class="clearfix form-actions">
        <div class="col-md-offset-1 col-md-5">
            <button class="btn btn-info" type="submit">
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
    //called when key is pressed in textbox
    $(".number").keypress(function (e) {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 47 && e.which != 0 && (e.which < 46 || e.which > 57)){
            //display error message
            //        $("#errmsg").html("Digits Only").show().fadeOut("slow");
            return false;
        }
    });
    
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
                $("#supid").val(ui.item.supid);
            }
        })
    });
    
    
    $(this).ready(function() {
        $('#formRole').submit(function() {
            //  if (confirm("Yakin data sudah benar ?")) {
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                dataType: "json",
                async: false,
                data: $(this)
                .serialize(),
                success: function(data) {
                    window.scrollTo(0, 0);
                    document.formRole.reset();
                    $("#result").html(data).show().fadeIn("slow");
                }
            })
            return false;
        });

    });
    var scripts = [null, null]
    $('.page-content-area').ace_ajax('loadScripts', scripts, function() {
        //inline scripts related to this page
    });
</script> 