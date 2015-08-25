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
            <a href="<?php echo site_url('perijinan/addDokumen') ?>" data-toggle="modal" class="btn btn-small btn-primary">
                <i class="menu-icon fa fa-plus"></i>
                Tambah Dokumen</a>
        </p>
    </div>

    <div id="adv-view1" style="background: #ffffff;">
        <div id="tb" style="height: 30px;">  
            <span>Cari :</span> 
            <input id="nama" class="text-input" onkeyup="search()"/>
        </div>
        <table id="tt" class="easyui-datagrid" style="height: 450px;" 
               url="<?php echo site_url("perijinan/loadDokumen"); ?>"
               title="Data Dokumen Perijinan" rownumbers="true" striped="true" nowrap="true"
               toolbar="#tb" pagination="true" singleSelect="true">
            <thead>
                <tr>
                    <!--<th field="dok_id" width="40" sortable="true" >Id</th>-->
                    <th field="dok_deskripsi" width="400" sortable="true" >Deskripsi</th>
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

    function deleteDokumen(id) {
        if (confirm("Yakin ingin menghapus baris ini ?")) {
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('perijinan/hapusDokumen'); ?>',
                dataType: "json",
                data: {
                    id: id
                },
                success: function(data) {
                    if (data) {
                        window.location.href = '<?php echo site_url('perijinan/dokumenPerijinan') ?>';
                    } else {
                        alert("gagal menghapus");
                    }
                }
            });
        }
    }
</script> 
