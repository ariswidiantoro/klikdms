<div id="result"></div>
<form class="form-horizontal" method="post" action="<?php echo base_url() ?>admin/updateGroupCabang" id="formRole" name="formRole">
    <input type="hidden" id="krid" name="krid" value="<?php echo $krid ?>">
    <div  class="form-group" style="margin-left: 0px;">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nama Karyawan</label>
        <div class="col-sm-8">
            <input type="hidden" name="krid" id="krid" value="<?php echo $karyawan['krid']; ?>">
            <input type="text" name="kr_nama" readonly="readonly" value="<?php echo $karyawan['kr_nama'] ?>" id="kr_nama"/>
        </div>
    </div>
    <table style="width: 100%" id="table" class="table table-striped table-bordered table-hover">
        <thead>
            <tr class="timetable">
                <th class="center" style="width: 10%">
                    <label>
                        <input type="checkbox" class="ace" />
                        <span class="lbl"></span>
                    </label>
                </th>
                <th style="width: 20%">Kode Cabang</th>
                <th>Nama Cabang</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($cabang as $value) {
                $checked = (array_key_exists($value['cbid'], $cbid)) ? 'checked' : '';
                ?>
                <tr>
                    <td style="text-align: center">
                        <input type="checkbox" class="ace"  value="1" <?php echo $checked ?> name="check<?php echo $value['cbid'] ?>"><span class="lbl"> </span>
                    </td>
                    <td>
                        <input type="hidden" name="cbid[]" value="<?php echo $value['cbid']; ?>">
                        <?php echo $value['cbid'] ?>
                    </td>
                    <td><?php echo $value['cb_nama'] ?></td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
    <div class="clearfix form-actions">
        <div class="col-md-offset-1 col-md-5">
            <button class="btn btn-info" type="submit">
                <i class="ace-icon fa fa-check bigger-50"></i>
                Simpan
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
    $(function() {
        $('table th input:checkbox').on('click', function() {
            var that = this;
            $(this).closest('table').find('tr > td:first-child input:checkbox')
            .each(function() {
                this.checked = that.checked;
                $(this).closest('tr').toggleClass('selected');
            });
        });
        $('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});
        function tooltip_placement(context, source) {
            var $source = $(source);
            var $parent = $source.closest('table')
            var off1 = $parent.offset();
            var w1 = $parent.width();

            var off2 = $source.offset();
            var w2 = $source.width();

            if (parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2))
                return 'right';
            return 'left';
        }
    });
    $(this).ready(function() {
        $('#formRole').submit(function() {
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                dataType: "json",
                async: false,
                data: $(this)
                .serialize(),
                success: function(data) {
                    window.scrollTo(0, 0);
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