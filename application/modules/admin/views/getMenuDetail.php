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
        if (count($menu) > 0) {
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
        }
        ?>
    </tbody>
</table>
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
</script>