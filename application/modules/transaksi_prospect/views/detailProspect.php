<div class="page-header">
    <h1>
        Detail Prospect
    </h1>
</div>   
<div>
    <div id="user-profile" class="user-profile">
        <div class="tabbable">
            <ul class="nav nav-tabs padding-18">
                <li class="active">
                    <a data-toggle="tab" href="#home">
                        <i class="green ace-icon fa fa-user bigger-120"></i>
                        Detail Customer
                    </a>
                </li>

                <li>
                    <a data-toggle="tab" href="#feed">
                        <i class="orange ace-icon fa fa-rss bigger-120"></i>
                        Aktifitas Prospect
                    </a>
                </li>
            </ul>

            <div class="tab-content no-border padding-24">
                <div id="home" class="tab-pane in active">
                    <div class="row">
                        <div class="col-xs-12 col-sm-9">
                            <h4 class="blue">
                                <span class="left"><?php echo $data['pros_nama']; ?></span>

                                <!--<span class="label label-purple arrowed-in-right">
                                    <i class="ace-icon fa fa-circle smaller-80 align-middle"></i>
                                    online
                                </span> -->
                            </h4>

                            <div class="profile-user-info">
                                <div class="profile-info-row">
                                    <div class="profile-info-name align-left"> Jenis Customer </div>

                                    <div class="profile-info-value">
                                        <span><?php echo $data['pros_type']; ?></span>
                                    </div>
                                </div>

                                <div class="profile-info-row">
                                    <div class="profile-info-name align-left"> Alamat </div>

                                    <div class="profile-info-value">
                                        <i class="fa fa-map-marker light-orange bigger-110"></i>
                                        <span><?php echo $data['pros_alamat']; ?></span>
                                        <span><?php echo $data['kota_deskripsi']; ?></span>
                                        <span><?php echo $data['prop_deskripsi']; ?></span>
                                    </div>
                                </div>

                                <div class="profile-info-row">
                                    <div class="profile-info-name align-left"> Area </div>

                                    <div class="profile-info-value">
                                        <span><?php echo $data['area_deskripsi']; ?></span>
                                    </div>
                                </div>
                                <div class="profile-info-row">
                                    <div class="profile-info-name align-left"> No. HP </div>

                                    <div class="profile-info-value">
                                        <span><?php echo $data['pros_hp']; ?></span>
                                    </div>
                                </div>
                                <div class="profile-info-row">
                                    <div class="profile-info-name align-left"> No. Telp </div>

                                    <div class="profile-info-value">
                                        <span><?php echo $data['pros_telpon']; ?></span>
                                    </div>
                                </div>
                                <div class="profile-info-row">
                                    <div class="profile-info-name align-left"> No. Fax </div>

                                    <div class="profile-info-value">
                                        <span><?php echo $data['pros_fax']; ?></span>
                                    </div>
                                </div>
                                <div class="profile-info-row">
                                    <div class="profile-info-name align-left"> No. KTP </div>

                                    <div class="profile-info-value">
                                        <span><?php echo $data['pros_noid']; ?></span>
                                    </div>
                                </div>
                                <div class="profile-info-row">
                                    <div class="profile-info-name align-left"> Last Online </div>

                                    <div class="profile-info-value">
                                        <span>3 hours ago</span>
                                    </div>
                                </div>
                            </div>

                            <div class="hr hr-8 dotted"></div>

                        </div><!-- /.col -->
                    </div><!-- /.row -->

                    <div class="space-20"></div>

                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            <div class="widget-box transparent">
                                <div class="widget-header widget-header-small">
                                    <h4 class="widget-title smaller">
                                        <i class="ace-icon fa fa-check-square-o bigger-110"></i>
                                        Keterangan Prospect
                                    </h4>
                                </div>

                                <div class="widget-body">
                                    <div class="widget-main">
                                        <p>
                                            <?php echo $data['pros_keterangan']; ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div><!-- /#home -->

                <div id="feed" class="tab-pane">
                    <div class="profile-feed row">
                        <div class="col-sm-6">
                            <div class="profile-activity clearfix">
                                <div>
                                    <a class="user" href="#"> Alex Doe </a>
                                    changed his profile photo.
                                    <a href="#">Take a look</a>

                                    <div class="time">
                                        <i class="ace-icon fa fa-clock-o bigger-110"></i>
                                        an hour ago
                                    </div>
                                </div>

                                <div class="tools action-buttons">
                                    <a href="#" class="blue">
                                        <i class="ace-icon fa fa-pencil bigger-125"></i>
                                    </a>

                                    <a href="#" class="red">
                                        <i class="ace-icon fa fa-times bigger-125"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="profile-activity clearfix">
                                <div>

                                    <a class="user" href="#"> Susan Smith </a>

                                    is now friends with Alex Doe.
                                    <div class="time">
                                        <i class="ace-icon fa fa-clock-o bigger-110"></i>
                                        2 hours ago
                                    </div>
                                </div>

                                <div class="tools action-buttons">
                                    <a href="#" class="blue">
                                        <i class="ace-icon fa fa-pencil bigger-125"></i>
                                    </a>

                                    <a href="#" class="red">
                                        <i class="ace-icon fa fa-times bigger-125"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="profile-activity clearfix">
                                <div>
                                    <i class="pull-left thumbicon fa fa-check btn-success no-hover"></i>
                                    <a class="user" href="#"> Alex Doe </a>
                                    joined
                                    <a href="#">Country Music</a>

                                    group.
                                    <div class="time">
                                        <i class="ace-icon fa fa-clock-o bigger-110"></i>
                                        5 hours ago
                                    </div>
                                </div>

                                <div class="tools action-buttons">
                                    <a href="#" class="blue">
                                        <i class="ace-icon fa fa-pencil bigger-125"></i>
                                    </a>

                                    <a href="#" class="red">
                                        <i class="ace-icon fa fa-times bigger-125"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="profile-activity clearfix">
                                <div>
                                    <i class="pull-left thumbicon fa fa-picture-o btn-info no-hover"></i>
                                    <a class="user" href="#"> Alex Doe </a>
                                    uploaded a new photo.
                                    <a href="#">Take a look</a>

                                    <div class="time">
                                        <i class="ace-icon fa fa-clock-o bigger-110"></i>
                                        5 hours ago
                                    </div>
                                </div>

                                <div class="tools action-buttons">
                                    <a href="#" class="blue">
                                        <i class="ace-icon fa fa-pencil bigger-125"></i>
                                    </a>

                                    <a href="#" class="red">
                                        <i class="ace-icon fa fa-times bigger-125"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="profile-activity clearfix">
                                <div>

                                    <a class="user" href="#"> David Palms </a>

                                    left a comment on Alex's wall.
                                    <div class="time">
                                        <i class="ace-icon fa fa-clock-o bigger-110"></i>
                                        8 hours ago
                                    </div>
                                </div>

                                <div class="tools action-buttons">
                                    <a href="#" class="blue">
                                        <i class="ace-icon fa fa-pencil bigger-125"></i>
                                    </a>

                                    <a href="#" class="red">
                                        <i class="ace-icon fa fa-times bigger-125"></i>
                                    </a>
                                </div>
                            </div>
                        </div><!-- /.col -->

                        <div class="col-sm-6">
                            <div class="profile-activity clearfix">
                                <div>
                                    <i class="pull-left thumbicon fa fa-pencil-square-o btn-pink no-hover"></i>
                                    <a class="user" href="#"> Alex Doe </a>
                                    published a new blog post.
                                    <a href="#">Read now</a>

                                    <div class="time">
                                        <i class="ace-icon fa fa-clock-o bigger-110"></i>
                                        11 hours ago
                                    </div>
                                </div>

                                <div class="tools action-buttons">
                                    <a href="#" class="blue">
                                        <i class="ace-icon fa fa-pencil bigger-125"></i>
                                    </a>

                                    <a href="#" class="red">
                                        <i class="ace-icon fa fa-times bigger-125"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="profile-activity clearfix">
                                <div>

                                    <a class="user" href="#"> Alex Doe </a>

                                    upgraded his skills.
                                    <div class="time">
                                        <i class="ace-icon fa fa-clock-o bigger-110"></i>
                                        12 hours ago
                                    </div>
                                </div>

                                <div class="tools action-buttons">
                                    <a href="#" class="blue">
                                        <i class="ace-icon fa fa-pencil bigger-125"></i>
                                    </a>

                                    <a href="#" class="red">
                                        <i class="ace-icon fa fa-times bigger-125"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="profile-activity clearfix">
                                <div>
                                    <i class="pull-left thumbicon fa fa-key btn-info no-hover"></i>
                                    <a class="user" href="#"> Alex Doe </a>

                                    logged in.
                                    <div class="time">
                                        <i class="ace-icon fa fa-clock-o bigger-110"></i>
                                        12 hours ago
                                    </div>
                                </div>

                                <div class="tools action-buttons">
                                    <a href="#" class="blue">
                                        <i class="ace-icon fa fa-pencil bigger-125"></i>
                                    </a>

                                    <a href="#" class="red">
                                        <i class="ace-icon fa fa-times bigger-125"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="profile-activity clearfix">
                                <div>
                                    <i class="pull-left thumbicon fa fa-power-off btn-inverse no-hover"></i>
                                    <a class="user" href="#"> Alex Doe </a>

                                    logged out.
                                    <div class="time">
                                        <i class="ace-icon fa fa-clock-o bigger-110"></i>
                                        16 hours ago
                                    </div>
                                </div>

                                <div class="tools action-buttons">
                                    <a href="#" class="blue">
                                        <i class="ace-icon fa fa-pencil bigger-125"></i>
                                    </a>

                                    <a href="#" class="red">
                                        <i class="ace-icon fa fa-times bigger-125"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="profile-activity clearfix">
                                <div>
                                    <i class="pull-left thumbicon fa fa-key btn-info no-hover"></i>
                                    <a class="user" href="#"> Alex Doe </a>

                                    logged in.
                                    <div class="time">
                                        <i class="ace-icon fa fa-clock-o bigger-110"></i>
                                        16 hours ago
                                    </div>
                                </div>

                                <div class="tools action-buttons">
                                    <a href="#" class="blue">
                                        <i class="ace-icon fa fa-pencil bigger-125"></i>
                                    </a>

                                    <a href="#" class="red">
                                        <i class="ace-icon fa fa-times bigger-125"></i>
                                    </a>
                                </div>
                            </div>
                        </div><!-- /.col -->
                    </div><!-- /.row -->

                    <div class="space-12"></div>

                    <div class="center">
                        <button type="button" class="btn btn-sm btn-primary btn-white btn-round">
                            <i class="ace-icon fa fa-rss bigger-150 middle orange2"></i>
                            <span class="bigger-110">View more activities</span>

                            <i class="icon-on-right ace-icon fa fa-arrow-right"></i>
                        </button>
                    </div>
                </div><!-- /#feed -->
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(this).ready(function() {
        var scripts = [null, null]
        $('.page-content-area').ace_ajax('loadScripts', scripts, function() {
            //inline scripts related to this page
        });
    });
</script>