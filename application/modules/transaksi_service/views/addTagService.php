<style type="text/css">
    html .ui-autocomplete { 
        /* without this, the menu expands to 100% in IE6 */
        max-height: 200px;
        padding-right: 20px;
        overflow-y: auto;
        width:300px; 
    }      
</style>
<div id="result"></div>
<div class="page-header">
    <h1>
        <?php echo $etc['judul']; ?>
    </h1>
</div>
<form class="form-horizontal" id="formAdd" method="post" action="<?php echo site_url($etc['targetSave']); ?>" name="formAdd">
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-left" for="form-field-1">No. Invoice</label>
        <div class="col-sm-6">
            <input type="text" id="trans_nota" name="trans_nota" required="required" maxlength="20" 
                   onkeyup="acomplete('trans_nota', 'auto_fakturTagSvc', 'trans_notaid', 'trans_nopol','trans_pelid')"
                   class="req upper ace col-xs-10 col-sm-6" />
            <a href="javascript:void(0);" class="btn btn-sm btn-primary"><i class="ace-icon fa fa-list"></i>Daftar Invoice</a>
            <input type="hidden" id="trans_notaid" name="trans_notaid" />
            <input type="hidden" id="trans_pelid" name="trans_pelid" />
            <input type="hidden" id="trans_subtrans" name="trans_subtrans" value="<?php echo $etc['subtrans']; ?>" />
            <input type="hidden" id="trans_type" name="trans_type" value="I" />
            <input type="hidden" id="trans_invid" name="trans_invid" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-left" for="form-field-1">No. Polisi</label>
        <div class="col-sm-6">
            <input type="text" id="trans_nopol" name="trans_nopol" required="required" readonly maxlength="20" 
                   placeholder="NO. POLISI" class="upper form-control input-xlarge req" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-left" for="form-field-1">Tanggal</label>
        <div class="col-sm-2">
            <div class="input-group">
                <input type="text" id="trans_tgl" name="trans_tgl" readonly="readonly" value="<?php echo date('d-m-Y'); ?>" 
                       class="form-control datepicker req" data-date-format="dd-mm-yyyy" />
                <span class="input-group-addon">
                    <i class="fa fa-calendar bigger-110"></i>
                </span>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-left" for="form-field-1">No. Kertas</label>
        <div class="col-sm-6">
            <input type="text" id="trans_numerator" name="trans_numerator" required="required" maxlength="20" 
                   placeholder="NO. KERTAS" class="upper form-control input-xlarge req" />
        </div>
    </div>
    <div id="detailtrans">
        <div class="table-header">
            DETAIL PEMBAYARAN
        </div>
        <div>
            <table id="simple-table-jasa" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th style="width: 2%">NO</th>
                        <th style="width: 15%">JENIS PEMBAYARAN</th>
                        <th style="width: 10%">ACCOUNT</th>
                        <th style="width: 30%">KETERANGAN</th>
                        <th style="width: 20%">NOMINAL</th>
                        <th style="width: 5%">ADD</th>
                        <th style="width: 5%">HAPUS</th>
                    </tr>
                </thead>
                <tbody>
                    <tr  class="item-tag">
                        <td class="totalTag" style="text-align: right; vertical-align: middle;" colspan="4">
                            TOTAL TAGIHAN &nbsp;
                        </td>
                        <td>
                            <input type="text"  automplete="off"  class="number ace col-xs-10 col-sm-10" value="0" readonly 
                                 style="width:100%;text-align: right"  name="total_tagihan" id="total_tagihan" />
                        </td>
                        <td class="center" style="vertical-align: middle;" colspan="2">&nbsp;</td>
                    </tr>
                    <tr  class="item-um">
                        <td class="totalUm" style="text-align: right; vertical-align: middle;" colspan="4">
                            TOTAL UANGMUKA &nbsp;
                        </td>
                        <td>
                            <input type="text"  automplete="off"  class="number ace col-xs-10 col-sm-10" value="0" readonly 
                                 style="width:100%;text-align: right"  name="total_uangmuka" id="total_uangmuka" />
                        </td>
                        <td class="center" style="vertical-align: middle;" colspan="2">&nbsp;</td>
                    </tr>
                    <tr  class="item-row">
                        <td class="dtrans" style="text-align: center; vertical-align: middle;">
                            1
                        </td>
                        <td>
                            <select id="dtrans_jenis1" name="dtrans_jenis[]" onchange="changeType('1');" style="width:100%;" 
                                    class="form-control input-small">
                                <option value="">PILIH</option>
                                <option value ="1">KAS</option>
                                <option value ="2">BANK</option>
                                <option value ="3">CEK</option>
                            </select>
                        </td>
                        <td>
                            <select id="dtrans_coa1" name="dtrans_coa[]" required="required" class="form-control input-medium"></select>
                            <input type="hidden" id="dtrans_trans1" name="dtrans_trans[]" />
                        </td>
                        <td>
                            <input type="text" autocomplete ="off" placeholder="KETERANGAN" 
                                   class="upper ace col-xs-10 col-sm-10" style="width:100%;"  name="dtrans_desc[]" id="dtrans_desc1" />
                        </td>
                        <td>
                            <input type="text"  automplete="off"  class="number ace col-xs-10 col-sm-10" value="0" 
                                 onchange="$('#'+this.id).val(formatCurrency(this.value));" onkeyup="countTotal()"  
                                 style="width:100%;text-align: right"  name="dtrans_nominal[]" id="dtrans_nominal1" />
                        </td>
                        <td class="center" style="vertical-align: middle;">
                            <a class="green btnAdd"  onclick="addRow()" href="javascript:;"><i class="ace-icon fa fa-plus bigger-130"></i></a>
                        </td>
                        <td  class="center" style="vertical-align: middle;">
                            <a class="red btnDelete" href="javascript:;"><i class="ace-icon fa fa-trash-o bigger-130"></i></a>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4" style="text-align: right">
                            SISA TAGIHAN &nbsp;
                        </th>
                        <th>
                            <input type="text" readonly="readonly" style="width: 100%;text-align: right;" 
                                   value="0" name="totalTrans" id="totalTrans" class="number col-xs-10 col-sm-10" />  
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
    <div style="padding-top:8px;">
        <div><strong>TERBILANG : </strong></div>
            <i><span id="terbilang"style="font-weight:bold;"></span></i>
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
        </div>
    </div>
