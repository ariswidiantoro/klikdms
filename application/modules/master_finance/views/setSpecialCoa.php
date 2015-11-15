<style type="text/css">
    html .ui-autocomplete { 
        /* without this, the menu expands to 100% in IE6 */
        max-height: 200px;
        padding-right: 20px;
        overflow-y: auto;
        width:300px; 
    }      
</style>
<div id="result"></div>
<div class="page-header">
    <h1>
        Setting Special COA
    </h1>
</div>
<form class="form-horizontal" id="formEdit" method="post" action="<?php echo site_url('master_finance/saveSetSpecialCoa'); ?>" name="formEdit">
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Deskripsi</label>
        <div class="col-sm-8">
            <input type="text" required="required" readonly value="<?php echo $data['spec_deskripsi'] ?>" maxlength="50" 
                   name="spec_deskripsi" id="spec_deskripsi"  class="ace col-xs-10 col-sm-10 upper" />
            <input type="hidden" required="required"  value="<?php echo $data['specid'] ?>" name="specid" id="specid"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Kode</label>
        <div class="col-sm-8">
            <input type="text" required="required" value="<?php echo $data['setcoa_kode'] ?>" 
                   maxlength="20" placeholder="COA"
                   name="coa" id="coa"  class="ace col-xs-10 col-sm-5 upper" autocomplete="off" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">&nbsp;</label>
        <div class="col-sm-8">
            <label>
                <input class="ace" id="breakdown" value="1" type="checkbox" <?php if($data['setcoa_is_breakdown'] == '1') echo 'checked';?> name="breakdown">
                <span class="lbl"> Breakdown Saldo</span>
            </label>
        </div>
    </div>
    <div class="clearfix form-actions">
        <div class="col-md-offset-1 col-md-5">
            <button class="btn btn-info" type="button" onclick="javascript:saveData()">
                <i class="ace-icon fa fa-check bigger-50"></i>
                Update
            </button>

            &nbsp; &nbsp; &nbsp;
            <button class="btn btn-danger" type="button" onclick="javascript:redirect('data');">
                <i class="ace-icon fa 	fa-ban bigger-50"></i>
                Batal
            </button>
        </div>
    </div>
</form>
<script type="text/javascript">
    function redirect(data){
        bootbox.confirm("Anda yakin ?", function(result) {
            if(result) {
                window.location.href = "#master_finance/specialCoa";
            }});
    }
    
    function saveData(){
        var result = false;
        if(!$('#formEdit').valid()){
            
        }else{
            bootbox.confirm("Anda yakin data sudah benar ?", function(result) {
                if(result) {
                    $("#formEdit").submit();
                }
            });
        }
        return false;
    }
    
    $(this).ready(function() {    
        $("#coa").autocomplete({
            minLength: 1,
            source: function(req, add) {
                $.ajax({
                    url: "<?php echo site_url('auto_complete/auto_coa'); ?>",
                    dataType: 'json',
                    type: 'POST',
                    data: {
                        param : $("#coa").val(),
                        cbid : '<?php echo ses_cabang ?>'
                    },
                    success: function(data) {
                        add(data.message);
                    }
                });
            },
            create: function () {
                $(this).data('ui-autocomplete')._renderItem = function (ul, item) {
                    return $('<li></li>')
                    .append("<strong>" + item.value + "</strong><br>" + item.desc + "")
                    .appendTo(ul);
                };
            }
        });
        
        $('#formEdit').submit(function() {
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url('master_finance/saveSetSpecialCoa') ?>",
                dataType: "json",
                async: false,
                data: $(this).serialize(),
                success: function(data) {
                    window.scrollTo(0, 0);
                    if(data.status == true)
                        document.formEdit.reset();
                    $("#result").html(data.msg).show().fadeIn("slow");
                }
            })
            return false;
        });
        
        $('#formEdit').validate({
            errorElement: 'div',
            errorClass: 'help-block',
            focusInvalid: false,
            ignore: "",
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
            }
        });
    });
    
    var scripts = [null, null]
    $('.page-content-area').ace_ajax('loadScripts', scripts, function() {
        //inline scripts related to this page
    });
</script> 
