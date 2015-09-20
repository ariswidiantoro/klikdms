<form class="form-horizontal" method="post" action="<?php echo base_url() ?>administrator/simpanUserRole" id="formRole" name="formRole">
    <input type="hidden" id="user_krid" name="user_krid" value="<?php echo $krid ?>">
    <table style="width: 100%" id="table" class="table table-striped table-bordered table-hover">
        <thead>
            <tr class="timetable">
                <th class="center" style="width: 10%">
                    <label>
                        <input type="checkbox" class="ace" />
                        <span class="lbl"></span>
                    </label>
                </th>
                <th>Nama Role Menu</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($role as $value) {
                $checked = (array_key_exists($value['roleid'], $user)) ? 'checked' : '';
                ?>
                <tr>
                    <td style="text-align: center">
                        <input type="checkbox" class="ace"  value="1" <?php echo $checked ?> name="check<?php echo $value['roleid'] ?>"><span class="lbl"> </span>
                    </td>
                    <td>
                        <input type="hidden" name="roleid[]" value="<?php echo $value['roleid']; ?>">
                        <?php echo $value['role_menu'] ?>
                    </td>
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
    
//    $(this).ready(function() {
//        $('#formRole').submit(function() {
//            $.ajax({
//                type: 'POST',
//                url: $(this).attr('action'),
//                dataType: "json",
//                async: false,
//                data: $(this).serialize(),
//                success: function(data) {
//                    if (data) {
//                        window.location.href = '<?php echo site_url('administrator/role') ?>';
//                    }else{
//                        alert("Data Gagal disimpan");
//                    }
//                }
//            })
//            return false;
//        });
//
//    });
//    
    function carimenu()
    {
        window.location.href = '<?php echo site_url('administrator/editRoleDetail') ?>'+'/'+$('#roleid').val()+'/'+$('#cari_menu').val();
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