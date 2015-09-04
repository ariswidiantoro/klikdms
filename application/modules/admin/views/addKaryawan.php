<div id="result"></div>
<form class="form-horizontal" id="form" method="post" action="<?php echo site_url('admin/saveKaryawan'); ?>" name="form">
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Cabang</label>
        <div class="col-sm-8">
            <span style="float: left;width: 30%;">
                <select name="kr_cbid" id="kr_cbid" required="required" class="form-control col-xs-10 col-sm-10"  >
                    <option value="">Pilih</option>
                    <?php
                    if (count($cabang) > 0) {
                        foreach ($cabang as $value) {
                            $select = (ses_cabang == $value['cbid']) ? 'selected' : '';
                            ?>
                            <option value="<?php echo $value['cbid']; ?>" <?php echo $select; ?>><?php echo $value['cb_nama']; ?></option> 
                            <?php
                        }
                    }
                    ?>
                </select>
            </span>
            <span style="float: left;width: 60%;margin-left: 10px; ">
                <input type="hidden" id="kr_atasanid" name="kr_atasanid">
                <input type="text" name="kr_atasan" id="kr_atasan"  placeholder="Atasan" class="form-control col-xs-10" />
            </span>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Departemen</label>
        <div class="col-sm-8">
            <select name="jab_deptid" id="jab_deptid" onchange="getJabatan()" class="form-control" style="width: 30%" >
                <option value="">Pilih</option>
                <?php
                if (count($departemen) > 0) {
                    foreach ($departemen as $value) {
                        ?>
                        <option value="<?php echo $value['deptid']; ?>"><?php echo $value['dept_deskripsi'] ?></option> 
                        <?php
                    }
                }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Jabatan</label>
        <div class="col-sm-8">
            <select name="kr_jabid" id="kr_jabid" required="required" class="form-control" style="width: 30%">
            </select>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">NIK</label>
        <div class="col-sm-8">
            <input type="text" name="kr_nik" required="required"  placeholder="Nomor Induk Karyawan" class="ace col-xs-10 col-sm-3" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nama Karyawan</label>
        <div class="col-sm-8">
            <input type="text" name="kr_nama" required="required"  placeholder="Nama" class="upper ace col-xs-10 col-sm-5" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Username</label>
        <div class="col-sm-8">
            <input type="text" name="kr_username"  required="required"  placeholder="Username" class="ace col-xs-10 col-sm-3" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Alamat</label>
        <div class="col-sm-8">
            <textarea class="upper ace col-xs-10 col-sm-5" name="kr_alamat" rows="4"></textarea>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Propinsi</label>
        <div class="col-sm-8">
            <select name="propinsi" id="propinsi" onchange="getKota()" class="form-control" style="width: 30%" >
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
            <select name="kr_kotaid" id="kr_kotaid" class="form-control" style="width: 30%" >
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nomor Hp</label>
        <div class="col-sm-8">
            <input type="text" name="kr_hp"  placeholder="Hp" class="ace col-xs-10 col-sm-3" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Tempat Lahir</label>
        <div class="col-sm-8">
            <input type="text" name="kr_tempat_lahir"  placeholder="Tempat Lahir" class="ace col-xs-10 col-sm-5" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Tgl Lahir</label>
        <div class="col-sm-8">
            <div class="input-group input-group-sm col-sm-2">
                <input type="text" name="kr_tgl_lahir" id="datepicker" class="form-control" />
                <span class="input-group-addon">
                    <i class="ace-icon fa fa-calendar"></i>
                </span>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Email</label>
        <div class="col-sm-8">
            <input type="text" name="kr_email"  placeholder="Email" class="ace col-xs-10 col-sm-5" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nomor KTP</label>
        <div class="col-sm-8">
            <input type="text" name="kr_nomor_ktp"  placeholder="Nomor KTP" class="ace col-xs-10 col-sm-5" />
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