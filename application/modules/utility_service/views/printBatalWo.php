<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?>
<div style="margin: 100px auto; width: 400px; text-align: center; font-family: tahoma; font-size: 12px; letter-spacing: 1px;">
    Tanggal batal : <?php echo Date('d-M-Y H:i') ?>
    <h3 style="border: 1px dotted #000; text-align: center; padding: 10px; font-size: 20px;">BATAL <?php echo $data['wo_nomer'] ?></h3>
    <h3 style="border: 1px dotted #000; text-align: left; padding: 10px; font-size: 13px;">Alasan : <?php echo $data['btl_alasan'] ?></h3>
</div>
<script>
    window.print();
    self.close();
</script>
