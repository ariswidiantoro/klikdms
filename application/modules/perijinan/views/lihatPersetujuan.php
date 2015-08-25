<script src="<?php echo path_js(); ?>jquery-ui.js"></script>
<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
echo $this->session->flashdata('msg');
?> 
<form class="form-horizontal" id="formMenu" method="post" action="<?php echo site_url('perijinan/simpanPersetujuanPerijinan'); ?>" name="formMenu">
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nomor</label>
        <div class="col-sm-8">
            <input type="text" name="pt_nomor" readonly="readonly" value="<?php echo $data['pt_nomor'] ?>" class="ace col-xs-10 col-sm-3" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Tgl</label>
        <div class="col-sm-8">
            <div class="input-group input-group-sm col-sm-2">
                <input type="text" name="pt_tgl" class="datepicker" readonly="readonly" value="<?php echo date('d-m-Y', strtotime($data['pt_tgl'])); ?>" class="form-control" />
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
                    <th style="width:30%" style="text-align: center" >Dokumen Perijinan</th>
                    <th style="width:10%"  style="text-align: center" >Surat&nbsp;Ijin</th>
                    <th style="width:5%"  style="text-align: center" >Gambar</th>
                    <th style="width:10%"  style="text-align: center" >Tgl&nbsp;Terbit</th>
                    <th style="width:10%"  style="text-align: center" >Keterangan</th>
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
                            <input type="hidden" name="ptdid[]" value="<?php echo $value['ptdid']; ?>">
                            <?php echo $value['dok_deskripsi']; ?>
                        </td>
                        <td>
                            <?php echo $value['ptd_nomor'] ?>
                        </td>
                        <td style="text-align: center;">
                            <a href='javascript:;' onclick="lihatGambar('<?php echo $value['ptd_gambar'] ?>')" class='green' title='Edit'><i class='ace-icon fa fa-eye bigger-130'></i></a>
                        </td>
                        <td style="text-align: center;">
                            <?php
                            if ($value['ptd_tgl_terbit'] != '0000-00-00') {
                                echo date('d-m-Y', strtotime($value['ptd_tgl_terbit']));
                            }
                            ?>
                        </td>
                        <td>
                            <?php echo $value['ptd_ketpengajuan']; ?>
                        </td>
                    </tr>
                    <?php
                    $i++;
                }
                ?>

            </tbody>
        </table>
    </div>
</form>

<script type="text/javascript">
    $( ".datepicker" ).datepicker({
    });
    
    function lihatGambar(id) {
        window.scrollTo(0, 0);
        var left = (screen.width / 2) - ((screen.width/1.1) / 2);
        var top = (screen.height / 2) - ((screen.height/1.1) / 2);
        window.open('<?php echo site_url('perijinan/lihatGambar'); ?>'+'/'+id, '_blank',
        'toolbar=0,location=0,menubar=0,width='+screen.width/1.1+', height='+screen.height/1.1+', top=' + top + ', left=' + left);
    }
    
</script>