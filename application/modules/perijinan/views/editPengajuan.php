<script src="<?php echo path_js(); ?>jquery-ui.js"></script>
<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
echo $this->session->flashdata('msg');
?> 
<form class="form-horizontal" id="formMenu" method="post" action="<?php echo site_url('perijinan/updatePengajuanTanah'); ?>" name="formMenu">
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nomor</label>
        <div class="col-sm-8">
            <input type="text" name="pt_nomor" value="<?php echo $data['pt_nomor'] ?>" class="ace col-xs-10 col-sm-3" />
            <input type="hidden" name="ptid" value="<?php echo $data['ptid'] ?>" class="ace col-xs-10 col-sm-3" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Tgl</label>
        <div class="col-sm-8">
            <div class="input-group input-group-sm col-sm-2">
                <input type="text" name="pt_tgl" class="datepicker" value="<?php echo date('d-m-Y', strtotime($data['pt_tgl'])); ?>" class="form-control" />
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
                    <th style="width:10%"  style="text-align: center">Upload Gambar Scan</th>
                    <th style="width:10%"  style="text-align: center">Tgl Terbit</th>
                    <th style="width:30%"  style="text-align: center">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                foreach ($detail as $value) {
                    ?>
                    <tr class="timetable">
                        <td>
                            <?php echo $i; ?>
                        </td>
                        <td>
                            <input type="hidden" name="ptd_dok_id[]" value="<?php echo $value['ptd_dok_id']; ?>">
                            <?php echo $value['dok_deskripsi']; ?>
                        </td>
                        <td>
                            <input type="text" value="<?php echo $value['ptd_nomor'] ?>" name="ptd_nomor[]"/>

                        </td>
                        <td>
                            <input type="file" name="ptd_gambar<?php echo $value['ptdid']; ?>" />
                        </td>
                        <td>
                            <div class="input-group input-group-sm col-sm-4">
                                <input type="text" value="<?php if($value['ptd_tgl_terbit'] != '0000-00-00'){ echo date('d-m-Y', strtotime($value['ptd_tgl_terbit']));} ?>" name="ptd_tgl_terbit[]"  class="datepicker" class="col-xs-10 col-sm-10" />
                                <span class="input-group-addon">
                                    <i class="ace-icon fa fa-calendar"></i>
                                </span>
                            </div>
                        </td>
                        <td>
                            <input type="text" name="ptd_ketpengajuan[]" value="<?php echo $value['ptd_ketpengajuan'] ?>" style="width: 100%"/>
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
</script>