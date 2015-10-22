<div id="result"></div>
<!--<div class="page-header">
    <h1>
        Surat Pesanan Kendaraan (SPK)
    </h1>
</div>-->
<script type="text/javascript">
    function addRow() {
        var inc = $('.dtlaksesories').length+1;
        $(".item-row:last").after('<tr  class="item-row">\n\
            <td class="dtlaksesories" style="text-align: center; vertical-align: middle;">\n\
                '+(inc)+'\n\
            </td>\n\
            <td>\n\
                <input type="text"  autocomplete="off" onkeyup="acomplete('+(inc)+')"  placeholder="NAMA AKSESORIES"\n\
                       class="upper ace col-xs-10 col-sm-10" style="width:100%;" id="dtrans_aksname'+(inc)+'"  name="dtrans_aksname[]" />\n\
                <input type="hidden"  id="dtrans_aksid1"  name="dtrans_aksid[]" />\n\
            </td>\n\
            <td>\n\
                    <input type="text" id="dtrans_harga'+(inc)+'" name="dtrans_harga[]"  placeholder="HARGA" class="form-control number upper" />\n\
            </td>\n\
            <td class="center" style="vertical-align: middle;">\n\
                <a class="green btnAdd"  onclick="addRow()" href="javascript:;"><i class="ace-icon fa fa-plus bigger-130"></i></a>\n\
            </td>\n\
            <td  class="center" style="vertical-align: middle;">\n\
                <a class="red btnDelete" href="javascript:;"><i class="ace-icon fa fa-trash-o bigger-130"></i></a>\n\
            </td>\n\
        </tr>');
                    $(".btnDelete").bind("click", Delete);
                    numberOnly();
                }
