<div id="result"></div>

<form class="form-horizontal" method="post" action="<?php echo base_url() ?>admin/updateRoleDetail" id="formRole" name="formRole">
    <input type="hidden" id="roleid" name="roleid" value="<?php echo $role['roleid'] ?>">
    <div  class="form-group" style="margin-left: 0px;">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nama Role</label>
        <div class="col-sm-8">
            <input type="text" name="role_nama" readonly="readonly" value="<?php echo $role['role_nama'] ?>" id="role_nama"/>
        </div>
    </div>
    <div  class="form-group" style="margin-left: 0px;">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Cari Menu</label>
        <div class="col-sm-8">
            <select name="centang" id="centang" class="form-control col-xs-10 col-sm-1" style="width: 20%">
                <option value="">Semua</option>
                <option value="1">Sudah Dipilih</option>
                <option value="2">Belum Terpilih</option>
            </select>
            <select name="sortby" id="sortby" class="form-control col-xs-10 col-sm-1" style="width: 20%">
                <option value="menu_nama">Nama Menu</option>
                <option value="menu_deskripsi">Deskripsi</option>
            </select>&nbsp;
            <input type="text" class="col-xs-10 col-sm-5" name="cari_menu" id="cari_menu"/>
            <a href="javascript:;" onclick="carimenu()" class="btn btn-sm btn-primary">Cari</a>
        </div>
    </div>

    <div id="roleDetail">
        <table style="width: 100%" id="table" class="table table-striped table-bordered table-hover">
            <thead>
                <tr class="timetable">
                    <th class="center">
                        <label>
                            <input type="checkbox" class="ace" />
                            <span class="lbl"></span>
                        </label>
                    </th>
                    <th>Deskripsi</th>
                    <th>Nama Menu</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($menu as $value) {
                    $checked = (array_key_exists($value['menuid'], $detail)) ? 'checked' : '';
                    ?>
                    <tr>
                        <td style="text-align: center">
                            <input type="checkbox" class="ace"  value="1" <?php echo $checked ?> name="check<?php echo $value['menuid'] ?>"><span class="lbl"> </span>
                        </td>
                        <td>
                            <input type="hidden" name="menuid[]" value="<?php echo $value['menuid']; ?>">
                            <?php echo $value['menu_deskripsi'] ?>
                        </td>
                        <td><?php echo $value['menu_nama'] ?></td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>

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
    
    
    function submited(actions) {
        $('#roleDetail').html('');
        $.ajax({
            type: 'POST',
            url: '' + actions + '',
            data: {
                sortby : $("#sortby").val(),
                cari_menu : $("#cari_menu").val(),
                centang : $("#centang").val(),
                roleid : $("#roleid").val()
            },
            success: function(data) {
                $('#roleDetail').html(data);
                //                $('#roleDetail').fadeIn('fast');
            }
        })
    }

    function carimenu() {
        submited('<?php echo site_url('admin/getMenuDetail'); ?>');
        if ($('#tranid').val() == '') {
            alert('KODE PERKIRAAN TDK BOLEH KOSONG');
        } else {
            $('#form').submit();
        }
        $('#form').unbind('submit');
    }
    
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
</script>