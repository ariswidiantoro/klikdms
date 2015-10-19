<div id="result"></div>
<div class="page-header">
    <h1>
        Update Chart of Account <?php echo $data['coa_kode'] ?>
    </h1>
</div>
<form class="form-horizontal" id="formEdit" method="post" action="<?php echo site_url('master_finance/updateCoa'); ?>" name="formEdit">
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Kode COA</label>
        <div class="col-sm-8">
            <input type="text" required="required" maxlength="30" value="<?php echo $data['coa_kode'] ?>" style='text-transform:uppercase' name="coa_kode" id="coa_kode" class="col-xs-10 col-sm-5" />
            <input type="hidden" required="required"  value="<?php echo $data['coaid'] ?>" name="coaid" id="coaid"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Deskripsi</label>
        <div class="col-sm-8">
            <input type="text" required="required" value="<?php echo $data['coa_desc'] ?>" maxlength="50" style='text-transform:uppercase' name="coa_desc" id="coa_desc"  class="ace col-xs-10 col-sm-10" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Tipe</label>
        <div class="col-sm-8">
            <select class="form-control input-xlarge" id="coa_type" name="coa_type">
                <option value="">PILIH</option>
                <optgroup label="AKTIVA">
                <option value="1" <?php if ($data['coa_type'] == '1') echo 'selected'; ?>>KAS</option>
                <option value="2" <?php if ($data['coa_type'] == '2') echo 'selected'; ?>>BANK</option>
                <option value="3" <?php if ($data['coa_type'] == '3') echo 'selected'; ?>>PIUTANG DAGANG</option>
                <option value="4" <?php if ($data['coa_type'] == '4') echo 'selected'; ?>>PERSEDIAAN</option>
                <option value="5" <?php if ($data['coa_type'] == '5') echo 'selected'; ?>>BIAYA DIBAYAR DIMUKA</option>
                <option value="6" <?php if ($data['coa_type'] == '6') echo 'selected'; ?>>INVESTASI JANGKA PANJANG</option>
                <option value="7" <?php if ($data['coa_type'] == '7') echo 'selected'; ?>>HARTA TETAP BERWUJUD</option>
                <option value="8" <?php if ($data['coa_type'] == '8') echo 'selected'; ?>>HARTA TETAP TIDAK BERWUJUD</option>
                <option value="9" <?php if ($data['coa_type'] == '9') echo 'selected'; ?>>HARTA LAINNYA</option>
                <optgroup label="PASIVA">
                <option value="10" <?php if ($data['coa_type'] == '10') echo 'selected'; ?>>HUTANG LANCAR</option>
                <option value="11" <?php if ($data['coa_type'] == '11') echo 'selected'; ?>>PENDAPATAN DITERIMA DIMUKA</option>
                <option value="12" <?php if ($data['coa_type'] == '12') echo 'selected'; ?>>HUTANG JANGKA PANJANG</option>
                <option value="13" <?php if ($data['coa_type'] == '13') echo 'selected'; ?>>HUTANG LAINNYA</option>
                <optgroup label="MODAL">
                <option value="14" <?php if ($data['coa_type'] == '14') echo 'selected'; ?>>MODAL</option>
                <optgroup label="RUGI-LABA">
                <option value="15" <?php if ($data['coa_type'] == '15') echo 'selected'; ?>>PENJUALAN</option>
                <option value="16" <?php if ($data['coa_type'] == '16') echo 'selected'; ?>>HPP</option>
                <option value="17" <?php if ($data['coa_type'] == '17') echo 'selected'; ?>>PENDAPATAN USAHA</option>
                <option value="18" <?php if ($data['coa_type'] == '18') echo 'selected'; ?>>PENDAPATAN LAIN</option>
                <option value="19" <?php if ($data['coa_type'] == '19') echo 'selected'; ?>>BIAYA PRODUKSI</option>
                <option value="20" <?php if ($data['coa_type'] == '20') echo 'selected'; ?>>BIAYA LAINNYA</option>
                <option value="21" <?php if ($data['coa_type'] == '21') echo 'selected'; ?>>BIAYA OPERASIONAL</option>
                <option value="22" <?php if ($data['coa_type'] == '22') echo 'selected'; ?>>BIAYA NON OPERASIONAL</option>
                <option value="23" <?php if ($data['coa_type'] == '23') echo 'selected'; ?>>BIAYA LAINNYA</option>
                <option value="24" <?php if ($data['coa_type'] == '24') echo 'selected'; ?>>PENDAPATAN LUAR USAHA</option>
                <option value="25" <?php if ($data['coa_type'] == '25') echo 'selected'; ?>>PENGELUARAN LUAR USAHA</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Level</label>
        <div class="col-sm-8">
            <select class="form-control input-medium" id="coa_level" name="coa_level">
                <option value="0"></option>
                <option value="1" <?php if ($data['coa_level'] == '1') echo 'selected'; ?>>1</option>
                <option value="2" <?php if ($data['coa_level'] == '2') echo 'selected'; ?>>2</option>    
                <option value="3" <?php if ($data['coa_level'] == '3') echo 'selected'; ?>>3</option>    
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Kas / Bank</label>
        <div class="col-sm-8">
           <select class="ace col-xs-10 col-sm-5" id="kas_bank" name="kas_bank">
                <option value=""></option>
                <option value="1" <?php if ($data['coa_is_kas_bank'] == '1') echo 'selected'; ?>>KAS</option>
                <option value="2" <?php if ($data['coa_is_kas_bank'] == '2') echo 'selected'; ?>>BANK</option>    
                <option value="3" <?php if ($data['coa_is_kas_bank'] == '3') echo 'selected'; ?>>CEK</option>    
            </select><i>* PILIH JIKA ACCOUNT UTAMA KAS/BANK/CEK</i>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">&nbsp;</label>
        <div class="col-sm-8">
            <label>
                <input class="ace" id="rugi_laba" value="1" 
                       type="checkbox" <?php if ($data['coa_is_rugi_laba'] == '1') echo 'checked'; ?> name="rugi_laba">
                <span class="lbl"> Masuk Rugi Laba</span>
            </label>
        </div>
    </div>
    
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">&nbsp;</label>
        <div class="col-sm-8">
            <label>
                <input class="ace" id="auto_jurnal" value="1" 
                       type="checkbox" <?php if ($data['coa_is_auto_jurnal'] == '1') echo 'checked'; ?> name="auto_jurnal">
                <span class="lbl"> Automatic Jurnal</span>
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
                window.location.href = "#master_finance/coa";
            }});
    }
    
    function saveData(){
        var result = false;
        bootbox.confirm("Anda yakin data sudah benar ?", function(result) {
            if(result) {
                $("#formEdit").submit();
            }
        });
        return false;
    }
    
    $(this).ready(function() {
        $('#formEdit').submit(function() {
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url('master_finance/updateCoa') ?>",
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

    });
    var scripts = [null, null]
    $('.page-content-area').ace_ajax('loadScripts', scripts, function() {
        //inline scripts related to this page
    });
</script> 