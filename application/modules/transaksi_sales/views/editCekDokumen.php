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
            <input type="text" readonly maxlength="30" value="<?php echo $data['spk_no'] ?>" autofocus name="spk_no"
                   id="spk_no" class="col-xs-10 col-sm-5 upper req" />
            <input type="hidden" name="spkid" value="<?php echo $data['spkid'] ?>" id="spkid">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1">No Kontrak</label>
        <div class="col-sm-7">
            <input type="text" readonly maxlength="30" name="spk_nokontrak"
                   id="spk_nokontrak" value="<?php echo $data['spk_nokontrak'] ?>" class="col-xs-10 col-sm-5 upper req" />
            <input type="hidden" value="" name="fpk_spkid" id="fpk_spkid">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Kategory</label>
        <div class="col-sm-7">
            <input type="text" readonly maxlength="30" value="<?php echo $data['ck_deskripsi'] ?>" class="col-xs-10 col-sm-5 upper req" />
        </div>
    </div>
    <div class="form-group">
        <div id="result" align="center" style="overflow-x: auto;margin:-2px 0 0 0;">
            <table id="table" class="table table-bordered">
                <thead>
                    <tr class="timetable">
                        <th>Dokumen</th>
                        <th>Nomer Dokumen</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (count($cek) > 0) {
                        foreach ($cek as $value) {
                            ?>
                            <tr>
                                <td style="text-align: left">
                                    <?php echo $value['cek_deskripsi'] ?>
                                    <input type="hidden" name="id[]" value="<?php echo $value['cekid']; ?>">
                                </td>
                                <td>
                                    <input type="text" name="dokumen[]" value="<?php echo $value['list_nomer'] ?>" maxlength="30" style="width: 100%" class="col-xs-10 col-sm-10 upper">
                                </td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
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
            data: {kategory: $("#kategory").val()},
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
                url: "<?php echo site_url('transaksi_sales/updateCekDokumen') ?>",
                dataType: "json",
                async: false,
                data: $(this).serialize(),
                success: function(data) {
                    window.scrollTo(0, 0);
                    if(data.result){
                        $('.page-content-area').ace_ajax('loadUrl', "#transaksi_sales/editCekDokumen?id="+$("#spkid").val(), true);
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
                    data: {param : $("#spk_no").val()},
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
