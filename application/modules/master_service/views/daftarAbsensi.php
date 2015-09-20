<div id="result"></div>
<div class="page-header">
    <h1>
        <small>
            Daftar Mekanik yang sudah Absensi Tanggal <?php echo date('d-M-Y') ?>
        </small>
    </h1>
</div><!-- /.page-header -->
<form class="form-horizontal" id="form" method="post" action="<?php echo site_url('master_service/saveAbsensi'); ?>" name="form">
    <table id="simple-table" class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th>Nama Mekanik</th>
                <th  width="10%">Jam IN</th>
                <th  width="10%">Jam Out</th>
                <th  width="10%">Jam Tersedia</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (count($data) > 0) {
                $i = 1;
                foreach ($data as $value) {
                    ?>
                    <tr>
                        <td>
                            <input type="hidden" name="krid[]" value="<?php echo $value['krid']; ?>" class="ace col-xs-10 col-sm-10">
                            <?php echo $value['kr_nama']; ?>
                        </td>
                        <td>
                            <div class="input-group bootstrap-timepicker">
                                <input id="start<?php echo $i ?>"  type="text" name="start[]" value="<?php echo $value['abs_in']; ?>" readonly="readonly" class="form-control" />
                            </div>
                        </td>
                        <td>
                            <div class="input-group bootstrap-timepicker">
                                <input id="end<?php echo $i ?>" type="text" name="end[]" value="<?php echo $value['abs_out']; ?>" readonly="readonly" class="form-control" />
                            </div>
                        </td>
                        <td>
                            <input type="text" readonly="readonly" id="total<?php echo $i ?>" value="<?php echo $value['abs_total']; ?>"  name="total[]" class="ace col-xs-10 col-sm-10">
                        </td>

                        <td>
                            <input type="text" name="keterangan[]" readonly="readonly" value="<?php echo $value['abs_deskripsi']; ?>" class="ace col-xs-10 col-sm-10">
                        </td>
                    </tr>
                    <?php
                }
            } else {
                ?>
                <tr>
                    <td class="left" colspan="6">
                        Data Tidak Ditemukan
                    </td>

                </tr> 
            <?php } ?>
        </tbody>
    </table>
</form>

<script type="text/javascript">
    
    function toSeconds(time) {
        var timer = time;
        // Extract hours, minutes and seconds
        var parts = timer.split(":");
        // compute  and return total seconds
        return parts[0] * 3600 + // an hour has 3600 seconds
        parts[1] * 60 + // a minute has 60 seconds
            +
            "00"; // seconds
    }
    
    function setTotalTime(number)
    {
        var a = "10:22:57"
        var b = "11:30:00"
        //        var difference = Math.abs(toSeconds($("#start"+number).val()) - toSeconds($("#end"+number).val()));
        var difference = Math.abs(toSeconds($("#start"+number).val()) - toSeconds($("#end"+number).val()));

        // format time differnece
        var result = [
            Math.floor((difference / 3600)-1), // an hour has 3600 seconds
            Math.floor(((difference % 3600) / 60)*100/60), // a minute has 60 seconds
        ];
        // 0 padding and concatation
        result = result.map(function(v) {
            return v < 10 ?  v : v;
        }).join('.');
        //        alert(result);
        $("#total"+number).val(result);
    }
    
    var scripts = [null, null]
    $('.page-content-area').ace_ajax('loadScripts', scripts, function() {
        //inline scripts related to this page
        jQuery(function($) {
            $('.timepicker').timepicker({
                minuteStep: 1,
                showMeridian: false
            }).next().on(ace.click_event, function(){
                $(this).prev().focus();
            });
            //initiate dataTables plugin
            //And for the first simple table, which doesn't have TableTools or dataTables
            //select/deselect all rows according to table header checkbox
            var active_class = 'active';
            $('#simple-table > thead > tr > th input[type=checkbox]').eq(0).on('click', function(){
                var th_checked = this.checked;//checkbox inside "TH" table header
			
                $(this).closest('table').find('tbody > tr').each(function(){
                    var row = this;
                    if(th_checked) $(row).addClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', true);
                    else $(row).removeClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', false);
                });
            });
		
            //select/deselect a row when the checkbox is checked/unchecked
            $('#simple-table').on('click', 'td input[type=checkbox]' , function(){
                var $row = $(this).closest('tr');
                if(this.checked) $row.addClass(active_class);
                else $row.removeClass(active_class);
            });
        })
    });
    $(this).ready(function() {
        $('#form').submit(function() {
            //  if (confirm("Yakin data sudah benar ?")) {
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                dataType: "json",
                async: false,
                data: $(this)
                .serialize(),
                success: function(data) {
                    window.scrollTo(0, 0);
                    if (data.result) {
                        document.form.reset();
                    }
                    $("#result").html(data.msg).show().fadeIn("slow");
                }
            })
            return false;
        });

    });
    
</script>
