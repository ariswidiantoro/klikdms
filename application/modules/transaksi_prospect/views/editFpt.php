<div class="page-header">
    <h1>
        <?php echo $title; ?>
    </h1>
</div>      
<div id="result"></div>
<div id="fuelux-wizard-container">
    <div>
        <ul class="steps">
            <li data-step="1" class="active">
                <span class="step">1</span>
                <span class="title">Prospect</span>
            </li>
            <li data-step="2">
                <span class="step">2</span>
                <span class="title">Kendaraan</span>
            </li>
            <li data-step="3">
                <span class="step">3</span>
                <span class="title">Aksesories</span>
            </li>
            <li data-step="4">
                <span class="step">4</span>
                <span class="title">Pembayaran</span>
            </li>
        </ul>
    </div>

    <hr />

    <div class="step-content pos-rel">
        <form class="form-horizontal" id="formAdd" method="post" action="<?php echo site_url('transaksi_prospect/updateFpt'); ?>" name="formAdd">
            <div class="step-pane active" data-step="1">
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Kode Prospect</label>
                    <div class="col-sm-8">
                        <div class="input-group col-sm-8">
                            <input type="hidden" name="fptid" value="<?php echo $data['fptid'] ?>">
                            <input type="text" name="fpt_prosid" id="fpt_prosid" readonly="readonly" required value="<?php echo $data['prosid'] ?>" class="form-control upper" />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Tgl FPT</label>
                    <div class="col-sm-2">
                        <div class="input-group">
                            <input type="text" name="fpt_tgl" readonly="readonly" value="<?php echo date('d-m-Y', strtotime($data['fpt_tgl'])); ?>" class="form-control" />
                            <span class="input-group-addon">
                                <i class="ace-icon fa fa-calendar" style="width: 12px;"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nama Pelanggan</label>
                    <div class="col-sm-8">
                        <div class="input-group col-sm-8">
                            <input type="text" name="fpt_prosnama" id="fpt_prosnama" readonly="readonly" required value="<?php echo $data['pros_nama'] ?>" class="form-control upper" />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Alamat</label>
                    <div class="col-sm-8">
                        <div class="input-group col-sm-8">
                            <textarea name="fpt_alamat" class="form-control upper" readonly="readonly" required rows="4"><?php echo $data['pros_alamat'] ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nomor HP</label>
                    <div class="col-sm-3">
                        <div class="input-group">
                            <input type="text" name="fpt_nohp" id="fpt_nohp" readonly="readonly" value="<?php echo $data['pros_hp'] ?>" class="form-control number upper" />
                            <span class="input-group-addon">
                                <i class="ace-icon fa fa-mobile-phone" style="width: 12px;"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nama Sales</label>
                    <div class="col-sm-8">
                        <div class="input-group col-sm-8">
                            <input type="text" name="fpt_sales" id="fpt_sales" readonly="readonly" required value="<?php echo $data['kr_nama'] ?>" class="form-control upper" />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Penerima Komisi</label>
                    <div class="col-sm-8">
                        <div class="input-group col-sm-8">
                            <input type="text" name="fpt_penerima_komisi" placeholder="NAMA PERANTARA PENERIMA KOMISI, JIKA ADA" value="<?php echo $data['fpt_penerima_komisi'] ?>" id="fpt_penerima_komisi" class="form-control upper" />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Komisi</label>
                    <div class="col-sm-8">
                        <div class="input-group col-sm-8">
                            <input type="text" name="fpt_komisi" id="fpt_komisi" value="<?php echo number_format($data['fpt_komisi']) ?>" style="text-align: right;" class="form-control number upper" />
                        </div> <i>*) DI ISI BESARAN KOMISI</i>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Keterangan</label>
                    <div class="col-sm-8">
                        <div class="input-group col-sm-8">
                            <textarea name="fpt_keterangan" class="form-control upper" rows="4"><?php echo $data['fpt_note'] ?></textarea>
                        </div><i>*) KETERANGAN DIISI JIKA ADA INFORMASI CASHBACK, DISKON ATAU INFORMASI LAINNYA</i>
                    </div>
                </div>
            </div>
            <div class="step-pane" data-step="2">
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Merk Kendaraan</label>
                    <div class="col-sm-6">
                        <select name="fpt_merkid" id="fpt_merkid" required class="form-control input-xlarge" onchange="getModel()" >
                            <option value="">PILIH</option>
                            <?php
                            if (count($merk) > 0) {
                                foreach ($merk as $value) {
                                    $select = ($data['fpt_merkid'] == $value['merkid']) ? 'selected' : '';
                                    ?>
                                    <option value="<?php echo $value['merkid']; ?>" <?php echo $select; ?>><?php echo $value['merk_deskripsi'] ?></option> 
                                    <?php
                                }
                            }
                            ?>
                        </select> 
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Segment Kendaraan</label>
                    <div class="col-sm-8">
                        <select name="fpt_segid" id="fpt_segid" required class="form-control input-xlarge" onchange="getModel()" >
                            <option value="">PILIH</option>
                            <?php
                            if (count($segment) > 0) {
                                foreach ($segment as $value) {
                                    $select = ($data['fpt_segid'] == $value['segid']) ? 'selected' : '';
                                    ?>
                                    <option value="<?php echo $value['segid']; ?>" <?php echo $select; ?>><?php echo $value['seg_nama'] . ' - ' . $value['segid'] ?></option> 
                                    <?php
                                }
                            }
                            ?>
                        </select> 
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Model Kendaraan</label>
                    <div class="col-sm-6">
                        <select name="fpt_modelid" id="fpt_modelid" onchange="getType()" required class="form-control input-xlarge">
                            <?php
                            if (count($model) > 0) {
                                foreach ($model as $value) {
                                    $select = ($data['fpt_modelid'] == $value['modelid']) ? 'selected' : '';
                                    ?>
                                    <option value="<?php echo $value['modelid']; ?>"<?php echo $select; ?>><?php echo $value['model_deskripsi'] ?></option> 
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Tipe Kendaraan</label>
                    <div class="col-sm-6">
                        <select name="fpt_ctyid" id="fpt_ctyid" required class="form-control input-xxlarge">
                            <?php
                            if (count($type) > 0) {
                                foreach ($type as $value) {
                                    $select = ($data['fpt_ctyid'] == $value['ctyid']) ? 'selected' : '';
                                    ?>
                                    <option value="<?php echo $value['ctyid']; ?>"<?php echo $select; ?>><?php echo $value['cty_deskripsi'] ?></option> 
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Warna Kendaraan</label>
                    <div class="col-sm-6">
                        <select name="fpt_warnaid" id="fpt_warnaid" required class="form-control input-large" >
                            <?php
                            if (count($warna) > 0) {
                                foreach ($warna as $value) {
                                    $select = ($data['fpt_warnaid'] == $value['warnaid']) ? 'selected' : '';
                                    ?>
                                    <option value="<?php echo $value['warnaid']; ?>" <?php echo $select; ?>><?php echo $value['warna_deskripsi'] ?></option> 
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Tahun Pembuatan</label>
                    <div class="col-sm-8">
                        <select name="fpt_tahun" id="fpt_tahun" class="form-control input-medium">
                            <?php
                            for ($tahun = date('Y'); $tahun >= date('Y') - 30; $tahun--) {
                                $select = ($tahun == date('Y')) ? 'selected' : '';
                                ?>
                                <option value="<?php echo $tahun; ?>" <?php echo $select ?>><?php echo $tahun ?></option> 
                                <?php
                            }
                            ?>
                        </select> 
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Kondisi</label>
                    <div class="col-sm-8">
                        <select name="fpt_kondisi" id="fpt_kondisi" class="form-control input-medium"  >
                            <option value="BARU">BARU</option>
                            <option value="BEKAS" <?php if ($data['fpt_kondisi'] == 'BEKAS') echo 'selected'; ?>>BEKAS</option>
                        </select> 
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Kuantitas</label>
                    <div class="col-sm-2">
                        <div class="input-group">
                            <input type="text" name="fpt_qty"  value="<?php echo $data['fpt_qty'] ?>" placeholder="Kuantitas" class="form-control number upper" />
                            <span class="input-group-addon">
                                <i class="ace-icon fa fa-car" style="width: 12px;"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Karoseri</label>
                    <div class="col-sm-8">
                        <select name="fpt_karoid" id="fpt_karoid" class="form-control"  style="width: 20%;">
                            <option value="">PILIH</option>
                            <?php
                            if (count($karoseri) > 0) {
                                foreach ($karoseri as $value) {
                                    $select = ($data['fpt_karoid'] == $value['karoid']) ? 'selected' : '';
                                    ?>
                                    <option value="<?php echo $value['karoid']; ?>" <?php echo $select ?>><?php echo $value['karo_nama'] ?></option> 
                                    <?php
                                }
                            }
                            ?>
                        </select> 
                    </div>
                </div>
            </div>

            <div class="step-pane" data-step="3">
                <div id="detailtrans">
                    <div class="table-header">
                        DETAIL AKSESORIES TAMBAHAN
                    </div>
                    <div>
                        <table id="simple-table-aksesories" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 2%">NO</th>
                                    <th style="width: 15%">AKSESORIES</th>
                                    <th style="width: 10%">HARGA</th>
                                    <th style="width: 5%">ADD</th>
                                    <th style="width: 5%">HAPUS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (count($fat) > 0) {
                                    foreach ($fat as $value) {
                                        ?>
                                        <tr  class="item-row">
                                            <td class="dtlaksesories" style="text-align: center; vertical-align: middle;">
                                                1
                                            </td>
                                            <td>
                                                <input type="text" value="<?php echo $value['aks_nama'] ?>" autocomplete="off" onkeyup="acomplete('1')"  placeholder="NAMA AKSESORIES"
                                                       class="upper ace col-xs-10 col-sm-10" style="width:100%;" id="dtrans_aksname1"  name="dtrans_aksname[]" />
                                                <input type="hidden" value="<?php echo $value['aksid'] ?>" id="dtrans_aksid1"  name="dtrans_aksid[]" />
                                            </td>
                                            <td>
                                                <input type="text" style="text-align: right;" id="dtrans_harga1" name="dtrans_harga[]" onchange="$('#'+this.id).val(formatDefault(this.value));totalAccesories();"  value="<?php echo number_format($value['fat_harga'], 2) ?>"   placeholder="HARGA" class="form-control number upper hargaaccs" />
                                            </td>
                                            <td class="center" style="vertical-align: middle;">
                                                <a class="green btnAdd"  onclick="addRow()" href="javascript:;"><i class="ace-icon fa fa-plus bigger-130"></i></a>
                                            </td>
                                            <td  class="center" style="vertical-align: middle;">
                                                <a class="red btnDelete" href="javascript:;"><i class="ace-icon fa fa-trash-o bigger-130"></i></a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <tr  class="item-row">
                                        <td class="dtlaksesories" style="text-align: center; vertical-align: middle;">
                                            1
                                        </td>
                                        <td>
                                            <input type="text"  autocomplete="off" onkeyup="acomplete('1')"  placeholder="NAMA AKSESORIES"
                                                   class="upper ace col-xs-10 col-sm-10" style="width:100%;" id="dtrans_aksname1"  name="dtrans_aksname[]" />
                                            <input type="hidden"  id="dtrans_aksid1"  name="dtrans_aksid[]" />
                                        </td>
                                        <td>
                                            <input type="text" id="dtrans_harga1" style="text-align: right;" name="dtrans_harga[]" onchange="$('#'+this.id).val(formatDefault(this.value));" placeholder="HARGA" class="form-control number upper" />
                                        </td>
                                        <td class="center" style="vertical-align: middle;">
                                            <a class="green btnAdd"  onclick="addRow()" href="javascript:;"><i class="ace-icon fa fa-plus bigger-130"></i></a>
                                        </td>
                                        <td  class="center" style="vertical-align: middle;">
                                            <a class="red btnDelete" href="javascript:;"><i class="ace-icon fa fa-trash-o bigger-130"></i></a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="step-pane" data-step="4">
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Metode Pembayaran</label>
                    <div class="col-sm-8">
                        <select name="fpt_pay_method" id="fpt_pay_method" onChange="javascript:changePayMethod();" class="form-control input-medium" >
                            <option value="1" >TUNAI</option>
                            <option value="2" <?php if ($data['fpt_pay_method'] == '2') echo 'selected'; ?>>LEASING</option>
                        </select> 
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Tipe Penjualan</label>
                    <div class="col-sm-8">
                        <select name="fpt_harga_method" id="fpt_harga_method" class="form-control input-large" >
                            <option value="1">ON THE ROAD</option>
                            <option value="2" <?php if ($data['fpt_harga_method'] == '2') echo 'selected'; ?>>OFF THE ROAD</option>
                        </select> 
                    </div>
                </div>
                <div class="form-group leasing" style="<?php if ($data['fpt_pay_method'] == '2') echo ''; else 'display:none;'; ?>">
                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Leasing</label>
                    <div class="col-sm-8">
                        <select name="fpt_leasid" id="fpt_leasid" class="form-control input-large" >
                            <option value="">PILIH</option>
                            <?php
                            if (count($leasing) > 0) {
                                foreach ($leasing as $value) {
                                    $select = ($data['fpt_leasid'] == $value['leasid']) ? 'selected' : '';
                                    ?>
                                    <option value="<?php echo $value['leasid']; ?>" <?php echo $select ?>><?php echo $value['leas_nama'] ?></option> 
                                    <?php
                                }
                            }
                            ?>
                        </select> 
                    </div>
                </div>
                <div class="form-group leasing" style="<?php if ($data['fpt_pay_method'] == '2') echo ''; else 'display:none;'; ?>">
                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Jangka Waktu</label>
                    <div class="col-sm-3">
                        <div class="input-group col-sm-3">
                            <input type="text" name="fpt_jangka" value="<?php echo $data['fpt_jangka'] ?>" id="fpt_jangka" style="text-align: right;" maxlenght="3"  class="form-control number upper" />
                        </div>
                    </div> <span align="left">BULAN</span>
                </div>

                <div class="hr hr-16 hr-dotted"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Uang Muka</label>
                    <div class="col-sm-8">
                        <div class="input-group col-sm-6">
                            <input type="text" name="fpt_uangmuka" id="fpt_uangmuka" value="<?php echo number_format($data['fpt_uangmuka']) ?>" style="text-align: right;" value="0" onchange="$('#'+this.id).val(formatDefault(this.value));" class="form-control number upper" />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Cashback</label>
                    <div class="col-sm-8">
                        <div class="input-group col-sm-6">
                            <input type="text" name="fpt_cashback" id="fpt_cashback" value="<?php echo number_format($data['fpt_cashback']) ?>" style="text-align: right;" onchange="$('#'+this.id).val(formatDefault(this.value));total()" class="form-control number upper potongan" />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Diskon</label>
                    <div class="col-sm-8">
                        <div class="input-group col-sm-6">
                            <input type="text" name="fpt_diskon" id="fpt_diskon" style="text-align: right;" value="<?php echo number_format($data['fpt_diskon']) ?>" onchange="$('#'+this.id).val(formatDefault(this.value));total()" class="form-control number upper potongan" />
                        </div>
                    </div>
                </div>
                <div class="hr hr-16 hr-dotted"></div>
                <div class="space-2"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Harga Kosong</label>
                    <div class="col-sm-8">
                        <div class="input-group col-sm-6">
                            <input type="text" name="fpt_hargako" id="fpt_hargako" style="text-align: right;" value="<?php echo number_format($data['fpt_hargako']) ?>" onchange="$('#'+this.id).val(formatDefault(this.value));" onkeyup="total()"  class="form-control harga number upper" />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1">BBN</label>
                    <div class="col-sm-8">
                        <div class="input-group col-sm-6">
                            <input type="text" name="fpt_bbn" id="fpt_bbn" style="text-align: right;" value="<?php echo number_format($data['fpt_bbn']) ?>" onchange="$('#'+this.id).val(formatDefault(this.value));" onkeyup="total()"  class="form-control harga number upper" />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Asuransi</label>
                    <div class="col-sm-8">
                        <div class="input-group col-sm-6">
                            <input type="text" name="fpt_asuransi" id="fpt_asuransi" style="text-align: right;" value="<?php echo number_format($data['fpt_asuransi']) ?>" onchange="$('#'+this.id).val(formatDefault(this.value));" onkeyup="total()"  class="form-control harga number upper" />
                        </div>
                    </div>
                </div>
                <!--                <div class="form-group">
                                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Aksesories</label>
                                    <div class="col-sm-8">
                                        <div class="input-group col-sm-6">
                                            <input type="text" name="fpt_accesories" id="fpt_accesories" style="text-align: right;" onchange="$('#'+this.id).val(formatDefault(this.value));" onkeyup="total()" class="form-control harga number upper" />
                                        </div>
                                    </div>
                                </div>-->
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Karoseri</label>
                    <div class="col-sm-8">
                        <div class="input-group col-sm-6">
                            <input type="text" name="fpt_karoseri" id="fpt_karoseri" style="text-align: right;" value="<?php echo number_format($data['fpt_karoseri']) ?>" onchange="$('#'+this.id).val(formatDefault(this.value));" onkeyup="total()"  class="form-control harga number upper" />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Administrasi</label>
                    <div class="col-sm-8">
                        <div class="input-group col-sm-6">
                            <input type="text" name="fpt_administrasi" id="fpt_administrasi" style="text-align: right;" value="<?php echo number_format($data['fpt_administrasi']) ?>" onchange="$('#'+this.id).val(formatDefault(this.value));" onkeyup="total()"  class="form-control harga number upper" />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1"><b>TOTAL</b></label>
                    <div class="col-sm-8">
                        <div class="input-group col-sm-6">
                            <input type="text" name="fpt_total" id="fpt_total" style="text-align: right;" value="<?php echo number_format($data['fpt_total']) ?>" readonly  class="form-control number upper" />
                        </div>
                    </div>
                </div>
            </div>


        </form>
    </div>

    <!-- /section:plugins/fuelux.wizard.container -->
</div>

<hr />
<div class="wizard-actions pull-left">
    <!-- #section:plugins/fuelux.wizard.buttons -->
    <button class="btn btn-prev">
        <i class="ace-icon fa fa-arrow-left"></i>
        Prev
    </button>

    <button class="btn btn-success btn-next" data-last="Finish">
        Next
        <i class="ace-icon fa fa-arrow-right icon-on-right"></i>
    </button>

    <!-- /section:plugins/fuelux.wizard.buttons -->
</div>
<script src="<?php echo path_js(); ?>ace/elements.wizard.js"></script>
<script src="<?php echo path_js(); ?>fuelux/fuelux.wizard.js"></script>
<script src="<?php echo path_js(); ?>jquery.validate.js"></script>
<script type="text/javascript">
    function redirect(data){
        bootbox.confirm("Anda yakin kembali ?", function(result) {
            if(result) {
                window.location.href = "#master_sales/masterLeasing";
            }});
    }
    
    function saveData(){
        var result = false;
        bootbox.confirm("Anda yakin data sudah benar ?", function(result) {
            if(result) {
                $("#formAdd").submit();
            }
        });
        return false;
    }
    
    function getKota(){
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('master_sales/jsonKota') ?>',
            dataType: "json",
            async: false,
            data: {
                propid : $("#propid").val()
            },
            success: function(data) {
                $('#kotaid').html('');
                $('#kotaid').append('<option value="">PILIH</option>');
                $.each(data, function(messageIndex, message) {
                    $('#kotaid').append('<option value="' + message['kotaid'] + '">' + message['kota_deskripsi'] + '</option>');
                });
            }
        })
    }
    
    function getModel(){
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('master_sales/jsonModelKendaraan') ?>',
            dataType: "json",
            async: false,
            data: {
                merkid : $("#fpt_merkid").val(),
                segid : $("#fpt_segid").val()
            },
            success: function(data) {
                $('#fpt_modelid').html('');
                $('#fpt_modelid').append('<option value="">PILIH</option>');
                $.each(data, function(messageIndex, message) {
                    $('#fpt_modelid').append('<option value="' + message['modelid'] + '">' + message['model_deskripsi'] + '</option>');
                });
            }
        })
    }
    
    function getType(){
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('master_sales/jsonTypeKendaraan') ?>',
            dataType: "json",
            async: false,
            data: {
                modelid : $("#fpt_modelid").val()
            },
            success: function(data) {
                getWarnaModel();
                $('#fpt_ctyid').html('');
                $('#fpt_ctyid').append('<option value="">PILIH</option>');
                $.each(data, function(messageIndex, message) {
                    $('#fpt_ctyid').append('<option value="' + message['ctyid'] + '">' + message['cty_deskripsi'] + '</option>');
                });
            }
        })
    }
    
    function getWarnaModel(){
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('master_sales/jsonWarnaModel') ?>',
            dataType: "json",
            async: false,
            data: {
                modelid : $("#fpt_modelid").val()
            },
            success: function(data) {
                $('#fpt_ccoid').html('');
                $('#fpt_ccoid').append('<option value="">PILIH</option>');
                $.each(data, function(messageIndex, message) {
                    $('#fpt_ccoid').append('<option value="' + message['warnaid'] + '">' + message['warna_deskripsi'] + '</option>');
                });
            }
        })
    }
    
    function totalAccesories(){    
        var totalAccs = 0;
        var price;
        $(".hargaaccs").each(function() {
            price = $(this).val().replace(/,/g, "");
            totalAccs += Number(price);
        });
        $("#fpt_accesories").val(formatDefault(totalAccs));
        total();
    }
    
    function total(){    
        var total = 0;
        var price;
        $(".harga").each(function() {
            price = $(this).val().replace(/,/g, "");
            total += Number(price);
        });
        $(".potongan").each(function() {
            price = $(this).val().replace(/,/g, "");
            total -= Number(price);
        });
        $("#fpt_total").val(formatDefault(total));
    }
    
    function Delete() {
        var par = $(this).parent().parent(); //tr
        par.remove();
        //        totalJasa();
    }
    function acomplete(inc){
        $("#dtrans_aksname" + inc).autocomplete({
            minLength: 1,
            source: function(req, add) {
                $.ajax({
                    url: "<?php echo site_url('transaksi_prospect/autoAksesories'); ?>",
                    dataType: 'json',
                    type: 'POST',
                    data: {
                        param : $("#dtrans_aksname" + inc).val(),
                        cbid : '<?php echo ses_cabang; ?>'
                    },
                    success: function(data) {
                        add(data.message);
                    }
                });
            },
            select: function(event, ui) {
                var kode = ui.item.value;
                $("#dtrans_harga"+inc).val(formatDefault(ui.item.trgtwo));
                $("#dtrans_aksid"+inc).val(ui.item.trgone);
                totalAccesories();
                $("input[name^=dtrans_aksname]").each(function() {
                    var k = $(this).val().replace(/,/g, "");
                    if (k == kode) {
                        bootbox.dialog({
                            message: "<span class='bigger-110'>Aksesories Ini Sudah dipilih</span>",
                            buttons: 			
                                {
                                "danger" :
                                    {
                                    "label" : "Error !!",
                                    "className" : "btn-sm btn-danger"
                                }
                            }
                        });
                        kode = '';
                        valid = 1;
                        return false;
                    }
                });
                
            }
        });
    }
    
    function addRow() {
        var inc = $('.dtlaksesories').length+1;
        alert(inc);
        $(".item-row:last").after('<tr  class="item-row">\n\
            <td class="dtlaksesories" style="text-align: center; vertical-align: middle;">\n\
                '+(inc)+'\n\
            </td>\n\
            <td>\n\
                <input type="text"  autocomplete="off" onkeyup="acomplete('+(inc)+')"  placeholder="NAMA AKSESORIES"\n\
                       class="upper ace col-xs-10 col-sm-10" style="width:100%;" id="dtrans_aksname'+(inc)+'"  name="dtrans_aksname[]" />\n\
                <input type="hidden"  id="dtrans_aksid'+inc+'"  name="dtrans_aksid[]" />\n\
            </td>\n\
            <td>\n\
                    <input type="text" style="text-align: right;"  id="dtrans_harga'+(inc)+'" name="dtrans_harga[]" onchange="$(\'#\'+this.id).val(formatDefault(this.value));totalAccesories();"  placeholder="HARGA" class="form-control number upper hargaaccs" />\n\
            </td>\n\
            <td class="center" style="vertical-align: middle;">\n\
                <a class="green btnAdd"  onclick="addRow()" href="javascript:;"><i class="ace-icon fa fa-plus bigger-130"></i></a>\n\
            </td>\n\
            <td  class="center" style="vertical-align: middle;">\n\
                <a class="red btnDelete" href="javascript:;"><i class="ace-icon fa fa-trash-o bigger-130"></i></a>\n\
            </td>\n\
        </tr>');
                    $(".btnDelete").bind("click", Delete);
                    numberOnly();
                }
    
                function changePayMethod(){
                    if($('#fpt_pay_method').val() == '1'){
                        $('.leasing').hide();
                        $('#fpt_harga_method').removeAttr('readonly');
                    }else{
                        $('.leasing').show();
                        $('#fpt_harga_method').val('1');
                        $('#fpt_harga_method').attr('readonly', 'readonly');
                    }
                }
    
				
                $(this).ready(function() {
                    //called when key is pressed in textbox
                    $(".number").keypress(function (e) {
                        //if the letter is not digit then display error and don't type anything
                        if (e.which != 8 && e.which != 47 && e.which != 0 && (e.which < 46 || e.which > 57)){
                            return false;
                        }
                    });
        
                    $( "#datepicker" ).datepicker({
                        showOtherMonths: true,
                        selectOtherMonths: false,
                        isRTL:true,
                        yearRange: "c-30:c+3",
                        changeMonth: true,
                        changeYear: true,
					
                        showButtonPanel: true,
                        beforeShow: function() {
                            //change button colors
                            var datepicker = $(this).datepicker( "widget" );
                            setTimeout(function(){
                                var buttons = datepicker.find('.ui-datepicker-buttonpane')
                                .find('button');
                                buttons.eq(0).addClass('btn btn-xs');
                                buttons.eq(1).addClass('btn btn-xs btn-success');
                                buttons.wrapInner('<span class="bigger-110" />');
                            }, 0);
                        }
                    });
                
                    $('#formAdd').submit(function() {
                        $.ajax({
                            type: 'POST',
                            url: "<?php echo site_url('transaksi_prospect/updateFpt') ?>",
                            dataType: "json",
                            async: false,
                            data: $(this).serialize(),
                            success: function(data) {
                                window.scrollTo(0, 0);
                                if (data.result) {
                                    $('.page-content-area').ace_ajax('loadUrl', "#transaksi_prospect/validasiFpt", false);
                                }
                                $("#result").html(data).show().fadeIn("slow");
                            }
                        })
                        return false;
                    });

                });
    
                var scripts = [null, null]
                $('.page-content-area').ace_ajax('loadScripts', scripts, function() {
                    //inline scripts related to this page
                });
    
                jQuery(function($) {
                    var $validation = false;
                    $('#fuelux-wizard-container')
                    .ace_wizard({
                        //step: 2 //optional argument. wizard will jump to step "2" at first
                        //buttons: '.wizard-actions:eq(0)'
                    })
                    .on('actionclicked.fu.wizard' , function(e, info){
                        if(info.step == 1 && $validation) {
                            if(!$('#formAdd').valid()) e.preventDefault();
                        }
                    })
                    .on('finished.fu.wizard', function(e) {
                        var result = false;
                        bootbox.confirm("Anda yakin data sudah benar ?", function(result) {
                            if(result) {
                                $("#formAdd").submit();
                            }
                        });
                        return false;
                    })
                    .on('stepclick.fu.wizard', function(e){
                        // e.preventDefault();//this will prevent clicking and selecting steps
                    });
			
                    $('#formAdd').validate({
                        errorElement: 'div',
                        errorClass: 'help-block',
                        focusInvalid: false,
                        ignore: "",
                        rules: {
                            pros_type: {
                                required: true
                            },
                            pros_nama: {
                                required: true
                            },
                            pros_alamat: {
                                required: true
                            },
                            pros_hp: {
                                required: true
                            }
                        },
			
                        messages: {
                            pros_type: {
                                required: "Pastikan tipe pelanggan tidak kosong."
                            },
                            pros_nama: {
                                required: "Pastikan nama pelanggan tidak kosong."
                            },
                            pros_alamat: {
                                required: "Pastikan alamat pelanggan tidak kosong."
                            },
                            pros_hp: {
                                required: "Pastikan no. handphone tidak kosong."
                            }
                        },
			
                        highlight: function (e) {
                            $(e).closest('.form-group').removeClass('has-info').addClass('has-error');
                        },
			
                        success: function (e) {
                            $(e).closest('.form-group').removeClass('has-error');//.addClass('has-info');
                            $(e).remove();
                        },
			
                        errorPlacement: function (error, element) {
                            if(element.is('input[type=checkbox]') || element.is('input[type=radio]')) {
                                var controls = element.closest('div[class*="col-"]');
                                if(controls.find(':checkbox,:radio').length > 1) controls.append(error);
                                else error.insertAfter(element.nextAll('.lbl:eq(0)').eq(0));
                            }
                            else if(element.is('.chosen-select')) {
                                error.insertAfter(element.siblings('[class*="chosen-container"]:eq(0)'));
                            }
                            else error.insertAfter(element.parent());
                        },
			
                        submitHandler: function (form) {
                        },
                        invalidHandler: function (form) {
                        }
                    });
                })
</script>
