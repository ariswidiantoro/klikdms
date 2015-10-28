<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta charset="utf-8" />
        <title>----</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

        <!--[if !IE]> -->
        <link rel="stylesheet" href="<?php echo path_css(); ?>pace.css" />

        <script data-pace-options='{ "ajax": true, "document": true, "eventLag": false, "elements": false }' src="<?php echo path_js(); ?>pace.js"></script>

        <!-- <![endif]-->

        <!-- bootstrap & fontawesome -->
        <link rel="stylesheet" href="<?php echo path_css(); ?>bootstrap.css" />
        <link rel="stylesheet" href="<?php echo path_css(); ?>font-awesome.css" />
        <link rel="stylesheet"  href="<?php echo path_css(); ?>report.css"/>


      


        <link rel="stylesheet" href="<?php echo path_css(); ?>jquery-ui.css" />
        <link rel="stylesheet" href="<?php echo path_css(); ?>datepicker.css" />
        <link rel="stylesheet" href="<?php echo path_css(); ?>ui.jqgrid.css" />


        <!-- text fonts -->
        <link rel="stylesheet" href="<?php echo path_css(); ?>ace-fonts.css" />
        <link rel="stylesheet" href="<?php echo path_css(); ?>bootstrap-timepicker.css" />
        <link rel="stylesheet" href="<?php echo path_css(); ?>bootstrap-datetimepicker.css" />

        <!-- ace styles -->
        <link rel="stylesheet" href="<?php echo path_css(); ?>ace.css" class="ace-main-stylesheet" id="main-ace-style" />

        <!--[if lte IE 9]>
                <link rel="stylesheet" href="<?php echo path_css(); ?>ace-part2.css" class="ace-main-stylesheet" />
        <![endif]-->

        <!--[if lte IE 9]>
          <link rel="stylesheet" href="<?php echo path_css(); ?>ace-ie.css" />
        <![endif]-->

        <!-- ace settings handler -->
        <script src="<?php echo path_js(); ?>ace-extra.js"></script>

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

        <!--[if lte IE 8]>
        <script src="<?php echo path_js(); ?>html5shiv.js"></script>
        <script src="../../assets/js/respond.js"></script>
        <![endif]-->
    </head>

    <body class="no-skin">
        <!-- #section:basics/navbar.layout -->
        <div id="navbar" class="navbar navbar-default">
            <script type="text/javascript">
                try{ace.settings.check('navbar' , 'fixed')}catch(e){}
            </script>

            <div class="navbar-container" id="navbar-container">
                <!-- #section:basics/sidebar.mobile.toggle -->
                <button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
                    <span class="sr-only">Toggle sidebar</span>

                    <span class="icon-bar"></span>

                    <span class="icon-bar"></span>

                    <span class="icon-bar"></span>
                </button>

                <!-- #section:basics/navbar.dropdown -->
                <div class="navbar-buttons navbar-header pull-left" role="navigation">
                    <ul class="nav ace-nav">
                        <?php
                        $this->load->model('model_admin');
                        $header = $this->model_admin->getMenuModule();
                        if (count($header) > 0) {
                            foreach ($header as $value) {
                                ?>
                                <li class="transparent">
                                    <a href="<?php echo site_url($value['menu_url']); ?>"><i class="<?php echo $value['menu_icon'] ?>"></i>&nbsp;<?php echo $value['menu_nama'] ?></a>
                                </li>
                                <?php
                            }
                        }
                        ?>
                    </ul>
                </div>
                <div class="navbar-buttons navbar-header pull-right" role="navigation">
                    <ul class="nav ace-nav">
                        <li class="light-blue">
                            <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                                <span class="user-info">
                                    <small>Welcome,</small>
                                    <?php echo ses_username; ?>
                                </span>

                                <i class="ace-icon fa fa-caret-down"></i>
                            </a>

                            <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                                <li>
                                    <a href="#">
                                        <i class="ace-icon fa fa-cog"></i>
                                        Settings
                                    </a>
                                </li>

                                <li>
                                    <a href="#admin/profile" data-url="admin/">
                                        <i class="ace-icon fa fa-user"></i>
                                        Profile
                                    </a>
                                </li>

                                <li class="divider"></li>

                                <li>
                                    <a href="<?php echo site_url('welcome/logout') ?>">
                                        <i class="ace-icon fa fa-power-off"></i>
                                        Logout
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>

                <!-- /section:basics/navbar.dropdown -->
            </div><!-- /.navbar-container -->
        </div>

        <!-- /section:basics/navbar.layout -->
        <div class="main-container" id="main-container">
            <script type="text/javascript">
                try{ace.settings.check('main-container' , 'fixed')}catch(e){}
            </script>

            <!-- #section:basics/sidebar -->
            <div id="sidebar" class="sidebar                  responsive">
                <script type="text/javascript">
                    try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
                </script>

                <div class="sidebar-shortcuts" id="sidebar-shortcuts">
                    <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
                        <button class="btn btn-success">
                            <i class="ace-icon fa fa-signal"></i>
                        </button>

                        <button class="btn btn-info">
                            <i class="ace-icon fa fa-pencil"></i>
                        </button>

                        <!-- #section:basics/sidebar.layout.shortcuts -->
                        <button class="btn btn-warning">
                            <i class="ace-icon fa fa-users"></i>
                        </button>

                        <button class="btn btn-danger">
                            <i class="ace-icon fa fa-cogs"></i>
                        </button>

                        <!-- /section:basics/sidebar.layout.shortcuts -->
                    </div>

                    <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
                        <span class="btn btn-success"></span>

                        <span class="btn btn-info"></span>

                        <span class="btn btn-warning"></span>

                        <span class="btn btn-danger"></span>
                    </div>
                </div><!-- /.sidebar-shortcuts -->
                <script type="text/javascript">
            
                    window.jQuery || document.write("<script src='<?php echo path_js(); ?>jquery.js'>"+"<"+"/script>");
                </script>
                <!--<script src="<?php echo path_js(); ?>jquery.sun.js"></script>-->
                <?php $this->load->view('attribut/menu') ?>


                <!-- #section:basics/sidebar.layout.minimize -->
                <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
                    <i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
                </div>

                <!-- /section:basics/sidebar.layout.minimize -->
                <script type="text/javascript">
                    try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
                </script>
            </div>

            <!-- /section:basics/sidebar -->
            <div class="main-content">
                <div class="main-content-inner">
                    <!-- #section:basics/content.breadcrumbs -->
                    <div class="breadcrumbs" id="breadcrumbs">
                        <script type="text/javascript">
                            try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
                        </script>

                        <ul class="breadcrumb">
                            <!--                            <li>
                                                            <i class="ace-icon fa fa-home home-icon"></i>
                                                            <a href="#">Home</a>
                                                        </li>-->
                        </ul><!-- /.breadcrumb -->

                        <!-- #section:basics/content.searchbox -->
                        <div class="nav-search" id="nav-search">
                            <!--                            <form class="form-search">
                                                            <span class="input-icon">
                                                                <input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
                                                                <i class="ace-icon fa fa-search nav-search-icon"></i>
                                                            </span>
                                                        </form>-->
                        </div><!-- /.nav-search -->

                        <!-- /section:basics/content.searchbox -->
                    </div>

                    <!-- /section:basics/content.breadcrumbs -->
                    <div class="page-content">
                        <!-- #section:settings.box -->
                        <div class="ace-settings-container" id="ace-settings-container">
                            <div class="btn btn-app btn-xs btn-warning ace-settings-btn" id="ace-settings-btn">
                                <i class="ace-icon fa fa-cog bigger-130"></i>
                            </div>

                            <div class="ace-settings-box clearfix" id="ace-settings-box">
                                <div class="pull-left width-50">
                                    <!-- #section:settings.skins -->
                                    <div class="ace-settings-item">
                                        <div class="pull-left">
                                            <select id="skin-colorpicker" class="hide">
                                                <option data-skin="no-skin" value="#438EB9">#438EB9</option>
                                                <option data-skin="skin-1" value="#222A2D">#222A2D</option>
                                                <option data-skin="skin-2" value="#C6487E">#C6487E</option>
                                                <option data-skin="skin-3" value="#D0D0D0">#D0D0D0</option>
                                            </select>
                                        </div>
                                        <span>&nbsp; Choose Skin</span>
                                    </div>

                                    <!-- /section:settings.skins -->

                                    <!-- #section:settings.navbar -->
                                    <div class="ace-settings-item">
                                        <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-navbar" />
                                        <label class="lbl" for="ace-settings-navbar"> Fixed Navbar</label>
                                    </div>

                                    <!-- /section:settings.navbar -->

                                    <!-- #section:settings.sidebar -->
                                    <div class="ace-settings-item">
                                        <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-sidebar" />
                                        <label class="lbl" for="ace-settings-sidebar"> Fixed Sidebar</label>
                                    </div>

                                    <!-- /section:settings.sidebar -->

                                    <!-- #section:settings.breadcrumbs -->
                                    <div class="ace-settings-item">
                                        <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-breadcrumbs" />
                                        <label class="lbl" for="ace-settings-breadcrumbs"> Fixed Breadcrumbs</label>
                                    </div>

                                    <!-- /section:settings.breadcrumbs -->

                                    <!-- #section:settings.rtl -->
                                    <div class="ace-settings-item">
                                        <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-rtl" />
                                        <label class="lbl" for="ace-settings-rtl"> Right To Left (rtl)</label>
                                    </div>

                                    <!-- /section:settings.rtl -->

                                    <!-- #section:settings.container -->
                                    <div class="ace-settings-item">
                                        <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-add-container" />
                                        <label class="lbl" for="ace-settings-add-container">
                                            Inside
                                            <b>.container</b>
                                        </label>
                                    </div>

                                    <!-- /section:settings.container -->
                                </div><!-- /.pull-left -->

                                <div class="pull-left width-50">
                                    <!-- #section:basics/sidebar.options -->
                                    <div class="ace-settings-item">
                                        <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-hover" />
                                        <label class="lbl" for="ace-settings-hover"> Submenu on Hover</label>
                                    </div>

                                    <div class="ace-settings-item">
                                        <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-compact" />
                                        <label class="lbl" for="ace-settings-compact"> Compact Sidebar</label>
                                    </div>

                                    <div class="ace-settings-item">
                                        <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-highlight" />
                                        <label class="lbl" for="ace-settings-highlight"> Alt. Active Item</label>
                                    </div>

                                    <!-- /section:basics/sidebar.options -->
                                </div><!-- /.pull-left -->
                            </div><!-- /.ace-settings-box -->
                        </div><!-- /.ace-settings-container -->

                        <!-- /section:settings.box -->
                        <div class="page-content-area" data-ajax-content="true">

                            <?php
                            if (!empty($content)) {
                                $this->load->view($content);
                            }
                            ?>
                            <!-- ajax content goes here -->
                        </div>
                    </div><!-- /.page-content -->
                </div>
            </div><!-- /.main-content -->

            <div class="footer">
                <div class="footer-inner">
                    <!-- #section:basics/footer -->
                    <div class="footer-content">
                        <span class="bigger-120">
                            <span class="blue bolder">Klik DMS</span>
                            Application &copy; 2015-2016
                        </span>

                        &nbsp; &nbsp;
                        <span class="action-buttons">
                            <a href="#">
                                <i class="ace-icon fa fa-twitter-square light-blue bigger-150"></i>
                            </a>

                            <a href="#">
                                <i class="ace-icon fa fa-facebook-square text-primary bigger-150"></i>
                            </a>

                            <a href="#">
                                <i class="ace-icon fa fa-rss-square orange bigger-150"></i>
                            </a>
                        </span>
                    </div>

                    <!-- /section:basics/footer -->
                </div>
            </div>

            <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
                <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
            </a>
        </div><!-- /.main-container -->

        <!-- basic scripts -->

        <!--[if !IE]> -->



        <!-- <![endif]-->

        <!--[if IE]>
