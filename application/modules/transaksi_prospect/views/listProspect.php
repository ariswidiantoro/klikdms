<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
echo $this->session->flashdata('msg');
?> 
<div id="result"></div>
<div class="row">
    <div class="col-xs-12">
        <p>
            <a href="#modal-table" role="button" data-toggle="modal" class="btn btn-sm btn-primary">
                <i class="ace-icon fa fa-plus"></i>
                Tambah Prospect</a>
        </p>
        <table id="grid-table"></table>
        <div id="pager"></div>
    </div>
</div>
<script type="text/javascript">
    
    var scripts = [null, null]
    $('.page-content-area').ace_ajax('loadScripts', scripts, function() {
        //inline scripts related to this page
    });  
    function search() {
        $('#tt').treegrid('reload', {menu_nama:$("#nama").val()}); 
    }
    function addMenu()
    {
        document.formMenu.reset();
        $('#Action').val('add');
        $("#AccSubFrom").removeAttr('disabled');
        $('#myModal').modal('show');
    }

    function hapusMenu(id) {
        if (confirm("Yakin ingin menghapus baris ini ?")) {
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('admin/hapusMenu'); ?>',
                dataType: "json",
                data: {
                    id: id
                },
                success: function(data) {
                    $("#result").html(data).show().fadeIn("slow");
                }
            });
        }
    }

    $(document).ready(function (){
        jQuery("#grid-table").jqGrid({
            url:'<?php echo site_url('transaksi_prospect/loadDataProspect') ?>',      //another controller function for generating data
            mtype : "post",             //Ajax request type. It also could be GET
            datatype: "json",            //supported formats XML, JSON or Arrray
            colNames:['Kode','Tanggal', 'Nama','Alamat','Status' ,'Detail', 'Edit', 'Hapus'],       //Grid column headings
            colModel:[
                {name:'prosid',index:'prosid', width:80, align:"left"},
                {name:'pros_tgl',index:'pros_tgl', width:80, align:"left"},
                {name:'pros_nama',index:'pros_nama', width:120, align:"left"},
                {name:'pros_alamat',index:'pros_alamat', width:150, align:"left"},
                {name:'pros_status',index:'pros_status', width:80, align:"left"},
                {name:'detail',index:'detail', width:20, align:"center"},
                {name:'edit',index:'edit', width:20, align:"center"},
                {name:'hapus',index:'hapus', width:20, align:"center"},
            ],
            rowNum:10,
            height : 300,
            width: $(".page-content").width(),
            //height: 300,
            rowList:[10,20,30],
            pager: '#pager',
            sortname: 'pros_',
            viewrecords: true,
            rownumbers: true,
            gridview: true,
            caption:"Daftar Menu"
        }).navGrid('#pager',{edit:false,add:false,del:false});
        $(window).on('resize.jqGrid', function () {
            $("#grid-table").jqGrid( 'setGridWidth', $(".page-content").width() );
        })
        
        var parent_column = $("#grid-table").closest('[class*="col-"]');
        $(document).on('settings.ace.jqGrid' , function(ev, event_name, collapsed) {
            if( event_name === 'sidebar_collapsed' || event_name === 'main_container_fixed' ) {
                //setTimeout is for webkit only to give time for DOM changes and then redraw!!!
                setTimeout(function() {
                    $("#grid-table").jqGrid( 'setGridWidth', parent_column.width() );
                }, 0);
            }
        })
    });
    

</script> 
<a href="#modal-table" role="button" class="green" data-toggle="modal"> Table Inside a Modal Box </a>
<div id="modal-form" class="modal" tabindex="-1">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="blue bigger">Please fill the following form fields</h4>
					</div>

					<div class="modal-body">
						<div class="row">
							<div class="col-xs-12 col-sm-5">
								<div class="space"></div>

								<input type="file" />
							</div>

							<div class="col-xs-12 col-sm-7">
								<div class="form-group">
									<label for="form-field-select-3">Location</label>

									<div>
										<select class="chosen-select" data-placeholder="Choose a Country...">
											<option value="">&nbsp;</option>
											<option value="AL">Alabama</option>
											<option value="AK">Alaska</option>
											<option value="AZ">Arizona</option>
											<option value="AR">Arkansas</option>
											<option value="CA">California</option>
											<option value="CO">Colorado</option>
											<option value="CT">Connecticut</option>
											<option value="DE">Delaware</option>
											<option value="FL">Florida</option>
											<option value="GA">Georgia</option>
											<option value="HI">Hawaii</option>
											<option value="ID">Idaho</option>
											<option value="IL">Illinois</option>
											<option value="IN">Indiana</option>
											<option value="IA">Iowa</option>
											<option value="KS">Kansas</option>
											<option value="KY">Kentucky</option>
											<option value="LA">Louisiana</option>
											<option value="ME">Maine</option>
											<option value="MD">Maryland</option>
											<option value="MA">Massachusetts</option>
											<option value="MI">Michigan</option>
											<option value="MN">Minnesota</option>
											<option value="MS">Mississippi</option>
											<option value="MO">Missouri</option>
											<option value="MT">Montana</option>
											<option value="NE">Nebraska</option>
											<option value="NV">Nevada</option>
											<option value="NH">New Hampshire</option>
											<option value="NJ">New Jersey</option>
											<option value="NM">New Mexico</option>
											<option value="NY">New York</option>
											<option value="NC">North Carolina</option>
											<option value="ND">North Dakota</option>
											<option value="OH">Ohio</option>
											<option value="OK">Oklahoma</option>
											<option value="OR">Oregon</option>
											<option value="PA">Pennsylvania</option>
											<option value="RI">Rhode Island</option>
											<option value="SC">South Carolina</option>
											<option value="SD">South Dakota</option>
											<option value="TN">Tennessee</option>
											<option value="TX">Texas</option>
											<option value="UT">Utah</option>
											<option value="VT">Vermont</option>
											<option value="VA">Virginia</option>
											<option value="WA">Washington</option>
											<option value="WV">West Virginia</option>
											<option value="WI">Wisconsin</option>
											<option value="WY">Wyoming</option>
										</select>
									</div>
								</div>

								<div class="space-4"></div>

								<div class="form-group">
									<label for="form-field-username">Username</label>

									<div>
										<input type="text" id="form-field-username" placeholder="Username" value="alexdoe" />
									</div>
								</div>

								<div class="space-4"></div>

								<div class="form-group">
									<label for="form-field-first">Name</label>

									<div>
										<input type="text" id="form-field-first" placeholder="First Name" value="Alex" />
										<input type="text" id="form-field-last" placeholder="Last Name" value="Doe" />
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="modal-footer">
						<button class="btn btn-sm" data-dismiss="modal">
							<i class="ace-icon fa fa-times"></i>
							Cancel
						</button>

						<button class="btn btn-sm btn-primary">
							<i class="ace-icon fa fa-check"></i>
							Save
						</button>
					</div>
				</div>
			</div>
		</div>

