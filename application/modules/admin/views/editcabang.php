<div id="result"></div>
<form class="form-horizontal" id="formMenu" method="post" action="<?php echo site_url('admin/updateCabang'); ?>" name="formMenu" enctype="multipart/form-data">
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Kode Cabang</label>
        <div class="col-sm-8">
            <input type="text" name="cbid" id="cbid" readonly="readonly" value="<?php echo $cabang['cbid'] ?>" class="col-xs-10 col-sm-5" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nama Cabang</label>
        <div class="col-sm-8">
            <input type="text" name="cb_nama" id="cb_nama" placeholder="Nama Cabang" value="<?php echo $cabang['cb_nama'] ?>" class="col-xs-10 col-sm-5" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nama Perusahaan</label>
        <div class="col-sm-8">
            <select name="cb_compid" id="menu_parentid" class="form-control" style="width: 30%" >
                <?php
                if (count($pt) > 0) {
                    foreach ($pt as $value) {
                        $select = ($cabang['cb_compid'] == $value['compid']) ? 'selected' : '';
                        ?>
                        <option value="<?php echo $value['compid']; ?>" <?php echo $select; ?>><?php echo $value['comp_nama'] ?></option> 
                        <?php
                    }
                }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Alamat</label>
        <div class="col-sm-8">
            <textarea name="cb_alamat" class="ace col-xs-10 col-sm-5"><?php echo $cabang['cb_alamat'] ?></textarea>
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
                        $select = ($cabang['kota_propid'] == $value['propid']) ? 'selected' : '';
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
            <select name="cb_kotaid" id="cb_kotaid" class="form-control" style="width: 30%" >
                <?php
                if (count($kota) > 0) {
                    foreach ($kota as $value) {
                        $select = ($cabang['cb_kotaid'] == $value->kotaid) ? 'selected' : '';
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
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Npwp</label>
        <div class="col-sm-8">
            <input type="text" name="cb_npwp" id="cb_npwp" value="<?php echo $cabang['cb_npwp'] ?>"  placeholder="Npwp" class="col-xs-10 col-sm-5" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Telpon</label>
        <div class="col-sm-8">
            <input type="text" name="cb_telpon" id="cb_telpon" value="<?php echo $cabang['cb_telpon'] ?>"  placeholder="Nomer Telpon" class="col-xs-10 col-sm-5" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Fax</label>
        <div class="col-sm-8">
            <input type="text" name="cb_fax" id="cb_fax" value="<?php echo $cabang['cb_fax'] ?>"  placeholder="Fax" class="col-xs-10 col-sm-5" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Email</label>
        <div class="col-sm-8">
            <input type="email" name="cb_email" id="cb_email" value="<?php echo $cabang['cb_email'] ?>"  placeholder="email" class="col-xs-10 col-sm-5" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Icon</label>
        <div class="col-sm-4">
            <input type="file" name="cb_icon" id="cb_icon" class="file-input col-xs-10 col-sm-4" />
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
   
    jQuery(function($) {
        $('.file-input').ace_file_input({
            no_file:'Upload Icon',
            btn_choose:'Choose',
            btn_change:'Change',
            droppable:false,
            onchange:null,
            thumbnail:false //| true | large
            //whitelist:'gif|png|jpg|jpeg'
            //blacklist:'exe|php'
            //onchange:''
            //
        });
        //pre-show a file name, for example a previously selected file
        //$('#id-input-file-1').ace_file_input('show_file_list', ['myfile.txt'])
			
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
                $('#cb_kotaid').html('');
                $.each(data, function(messageIndex, message) {
                    $('#cb_kotaid').append('<option value="' + message.kotaid + '">' + message.kota_deskripsi + '</option>');
                });
            }
        })
    }
    $(this).ready(function() {
        $('#formMenu').submit(function() {
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                dataType: "json",
                async: false,
                data: new FormData( this ),
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $("#imgAjaxLoader")
                    .show();
                },
                success: function(data) {
                    window.scrollTo(0, 0);
                    $("#result").html(data).show().fadeIn("slow");
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