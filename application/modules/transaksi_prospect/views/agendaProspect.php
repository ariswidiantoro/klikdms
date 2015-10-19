<div id="result"></div>
<?php
echo $this->session->flashdata('msg');
?>
<form class="form-horizontal" id="form" method="post" action="<?php echo site_url('transaksi_prospect/saveAgenda'); ?>" name="form">
    <input type="hidden" value="<?php echo $prosid; ?>" name="prosid" id="prosid">
    <div class="row">
        <div>
            <input type="hidden" name="type" id="type">
            <!-- #section:elements.tab -->
            <div class="tabbable">
                <ul class="nav nav-tabs" id="myTab">
                    <li class="active">
                        <a data-toggle="tab" href="#agenda">
                            <i class="green ace-icon fa fa-home bigger-120"></i>
                            Agenda
                        </a>
                    </li>

                    <li>
                        <a data-toggle="tab" href="#follow">
                            <i class="green ace-icon fa fa-ban"></i>
                            Follow Up
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div id="agenda" class="tab-pane fade in active">
                        <div class="row">
                            <table id="simple-table" class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 60%">Keterangan</th>
                                        <th>Waktu</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (count($agenda) > 0) {
                                        foreach ($agenda as $value) {
                                            ?>
                                            <tr>
                                                <td><?php echo $value['agen_deskripsi'] ?></td>
                                                <td><?php echo date('d-m-Y H:i:s', strtotime($value['agen_tgl'])) ?></td>
                                            </tr>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <tr>
                                            <td colspan="3">Belum ada agenda</td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div  class="row">
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Agenda</label>
                                <div class="col-sm-8">
                                    <div class='input-group col-xs-10 col-sm-10'>
                                        <textarea name="agenda" id="data_agenda" class="form-control col-sm-5 req"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Waktu</label>
                                <div class="col-sm-8">
                                    <div class='input-group date col-xs-10 col-sm-4' id='datetimepicker1'>
                                        <input type='text' readonly="readonly" value="<?php echo date('d-m-Y H:i'); ?>" name="tgl_agenda" id="tgl_agenda" class="form-control req" />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix form-actions">
                                <div class="col-md-offset-1 col-md-5">
                                    <button class="btn btn-info" type="button" onclick="simpanAgenda()">
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
                        </div>
                    </div>


                    <div id="follow" class="tab-pane fade">
                        <div class="row">
                            <table id="simple-table" class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Agenda</th>
                                        <th>Tanggal</th>
                                        <th>Metode</th>
                                        <th>Statement</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (count($follow) > 0) {
                                        foreach ($follow as $value) {
                                            ?>
                                            <tr>
                                                <td><?php echo $value['agen_deskripsi'] ?></td>
                                                <td><?php echo date('d-m-Y H:i:s', strtotime($value['follow_tgl'])) ?></td>
                                                <td><?php echo $value['follow_metode']; ?></td>
                                                <td><?php echo $value['follow_statement']; ?></td>
                                                <td><?php echo $value['follow_deskripsi']; ?></td>
                                            </tr>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <tr>
                                            <td colspan="5">Belum ada follow up</td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div  class="row">
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Agenda</label>
                                <div class="col-sm-8">
                                    <div class='input-group col-xs-10 col-sm-10'>
                                        <select name="follow_agenid" id="follow_agenid" class="ace col-xs-10 col-sm-8">
                                            <?php
                                            if (count($agenda) > 0) {
                                                foreach ($agenda as $value) {
                                                    ?>
                                                    <option value="<?php echo $value['agenid'] ?>"><?php echo $value['agen_deskripsi'] ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Tgl</label>
                                <div class="col-sm-8">
                                    <div class='input-group date col-xs-10 col-sm-4' id='datetimepicker2'>
                                        <input type='text' readonly="readonly" value="<?php echo date('d-m-Y H:i'); ?>" name="follow_tgl" id="follow_tgl" class="form-control req" />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Metode</label>
                                <div class="col-sm-8">
                                    <div class='input-group date col-xs-10 col-sm-6' id='datetimepicker2'>
                                        <select name="follow_metode"  id="follow_metode" class="ace col-xs-10 col-sm-8">
                                            <option value="" required="required"> PILIH </option>
                                            <option value="CALL IN">CALL IN</option>
                                            <option value="CALL OUT"> CALL OUT</option>
                                            <option value="WALK IN">WALK IN</option>
                                            <option value="WALK OUT">WALK OUT</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Statement</label>
                                <div class="col-sm-8">
                                    <div class='input-group date col-xs-10 col-sm-6' id='datetimepicker2'>
                                        <select name="follow_statement"   id="follow_statement" class="ace col-xs-10 col-sm-8">
                                            <option  value="">Pilih Statement</option>
                                            <option value="TANYA HARGA /DP">Tanya harga /DP</option>
                                            <option value="SPK DENGAN TANDA JADI >1 JUTA" >SPK dengan Tanda jadi >1 juta</option>
                                            <option value="TANYA KREDIT /BUNGA">Tanya kredit /bunga</option>
                                            <option  value="INGIN / TELAH TEST DRIVE">Ingin / Telah Test Drive</option>
                                            <option value="SPK TANPA TANDA JADI">SPK Tanpa Tanda Jadi</option>
                                            <option value="SPK DENGAN TANDA JADI">SPK dengan Tanda Jadi</option>
                                            <option value="SPK DENGAN TANDA JADI < 1 JUTA">SPK dengan Tanda Jadi < 1 Juta</option>
                                            <option value="TANYA DATA LEASING">Tanya data leasing</option>
                                            <option value="MEMINTA HUBUNGI SEGERA">Meminta hubungi segera</option>
                                            <option value="OTHER">Other</option>
                                            <option value="MEMINTA QUOTATION/SPK">Meminta quotation/SPK</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Keterangan</label>
                                <div class="col-sm-8">
                                    <div class='input-group col-xs-10 col-sm-10'>
                                        <textarea name="follow_deskripsi" id="follow_deskripsi" class="form-control col-sm-5 req"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix form-actions">
                                <div class="col-md-offset-1 col-md-5">
                                    <button class="btn btn-info" type="button" onclick="simpanFollow()">
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
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.col -->
    </div>
    <div id="result" style="overflow-x: auto;margin:-2px 0 0 0;" >
    </div>
</form>
<script type="text/javascript">
    $(function () {
        $('#datetimepicker1').datetimepicker({format: 'DD-MM-YYYY HH:mm'});
        $('#datetimepicker2').datetimepicker({format: 'DD-MM-YYYY HH:mm'});
    });
    var scripts = [null, null]
    $('.page-content-area').ace_ajax('loadScripts', scripts, function() {
        //inline scripts related to this page
    });
    
    function simpanAgenda()
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo site_url('transaksi_prospect/saveAgenda'); ?>",
            dataType: "json",
            async: false,
            data: {
                'prosid'     : $("#prosid").val(),
                'agenda'     : $("#data_agenda").val(),
                'tgl_agenda' : $("#tgl_agenda").val()
            },
            success: function(data) {
                if (data.result) {
                    $('.page-content-area').ace_ajax('loadUrl', "#transaksi_prospect/agendaProspect?id="+$("#prosid").val(), false);
                }else{
                    bootbox.dialog({
                        message: "<span class='bigger-110'>Gagal menambah agenda</span>",
                        buttons: 			
                            {
                            "info" :
                                {
                                "label" : "Sukses !!",
                                "className" : "btn-sm btn-info"
                            }
                        }
                    });
                }
            }
        })
    }
    function simpanFollow()
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo site_url('transaksi_prospect/saveFollow'); ?>",
            dataType: "json",
            async: false,
            data: {
                'follow_agenid' : $("#follow_agenid").val(),
                'follow_tgl' : $("#follow_tgl").val(),
                'follow_metode' : $("#follow_metode").val(),
                'follow_statement' : $("#follow_statement").val(),
                'follow_deskripsi' : $("#follow_deskripsi").val()
            },
            success: function(data) {
                if (data.result) {
                    $('.page-content-area').ace_ajax('loadUrl', "#transaksi_prospect/agendaProspect?id="+$("#prosid").val(), false);
                }else{
                    bootbox.dialog({
                        message: "<span class='bigger-110'>Gagal menambah follow</span>",
                        buttons: 			
                            {
                            "info" :
                                {
                                "label" : "Sukses !!",
                                "className" : "btn-sm btn-info"
                            }
                        }
                    });
                }
            }
        })
    }
</script>