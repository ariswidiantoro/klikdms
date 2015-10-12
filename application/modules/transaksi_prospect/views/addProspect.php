<div class="page-header">
    <h1>
        Tambah Prospect
    </h1>
</div>      
<div id="result"></div>
<div id="fuelux-wizard-container">
    <div>
        <ul class="steps">
            <li data-step="1" class="active">
                <span class="step">1</span>
                <span class="title">Data Calon Customer</span>
            </li>

            <li data-step="2">
                <span class="step">2</span>
                <span class="title">Prospect Kendaraan</span>
            </li>

            <li data-step="3">
                <span class="step">3</span>
                <span class="title">Informasi Lain-Lain</span>
            </li>
        </ul>
    </div>

    <hr />

    <div class="step-content pos-rel">
        <form class="form-horizontal" id="formAdd" method="post" action="<?php echo site_url('transaksi_prospect/saveProspect'); ?>" name="formAdd">
            <div class="step-pane active" data-step="1">
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Tipe Customer</label>
                    <div class="col-sm-3">
                        <div class="input-group">
                            <select name="pros_type" required="required" class="form-control req">
                                <option value="">PILIH</option>
                                <option value="retail">RETAIL</option>
                                <option value="broker">BROKER</option>
                                <option value="fleet">FLEET</option>
                                <option value="gso">GSO / PEMERINTAHAN</option>
                            </select>
                        </div>
                    </div>
                </div> 
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nama</label>
                    <div class="col-sm-8">
                        <div class="input-group col-sm-8">
                            <input type="text" name="pros_nama" required="required" placeholder="Nama" class="form-control upper req" />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Alamat</label>
                    <div class="col-sm-8">
                        <div class="input-group col-sm-8">
                            <textarea name="pros_alamat" class="form-control upper req" required="required" rows="4"></textarea>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Propinsi</label>
                    <div class="col-sm-8">
                        <select name="propinsi" id="propid" onchange="getKota()" class="form-control input-medium req" >
                            <option value="">PILIH</option>
                            <?php
                            if (count($propinsi) > 0) {
                                foreach ($propinsi as $value) {
                                    ?>
                                    <option value="<?php echo $value['propid']; ?>"><?php echo $value['prop_deskripsi'] ?></option> 
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Kab / Kota</label>
                    <div class="col-sm-8">
                        <select name="pros_kotaid" id="kotaid" onchange="getArea()" class="form-control input-medium req" >
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Area</label>
                    <div class="col-sm-8">
                        <select name="pros_area" id="areaid" class="form-control input-medium req" >
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nomor HP</label>
                    <div class="col-sm-3">
                        <div class="input-group">
                            <input type="text" name="pros_hp" id="pros_hp"  placeholder="Nomor HP" class="form-control number upper req" />
                            <span class="input-group-addon">
                                <i class="ace-icon fa fa-mobile-phone" style="width: 12px;"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nomor Telpon</label>
                    <div class="col-sm-3">
                        <div class="input-group">
                            <input type="text" id="pros_telpon"  name="pros_telpon" placeholder="Nomor Telpon" class="form-control number upper" />
                            <span class="input-group-addon">
                                <i class="ace-icon fa fa-phone" style="width: 12px;"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nomor KTP</label>
                    <div class="col-sm-8">
                        <input type="text" name="pros_nomor_id" placeholder="Nomor KTP" class="ace col-xs-10 col-sm-5 number upper" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Fax</label>
                    <div class="col-sm-3">
                        <div class="input-group">
                            <input type="text" name="pros_fax"  placeholder="Nomor Fax" class="form-control number upper" />
                            <span class="input-group-addon">
                                <i class="ace-icon fa fa-fax" style="width: 12px;"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Tempat Lahir</label>
                    <div class="col-sm-8">
                        <input type="text" name="pros_tempat_lahir"  placeholder="Tempat Lahir" class="ace col-xs-10 col-sm-5 upper" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Tgl Lahir</label>
                    <div class="col-sm-2">
                        <div class="input-group">
                            <input type="text" name="pros_tgl_lahir" id="datepicker" readonly="readonly" class="form-control" />
                            <span class="input-group-addon">
                                <i class="ace-icon fa fa-calendar" style="width: 12px;"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Jenis Kelamin</label>
                    <div class="col-sm-8">
                        <div class="radio">
                            <label>
                                <input name="pros_gender" type="radio" value="L" class="ace" />
                                <span class="lbl">Laki-Laki</span>
                            </label>
                        </div>

                        <div class="radio">
                            <label>
                                <input name="pros_gender" type="radio" value="P" class="ace" />
                                <span class="lbl">Perempuan</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Email</label>
                    <div class="col-sm-8">
                        <input type="text" name="pros_email"  placeholder="Email" class="ace col-xs-10 col-sm-5" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Agama</label>
                    <div class="col-sm-8" style="display: block;">
                        <div class="radio">
                            <label>
                                <input name="pros_agama" type="radio" value="islam" class="ace" />
                                <span class="lbl">Islam</span>
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input name="pros_agama" type="radio" value="kristen" class="ace" />
                                <span class="lbl">Kristen</span>
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input name="pros_agama" type="radio" value="budha" class="ace" />
                                <span class="lbl">Budha</span>
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input name="pros_agama" type="radio" value="katolik" class="ace" />
                                <span class="lbl">Katolik</span>
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input name="pros_agama" type="radio" value="hindu" class="ace" />
                                <span class="lbl">Hindu</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="step-pane" data-step="2">
                <div id="detailtrans">
                    <div class="table-header">
                        DETAIL KENDARAAN
                    </div>
                    <div>
                        <table id="simple-table-jasa" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 2%">NO</th>
                                    <th style="width: 15%">MERK</th>
                                    <th style="width: 15%">MODEL</th>
                                    <th style="width: 20%">TYPE</th>
                                    <th style="width: 10%">QTY</th>
                                    <th style="width: 5%">ADD</th>
                                    <th style="width: 5%">HAPUS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr  class="item-row">
                                    <td class="dtlkendaraan" style="text-align: center;">
                                        1
                                    </td>
                                    <td>
                                        <select name="cars_merkid[]" id="merkid1" onchange="getModel('1')"  class="form-control" style="width: 100%;" >
                                            <option value="">PILIH</option>
                                            <?php
                                            if (count($merk) > 0) {
                                                foreach ($merk as $value) {
                                                    ?>
                                                    <option value="<?php echo $value['merkid']; ?>"><?php echo $value['merk_deskripsi'] ?></option> 
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="cars_modelid[]" id="modelid1" onchange="getType('1')" class="form-control" style="width: 100%;">
                                            <option value="">PILIH</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="cars_ctyid[]" id="ctyid1" class="form-control" style="width: 100%;">
                                            <option value="">PILIH</option>
                                        </select>
                                    </td>
                                    <td><div class="input-group">
                                            <input type="text" name="cars_qty[]"  placeholder="Kuantitas" class="form-control number upper" />
                                            <span class="input-group-addon">
                                                <i class="ace-icon fa fa-car" style="width: 12px;"></i>
                                            </span>
                                        </div>
                                    </td>
                                    <td class="center">
                                        <a class="green btnAdd"  onclick="addRow()" href="javascript:;"><i class="ace-icon fa fa-search-plus bigger-130"></i></a>
                                    </td>
                                    <td  class="center">
                                        <a class="red btnDelete" href="javascript:;"><i class="ace-icon fa fa-trash-o bigger-130"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="step-pane" data-step="3">
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1">NPWP</label>
                    <div class="col-sm-8">
                        <input type="text" name="pros_npwp" placeholder="Nomor NPWP" class="ace col-xs-10 col-sm-5 number upper" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Bisnis</label>
                    <div class="col-sm-8">
                        <select name="pros_bisnis" class="form-control input-medium">
                            <option value="">PILIH</option>
                            <?php
                            if (count($bisnis) > 0) {
                                foreach ($bisnis as $fbisnis) {
                                    ?>
                                    <option value="<?php echo $fbisnis['bisnisid']; ?>"><?php echo $fbisnis['bisnis_nama'] ?></option> 
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Sumber Informasi</label>
                    <div class="col-sm-8">
                        <select name="pros_sumber_info" class="form-control input-medium">
                            <option value="">PILIH</option>
                            <?php
                            if (count($sinfo) > 0) {
                                foreach ($sinfo as $fsinfo) {
                                    ?>
                                    <option value="<?php echo $fsinfo['smbinfoid']; ?>"><?php echo $fsinfo['smbinfo_deskripsi'] ?></option> 
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Kontak Awal</label>
                    <div class="col-sm-8">
                        <select name="pros_kontak_awal" class="form-control input-medium">
                            <option value="">PILIH</option>
                            <?php
                            if (count($kontak) > 0) {
                                foreach ($kontak as $fkontak) {
                                    ?>
                                    <option value="<?php echo $fkontak['kontakid']; ?>"><?php echo $fkontak['kontak_deskripsi'] ?></option> 
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Keterangan</label>
                    <div class="col-sm-8">
                        <div class="input-group col-sm-8">
                            <textarea name="pros_keterangan" class="form-control upper" rows="4"></textarea>
                        </div>
                    </div>
                </div>
            </div>


        </form>
    </div>

    <!-- /section:plugins/fuelux.wizard.container -->
</div>
<hr />
<div class="wizard-actions pull-left">
    <!-- #section:plugins/fuelux.wizard.buttons -->
    <button class="btn btn-prev">
        <i class="ace-icon fa fa-arrow-left"></i>
        Prev
    </button>

    <button class="btn btn-success btn-next" data-last="Finish">
        Next
        <i class="ace-icon fa fa-arrow-right icon-on-right"></i>
    </button>

    <!-- /section:plugins/fuelux.wizard.buttons -->
</div>
<script src="<?php echo path_js(); ?>ace/elements.wizard.js"></script>
<script src="<?php echo path_js(); ?>fuelux/fuelux.wizard.js"></script>
<script type="text/javascript">
    function redirect(data){
        bootbox.confirm("Anda yakin kembali ?", function(result) {
            if(result) {
                window.location.href = "#master_sales/masterLeasing";
            }});
    }
    
    function saveData(){
        var result = false;
        bootbox.confirm("Anda yakin data sudah benar ?", function(result) {
            if(result) {
                $("#formAdd").submit();
            }
        });
        return false;
    }
    
    function getKota(){
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('master_sales/jsonKota') ?>',
            dataType: "json",
            async: false,
            data: {
                propid : $("#propid").val()
            },
            success: function(data) {
                $('#kotaid').html('');
                $('#kotaid').append('<option value="">PILIH</option>');
                $.each(data, function(messageIndex, message) {
                    $('#kotaid').append('<option value="' + message['kotaid'] + '">' + message['kota_deskripsi'] + '</option>');
                });
            }
        })
    }
    
    function getArea(){
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('master_sales/jsonArea') ?>',
            dataType: "json",
            async: false,
            data: {
                kotaid : $("#kotaid").val()
            },
            success: function(data) {
                $('#areaid').html('');
                $('#areaid').append('<option value="">PILIH</option>');
                $.each(data, function(messageIndex, message) {
                    $('#areaid').append('<option value="' + message['areaid'] + '">' + message['area_deskripsi'] + '</option>');
                });
            }
        })
    }
    
    function getModel(target){
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('master_sales/jsonModelKendaraan') ?>',
            dataType: "json",
            async: false,
            data: {
                merkid : $("#merkid"+target).val()
            },
            success: function(data) {
                $('#modelid'+target).html('');
                $('#modelid'+target).append('<option value="">PILIH</option>');
                $.each(data, function(messageIndex, message) {
                    $('#modelid'+target).append('<option value="' + message['modelid'] + '">' + message['model_deskripsi'] + '</option>');
                });
            }
        })
    }
    
    function getType(target){
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('master_sales/jsonTypeKendaraan') ?>',
            dataType: "json",
            async: false,
            data: {
                modelid : $("#modelid"+target).val()
            },
            success: function(data) {
                $('#ctyid'+target).html('');
                $('#ctyid'+target).append('<option value="">PILIH</option>');
                $.each(data, function(messageIndex, message) {
                    $('#ctyid'+target).append('<option value="' + message['ctyid'] + '">' + message['cty_deskripsi'] + '</option>');
                });
            }
        })
    }
    
    function Delete() {
        var par = $(this).parent().parent(); //tr
        par.remove();
        totalLc();
    }
    
    function addRow() {
        var inc = $('.dtlkendaraan').length+1;
        $(".item-row:last").after(
        '<tr class="item-row">\n\
                    <td class="dtlkendaraan center">' + inc + '<input type="hidden" name="no[]" id="no'+ inc +'"  /></td>\n\
                         <td>\n\
                             <select class="form-control input-xlarge" style="width:100%;" onchange="getModel('+( inc )+')"  name="merkid[]" id="merkid'+(inc)+'" >\n\
                            <option value="">PILIH</option>\n\
<?php
foreach ($merk as $value) {
    echo "<option value=\'" . $value['merkid'] . "\' > " . $value['merk_deskripsi'] . "</option> ";
}
?> \n\
                        </select> \n\
                         </td>\n\
                         <td>\n\
                             <select class="form-control input-small" style="width:100%;text-align: left" onchange="getType('+( inc )+')"  name="modelid[]" id="modelid'+( inc )+'" >\n\
                            <option value="">PILIH</option>\n\
                        </select> \n\
                         </td>\n\
                        <td>\n\
                             <select class="form-control input-xxlarge" style="width:100%;text-align: left"  name="ctyid[]" id="ctyid'+( inc )+'" >\n\
                            <option value="">PILIH</option>\n\
                        </select> \n\
                         </td>\n\
                         <td><div class="input-group">\n\
                            <input type="text" name="pros_kuantitas"  placeholder="Kuantitas" class="form-control number upper" />\n\
                            <span class="input-group-addon">\n\
                                <i class="ace-icon fa fa-car" style="width: 12px;"></i>\n\
                            </span>\n\
                        </div>\n\
                         <td  class="center">\n\
                             <a class="green btnAdd"  onclick="addRow()" href="javascript:;"><i class="ace-icon fa fa-search-plus bigger-130"></i></a>\n\
                         </td>\n\
                         <td style="text-align: center">\n\
                             <a class="red btnDelete" href="javascript:;"><i class="ace-icon fa fa-trash-o bigger-130"></i></a>\n\
                         </td>\n\
                       </tr>\n\
                    </tr>');
                                 $(".btnDelete").bind("click", Delete);
                             }
    
                             $(this).ready(function() {
                                 //called when key is pressed in textbox
                                 $(".number").keypress(function (e) {
                                     //if the letter is not digit then display error and don't type anything
                                     if (e.which != 8 && e.which != 47 && e.which != 0 && (e.which < 46 || e.which > 57)){
                                         return false;
                                     }
                                 });

                                 $( "#datepicker" ).datepicker({
                                     showOtherMonths: true,
                                     selectOtherMonths: false,
                                     isRTL:true,
                                     yearRange: "c-30:c+3",
                                     changeMonth: true,
                                     changeYear: true,

                                     showButtonPanel: true,
                                     beforeShow: function() {
                                         //change button colors
                                         var datepicker = $(this).datepicker( "widget" );
                                         setTimeout(function(){
                                             var buttons = datepicker.find('.ui-datepicker-buttonpane')
                                             .find('button');
                                             buttons.eq(0).addClass('btn btn-xs');
                                             buttons.eq(1).addClass('btn btn-xs btn-success');
                                             buttons.wrapInner('<span class="bigger-110" />');
                                         }, 0);
                                     }
                                 });

                                 $('#formAdd').submit(function() {
                                     $.ajax({
                                         type: 'POST',
                                         url: "<?php echo site_url('transaksi_prospect/saveProspect') ?>",
                                         dataType: "json",
                                         async: false,
                                         data: $(this).serialize(),
                                         success: function(data) {
                                             window.scrollTo(0, 0);
                                             if (data.result) {
                                                 document.formAdd.reset();
                                             }
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

                             jQuery(function($) {
                                 var $validation = false;
                                 $('#fuelux-wizard-container')
                                 .ace_wizard({
                                     //step: 2 //optional argument. wizard will jump to step "2" at first
                                     //buttons: '.wizard-actions:eq(0)'
                                 })
                                 .on('actionclicked.fu.wizard' , function(e, info){
                                     if(info.step == 1 && $validation) {
                                         if(!$('#formAdd').valid()) e.preventDefault();
                                     }
                                 })
                                 .on('finished.fu.wizard', function(e) {
                                     var result = false;
                                     bootbox.confirm("Anda yakin data sudah benar ?", function(result) {
                                         if(result) {
                                             $("#formAdd").submit();
                                         }
                                     });
                                     return false;
                                 })
                                 .on('stepclick.fu.wizard', function(e){
                                     // e.preventDefault();//this will prevent clicking and selecting steps
                                 });

                                 $('#formAdd').validate({
                                     errorElement: 'div',
                                     errorClass: 'help-block',
                                     focusInvalid: false,
                                     ignore: "",
                                     rules: {
                                         pros_type: {
                                             required: true
                                         },
                                         pros_nama: {
                                             required: true
                                         },
                                         pros_alamat: {
                                             required: true
                                         },
                                         pros_hp: {
                                             required: true
                                         }
                                     },

                                     messages: {
                                         pros_type: {
                                             required: "Pastikan tipe pelanggan tidak kosong."
                                         },
                                         pros_nama: {
                                             required: "Pastikan nama pelanggan tidak kosong."
                                         },
                                         pros_alamat: {
                                             required: "Pastikan alamat pelanggan tidak kosong."
                                         },
                                         pros_hp: {
                                             required: "Pastikan no. handphone tidak kosong."
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
                             })
</script>