</script>
<form class="form-horizontal" id="formAdd" method="post" action="<?php echo site_url('transaksi_sales/saveSpk'); ?>" name="formAdd">

    <table style="width: 100%">
        <tr>
            <td  style="width: 48%">
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1">No Spk</label>
                    <div class="col-sm-7">
                        <input type="text" required="required" name="spk_no" id="spk_no"  
                               class="form-control input-xlarge upper req" />
                    </div>
                </div>  
            </td>
            <td  style="width: 48%">
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1">No. Fpt</label>
                    <div class="col-sm-7">
                        <input type="text" required="required" name="fpt_no" id="fpt_no"  
                               class="form-control input-xlarge upper req" />
                        <input type="hidden" name="spk_fptid" id="spk_fptid"/>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td  style="width: 48%">
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1">No. Kontrak</label>
                    <div class="col-sm-7">
                        <input type="text" required="required" name="spk_nokontrak" id="spk_nokontrak"  
                               class="form-control input-xlarge upper req" />
                    </div>
                </div>
            </td>
            <td  style="width: 48%">
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Merk Kendaraan</label>
                    <div class="col-sm-7">
                        <input type="text" required="required" readonly ="readonly"
                               name="spk_merk" id="spk_merk"  class="form-control input-xlarge upper req" />
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td  style="width: 48%">
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Kode. Customer</label>
                    <div class="col-sm-7">
                        <input type="text" required="required" readonly ="readonly"
                               name="spk_pelid" id="spk_pelid"  class="form-control input-xlarge upper req" />
                    </div>
                </div>
            </td>
            <td  style="width: 48%">
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Tipe Kendaraan</label>
                    <div class="col-sm-7">
                        <input type="text" required="required" readonly ="readonly"
                               name="spk_type" id="spk_type"  class="form-control input-xlarge upper req" />
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td  style="width: 48%">
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Nama. Customer</label>
                    <div class="col-sm-7">
                        <input type="text" required="required" readonly ="readonly"
                               name="spk_customername" id="spk_customername"  class="form-control input-xlarge  upper req" />
                    </div>
                </div>
            </td>
            <td  style="width: 48%">
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Warna Kendaraan</label>
                    <div class="col-sm-7">
                        <input type="text" required="required" readonly ="readonly"
                               name="spk_warna" id="spk_warna"  class="form-control input-xlarge  upper req" />
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td  style="width: 48%">
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Alamat Customer</label>
                    <div class="col-sm-7">
                        <textarea name="spk_alamat" id="spk_alamat" class="form-control input-xlarge  upper"> </textarea>
                    </div>
                </div>
            </td>
            <td  style="width: 48%">
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Kondisi</label>
                    <div class="col-sm-7">
                        <input type="text" required="required" readonly ="readonly"
                               name="spk_kondisi" id="spk_kondisi"  class="form-control input-xlarge  upper req" />
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td  style="width: 48%">
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Nama BPKB</label>
                    <div class="col-sm-7">
                        <input type="text" required="required" name="spk_namabpkb" id="spk_namabpkb"  
                               class="form-control input-xlarge upper req" />
                    </div>
                </div>
            </td>
            <td  style="width: 48%">
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Pembayaran</label>
                    <div class="col-sm-7">
                        <input type="text" readonly required
                               name="spk_paymethod" id="spk_paymethod"  class="form-control input-xlarge upper" />
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td  style="width: 48%">
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Alamat BPKB</label>
                    <div class="col-sm-7">
                        <textarea name="spk_alamatbpkb" id="spk_alamatbpkb" class="form-control input-xlarge  upper"> </textarea>
                    </div>
                </div>
            </td>
            <td  style="width: 48%">
            </td>
        </tr>
        <tr>
            <td  style="width: 48%">
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Salesman</label>
                    <div class="col-sm-7">
                        <input type="text" readonly name="spk_sales" id="spk_sales"  
                               class="form-control input-xlarge upper req" />
                    </div>
                </div>
            </td>
            <td  style="width: 48%">

            </td>
        </tr>

    </table>

    <div class="page-header">
        <h1>
            <small>
                Accessories
            </small>
        </h1>
    </div>
    <div id="detailtrans">
        <div class="table-header">
            DETAIL ACCESSORIES TAMBAHAN
        </div>
        <div>
            <table id="simple-table-aksesories" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th style="width: 2%">NO</th>
                        <th style="width: 15%">AKSESORIES</th>
                        <th style="width: 10%">HARGA</th>
                        <th style="width: 5%">ADD</th>
                        <th style="width: 5%">HAPUS</th>
                    </tr>
                </thead>
                <tbody>
                    <tr  class="item-row">
                        <td class="dtlaksesories" style="text-align: center; vertical-align: middle;">
                            1
                        </td>
                        <td>
                            <input type="text"  autocomplete="off" onkeyup="acomplete('1')"  placeholder="NAMA AKSESORIES"
                                   class="upper ace col-xs-10 col-sm-10" style="width:100%;" id="dtrans_aksname1"  name="dtrans_aksname[]" />
                            <input type="hidden"  id="dtrans_aksid1"  name="dtrans_aksid[]" />
                        </td>
                        <td>
                            <input type="text" id="dtrans_harga1" name="dtrans_harga[]"  placeholder="HARGA" class="form-control number upper" />
                        </td>
                        <td class="center" style="vertical-align: middle;">
                            <a class="green btnAdd"  onclick="addRow()" href="javascript:;"><i class="ace-icon fa fa-plus bigger-130"></i></a>
                        </td>
                        <td  class="center" style="vertical-align: middle;">
                            <a class="red btnDelete" href="javascript:;"><i class="ace-icon fa fa-trash-o bigger-130"></i></a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="page-header">
        <h1>
            <small>
                Harga
            </small>
        </h1>
    </div>
    <table style="width: 100%">
        <tr>
            <td  style="width: 48%">
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Uang Muka</label>
                    <div class="col-sm-7">
                        <input type="text" maxlength="8" readonly
                               name="spk_uangmuka"  value="0" id="spk_uangmuka"  class="form-control input-xlarge number right" />
                    </div>
                </div>
            </td>
            <td  style="width: 48%">
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Harga Kosong</label>
                    <div class="col-sm-7">
                        <input type="text"  maxlength="50" value="0"  name="spk_hargako" id="spk_hargako" required="required"  
                               readonly class="form-control input-xlarge number right" />
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td  style="width: 48%">
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Bbn</label>
                    <div class="col-sm-7">
                        <input type="text"  maxlength="50" value="0"  name="spk_bbn" id="spk_bbn" required="required"  
                               readonly class="form-control input-xlarge number right" />
                    </div>
                </div>
            </td>
            <td  style="width: 48%">
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Asuransi</label>
                    <div class="col-sm-7">
                        <input type="text"  maxlength="50" value="0"  name="spk_asuransi" id="spk_asuransi" required="required"  
                               readonly class="form-control input-xlarge number right" />
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td  style="width: 48%">
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Accessories</label>
                    <div class="col-sm-7">
                        <input type="text"  maxlength="50" value="0"  name="spk_aksesoris" id="spk_aksesoris" required="required"  
                               readonly class="form-control input-xlarge upper right" />
                    </div>
                </div>
            </td>
            <td  style="width: 48%">
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Karoseri</label>
                    <div class="col-sm-7">
                        <input type="text"  maxlength="50" value="0"  name="spk_karoseri" id="spk_karoseri" required="required"  
                               readonly class="form-control input-xlarge number right" />
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td  style="width: 48%">
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Administrasi</label>
                    <div class="col-sm-7">
                        <input type="text"  maxlength="50" value="0"  name="spk_administrasi" id="spk_administrasi" required="required"  
                               readonly class="form-control input-xlarge number right" />
                    </div>
                </div>
            </td>
            <td  style="width: 48%">
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Lain-Lain</label>
                    <div class="col-sm-7">
                        <input type="text"  maxlength="50" onchange="$('#'+this.id).val(formatDefault(this.value));" value="0" name="spk_lainlain" id="spk_lainlain" required="required"  
                               class="form-control input-xlarge number right" />
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td  style="width: 48%">

            </td>
            <td  style="width: 48%">
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"><strong>TOTAL</strong></label>
                    <div class="col-sm-7">
                        <input type="text"  maxlength="50" value="0"  name="spk_total" id="spk_total" required="required"  
                               readonly class="form-control input-xlarge number right"/>
                    </div>
                </div>
            </td>
        </tr>
    </table>

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
        </div>
    </div>
