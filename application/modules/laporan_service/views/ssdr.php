<form class="form-horizontal" id="form" method="post" action="" name="form">
    <div class="row">
        <div  class="well well-sm">
            <input type="hidden" name="type" id="type">
            <!-- #section:elements.tab -->
            <div class="tabbable">
                <ul class="nav nav-tabs" id="myTab">
                    <li class="active">
                        <a data-toggle="tab" href="#service">
                            <i class="green ace-icon fa fa-home bigger-120"></i>
                            Service
                        </a>
                    </li>

                    <li>
                        <a data-toggle="tab" href="#batal">
                            <i class="green ace-icon fa fa-ban"></i>
                            Batal
                        </a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#outstanding">
                            <i class="green ace-icon fa fa-globe"></i>
                            Outstanding
                        </a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#sa">
                            <i class="green ace-icon fa fa-user bigger-120"></i>
                            By Sa
                        </a>
                    </li>
                    <!--                    <li>
                                            <a data-toggle="tab" href="#mekanik">
                                                <i class="green ace-icon fa fa-user bigger-120"></i>
                                                By Mekanik
                                            </a>
                                        </li>-->
                    <li>
                        <a data-toggle="tab" href="#checker">
                            <i class="green ace-icon fa fa-user bigger-120"></i>
                            By Final Checker
                        </a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#inextern">
                            <i class="green ace-icon fa fa-globe"></i>
                            By Extern / Intern
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div id="service" class="tab-pane fade in active">
                        <div class="row">
                            <div class="col-xs-6 col-sm-2">
                                <div>
                                    <div class="input-group">
                                        <input type="text" name="start_service" value="<?php echo date('d/m/Y') ?>" class="datepicker form-control" style="position: static;"/>
                                        <span class="input-group-addon">
                                            <i class="ace-icon fa fa-calendar"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div id="default-buttons" class="col-xs-6 col-sm-6">
                                <button onclick="$('#type').val('service');return lihat();" class="btn btn-white btn-info btn-bol" type="button"><i class="ace-icon fa fa-eye bigger-110 blue"></i>Lihat</button>
                                <button onclick="$('#type').val('service');return excel();" class="btn btn-white btn-info btn-bol" type="button"><i class="ace-icon fa fa-file-excel-o  bigger-110 blue"/></i>Export</button>
                                <button onclick="$('#type').val('service');return print()" class="btn btn-white btn-info btn-bol" type="button"><i class="ace-icon glyphicon glyphicon-print bigger-110 blue"></i>Print</button>
                            </div>
                        </div>
                    </div>


                    <div id="batal" class="tab-pane fade">
                        <div class="row">
                            <div class="col-xs-6 col-sm-2">
                                <div>
                                    <div class="input-group" style="position: static">
                                        <input type="text" value="<?php echo date('d/m/Y') ?>" name="end_batal" class="datepicker form-control" />
                                        <span class="input-group-addon">
                                            <i class="ace-icon fa fa-calendar"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div id="default-buttons" class="col-xs-6 col-sm-6">
                                <button onclick="$('#type').val('batal');return lihat();" class="btn btn-white btn-info btn-bol" type="button"><i class="ace-icon fa fa-eye bigger-110 blue"></i>Lihat</button>
                                <button onclick="$('#type').val('batal');return excel();" class="btn btn-white btn-info btn-bol" type="button"><i class="ace-icon fa fa-file-excel-o  bigger-110 blue"/></i>Export</button>
                                <button onclick="$('#type').val('batal');return print();" class="btn btn-white btn-info btn-bol" type="button"><i class="ace-icon glyphicon glyphicon-print bigger-110 blue"></i>Print</button>
                            </div>
                        </div>
                    </div>
                    <div id="outstanding" class="tab-pane fade">
                        <div class="row">
                            <div class="col-xs-6 col-sm-2">
                                <div>
                                    <div class="input-group">
                                        <input type="text" name="start_outstanding" value="<?php echo date('d/m/Y') ?>" class="datepicker form-control" style="position: static;"/>
                                        <span class="input-group-addon">
                                            <i class="ace-icon fa fa-calendar"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div id="default-buttons" class="col-xs-6 col-sm-6">
                                <button onclick="$('#type').val('outstanding');return lihat();" class="btn btn-white btn-info btn-bol" type="button"><i class="ace-icon fa fa-eye bigger-110 blue"></i>Lihat</button>
                                <button onclick="$('#type').val('outstanding');return excel();" class="btn btn-white btn-info btn-bol" type="button"><i class="ace-icon fa fa-file-excel-o  bigger-110 blue"/></i>Export</button>
                                <button onclick="$('#type').val('outstanding');return print();" class="btn btn-white btn-info btn-bol" type="button"><i class="ace-icon glyphicon glyphicon-print bigger-110 blue"></i>Print</button>
                            </div>
                        </div>
                    </div>
                    <div id="sa" class="tab-pane fade">
                        <div class="row">
                            <div class="col-xs-6 col-sm-2">
                                <div>
                                    <div class="input-group" style="position: static">
                                        <input type="text" value="<?php echo date('d/m/Y') ?>" name="end_sa" class="datepicker form-control" />
                                        <span class="input-group-addon">
                                            <i class="ace-icon fa fa-calendar"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-2">
                                <div>
                                    <div class="input-group col-sm-10">
                                        <select name="sa" id="sa" required="required" class="form-control col-xs-10 col-sm-10 upper" style="width: 100%">
                                            <option value="all">Semua</option>
                                            <?php
                                            if (count($sa) > 0) {
                                                foreach ($sa as $value) {
                                                    $select = ($value['krid'] == ses_krid) ? 'selected' : '';
                                                    ?>
                                                    <option value="<?php echo $value['krid']; ?>" <?php echo $select; ?>><?php echo $value['kr_nama'] ?></option> 
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div id="default-buttons" class="col-xs-6 col-sm-6">
                                <button onclick="$('#type').val('sa');return lihat();" class="btn btn-white btn-info btn-bol" type="button"><i class="ace-icon fa fa-eye bigger-110 blue"></i>Lihat</button>
                                <button onclick="$('#type').val('sa');return excel();" class="btn btn-white btn-info btn-bol" type="button"><i class="ace-icon fa fa-file-excel-o  bigger-110 blue"/></i>Export</button>
                                <button onclick="$('#type').val('sa');return print();" class="btn btn-white btn-info btn-bol" type="button"><i class="ace-icon glyphicon glyphicon-print bigger-110 blue"></i>Print</button>
                            </div>
                        </div>
                    </div>
                    <div id="checker" class="tab-pane fade">
                        <div class="row">
                            <div class="col-xs-6 col-sm-2">
                                <div>
                                    <div class="input-group" style="position: static">
                                        <input type="text" value="<?php echo date('d/m/Y') ?>" name="end_checker" class="datepicker form-control" />
                                        <span class="input-group-addon">
                                            <i class="ace-icon fa fa-calendar"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-2">
                                <div>
                                    <div class="input-group" style="position: static">
                                        <select name="checker" id="checker" required="required" class="form-control col-xs-10 col-sm-10 upper">
                                            <option value="all">Semua</option>
                                            <?php
                                            if (count($checker) > 0) {
                                                foreach ($checker as $value) {
                                                    $select = ($value['krid'] == ses_krid) ? 'selected' : '';
                                                    ?>
                                                    <option value="<?php echo $value['krid']; ?>" <?php echo $select; ?>><?php echo $value['kr_nama'] ?></option> 
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div id="default-buttons" class="col-xs-6 col-sm-4">
                                <button onclick="$('#type').val('checker');return lihat();" class="btn btn-white btn-info btn-bol" type="button"><i class="ace-icon fa fa-eye bigger-110 blue"></i>Lihat</button>
                                <button onclick="$('#type').val('checker');return excel();" class="btn btn-white btn-info btn-bol" type="button"><i class="ace-icon fa fa-file-excel-o  bigger-110 blue"/></i>Export</button>
                                <button onclick="$('#type').val('checker');return print();" class="btn btn-white btn-info btn-bol" type="button"><i class="ace-icon glyphicon glyphicon-print bigger-110 blue"></i>Print</button>
                            </div>
                        </div>
                    </div>
                    <div id="inextern" class="tab-pane fade">
                        <div class="row">
                            <div class="col-xs-6 col-sm-2">
                                <div>
                                    <div class="input-group" style="position: static">
                                        <input type="text" value="<?php echo date('d/m/Y') ?>" name="end_inextern" class="datepicker form-control" />
                                        <span class="input-group-addon">
                                            <i class="ace-icon fa fa-calendar"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-2">
                                <div>
                                    <div class="input-group col-sm-10">
                                        <select name="inextern" id="inextern" required="required" class="form-control col-xs-10 col-sm-10 upper">
                                            <option value="all">Semua</option>
                                            <option value="1">Intern</option>
                                            <option value="2">Extern</option>
                                            <option value="3">Group</option>
                                            <option value="4">Cabang</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div id="default-buttons" class="col-xs-6 col-sm-4">
                                <button onclick="$('#type').val('inextern');return lihat();" class="btn btn-white btn-info btn-bol" type="button"><i class="ace-icon fa fa-eye bigger-110 blue"></i>Lihat</button>
                                <button onclick="$('#type').val('inextern');return excel();" class="btn btn-white btn-info btn-bol" type="button"><i class="ace-icon fa fa-file-excel-o  bigger-110 blue"/></i>Export</button>
                                <button onclick="$('#type').val('inextern');return print();" class="btn btn-white btn-info btn-bol" type="button"><i class="ace-icon glyphicon glyphicon-print bigger-110 blue"></i>Print</button>
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
<div id="loading" >
    <div class="loading-img"><i class="ace-icon fa fa-spinner fa-spin orange bigger-200"></i></div> <div class="loading-text">Mengambil Data ...</div>
</div>
<script type="text/javascript">
    $( ".datepicker" ).datepicker({
    });
    $('#loading').hide();
    //isolate event
    function submited(actions) {
        $('#form').bind('submit', function() {
            $('#result').html('');
            $('#loading').show();
            $.ajax({
                type: 'POST',
                url: '' + actions + '',
                data: $(this).serialize(),
                success: function(data) {
                    $('#loading').hide();
                    $('#result').html(data);
                    $('#result').fadeIn('fast');
                }
            })
            return false
        });
    }

    function lihat() {
        submited('<?php echo site_url('laporan_service/' . $link . '/lihat'); ?>');
        if ($('#tranid').val() == '') {
            alert('KODE PERKIRAAN TDK BOLEH KOSONG');
        } else {
            $('#form').submit();
        }
        $('#form').unbind('submit');
    }

    function excel() {
        $('#form').removeAttr('action');
        $('#form').attr('action', "<?php echo site_url('laporan_service/' . $link . '/excel'); ?>");
        if ($('#tranid').val() == '') {
            alert('KODE PERKIRAAN TDK BOLEH KOSONG');
        } else {
            $('#form').submit();
        }
    }

    function print() {
        $('#form').removeAttr('action');
        $('#form').attr('action', "<?php echo site_url('laporan_service/' . $link . '/print'); ?>");
        $('#form').attr('target', "_new");

        if ($('#tranid').val() == '') {
            alert('KODE PERKIRAAN TDK BOLEH KOSONG');
        } else {
            $('#form').submit();
        }
    }
    
    var scripts = [null, null]
    $('.page-content-area').ace_ajax('loadScripts', scripts, function() {
        //inline scripts related to this page
    });
</script>