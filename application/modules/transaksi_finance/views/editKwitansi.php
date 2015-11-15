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
            <input type="hidden" id="trans_purpose" name="trans_purpose" value="<?php echo $etc['purpose']; ?>" />
            <input type="hidden" id="trans_trans" name="trans_trans" value="<?php echo $etc['trans']; ?>" />
            <input type="hidden" id="trans_type" name="trans_type" value="<?php echo $etc['type']; ?>" />
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
        <label class="col-sm-2 control-label no-padding-left" for="form-field-1">Jenis Penerimaan</label>
        <div class="col-sm-3">
            <select id="trans_jenis" name="trans_jenis" required="required" onchange="changeType();" class="form-control input-medium req">
                <option value="">PILIH</option>
                <option value ="1">KAS</option>
                <option value ="2">BANK</option>
                <option value ="3">CEK</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-left" for="form-field-1">Account Penyimpanan</label>
        <div class="col-sm-3">
            <select id="trans_coa" name="trans_coa" required="required" class="form-control input-xlarge req"></select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-left" for="form-field-1">Pelanggan</label>
        <div class="col-sm-6">
            <input type="text" id="trans_pelname" name="trans_pelname" required="required" maxlength="50" 
                   onkeyup="acomplete('trans_pelname', 'auto_pelid', 'trans_pelid', '','')"class="req upper ace col-xs-10 col-sm-4" />
            <a href="#master_service/addPelanggan?href=transaksi_finance/kwitansi" class="btn btn-sm btn-primary">
                <i class="ace-icon fa fa-plus"></i>
                Tambah Pelanggan</a>
            <input type="hidden" id="trans_pelid" name="trans_pelid" />
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
                        <th style="width: 25%">DESKRIPSI</th>
                        <th style="width: 10%">NO. NOTA</th>
                        <th style="width: 10%">COST CENTER</th>
                        <th style="width: 20%">NOMINAL</th>
                        <th style="width: 5%">ADD</th>
                        <th style="width: 5%">HAPUS</th>
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
                                   onkeyup="acomplete('dtrans_nota1', 'auto_faktur', 'dtrans_notaid1', '', '')" 
                                   class="ace col-xs-10 col-sm-10" style="width:100%;"  name="dtrans_nota[]" id="dtrans_nota1" />
                            <input type="hidden" id="dtrans_notaid1"  name="dtrans_notaid[]" />
                        </td>
                        <td>
                            <select class="form-control input-small" style="width:100%;"  name="dtrans_ccid[]" id="dtrans_ccid">
                                <option value ="0"></option>
                                <?php
                                foreach ($etc['costcenter'] as $ccid) {
                                    echo "<option value = '" . $ccid['ccid'] . "'>" . $ccid['cc_kode'] . " | " . $ccid['cc_name'] . "</option>";
                                }
                                ?>
                            </select>
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
                        <th colspan="5" style="text-align: right">
                            TOTAL
                        </th>
                        <th>
                            <input type="text" readonly="readonly" style="width: 100%;text-align: right;" 
                                   value="0" name="totalTrans" id="totalTrans" class="col-xs-10 col-sm-10" />  
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
    
    <div id="bank" style="display:none;">
        <div class="table-header">
            DETAIL BANK
        </div>
        <div>
            <table id="simple-table-bank" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th style="width: 2%">NO</th>
                        <th style="width: 20%">BANK</th>
                        <th style="width: 10%">NO. REK</th>
                        <th style="width: 10%">NO. CEK</th>
                        <th style="width: 10%">JTH. TEMPO</th>
                        <th style="width: 10%">KOTA</th>
                        <th style="width: 15%;">NOMINAL</th>
                        <th style="width: 4%">ADD</th>
                        <th style="width: 4%">HAPUS</th>
                    </tr>
                </thead>
                <tbody>
                    <tr  class="item-row-bank">
                        <td class="detailbank" style="text-align: center;">
                            1
                        </td>
                        <td>
                            <input type="text"  autocomplete="off" onkeyup="acomplete('dbnk_bankname1', 'auto_bank', 'dbnk_bankid1', '', '')"  
                                   placeholder="BANK" class="upper ace col-xs-10 col-sm-10" style="width:100%;" id="dbnk_bankname1"  name="dbnk_bankname[]" />
                            <input type="hidden" id="dbnk_bankid1"  name="dbnk_bankid[]" />
                        </td>
                        <td>
                            <input type="text" class="upper ace col-xs-10 col-sm-10" style="width:100%;" placeholder="NO. REK" name="dbnk_norek[]" id="dbnk_norek1" />
                        </td>
                        <td>
                            <input type="text" class="upper ace col-xs-10 col-sm-10" style="width:100%;" placeholder="NO. CEK" name="dbnk_nocek[]" id="dbnk_nocek1" />
                        </td>
                        <td>
                            <input type="text" class="ace col-xs-10 col-sm-10 datepicker" style="width:100%;"
                                   placeholder="TGL. JTEMPO" name="dbnk_jtempo[]" id="dbnk_jtempo1" />
                        </td>
                        <td>
                            <input type="text"  autocomplete="off" onkeyup="acomplete('dbnk_kota1', 'auto_kota', 'dbnk_kotaid1', '', '')" 
                                   class="upper ace col-xs-10 col-sm-10" style="width:100%;"  name="dbnk_kota[]" id="dbnk_kota1" />
                            <input type="hidden"  name="dbnk_kotaid[]" id="dbnk_kotaid1" />
                        </td>
                        <td>
                            <input type="text" autocomplete="off" value="0" onchange="$('#'+this.id).val(formatCurrency(this.value));" onkeyup="countTotalBank()"  
                                   class="number ace col-xs-10 col-sm-10" style="width:100%;text-align: right"  name="dbnk_nominal[]" id="dbnk_nominal1" />
                        </td>
                        <td class="center" style="vertical-align:middle;">
                            <a class="green btnAdd"  onclick="addRowBank()" href="javascript:;"><i class="ace-icon fa fa-plus bigger-130"></i></a>
                        </td>
                        <td  class="center" style="vertical-align:middle;">
                            <a class="red btnDelete" href="javascript:;"><i class="ace-icon fa fa-trash-o bigger-130"></i></a>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="6" style="text-align: right">
                            TOTAL BANK
                        </th>
                        <th>
                            <input type="text" readonly="readonly" style="width: 100%;text-align: right;" value="0" name="totalTransBank" 
                                   id="totalTransBank" class="col-xs-10 col-sm-10" />  
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
        <div>TERBILANG : </div>
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
        /*bootbox.confirm(" ?", function(result) {
            if(result) { */
                window.location.href = "#transaksi_finance/daftarKwitansi";
            //}});
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
                                onkeyup = "acomplete(\'dtrans_nota'+inc+'\', \'auto_faktur\', \'dtrans_notaid'+inc+'\', \'dtrans_pelid'+inc+'\', \'dtrans_pelname'+inc+'\')"\n\
                                placeholder = "NO. NOTA"\n\
                                name="dtrans_nota[]" id="dtrans_nota'+ inc +'" />\n\
                            <input type="hidden" name="dtrans_notaid[]" id="dtrans_notaid'+inc+'"/>\n\
                            <input type="hidden" name="dtrans_pelid[]" id="dtrans_pelid'+inc+'"/>\n\
                         </td>\n\
                         <td>\n\
                            <select class="form-control input-small" style="width:100%;"  name="dtrans_ccid[]" id="dtrans_ccid'+inc+'">\n\
                                <option value="0"></option>\n\<?php foreach ($etc['costcenter'] as $ccid){    
                                    echo "<option value = \'" . $ccid['ccid'] . "\'>" . $ccid['cc_kode'] . " | " . $ccid['cc_name'] . "</option>";}?>\n\
                            </select>\n\
                             <input type="hidden" name="dtrans_supid[]" id="dtrans_supid'+inc+'/>"\n\
                         </td>\n\
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
        
    function addRowBank() {
        var inc = $('.detailbank').length+1;
        $(".item-row-bank:last").after('<tr class="item-row-bank">\n\
               <td class="detailbank center" style="vertical-align:middle;">' + inc + '<input type="hidden" name="no[]" id="no'+ inc +'"  /></td>\n\
                    <td>\n\
                        <input type="text"  autocomplete="off" placeholder="BANK"\n\
                            onkeyup="acomplete(dbnk_bankname'+inc+', auto_bank, dbnk_bankid'+inc+',\'\', \'\')"\n\ \n\
                            class="upper ace col-xs-10 col-sm-10" style="width:100%;" id="dbnk_bank'+ inc +'"  name="dbnk_bank[]" />\n\
                       <input type="hidden" id="dbnk_bankid'+ inc +'" name="dbnk_bankid[]" />\n\
                    </td>\n\
                    <td>\n\
                       <input type="text" placeholder="NO. REK" class="upper ace col-xs-10 col-sm-10" style="width:100%;"name="dbnk_norek[]" id="dbnk_norek'+ inc +'" />\n\
                   </td>\n\
                   <td>\n\
                       <input type="text" placeholder="NO. CEK" class="upper ace col-xs-10 col-sm-10" style="width:100%;" name="dbnk_nocek[]" id="dbnk_nocek'+ inc +'" />\n\
                    </td>\n\
                   <td>\n\
                       <input type="text" placeholder="TGL. JTEMPO" class="upper ace col-xs-10 col-sm-10 datepicker" style="width:100%;" name="dbnk_jtempo[]" \n\
                            id="dbnk_jtempo'+ inc +'" />\n\
                    </td>\n\
                    <td>\n\
                        <input type="text" placeholder="KOTA" autocomplete="off" onkeyup = "acomplete(\'dbnk_kota'+inc+'\', \'auto_kota\', \'dbnk_kotaid'+inc+'\', \'\', \'\')"\n\
                            class="upper ace col-xs-10 col-sm-10" style="width:100%;" name="dbnk_kota[]" id="dbnk_kota'+ inc +'" />\n\
                        <input type="hidden" name="dbnk_kotaid[]" id="dbnk_kotaid'+ inc +'" />\n\
                    </td>\n\
                    <td>\n\
                        <input type="text" class="number ace col-xs-10 col-sm-10" style="width:100%;text-align: right" \n\
                           onchange="$(\'#\'+this.id+\'\').val(formatCurrency(this.value));" onkeyup="countTotalBank()" \n\
                             name="dbnk_nominal[]" id="dbnk_nominal'+ inc +'" />\n\
                    </td>\n\
                    <td class="center" style="vertical-align: middle;">\n\
                        <a class="green btnAdd"  onclick="addRowBank()" href="javascript:;"><i class="ace-icon fa fa-plus bigger-130"></i></a>\n\
                    </td>\n\
                    <td class="center" style="vertical-align: middle;">\n\
                        <a class="red btnDelete" href="javascript:;"><i class="ace-icon fa fa-trash-o bigger-130"></i></a>\n\
                    </td>\n\
                  </tr>\n\
               </tr>');
        $(".btnDelete").bind("click", Delete);
        displayDate();
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
                
                if(url='auto_pelid'){
                     row.find("input[name^=dtrans_pelid]").val(ui.item.trglocal);
                }



            }
        });
    }
    
    function getDetailTrans(kstid) {
        var inc = 0;
        kstid = kstid.toUpperCase();
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('transaksi_finance/getDetailTrans'); ?>",
            data: {kstid : kstid},
            dataType: 'json',
            success: function(data) {
                if (data.main.kstid != '') {
                    var tgl = data.main.kst_tgl.split("-");
                    $('.item-row').children().remove();
                    $("#trans_docno").val(data.main.kst_nomer);
                    $("#trans_kstid").val(data.main.kstid);
                    $("#trans_pelname").val(data.main.pel_nama);
                    $("#trans_pelid").val(data.main.kst_pelid);
                    $("#trans_desc").val(data.main.kst_desc);
                    $("#trans_noreff").val(data.main.kst_noreff);
                    $("#trans_tgl").val(tgl[2] + '-' + tgl[1] + '-' + tgl[0]);
                    $("#trans_trans").val(data.main.kst_trans);
                    $("#trans_type").val(data.main.kst_type);
                    if( $('#trans_trans').val() == 'KWIKAS'){
                        $('#trans_jenis').val('1');
                    }else if( $('#trans_trans').val() == 'KWIBNK'){
                        $('#trans_jenis').val('2');
                    }else{
                        $('#trans_jenis').val('3');
                    }
                    changeType();
                     $("#trans_coa").val(data.main.kst_coa);

                    for (var i = 0; i < data.detail.length; i++) {
                        addRow();
                        inc = i+1;
                        $("#dtrans_coa" + inc).val(data.detail[i].dkst_coa);
                        if ((data.detail[i].dkst_coa == "<?php echo PIUTANG_UNIT; ?>")) {
                            $("#dtrans_nota" + inc ).css('background-color', '#FFCCCC');
                        }
                        $("#dtrans_desc" + inc).val(data.detail[i].dkst_descrip);
                        //$("#dtrans_pelnama" + inc).val(data.detail[i].dkst_ccid);
                        $("#dtrans_pelid" + inc).val(data.detail[i].dkst_pelid);
                        $("#dtrans_ccid" + inc).val(data.detail[i].dkst_ccid);
                        //$("#dtrans_supnama" + inc).val(data.detail[i].dkst_supnama);
                        $("#dtrans_supid" + inc).val(data.detail[i].dkst_supid);
                        if(data.main.kst_type == 'I'){
                            $("#dtrans_nominal" + inc).val(formatCurrency(data.detail[i].dkst_kredit));
                        }else{
                            $("#dtrans_nominal" + inc).val(formatCurrency(data.detail[i].dkst_debit));
                        }
                    }
                    countTotal();

                <?php
                if ($etc['trans'] != 'KWIKAS') {
                    ?>
                        $('.item-row-bank').children().remove();
                        inc = 0;
                        for (var i = 0; i < data.bank.length; i++) {
                            addRowBank();
                            inc = i+1;
                            $("#dbnk_bank" + inc ).val(data.bank[i].dbnk_banknama);
                            $("#dbnk_bankid" + inc ).val(data.bank[i].dbnk_bankid);
                            $("#dbnk_norek" + inc ).val(data.bank[i].dbnk_norek);
                            $("#dbnk_nocek" + inc ).val(data.bank[i].dbnk_nocek);
                            $("#dbnk_kota" + inc ).val(data.bank[i].dbnk_kotanama);
                            $("#dbnk_kotaid" + inc ).val(data.bank[i].dbnk_kotaid);
                            var tgl = data.bank[i].dbnk_jtempo.split("-");
                            $("#dbnk_jtempo" + inc).val(tgl[2] + '-' + tgl[1] + '-' + tgl[0]);
                            $("#dbnk_nominal" + inc).val(formatCurrency(data.bank[i].dbnk_nominal));
                        }
                        countTotalBank();
                <?php
                }
                ?>
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
        var total = 0;
        var price;
        $("input[name^=dtrans_nominal]").each(function() {
            price = $(this).val().replace(/,/g, "");
            total += Number(price);
        });
        $("#totalTrans").val(formatCurrency(total));
        terbilang(total);
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
    
    function changeType(){
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('transaksi_finance/jsonMainCoa') ?>',
            dataType: "json",
            async: false,
            data: {
                type : $('#trans_jenis').val()
            },
            success: function(data) {
                $('#trans_coa').html('');
                $('#trans_coa').append('<option value="">PILIH</option>');
                $.each(data, function(messageIndex, message) {
                    $('#trans_coa').append('<option value="' + message['coa_kode'] + '">' + message['coa_desc'] + '</option>');
                });
            }
        })
        
        if($('#trans_jenis').val() == '1'){
            $('#bank').hide();
            $('#trans_trans').val("KWIKAS");
        }else if($('#trans_jenis').val() == '2'){
            $('#trans_trans').val("KWIBNK");
            $('#bank').show();
        }else{
            $('#trans_trans').val("KWICEK");
            $('#bank').show();
        }
    }

    $(this).ready(function() {
        $( ".datepicker" ).datepicker({
            autoclose: true,
            todayHighlight: true,
            dateFormat:'dd-mm-yy'	
        })
        .next().on(ace.click_event, function(){
            $(this).prev().focus();
        });
        
        getDetailTrans('<?php echo $etc['kstid'];?>');

        $('#formAdd').submit(function() {
            if($("#totalTrans").val())
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url($etc['targetSave']); ?>",
                dataType: "json",
                async: false,
                data: $(this).serialize(),
                success: function(data) {
                    window.scrollTo(0, 0);
                    if(data.status == true){
                        document.formAdd.reset();
                        redirect('data');
                    }
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
