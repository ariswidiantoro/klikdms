<div id="result"></div>
<form class="form-horizontal" id="form" method="post" action="<?php echo site_url('master_sparepart/saveSpesialItem'); ?>" name="form">
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Pilih File</label>
        <div class="col-sm-8">
            <input type="file" name="rak_deskripsi" placeholder="Nama Rak" class="file-input col-xs-10 col-sm-5" />
            <!--<input type="file" name="file"  class="file-input ace col-xs-10 col-sm-3" />-->
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
<!--<script type="text/javascript" src="<?php echo path_js(); ?>ace/elements.fileinput.js"></script>-->
<script type="text/javascript">
    $(this).ready(function() {
        $('#form').submit(function() {
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
    
    jQuery(function($) {
        $('.file-input').ace_file_input({
            no_file:'Pilih File',
            btn_choose:'Choose',
            btn_change:'Change',
            droppable:false,
            onchange:null,
            thumbnail:false, //| true | large
            whitelist:'xls'
            //blacklist:'exe|php'
            //onchange:''
            //
        });
        //pre-show a file name, for example a previously selected file
        //$('#id-input-file-1').ace_file_input('show_file_list', ['myfile.txt'])
			
    });
    var scripts = [null, null]
    $('.page-content-area').ace_ajax('loadScripts', scripts, function() {
        //inline scripts related to this page
    });
</script> 