<div id="result"></div>
<form class="form-horizontal" id="form" method="post" action="<?php echo site_url('master_service/updatePelanggan'); ?>" name="form">
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Type Pelanggan</label>
        <div class="col-sm-8">
            <select name="pel_type" required="required" class="ace col-xs-10 col-sm-3 req">
                <option value="">Pilih</option>
                <option value="retail" <?php if ($data['pel_type'] == 'retail') echo 'selected'; ?>>Retail</option>
                <option value="broker" <?php if ($data['pel_type'] == 'broker') echo 'selected'; ?>>Broker</option>
                <option value="fleet" <?php if ($data['pel_type'] == 'fleet') echo 'selected'; ?>>Fleet</option>
                <option value="gso" <?php if ($data['pel_type'] == 'gso') echo 'selected'; ?>>Gso/Pemerintahan</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nama</label>
        <div class="col-sm-8">
            <input type="hidden" value="<?php echo $data['pelid']; ?>" name="pelid">
            <input type="text" name="pel_nama" value="<?php echo $data['pel_nama']; ?>" required="required" placeholder="Nama" class="upper ace col-xs-10 col-sm-10 req" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Alamat</label>
        <div class="col-sm-8">
            <textarea name="pel_alamat" class="upper ace col-xs-10 col-sm-7 req" required="required" rows="4"><?php echo $data['pel_alamat']; ?></textarea>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Propinsi</label>
        <div class="col-sm-8">
            <select name="propinsi" id="propinsi" onchange="getKota()" class="ace col-xs-10 col-sm-3 req">
                <option value="">Pilih</option>
                <?php
                if (count($propinsi) > 0) {
                    foreach ($propinsi as $value) {
                        $select = ($data['kota_propid'] == $value['propid']) ? 'selected' : '';
                        ?>
                        <option value="<?php echo $value['propid']; ?>"<?php echo $select; ?>><?php echo $value['prop_deskripsi'] ?></option> 
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
            <select name="pel_kotaid" id="kr_kotaid" class="ace col-xs-10 col-sm-3 req">
                <?php
                if (count($kota) > 0) {
                    foreach ($kota as $value) {
                        $select = ($data['pel_kotaid'] == $value->kotaid) ? 'selected' : '';
                        ?>
                        <option value="<?php echo $value->kotaid; ?>"<?php echo $select; ?>><?php echo $value->kota_deskripsi ?></option> 
                        <?php
                    }
                }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Alamat Surat</label>
        <div class="col-sm-8">
            <textarea name="pel_alamat_surat" value="<?php echo $data['pel_alamat_surat']; ?>" class="ace col-xs-10 col-sm-7" rows="4"></textarea>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nomor KTP</label>
        <div class="col-sm-8">
            <input type="text" name="pel_nomor_id" value="<?php echo $data['pel_nomor_id']; ?>" placeholder="Nomor HP" class="ace col-xs-10 col-sm-3" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nomor HP</label>
        <div class="col-sm-8">
            <input type="text" name="pel_hp" value="<?php echo $data['pel_hp']; ?>"  placeholder="Nomor HP" class="ace col-xs-10 col-sm-3 req" />
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nomor Telpon</label>
        <div class="col-sm-8">
            <input type="text" name="pel_telpon" value="<?php echo $data['pel_telpon']; ?>" placeholder="Nomor Telpon" class="ace col-xs-10 col-sm-3" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Npwp</label>
        <div class="col-sm-8">
            <input type="text" name="pel_npwp" value="<?php echo $data['pel_npwp']; ?>" placeholder="Npwp" class="ace col-xs-10 col-sm-3" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Fax</label>
        <div class="col-sm-8">
            <input type="text" name="pel_fax" value="<?php echo $data['pel_fax']; ?>"  placeholder="Nomor Fax" class="ace col-xs-10 col-sm-3" />
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Tempat Lahir</label>
        <div class="col-sm-8">
            <input type="text" name="pel_tempat_lahir" value="<?php echo $data['pel_tempat_lahir']; ?>"  placeholder="Tempat Lahir" class="ace col-xs-10 col-sm-5" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Tgl Lahir</label>
        <div class="col-sm-8">
            <div class="input-group input-group-sm col-sm-2">
                <input type="text" name="pel_tgl_lahir" value="<?php if ($data['pel_tgl_lahir'] != '9999-01-01') echo dateToIndo($data['pel_tgl_lahir']); ?>" id="datepicker" class="form-control" />
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
                    <input name="pel_gender"  type="radio" <?php if ($data['pel_gender'] == 'L') echo 'checked'; ?> value="L"  class="ace" />
                    <span class="lbl"   >Laki-Laki</span>
                </label>
            </div>

            <div class="radio">
                <label>
                    <input name="pel_gender" <?php if ($data['pel_gender'] == 'P') echo 'checked'; ?> type="radio" value="P" class="ace" />
                    <span class="lbl">Perempuan</span>
                </label>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Email</label>
        <div class="col-sm-8">
            <input type="text" name="pel_email" value="<?php echo $data['pel_email']; ?>"  placeholder="Email" class="ace col-xs-10 col-sm-5" />
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Agama</label>
        <div class="col-sm-8">
            <div class="radio">
                <label>
                    <input name="pel_agama" <?php if ($data['pel_agama'] == 'islam') echo 'checked'; ?> type="radio" value="islam" class="ace" />
                    <span class="lbl">Islam</span>
                </label>
            </div>
            <div class="radio">
                <label>
                    <input name="pel_agama" <?php if ($data['pel_agama'] == 'kristen') echo 'checked'; ?> type="radio" value="kristen" class="ace" />
                    <span class="lbl">Kristen</span>
                </label>
            </div>
            <div class="radio">
                <label>
                    <input name="pel_agama" type="radio" <?php if ($data['pel_agama'] == 'budha') echo 'checked'; ?> value="budha" class="ace" />
                    <span class="lbl">Budha</span>
                </label>
            </div>
            <div class="radio">
                <label>
                    <input name="pel_agama" type="radio" <?php if ($data['pel_agama'] == 'katolik') echo 'checked'; ?> value="katolik" class="ace" />
                    <span class="lbl">Katolik</span>
                </label>
            </div>
            <div class="radio">
                <label>
                    <input name="pel_agama" type="radio" <?php if ($data['pel_agama'] == 'hindu') echo 'checked'; ?> value="hindu" class="ace" />
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
    $(this).ready(function() {
        $("#kr_atasan").autocomplete({
            minLength: 1,
            source:
                function(request, add) {
                $.ajax({
                    url: "<?php echo site_url('admin/jsonKaryawan'); ?>",
                    dataType: 'json',
                    type: 'POST',
                    data: {
                        cbid : $("#kr_cbid").val(),
                        param : $("#kr_atasan").val()
                    },
                    success:
                        function(data) {
                        if (data.response == "true")
                        {
                            add(data.message);
                        }
                        else
                        {
                            add(data.message);
                        }
                    }

                });
            },
            select: function(event, ui) {
                $('#kr_atasanid').val(ui.item.krid);
                return true;
            }
        })
    });
    
    
    function getJabatan()
    {
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('admin/jsonJabatan') ?>',
            dataType: "json",
            async: false,
            data: {
                departemen : $("#jab_deptid").val()
            },
            success: function(data) {
                $('#kr_jabid').html('');
                $.each(data, function(messageIndex, message) {
                    $('#kr_jabid').append('<option value="' + message.jabid + '">' + message.jab_deskripsi + '</option>');
                });
            }
        })
    }
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
                        document.form.reset();
                    }
                    $("#result").html(data.msg).show().fadeIn("slow");
                }
            })
            return false;
        });

    });
   
</script>