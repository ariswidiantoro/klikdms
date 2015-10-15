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
        <label class="col-sm-2 control-label no-padding-left" for="form-field-1">No. Transaksi</label>
        <div class="col-sm-3">
            <input type="text" id="trans_docno" name="trans_docno" required="required" maxlength="20" class="upper form-control input-xlarge req" />
            <input type="hidden" id="trans_kstid" name="trans_kstid" value="<?php echo $etc['kstid']; ?>" />
            <input type="hidden" id="trans_trans" name="trans_trans" value="<?php echo $etc['trans']; ?>" />
            <input type="hidden" id="trans_type" name="trans_type" value="<?php echo $etc['type']; ?>" />
            <input type="hidden" id="trans_purpose" name="trans_purpose" value="<?php echo $etc['purpose']; ?>" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-left" for="form-field-1">No. Referensi</label>
        <div class="col-sm-3">
            <input type="text" id="trans_noref" name="trans_noref"  maxlength="30" class="upper form-control input-xlarge" />
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
    <div id="detailtrans">
        <div class="table-header">
            DETAIL TRANSAKSI
        </div>
        <div>
            <table id="simple-table-jasa" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th style="width: 2%">NO</th>
                        <th style="width: 10%">COA</th>
                        <th style="width: 20%">DESKRIPSI</th>
                        <th style="width: 10%">NO. NOTA</th>
                        <th style="width: 10%">NO. CUSTOMER</th>
                        <th style="width: 10%">COST CENTER</th>
                        <th style="width: 10%">SUP. KODE</th>
                        <th style="width: 15%">DEBIT</th>
                        <th style="width: 15%">KREDIT</th>
                        <th style="width: 5%">ADD</th>
                        <th style="width: 5%">DEL</th>
                    </tr>
                </thead>
                <tbody>
                    <tr  class="item-row">
                        <td class="dtrans" style="text-align: center; vertical-align: middle;">
                            1
                        </td>
                        <td>
                            <input type="text"  autocomplete="off" 
                                   onkeyup="acomplete('dtrans_coa1', 'auto_coa', 'dtrans_coa1', 'dtrans_desc1', '')"  placeholder="COA"
                                   class="upper ace col-xs-10 col-sm-10" style="width:100%;" id="dtrans_coa1"  name="dtrans_coa[]" />
                        </td>
                        <td>
                            <input type="text" class="upper ace col-xs-10 col-sm-10" placeholder="DESKRIPSI"
                                   style="width:100%;"  name="dtrans_desc[]" id="dtrans_desc1" />
                        </td>
                        <td>
                            <input type="text" autocomplete ="off" placeholder="NO. NOTA"
                                   onkeyup="acomplete('dtrans_nota1', 'auto_spk', 'dtrans_notaid1', 'dtrans_pelid1', 'dtrans_pelname1')" 
                                   class="ace col-xs-10 col-sm-10" style="width:100%;"  name="dtrans_nota[]" id="dtrans_nota1" />
                            <input type="hidden" id="dtrans_notaid1"  name="dtrans_notaid[]" />
                        </td>
                        <td>
                            <input type="text" autocomplete ="off" placeholder="NO. CUSTOMER"
                                   onkeyup="acomplete('dtrans_pelname1', 'auto_plg', 'dtrans_pelid1', '', '')" 
                                   class="ace col-xs-10 col-sm-10" style="width:100%;"  name="dtrans_pelname[]" id="dtrans_pelname1" />
                            <input type="hidden" id="dtrans_pelid1"  name="dtrans_pelid[]" />
                        </td>
                        <td>
                            <select class="form-control input-small" style="width:100%;"  name="dtrans_ccid[]" id="dtrans_ccid">
                                <option value =""></option>
                                <?php
                                foreach ($etc['costcenter'] as $ccid) {
                                    echo "<option value = '" . $ccid['ccid'] . "'>" . $ccid['cc_kode'] . " | " . $ccid['cc_name'] . "</option>";
                                }
                                ?>
                            </select>
                        </td>
                        <td>
                            <input type="text" autocomplete="off" 
                                   onkeyup="acomplete('dtrans_supname1', 'auto_supid', 'dtrans_supid1', '', '')" placeholder="ID SUPPLIER"
                                   class="number ace col-xs-10 col-sm-10" style="width:100%;"  name="dtrans_supnama[]" id="dtrans_supnama1" />
                            <input type="hidden" id="dtrans_supid1" name="dtrans_supid[]" />
                        </td>
                        <td>
                            <input type="text"  automplete="off"  class="number ace col-xs-10 col-sm-10" value="0" 
                                 onchange="$('#'+this.id).val(formatCurrency(this.value));" onkeyup="countDebit()"  
                                 style="width:100%;text-align: right" name="dtrans_debit[]" id="dtrans_debit" />
                        </td>
                        <td>
                            <input type="text"  automplete="off"  class="number ace col-xs-10 col-sm-10" value="0" 
                                 onchange="$('#'+this.id).val(formatCurrency(this.value));" onkeyup="countKredit()"  
                                 style="width:100%;text-align: right" name="dtrans_kredit[]" id="dtrans_kredit" />
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
                        <th colspan="7" style="text-align: right">
                            TOTAL
                        </th>
                        <th>
                            <input type="text" readonly="readonly" style="width: 100%;text-align: right;" 
                                   value="0" name="totalDebit" id="totalDebit" class="col-xs-10 col-sm-10" />  
                        </th>
                        <th>
                            <input type="text" readonly="readonly" style="width: 100%;text-align: right;" 
                                   value="0" name="totalKredit" id="totalKredit" class="col-xs-10 col-sm-10" />  
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
                Daftar Transaksi
            </button>
        </div>
    </div>
