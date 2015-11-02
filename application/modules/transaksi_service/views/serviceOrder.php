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

</style>
<script type="text/javascript">
    function addRowJasa() {
        var inc = $('.nomorjasa').length+1;
        $(".item-row-keluhan:last").after(
        '<tr class="item-row-keluhan">\n\
               <td class="nomorjasa"  style="text-align: center;">' + inc +'</td>\n\
                    <td>\n\
                        <input type="text" maxlength="60"  class="upper ace col-xs-10 col-sm-10" style="width:100%;" id="woj_keluhan' + inc + '"  name="woj_keluhan[]" /><input type="hidden" id="woj_flatid' + inc + '" name="woj_flatid[]" />\n\
                    </td>\n\
                    <td>\n\
                          <input type="text"  autocomplete="off" onkeyup="autoCompleteJasa(' + inc + ')" class="upper kodejasa ace col-xs-10 col-sm-10" style="width:100%;" id="wod_kode' + inc + '" name="wod_kode[]" />\n\
                   </td>\n\
                    <td>\n\
                           <input type="text"  autocomplete="off"  class="upper ace col-xs-10 col-sm-10" style="width:100%;" id="woj_namajasa' + inc + '" name="woj_namajasa[]" />\n\
                   </td>\n\
                    <td>\n\
                           <input type="text" readonly="readonly" autocomplete="off"  class="number ace col-xs-10 col-sm-10" style="width:100%;text-align: right" id="woj_rate' + inc + '" name="woj_rate[]" />\n\
                   </td>\n\
                    <td>\n\
                           <input type="text" readonly="readonly" autocomplete="off"  class="ace col-xs-10 col-sm-10" style="width:100%;text-align: right" id="woj_subtotal' + inc + '" name="woj_subtotal[]" />\n\
                   </td>\n\
                   <td class="center">\n\
                       <a class="green btnAdd"  onclick="addRowJasa()" href="javascript:;"><i class="ace-icon fa fa-search-plus bigger-130"></i></a>\n\
                    </td>\n\
                    <td class="center">\n\
                        <a class="red btnDeleteJasa" href="javascript:;"><i class="ace-icon fa fa-trash-o bigger-130"></i></a>\n\
                  </tr>\n\
               </tr>');
                            
                            $(".btnDeleteJasa").bind("click", Delete);
                            numberOnly();
                        }
        
                        function addRowSp() {
                            var inc = $('.nomorsp').length+1;
                            $(".item-row-sp:last").after(
                            '<tr class="item-row-sp">\n\
               <td class="nomorsp"  style="text-align: center;">' + inc +'</td>\n\
                    <td>\n\
                         <input type="text"  autocomplete="off" onkeyup="autoCompleteSp(' + inc + ')"  class="ace col-xs-10 col-sm-10" style="width:100%;" id="wod_kodesp' + inc + '" name="wod_kodesp[]" /><input type="hidden" id="wop_inveid' + inc + '" name="wop_inveid[]" />\n\
                    </td>\n\
                    <td>\n\
                          <input type="text" readonly="readonly"  autocomplete="off"  class="ace col-xs-10 col-sm-10" style="width:100%;" id="inve_nama' + inc + '" name="inve_nama[]" />\n\
                   </td>\n\
                    <td>\n\
                           <input type="text" value="0" autocomplete="off" onchange="subTotalSp(' + inc + ')"  class="number ace col-xs-10 col-sm-10" style="width:100%;text-align: right" id="wop_qty' + inc + '" name="wop_qty[]" />\n\
                   </td>\n\
                    <td>\n\
                           <input type="text" readonly="readonly" value="0" autocomplete="off"  class="number ace col-xs-10 col-sm-10" style="width:100%;text-align: right" id="wop_harga' + inc + '" name="wop_harga[]" />\n\
                   </td>\n\
                    <td>\n\
                           <input type="text" readonly="readonly" autocomplete="off"  class="ace col-xs-10 col-sm-10" style="width:100%;text-align: right" id="wop_subtotal' + inc + '" name="wop_subtotal[]" />\n\
                   </td>\n\
                   <td class="center">\n\
                       <a class="green btnAdd"  onclick="addRowSp()" href="javascript:;"><i class="ace-icon fa fa-search-plus bigger-130"></i></a>\n\
                    </td>\n\
                    <td class="center">\n\
                        <a class="red btnDeleteSp" href="javascript:;"><i class="ace-icon fa fa-trash-o bigger-130"></i></a>\n\
                  </tr>\n\
               </tr>');
                            
                            $(".btnDeleteSp").bind("click", DeleteSp);
                            numberOnly();
                        }
                        
                        function addRowSo() {
                            var inc = $('.nomorso').length+1;
                            $(".item-row-so:last").after(
                            '<tr class="item-row-so">\n\
               <td class="nomorso"  style="text-align: center;">' + inc +'</td>\n\
                    <td>\n\
                          <input type="text"  autocomplete="off"  class="ace col-xs-10 col-sm-10" style="width:100%;" id="wos_nama' + inc + '" name="wos_nama[]" />\n\
                   </td>\n\
                    <td>\n\
                           <input type="text" value="0" onchange="$(\'#\'+this.id).val(formatDefault(this.value));totalSo()" autocomplete="off"  class="number ace col-xs-10 col-sm-10" style="width:100%;text-align: right" id="wos_harga' + inc + '" name="wos_harga[]" />\n\
                   </td>\n\
                   <td class="center">\n\
                       <a class="green btnAdd"  onclick="addRowSo()" href="javascript:;"><i class="ace-icon fa fa-search-plus bigger-130"></i></a>\n\
                    </td>\n\
                    <td class="center">\n\
                        <a class="red btnDeleteSo" href="javascript:;"><i class="ace-icon fa fa-trash-o bigger-130"></i></a>\n\
                  </tr>\n\
               </tr>');
                            
                            $(".btnDeleteSo").bind("click", DeleteSo);
                            numberOnly();
                        }
