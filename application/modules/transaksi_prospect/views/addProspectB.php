<div id="result"></div>
<div class="page-header">
    <h1>
        Tambah Leasing
    </h1>
</div>

<form class="form-horizontal" id="formAdd" method="post" action="<?php echo site_url('master_sales/saveLeasing'); ?>" name="formAdd">
    <form class="form-horizontal" id="form" method="post" action="<?php echo site_url('master_service/savePelanggan'); ?>" name="form">
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Type Pelanggan</label>
        <div class="col-sm-8">
            <select name="pel_type" required="required" class="form-control" style="width:30%;">
                <option value="">Pilih</option>
                <option value="retail">Retail</option>
                <option value="broker">Broker</option>
                <option value="fleet">Fleet</option>
                <option value="gso">Gso/Pemerintahan</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nama</label>
        <div class="col-sm-8">
            <input type="text" name="pel_nama" required="required" placeholder="Nama" class="upper ace col-xs-10 col-sm-10" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Alamat</label>
        <div class="col-sm-8">
            <textarea name="pel_alamat" class="upper ace col-xs-10 col-sm-7" required="required" rows="4"></textarea>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Propinsi</label>
        <div class="col-sm-8">
            <select name="propinsi" id="propid" onchange="getKota()" class="form-control" style="width:30%;">
                <option value="">Pilih</option>
                <?php
                if (count($propinsi) > 0) {
                    foreach ($propinsi as $value) {
                        ?>
                        <option value="<?php echo $value['propid']; ?>"><?php echo $value['prop_deskripsi'] ?></option> 
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
            <select name="pel_kotaid" id="kotaid" class="form-control" style="width:30%;">
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Alamat Surat</label>
        <div class="col-sm-8">
            <textarea name="pel_alamat_surat" class="ace col-xs-10 col-sm-7" rows="4"></textarea>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right number" for="form-field-1">Nomor HP</label>
        <div class="col-sm-8">
            <input type="text" name="pel_hp"  placeholder="Nomor HP" class="ace col-xs-10 col-sm-3" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right number" for="form-field-1">Nomor KTP</label>
        <div class="col-sm-8">
            <input type="text" name="pel_nomor_id" placeholder="Nomor HP" class="ace col-xs-10 col-sm-3" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right number" for="form-field-1">Nomor Telpon</label>
        <div class="col-sm-8">
            <input type="text" name="pel_telpon" placeholder="Nomor Telpon" class="ace col-xs-10 col-sm-3" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Fax</label>
        <div class="col-sm-8">
            <input type="text" name="pel_fax"  placeholder="Nomor Fax" class="ace col-xs-10 col-sm-3" />
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Tempat Lahir</label>
        <div class="col-sm-8">
            <input type="text" name="pel_tempat_lahir"  placeholder="Tempat Lahir" class="ace col-xs-10 col-sm-5" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Tgl Lahir</label>
        <div class="col-sm-8">
            <div class="input-group input-group-sm col-sm-2">
                <input type="text" name="pel_tgl_lahir" id="datepicker" class="form-control" />
                <span class="input-group-addon">
                    <i class="ace-icon fa fa-calendar"></i>
                </span>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Jenis Kelamin</label>
        <div class="col-sm-8">
            <div class="radio">
                <label>
                    <input name="pel_gender" type="radio" value="L" class="ace" />
                    <span class="lbl">Laki-Laki</span>
                </label>
            </div>

            <div class="radio">
                <label>
                    <input name="pel_gender" type="radio" value="P" class="ace" />
                    <span class="lbl">Perempuan</span>
                </label>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Email</label>
        <div class="col-sm-8">
            <input type="text" name="pel_email"  placeholder="Email" class="ace col-xs-10 col-sm-5" />
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Agama</label>
        <div class="col-sm-8">
            <div class="radio">
                <label>
                    <input name="pel_agama" type="radio" value="islam" class="ace" />
                    <span class="lbl">Islam</span>
                </label>
            </div>
            <div class="radio">
                <label>
                    <input name="pel_agama" type="radio" value="kristen" class="ace" />
                    <span class="lbl">Kristen</span>
                </label>
            </div>
            <div class="radio">
                <label>
                    <input name="pel_agama" type="radio" value="budha" class="ace" />
                    <span class="lbl">Budha</span>
                </label>
            </div>
            <div class="radio">
                <label>
                    <input name="pel_agama" type="radio" value="katolik" class="ace" />
                    <span class="lbl">Katolik</span>
                </label>
            </div>
            <div class="radio">
                <label>
                    <input name="pel_agama" type="radio" value="hindu" class="ace" />
                    <span class="lbl">Hindu</span>
                </label>
            </div>
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
            <button class="btn btn-info" type="button" onclick="javascript:redirect('data');">
                <i class="ace-icon fa 	fa-book bigger-50"></i>
                Daftar Leasing
            </button>
        </div>
    </div>
</form>

<script type="text/javascript">
    function redirect(data){
        bootbox.confirm("Anda yakin kembali ?", function(result) {
            if(result) {
                window.location.href = "#master_sales/masterLeasing";
            }});
    }
    
    function saveData(){
        var result = false;
        bootbox.confirm("Anda yakin data sudah benar ?", function(result) {
            if(result) {
                $("#formAdd").submit();
            }
        });
        return false;
    }
    
    function getKota(){
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('master_sales/jsonKota') ?>',
            dataType: "json",
            async: false,
            data: {
                propid : $("#propid").val()
            },
            success: function(data) {
                $('#leas_kotaid').html('');
                $('#leas_kotaid').append('<option value="">PILIH</option>');
                $.each(data, function(messageIndex, message) {
                    $('#leas_kotaid').append('<option value="' + message['kotaid'] + '">' + message['kota_deskripsi'] + '</option>');
                });
            }
        })
    }
    
    $(this).ready(function() {
        //called when key is pressed in textbox
        $(".number").keypress(function (e) {
            //if the letter is not digit then display error and don't type anything
            if (e.which != 8 && e.which != 47 && e.which != 0 && (e.which < 46 || e.which > 57)){
                return false;
            }
        });
    
        $('#formAdd').submit(function() {
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url('master_sales/saveLeasing') ?>",
                dataType: "json",
                async: false,
                data: $(this).serialize(),
                success: function(data) {
                    window.scrollTo(0, 0);
                    document.formAdd.reset();
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