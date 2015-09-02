<div id="result"></div>
<form class="form-horizontal" id="form" method="post" action="<?php echo site_url('master_service/savePelanggan'); ?>" name="form">
    <div class="page-header">
        <h1>
            <small>
                Data Pelanggan
            </small>
        </h1>
    </div><!-- /.page-header -->
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nama</label>
        <div class="col-sm-8">
            <input type="text" name="pel_nama" required="required" placeholder="Nama" class="upper ace col-xs-10 col-sm-5" />
            <button class="btn btn-sm btn-primary ace col-xs-10 col-sm-4" type="button">
                Tambah Pelanggan
            </button>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Kode Pelanggan</label>
        <div class="col-sm-8">
            <input type="text" name="pel_nama" required="required" placeholder="Kode Pelanggan" class="upper ace col-xs-10 col-sm-5" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Alamat</label>
        <div class="col-sm-8">
            <textarea name="pel_alamat" class="upper ace col-xs-10 col-sm-7" required="required" rows="4"></textarea>
        </div>
    </div>
    <div class="page-header">
        <h1>
            <small>
                Data Kendaraan
            </small>
        </h1>
    </div><!-- /.page-header -->


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