</form>
<script type="text/javascript">
    numberOnly();
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
    
    
    $(this).ready(function() {
        // AUTO COMPLETE NO KONTRAK
        $("#spk_nokontrak").autocomplete({
            minLength: 1,
            source: function(req, add) {
                $.ajax({
                    url: '<?php echo site_url('transaksi_sales/autoNoKontrak'); ?>',
                    dataType: 'json',
                    type: 'POST',
                    data: {param : $("#spk_nokontrak").val()},
                    success: function(data) {
                        add(data);
                    }
                });
            },
            select: function(event, ui) {
                $('.page-content-area').ace_ajax('startLoading');
                $.ajax({
                    url: '<?php echo site_url('transaksi_sales/jsonDataNoKontrak'); ?>',
                    dataType: 'json',
                    type: 'POST',
                    data: {param : ui.item.value},
                    success: function(data) {
                        $("#spk_pelid").val(data['pelid']);
                        $("#spk_customername").val(data['pel_nama']);
                        $("#spk_namabpkb").val(data['pel_nama']);
                        $("#spk_alamat").html(data['pel_alamat']);
                        $("#spk_alamatbpkb").html(data['pel_alamat']);
                        $('.page-content-area').ace_ajax('stopLoading', true);
                    }
                });
            }
        });
        // AUTO COMPLETE FPT
        $("#fpt_no").autocomplete({
            minLength: 1,
            source: function(req, add) {
                $.ajax({
                    url: '<?php echo site_url('transaksi_sales/autoFpt'); ?>',
                    dataType: 'json',
                    type: 'POST',
                    data: {param : $("#fpt_no").val()},
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
            },
            select: function(event, ui) {
                $('.page-content-area').ace_ajax('startLoading');
                $.ajax({
                    url: '<?php echo site_url('transaksi_sales/jsonDataFpt'); ?>',
                    dataType: 'json',
                    type: 'POST',
                    data: {param : ui.item.fptid},
                    success: function(data) {
                        $("#spk_merk").val(data['merk_deskripsi']);
                        $("#spk_type").val(data['cty_deskripsi']);
                        $("#spk_warna").val(data['warna_deskripsi']);
                        $("#spk_kondisi").val(data['fpt_kondisi']);
                        $("#spk_sales").val(data['kr_nama']);
                        $("#spk_uangmuka").val(formatDefaultTanpaKoma(data['fpt_uangmuka']));
                        $("#spk_hargako").val(formatDefaultTanpaKoma(data['fpt_hargako']));
                        $("#spk_bbn").val(formatDefaultTanpaKoma(data['fpt_bbn']));
                        $("#spk_asuransi").val(formatDefaultTanpaKoma(data['fpt_asuransi']));
                        $("#spk_karoseri").val(formatDefaultTanpaKoma(data['fpt_karoseri']));
                        $("#spk_aksesoris").val(formatDefaultTanpaKoma(data['fpt_accesories']));
                        $("#spk_administrasi").val(formatDefaultTanpaKoma(data['fpt_administrasi']));
                        $("#spk_total").val(formatDefaultTanpaKoma(data['fpt_total']));
                        if (data['fpt_pay_method'] == '1') {
                            $("#spk_paymethod").val("TUNAI");
                        }else{
                            $("#spk_paymethod").val("LEASING");
                        }
                        $('.page-content-area').ace_ajax('stopLoading', true);
                    }
                });
            }
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
        
        $('#formAdd').submit(function() {
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url('transaksi_sales/saveSpk') ?>",
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

    });
    var scripts = [null, null]
    $('.page-content-area').ace_ajax('loadScripts', scripts, function() {
        //inline scripts related to this page
    });
</script> 