</script>
<form class="form-horizontal" id="form" action="<?php echo site_url('transaksi_service/saveWo'); ?>" method="post" name="form">
    <?php
    $this->session->unset_userdata('href_wo');
    ?>
    <table style="width: 100%">
        <tr>
            <td style="width: 48%">
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Jenis WO</label>
                    <div class="col-sm-7">
                        <input type="text" style="text-align: center" readonly="readonly" value="<?php echo $jenis; ?>" name="wo_jenis" class="upper col-xs-10 col-sm-2" />

                    </div>
                </div>
            </td>
            <td  style="width: 48%">
                &nbsp;
            </td>
        </tr>
        <tr>
            <td>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1">No Polisi</label>
                    <div class="col-sm-7">
                        <div class='input-group'>
                            <input type="text" autocomplete="off" required="required" name="nopol" id="nopol" class="req upper col-xs-10 col-sm-5" />
                            <input type="hidden"  id="wo_mscid" name="wo_mscid" />
                            <input type="hidden"  id="type" name="wo_type" value="<?php echo $type; ?>"/>
                            <input type="hidden"  id="wo_inextern" name="wo_inextern"/>
                            <a href="#master_service/addKendaraanWo?href=transaksi_service/serviceOrder&jenis=<?php echo $jenis; ?>&type=<?php echo $type ?>&" class="btn btn-sm btn-primary">
                                <i class="ace-icon fa fa-plus"></i>
                                Tambah Kendaraan</a>
                        </div>
                    </div>
                </div>
            </td>
            <td>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Merk</label>
                    <div class="col-sm-7">
                        <input type="text" readonly="readonly" id="merk" name="merk" class="upper col-xs-10 col-sm-10" />
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Nama Pelanggan</label>
                    <div class="col-sm-7">
                        <input type="text" readonly="readonly"  id="pel_nama" name="pel_nama" class="upper col-xs-10 col-sm-10" />
                    </div>
                </div> 
            </td>
            <td>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Model</label>
                    <div class="col-sm-7">
                        <input type="text" readonly="readonly"  id="model" name="model" class="upper col-xs-10 col-sm-10" />
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Estimasi Diserahkan</label>
                    <div class="col-sm-7">
                        <div class='input-group date col-xs-10 col-sm-10' id='datetimepicker1'>
                            <input type='text' readonly="readonly" value="<?php echo date('d-m-Y H:i'); ?>" name="wo_selesai" class="form-control" />
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>
            </td>
            <td>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Kode Pelanggan</label>
                    <div class="col-sm-7">
                        <div class='input-group'>
                            <input type="text" required="required"  id="pelid" name="wo_pelid" class="req upper col-xs-10 col-sm-10" />
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Pembawa</label>
                    <div class="col-sm-7">
                        <div class='input-group'>
                            <input type="text" required="required" autocomplete="off"  id="wo_pembawa" name="wo_pembawa" class="req upper col-xs-10 col-sm-10" />
                        </div>
                    </div>
                </div>
            </td>
            <td>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Status</label>
                    <div class="col-sm-7">
                        <div class='input-group ace col-xs-10 col-sm-10'>
                            <select name="wo_tunggu" required="required" class="ace col-xs-10 col-sm-8">
                                <option value="">Pilih</option>
                                <option value="tunggu">Tunggu</option>
                                <option value="tinggal">Tinggal</option>
                            </select>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Nomerator Kertas</label>
                    <div class="col-sm-7">
                        <div class='input-group ace col-xs-10 col-sm-10'>
                            <input type="text" required="required" autocomplete="off"  id="wo_numerator" name="wo_numerator" class="req upper col-xs-10 col-sm-10" />
                        </div>
                    </div>
                </div>
            </td>
            <td>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Km</label>
                    <div class="col-sm-7">
                        <div class='input-group ace col-xs-10 col-sm-10'>
                            <input type="text" required="required" autocomplete="off"  id="wo_km" name="wo_km" class="req number col-xs-10 col-sm-4" />
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Final Checker</label>
                    <div class="col-sm-7">
                        <div class='input-group col-xs-10 col-sm-10'>
                            <select name="wo_sa" id="wo_sa" required="required" class="ace col-xs-10 col-sm-10 upper req">
                                <option value="">Pilih</option>
                                <?php
                                if (count($sa) > 0) {
                                    foreach ($sa as $value) {
                                        $select = ($value['krid'] == ses_krid) ? 'selected' : '';
                                        ?>
                                        <option value="<?php echo $value['krid']; ?>" <?php echo $select; ?>><?php echo $value['kr_nama'] ?></option> 
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </td>
            <td>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Stall</label>
                    <div class="col-sm-7">
                        <div class='input-group ace col-xs-10 col-sm-10'>
                            <select name="wo_stallid" required="required" class="req ace col-xs-10 col-sm-10">
                                <option value="">Pilih</option>
                                <?php
                                if (count($stall) > 0) {
                                    foreach ($stall as $value) {
                                        ?>
                                        <option value="<?php echo $value['stallid'] ?>"><?php echo $value['stall_nomer']; ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    </table>

    <div class="hr hr-16 hr-dotted"></div>
    <div>
        <div class="table-header">
            Daftar Analisa Pekerjaan
        </div>
        <div>
            <table id="simple-table-jasa" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th style="width: 3%">No</th>
                        <th style="width: 20%">Analisa Pekerjaan</th>
                        <th style="width: 15%">Kode Jasa</th>
                        <th style="width: 20%">Nama Jasa</th>
                        <th style="width: 10%">Rate/Jam</th>
                        <th style="width: 10%">Total</th>
                        <th style="width: 5%">Add</th>
                        <th style="width: 5%">Hapus</th>
                    </tr>
                </thead>

                <tbody>
                    <tr  class="item-row-keluhan">
                        <td class="nomorjasa" style="text-align: center;">
                            1
                        </td>
                        <td>
                            <div class='input-group ace col-xs-10 col-sm-10' style="width:100%;">
                                <input type="text" maxlength="60"  required="required" class="upper ace col-xs-10 col-sm-10" style="width:100%;"  name="woj_keluhan[]" />
                            </div>
                        </td>
                        <td>
                            <input type="text"  autocomplete="off" onkeyup="autoCompleteJasa(1)" class="upper kodejasa ace col-xs-10 col-sm-10" style="width:100%;" id="wod_kode1" name="wod_kode[]" />
                            <input type="hidden" id="woj_flatid1" name="woj_flatid[]" />
                        </td>
                        <td>
                            <input type="text"  autocomplete="off"  class="upper ace col-xs-10 col-sm-10" style="width:100%;" id="woj_namajasa1" name="woj_namajasa[]" />
                        </td>
                        <td>
                            <input type="text" readonly="readonly" autocomplete="off"  class="number ace col-xs-10 col-sm-10" style="width:100%;text-align: right" id="woj_rate1" name="woj_rate[]" />
                        </td>
                        <td>
                            <input type="text" readonly="readonly" autocomplete="off"  class="ace col-xs-10 col-sm-10" style="width:100%;text-align: right" id="woj_subtotal1" name="woj_subtotal[]" />
                        </td>
                        <td class="center">
                            <a class="green btnAdd"  onclick="addRowJasa()" href="javascript:;"><i class="ace-icon fa fa-search-plus bigger-130"></i></a>
                        </td>
                        <td  class="center">
                            &nbsp;
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="5" style="text-align: right">
                            TOTAL JASA
                        </th>
                        <th>
                            <input type="text" readonly="readonly" style="width: 100%;text-align: right;" value="0" name="total_jasa" id="total_jasa" class="total_jasa col-xs-10 col-sm-10" />  
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
    <div>
        <div class="table-header">
            Daftar Perkiraan Sparepart
        </div>
        <div>
            <table id="simple-table-sp" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th style="width: 3%">No</th>
                        <th style="width: 15%">Kode Sparepart</th>
                        <th style="width: 20%">Nama Sparepart</th>
                        <th style="width: 5%">Qty</th>
                        <th style="width: 10%">Harga Satuan</th>
                        <th style="width: 10%">Sub Total</th>
                        <th style="width: 5%">Add</th>
                        <th style="width: 5%">Hapus</th>
                    </tr>
                </thead>

                <tbody>
                    <tr  class="item-row-sp">
                        <td class="nomorsp" style="text-align: center;">
                            1
                        </td>
                        <td>
                            <input type="text" onkeyup="autoCompleteSp(1)"  autocomplete="off"  class="upper ace col-xs-10 col-sm-10" style="width:100%;" id="wod_kodesp1" name="wod_kodesp[]" />
                            <input type="hidden" id="wop_inveid1" name="wop_inveid[]" />
                        </td>
                        <td>
                            <input type="text" readonly="readonly"  autocomplete="off"  class="ace col-xs-10 col-sm-10" style="width:100%;" id="inve_nama1" name="inve_nama[]" />
                        </td>
                        <td>
                            <input type="text" value="0" autocomplete="off" onchange="subTotalSp('1')"  class="number ace col-xs-10 col-sm-10" style="width:100%;text-align: right" id="wop_qty1" name="wop_qty[]" />
                        </td>
                        <td>
                            <input type="text" value="0" readonly="readonly" autocomplete="off"  class="number ace col-xs-10 col-sm-10" style="width:100%;text-align: right" id="wop_harga1" name="wop_harga[]" />
                        </td>
                        <td>
                            <input type="text" readonly="readonly" autocomplete="off"  class="ace col-xs-10 col-sm-10" style="width:100%;text-align: right" id="wop_subtotal1" name="wop_subtotal[]" />
                        </td>
                        <td class="center">
                            <a class="green btnAdd"  onclick="addRowSp()" href="javascript:;"><i class="ace-icon fa fa-search-plus bigger-130"></i></a>
                        </td>
                        <td  class="center">
                            &nbsp;
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="5" style="text-align: right">
                            TOTAL SPAREPART
                        </th>
                        <th>
                            <input type="text" readonly="readonly" style="width: 100%;text-align: right;" value="0" name="total_sp" id="total_sp" class="total_sp col-xs-10 col-sm-10" />  
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
    <div>
        <div class="table-header">
            Daftar Perkiraan Sub Order
        </div>
        <div>
            <table id="simple-table-so" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th style="width: 3%">No</th>
                        <th style="width: 40%">Nama Perbaikan</th>
                        <th style="width: 15%">Harga</th>
                        <th style="width: 5%">Add</th>
                        <th style="width: 5%">Hapus</th>
                    </tr>
                </thead>

                <tbody>
                    <tr  class="item-row-so">
                        <td class="nomorso" style="text-align: center;">
                            1
                        </td>
                        <td>
                            <input type="text"  autocomplete="off"  class="upper ace col-xs-10 col-sm-10" style="width:100%;" id="wos_nama1" name="wos_nama[]" />
                        </td>
                        <td>
                            <input type="text" value="0" onchange="$('#'+this.id).val(formatDefault(this.value));totalSo()" autocomplete="off"  class="number ace col-xs-10 col-sm-10" style="width:100%;text-align: right" id="wos_harga1" name="wos_harga[]" />
                        </td>
                        <td class="center">
                            <a class="green btnAdd"  onclick="addRowSo()" href="javascript:;"><i class="ace-icon fa fa-search-plus bigger-130"></i></a>
                        </td>
                        <td  class="center">
                            &nbsp;
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="2" style="text-align: right">
                            TOTAL SUB ORDER
                        </th>
                        <th>
                            <input type="text" readonly="readonly" style="width: 100%;text-align: right;" value="0" name="total_so" id="total_so" class="total_so col-xs-10 col-sm-10" />  
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
    $(function () {
        $('#datetimepicker1').datetimepicker({format: 'DD-MM-YYYY HH:mm'});
    });
    
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
                nopol: {
                    required: true
                },
                wo_pelid: {
                    required: true
                },
                wo_stallid: {
                    required: true
                },
                wo_pembawa: {
                    required: true
                },
                wo_numerator: {
                    required: true
                },
                wo_tunggu: {
                    required: true
                },
                wo_km: {
                    required: true
                }
            },
			
            messages: {
                nopol: {
                    required: "Pastikan nopol tidak kosong"
                },
                wo_pelid: {
                    required: "Pastikan kode pelanggan tidak kosong"
                },
                wo_tunggu: {
                    required: "Pastikan pilih status"
                },
                wo_pembawa: {
                    required: "Pastikan nama pembawa diisi"
                },
                wo_stallid: {
                    required: "Pastikan stall dipilih"
                },
                wo_numerator: {
                    required: "Pastikan numrator diisi"
                },
                wo_km: {
                    required: "Pastikan km tidak kosong"
                }
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
    
    function getDataKendaraan(nopol)
    {
        $.ajax({
            url: '<?php echo site_url('transaksi_service/jsonDataKendaraan'); ?>',
            dataType: 'json',
            type: 'POST',
            data: {param : nopol},
            success: function(data) {
                if (data.response) {
                    $("#pel_nama").val(data.data['pel_nama']);
                    $("#pelid").val(data.data['pelid']);
                    $("#wo_mscid").val(data.data['mscid']);
                    $("#merk").val(data.data['merk_deskripsi']);
                    $("#wo_inextern").val(data.data['msc_inextern']);
                    $("#model").val(data.data['model_deskripsi']);
                }else{
                    bootbox.dialog({
                        message: "<span class='bigger-110'>Maaf, Nomor Polisi Ini Tidak Terdaftar</span>",
                        buttons: 			
                            {
                            "danger" :
                                {
                                "label" : "Error !!",
                                "className" : "btn-sm btn-danger"
                            }
                        }
                    });
                    $("#pel_nama").val('');
                    $("#pelid").val('');
                    $("#wo_mscid").val('');
                    $("#merk").val('');
                    $("#model").val('');
                }
                $('.page-content-area').ace_ajax('stopLoading', true);
            }
            
        });
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
    
                           
    
    var scripts = [null, null]
    $('.page-content-area').ace_ajax('loadScripts', scripts, function() {
        //inline scripts related to this page
    });
    function clearForm()
    {
        var otable = document.getElementById('simple-table-jasa');
        var counti = otable.rows.length - 2;
        while (counti > 1) {
            otable.deleteRow(counti);
            counti--;
        }
        var otable = document.getElementById('simple-table-sp');
        var counti = otable.rows.length - 2;
        while (counti > 1) {
            otable.deleteRow(counti);
            counti--;
        }
        var otable = document.getElementById('simple-table-so');
        var counti = otable.rows.length - 2;
        while (counti > 1) {
            otable.deleteRow(counti);
            counti--;
        }
    }

    var inc = 0;
    function Delete() {
        var par = $(this).parent().parent(); //tr
        par.remove();
        totalJasa();
    }
    function DeleteSp() {
        var par = $(this).parent().parent(); //tr
        par.remove();
        totalSp();
    }
    function DeleteSo() {
        var par = $(this).parent().parent(); //tr
        par.remove();
        totalSo();
    }
    
    
    function totalJasa()
    {
        var total = 0;
        var price;
        $("input[name^=woj_subtotal]").each(function() {
            price = $(this).val().replace(/,/g, "");
            total += Number(price);
        });
        $("#total_jasa").val(formatDefault(total));
    }
    function totalSp()
    {
        var total = 0;
        var price;
        $("input[name^=wop_subtotal]").each(function() {
            price = $(this).val().replace(/,/g, "");
            total += Number(price);
        });
        $("#total_sp").val(formatDefault(total));
    }
    function totalSo()
    {
        var total = 0;
        var price;
        $("input[name^=wos_harga]").each(function() {
            price = $(this).val().replace(/,/g, "");
            total += Number(price);
        });
        $("#total_so").val(formatDefault(total));
    }
                        
    function subTotalSp(inc)
    {
        var qty = cekDefaultNol($("#wop_qty"+inc).val().replace(/,/g, ""));
        var harga = cekDefaultNol($("#wop_harga"+inc).val().replace(/,/g, ""));
        $("#wop_subtotal"+inc).val(formatDefault(qty*harga));
        totalSp();
    }
    
    
    function autoCompleteJasa(inc)
    {
        $("#wod_kode" + inc).autocomplete({
            minLength: 1,
            source: function(req, add) {
                $.ajax({
                    url: "<?php echo site_url('transaksi_service/getFlateRateAuto'); ?>",
                    dataType: 'json',
                    type: 'POST',
                    data: {
                        term : $("#wod_kode" + inc).val(),
                        type : $("#type").val()
                    },
                    success: function(data) {
                        add(data);
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
                $("input[name^=wod_kode]").each(function() {
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
    function autoCompleteSp(inc)
    {
        $("#wod_kodesp" + inc).autocomplete({
            minLength: 1,
            source: function(req, add) {
                $.ajax({
                    url: '<?php echo site_url('master_sparepart/jsonBarang'); ?>',
                    dataType: 'json',
                    type: 'POST',
                    data: {param : $("#wod_kodesp" + inc).val()},
                    success: function(data) {
                        add(data);
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
                $("input[name^=wod_kode]").each(function() {
                    var k = $(this).val().replace(/,/g, "");
                    if (k == kode) {
                        bootbox.dialog({
                            message: "<span class='bigger-110'>Maaf, Kode barang Ini Sudah dipilih</span>",
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
                    getDataSp(ui.item.value,inc);
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
                    $("#woj_namajasa"+inc).val(data.data['flat_deskripsi']);
                    $("#woj_flatid"+inc).val(data.data['flatid']);
                    $("#woj_rate"+inc).val(formatDefaultTanpaDecimal(data.data['flat_lc']));
                    $("#woj_subtotal"+inc).val(formatDefaultTanpaDecimal(data.data['flat_total']));
                    totalJasa();
                }else{
                    $("#woj_namajasa"+inc).val('');
                    $("#woj_flatid"+inc).val('');
                    $("#woj_rate"+inc).val(0);
                    $("#woj_subtotal"+inc).val(0);
                    totalJasa();
                }
            }
        });
    }
    
    function getDataSp(kode, inc)
    {
        $.ajax({ 
            url: '<?php echo site_url('master_sparepart/jsonDataBarang'); ?>',
            dataType: 'json',
            type: 'POST',
            data: {param : kode},
            success: function(data){
                if (data['response']) {
                    $("#inve_nama"+inc).val(data['inve_nama']);
                    $("#wop_inveid"+inc).val(data['inveid']);
                    $("#wop_harga"+inc).val(formatDefault(data['inve_harga']));
                    $("#wop_qty"+inc).val(1);
                    $("#wop_subtotal"+inc).val(formatDefault(data['inve_harga']));
                    totalSp();
                }else{
                    $("#inve_nama"+inc).val('');
                    $("#wop_inveid"+inc).val('');
                    $("#wop_harga"+inc).val(0);
                    $("#wop_qty"+inc).val(0);
                    $("#wop_subtotal"+inc).val();
                    totalSp();
                }
            }
        });
    }
    
    
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
                        window.open("<?php echo site_url("transaksi_service/printWo"); ?>/"+data.kode,'_blank', params);
                    }
                    $("#result").html(data.msg).show().fadeIn("slow");
                }
            })
        });
        $("#nopol").autocomplete({
            minLength: 1,
            source: function(req, add) {
                $.ajax({
                    url: '<?php echo site_url('transaksi_service/jsonNopol'); ?>',
                    dataType: 'json',
                    type: 'POST',
                    data: {param : $("#nopol").val()},
                    success: function(data) {
                        add(data);
                    }
                });
            },
            create: function () {
                $(this).data('ui-autocomplete')._renderItem = function (ul, item) {
                    return $('<li>')
                    .append("<a><strong>" + item.value + "</strong><br>" + item.msc_norangka + "</a>")
                    .appendTo(ul);
                };
            },select: function(event, ui) {
                $('.page-content-area').ace_ajax('startLoading');
                getDataKendaraan(ui.item.value);
            }
        })
    });
    
    
</script> 
