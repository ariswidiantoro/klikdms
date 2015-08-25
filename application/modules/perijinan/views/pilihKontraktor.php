<!DOCTYPE html>

<?php
echo $this->session->flashdata('msg');
?> 
<style type="text/css">
    #fm{
        margin:0;
        padding:10px 30px;
    }
    .ftitle{
        font-size:14px;
        font-weight:bold;
        padding:5px 0;
        margin-bottom:10px;
        border-bottom:1px solid #ccc;
    }
    .fitem{
        margin-bottom:5px;
    }
    .fitem label{
        display:inline-block;
        width:80px;
    }
    .fitem input{
        width:160px;
    }
    /*    #myModal .modal-dialog
        {
            width: 900px;;
        }*/
</style>
<div style="height: 100%;">
    <form class="form-horizontal" id="formMenu" method="post" action="<?php echo site_url('perijinan/simpanPilihKontraktor'); ?>" name="formRole">
        <div class="form-group">
            <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Cabang</label>
            <div class="col-sm-8">
                <select name="cabang"  required="required" class="col-xs-10 col-sm-5">
                    <option value="">Pilih</option>
                    <?php
                    if (count($cabang) > 0) {
                        foreach ($cabang as $value) {
                            $select = (ses_cabang == $value['cbid']) ? 'selected' : '';
                            ?>
                            <option value="<?php echo $value['cbid'] ?>" <?php echo $select; ?>><?php echo $value['cb_nama'] ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Kontraktor</label>
            <div class="col-sm-8">
                <select name="kontraktor"  required="required" class="col-xs-10 col-sm-5">
                    <option value="">Pilih</option>
                    <?php
                    if (count($kontraktor) > 0) {
                        foreach ($kontraktor as $value) {
                            $konid = empty($pekerja['konid']) ? '' : $pekerja['konid'];
                            $select = ($konid == $value['konid']) ? 'selected' : '';
                            ?>
                            <option value="<?php echo $value['konid'] ?>" <?php echo $select; ?>><?php echo $value['kon_nama'] ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
            </div>
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

    <div id="adv-view1" style="background: #ffffff;">
        <div id="tb" style="height: 30px;">  
            <span>Cari :</span> 
            <input id="nama" class="text-input" onkeyup="search()"/>
        </div>
        <table id="tt" class="easyui-datagrid" style="height: 450px;" 
               url="<?php echo site_url("perijinan/loadPilihKontraktor"); ?>"
               title="Data Role" rownumbers="true" striped="true" nowrap="true"
               toolbar="#tb" pagination="true" singleSelect="true">
            <thead>
                <tr>
                    <th field="cb_nama" width="100" sortable="true" >Nama Cabang</th>
                    <th field="kon_nama" width="130" sortable="true" >Nama Kontraktor</th>
                    <th field="kon_lokasi" width="130" sortable="true" >Lokasi Kontraktor</th>
                    <th field="kon_alamat" width="300" sortable="true" >Alamat Kontraktor</th>
                    <th field="edit" align="center" width="80" sortable="true" >Edit</th>
                    <th field="hapus" align="center" width="80" sortable="true" >Hapus</th>
                </tr>
            </thead>   
        </table>
    </div>
</div>
<script type="text/javascript">
    function search() {
        $('#tt').datagrid('reload', {sortby:$("#nama").val()}); 
    }
    function addMenu()
    {
        document.formMenu.reset();
        $('#Action').val('add');
        $("#AccSubFrom").removeAttr('disabled');
        $('#myModal').modal('show');
    }

    function deleteCabang(id) {
        if (confirm("Yakin ingin menghapus baris ini ?")) {
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('administrator/hapusCabang'); ?>',
                dataType: "json",
                data: {
                    id: id
                },
                success: function(data) {
                    if (data) {
                        window.location.href = '<?php echo site_url('administrator/cabang') ?>';
                    } else {
                        alert("gagal menghapus");
                    }
                }
            });
        }
    }
</script> 
