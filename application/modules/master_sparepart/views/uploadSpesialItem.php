<div id="result"></div>
<form class="form-horizontal" id="form" method="post" action=""
      name="form" enctype="multipart/form-data">
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">&nbsp;</label>
        <div class="col-sm-8">
            <span>Silahkan download format dibawah ini <br></span><br>
            <strong>UNTUK MENYIMPAN EXCEL PASTIKAN SAVE AS->Excel 97-2003</strong><br>
            <a class="link" href="#" onclick="get_format()">Download format excel disini.</a>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Pilih File</label>
        <div class="col-sm-8">
            <input type="hidden" name="cek" value="cek">
            <input type="file" name="spesial" id="spesial"  class="file-input col-xs-10 col-sm-5" />
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
    function get_format()
    {
        window.scrollTo(0, 0);
        var left = (screen.width / 2) - ((screen.width/2) / 2);
        var top = (screen.height / 2) - ((screen.height/2) / 2);
        window.open('<?php echo site_url('master_sparepart/get_format_spesial'); ?>', '_blank',
        'toolbar=0,location=0,menubar=0,width='+screen.width/2+', height='+screen.height/2+', top=' + top + ', left=' + left);
    }
    
    $(this).ready(function() {
        $('#form').submit(function() {
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url('master_sparepart/saveSpesialItem'); ?>",
                dataType: "json",
                async: false,
                data: new FormData( this ),
                processData: false,
                contentType: false,
                success: function(data) {
                    window.scrollTo(0, 0);
                    if (data.result) {
                        alert("sukses");
                        var $el = $('#spesial');
                        $el.wrap('<form>').closest('form').get(0).reset();
                        $el.unwrap();
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