<script type="text/javascript">
window.jQuery || document.write("<script src='../../assets/js/jquery1x.js'>"+"<"+"/script>");
</script>
<![endif]-->
        <script type="text/javascript">
            if('ontouchstart' in document.documentElement) document.write("<script src='<?php echo path_js(); ?>jquery.mobile.custom.js'>"+"<"+"/script>");
        </script>
        <script src="<?php echo path_js(); ?>bootstrap.js"></script>
        <script src="<?php echo path_js(); ?>jquery-ui.js"></script>
        <script src="<?php echo path_js(); ?>validasi.js"></script>
        <script src="<?php echo path_js(); ?>bootbox.js"></script>
        <script src="<?php echo path_js(); ?>jquery.validate.js"></script>


        <script src="<?php echo path_js(); ?>dataTables/jquery.dataTables.js"></script>
        <script src="<?php echo path_js(); ?>dataTables/jquery.dataTables.bootstrap.js"></script>
        <script src="<?php echo path_js(); ?>dataTables/extensions/TableTools/js/dataTables.tableTools.js"></script>
        <script src="<?php echo path_js(); ?>dataTables/extensions/ColVis/js/dataTables.colVis.js"></script>
        <script src="<?php echo path_js(); ?>date-time/moment.js"></script>
        <script src="<?php echo path_js(); ?>date-time/bootstrap-timepicker.js"></script>
        <script src="<?php echo path_js(); ?>date-time/bootstrap-datetimepicker.js"></script>


        <!-- ace scripts -->
        <script src="<?php echo path_js(); ?>ace/elements.scroller.js"></script>
        <script src="<?php echo path_js(); ?>ace/elements.colorpicker.js"></script>
        <script src="<?php echo path_js(); ?>ace/elements.fileinput.js"></script>
        <script src="<?php echo path_js(); ?>ace/elements.typeahead.js"></script>
        <script src="<?php echo path_js(); ?>ace/elements.wysiwyg.js"></script>
        <script src="<?php echo path_js(); ?>ace/elements.spinner.js"></script>
        <script src="<?php echo path_js(); ?>ace/elements.treeview.js"></script>
        <script src="<?php echo path_js(); ?>ace/elements.wizard.js"></script>
        <script src="<?php echo path_js(); ?>ace/elements.aside.js"></script>
        <script src="<?php echo path_js(); ?>ace/ace.js"></script>
        <script src="<?php echo path_js(); ?>ace/ace.ajax-content.js"></script>
        <script src="<?php echo path_js(); ?>ace/ace.touch-drag.js"></script>
        <script src="<?php echo path_js(); ?>ace/ace.sidebar.js"></script>
        <script src="<?php echo path_js(); ?>ace/ace.sidebar-scroll-1.js"></script>
        <script src="<?php echo path_js(); ?>ace/ace.submenu-hover.js"></script>
        <script src="<?php echo path_js(); ?>ace/ace.widget-box.js"></script>
        <script src="<?php echo path_js(); ?>ace/ace.settings.js"></script>
        <script src="<?php echo path_js(); ?>ace/ace.settings-rtl.js"></script>
        <script src="<?php echo path_js(); ?>ace/ace.settings-skin.js"></script>
        <script src="<?php echo path_js(); ?>ace/ace.widget-on-reload.js"></script>
        <script src="<?php echo path_js(); ?>ace/ace.searchbox-autocomplete.js"></script>
        <script src="<?php echo path_js(); ?>jqGrid/jquery.jqGrid.src.js"></script>
        <script src="<?php echo path_js(); ?>jqGrid/i18n/grid.locale-id.js"></script>
    </body>

</html>
