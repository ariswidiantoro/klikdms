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