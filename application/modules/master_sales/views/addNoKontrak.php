<div id="result"></div>
<?php
echo $this->session->flashdata('msg');
?>
<form class="form-horizontal" id="form" method="post" action="<?php echo site_url('master_sales/saveNoKontrak'); ?>" name="form">
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nomer Kontrak</label>
        <div class="col-sm-8">
            <input type="text" name="kon_nomer" required="required" placeholder="Nomer Kontrak" class="req upper ace col-xs-10 col-sm-3" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nama Prospek</label>
        <div class="col-sm-8">
            <input type="text" name="pel_nama" required="required" id="pel_nama" placeholder="Nama" class="req upper ace col-xs-10 col-sm-6" />
            <input type="hidden" name="prosid" id="prosid">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Alamat</label>
        <div class="col-sm-8">
            <textarea name="pel_alamat" id="pel_alamat" class="req upper ace col-xs-10 col-sm-7" required="required" rows="4"></textarea>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Propinsi</label>
        <div class="col-sm-8">
            <select name="propinsi" id="propinsi" required="required" onchange="getKota()" class="req ace col-xs-10 col-sm-3">
                <option value="">Pilih</option>
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
            <select name="pel_kotaid" required="required" id="kr_kotaid" class="req ace col-xs-10 col-sm-3">
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Alamat Surat</label>
        <div class="col-sm-8">
            <textarea name="pel_alamat_surat" class="ace col-xs-10 col-sm-7" rows="4"></textarea>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nomor HP</label>
        <div class="col-sm-8">
            <input type="text" name="pel_hp" id="pel_hp" required="required"  placeholder="Nomor HP" class="req ace col-xs-10 col-sm-3" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nomor KTP</label>
        <div class="col-sm-8">
            <input type="text" name="pel_nomor_id" id="pel_nomor_id" required="required" placeholder="Nomor HP" class="req ace col-xs-10 col-sm-3" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nomor Telpon</label>
        <div class="col-sm-8">
            <input type="text" name="pel_telpon" id="pel_telpon" placeholder="Nomor Telpon" class="ace col-xs-10 col-sm-3" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Fax</label>
        <div class="col-sm-8">
            <input type="text" name="pel_fax"  placeholder="Nomor Fax" class="ace col-xs-10 col-sm-3" />
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Tempat Lahir</label>
        <div class="col-sm-8">
            <input type="text" name="pel_tempat_lahir" id="pel_tempat_lahir"  autocomplete="off" placeholder="Tempat Lahir" class="ace col-xs-10 col-sm-5 upper" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Tgl Lahir</label>
        <div class="col-sm-8">
            <div class="input-group input-group-sm col-sm-2">
                <input type="text" name="pel_tgl_lahir" id="pel_tgl_lahir" class="form-control datepicker" />
                <span class="input-group-addon">
                    <i class="ace-icon fa fa-calendar"></i>
                </span>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Jenis Kelamin</label>
        <div class="col-sm-8">
            <div class="radio">
                <label>
                    <input name="pel_gender" type="radio" value="L" id="L" class="ace" />
                    <span class="lbl">Laki-Laki</span>
                </label>
            </div>

            <div class="radio">
                <label>
                    <input name="pel_gender" type="radio" value="P" id="P" class="ace" />
                    <span class="lbl">Perempuan</span>
                </label>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Email</label>
        <div class="col-sm-8">
            <input type="text" name="pel_email"  placeholder="Email" class="ace col-xs-10 col-sm-5" />
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Agama</label>
        <div class="col-sm-8">
            <div class="radio">
                <label>
                    <input name="pel_agama" type="radio" value="islam" id="islam" class="ace" />
                    <span class="lbl">Islam</span>
                </label>
            </div>
            <div class="radio">
                <label>
                    <input name="pel_agama" type="radio" value="kristen" id="kristen" class="ace" />
                    <span class="lbl">Kristen</span>
                </label>
            </div>
            <div class="radio">
                <label>
                    <input name="pel_agama" type="radio" value="budha" id="budha" class="ace" />
                    <span class="lbl">Budha</span>
                </label>
            </div>
            <div class="radio">
                <label>
                    <input name="pel_agama" type="radio" value="katolik" id="katolik" class="ace" />
                    <span class="lbl">Katolik</span>
                </label>
            </div>
            <div class="radio">
                <label>
                    <input name="pel_agama" type="radio" value="hindu" id="hindu" class="ace" />
                    <span class="lbl">Hindu</span>
                </label>
            </div>
        </div>
    </div>

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
    var scripts = [null, null]
    $('.page-content-area').ace_ajax('loadScripts', scripts, function() {
        //inline scripts related to this page
    });
    
    function getKota()
    {
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('admin/jsonKota') ?>',
            dataType: "json",
            async: false,
            data: {
                propid : $("#propinsi").val()
            },
            success: function(data) {
                $('#kr_kotaid').html('');
                $.each(data, function(messageIndex, message) {
                    $('#kr_kotaid').append('<option value="' + message.kotaid + '">' + message.kota_deskripsi + '</option>');
                });
            }
        })
    }
    
    $( ".datepicker" ).datepicker({
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
    
    $(this).ready(function() {
        $('#form').submit(function() {
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
                    if (data.result) {
                        $('.page-content-area').ace_ajax('loadUrl', "#master_sales/addNoKontrak", false);
                    }
                    $("#result").html(data.msg).show().fadeIn("slow");
                }
            })
            return false;
        });

    });
    
    $(this).ready(function() {
        
        $("#pel_nama").autocomplete({
            minLength: 1,
            source: function(req, add) {
                $.ajax({
                    url: '<?php echo site_url('master_sales/jsonNamaProspek'); ?>',
                    dataType: 'json',
                    type: 'POST',
                    data: {param : $("#pel_nama").val()},
                    success: function(data) {
                        add(data.message);
                    }
                });
            },
            create: function () {
                $(this).data('ui-autocomplete')._renderItem = function (ul, item) {
                    return $('<li>')
                    .append('<a><strong>' + item.label + '</strong><br>' + item.desc + '</a>')
                    .appendTo(ul);
                };
            },
            select: function(event, ui) {
                $("#prosid").val(ui.item.prosid);
                $('.page-content-area').ace_ajax('startLoading');
                $.ajax({
                    url: '<?php echo site_url('master_sales/getDataProspek'); ?>',
                    dataType: 'json',
                    type: 'POST',
                    data: {param : ui.item.prosid},
                    success: function(data) {
                        var tgl = "";
                        if (data['pros_tgl_lahir'] != "<?php echo dateToIndo(DEFAULT_TGL) ?>") {
                            var date = data['pros_tgl_lahir'].split("-");
                            tgl = date['2']+"-"+date['1']+"-"+date['0'];
                        }
                        $('#kr_kotaid').html('');
                        $("#pel_alamat").html(data['pros_alamat']);
                        $("#propinsi").val(data['kota_propid']);
                        $("#pel_hp").val(data['pros_hp']);
                        $("#pel_nomor_id").val(data['prop_nomor_id']);
                        $("#pel_telpon").val(data['pros_telpon']);
                        $("#pel_fax").val(data['pros_fax']);
                        $("#pel_email").val(data['pros_email']);
                        $("#"+data['pros_gender']).checked = true;
                        $("#"+data['pros_agama']).checked = true;
                        $("#pel_tempat_lahir").val(data['pros_tempat_lahir']);
                        $("#pel_tgl_lahir").val(tgl);
                        $('#kr_kotaid').append('<option value="' + data['kotaid'] + '">' + data['kota_deskripsi'] + '</option>');
                        $('.page-content-area').ace_ajax('stopLoading', true);
                    }
                });
            }
        })
        
    });
   
</script>
