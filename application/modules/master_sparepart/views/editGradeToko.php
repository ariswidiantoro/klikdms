<div id="result"></div>
<style>
    .ui-autocomplete {
        max-height: 200px;
        overflow-y: auto;
        overflow-x: hidden;
        color: black;
        padding-right: 20px;
    }
    * html .ui-autocomplete {
        height: 200px;
    }
</style>
<form class="form-horizontal" id="form" method="post" action="<?php echo site_url('master_sparepart/updateGradeToko'); ?>" name="form">
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nama</label>
        <div class="col-sm-8">
            <input type="text" name="pel_nama" value="<?php echo $data['pel_nama']; ?>" id="pel_nama" autocomplete="off" spellcheck="false" required="required" placeholder="Nama" class="upper ace col-xs-10 col-sm-5" />
            <input type="hidden" name="gradid" value="<?php echo $data['gradid']; ?>"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Kode Pelanggan</label>
        <div class="col-sm-8">

            <input type="text" name="pelid" value="<?php echo $data['pelid']; ?>" required="required" id="pelid" placeholder="Kode Pelanggan" class="upper ace col-xs-10 col-sm-5" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Alamat</label>
        <div class="col-sm-8">
            <textarea name="pel_alamat" id="pel_alamat" class="upper ace col-xs-10 col-sm-7" required="required" rows="4"><?php echo $data['pel_alamat']; ?></textarea>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Plus 1</label>
        <div class="col-sm-8">
            <input type="text" name="grad_1" value="<?php echo $data['grad_1']; ?>" id="grad_1" autocomplete="off" spellcheck="false" required="required" value="0" class="number ace col-xs-10 col-sm-1" />%
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Plus 2</label>
        <div class="col-sm-8">
            <input type="text" name="grad_2" id="grad_2" value="<?php echo $data['grad_2']; ?>" autocomplete="off" spellcheck="false" required="required" value="0" class="number ace col-xs-10 col-sm-1" />%
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Plus 3</label>
        <div class="col-sm-8">
            <input type="text" name="grad_3" id="grad_3" value="<?php echo $data['grad_3']; ?>" autocomplete="off" spellcheck="false" required="required" value="0" class="number ace col-xs-10 col-sm-1" />%
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
<script src="http://cdn.jsdelivr.net/typeahead.js/0.9.3/typeahead.min.js"></script>
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">

<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
<script type="text/javascript">
    var scripts = [null, null]
    $('.page-content-area').ace_ajax('loadScripts', scripts, function() {
        //inline scripts related to this page
    
    });
    $(".number").keypress(function (e) {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 47 && e.which != 0 && (e.which < 46 || e.which > 57)){
            //display error message
            //        $("#errmsg").html("Digits Only").show().fadeOut("slow");
            return false;
        }
    });
    
    $(document).ready(function(){
        $("#pel_nama").autocomplete({
            minLength: 1,
            source: function(req, add) {
                $.ajax({
                    url: '<?php echo site_url('master_service/jsonPelanggan'); ?>',
                    dataType: 'json',
                    type: 'POST',
                    data: {param : $("#pel_nama").val()},
                    success: function(data) {
                        if (data.response == "true") {
                            add(data.message);
                        } else {
                            add(data.value);
                        }
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
                $("#pelid").val(ui.item.pelid);
                $("#pel_alamat").html(ui.item.desc);
            }
        })
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
//                        $("#pel_alamat").html("");
                    }
                    $("#result").html(data.msg).show().fadeIn("slow");
                }
            })
            return false;
        });

    });
   
</script>
