<div id="result"></div>
<form class="form-horizontal" id="form" method="post" action="<?php echo site_url('master_service/updateSupplier'); ?>" name="form">
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nama</label>
        <div class="col-sm-8">
            <input type="hidden" name="supid" value="<?php echo $data['supid']; ?>">
            <input type="text" name="sup_nama" value="<?php echo $data['sup_nama']; ?>" required="required" placeholder="Nama" class="upper req ace col-xs-10 col-sm-10" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Alamat</label>
        <div class="col-sm-8">
            <textarea name="sup_alamat" class="upper req ace col-xs-10 col-sm-7" required="required" rows="4"><?php echo $data['sup_alamat']; ?></textarea>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Propinsi</label>
        <div class="col-sm-8">
            <select name="propinsi" id="propinsi" onchange="getKota()" class="upper req ace col-xs-10 col-sm-3">
                <option value="">Pilih</option>
                <?php
                if (count($propinsi) > 0) {
                    foreach ($propinsi as $value) {
                        $select = ($data['kota_propid'] == $value['propid']) ? 'selected' : '';
                        ?>
                        <option value="<?php echo $value['propid']; ?>" <?php echo $select; ?>><?php echo $value['prop_deskripsi'] ?></option> 
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
            <select name="sup_kotaid" id="sup_kotaid" class="upper req ace col-xs-10 col-sm-3">
                <?php
                if (count($kota) > 0) {
                    foreach ($kota as $value) {
                        $select = ($data['pel_kotaid'] == $value->kotaid) ? 'selected' : '';
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
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nomor HP</label>
        <div class="col-sm-8">
            <input type="text" name="sup_hp" required value="<?php echo $data['sup_hp']; ?>"  placeholder="Nomor HP" class="upper req ace col-xs-10 col-sm-3" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nomor Telpon</label>
        <div class="col-sm-8">
            <input type="text" name="sup_telpon" value="<?php echo $data['sup_telpon']; ?>" placeholder="Nomor Telpon" class="ace col-xs-10 col-sm-3" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Fax</label>
        <div class="col-sm-8">
            <input type="text" name="sup_fax" value="<?php echo $data['sup_fax']; ?>"  placeholder="Nomor Fax" class="ace col-xs-10 col-sm-3" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">NPWP</label>
        <div class="col-sm-8">
            <input type="text" name="sup_npwp" value="<?php echo $data['sup_npwp']; ?>"  placeholder="Nomor NPWP" class="ace col-xs-10 col-sm-3" />
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
    var scripts = [null, null]
    $('.page-content-area').ace_ajax('loadScripts', scripts, function() {
        //inline scripts related to this page
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
                $('#sup_kotaid').html('');
                $.each(data, function(messageIndex, message) {
                    $('#sup_kotaid').append('<option value="' + message.kotaid + '">' + message.kota_deskripsi + '</option>');
                });
            }
        })
    }
    
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