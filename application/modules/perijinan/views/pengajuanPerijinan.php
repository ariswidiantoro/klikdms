<script src="<?php echo path_js(); ?>jquery-ui.js"></script>
<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
echo $this->session->flashdata('msg');
?> 
<form class="form-horizontal" id="formMenu" method="post" action="<?php echo site_url('perijinan/simpanPengajuanPerijinan'); ?>" name="formMenu"   enctype="multipart/form-data">
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nomor</label>
        <div class="col-sm-8">
            <input type="text" name="pt_nomor" required="required"  placeholder="Nomor Dokumen" class="ace col-xs-10 col-sm-3" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Tgl</label>
        <div class="col-sm-8">
            <div class="input-group input-group-sm col-sm-2">
                <input type="text" name="pt_tgl" class="datepicker" class="form-control" />
                <span class="input-group-addon">
                    <i class="ace-icon fa fa-calendar"></i>
                </span>
            </div>
        </div>
    </div>
    <div class="control-group">
        <table style="width: 100%" class="table table-bordered table-hover">
            <thead  class="table-header">
                <tr>
                    <th style="width:5%" style="text-align: center">No</th>
                    <th style="width:40%" style="text-align: center">Dokumen Perijinan</th>
                    <th style="width:10%"  style="text-align: center">No. Surat Ijin</th>
                    <th style="width:20%"  style="text-align: center">Upload&nbsp;Gambar</th>
                    <th  style="text-align: center">Tgl Terbit</th>
                    <th style="width:30%"  style="text-align: center">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                foreach ($dok as $value) {
                    ?>
                    <tr class="timetable">
                        <td>
                            <?php echo $i; ?>
                        </td>
                        <td>
                            <input type="hidden" name="ptd_dok_id[]" value="<?php echo $value['dok_id']; ?>">
                            <?php echo $value['dok_deskripsi']; ?>
                        </td>
                        <td>
                            <input type="text" name="ptd_nomor[]"/>
                        </td>
                        <td>
                            <input type="file" class="file-input col-xs-10 col-sm-9" name="ptd_gambar<?php echo $value['dok_id']; ?>" />
                        </td>
                        <td>
                            <div class="input-group input-group-sm col-sm-4">
                                <input type="text" name="ptd_tgl_terbit[]"  class="datepicker" class="col-xs-10 col-sm-10" />
                                <span class="input-group-addon">
                                    <i class="ace-icon fa fa-calendar"></i>
                                </span>
                            </div>
                        </td>
                        <td>
                            <input type="text" name="ptd_ketpengajuan[]" style="width: 100%"/>
                        </td>
                    </tr>
                    <?php
                    $i++;
                }
                ?>

            </tbody>
        </table>
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
    $( ".datepicker" ).datepicker({
    });
    
    jQuery(function($) {
        $('.file-input').ace_file_input({
            no_file:'Upload Scan',
            btn_choose:'Choose',
            btn_change:'Change',
            droppable:false,
            onchange:null,
            thumbnail:false //| true | large
            //whitelist:'gif|png|jpg|jpeg'
            //blacklist:'exe|php'
            //onchange:''
            //
        });
        //pre-show a file name, for example a previously selected file
        //$('#id-input-file-1').ace_file_input('show_file_list', ['myfile.txt'])
			
    });
</script>