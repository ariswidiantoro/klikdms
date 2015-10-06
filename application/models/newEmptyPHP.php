<div id="detailtrans">
    <div class="table-header">
        DETAIL TRANSAKSI
    </div>
    <div>
        <table id="simple-table-jasa" class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th style="width: 2%">NO</th>
                    <th style="width: 10%">MERK</th>
                    <th style="width: 20%">MODEL</th>
                    <th style="width: 10%">TYPE</th>
                    <th style="width: 10%">QTY</th>
                    <th style="width: 5%">ADD</th>
                    <th style="width: 5%">HAPUS</th>
                </tr>
            </thead>
            <tbody>
                <tr  class="item-row">
                    <td class="dtlkendaraan" style="text-align: center;">
                        1
                    </td>
                    <td>
                        <select class="form-control input-small" style="width:100%;text-align: left" onchange="getModel('modelid1')"  name="merkid[]" id="merkid1" >
                            <option value="">PILIH</option>
                            <?php
                            if (count($merk) > 0) {
                                foreach ($merk as $value) {
                                    ?>
                                    <option value="<?php echo $value['merkid']; ?>"><?php echo $value['merk_deskripsi'] ?></option> 
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </td>
                    <td>
                        <select name="modelid[]" id="modelid1" onchange="getType('')" class="form-control input-small" style="width: 100%;">
                            <option value="">PILIH</option>
                        </select>
                    </td>
                    <td>
                        <select name="ctyid[]" id="ctyid1" class="form-control input-xxlarge" style="width: 100%;">
                            <option value="">PILIH</option>
                        </select>
                    </td>
                    <td><div class="input-group">
                            <input type="text" name="pros_kuantitas"  placeholder="Kuantitas" class="form-control number upper" />
                            <span class="input-group-addon">
                                <i class="ace-icon fa fa-car" style="width: 12px;"></i>
                            </span>
                        </div>
                    </td>
                    <td class="center">
                        <a class="green btnAdd"  onclick="addRow()" href="javascript:;"><i class="ace-icon fa fa-search-plus bigger-130"></i></a>
                    </td>
                    <td  class="center">
                        <a class="red btnDelete" href="javascript:;"><i class="ace-icon fa fa-trash-o bigger-130"></i></a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>


<script>
    function Delete() {
        var par = $(this).parent().parent(); //tr
        par.remove();
        totalLc();
    }
    
    function addRow() {
        var inc = $('.dtlkendaraan').length+1;
        $(".item-row:last").after(
        '<tr class="item-row">\n\
                    <td class="dtlkendaraan center">' + inc + '<input type="hidden" name="no[]" id="no'+ inc +'"  /></td>\n\
                         <td>\n\
                             <select class="form-control input-small" style="width:100%;text-align: left" onchange="getModel(modelid'+( inc )+')"  name="merkid[]" id="merkid1" >\n\
                            <option value="">PILIH</option><?php
                            if (count($merk) > 0) {
                                foreach ($merk as $value) {
                                    echo "<option value='" . $value['merkid'] . "' > " . $value['merk_deskripsi'] . "</option>";
                                }
                            }
                            ?> \n\
                        </select> \n\
                         </td>\n\
                         <td>\n\
                             <select class="form-control input-small" style="width:100%;text-align: left" onchange="getType(ctyid'+( inc )+')"  name="modelid[]" id="modelid'+( inc )+'" >\n\
                            <option value="">PILIH</option>\n\
                        </select> \n\
                         </td>\n\
                        <td>\n\
                             <select class="form-control input-xxlarge" style="width:100%;text-align: left"  name="ctyid[]" id="ctyid'+( inc )+'" >\n\
                            <option value="">PILIH</option>\n\
                        </select> \n\
                         </td>\n\
                         <td><div class="input-group">\n\
                            <input type="text" name="pros_kuantitas"  placeholder="Kuantitas" class="form-control number upper" />\n\
                            <span class="input-group-addon">\n\
                                <i class="ace-icon fa fa-car" style="width: 12px;"></i>\n\
                            </span>\n\
                        </div>\n\
                         <td  class="center">\n\
                             <a class="green btnAdd"  onclick="addRow()" href="javascript:;"><i class="ace-icon fa fa-search-plus bigger-130"></i></a>\n\
                         </td>\n\
                         <td style="text-align: center">\n\
                             <a class="red btnDelete" href="javascript:;"><i class="ace-icon fa fa-trash-o bigger-130"></i></a>\n\
                         </td>\n\
                       </tr>\n\
                    </tr>');
                                 $(".btnDelete").bind("click", Delete);
        }
</script>