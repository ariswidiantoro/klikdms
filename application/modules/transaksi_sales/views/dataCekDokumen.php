<table id="table" class="table table-bordered">
    <thead>
        <tr class="timetable">
            <th>Dokumen</th>
            <th>Nomer Dokumen</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (count($data) > 0) {
            foreach ($data as $value) {
                ?>
                <tr>
                    <td style="text-align: left">
                        <?php echo $value['cek_deskripsi'] ?>
                        <input type="hidden" name="id[]" value="<?php echo $value['cekid']; ?>">
                    </td>
                    <td>
                        <input type="text" name="dokumen[]" value="<?php echo $value['list_nomer'] ?>" maxlength="30" style="width: 100%" class="col-xs-10 col-sm-10 upper">
                    </td>
                </tr>
                <?php
            }
        }
        ?>
    </tbody>
</table>
