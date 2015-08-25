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
            <a href="<?php echo site_url('perijinan/addSurvey') ?>" class="btn btn-small btn-primary">
                <i class="menu-icon fa fa-plus"></i>
                Add Survey</a>
        </p>
    </div>

    <div id="adv-view1" style="background: #ffffff;">
        <div id="tb" style="height: 30px;">  
            <span>Cari :</span> 
            <input id="nama" class="text-input" onkeyup="search()"/>
        </div>
        <table id="tt" class="easyui-datagrid" style="height: 450px;" 
               url="<?php echo site_url("perijinan/loadSurvey"); ?>"
               title="Data Survey Tanah" rownumbers="true" striped="true" nowrap="true"
               toolbar="#tb" pagination="true" singleSelect="true">
            <thead>
                <tr>
                    <!--<th field="dok_id" width="40" sortable="true" >Id</th>-->
                    <th field="kon_nama" width="120" sortable="true" rowspan="2">Cabang</th>
                    <th field="" width="120" sortable="true" colspan="2" align="center">Kontraktor</th>
                    <th field="" width="120" sortable="true" colspan="3" align="center" >Hasil Survey</th>
                    <th field="edit" align="center" width="80" rowspan="2" sortable="true" >Edit</th>
                    <th field="hapus" align="center" width="80" rowspan="2" sortable="true" >Hapus</th>
                </tr>
                <tr>
                    <th field="kon_nama" width="120" sortable="true" >Nama Kontraktor</th>
                    <th field="kon_direktur" width="120" sortable="true" >Nama Direktur</th>
                    <th field="sur_nama_pemilik" width="150" sortable="true" >Nama Pemilik Tanah</th>
                    <th field="sur_luas" width="120" sortable="true" >Luas</th>
                    <th field="sur_alamat" width="150" sortable="true" >Alamat</th>
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