</form>

<script type="text/javascript">
    function redirect(data){
        bootbox.confirm("Anda yakin kembali ?", function(result) {
            if(result) {
                window.location.href = "#transaksi_finance/";
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
    
    function Delete() {
        var par = $(this).parent().parent(); //tr
        par.remove();
        countTotal();
        countTotalBank()
    }
    
    function addRow() {
        var inc = $('.dtrans').length+1;
        $(".item-row:last").after(
        '<tr class="item-row">\n\
                    <td class="dtrans center" style="vertical-align:middle;">' + inc + '</td>\n\
                         <td>\n\
                             <input type="text"  autocomplete="off" \n\
                                placeholder = "COA"\n\
                                onkeyup = "acomplete(\'dtrans_coa'+inc+'\', \'auto_coa\', \'dtrans_coa'+inc+'\', \'dtrans_desc'+inc+'\', \'\')"\n\
                                class="upper ace col-xs-10 col-sm-10" style="width:100%;" id="dtrans_coa'+ inc +'"  name="dtrans_coa[]" />\n\
                         </td>\n\
                         <td>\n\
                            <input type="text" autocomplete="off" class="upper ace col-xs-10 col-sm-10" style="width:100%;"\n\
                                placeholder = "DESKRIPSI"\n\
                                name="dtrans_desc[]" id="dtrans_desc'+ inc +'" />\n\
                        </td>\n\
                        <td>\n\
                            <input type="text" autocomplete="off" class="upper ace col-xs-10 col-sm-10" style="width:100%;"  \n\
                                onkeyup = "acomplete(\'dtrans_nota'+inc+'\', \'auto_spk\', \'dtrans_notaid'+inc+'\', \'dtrans_pelid'+inc+'\', \'dtrans_pelname'+inc+'\')"\n\
                                placeholder = "NO. NOTA"\n\
                                name="dtrans_nota[]" id="dtrans_nota'+ inc +'" />\n\
                            <input type="hidden" name="dtrans_notaid[]" id="dtrans_notaid'+inc+'"/>\n\
                         </td>\n\
                        <td>\n\
                            <input type="text" autocomplete="off" class="upper ace col-xs-10 col-sm-10" style="width:100%;"  \n\
                                onkeyup = "acomplete(\'dtrans_pelname'+inc+'\', \'auto_plg\', \'dtrans_pelid'+inc+'\', \'\', \'\')"\n\
                                placeholder = "NO. CUSTOMER"\n\
                                name="dtrans_pelname[]" id="dtrans_pelname'+ inc +'" />\n\
                            <input type="hidden" name="dtrans_pelid[]" id="dtrans_pelid'+inc+'"/>\n\
                         </td>\n\
                         <td>\n\
                            <select class="form-control input-small" style="width:100%;"  name="dtrans_ccid[]" id="dtrans_ccid'+inc+'">\n\
                                <option value=""></option>\n\<?php foreach ($etc['costcenter'] as $ccid){    
                                    echo "<option value = \'" . $ccid['ccid'] . "\'>" . $ccid['cc_kode'] . " | " . $ccid['cc_name'] . "</option>";}?>\n\
                            </select>\n\
                         </td>\n\
                         <td>\n\
                             <input type="text"  autocomplete="off" \n\
                                onkeyup="acomplete(dtrans_supnama'+inc+', auto_supid, dtrans_supid'+inc+', \'\', \'\')" \n\
                                placeholder = "ID SUPPLIER"\n\
                                class="upper ace col-xs-10 col-sm-10" style="width:100%;" \n\
                                name="dtrans_supnama[]" id="dtrans_supnama'+ inc +'" />\n\
                             <input type="hidden" name="dtrans_supid[]" id="dtrans_supid'+inc+'/>"\n\
                         </td>\n\
                         <td>\n\
                             <input type="text"  autocomplete="off" value= "0" onchange="$(\'#\'+this.id+\'\').val(formatCurrency(this.value));" onkeyup="countDebit()" \n\
                                class="upper ace col-xs-10 col-sm-10" style="width:100%;text-align: right"  \n\
                                name="dtrans_debit[]" id="dtrans_debit'+ inc +'" />\n\
                         </td>\n\
                         <td>\n\
                             <input type="text"  autocomplete="off" value= "0" onchange="$(\'#\'+this.id+\'\').val(formatCurrency(this.value));" onkeyup="countKredit()" \n\
                                class="upper ace col-xs-10 col-sm-10" style="width:100%;text-align: right"  \n\
                                name="dtrans_kredit[]" id="dtrans_kredit'+ inc +'" />\n\
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
            $("#" + id).autocomplete({
                minLength: 1,
                source: function(req, add) {
                    $.ajax({
                        url: "<?php echo site_url('auto_complete'); ?>/"+url,
                        dataType: 'json',
                        type: 'POST',
                        data: {
                            param : $("#" + id).val(),
                            cbid : '<?php echo ses_cabang; ?>'
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
                    $('#' + trglocal ).val(ui.item.trglocal);
                    if(trgid != ''){
                        $('#' + trgid).val(ui.item.trgid);
                        $('#' + trgname).val(ui.item.trgname);
                    }

                    if(url == 'auto_coa'){
                        /* UNIT */
                        if(ui.item.value == '100601'){
                              row.find("input[name^=dtrans_nota]").attr('required','required');
                              row.find("input[name^=dtrans_nota]").attr('required','required');
                        /* SERVICE */
                        }else if(ui.item.value == 'xx'){
                              row.find("input[name^=dtrans_nota]").attr('required','required');
                              row.find("input[name^=dtrans_nota]").attr('required','required');
                        }
                    }
                    
                    

                }
            });
        }
        
        function countTotal(){
            var total = 0;
            var price;
            $("input[name^=dtrans_nominal]").each(function() {
                price = $(this).val().replace(/,/g, "");
                total += Number(price);
            });
            $("#totalTrans").val(formatCurrency(total));
        }
        
        function countTotalBank(){
            var total = 0;
            var price;
            $("input[name^=dbnk_nominal]").each(function() {
                price = $(this).val().replace(/,/g, "");
                total += Number(price);
            });
            $("#totalTransBank").val(formatCurrency(total));
        }
    
        $(this).ready(function() {
            $( ".datepicker" ).datepicker({
                autoclose: true,
                todayHighlight: true
            })
            .next().on(ace.click_event, function(){
                $(this).prev().focus();
            });


            $('#formAdd').submit(function() {
                $.ajax({
                    type: 'POST',
                    url: "<?php echo site_url('transaksi_finance/saveTrans') ?>",
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
