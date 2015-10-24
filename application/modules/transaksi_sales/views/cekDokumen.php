<div id="msg"></div>
<?php
echo $this->session->flashdata('msg');
?>
<style type="text/css">
    .ui-autocomplete {
        max-height: 200px;
        overflow-y: auto;
        overflow-x: hidden;
        padding-right: 20px;
    }
    * html .ui-autocomplete {
        height: 200px;
    }
    input:focus {
        background-color: yellow;
    } 
</style>
<form class="form-horizontal" name="formAdd" method="post" action="" id="formAdd">
    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1">No Spk</label>
        <div class="col-sm-7">
            <input type="text" required="required" maxlength="30" autofocus name="spk_no"
                   id="spk_no" class="col-xs-10 col-sm-5 upper req" />
            <input type="hidden" name="spkid" id="spkid">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1">No Kontrak</label>
        <div class="col-sm-7">
            <input type="text" readonly maxlength="30" name="spk_nokontrak"
                   id="spk_nokontrak" class="col-xs-10 col-sm-5 upper req" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Kategory</label>
        <div class="col-sm-7">
            <select name="kategory" id="kategory" onchange="lihat()" class="ace col-xs-10 col-sm-4" >
                <option value="0">PILIH</option>
                <?php
                if (count($kategory) > 0) {
                    foreach ($kategory as $value) {
                        ?>
                        <option value="<?php echo $value['ckid']; ?>"><?php echo $value['ck_deskripsi'] ?></option> 
                        <?php
                    }
                }
                ?>
            </select> 
        </div>
    </div>
    <div class="form-group">
        <div id="result" align="center" style="overflow-x: auto;margin:-2px 0 0 0;">
        </div>
    </div>


    <div class="clearfix form-actions">
        <div class="col-md-offset-1 col-md-5">
            <button class="btn btn-success" type="button" onclick="javascript:saveData()">
                <i class="ace-icon fa fa-check bigger-50"></i>
                Simpan
            </button>
            &nbsp; &nbsp; &nbsp;
            <button class="btn" type="reset">
                <i class="ace-icon fa fa-undo bigger-50"></i>
                Reset
            </button>
            &nbsp; &nbsp; &nbsp;
        </div>
    </div>
</form>
<script type="text/javascript">
    //called when key is pressed in textbox
    numberOnly();
    function submited(actions) {
        $('#result').html('');
        $.ajax({
            type: 'POST',
            url: '' + actions + '',
            data: {
                kategory: $("#kategory").val(),
                spkid: $("#spkid").val()
            },
            success: function(data) {
                $('#result').html(data);
                $('#result').fadeIn('fast');
            }
        })
    }

    function lihat() {
        submited('<?php echo site_url('transaksi_sales/dataCekDokumen'); ?>');
        if ($('#tranid').val() == '') {
            alert('KODE PERKIRAAN TDK BOLEH KOSONG');
        } else {
            $('#form').submit();
        }
        $('#form').unbind('submit');
    }
    
    
    function saveData(){
        var result = false;
        if(!$('#formAdd').valid()){
            e.preventDefault();
        }else{
            bootbox.confirm("Anda yakin data sudah benar ?", function(result) {
                if(result) {
                    $("#formAdd").submit();
                }
            });
        }
        return false;
    }
    
    function total(){    
        var total = 0;
        var price;
        $(".harga").each(function() {
            price = $(this).val().replace(/,/g, "");
            total += Number(price);
        });
        total -= Number($("#fpk_um").val().replace(/,/g, ""));
        $("#fpk_total").val(formatDefaultTanpaDecimal(total));
    }
    $(this).ready(function() {
        $('#formAdd').validate({
            errorElement: 'div',
            errorClass: 'help-block',
            focusInvalid: false,
            ignore: "",
            rules: {},
            messages: {},
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
            },
            submitHandler: function (form) {
            },
            invalidHandler: function (form) {
            }
        });
        
        $('#formAdd').submit(function() {
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url('transaksi_sales/saveCekDokumen') ?>",
                dataType: "json",
                async: false,
                data: $(this).serialize(),
                success: function(data) {
                    window.scrollTo(0, 0);
                    if(data.result){
                        $('.page-content-area').ace_ajax('loadUrl', "#transaksi_sales/cekDokumen", true);
                    }
                    else
                        $("#msg").html(data.msg).show().fadeIn("slow");
                }
            })
            return false;
        });
        
        $("#spk_no").autocomplete({
            minLength: 1,
            source: function(req, add) {
                $.ajax({
                    url: '<?php echo site_url('transaksi_sales/autoSpk'); ?>',
                    dataType: 'json',
                    type: 'POST',
                    data: {
                        param : $("#spk_no").val(),
                        approve : 0
                    },
                    success: function(data) {
                        add(data);
                    }
                });
            },
            create: function () {
                $(this).data('ui-autocomplete')._renderItem = function (ul, item) {
                    return $('<li>')
                    .append("<a><strong>" + item.value + "</strong><br>" + item.spk_nokontrak + "</a>")
                    .appendTo(ul);
                };
            },
            select: function(event, ui) {
                $("#spk_nokontrak").val(ui.item.spk_nokontrak);
                $("#spkid").val(ui.item.spkid);
            }
        });

    });
    
    var scripts = [null, null]
    $('.page-content-area').ace_ajax('loadScripts', scripts, function() {
        //inline scripts related to this page
    });
</script> 
