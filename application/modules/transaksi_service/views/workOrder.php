<div id="result"></div>
<style type="text/css">
    input:required {
        box-shadow: 4px 4px 20px rgba(200, 0, 0, 0.85);

    }
    .ui-autocomplete {
        max-height: 200px;
        overflow-y: auto;
        overflow-x: hidden;
        padding-right: 20px;
    }
    * html .ui-autocomplete {
        height: 200px;
    }
    input:focus {
        background-color: yellow;
    } 
</style>
<form class="form-horizontal" id="form" method="post" name="form">
    <table id="simple-table-so" class="table table-striped table-bordered table-hover">


        <?php
        foreach ($jenis as $value) {
            ?>
            <tr>
                <td>
                    <a href="#transaksi_service/serviceOrder?jenis=<?php echo $value['woj_kode'] . '&type=' . $value['woj_type'] ?>"  class="btn btn-success ace col-xs-10 col-sm-3"><?php echo "[" . $value['woj_kode'] . "]  " . $value['woj_deskripsi'] ?></a>
                </td>
            </tr>
            <?php
        }
        ?>

    </table>
</form>
<script type="text/javascript">
    $("#waiting").hide();
                           
    
    var scripts = [null, null]
    $('.page-content-area').ace_ajax('loadScripts', scripts, function() {
        //inline scripts related to this page
    });
</script> 