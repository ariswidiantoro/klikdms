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
    <div id="adv-view">
        <p>
            <a href="<?php echo site_url('administrator/addCabang') ?>" data-toggle="modal" class="btn btn-small btn-primary">
                <i class="icon-ok bigger-70"></i>
                Tambah Cabang</a>
        </p>
    </div>

    <div id="adv-view1" style="background: #ffffff;">
        <div id="tb" style="height: 30px;">  
            <span>Cari :</span> 
            <input id="nama" class="text-input" onkeyup="search()"/>
        </div>
        <table id="tt" class="easyui-datagrid" style="height: 450px;" 
               url="<?php echo site_url("administrator/loadCabang"); ?>"
               title="Data Role" rownumbers="true" striped="true" nowrap="true"
               toolbar="#tb" pagination="true" singleSelect="true">
            <thead>
                <tr>
                    <th field="cbid" width="100" sortable="true" >Kode Cabang</th>
                    <th field="cb_nama" width="130" sortable="true" >Nama Cabang</th>
                    <th field="cb_alamat" width="300" sortable="true" >Alamat</th>
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
