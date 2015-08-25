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
            <a href="<?php echo site_url('administrator/addKaryawan') ?>" class="btn btn-small btn-primary">
                <i class="icon-ok bigger-70"></i>
                Tambah Karyawan</a>
        </p>
    </div>

    <div id="adv-view1" style="background: #ffffff;">
        <div id="tb" style="height: 30px;">  
            <span>Cari :</span> 
            <input id="nama" class="text-input" onkeyup="search()"/>
        </div>
        <table id="tt" class="easyui-datagrid" style="height: 420px;" 
               url="<?php echo site_url("administrator/loadKaryawan"); ?>"
               title="Data Role" rownumbers="true" striped="true" nowrap="true"
               toolbar="#tb" pagination="true" singleSelect="true">
            <thead>
                <tr>
                    <th field="nik" width="70" sortable="true" >NIK</th>
                    <th field="nama" width="150" sortable="true" >Nama Karyawan</th>
                    <th field="alamat" width="200" sortable="true" >Alamat</th>
                    <th field="hp" width="100" sortable="true" >Hp</th>
                    <th field="ktp" width="100" sortable="true" >Nomor KTP</th>
                    <th field="username" width="80" sortable="true" >Username</th>
                    <th field="password" width="100" sortable="true" align="center">Ubah Password</th>
                    <th field="jabatan" width="100" align="center"  sortable="true">Jabatan</th>
                    <th field="role" width="50" align="center"  sortable="true">Role</th>
                    <th field="edit" align="center" width="40" sortable="true" >Edit</th>
                    <th field="hapus" align="center" width="50" sortable="true" >Hapus</th>
                </tr>
            </thead>   
            <tbody></tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
    function search() {
        $('#tt').datagrid('reload', {menu_nama:$("#nama").val()}); 
    }
    function addMenu()
    {
        document.formMenu.reset();
        $('#Action').val('add');
        $("#AccSubFrom").removeAttr('disabled');
        $('#myModal').modal('show');
    }

    function deleteKaryawan(id) {
        if (confirm("Yakin ingin menghapus baris ini ?")) {
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('administrator/hapusKaryawan'); ?>',
                dataType: "json",
                data: {
                    id: id
                },
                success: function(data) {
                    if (data) {
                        window.location.href = '<?php echo site_url('administrator/karyawan') ?>';
                    } else {
                        alert("gagal menghapus");
                    }
                }
            });
        }
    }

    function editMenu(id)
    {
        document.formMenu.reset();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url() ?>administrator/get_menu_by_id",
            dataType: "json",
            async: false,
            data: {
                menuid: id
            },
            success: function(data) {
                if (data) {
                    $('#Action').val('update');
                    $("#menuid").val(id);
                    $("#menu_nama").val(data['menu_nama']);
                    $("#menu_type").val(data['menu_type']);
                    $("#menu_url").val(data['menu_url']);
                    $("#menu_deskripsi").val(data['menu_deskripsi']);
                    $("#menu_icon").val(data['menu_icon']);
                    $('#menu_parentid').val(data['menu_parentid']);
                    if (data['menu_isactive'] == '1') {
                        $("#menu_isactive").attr('checked', true);
                    } else {
                        $('#menu_isactive').attr('checked', false);
                    }
                    $('#myModal').modal('show');
                }
            }
        });
    }

    function saveMenu()
    {
        var action = $('#Action').val();
        if (action == 'add') {
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url() ?>administrator/simpan_menu",
                dataType: "json",
                async: false,
                data: $("#formMenu").serialize(),
                success: function(data) {
                    if (data) {
                        window.location.href = '<?php echo site_url('administrator/menu') ?>';
                    } else {
                        alert("Data gagal disimpan");
                    }
                }
            });
        } else if (action == 'update') {
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url() ?>administrator/update_menu",
                dataType: "json",
                async: false,
                data: $("#formMenu").serialize(),
                success: function(data) {
                    if (data) {
                        window.location.href = '<?php echo site_url('administrator/menu') ?>';
                    } else {
                        alert("Data gagal disimpan");
                    }
                }
            });
        }

    }
</script> 
