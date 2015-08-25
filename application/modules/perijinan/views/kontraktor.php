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
            <a href="<?php echo site_url('perijinan/addKontraktor') ?>" class="btn btn-small btn-primary">
                <i class="menu-icon fa fa-plus"></i>
                Tambah Kontraktor</a>
        </p>
    </div>

    <div id="adv-view1" style="background: #ffffff;">
        <div id="tb" style="height: 30px;">  
            <span>Cari :</span> 
            <input id="nama" class="text-input" onkeyup="search()"/>
        </div>
        <table id="tt" class="easyui-datagrid" style="height: 450px;" 
               url="<?php echo site_url("perijinan/loadKontraktor"); ?>"
               title="Data Dokumen Perijinan" rownumbers="true" striped="true" nowrap="true"
               toolbar="#tb" pagination="true" singleSelect="true">
            <thead>
                <tr>
                    <!--<th field="dok_id" width="40" sortable="true" >Id</th>-->
                    <th field="kon_nama" width="120" sortable="true" >Nama Kontraktor</th>
                    <th field="kon_direktur" width="120" sortable="true" >Nama Direktur</th>
                    <th field="kon_alamat" width="250" sortable="true" >Alamat</th>
                    <th field="kon_lokasi" width="100" sortable="true">Lokasi</th>
                    <th field="kon_npwp_gambar" width="50" sortable="true" align="center">Npwp</th>
                    <th field="kon_siup_gambar" width="50" sortable="true"  align="center">Siup</th>
                    <th field="kon_siujk_gambar" width="50" sortable="true"  align="center">Siujk</th>
                    <th field="kon_tdp_gambar" width="50" sortable="true"  align="center">Tdp</th>
                    <th field="kon_domisili_gambar" width="70" sortable="true"  align="center">Domisili</th>
                    <th field="kon_akta_gambar" width="50" sortable="true"  align="center">Akta</th>
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

    function gambarLegalitas(id) {
        window.scrollTo(0, 0);
        var left = (screen.width / 2) - ((screen.width/1.1) / 2);
        var top = (screen.height / 2) - ((screen.height/1.1) / 2);
        window.open('<?php echo site_url('perijinan/lihatGambar'); ?>'+'/'+id, '_blank',
        'toolbar=0,location=0,menubar=0,width='+screen.width/1.1+', height='+screen.height/1.1+', top=' + top + ', left=' + left);
    }
    function deleteKontraktor(id) {
        if (confirm("Yakin ingin menghapus baris ini ?")) {
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('perijinan/hapusKontraktor'); ?>',
                dataType: "json",
                data: {
                    id: id
                },
                success: function(data) {
                    if (data) {
                        window.location.href = '<?php echo site_url('perijinan/kontraktor') ?>';
                    } else {
                        alert("gagal menghapus");
                    }
                }
            });
        }
    }
</script> 
