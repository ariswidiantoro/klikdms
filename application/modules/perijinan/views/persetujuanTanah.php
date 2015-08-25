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
    <div id="adv-view1" style="background: #ffffff;">
        <div id="tb"  style="height: 40px;">  
            <span>Cari :</span> 
            <select onchange="search()" id="status" style="width: 150px;">
                <option value="0">Belum Disetujui</option>
                <option value="1">Sudah Disetujui</option>
            </select>
            <input id="nama" placeholder="Nomor Dokumen" onkeyup="search()"/>
        </div>
        <table id="tt" class="easyui-datagrid" style="height: 450px;" 
               url="<?php echo site_url("perijinan/loadPersetujuan"); ?>"
               title="Data Pengajuan Tanah" rownumbers="true" striped="true" nowrap="true"
               toolbar="#tb" pagination="true" singleSelect="true">
            <thead>
                <tr>
                    <th field="pt_nomor" width="150" sortable="true" >Nomor Dokumen</th>
                    <th field="pt_tgl" width="120" sortable="true" >Tgl Pengajuan</th>
                    <th field="cb_nama" width="160" sortable="true" >Cabang Pemohon</th>
                    <th field="kon_nama" width="160" sortable="true" >Nama Kontraktor</th>
                    <th field="setujui" align="center" width="70" sortable="true" >Setujui</th>
                    <th field="validasi" align="center" width="130" sortable="true" >Edit Persetujuan</th>
                    <th field="print" align="center" width="100" sortable="true" >Cetak Form</th>
                    <th field="status" align="center" width="130" sortable="true" >Status</th>
                </tr>
            </thead>   
        </table>
    </div>
</div>
<script type="text/javascript">
    function search() {
        $('#tt').datagrid('load', {
            //itemid: $('#itemid').val(),
            sortby:$("#nama").val(),
            status: $('#status').val()
        });
        //        $('#tt').datagrid('load', {sortby:$("#nama").val(), status: $('#status').val()}); 
    }

    function setujui(id) {
        if (confirm("Yakin ingin menyetujui pengajuan tanah ini ?")) {
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('perijinan/setujuiPengajuan'); ?>',
                dataType: "json",
                data: {
                    id: id
                },
                success: function(data) {
                    if (data) {
                        window.location.href = '<?php echo site_url('perijinan/persetujuanTanah') ?>';
                    } else {
                        alert("gagal menghapus");
                    }
                }
            });
        }
    }
</script> 
