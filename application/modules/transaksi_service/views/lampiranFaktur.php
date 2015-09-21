<div id="result"></div>
<form class="form-horizontal" id="formRole" method="post" action="" name="formRole">
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nomor Wo</label>
        <div class="col-sm-8">
            <input type="text" name="wo" id="wo" placeholder="Nomer Wo" class="upper col-xs-10 col-sm-5" />
            <a href="javascript:;" onclick="lihatLampiran()" class="btn btn-sm btn-primary">
                <i class="ace-icon fa fa-eye"></i>
                Lihat Lampiran</a>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nomor Polisi</label>
        <div class="col-sm-8">
            <input type="text" name="cb_nama" readonly="readonly" id="cb_nama" class="upper col-xs-10 col-sm-5" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nama Pelanggan</label>
        <div class="col-sm-8">
            <input type="text" name="cb_telpon" readonly="readonly" id="cb_telpon" class="upper col-xs-10 col-sm-5" />
        </div>
    </div>
</form>
<script type="text/javascript">
    function lihatLampiran()
    {
        var params  = 'width=1000';
        var left = (screen.width/2)-(1000/2);
        var top = (screen.height/2);
        params += ', height='+screen.height;
        params += ', fullscreen=yes,scrollbars=yes,left='+left+'top='+top;
        window.open("<?php echo site_url("transaksi_service/printLampiranFakturService"); ?>/"+$("#wo").val(),'_blank', params);
    }
    var scripts = [null, null]
    $('.page-content-area').ace_ajax('loadScripts', scripts, function() {
        //inline scripts related to this page
    });
</script> 