</form>

<script type="text/javascript">
    function redirect(data){
                window.location.href = "#<?php echo $etc['targetListData']; ?>";
    }
    function alertDialog(msg){
        bootbox.dialog({
            message: "<span class='bigger-110'>"+msg+"</span>",
            buttons: 			
            {
                "danger" :
                {
                    "label" : "OK",
                    "className" : "btn-sm btn-danger"
                }
            }
        });
    }
    
    function saveData(){
        var result = false;
        if(!$('#formAdd').valid()){
           // e.preventDefault();
        }else{
                bootbox.confirm("Anda yakin data sudah benar ?", function(result) {
                    if(result) {
                        $("#formAdd").submit();
                    }
                });
        }
        return false;
    }
    
    function Delete() {
        var par = $(this).parent().parent(); //tr
        par.remove();
        countTotal();
    }
        
    function addRow() {
        var inc = $('.dtrans').length+1;
        $(".item-row:last").after(
        '<tr class="item-row">\n\
                    <td class="dtrans center" style="vertical-align:middle;">' + inc + '</td>\n\
                        <td>\n\
                            <select id="dtrans_jenis'+inc+'" name="dtrans_jenis[]" onchange="changeType(\''+inc+'\');" style="width:100%;" \n\
                                    class="form-control input-small">\n\
                                <option value="">PILIH</option>\n\
                                <option value ="1">KAS</option>\n\
                                <option value ="2">BANK</option>\n\
                                <option value ="3">CEK</option>\n\
                            </select>\n\
                         </td>\n\
                         <td>\n\
                             <select id="dtrans_coa'+inc+'" name="dtrans_coa[]" required="required" class="form-control input-medium"></select>\n\
                            <input type="hidden" id="dtrans_trans'+inc+'" name="dtrans_trans[]" />\n\
                         </td>\n\
                         <td>\n\
                            <input type="text" autocomplete ="off" placeholder="KETERANGAN" \n\
                                   class="upper ace col-xs-10 col-sm-10" style="width:100%;"  name="dtrans_desc[]" id="dtrans_desc'+inc+'" />\n\
                         <td>\n\
                             <input type="text"  autocomplete="off" value= "0" onchange="$(\'#\'+this.id+\'\').val(formatCurrency(this.value));" onkeyup="countTotal()" \n\
                                class="upper ace col-xs-10 col-sm-10" style="width:100%;text-align: right"  \n\
                                name="dtrans_nominal[]" id="dtrans_nominal'+ inc +'" />\n\
                         </td>\n\
                         <td  class="center" style="vertical-align: middle;">\n\
                             <a class="green btnAdd"  onclick="addRow()" href="javascript:;"><i class="ace-icon fa fa-plus bigger-130"></i></a>\n\
                         </td>\n\
                         <td class="center" style="vertical-align: middle;">\n\
                             <a class="red btnDelete" href="javascript:;"><i class="ace-icon fa fa-trash-o bigger-130"></i></a>\n\
                         </td>\n\
                       </tr>\n\
                    </tr>');
            $(".btnDelete").bind("click", Delete);
            numberOnly();
    }

    function acomplete(id, url, trglocal, trgid, trgname){
        var row = $("#"+id).parents('.item-row');
        var pelid = $("#pelid").val();
        $("#" + id).autocomplete({
            minLength: 1,
            source: function(req, add) {
                $.ajax({
                    url: "<?php echo site_url('auto_complete'); ?>/"+url,
                    dataType: 'json',
                    type: 'POST',
                    data: {
                        param : $("#" + id).val(),
                        cbid : '<?php echo ses_cabang; ?>',
                        pelid : pelid
                    },
                    success: function(data) {
                        add(data.message);
                    }
                });
            },
            create: function () {
                $(this).data('ui-autocomplete')._renderItem = function (ul, item) {
                    return $('<li></li>')
                    .append("<strong>" + item.value + "</strong><br>" + item.desc + "")
                    .appendTo(ul);
                };
            },select: function(event, ui) {
                if(ui.item.status != ''){
                    $('#trans_notaid').val(ui.item.notaid);
                    $('#trans_pelid').val(ui.item.pelid);
                    $('#trans_invid').val(ui.item.invid);
                    $('#trans_nopol').val(ui.item.nopol);
                    $('#total_tagihan').val(formatCurrency(ui.item.inv_total));
                    $('#total_uangmuka').val(formatCurrency(ui.item.uangmuka));
                    $('#dtrans_nominal1').val(formatCurrency(ui.item.inv_total - ui.item.uangmuka));
                    countTotal();
                }else{
                    alertDialog('No Work Order tidak valid');
                }
            }
        });
    }
    
    function terbilang(total){
        $('#terbilang').html((toWords(total)+" rupiah").toUpperCase());
    }
    
    function displayDate(){
        $( ".datepicker").datepicker({
            changeMonth: true,
            changeYear: true,        
            dateFormat:'dd-mm-yy'		
        });	
    }

    function countTotal(){
        var totalTag = 0;
        var totalUm = 0;
        var total = 0;
        var price;
        $("input[name^=dtrans_nominal]").each(function() {
            price = $(this).val().replace(/,/g, "");
            total += Number(price);
        });
        
        totalTag = Number($("#total_tagihan").val().replace(/,/g, ""));
        totalUm = Number($("#total_uangmuka").val().replace(/,/g, ""));
        
        $("#totalTrans").val(formatCurrency(totalTag - (totalUm + total)));
        terbilang(totalTag - (totalUm + total));
    }
    
     function checkDuplication(param){
          var matches = 0;
          var nilai;
          $("input[name^=dtrans_jenis]").each(function() {
              nilai=$(this).val();
            if ($(this).val() == param) {
              matches++;
            }
          });
          if(matches > 1){
              return true;
          }else{
              return false;
          } 
    }
    
    function changeType(target){
        if(checkDuplication($('#dtrans_jenis'+target).val()) == true ){
            $('#dtrans_jenis'+target).val('');
            alertDialog("Jenis transaksi tersebut sudah dipilih");
        }else{
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('transaksi_finance/jsonMainCoa') ?>',
                dataType: "json",
                async: false,
                data: {
                    type : $('#dtrans_jenis'+target).val()
                },
                success: function(data) {
                    $('#dtrans_coa'+target).html('');
                    $('#dtrans_coa'+target).append('<option value="">PILIH</option>');
                    $.each(data, function(messageIndex, message) {
                        $('#dtrans_coa'+target).append('<option value="' + message['coa_kode'] + '">' + message['coa_desc'] + '</option>');
                    });
                }
            })
        
            if($('#dtrans_jenis'+target).val() == '1'){
                $('#dtrans_trans'+target).val("KAS");
            }else if($('#dtrans_jenis'+target).val() == '2'){
                $('#dtrans_trans'+target).val("BNK");
            }else{
                $('#dtrans_trans'+target).val("CEK");
            }
        }
    }

    $(this).ready(function(){
        numberOnly();
        
        $( ".datepicker" ).datepicker({
            autoclose: true,
            todayHighlight: true,
            dateFormat:'dd-mm-yy'	
        })
        .next().on(ace.click_event, function(){
            $(this).prev().focus();
        });
        
        $('#formAdd').submit(function() {
            if($("#totalTrans").val())
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url($etc['targetSave']) ?>",
                dataType: "json",
                async: false,
                data: $(this).serialize(),
                success: function(data) {
                    window.scrollTo(0, 0);
                    if(data.status == true)
                        document.formAdd.reset();
                    $("#result").html(data.msg).show().fadeIn("slow");
                }
            })
            return false;
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
    });

    var scripts = [null, null]
    $('.page-content-area').ace_ajax('loadScripts', scripts, function() {
        //inline scripts related to this page
    });
</script> 
