<div id="result"></div>
<style type="text/css">
    input:required {
        box-shadow: 4px 4px 20px rgba(200, 0, 0, 0.85);

    }

</style>
<form class="form-horizontal" id="formRole" method="post" name="formRole">
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nomer Faktur</label>
        <div class="col-sm-8">
            <input type="text" required="required" name="br_rate" id="br_rate" class="upper ace col-xs-10 col-sm-3" />
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
    <div class="hr hr-16 hr-dotted"></div>

<!--    <table class="table table-striped table-bordered">
        <tbody>
            <tr>
                <td class="center" style="width: 20%">
                    Kode Barang :
                    <input type="text" style="width: 100%;" name="kodeBarang" id="kodeBarang" onchange="getData(this.id)" class="upper ace col-xs-10 col-sm-10 required">
                </td>
                <td class="center"  style="width: 30%">
                    <label>Nama Barang</label>
                </td>
                <td class="center"  style="width: 10%">
                    Qty :
                    <input type="text" name="" style="width: 100%" class="upper ace col-xs-10 col-sm-10">
                </td>
                <td class="center"  style="width: 10%">
                    Harga :
                    <input type="text" name="" style="width: 100%" class="upper ace col-xs-10 col-sm-10">
                </td>
                <td class="center"  style="width: 20%">
                    Diskon :
                    <input type="text" name="" style="width: 100%" class="upper ace col-xs-10 col-sm-10">
                </td>

            </tr>
        </tbody>
    </table>-->
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Kode Barang</label>
        <div class="col-sm-8">
            <input type="text" placeholder="KODE BARANG" name="kodeBarang" id="kodeBarang" onchange="getData(this.id)" class="upper ace col-xs-10 col-sm-6">
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
            <tr  class="item-row" style="display: none">

            </tr>
            <tbody>

            </tbody>
            <tfoot>
            <th colspan="6" style="text-align: right">TOTAL</th>
            <th style="text-align: right">0</th>
            </tfoot>
        </table>
    </div>
    <div class="clearfix form-actions">
        <div class="col-md-offset-1 col-md-5">
            <button class="btn btn-info" type="button" onclick="submit()">
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
    var inc = 0;
    
    
    function addRow(inc) {
        $(".item-row:last").after(
        '<tr class="item-row">\n\
                    <td class="nomororder">' + inc + '<input type="hidden" name="no[]" id="no'+ inc +'"  /></td>\n\
                         <th>\n\
                             <span id="kodeBrg' + inc + '"></span>\n\
                            <input type="hidden" style="width:90%" id="inve_kode' + inc + '" name="inve_kode[]" />\n\
                            <input type="hidden" style="width:90%" id="inveid' + inc + '" name="inveid[]" />\n\
                         </th>\n\
                         <th>\n\
                                <span id="inve_nama' + inc + '"></span>\n\
                        </th>\n\
                        <th>\n\
                            <input type="text" class="number ace col-xs-10 col-sm-3" style="width:100%;text-align: right" id="inve_qty' + inc + '" name="inve_qty[]" />\n\
                         </th>\n\
                         <th>\n\
                             <input type="text" class="number ace col-xs-10 col-sm-3" style="width:100%;text-align: right" id="inve_harga' + inc + '" name="inve_harga[]" />\n\
                         </th>\n\
                         <th>\n\
                             <input type="text" class="number ace col-xs-10 col-sm-10" style="width:100%;text-align: right" id="inve_diskon' + inc + '" name="inve_diskon[]" />\n\
                         </th>\n\
                         <th>\n\
                             <input type="text" class="number ace col-xs-10 col-sm-10" readonly="readonly" style="width:100%;text-align: right" id="inve_subtotal' + inc + '" name="inve_subtotal[]" />\n\
                         </th>\n\
                         <th>\n\
                             <a class="red" href="#"><i class="ace-icon fa fa-trash-o bigger-130"></i></a>\n\
                         </th>\n\
                       </tr>\n\
                    </tr>');
                             }
    
    
                             function getData(id){
                                 var cek = 0;
                                 if($("#"+id).val() !=""){
                                     $("#wait").attr("style","position: fixed;top: 0;left: 0;right: 0;height: 100%;opacity: 0.4;filter: alpha(opacity=40); background-color: #000;");
                                     $("input[name^=inve_kode]").each(function(){
                                         if($(this).val() == $("#"+id).val()){
                                             cek = 1;
                                             var str = ($(this).attr("id"));
                                             var baris = str.replace('inve_kode','');
                                             /* set QTY if exists */
                                             var setqty = parseInt($("#inve_qty"+baris).val(),10) + 1;
                                             $("#inve_qty"+baris).val(setqty);
                                             /* Jumlah Sub Total */
                                             //                                             total("harga"+baris,"qty"+baris,"total"+baris);
                                             /* Jumlah Total */
                                             var sum=0;
                                             //                                             $(".total").each(function(){
                                             //                                                 if($(this).val() != "")
                                             //                                                     sum += parseInt($(this).val());   
                                             //                                             });
                                             //                                             $("#subtotal").val(sum);
                                             /* set empty */
                                             $('#'+id).focus();
                                             $("#"+id).val(""); 
                                             //                                             $("#wait").removeAttr("style","position: fixed;top: 0;left: 0;right: 0;height: 100%;opacity: 0.4;filter: alpha(opacity=40); background-color: #000;");
                                         }
                                     });
                                     if(cek == 0){
                                         $.ajax({ 
                                             url: '<?php echo site_url('master_sparepart/jsonDataBarang'); ?>',
                                             dataType: 'json',
                                             type: 'POST',
                                             data: {param : $("#kodeBarang").val()},
                                             success: function(data){
                                                 if (data['response']) {
                                                     inc++;
                                                     addRow(inc);
                                                     $("#kodeBrg"+inc).html(data['inve_kode']);
                                                     $("#inveid"+inc).val(data['inveid']);
                                                     $("#inve_kode"+inc).val(data['inve_kode']);
                                                     $("#inve_nama"+inc).html(data['inve_nama']);
                                                     $("#inve_qty"+inc).val(1);
                                                     $("#inve_diskon"+inc).val(0);
                                                     $("#inve_harga"+inc).val(0);
                                                     $("#inve_subtotal"+inc).val(0);
                                                     $("#"+id).val(""); 
                                                 }else{
                                                     alert("Kode Barang ini tidak terdaftar");
                                                 }
                                                 $('#'+id).focus();
                                             }
                                         });
                                     }
                                 }
                             }
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
                             });
    
    
                             function submit()
                             {
                                 $(this).ready(function() {
                                     //            $('#formRole').submit(function() {
                                     //  if (confirm("Yakin data sudah benar ?")) {
                                     $.ajax({
                                         type: 'POST',
                                         url: "<?php echo site_url('transaksi_sparepart/savePenerimaanBarang'); ?>",
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

                                 //        });
                             }
   
                             var scripts = [null, null]
                             $('.page-content-area').ace_ajax('loadScripts', scripts, function() {
                                 //inline scripts related to this page
                             });
</script> 