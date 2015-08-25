<script src="<?php echo path_js(); ?>jquery-ui.js"></script>
<form class="form-horizontal" id="formMenu" method="post" action="<?php echo site_url('administrator/simpanKaryawan'); ?>" name="formMenu">
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Cabang</label>
        <div class="col-sm-8">
            <select name="kr_cbid" id="menu_parentid" required="required" class="col-xs-10 col-sm-5" >
                <option value="">Pilih</option>
                <?php
                if (count($cabang) > 0) {
                    foreach ($cabang as $value) {
                        ?>
                        <option value="<?php echo $value['cbid']; ?>"><?php echo $value['cb_nama'] . "&nbsp;&nbsp;(" . $value['cbid'] . ")" ?></option> 
                        <?php
                    }
                }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">NIK</label>
        <div class="col-sm-8">
            <input type="text" name="kr_nik"  placeholder="Nomor Induk Karyawan" class="ace col-xs-10 col-sm-3" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nama Karyawan</label>
        <div class="col-sm-8">
            <input type="text" name="kr_nama" required="required"  placeholder="Nama" class="ace col-xs-10 col-sm-5" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Alamat</label>
        <div class="col-sm-8">
            <textarea class="ace col-xs-10 col-sm-5" name="kr_alamat" rows="4"></textarea>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nomor Hp</label>
        <div class="col-sm-8">
            <input type="text" name="kr_hp"  placeholder="Hp" class="ace col-xs-10 col-sm-3" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Username</label>
        <div class="col-sm-8">
            <input type="text" name="kr_username"  placeholder="Username" class="ace col-xs-10 col-sm-3" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Tempat Lahir</label>
        <div class="col-sm-8">
            <input type="text" name="kr_hp"  placeholder="Tempat Lahir" class="ace col-xs-10 col-sm-5" />
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
            <input type="text" name="kr_nomorktp"  placeholder="Nomor KTP" class="ace col-xs-10 col-sm-5" />
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Jabatan</label>
        <div class="col-sm-8">
            <select name="kr_jabatanid" id="menu_parentid" required="required" class="col-xs-10 col-sm-5" >
                <option value="">Pilih</option>
                <?php
                if (count($jabatan) > 0) {
                    foreach ($jabatan as $value) {
                        ?>
                        <option value="<?php echo $value['jabatanid']; ?>"><?php echo $value['jabatan_deskripsi'] ?></option> 
                        <?php
                    }
                }
                ?>
            </select>
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
    $( "#datepicker" ).datepicker({
//        showOtherMonths: true,
//        selectOtherMonths: false,
        //isRTL:true,
			
					
        /*
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
         */
    });
</script>