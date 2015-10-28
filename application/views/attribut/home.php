<link href="<?php echo path_metro() ?>css/metro-bootstrap.css" rel="stylesheet">
<link href="<?php echo path_metro() ?>css/metro-bootstrap-responsive.css" rel="stylesheet">
<link href="<?php echo path_metro() ?>css/iconFont.css" rel="stylesheet">
<link href="<?php echo path_metro() ?>js/prettify/prettify.css" rel="stylesheet">

<!-- Load JavaScript Libraries -->
<script src="<?php echo path_metro() ?>js/jquery/jquery.min.js"></script>
<script src="<?php echo path_metro() ?>js/jquery/jquery.widget.min.js"></script>
<script src="<?php echo path_metro() ?>js/jquery/jquery.mousewheel.js"></script>
<script src="<?php echo path_metro() ?>js/prettify/prettify.js"></script>

<script src="<?php echo path_metro() ?>js/metro.min.js"></script>
<script src="<?php echo path_metro() ?>js/start-screen.js"></script>
<body class="metro tile-area-bg">

    <div class="tile-area">
        <h1 class="tile-area-title fg-white"><?php echo "KlikDms"; ?></h1>
        <div class="tile-group six">
            <div class="tile-group ten">
            </div>  End group 

            <div class="tile-group one">
                <div class="tile-group-title">Shortcut</div>
                <a href="<?php echo site_url("dashboard"); ?>" class="tile half bg-orange" data-click="transform">
                    <div class="tile-content icon">
                        <span class="icon-grid"></span>
                    </div>
                </a>
                <a href="<?php echo site_url('welcome/pesan'); ?>" class="tile half bg-blue" data-click="transform">
                    <div class="tile-content icon">
                        <span class="icon-home"></span>
                    </div>
                </a>
                <a href="<?php echo site_url('setting/pesan'); ?>" class="tile half bg-darkGreen" data-click="transform">
                    <div class="tile-content icon">
                        <span class="icon-mail"></span>
                    </div>
                </a>
            </div>  End tile group 
            <div class="tile-group double">

                <a href="<?php echo site_url('it'); ?>" class="tile bg-red" data-click="transform">
                    <div class="tile-content icon">
                        <span class="icon-hash"></span>
                    </div>
                    <div class="brand">
                        <div class="label">IT</div>
                    </div>
                </a>
                <a href="<?php echo site_url('welcome/shadow_user'); ?>" class="tile bg-green" data-click="transform">
                    <div class="tile-content icon">
                        <span class="icon-user"></span>
                    </div>
                    <div class="brand">
                        <div class="label">Shadow User</div>
                    </div>
                </a>
                <a href="<?php echo site_url('welcome/shadow_cabang'); ?>" class="tile bg-darkCyan" data-click="transform">
                    <div class="tile-content icon">
                        <span class="icon-github-6"></span>
                    </div>
                    <div class="brand">
                        <div class="label">Shadow Cabang</div>
                    </div>
                </a>
            </div>  End group 

            <div class="tile-group double">
                <div class="tile-group-title">Gallery</div>
                <div class="tile double" data-click="transform">
                    <div class="tile-content image-set">
                        <img src="<?php echo path_metro() ?>images/1.jpg">
                        <img src="<?php echo path_metro() ?>images/2.jpg">
                        <img src="<?php echo path_metro() ?>images/3.jpg">
                        <img src="<?php echo path_metro() ?>images/4.jpg">
                        <img src="<?php echo path_metro() ?>images/5.jpg">
                    </div>
                </div>
                <div class="tile double live" data-role="live-tile" data-effect="slideUpDown" data-click="transform">
                    <div class="tile-content image">
                        <img src="<?php echo path_metro()?>images/1.jpg">
                    </div>
                    <div class="tile-content image">
                        <img src="<?php echo path_metro()?>images/2.jpg">
                    </div>
                    <div class="tile-content image">
                        <img src="<?php echo path_metro()?>images/3.jpg">
                    </div>
                    <div class="tile-content image">
                        <img src="<?php echo path_metro()?>images/4.jpg">
                    </div>
                    <div class="tile-content image">
                        <img src="<?php echo path_metro()?>images/5.jpg">
                    </div>

                    <div class="tile-status">
                        <span class="label">Images</span>
                    </div>
                </div>
            </div>
        </div>
</body>
<script type="text/javascript">
    var scripts = [null, null]
    $('.page-content-area').ace_ajax('loadScripts', scripts, function() {
        //inline scripts related to this page
    });
</script>
