<form class="form-horizontal" id="formMenu" method="post" action="<?php echo site_url('perijinan/simpanSurvey'); ?>" name="formRole"  enctype="multipart/form-data">
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nomor</label>
        <div class="col-sm-8">
            <input type="text" name="kon_nama" required="required" id="dok_deskripsi" placeholder="Nama Kontraktor" class="col-xs-10 col-sm-9" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nama Direktur</label>
        <div class="col-sm-8">
            <input type="text" name="kon_direktur" required="required" placeholder="Nama Direktur" class="col-xs-10 col-sm-9" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Npwp</label>
        <div class="col-sm-8">
            <span style="float: left;width: 30%;">
                <input type="text" name="kon_npwp_nomor" required="required" style="width: 95%" placeholder="Nomor Npwp"/>
            </span>

            <span style="float: left;width: 30%;">
                <input type="file" name="kon_npwp_gambar"  class="file-input col-xs-10 col-sm-9" />
            </span>

        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Siup</label>
        <div class="col-sm-8">
            <span style="float: left;width: 30%;">
                <input type="text" name="kon_siup_nomor" required="required" style="width: 95%" placeholder="Nomor Siup"/>
            </span>

            <span style="float: left;width: 30%;">
                <input type="file" name="kon_siup_gambar"  class="file-input col-xs-10 col-sm-9" />
            </span>

        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Siujk</label>
        <div class="col-sm-8">
            <span style="float: left;width: 30%;">
                <input type="text" name="kon_siujk_nomor" required="required" style="width: 95%" placeholder="Nomor Siujk"/>
            </span>

            <span style="float: left;width: 30%;">
                <input type="file" name="kon_siujk_gambar"  class="file-input col-xs-10 col-sm-9" />
            </span>

        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Tdp</label>
        <div class="col-sm-8">
            <span style="float: left;width: 30%;">
                <input type="text" name="kon_tdp_nomor" required="required" style="width: 95%" placeholder="Nomor Tdp"/>
            </span>

            <span style="float: left;width: 30%;">
                <input type="file" name="kon_tdp_gambar"  class="file-input col-xs-10 col-sm-9" />
            </span>

        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Domisili</label>
        <div class="col-sm-8">
            <span style="float: left;width: 30%;">
                <input type="text" name="kon_domisili_nomor" required="required" style="width: 95%" placeholder="Nomor Surat Domisili"/>
            </span>

            <span style="float: left;width: 30%;">
                <input type="file" name="kon_domisili_gambar"  class="file-input col-xs-10 col-sm-9" />
            </span>

        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Akta Pendirian</label>
        <div class="col-sm-8">
            <span style="float: left;width: 30%;">
                <input type="text" name="kon_akta_nomor" required="required" style="width: 95%" placeholder="Nomor Akta Pendirian"/>
            </span>

            <span style="float: left;width: 30%;">
                <input type="file" name="kon_akta_gambar"  class="file-input col-xs-10 col-sm-9" />
            </span>

        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Lokasi</label>
        <div class="col-sm-8">
            <input type="text" name="kon_lokasi" required="required" placeholder="Lokasi" class="col-xs-10 col-sm-9" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Alamat</label>
        <div class="col-sm-8">
            <textarea name="kon_alamat" cols="3" rows="4" class="col-xs-10 col-sm-9">

            </textarea>
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
<script type="text/javascript" src="<?php echo path_js(); ?>ace/elements.fileinput.js"></script>
<script type="text/javascript">
    jQuery(function($) {
        $('.file-input').ace_file_input({
            no_file:'Upload Scan',
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
</script>